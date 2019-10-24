<?php
// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedNamespaceFound
namespace DonMhico\OopsCommand;

use DonMhico\OopsCommand\Abstracts\AbstractCommand;

/**
 * Class OopsCommand
 *
 * Entry point of the `wp oops` cli command.
 *
 * TODO Find a way to incorporate standard WP CLI's docBlock for commands.
 *
 * @package DonMhico\OopsCommand
 * @since 0.0.1
 */
class OopsCommand extends AbstractCommand {
	/**
	 * Returns the namespace of the sub commands to be loaded.
	 *
	 * @since 0.0.1
	 *
	 * @return string
	 */
	public function get_extended_namespace() {
		return __NAMESPACE__ . '\\SubCommand';
	}

	/**
	 * Perform the command
	 *
	 * @since 0.0.1
	 *
	 * @return void
	 */
	public function call() {
		\WP_CLI::success( "Oops! It's a success!" );
	}
}
