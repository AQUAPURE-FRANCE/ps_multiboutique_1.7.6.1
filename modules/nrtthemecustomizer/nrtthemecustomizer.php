<?php

/* AxonVIP - Theme Customizer - 2016 - AxonVIP@gmail.com */

if (!defined('_PS_VERSION_'))
    exit;

include_once(_PS_MODULE_DIR_ . 'nrtthemecustomizer/model/nrtThemeCustomizerModel.php');

class NrtThemeCustomizer extends Module
{
    private $_output = '';

    private $_standardConfig = '';
    private $_styleConfig = '';
    private $_multiLangConfig = '';

    private $_bgImageConfig = '';
    private $_fontConfig = '';

    private $_cssRules = array();
    private $_configDefaults = array();
    private $_websafeFonts = array();
    private $_googleFonts = array();

    function __construct()
    {
        $this->name = 'nrtthemecustomizer';
        $this->tab = 'front_office_features';
        $this->version = '1.0';
        $this->author = 'AxonVIP';
        $this->need_instance = 0;
        $this->secure_key = Tools::encrypt($this->name);
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Theme Customizer');
        $this->description = $this->l('Required by author: AxonVIP.');

        $this->_defineArrays();
    }

    /* ------------------------------------------------------------- */
    /*  INSTALL THE MODULE
    /* ------------------------------------------------------------- */
    public function install()
    {
        if (Shop::isFeatureActive()) {
            Shop::setContext(Shop::CONTEXT_ALL);
        }

        return parent::install()
        && $this->registerHook('header')
        && $this->_createConfigs()
        && $this->_createTab();
    }

    /* ------------------------------------------------------------- */
    /*  UNINSTALL THE MODULE
    /* ------------------------------------------------------------- */
    public function uninstall()
    {
        return parent::uninstall()
        && $this->unregisterHook('header')
        && $this->_deleteConfigs()
        && $this->_deleteTab();
    }

    /* ------------------------------------------------------------- */
    /*  CREATE THE TABLES
    /* ------------------------------------------------------------- */
    private function _createTables()
    {
        return true;
    }

    /* ------------------------------------------------------------- */
    /*  DELETE THE TABLES
    /* ------------------------------------------------------------- */
    private function _deleteTables()
    {
        return true;
    }
    /* ------------------------------------------------------------- */
    /*  CREATE CONFIGS
    /* ------------------------------------------------------------- */
    private function _createConfigs()
    {
        $languages = $this->context->language->getLanguages();

        // General Options
        $response = Configuration::updateValue('NRT_showPanelTool', 1);
        $response &= Configuration::updateValue('NRT_mainLayout', 'fullwidth');
        $response &= Configuration::updateValue('NRT_enableCountdownTimer', 1);
        $response &= Configuration::updateValue('NRT_quickView', 1);
		 // Maps
		$response &= Configuration::updateValue('NRT_GGMapsAPIKeys', 'AIzaSyASya36pm5HYdSIIhmXV8KIll6M0-JC9-s');
		$response &= Configuration::updateValue('NRT_GGMapsJava',1);
        // Header Options
        $response &= Configuration::updateValue('NRT_stickyMenu', 1);
        $response &= Configuration::updateValue('NRT_stickySearch', 1);
        $response &= Configuration::updateValue('NRT_stickyCart', 1);

        // Category Page Options
        $response &= Configuration::updateValue('NRT_subcategories', 0);
        $response &= Configuration::updateValue('NRT_categoryShowAvgRating', 1);
        $response &= Configuration::updateValue('NRT_categoryShowColorOptions', 0);
        $response &= Configuration::updateValue('NRT_categoryShowStockInfo', 0);

        // Product Page Options
        $response &= Configuration::updateValue('NRT_productShowReference', 0);
        $response &= Configuration::updateValue('NRT_productShowCondition', 1);
        $response &= Configuration::updateValue('NRT_productShowManName', 0);
        $response &= Configuration::updateValue('NRT_productVerticalThumb', 0);
        $response &= Configuration::updateValue('NRT_productUpsell', 0);

        // Font Options
        $response &= Configuration::updateValue('NRT_includeCyrillicSubset', 0);
        $response &= Configuration::updateValue('NRT_includeGreekSubset', 0);
        $response &= Configuration::updateValue('NRT_includeVietnameseSubset', 0);
        $response &= Configuration::updateValue('NRT_mainFont', 'None');
        $response &= Configuration::updateValue('NRT_titleFont', 'None');

        // Color Options
        $response &= Configuration::updateValue('NRT_mainColorScheme', '#1b1b1b');
        $response &= Configuration::updateValue('NRT_activeColorScheme', '#ddbc5f');

        // Background Options
        $response &= Configuration::updateValue('NRT_backgroundColor', '#ffffff');
        $response &= Configuration::updateValue('NRT_backgroundImage', '');
        $response &= Configuration::updateValue('NRT_backgroundRepeat', 'repeat');
        $response &= Configuration::updateValue('NRT_backgroundAttachment', 'scroll');
        $response &= Configuration::updateValue('NRT_backgroundSize', 'auto');

        $response &= Configuration::updateValue('NRT_bodyBackgroundColor', '#ffffff');
        $response &= Configuration::updateValue('NRT_bodyBackgroundImage', '');
        $response &= Configuration::updateValue('NRT_bodyBackgroundRepeat', 'repeat');
        $response &= Configuration::updateValue('NRT_bodyBackgroundAttachment', 'scroll');
        $response &= Configuration::updateValue('NRT_bodyBackgroundSize', 'auto');

		$response &= Configuration::updateValue('NRT_breadcrumbBackgroundImage', 'bg_breadcrumb-1.jpg');
        // Custom Codes
        $response &= Configuration::updateValue('NRT_customCSS', '');
        $response &= Configuration::updateValue('NRT_customJS', '');

        // Override Options
        $response &= Configuration::updateValue('PS_TC_ACTIVE', 0);
        $response &= Configuration::updateValue('PS_QUICK_VIEW', 1);
        $response &= Configuration::updateValue('PS_GRID_PRODUCT', 0);

        return $response;
    }

