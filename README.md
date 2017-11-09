# CodeIgnitor3-Easy_Migration
CodeIgnitor 3 library that makes migration easy and efficient.

## Requirement

## Installation
+ Download and drag the Migrationfields.php file into your application/libraries directory.
+ Create a writable sub-directory of **migrations** called **json**.

## How it works
When migrate method is called via Migrate controller, Easy_migration instance look for files present in **mingrations** director under **application**. It loop thought all files and create instance of each class present in those mutational files. A public method **fields()** is called and it generate fields array. It contain detail for creation of table. Before creating table in database, a json file (example 001_tablename.json) with version number is saved in sub-directory called **json**. Which later can be called to restore the table to the structure mentioned in the json file. Note, no migration information in store in database.

## How to use it
+ Create a file in migration directory **Person.php**.
```php
<?php
include_once APPPATH.'libraries/Easy_table.php';

class Person extends Easy_table
{
    public function __construct()
    {
        parent::__construct();
    }

    public function fields()
    {
        $this->increments('id')->primary()
            ->char('first_name', 100)
            ->char('middle_name', 100)->null()
            ->char('email', 100)->unique()
            ->integer('age', 3, 0)
            ->decimal('assert', 8,2)
            ->date('dob')->index();
    }
}
```
A file in migration directory should have single class with two required method know as **constructor** and **fields**. 

The file should manually include **Easy_table.php" file on top. The class should extend Easy_table class as shown in above example.

File name and class name should start with capital letter. Example **Person.php** should have **class Person**


+ Create **migrate** controller.
```php
<?php
class Migrate extends CI_Controller
{
    public function index()
    {
        $this->load->library('easy_migration');

        echo "Running";
        $this->easy_migration->migrate();
    }

}
```
+ To run the migration just, call the migration from browser (http://host.com/migrate)


___
Enjoy using my Easy_migration and please report any issues you find or try some pull requests. 
Thank you!