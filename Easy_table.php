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
    private $storageEngine = 'InnoDB';
    private $charset = 'utf8';
    private $collation = 'utf8_unicode_ci';
    private $comment = '';
    private $fields = [];
    private $currentField;
    private $dbforge;

    protected function __construct()
    {
        $ciObject =& get_instance();
        $ciObject->load->dbforge();
        $this->dbforge = $ciObject->dbforge;

        $this->currentField = '';
    }

    protected function fields(){

    }

    /**
     * @param string $fieldName
     * @param int $size
     * @return $this
     */
    protected function increments($fieldName='', $size=10)
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
     * @param int $default
     * @param bool $unsigned
     * @return $this
     */
    protected function integer($fieldName='', $size=10, $default=0, $unsigned=true)
    {
        $this->currentField = $fieldName;
        $this->fields[$fieldName] = [
            'type' => 'INT',
            'constraint' => $size,
            'unsigned' => $unsigned,
        ];
        $this->setDefault($default);
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
    protected function decimal($fieldName='', $size=0, $scale=0, $default=0, $unsigned=true)
    {
        $this->currentField = $fieldName;
        $this->fields[$fieldName] = [
            'type' => 'DECIMAL',
            'constraint' => "$size, $scale",
            'unsigned' => $unsigned,
        ];
        $this->setDefault($default);
        return $this;
    }

    /**
     * @param string $fieldName
     * @param int $size
     * @param int $scale
     * @param int $default
     * @return $this
     */
    protected function money($fieldName='', $size=10, $scale=2, $default=0)
    {
        $this->currentField = $fieldName;
        $this->fields[$fieldName] = [
            'type' => 'DECIMAL',
            'constraint' => "$size, $scale",
            'unsigned' => true,
        ];
        $this->setDefault($default);
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
    protected function float($fieldName='', $size=0, $scale=0, $default=0, $unsigned=true)
    {
        $this->currentField = $fieldName;
        $this->fields[$fieldName] = [
            'type' => 'FLOAT',
            'constraint' => "$size, $scale",
            'unsigned' => $unsigned,
        ];
        $this->setDefault($default);
        return $this;
    }

    /**
     * @param string $fieldName
     * @param bool $default
     * @return $this
     */
    protected function boolean($fieldName='', $default=false)
    {
        $this->currentField = $fieldName;
        $this->fields[$fieldName] = [
            'type' => 'INT',
            'constraint' => 1,
            'unsigned' => true,
        ];
        $this->setDefault($default);
        return $this;
    }

    /**
     * @param string $fieldName
     * @param int $size
     * @param string $default
     * @return $this
     */
    protected function char($fieldName='', $size=255, $default='')
    {
        $this->currentField = $fieldName;
        $this->fields[$fieldName] = [
            'type' => 'VARCHAR',
            'constraint' => $size,
        ];
        $this->setDefault($default);
        return $this;
    }

    /**
     * @param string $fieldName
     * @return $this
     */
    protected function text($fieldName='')
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
    protected function date($fieldName='', $default=false)
    {
        $this->currentField = $fieldName;
        $this->fields[$fieldName] = [
            'type' => 'DATE',
        ];
        $this->setDefault($default);
        return $this;
    }

    /**
     * @param string $fieldName
     * @param bool $default
     * @return $this
     */
    protected function dateTime($fieldName='', $default=false)
    {
        $this->currentField = $fieldName;
        $this->fields[$fieldName] = [
            'type' => 'DATETIME',
        ];
        $this->setDefault($default);
        return $this;
    }

    /**
     * It is  ENUM data type
     * @param string $fieldName
     * @param array $choice
     * @param string $default
     * @return $this
     */
    protected function choice($fieldName='', array $choice, $default='')
    {
        $type = "ENUM(";
        foreach ($choice as $val){
            $type .= "'".$val."',";
        }
        $type = rtrim($type, ',');
        $type .= ")";
        $this->currentField = $fieldName;
        $this->fields[$fieldName] = [
            'type' => $type,
        ];
        $this->setDefault($default);
        return $this;
    }
    /**
     * @return $this
     */
    protected function primary()
    {
        $this->dbforge->add_key($this->currentField, true);
        return $this;
    }

    /**
     * @return $this
     */
    protected function index()
    {
        $this->dbforge->add_key($this->currentField);
        return $this;
    }

    /**
     * @return $this
     */
    protected function unique()
    {
        array_push($this->fields[$this->currentField], [
            'unique' => true
        ]);

        return $this;
    }

    /**
     * @return $this
     */
    protected function null()
    {
        array_push($this->fields[$this->currentField], [
            'null' => true
        ]);

        return $this;
    }


    /**
     * Add comment to column
     * @param string $comment
     * @return $this
     */
    protected function comment($comment=''){
        if(!$comment){
            $this->fields[$this->currentField]['comment'] = $default;
        }

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

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }


    /**
     * @param string $default
     * @return $this
     */
    private function setDefault($default=''){
        if(!$default){
            $this->fields[$this->currentField]['default'] = $default;
        }

        return $this;
    }
}