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
require_once(_PS_MODULE_DIR_.'ets_contactform7/classes/ctf_paggination_class.php');
class AdminContactFormContactFormController extends ModuleAdminController
{
   public function __construct()
   {
       parent::__construct();
       $this->bootstrap = true;
   }
   public function initContent()
   {
        $this->context->controller->addJqueryUI('ui.sortable');
        parent::initContent();
        if(Tools::getValue('action')=='updateContactFormOrdering' && $formcontact=Tools::getValue('formcontact'))
        {
            $page = Tools::getValue('page',1);
            foreach($formcontact as $key=> $form)
            {
                $position=$key + ($page-1)*20;
                Db::getInstance()->execute('UPDATE '._DB_PREFIX_.'ets_ctf_contact SET position="'.(int)$position.'" WHERE id_contact='.(int)$form);
            }
            die(
                Tools::jsonEncode(
                    array(
                        'page'=>$page,
                    )
                )
            );
        }
   }
   public function renderList()
   {
        $filter='';
        $url_extra='';
        $values_submit= array();
        if(Tools::getValue('id_contact'))
        {
            $filter .=' AND c.id_contact="'.(int)Tools::getValue('id_contact').'"';
            $url_extra .='&id_contact='.(int)Tools::getValue('id_contact');
            $values_submit['id_contact']=Tools::getValue('id_contact');
        }
        if(Tools::getValue('contact_title'))
        {
            $filter .=' AND cl.title like "'.pSQL(Tools::getValue('contact_title')).'"';
            $url_extra .='&contact_title='.Tools::getValue('contact_title');
            $values_submit['contact_title']=Tools::getValue('contact_title');
        }
        if(Tools::getValue('hook'))
        {
            $filter .=' AND c.hook like "%'.pSQL(Tools::getValue('hook')).'%"';
            $url_extra .='&hook='.Tools::getValue('hook');
            $values_submit['hook'] = Tools::getValue('hook');
        }
        if(Tools::getValue('messageFilter_dateadd_from'))
        {
            $filter .=' AND c.date_add >="'.pSQL(Tools::getValue('messageFilter_dateadd_from')).'"';
            $url_extra .='&messageFilter_dateadd_from='.Tools::getValue('messageFilter_dateadd_from');
            $values_submit['messageFilter_dateadd_from']=Tools::getValue('messageFilter_dateadd_from');
        }
        if(Tools::getValue('messageFilter_dateadd_to'))
        {
            $filter .= ' AND c.date_add <= "'.pSQL(Tools::getValue('messageFilter_dateadd_to')).'"';
            $url_extra .='&messageFilter_dateadd_to='.Tools::getValue('messageFilter_dateadd_to');
            $values_submit['messageFilter_dateadd_to']=Tools::getValue('messageFilter_dateadd_to');
        }
        if(Tools::getValue('save_message')!='')
        {
            $filter .= ' AND c.save_message = "'.(int)Tools::getValue('save_message').'"';
            $url_extra .='&save_message='.Tools::getValue('save_message');
            $values_submit['save_message']=Tools::getValue('save_message');
        }
        if(Tools::getValue('active_contact')!='')
        {
            $filter .= ' AND c.active = "'.(int)Tools::getValue('active_contact').'"';
            $url_extra .='&active_contact='.Tools::getValue('active_contact');
            $values_submit['active_contact']=Tools::getValue('active_contact');
        }
        if(Tools::getValue('sort')=='id_contact')
            $sort='c.id_contact';
        else
            $sort= Tools::getValue('sort','position');
        $sort_type=Tools::getValue('sort_type','asc');
        $total= $this->module->getContacts(false,$filter,0,0,true);
        $limit=20;
        $page = Tools::getValue('page',1);
        $start= ($page-1)*$limit;
        $pagination = new Ctf_paggination_class();
        $pagination->url = $this->context->link->getAdminLink('AdminContactFormContactForm',true).$url_extra.'&page=_page_';
        $pagination->limit=$limit;
        $pagination->page= $page;
        $pagination->total=$total;
        $contacts= $this->module->getContacts(false,$filter,$start,$limit,false,$sort,$sort_type);
        if($contacts)
        {
            foreach($contacts as &$contact)
            {
                $contact['hooks']= explode(',',$contact['hook']);
                if($contact['enable_form_page'])
                    $contact['link']= Ets_contactform7::getLinkContactForm($contact['id_contact']);
                $contact['count_views'] = Db::getInstance()->getValue('SELECT COUNT(*) FROM '._DB_PREFIX_.'ets_ctf_log WHERE id_contact='.(int)$contact['id_contact']);
                $contact['count_message'] = Db::getInstance()->getValue('SELECT COUNT(*) FROM '._DB_PREFIX_.'ets_ctf_contact_message WHERE id_contact='.(int)$contact['id_contact']);
             }
        }
        $hooks=array(
            'nav_top'=>$this->module->l('Header - top navigation'),
            'header'=>$this->module->l('Header - main header'),
            'footer'=>$this->module->l('Footer'),
            'displayTop'=> $this->module->l('Top'),
            'home'=> $this->module->l('Home'),
            'left_column'=> $this->module->l('Left column'),
            'footer'=> $this->module->l('Footer page'),
            'right_column' => $this->module->l('Right column'),
            'product_thumbs'=> $this->module->l('Product page - below product image'),
            'product_right' => $this->module->l('Product page - right column'),
            'product_left' => $this->module->l('Product page - left column'),
            'checkout_page'=> $this->module->l('Checkout page'),
            'register_page' => $this->module->l('Register page'),
            'login_page'=> $this->module->l('Login page'),
        );
        $this->context->smarty->assign(
            array(
                'contacts'=>$contacts,
                'url_module'=> $this->context->link->getAdminLink('AdminModules', true).'&configure='.$this->module->name.'&tab_module='.$this->module->tab.'&module_name='.$this->module->name,
                'pagination_text' => $pagination->render(),
                'filter'=>$filter,
                'filter_params'=> $url_extra,
                'is_ps15' => version_compare(_PS_VERSION_, '1.6', '<')? true: false,
                'okimport'=>Tools::getValue('okimport'),
                'hooks'=>$hooks,
                'sort'=> Tools::getValue('sort','position'),
                'sort_type' => Tools::getValue('sort_type','asc'),
                '_PS_JS_DIR_' => _PS_JS_DIR_,
                'ETS_CTF7_ENABLE_TMCE' => Configuration::get('ETS_CTF7_ENABLE_TMCE'),
            )
        );
       return $this->module->display(_PS_MODULE_DIR_.$this->module->name.DIRECTORY_SEPARATOR.$this->module->name.'.php', 'list-contact.tpl');
   }
}