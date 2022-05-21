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
      "directories": ["../../customer-packages"],
      "require": {
          ..add dependencies...
      },
      "require-dev": {
          ..add dependencies...
      }
    }
  }
~~~

## FAQ

### not installed dependencies in recently clones

~~~
$ composer update #first time install main require and require-dev
$ composer update #second time install from composer-repository-directory
~~~
