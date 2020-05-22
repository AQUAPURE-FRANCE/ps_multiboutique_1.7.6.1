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

class Ets_contact_class extends ObjectModel
{
    public $title;
    public $short_code;
    public $email_to;
    public $bcc;
    public $bcc2;
    public $email_from;
    public $subject;
    public $additional_headers;
    public $message_body;
    public $exclude_lines;
    public $use_html_content;
    public $file_attachments;
    public $hook;
    public $template_mail;
    public $use_email2;
    public $email_to2;
    public $email_from2;
    public $subject2;
    public $additional_headers2;
    public $message_body2;
    public $exclude_lines2;
    public $use_html_content2;
    public $file_attachments2;
    public $message_mail_sent_ok;
    public $message_mail_sent_ng;
    public $message_validation_error;
    public $message_spam;
    public $message_accept_terms;
    public $message_invalid_required;
    public $message_invalid_too_long;
    public $message_invalid_too_short;
    public $message_invalid_date;
    public $message_date_too_early;
    public $message_date_too_late;
    public $message_upload_failed;
    public $message_upload_file_type_invalid;
    public $message_upload_file_too_large;
    public $message_quiz_answer_not_correct;
    public $message_invalid_email;
    public $message_invalid_url;
    public $message_invalid_tel;
    public $additional_settings;
    public $save_message;
    public $star_message;
    public $save_attachments;
    public $open_form_by_button;
    public $button_label;
    public $id_employee;
    public $date_add;
    public $date_upd;
    public $message_upload_failed_php_error;
    public $message_invalid_number;
    public $message_number_too_small;
    public $message_number_too_large;
    public $message_captcha_not_match;
    public $message_ip_black_list;
    public $title_alias;
    public $meta_title;
    public $meta_keyword;
    public $meta_description;
    public $enable_form_page;
    public $position;
    public $active;
    public static $definition = array(
        'table' => 'ets_ctf_contact',
        'primary' => 'id_contact',
        'multilang' => true,
        'fields' => array(
            'email_to'=>     array('type'=> self::TYPE_HTML),
            'bcc'=>     array('type'=> self::TYPE_HTML),
            'active' => array('type'=>self::TYPE_INT),
            'email_from'=>     array('type'=> self::TYPE_HTML),
            'additional_headers'=>     array('type'=> self::TYPE_HTML),
            'exclude_lines' => array('type'=>self::TYPE_INT),
            'use_html_content'=> array('type'=>self::TYPE_INT),
            'save_message' => array('type'=>self::TYPE_INT),
            'star_message'=>array('type'=>self::TYPE_INT),
            'save_attachments' => array('type'=>self::TYPE_INT),
            'open_form_by_button' => array('type'=>self::TYPE_INT),
            'hook'=>array('type'=>self::TYPE_HTML),
            'button_label' => array('type'=>self::TYPE_HTML,'lang'=>true),
            'id_employee' => array('type'=>self::TYPE_INT),
            'title' =>    array('type' => self::TYPE_HTML,'lang'=>true),
            'short_code' =>  array('type' => self::TYPE_HTML,'lang'=>true),
            'subject' =>    array('type' => self::TYPE_HTML,'lang'=>true),
            'message_body'=> array('type'=> self::TYPE_HTML,'lang'=>true),
            'file_attachments'=> array('type'=> self::TYPE_HTML),
            'use_email2' => array('type'=>self::TYPE_INT),
            'email_to2' => array('type'=>self::TYPE_HTML),
            'bcc2'=>     array('type'=> self::TYPE_HTML),
            'email_from2' => array('type'=>self::TYPE_HTML),
            'subject2'=> array('type'=>self::TYPE_HTML,'lang'=>true),
            'additional_headers2'=>array('type'=> self::TYPE_HTML),
            'message_body2' => array('type'=> self::TYPE_HTML,'lang'=>true),
            'exclude_lines2' => array('type'=>self::TYPE_INT),
            'use_html_content2'=> array('type'=>self::TYPE_INT),
            'file_attachments2'=> array('type'=> self::TYPE_HTML),
            'message_mail_sent_ok'=> array('type'=>self::TYPE_HTML,'lang'=>true),
            'message_mail_sent_ng'=> array('type'=>self::TYPE_HTML,'lang'=>true),
            'message_validation_error'=> array('type'=>self::TYPE_HTML,'lang'=>true),
            'message_spam'=> array('type'=>self::TYPE_HTML,'lang'=>true),
            'message_accept_terms'=> array('type'=>self::TYPE_HTML,'lang'=>true),
            'message_invalid_required'=> array('type'=>self::TYPE_HTML,'lang'=>true),
            'message_invalid_too_long'=> array('type'=>self::TYPE_HTML,'lang'=>true),
            'message_invalid_too_short'=> array('type'=>self::TYPE_HTML,'lang'=>true),
            'message_date_too_early'=> array('type'=>self::TYPE_HTML,'lang'=>true),
            'message_date_too_late'=> array('type'=>self::TYPE_HTML,'lang'=>true),
            'message_invalid_date'=> array('type'=>self::TYPE_HTML,'lang'=>true),
            'message_upload_failed'=> array('type'=>self::TYPE_HTML,'lang'=>true), 
            'message_upload_file_type_invalid'=> array('type'=>self::TYPE_HTML,'lang'=>true),
            'message_upload_file_too_large'=> array('type'=>self::TYPE_HTML,'lang'=>true),
            'message_quiz_answer_not_correct'=> array('type'=>self::TYPE_HTML,'lang'=>true),
            'message_invalid_email'=> array('type'=>self::TYPE_HTML,'lang'=>true),
            'message_invalid_url'=> array('type'=>self::TYPE_HTML,'lang'=>true),
            'message_invalid_tel'=> array('type'=>self::TYPE_HTML,'lang'=>true),
            'additional_settings'=> array('type'=>self::TYPE_HTML,'lang'=>true),
            'message_upload_failed_php_error'=>array('type'=>self::TYPE_HTML,'lang'=>true),
            'message_invalid_number'=>array('type'=>self::TYPE_HTML,'lang'=>true),
            'message_number_too_small'=>array('type'=>self::TYPE_HTML,'lang'=>true),
            'message_number_too_large'=>array('type'=>self::TYPE_HTML,'lang'=>true),
            'message_captcha_not_match'=>array('type'=>self::TYPE_HTML,'lang'=>true),
            'message_ip_black_list'=>array('type'=>self::TYPE_HTML,'lang'=>true),
            'template_mail'=>array('type'=>self::TYPE_HTML,'lang'=>true),
            'title_alias'=>array('type'=>self::TYPE_HTML,'lang'=>true),
            'meta_title'=>array('type'=>self::TYPE_HTML,'lang'=>true),
            'meta_keyword'=>array('type'=>self::TYPE_HTML,'lang'=>true),
            'meta_description'=>array('type'=>self::TYPE_HTML,'lang'=>true),
            'enable_form_page' => array('type'=>self::TYPE_INT),
            'position' => array('type'=>self::TYPE_INT),
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
			INSERT INTO `'._DB_PREFIX_.'ets_ctf_contact_shop` (`id_shop`, `id_contact`)
			VALUES('.(int)$id_shop.', '.(int)$this->id.')'
		);
		return $res;
   	}
}