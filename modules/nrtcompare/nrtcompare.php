<?php
/*
* 2007-2015 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_'))
	exit;

class NrtCompare extends Module
{
	function __construct()
	{
		$this->name = 'nrtcompare';
		$this->tab = 'front_office_features';
		$this->version = '1.3.0';
		$this->author = 'AxonVIP';
		$this->need_instance = 0;

		$this->bootstrap = true;
		parent::__construct();

		$this->displayName = $this->l('Product Compare');
		$this->description = $this->l('Required by author: AxonVIP.');
		$this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
	}

	function install()
	{
		$success = (parent::install()
			&& $this->registerHook('header')
			&& $this->registerHook('buttoncompare')
			&& Configuration::updateValue('NRT_COMPARATOR_MAX_ITEM', 3)
			&& $this->addTab()
		);
		return $success;
	}

	public function uninstall()
	{
		$success = (parent::uninstall()
			&& Configuration::deleteByName('NRT_COMPARATOR_MAX_ITEM')
			&& $this->_deleteTab()
		);
		return $success;
	}
	
public function addTab()
	{
        $response = true;

        // First check for parent tab
        $parentTabID = Tab::getIdFromClassName('AdminNrtMenu');

        if ($parentTabID) {
            $parentTab = new Tab($parentTabID);
        }
        else {
            $parentTab = new Tab();
            $parentTab->active = 1;
            $parentTab->name = array();
            $parentTab->class_name = "AdminNrtMenu";
            foreach (Language::getLanguages() as $lang) {
                $parentTab->name[$lang['id_lang']] = "TAB_THEMES";
            }
            $parentTab->id_parent = 0;
            $parentTab->module ='';
            $response &= $parentTab->add();
        }

			// Check for parent tab2
			$parentTab_2ID = Tab::getIdFromClassName('AdminNrtMenuzxc');
			if ($parentTab_2ID) {
				$parentTab_2 = new Tab($parentTab_2ID);
			}
			else {
				$parentTab_2 = new Tab();
				$parentTab_2->active = 1;
				$parentTab_2->name = array();
				$parentTab_2->class_name = "AdminNrtMenuzxc";
				foreach (Language::getLanguages() as $lang) {
					$parentTab_2->name[$lang['id_lang']] = "Configure";
				}
				$parentTab_2->id_parent = $parentTab->id;
				$parentTab_2->module = '';
				$response &= $parentTab_2->add();
			}
		// Created tab
        $tab = new Tab();
        $tab->active = 1;
        $tab->class_name = "AdminNrtCompare";
        $tab->name = array();
        foreach (Language::getLanguages() as $lang) {
            $tab->name[$lang['id_lang']] = "Manage Products Compare";
        }
        $tab->id_parent = $parentTab_2->id;
        $tab->module = $this->name;
        $response &= $tab->add();

        return $response;
    }

    /* ------------------------------------------------------------- */
    /*  DELETE THE TAB MENU
    /* ------------------------------------------------------------- */
    private function _deleteTab()
    {
        $id_tab = Tab::getIdFromClassName('AdminNrtCompare');
		$parentTabID = Tab::getIdFromClassName('AdminNrtMenu');
        $tab = new Tab($id_tab);
        $tab->delete();

		// Get the number of tabs inside our parent tab
        // If there is no tabs, remove the parent
		$parentTab_2ID = Tab::getIdFromClassName('AdminNrtMenuzxc');
		$tabCount_2 = Tab::getNbTabs($parentTab_2ID);
        if ($tabCount_2 == 0) {
            $parentTab_2 = new Tab($parentTab_2ID);
            $parentTab_2->delete();
        }
        // Get the number of tabs inside our parent tab
        // If there is no tabs, remove the parent
        $tabCount = Tab::getNbTabs($parentTabID);
        if ($tabCount == 0) {
            $parentTab = new Tab($parentTabID);
            $parentTab->delete();
        }

        return true;
    }
	/**
	* Returns module content for left column
	*
	* @param array $params Parameters
	* @return string Content
	*
	*/
	
	public function getContent()
        {
                $output = '';
                $errors = array();
                if (Tools::isSubmit('submitNrtcompare'))
                {
                        $max_compare_item = Tools::getValue('NRT_COMPARATOR_MAX_ITEM');
                        if (!strlen($max_compare_item))
                                $errors[] = $this->l('Please complete the "Displayed tags" field.');
                        elseif (!Validate::isInt($max_compare_item) || (int)($max_compare_item) <= 0)
                                $errors[] = $this->l('Invalid number.');
                        if (count($errors))
                                $output = $this->displayError(implode('<br />', $errors));
                        else
                        {
                                Configuration::updateValue('NRT_COMPARATOR_MAX_ITEM', (int)$max_compare_item);

                                $output = $this->displayConfirmation($this->l('Settings updated'));
                        }
                }
                return $output.$this->renderForm();
        }
	public function renderForm()
	{
		$fields_form = array(
			'form' => array(
				'legend' => array(
					'title' => $this->l('Settings'),
					'icon' => 'icon-cogs'
				),
				'input' => array(
					array(
						'type' => 'text',
						'label' => $this->l('Product comparison'),
						'name' => 'NRT_COMPARATOR_MAX_ITEM',
						'class' => 'fixed-width-xs',
						'desc' => $this->l('Set the maximum number of products that can be selected for comparison.')
                        )
				),
				'submit' => array(
					'title' => $this->l('Save'),
				)
			),
		);

		$helper = new HelperForm();
		$helper->show_toolbar = false;
		$helper->table = $this->table;
		$lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->default_form_language = $lang->id;
		$helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
		$helper->identifier = $this->identifier;
		$helper->submit_action = 'submitNrtcompare';
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$helper->tpl_vars = array(
			'fields_value' => $this->getConfigFieldsValues(),
			'languages' => $this->context->controller->getLanguages(),
			'id_language' => $this->context->language->id
		);

		return $helper->generateForm(array($fields_form));
	}

	public function getConfigFieldsValues()
	{
		return array(
			'NRT_COMPARATOR_MAX_ITEM' => Tools::getValue('NRT_COMPARATOR_MAX_ITEM', (int)Configuration::get('NRT_COMPARATOR_MAX_ITEM'))
		);
	}
	function hookHeader($params)
	{
	$this->smarty->assignGlobal('link_compare',$this->context->link->getModuleLink('nrtcompare', 'comparator'));
	$this->page_name = Dispatcher::getInstance()->getController();
	Media::addJsDef(array('first_alert_compare' => $this->l('You cannot add more than ')));
	Media::addJsDef(array('last_alert_compare' => $this->l(' product(s) to the product Comparison')));
	Media::addJsDef(array('limit_compare' => (int)Configuration::get('NRT_COMPARATOR_MAX_ITEM')));
	Media::addJsDef(array('add_compare' => $this->l('Product successfully added to the product comparison!')));
	Media::addJsDef(array('view_compare' => $this->l('Go to Compare')));
	Media::addJsDef(array('remove_compare' => $this->l('Product successfully removed from the product comparison!')));
	Media::addJsDef(array('mycompare' =>  $this->context->link->getModuleLink('nrtcompare', 'comparator')));
	Media::addJsDef(array('add_to_compare' => $this->l('Add to Compare')));
	Media::addJsDef(array('remove_to_compare' => $this->l('Remove to Compare')));
	Media::addJsDef(array('baseDir' => $this->context->shop->getBaseURL(true, true)));
	Media::addJsDef(array('static_token' => Tools::getToken(false)));	
	$this->context->controller->addJS($this->_path.'compare.js');
	if (in_array($this->page_name, array('comparator'))) {
		$this->context->controller->addCSS($this->_path.'compare.css', 'all');
	}
	}
	
	function hookButtoncompare($params)
	{
		global $cookie;
		$this->smarty->assign('product', $params['product']);
		if(isset($cookie->compare_product_list)){
			$products_id=explode (",",$cookie->compare_product_list);
			$this->smarty->assign('products_id',$products_id);	
		}
		return $this->display(__FILE__, 'buttoncompare.tpl');
	}
	
	function AddCompare($id_product)
	{
		global $cookie;
		if(isset($cookie->compare_product_list)){
			$products_id=explode (",",$cookie->compare_product_list);
			$check_no=true;
			foreach($products_id as $key=>$product_id){
				if($id_product == $product_id ){
					unset($products_id[$key]);
					$check_no=false;
					break;	
				}
			}
			if($check_no){
				if(count($products_id) >= (int)Configuration::get('NRT_COMPARATOR_MAX_ITEM')){
					echo 'limit';
					return;
				}
				$cookie->compare_product_list=trim($cookie->compare_product_list.','.$id_product,',');
			}else{
				$cookie->compare_product_list=trim(implode(',',$products_id),',');
			}
			if($cookie->compare_product_list==''){
				unset($cookie->compare_product_list);
			}
		}else{
			$cookie->compare_product_list=$id_product;
			$check_no=true;
		}
		if($check_no){
			echo 'checked';
		}
		else{
			echo 'remove';	
		}
	}


	function RemoveCompare($id_product)
	{
		global $cookie;
		if(isset($cookie->compare_product_list)){
			$products_id=explode (",",$cookie->compare_product_list);
			foreach($products_id as $key=>$product_id){
				if($id_product == $product_id ){
					unset($products_id[$key]);
					break;	
				}
			}
			$cookie->compare_product_list=trim(implode(',',$products_id),',');
			if($cookie->compare_product_list==''){
				unset($cookie->compare_product_list);
			}
			echo 'ok';
		}else{
			return false;
		}
	}
	
	
}
