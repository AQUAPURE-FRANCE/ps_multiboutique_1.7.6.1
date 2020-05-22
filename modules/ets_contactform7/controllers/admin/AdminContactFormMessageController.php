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

if (!defined('_PS_VERSION_'))
    	exit;
require_once(_PS_MODULE_DIR_.'ets_contactform7/classes/ContactReply.php');
require_once(_PS_MODULE_DIR_.'ets_contactform7/classes/ctf_paggination_class.php');
class AdminContactFormMessageController extends ModuleAdminController
{
   public function __construct()
   {
       parent::__construct();
       $this->bootstrap = true;
   }
   public function initContent()
   {
        parent::initContent();
        if(Tools::isSubmit('submitSpecialActionMessage') && $id_message=Tools::getValue('id_contact_message'))
        {
            $messages = array();
            Db::getInstance()->execute('UPDATE '._DB_PREFIX_.'ets_ctf_contact_message SET special="'.(int)Tools::getValue('submitSpecialActionMessage').'" WHERE id_contact_message ="'.(int)$id_message.'"');
            $messages[$id_message] = $this->displayRowMesage($id_message);
            die(
                Tools::jsonEncode(
                    array(
                        'ok'=>true,
                        'messages'=>$messages,
                    )
                )
            );
        }
        if(Tools::isSubmit('submitBulkActionMessage'))
        {
            $bulk_action_message=Tools::getValue('bulk_action_message');
            if($bulk_action_message && Tools::getValue('message_readed'))
            {
                if($bulk_action_message=='mark_as_read')
                {
                    $messages = array();
                    foreach(Tools::getValue('message_readed') as $key=>$value)
                    {
                        Db::getInstance()->execute('UPDATE '._DB_PREFIX_.'ets_ctf_contact_message SET readed=1 WHERE id_contact_message ="'.(int)$key.'"');
                        unset($value);
                        $messages[$key] = $this->displayRowMesage($key);
                    }
                    die(
                        Tools::jsonEncode(
                            array(
                                'ok'=>true,
                                'messages'=>$messages,
                                'count_messages' => $this->module->getCountMessageNoReaed(),
                            )
                        )
                    );
                    
                }
                elseif($bulk_action_message=='mark_as_unread')
                {
                    $messages = array();
                    foreach(Tools::getValue('message_readed') as $key=>$value)
                    {
                        Db::getInstance()->execute('UPDATE '._DB_PREFIX_.'ets_ctf_contact_message SET readed=0 WHERE id_contact_message ="'.(int)$key.'"');
                        unset($value);
                        $messages[$key] = $this->displayRowMesage($key);
                    }
                    die(
                        Tools::jsonEncode(
                            array(
                                'ok'=>true,
                                'messages'=>$messages,
                                'count_messages' => $this->module->getCountMessageNoReaed(),
                            )
                        )
                    );
                    
                }
                elseif($bulk_action_message=='delete_selected')
                {
                    foreach(Tools::getValue('message_readed') as $key=>$value)
                    {
                        $attachments= Db::getInstance()->getValue('SELECT attachments FROM '._DB_PREFIX_.'ets_ctf_contact_message WHERE id_contact_message="'.(int)$key.'"');
                        if($attachments)
                        {
                            foreach(explode(',',$attachments) as $attachment)
                            {
                                @unlink(dirname(__FILE__).'/../../views/img/etscf7_upload/'.$attachment);
                            }
                        }
                        Db::getInstance()->execute('DELETE FROM '._DB_PREFIX_.'ets_ctf_contact_message WHERE id_contact_message ="'.(int)$key.'"');
                        unset($value);
                    }
                    die(
                        Tools::jsonEncode(
                            array(
                                'ok'=>true,
                                'url_reload'=>$this->context->link->getAdminLink('AdminContactFormMessage',true).'&conf=1'
                            )
                        )
                    );
                }
            }
        }
        if(Tools::isSubmit('submitReplyMessage') && $id_message=Tools::getValue('id_message'))
        {
            $reply= new Ets_contact_reply_class();
            $errors = array();
            if(!Tools::getValue('reply_to')|| !Tools::getValue('reply_subject') || !Tools::getValue('message_reply'))
            {
                $errors[]= $this->module->l('All fields are required');
            }
            elseif(!Ets_contactform7::getEmailToString(Tools::getValue('reply_to')))
            {
                $errors[] = $this->module->l('Email is not validate');
            }
            if($errors)
            {
                die(
                Tools::jsonEncode(
                    array(
                        'error'=> $this->module->displayError($errors),
                    )  
                )
                );
            }
            else
            {
                $id_shop= Context::getContext()->shop->id;
                $link_basic =(Configuration::get('PS_SSL_ENABLED_EVERYWHERE')?'https://':'http://').Context::getContext()->shop->domain.Context::getContext()->shop->getBaseURI();
                if (Configuration::get('PS_LOGO_MAIL') !== false && file_exists(_PS_IMG_DIR_.Configuration::get('PS_LOGO_MAIL', null, null,$id_shop))) {
                    $logo = Configuration::get('PS_LOGO_MAIL', null, null,$id_shop);
                    $shop_logo ='<img src="'.$link_basic.'/img/'.$logo.'" alt="'.Configuration::get('PS_SHOP_NAME').'" >';
                } else {
                    if (file_exists(_PS_IMG_DIR_.Configuration::get('PS_LOGO', null, null,$id_shop))) {
                        $logo = Configuration::get('PS_LOGO', null, null,$id_shop);
                        $shop_logo ='<img src="'.$link_basic.'/img/'.$logo.'" alt="'.Configuration::get('PS_SHOP_NAME').'" >';
                    } else {
                        $shop_logo='';
                    }
                }
                $shop_url=Context::getContext()->link->getPageLink('index', true,Context::getContext()->language->id,null,false,$id_shop);
                $template_email = Configuration::get('ETS_CTF_TEMPLATE_3',Context::getContext()->language->id);
                $template_vars=array(
                    '{message_content}' => Configuration::get('ETS_CTF7_ENABLE_TEAMPLATE')? str_replace(array('{message_content}','{shop_name}','{shop_url}','{shop_logo}','%7Bshop_url%7D','%7Bshop_logo%7D'),array(Tools::getValue('message_reply'),Configuration::get('PS_SHOP_NAME'),$shop_url,$shop_logo,$shop_url,$shop_logo),$template_email): Tools::getValue('message_reply'),
                );
                $toEmail = Ets_contactform7::getEmailToString(Tools::getValue('reply_to'));
                $toName = str_replace(array('<','>',$toEmail),'',Tools::getValue('reply_to'));
        		$fromEmail = Ets_contactform7::getEmailToString(Tools::getValue('from_reply'));
                $fromName = str_replace(array('<','>',$fromEmail),'',Tools::getValue('from_reply'));
                $replyTo = Ets_contactform7::getEmailToString(Tools::getValue('reply_to_reply'));
                $replyToName = trim(str_replace(array('<','>',$replyTo),'',Tools::getValue('reply_to_reply')));
                if(Mail::Send(
        			Context::getContext()->language->id,
        			Configuration::get('ETS_CTF7_ENABLE_TEAMPLATE') ? 'contact_reply_form7' : 'contact_reply_form7_plain',
        			Tools::getValue('reply_subject'),
        			$template_vars,
        			$toEmail,
        			$toName ? $toName: null,
                    $fromEmail ? $fromEmail :null,
        			$fromName ? $fromName : null,
        			null,
                    null,
        			dirname(__FILE__).'/../../mails/',
        			null,
        			Context::getContext()->shop->id,
                    $replyTo? $replyTo :null,
                    $replyToName ? $replyToName :null
                ))
                {
                     $reply->id_contact_message=$id_message;
                     $reply->content = Tools::getValue('message_reply');
                     $reply->id_employee= $this->context->employee->id;
                     $reply->reply_to = Tools::getValue('reply_to');
                     $reply->subject = Tools::getValue('reply_subject');
                     $reply->add();
                     die(
                        Tools::jsonEncode(
                            array(
                                'success' => $this->module->l('Your message has been successfully sent'),
                                'message_reply' => Tools::getValue('message_reply'),
                                'id_message'=>$id_message,
                                'reply'=>$this->module->displayReplyMessage($reply),
                            ) 
                        )
                     );
                }
                else
                {
                    $errors[] = $this->module->l('An error occurred while sending the message');
                    die(
                        Tools::jsonEncode(
                            array(
                                'error'=> $this->module->displayError($errors),
                            )  
                        )
                    );
                }
                
            }
        }
        if(Tools::isSubmit('deleteMessage')&& $id_message=Tools::getValue('id_message'))
        {
            $attachments= Db::getInstance()->getValue('SELECT attachments FROM '._DB_PREFIX_.'ets_ctf_contact_message WHERE id_contact_message="'.(int)$id_message.'"');
            if($attachments)
            {
                foreach(explode(',',$attachments) as $attachment)
                {
                    @unlink(dirname(__FILE__).'/../../views/img/etscf7_upload/'.$attachment);
                }
            }
            Db::getInstance()->execute('DELETE FROM '._DB_PREFIX_.'ets_ctf_contact_message WHERE id_contact_message="'.(int)$id_message.'"');
            Db::getInstance()->execute('DELETE FROM '._DB_PREFIX_.'ets_ctf_contact_message_shop where id_contact_message='.(int)$id_message);
            Db::getInstance()->execute('DELETE FROM '._DB_PREFIX_.'ets_ctf_message_reply WHERE id_contact_message='.(int)$id_message);
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminContactFormMessage',true).'&conf=1');
        }
        if(Tools::isSubmit('ajax_ets') && Tools::isSubmit('viewMessage')&& $id_message=Tools::getValue('id_message'))
        {
            $message= $this->getMessageById($id_message);
            if($message['reply_to'] && Ets_contactform7::getEmailToString($message['reply_to']))
            {
                $message['reply_to_check']= true;
            }
            else
                $message['reply_to_check']=false;
            if($message)
            {
                $replies= $this->getRepliesByIdMessage($id_message);
                $this->context->smarty->assign(
                    array(
                        'message'=>$message,
                        'replies'=>$replies,
                    )
                );
                $message_html= $this->module->display(_PS_MODULE_DIR_.$this->module->name.DIRECTORY_SEPARATOR.$this->module->name.'.php', 'message.tpl');
                $messages = array();
                if(!Tools::getValue('message_readed'))
                {
                    Db::getInstance()->execute('UPDATE '._DB_PREFIX_.'ets_ctf_contact_message SET readed="1" WHERE id_contact_message ="'.(int)$id_message.'"');
                    $messages[$id_message] = $this->displayRowMesage($id_message);
                }
                die(Tools::jsonEncode(
                    array(
                        'message_html'=>$message_html,
                        'messages'=>$messages,
                        'count_messages' => $this->module->getCountMessageNoReaed(),
                    )
                ));
            }
        }
   }
   public function renderList()
   {
        if(Tools::isSubmit('viewMessage') && $id_message=Tools::getValue('id_message'))
        {
            $message= $this->getMessageById($id_message);
            if($message['reply_to'] && Ets_contactform7::getEmailToString($message['reply_to']))
            {
                $message['reply_to_check']= True;
            }
            else
                $message['reply_to_check']=false;
            if($message)
            {
                $replies= $this->getRepliesByIdMessage($id_message);
                $this->context->smarty->assign(
                    array(
                        'message'=>$message,
                        'replies'=>$replies,
                        'base_url' => $this->module->getBaseLink(),
                    )
                );
                return $this->module->display(_PS_MODULE_DIR_.$this->module->name.DIRECTORY_SEPARATOR.$this->module->name.'.php', 'message.tpl');
            }
        }
        else
        {
            $filter='';
            $url_extra='';
            $values_submit= array();
            if(Tools::getValue('id_contact'))
            {
                $filter .=' AND m.id_contact="'.(int)Tools::getValue('id_contact').'"';
                $url_extra .='&id_contact='.(int)Tools::getValue('id_contact');
                $values_submit['id_contact']=Tools::getValue('id_contact');
            }
            if(Tools::getValue('id_contact_message'))
            {
                $filter .=' AND m.id_contact_message="'.(int)Tools::getValue('id_contact_message').'"';
                $url_extra .='&id_contact_message='.(int)Tools::getValue('id_contact_message');
                $values_submit['id_contact_message']=(int)Tools::getValue('id_contact_message');
            }
            if(Tools::getValue('subject'))
            {
                $filter .=' AND m.subject like "%'.Tools::getValue('subject').'%"';
                $url_extra .='&subject='.Tools::getValue('subject');
                $values_submit['subject'] = Tools::getValue('subject');
            }
            if(Tools::getValue('sender'))
            {
                $filter .=' AND m.sender like "%'.Tools::getValue('sender').'%"';
                $url_extra .='&sender='.Tools::getValue('sender');
                $values_submit['sender'] = Tools::getValue('sender');
            }
            if(Tools::getValue('messageFilter_dateadd_from'))
            {
                $filter .=' AND m.date_add >="'.Tools::getValue('messageFilter_dateadd_from').'"';
                $url_extra .='&messageFilter_dateadd_from='.Tools::getValue('messageFilter_dateadd_from');
                $values_submit['messageFilter_dateadd_from']=Tools::getValue('messageFilter_dateadd_from');
            }
            if(Tools::getValue('messageFilter_dateadd_to'))
            {
                $filter .= ' AND m.date_add <= "'.Tools::getValue('messageFilter_dateadd_to').'"';
                $url_extra .='&messageFilter_dateadd_to='.Tools::getValue('messageFilter_dateadd_to');
                $values_submit['messageFilter_dateadd_to']=Tools::getValue('messageFilter_dateadd_to');
            }
            if(Tools::getValue('messageFilter_replied')!='')
            {
                if(Tools::getValue('messageFilter_replied')==0)
                    $filter .=' AND m.id_contact_message NOT IN (SELECT id_contact_message FROM '._DB_PREFIX_.'ets_ctf_message_reply)';
                else
                    $filter .=' AND m.id_contact_message IN (SELECT id_contact_message FROM '._DB_PREFIX_.'ets_ctf_message_reply)';
                $url_extra .='&messageFilter_replied='.Tools::getValue('messageFilter_replied');
                $values_submit['messageFilter_replied']=Tools::getValue('messageFilter_replied');
            }
            if(Tools::getValue('messageFilter_message')!='')
            {
                $filter .=' AND m.body like "%'.pSQL(Tools::getValue('messageFilter_message')).'%"';
                $url_extra .='&messageFilter_message='.Tools::getValue('messageFilter_message');
                $values_submit['messageFilter_message']=Tools::getValue('messageFilter_message');
            }
            $url_extra_no_order=$url_extra;
            if(Tools::getValue('OrderBy')!='' && Tools::getValue('OrderBy')!='m.id_contact_message')
            {
               $orderBy= Tools::getValue('OrderBy').' '.Tools::getValue('OrderWay','DESC').',m.id_contact_message DESC';
               $url_extra .= '&OrderBy='.Tools::getValue('OrderBy').'&OrderWay='.Tools::getValue('OrderWay','DESC');
            }
            else
            {
                $orderBy = Tools::getValue('OrderBy','m.id_contact_message').' '.Tools::getValue('OrderWay','DESC');
            }
            $totalMessage= $this->module->getMessages($filter,0,0,true,$orderBy);
            $limit=Configuration::get('ETS_CTF7_NUMBER_MESSAGE') ? Configuration::get('ETS_CTF7_NUMBER_MESSAGE'):20;
            $page = Tools::getValue('page',1);
            $start= ($page-1)*$limit;
            $pagination = new Ctf_paggination_class();
            $pagination->url = $this->context->link->getAdminLink('AdminContactFormMessage',true).$url_extra.'&page=_page_';
            $pagination->limit=$limit;
            $pagination->page= $page;
            $pagination->total=$totalMessage;
            if(Tools::isSubmit('submitExportButtonMessage'))
            { 
                ob_get_clean();
                ob_start();
                $messages = $this->module->getMessages($filter); 
                $csv ="Subject\tFrom\tContact Form\tMessage\tDate"."\r\n";    
                foreach($messages as $row) {
                    $message=array();
                    $message[]=$row['subject'];
                    $message[]=$row['sender'];
                    $message[]=$row['title'];
                    $message[]=str_replace("\n",'',strip_tags($row['body']));
                    $message[]=$row['date_add'];
                    $csv .= join("\t", $message)."\r\n";             
                }
                $csv = chr(255).chr(254).mb_convert_encoding($csv, "UTF-16LE", "UTF-8");
            	header("Content-type: application/x-msdownload");
            	header("Content-disposition: csv; filename=" . date("Y-m-d") .
            	"_message_list.csv; size=".Tools::strlen($csv));
            	echo $csv;
            	exit();
            }
            $messages= $this->module->getMessages($filter,$start,$limit,false,$orderBy);
            if($messages)
            {
                foreach($messages as &$message)
                {
                    $message['replies'] = $this->getRepliesByIdMessage($message['id_contact_message']);
                    $message['row_message'] = $this->displayRowMesage($message);
                }
                    
            }
            $contacts= $this->module->getContacts();
            $this->context->smarty->assign(
                array(
                    'messages'=>$messages,
                    'contacts'=>$contacts,
                    'url_module'=> $this->context->link->getAdminLink('AdminModules', true).'&configure='.$this->module->name.'&tab_module='.$this->module->tab.'&module_name='.$this->module->name,
                    'link'=>$this->context->link,
                    'base_url' => $this->module->getBaseLink(),
                    'filter'=>$filter,
                    'is_ps15' => version_compare(_PS_VERSION_, '1.6', '<')? true: false,
                    'pagination_text' => $pagination->render(),
                    'values_submit'=>$values_submit,
                    'url_full' => $this->context->link->getAdminLink('AdminContactFormMessage',true).$url_extra_no_order.'&page='.Tools::getValue('page',1),
                    'orderBy'=>Tools::getValue('OrderBy','m.id_contact_message'),
                    'orderWay' => Tools::getValue('OrderWay','DESC'),
                )
            );
           return $this->module->display(_PS_MODULE_DIR_.$this->module->name.DIRECTORY_SEPARATOR.$this->module->name.'.php', 'list-message.tpl');
        }
   }
  
