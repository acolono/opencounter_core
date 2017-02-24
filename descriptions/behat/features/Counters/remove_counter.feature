Feature: remove counter
  As a developer
  in order to clean up after our tests
  I need to be able to delete the existing counter

  # NOTE: user only cares about names. counter ids are used behind the scenes
#  Scenario: remove existing counter by id
#    Given a counter with id "1CE05088-ED1F-43E9-A415-3B3792655A9B" has been set
#    When I remove the counter with id "1CE05088-ED1F-43E9-A415-3B3792655A9B"
#    Then no counter with id "1CE05088-ED1F-43E9-A415-3B3792655A9B" has been set

  Scenario: remove existing counter by name
    Given a counter with name "onecounter" has been set
    When I remove the counter with name "onecounter"
    Then no counter "onecounter" has been set