<?php

/* Withinpixels - Megamenu - 2014 - Sercan YEMEN - twitter.com/sercan */

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
include_once(_PS_MODULE_DIR_ . 'nrtmegamenu/model/nrtMegamenuModel.php');
include_once(_PS_MODULE_DIR_ . 'nrtmegamenu/model/nrtMegamenuItemsModel.php');

class NrtMegamenu extends Module
{
    private $_output = '';

    function __construct()
    {
        $this->name = 'nrtmegamenu';
        $this->tab = 'front_office_features';
        $this->version = '1.0';
        $this->author = 'AxonVIP';
        $this->need_instance = 0;
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Megamenu Drop & Drag');
        $this->description = $this->l('Required by author: AxonVIP.');
    }

    /* ------------------------------------------------------------- */
    /*  INSTALL THE MODULE
    /* ------------------------------------------------------------- */
    public function install()
    {
        if (Shop::isFeatureActive()){
            Shop::setContext(Shop::CONTEXT_ALL);
        }

        return parent::install()
               && $this->registerHook('megamenu')
               && $this->registerHook('header')
               && $this->_createTables()
               && $this->_installDemoData()
               && $this->_createTab();
    }

    /* ------------------------------------------------------------- */
    /*  UNINSTALL THE MODULE
    /* ------------------------------------------------------------- */
    public function uninstall()
    {
        return parent::uninstall()
               && $this->unregisterHook('megamenu')
               && $this->_deleteTables()
               && $this->_deleteTab();
    }

