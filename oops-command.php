<?php

if ( ! class_exists( 'WP_CLI' ) ) {
	return;
}

$wpcli_oops_autoloader = dirname( __FILE__ ) . '/vendor/autoload.php';
if ( file_exists( $wpcli_oops_autoloader ) ) {
	require_once $wpcli_oops_autoloader;
}

WP_CLI::add_command( 'oops', 'Oops_Command' );
