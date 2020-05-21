<?php
/**
 * 2007-2018 ETS-Soft
 *
 * NOTICE OF LICENSE
 *
 * This file is not open source! Each license that you purchased is only available for 1 wesite only.
 * If you want to use this file on more websites (or projects), you need to purchase additional licenses. 
 * You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
 * 
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please contact us for extra customization service at an affordable price
 *
 *  @author ETS-Soft <etssoft.jsc@gmail.com>
 *  @copyright  2007-2018 ETS-Soft
 *  @license    Valid for 1 website (or project) for each purchase of license
 *  International Registered Trademark & Property of ETS-Soft
 */

class Ets_contact_reply_class extends ObjectModel
{
    public $id_contact_message;
    public $id_employee;
    public $content;
    public $reply_to;
    public $subject;
    public $date_add;
    public $date_upd;
    public static $definition = array(
        'table' => 'ets_ctf_message_reply',
        'primary' => 'id_ets_ctf_message_reply',
        'fields' => array(
            'id_contact_message'=>     array('type'=> self::TYPE_INT),
            'id_employee'=>     array('type'=> self::TYPE_INT),
            'content'=>     array('type'=> self::TYPE_HTML),
            'reply_to' => array('type'=> self::TYPE_HTML),
            'subject' => array('type'=> self::TYPE_HTML),
            'date_add' => array('type'=>self::TYPE_DATE),
            'date_upd' => array('type'=>self::TYPE_DATE),
        ),
    );
    public	function __construct($id_item = null, $id_lang = null, $id_shop = null)
	{
		parent::__construct($id_item, $id_lang, $id_shop);
    }
}