    /* ------------------------------------------------------------- */
    /*  CREATE THE TABLES
    /* ------------------------------------------------------------- */
    private function _createTables()
    {

        $response = (bool) Db::getInstance()->execute('
            CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'nrtmegamenu` (
                `id_nrtmegamenu` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `active` tinyint(1) unsigned NOT NULL,
                `position` tinyint(3) unsigned NOT NULL,
                `open_in_new` tinyint(1) NOT NULL,
                `icon_class` varchar(255) NOT NULL,
                `menu_class` varchar(255) NOT NULL,
                `width_popup_class` varchar(255) NOT NULL,
                PRIMARY KEY (`id_nrtmegamenu`)
            ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=UTF8;
        ');
        
        $response &= Db::getInstance()->execute('
            INSERT INTO `' . _DB_PREFIX_ . 'nrtmegamenu` VALUES (1, 1, 0, 0, "fa fa-home", "", "");
        ');
        $response &= Db::getInstance()->execute('
            INSERT INTO `' . _DB_PREFIX_ . 'nrtmegamenu` VALUES (2, 1, 1, 0, "", "", "");
        ');
        
        $response &= Db::getInstance()->execute('
            CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'nrtmegamenu_lang` (
                `id_nrtmegamenu` int(10) unsigned NOT NULL,
                `id_lang` int(10) unsigned NOT NULL,
                `title` text NOT NULL,
                `description` varchar(255) NOT NULL,
                `link` varchar(255) NOT NULL,
                PRIMARY KEY (`id_nrtmegamenu`,`id_lang`)
            ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=UTF8;
        ');
        
        $response &= Db::getInstance()->execute('
            INSERT INTO `' . _DB_PREFIX_ . 'nrtmegamenu_lang` VALUES (1, 1, "HOME", "", "#");
        ');
        $response &= Db::getInstance()->execute('
            INSERT INTO `' . _DB_PREFIX_ . 'nrtmegamenu_lang` VALUES (2, 1, "CUSTOM", "", "#");
        ');
        
        $response &= Db::getInstance()->execute('
            CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'nrtmegamenu_shop` (
                `id_nrtmegamenu` int(10) unsigned NOT NULL,
                `id_shop` int(10) unsigned NOT NULL,
                PRIMARY KEY (`id_nrtmegamenu`,`id_shop`)
            ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=UTF8;
        ');
        
        $response &= Db::getInstance()->execute('
            INSERT INTO `' . _DB_PREFIX_ . 'nrtmegamenu_shop` VALUES (1, 1);
        ');
        $response &= Db::getInstance()->execute('
            INSERT INTO `' . _DB_PREFIX_ . 'nrtmegamenu_shop` VALUES (2, 1);
        ');
        
        $response &= Db::getInstance()->execute('
            CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'nrtmegamenuitems` (
                `id_nrtmegamenuitems` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `id_nrtmegamenu` int(10) unsigned NULL,
                `active` tinyint(1) unsigned NOT NULL,
                `nleft` int(10) unsigned NOT NULL,
                `nright` int(10) unsigned NOT NULL,
                `depth` int(10) unsigned NOT NULL,
                `icon_class` varchar(255) NOT NULL,
                `menu_type` tinyint(3) unsigned NOT NULL,
                `menu_class` varchar(255) NOT NULL,
                `menu_layout` varchar(255) NOT NULL,
                `menu_image` varchar(255) NOT NULL,
                `open_in_new` tinyint(1) NOT NULL,
                `show_image` tinyint(1) NOT NULL,
                PRIMARY KEY (`id_nrtmegamenuitems`)
            ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=UTF8;
        ');

        $response &= Db::getInstance()->execute('
            CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'nrtmegamenuitems_lang` (
                `id_nrtmegamenuitems` int(10) unsigned NOT NULL,
                `id_lang` int(10) unsigned NOT NULL,
                `title` varchar(255) NOT NULL,
                `description` varchar(255) NOT NULL,
                `link` varchar(255) NOT NULL,
                `content` text NOT NULL,
                PRIMARY KEY (`id_nrtmegamenuitems`,`id_lang`)
            ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=UTF8;
        ');
        return $response;
    }

    /* ------------------------------------------------------------- */
    /*  DELETE THE TABLES
    /* ------------------------------------------------------------- */
    private function _deleteTables()
    {
        return Db::getInstance()->execute('
                DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'nrtmegamenu`, `' . _DB_PREFIX_ . 'nrtmegamenu_lang`, `' . _DB_PREFIX_ . 'nrtmegamenu_shop`, `' . _DB_PREFIX_ . 'nrtmegamenuitems`, `' . _DB_PREFIX_ . 'nrtmegamenuitems_lang`;
        ');
    }

    /* ------------------------------------------------------------- */
    /*  CREATE CONFIGS
    /* ------------------------------------------------------------- */
    private function _createConfigs()
    {
        return true;
    }

    /* ------------------------------------------------------------- */
    /*  DELETE CONFIGS
    /* ------------------------------------------------------------- */
    private function _deleteConfigs()
    {
        return true;
    }

    /* ------------------------------------------------------------- */
    /*  INSTALL DEMO DATA
    /* ------------------------------------------------------------- */
    private function _installDemoData()
    {
        return true;
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
        $tab->class_name = "AdminNrtMegamenu";
        $tab->name = array();
        foreach (Language::getLanguages() as $lang){
            $tab->name[$lang['id_lang']] = "Manage Megamenu";
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
        $id_tab = Tab::getIdFromClassName('AdminNrtMegamenu');
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

    /* ------------------------------------------------------------- */
    /*  HOOK THE MODULE INTO SHOP DATA DUPLICATION ACTION
    /* ------------------------------------------------------------- */
    public function hookActionShopDataDuplication($params)
    {
        Db::getInstance()->execute('
            INSERT IGNORE INTO '._DB_PREFIX_.'nrtmegamenu_shop (id_nrtmegamenu, id_shop)
            SELECT id_nrtmegamenu, '.(int)$params['new_id_shop'].'
            FROM '._DB_PREFIX_.'nrtmegamenu_shop
            WHERE id_shop = '.(int)$params['old_id_shop']
        );
    }


    /* ------------------------------------------------------------- */
    /*
    /*  FRONT OFFICE RELATED STUFF
    /*
    /* ------------------------------------------------------------- */

    /*
     * MENU TYPES
     *
     * id : description
     * --   -----------
     *  1 : Custom link
     *  2 : Category link
     *  3 : Product link
     *  4 : Manufacturer link
     *  5 : Supplier link
     *  6 : CMS page link
     *  7 : Custom content
     *  8 : Divider
     *
     */

    /* ------------------------------------------------------------- */
    /*  RENDER MEGAMENU
    /* ------------------------------------------------------------- */
    private function renderMenu()
    {
        $id_lang = $this->context->language->id;
        $id_shop = $this->context->shop->id;

        $roots = NrtMegamenuModel::getMenus($id_shop);

        $menuTypes = array(
            'customlink' => 1,
            'category' => 2,
            'product' => 3,
            'manufacturer' => 4,
            'supplier' => 5,
            'cmspage' => 6,
            'customcontent' => 7,
            'divider' => 8,
        );

        $nrtmegamenu = array();

        // Get Root Items
        foreach ($roots as $root)
        {
            $nrtmegamenu['root'][$root['id_nrtmegamenu']] = new NrtMegamenuModel($root['id_nrtmegamenu'], $id_lang);
        }

        // Get Menu Items
        foreach ($roots as $root)
        {
            $items = NrtMegamenuItemsModel::getMenuItems($root['id_nrtmegamenu']);

            if (!$items){
                continue;
            }

            // Iterate through all items and prepare them
            foreach ($items as $item)
            {
                $nrtMegamenuItem = new NrtMegamenuItemsModel($item['id_nrtmegamenuitems'], $id_lang);

                $menuTitle = "";
                $menuLink = "";

                switch ($nrtMegamenuItem->menu_type)
                {
                    case 1:
                        // Custom Link
                        $menuLink = $nrtMegamenuItem->link;
                        $menuType = array_search($nrtMegamenuItem->menu_type, $menuTypes);
                        break;

                    case 2:
                        // Category Link
                        $category = new Category($nrtMegamenuItem->link, $id_lang);
                        $menuTitle = $category->name;
                        $menuLink = $this->context->link->getCategoryLink($category, null, $id_lang);
                        $menuType = array_search($nrtMegamenuItem->menu_type, $menuTypes);
                        break;

                    case 3:
					
					$menuType = array_search($nrtMegamenuItem->menu_type, $menuTypes);
					$customProduct = get_object_vars(new Product($nrtMegamenuItem->link, true, $id_lang));
					$customProduct['id_product'] = $customProduct['id'];
					$coverImage = Product::getCover($customProduct['id_product']);
					$customProduct['id_image'] = $coverImage['id_image'];
					$products= Product::getProductProperties($id_lang, $customProduct);
					
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
					if(isset($products)){
						$products_for_template= $presenter->present(
							$presentationSettings,
							$assembler->assembleProduct($products),
							$this->context->language
						);
					
					}
					$nrtMegamenuItem->product=$products_for_template;
                        break;

                    case 4:
                        // Manufacturer Link
                        $manufacturer = new Manufacturer($nrtMegamenuItem->link, $id_lang);
                        $menuTitle = $manufacturer->name;
                        $menuLink = $this->context->link->getManufacturerLink($manufacturer, null, $id_lang);
                        $menuType = array_search($nrtMegamenuItem->menu_type, $menuTypes);

                        if ($nrtMegamenuItem->show_image){
                            $nrtMegamenuItem->image = $this->context->link->getMediaLink(_THEME_MANU_DIR_ . $manufacturer->id_manufacturer . '-medium_default.jpg');
                        }
                        break;

                    case 5:
                        // Supplier Link
                        $supplier = new Supplier($nrtMegamenuItem->link, $id_lang);
                        $menuTitle = $supplier->name;
                        $menuLink = $this->context->link->getSupplierLink($supplier, null, $id_lang);
                        $menuType = array_search($nrtMegamenuItem->menu_type, $menuTypes);

                        if ($nrtMegamenuItem->show_image){
                            $nrtMegamenuItem->image = $this->context->link->getMediaLink(_THEME_SUP_DIR_ . $supplier->id_supplier . '-medium_default.jpg');
                        }
                        break;

                    case 6:
                        // CMS Page Link
                        $cmsPage = new CMS($nrtMegamenuItem->link, $id_lang);
                        $menuTitle = $cmsPage->meta_title;
                        $menuLink = $this->context->link->getCMSLink($cmsPage, null, null, $id_lang);
                        $menuType = array_search($nrtMegamenuItem->menu_type, $menuTypes);
                        break;

                    case 7:
                        // Custom Content
                        $menuType = array_search($nrtMegamenuItem->menu_type, $menuTypes);
                        break;

                    case 8:
                        // Divider
                        $menuType = array_search($nrtMegamenuItem->menu_type, $menuTypes);
                        break;

                    default:
                        break;
                }

                if ($menuTitle != ''){
                    $nrtMegamenuItem->title = $menuTitle;
                }

                if ($menuLink != ''){
                    $nrtMegamenuItem->link = $menuLink;
                }

                $nrtMegamenuItem->menu_type_name = $menuType;

                $nrtmegamenu['root'][$root['id_nrtmegamenu']]->items[] = $nrtMegamenuItem;
            }

        }

        return $nrtmegamenu;
    }

    /* ------------------------------------------------------------- */
    /*  PREPARE FOR HOOK
    /* ------------------------------------------------------------- */
    private function _prepHook($params)
    {
        $nrtmegamenu = $this->renderMenu();
        if ($nrtmegamenu){
            $this->smarty->assign('nrtmegamenu', $nrtmegamenu['root']);
        }

        if (isset($params['nrtmegamenumobile']) && $params['nrtmegamenumobile'] == true){
            $this->smarty->assign('nrtmegamenumobile', true);
        }	
    }
    /* ------------------------------------------------------------- */
    /*  HOOK (displayHeader)
    /* ------------------------------------------------------------- */
    public function hookHeader()
    {
        $this->context->controller->addJS($this->_path.'views/js/hook/jquery.megamenu.js');
    }
    /* ------------------------------------------------------------- */
    /*  HOOK (displayTop)
    /* ------------------------------------------------------------- */
    public function hookMegamenu($params)
    {
        $this->_prepHook($params);
        return $this->display(__FILE__, 'views/templates/hook/nrtmegamenu.tpl');
    }

}