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
    const BASEPATH =  'migrations/';

    public function __construct()
    {

    }


    /**
     * Run migration with the help of fiels in migrations directory
     * @param string $tableName - run migration only for specified table
     * @param int $version  - 0 equal to latest version
     */
    public function migrate($tableName='', $version=0)
    {
        if((empty($tableName)) && ($version <= 0)){
            $this->runForLatest();
        }else{
            $this->runfo();
        }
    }

    private function runFor($className='', $version=0){

        if($version > 0){
            // Get the respective JSON file with version number
            $file = self::BASEPATH.'json/'.str_pad($version, 3, "0", STR_PAD_LEFT).'_'.$className.'.json';

            if(!file_exists($file)){
                throw new Exception("JSON file does not exist.");
            }

            // Get Field Array from JSON file
            $fields = json_decode(file_get_contents($file));

            // Get class name as Table name & Create Table
            $this->dbforge->add_field($fields);

            $tableAttributes = [
                'ENGINE' => $object->storageEngine,
                'CHARACTER SET' => $object->charset,
                'COLLATE' => $object->collation,
            ];
            $this->dbforge->create_table($this->tableName, true, $tableAttributes);
        }else{
            // Get data from migration class
            $file = self::BASEPATH.$className.'.php';
            $objectClassName = ucfirst($className);
            $object = new $objectClassName;

            // Execute the fields method
            $object->fields();

            // Collect Array
            $fields = $object->getFields();

            // Get Table Attributes
            $tableAttributes = [
                'ENGINE' => $object->storageEngine,
                'CHARACTER SET' => $object->charset,
                'COLLATE' => $object->collation,
            ];

            # Create JSON file under migrate directory with incremental value
            $this->createJsonFile($fields, $objectClassName);

            # Get class name as Table name & Create Table
            $this->dbforge->add_field($fields);


            $this->dbforge->create_table($this->tableName, true, $tableAttributes);
        }


    }

    /**
     * Run when migration run for Latest file
     */
    private function runForLatest(){
        // Load all files and class from Migration directory
        $classFiles = array_diff(scandir(self::BASEPATH, 1), array('..', '.'));
        foreach ($classFiles as $className){
            # Load Class
            include_once self::BASEPATH.$className.'.php';
            $objectClassName = ucfirst($className);
            $object = new $objectClassName;

            # Execute the fields method
            $object->fields();

            # Collect Array
            $fields = $object->getFields();

            # Create JSON file under migrate directory with incremental value
            $this->createJsonFile(
                $fields,
                $objectClassName,
                $this->getTableAttributes($object)
                );

            # Get class name as Table name & Create Table
            $this->dbforge->add_field($fields);


            $this->dbforge->create_table($this->tableName, true, $tableAttributes);
        }
    }


    /**
     * Save fields into JSON file with incremented version number
     * @param array $fields
     * @param string $className
     * @param array $tableAttributes
     */
    private function createJsonFile(array $fields, $className='', array $tableAttributes)
    {
        // Search for last File
        $jsonFiles = array_diff(
            scandir(self::BASEPATH.'json', SCANDIR_SORT_ASCENDING),
            ['..', '.']
        );

        $latestVersion = 0;
        foreach ($jsonFiles as $file){
            if (strpos($file, $className) !== false) {
                //File found, get latest version
                $fileNameParts = explode('_', $file);
                $currentVersion = (int) $fileNameParts[0];

                if($currentVersion > $latestVersion){
                    $latestVersion = $currentVersion;
                }
            }
        }

        // New Version
        $newVersion = $latestVersion + 1;
        $newFile = self::BASEPATH.'json/'.str_pad($newVersion, 3, "0", STR_PAD_LEFT).'_'.strtolower($className).'.json';

        $jsonData = json_encode(
            [
                'fields'=> $fields,
                'tableAttributes' => $tableAttributes
            ]
        );

        file_put_contents($newFile, $jsonData);
    }


    /**
     * Collect table attributes from migration object and return as array
     * @param $object
     * @return array
     */
    private function getTableAttributes($object)
    {
        return [
            'ENGINE' => $object->storageEngine,
            'CHARACTER SET' => $object->charset,
            'COLLATE' => $object->collation,
        ];
    }
}
