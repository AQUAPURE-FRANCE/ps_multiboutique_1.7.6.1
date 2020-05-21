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
class AdminContactFormIntegrationController extends ModuleAdminController
{
    public $_html;
    public $_fields_form;
    public function __construct()
    {
       parent::__construct();
       $this->bootstrap = true;
       $this->_fields_form = Ets_contactform7::$_config_fields;
   }
   public function initContent()
   {
        parent::initContent();
        
   }
   public function renderList()
   {
        $errors= array();
        $id_lang_default = (int)Configuration::get('PS_LANG_DEFAULT');
        $inputs = $this->_fields_form['form']['input'];
        $languages= Language::getLanguages(false);
        if(Tools::isSubmit('cft_import_contact_submit'))
        {
            $this->module->processImport();
            $errors = $this->module->_errors;
            if($errors)
            {
                $this->_html .=$this->module->displayError($errors);
            }
        } 
        else
        {
            if(Tools::isSubmit('btnSubmit'))
            {
                if($inputs)
                {
                    foreach($inputs as $input)
                    {
                        $key = $input['name'];
                        if(isset($input['lang']) && $input['lang'])
                        {
                            if(isset($input['required']) && $input['required'] && !Tools::getValue($key.'_'.$id_lang_default))
                                $errors[] = $input['label'].' '.$this->module->l('is required');
                            elseif(isset($input['validate']) && method_exists('Validate',$input['validate']))
                            {
                                $validate = $input['validate'];
                                if(!Validate::$validate(trim(Tools::getValue($key.'_'.$id_lang_default))))
                                    $errors[] = $input['label'].' '.$this->module->l('is invalid');
                                else{
                                    if($languages)
                                    {
                                        foreach($languages as $lang)
                                        {
                                            if( Tools::getValue($key.'_'.$lang['id_lang']) &&!Validate::$validate(trim(Tools::getValue($key.'_'.$lang['id_lang']))))
                                                $errors[] = $input['label'].' '.$lang['iso_code'].' '.$this->module->l('is invalid');
                                        }
                                    }
                                }
                                unset($validate);
                            } 
                        }
                        elseif(isset($input['required']) && $input['required'] && !Tools::getValue($key))
                                $errors[] = $input['label'].' '.$this->module->l('is required');
                        elseif(isset($input['validate']) && method_exists('Validate',$input['validate']))
                        {
                            $validate = $input['validate'];
                            if(!Validate::$validate(trim(Tools::getValue($key))))
                                $errors[] = $input['label'].' '.$this->module->l('is invalid');
                            unset($validate);
                        }
                        
                    }
                }
                if(Configuration::get('ETS_CTF7_ENABLE_RECAPTCHA'))
                {
                    if(!Configuration::get('ETS_CFT7_SITE_KEY'))
                        $errors[]= $this->module->l('Site Key is required');
                    if(!Configuration::get('ETS_CFT7_SECRET_KEY'))
                        $errors[]= $this->module->l('Secret Key is required');
                }
                if($errors)
                    $this->_html .= $this->module->displayError($errors);
                else
                {
                    if($inputs)
                    {
                        foreach($inputs as $input)
                        {
                            $key=$input['name'];
                            if(isset($input['lang']) && $input['lang'])
                            {
                                $vals = array();
                                foreach($languages as $language)
                                {
                                    $vals[$language['id_lang']]= Tools::getValue($key.'_'.$language['id_lang'])?Tools::getValue($key.'_'.$language['id_lang']):Tools::getValue($key.'_'.$id_lang_default);
                                }
                                Configuration::updateValue($key,$vals,true);
                            }
                            else
                            {
                                Configuration::updateValue($key,Tools::getValue($key));
                            }
                        }
                    }
                    Tools::redirectAdmin($this->context->link->getAdminLink('AdminContactFormIntegration').'&conf=4&current_tab='.Tools::getValue('current_tab'));
                }
            }
        }
        $this->context->smarty->assign(
            array(
                'form_config'=>$this->module->renderFormConfig(),
            )
        );
        $this->_html .=$this->module->display(_PS_MODULE_DIR_.$this->module->name.DIRECTORY_SEPARATOR.$this->module->name.'.php', 'form.tpl');
        return $this->_html;
   }
}