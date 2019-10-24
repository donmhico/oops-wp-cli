<?php
// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedNamespaceFound
namespace DonMhico\OopsCommand;

/**
 * Class Utils
 *
 * @package DonMhico\OopsCommand
 * @since 0.0.1
 */
class Utils {
	/**
	 * Converts a wp cli command stdin to a class name.
	 *
	 * Example:
	 *
	 * generate-plugin -> GeneratePlugin
	 *
	 * @since 0.0.1
	 *
	 * @param string $command_string
	 * @return string
	 */
	public static function get_command_class_string( string $command_string ) : string {
		// Convert the command to class.
		// generate-plugin -> GeneratePlugin
		// 1. Replace '-' with whitespace.
		$command_class_string = str_replace( '-', ' ', $command_string );
		// 2. Pass to ucwords().
		$command_class_string = ucwords( $command_class_string );
		// 3. Remove whitespace.
		$command_class_string = str_replace( ' ', '', $command_class_string );

		return $command_class_string;
	}
}
