visualSelenium
==============

This repository provides an extended selenium testCase class with an createScreenshot function.
with this function you can generated an screenshot with implemented message.

Installation
------------

Add this repository to your composer.json as below:

```php
{
    ...
    "repositories":[
        ...
        ,
        {
            "type": "git",
            "url": "https://github.com/Seretos/visualSelenium"
        },
        {
            "type": "git",
            "url": "https://github.com/Seretos/fileManager"
        }
    ],
    ...
    "require-dev": {
        ...
        "Seretos/visualSelenium": "0.1.*"
    }
}
```

Usage
-----

see [example selenium test](./tests/integration/VisualSeleniumIntegrationTest.php)