# IScaled Solution: PHP test

## 1. Requirements
  - PHP 8.1 +
  - MySQL 8.0.30 +
  - Composer 2.4
  
## 2. Installation

  - Install the dependecies of the project using the command `composer install`
  - To ensure that all the autoload is setup properly you run `composer dumpautoload`
  - Setup your local database by creating an empty database named "phptest" on your MySQL server then import the dbdump.sql in the "phptest" database
  - Create environment variable. Duplicate and rename the `.env.example` to `.env` and replace the necessary details.
  - Now you can run the app using the command `php index.php`
  
