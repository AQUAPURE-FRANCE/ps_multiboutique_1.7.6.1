<?php
/**
* 2007-2019 PrestaShop
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
*  @copyright 2007-2019 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

class Latestposts extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'latestposts';
        $this->tab = 'search_filter';
        $this->version = '1.0.0';
        $this->author = 'AQUAPURE-FRANCE';
        $this->need_instance = 1;

        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Latest Posts');
        $this->description = $this->l('Get the lastest posts');

        $this->confirmUninstall = $this->l('');

        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    public function install()
    {
        Configuration::updateValue('LATESTPOSTS_LIVE_MODE', false);

        return parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('displayHeader');
    }

    public function uninstall()
    {
        Configuration::deleteByName('LATESTPOSTS_LIVE_MODE');

        return parent::uninstall();
    }

    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookHeader()
    {
        // Create page from which data will be retrieved
        Media::addJsDef(['latestpost_ajax' => $this->_path.'ajax.php',
            'displayProductOnHomepage_ajax' => $this->_path.'displayProductOnHomePageAjax.php']);

        $this->context->controller->registerStylesheet(
            'module-mymodcomments-bs', $this->_path.'/views/css/latestposts.css', ['media' => 'all', 'priority' => 0]);
        $this->context->controller->addJS($this->_path . 'views/js/latestposts.js');
    }
}
