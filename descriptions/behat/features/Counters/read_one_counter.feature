Feature: read one counter
  As an admin
  in order to /display the counter value
  i need to be able to /get the counter value/ from api

  GET /counters/1/value

  Scenario: Getting the value for a single counter in the collection
    Given a counter "onecounter" with a value of "1" has been set
    When I get the value of the counter with name "onecounter"
    Then the value returned should be 1

  #  Scenario: Getting the status for a single counter in the collection
  #    Given a counter "onecounter" with a status of "active" has been set
  #    When I get the status of the counter with name "onecounter"
  #    Then the status returned should be "active"
      #PENDING Scenario: getting default counter

      #PENDING Scenario: Geting a non-existing Counter field


  #  Scenario: Getting a representation of a counter
  #    Given a counter "onecounter" with a value of "1" has been set
  #    When I get the counter with name "onecounter"
  #    Then I should see the Counter Properties:
  #      | name       | value | status |
  #      | onecounter | 1     | active |
