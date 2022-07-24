<?php
/*
Plugin Name: 2FA Support
Plugin URI: https://ghst.pw/2fa-support
Description: Adds 2FA support
Version: 1.0
Author: Matthew
Author URI: https://matc.io
*/

require_once 'PHPGangsta/GoogleAuthenticator.php';

// No direct call
if( !defined( 'YOURLS_ABSPATH' ) ) die();

yourls_add_action( 'plugins_loaded', 'matthew_2fa_init' );

function matthew_2fa_init() {
    // Register plugin page
    yourls_register_plugin_page( 'matthew_2fa_support', '2FA Setup', 'matthew_2fa_display_page' );
    
    // Create our custom options variable
    if ( !yourls_get_option( 'matthew_2fa_tokens', false ) ) {
        yourls_add_option( 'matthew_2fa_tokens', '{}' );
    }
}

function matthew_2fa_display_page() {
    $matthew_2fa_tokens = json_decode( yourls_get_option( 'matthew_2fa_tokens' ), true );

    if( isset( $_POST[ 'matthew_2fa_token' ] ) ) {
        yourls_verify_nonce( 'matthew_2fa_validation' );
        $matthew_2fa_token_ga = new PHPGangsta_GoogleAuthenticator();
        
        if( $matthew_2fa_token_ga->verifyCode( $matthew_2fa_tokens[ YOURLS_USER ][ 'secret' ], $_POST[ 'matthew_2fa_token' ], 2 ) ) {
            // Code was correct, so activate 2fa.
            $matthew_2fa_tokens[ YOURLS_USER ][ 'active' ] = true;
            yourls_update_option( 'matthew_2fa_tokens', json_encode( $matthew_2fa_tokens ) );
            return;
        } else {
            // Wrong code.
            echo '<p><span color="red">Incorrect token entered, new QR generated</span></p>';
        } 
    }

    // If key doesn't exist for the current user, then set default values.
    if( !array_key_exists( YOURLS_USER, $matthew_2fa_tokens ) || !$matthew_2fa_tokens[ YOURLS_USER ][ 'active' ] ) {
        $matthew_2fa_tokens[ YOURLS_USER ] = [
            'active' => false,
            'secret' => '',
        ];
        yourls_update_option( 'matthew_2fa_tokens', json_encode( $matthew_2fa_tokens ) );

        if( isset( $_POST[ 'activate' ] ) || isset( $_POST[ 'matthew_2fa_token' ] ) ) {
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
        yourls_update_option( 'matthew_2fa_tokens', json_encode( $matthew_2fa_tokens ) );

        echo '<p><span color="green">Deactivated!</span></p>';
        matthew_2fa_display_activate();
    } else {
        matthew_2fa_display_deactivate();
    }
}

function matthew_2fa_display_activate() {
    $matthew_2fa_nonce = yourls_nonce_field('matthew_2fa_activate');
    echo <<<SETT
    <main>
        <h2>2FA Settings</h2>
        <form method="post">
            $matthew_2fa_nonce
            <p><input type="submit" name="activate" value="Activate?" class="button" /></p>
        </form>
    </main>
    SETT;
}

function matthew_2fa_display_token() {
    // Create & generate the 2fa secret
    $matthew_2fa_ga = new PHPGangsta_GoogleAuthenticator();
    $matthew_2fa_secret = $matthew_2fa_ga->createSecret();
    $matthew_2fa_qr = $matthew_2fa_ga->getQRCodeGoogleUrl( 'YOURLS', $matthew_2fa_secret );

    // Save secret
    $matthew_2fa_tokens[ YOURLS_USER ][ 'secret' ] = $matthew_2fa_secret;
    yourls_update_option( 'matthew_2fa_tokens', json_encode( $matthew_2fa_tokens ) );

    // Display QR code & prompt to verify token
    $matthew_2fa_nonce = yourls_nonce_field('matthew_2fa_validation');
    echo <<<QR
    <main>
        <center>
            <img src="$matthew_2fa_qr" /><br>

            <form method="post">
                $matthew_2fa_nonce
                <p>
                    <label>Verify token:</label>
                    <input type="text" name="matthew_2fa_token" />
                </p>
                <p><input type="submit" value="Verify" class="button" /></p>
            </form>
        </center>
    </main>
    QR;
}

function matthew_2fa_display_deactivate() {
    $matthew_2fa_nonce = yourls_nonce_field('matthew_2fa_deactivate');

    echo <<<DEAC
    <main>
        <h2>2FA Settings</h2>
        <form method="post">
            $matthew_2fa_nonce
            <p><input type="submit" name="deactivate" value="Deactivate?" class="button" /></p>
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

// Attach 2FA validate function to check if 2fa code is valid.
yourls_add_filter( 'is_valid_user', 'matthew_2fa_validate' );

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

    // Ensure 2FA token was sent.
    if( !isset( $_REQUEST[ 'matthew_2fa_otp' ] )) {
        return false;
    }
    
    $matthew_2fa_ga = new PHPGangsta_GoogleAuthenticator();
    $matthew_2fa_secret = $matthew_2fa_tokens[ YOURLS_USER ][ 'secret' ];

    // Verify token with secret
    if( $matthew_2fa_ga->verifyCode( $matthew_2fa_secret, $_REQUEST[ 'matthew_2fa_otp' ], 2 ) ) {
        return true;
    }

    // Token wasn't corret. Login failed
    return false;
}