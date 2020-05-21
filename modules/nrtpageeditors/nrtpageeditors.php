<?php
/**
* 2007-2014 PrestaShop
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
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2014 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_'))
	exit;
use PrestaShop\PrestaShop\Core\Module\WidgetInterface;
use PrestaShop\PrestaShop\Adapter\Category\CategoryProductSearchProvider;
use PrestaShop\PrestaShop\Adapter\Image\ImageRetriever;
use PrestaShop\PrestaShop\Adapter\Product\PriceFormatter;
use PrestaShop\PrestaShop\Core\Product\ProductListingPresenter;
use PrestaShop\PrestaShop\Adapter\Product\ProductColorsRetriever;
use PrestaShop\PrestaShop\Core\Product\Search\ProductSearchContext;
use PrestaShop\PrestaShop\Core\Product\Search\ProductSearchQuery;
use PrestaShop\PrestaShop\Core\Product\Search\SortOrder;
use PrestaShop\PrestaShop\Core\Addon\Module\ModuleManagerBuilder;
use Symfony\Component\HttpKernel\HttpKernelInterface;
include_once(_PS_MODULE_DIR_.'nrtpageeditors/models/NrtEditorsHtml.php');

class Nrtpageeditors extends Module
{
	protected $config_form = false;
	private $pattern = '/^([A-Z_]*)[0-9]+/';
	private $spacer_size = '5';
	private $user_groups;
	const INSTALL_SQL_FILE = 'import_data_home.sql';
	public function __construct()
	{
		$this->name = 'nrtpageeditors';
		$this->tab = 'front_office_features';
		$this->version = '1.0';
		$this->author = 'AxonVIP';
		$this->need_instance = 0;
		$this->controllers = array('editor');
		$this->bootstrap = true;
		parent::__construct();
		$this->displayName = $this->l('Home Page Editor');
		$this->description = $this->l('Required by author: AxonVIP.');
		$this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
		$this->config_name = 'NRT_page';
		$this->link_default='/axon2/home3/';
		if (file_exists(_PS_THEME_DIR_. 'link_default.php')){
			require_once(_PS_THEME_DIR_. 'link_default.php');
			if(isset($link_default)){
				$this->link_default=$link_default;
			}
		}
	}

	public function install()
	{
		Configuration::updateValue($this->config_name.'_content','');	
		$success = parent::install() 
			&& $this->registerHook('header')
			&& $this->installCustomHtml()
			&& $this->installSample()
			&& $this->generateCss() 
			&& $this->createTables()
            && $this->registerHook('addproduct')
            && $this->registerHook('updateproduct')
            && $this->registerHook('deleteproduct')
            && $this->registerHook('categoryUpdate')
			&& $this->registerHook('displayHomeCustom')
			&& $this->addTab();
		return $success;	
	}

	public function uninstall()
	{
		Configuration::deleteByName($this->config_name.'_content');
		return parent::uninstall() && $this->deleteTables() && $this->_deleteTab();
	}
	
    public function hookAddProduct($params)
    {
         $this->_clearCache('*');
    }
    public function hookUpdateProduct($params)
    {
         $this->_clearCache('*');
    }

    public function hookDeleteProduct($params)
    {
         $this->_clearCache('*');
    }

    public function hookCategoryUpdate($params)
    {
        $this->_clearCache('*');
    }

	public function installSample()
	{
		$str = file_get_contents($this->getLocalPath().'template_home.csv');
		if(isset($this->link_default)){
			$str = str_replace($this->link_default, __PS_BASE_URI__, $str); 
		}
		Configuration::updateValue($this->config_name.'_content',$str);	
		return true;
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
        $tab->class_name = "AdminNrtThemePageEditor";
        $tab->name = array();
        foreach (Language::getLanguages() as $lang) {
            $tab->name[$lang['id_lang']] = "Manage Home Page Editor";
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
        $id_tab = Tab::getIdFromClassName('AdminNrtThemePageEditor');
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
	 * Creates tables
	 */
	protected function createTables()
	{
		/* custom html */
		$res = Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'nrteditors_html` (
			`id_html` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`id_shop` INT(11) UNSIGNED NOT NULL,
			INDEX (`id_html`, `id_shop`)
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
		');

		$res &= Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'nrteditors_htmlc` (
			  `id_html` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `title` varchar(255) NOT NULL ,
			  PRIMARY KEY (`id_html`)
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
		');

		/* custom html lang */
		$res &= Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'nrteditors_htmlc_lang` (
			`id_html` INT(11) UNSIGNED NOT NULL,
			`id_lang` INT(11) UNSIGNED NOT NULL,
			`id_shop` INT(11) UNSIGNED NOT NULL,
			`html` text NULL,
			INDEX ( `id_html` , `id_lang`, `id_shop`)
		) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
		');

		return $res;
	}

	/**
	 * deletes tables
	 */
	protected function deleteTables()
	{
		return Db::getInstance()->execute('
			DROP TABLE IF EXISTS `'._DB_PREFIX_.'nrteditors_html`, `'._DB_PREFIX_.'nrteditors_htmlc`, `'._DB_PREFIX_.'nrteditors_htmlc_lang`;
		');
	}
 public function installCustomHtml() {
	if (!file_exists($this->getLocalPath(). self::INSTALL_SQL_FILE)){
		return (false);
	} else if (!$sql = file_get_contents($this->getLocalPath(). self::INSTALL_SQL_FILE)){
		return (false);
	}
	if(isset($this->link_default)){
		$sql = str_replace($this->link_default, __PS_BASE_URI__, $sql); 
	}
	$sql = str_replace('ps_', _DB_PREFIX_, $sql);
	$sql = preg_split("/;\s*[\r\n]+/", $sql);
	foreach ($sql as $query) {
		if (!empty($query)) {
				if (!Db::getInstance()->Execute(trim($query))){
					return (false);
			}
		}
	 }
  return true;
 }
	public function installTable() {

		if (!file_exists(_PS_THEME_DIR_. 'modules/nrtpageeditors/'. self::INSTALL_SQL_FILE))
			return (false);

		else if (!$sql = file_get_contents(_PS_THEME_DIR_. 'modules/nrtpageeditors/'. self::INSTALL_SQL_FILE))
			return (false);
		if(isset($this->link_default)){
			$sql = str_replace($this->link_default, __PS_BASE_URI__, $sql); 
		}
		$sql = str_replace('ps_', _DB_PREFIX_, $sql);
		$sql = preg_split("/;\s*[\r\n]+/", $sql);
		foreach ($sql as $query) {
			if (!empty($query)) {
				if (!Db::getInstance()->Execute(trim($query)))
				return (false);
			}
		}
		return true;
	}
	
	/**
	 * Load the configuration form
	 */
	public function getContent()
	{
		/**
		 * If values have been submitted in the form, process.
		 */
		$output = '';
		if (Tools::getValue('controller') != 'AdminModules' && Tools::getValue('configure') != $this->name)
			return;


		Media::addJsDef(array('nrtsearch_url' => $this->_path.'ajax_products_list.php')); 

		$this->context->controller->addJS($this->_path.'js/back.js');
		$this->context->controller->addCSS($this->_path.'css/back.css');

		$this->context->controller->addJS($this->_path.'js/fontawesome-iconpicker.min.js');
		$this->context->controller->addCSS($this->_path.'css/fontawesome-iconpicker.min.css');

		$this->context->controller->addJS($this->_path.'js/spectrum.js');
		$this->context->controller->addCSS($this->_path.'css/spectrum.css');

		$this->context->controller->addJqueryUI('ui.sortable');
		//$this->context->controller->addJqueryPlugin('colorpicker');

		if (Tools::isSubmit('addCustomHtml') || (Tools::isSubmit('id_html')  && !Tools::isSubmit('submitAddHtml') && NrtEditorsHtml::htmlExists((int)Tools::getValue('id_html'))))
			return $this->renderAddHtmlForm();
		elseif(Tools::isSubmit('submitAddHtml') || Tools::isSubmit('delete_id_html'))
		{
			if(!Tools::isSubmit('back_to_configuration'))
			{
				if ($this->_postValidationHtml())
				{
					$this->_postProcessHtml();
				}
		}
		}
		elseif(Tools::isSubmit('importConfiguration'))
		{
			if(isset($_FILES['uploadConfig']) && isset($_FILES['uploadConfig']['tmp_name']))
			{
				$str = file_get_contents($_FILES['uploadConfig']['tmp_name']);
				Configuration::updateValue($this->config_name.'_content', $str);
				$this->generateCss();
				if (isset($errors) AND $errors!='')
					$output .= $this -> displayError($errors);
				else
					$output .= $this -> displayConfirmation($this->l('Configuration imported'));
			}
			else
				$output .= $this -> displayError($this->l('No config file'));	
		}
		elseif(Tools::isSubmit('importConfigurationdemo1'))
		{
			$str = file_get_contents($this->getLocalPath().'template_home1.csv');
			Configuration::updateValue($this->config_name.'_content',$str);	
			$this->generateCss();
		}
		elseif(Tools::isSubmit('importConfigurationdemo2'))
		{
			$str = file_get_contents($this->getLocalPath().'template_home2.csv');
			Configuration::updateValue($this->config_name.'_content',$str);	
			$this->generateCss();
		}
		elseif(Tools::isSubmit('importConfigurationdemo3'))
		{
			$str = file_get_contents($this->getLocalPath().'template_home3.csv');
			Configuration::updateValue($this->config_name.'_content',$str);	
			$this->generateCss();
		}
		elseif(Tools::isSubmit('importConfigurationdemo4'))
		{
			$str = file_get_contents($this->getLocalPath().'template_home4.csv');
			Configuration::updateValue($this->config_name.'_content',$str);	
			$this->generateCss();
		}
		elseif(Tools::isSubmit('importDatabase'))
		{
			$this->installTable();
		}
		elseif (Tools::isSubmit('exportConfiguration'))
		{
						
			$content = Configuration::get($this->config_name.'_content');
		

			$file_name = 'export_home_'.time().'.csv';
			$fd = fopen($this->getLocalPath().'export/'.$file_name, 'w+');
			file_put_contents($this->getLocalPath().'export/'.$file_name, print_r($content, true));
			fclose($fd);
			Tools::redirect(_PS_BASE_URL_.__PS_BASE_URI__.'modules/'.$this->name.'/export/'.$file_name);
		}

		
		if (Tools::isSubmit('submitNrtpageeditorsModule'))
			$this->_postProcess();
		
		$this->context->smarty->assign('module_dir', $this->_path);
		$output = $this->context->smarty->fetch($this->local_path.'views/templates/admin/configure.tpl');

		$output .= '<div class="panel clearfix">
		<form class="pull-left" id="importForm" method="post" enctype="multipart/form-data" action="'.$this->context->link->getAdminLink('AdminModules', false).'&importConfiguration&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'">
		<div style="display:inline-block;"><input type="file" id="uploadConfig" name="uploadConfig" /></div>
	
		<button type="submit" class="btn btn-default btn-lg"><span class="icon icon-upload"></span> '.$this->l('Import').'</button>
		
		</form><a target="_blank" href="'.$this->context->link->getAdminLink('AdminModules', false).'&exportConfiguration&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'">
		<button class="btn btn-default btn-lg pull-right"><span class="icon icon-share"></span> '.$this->l('Export').'</button>
		</a></div>';
$tab_='<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#homepageeditor" aria-controls="home" role="tab" data-toggle="tab">'
	.$this->l('Custom Home Page').'</a></li>
    <li role="presentation"><a href="#customhtml" aria-controls="profile" role="tab" data-toggle="tab">'
	.$this->l('Custom Html').'</a></li>
    <li role="presentation"><a href="#imexport" aria-controls="messages" role="tab" data-toggle="tab">'
	.$this->l('Import / Export').'</a></li>
  </ul>';
  
  
  $demo_home1='<form class="import_demo" style="display:none;"  method="post" action="'.$this->context->link->getAdminLink('AdminModules', false).'&importConfigurationdemo1&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'">	
		<button type="submit" class="btn btn-default btn-lg"><span class="icon icon-upload"></span> '.$this->l('Template home 1').'</button></form>';
  $demo_home2='<form class="import_demo" style="display:none;" method="post" action="'.$this->context->link->getAdminLink('AdminModules', false).'&importConfigurationdemo2&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'">	
		<button type="submit" class="btn btn-default btn-lg"><span class="icon icon-upload"></span> '.$this->l('Template home 2').'</button></form>';
  $demo_home3='<form class="import_demo" style="display:none;" method="post" action="'.$this->context->link->getAdminLink('AdminModules', false).'&importConfigurationdemo3&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'">	
		<button type="submit" class="btn btn-default btn-lg"><span class="icon icon-upload"></span> '.$this->l('Template home 3').'</button></form>';
  $demo_home4='<form class="import_demo" style="display:none;" method="post" action="'.$this->context->link->getAdminLink('AdminModules', false).'&importConfigurationdemo4&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'">	
		<button type="submit" class="btn btn-default btn-lg"><span class="icon icon-upload"></span> '.$this->l('Template home 4').'</button></form>';
  $import_data='<form class="import_demo" method="post" action="'.$this->context->link->getAdminLink('AdminModules', false).'&importDatabase&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'">	
		<button type="submit" class="btn btn-default btn-lg"><span class="icon icon-upload"></span> '.$this->l('Template Html For Theme').'</button></form>';
		return $tab_.
		'<div class="tab-content">'.
			'<div role="tabpanel" class="tab-pane active" id="homepageeditor">'
				.$demo_home1.$demo_home2.$demo_home3.$demo_home4.
				$this->renderForm().
			'</div>
		</div>'.
		'<div role="tabpanel" class="tab-pane" id="customhtml">'.
			$import_data.$this->renderHtmlContents().
		'</div>'.
			'<div role="tabpanel" class="tab-pane" id="imexport">'.
				$output.
			'</div>'.
		'</div>';
	}

	/**
	 * Create the form that will be displayed in the configuration of your module.
	 */
	protected function renderForm()
	{
		$helper = new HelperForm();
		$this->updatePosition(Hook::getIdByName('Header'), 1, 200);

		$helper->show_toolbar = false;
		$helper->table = $this->table;
		$helper->module = $this;
		$helper->default_form_language = $this->context->language->id;
		$helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

		$helper->identifier = $this->identifier;
		$helper->submit_action = 'submitNrtpageeditorsModule';
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
			.'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');

		$content = Configuration::get($this->config_name.'_content');

		$content_format = array();

		if (isset($content) && ($content != 'null' || $content != ''))
		{
			$contenta = json_decode($content, true);
			
			if (is_array($contenta))
				$content_format = $this->buildSubmenuTree($contenta, false);
		}

			
		$var = array();
		$var['content'] = Configuration::get($this->config_name.'_content');	
		$helper->tpl_vars = array(
			'fields_value' => $var, /* Add values for your inputs */
			'languages' => $this->context->controller->getLanguages(),
			'manufacturers_select' => $this->renderManufacturersSelect(),
			'custom_html_select' => $this->renderCustomHtmlSelect(),
			'available_modules' => $this->getAvailableModules(),
			'fronteditor_link' => $this->context->link->getModuleLink('nrtpageeditors','Editor', array(
				'nrt_fronteditor_token' => $this->getFrontEditorToken(),
				'admin_webpath' => $this->context->controller->admin_webpath,
				'id_employee' => is_object($this->context->employee) ? (int)$this->context->employee->id :
				Tools::getValue('id_employee')
				)),
			'categories_select' => $this->renderCategoriesSelect(false),
			'images_formats' => ImageType::getImagesTypes('products'),
			'submenu_content' => htmlentities($content, ENT_COMPAT, 'UTF-8'),
			'submenu_content_format' => $content_format,
			'id_language' => $this->context->language->id,
		);

		return $helper->generateForm(array($this->getConfigForm()));
	}

	/**
	 * Create the structure of your form.
	 */
	protected function getConfigForm()
	{
		return array(
			'form' => array(
				'input' => array(
					array(
							'type' => 'grid_editors',
							'label' => '',
							'col' => 12,
							'preffix_wrapper' => 'grid-submenu',
							'name' => 'grid_editors',
						),
				),
				'submit' => array(
					'title' => $this->l('Save'),
				),
			),
		);
	}
	/**
	 * Save form data.
	 */
	protected function _postProcess()
	{
		Configuration::updateValue($this->config_name.'_content', htmlentities(urldecode(Tools::getValue('submenu-elements'))),true);
		$this->generateCss();
	}

	public function generateElementsCss($elements)
	{
		$css = ''.PHP_EOL;


		foreach ($elements as $key => $element)
		{	
			if(isset($element['row_s']))
			{
				if(isset($element['row_s']['bgw']) && $element['row_s']['bgw'])
					$css .= '#nrtpageeditors .content-'.$element['elementId'].'{
					'.(isset($element['row_s']['bgc']) && $element['row_s']['bgc'] != '' ? 'background-color: '.$element['row_s']['bgc'].';' : '').'
					'.(isset($element['row_s']['bgi']) && $element['row_s']['bgi'] != '' ? 'background-image: url('.$element['row_s']['bgi'].'); background-repeat: '.$this->convertBgRepeat($element['row_s']['bgr']).';' : '').'

					}';
				else	
					$css .= ' #nrtpageeditors .content-'.$element['elementId'].'{
						'.(isset($element['row_s']['bgc']) && $element['row_s']['bgc'] != '' ? 'background-color: '.$element['row_s']['bgc'].';' : '').'
						'.(isset($element['row_s']['bgi']) && $element['row_s']['bgi'] != '' ? 'background-image: url('.$element['row_s']['bgi'].'); background-repeat: '.$this->convertBgRepeat($element['row_s']['bgr']).';' : '').'

					}';
			}
		}

		return $css;
	}

	public function generateCss()
	{
		$css = '';
		$content = Configuration::get($this->config_name.'_content');

		if (strlen($content))
		{
			$content = $this->buildSubmenuTree(json_decode($content, true), false, true);
			$css .=  $this->generateElementsCss($content);
		}


		$css  = trim(preg_replace('/\s+/', ' ', $css));

		if (Shop::getContext() == Shop::CONTEXT_GROUP)
			$my_file = $this->local_path.'css/home_editors_g_'.(int)$this->context->shop->getContextShopGroupID().'.css';
		elseif (Shop::getContext() == Shop::CONTEXT_SHOP)
			$my_file = $this->local_path.'css/home_editors_s_'.(int)$this->context->shop->getContextShopID().'.css';
		
		$fh = fopen($my_file, 'w') or die("can't open file");
		fwrite($fh, $css);
		fclose($fh);

		$this->_clearCache('*');

		return true;

	}

	public function renderAddHtmlForm()
	{	

		$fields_form = array(
			'form' => array(
				'tab_name' => 'main_tab',
				'legend' => array(
					'title' => $this->l('Add custom html'),
					'icon' => 'icon-cogs',
					'id' => 'fff'
				),
				'input' => array(
					array(
						'type' => 'text',
						'label' => $this->l('Name'),
						'name' => 'title',
						'desc' => $this->l('Custom html name, Only for backoffice purposes'),
						'lang' => false,
					),
					array(
					'type' => 'textarea',
					'label' => $this->l('Html content'),
					'name' => 'html',
					'lang' => true,
					'autoload_rte' => true,
					'desc' => $this->l('Custom html content which you can later select in editors'),
					'cols' => 60,
					'rows' => 30
				),
				),
				'submit' => array(
					'title' => $this->l('Save'),
				),
				'buttons' => array(
				'button' => array(
					'name' => 'back_to_configuration',
					'type' => 'submit',
					'icon' => 'process-icon-back',
					'class' => 'btn btn-default pull-left',
					'title' => $this->l('Back')
					),)

			),
		);
		
		if (Tools::isSubmit('id_html') && NrtEditorsHtml::htmlExists((int)Tools::getValue('id_html')))
		{
			$tab = new NrtEditorsHtml((int)Tools::getValue('id_html'));
			$fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'id_html');	
		}

		$helper = new HelperForm();
		$helper->show_toolbar = false;
		$helper->table = $this->table;
		$lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->default_form_language = $lang->id;
		$helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
		$this->fields_form = array();
		$helper->module = $this;
		$helper->identifier = $this->identifier;
		$helper->submit_action = 'submitAddHtml';
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$language = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->tpl_vars = array(
			'base_url' => $this->context->shop->getBaseURL(),
			'language' => array(
				'id_lang' => $language->id,
				'iso_code' => $language->iso_code
			),
			'fields_value' => $this->getAddHtmlFieldsValues(),
			'languages' => $this->context->controller->getLanguages(),
			'id_language' => $this->context->language->id,
			'module_path' => $this->_path,
			'image_baseurl' => $this->_path.'images/'
		);


		$helper->override_folder = '/';

		return $helper->generateForm(array($fields_form));
	}

	public function getAddHtmlFieldsValues()
	{
		$fields = array();

		$fields['title'] = '';

		if (Tools::isSubmit('id_html') && NrtEditorsHtml::htmlExists((int)Tools::getValue('id_html')))
		{
			$html = new NrtEditorsHtml((int)Tools::getValue('id_html'));
			$fields['id_html'] = (int)Tools::getValue('id_html', $html->id);
			$fields['title'] = $html->title;
			
		}
		else
			$html = new NrtEditorsHtml();
		
		$languages = Language::getLanguages(false);

		foreach ($languages as $lang)
			$fields['html'][$lang['id_lang']] = Tools::getValue('html_'.(int)$lang['id_lang'], $html->html[$lang['id_lang']]);

		return $fields;
	}

	public function renderHtmlContents(){

		$shops = Shop::getContextListShopID();
		$tabs = array();

		$tabs = NrtEditorsHtml::getHtmls();

		$this->context->smarty->assign(
			array(
				'link' => $this->context->link,
				'tabs' => $tabs,
			)
		);

		return $this->display(__FILE__, 'listhtml.tpl');

	}

	private function _postValidationHtml()
	{
		$errors = array();

		/* Validation for tab */
		if (Tools::isSubmit('submitAddHtml'))
		{
			/* If edit : checks id_tab */
			if (Tools::isSubmit('id_html'))
			{
				if (!Validate::isInt(Tools::getValue('id_html')) && !NrtEditorsHtml::htmlExists(Tools::getValue('id_html')))
					$errors[] = $this->l('Invalid id_html');
			}

			if (!Tools::strlen(Tools::getValue('title')))
					$errors[] = $this->l('Title is not set');

			/* Checks title/description for default lang */
			$id_lang_default = (int)Configuration::get('PS_LANG_DEFAULT');
			if (Tools::strlen(Tools::getValue('html_'.$id_lang_default)) == 0)
				$errors[] = $this->l('The html is not set');
		} 
		/* Validation for deletion */
		elseif (Tools::isSubmit('delete_id_html') && (!Validate::isInt(Tools::getValue('delete_id_html')) || !NrtEditorsHtml::htmlExists((int)Tools::getValue('delete_id_html'))))
			$errors[] = $this->l('Invalid id_html');

		/* Display errors if needed */
		if (count($errors))
		{
			$this->_html .= $this->displayError(implode('<br />', $errors));

			return false;
		}

		/* Returns if validation is ok */

		return true;
	}

	private function _postProcessHtml()
	{
		$errors = array();

		/* Processes tab */
		if (Tools::isSubmit('submitAddHtml'))
		{
			/* Sets ID if needed */
			if (Tools::getValue('id_html'))
			{ 
				$tab = new NrtEditorsHtml((int)Tools::getValue('id_html'));
				if (!Validate::isLoadedObject($tab))
				{
					$this->_html .= $this->displayError($this->l('Invalid id_tab'));

					return false;
				}
			}
			else
				$tab = new NrtEditorsHtml();

			
			$tab->title = Tools::getValue('title');
		
			/* Sets each langue fields */
			$languages = Language::getLanguages(false);
			foreach ($languages as $language)
				$tab->html[$language['id_lang']] = Tools::getValue('html_'.$language['id_lang']);
				
	

			/* Processes if no errors  */
			if (!$errors)
			{
				/* Adds */
				if (!Tools::getValue('id_html'))
				{
					if (!$tab->add())
						$errors[] = $this->displayError($this->l('The html content could not be added.'));
				}
				/* Update */
				elseif (!$tab->update())
					$errors[] = $this->displayError($this->l('The html could not be updated.'));
			}
		} /* Deletes */
		elseif (Tools::isSubmit('delete_id_html'))
		{
			$tab = new NrtEditorsHtml((int)Tools::getValue('delete_id_html'));
			$res = $tab->delete();
			if (!$res)
				$this->_html .= $this->displayError('Could not delete.');
			else
				Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=1&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name);
		}
			
		/* Display errors if needed */
		if (count($errors))
			$this->_html .= $this->displayError(implode('<br />', $errors));
		elseif (Tools::isSubmit('submitAddTab') && Tools::getValue('id_tab'))
			Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=4&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name);
		elseif (Tools::isSubmit('submitAddTab'))
			Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=3&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name);
	}

	/**
	 * Add the CSS & JavaScript files you want to be added on the FO.
	 */
	public function hookHeader()
	{	
		if (!isset($this->context->controller->php_self) || $this->context->controller->php_self != 'index')
			return;
		
			$this->putAssetsFiles();
	}

	public function putAssetsFiles()
	{
		if (Shop::getContext() == Shop::CONTEXT_GROUP){
			$this->context->controller->registerStylesheet('modules-nrtpageeditors', 'modules/'.$this->name.'/css/home_editors_g_'.(int)$this->context->shop->getContextShopGroupID().'.css', ['media' => 'all', 'priority' => 1003]);
		}
		elseif (Shop::getContext() == Shop::CONTEXT_SHOP)
		{
			$this->context->controller->registerStylesheet('modules-nrtpageeditors', 'modules/'.$this->name.'/css/home_editors_s_'.(int)$this->context->shop->getContextShopID().'.css', ['media' => 'all', 'priority' => 1003]);
		}
	}

	public function hookDisplayHomeCustom()
	{	
		$random = round(rand(1, max(3, 1)));
		
		if (!$this->isCached('nrtpageeditors.tpl', $this->getCacheId('nrtpageeditors|'.$random)))
		{

		$content = Configuration::get($this->config_name.'_content');
		if (strlen($content))
		$content = $this->buildSubmenuTree(json_decode($content, true), true);
		$imagesTypes = ImageType::getImagesTypes('products');
		$images = array();

		foreach ($imagesTypes as $image) {
			$images[$image['name']] = Image::getSize($image['name']);
			$images[$image['name']]['name'] = $image['name'];
		}
		$this->smarty->assign(array(
			'content' => $content,
			'manufacturerSize' => Image::getSize('manufacturer'),
			'images_types' => $images,
			'this_path' => $this->_path,
			'manu_dir'=> _THEME_MANU_DIR_
		));
		}
		return $this->display(__FILE__, 'nrtpageeditors.tpl', $this->getCacheId('nrtpageeditors|'.$random));

	}

	protected function getCacheId($name = null)
	{
		if ($name === null)
		$name = 'nrtpageeditors';
		return parent::getCacheId($name);
	}

	public function renderManufacturersSelect()
	{
		$return_manufacturers = array();

		$manufacturers = Manufacturer::getManufacturers(false, $this->context->language->id);
		foreach ($manufacturers as $key=>$manufacturer)
		{
			$return_manufacturers[$key]['name'] = $manufacturer['name'];
			$return_manufacturers[$key]['id'] =  $manufacturer['id_manufacturer'];
		}
		return $return_manufacturers;
	}

	public function renderCustomHtmlSelect()
	{	
		$custom_html = array();
		$id_lang = (int)Context::getContext()->language->id;

		$custom_html = NrtEditorsHtml::getHtmls();
		return $custom_html;
	}

	public function renderCategoriesSelect($frontend)
	{
		$return_categories = array();

		$shops_to_get = Shop::getContextListShopID();

		foreach ($shops_to_get as $shop_id)
			$return_categories = $this->generateCategoriesOption2(Category::getNestedCategories(null, (int)$this->context->language->id, true), $frontend);

		return $return_categories;
	}

	public function customGetNestedCategories($shop_id, $root_category = null, $id_lang = false, $active = true, $groups = null, $use_shop_restriction = true, $sql_filter = '', $sql_sort = '', $sql_limit = '')
	{
		if (isset($root_category) && !Validate::isInt($root_category))
			die(Tools::displayError());

		if (!Validate::isBool($active))
			die(Tools::displayError());

		if (isset($groups) && Group::isFeatureActive() && !is_array($groups))
			$groups = (array)$groups;

			$result = Db::getInstance()->executeS('
							SELECT c.*, cl.*
				FROM `'._DB_PREFIX_.'category` c
				INNER JOIN `'._DB_PREFIX_.'category_shop` category_shop ON (category_shop.`id_category` = c.`id_category` AND category_shop.`id_shop` = "'.(int)$shop_id.'")
				LEFT JOIN `'._DB_PREFIX_.'category_lang` cl ON c.`id_category` = cl.`id_category` AND cl.`id_shop` = "'.(int)$shop_id.'"
				WHERE 1 '.$sql_filter.' '.($id_lang ? 'AND `id_lang` = '.(int)$id_lang : '').'
				'.($active ? ' AND c.`active` = 1' : '').'
				'.(isset($groups) && Group::isFeatureActive() ? ' AND cg.`id_group` IN ('.implode(',', $groups).')' : '').'
				'.(!$id_lang || (isset($groups) && Group::isFeatureActive()) ? ' GROUP BY c.`id_category`' : '').'
				'.($sql_sort != '' ? $sql_sort : ' ORDER BY c.`level_depth` ASC').'
				'.($sql_sort == '' && $use_shop_restriction ? ', category_shop.`position` ASC' : '').'
				'.($sql_limit != '' ? $sql_limit : '')
			);

			$categories = array();
			$buff = array();

			if (!isset($root_category))
				$root_category = 1;

			foreach ($result as $row)
			{
				$current = &$buff[$row['id_category']];
				$current = $row;

				if ($row['id_category'] == $root_category)
					$categories[$row['id_category']] = &$current;
				else
					$buff[$row['id_parent']]['children'][$row['id_category']] = &$current;
			}

		return $categories;
	}

		private function generateCategoriesOption2($categories, $frontend)
	{
		$return_categories = array();

		foreach ($categories as $key => $category)
		{
				$shop = (object) Shop::getShop((int)$category['id_shop']);

				$return_categories[$key]['id'] =  (int)$category['id_category'];
				$return_categories[$key]['name'] = (!$frontend ? str_repeat('&nbsp;', $this->spacer_size * (int)$category['level_depth']) : '').$category['name'].' ('.$shop->name.')';
			
			if (isset($category['children']) && !empty($category['children']))
				$return_categories[$key]['children'] = $this->generateCategoriesOption2($category['children'], $frontend);
		}

		return $return_categories;
	}

	public function buildSubmenuTree(array $dataset, $frontend = false, $cssgenerator = false) 
	{
		$id_lang = (int)Context::getContext()->language->id;
		$id_shop = (int)Context::getContext()->shop->id;
		$id_lang_default = (int)Configuration::get('PS_LANG_DEFAULT');

		$tree = array();
		foreach ($dataset as $id=>&$node) {
			if($cssgenerator)
			{

				//set style
				if(isset($node['content_s']['br_top_st']))
					$node['content_s']['br_top_st'] = $this->convertBorderType($node['content_s']['br_top_st']);

				if(isset($node['content_s']['br_right_st']))
					$node['content_s']['br_right_st'] = $this->convertBorderType($node['content_s']['br_right_st']);

				if(isset($node['content_s']['br_bottom_st']))
					$node['content_s']['br_bottom_st'] = $this->convertBorderType($node['content_s']['br_bottom_st']);

				if(isset($node['content_s']['br_left_st']))
					$node['content_s']['br_left_st'] = $this->convertBorderType($node['content_s']['br_left_st']);

			}
			if($frontend)
			{
				

				if(isset($node['content_s']['title'][$id_lang]) && $node['content_s']['title'][$id_lang]!='')
					$node['content_s']['title'] = $node['content_s']['title'][$id_lang];
				elseif(isset($node['content_s']['title'][$id_lang_default]) && $node['content_s']['title'][$id_lang_default]!='')
					$node['content_s']['title'] = $node['content_s']['title'][$id_lang_default];
				else
					unset($node['content_s']['title']);

				if(isset($node['content_s']['href'][$id_lang]) && $node['content_s']['href'][$id_lang]!='')
					$node['content_s']['href'] = $node['content_s']['href'][$id_lang];
				elseif(isset($node['content_s']['href'][$id_lang_default]) && $node['content_s']['href'][$id_lang_default]!='')
					$node['content_s']['href'] = $node['content_s']['href'][$id_lang_default];
				else
					unset($node['content_s']['href']);


				if(isset($node['content_s']['legend'][$id_lang]) && $node['content_s']['legend'][$id_lang]!='')
					$node['content_s']['legend'] = $node['content_s']['legend'][$id_lang];
				elseif(isset($node['content_s']['legend'][$id_lang_default]) && $node['content_s']['legend'][$id_lang_default]!='')
					$node['content_s']['legend'] = $node['content_s']['legend'][$id_lang_default];
				else
					unset($node['content_s']['legend']);

				if(isset($node['tabtitle'][$id_lang]) && $node['tabtitle'][$id_lang]!='')
					$node['tabtitle'] = html_entity_decode($node['tabtitle'][$id_lang]);
				elseif(isset($node['tabtitle'][$id_lang_default]) && $node['tabtitle'][$id_lang_default]!='')
					$node['tabtitle'] = html_entity_decode($node['tabtitle'][$id_lang_default]);
				else
					unset($node['tabtitle']);


			//set variouse links
				if(isset($node['contentType'])){


					switch ($node['contentType']) {
						case 1:
						if(isset($node['content']['ids']))
						{	
							$customhtml = new NrtEditorsHtml((int)$node['content']['ids'], $id_lang);

							if (Validate::isLoadedObject($customhtml))
							{
								$node['content']['ids'] = $customhtml->html;
							}
						}	
						break;
						case 4:

						if(isset($node['content']['ids']) && !empty($node['content']['ids'])){
						$products=array();
						foreach($node['content']['ids'] as $id_product){
						$customProduct = get_object_vars(new Product($id_product, true, $id_lang));
						$customProduct['id_product'] = $customProduct['id'];
						$coverImage = Product::getCover($customProduct['id_product']);
						$customProduct['id_image'] = $coverImage['id_image'];
						if(Product::getProductProperties($id_lang, $customProduct))
						$products[]= Product::getProductProperties($id_lang, $customProduct);
						}
						$assembler = new ProductAssembler($this->context);
						$presenterFactory = new ProductPresenterFactory($this->context);
						$presentationSettings = $presenterFactory->getPresentationSettings();
						$presenter = new ProductListingPresenter(
							new ImageRetriever(
								$this->context->link
							),
							$this->context->link,
							new PriceFormatter(),
							new ProductColorsRetriever(),
							$this->context->getTranslator()
						);
						$products_for_template = [];
							if(is_array($products)){
							foreach ($products as $rawProduct) {
								$products_for_template[] = $presenter->present(
									$presentationSettings,
									$assembler->assembleProduct($rawProduct),
									$this->context->language
								);
								}
							}
							
							$node['content']['products']=$products_for_template;

							$this->addColorsToProductList($node['content']['products']);

							$node['content']['productsimg'] = array();

							if($node['content']['view'] == 0 || $node['content']['view'] == 2)
							{
								$node['content']['line_md'] = $this->convertGridSizeValue($node['content']['line_md']);
								$node['content']['line_sm'] = $this->convertGridSizeValue($node['content']['line_sm']);
								$node['content']['line_xs'] = $this->convertGridSizeValue($node['content']['line_xs']);
							}
						}

						break;
						case 2:
						if(isset($node['content']['ids']))
						{	
							
							if($node['content']['ids'] == 'n')
							{
								if($node['content']['o'] == 1){
									$products = Product::getNewProducts($id_lang, 0, (int)$node['content']['limit']);
								}
								else
								{
									$products = Product::getNewProducts($id_lang, 0, (int)$node['content']['limit'], false, $node['content']['o'], $node['content']['ob']);
								}
							}
							elseif($node['content']['ids'] == 's')
							{
								if($node['content']['o'] == 1)
								{
									$products = Product::getPricesDrop($id_lang, 0, (int)$node['content']['limit']);
								}
								else
								{
									$products = Product::getPricesDrop($id_lang, 0, (int)$node['content']['limit'], false, $node['content']['o'], $node['content']['ob']);
								}
							}
							elseif($node['content']['ids'] == 'b')
							{
							$products = ProductSale::getBestSales($id_lang, 0, (int)$node['content']['limit'], 'sales');
							}
							else
							{
								$category = new Category((int)$node['content']['ids'], $id_lang);
								if($node['content']['o'] == 1){
									$products = $category->getProducts($id_lang, 1, (int)$node['content']['limit'], null, null, false, true, true, (int)$node['content']['limit']);
								}
								else
									$products = $category->getProducts($id_lang, 1, (int)$node['content']['limit'], $node['content']['o'], $node['content']['ob']);
							}
						$assembler = new ProductAssembler($this->context);
						$presenterFactory = new ProductPresenterFactory($this->context);
						$presentationSettings = $presenterFactory->getPresentationSettings();
						$presenter = new ProductListingPresenter(
							new ImageRetriever(
								$this->context->link
							),
							$this->context->link,
							new PriceFormatter(),
							new ProductColorsRetriever(),
							$this->context->getTranslator()
						);
						$products_for_template = [];
							if(is_array($products)){
							foreach ($products as $rawProduct) {
								$products_for_template[] = $presenter->present(
									$presentationSettings,
									$assembler->assembleProduct($rawProduct),
									$this->context->language
								);
								}
							}
							$node['content']['products'] = $products_for_template;

							$this->addColorsToProductList($node['content']['products']);

							$node['content']['productsimg'] = array();
							
							if($node['content']['view'] == 0 || $node['content']['view'] == 2)
							{
								
								$node['content']['line_md'] = $this->convertGridSizeValue($node['content']['line_md']);
								$node['content']['line_sm'] = $this->convertGridSizeValue($node['content']['line_sm']);
								$node['content']['line_xs'] = $this->convertGridSizeValue($node['content']['line_xs']);
							}
						}
						break;
						case 6:
						if(isset($node['content']['source'][$id_lang]) && $node['content']['source'][$id_lang]!='')
							$node['content']['source'] = $node['content']['source'][$id_lang];
						elseif(isset($node['content']['source'][$id_lang_default]) && $node['content']['source'][$id_lang_default]!='')
							$node['content']['source'] = $node['content']['source'][$id_lang_default];
						else
							unset($node['content']['source']);

						if(isset($node['content']['href'][$id_lang]) && $node['content']['href'][$id_lang]!='')
							$node['content']['href'] = $node['content']['href'][$id_lang];
						elseif(isset($node['content']['href'][$id_lang_default]) && $node['content']['href'][$id_lang_default]!='')
							$node['content']['href'] = $node['content']['href'][$id_lang_default];
						else
							unset($node['content']['href']);

						break;
						case 7:
						if($node['content']['view'] == 0)
						{
							$node['content']['line_md'] = $this->convertGridSizeValue($node['content']['line_md']);
							$node['content']['line_sm'] = $this->convertGridSizeValue($node['content']['line_sm']);
							$node['content']['line_xs'] = $this->convertGridSizeValue($node['content']['line_xs']);
						}
						if (isset($node['content']['ids'][0]) && ($node['content']['ids'][0] == 0)){
							$node['content']['manu'] = Manufacturer::getManufacturers(false, $this->context->language->id, true, false, false, false);
							foreach($node['content']['manu'] as $key=>$manu){
								$node['content']['manu']['id'][$key]=$manu['id_manufacturer'];
							}
						}
						break;
						case 9:
							$node['content']['module'] = $this->execModuleHook($node['content']['hook'], array(), $node['content']['id_module'], $id_shop);
						break;
					}

				}

			}

			if(!$frontend){
				if(isset($node['contentType']) && $node['contentType'] == 4 ){
					if(isset($node['content']['ids']) && !empty($node['content']['ids']))
						$node['content']['ids'] = $this->getProducts($node['content']['ids']);
				}
			}


				
			

	
			if ($node['parentId'] === 0) {
				$tree[$id] = &$node;
			} else {
				if (!isset($dataset[$node['parentId']]['children'])) 
					$dataset[$node['parentId']]['children'] = array();
				$dataset[$node['parentId']]['children'][$id] = &$node;
			}
			
		}
		

		$tree = $this->sortArrayTree($tree);
		return $tree;
	}
	
	public function sortArrayTree($passedTree)
	{
		usort($passedTree,array($this, 'sortByPosition'));

		foreach ($passedTree as $key => $subtree) {

			if( !empty( $subtree['children'] ) )
			{	
				$passedTree[$key]['children'] = $this->sortArrayTree($subtree['children']);
				
			}
		}	
		
		return $passedTree;
	}

	public function sortByPosition($a, $b) 
	{
		return $a['position'] - $b['position'];
	}

	public function convertGridSizeValue($value) 
	{
		switch ($value) {
			case 1:
			return 12;
			break;
			case 2:
			return 6;
			break;
			case 15:
			return 5;
			break;
			case 3:
			return 4;
			break;
			case 4:
			return 3;
			break;
			case 6:
			return 2;
			break;
			case 12:
			return 1;
			break;
		}
	}

	 public function getAvailableModules()
    {	
    	$id_shop = (int)Context::getContext()->shop->id;
    	$usableHooks = array('displayNav2','displayNav1','displayFooterBefore','displayNav','displayTopColumn','displayFooter','displayFooterProduct','displayNavFullWidth','displayTop','displayHome','displayLeftColumn','displayRightColumn','slideshow','blocktags','bannerslider','smartbloghomelatestnews','vmegamenu','testimonials','bestsellers','specialproduct');
		
        $excludeModules = array('nrtthemecustomizer', 'nrtblocksearch', 'ps_sharebuttons' ,'ps_languageselector','ps_facetedsearch','ps_currencyselector','ps_categorytree','ps_shoppingcart');
		
  		$modules = Db::getInstance()->executeS('
		SELECT m.id_module, m.name
		FROM `'._DB_PREFIX_.'module` m 
	    WHERE m.`name` NOT IN (\'' . implode("','", $excludeModules) . '\') ');
  		$modulesHooks = array();
		 foreach ($modules as $key => $module)
		 {
		 	 $moduleInstance = Module::getInstanceByName($module['name']);
		 	 if(Validate::isLoadedObject($moduleInstance))
		 	  {
		 	 $flag = false;
		 	 $modules[$key]['hooks'] = '';
			$hook_module_name = Db::getInstance()->executeS('SELECT m.name
			FROM `'._DB_PREFIX_.'hook` m 
			LEFT JOIN `'._DB_PREFIX_.'hook_module` n 
			ON m.`id_hook` = n.`id_hook` WHERE n.`id_module`= '.$module['id_module']);
			foreach($hook_module_name as $hook_name){
				if($moduleInstance->isHookableOn($hook_name['name']) && in_array($hook_name['name'],$usableHooks))
				{											
					if($flag){
						$modules[$key]['hooks'] .= ',';	
					}
					$modules[$key]['hooks'] .= $hook_name['name'];
					$flag = true;
				}
			}
  			if($flag){
				$modulesHook[$module['name']] =  $modules[$key];
			}
			  }
		 }
        return $modulesHook;
    }


    public function execModuleHook($hook_name, $hook_args = array(), $name_module = null, $id_shop = null)
	{
		
		$id_module = Module::getModuleIdByName($name_module);
		// Check arguments validity
		if (($id_module && !is_numeric($id_module)) || !Validate::isHookName($hook_name))
			return false;
		
		// Check if hook exists
		if (!$id_hook = Hook::getIdByName($hook_name))
			return false;

		// Store list of executed hooks on this page
		Hook::$executed_hooks[$id_hook] = $hook_name;

		$live_edit = false;
		$context = Context::getContext();
		if (!isset($hook_args['cookie']) || !$hook_args['cookie'])
			$hook_args['cookie'] = $context->cookie;
		if (!isset($hook_args['cart']) || !$hook_args['cart'])
			$hook_args['cart'] = $context->cart;

		$retro_hook_name = Hook::getRetroHookName($hook_name);

		// Look on modules list
		$altern = 0;
		$output = '';

		$different_shop = false;
		if ($id_shop !== null && Validate::isUnsignedId($id_shop) && $id_shop != $context->shop->getContextShopID())
		{
			$old_context_shop_id = $context->shop->getContextShopID();
			$old_context = $context->shop->getContext();
			$old_shop = clone $context->shop;
			$shop = new Shop((int)$id_shop);
			if (Validate::isLoadedObject($shop))
			{
				$context->shop = $shop;
				$context->shop->setContext(Shop::CONTEXT_SHOP, $shop->id);
				$different_shop = true;
			}
		}
			if (!($moduleInstance = Module::getInstanceById($id_module)))
				return false;

			// Check which / if method is callable
			$hook_callable = is_callable(array($moduleInstance, 'hook'.$hook_name));
			$hook_retro_callable = is_callable(array($moduleInstance, 'hook'.$retro_hook_name));
			$renderWidget_callable = is_callable(array($moduleInstance, 'renderWidget'));
			$check=true;
			$exceptions = Module::getExceptionsStatic($id_module,Hook::getIdByName($hook_name));
			$controller = Dispatcher::getInstance()->getController();
			$controller_obj = Context::getContext()->controller;
			$modules_shop_active = Db::getInstance()->executeS('
																SELECT *
																FROM `'._DB_PREFIX_.'module_shop` m
																WHERE m.`id_module` ='.$id_module);
			//check if current controller is a module controller
			if (isset($controller_obj->module) && Validate::isLoadedObject($controller_obj->module)) {
				$controller = 'module-'.$controller_obj->module->name.'-'.$controller;
			}
			if (in_array($controller, $exceptions)) {
				$check=false;
			}
			if (($hook_callable || $hook_retro_callable) && $check && $modules_shop_active)
			{
				$hook_args['altern'] = ++$altern;
				// Call hook method
				if ($hook_callable)
					$display = $moduleInstance->{'hook'.$hook_name}($hook_args);
				elseif ($hook_retro_callable)
					$display = $moduleInstance->{'hook'.$retro_hook_name}($hook_args);
					$output .= $display;
			}
			else if($renderWidget_callable && $check && $modules_shop_active){
			$output=$moduleInstance->renderWidget($hook_name, $hook_args);
			}

		if ($different_shop)
		{
			$context->shop = $old_shop;
			$context->shop->setContext($old_context, $shop->id);
		}

		return $output;
	}

	public function getProducts($ids)
	{		
	
			if(!isset($ids) || empty($ids))
				return;
			
			if(is_array($ids))
				$product_ids = join(',', $ids);
			else
				$product_ids = $ids;

			if (Group::isFeatureActive())
				{
					$sql_groups_join = '
					LEFT JOIN `'._DB_PREFIX_.'category_product` cp ON (cp.`id_category` = product_shop.id_category_default
						AND cp.id_product = product_shop.id_product)
					LEFT JOIN `'._DB_PREFIX_.'category_group` cg ON (cp.`id_category` = cg.`id_category`)';
					$groups = FrontController::getCurrentCustomerGroups();
					$sql_groups_where = 'AND cg.`id_group` '.(count($groups) ? 'IN ('.implode(',', $groups).')' : '='.(int)Group::getCurrent()->id);
				}

				$selected_products = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
					SELECT DISTINCT p.id_product, pl.name, pl.link_rewrite, p.reference, i.id_image, m.`name` AS manufacturer_name, product_shop.show_price, product_shop.`id_category_default`, 
						cl.link_rewrite category, p.ean13, stock.out_of_stock, p.available_for_order, p.customizable, IFNULL(stock.quantity, 0) as quantity,
						product_shop.`unity`, product_shop.`unit_price_ratio`,
						DATEDIFF(product_shop.`date_add`, DATE_SUB(NOW(),
					INTERVAL '.(Validate::isUnsignedInt(Configuration::get('PS_NB_DAYS_NEW_PRODUCT')) ? Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20).'
						DAY)) > 0 AS new
					FROM '._DB_PREFIX_.'product p
					'.Shop::addSqlAssociation('product', 'p').
					(Combination::isFeatureActive() ? 'LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa
					ON (p.`id_product` = pa.`id_product`)
					'.Shop::addSqlAssociation('product_attribute', 'pa', false, 'product_attribute_shop.`default_on` = 1').'
					'.Product::sqlStock('p', 'product_attribute_shop', false, $this->context->shop) :  Product::sqlStock('p', 'product', false,
						$this->context->shop)).'
					LEFT JOIN `'._DB_PREFIX_.'manufacturer` m
					ON m.`id_manufacturer` = p.`id_manufacturer`
					LEFT JOIN '._DB_PREFIX_.'product_lang pl ON (pl.id_product = p.id_product'.Shop::addSqlRestrictionOnLang('pl').')
					LEFT JOIN '._DB_PREFIX_.'category_lang cl ON (cl.id_category = product_shop.id_category_default'
						.Shop::addSqlRestrictionOnLang('cl').')
					LEFT JOIN '._DB_PREFIX_.'image i ON (i.id_product = p.id_product AND i.cover = 1)
					'.(Group::isFeatureActive() ? $sql_groups_join : '').'
					WHERE p.id_product IN ('.$product_ids.')
					AND pl.id_lang = '.(int)$this->context->language->id.'
					AND cl.id_lang = '.(int)$this->context->language->id.'
					AND product_shop.active = 1
					'.(Group::isFeatureActive() ? $sql_groups_where : '').
					' ORDER BY FIELD(p.id_product, '.$product_ids.')'
					);



				$tax_calc = Product::getTaxCalculationMethod();
				$final_products_list = array();

				foreach ($selected_products as &$selected_product)
				{
					$usetax = false;
					$selected_product['id_product'] = (int)$selected_product['id_product'];
					$selected_product['image'] = $this->context->link->getImageLink($selected_product['link_rewrite'],
						(int)$selected_product['id_product'].'-'.(int)$selected_product['id_image'], ImageType::getFormatedName('home'));
					$selected_product['link'] = $this->context->link->getProductLink((int)$selected_product['id_product'], $selected_product['link_rewrite'],
						$selected_product['category'], $selected_product['ean13']);
					if (($tax_calc == 0 || $tax_calc == 2)){
						$usetax = true;
						$selected_product['displayed_price'] = Product::getPriceStatic((int)$selected_product['id_product'], true, null);
						}
					elseif ($tax_calc == 1)
						$selected_product['displayed_price'] = Product::getPriceStatic((int)$selected_product['id_product'], false, null);
					$selected_product['price_without_reduction'] = Product::getPriceStatic(
				(int)$selected_product['id_product'],
				$usetax,
				((isset($selected_product['id_product_attribute']) && !empty($selected_product['id_product_attribute'])) ? (int)$selected_product['id_product_attribute'] : null),
				6,
				null,
				false,
				false
			);

					$selected_product['reduction'] = Product::getPriceStatic(
			(int)$selected_product['id_product'],
			$usetax,
			((isset($selected_product['id_product_attribute']) && !empty($selected_product['id_product_attribute'])) ? (int)$selected_product['id_product_attribute'] : null),
			6,
			null,
			true,
			true,
			1,
			true,
			null,
			null,
			null,
			$specific_prices
		);
					$selected_product['allow_oosp'] = Product::isAvailableWhenOutOfStock((int)$selected_product['out_of_stock']);

					if (!isset($final_products_list[$selected_product['id_product'].'-'.$selected_product['id_image']]))
						$final_products_list[$selected_product['id_product'].'-'.$selected_product['id_image']] = $selected_product;
				}

				return $final_products_list;
	
	}

	public function addColorsToProductList(&$products)
	{
	if (!is_array($products) || !count($products) || !file_exists(_PS_THEME_DIR_.'product-list-colors.tpl'))
		return;

	$products_need_cache = array();
	foreach ($products as &$product)
		$products_need_cache[] = (int)$product['id_product'];

		unset($product);

		$colors = false;
		if (count($products_need_cache))
			$colors = Product::getAttributesColorList($products_need_cache);

		foreach ($products as &$product)
		{
			$tpl = $this->context->smarty->createTemplate(_PS_THEME_DIR_.'product-list-colors.tpl');
			if (isset($colors[$product['id_product']]))
				$tpl->assign(array(
					'id_product' => $product['id_product'],
					'colors_list' => $colors[$product['id_product']],
					'link' => Context::getContext()->link,
					'img_col_dir' => _THEME_COL_DIR_,
					'col_img_dir' => _PS_COL_IMG_DIR_
					));

			if (!in_array($product['id_product'], $products_need_cache) || isset($colors[$product['id_product']]))
				$product['color_list'] = $tpl->fetch(_PS_THEME_DIR_.'product-list-colors.tpl');
			else
				$product['color_list'] = '';
		}
	}

	protected function getColorsListCacheId($id_product)
	{
		return Product::getColorsListCacheId($id_product);
	}

	public function convertBgRepeat($value) {

			switch($value) {
				case 3 :
					$repeat_option = 'repeat';
					break;
				case 2 :
					$repeat_option = 'repeat-x';
					break;
				case 1 :
					$repeat_option = 'repeat-y';
					break;
				default :
					$repeat_option = 'no-repeat';
			}
			return  $repeat_option;
	}

	public function convertBorderType($type) 
	{
			$border_type = 'none';

			switch($type) {
				case 5 :
					$border_type = 'groove';
					break;
				case 4 :
					$border_type = 'double';
					break;
				case 3 :
					$border_type = 'dotted';
					break;
				case 2 :
					$border_type = 'dashed';
					break;
				case 1 :
					$border_type = 'solid';
					break;
				default :
					$border_type = 'none';
			}

		return $border_type;
	}

	public function getFrontEditorToken()
	{
		return Tools::getAdminToken($this->name.(int)Tab::getIdFromClassName($this->name)
			.(is_object(Context::getContext()->employee) ? (int)Context::getContext()->employee->id :
				Tools::getValue('id_employee')));
	}

	public function checkEnvironment()
	{
		$cookie = new Cookie('psAdmin', '', (int)Configuration::get('PS_COOKIE_LIFETIME_BO'));
		return isset($cookie->id_employee) && isset($cookie->passwd) && Employee::checkPassword($cookie->id_employee, $cookie->passwd);
	}

	public function ajaxProcessSearchProducts()
    {

    	$query = Tools::getValue('q', false);
        if (!$query or $query == '' or strlen($query) < 1) {
            die();
        }

        /*
         * In the SQL request the "q" param is used entirely to match result in database.
         * In this way if string:"(ref : #ref_pattern#)" is displayed on the return list,
         * they are no return values just because string:"(ref : #ref_pattern#)"
         * is not write in the name field of the product.
         * So the ref pattern will be cut for the search request.
         */
        if ($pos = strpos($query, ' (ref:')) {
            $query = substr($query, 0, $pos);
        }

        $excludeIds = Tools::getValue('excludeIds', false);
        if ($excludeIds && $excludeIds != 'NaN') {
            $excludeIds = implode(',', array_map('intval', explode(',', $excludeIds)));
        } else {
            $excludeIds = '';
        }

        // Excluding downloadable products from packs because download from pack is not supported
        $excludeVirtuals = (bool)Tools::getValue('excludeVirtuals', true);
        $exclude_packs = (bool)Tools::getValue('exclude_packs', true);

        $context = Context::getContext();

        $sql = 'SELECT p.`id_product`, pl.`link_rewrite`, p.`reference`, pl.`name`, image_shop.`id_image` id_image, il.`legend`, p.`cache_default_attribute`
                FROM `'._DB_PREFIX_.'product` p
                '.Shop::addSqlAssociation('product', 'p').'
                LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (pl.id_product = p.id_product AND pl.id_lang = '.(int)$context->language->id.Shop::addSqlRestrictionOnLang('pl').')
                LEFT JOIN `'._DB_PREFIX_.'image_shop` image_shop
                    ON (image_shop.`id_product` = p.`id_product` AND image_shop.cover=1 AND image_shop.id_shop='.(int)$context->shop->id.')
                LEFT JOIN `'._DB_PREFIX_.'image_lang` il ON (image_shop.`id_image` = il.`id_image` AND il.`id_lang` = '.(int)$context->language->id.')
                WHERE (pl.name LIKE \'%'.pSQL($query).'%\' OR p.reference LIKE \'%'.pSQL($query).'%\')'.
                (!empty($excludeIds) ? ' AND p.id_product NOT IN ('.$excludeIds.') ' : ' ').
                ($excludeVirtuals ? 'AND NOT EXISTS (SELECT 1 FROM `'._DB_PREFIX_.'product_download` pd WHERE (pd.id_product = p.id_product))' : '').
                ($exclude_packs ? 'AND (p.cache_is_pack IS NULL OR p.cache_is_pack = 0)' : '').
                ' GROUP BY p.id_product';

        $items = Db::getInstance()->executeS($sql);

        if ($items && ($excludeIds || strpos($_SERVER['HTTP_REFERER'], 'AdminScenes') !== false)) {
            foreach ($items as $item) {
                echo trim($item['name']).(!empty($item['reference']) ? ' (ref: '.$item['reference'].')' : '').'|'.(int)($item['id_product'])."\n";
            }
        } elseif ($items) {
            // packs
            $results = array();
            foreach ($items as $item) {
                // check if product have combination
                if (Combination::isFeatureActive() && $item['cache_default_attribute']) {
                    $sql = 'SELECT pa.`id_product_attribute`, pa.`reference`, ag.`id_attribute_group`, pai.`id_image`, agl.`name` AS group_name, al.`name` AS attribute_name,
                                a.`id_attribute`
                            FROM `'._DB_PREFIX_.'product_attribute` pa
                            '.Shop::addSqlAssociation('product_attribute', 'pa').'
                            LEFT JOIN `'._DB_PREFIX_.'product_attribute_combination` pac ON pac.`id_product_attribute` = pa.`id_product_attribute`
                            LEFT JOIN `'._DB_PREFIX_.'attribute` a ON a.`id_attribute` = pac.`id_attribute`
                            LEFT JOIN `'._DB_PREFIX_.'attribute_group` ag ON ag.`id_attribute_group` = a.`id_attribute_group`
                            LEFT JOIN `'._DB_PREFIX_.'attribute_lang` al ON (a.`id_attribute` = al.`id_attribute` AND al.`id_lang` = '.(int)$context->language->id.')
                            LEFT JOIN `'._DB_PREFIX_.'attribute_group_lang` agl ON (ag.`id_attribute_group` = agl.`id_attribute_group` AND agl.`id_lang` = '.(int)$context->language->id.')
                            LEFT JOIN `'._DB_PREFIX_.'product_attribute_image` pai ON pai.`id_product_attribute` = pa.`id_product_attribute`
                            WHERE pa.`id_product` = '.(int)$item['id_product'].'
                            GROUP BY pa.`id_product_attribute`, ag.`id_attribute_group`
                            ORDER BY pa.`id_product_attribute`';

                    $combinations = Db::getInstance()->executeS($sql);
                    if (!empty($combinations)) {
                        foreach ($combinations as $k => $combination) {
                            $results[$combination['id_product_attribute']]['id'] = $item['id_product'];
                            $results[$combination['id_product_attribute']]['id_product_attribute'] = $combination['id_product_attribute'];
                            !empty($results[$combination['id_product_attribute']]['name']) ? $results[$combination['id_product_attribute']]['name'] .= ' '.$combination['group_name'].'-'.$combination['attribute_name']
                            : $results[$combination['id_product_attribute']]['name'] = $item['name'].' '.$combination['group_name'].'-'.$combination['attribute_name'];
                            if (!empty($combination['reference'])) {
                                $results[$combination['id_product_attribute']]['ref'] = $combination['reference'];
                            } else {
                                $results[$combination['id_product_attribute']]['ref'] = !empty($item['reference']) ? $item['reference'] : '';
                            }
                            if (empty($results[$combination['id_product_attribute']]['image'])) {
                                $results[$combination['id_product_attribute']]['image'] = str_replace('http://', Tools::getShopProtocol(), $context->link->getImageLink($item['link_rewrite'], $combination['id_image'], 'home_default'));
                            }
                        }
                        self::getProductCombinations($results);
                    } else {
                        $product = array(
                            'id' => (int)($item['id_product']),
                            'name' => 'aa',
                            'ref' => (!empty($item['reference']) ? $item['reference'] : ''),
                            'image' => str_replace('http://', Tools::getShopProtocol(), $context->link->getImageLink($item['link_rewrite'], $item['id_image'], 'home_default')),
                        );
                        array_push($results, $product);
                    }
                } else {
                    $product = array(
                        'id' => (int)($item['id_product']),
                        'name' => 'aa',
                        'ref' => (!empty($item['reference']) ? $item['reference'] : ''),
                        'image' => str_replace('http://', Tools::getShopProtocol(), $context->link->getImageLink($item['link_rewrite'], $item['id_image'], 'home_default')),
                    );
                    array_push($results, $product);
                }
            }
            $results = array_values($results);
            echo Tools::jsonEncode($results);
        } else {
            Tools::jsonEncode(new stdClass);
        }
    }

    /**
     * Retrieve from database all attributes details of a product
     * @param $id
     * @return array
     * @throws PrestaShopDatabaseException
     */
    public static function getProductAttributesForTemplate($id)
    {
        $data = Db::getInstance()->executeS('
                    SELECT DISTINCT
                    '._DB_PREFIX_.'attribute.color as html_color_code, '. _DB_PREFIX_ .'attribute.id_attribute,
                    '._DB_PREFIX_.'attribute_lang.name,
                    '._DB_PREFIX_.'attribute_group.group_type,
                    '._DB_PREFIX_.'attribute_group_lang.name as group_name, '._DB_PREFIX_.'attribute_group_lang.public_name as public_name,
                    '._DB_PREFIX_.'attribute_group_lang.id_attribute_group,
                    '._DB_PREFIX_.'product_attribute.default_on, '._DB_PREFIX_.'product_attribute.reference, '._DB_PREFIX_.'product_attribute.price, '._DB_PREFIX_.'product_attribute.id_product_attribute,
                    '._DB_PREFIX_.'image.id_image as id_product_image
                    
                    FROM '._DB_PREFIX_.'product
                    
                    JOIN '._DB_PREFIX_.'product_attribute ON '._DB_PREFIX_.'product_attribute.id_product = '._DB_PREFIX_.'product.id_product
                    JOIN '._DB_PREFIX_.'product_attribute_combination ON '._DB_PREFIX_.'product_attribute_combination.id_product_attribute = '._DB_PREFIX_.'product_attribute.id_product_attribute
                    JOIN '._DB_PREFIX_.'attribute ON '._DB_PREFIX_.'attribute.id_attribute = '._DB_PREFIX_.'product_attribute_combination.id_attribute 
                    JOIN '._DB_PREFIX_.'attribute_lang ON '._DB_PREFIX_.'attribute_lang.id_attribute = '._DB_PREFIX_.'attribute.id_attribute
                    JOIN '._DB_PREFIX_.'attribute_group ON '._DB_PREFIX_.'attribute_group.id_attribute_group = '._DB_PREFIX_.'attribute.id_attribute_group
                    JOIN '._DB_PREFIX_.'attribute_group_lang ON '._DB_PREFIX_.'attribute_group_lang.id_attribute_group = '._DB_PREFIX_.'attribute_group.id_attribute_group
                    JOIN '._DB_PREFIX_.'image ON '._DB_PREFIX_.'image.id_product = '._DB_PREFIX_.'product.id_product
                
                    WHERE '._DB_PREFIX_.'product.id_product = '.$id.' AND '._DB_PREFIX_.'attribute_group_lang.name NOT IN ("OPTION", "modules") AND ps_attribute_lang.name NOT IN ("Immunitaire", "Standard (RS-SG)", "Standard (RS)")'
        );

        $attributes = [];
        foreach ($data as $key => $attribute) {
            // Common attributes features
            $attributes[$attribute['id_attribute_group']]['group_name'] = $attribute['group_name'];
            $attributes[$attribute['id_attribute_group']]['name'] = $attribute['public_name'];
            $attributes[$attribute['id_attribute_group']]['group_type'] = $attribute['group_type'];
            $attributes[$attribute['id_attribute_group']]['default'] = (int) $attribute['id_attribute'];

            // Particular attributes features
            $attributes[$attribute['id_attribute_group']]['attributes'][$attribute['id_attribute']]['name'] = $attribute['name'];
            if ($attribute['default_on'] == 1) {
                $attributes[$attribute['id_attribute_group']]['attributes'][$attribute['id_attribute']]['selected'] = 1;
            } else {
                $attributes[$attribute['id_attribute_group']]['attributes'][$attribute['id_attribute']]['selected'] = '';
            }

            $attributes[$attribute['id_attribute_group']]['attributes'][$attribute['id_attribute']]['texture'] = (@filemtime(_PS_COL_IMG_DIR_ . $attributes['id_attribute'] . '.jpg')) ? _THEME_COL_DIR_ . $attributes['id_attribute'] . '.jpg' : '';
            $attributes[$attribute['id_attribute_group']]['attributes'][$attribute['id_attribute']]['reference'] = $attribute['reference'];
            $attributes[$attribute['id_attribute_group']]['attributes'][$attribute['id_attribute']]['price'] = round($attribute['price'], 2);
            $attributes[$attribute['id_attribute_group']]['attributes'][$attribute['id_attribute']]['html_color_code'] = $attribute['html_color_code'];
            $attributes[$attribute['id_attribute_group']]['attributes'][$attribute['id_attribute']]['id_product_attribute'] = $attribute['id_product_attribute'];

            if (!in_array($attribute['id_product_image'], $attributes[$attribute['id_attribute_group']]['attributes'][$attribute['id_attribute']]['images'])) {
                // Create indexation from number of existing images in array
                $i = count($attributes[$attribute['id_attribute_group']]['attributes'][$attribute['id_attribute']]['images']);
                $attributes[$attribute['id_attribute_group']]['attributes'][$attribute['id_attribute']]['images'][$i++] = $attribute['id_product_image'];
            }
//            $attributes[$attribute['id_attribute_group']]['attributes'][$attribute['id_attribute']] = array(
//            'name' => $attribute['name'],
//            'html_color_code' => $attribute['html_color_code'],
//            'texture' => (@filemtime(_PS_COL_IMG_DIR_ . $attributes['id_attribute'] . '.jpg')) ? _THEME_COL_DIR_ . $attributes['id_attribute'] . '.jpg' : '',
//            'selected' => (isset($product_for_template['attributes'][$attribute['id_attribute_group']]['id_attribute']) && $product_for_template['attributes'][$attribute['id_attribute_group']]['id_attribute'] == $attribute['id_attribute']) ? true : false,
//            );
        }
        //return dump($attributes);
        return $attributes;
    }

}
