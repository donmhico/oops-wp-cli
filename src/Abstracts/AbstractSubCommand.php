<?php
// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedNamespaceFound
namespace DonMhico\OopsCommand\Abstracts;

use DonMhico\OopsCommand\Interfaces\CallableInterface;

/**
 * Class AbstractSubCommand
 *
 * Legend: The command below is the usage of OOPS-WP CLI.
 * $ wp oops <sub command>
 *
 * Usage:
 *
 * To create a new <sub command> (e.g. 'build'), follow these steps:
 *
 * 1. Create a new directory under src\SubCommand using the name of the new command
 * in PascalCase. (E.g. Build)
 * 2. Create a new class inside src\SubCommand\Build and name it Build.php (or PascalCase.php)
 * 3. Extend Build class with AbstractSubCommand and make sure it implements the
 * get_extended_namespace() method.
 *
 * @package DonMhico\OopsCommand\Abstracts
 * @since 0.0.1
 */
abstract class AbstractSubCommand extends AbstractCommand implements CallableInterface {
}
