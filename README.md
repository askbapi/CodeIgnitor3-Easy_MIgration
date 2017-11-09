# CodeIgnitor3-Easy_Migration
CodeIgnitor 3 library that makes migration easy and efficient.

It only support MYSQL database on current version.

## Requirement
+ CodeIgnitor version 3
+ PHP 5.6+
+ MYSQL 5.6+

## Installation and Preparedness
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

The file should manually include **Easy_table.php** file on top. The class should extend Easy_table class as shown in above example.

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

## Available methods Easy_migration.php
### migrate
Execute the migration. Creates table and json files.

***Parameters*** 
+ string $tableName - run migration only for specified table
+ int $version  - 0 equal to latest version

***Return*** 
+ Doesn't return anything

For overall migration
```php
$this->easy_migration->migrate();
```

For specific migration
```php
$this->easy_migration->migrate('persion', 2);
```

## Available methods Easy_table.php

### primary
Make the field primary. It is after field defination.
***Parameters*** 
+ No parameters need

***Return*** 
+ Doesn't return anything

```php
increments('id')->primary()
```

### index
Behave same as primary method. But only do index on the field.

***Parameters*** 
+ No parameters need

***Return*** 
+ Doesn't return anything

### unique
Behave same as primary method. But only do unique on the field.

***Parameters*** 
+ No parameters need

***Return*** 
+ Doesn't return anything

### null
Allow the field to have null value

***Parameters*** 
+ No parameters need

***Return*** 
+ Doesn't return anything

### increments
It is a field that is unsigned interger having constraint of 10. It is generally used for primary key with AUTO_INCREMENT.

***Parameters*** 
+ string $fieldName - Name of the field
+ int $size - constraint

***Return*** 
+ Doesn't return anything

### integer
Make field integer

***Parameters*** 
+ string $fieldName - Name of the field
+ int $size - constraint
+ string $default - default value for the field. By default set to **0**
+ bool $unsigned - make the field signed (false) or unsigned (true). By default set to **true**

***Return*** 
+ Doesn't return anything

### decimal
Make field decimal

***Parameters*** 
+ string $fieldName - Name of the field
+ int $size - whole-number part
+ int $scale - fractional part
+ string $default - default value for the field. By default set to **0**
+ bool $unsigned - make the field signed (false) or unsigned (true). By default set to **true**

***Return*** 
+ Doesn't return anything

### float
Make field float

***Parameters*** 
+ string $fieldName - Name of the field
+ int $size - whole-number part
+ int $scale - fractional part
+ string $default - default value for the field. By default set to **0**
+ bool $unsigned - make the field signed (false) or unsigned (true). By default set to **true**

***Return*** 
+ Doesn't return anything

### boolean
Integet field act as boolean. 0 is equal to false and 1 is equal to true.

***Parameters*** 
+ string $fieldName - Name of the field
+ string $default - default value for the field. By default set to **false**

***Return*** 
+ Doesn't return anything

### char
Make field varchar

***Parameters*** 
+ string $fieldName - Name of the field
+ int $size - constraint
+ string $default - default value for the field. 

***Return*** 
+ Doesn't return anything

### text
Make field text

***Parameters*** 
+ string $fieldName - Name of the field

***Return*** 
+ Doesn't return anything

### date
Make field date

***Parameters*** 
+ string $fieldName - Name of the field
+ string $default - default value for the field. By default set to **0000-00-00**

***Return*** 
+ Doesn't return anything

### dateTime
Make field datetime

***Parameters*** 
+ string $fieldName - Name of the field
+ string $default - default value for the field. By default set to **0000-00-00**

***Return*** 
+ Doesn't return anything

### setTableName
Take a table name

***Parameters*** 
+ string $tableName

***Return*** 
+ Doesn't return anything

### setStorageEngine
Define MYSQL engine type

***Parameters*** 
+ string $storageEngine - Define MYSQL engine type. By default set to **InnoDB**

***Return*** 
+ Doesn't return anything

### setCharset
Set charset for the table

***Parameters*** 
+ string $charset - By default set to **uft8**

***Return*** 
+ Doesn't return anything

### setCollation 
Set collation for the table

***Parameters*** 
+ string $collation - By default set to **utf8_unicode_ci**

***Return*** 
+ Doesn't return anything

___
Enjoy using my Easy_migration and please report any issues you find or try some pull requests. 
Thank you!