<?php
/*
Plugin Name: 2FA Support
Plugin URI: https://ghst.pw/2fa-support
Description: Adds 2FA support
Version: 1.1
Author: Matthew
Author URI: https://matc.io
*/

require_once 'PHPGangsta/GoogleAuthenticator.php';

// No direct call
if( !defined( 'YOURLS_ABSPATH' ) ) die();

yourls_add_action( 'plugins_loaded', 'matthew_2fa_init' );

// Initial setup for the plugin
function matthew_2fa_init() {
    // Register plugin page
    yourls_register_plugin_page( 'matthew_2fa_support', '2FA Setup', 'matthew_2fa_display_page' );
    
    // Create our custom options variable
    if ( !yourls_get_option( 'matthew_2fa_tokens', false ) ) {
        yourls_add_option( 'matthew_2fa_tokens', '{}' );
    }
}

// Displays main admin page
function matthew_2fa_display_page() {
    $matthew_2fa_tokens = json_decode( yourls_get_option( 'matthew_2fa_tokens' ), true );

    if( matthew_2fa_is_otp() && isset( $_POST[ 'matthew_2fa_otp_token' ] ) ) {
        yourls_verify_nonce( 'matthew_2fa_validation' );
        if( matthew_2fa_handle_otp_activate( $matthew_2fa_tokens ) ) {
            return;
        }
    }

    // If key doesn't exist for the current user, then set default values.
    if( !array_key_exists( YOURLS_USER, $matthew_2fa_tokens ) || !$matthew_2fa_tokens[ YOURLS_USER ][ 'active' ] ) {
        $matthew_2fa_tokens[ YOURLS_USER ] = [
            'active' => false,
            'type' => '',
            'secret' => '',
        ];
        yourls_update_option( 'matthew_2fa_tokens', json_encode( $matthew_2fa_tokens ) );

        // Checks whether we are currently trying to activate 2FA, or if we should prompt to activate
        if( isset( $_POST[ 'activate' ] ) && matthew_2fa_is_otp() || isset( $_POST[ 'matthew_2fa_otp_token' ] ) ) {
            yourls_verify_nonce( 'matthew_2fa_activate' );

            // Display QR code along with verification form
            matthew_2fa_display_token();
        } else {
            // Prompt first-time setup.
            matthew_2fa_display_activate();
        }
    } elseif( isset( $_POST[ 'deactivate' ] ) ) {
        yourls_verify_nonce( 'matthew_2fa_deactivate' );

        $matthew_2fa_tokens[ YOURLS_USER ][ 'active' ] = false;
        $matthew_2fa_tokens[ YOURLS_USER ][ 'secret' ] = '';
        $matthew_2fa_tokens[ YOURLS_USER ][ 'type' ] = '';
        yourls_update_option( 'matthew_2fa_tokens', json_encode( $matthew_2fa_tokens ) );

        echo '<p><span color="green">'. yourls__( 'Deactivated!' ). '</span></p>';
        matthew_2fa_display_activate();
    } else {
        matthew_2fa_display_deactivate();
    }
}

// Displays the 2FA activation page, allowing the user to select what type of OTP
function matthew_2fa_display_activate() {
    $matthew_2fa_nonce = yourls_nonce_field( 'matthew_2fa_activate');
    $matthew_2fa_activate_text = yourls__( 'Activate' );
    echo <<<SETT
    <main>
        <h2>2FA Settings</h2>
        <form method="post">
            $matthew_2fa_nonce
            <p>
                <label for="matthew_2fa_type">Choose 2FA type:</label>
                <select id="matthew_2fa_type" name="matthew_2fa_type">
                    <option value="otp">OTP</option>
                </select> 
            </p>
            <p><input type="submit" name="activate" value="$matthew_2fa_activate_text" class="button" /></p>
        </form>
    </main>
    SETT;
}

// Displays the deactivation form to disable 2FA
function matthew_2fa_display_deactivate() {
    $matthew_2fa_nonce = yourls_nonce_field( 'matthew_2fa_deactivate' );
    $matthew_2fa_deactivate_text = yourls__( 'Deactivate' );

    echo <<<DEAC
    <main>
        <h2>2FA Settings</h2>
        <form method="post">
            $matthew_2fa_nonce
            <p><input type="submit" name="deactivate" value="$matthew_2fa_deactivate_text" class="button" /></p>
        </form>
    </main>
    DEAC;
}

// Add 2FA input to the login form
yourls_add_action( 'login_form_bottom', 'matthew_2fa_add_input' );

function matthew_2fa_add_input() {
    ?>
    <p>
        <label for="matthew_2fa_otp"><?php yourls_e( '2FA Token' ); ?></label><br />
        <input type="text" id="matthew_2fa_otp" name="matthew_2fa_otp" placeholder="<?php yourls_e( 'Leave empty if necessary' ); ?>" size="30" class="text" />
    </p>
    <?php
}

