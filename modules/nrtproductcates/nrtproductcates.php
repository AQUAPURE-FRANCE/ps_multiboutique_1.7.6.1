<?php
/*
*  2015 AxonVIP
*
*  @author AxonVIP <AxonVIP@gmail.com>
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
class NrtProductCates extends Module
{

	public function __construct()
	{
		$this->name = 'nrtproductcates';
		$this->tab = 'front_office_features';
		$this->version = '1.0';
		$this->author = 'AxonVIP';
		$this->need_instance = 0;

		$this->bootstrap = true;
		parent::__construct();

		$this->displayName = $this->l('Products in the same category');
		$this->description = $this->l('Displays other products on the same categories.');
		$this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
	}

	public function install()
	{
		$success = (parent::install()
			&& $this->registerHook('header')
			&& $this->registerHook('productFooter')
		);

                $this->_createTab();
                $this->_createConfigs();

		return $success;
	}

	public function uninstall()
	{
                $this->_deleteTab();
                $this->_deleteConfigs();

		return parent::uninstall();
	}
        
         
        /* ------------------------------------------------------------- */
        /*  CREATE CONFIGS
        /* ------------------------------------------------------------- */
        private function _createConfigs()
        {
            $languages = $this->context->language->getLanguages();

            foreach ($languages as $language){
                $title[$language['id_lang']] = 'Products same category';
            }
            foreach ($languages as $language){
                $href[$language['id_lang']] = '';
            }
            foreach ($languages as $language){
                $title_small[$language['id_lang']] = '';
            }
            $response = Configuration::updateValue('NRT_PRODUCTCATES_NBR', 6);
            $response &= Configuration::updateValue('NRT_PRODUCTCATES_TITLE', $title);
			$response &= Configuration::updateValue('NRT_PRODUCTCATES_TITLE_LINK', $href);
			$response &= Configuration::updateValue('NRT_PRODUCTCATES_TITLE_SMALL', $title_small);
            $response &= Configuration::updateValue('NRT_PRODUCTCATES_VERTICAL', 1);
            $response &= Configuration::updateValue('NRT_PRODUCTCATES_COLUMNITEM', 1);
            $response &= Configuration::updateValue('NRT_PRODUCTCATES_MAXITEM', 3);
            $response &= Configuration::updateValue('NRT_PRODUCTCATES_MEDIUMITEM', 3);
            $response &= Configuration::updateValue('NRT_PRODUCTCATES_MINITEM', 2);
            $response &= Configuration::updateValue('NRT_PRODUCTCATES_AUTOSCROLL', 0);
            $response &= Configuration::updateValue('NRT_PRODUCTCATES_PAUSEONHOVER', 0);
            $response &= Configuration::updateValue('NRT_PRODUCTCATES_PAGINATION', 0);
            $response &= Configuration::updateValue('NRT_PRODUCTCATES_NAVIGATION', 2);
            $response &= Configuration::updateValue('NRT_PRODUCTCATES_LAZYLOAD', 1);

            return $response;
        }
        
        /* ------------------------------------------------------------- */
        /*  DELETE CONFIGS
        /* ------------------------------------------------------------- */
        private function _deleteConfigs()
        {
            $response = Configuration::deleteByName('NRT_PRODUCTCATES_TITLE');
			$response &= Configuration::deleteByName('NRT_PRODUCTCATES_TITLE_LINK');
			$response &= Configuration::deleteByName('NRT_PRODUCTCATES_TITLE_SMALL');
            $response &= Configuration::deleteByName('NRT_PRODUCTCATES_VERTICAL');
            $response &= Configuration::deleteByName('NRT_PRODUCTCATES_COLUMNITEM');
            $response &= Configuration::deleteByName('NRT_PRODUCTCATES_MAXITEM');
            $response &= Configuration::deleteByName('NRT_PRODUCTCATES_MEDIUMITEM');
            $response &= Configuration::deleteByName('NRT_PRODUCTCATES_MINITEM');
            $response &= Configuration::deleteByName('NRT_PRODUCTCATES_AUTOSCROLL');
            $response &= Configuration::deleteByName('NRT_PRODUCTCATES_PAGINATION');
            $response &= Configuration::deleteByName('NRT_PRODUCTCATES_NAVIGATION');
            $response &= Configuration::deleteByName('NRT_PRODUCTCATES_PAUSEONHOVER');
            $response &= Configuration::deleteByName('NRT_PRODUCTCATES_NBR');
            $response &= Configuration::deleteByName('NRT_PRODUCTCATES_LAZYLOAD');

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
            $tab->class_name = "AdminNrtProductCates";
            $tab->name = array();
            foreach (Language::getLanguages() as $lang){
                $tab->name[$lang['id_lang']] = "Manage Products same category";
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
            $id_tab = Tab::getIdFromClassName('AdminNrtProductCates');
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
                            if (Tools::isSubmit('NRT_PRODUCTCATES_TITLE_'.$language['id_lang'])){
                                $title[$language['id_lang']] = Tools::getValue('NRT_PRODUCTCATES_TITLE_'.$language['id_lang']);
                            }
                        }
                        if (isset($title) && $title){
                            Configuration::updateValue('NRT_PRODUCTCATES_TITLE', $title);
                        }
                        foreach ($languages as $language){
                            if (Tools::isSubmit('NRT_PRODUCTCATES_TITLE_LINK_'.$language['id_lang'])){
                                $title_link[$language['id_lang']] = Tools::getValue('NRT_PRODUCTCATES_TITLE_LINK_'.$language['id_lang']);
                            }
                        }
                        if (isset($title_link) && $title_link){
                            Configuration::updateValue('NRT_PRODUCTCATES_TITLE_LINK', $title_link);
                        }
                        foreach ($languages as $language){
                            if (Tools::isSubmit('NRT_PRODUCTCATES_TITLE_SMALL_'.$language['id_lang'])){
                                $title_small[$language['id_lang']] = Tools::getValue('NRT_PRODUCTCATES_TITLE_SMALL_'.$language['id_lang']);
                            }
                        }
                        if (isset($title_small) && $title_small){
                            Configuration::updateValue('NRT_PRODUCTCATES_TITLE_SMALL', $title_small);
                        }
                        if (Tools::isSubmit('NRT_PRODUCTCATES_VERTICAL')){
                            Configuration::updateValue('NRT_PRODUCTCATES_VERTICAL', Tools::getValue('NRT_PRODUCTCATES_VERTICAL'));
                        }
                        if (Tools::isSubmit('NRT_PRODUCTCATES_AUTOSCROLL')){
                            Configuration::updateValue('NRT_PRODUCTCATES_AUTOSCROLL', (int)Tools::getValue('NRT_PRODUCTCATES_AUTOSCROLL'));
                        }
                        if (Tools::isSubmit('NRT_PRODUCTCATES_PAUSEONHOVER')){
                            Configuration::updateValue('NRT_PRODUCTCATES_PAUSEONHOVER', (int)Tools::getValue('NRT_PRODUCTCATES_PAUSEONHOVER'));
                        }
                        if (Tools::isSubmit('NRT_PRODUCTCATES_PAGINATION')){
                            Configuration::updateValue('NRT_PRODUCTCATES_PAGINATION', (int)Tools::getValue('NRT_PRODUCTCATES_PAGINATION'));
                        }
                        if (Tools::isSubmit('NRT_PRODUCTCATES_NAVIGATION')){
                            Configuration::updateValue('NRT_PRODUCTCATES_NAVIGATION', (int)Tools::getValue('NRT_PRODUCTCATES_NAVIGATION'));
                        }
                        if (Tools::isSubmit('NRT_PRODUCTCATES_LAZYLOAD')){
                            Configuration::updateValue('NRT_PRODUCTCATES_LAZYLOAD', (int)Tools::getValue('NRT_PRODUCTCATES_LAZYLOAD'));
                        }
                        if (Tools::isSubmit('NRT_PRODUCTCATES_MAXITEM') || Tools::isSubmit('NRT_PRODUCTCATES_MEDIUMITEM') || Tools::isSubmit('NRT_PRODUCTCATES_MINITEM') || Tools::isSubmit('NRT_PRODUCTCATES_NBR') || Tools::isSubmit('NRT_PRODUCTCATES_COLUMNITEM')){
                            if (Validate::isInt(Tools::getValue('NRT_PRODUCTCATES_MAXITEM')) && Validate::isInt(Tools::getValue('NRT_PRODUCTCATES_MEDIUMITEM')) && Validate::isInt(Tools::getValue('NRT_PRODUCTCATES_MINITEM')) && Validate::isInt(Tools::getValue('NRT_PRODUCTCATES_NBR')) && Validate::isInt(Tools::getValue('NRT_PRODUCTCATES_COLUMNITEM'))){
                                Configuration::updateValue('NRT_PRODUCTCATES_COLUMNITEM', Tools::getValue('NRT_PRODUCTCATES_COLUMNITEM'));
                                Configuration::updateValue('NRT_PRODUCTCATES_MAXITEM', Tools::getValue('NRT_PRODUCTCATES_MAXITEM'));
                                Configuration::updateValue('NRT_PRODUCTCATES_MEDIUMITEM', Tools::getValue('NRT_PRODUCTCATES_MEDIUMITEM'));
                                Configuration::updateValue('NRT_PRODUCTCATES_MINITEM', Tools::getValue('NRT_PRODUCTCATES_MINITEM'));
                                Configuration::updateValue('NRT_PRODUCTCATES_NBR', Tools::getValue('NRT_PRODUCTCATES_NBR'));
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
							'name' => 'NRT_PRODUCTCATES_TITLE',
							'label' => $this->l('Title'),
							'required' => false,
							'lang' => true,
					),
					array(
							'type' => 'text',
							'name' => 'NRT_PRODUCTCATES_TITLE_LINK',
							'label' => $this->l('Title link'),
							'required' => false,
							'lang' => true,
					),
					array(
							'type' => 'text',
							'name' => 'NRT_PRODUCTCATES_TITLE_SMALL',
							'label' => $this->l('Title small'),
							'required' => false,
							'lang' => true,
					),
					array(
						'type' => 'text',
						'label' => $this->l('Total products to display'),
						'required' => true,
						'name' => 'NRT_PRODUCTCATES_NBR',
						'class' => 'fixed-width-xxl',
						'desc' => $this->l('Define the number of products to be displayed in this block on home page.')
					),
					array(
						'type' => 'select',
						'name' => 'NRT_PRODUCTCATES_VERTICAL',
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
						'name' => 'NRT_PRODUCTCATES_COLUMNITEM',
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
						'name' => 'NRT_PRODUCTCATES_MAXITEM',
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
						'name' => 'NRT_PRODUCTCATES_MEDIUMITEM',
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
						'name' => 'NRT_PRODUCTCATES_MINITEM',
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
						'name' => 'NRT_PRODUCTCATES_AUTOSCROLL',
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
						'name' => 'NRT_PRODUCTCATES_LAZYLOAD',
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
						'name' => 'NRT_PRODUCTCATES_PAUSEONHOVER',
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
						'name' => 'NRT_PRODUCTCATES_NAVIGATION',
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
						'name' => 'NRT_PRODUCTCATES_PAGINATION',
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
                $helper->fields_value['NRT_PRODUCTCATES_VERTICAL'] = Configuration::get('NRT_PRODUCTCATES_VERTICAL');
                $helper->fields_value['NRT_PRODUCTCATES_COLUMNITEM'] = Configuration::get('NRT_PRODUCTCATES_COLUMNITEM');
                $helper->fields_value['NRT_PRODUCTCATES_MAXITEM'] = Configuration::get('NRT_PRODUCTCATES_MAXITEM');
                $helper->fields_value['NRT_PRODUCTCATES_MEDIUMITEM'] = Configuration::get('NRT_PRODUCTCATES_MEDIUMITEM');
                $helper->fields_value['NRT_PRODUCTCATES_MINITEM'] = Configuration::get('NRT_PRODUCTCATES_MINITEM');
                $helper->fields_value['NRT_PRODUCTCATES_AUTOSCROLL'] = Configuration::get('NRT_PRODUCTCATES_AUTOSCROLL');
                $helper->fields_value['NRT_PRODUCTCATES_PAUSEONHOVER'] = Configuration::get('NRT_PRODUCTCATES_PAUSEONHOVER');
                $helper->fields_value['NRT_PRODUCTCATES_PAGINATION'] = Configuration::get('NRT_PRODUCTCATES_PAGINATION');
                $helper->fields_value['NRT_PRODUCTCATES_NAVIGATION'] = Configuration::get('NRT_PRODUCTCATES_NAVIGATION');
                $helper->fields_value['NRT_PRODUCTCATES_NBR'] = Configuration::get('NRT_PRODUCTCATES_NBR');
                $helper->fields_value['NRT_PRODUCTCATES_LAZYLOAD'] = Configuration::get('NRT_PRODUCTCATES_LAZYLOAD');

                foreach($languages as $language){
                    $helper->fields_value['NRT_PRODUCTCATES_TITLE'][$language['id_lang']] = Configuration::get('NRT_PRODUCTCATES_TITLE', $language['id_lang']);
                }

                foreach($languages as $language){
                    $helper->fields_value['NRT_PRODUCTCATES_TITLE_LINK'][$language['id_lang']] = Configuration::get('NRT_PRODUCTCATES_TITLE_LINK', $language['id_lang']);
                }
                foreach($languages as $language){
                    $helper->fields_value['NRT_PRODUCTCATES_TITLE_SMALL'][$language['id_lang']] = Configuration::get('NRT_PRODUCTCATES_TITLE_SMALL', $language['id_lang']);
                }
		return $helper->generateForm(array($fields_form));
	}
	private function getCurrentProduct($products, $id_current)
	{
		if ($products)
			foreach ($products AS $key => $product)
				if ($product['id_product'] == $id_current)
					return $key;
		return false;
	}
	
	protected function getProducts($params)
    {  
		$id_product = (int)$params['product']['id_product'];
         $product = $params['product'];
		$id_default_lang = $this->context->language->id;
		$cache_id = 'nrtproductcates|'.$id_product.'|'.(isset($params['category']->id_category) ? (int)$params['category']->id_category : $product->id_category_default);

			/* If the visitor has came to this product by a category, use this one */
			if (isset($params['category']->id_category))
				$category = $params['category'];
			/* Else, use the default product category */
			else
			{
				if (isset($product->id_category_default) AND $product->id_category_default > 1)
					$category = new Category((int)$product->id_category_default);
			}
			if (!Validate::isLoadedObject($category) OR !$category->active) 
				return;
                              
			// Get infos
			$categoryProducts = $category->getProducts($this->context->language->id, 1, 100); /* 100 products max. */

			$sizeOfCategoryProducts = (int)sizeof($categoryProducts);
			$middlePosition = 0;
			if (is_array($categoryProducts) AND sizeof($categoryProducts))
			{
				foreach ($categoryProducts AS $key => $categoryProduct)
					if ($categoryProduct['id_product'] == $id_product)
					{
						unset($categoryProducts[$key]);
						break;
					}

				$taxes = Product::getTaxCalculationMethod();
					foreach ($categoryProducts AS $key => $categoryProduct)
						if ($categoryProduct['id_product'] != $id_product)
						{
							if ($taxes == 0 OR $taxes == 2)
								$categoryProducts[$key]['displayed_price'] = Product::getPriceStatic((int)$categoryProduct['id_product'], true, NULL, 2);
							elseif ($taxes == 1)
								$categoryProducts[$key]['displayed_price'] = Product::getPriceStatic((int)$categoryProduct['id_product'], false, NULL, 2);
						}
			
				// Get positions
				$middlePosition = round($sizeOfCategoryProducts / 2, 0);
				$productPosition = $this->getCurrentProduct($categoryProducts, (int)$id_product);
			
				// Flip middle product with current product
				if ($productPosition)
				{
					$tmp = $categoryProducts[$middlePosition-1];
					$categoryProducts[$middlePosition-1] = $categoryProducts[$productPosition];
					$categoryProducts[$productPosition] = $tmp;
				}
			
				// If products tab higher than 30, slice it
				if (Configuration::get('NRT_PRODUCTCATES_NBR'))
				    $nbp = Configuration::get('NRT_PRODUCTCATES_NBR');
				else {
				    $nbp = 30; 
				}
				if ($sizeOfCategoryProducts > $nbp)
				{
					$categoryProducts = array_slice($categoryProducts, $middlePosition - ($nbp/2), $nbp, true);
					$middlePosition = $nbp/2;
				}
			}
     
                  $imagesTypes = ImageType::getImagesTypes('products');
		$images = array();

		   foreach ($imagesTypes as $image) {
				$images[$image['name']] = Image::getSize($image['name']);
				$images[$image['name']]['name'] = $image['name'];
			}
				  
			// Display tpl
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
		if(is_array($categoryProducts)){
        foreach ($categoryProducts as $rawProduct) {
            $products_for_template[] = $presenter->present(
                $presentationSettings,
                $assembler->assembleProduct($rawProduct),
                $this->context->language
            );
        	}
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
                'title' => Configuration::get('NRT_PRODUCTCATES_TITLE', $id_default_lang),
				'href' => Configuration::get('NRT_PRODUCTCATES_TITLE_LINK', $id_default_lang),
				'legend' => Configuration::get('NRT_PRODUCTCATES_TITLE_SMALL', $id_default_lang),
                'colnb' => Configuration::get('NRT_PRODUCTCATES_COLUMNITEM'),
                'line_md' => Configuration::get('NRT_PRODUCTCATES_MAXITEM'),
                'line_sm' => Configuration::get('NRT_PRODUCTCATES_MEDIUMITEM'),
                'line_xs' => Configuration::get('NRT_PRODUCTCATES_MINITEM'),
                'ap' => Configuration::get('NRT_PRODUCTCATES_AUTOSCROLL'),
                'dt' => Configuration::get('NRT_PRODUCTCATES_PAGINATION'),
                'ar' => Configuration::get('NRT_PRODUCTCATES_NAVIGATION'),
                'line_ms' => Configuration::get('NRT_PRODUCTCATES_PAUSEONHOVER'),
                'line_lg' => Configuration::get('NRT_PRODUCTCATES_LAZYLOAD'),
				'view' => Configuration::get('NRT_PRODUCTCATES_VERTICAL'),
				'products' => $products
            );

            $this->smarty->assign('nodecontent', $nodecontent);
			 $this->smarty->assign('images_types', $images);
        }
		
  public function hookProductFooter($params)
	{ 
		if (Configuration::get('PS_CATALOG_MODE'))
				return;
		$this->_prepHook($params);
		return $this->display(__FILE__, 'nrtproductcates.tpl');
	}
}
