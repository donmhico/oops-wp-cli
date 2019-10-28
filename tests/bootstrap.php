<?php
// phpcs:enable
require_once VENDOR_DIR . '/autoload.php';
require_once WP_CLI_ROOT . '/php/utils.php';

if ( ! function_exists( 'wpcli_tests_include_config' ) ) {
	function wpcli_tests_include_config( array $config_filenames = [] ) {
		$config_filename = false;
		foreach ( $config_filenames as $filename ) {
			if ( file_exists( PACKAGE_ROOT . '/' . $filename ) ) {
				$config_filename = PACKAGE_ROOT . '/' . $filename;
				break;
			}
		}

		if ( $config_filename ) {
			$config  = file_get_contents( $config_filename );
			$matches = null;
			$pattern = '/bootstrap="(?P<bootstrap>.*)"/';
			$result  = preg_match( $pattern, $config, $matches );
			if ( isset( $matches['bootstrap'] ) && file_exists( $matches['bootstrap'] ) ) {
				include_once PACKAGE_ROOT . '/' . $matches['bootstrap'];
			}
		}
	}
}

wpcli_tests_include_config(
	[
		'phpunit.xml',
		'.phpunit.xml',
		'phpunit.xml.dist',
		'.phpunit.xml.dist',
	]
);