// Attach 2FA validate function to check if 2FA code is valid.
yourls_add_filter( 'is_valid_user', 'matthew_2fa_validate' );

// Checks if the user has enabled 2FA, and if so, validate it.
function matthew_2fa_validate( $is_valid ) {
    // If user failed to properly authenticate, return
    if( !$is_valid ) {
        return false;
    }

    // If cookies are set, we are already logged in
    // OR if this is an API request, skip 2fa
    if( isset( $_COOKIE[ yourls_cookie_name() ] ) || yourls_is_API() ) {
        return $is_valid;
    }

    // Cookies aren't set, and this isn't an API request, so we proceed to verify the 2FA token
    $matthew_2fa_tokens = json_decode( yourls_get_option( 'matthew_2fa_tokens' ), true );

    if( !array_key_exists( YOURLS_USER, $matthew_2fa_tokens ) || !$matthew_2fa_tokens[ YOURLS_USER ][ 'active' ] ) {
        // User has not enabled 2fa, so no need to verify anynthing
        return $is_valid;
    }

    // User has enabled 2FA

    //TODO: Handle multiple types of 2FA (i.e., YubiKey)

    // If the user has set an OTP, verify using that
    if( $matthew_2fa_tokens[ YOURLS_USER ][ 'type' ] == 'otp' ) {
        return matthew_2fa_verify_otp( $matthew_2fa_tokens );
    }
}

/* 
    MARK: OTP SECTION
*/

// Checks if we are dealing with an OTP request
function matthew_2fa_is_otp() {
    return isset( $_POST[ 'matthew_2fa_type' ] ) && $_POST[ 'matthew_2fa_type' ] == 'otp';
}

// Handles verifying if OTP was correct, if so, activates OTP 2FA for the user
function matthew_2fa_handle_otp_activate( $matthew_2fa_tokens ) {
    $matthew_2fa_token_ga = new PHPGangsta_GoogleAuthenticator();
        
    if( $matthew_2fa_token_ga->verifyCode( $matthew_2fa_tokens[ YOURLS_USER ][ 'secret' ], $_POST[ 'matthew_2fa_otp_token' ], 2 ) ) {
        // Code was correct, so activate 2FA
        $matthew_2fa_tokens[ YOURLS_USER ][ 'active' ] = true;
        yourls_update_option( 'matthew_2fa_tokens', json_encode( $matthew_2fa_tokens ) );
        echo '<p><span color="green">'. yourls__( 'Activated!' ). '</span></p>';
        matthew_2fa_display_deactivate();

        return true;
    } else {
        // Wrong code.
        echo '<p><span color="red">'. yourls__( 'Incorrect token entered, new QR generated' ). '</span></p>';
        return false;
    } 
}

// Displays the OTP QR code & verifies that it was scanned correctly
function matthew_2fa_display_token() {
    // Create & generate the 2FA secret
    $matthew_2fa_ga = new PHPGangsta_GoogleAuthenticator();
    $matthew_2fa_secret = $matthew_2fa_ga->createSecret();
    $matthew_2fa_qr = $matthew_2fa_ga->getQRCodeGoogleUrl( 'YOURLS', $matthew_2fa_secret );

    // Save secret
    $matthew_2fa_tokens[ YOURLS_USER ][ 'secret' ] = $matthew_2fa_secret;
    $matthew_2fa_tokens[ YOURLS_USER ][ 'type' ] = 'otp';
    yourls_update_option( 'matthew_2fa_tokens', json_encode( $matthew_2fa_tokens ) );

    // Display QR code & prompt to verify token
    ?>
    <main>
        <center>
            <img src="<?php echo $matthew_2fa_qr; ?>" /><br>

            <form method="post">
                <?php yourls_nonce_field( 'matthew_2fa_validation' ); ?>
                <p>
                    <input type="hidden" name="matthew_2fa_type" value="otp">
                    <label><?php yourls_e( 'Verify token:' ); ?></label>
                    <input type="text" name="matthew_2fa_otp_token" />
                </p>
                <p><input type="submit" value="<?php yourls_e( 'Verify' ); ?>" class="button" /></p>
            </form>
        </center>
    </main>
    <?php
}

// Verifies if the OTP code sent is valid on-login.
function matthew_2fa_verify_otp( $matthew_2fa_user_settings ) {
    // Ensure 2FA token was sent.
    if( !isset( $_REQUEST[ 'matthew_2fa_otp' ] )) {
        return false;
    }
    
    $matthew_2fa_ga = new PHPGangsta_GoogleAuthenticator();
    $matthew_2fa_secret = $matthew_2fa_user_settings[ YOURLS_USER ][ 'secret' ];

    // Verify token with secret
    if( $matthew_2fa_ga->verifyCode( $matthew_2fa_secret, $_REQUEST[ 'matthew_2fa_otp' ], 2 ) ) {
        return true;
    }

    // Token wasn't corret. Login failed
    return false;
}