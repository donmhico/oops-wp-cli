<?php

// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedClassFound
class Oops_Command extends WP_CLI_Command {
	public function init( $args, $assoc_args ) {
		WP_CLI::success( 'This is the start! ' );
	}
}
