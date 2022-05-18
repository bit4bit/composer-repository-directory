# composer-repository-directory

composer plugin that allow use packages from directories.


## Usage

~~~
$ composer require bit4bit/composer-repository-directory
~~~

add to composer.json:

~~~
 "extra": {
    "composer-repository-directory": {
      "directories": ["../../customer-packages"]
    }
  }
~~~
