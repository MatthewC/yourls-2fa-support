<?php
/*
author: Matthew
version: 1.0
*/

// No direct call.
if( !defined( 'YOURLS_UNINSTALL_PLUGIN' ) ) die();

yourls_delete_option('matthew_2fa_tokens');
