<?php
/*
*  2015 AxonVIP
*
*  @author AxonVIP <AxonVIP@gmail.com>
*/

if (!defined('_PS_VERSION_'))
	exit;
use PrestaShop\PrestaShop\Core\Module\WidgetInterface;
use PrestaShop\PrestaShop\Adapter\Image\ImageRetriever;
use PrestaShop\PrestaShop\Adapter\Product\PriceFormatter;
use PrestaShop\PrestaShop\Core\Product\ProductListingPresenter;
use PrestaShop\PrestaShop\Adapter\Product\ProductColorsRetriever;
use PrestaShop\PrestaShop\Adapter\BestSales\BestSalesProductSearchProvider;
use PrestaShop\PrestaShop\Core\Product\Search\ProductSearchContext;
use PrestaShop\PrestaShop\Core\Product\Search\ProductSearchQuery;
use PrestaShop\PrestaShop\Core\Product\Search\SortOrder;
class NrtBestSellers extends Module
{
	public function __construct()
	{
		$this->name = 'nrtbestsellers';
		$this->tab = 'front_office_features';
		$this->version = '1.0';
		$this->author = 'AxonVIP';
		$this->need_instance = 0;
		$this->bootstrap = true;

		parent::__construct();

		$this->displayName = $this->l('Bestsellers');
		$this->description = $this->l('Adds a slider displaying bestseller products.');
		$this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
	}

	public function install()
	{
		$this->_clearCache('*');

		if (!parent::install()
			|| !$this->registerHook('bestsellers')
			|| !$this->registerHook('header')
			|| !ProductSale::fillProductSales()
		)
			return false;
                        $this->_createConfigs();
                        $this->_createTab();                        
		return true;
	}

	public function uninstall()
	{
		$this->_clearCache('*');
                $this->_deleteConfigs();
                $this->_deleteTab();
                
		return parent::uninstall();
	}
       /* ------------------------------------------------------------- */
        /*  CREATE CONFIGS
        /* ------------------------------------------------------------- */
        private function _createConfigs()
        {
            $languages = $this->context->language->getLanguages();

            foreach ($languages as $language){
                $title[$language['id_lang']] = 'Bestseller';
            }
            foreach ($languages as $language){
                $href[$language['id_lang']] = '';
            }
            foreach ($languages as $language){
                $title_small[$language['id_lang']] = '';
            }
            $response = Configuration::updateValue('NRT_BESTSELLERS_NBR', 6);
            $response &= Configuration::updateValue('NRT_BESTSELLERS_TITLE', $title);
			$response &= Configuration::updateValue('NRT_BESTSELLERS_TITLE_LINK', $href);
			$response &= Configuration::updateValue('NRT_BESTSELLERS_TITLE_SMALL', $title_small);
            $response &= Configuration::updateValue('NRT_BESTSELLERS_VERTICAL', 1);
            $response &= Configuration::updateValue('NRT_BESTSELLERS_COLUMNITEM', 1);
            $response &= Configuration::updateValue('NRT_BESTSELLERS_MAXITEM', 1);
            $response &= Configuration::updateValue('NRT_BESTSELLERS_MEDIUMITEM', 1);
            $response &= Configuration::updateValue('NRT_BESTSELLERS_MINITEM', 1);
            $response &= Configuration::updateValue('NRT_BESTSELLERS_AUTOSCROLL', 0);
            $response &= Configuration::updateValue('NRT_BESTSELLERS_PAUSEONHOVER', 0);
            $response &= Configuration::updateValue('NRT_BESTSELLERS_PAGINATION', 0);
            $response &= Configuration::updateValue('NRT_BESTSELLERS_NAVIGATION', 2);
            $response &= Configuration::updateValue('NRT_BESTSELLERS_LAZYLOAD', 1);

            return $response;
        }
        
