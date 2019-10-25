<?php
// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedNamespaceFound
namespace DonMhico\OopsCommand\Interfaces;

/**
 * Interface ExtensibleInterface
 *
 * Contract to objects that can be extended. Example the `oops`
 * command can be extended to have sub commands. And sub commands can be
 * extended to have args.
 *
 * @package DonMhico\OopsCommand\Interfaces
 * @since 0.0.1
 */
interface ExtensibleInterface {
	public function get_extended_namespace() : string;
}
