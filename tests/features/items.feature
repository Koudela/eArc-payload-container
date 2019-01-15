Feature: earc/payload-container items

  Background:
    Given an items object is defined

  Scenario: no item is set
    Then iteration over items has 0 steps
    Then items has name1 returns false
    Then items get name2 throws an ItemNotFoundException
    Then items call name3 throws an ItemNotFoundException
    Then items set name4 value4 does not throw an exception
    And items get name4 returns value4
    Then items overwrite name5 value5 returns null
    And items get name5 returns value5
    Then items remove name6 does not throw an exception
    And items get name6 throws an ItemNotFoundException

  Scenario:
    Given item name has value value