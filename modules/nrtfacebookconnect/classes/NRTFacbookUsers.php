<?php

class NRTFacebookUsers extends ObjectModel{
	public $id;
	public $id_user;
	public $id_shop_group;
	public $id_shop;
	public $first_name;
	public $last_name;
	public $email;
	public $gender;
	public $birthday;
	public $date_add;
	public $date_upd;

	public static $definition = array(
		'table' => 'nrtfacebookusers',
		'primary' => 'id',
		'fields' => array(
			'id_user' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 100, 'required' => true),
			'id_shop_group' => array('type' => self::TYPE_INT, 'validate' => 'isInt', 'size' => 11, 'required' => true),
			'id_shop' => array('type' => self::TYPE_INT, 'validate' => 'isInt', 'size' => 11, 'required' => true),
		    'first_name' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 100),
		    'last_name' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 100),
		    'email' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 100),
		    'gender' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 100),
		    'birthday' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
		    'date_add' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
		    'date_upd' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
	    ),
    );

	public function add($autodate = true, $null_values = false){
		if (!parent::add($autodate, $null_values))
			return false;
		return true;
	}
}
