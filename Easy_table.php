<?php
/**
 * Created by PhpStorm.
 * User: Bapi Roy
 * Date: 9/11/17
 * Time: 3:09 AM
 * version: 0.1.0
 */

class Easy_table
{
    private $storageEngine='InnoDB';
    private $charset='utf8';
    private $collation='utf8_unicode_ci';
    private $fields = [];
    private $currentField;
    private $dbforge;

    public function __construct()
    {
        $ciObject =& get_instance();
        $ciObject->load->dbforge();
        $this->dbforge = $ciObject->dbforge;

        $this->currentField = '';
    }

    /**
     * @param string $fieldName
     * @param int $size
     * @return $this
     */
    public function increments($fieldName='', $size=10)
    {
        $this->currentField = $fieldName;
        $this->fields[$fieldName] = [
            'type' => 'INT',
            'constraint' => $size,
            'unsigned' => true,
            'auto_increment' => true
        ];
        return $this;
    }

    /**
     * @param string $fieldName
     * @param int $size
     * @param string $default
     * @param bool $unsigned
     * @return $this
     */
    public function integer($fieldName='', $size=10, $default='', $unsigned=true)
    {
        $this->currentField = $fieldName;
        $this->fields[$fieldName] = [
            'type' => 'INT',
            'constraint' => $size,
            'unsigned' => $unsigned,
            'default' => $default,

        ];
        return $this;
    }

    /**
     * @param string $fieldName
     * @param int $size
     * @param int $scale
     * @param int $default
     * @param bool $unsigned
     * @return $this
     */
    public function decimal($fieldName='', $size=0, $scale=0, $default=0, $unsigned=true)
    {
        $this->currentField = $fieldName;
        $this->fields[$fieldName] = [
            'type' => 'DECIMAL',
            'constraint' => "$size, $scale",
            'unsigned' => $unsigned,
            'default' => $default,

        ];
        return $this;
    }

    /**
     * @param string $fieldName
     * @param int $size
     * @param int $scale
     * @param int $default
     * @param bool $unsigned
     * @return $this
     */
    public function float($fieldName='', $size=0, $scale=0, $default=0, $unsigned=true)
    {
        $this->currentField = $fieldName;
        $this->fields[$fieldName] = [
            'type' => 'FLOAT',
            'constraint' => "$size, $scale",
            'unsigned' => $unsigned,
            'default' => $default,

        ];
        return $this;
    }

    /**
     * @param string $fieldName
     * @param bool $default
     * @return $this
     */
    public function boolean($fieldName='', $default=false)
    {
        $this->currentField = $fieldName;
        $this->fields[$fieldName] = [
            'type' => 'INT',
            'constraint' => 1,
            'unsigned' => true,
            'default' => $default,
        ];
        return $this;
    }

    /**
     * @param string $fieldName
     * @param int $size
     * @param bool $default
     * @return $this
     */
    public function char($fieldName='', $size=0, $default=false)
    {
        $this->currentField = $fieldName;
        $this->fields[$fieldName] = [
            'type' => 'VARCHAR',
            'constraint' => $size,
            'default' => $default,
        ];
        return $this;
    }

    /**
     * @param string $fieldName
     * @return $this
     */
    public function text($fieldName='')
    {
        $this->currentField = $fieldName;
        $this->fields[$fieldName] = [
            'type' => 'TXT',
        ];
        return $this;
    }

    /**
     * @param string $fieldName
     * @param bool $default
     * @return $this
     */
    public function date($fieldName='', $default=false)
    {
        $this->currentField = $fieldName;
        $this->fields[$fieldName] = [
            'type' => 'DATE',
            'default' => $default,
        ];
        return $this;
    }

    /**
     * @param string $fieldName
     * @param bool $default
     * @return $this
     */
    public function dateTime($fieldName='', $default=false)
    {
        $this->currentField = $fieldName;
        $this->fields[$fieldName] = [
            'type' => 'DATETIME',
            'default' => $default,
        ];
        return $this;
    }

    /**
     * @return $this
     */
    public function primary()
    {
        $this->dbforge->add_key($this->currentField, true);
        return $this;
    }

    /**
     * @return $this
     */
    public function index()
    {
        $this->dbforge->add_key($this->currentField);
        return $this;
    }

    /**
     * @return $this
     */
    public function unique()
    {
        array_push($this->fields[$this->currentField], [
            'unique' => true
        ]);

        return $this;
    }

    /**
     * @return $this
     */
    public function null()
    {
        array_push($this->fields[$this->currentField], [
            'null' => true
        ]);

        return $this;
    }

    /**
     * @param string $storageEngine
     * @return $this
     */
    public function setStorageEngine($storageEngine)
    {
        $this->storageEngine = $storageEngine;
        return $this;
    }

    /**
     * @param string $charset
     * @return $this
     */
    public function setCharset($charset)
    {
        $this->charset = $charset;
        return $this;
    }

    /**
     * @param string $collation
     * @return $this
     */
    public function setCollation($collation)
    {
        $this->collation = $collation;
        return $this;
    }

    /**
     * @return string
     */
    public function getStorageEngine()
    {
        return $this->storageEngine;
    }

    /**
     * @return string
     */
    public function getCharset()
    {
        return $this->charset;
    }

    /**
     * @return string
     */
    public function getCollation()
    {
        return $this->collation;
    }


}