<?php
// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedNamespaceFound
namespace DonMhico\OopsCommand\Abstracts;

use DonMhico\OopsCommand\Interfaces\CallableInterface;
use DonMhico\OopsCommand\Interfaces\ExtensibleInterface;
use DonMhico\OopsCommand\Utils;

/**
 * Class AbstractCommand
 *
 * Dynamically load extensible objects (sub commands and args). This can be extended
 * to easily create new sub commands and args to OOPS-WP CLI.
 *
 * @package DonMhico\OopsCommand\Abstracts
 * @since 0.0.1
 */
abstract class AbstractCommand implements ExtensibleInterface, CallableInterface {
	/**
	 * Args of the WP CLI command.
	 *
	 * Example:
	 *
	 * `$ wp oops generate plugin`
	 *
	 * The value of `$args` is
	 *
	 * `$args = [
	 *     'generate',
	 *     'plugin'
	 * ]`
	 *
	 * @since 0.0.1
	 * @var array|null
	 */
	protected $args;

	/**
	 * Associative args of the WP CLI command.
	 *
	 * Example:
	 *
	 * `$ wp oops generate plugin --name=TestPlugin --author=WDS`
	 *
	 * The value of `$assoc_args` is
	 *
	 * `$assoc_args = [
	 *     'name'   => 'TestPlugin',
	 *     'plugin' => 'WDS
	 * ]`
	 *
	 * @since 0.0.1
	 * @var array|null
	 */
	protected $assoc_args;

	/**
	 * This __invoke() method captures the <command> used with
	 * `$wp oops <command>` command and dynamically instantiates
	 * the appropriate class to handle the command.
	 *
	 * @since 0.0.1
	 * @param array $args
	 * @param array $assoc_args
	 * @throws \WP_CLI\ExitException
	 */
	public function __invoke( array $args, array $assoc_args ) {
		$this->load_extends( $args, $assoc_args );
	}

	/**
	 * Dynamically load sub commands and args.
	 *
	 * @since 0.0.1
	 *
	 * @param array|null $args Passed $args in WP CLI.
	 * @param array|null $assoc_args Passed $assoc_args in WP CLI.
	 * @throws \WP_CLI\ExitException
	 */
	protected function load_extends( array $args = null, array $assoc_args = null ) {
		if ( null !== $args && null !== $assoc_args ) {
			$this->args       = $args;
			$this->assoc_args = $assoc_args;
		}

		if ( empty( $this->args ) ) {
			// No sub command given.
			$this->call();
			return;
		} else {
			// First, make sure that <command> exists.
			$command_string       = array_shift( $this->args );
			$command_class_string = Utils::get_command_class_string( $command_string );

			// Instantiate command class.
			try {
				// Command namespace.
				$command_fully_qualified_class = "{$this->get_extended_namespace()}\\{$command_class_string}";

				// AbstractCommands are inside their own directory.
				if ( ! ( $this instanceof AbstractSubCommand ) ) {
					$command_fully_qualified_class .= "\\{$command_class_string}";
				}

				// Dynamically call the class responsible for the command and sub command.
				$sub_command = new $command_fully_qualified_class();

				if ( $sub_command instanceof ExtensibleInterface ) {
					$sub_command->load_extends( $this->args, $this->assoc_args );
				} elseif ( $sub_command instanceof CallableInterface ) {
					$sub_command->call();
				} else {
					throw new \TypeError();
				}
			} catch ( \TypeError $type_error ) {
				\WP_CLI::error( $command_class_string . ' is not a command.' );
			} catch ( \Throwable $throwable ) {
				/**
				 * TODO Error logs can be improved.
				 *
				 * It should show something like.
				 *
				 * <non-existent-subcommand> sub command not found!
				 * <non-existent-subcommand> <non-existent-arg> arg not found!
				 */
				\WP_CLI::error( "'{$command_string}' sub command not found!" );
			}
		}
	}
}
