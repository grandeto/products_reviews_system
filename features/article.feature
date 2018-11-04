Feature: Article tests

    Scenario: Get homepage list articles
    In order to check list articles
    As a basic user
    I need to be able to find some titles article in the homepage

        Given I am on the homepage
        Then I should see "ARTICLE DE TEST 0"
        And I should see "ARTICLE DE TEST 1"

    Scenario: Get one article
    In order to check one article
    As a basic user
    I need to be able to access on a specific article

        Given I am on the homepage
        When I follow "article-de-test-0"
        Then I should see "ARTICLE DE TEST 0"