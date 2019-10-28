<?php
// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedNamespaceFound
namespace DonMhico\OopsCommand\Abstracts;

/**
 * Class AbstractArg
 *
 * Legend: The command below is the usage of OOPS-WP CLI.
 * $ wp oops <sub command> <arg> <--assoc=arg>
 *
 * Usage:
 *
 * To create a new <arg> for an existing <sub command>, follow these steps:
 *
 * 1. Create a directory named "Arg" under the "<SubCommand>" directory.
 * E.g. \src\SubCommand\<SubCommand>\Arg
 * 2. Create a new php class file inside the Arg directory. Name it with the convention <Arg>.php
 * with <Arg> being the PascalCase of the <arg>.
 * 3. Extend the new "<Arg>" class with "AbstractArg".
 *
 * Notes:
 *
 * 1. If you wish to accomplish something like `$wp oops <sub command> <arg[0]> <arg[1]>`, you only need
 * to follow the steps above with <arg[0]>. The rest of the args can be accessed inside your
 * <Arg[0]> class using the property `$this->args`.
 * 2. Assoc args, e.g. `$ wp oops <sub command> <arg> --sample-assoc=sample`, can be accessed using the
 * property `$this->assoc_args`.
 *
 * @package DonMhico\OopsCommand\Abstracts
 * @since 0.0.1
 */
abstract class AbstractArg extends AbstractCommand {

}
