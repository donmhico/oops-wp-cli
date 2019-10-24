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
