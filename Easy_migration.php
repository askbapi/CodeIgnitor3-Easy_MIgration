<?php
/**
 * Created by PhpStorm.
 * User: Bapi Roy
 * Date: 9/11/17
 * Time: 3:09 AM
 * version: 0.1.0
 */

class Easy_migration
{
    public function __construct()
    {

    }

    // $Version = 0 equal to latest version
    public function migrate($version=0, $tableName='')
    {
        // Load all files and class from Migration directory
        $classFiles = array_diff(scandir('migrations', 1), array('..', '.'));
        foreach ($classFiles as $className){
            # Load Class
            include_once APPPATH.'migrations/'.$className.'.php';
            $objjectClassName = ucfirst($className);
            $object = new $objjectClassName;

            # Execute the fields method
            $object->fields();

            # Collect Array
            $fields = $object->getFields();

            # Create JSON file under migrate directory with incremental value

            # Get class name as Table name
            # Create Table

        }

    }


}

