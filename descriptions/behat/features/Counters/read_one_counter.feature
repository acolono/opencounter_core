Feature: read one counter
  As an admin
  in order to /display the counter value
  i need to be able to /get the counter value/ from api

  GET /counters/1/value

  Scenario: Getting the value for a single counter in the collection by name
    Given a counter "onecounter" with a value of "11" has been set
    When I get the value of the counter with Name "onecounter"
    Then the value returned should be 11
#
#  Scenario: I (can )get the Id of the counter with Name :name
#    Given a counter "twocounter" with ID "0000000" and a value of 12 was added to the collection
#    When I get the Id of the counter with Name "onecounter"
#    Then the Id returned should be "0000000"


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
