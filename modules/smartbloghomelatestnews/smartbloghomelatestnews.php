<?php
if (!defined('_PS_VERSION_'))
    exit;
 
require_once (_PS_MODULE_DIR_.'smartblog/classes/SmartBlogPost.php');
require_once (_PS_MODULE_DIR_.'smartblog/smartblog.php');
class smartbloghomelatestnews extends Module {
    
     public function __construct(){
        $this->name = 'smartbloghomelatestnews';
        $this->tab = 'front_office_features';
        $this->version = '2.0.1';
        $this->bootstrap = true;
        $this->author = 'SmartDataSoft';
        $this->secure_key = Tools::encrypt($this->name);

        parent::__construct();

        $this->displayName = $this->l('SmartBlog Home Latest');
        $this->description = $this->l('The Most Powerfull Presta shop Blog  Module\'s tag - by smartdatasoft');
        $this->confirmUninstall = $this->l('Are you sure you want to delete your details ?');
        }
        
     public function install(){
                $langs = Language::getLanguages();
                $id_lang = (int) Configuration::get('PS_LANG_DEFAULT');
                 if (!parent::install() 
				 || !$this->registerHook('header')	
				 || !$this->registerHook('smartbloghomelatestnews')				 
				 )
            	return false;
	 			$this->_createConfigs();
                 return true;
            }
			
     public function uninstall() {
	 $this->DeleteCache();
	 $this->_deleteConfigs();
            if (!parent::uninstall())
                 return false;
            return true;
                }
        /* ------------------------------------------------------------- */
        /*  CREATE CONFIGS
        /* ------------------------------------------------------------- */
        private function _createConfigs()
        {
            $languages = $this->context->language->getLanguages();

            foreach ($languages as $language){
                $title[$language['id_lang']] = 'smartbloghomelatestnews';
            }
            foreach ($languages as $language){
                $href[$language['id_lang']] = '';
            }
            foreach ($languages as $language){
                $title_small[$language['id_lang']] = '';
            }
            $response = Configuration::updateValue('NRT_SMARTBLOG_NBR', 6);
            $response &= Configuration::updateValue('NRT_SMARTBLOG_TITLE', $title);
			$response &= Configuration::updateValue('NRT_SMARTBLOG_TITLE_LINK', $href);
			$response &= Configuration::updateValue('NRT_SMARTBLOG_TITLE_SMALL', $title_small);
            $response &= Configuration::updateValue('NRT_SMARTBLOG_VERTICAL', 1);
            $response &= Configuration::updateValue('NRT_SMARTBLOG_COLUMNITEM', 1);
            $response &= Configuration::updateValue('NRT_SMARTBLOG_MAXITEM', 3);
            $response &= Configuration::updateValue('NRT_SMARTBLOG_MEDIUMITEM', 2);
            $response &= Configuration::updateValue('NRT_SMARTBLOG_MINITEM', 1);
            $response &= Configuration::updateValue('NRT_SMARTBLOG_AUTOSCROLL', 0);
            $response &= Configuration::updateValue('NRT_SMARTBLOG_PAUSEONHOVER', 0);
            $response &= Configuration::updateValue('NRT_SMARTBLOG_PAGINATION', 0);
            $response &= Configuration::updateValue('NRT_SMARTBLOG_NAVIGATION', 1);
            $response &= Configuration::updateValue('NRT_SMARTBLOG_LAZYLOAD', 1);

            return $response;
        }
        
