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

class Logosticky extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'logosticky';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'Aquapure';
        $this->need_instance = 1;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('logo Sticky Menu');
        $this->description = $this->l('Add a secondary logo for the sticky menu in the front office');

        $this->confirmUninstall = $this->l('Are you you want to uninstall this modules');

        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        Configuration::updateValue('LOGOSTICKY', 'logo_alt.png');

        return parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('backOfficeHeader') &&
            $this->registerHook('logoStickyMenu') &&
            $this->registerHook('displayNav') &&
            $this->registerHook('displayNav2') &&
            $this->registerHook('displayBackOfficeHeader');
    }

    public function uninstall()
    {
        Configuration::deleteByName('LOGOSTICKY');

        return parent::uninstall();
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
        $errors = array();
        if (Tools::isSubmit('submitForm')) {
            $target_dir = _PS_MODULE_DIR_ . 'logosticky/img/';
            $target_file = $target_dir . basename($_FILES['LOGOSTICKY']["name"]);
            $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
            $file = 'logo_alt.' . $imageFileType;

            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" && $imageFileType != "ico") {
                if (empty($_FILES['LOGOSTICKY']["tmp_name"])) {
                    $errors[] = $this->l('Vous devez mettre une image');
                } else {
                    $errors[] = $this->l('Format d\'image invalide');
                }
            }
            if (count($errors)) {
                $output = $this->displayError(implode('<br />', $errors));
            } else {
                if (!file_exists($target_file)) {
                    $ext_logosticky = pathinfo($target_dir . Configuration::get('LOGOSTICKY'), PATHINFO_EXTENSION);
                    Configuration::updateValue('LOGOSTICKY', 'logo_alt.' . $ext_logosticky);
                    unlink(_PS_MODULE_DIR_ . 'logosticky/img/' . Configuration::get('LOGOSTICKY'));
                }
                move_uploaded_file($_FILES['LOGOSTICKY']["tmp_name"], $target_dir . $file);
                $output = $this->displayConfirmation($this->l('Le logo a bien été modifié'));
                $form_values = $this->getConfigFormValues();

                foreach (array_keys($form_values) as $key) {
                    Configuration::updateValue($key, 'logo_alt.' . pathinfo(Tools::getValue($key), PATHINFO_EXTENSION));
                }
            }
        }
        return $output . $this->renderForm();
    }

    /**
     * Create the form that will be displayed in the configuration of your module.
     */
    protected function renderForm()
    {
        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitLogostickyModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($this->getConfigForm()));
    }

    /**
     * Create the structure of your form.
     */
    protected function getConfigForm()
    {

        $dir = '/modules/logosticky/img/';
        $alt_logo = Configuration::get('LOGOSTICKY');
        $image = '<div class="col-lg-6"><img src="' . $dir . $alt_logo . '" class="img-thumbnail" width="400"></div>';
        return array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Settings'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'file',
                        'label' => $this->l('logo_sticky'),
                        'hint' => $this->trans(
                            'Will appear on main page. Recommended size for the default theme: height %height% and width %width%.',
                            array(
                                '%height%' => '40px',
                                '%width%' => '200px'
                            ),
                            'Admin.Design.Help'
                        ),
                        'name' => 'LOGOSTICKY',
                        'is_bool' => true,
                        'image' => $image,
                        'required' => 'required'
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                    'name' => 'submitForm',
                    'id' => 'submitForm'
                ),
            ),
        );
    }

    /**
     * Set values for the inputs.
     */
    protected function getConfigFormValues()
    {
        return array(
            'LOGOSTICKY' => Configuration::get('LOGOSTICKY', ''),
        );
    }

    /**
     * Save form data.
     */
    protected function postProcess()
    {
        /* Place your code here. */
    }

    /**
    * Add the CSS & JavaScript files you want to be loaded in the BO.
    */
    public function hookBackOfficeHeader()
    {
        if (Tools::getValue('module_name') == $this->name) {
            $this->context->controller->addJS($this->_path.'views/js/back.js');
            $this->context->controller->addCSS($this->_path.'views/css/back.css');
        }
    }

    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookHeader()
    {
        $this->context->controller->addJS($this->_path.'/views/js/front.js');
        $this->context->controller->addCSS($this->_path.'/views/css/front.css');
    }

    public function hookDisplayBackOfficeHeader()
    {
        /* Place your code here. */
    }

    public function hookLogoStickyMenu()
    {
        $dir_logo = '/modules/logosticky/img/' . Configuration::get('LOGOSTICKY');
        return $dir_logo;
    }
}
