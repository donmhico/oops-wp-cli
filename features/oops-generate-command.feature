Feature: wp oops generate

  Scenario: Run 'wp oops generate' command
    Given a WP install
    When I run `wp oops generate`
    Then STDOUT should contain:
    """
    Success: Oops generate! It's a success!
    """

  Scenario: Run 'wp oops generate non-existent-arg' which is a non-existing arg.
    Given a WP install
    When I try `wp oops generate non-existent-arg`
    Then STDERR should contain:
    """
    Error: 'non-existent-arg' sub command not found!
    """
    And the return code should be 1

  Scenario: Scaffold a plugin
    Given a WP install
    Given I run `wp plugin path`
    And save STDOUT as {PLUGIN_DIR}
    Given I run `wp core version`
    And save STDOUT as {WP_VERSION}

    When I run `wp oops generate plugin TestPlugin --author="TestPlugin Author"`
    Then STDOUT should not be empty
    And the {PLUGIN_DIR}/TestPlugin/.gitignore file should exist
    And the {PLUGIN_DIR}/TestPlugin/.editorconfig file should exist
    And the {PLUGIN_DIR}/TestPlugin/hello-world.php file should exist
    And the {PLUGIN_DIR}/TestPlugin/readme.txt file should exist
    And the {PLUGIN_DIR}/TestPlugin/package.json file should exist
    And the {PLUGIN_DIR}/TestPlugin/Gruntfile.js file should exist
    And the {PLUGIN_DIR}/TestPlugin/.gitignore file should contain:
      """
      .DS_Store
      phpcs.xml
      phpunit.xml
      Thumbs.db
      wp-cli.local.yml
      node_modules/
      """
    And the {PLUGIN_DIR}/TestPlugin/.distignore file should contain:
      """
      .git
      .gitignore
      """
    And the {PLUGIN_DIR}/TestPlugin/.phpcs.xml.dist file should contain:
      """
      	<rule ref="PHPCompatibilityWP"/>
      """
    And the {PLUGIN_DIR}/TestPlugin/.phpcs.xml.dist file should contain:
      """
      	<config name="testVersion" value="5.3-"/>
      """
    And the {PLUGIN_DIR}/TestPlugin/hello-world.php file should contain:
      """
      * Plugin Name:     Hello World
      """
    And the {PLUGIN_DIR}/TestPlugin/hello-world.php file should contain:
      """
      * Version:         0.1.0
      """
    And the {PLUGIN_DIR}/TestPlugin/hello-world.php file should contain:
      """
      * @package         TestPlugin
      """
    And the {PLUGIN_DIR}/TestPlugin/readme.txt file should contain:
      """
      Stable tag: 0.1.0
      """
    And the {PLUGIN_DIR}/TestPlugin/readme.txt file should contain:
      """
      Tested up to: {WP_VERSION}
      """

    When I run `cat {PLUGIN_DIR}/TestPlugin/package.json`
    Then STDOUT should be JSON containing:
      """
      {"author":"TestPlugin Author"}
      """
    And STDOUT should be JSON containing:
      """
      {"version":"0.1.0"}
      """