    /* ------------------------------------------------------------- */
    /*  DELETE CONFIGS
    /* ------------------------------------------------------------- */
    private function _deleteConfigs()
    {
        // General Options
        $response = Configuration::deleteByName('NRT_showPanelTool');
        $response &= Configuration::deleteByName('NRT_mainLayout');
        $response &= Configuration::deleteByName('NRT_enableCountdownTimer');
        $response &= Configuration::deleteByName('NRT_quickView');
		// Maps
		$response &= Configuration::deleteByName('NRT_GGMapsAPIKeys');
		$response &= Configuration::deleteByName('NRT_GGMapsJava');
        // Header Options
        $response &= Configuration::deleteByName('NRT_stickyMenu');
        $response &= Configuration::deleteByName('NRT_stickySearch');
        $response &= Configuration::deleteByName('NRT_stickyCart');
        
        // Category Page Options
        $response &= Configuration::deleteByName('NRT_subcategories');
        $response &= Configuration::deleteByName('NRT_categoryShowAvgRating');
        $response &= Configuration::deleteByName('NRT_categoryShowColorOptions');
        $response &= Configuration::deleteByName('NRT_categoryShowStockInfo');

        // Product Page Options
        $response &= Configuration::deleteByName('NRT_productShowReference');
        $response &= Configuration::deleteByName('NRT_productShowCondition');
        $response &= Configuration::deleteByName('NRT_productShowManName');
        $response &= Configuration::deleteByName('NRT_productVerticalThumb');
        $response &= Configuration::deleteByName('NRT_productUpsell');

        // Font Options
        $response &= Configuration::deleteByName('NRT_includeCyrillicSubset');
        $response &= Configuration::deleteByName('NRT_includeGreekSubset');
        $response &= Configuration::deleteByName('NRT_includeVietnameseSubset');
        $response &= Configuration::deleteByName('NRT_mainFont');
        $response &= Configuration::deleteByName('NRT_titleFont');

        // Color Options
        $response &= Configuration::deleteByName('NRT_mainColorScheme');
        $response &= Configuration::deleteByName('NRT_activeColorScheme');

        // Background Options
        $response &= Configuration::deleteByName('NRT_backgroundColor');
        $response &= Configuration::deleteByName('NRT_backgroundImage');
        $response &= Configuration::deleteByName('NRT_backgroundRepeat');
        $response &= Configuration::deleteByName('NRT_backgroundAttachment');
        $response &= Configuration::deleteByName('NRT_backgroundSize');

        $response &= Configuration::deleteByName('NRT_bodyBackgroundColor');
        $response &= Configuration::deleteByName('NRT_bodyBackgroundImage');
        $response &= Configuration::deleteByName('NRT_bodyBackgroundRepeat');
        $response &= Configuration::deleteByName('NRT_bodyBackgroundAttachment');
        $response &= Configuration::deleteByName('NRT_bodyBackgroundSize');

		$response &= Configuration::deleteByName('NRT_breadcrumbBackgroundImage');
        // Custom Codes
        $response &= Configuration::deleteByName('NRT_customCSS');
        $response &= Configuration::deleteByName('NRT_customJS');

        return $response;
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
        $tab->class_name = "AdminNrtThemeCustomizerConfig";
        $tab->name = array();
        foreach (Language::getLanguages() as $lang) {
            $tab->name[$lang['id_lang']] = "Manage Theme Customizer";
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
        $id_tab = Tab::getIdFromClassName('AdminNrtThemeCustomizerConfig');
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
    /*  DEFINE ARRAYS
    /* ------------------------------------------------------------- */
    private function _defineArrays()
    {
        $bgImageDirs = $this->context->link->getMediaLink(_MODULE_DIR_ . $this->name . '/views/img/front/bg/');
        
        $force_ssl = (Configuration::get('PS_SSL_ENABLED'));
        if($force_ssl){
            $bgImageDir = str_replace("http:", "https:", $bgImageDirs);
        } else {
            $bgImageDir = $bgImageDirs;
        }

		
        // CONFIG ARRAYS
        $this->_standardConfig = array(
            // General Options
            'NRT_showPanelTool',
            'NRT_mainLayout',
            'NRT_enableCountdownTimer',
            'NRT_quickView',
            'NRT_categoryShowAvgRating',
			'NRT_GGMapsAPIKeys',
			'NRT_GGMapsJava',
            // Header Options
            'NRT_stickyMenu',
            'NRT_stickySearch',
            'NRT_stickyCart',

            // Category Page Options
	    'PS_GRID_PRODUCT',
            'NRT_subcategories',
            'NRT_categoryShowColorOptions',
            'NRT_categoryShowStockInfo',

            // Product Page Options
            'NRT_productShowReference',
            'NRT_productShowCondition',
            'NRT_productShowManName',
	    	'NRT_productVerticalThumb',
            'NRT_productUpsell',

            // Font Options
            'NRT_includeCyrillicSubset',
            'NRT_includeGreekSubset',
            'NRT_includeVietnameseSubset'
        );

        $this->_styleConfig = array(
            // Background Options
            'NRT_backgroundColor',
            'NRT_backgroundImage',
            'NRT_backgroundRepeat',
            'NRT_backgroundAttachment',
            'NRT_backgroundSize',

            'NRT_bodyBackgroundColor',
            'NRT_bodyBackgroundImage',
            'NRT_bodyBackgroundRepeat',
            'NRT_bodyBackgroundAttachment',
            'NRT_bodyBackgroundSize',
			
			'NRT_breadcrumbBackgroundImage',

            // Font Options
            'NRT_mainFont',
            'NRT_titleFont',

            // Color Options
            'NRT_mainColorScheme',
            'NRT_activeColorScheme',

            // Custom Codes
            'NRT_customCSS',
            'NRT_customJS'
        );

        // SPECIAL ARRAYS
        // These arrays are only for defining certain config values that needs to be handled differently.
        $this->_bgImageConfig = array(
            'NRT_backgroundImage',
            'NRT_bodyBackgroundImage',
			'NRT_breadcrumbBackgroundImage'
        );

        $this->_fontConfig = array(
            'NRT_mainFont',
            'NRT_titleFont'
        );
        // End - SPECIAL ARRAYS

        // CSS AND CONFIG RELATIONS
		$config_1= array(
            // #page Background
            'NRT_backgroundColor' => array(
                array(
                    'selector' => 'main',
                    'rule' => 'background-color'
                )
            ),
            'NRT_backgroundImage' => array(
                array(
                    'selector' => 'main',
                    'rule' => 'background-image',
                    'prefix' => 'url("' . $bgImageDir,
                    'suffix' => '")'
                )
            ),
            'NRT_backgroundRepeat' => array(
                array(
                    'selector' => 'main',
                    'rule' => 'background-repeat'
                )
            ),
            'NRT_backgroundAttachment' => array(
                array(
                    'selector' => 'main',
                    'rule' => 'background-attachment'
                )
            ),
            'NRT_backgroundSize' => array(
                array(
                    'selector' => 'main',
                    'rule' => 'background-size'
                )
            ),

            // Body Background
            'NRT_bodyBackgroundColor' => array(
                array(
                    'selector' => 'body',
                    'rule' => 'background-color'
                )
            ),
            'NRT_bodyBackgroundImage' => array(
                array(
                    'selector' => 'body',
                    'rule' => 'background-image',
                    'prefix' => 'url("' . $bgImageDir,
                    'suffix' => '")'
                )
            ),
            'NRT_bodyBackgroundRepeat' => array(
                array(
                    'selector' => 'body',
                    'rule' => 'background-repeat'
                )
            ),
            'NRT_bodyBackgroundAttachment' => array(
                array(
                    'selector' => 'body',
                    'rule' => 'background-attachment'
                )
            ),
            'NRT_bodyBackgroundSize' => array(
                array(
                    'selector' => 'body',
                    'rule' => 'background-size'
                )
            )
			
        );
		
		if (file_exists(_PS_THEME_DIR_. 'modules/nrtthemecustomizer/config.php')){
			require_once(_PS_THEME_DIR_. 'modules/nrtthemecustomizer/config.php');
			if(isset($config_2))
			$this->_cssRules=array_merge($config_1,$config_2);
		}
		else{
			$this->_cssRules=$config_1;	
		}
        // Config defaults
        $this->_configDefaults = array(
            'NRT_mainColorScheme' => '#1b1b1b',
            'NRT_activeColorScheme' => '#ddbc5f',

            /* Background Options */
            'NRT_backgroundColor' => '#ffffff',
            'NRT_backgroundRepeat' => 'repeat',
            'NRT_backgroundAttachment' => 'scroll',
            'NRT_backgroundSize' => 'auto',

            'NRT_bodyBackgroundColor' => '#ffffff',
            'NRT_bodyBackgroundRepeat' => 'repeat',
            'NRT_bodyBackgroundAttachment' => 'scroll',
            'NRT_bodyBackgroundSize' => 'auto'
        );

        // Web-safe Fonts
        $this->_websafeFonts = array('Arial', 'sans-serif');

        // Google Fonts
        $this->_googleFonts = array(
			'Amiko' => array('subsets' => array('latin', 'latin-ext', 'greek'), 'variants' => array('400','600','700')),
		    'Poppins' => array('subsets' => array('latin', 'latin-ext', 'greek'), 'variants' => array('400','600')),
            'ABeeZee' => array('subsets' => array('latin'), 'variants' => array('400', 'italic')),
            'Abel' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Abril Fatface' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Aclonica' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Acme' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Actor' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Adamina' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Advent Pro' => array('subsets' => array('latin', 'latin-ext', 'greek'), 'variants' => array('100', '200', '300', '400', '500', '600', '700')),
            'Aguafina Script' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Akronim' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Aladin' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Aldrich' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Alef' => array('subsets' => array('latin'), 'variants' => array('400', '700')),
            'Alegreya' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400', 'italic', '700', '700italic', '900', '900italic')),
            'Alegreya SC' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400', 'italic', '700', '700italic', '900', '900italic')),
            'Alegreya Sans' => array('subsets' => array('latin', 'latin-ext', 'vietnamese'), 'variants' => array('100', '100italic', '300', '300italic', '400', 'italic', '500', '500italic', '700', '700italic', '800', '800italic', '900', '900italic')),
            'Alegreya Sans SC' => array('subsets' => array('latin', 'latin-ext', 'vietnamese'), 'variants' => array('100', '100italic', '300', '300italic', '400', 'italic', '500', '500italic', '700', '700italic', '800', '800italic', '900', '900italic')),
            'Alex Brush' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Alfa Slab One' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Alice' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Alike' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Alike Angular' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Allan' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400', '700')),
            'Allerta' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Allerta Stencil' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Allura' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Almendra' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400', 'italic', '700', '700italic')),
            'Almendra Display' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Almendra SC' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Amarante' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Amaranth' => array('subsets' => array('latin'), 'variants' => array('400', 'italic', '700', '700italic')),
            'Amatic SC' => array('subsets' => array('latin'), 'variants' => array('400', '700')),
            'Amethysta' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Anaheim' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Andada' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Andika' => array('subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'), 'variants' => array('400')),
            'Angkor' => array('subsets' => array('khmer'), 'variants' => array('400')),
            'Annie Use Your Telescope' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Anonymous Pro' => array('subsets' => array('cyrillic', 'greek-ext', 'cyrillic-ext', 'latin', 'latin-ext', 'greek'), 'variants' => array('400', 'italic', '700', '700italic')),
            'Antic' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Antic Didone' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Antic Slab' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Anton' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Arapey' => array('subsets' => array('latin'), 'variants' => array('400', 'italic')),
            'Arbutus' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Arbutus Slab' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Architects Daughter' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Archivo Black' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Archivo Narrow' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400', 'italic', '700', '700italic')),
            'Arimo' => array('subsets' => array('cyrillic', 'greek-ext', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese', 'greek'), 'variants' => array('400', 'italic', '700', '700italic')),
            'Arizonia' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Armata' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Artifika' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Arvo' => array('subsets' => array('latin'), 'variants' => array('400', 'italic', '700', '700italic')),
            'Asap' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400', 'italic', '700', '700italic')),
            'Asset' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Astloch' => array('subsets' => array('latin'), 'variants' => array('400', '700')),
            'Asul' => array('subsets' => array('latin'), 'variants' => array('400', '700')),
            'Atomic Age' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Aubrey' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Audiowide' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Autour One' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Average' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Average Sans' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Averia Gruesa Libre' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Averia Libre' => array('subsets' => array('latin'), 'variants' => array('300', '300italic', '400', 'italic', '700', '700italic')),
            'Averia Sans Libre' => array('subsets' => array('latin'), 'variants' => array('300', '300italic', '400', 'italic', '700', '700italic')),
            'Averia Serif Libre' => array('subsets' => array('latin'), 'variants' => array('300', '300italic', '400', 'italic', '700', '700italic')),
            'Bad Script' => array('subsets' => array('cyrillic', 'latin'), 'variants' => array('400')),
            'Balthazar' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Bangers' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Basic' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Battambang' => array('subsets' => array('khmer'), 'variants' => array('400', '700')),
            'Baumans' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Bayon' => array('subsets' => array('khmer'), 'variants' => array('400')),
            'Belgrano' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Belleza' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'BenchNine' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('300', '400', '700')),
            'Bentham' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Berkshire Swash' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Bevan' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Bigelow Rules' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Bigshot One' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Bilbo' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Bilbo Swash Caps' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Bitter' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400', 'italic', '700')),
            'Black Ops One' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Bokor' => array('subsets' => array('khmer'), 'variants' => array('400')),
            'Bonbon' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Boogaloo' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Bowlby One' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Bowlby One SC' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Brawler' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Bree Serif' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Bubblegum Sans' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Bubbler One' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Buda' => array('subsets' => array('latin'), 'variants' => array('300')),
            'Buenard' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400', '700')),
            'Butcherman' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Butterfly Kids' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Cabin' => array('subsets' => array('latin'), 'variants' => array('400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic')),
            'Cabin Condensed' => array('subsets' => array('latin'), 'variants' => array('400', '500', '600', '700')),
            'Cabin Sketch' => array('subsets' => array('latin'), 'variants' => array('400', '700')),
            'Caesar Dressing' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Cagliostro' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Calligraffitti' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Cambo' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Candal' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Cantarell' => array('subsets' => array('latin'), 'variants' => array('400', 'italic', '700', '700italic')),
            'Cantata One' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Cantora One' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Capriola' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Cardo' => array('subsets' => array('greek-ext', 'latin', 'latin-ext', 'greek'), 'variants' => array('400', 'italic', '700')),
            'Carme' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Carrois Gothic' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Carrois Gothic SC' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Carter One' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Caudex' => array('subsets' => array('greek-ext', 'latin', 'latin-ext', 'greek'), 'variants' => array('400', 'italic', '700', '700italic')),
            'Cedarville Cursive' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Ceviche One' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Changa One' => array('subsets' => array('latin'), 'variants' => array('400', 'italic')),
            'Chango' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Chau Philomene One' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400', 'italic')),
            'Chela One' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Chelsea Market' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Chenla' => array('subsets' => array('khmer'), 'variants' => array('400')),
            'Cherry Cream Soda' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Cherry Swash' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400', '700')),
            'Chewy' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Chicle' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Chivo' => array('subsets' => array('latin'), 'variants' => array('400', 'italic', '900', '900italic')),
            'Cinzel' => array('subsets' => array('latin'), 'variants' => array('400', '700', '900')),
            'Cinzel Decorative' => array('subsets' => array('latin'), 'variants' => array('400', '700', '900')),
            'Clicker Script' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Coda' => array('subsets' => array('latin'), 'variants' => array('400', '800')),
            'Coda Caption' => array('subsets' => array('latin'), 'variants' => array('800')),
            'Codystar' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('300', '400')),
            'Combo' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Comfortaa' => array('subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'greek'), 'variants' => array('300', '400', '700')),
            'Coming Soon' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Concert One' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Condiment' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Content' => array('subsets' => array('khmer'), 'variants' => array('400', '700')),
            'Contrail One' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Convergence' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Cookie' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Copse' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Corben' => array('subsets' => array('latin'), 'variants' => array('400', '700')),
            'Courgette' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Cousine' => array('subsets' => array('cyrillic', 'greek-ext', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese', 'greek'), 'variants' => array('400', 'italic', '700', '700italic')),
            'Coustard' => array('subsets' => array('latin'), 'variants' => array('400', '900')),
            'Covered By Your Grace' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Crafty Girls' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Creepster' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Crete Round' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400', 'italic')),
            'Crimson Text' => array('subsets' => array('latin'), 'variants' => array('400', 'italic', '600', '600italic', '700', '700italic')),
            'Croissant One' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Crushed' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Cuprum' => array('subsets' => array('cyrillic', 'latin', 'latin-ext'), 'variants' => array('400', 'italic', '700', '700italic')),
            'Cutive' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Cutive Mono' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Damion' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Dancing Script' => array('subsets' => array('latin'), 'variants' => array('400', '700')),
            'Dangrek' => array('subsets' => array('khmer'), 'variants' => array('400')),
            'Dawning of a New Day' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Days One' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Delius' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Delius Swash Caps' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Delius Unicase' => array('subsets' => array('latin'), 'variants' => array('400', '700')),
            'Della Respira' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Denk One' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Devonshire' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Didact Gothic' => array('subsets' => array('cyrillic', 'greek-ext', 'cyrillic-ext', 'latin', 'latin-ext', 'greek'), 'variants' => array('400')),
            'Diplomata' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Diplomata SC' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Domine' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400', '700')),
            'Donegal One' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Doppio One' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Dorsa' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Dosis' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('200', '300', '400', '500', '600', '700', '800')),
            'Dr Sugiyama' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Droid Sans' => array('subsets' => array('latin'), 'variants' => array('400', '700')),
            'Droid Sans Mono' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Droid Serif' => array('subsets' => array('latin'), 'variants' => array('400', 'italic', '700', '700italic')),
            'Duru Sans' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Dynalight' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'EB Garamond' => array('subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'), 'variants' => array('400')),
            'Eagle Lake' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Eater' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Economica' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400', 'italic', '700', '700italic')),
            'Electrolize' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Elsie' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400', '900')),
            'Elsie Swash Caps' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400', '900')),
            'Emblema One' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Emilys Candy' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Engagement' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Englebert' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Enriqueta' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400', '700')),
            'Erica One' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Esteban' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Euphoria Script' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Ewert' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Exo' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic')),
            'Exo 2' => array('subsets' => array('cyrillic', 'latin', 'latin-ext'), 'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic')),
            'Expletus Sans' => array('subsets' => array('latin'), 'variants' => array('400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic')),
            'Fanwood Text' => array('subsets' => array('latin'), 'variants' => array('400', 'italic')),
            'Fascinate' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Fascinate Inline' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Faster One' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Fasthand' => array('subsets' => array('khmer'), 'variants' => array('400')),
            'Fauna One' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Federant' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Federo' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Felipa' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Fenix' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Finger Paint' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Fjalla One' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Fjord One' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Flamenco' => array('subsets' => array('latin'), 'variants' => array('300', '400')),
            'Flavors' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Fondamento' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400', 'italic')),
            'Fontdiner Swanky' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Forum' => array('subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'), 'variants' => array('400')),
            'Francois One' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Freckle Face' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Fredericka the Great' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Fredoka One' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Freehand' => array('subsets' => array('khmer'), 'variants' => array('400')),
            'Fresca' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Frijole' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Fruktur' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Fugaz One' => array('subsets' => array('latin'), 'variants' => array('400')),
            'GFS Didot' => array('subsets' => array('greek'), 'variants' => array('400')),
            'GFS Neohellenic' => array('subsets' => array('greek'), 'variants' => array('400', 'italic', '700', '700italic')),
            'Gabriela' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Gafata' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Galdeano' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Galindo' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Gentium Basic' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400', 'italic', '700', '700italic')),
            'Gentium Book Basic' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400', 'italic', '700', '700italic')),
            'Geo' => array('subsets' => array('latin'), 'variants' => array('400', 'italic')),
            'Geostar' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Geostar Fill' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Germania One' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Gilda Display' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Give You Glory' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Glass Antiqua' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Glegoo' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Gloria Hallelujah' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Goblin One' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Gochi Hand' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Gorditas' => array('subsets' => array('latin'), 'variants' => array('400', '700')),
            'Goudy Bookletter 1911' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Graduate' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Grand Hotel' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Gravitas One' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Great Vibes' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Griffy' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Gruppo' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Gudea' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400', 'italic', '700')),
            'Habibi' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Hammersmith One' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Hanalei' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Hanalei Fill' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Handlee' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Hanuman' => array('subsets' => array('khmer'), 'variants' => array('400', '700')),
            'Happy Monkey' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Headland One' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Henny Penny' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Herr Von Muellerhoff' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Holtwood One SC' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Homemade Apple' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Homenaje' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'IM Fell DW Pica' => array('subsets' => array('latin'), 'variants' => array('400', 'italic')),
            'IM Fell DW Pica SC' => array('subsets' => array('latin'), 'variants' => array('400')),
            'IM Fell Double Pica' => array('subsets' => array('latin'), 'variants' => array('400', 'italic')),
            'IM Fell Double Pica SC' => array('subsets' => array('latin'), 'variants' => array('400')),
            'IM Fell English' => array('subsets' => array('latin'), 'variants' => array('400', 'italic')),
            'IM Fell English SC' => array('subsets' => array('latin'), 'variants' => array('400')),
            'IM Fell French Canon' => array('subsets' => array('latin'), 'variants' => array('400', 'italic')),
            'IM Fell French Canon SC' => array('subsets' => array('latin'), 'variants' => array('400')),
            'IM Fell Great Primer' => array('subsets' => array('latin'), 'variants' => array('400', 'italic')),
            'IM Fell Great Primer SC' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Iceberg' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Iceland' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Imprima' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Inconsolata' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400', '700')),
            'Inder' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Indie Flower' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Inika' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400', '700')),
            'Irish Grover' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Istok Web' => array('subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'), 'variants' => array('400', 'italic', '700', '700italic')),
            'Italiana' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Italianno' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Jacques Francois' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Jacques Francois Shadow' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Jim Nightshade' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Jockey One' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Jolly Lodger' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Josefin Sans' => array('subsets' => array('latin'), 'variants' => array('100', '100italic', '300', '300italic', '400', 'italic', '600', '600italic', '700', '700italic')),
            'Josefin Slab' => array('subsets' => array('latin'), 'variants' => array('100', '100italic', '300', '300italic', '400', 'italic', '600', '600italic', '700', '700italic')),
            'Joti One' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Judson' => array('subsets' => array('latin'), 'variants' => array('400', 'italic', '700')),
            'Julee' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Julius Sans One' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Junge' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Jura' => array('subsets' => array('cyrillic', 'greek-ext', 'cyrillic-ext', 'latin', 'latin-ext', 'greek'), 'variants' => array('300', '400', '500', '600')),
            'Just Another Hand' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Just Me Again Down Here' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Kameron' => array('subsets' => array('latin'), 'variants' => array('400', '700')),
            'Kantumruy' => array('subsets' => array('khmer'), 'variants' => array('300', '400', '700')),
            'Karla' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400', 'italic', '700', '700italic')),
            'Kaushan Script' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Kavoon' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Kdam Thmor' => array('subsets' => array('khmer'), 'variants' => array('400')),
            'Keania One' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Kelly Slab' => array('subsets' => array('cyrillic', 'latin', 'latin-ext'), 'variants' => array('400')),
            'Kenia' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Khmer' => array('subsets' => array('khmer'), 'variants' => array('400')),
            'Kite One' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Knewave' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Kotta One' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Koulen' => array('subsets' => array('khmer'), 'variants' => array('400')),
            'Kranky' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Kreon' => array('subsets' => array('latin'), 'variants' => array('300', '400', '700')),
            'Kristi' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Krona One' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'La Belle Aurore' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Lancelot' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Lato' => array('subsets' => array('latin'), 'variants' => array('100', '100italic', '300', '300italic', '400', 'italic', '700', '700italic', '900', '900italic')),
            'League Script' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Leckerli One' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Ledger' => array('subsets' => array('cyrillic', 'latin', 'latin-ext'), 'variants' => array('400')),
            'Lekton' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400', 'italic', '700')),
            'Lemon' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Libre Baskerville' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400', 'italic', '700')),
            'Life Savers' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400', '700')),
            'Lilita One' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Lily Script One' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Limelight' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Linden Hill' => array('subsets' => array('latin'), 'variants' => array('400', 'italic')),
            'Lobster' => array('subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'), 'variants' => array('400')),
            'Lobster Two' => array('subsets' => array('latin'), 'variants' => array('400', 'italic', '700', '700italic')),
            'Londrina Outline' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Londrina Shadow' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Londrina Sketch' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Londrina Solid' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Lora' => array('subsets' => array('cyrillic', 'latin', 'latin-ext'), 'variants' => array('400', 'italic', '700', '700italic')),
            'Love Ya Like A Sister' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Loved by the King' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Lovers Quarrel' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Luckiest Guy' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Lusitana' => array('subsets' => array('latin'), 'variants' => array('400', '700')),
            'Lustria' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Macondo' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Macondo Swash Caps' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Magra' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400', '700')),
            'Maiden Orange' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Mako' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Marcellus' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Marcellus SC' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Marck Script' => array('subsets' => array('cyrillic', 'latin', 'latin-ext'), 'variants' => array('400')),
            'Margarine' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Marko One' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Marmelad' => array('subsets' => array('cyrillic', 'latin', 'latin-ext'), 'variants' => array('400')),
            'Marvel' => array('subsets' => array('latin'), 'variants' => array('400', 'italic', '700', '700italic')),
            'Mate' => array('subsets' => array('latin'), 'variants' => array('400', 'italic')),
            'Mate SC' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Maven Pro' => array('subsets' => array('latin'), 'variants' => array('400', '500', '700', '900')),
            'McLaren' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Meddon' => array('subsets' => array('latin'), 'variants' => array('400')),
            'MedievalSharp' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Medula One' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Megrim' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Meie Script' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Merienda' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400', '700')),
            'Merienda One' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Merriweather' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('300', '300italic', '400', 'italic', '700', '700italic', '900', '900italic')),
            'Merriweather Sans' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('300', '300italic', '400', 'italic', '700', '700italic', '800', '800italic')),
            'Metal' => array('subsets' => array('khmer'), 'variants' => array('400')),
            'Metal Mania' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Metamorphous' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Metrophobic' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Michroma' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Milonga' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Miltonian' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Miltonian Tattoo' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Miniver' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Miss Fajardose' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Modern Antiqua' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Molengo' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Molle' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('italic')),
            'Monda' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400', '700')),
            'Monofett' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Monoton' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Monsieur La Doulaise' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Montaga' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Montez' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Montserrat' => array('subsets' => array('latin'), 'variants' => array('400','500', '700')),
            'Montserrat Alternates' => array('subsets' => array('latin'), 'variants' => array('400', '700')),
            'Montserrat Subrayada' => array('subsets' => array('latin'), 'variants' => array('400', '700')),
            'Moul' => array('subsets' => array('khmer'), 'variants' => array('400')),
            'Moulpali' => array('subsets' => array('khmer'), 'variants' => array('400')),
            'Mountains of Christmas' => array('subsets' => array('latin'), 'variants' => array('400', '700')),
            'Mouse Memoirs' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Mr Bedfort' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Mr Dafoe' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Mr De Haviland' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Mrs Saint Delafield' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Mrs Sheppards' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Muli' => array('subsets' => array('latin'), 'variants' => array('300', '300italic', '400', 'italic')),
            'Mystery Quest' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Neucha' => array('subsets' => array('cyrillic', 'latin'), 'variants' => array('400')),
            'Neuton' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('200', '300', '400', 'italic', '700', '800')),
            'New Rocker' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'News Cycle' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400', '700')),
            'Niconne' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Nixie One' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Nobile' => array('subsets' => array('latin'), 'variants' => array('400', 'italic', '700', '700italic')),
            'Nokora' => array('subsets' => array('khmer'), 'variants' => array('400', '700')),
            'Norican' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Nosifer' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Nothing You Could Do' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Noticia Text' => array('subsets' => array('latin', 'latin-ext', 'vietnamese'), 'variants' => array('400', 'italic', '700', '700italic')),
            'Noto Sans' => array('subsets' => array('cyrillic', 'greek-ext', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese', 'greek'), 'variants' => array('400', 'italic', '700', '700italic')),
            'Noto Serif' => array('subsets' => array('cyrillic', 'greek-ext', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese', 'greek'), 'variants' => array('400', 'italic', '700', '700italic')),
            'Nova Cut' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Nova Flat' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Nova Mono' => array('subsets' => array('latin', 'greek'), 'variants' => array('400')),
            'Nova Oval' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Nova Round' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Nova Script' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Nova Slim' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Nova Square' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Numans' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Nunito' => array('subsets' => array('latin'), 'variants' => array('300', '400', '700')),
            'Odor Mean Chey' => array('subsets' => array('khmer'), 'variants' => array('400')),
            'Offside' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Old Standard TT' => array('subsets' => array('latin'), 'variants' => array('400', 'italic', '700')),
            'Oldenburg' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Oleo Script' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400', '700')),
            'Oleo Script Swash Caps' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400', '700')),
            'Open Sans' => array('subsets' => array('cyrillic', 'greek-ext', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese', 'greek'), 'variants' => array('300', '300italic', '400', 'italic', '600', '600italic', '700', '700italic', '800', '800italic')),
            'Open Sans Condensed' => array('subsets' => array('cyrillic', 'greek-ext', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese', 'greek'), 'variants' => array('300', '300italic', '700')),
            'Oranienbaum' => array('subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'), 'variants' => array('400')),
            'Orbitron' => array('subsets' => array('latin'), 'variants' => array('400', '500', '700', '900')),
            'Oregano' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400', 'italic')),
            'Orienta' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Original Surfer' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Oswald' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('300', '400', '700')),
            'Over the Rainbow' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Overlock' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400', 'italic', '700', '700italic', '900', '900italic')),
            'Overlock SC' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Ovo' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Oxygen' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('300', '400', '700')),
            'Oxygen Mono' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'PT Mono' => array('subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'), 'variants' => array('400')),
            'PT Sans' => array('subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'), 'variants' => array('400', 'italic', '700', '700italic')),
            'PT Sans Caption' => array('subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'), 'variants' => array('400', '700')),
            'PT Sans Narrow' => array('subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'), 'variants' => array('400', '700')),
            'PT Serif' => array('subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'), 'variants' => array('400', 'italic', '700', '700italic')),
            'PT Serif Caption' => array('subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'), 'variants' => array('400', 'italic')),
            'Pacifico' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Paprika' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Parisienne' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Passero One' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Passion One' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400', '700', '900')),
            'Pathway Gothic One' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Patrick Hand' => array('subsets' => array('latin', 'latin-ext', 'vietnamese'), 'variants' => array('400')),
            'Patrick Hand SC' => array('subsets' => array('latin', 'latin-ext', 'vietnamese'), 'variants' => array('400')),
            'Patua One' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Paytone One' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Peralta' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Permanent Marker' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Petit Formal Script' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Petrona' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Philosopher' => array('subsets' => array('cyrillic', 'latin'), 'variants' => array('400', 'italic', '700', '700italic')),
            'Piedra' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Pinyon Script' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Pirata One' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Plaster' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Play' => array('subsets' => array('cyrillic', 'greek-ext', 'cyrillic-ext', 'latin', 'latin-ext', 'greek'), 'variants' => array('400', '700')),
            'Playball' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Playfair Display' => array('subsets' => array('cyrillic', 'latin', 'latin-ext'), 'variants' => array('400', 'italic', '700', '700italic', '900', '900italic')),
            'Playfair Display SC' => array('subsets' => array('cyrillic', 'latin', 'latin-ext'), 'variants' => array('400', 'italic', '700', '700italic', '900', '900italic')),
            'Podkova' => array('subsets' => array('latin'), 'variants' => array('400', '700')),
            'Poiret One' => array('subsets' => array('cyrillic', 'latin', 'latin-ext'), 'variants' => array('400')),
            'Poller One' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Poly' => array('subsets' => array('latin'), 'variants' => array('400', 'italic')),
            'Pompiere' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Pontano Sans' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Port Lligat Sans' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Port Lligat Slab' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Prata' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Preahvihear' => array('subsets' => array('khmer'), 'variants' => array('400')),
            'Press Start 2P' => array('subsets' => array('cyrillic', 'latin', 'latin-ext', 'greek'), 'variants' => array('400')),
            'Princess Sofia' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Prociono' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Prosto One' => array('subsets' => array('cyrillic', 'latin', 'latin-ext'), 'variants' => array('400')),
            'Puritan' => array('subsets' => array('latin'), 'variants' => array('400', 'italic', '700', '700italic')),
            'Purple Purse' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Quando' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Quantico' => array('subsets' => array('latin'), 'variants' => array('400', 'italic', '700', '700italic')),
            'Quattrocento' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400', '700')),
            'Quattrocento Sans' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400', 'italic', '700', '700italic')),
            'Questrial' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Quicksand' => array('subsets' => array('latin'), 'variants' => array('300', '400', '700')),
            'Quintessential' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Qwigley' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Racing Sans One' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Radley' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400', 'italic')),
            'Raleway' => array('subsets' => array('latin'), 'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900')),
            'Raleway Dots' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Rambla' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400', 'italic', '700', '700italic')),
            'Rammetto One' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Ranchers' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Rancho' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Rationale' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Redressed' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Reenie Beanie' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Revalia' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Ribeye' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Ribeye Marrow' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Righteous' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Risque' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Roboto' => array('subsets' => array('cyrillic', 'greek-ext', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese', 'greek'), 'variants' => array('100', '100italic', '300', '300italic', '400', 'italic', '500', '500italic', '700', '700italic', '900', '900italic')),
            'Roboto Condensed' => array('subsets' => array('cyrillic', 'greek-ext', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese', 'greek'), 'variants' => array('300', '300italic', '400', 'italic', '700', '700italic')),
            'Roboto Slab' => array('subsets' => array('cyrillic', 'greek-ext', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese', 'greek'), 'variants' => array('100', '300', '400', '700')),
            'Rochester' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Rock Salt' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Rokkitt' => array('subsets' => array('latin'), 'variants' => array('400', '700')),
            'Romanesco' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Ropa Sans' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400', 'italic')),
            'Rosario' => array('subsets' => array('latin'), 'variants' => array('400', 'italic', '700', '700italic')),
            'Rosarivo' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400', 'italic')),
            'Rouge Script' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Ruda' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400', '700', '900')),
            'Rufina' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400', '700')),
            'Ruge Boogie' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Ruluko' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Rum Raisin' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Ruslan Display' => array('subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'), 'variants' => array('400')),
            'Russo One' => array('subsets' => array('cyrillic', 'latin', 'latin-ext'), 'variants' => array('400')),
            'Ruthie' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Rye' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Sacramento' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Sail' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Salsa' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Sanchez' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400', 'italic')),
            'Sancreek' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Sansita One' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Sarina' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Satisfy' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Scada' => array('subsets' => array('cyrillic', 'latin', 'latin-ext'), 'variants' => array('400', 'italic', '700', '700italic')),
            'Schoolbell' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Seaweed Script' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Sevillana' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Seymour One' => array('subsets' => array('cyrillic', 'latin', 'latin-ext'), 'variants' => array('400')),
            'Shadows Into Light' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Shadows Into Light Two' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Shanti' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Share' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400', 'italic', '700', '700italic')),
            'Share Tech' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Share Tech Mono' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Shojumaru' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Short Stack' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Siemreap' => array('subsets' => array('khmer'), 'variants' => array('400')),
            'Sigmar One' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Signika' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('300', '400', '600', '700')),
            'Signika Negative' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('300', '400', '600', '700')),
            'Simonetta' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400', 'italic', '900', '900italic')),
            'Sintony' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400', '700')),
            'Sirin Stencil' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Six Caps' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Skranji' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400', '700')),
            'Slackey' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Smokum' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Smythe' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Sniglet' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400', '800')),
            'Snippet' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Snowburst One' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Sofadi One' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Sofia' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Sonsie One' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Sorts Mill Goudy' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400', 'italic')),
            'Source Code Pro' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('200', '300', '400', '500', '600', '700', '900')),
            'Source Sans Pro' => array('subsets' => array('latin', 'latin-ext', 'vietnamese'), 'variants' => array('200', '200italic', '300', '300italic', '400', 'italic', '600', '600italic', '700', '700italic', '900', '900italic')),
            'Special Elite' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Spicy Rice' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Spinnaker' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Spirax' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Squada One' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Stalemate' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Stalinist One' => array('subsets' => array('cyrillic', 'latin', 'latin-ext'), 'variants' => array('400')),
            'Stardos Stencil' => array('subsets' => array('latin'), 'variants' => array('400', '700')),
            'Stint Ultra Condensed' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Stint Ultra Expanded' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Stoke' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('300', '400')),
            'Strait' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Sue Ellen Francisco' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Sunshiney' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Supermercado One' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Suwannaphum' => array('subsets' => array('khmer'), 'variants' => array('400')),
            'Swanky and Moo Moo' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Syncopate' => array('subsets' => array('latin'), 'variants' => array('400', '700')),
            'Tangerine' => array('subsets' => array('latin'), 'variants' => array('400', '700')),
            'Taprom' => array('subsets' => array('khmer'), 'variants' => array('400')),
            'Tauri' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Telex' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Tenor Sans' => array('subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'), 'variants' => array('400')),
            'Text Me One' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'The Girl Next Door' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Tienne' => array('subsets' => array('latin'), 'variants' => array('400', '700', '900')),
            'Tinos' => array('subsets' => array('cyrillic', 'greek-ext', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese', 'greek'), 'variants' => array('400', 'italic', '700', '700italic')),
            'Titan One' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Titillium Web' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('200', '200italic', '300', '300italic', '400', 'italic', '600', '600italic', '700', '700italic', '900')),
            'Trade Winds' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Trocchi' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Trochut' => array('subsets' => array('latin'), 'variants' => array('400', 'italic', '700')),
            'Trykker' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Tulpen One' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Ubuntu' => array('subsets' => array('cyrillic', 'greek-ext', 'cyrillic-ext', 'latin', 'latin-ext', 'greek'), 'variants' => array('300', '300italic', '400', 'italic', '500', '500italic', '700', '700italic')),
            'Ubuntu Condensed' => array('subsets' => array('cyrillic', 'greek-ext', 'cyrillic-ext', 'latin', 'latin-ext', 'greek'), 'variants' => array('400')),
            'Ubuntu Mono' => array('subsets' => array('cyrillic', 'greek-ext', 'cyrillic-ext', 'latin', 'latin-ext', 'greek'), 'variants' => array('400', 'italic', '700', '700italic')),
            'Ultra' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Uncial Antiqua' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Underdog' => array('subsets' => array('cyrillic', 'latin', 'latin-ext'), 'variants' => array('400')),
            'Unica One' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'UnifrakturCook' => array('subsets' => array('latin'), 'variants' => array('700')),
            'UnifrakturMaguntia' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Unkempt' => array('subsets' => array('latin'), 'variants' => array('400', '700')),
            'Unlock' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Unna' => array('subsets' => array('latin'), 'variants' => array('400')),
            'VT323' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Vampiro One' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Varela' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Varela Round' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Vast Shadow' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Vibur' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Vidaloka' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Viga' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Voces' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Volkhov' => array('subsets' => array('latin'), 'variants' => array('400', 'italic', '700', '700italic')),
            'Vollkorn' => array('subsets' => array('latin'), 'variants' => array('400', 'italic', '700', '700italic')),
            'Voltaire' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Waiting for the Sunrise' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Wallpoet' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Walter Turncoat' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Warnes' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Wellfleet' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Wendy One' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('400')),
            'Wire One' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Yanone Kaffeesatz' => array('subsets' => array('latin', 'latin-ext'), 'variants' => array('200', '300', '400', '700')),
            'Yellowtail' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Yeseva One' => array('subsets' => array('cyrillic', 'latin', 'latin-ext'), 'variants' => array('400')),
            'Yesteryear' => array('subsets' => array('latin'), 'variants' => array('400')),
            'Zeyada' => array('subsets' => array('latin'), 'variants' => array('400')),
			'None' => ''
        );

    }

    /* ------------------------------------------------------------- */
    /*  GET CONTENT
    /* ------------------------------------------------------------- */
    public function getContent()
    {
        $id_shop = $this->context->shop->id;
        $languages = $this->context->language->getLanguages();
        $errors = array();
		  $reset_tables='<form class="import_demo"  method="post" action="'.$this->context->link->getAdminLink('AdminModules', false).'&reset_tables&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'">	
		<button type="submit" class="btn btn-default btn-lg" style="margin-bottom:20px;float:left;margin-right:20px;"><span class="icon icon-refresh"></span>&nbsp;&nbsp;'.$this->l('Refresh Tables').'</button></form><form class="import_demo"  method="post" action="'.$this->context->link->getAdminLink('AdminModules', false).'&reset_link_page&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'">	
		<button type="submit" class="btn btn-default btn-lg" style="margin-bottom:20px;"><span class="icon icon-refresh"></span>&nbsp;&nbsp;'.$this->l('Refresh Link Page').'</button></form>';
        // Load css file for option panel
        $this->context->controller->addCSS(_MODULE_DIR_ . $this->name . '/views/css/admin/admin.css');

        // Load js file for option panel
		$this->context->controller->addJS($this->_path.'views/js/admin/jquery.ntp.js');
		
		if (Tools::isSubmit('reset_link_page')) {
			if (file_exists(_PS_THEME_DIR_. 'link_default.php')){
				require_once(_PS_THEME_DIR_. 'link_default.php');
				if(isset($link_default)){
					//config
					$links_page = Db::getInstance()->executeS('
					SELECT *
					FROM `'._DB_PREFIX_.'configuration`  
					WHERE `value` like "%'.$link_default.'%"');
					foreach($links_page as $link_page){
						Configuration::updateValue($link_page['name'],str_replace($link_default,__PS_BASE_URI__,$link_page['value']));
					}
					//config by lang
					$links_page_lang = Db::getInstance()->executeS('
					SELECT '._DB_PREFIX_.'configuration.id_configuration,'._DB_PREFIX_.'configuration.name,'._DB_PREFIX_.'configuration_lang.value,'._DB_PREFIX_.'configuration_lang.id_lang
					FROM '._DB_PREFIX_.'configuration
					INNER JOIN '._DB_PREFIX_.'configuration_lang
					ON '._DB_PREFIX_.'configuration.id_configuration = '._DB_PREFIX_.'configuration_lang.id_configuration
					WHERE '._DB_PREFIX_.'configuration_lang.value like "%'.$link_default.'%" GROUP BY '._DB_PREFIX_.'configuration.id_configuration');
					$values_lang = Db::getInstance()->executeS('
					SELECT '._DB_PREFIX_.'configuration.id_configuration,'._DB_PREFIX_.'configuration.name,'._DB_PREFIX_.'configuration_lang.value,'._DB_PREFIX_.'configuration_lang.id_lang
					FROM '._DB_PREFIX_.'configuration
					INNER JOIN '._DB_PREFIX_.'configuration_lang
					ON '._DB_PREFIX_.'configuration.id_configuration = '._DB_PREFIX_.'configuration_lang.id_configuration
					WHERE '._DB_PREFIX_.'configuration_lang.value like "%'.$link_default.'%"');
					foreach($links_page_lang as $link_page_lang){
						$value_=array();
						foreach($values_lang as $value_lang){
								if($value_lang['id_configuration']==$link_page_lang['id_configuration']){
									$value_[$value_lang['id_lang']]=str_replace($link_default,__PS_BASE_URI__,$value_lang['value']);
								}
						}
Configuration::updateValue($link_page_lang['name'],str_replace($link_default,__PS_BASE_URI__,$value_),true);
					}
				}
			}
		}
        elseif (Tools::isSubmit('reset_tables')) {
			$parentTabID = Tab::getIdFromClassName('AdminNrtMenu');
			$tables = Db::getInstance()->executeS('
			SELECT id_tab
			FROM `'._DB_PREFIX_.'tab`  
			WHERE `id_parent` = 0 AND active =0 AND id_tab > '.$parentTabID);
			foreach($tables as $table){
		 Db::getInstance()->execute('DELETE FROM `'._DB_PREFIX_.'tab` WHERE `id_tab` = '.$table['id_tab'].'');
		 Db::getInstance()->execute('DELETE FROM `'._DB_PREFIX_.'tab_lang` WHERE `id_tab` = '.$table['id_tab'].'');
			}
		}
        elseif (Tools::isSubmit('submit' . $this->name)) {

            // Standard config
            foreach ($this->_standardConfig as $config) {
                if (Tools::isSubmit($config)) {
                    Configuration::updateValue($config, Tools::getValue($config));
                }
            }

            // Style config
            foreach ($this->_styleConfig as $config) {

                // Check if the config is a background image
                if (in_array($config, $this->_bgImageConfig)) {
                    if (isset($_FILES[$config]) && isset($_FILES[$config]['tmp_name']) && !empty($_FILES[$config]['tmp_name'])) {
                        if ($error = ImageManager::validateUpload($_FILES[$config], Tools::convertBytes(ini_get('upload_max_filesize')))) {
                            $errors[] = $error;
                        }
                        else {
                            $imageName = explode('.', $_FILES[$config]['name']);
                            $imageExt = $imageName[1];
                            $imageName = $imageName[0];
                            $backgroundImageName = $imageName . '-' . $id_shop . '.' . $imageExt;

                            if (!move_uploaded_file($_FILES[$config]['tmp_name'], _PS_MODULE_DIR_ . $this->name . '/views/img/front/bg/' . $backgroundImageName)) {
                                $errors[] = $this->l('File upload error.');
                            }
                            else {
                                Configuration::updateValue($config, $backgroundImageName);
                            }
                        }
                    }

                    continue;
                }

                if (Tools::isSubmit($config)) {
                    Configuration::updateValue($config, Tools::getValue($config));
                }

            }

            // Custom Codes
            if (Tools::isSubmit('NRT_customCSS')) {
                Configuration::updateValue('NRT_customCSS', Tools::getValue('NRT_customCSS'));
            }

            if (Tools::isSubmit('NRT_customJS')) {
                Configuration::updateValue('NRT_customJS', Tools::getValue('NRT_customJS'));
            }

            // Write the configurations to a CSS file
            $response = $this->_writeCss();
            if (!$response) {
                $errors[] = $this->l('An error occured while writing the css file!');
            }

            // Prepare the output
            if (count($errors)) {
                $this->_output .= $this->displayError(implode('<br />', $errors));
            }
            else {
                $this->_output .= $this->displayConfirmation($this->l('Configuration updated'));
            }

        }
        elseif (Tools::isSubmit('deleteConfig')) {
            $config = Tools::getValue('deleteConfig');
            $configValue = Configuration::get($config);

            if (file_exists(_PS_MODULE_DIR_ . $this->name . '/views/img/front/bg/' . $configValue)) {
                unlink(_PS_MODULE_DIR_ . $this->name . '/views/img/front/bg/' . $configValue);
            }

            Configuration::updateValue($config, null);

        }

        return $reset_tables.$this->_output . $this->_displayForm();
    }

    /* ------------------------------------------------------------- */
    /*  DISPLAY CONFIGURATION FORM
    /* ------------------------------------------------------------- */
    private function _displayForm()
    {
        $id_default_lang = $this->context->language->id;
        $languages = $this->context->language->getLanguages();
        $id_shop = $this->context->shop->id;

        // General Options
        $layoutTypes = array(
            array(
                'value' => 'fullwidth',
                'name' => 'FullWidth'
            ),
            array(
                'value' => 'boxed',
                'name' => 'Boxed'
            )
        );

        // Background Options
        $backgroundRepeatOptions = array(
            array(
                'value' => 'repeat-x',
                'name' => 'Repeat-X'
            ),
            array(
                'value' => 'repeat-y',
                'name' => 'Repeat-Y'
            ),
            array(
                'value' => 'repeat',
                'name' => 'Repeat Both'
            ),
            array(
                'value' => 'no-repeat',
                'name' => 'No Repeat'
            )
        );

        $backgroundAttachmentOptions = array(
            array(
                'value' => 'scroll',
                'name' => 'Scroll'
            ),
            array(
                'value' => 'fixed',
                'name' => 'Fixed'
            )
        );

        $backgroundSizeOptions = array(
            array(
                'value' => 'auto',
                'name' => 'Auto'
            ),
            array(
                'value' => 'cover',
                'name' => 'Cover'
            )
        );

        // Font Options
        $fontOptions = array();

        foreach ($this->_websafeFonts as $fontName){
            $fontOptions[] = array(
                'value' => $fontName,
                'name' => $fontName
            );
        }

        foreach ($this->_googleFonts as $fontName => $fontInfo){
            $fontOptions[] = array(
                'value' => $fontName,
                'name' => $fontName
            );
        }
        $fields_form = array(
            'nrt-general' => array(
                'form' => array(
                    'legend' => array(
                        'title' => $this->l('General'),
                        'icon' => 'icon-cog'
                    ),
                    'input' => array(
					array(
                            'type' => 'select',
                            'name' => 'NRT_mainLayout',
                            'label' => $this->l('Layout type'),
                            'required' => false,
                            'lang' => false,
                            'options' => array(
                                'query' => $layoutTypes,
                                'id' => 'value',
                                'name' => 'name'
                            )
                        ),
                        array(
                            'type' => 'switch',
                            'name' => 'NRT_showPanelTool',
                            'label' => $this->l('Show paneltool'),
                            'required' => false,
                            'is_bool' => true,
                            'values' => array(
                                array(
                                    'id' => 'showPanelTool_on',
                                    'value' => 1,
                                    'label' => $this->l('On')
                                ),
                                array(
                                    'id' => 'showPanelTool_off',
                                    'value' => 0,
                                    'label' => $this->l('Off')
                                )
                            )
                        ),
                        array(
                            'type' => 'switch',
                            'name' => 'NRT_enableCountdownTimer',
                            'label' => $this->l('Enable Countdown Timers'),
                            'desc' => $this->l('This option enables/disables countdown timers for timed specific prices.'),
                            'required' => false,
                            'is_bool' => true,
                            'values' => array(
                                array(
                                    'id' => 'timer_on',
                                    'value' => 1,
                                    'label' => $this->l('On')
                                ),
                                array(
                                    'id' => 'timer_off',
                                    'value' => 0,
                                    'label' => $this->l('Off')
                                )
                            )
                        ),
                        array(
                            'type' => 'switch',
                            'label' => $this->l('Enable quick view'),
                            'name' => 'NRT_quickView',
                            'required' => false,
                            'is_bool' => true,
                            'values' => array(
                                array(
                                    'id' => 'quickview_on',
                                    'value' => 1,
                                    'label' => $this->l('Yes')
                                ),
                                array(
                                    'id' => 'quickview_off',
                                    'value' => 0,
                                    'label' => $this->l('No')
                                )
                            )
                        ),
                        array(
                            'type' => 'switch',
                            'label' => $this->l('Embed Google maps Javascript'),
                            'name' => 'NRT_GGMapsJava',
                            'required' => false,
                            'is_bool' => true,
                            'values' => array(
                                array(
                                    'id' => 'GGMapsJava_on',
                                    'value' => 1,
                                    'label' => $this->l('Yes')
                                ),
                                array(
                                    'id' => 'GGMapsJava_off',
                                    'value' => 0,
                                    'label' => $this->l('No')
                                )
                            )
                        ),
                        array(
                            'type' => 'text',
                            'label' => $this->l('Google Maps API keys'),
                            'name' => 'NRT_GGMapsAPIKeys',
                            'required' => false,
                            'class' => 'fixed-width-xxl'
                        ),
                        array(
                            'type' => 'hidden',
                            'label' => $this->l('Show average rating stars'),
                            'name' => 'NRT_categoryShowAvgRating',
                            'required' => false,
                            'is_bool' => true,
                            'values' => array(
                                array(
                                    'id' => 'avgratings_on',
                                    'value' => 1,
                                    'label' => $this->l('Yes')
                                ),
                                array(
                                    'id' => 'avgratings_off',
                                    'value' => 0,
                                    'label' => $this->l('No')
                                )
                            )
                        )
                    ),
                    // Submit Button
                    'submit' => array(
                        'title' => $this->l('Save'),
                        'name' => 'savenrtThemeConfig'
                    )
                )
            ),
            'nrt-header' => array(
                'form' => array(
                    'legend' => array(
                        'title' => $this->l('Header'),
                        'icon' => 'icon-cog'
                    ),
                    'input' => array(
                        array(
                            'type' => 'switch',
                            'label' => $this->l('Sticky menu'),
                            'name' => 'NRT_stickyMenu',
                            'required' => false,
                            'is_bool' => true,
                            'values' => array(
                                array(
                                    'id' => 'stickymenu_on',
                                    'value' => 1,
                                    'label' => $this->l('On')
                                ),
                                array(
                                    'id' => 'stickymenu_off',
                                    'value' => 0,
                                    'label' => $this->l('Off')
                                )
                            )
                        ),
                        array(
                            'type' => 'switch',
                            'label' => $this->l('Sticky Search'),
                            'name' => 'NRT_stickySearch',
                            'required' => false,
                            'is_bool' => true,
                            'values' => array(
                                array(
                                    'id' => 'stickysearch_on',
                                    'value' => 1,
                                    'label' => $this->l('On')
                                ),
                                array(
                                    'id' => 'stickysearch_off',
                                    'value' => 0,
                                    'label' => $this->l('Off')
                                )
                            )
                        ),
                        array(
                            'type' => 'switch',
                            'label' => $this->l('Sticky Cart'),
                            'name' => 'NRT_stickyCart',
                            'required' => false,
                            'is_bool' => true,
                            'values' => array(
                                array(
                                    'id' => 'stickymenucart_on',
                                    'value' => 1,
                                    'label' => $this->l('On')
                                ),
                                array(
                                    'id' => 'stickycart_off',
                                    'value' => 0,
                                    'label' => $this->l('Off')
                                )
                            )
                        )
		    ),
                    // Submit Button
                    'submit' => array(
                        'title' => $this->l('Save'),
                        'name' => 'savenrtThemeConfig'
                    )
                )
            ),
            'nrt-categorypages' => array(
                'form' => array(
                    'legend' => array(
                        'title' => $this->l('Category Pages'),
                        'icon' => 'icon-cog'
                    ),
                    'input' => array(
			array(
                            'type' => 'switch',
                            'label' => $this->l('Display categories as a list of products instead of the default grid-based display'),
                            'name' => 'PS_GRID_PRODUCT',
                            'required' => false,
                            'is_bool' => true,
			    'desc' => $this->l('Works only for first-time users. This setting is overridden by the user\'s choice as soon as the user cookie is set.'),
                            'values' => array(
                                array(
                                    'id' => 'grid_list_on',
                                    'value' => 1,
                                    'label' => $this->l('Yes')
                                ),
                                array(
                                    'id' => 'grid_list_off',
                                    'value' => 0,
                                    'label' => $this->l('No')
                                )
                            )
                        ),
                        array(
                            'type' => 'switch',
                            'label' => $this->l('Show subcategories'),
                            'name' => 'NRT_subcategories',
                            'required' => false,
                            'is_bool' => true,
                            'values' => array(
                                array(
                                    'id' => 'subcategories_on',
                                    'value' => 1,
                                    'label' => $this->l('Yes')
                                ),
                                array(
                                    'id' => 'subcategories_off',
                                    'value' => 0,
                                    'label' => $this->l('No')
                                )
                            )
                        ),
                        array(
                            'type' => 'switch',
                            'label' => $this->l('Show color options'),
                            'name' => 'NRT_categoryShowColorOptions',
                            'required' => false,
                            'is_bool' => true,
                            'values' => array(
                                array(
                                    'id' => 'coloroptions_on',
                                    'value' => 1,
                                    'label' => $this->l('Yes')
                                ),
                                array(
                                    'id' => 'coloroptions_off',
                                    'value' => 0,
                                    'label' => $this->l('No')
                                )
                            )
                        ),
                        array(
                            'type' => 'switch',
                            'label' => $this->l('Show stock information'),
                            'name' => 'NRT_categoryShowStockInfo',
                            'required' => false,
                            'is_bool' => true,
                            'values' => array(
                                array(
                                    'id' => 'stockinfo_on',
                                    'value' => 1,
                                    'label' => $this->l('Yes')
                                ),
                                array(
                                    'id' => 'stockinfo_off',
                                    'value' => 0,
                                    'label' => $this->l('No')
                                )
                            )
                        )
                    ),
                    // Submit Button
                    'submit' => array(
                        'title' => $this->l('Save'),
                        'name' => 'savenrtThemeConfig'
                    )
                )
            ),
            'nrt-productpages' => array(
                'form' => array(
                    'legend' => array(
                        'title' => $this->l('Product Pages'),
                        'icon' => 'icon-cog'
                    ),
                    'input' => array(
                        array(
                            'type' => 'switch',
                            'label' => $this->l('Show product reference code'),
                            'name' => 'NRT_productShowReference',
                            'required' => false,
                            'is_bool' => true,
                            'values' => array(
                                array(
                                    'id' => 'productreference_on',
                                    'value' => 1,
                                    'label' => $this->l('Yes')
                                ),
                                array(
                                    'id' => 'productreference_off',
                                    'value' => 0,
                                    'label' => $this->l('No')
                                )
                            )
                        ),
                        array(
                            'type' => 'switch',
                            'label' => $this->l('Show product condition'),
                            'name' => 'NRT_productShowCondition',
                            'required' => false,
                            'is_bool' => true,
                            'values' => array(
                                array(
                                    'id' => 'productcondition_on',
                                    'value' => 1,
                                    'label' => $this->l('Yes')
                                ),
                                array(
                                    'id' => 'productcondition_off',
                                    'value' => 0,
                                    'label' => $this->l('No')
                                )
                            )
                        ),
                        array(
                            'type' => 'switch',
                            'label' => $this->l('Show product manufacturer name'),
                            'name' => 'NRT_productShowManName',
                            'required' => false,
                            'is_bool' => true,
                            'values' => array(
                                array(
                                    'id' => 'productmanname_on',
                                    'value' => 1,
                                    'label' => $this->l('Yes')
                                ),
                                array(
                                    'id' => 'productmanname_off',
                                    'value' => 0,
                                    'label' => $this->l('No')
                                )
                            )
                        ),
                        array(
                            'type' => 'switch',
                            'label' => $this->l('Enable Vertical thumbnail list'),
                            'name' => 'NRT_productVerticalThumb',
                            'required' => false,
                            'is_bool' => true,
                            'values' => array(
                                array(
                                    'id' => 'productVerticalThumb_on',
                                    'value' => 1,
                                    'label' => $this->l('Yes')
                                ),
                                array(
                                    'id' => 'productVerticalThumb_off',
                                    'value' => 0,
                                    'label' => $this->l('No')
                                )
                            )
                        ),
                        array(
                            'type' => 'switch',
                            'label' => $this->l('Enable Upsell Product Slider'),
                            'name' => 'NRT_productUpsell',
                            'required' => false,
                            'is_bool' => true,
                            'values' => array(
                                array(
                                    'id' => 'productUpsell_on',
                                    'value' => 1,
                                    'label' => $this->l('Yes')
                                ),
                                array(
                                    'id' => 'productUpsell_off',
                                    'value' => 0,
                                    'label' => $this->l('No')
                                )

                            )
                        )
                    ),
                    // Submit Button
                    'submit' => array(
                        'title' => $this->l('Save'),
                        'name' => 'savenrtThemeConfig'
                    )
                )
            ),
            'nrt-fonts' => array(
                'form' => array(
                    'legend' => array(
                        'title' => $this->l('Fonts'),
                        'icon' => 'icon-cog'
                    ),
                    'input' => array(
                        array(
                            'type' => 'switch',
                            'name' => 'NRT_includeCyrillicSubset',
                            'label' => $this->l('Include Cyrillic subsets'),
                            'desc' => $this->l('If the selected font has support for Cyrillic subset, AxonVIP will automatically include it if selected Yes. To see which fonts have Cyrillic subsets support: https://www.google.com/fonts'),
                            'required' => false,
                            'is_bool' => true,
                            'values' => array(
                                array(
                                    'id' => 'cyrillic_on',
                                    'value' => 1,
                                    'label' => $this->l('Include Cyrillic')
                                ),
                                array(
                                    'id' => 'cyrillic_off',
                                    'value' => 0,
                                    'label' => $this->l('Exclude Cyrillic')
                                )
                            )
                        ),
                        array(
                            'type' => 'switch',
                            'name' => 'NRT_includeGreekSubset',
                            'label' => $this->l('Include Greek subsets'),
                            'desc' => $this->l('If the selected font has support for Greek subset, AxonVIP will automatically include it if selected Yes. To see which fonts have Greek subsets support: https://www.google.com/fonts'),
                            'required' => false,
                            'is_bool' => true,
                            'values' => array(
                                array(
                                    'id' => 'greek_on',
                                    'value' => 1,
                                    'label' => $this->l('Include Greek')
                                ),
                                array(
                                    'id' => 'greek_off',
                                    'value' => 0,
                                    'label' => $this->l('Exclude Greek')
                                )
                            )
                        ),
                        array(
                            'type' => 'switch',
                            'name' => 'NRT_includeVietnameseSubset',
                            'label' => $this->l('Include Vietnamese subset'),
                            'desc' => $this->l('If the selected font has support for Vietnamese subset, AxonVIP will automatically include it if selected Yes. To see which fonts have Vietnamese subset support: https://www.google.com/fonts'),
                            'required' => false,
                            'is_bool' => true,
                            'values' => array(
                                array(
                                    'id' => 'vietnamese_on',
                                    'value' => 1,
                                    'label' => $this->l('Include Vietnamese')
                                ),
                                array(
                                    'id' => 'vietnamese_off',
                                    'value' => 0,
                                    'label' => $this->l('Exclude Vietnamese')
                                )
                            )
                        ),
                        array(
                            'type' => 'select',
                            'name' => 'NRT_mainFont',
                            'label' => $this->l('Main Font Family'),
                            'required' => false,
                            'lang' => false,
                            'options' => array(
                                'query' => $fontOptions,
                                'id' => 'value',
                                'name' => 'name'
                            )
                        ),
                        array(
                            'type' => 'select',
                            'name' => 'NRT_titleFont',
                            'label' => $this->l('Title Font Family'),
                            'required' => false,
                            'lang' => false,
                            'options' => array(
                                'query' => $fontOptions,
                                'id' => 'value',
                                'name' => 'name'
                            )
                        )
                    ),
                    // Submit Button
                    'submit' => array(
                        'title' => $this->l('Save'),
                        'name' => 'savenrtThemeConfig'
                    )
                )
            ),
            'nrt-colors' => array(
                'form' => array(
                    'legend' => array(
                        'title' => $this->l('Colors'),
                        'icon' => 'icon-cog'
                    ),
                    'input' => array(
                        array(
                            'type' => 'color',
                            'name' => 'NRT_mainColorScheme',
                            'label' => $this->l('Main color scheme'),
                            'size' => 20,
                            'required' => false,
                            'lang' => false
                        ),
                        array(
                            'type' => 'color',
                            'name' => 'NRT_activeColorScheme',
                            'label' => $this->l('Active color scheme'),
                            'size' => 20,
                            'required' => false,
                            'lang' => false
                        )
                    ),
                    // Submit Button
                    'submit' => array(
                        'title' => $this->l('Save'),
                        'name' => 'savenrtThemeConfig'
                    )
                )
            ),
            'nrt-background' => array(
                'form' => array(
                    'legend' => array(
                        'title' => $this->l('Backgrounds'),
                        'icon' => 'icon-cog'
                    ),
                    'input' => array(
                        array(
                            'type' => 'color',
                            'name' => 'NRT_backgroundColor',
                            'label' => $this->l('Background color'),
                            'size' => 20,
                            'required' => false,
                            'lang' => false
                        ),
                        array(
                            'type' => 'file',
                            'name' => 'NRT_backgroundImage',
                            'label' => $this->l('Background image'),
                            'size' => 20,
                            'required' => false,
                            'lang' => false
                        ),
                        array(
                            'type' => 'select',
                            'name' => 'NRT_backgroundRepeat',
                            'label' => $this->l('Background repeat'),
                            'required' => false,
                            'lang' => false,
                            'options' => array(
                                'query' => $backgroundRepeatOptions,
                                'id' => 'value',
                                'name' => 'name'
                            )
                        ),
                        array(
                            'type' => 'select',
                            'name' => 'NRT_backgroundAttachment',
                            'label' => $this->l('Background attachment'),
                            'required' => false,
                            'lang' => false,
                            'options' => array(
                                'query' => $backgroundAttachmentOptions,
                                'id' => 'value',
                                'name' => 'name'
                            )
                        ),
                        array(
                            'type' => 'select',
                            'name' => 'NRT_backgroundSize',
                            'label' => $this->l('Background size'),
                            'required' => false,
                            'lang' => false,
                            'options' => array(
                                'query' => $backgroundSizeOptions,
                                'id' => 'value',
                                'name' => 'name'
                            )
                        ),
                        array(
                            'type' => 'color',
                            'name' => 'NRT_bodyBackgroundColor',
                            'label' => $this->l('Body background color'),
                            'desc' => $this->l('Body background color only visible in "Boxed" mode.'),
                            'size' => 20,
                            'required' => false,
                            'lang' => false
                        ),
                        array(
                            'type' => 'file',
                            'name' => 'NRT_bodyBackgroundImage',
                            'label' => $this->l('Body background image'),
                            'desc' => $this->l('Body background image only visible in "Boxed" mode.'),
                            'size' => 20,
                            'required' => false,
                            'lang' => false
                        ),
                        array(
                            'type' => 'select',
                            'name' => 'NRT_bodyBackgroundRepeat',
                            'label' => $this->l('Body background repeat'),
                            'required' => false,
                            'lang' => false,
                            'options' => array(
                                'query' => $backgroundRepeatOptions,
                                'id' => 'value',
                                'name' => 'name'
                            )
                        ),
                        array(
                            'type' => 'select',
                            'name' => 'NRT_bodyBackgroundAttachment',
                            'label' => $this->l('Body background attachment'),
                            'required' => false,
                            'lang' => false,
                            'options' => array(
                                'query' => $backgroundAttachmentOptions,
                                'id' => 'value',
                                'name' => 'name'
                            )
                        ),
                        array(
                            'type' => 'select',
                            'name' => 'NRT_bodyBackgroundSize',
                            'label' => $this->l('Body background size'),
                            'required' => false,
                            'lang' => false,
                            'options' => array(
                                'query' => $backgroundSizeOptions,
                                'id' => 'value',
                                'name' => 'name'
                            )
                        ),
                        array(
                            'type' => 'file',
                            'name' => 'NRT_breadcrumbBackgroundImage',
                            'label' => $this->l('Breadcrumb background image'),
                            'size' => 20,
                            'required' => false,
                            'lang' => false
                        )
                    ),
                    // Submit Button
                    'submit' => array(
                        'title' => $this->l('Save'),
                        'name' => 'savenrtThemeConfig'
                    )
                )
            ),
            'nrt-codes' => array(
                'form' => array(
                    'legend' => array(
                        'title' => $this->l('Custom Codes'),
                        'icon' => 'icon-cog'
                    ),
                    'input' => array(
                        array(
                            'type' => 'textarea',
                            'name' => 'NRT_customCSS',
                            'desc' => $this->l('Important Note: Use this area if only there are rules you cannot override with using normal css files. This will add css rules as inline code and it is not the best practice. Try using "custom.css" file located under "themes/[theme_name]/css/" folder to add your custom css rules.'),
                            'rows' => 10,
                            'label' => $this->l('Custom CSS Code'),
                            'required' => false,
                            'lang' => false
                        ),
                        array(
                            'type' => 'textarea',
                            'name' => 'NRT_customJS',
                            'rows' => 10,
                            'label' => $this->l('Custom JS Code'),
                            'required' => false,
                            'lang' => false
                        )
                    ),
                    // Submit Button
                    'submit' => array(
                        'title' => $this->l('Save'),
                        'name' => 'savenrtThemeConfig'
                    )
                )
            )
        );

        $helper = new HelperForm();

        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;

        $helper->default_form_language = $id_default_lang;
        $helper->allow_employee_form_lang = $id_default_lang;

        $helper->title = $this->displayName;
        $helper->show_toolbar = true;
        $helper->toolbar_scroll = true;
        $helper->submit_action = 'submit' . $this->name;
        $helper->toolbar_btn = array(
            'save' => array(
                'desc' => $this->l('Save'),
                'href' => AdminController::$currentIndex . '&configure=' . $this->name . '&save' . $this->name . '&token=' . Tools::getAdminTokenLite('AdminModules'),
            )
        );

        foreach ($languages as $language) {
            $helper->languages[] = array(
                'id_lang' => $language['id_lang'],
                'iso_code' => $language['iso_code'],
                'name' => $language['name'],
                'is_default' => ($id_default_lang == $language['id_lang'] ? 1 : 0)
            );
        }

        // Load standard field values
        foreach ($this->_standardConfig as $key => $standardNrt) {
            $helper->fields_value[$standardNrt] = Configuration::get($standardNrt);
        }

        // Load css field values
        foreach ($this->_styleConfig as $key => $cssNrt) {
            $helper->fields_value[$cssNrt] = Configuration::get($cssNrt);
        }

        // Custom variables
        $helper->tpl_vars = array(
            'nrttabs' => $this->_getTabs(),
            'imagePath' => _MODULE_DIR_ . $this->name . '/views/img/front/bg/',
            'shopId' => $id_shop
        );

        return $helper->generateForm($fields_form);
    }

    /* ------------------------------------------------------------- */
    /*  GET TABS
    /* ------------------------------------------------------------- */
    private function _getTabs()
    {
        $tabArray = array(
            'General' => 'fieldset_nrt-general',
            'Header' => 'fieldset_nrt-header_1',
            'Category Pages' => 'fieldset_nrt-categorypages_2',
            'Product Pages' => 'fieldset_nrt-productpages_3',
            'Fonts' => 'fieldset_nrt-fonts_4',
            'Colors' => 'fieldset_nrt-colors_5',
            'Background' => 'fieldset_nrt-background_6',
            'Custom Codes' => 'fieldset_nrt-codes_7',
        );

        return $tabArray;
    }

    /* ------------------------------------------------------------- */
    /*  WRITE CSS
    /* ------------------------------------------------------------- */
    private function _writeCss()
    {
        $id_shop = $this->context->shop->id;

        $cssFile = _PS_MODULE_DIR_ . $this->name . '/views/css/front/configCss-' . $id_shop . '.css';
        $handle = fopen($cssFile, 'w');

        $config = $this->_getThemeConfig();

        // Starting of the cssCode
        $cssCode = '';

        // Read _cssRules and create css rules
        foreach ($this->_cssRules as $configName => $css) {

            // Check if the config is set, and it's not the default value
            if ($config[$configName] == '') {
                continue;
            }
            if (isset($this->_configDefaults[$configName]) && $config[$configName] == $this->_configDefaults[$configName]) {
                continue;
            }

            // If the config is a font config then do this and write the css rule for it
			
			
            if (in_array($configName, $this->_fontConfig) ){
                foreach ($css as $line){
					if($config[$configName] != 'None'){
						$cssCode .= $line['selector'] . '{' . $line['rule'] . ':' . (isset($line['prefix']) ? $line['prefix'] : '') . (isset($line['value']) ? $line['value'] : '"' . $config[$configName] . '", "Helvetica", "Arial", "sans-serif"') . (isset($line['suffix']) ? $line['suffix'] : '') . ';}';
					}
                }
                continue;
            }

            // Otherwise create the general css rule for it
            foreach ($css as $line) {
                $cssCode .= (isset($line['media']) ? $line['media'].'{' : '') . $line['selector'] . '{' . $line['rule'] . ':' . (isset($line['prefix']) ? $line['prefix'] : '') . (isset($line['value']) ? $line['value'] : $config[$configName]) . (isset($line['suffix']) ? $line['suffix'] : '') . ';}' . (isset($line['media']) ? '}' : '');
            }


        }

        $response = fwrite($handle, $cssCode);

        return $response;

    }

    /* ------------------------------------------------------------- */
    /*  GET THEME CONFIG
    /* ------------------------------------------------------------- */
    private function _getThemeConfig($standard = true, $style = true, $multiLang = true)
    {
        $id_default_lang = $this->context->language->id;

        $config = array();

        if ($standard) {
            foreach ($this->_standardConfig as $configItem) {
                $config[$configItem] = Configuration::get($configItem);
            }
        }

        if ($style) {
            foreach ($this->_styleConfig as $configItem) {
                $config[$configItem] = Configuration::get($configItem);
            }
        }

        return $config;
    }
 /* ------------------------------------------------------------- */
    /*  PREPARE FOR HOOK
    /* ------------------------------------------------------------- */
    private function _prepHook($params)
    {
		Media::addJsDef(array('baseUri' => $this->context->shop->getBaseURL(true, true)));
		Media::addJsDef(array('LANG_RTL' => (int)$this->context->language->is_rtl));
		Media::addJsDef(array('langIso' => $this->context->language->language_code));
		Media::addJsDef(array('next_' => $this->l('next')));
		Media::addJsDef(array('back_' => $this->l('back')));
		Media::addJsDef(array('countdownDay' => $this->l('Day')));
		Media::addJsDef(array('countdownDays' => $this->l('Days')));
		Media::addJsDef(array('countdownHour' => $this->l('Hour')));
		Media::addJsDef(array('countdownHours' => $this->l('Hours')));
		Media::addJsDef(array('countdownMinute' => $this->l('Min')));
		Media::addJsDef(array('countdownMinutes' => $this->l('Mins')));
		Media::addJsDef(array('countdownSecond' => $this->l('Sec')));
		Media::addJsDef(array('countdownSeconds' => $this->l('Secs')));
		if(Configuration::get('NRT_enableCountdownTimer')==1)
		Media::addJsDef(array('NRT_enableCountdownTimer' => true));
		if(Configuration::get('NRT_stickyMenu')==1)
		Media::addJsDef(array('NRT_stickyMenu' =>  true));
		if(Configuration::get('NRT_stickySearch')==1)
		Media::addJsDef(array('NRT_stickySearch' => true));
		if(Configuration::get('NRT_stickyCart')==1)
		Media::addJsDef(array('NRT_stickyCart' => true));
		Media::addJsDef(array('NRT_mainLayout' =>  Configuration::get('NRT_mainLayout')));
        $config = $this->_getThemeConfig();
        $controller_name = Dispatcher::getInstance()->getController();

        if ($config) {
            foreach ($config as $key => $value) {
                $this->smarty->assignGlobal($key, $value);
            }
        }
		$image_types =(ImageType::getImagesTypes());
		foreach($image_types as $image_type){
			 $this->smarty->assignGlobal('size_'.$image_type['name'],Image::getSize($image_type['name']));	
		}
		$this->smarty->assignGlobal('NRT_IMG_BREADCRUMB',$this->context->link->getMediaLink((_MODULE_DIR_ . $this->name . '/views/img/front/bg/').Configuration::get('NRT_breadcrumbBackgroundImage')));
		if(Configuration::get('PS_ORDER_OUT_OF_STOCK')){
			$this->smarty->assignGlobal('order_out_of_stock','ok');
		}
		if(Configuration::get('PS_CATALOG_MODE')){
			$this->smarty->assignGlobal('is_catalog_mode','ok');
		}
        /* Show paneltool */
        $NRT_showPanelTool = Configuration::get('NRT_showPanelTool');
        if($NRT_showPanelTool){
			$this->context->controller->addJS($this->_path.'views/js/front/jquery.colorpicker.js');
			$this->context->controller->addJS($this->_path.'views/js/front/jquery.colortool.js');
            $this->smarty->assignGlobal('NRT_PANELTOOL_TPL', $this->context->link->getMediaLink(_PS_MODULE_DIR_.$this->name).'/views/templates/front/colortool.tpl');
        }
        $GGmaps_Java_path = 'https://maps.googleapis.com/maps/api/js';
        $NRT_GGMapsJava = Configuration::get('NRT_GGMapsJava');
        $NRT_GGMapsAPIKeys = Configuration::get('NRT_GGMapsAPIKeys');
        if (isset($NRT_GGMapsJava) && $NRT_GGMapsJava && Dispatcher::getInstance()->getController() == 'contact'){
			Media::addJsDef(array('NRT_GGMapsJava' =>  Configuration::get('NRT_GGMapsJava')));
            if(isset($NRT_GGMapsAPIKeys) && $NRT_GGMapsAPIKeys){
                $GGmaps_Java_path .= '?key=' . $NRT_GGMapsAPIKeys;
            } else {
                $GGmaps_Java_path .= '&sensor=false';
            }
           $this->context->controller->registerJavascript('ggmaps-java', $GGmaps_Java_path, ['server' => 'remote', 'position' => 'head', 'priority' => 10]);		
        }
	$productVerticalThumb = Configuration::get('NRT_productVerticalThumb');
//	var_dump($productVerticalThumb);
	if (isset($productVerticalThumb) && $productVerticalThumb){
		$this->context->controller->registerJavascript('jquery.carouFredSel-6.2.1.min.js', '/assets/js/nrt-js/jquery.carouFredSel-6.2.1.min.js', ['position' => 'bottom', 'priority' => 10001]);
	}
	 /* LOAD CSS */
	$this->context->controller->registerStylesheet('font-awesome.css', '/assets/mod_css/font-awesome/font-awesome.css',['media' => 'all', 'priority' => -1]);
$this->context->controller->registerStylesheet('style_global.css', '/assets/mod_css/style_global.css',['media' => 'all', 'priority' => 1001]);
	 /* LOAD JS */
	$this->context->controller->registerJavascript('jquery.min.js', '/assets/mod_js/jquery.min.js', ['position' => 'head', 'priority' => 0]);	
	$this->context->controller->registerJavascript('jquery.plugins.js', '/assets/mod_js/jquery.plugins.js', ['position' => 'bottom', 'priority' => 10000]);
	$this->context->controller->registerJavascript('jquery.custom.js', '/assets/mod_js/jquery.custom.js', ['position' => 'bottom', 'priority' => 10002]);
	$this->context->controller->registerJavascript('jquery.title.js', '/assets/mod_js/jquery.title.js', ['position' => 'bottom', 'priority' => 10003]);
	$this->context->controller->registerJavascript('front.js', '/assets/mod_js/front.js', ['position' => 'bottom', 'priority' => 0]);
 /* -----------------------carousel-------------------------------------- */
$this->context->controller->registerJavascript('owl.carousel.min.js', '/assets/mod_js/carousel/owl.carousel.min.js', ['position' => 'bottom', 'priority' => 9999]);
$this->context->controller->registerStylesheet('owl.carousel.min.css', '/assets/mod_js/carousel/owl.carousel.min.css');
$this->context->controller->registerStylesheet('owl.theme.default.min.css', '/assets/nrt-js/carousel/owl.theme.default.min.css');
 /* ------------------------------------------------------------- */
 	$this->context->controller->addJqueryUI('ui.autocomplete');
        return true;
    }

    /* ------------------------------------------------------------- */
    /*  HOOK (displayHeader)
    /* ------------------------------------------------------------- */
    public function hookHeader($params)
    {
        $this->_prepHook($params);
		$this->CustomCss($params);
		if(Configuration::get('NRT_titleFont')==Configuration::get('NRT_mainFont')){
			if(Configuration::get('NRT_mainFont') != 'None' && !in_array(Configuration::get('NRT_mainFont'),$this->_websafeFonts))
			$this->smarty->assignGlobal('Standard_mainFont',$this->StandardFont('NRT_mainFont'));
		}else{
			if(Configuration::get('NRT_mainFont') != 'None' && !in_array(Configuration::get('NRT_mainFont'),$this->_websafeFonts)){
				$this->smarty->assignGlobal('Standard_mainFont',$this->StandardFont('NRT_mainFont'));
			}
			if(Configuration::get('NRT_titleFont') != 'None' && !in_array(Configuration::get('NRT_titleFont'),$this->_websafeFonts)){
				$this->smarty->assignGlobal('Standard_titleFont',$this->StandardFont('NRT_titleFont'));
			}
		}
    }
    /* ------------------------------------------------------------- */
    /*  Standar Font google
    /* ------------------------------------------------------------- */
    public function StandardFont($configName)
    {
				$config = $this->_getThemeConfig();
                // If not then do some preparations for google fonts
                // then write the proper css rule
                $googleFontName = str_replace(' ', '+', $config[$configName]);
                $googleFontSubsets = $this->_googleFonts[$config[$configName]]['subsets'];
                $googleFontVariants = $this->_googleFonts[$config[$configName]]['variants'];

                $isIncludeCyrillic = Configuration::get('NRT_includeCyrillicSubset');
                $isIncludeGreek = Configuration::get('NRT_includeCyrillicSubset');
                $isIncludeVietnamese = Configuration::get('NRT_includeCyrillicSubset');
				
 				if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
                    $importCode = 'https://fonts.googleapis.com/css?family='.$googleFontName;
                else
                    $importCode = 'http://fonts.googleapis.com/css?family='.$googleFontName;
                /* VARIANTS */
                // Include normal (400)
				if ( in_array('300', $googleFontVariants) ){
							$importCode .= ':300';
					$importCode .= ',400';
						}
				else
					$importCode .= ':400';
                // Include bold if available
                if ( in_array('500', $googleFontVariants) ){
                    $importCode .= ',500';
                }
                // Include bold if available
                if ( in_array('600', $googleFontVariants) ){
                    $importCode .= ',600';
                }
                // Include bold if available
                if ( in_array('700', $googleFontVariants) ){
                    $importCode .= ',700';
                }
                /* SUBSETS */
                // Include Latin and Latin-ext
                $importCode .= ';subset=latin,latin-ext';

                // Include Cyrillic subsets if they are selected and available for the font
                if ($isIncludeCyrillic){
                    if ( in_array('cyrillic', $googleFontSubsets) ){
                        $importCode .=',cyrillic';
                    }
                    if ( in_array('cyrillic-ext', $googleFontSubsets) ){
                        $importCode .=',cyrillic-ext';
                    }
                }

                // Include Greek subsets if they are selected and available for the font
                if ($isIncludeGreek){
                    if ( in_array('greek', $googleFontSubsets) ){
                        $importCode .=',greek';
                    }
                    if ( in_array('cyrillic-ext', $googleFontSubsets) ){
                        $importCode .=',greek-ext';
                    }
                }

                // Include Vietnamese subset if it is selected and available for the font
                if ($isIncludeVietnamese && in_array('vietnamese', $googleFontSubsets)){
                    $importCode .=',greek';
                }
				return $importCode;
    }
    public function CustomCss($params)
    {
        $id_shop = $this->context->shop->id;

        /* We are loading css files in this hook, because
         * this is the only way to make sure these css files
         * will override any other css files.. Otherwise
         * module positioning will cause a lot of issues.
         */
        $cssFile = 'configCss-' . $id_shop . '.css';
        if (file_exists(_PS_MODULE_DIR_ . $this->name . '/views/css/front/' . $cssFile)) {
			$this->context->controller->registerStylesheet('configCss',$this->context->controller->getAssetUriFromLegacyDeprecatedMethod($this->_path.'views/css/front/' . $cssFile),['media' => 'all', 'priority' => 1002]);
        }
    }
}