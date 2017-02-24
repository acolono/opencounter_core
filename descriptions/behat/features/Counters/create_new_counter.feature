Feature: create a new counter
  As an admin
  in order to know what I am counting
  I need to be able to create a new counter with a name and default value of '0'

  Scenario: create a new counter with custom name
    Given no counter "onecounter" has been set
    When I set a counter with name "onecounter"
    Then I can get the value of the counter with Name "onecounter"
    And the value returned should be 0


#
#  Scenario: creating new counter if name already taken
#    Given a counter with name "onecounter" has been set
#    When I set a counter with name "onecounter"
#    Then I should see an error "A counter by that name already exists"

#  Scenario: creating new counter with invalid name
#    When I set a counter with name "1 counter / (this is a bad countername)"
#    Then I should see an error "Counter name needs to be alphanumeric without whitespace or special chars"

    # Scenario: creating default counter