   public function getMessageById($id_message)
   {
        $message= Db::getInstance()->getRow('
        SELECT m.*,cl.title,c.save_attachments , CONCAT(cu.firstname," ",cu.lastname) as customer_name FROM '._DB_PREFIX_.'ets_ctf_contact_message m
        INNER JOIN '._DB_PREFIX_.'ets_ctf_contact_message_shop ms ON (m.id_contact_message=ms.id_contact_message)
        LEFT JOIN '._DB_PREFIX_.'ets_ctf_contact c ON (c.id_contact=m.id_contact)
        lEFT JOIN '._DB_PREFIX_.'ets_ctf_contact_lang cl on (c.id_contact=cl.id_contact AND cl.id_lang="'.(int)$this->context->language->id.'")
        LEFT JOIN '._DB_PREFIX_.'customer cu ON (m.id_customer=cu.id_customer)
        WHERE ms.id_shop="'.(int)Context::getContext()->shop->id.'" AND m.id_contact_message='.(int)$id_message);
        if(trim($message['attachments']))
            $message['attachments'] = explode(',',trim($message['attachments']));
        else
            $message['attachments']='';
        $message['replies'] = $this->getRepliesByIdMessage($message['id_contact_message']);
        $message['from_reply'] = Configuration::get('PS_SHOP_NAME').' <'.(Configuration::get('PS_MAIL_METHOD')==2? Configuration::get('PS_MAIL_USER'): Configuration::get('PS_SHOP_EMAIL')).'>';
        $message['reply'] =  Configuration::get('PS_SHOP_NAME').' <'.Configuration::get('PS_SHOP_EMAIL').'>';
        return $message;
   }
   public function getRepliesByIdMessage($id_message)
   {
       $replies= Db::getInstance()->executeS('
       SELECT * FROM '._DB_PREFIX_.'ets_ctf_message_reply 
       WHERE id_contact_message="'.(int)$id_message.'"'
       );
       return $replies;
   }
   public function displayRowMesage($message)
   {
        if(!is_array($message))
            $message = $this->getMessageById($message);
        $this->context->smarty->assign(
            array(
                'message'=>$message,
            )
        );
        return $this->module->display(_PS_MODULE_DIR_.$this->module->name.DIRECTORY_SEPARATOR.$this->module->name.'.php', 'row-message.tpl');
   }
}