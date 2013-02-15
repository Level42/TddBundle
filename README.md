TddBundle
=========

A bundle to generate test class from annotated classes (for TDD).

1) Installing
----------------------------------
Download bundle in `src/Level42/TddBundle`

or add in your composer.json file

    "require": {
        ...
        "Level42/tdd-generator-bundle": "0.1"
        ...
    },

If you don't have Composer yet, download it following the instructions on
[http://getcomposer.org/](http://getcomposer.org/ "http://getcomposer.org/").

2) Using
-------------------------------
### 2.1) Add annotations ###

In the classes to test, add annotation on the class comment :
`@TddClass()`

For each methods to test in the class, add annotations :

`@TddTestCase({
    {"method"="testCase3Success", "description"="Nominal test case", "result"="Waiting for an object saved in database (with ID)"},
    {"method"="testCase3Failed", "description"="Failed test case", "result"="Waiting for an error when entity was validated"},
    {"method"="testCase3Exception", "description"="Exception test case", "result"="Waiting for an Exception rised by database"}
})`

- `method` : Method name for test class
- `description` : Used to phpDoc of the test
- `result` : Used to phpDoc of the test, expected result of the test.

### 2.2) Launch command ###

TODO