Feature: wp oops

  Scenario: Run 'wp oops' command
    Given a WP install
    When I run `wp oops`
    Then STDOUT should contain:
    """
    Success: Oops! It's a success!
    """

  Scenario: Run 'wp oops non-existent' which is a non-existing sub command.
    Given a WP install
    When I try `wp oops non-existent`
    Then STDERR should contain:
    """
    Error: 'non-existent' sub command not found!
    """
    And the return code should be 1
