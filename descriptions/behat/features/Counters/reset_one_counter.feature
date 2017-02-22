Feature: reset one counter
  As an apiuser
  in order to remove the current counter value (start over)
  i need to be able to reset the counter value and state to default from api

  PUT /counters/1
  given a Counter, it is possible to replace its value with 0.

  Scenario: Resetting the first counter
    Given a counter "excounter" with a value of "8" has been set
    When I reset the counter with Name "excounter"
    And I get the value of the counter with Name "excounter"
    Then the value returned should be "0"

  Scenario: Resetting counter that doesn't exist
    Given no counter "onecounter" has been set
    When I reset the counter with Name "onecounter"
    Then I should see an error "Counter not found. You can not reset a counter that doesnt exist."