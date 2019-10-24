<?php
// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedNamespaceFound
namespace DonMhico\OopsCommand\SubCommand\Generate;

use DonMhico\OopsCommand\Abstracts\AbstractSubCommand;

/**
 * Class Generate
 *
 * Responsible for `$ wp oops generate` sub command.
 *
 * @package DonMhico\OopsCommand\SubCommand\Generate
 * @since 0.0.1
 */
class Generate extends AbstractSubCommand {
	/**
	 * Namespace for the \Args.
	 *
	 * @since 0.0.1
	 *
	 * @return string
	 */
	public function get_extended_namespace() {
		return __NAMESPACE__ . '\\Arg';
	}

	/**
	 * Perform the sub command
	 *
	 * @since 0.0.1
	 *
	 * @return void
	 */
	public function call() {
		\WP_CLI::success( "Oops generate! It's a success!" );
	}
}

