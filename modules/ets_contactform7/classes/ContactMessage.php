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

class Ets_contact_message_class extends ObjectModel
{
    public $id_contact;
    public $id_customer;
    public $subject;
    public $sender;
    public $body;
    public $recipient;
    public $attachments;
    public $replied;
    public $reply_to;
    public $special;
    public $readed;
    public $date_add;
    public $date_upd;
    public static $definition = array(
        'table' => 'ets_ctf_contact_message',
        'primary' => 'id_contact_message',
        'fields' => array(
            'id_contact'=>     array('type'=> self::TYPE_INT),
            'id_customer' => array('type'=> self::TYPE_INT),
            'subject'=>     array('type'=> self::TYPE_HTML),
            'sender'=>     array('type'=> self::TYPE_HTML),
            'readed' =>array('type'=> self::TYPE_INT),
            'special' =>array('type'=> self::TYPE_INT),
            'body' => array('type'=>self::TYPE_HTML),
            'recipient' => array('type'=>self::TYPE_HTML),
            'attachments' => array('type'=>self::TYPE_HTML),
            'reply_to' => array('type'=>self::TYPE_HTML),
            'replied'=> array('type'=>self::TYPE_INT),
            'date_add' => array('type'=>self::TYPE_DATE),
            'date_upd' => array('type'=>self::TYPE_DATE),
        ),
    );
    public	function __construct($id_item = null, $id_lang = null, $id_shop = null)
	{
		parent::__construct($id_item, $id_lang, $id_shop);
    }
    public function add($autodate = true, $null_values = false)
   	{
		$context = Context::getContext();
		$id_shop = $context->shop->id;
		$res = parent::add($autodate, $null_values);
		$res &= Db::getInstance()->execute('
			INSERT INTO `'._DB_PREFIX_.'ets_ctf_contact_message_shop` (`id_shop`, `id_contact_message`)
			VALUES('.(int)$id_shop.', '.(int)$this->id.')'
		);
		return $res;
   	}
}