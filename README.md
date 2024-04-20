# PHP Coding Competition

## Challenge 4: First to have all tests passing
- Must not change unit tests `tests/` directory
  - Show me your `git diff --main tests/`
  - If you need an older version of PHPUnit for you PHP version, you may downgrade the PHPUnit version and update the tests for your version
- composer install --dev
- vendor/bin/phpunit --configuration phpunit.xml
- No skipping tests
- First one to show me tests all passing wins the Challenge!
  - Bring your laptop to me to show me, or call me over to you
- Output should look something like this:
```
vendor/bin/phpunit --configuration phpunit.xml
PHPUnit 11.1.2 by Sebastian Bergmann and contributors.

Runtime:       PHP 8.3.4
Configuration: /Users/markniebergall/PhpstormProjects/PhpCodingCompetition-UnitTestsPassing/phpunit.xml

........................                                          24 / 24 (100%)

Time: 00:00.164, Memory: 8.00 MB

OK (24 tests, 70 assertions)
```