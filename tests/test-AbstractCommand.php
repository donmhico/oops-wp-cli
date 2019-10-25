<?php

class AbstractCommandTest extends \PHPUnit\Framework\TestCase {
	public function testGetExtendedNamespace() {
		// phpcs:ignore WordPress.Classes.ClassInstantiation.MissingParenthesis
		$sample_abstract_command_obj = new class extends \DonMhico\OopsCommand\Abstracts\AbstractCommand {
			public function call() {
			}
		};

		$this->assertStringEndsWith(
			'\\SubCommand',
			$sample_abstract_command_obj->get_extended_namespace()
		);

		// phpcs:ignore WordPress.Classes.ClassInstantiation.MissingParenthesis
		$sample_abstract_subcommand_obj = new class extends \DonMhico\OopsCommand\Abstracts\AbstractSubCommand {
			public function call() {
			}
		};

		$this->assertStringEndsWith(
			'\\Arg',
			$sample_abstract_subcommand_obj->get_extended_namespace()
		);
	}
}
