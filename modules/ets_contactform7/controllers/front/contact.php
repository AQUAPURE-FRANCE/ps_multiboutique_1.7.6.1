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
 
require_once(_PS_MODULE_DIR_.'ets_contactform7/classes/form-tag.php');
require_once(_PS_MODULE_DIR_.'ets_contactform7/classes/function.php');
require_once(_PS_MODULE_DIR_.'ets_contactform7/classes/Contact.php');
require_once(_PS_MODULE_DIR_.'ets_contactform7/classes/contact-form.php');
require_once(_PS_MODULE_DIR_.'ets_contactform7/classes/form-tags-manager.php');
require_once(_PS_MODULE_DIR_.'ets_contactform7/classes/submission.php');
require_once(_PS_MODULE_DIR_.'ets_contactform7/classes/mail.php');
require_once(_PS_MODULE_DIR_.'ets_contactform7/classes/pipe.php');
require_once(_PS_MODULE_DIR_.'ets_contactform7/classes/integration.php');
require_once(_PS_MODULE_DIR_.'ets_contactform7/classes/recaptcha.php');
require_once(_PS_MODULE_DIR_.'ets_contactform7/classes/validation.php');
class Ets_contactform7ContactModuleFrontController extends ModuleFrontController
{
    /**
    * @see FrontController::initContent()
    */
    public function initContent()
    {
        
        parent::initContent();
        if(Tools::getValue('action')=='addLoger' && $id_contact=(int)Tools::getValue('id_contact'))
        {
            
        }
        $this->module->setMetas();
        $this->context= Context::getContext();
        $id_contact=Tools::getValue('id_contact');
        $ip = Tools::getRemoteAddr();
        $browser= $this->module->getDevice();
        if(!Db::getInstance()->getRow('SELECT * FROM '._DB_PREFIX_.'ets_ctf_log WHERE ip="'.pSQL($ip).'" AND DAY(datetime_added) ="'.pSQL(date('d')).'" AND MONTH(datetime_added) ="'.pSQL(date('m')).'" AND YEAR(datetime_added) ="'.pSQL(date('Y')).'" AND id_contact='.(int)$id_contact))
        {
            Db::getInstance()->execute('INSERT INTO '._DB_PREFIX_.'ets_ctf_log(ip,id_contact,browser,id_customer,datetime_added) VALUES ("'.pSQL($ip).'","'.(int)$id_contact.'","'.pSQL($browser).'","'.(int)Context::getContext()->customer->id.'","'.pSQL(date('Y-m-d h:i:s')).'")');
        }
        if(Tools::getValue('action')=='addLoger')
        {
            die(
                Tools::jsonEncode(
                    array(
                        'sus'=>true
                    )
                )
            );
        }
        $contact= new Ets_contact_class($id_contact,$this->context->language->id);
        if($contact->id && $contact->active && $contact->enable_form_page && $this->module->existContact($id_contact))
        {
            
            $contact_form = $this->module->etscf7_contact_form($contact->id);
            $this->context->smarty->assign(
                array(
                    'form_html'=>$this->module->form_html( $contact_form ),
                    'contact'=>$contact,
                    'link_contact'=> $this->module->getLinkContactForm($id_contact),
                )
            );
            if(version_compare(_PS_VERSION_, '1.7', '<'))
                $this->setTemplate('contactform16.tpl');
            else
                $this->setTemplate('module:ets_contactform7/views/templates/front/contactform.tpl');
        }
        elseif(version_compare(_PS_VERSION_, '1.7', '<'))
            $this->setTemplate('not-found16.tpl');
        else
            $this->setTemplate('module:ets_contactform7/views/templates/front/not-found.tpl');
    }
    public function getBreadcrumbLinks()
    {
        if(version_compare(_PS_VERSION_, '1.7', '<'))
            return '';
        $breadcrumb = parent::getBreadcrumbLinks();
        $id_contact=Tools::getValue('id_contact');
        $contact= new Ets_contact_class($id_contact,$this->context->language->id);
        $breadcrumb['links'][] = array(
            'title' => $contact->title,
            'url' => $this->module->getLinkContactForm($id_contact),
         );
         return $breadcrumb;
     }
}