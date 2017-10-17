Feature: List all counters
  As an admin
  I want to list all counters
  in order to see accessible counter ids.

  Scenario: Get list of all counters.
    Given there are 3 counters
    When I list all counters
    Then I should see 3 counters
