Feature: listing posts

  @domain
  Scenario: listing posts
    Given post exists with data:
      | title    | Listing posts                                     |
      | content  | This post was created as a test for listing posts |
    When I visit post list
    Then I should see post "Listing posts" on the list