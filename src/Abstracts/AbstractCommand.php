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
	 * @param array $args Passed $args in WP CLI.
	 * @param array $assoc_args Passed $assoc_args in WP CLI.
	 * @throws \WP_CLI\ExitException
	 */
	public function __invoke( array $args, array $assoc_args ) {
		$this->args       = $args;
		$this->assoc_args = $assoc_args;

		$this->load_extends();
	}

	/**
	 * Dynamically load sub commands and args.
	 *
	 * @since 0.0.1
	 *
	 * @throws \WP_CLI\ExitException
	 */
	protected function load_extends() {
		// Invoke call() directly if no $args is provided
		// or the current instance is already an AbstractArg.
		if ( empty( $this->args ) || $this instanceof AbstractArg ) {
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

				// Dynamically call the class responsible for the sub command and arg.
				$sub_command = new $command_fully_qualified_class();
				$this->init_sub_command( $sub_command );

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

	public function init_sub_command( AbstractCommand $sub_command ) {
		$sub_command->args       = $this->args;
		$sub_command->assoc_args = $this->assoc_args;

		if ( $sub_command instanceof ExtensibleInterface ) {
			$sub_command->load_extends();
		}
	}

	/**
	 * Get the namespace of the extended classes to be loaded.
	 *
	 * This is use to get the fully qualified class name of the sub commands
	 * and args that will autoload.
	 *
	 * Command autoloads SubCommands.
	 * SubCommands autoloads Args.
	 *
	 * @since 0.0.1
	 * @return string
	 * @throws \Exception
	 */
	public function get_extended_namespace() : string {
		$calling_class           = get_class( $this );
		$reflection              = new \ReflectionClass( $calling_class );
		$calling_class_namespace = $reflection->getNamespaceName();

		if ( $this instanceof AbstractSubCommand ) {
			$calling_class_namespace .= '\\Arg';
		} elseif ( $this instanceof AbstractCommand ) {
			$calling_class_namespace .= '\\SubCommand';
		} else {
			throw new \Exception( 'The class should autoload something.' );
		}

		return $calling_class_namespace;
	}

}
