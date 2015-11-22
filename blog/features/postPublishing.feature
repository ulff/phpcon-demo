Feature: publishing post

  @domain
  Scenario: publishing post
    When I create post with data:
      | title    | Publishing post                                      |
      | content  | This post was created as a test for publishing posts |
    Then new post should be published