Feature: updating post

  Background:
    Given post exists with data:
      | title    | Updating posts                                     |
      | content  | This post was created as a test for updating posts |

  @domain
  Scenario: updating post
    When I update post with data:
      | title    | Post after update            |
      | content  | This post was updated once   |
    Then post should be updated

  @domain
  Scenario: updated post should affect post list
    When I update post with data:
      | title    | Post after update            |
      | content  | This post was updated once   |
    And I visit post list
    Then I should see post "Post after update" on the list
    Then I should not see post "Updating posts" on the list