        /* ------------------------------------------------------------- */
        /*  DELETE CONFIGS
        /* ------------------------------------------------------------- */
        private function _deleteConfigs()
        {
            $response = Configuration::deleteByName('NRT_BESTSELLERS_TITLE');
			$response &= Configuration::deleteByName('NRT_BESTSELLERS_TITLE_LINK');
			$response &= Configuration::deleteByName('NRT_BESTSELLERS_TITLE_SMALL');
            $response &= Configuration::deleteByName('NRT_BESTSELLERS_VERTICAL');
            $response &= Configuration::deleteByName('NRT_BESTSELLERS_COLUMNITEM');
            $response &= Configuration::deleteByName('NRT_BESTSELLERS_MAXITEM');
            $response &= Configuration::deleteByName('NRT_BESTSELLERS_MEDIUMITEM');
            $response &= Configuration::deleteByName('NRT_BESTSELLERS_MINITEM');
            $response &= Configuration::deleteByName('NRT_BESTSELLERS_AUTOSCROLL');
            $response &= Configuration::deleteByName('NRT_BESTSELLERS_PAGINATION');
            $response &= Configuration::deleteByName('NRT_BESTSELLERS_NAVIGATION');
            $response &= Configuration::deleteByName('NRT_BESTSELLERS_PAUSEONHOVER');
            $response &= Configuration::deleteByName('NRT_BESTSELLERS_NBR');
            $response &= Configuration::deleteByName('NRT_BESTSELLERS_LAZYLOAD');

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
            } else {
                $parentTab = new Tab();
                $parentTab->active = 1;
                $parentTab->name = array();
                $parentTab->class_name = "AdminNrtMenu";
                foreach (Language::getLanguages() as $lang){
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
            $tab->class_name = "AdminNrtTopSellers";
            $tab->name = array();
            foreach (Language::getLanguages() as $lang){
                $tab->name[$lang['id_lang']] = "Manage Bestsellers";
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
            $id_tab = Tab::getIdFromClassName('AdminNrtTopSellers');
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
            if ($tabCount == 0){
                $parentTab = new Tab($parentTabID);
                $parentTab->delete();
            }

            return true;
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

	public function hookActionOrderStatusPostUpdate($params)
	{
		$this->_clearCache('*');
	}
     
	public function getContent()
	{
                $languages = $this->context->language->getLanguages();
		$output = '';
                
		if (Tools::isSubmit('submit'.$this->name))
		{
			$title = array();
			$title_link = array();
			$title_small = array();

                        foreach ($languages as $language){
                            if (Tools::isSubmit('NRT_BESTSELLERS_TITLE_'.$language['id_lang'])){
                                $title[$language['id_lang']] = Tools::getValue('NRT_BESTSELLERS_TITLE_'.$language['id_lang']);
                            }
                        }
                        if (isset($title) && $title){
                            Configuration::updateValue('NRT_BESTSELLERS_TITLE', $title);
                        }
                        foreach ($languages as $language){
                            if (Tools::isSubmit('NRT_BESTSELLERS_TITLE_LINK_'.$language['id_lang'])){
                                $title_link[$language['id_lang']] = Tools::getValue('NRT_BESTSELLERS_TITLE_LINK_'.$language['id_lang']);
                            }
                        }
                        if (isset($title_link) && $title_link){
                            Configuration::updateValue('NRT_BESTSELLERS_TITLE_LINK', $title_link);
                        }
                        foreach ($languages as $language){
                            if (Tools::isSubmit('NRT_BESTSELLERS_TITLE_SMALL_'.$language['id_lang'])){
                                $title_small[$language['id_lang']] = Tools::getValue('NRT_BESTSELLERS_TITLE_SMALL_'.$language['id_lang']);
                            }
                        }
                        if (isset($title_small) && $title_small){
                            Configuration::updateValue('NRT_BESTSELLERS_TITLE_SMALL', $title_small);
                        }
                        if (Tools::isSubmit('NRT_BESTSELLERS_VERTICAL')){
                            Configuration::updateValue('NRT_BESTSELLERS_VERTICAL', Tools::getValue('NRT_BESTSELLERS_VERTICAL'));
                        }
                        if (Tools::isSubmit('NRT_BESTSELLERS_AUTOSCROLL')){
                            Configuration::updateValue('NRT_BESTSELLERS_AUTOSCROLL', (int)Tools::getValue('NRT_BESTSELLERS_AUTOSCROLL'));
                        }
                        if (Tools::isSubmit('NRT_BESTSELLERS_PAUSEONHOVER')){
                            Configuration::updateValue('NRT_BESTSELLERS_PAUSEONHOVER', (int)Tools::getValue('NRT_BESTSELLERS_PAUSEONHOVER'));
                        }
                        if (Tools::isSubmit('NRT_BESTSELLERS_PAGINATION')){
                            Configuration::updateValue('NRT_BESTSELLERS_PAGINATION', (int)Tools::getValue('NRT_BESTSELLERS_PAGINATION'));
                        }
                        if (Tools::isSubmit('NRT_BESTSELLERS_NAVIGATION')){
                            Configuration::updateValue('NRT_BESTSELLERS_NAVIGATION', (int)Tools::getValue('NRT_BESTSELLERS_NAVIGATION'));
                        }
                        if (Tools::isSubmit('NRT_BESTSELLERS_LAZYLOAD')){
                            Configuration::updateValue('NRT_BESTSELLERS_LAZYLOAD', (int)Tools::getValue('NRT_BESTSELLERS_LAZYLOAD'));
                        }
                        if (Tools::isSubmit('NRT_BESTSELLERS_MAXITEM') || Tools::isSubmit('NRT_BESTSELLERS_MEDIUMITEM') || Tools::isSubmit('NRT_BESTSELLERS_MINITEM') || Tools::isSubmit('NRT_BESTSELLERS_NBR') || Tools::isSubmit('NRT_BESTSELLERS_COLUMNITEM')){
                            if (Validate::isInt(Tools::getValue('NRT_BESTSELLERS_MAXITEM')) && Validate::isInt(Tools::getValue('NRT_BESTSELLERS_MEDIUMITEM')) && Validate::isInt(Tools::getValue('NRT_BESTSELLERS_MINITEM')) && Validate::isInt(Tools::getValue('NRT_BESTSELLERS_NBR')) && Validate::isInt(Tools::getValue('NRT_BESTSELLERS_COLUMNITEM'))){
                                Configuration::updateValue('NRT_BESTSELLERS_COLUMNITEM', Tools::getValue('NRT_BESTSELLERS_COLUMNITEM'));
                                Configuration::updateValue('NRT_BESTSELLERS_MAXITEM', Tools::getValue('NRT_BESTSELLERS_MAXITEM'));
                                Configuration::updateValue('NRT_BESTSELLERS_MEDIUMITEM', Tools::getValue('NRT_BESTSELLERS_MEDIUMITEM'));
                                Configuration::updateValue('NRT_BESTSELLERS_MINITEM', Tools::getValue('NRT_BESTSELLERS_MINITEM'));
                                Configuration::updateValue('NRT_BESTSELLERS_NBR', Tools::getValue('NRT_BESTSELLERS_NBR'));
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
	
	public function renderForm()
	{
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
							'name' => 'NRT_BESTSELLERS_TITLE',
							'label' => $this->l('Title'),
							'required' => false,
							'lang' => true,
					),
					array(
							'type' => 'text',
							'name' => 'NRT_BESTSELLERS_TITLE_LINK',
							'label' => $this->l('Title link'),
							'required' => false,
							'lang' => true,
					),
					array(
							'type' => 'text',
							'name' => 'NRT_BESTSELLERS_TITLE_SMALL',
							'label' => $this->l('Title small'),
							'required' => false,
							'lang' => true,
					),
					array(
						'type' => 'text',
						'label' => $this->l('Total products to display'),
						'required' => true,
						'name' => 'NRT_BESTSELLERS_NBR',
						'class' => 'fixed-width-xxl',
						'desc' => $this->l('Define the number of products to be displayed in this block on home page.')
					),
					array(
						'type' => 'select',
						'name' => 'NRT_BESTSELLERS_VERTICAL',
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
						'name' => 'NRT_BESTSELLERS_COLUMNITEM',
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
						'name' => 'NRT_BESTSELLERS_MAXITEM',
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
						'name' => 'NRT_BESTSELLERS_MEDIUMITEM',
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
						'name' => 'NRT_BESTSELLERS_MINITEM',
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
						'name' => 'NRT_BESTSELLERS_AUTOSCROLL',
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
						'name' => 'NRT_BESTSELLERS_LAZYLOAD',
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
						'name' => 'NRT_BESTSELLERS_PAUSEONHOVER',
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
						'name' => 'NRT_BESTSELLERS_NAVIGATION',
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
						'name' => 'NRT_BESTSELLERS_PAGINATION',
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
                $helper->fields_value['NRT_BESTSELLERS_VERTICAL'] = Configuration::get('NRT_BESTSELLERS_VERTICAL');
                $helper->fields_value['NRT_BESTSELLERS_COLUMNITEM'] = Configuration::get('NRT_BESTSELLERS_COLUMNITEM');
                $helper->fields_value['NRT_BESTSELLERS_MAXITEM'] = Configuration::get('NRT_BESTSELLERS_MAXITEM');
                $helper->fields_value['NRT_BESTSELLERS_MEDIUMITEM'] = Configuration::get('NRT_BESTSELLERS_MEDIUMITEM');
                $helper->fields_value['NRT_BESTSELLERS_MINITEM'] = Configuration::get('NRT_BESTSELLERS_MINITEM');
                $helper->fields_value['NRT_BESTSELLERS_AUTOSCROLL'] = Configuration::get('NRT_BESTSELLERS_AUTOSCROLL');
                $helper->fields_value['NRT_BESTSELLERS_PAUSEONHOVER'] = Configuration::get('NRT_BESTSELLERS_PAUSEONHOVER');
                $helper->fields_value['NRT_BESTSELLERS_PAGINATION'] = Configuration::get('NRT_BESTSELLERS_PAGINATION');
                $helper->fields_value['NRT_BESTSELLERS_NAVIGATION'] = Configuration::get('NRT_BESTSELLERS_NAVIGATION');
                $helper->fields_value['NRT_BESTSELLERS_NBR'] = Configuration::get('NRT_BESTSELLERS_NBR');
                $helper->fields_value['NRT_BESTSELLERS_LAZYLOAD'] = Configuration::get('NRT_BESTSELLERS_LAZYLOAD');

                foreach($languages as $language){
                    $helper->fields_value['NRT_BESTSELLERS_TITLE'][$language['id_lang']] = Configuration::get('NRT_BESTSELLERS_TITLE', $language['id_lang']);
                }

                foreach($languages as $language){
                    $helper->fields_value['NRT_BESTSELLERS_TITLE_LINK'][$language['id_lang']] = Configuration::get('NRT_BESTSELLERS_TITLE_LINK', $language['id_lang']);
                }
                foreach($languages as $language){
                    $helper->fields_value['NRT_BESTSELLERS_TITLE_SMALL'][$language['id_lang']] = Configuration::get('NRT_BESTSELLERS_TITLE_SMALL', $language['id_lang']);
                }
		return $helper->generateForm(array($fields_form));
	}

	
protected function getProducts($params)
    {		
        if (Configuration::get('PS_CATALOG_MODE')) {
            return false;
        }

        $searchProvider = new BestSalesProductSearchProvider(
            $this->context->getTranslator()
        );

        $context = new ProductSearchContext($this->context);

        $query = new ProductSearchQuery();

        $nProducts = (int) Configuration::get('NRT_BESTSELLERS_TO_DISPLAY');

        $query
            ->setResultsPerPage($nProducts)
            ->setPage(1)
        ;

        $query->setSortOrder(SortOrder::random());

        $result = $searchProvider->runQuery(
            $context,
            $query
        );

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

        foreach ($result->getProducts() as $rawProduct) {
            $products_for_template[] = $presenter->present(
                $presentationSettings,
                $assembler->assembleProduct($rawProduct),
                $this->context->language
            );
        }

        return $products_for_template;
	} 
	/* ------------------------------------------------------------- */
        /*  PREPARE FOR HOOK
        /* ------------------------------------------------------------- */

        private function _prepHook($params)
        {
		$imagesTypes = ImageType::getImagesTypes('products');
		$images = array();

		   foreach ($imagesTypes as $image) {
				$images[$image['name']] = Image::getSize($image['name']);
				$images[$image['name']]['name'] = $image['name'];
			}
            $id_default_lang = $this->context->language->id;
			$products=$this->getProducts($params);
            $nodecontent = array(
                'title' => Configuration::get('NRT_BESTSELLERS_TITLE', $id_default_lang),
				'href' => Configuration::get('NRT_BESTSELLERS_TITLE_LINK', $id_default_lang),
				'legend' => Configuration::get('NRT_BESTSELLERS_TITLE_SMALL', $id_default_lang),
                'colnb' => Configuration::get('NRT_BESTSELLERS_COLUMNITEM'),
                'line_md' => Configuration::get('NRT_BESTSELLERS_MAXITEM'),
                'line_sm' => Configuration::get('NRT_BESTSELLERS_MEDIUMITEM'),
                'line_xs' => Configuration::get('NRT_BESTSELLERS_MINITEM'),
                'ap' => Configuration::get('NRT_BESTSELLERS_AUTOSCROLL'),
                'dt' => Configuration::get('NRT_BESTSELLERS_PAGINATION'),
                'ar' => Configuration::get('NRT_BESTSELLERS_NAVIGATION'),
                'line_ms' => Configuration::get('NRT_BESTSELLERS_PAUSEONHOVER'),
                'line_lg' => Configuration::get('NRT_BESTSELLERS_LAZYLOAD'),
				'view' => Configuration::get('NRT_BESTSELLERS_VERTICAL'),
				'products' => $products
            );

            $this->smarty->assign('nodecontent', $nodecontent);
			 $this->smarty->assign('images_types', $images);
        }
		
    public function hookBestsellers($params)
	{ 
		if (Configuration::get('PS_CATALOG_MODE'))
				return;
		$this->_prepHook($params);
		return $this->display(__FILE__, 'nrtbestsellers.tpl');
	}
	public function hookRightColumn($params)
	{
		return $this->hookBestsellers($params);
	}
	public function hookLeftColumn($params)
	{
		return $this->hookBestsellers($params);
	}

}
