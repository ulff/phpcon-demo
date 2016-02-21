Feature: adding comment to post

  @domain
  Scenario: add comment to post
    Given post exists with data:
      | title    | Adding comment                                                 |
      | content  | This post was created as a background for adding comments test |
    When I add new comment for that post with data:
      | author  | Barrack Osama                     |
      | content | This is content of added comment  |
    Then new comment should be added to that post