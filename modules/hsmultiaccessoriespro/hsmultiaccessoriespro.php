<?php
/**
 * Multi Accessories Pro
 *
 * @author    PrestaMonster
 * @copyright PrestaMonster
 * @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

require_once dirname(__FILE__) . '/abstract/hsmultiaccessoriesabstract.php';
require_once dirname(__FILE__) . '/classes/HsAccessoriesGroupProduct.php';
require_once dirname(__FILE__) . '/classes/HsMaProductSetting.php';

class HsMultiAccessoriesPro extends HsMultiAccessoriesAbstract
{
    /**
     * construct method.
     */
    public function __construct()
    {
        $this->name = 'hsmultiaccessoriespro';
        $this->version = '4.2.0';
        $this->tab = 'front_office_features';
        $this->displayName = $this->l('Multi Accessories Pro');
        $this->class_controller_admin_group = 'AdminHsMultiAccessoriesGroupPro';
        $this->class_controller_admin_welcome_page = 'AdminHsMultiAccessoriesWelcomePagePro';
        $this->class_controller_accessory_search = 'AdminHsMultiAccessoriesSearchPro';
        $this->class_controller_admin_product_setting = 'AdminHsMultiAccessoriesProductSetting';
        $this->module_key = '32491cc370c598602cd7d07bdf4bdf14';
        $this->author_address = '0x741A23f5969c86d9118808f1eAC29D40B37562F1';
        $this->author = 'PrestaMonster';
        parent::__construct();
        $this->description = $this->l('Manage accessories of a product in groups and offer ability to check out the main product and its accessories in 1 click.');
        $this->confirmUninstall = sprintf($this->l('Do you want to uninstall %s?'), $this->displayName);
        $this->tab_admin_welcome_page = array('AdminHsMultiAccessoriesWelcomePagePro' => $this->l('Welcome page'));
        $this->tabs27 = array(
            array($this->class_controller_accessory_search => $this->l('Accessory search')),
            array($this->class_controller_admin_product_setting => $this->l('Product Setting')),
        );
    }

    /**
     * Install module.
     *
     * @return bool
     */
    public function install()
    {
        require_once dirname(__FILE__) . '/classes/HsMultiAccessoriesInstaller.php';
        $this->installer = new HsMultiAccessoriesInstaller($this->name, $this->class_controller_admin_group, $this->l('Multi Accessories'));

        return parent::install();
    }

    /**
     * Uninstall module.
     *
     * @return bool
     */
    public function uninstall()
    {
        require_once dirname(__FILE__) . '/classes/HsMultiAccessoriesInstaller.php';
        $this->uninstaller = new HsMultiAccessoriesInstaller($this->name, $this->class_controller_admin_group, $this->displayName);

        return parent::uninstall();
    }

    /**
     * Dedicated callback to upgrading process.
     *
     * @param type $version
     *
     * @return bool
     */
    public function upgrade($version)
    {
        require_once dirname(__FILE__) . '/classes/HsMultiAccessoriesInstaller.php';
        $this->installer = new HsMultiAccessoriesInstaller($this->name, $this->class_controller_admin_product_setting, $this->class_controller_admin_group, $this->displayName);

        return parent::upgrade($version);
    }

    public function hookActionAdminControllerSetMedia()
    {
        if (!($this->context->controller instanceof AdminProductsController) && !($this->context->controller instanceof AdminHsMultiAccessoriesWelcomePageProController) && !($this->context->controller instanceof AdminHsMultiAccessoriesGroupProController)) {
            return;
        }
        return parent::hookActionAdminControllerSetMedia();
    }

    /**
     * A custom hook so that we can place the Multi Accessories block anywhere on product page's template <br/>
     * For example:<br/>
     * {hook h="displayMultiAccessoriesProduct"}.
     *
     * @return HTML
     */
    public function hookDisplayMultiAccessoriesProduct($params)
    {
        if (!isset($params['product'])) {
            return parent::hookDisplayRightColumnProduct();
        }
        
        $mainProduct = $params['product'];
        $id_product = $params['product']['id_product'];
        $id_lang = (int) Context::getContext()->language->id;
        $id_shop = (int) Context::getContext()->shop->id;
        $id_products = array();

        if (HsAccessoriesGroupAbstract::haveAccessories(array($id_product), $id_lang)) {
            $id_products = array($id_product);
        }

        $id_groups = HsAccessoriesGroupAbstract::getIdGroups($id_lang, true);
        $include_out_of_stock = Configuration::get('HSMA_SHOW_ACCESSORIES_OFS');
        $accessories_groups = HsAccessoriesGroupAbstract::getAccessoriesByGroups($id_groups, $id_products, true, $id_lang, $include_out_of_stock, true);

        $currency_decimals = $this->getDecimals();
        $use_tax = $this->isUsetax();
        $random_main_product_id = $this->getRandomId();
        $accessories_table_price = array();

        /* Format product */
        $default_id_product_attribute = (int) Product::getDefaultAttribute($id_product, self::DEFAULT_QTY);
        $mainProduct['id_product_attribute'] = $default_id_product_attribute;
        $formatted_product = array();
        $formatted_product['id_product'] = $id_product;
        $formatted_product['link_rewrite'] = $mainProduct['link_rewrite'];
        $formatted_product['name'] = $mainProduct['name'];
        $formatted_product['qty'] = self::DEFAULT_QTY;
        $formatted_product['out_of_stock'] = Product::isAvailableWhenOutOfStock($mainProduct['out_of_stock']);
        $formatted_product['available_quantity'] = (int) $mainProduct['quantity'];
        $formatted_product['description_short'] = $mainProduct['description_short'];
        $formatted_product['default_id_product_attribute'] = $mainProduct['id_product_attribute'];
        $combinations = HsMaProduct::getCombinations((int) $id_product, $id_shop);
        
        if (!empty($combinations)) {
            $formatted_product['combinations'] = $combinations;
        } else {
            $formatted_product['id_product_attribute'] = $formatted_product['default_id_product_attribute'];
            $formatted_product['combinations'][] = $this->createDefaultProductCombination($formatted_product);
        }
        
        $formatted_product['combinations'] = $this->formatMainProductCombinations($formatted_product);
        $accessories_table_price[$random_main_product_id] = $formatted_product;

        $id_products_buy_together = array();
        foreach ($accessories_groups as &$accessories_group) {
            foreach ($accessories_group as &$accessory) {
                $product = new Product((int) $accessory['id_accessory'], false, $id_lang);
                $random_product_accessories_id = $this->getRandomId();
                if (!Validate::isLoadedObject($product)) {
                    unset($accessory);
                    continue;
                }
                /* customization*/
                $accessory['customization'] = $product->customizable ? $product->getCustomizationFields($id_lang) : false;
                $accessory['customizable'] = $product->customizable;
                $accessory = $this->getCustomizationData($accessory);
                /*End of customization*/
                if ($accessory['is_available_buy_together']) {
                    $id_products_buy_together[$accessory['id_accessory_group']] = $accessory['id_accessory'];
                }
                if ($is_product_page) {
                    $accessories_table_price[$random_product_accessories_id] = $this->formatAccessory($accessory);
                }
                //@todo: Fix the price different with group customer
                $default_id_product_attribute = (int) $accessory['id_product_attribute'];
                $price = HsMaProduct::getPriceStatic($accessory['id_accessory'], $use_tax, $default_id_product_attribute, $currency_decimals);
                $accessory['price'] = $price;
                $accessory['random_product_accessories_id'] = $random_product_accessories_id;
                $accessory['default_id_product_attribute'] = $default_id_product_attribute;
                if ($this->isPrestashop17()) {
                    $accessory['link'] = $this->context->link->getProductLink($product, $product->link_rewrite, $product->category, $product->ean13, $id_lang, $id_shop, $product->cache_default_attribute);
                } else {
                    $accessory['link'] = $this->context->link->getProductLink($product);
                }
                $accessories_table_price[$random_product_accessories_id]['link'] = $accessory['link'];
                if (!empty($accessory['customization'])) {
                    $accessories_table_price[$random_product_accessories_id]['customizations'] = $accessory['customizations'];
                    $accessories_table_price[$random_product_accessories_id]['id_customization'] = $accessory['id_customization'];
                    $accessories_table_price[$random_product_accessories_id]['is_customizable'] = $accessory['is_customizable'];
                    $accessories_table_price[$random_product_accessories_id]['is_enough_customization'] = $accessory['is_enough_customization'];
                }
                $accessory['available_later'] = $this->getMessageAvailableLater($accessory['available_later']);
            }
        }
        
        $setting_buy_together = HsMaProductSetting::getBuyTogetherCurrentValue($id_products[0]);

        $data = array(
            'accessory_configuration_keys' => Configuration::getMultiple(array_keys($this->configuration_keys)),
            'accessory_block_title' => Configuration::get('HSMA_TITLE', $id_lang),
            'accessory_image_type' => Configuration::get('HSMA_IMAGE_TYPE'),
            'change_main_price' => Configuration::get('HSMA_CHANGE_MAIN_PRICE'),
            'image_size_fancybox' => Configuration::get('HSMA_IMAGE_SIZE_IN_FANCYBOX'),
            'show_table_price' => Configuration::get('HSMA_SHOW_PRICE_TABLE'),
            'show_combination' => Configuration::get('HSMA_SHOW_COMBINATION'),
            'sync_accessory_quantity' => (int) $this->getOptionAcessoryQuantitySetting(),
            'accessory_groups' => HsAccessoriesGroupAbstract::getGroups($id_lang, true),
            'accessories_table_price' => Tools::jsonEncode($accessories_table_price),
            'js_translate_text' => Tools::jsonEncode($this->getJsTranslateText()),
            'random_main_product_id' => $random_main_product_id,
            'sub_total' => $this->i18n['sub_total'],
            'accessories_groups' => $accessories_groups,
            'static_token' => Tools::getToken(false),
            'is_enabling_cart_ajax' => (int) $this->isEnableBlockCartAjax(),
            'main_product_minimal_quantity' => $product->minimal_quantity,
            'buy_main_accessory_together_group' => $setting_buy_together[$id_products[0]],
            'is_product_page' => true,
            'isPrestashop17' => $this->isPrestashop17(),
            'id_products_buy_together' => $id_products_buy_together,
            'path_theme' => $this->isPrestashop17() ? '17/' : '',
        );

        $this->context->smarty->assign($data);
        return $this->display($this->name . '.php', 'multi_accessories_home.tpl');
    }

    public static function getHsMultiAccessoriesData($product)
    {
        $params['product'] = $product;
        (new HsMultiAccessoriesPro())->hookDisplayMultiAccessoriesProduct($params);
    }
}