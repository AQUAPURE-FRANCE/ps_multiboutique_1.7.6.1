<?php

if (!defined('_PS_VERSION_'))
	exit;

use PrestaShop\PrestaShop\Core\Module\WidgetInterface;
	
class NrtFacebookConnect extends Module implements WidgetInterface
{
	public $error = "";
	public $fb_login_page;
	public $fb_on;
	public $fb_app_id;
   	private $templateFile;
	public function __construct(){
		$this->name = 'nrtfacebookconnect';
		$this->tab = 'front_office_features';
		$this->version = '1.0.0';
		$this->author = 'AxonVIP';
		$this->need_instance = 0;
		$this->bootstrap = true;
		
		parent::__construct();
		
		$this->_globalVars();
	 
		$this->displayName = $this->l('Facebook Connect');
		$this->description = $this->l('Allow your customers to sign in with Facebook');
		$this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
        $this->templateFile = 'module:nrtfacebookconnect/views/templates/hook/nav.tpl';
	}

	public function install(){
		if (!parent::install()
			|| !$this->registerHook('facebookconnect')
			|| !$this->registerHook('header')
			|| !$this->createFbTable()
			|| !$this->addTab()
			|| !Configuration::updateValue('HI_FB_LOGIN_PAGE', 'no_redirect')
			|| !Configuration::updateValue('HI_FB_ON', false)
			|| !Configuration::updateValue('HI_FB_APP_ID', '')
		)
			return false;
		
		return true;
	}

	public function uninstall(){
		if (!parent::uninstall())
			return false;
			$this->dropFbTable();
			$this->_deleteTab();
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
        $tab->class_name = "AdminNrtFacebookConnect";
        $tab->name = array();
        foreach (Language::getLanguages() as $lang) {
            $tab->name[$lang['id_lang']] = "Manage Facebook Connect";
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
        $id_tab = Tab::getIdFromClassName('AdminNrtFacebookConnect');
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
	private function createFbTable (){
		$sql = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'nrtfacebookusers` (
		   `id`            INT NOT NULL AUTO_INCREMENT,
		   `id_user`       VARCHAR (100) NOT NULL,
		   `id_shop_group` INT (11) NOT NULL,
		   `id_shop`       INT (11) NOT NULL,
		   `first_name`    VARCHAR (100) NOT NULL,
		   `last_name`     VARCHAR (100) NOT NULL,
		   `email`         VARCHAR (100) NOT NULL,
		   `gender`        VARCHAR (100) NOT NULL,
		   `birthday`      DATE NOT NULL,
		   `date_add`      DATE NOT NULL,
		   `date_upd`      DATE NOT NULL,
		   PRIMARY KEY     ( `id` )
		) ENGINE = '._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;';
		return Db::getInstance()->Execute(trim($sql));
	}

	private function dropFbTable(){
		return DB::getInstance()->execute("DROP TABLE IF EXISTS "._DB_PREFIX_."nrtfacebookusers");
	}

	private function _globalVars(){
		$this->fb_login_page = Configuration::get('HI_FB_LOGIN_PAGE');
		$this->fb_on = (bool)Configuration::get('HI_FB_ON');
		$this->fb_app_id = Configuration::get('HI_FB_APP_ID');
	}
	
	private function isSelectedShopGroup(){
		if (Shop::getContext() == Shop::CONTEXT_GROUP || Shop::getContext() == Shop::CONTEXT_ALL)
			return true;
		else
			return false;
	}

	protected function isTableExists($table)
	{
		$sqlExistsTable = "SELECT * FROM information_schema.TABLES WHERE TABLE_SCHEMA=DATABASE()
			AND TABLE_NAME='" . _DB_PREFIX_ . $table . "'; ";
		$exists = Db::getInstance()->ExecuteS($sqlExistsTable);
		return !empty($exists);
	}

	public function _displayForm(){		
		$html = $this->error;
		$html .= $this->generateAdminPage();
		return $html;
	}

	private function generateAdminPage(){
		$this->context->smarty->assign(array(
			'action' => Tools::safeOutput($_SERVER['REQUEST_URI']),
			'hi_fb_on' => $this->fb_on,
			'hi_fb_app_id' => $this->fb_app_id,
			'hi_login_page' => $this->fb_login_page
		));
		return $this->display(__FILE__, 'views/templates/admin/admin.tpl');
	}

	private function _postProcess(){
		Configuration::updateValue('HI_FB_LOGIN_PAGE', Tools::getValue('hi_fb_login_page'));
		Configuration::updateValue('HI_FB_ON', (bool)Tools::getValue('hi_fb_on'));
		Configuration::updateValue('HI_FB_APP_ID', trim(Tools::getValue('hi_fb_app_id')));
	}

	public function getContent(){
		$html = "";
		if (Tools::isSubmit('hi_fb_submit'))
			$this->_postProcess();

		$this->_globalVars();
		
		if (!$this->isSelectedShopGroup()){	
			$html .= $this->_displayForm();
		}else{
			$html .= '
				<p class="alert alert-warning">'.
					$this->l('You cannot manage the module from a "All Shops" or a "Group Shop" context, select directly the shop you want to edit').'
				</p>';
		}	
		return $html;
	}

	public function prepareHooks(){
		$fb_enable = false;
		
		// is Facebook active
		if ($this->fb_on && $this->fb_app_id && !$this->context->customer->isLogged())
			$fb_enable = true;

		$this->context->smarty->assign(array(
			'hi_fb_on' => $fb_enable,
			'hi_login_page' => $this->fb_login_page
		));
	}

	public function hookHeader(){
		Media::addJsDef(array('baseDir' => $this->context->shop->getBaseURL(true, true)));
		Media::addJsDef(array('no_email' => 'Facebook does not exist email address ! Please update your full information before signing in .'));
		$fb_enable = false;
		
		if ($this->fb_on && $this->fb_app_id && !$this->context->customer->isLogged())
			$fb_enable = true;
		
		$this->context->smarty->assign(array(
			'hi_fb_on' => $fb_enable,
			'hi_fb_app_id' => $this->fb_app_id,
			'hi_fb_login_page' => $this->fb_login_page
		));				
		return $this->display(__FILE__,'header.tpl');
	}
	
	public function hookFacebookconnect(){
		$this->prepareHooks();
		return $this->display(__FILE__,'facebookCustomHook.tpl');
	}
	
	public function sendConfirmationMail(Customer $customer, $password){
		if (!Configuration::get('PS_CUSTOMER_CREATION_EMAIL'))
			return true;
		return Mail::Send(
			$this->context->language->id,
			'account',
			Mail::l('Welcome!'),
			array(
				'{firstname}' => $customer->firstname,
				'{lastname}' => $customer->lastname,
				'{email}' => $customer->email,
				'{passwd}' => $password),
			$customer->email,
			$customer->firstname.' '.$customer->lastname
		);
	}
	
    public function renderWidget($hookName, array $params)
    {
	   $this->prepareHooks();
       $this->smarty->assign($this->getWidgetVariables($hookName, $params));
       return $this->fetch($this->templateFile);
    }

    public function getWidgetVariables($hookName, array $params)
    {
		return true;	
    }
		
}