Feature: publishing post

  @domain
  Scenario: publishing post
    When I create post with data:
      | title    | Publishing post                                      |
      | content  | This post was created as a test for publishing posts |
    Then new post should be published

  @domain
  Scenario: published post should occur on post list
    When I create post with data:
      | title    | Publishing another post                                        |
      | content  | Another post which was created as a test for publishing posts  |
    And I visit post list
    Then I should see post "Publishing another post" on the list