        /* ------------------------------------------------------------- */
        /*  DELETE CONFIGS
        /* ------------------------------------------------------------- */
        private function _deleteConfigs()
        {
            $response = Configuration::deleteByName('NRT_SMARTBLOG_TITLE');
			$response &= Configuration::deleteByName('NRT_SMARTBLOG_TITLE_LINK');
			$response &= Configuration::deleteByName('NRT_SMARTBLOG_TITLE_SMALL');
            $response &= Configuration::deleteByName('NRT_SMARTBLOG_VERTICAL');
            $response &= Configuration::deleteByName('NRT_SMARTBLOG_COLUMNITEM');
            $response &= Configuration::deleteByName('NRT_SMARTBLOG_MAXITEM');
            $response &= Configuration::deleteByName('NRT_SMARTBLOG_MEDIUMITEM');
            $response &= Configuration::deleteByName('NRT_SMARTBLOG_MINITEM');
            $response &= Configuration::deleteByName('NRT_SMARTBLOG_AUTOSCROLL');
            $response &= Configuration::deleteByName('NRT_SMARTBLOG_PAGINATION');
            $response &= Configuration::deleteByName('NRT_SMARTBLOG_NAVIGATION');
            $response &= Configuration::deleteByName('NRT_SMARTBLOG_PAUSEONHOVER');
            $response &= Configuration::deleteByName('NRT_SMARTBLOG_NBR');
            $response &= Configuration::deleteByName('NRT_SMARTBLOG_LAZYLOAD');

            return $response;
        }

/* ------------------------------------------------------------- */
    /*  CREATE THE TAB MENU
    /* ------------------------------------------------------------- */
    private function _createTab()
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
			$parentTab_2ID = Tab::getIdFromClassName('AdminSmartBlog');
			if ($parentTab_2ID) {
				$parentTab_2 = new Tab($parentTab_2ID);
			}
			else {
				$parentTab_2 = new Tab();
				$parentTab_2->active = 1;
				$parentTab_2->name = array();
				$parentTab_2->class_name = "AdminSmartBlog";
				foreach (Language::getLanguages() as $lang) {
					$parentTab_2->name[$lang['id_lang']] = "SmartBlog Configure";
				}
				$parentTab_2->id_parent = $parentTab->id;
				$parentTab_2->module = '';
				$response &= $parentTab_2->add();
			}
			// Created tab
        $tab = new Tab();
        $tab->active = 1;
        $tab->class_name = "AdminSmartBlogHomeLate";
        $tab->name = array();
        foreach (Language::getLanguages() as $lang) {
            $tab->name[$lang['id_lang']] = "SmartBlog Home Lates";
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
        $id_tab = Tab::getIdFromClassName('AdminSmartBlogHomeLate');
        $parentTabID = Tab::getIdFromClassName('AdminNrtMenu');

        $tab = new Tab($id_tab);
        $tab->delete();
		// Get the number of tabs inside our parent tab
        // If there is no tabs, remove the parent
		$parentTab_2ID = Tab::getIdFromClassName('AdminSmartBlog');
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
    public function hookHeader($params)
	{
		$image_types = BlogImageType::GetImageAll();
		 foreach($image_types as $image_type){
		$this->smarty->assign('size_'.str_replace('-','_',$image_type['type_name']).'_'.$image_type['type'],$image_type);
                }
	}
	public function hookSmartbloghomelatestnews($params)
	{	
                if(Module::isInstalled('smartblog') != 1){
                        $this->smarty->assign( array(
                                  'smartmodname' => $this->name
                         ));
                        return $this->display(__FILE__, 'views/templates/front/install_required.tpl');
                }
                else
                {
                            if (!$this->isCached('smartblog_latest_news.tpl', $this->getCacheId()))
                                {
                                    $view_data['posts'] = SmartBlogPost::GetPostLatestHome(Configuration::get('NRT_SMARTBLOG_NBR')); 
                                    $this->smarty->assign( array(
                                              'view_data'     	 => $view_data['posts']
                                    ));
						 $id_default_lang = $this->context->language->id;
						$nodecontent = array(
							'title' => Configuration::get('NRT_SMARTBLOG_TITLE', $id_default_lang),
							'href' => Configuration::get('NRT_SMARTBLOG_TITLE_LINK', $id_default_lang),
							'legend' => Configuration::get('NRT_SMARTBLOG_TITLE_SMALL', $id_default_lang),
							'colnb' => Configuration::get('NRT_SMARTBLOG_COLUMNITEM'),
							'line_md' => Configuration::get('NRT_SMARTBLOG_MAXITEM'),
							'line_sm' => Configuration::get('NRT_SMARTBLOG_MEDIUMITEM'),
							'line_xs' => Configuration::get('NRT_SMARTBLOG_MINITEM'),
							'ap' => Configuration::get('NRT_SMARTBLOG_AUTOSCROLL'),
							'dt' => Configuration::get('NRT_SMARTBLOG_PAGINATION'),
							'ar' => Configuration::get('NRT_SMARTBLOG_NAVIGATION'),
							'line_ms' => Configuration::get('NRT_SMARTBLOG_PAUSEONHOVER'),
							'line_lg' => Configuration::get('NRT_SMARTBLOG_LAZYLOAD'),
							'view' => Configuration::get('NRT_SMARTBLOG_VERTICAL')
						);
					
						$this->smarty->assign('nodecontent', $nodecontent);
									
									
                                }
                            return $this->display(__FILE__, 'views/templates/front/smartblog_latest_news.tpl', $this->getCacheId());
                }  
            }
            
     public function getContent(){
                $languages = $this->context->language->getLanguages();
		$output = '';
                
		if (Tools::isSubmit('submit'.$this->name))
		{
			$title = array();
			$title_link = array();
			$title_small = array();

                        foreach ($languages as $language){
                            if (Tools::isSubmit('NRT_SMARTBLOG_TITLE_'.$language['id_lang'])){
                                $title[$language['id_lang']] = Tools::getValue('NRT_SMARTBLOG_TITLE_'.$language['id_lang']);
                            }
                        }
                        if (isset($title) && $title){
                            Configuration::updateValue('NRT_SMARTBLOG_TITLE', $true);
                        }
                        foreach ($languages as $language){
                            if (Tools::isSubmit('NRT_SMARTBLOG_TITLE_LINK_'.$language['id_lang'])){
                                $title_link[$language['id_lang']] = Tools::getValue('NRT_SMARTBLOG_TITLE_LINK_'.$language['id_lang']);
                            }
                        }
                        if (isset($title_link) && $title_link){
                            Configuration::updateValue('NRT_SMARTBLOG_TITLE_LINK', $title_link);
                        }
                        foreach ($languages as $language){
                            if (Tools::isSubmit('NRT_SMARTBLOG_TITLE_SMALL_'.$language['id_lang'])){
                                $title_small[$language['id_lang']] = Tools::getValue('NRT_SMARTBLOG_TITLE_SMALL_'.$language['id_lang']);
                            }
                        }
                        if (isset($title_small) && $title_small){
                            Configuration::updateValue('NRT_SMARTBLOG_TITLE_SMALL', $title_small);
                        }
                        if (Tools::isSubmit('NRT_SMARTBLOG_VERTICAL')){
                            Configuration::updateValue('NRT_SMARTBLOG_VERTICAL', Tools::getValue('NRT_SMARTBLOG_VERTICAL'));
                        }
                        if (Tools::isSubmit('NRT_SMARTBLOG_AUTOSCROLL')){
                            Configuration::updateValue('NRT_SMARTBLOG_AUTOSCROLL', (int)Tools::getValue('NRT_SMARTBLOG_AUTOSCROLL'));
                        }
                        if (Tools::isSubmit('NRT_SMARTBLOG_PAUSEONHOVER')){
                            Configuration::updateValue('NRT_SMARTBLOG_PAUSEONHOVER', (int)Tools::getValue('NRT_SMARTBLOG_PAUSEONHOVER'));
                        }
                        if (Tools::isSubmit('NRT_SMARTBLOG_PAGINATION')){
                            Configuration::updateValue('NRT_SMARTBLOG_PAGINATION', (int)Tools::getValue('NRT_SMARTBLOG_PAGINATION'));
                        }
                        if (Tools::isSubmit('NRT_SMARTBLOG_NAVIGATION')){
                            Configuration::updateValue('NRT_SMARTBLOG_NAVIGATION', (int)Tools::getValue('NRT_SMARTBLOG_NAVIGATION'));
                        }
                        if (Tools::isSubmit('NRT_SMARTBLOG_LAZYLOAD')){
                            Configuration::updateValue('NRT_SMARTBLOG_LAZYLOAD', (int)Tools::getValue('NRT_SMARTBLOG_LAZYLOAD'));
                        }
                        if (Tools::isSubmit('NRT_SMARTBLOG_MAXITEM') || Tools::isSubmit('NRT_SMARTBLOG_MEDIUMITEM') || Tools::isSubmit('NRT_SMARTBLOG_MINITEM') || Tools::isSubmit('NRT_SMARTBLOG_NBR') || Tools::isSubmit('NRT_SMARTBLOG_COLUMNITEM')){
                            if (Validate::isInt(Tools::getValue('NRT_SMARTBLOG_MAXITEM')) && Validate::isInt(Tools::getValue('NRT_SMARTBLOG_MEDIUMITEM')) && Validate::isInt(Tools::getValue('NRT_SMARTBLOG_MINITEM')) && Validate::isInt(Tools::getValue('NRT_SMARTBLOG_NBR')) && Validate::isInt(Tools::getValue('NRT_SMARTBLOG_COLUMNITEM'))){
                                Configuration::updateValue('NRT_SMARTBLOG_COLUMNITEM', Tools::getValue('NRT_SMARTBLOG_COLUMNITEM'));
                                Configuration::updateValue('NRT_SMARTBLOG_MAXITEM', Tools::getValue('NRT_SMARTBLOG_MAXITEM'));
                                Configuration::updateValue('NRT_SMARTBLOG_MEDIUMITEM', Tools::getValue('NRT_SMARTBLOG_MEDIUMITEM'));
                                Configuration::updateValue('NRT_SMARTBLOG_MINITEM', Tools::getValue('NRT_SMARTBLOG_MINITEM'));
                                Configuration::updateValue('NRT_SMARTBLOG_NBR', Tools::getValue('NRT_SMARTBLOG_NBR'));
                            } else {
                                $errors[] = $this->l('value must be a numeric value!');
                            }
                        }
                        if (isset($errors) && count($errors))
                            $output .= $this->displayError(implode('<br />', $errors));
                        else
                            $output .= $this->displayConfirmation($this->l('Settings updated'));
		}
		return $output.$this->renderForm();
	}
            
     public function renderForm() {
                $id_default_lang = $this->context->language->id;
                $languages = $this->context->language->getLanguages();
       
	   
        $ad_row = array(
		array('value'=>'1'),
	    array('value'=>'2'),
		array('value'=>'3'),
		array('value'=>'4'),
		array('value'=>'5'),
		array('value'=>'6'),
		array('value'=>'7'),
		array('value'=>'8'),
		array('value'=>'9'),
		array('value'=>'10')
        );
		
        $yes_no = array(
		array('value'=>'0','name'=>'No'),
		array('value'=>'1','name'=>'Yes')
        );
		$type_display= array(
		array('value'=>'1','name'=>'Slider - info below big image'),
		array('value'=>'2','name'=>'Slider - info next to small image')
        );
		$arrows= array(
		array('value'=>'0','name'=>'In middle of slider'),
		array('value'=>'1','name'=>'Above slider(on column title)'),
		array('value'=>'2','name'=>'Hide')
        );		
		$fields_form = array(
			'form' => array(
				'legend' => array(
					'title' => $this->l('Settings'),
					'icon' => 'icon-cogs'
				),
				'input' => array(
					array(
							'type' => 'text',
							'name' => 'NRT_SMARTBLOG_TITLE',
							'label' => $this->l('Title'),
							'required' => false,
							'lang' => true,
					),
					array(
							'type' => 'text',
							'name' => 'NRT_SMARTBLOG_TITLE_LINK',
							'label' => $this->l('Title link'),
							'required' => false,
							'lang' => true,
					),
					array(
							'type' => 'text',
							'name' => 'NRT_SMARTBLOG_TITLE_SMALL',
							'label' => $this->l('Title small'),
							'required' => false,
							'lang' => true,
					),
					array(
						'type' => 'text',
						'label' => $this->l('Total products to display'),
						'name' => 'NRT_SMARTBLOG_NBR',
						'required' => true,
						'class' => 'fixed-width-xxl',
						'desc' => $this->l('Define the number of products to be displayed in this block on home page.')
					),
					array(
						'type' => 'hidden',
						'name' => 'NRT_SMARTBLOG_VERTICAL',
						'label' => $this->l('View type'),
						'class' => 'fixed-width-xxl',
						'required' => false,
						'options' => array(
							'query' => $type_display,
							'id' => 'value',
							'name' => 'name'
						)
					),
					array(
						'type' => 'select',
						'name' => 'NRT_SMARTBLOG_COLUMNITEM',
						'label' => $this->l('Products per column'),
						'class' => 'fixed-width-xxl',
						'required' => false,
						'options' => array(
						'query' => $ad_row,
						'id' => 'value',
						'name' => 'value'
						)
					),
					array(
						'type' => 'select',
						'name' => 'NRT_SMARTBLOG_MAXITEM',
						'label' => $this->l('Products per line - desktop'),
						'class' => 'fixed-width-xxl',
						'required' => false,
						'options' => array(
						'query' => $ad_row,
						'id' => 'value',
						'name' => 'value'
						)
						),
					array(
						'type' => 'select',
						'name' => 'NRT_SMARTBLOG_MEDIUMITEM',
						'label' => $this->l('Products per line - tablet'),
						'class' => 'fixed-width-xxl',
						'required' => false,
						'options' => array(
						'query' => $ad_row,
						'id' => 'value',
						'name' => 'value'
						)
						),
					array(
						'type' => 'select',
						'name' => 'NRT_SMARTBLOG_MINITEM',
						'label' => $this->l('Products per line - phone'),
						'class' => 'fixed-width-xxl',
						'required' => false,
						'options' => array(
						'query' => $ad_row,
						'id' => 'value',
						'name' => 'value'
						)
					),
					array(
						'type' => 'select',
						'name' => 'NRT_SMARTBLOG_AUTOSCROLL',
						'label' => $this->l('Auto scroll'),
						'class' => 'fixed-width-xxl',
						'required' => false,
						'options' => array(
						'query' => $yes_no,
						'id' => 'value',
						'name' => 'name'
						)
					),
					array(
						'type' => 'select',
						'name' => 'NRT_SMARTBLOG_LAZYLOAD',
						'label' => $this->l('Lazy load'),
						'class' => 'fixed-width-xxl',
						'required' => false,
						'options' => array(
						'query' => $yes_no,
						'id' => 'value',
						'name' => 'name'
						)
					),
					array(
						'type' => 'select',
						'name' => 'NRT_SMARTBLOG_PAUSEONHOVER',
						'label' => $this->l('Loop'),
						'class' => 'fixed-width-xxl',
						'required' => false,
						'options' => array(
						'query' => $yes_no,
						'id' => 'value',
						'name' => 'name'
						)
					),
					array(
						'type' => 'select',
						'name' => 'NRT_SMARTBLOG_NAVIGATION',
						'label' => $this->l('Slider arrows'),
						'class' => 'fixed-width-xxl',
						'required' => false,
						'options' => array(
						'query' => $arrows,
						'id' => 'value',
						'name' => 'name'
						)
					),
					array(
						'type' => 'select',
						'name' => 'NRT_SMARTBLOG_PAGINATION',
						'label' => $this->l('Slider dots'),
						'class' => 'fixed-width-xxl',
						'required' => false,
						'options' => array(
						'query' => $yes_no,
						'id' => 'value',
						'name' => 'name'
						)
					)
				),
				'submit' => array(
					'title' => $this->l('Save'),
				)
			),
		);

		$helper = new HelperForm();
		$helper->module = $this;
                $helper->name_controller = $this->name;
                $helper->token = Tools::getAdminTokenLite('AdminModules');
                $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;

                $helper->default_form_language = $id_default_lang;
                $helper->allow_employee_form_lang = $id_default_lang;

                $helper->title = $this->displayName;
                $helper->show_toolbar = true;
                $helper->toolbar_scroll = true;
                $helper->submit_action = 'submit'.$this->name;

                foreach($languages as $language){
                    $helper->languages[] = array(
                        'id_lang' => $language['id_lang'],
                        'iso_code' => $language['iso_code'],
                        'name' => $language['name'],
                        'is_default' => ($id_default_lang == $language['id_lang'] ? 1 : 0)
                    );
                }

                // Load current values
                $helper->fields_value['NRT_SMARTBLOG_VERTICAL'] = Configuration::get('NRT_SMARTBLOG_VERTICAL');
                $helper->fields_value['NRT_SMARTBLOG_COLUMNITEM'] = Configuration::get('NRT_SMARTBLOG_COLUMNITEM');
                $helper->fields_value['NRT_SMARTBLOG_MAXITEM'] = Configuration::get('NRT_SMARTBLOG_MAXITEM');
                $helper->fields_value['NRT_SMARTBLOG_MEDIUMITEM'] = Configuration::get('NRT_SMARTBLOG_MEDIUMITEM');
                $helper->fields_value['NRT_SMARTBLOG_MINITEM'] = Configuration::get('NRT_SMARTBLOG_MINITEM');
                $helper->fields_value['NRT_SMARTBLOG_AUTOSCROLL'] = Configuration::get('NRT_SMARTBLOG_AUTOSCROLL');
                $helper->fields_value['NRT_SMARTBLOG_PAUSEONHOVER'] = Configuration::get('NRT_SMARTBLOG_PAUSEONHOVER');
                $helper->fields_value['NRT_SMARTBLOG_PAGINATION'] = Configuration::get('NRT_SMARTBLOG_PAGINATION');
                $helper->fields_value['NRT_SMARTBLOG_NAVIGATION'] = Configuration::get('NRT_SMARTBLOG_NAVIGATION');
                $helper->fields_value['NRT_SMARTBLOG_NBR'] = Configuration::get('NRT_SMARTBLOG_NBR');
                $helper->fields_value['NRT_SMARTBLOG_LAZYLOAD'] = Configuration::get('NRT_SMARTBLOG_LAZYLOAD');

                foreach($languages as $language){
                    $helper->fields_value['NRT_SMARTBLOG_TITLE'][$language['id_lang']] = Configuration::get('NRT_SMARTBLOG_TITLE', $language['id_lang']);
                }

                foreach($languages as $language){
                    $helper->fields_value['NRT_SMARTBLOG_TITLE_LINK'][$language['id_lang']] = Configuration::get('NRT_SMARTBLOG_TITLE_LINK', $language['id_lang']);
                }
                foreach($languages as $language){
                    $helper->fields_value['NRT_SMARTBLOG_TITLE_SMALL'][$language['id_lang']] = Configuration::get('NRT_SMARTBLOG_TITLE_SMALL', $language['id_lang']);
                }
		return $helper->generateForm(array($fields_form));
	}
	public function DeleteCache()
            {
				return $this->_clearCache('smartblog_latest_news.tpl', $this->getCacheId());
			}
	public function hookactionsbdeletepost($params)
            {
                 return $this->DeleteCache();
            }
	public function hookactionsbnewpost($params)
            {
                 return $this->DeleteCache();
            }
	public function hookactionsbupdatepost($params)
            {
                return $this->DeleteCache();
            }
	public function hookactionsbtogglepost($params)
            {
                return $this->DeleteCache();
            }
	private function _installHookCustomer(){
	   $hooksfield = array(
			   'smartBlogHomePost'
		   ); 
	   foreach( $hooksfield as $hook ){
		   if( Hook::getIdByName($hook) ){

		   } else {
			   $new_hook = new Hook();
			   $new_hook->name = pSQL($hook);
			   $new_hook->title = pSQL($hook);
			   $new_hook->add();
			   $id_hook = $new_hook->id;
		   }
	   }
	   return true;
	}
}