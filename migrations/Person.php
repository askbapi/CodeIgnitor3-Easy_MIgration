<?php
/**
 * Created by PhpStorm.
 * User: bapi
 * Date: 9/11/17
 * Time: 11:31 PM
 */

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