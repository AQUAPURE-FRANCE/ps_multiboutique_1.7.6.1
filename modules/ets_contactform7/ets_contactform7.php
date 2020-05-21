<?php
/**
 * 2007-2018 ETS-Soft
 *
 * NOTICE OF LICENSE
 *
 * This file is not open source! Each license that you purchased is only available for 1 wesite only.
 * If you want to use this file on more websites (or projects), you need to purchase additional licenses. 
 * You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
 * 
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please contact us for extra customization service at an affordable price
 *
 *  @author ETS-Soft <etssoft.jsc@gmail.com>
 *  @copyright  2007-2018 ETS-Soft
 *  @license    Valid for 1 website (or project) for each purchase of license
 *  International Registered Trademark & Property of ETS-Soft
 */

if (!defined('_PS_VERSION_'))
	exit;
require_once(dirname(__FILE__).'/classes/form-tag.php');
require_once(dirname(__FILE__).'/classes/function.php');
require_once(dirname(__FILE__).'/classes/Contact.php');
require_once(dirname(__FILE__).'/classes/contact-form.php');
require_once(dirname(__FILE__).'/classes/form-tags-manager.php');
require_once(dirname(__FILE__).'/classes/submission.php');
require_once(_PS_MODULE_DIR_.'ets_contactform7/classes/mail.php');
require_once(_PS_MODULE_DIR_.'ets_contactform7/classes/pipe.php');
require_once(_PS_MODULE_DIR_.'ets_contactform7/classes/integration.php');
require_once(_PS_MODULE_DIR_.'ets_contactform7/classes/recaptcha.php');
require_once(_PS_MODULE_DIR_.'ets_contactform7/classes/validation.php');
require_once(_PS_MODULE_DIR_.'ets_contactform7/classes/ets_ctf_link_class.php');
require_once(_PS_MODULE_DIR_.'ets_contactform7/classes/ctf_browser.php');
class Ets_contactform7 extends Module
{
    public $contact_fields;
    public $_html;
    public $_errors;
    static public $_config_fields;
    static public $_email_fields;
    public $_ps17;
    public $_path_module;
    public $_hooks=array(
        'actionOutputHTMLBefore',
        'contactForm7LeftBlok',
        'displayBackOfficeHeader',
        'displayContactForm7',
        'displayHeader',
        'displayHome',
        'moduleRoutes',
        'displayNav2',
        'displayNav',
        'displayTop',
        'displayLeftColumn',
        'displayFooter',
        'displayRightColumn',
        'displayProductAdditionalInfo',
        'displayFooterProduct',
        'displayAfterProductThumbs',
        'displayRightColumnProduct',
        'displayLeftColumnProduct',
        'displayShoppingCartFooter',
        'displayCustomerAccountForm',
        'displayCustomerLoginFormAfter',
        'displayBackOfficeFooter'
    );
    public function __construct()
	{
		$this->name = 'ets_contactform7';
		$this->tab = 'front_office_features';
		$this->version = '2.0.3';
		$this->author = 'ETS-Soft';
		$this->need_instance = 0;
		$this->secure_key = Tools::encrypt($this->name);        
		$this->bootstrap = true;
        $this->module_key = '0cc001cd32aeba4622dec23df91ab813';
        if(version_compare(_PS_VERSION_, '1.7', '>='))
            $this->_ps17=true; 
		parent::__construct();
        $this->context = Context::getContext();
        $this->url_module = $this->_path;
        $this->displayName = $this->l('Contact Form 7');
		$this->description = $this->l('The most famous contact form plugin that will you create any kinds of contact form using contact form editor');
        $this->_path_module = $this->_path;
        if(Tools::getValue('action')=='getCountMessageContactForm7')
        {
            die(
                Tools::jsonEncode(
                    array(
                        'count' => $this->getCountMessageNoReaed(),
                    )
                )  
            );
        }
        self::$_config_fields=array(
			'form' => array(
				'legend' => array(
					'title' => $this->l('Integration'),
					'icon' => 'icon-cogs'
				),
                'id_form'=>'module_form_integration',
				'input' => array(
                    array(
                        'type' => 'switch',
                        'name'=>'ETS_CTF7_ENABLE_RECAPTCHA',
                        'label'=> $this->l('Enable reCAPTCHA'),
                        'values' => array(
                			array(
                				'id' => 'ETS_CTF7_ENABLE_RECAPTCHA_on',
                				'value' => 1,
                				'label' => $this->l('Yes')
                			),
                			array(
                				'id' => 'ETS_CTF7_ENABLE_RECAPTCHA_off',
                				'value' => 0,
                				'label' => $this->l('No')
                			)
                		),
                        'default'=>0,
                        'form_group_class'=>'form_group_contact google',
                    ), 
					array(
						'type' => 'text',
						'label' => $this->l('Site Key'),
						'name' => 'ETS_CFT7_SITE_KEY',
                        'form_group_class'=>'form_group_contact google google2',
					),
					array(
						'type' => 'text',
						'label' => $this->l('Secret Key'),
						'name' => 'ETS_CFT7_SECRET_KEY',
                        'form_group_class'=>'form_group_contact google google2',
					),
                    array(
						'type' => 'text',
						'label' => $this->l('Contact alias'),
						'name' => 'ETS_CFT7_CONTACT_ALIAS',
						'required' => true,
                        'lang'=>true,
                        'validate'=> 'isLinkRewrite',
                        'default'=>'contact-form',
                        'form_group_class'=>'form_group_contact other_setting',
					),
                    array(
                        'type' => 'switch',
                        'name'=>'ETS_CTF7_URL_SUBFIX',
                        'label'=> $this->l('Use URL subfix'),
                        'values' => array(
                			array(
                				'id' => 'ETS_CTF_URL_SUBFIX_on',
                				'value' => 1,
                				'label' => $this->l('Yes')
                			),
                			array(
                				'id' => 'ETS_CTF_URL_SUBFIX_off',
                				'value' => 0,
                				'label' => $this->l('No')
                			)
                		),
                        'default'=>0,
                        'form_group_class'=>'form_group_contact other_setting',
                        'desc' => $this->l('Add ".html" to the end of form page URL. Set this to "Yes" if your product pages are ended with ".html". Set this to "No", if product pages are NOT ended with ".html"'),
                    ), 
                    array(
                        'type' => 'switch',
                        'name'=>'ETS_CTF7_ENABLE_TMCE',
                        'label'=> $this->l('Enable TinyMCE editor'),
                        'values' => array(
                			array(
                				'id' => 'ETS_CTF7_ENABLE_TMCE_on',
                				'value' => 1,
                				'label' => $this->l('Yes')
                			),
                			array(
                				'id' => 'ETS_CTF7_ENABLE_TMCE_off',
                				'value' => 0,
                				'label' => $this->l('No')
                			)
                		),
                        'default'=>0,
                        'form_group_class'=>'form_group_contact other_setting',
                        'desc' => $this->l('Set this to "Yes" will allow you to enable rich text editor for textarea fields when compiling contact forms'),
                    ), 
                    array(
                        'type' => 'textarea',
                        'name'=>'ETS_CTF7_IP_BLACK_LIST',
                        'label'=> $this->l('IP black list'),
                        'desc' => $this->l('Enter each IP on a line to block those IP from submitting contact forms.'),
                        'form_group_class'=>'form_group_contact black_list',
                    ),
                    array(
                        'type' => 'text',
                        'name'=>'ETS_CTF7_NUMBER_MESSAGE',
                        'label'=> $this->l('Number of messages displayed per message page in back office'),
                        'default'=>20,
                        'validate'=>'isUnsignedId',
                        'form_group_class'=>'form_group_contact other_setting',
                        'required' => true,
                        'validate' => 'isUnsignedInt',
                    ),
                    
				),
				'submit' => array(
					'title' => $this->l('Save'),
				)
			),
		);
        self::$_email_fields=array(
            'form' => array(
				'legend' => array(
					'title' => $this->l('Email template'),
					'icon' => 'icon-file-text-o'
				),
                'id_form'=>'module_form_email_template',
				'input' => array(
                    array(
                        'type' => 'switch',
                        'name'=>'ETS_CTF7_ENABLE_TEAMPLATE',
                        'label'=> $this->l('Enable email template'),
                        'values' => array(
                			array(
                				'id' => 'ETS_CTF7_ENABLE_RECAPTCHA_on',
                				'value' => 1,
                				'label' => $this->l('Yes')
                			),
                			array(
                				'id' => 'ETS_CTF7_ENABLE_RECAPTCHA_off',
                				'value' => 0,
                				'label' => $this->l('No')
                			)
                		),
                        'default'=>1,
                        'form_group_class'=>'template',
                        'desc' => $this->l('Disable this option if you would like to send simple email without HTML/CSS styles'),
                    ), 
                    array(
                        'type'=>'textarea',
                        'label'=> $this->l('Main email template'),
                        'name'=>'ETS_CTF_TEMPLATE_1',
                        'lang'=>true,
                        'required'=>true,
                        'autoload_rte'=>true,
                        'default'=> $this->display(__FILE__,'mail_template.tpl'),
                        'form_group_class'=>'template template2',
                        'desc'=> $this->l('Available shortcodes:').'<span>{shop_name}</span>,<span>{shop_logo}</span>,<span>{message_content}</span>,<span>{shop_url}</span>',
                    ),
                    array(
                        'type'=>'textarea',
                        'label'=> $this->l('Mail 2 template'),
                        'name'=>'ETS_CTF_TEMPLATE_2',
                        'lang'=>true,
                        'required'=>true,
                        'autoload_rte'=>true,
                        'form_group_class'=>'template template2',
                        'default'=> $this->display(__FILE__,'mail_template2.tpl'),
                        'desc'=> $this->l('Available shortcodes:'). '<span>{shop_name}</span>,<span>{shop_logo}</span>,<span>{message_content}</span>,<span>{shop_url}</span>',
                    ),
                    array(
                        'type'=>'textarea',
                        'label'=> $this->l('Reply email template'),
                        'name'=>'ETS_CTF_TEMPLATE_3',
                        'lang'=>true,
                        'required'=>true,
                        'autoload_rte'=>true,
                        'form_group_class'=>'template template2',
                        'default'=> $this->display(__FILE__,'mail_template_reply.tpl'),
                        'desc'=> $this->l('Available shortcodes:').'<span>{shop_name}</span>,<span>{shop_logo}</span>,<span>{message_content}</span>,<span>{shop_url}</span>',
                    ),
				),
				'submit' => array(
					'title' => $this->l('Save'),
				)
			),
        );
        $this->contact_fields = array(
			'form' => array(
				'legend' => array(
					'title' => Tools::getValue('id_contact') ? $this->l('Edit contact form') : $this->l('Add contact form'),
					'icon' => Tools::getValue('id_contact') ? 'icon-pencil-square-o' : 'icon-pencil-square-o'
				),
				'input' => array(
					array(
						'type' => 'text',
						'label' => $this->l('Title'),
						'name' => 'title',
						'required' => true,
						'lang' => true,
                        'form_group_class'=>'form_group_contact form',
					),
                    array(
						'type' => 'textarea',
						'label' => $this->l('Form editor'),
						'name' => 'short_code',
						'required' => true,
						'lang' => true,
                        'id'=>'wpcf7-form',
                        'class'=>'wpcf7-form',
                        'default'=>('<label>Your Name (required) [text* your-name]</label> 
<label>Your Email (required) [email* your-email]</label> 
<label>Subject (required) [text* your-subject]</label> 
<label>Your Message (required) [textarea* your-message]</label>
[submit "Send"]'),
                        'form_group_class'=>'form_group_contact form short_code',
                        'cols'=>'200',
                        'rows' =>'10',                        
					),
                    array(
                        'type' => 'switch',
                        'name'=>'save_message',
                        'label'=> $this->l('Save messages'),
                        'values' => array(
                			array(
                				'id' => 'save_message_on',
                				'value' => 1,
                				'label' => $this->l('Yes')
                			),
                			array(
                				'id' => 'save_message_off',
                				'value' => 0,
                				'label' => $this->l('No')
                			)
                		),
                        'default'=>1,
                        'form_group_class'=>'form_group_contact general_settings',
                        'desc' => $this->l('Save customer messages to "Messages" tab.'),
                    ),
                    array(
                        'type' => 'switch',
                        'name'=>'save_attachments',
                        'label'=> $this->l('Save attachments'),
                        'values' => array(
                			array(
                				'id' => 'save_attachments_on',
                				'value' => 1,
                				'label' => $this->l('Yes')
                			),
                			array(
                				'id' => 'save_attachments_off',
                				'value' => 0,
                				'label' => $this->l('No')
                			)
                		),
                        'desc' => $this->l('Save attached files on your server, you can download the files in "Messages" tab. Enable this option is useful but it will take some of your hosting disk space to store the files. You can set this to "No" if it is not necessary for saving files on server because the files will be also sent to your email inbox'),
                        'default'=>1,
                        'form_group_class'=>'form_group_contact general_settings general_settings4',
                    ),
                    array(
                        'type' => 'switch',
                        'name'=>'star_message',
                        'label'=> $this->l('Star messages from this contact form'),
                        'values' => array(
                			array(
                				'id' => 'star_message_on',
                				'value' => 1,
                				'label' => $this->l('Yes')
                			),
                			array(
                				'id' => 'star_message_off',
                				'value' => 0,
                				'label' => $this->l('No')
                			)
                		),
                        'default'=>0,
                        'form_group_class'=>'form_group_contact general_settings general_settings4',
                        'desc' => $this->l('Hightlight messages sent from this contact form in the "Messages" tab by a yellow star'),
                    ),
                    array(
                        'type' => 'switch',
                        'name'=>'open_form_by_button',
                        'label'=> $this->l('Open form by button'),
                        'values' => array(
                			array(
                				'id' => 'open_form_by_button_on',
                				'value' => 1,
                				'label' => $this->l('Yes')
                			),
                			array(
                				'id' => 'open_form_by_button_off',
                				'value' => 0,
                				'label' => $this->l('No')
                			)
                		),
                        'form_group_class'=>'form_group_contact general_settings',
                        'desc' => $this->l('Display a button (hide the form initially), when customer click on the button, it will open the form via a popup'),
                    ),
                    array(
						'type' => 'text',
						'label' => $this->l('Button label'),
						'name' => 'button_label',
                        'lang'=>true,
                        'default' => $this->l('Open contact form'),
                        'form_group_class'=>'form_group_contact general_settings general_settings2',
					),
                    array(
                        'type' => 'switch',
                        'name'=>'enable_form_page',
                        'label'=> $this->l('Enable separate form page'),
                        'values' => array(
                			array(
                				'id' => 'enable_form_page_on',
                				'value' => 1,
                				'label' => $this->l('Yes')
                			),
                			array(
                				'id' => 'enable_form_page_off',
                				'value' => 0,
                				'label' => $this->l('No')
                			)
                		),
                        'default'=>1,
                        'form_group_class'=>'form_group_contact seo',
                        'desc' => $this->l('Besides displaying the form using shortcode, custom hook and default Prestashop hooks, you can also create a specific web page to display the form'),
                    ),
                    array(
						'type' => 'text',
						'label' => $this->l('Contact alias'),
						'name' => 'title_alias',
                        'lang'=>true,
                        'form_group_class'=>'form_group_contact seo seo3',
					),
                    array(
						'type' => 'text',
						'label' => $this->l('Meta title'),
						'name' => 'meta_title',
                        'lang'=>true,
                        'form_group_class'=>'form_group_contact seo seo3',
					),
                    array(
						'type' => 'tags',
						'label' => $this->l('Meta key words'),
						'name' => 'meta_keyword',
                        'lang'=>true,
                        'form_group_class'=>'form_group_contact seo seo3',
					),
                    array(
						'type' => 'textarea',
						'label' => $this->l('Meta description'),
						'name' => 'meta_description',
                        'lang'=>true,
                        'form_group_class'=>'form_group_contact seo seo3',
					),
                    array(
                        'type'=>'checkbox',
                        'name'=>'hook',
                        'label'=> $this->l('Preserved display position (default Prestashop hooks)'),
                        'values' => array(
                            'query'=>array(
                                array(
                                    'name'=>$this->l('Header - top navigation'),
                                    'val'=>'nav_top',
                                    'id'=>'nav_top',
                                ),
                                array(
                                    'name'=>$this->l('Header - main header'),
                                    'val'=>'header',
                                    'id'=>'header',
                                ),
                                array(
                                    'name'=>$this->l('Top'),
                                    'val'=>'displayTop',
                                    'id' =>'displayTop',
                                ),
                                array(
                                    'name'=>$this->l('Home'),
                                    'val'=>'home',
                                    'id' =>'home',
                                ),
                                array(
                                    'name'=>$this->l('Left column'),
                                    'val'=>'left_column',
                                    'id' =>'left_column',
                                ),
                                array(
                                    'name'=>$this->l('Right column'),
                                    'val'=>'right_column',
                                    'id' =>'right_column',
                                ),
                                 array(
                                    'name'=>$this->l('Footer page'),
                                    'val'=>'footer_page',
                                    'id' =>'footer_page',
                                ),
                                array(
                                    'name'=>$this->l('Product page - below product images'),
                                    'val'=>'product_thumbs',
                                    'id'=>'product_thumbs',
                                ),
                                array(
                                    'name'=>$this->l('Product page - Footer'),
                                    'val'=>'product_footer',
                                    'id'=>'product_footer',
                                ),
                                array(
                                    'name' => $this->l('Checkout page'),
                                    'val'=>'checkout_page',
                                    'id'=>'checkout_page',
                                ),
                                //array(
//                                    'name' => $this->l('Register page'),
//                                    'val'=>'register_page',
//                                    'id'=>'register_page',
//                                ),
                                array(
                                    'name' => $this->l('Login page'),
                                    'val'=>'login_page',
                                    'id'=>'login_page',
                                ),
                            ),
                            'id' => 'id',
                			'name' => 'name'
                        ),
                        'desc' => $this->l('Besides using shortcode, custom hook and a separated page to display the contact form, you can also display contact form on default Prestashop pre-defined hooks'),
                        'form_group_class'=>'form_group_contact general_settings form_hook'
                    ),
                    array(
                		'type' => 'switch',
                		'label' => $this->l('Activate contact form'),
                		'name' => 'active',
                		'values' => array(
                			array(
                				'id' => 'active_on',
                				'value' => 1,
                				'label' => $this->l('Yes')
                			),
                			array(
                				'id' => 'active_off',
                				'value' => 0,
                				'label' => $this->l('No')
                			)
                		),                        
                        'default'=>1,
                        'form_group_class'=>'form_group_contact general_settings',
                	),
                    array(
						'type' => 'text',
						'label' => $this->l('To'),
						'name' => 'email_to',
                        'required' => true,
                        'form_group_class'=>'form_group_contact mail',
                        'default' => Configuration::get('PS_SHOP_NAME').' <'.Configuration::get('PS_SHOP_EMAIL').'>',
					),
                    array(
						'type' => 'text',
						'label' => $this->l('Bcc'),
						'name' => 'bcc',
                        'form_group_class'=>'form_group_contact mail',
					),
                    array(
						'type' => 'text',
						'label' => $this->l('From'),
						'name' => 'email_from',
                        'form_group_class'=>'form_group_contact mail',
                        'default'=> '[your-name] <'.(Configuration::get('PS_MAIL_METHOD')==2? Configuration::get('PS_MAIL_USER'): Configuration::get('PS_SHOP_EMAIL')).'>',
                        'desc' => $this->l('This should be an authorized email address. Normally it is your shop SMTP email (if your website is enabled with SMTP) or an email associated with your website domain name (if your website uses default Mail() function to send emails)'),
					),
                    array(
						'type' => 'text',
						'label' => $this->l('Subject'),
						'name' => 'subject',
                        'lang'=>true,
                        'required' => true,
                        'validate'=>'isMailSubject',
                        'form_group_class'=>'form_group_contact mail',
                        'default' => '[your-subject]',
					),
                    array(
						'type' => 'text',
						'label' => $this->l('Reply to'),
						'name' => 'additional_headers',
                        'form_group_class'=>'form_group_contact mail',
                        'default' => '[your-name] <[your-email]>',
					),
                    array(
						'type' => 'textarea',
						'label' => $this->l('Message body'),
						'name' => 'message_body',
                        'lang'=> true,
                        'autoload_rte'=>true,
                        'form_group_class'=>'form_group_contact mail',
                        'default' => '<p>From: [your-name] ([your-email])</p><p>Subject: [your-subject]</p><p>Message Body: [your-message]</p><p>-- This e-mail was sent from a contact form on '.Configuration::get('PS_SHOP_NAME').'</p>'
					),
                    array(
						'type' => 'text',
						'label' => $this->l('File attachments'),
						'name' => 'file_attachments',
                        'form_group_class'=>'form_group_contact mail',
                        'desc' => $this->l('*Note: You need to enter respective mail-tags for the file form-tags used in the "Form editor" into this field in order to receive the files via email as well as "Messages" tab. See more details about mail-tag in ').'<a target="_blank" href="'.$this->getBaseLink().'modules/ets_contactform7/help/index.html#!/fi-setting-file">'.$this->l('Setting up file attachments with a mail').'</a>',
					),
                    array(
                		'type' => 'switch',
                		'label' => $this->l('Use mail 2'),
                		'name' => 'use_email2',
                		'values' => array(
                			array(
                				'id' => 'use_email2_on',
                				'value' => 1,
                				'label' => $this->l('Yes')
                			),
                			array(
                				'id' => 'use_email2_off',
                				'value' => 0,
                				'label' => $this->l('No')
                			)
                		),
                        'desc'=> $this->l('Mail (2) is an additional mail template often used as an autoresponder.'),
                        'form_group_class'=>'form_group_contact mail',
                	),
                    array(
						'type' => 'text',
						'label' => $this->l('To'),
						'name' => 'email_to2',
                        'form_group_class'=>'form_group_contact mail mail2',
                        'default' =>  '[your-name] <[your-email]>'
					),
                    array(
						'type' => 'text',
						'label' => $this->l('Bcc'),
						'name' => 'bcc2',
                        'form_group_class'=>'form_group_contact mail mail2',
					),
                    array(
						'type' => 'text',
						'label' => $this->l('From'),
						'name' => 'email_from2',
                        'form_group_class'=>'form_group_contact mail mail2',
                        'default'=> '[your-name] <'.(Configuration::get('PS_MAIL_METHOD')==2? Configuration::get('PS_MAIL_USER'): Configuration::get('PS_SHOP_EMAIL')).'>',
                        'desc' => $this->l('This should be an authorized email address. Normally it is your shop SMTP email (if your website is enabled with SMTP) or an email associated with your website domain name (if your website uses default Mail() function to send emails)'),
					),
                    array(
						'type' => 'text',
						'label' => $this->l('Subject'),
						'name' => 'subject2',
                        'lang'=>true,
                        'required' => true,
                        'validate'=>'isMailSubject',
                        'form_group_class'=>'form_group_contact mail mail2',
                        'default' => 'Your email has been sent'
					),
                    array(
						'type' => 'text',
						'label' => $this->l('Reply to'),
						'name' => 'additional_headers2',
                        'form_group_class'=>'form_group_contact mail mail2',
                        'default' => Configuration::get('PS_SHOP_NAME').' <'.Configuration::get('PS_SHOP_EMAIL').'>',
					),
                    array(
						'type' => 'textarea',
						'label' => $this->l('Message body'),
						'name' => 'message_body2',
                        'lang'=> true,
                        'autoload_rte'=>true,
                        'form_group_class'=>'form_group_contact mail mail2',
                        'default' => '<p>From: [your-name] ([your-email])</p><p>Subject: [your-subject]</p><p>Message Body: [your-message]</p><p>-- This e-mail was sent from a contact form on '.Configuration::get('PS_SHOP_NAME').'</p>'
					),
                    array(
						'type' => 'text',
						'label' => $this->l('File attachments'),
						'name' => 'file_attachments2',
                        'form_group_class'=>'form_group_contact mail mail2',
                        'desc' => $this->l('*Note: You need to enter respective mail-tags for the file form-tags used in the "Form editor" into this field in order to receive the files via email. See more details about mail-tag in ').'<a target="_blank" href="'.$this->getBaseLink().'modules/ets_contactform7/help/index.html#!/fi-setting-file">'.$this->l('Setting up file attachments with a mail').'</a>',
					),
                    array(
						'type' => 'text',
						'label' => $this->l('Sender is message was sent successfully'),
						'name' => 'message_mail_sent_ok',
                        'lang'=> true,
                        'default'=> $this->l('Thank you for your message. It has been sent.'),
                        'form_group_class'=>'form_group_contact message',
					),
                    array(
						'type' => 'text',
						'label' => $this->l('Sender is message failed to send'),
						'name' => 'message_mail_sent_ng',
                        'lang'=> true,
                        'default' =>$this->l('There was an error trying to send your message. Please try again later.'),
                        'form_group_class'=>'form_group_contact message',
					),
                    array(
						'type' => 'text',
						'label' => $this->l('Validation errors occurred'),
						'name' => 'message_validation_error',
                        'lang'=> true,
                        'default' =>$this->l('One or more fields have an error. Please check and try again.'),
                        'form_group_class'=>'form_group_contact message',
					),
                    array(
						'type' => 'text',
						'label' => $this->l('Submission was referred to as spam'),
						'name' => 'message_spam',
                        'lang'=> true,
                        'default' =>$this->l('There was an error trying to send your message. Please try again later.'),
                        'form_group_class'=>'form_group_contact message',
					),
                    array(
						'type' => 'text',
						'label' => $this->l('There are terms that the sender must accept'),
						'name' => 'message_accept_terms',
                        'lang'=> true,
                        'default' =>$this->l('You must accept the terms and conditions before sending your message.'),
                        'form_group_class'=>'form_group_contact message',
					),
                    array(
						'type' => 'text',
						'label' => $this->l('There is a field that the sender must fill in'),
						'name' => 'message_invalid_required',
                        'lang'=> true,
                        'default' =>$this->l('The field is required.'),
                        'form_group_class'=>'form_group_contact message',
					),
                    array(
						'type' => 'text',
						'label' => $this->l('There is a field with input that is longer than the maximum allowed length'),
						'name' => 'message_invalid_too_long',
                        'lang'=> true,
                        'default' =>$this->l('The field is too long.'),
                        'form_group_class'=>'form_group_contact message',
					),
                    array(
						'type' => 'text',
						'label' => $this->l('There is a field with input that is shorter than the minimum allowed length'),
						'name' => 'message_invalid_too_short',
                        'lang'=> true,
                        'default' =>$this->l('The field is too short.'),
                        'form_group_class'=>'form_group_contact message',
					),
                    array(
						'type' => 'text',
						'label' => $this->l('Date format that the sender entered is invalid'),
						'name' => 'message_invalid_date',
                        'lang'=> true,
                        'default' =>$this->l('The date format is incorrect.'),
                        'form_group_class'=>'form_group_contact message',
					),
                    array(
						'type' => 'text',
						'label' => $this->l('Date is earlier than minimum limit'),
						'name' => 'message_date_too_early',
                        'lang'=> true,
                        'default' =>$this->l('The date is before the earliest one allowed.'),
                        'form_group_class'=>'form_group_contact message',
					),
                    array(
						'type' => 'text',
						'label' => $this->l('Date is later than maximum limit'),
						'name' => 'message_date_too_late',
                        'lang'=> true,
                        'default' =>$this->l('The date is after the latest one allowed.'),
                        'form_group_class'=>'form_group_contact message',
					),
                    array(
						'type' => 'text',
						'label' => $this->l('Uploading a file fails for any reason'),
						'name' => 'message_upload_failed',
                        'lang'=> true,
                        'default' =>$this->l('There was an unknown error uploading the file.'),
                        'form_group_class'=>'form_group_contact message',
					),
                    array(
						'type' => 'text',
						'label' => $this->l('Uploaded file is not allowed for file type'),
						'name' => 'message_upload_file_type_invalid',
                        'lang'=> true,
                        'default' =>$this->l('You are not allowed to upload files of this type.'),
                        'form_group_class'=>'form_group_contact message',
					),
                    array(
						'type' => 'text',
						'label' => $this->l('Sender does not enter the correct answer to the quiz'),
						'name' => 'message_quiz_answer_not_correct',
                        'lang'=> true,
                        'default' =>$this->l('The answer to the quiz is incorrect.'),
                        'form_group_class'=>'form_group_contact message',
					),
                    array(
						'type' => 'text',
						'label' => $this->l('Uploaded file is too large'),
						'name' => 'message_upload_file_too_large',
                        'lang'=> true,
                        'default' =>$this->l('The file is too big.'),
                        'form_group_class'=>'form_group_contact message',
					),
                    array(
						'type' => 'text',
						'label' => $this->l('Uploading a file fails for PHP error'),
						'name' => 'message_upload_failed_php_error',
                        'lang'=> true,
                        'default' =>$this->l('There was an error uploading the file.'),
                        'form_group_class'=>'form_group_contact message',
					),
                    array(
						'type' => 'text',
						'label' => $this->l('Number format that the sender entered is invalid'),
						'name' => 'message_invalid_number',
                        'lang'=> true,
                        'default' =>$this->l('The number format is invalid.'),
                        'form_group_class'=>'form_group_contact message',
					),
                    array(
						'type' => 'text',
						'label' => $this->l('Number is smaller than minimum limit'),
						'name' => 'message_number_too_small',
                        'lang'=> true,
                        'default' =>$this->l('The number is smaller than the minimum allowed.'),
                        'form_group_class'=>'form_group_contact message',
					),
                    array(
						'type' => 'text',
						'label' => $this->l('Number is larger than maximum limit'),
						'name' => 'message_number_too_large',
                        'lang'=> true,
                        'default' =>$this->l('The number is larger than the maximum allowed'),
                        'form_group_class'=>'form_group_contact message',
					),
                    array(
						'type' => 'text',
						'label' => $this->l('Email address that the sender entered is invalid'),
						'name' => 'message_invalid_email',
                        'lang'=> true,
                        'default' =>$this->l('The e-mail address entered is invalid.'),
                        'form_group_class'=>'form_group_contact message',
					),
                    array(
						'type' => 'text',
						'label' => $this->l('URL that the sender entered is invalid'),
						'name' => 'message_invalid_url',
                        'lang'=> true,
                        'default' =>$this->l('The URL is invalid.'),
                        'form_group_class'=>'form_group_contact message',
					),
                    array(
						'type' => 'text',
						'label' => $this->l('Telephone number that the sender entered is invalid'),
						'name' => 'message_invalid_tel',
                        'lang'=> true,
                        'default' =>$this->l('The telephone number is invalid.'),
                        'form_group_class'=>'form_group_contact message',
					),
                    array(
						'type' => 'text',
						'label' => $this->l('Message ip in black list'),
						'name' => 'message_ip_black_list',
                        'lang'=> true,
                        'default' =>$this->l('You are not allowed to submit this form. Please contact webmaster for more information.'),
                        'form_group_class'=>'form_group_contact message',
					),
                    array(
						'type' => 'text',
						'label' => $this->l('Captcha entered is invalid'),
						'name' => 'message_captcha_not_match',
                        'lang'=> true,
                        'default' =>$this->l('Your entered code is incorrect.'),
                        'form_group_class'=>'form_group_contact message',
					),
                   
				),
				'submit' => array(
					'title' => $this->l('Save'),
				),
                'buttons' => array(
                    array(
                        'type'=>'submit',
                        'id' =>'submitSaveAndStayContact',
                        'name'=>'submitSaveAndStayContact',
                        'icon' =>'process-icon-save',
                        'class'=>'pull-right',
                        'title'=> $this->l('Save and stay'),
                    ),
                    array(
                        'id' =>'backListContact',
                        'href'=> defined('_PS_ADMIN_DIR_')? 'index.php?controller=AdminContactFormContactForm&token='.Tools::getAdminTokenLite('AdminContactFormContactForm'):'#',
                        'icon' =>'process-icon-cancel',
                        'class'=>'pull-left',
                        'title'=> $this->l('Cancel'),
                    )
                )
			),
		);
    }
    public function getContent()
    {
        if(version_compare(_PS_VERSION_, '1.6', '<'))
            $this->context->controller->addJqueryUI('ui.widget');
        else
            $this->context->controller->addJqueryPlugin('widget');
        $this->context->controller->addJqueryPlugin('tagify');
        
        if(Tools::isSubmit('exportContactForm'))
            $this->generateArchive();
        if(Tools::isSubmit('getFormElementAjax'))
        {
            die(Tools::jsonEncode(
                array(
                    'form_html'=>$this->replace_all_form_tags(Tools::getValue('short_code')),
                )
            ));
        }
        if(Tools::isSubmit('contactform7default'))
        {
            if((int)Tools::getValue('contactform7default')==1 && Tools::getValue('id_contact'))
            {
                Configuration::updateValue('ETS_CONTACTFORM7_DEFAULT',Tools::getValue('id_contact')); 
            }elseif((int)Tools::getValue('contactform7default')==0 && Configuration::get('ETS_CONTACTFORM7_DEFAULT')==Tools::getValue('id_contact'))
            {
                Configuration::updateValue('ETS_CONTACTFORM7_DEFAULT',0); 
            }
        }
        elseif(Tools::isSubmit('save_message_update') && $id_contact=Tools::getValue('id_contact'))
        {
            Db::getInstance()->execute('UPDATE '._DB_PREFIX_.'ets_ctf_contact SET save_message="'.(int)Tools::getValue('save_message_update').'" WHERE id_contact='.(int)$id_contact);
        }
        elseif(Tools::isSubmit('submitSaveContact') || Tools::isSubmit('submitSaveAndStayContact'))
        {
            $this->_html .= $this->saveContactFrom();
        }
        elseif(Tools::isSubmit('duplicatecontact') && $id_contact=Tools::getValue('id_contact'))
        {
            $contact= new Ets_contact_class($id_contact);
            unset($contact->id);
            $languages= Language::getLanguages(false);
            foreach($languages as $language)
            {
                $contact->title[$language['id_lang']] = $contact->title[$language['id_lang']].' ['.$this->l('duplicated').']';
            }
            $contact->position=(int)Db::getInstance()->getValue('SELECT count(*) FROM '._DB_PREFIX_.'ets_ctf_contact_shop where id_shop='.(int)$this->context->shop->id);
            $contact->add();
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminContactFormContactForm', true).'&conf=19');
        }
        elseif(Tools::isSubmit('deletecontact') && $id_contact=Tools::getValue('id_contact'))
        {
            $contact= new Ets_contact_class($id_contact);
            $contact->delete();
            Db::getInstance()->execute('DELETE FROM '._DB_PREFIX_.'ets_ctf_contact_shop WHERE id_contact='.(int)$id_contact);
            $contacts = Db::getInstance()->executeS('SELECT * FROM '._DB_PREFIX_.'ets_ctf_contact c ,'._DB_PREFIX_.'ets_ctf_contact_shop cs  WHERE c.id_contact=cs.id_contact AND  id_shop='.(int)$this->context->shop->id.' order by c.position asc');
            $messages= Db::getInstance()->getValue('SELECT attachments FROM '._DB_PREFIX_.'ets_ctf_contact_message WHERE id_contact="'.(int)$id_contact.'"');
            if($messages)
            {
                foreach($messages as $message)
                {
                    if($message['attachments'])
                    {
                        foreach(explode(',',$message['attachments']) as $attachment)
                        {
                            @unlink(dirname(__FILE__).'/views/img/etscf7_upload/'.$attachment);
                        }
                    }
                }
            }
            if($contacts)
                foreach($contacts as $key=> $contact)
                {
                    Db::getInstance()->execute('UPDATE '._DB_PREFIX_.'ets_ctf_contact set position="'.(int)$key.'" WHERE id_contact='.(int)$contact['id_contact']);
                }
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&conf=1');
        }
        elseif(Tools::isSubmit('preview') && $id_contact=Tools::getValue('id_contact'))
        {
            $contact= new Ets_contact_class($id_contact,$this->context->language->id);
            die(Tools::jsonEncode(
                array(
                    'form_html'=>$this->replace_all_form_tags($contact->short_code),
                    'contact'=>$contact,
                )
            ));
        }
        elseif(Tools::isSubmit('active_update') && $id_contact=Tools::getValue('id_contact'))
        {
            Db::getInstance()->execute('UPDATE '._DB_PREFIX_.'ets_ctf_contact SET active="'.(int)Tools::getValue('active_update').'" WHERE id_contact='.(int)$id_contact);
        }
        if(Tools::isSubmit('editContact') || Tools::isSubmit('addContact'))
        {
            $this->context->smarty->assign(
                array(
                    'link'=> $this->context->link,
                    'link_basic' => $this->getBaseLink(),
                    'ETS_CTF7_ENABLE_TMCE' => Configuration::get('ETS_CTF7_ENABLE_TMCE'),
                )
            );
            $this->_html .= $this->renderAddContactForm();
            $this->_html .= $this->display(__FILE__,'url.tpl');
            $this->_html .= $this->display(__FILE__,'textarea.tpl');
            $this->_html .= $this->display(__FILE__,'text.tpl');
            $this->_html .= $this->display(__FILE__,'telephone.tpl');
            $this->_html .= $this->display(__FILE__,'submit.tpl');
            $this->_html .= $this->display(__FILE__,'select.tpl');
            $this->_html .= $this->display(__FILE__,'radio.tpl');
            $this->_html .= $this->display(__FILE__,'quiz.tpl');
            $this->_html .= $this->display(__FILE__,'number.tpl');
            $this->_html .= $this->display(__FILE__,'email.tpl');
            $this->_html .= $this->display(__FILE__,'checkbox.tpl');
            $this->_html .= $this->display(__FILE__,'captcha.tpl');
            $this->_html .= $this->display(__FILE__,'recaptcha.tpl');
            $this->_html .= $this->display(__FILE__,'acceptance.tpl');
            $this->_html .= $this->display(__FILE__,'date.tpl');   
            $this->_html .= $this->display(__FILE__,'file.tpl');
        }
        else
        {
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminContactFormContactForm',true));
        }
        $this->context->smarty->assign(
            array(
                'html_content' => $this->_html,
                'okimport' => Tools::getValue('okimport'),
                '_PS_JS_DIR_' =>_PS_JS_DIR_,
                'ETS_CTF7_ENABLE_TMCE' => Configuration::get('ETS_CTF7_ENABLE_TMCE'),
            )
        );
        return $this->display(__FILE__,'admin.tpl');
    }
    public function install()
	{
        return parent::install()&& $this->_registerHook() && $this->installDb()&& $this->_installTabs()&& $this->createTemplateMail();       
    }
    public function _registerHook()
    {
        foreach($this->_hooks as $hook)
        {
            $this->registerHook($hook);
        }
        return true;
    }
    public function uninstall()
	{
        return parent::uninstall()&& $this->uninstallDb() && $this->_uninstallTabs();
    } 
    private function _installTabs()
    {
        $languages = Language::getLanguages(false);
        $tab = new Tab();
        $tab->class_name = 'AdminContactForm';
        $tab->module = $this->name;
        $tab->id_parent = 0;            
        foreach($languages as $lang){
            $tab->name[$lang['id_lang']] = $this->l('Contact');
        }
        $tab->save();
        if($tabId = $tab->id)
        {
            $subTabs = array(
                array(
                    'class_name' => 'AdminContactFormContactForm',
                    'tab_name' => $this->l('Contact forms'),
                    'icon'=>'icon icon-envelope-o'
                ),
                array(
                    'class_name' => 'AdminContactFormMessage',
                    'tab_name' => $this->l('Messages'),
                    'icon'=>'icon icon-comments',
                ),
                array(
                    'class_name' => 'AdminContactFormEmail',
                    'tab_name' => $this->l('Email templates'),
                    'icon'=>'icon icon-file-text-o',
                ),
                array(
                    'class_name' => 'AdminContactFormImportExport',
                    'tab_name' => $this->l('Import/Export'),
                    'icon'=>'icon icon-exchange',
                ),
                array(
                    'class_name' => 'AdminContactFormIntegration',
                    'tab_name' => $this->l('Integration'),
                    'icon'=>'icon icon-cogs',
                ),
                array(
                    'class_name' => 'AdminContactFormStatistics',
                    'tab_name' => $this->l('Statistics'),
                    'icon'=>'icon icon-line-chart',
                ),
                array(
                    'class_name' => 'AdminContactFormHelp',
                    'tab_name' => $this->l('Help'),
                    'icon'=>'icon icon-question-circle',
                ),
            );
            
            foreach($subTabs as $tabArg)
            {
                $tab = new Tab();
                $tab->class_name = $tabArg['class_name'];
                $tab->module = $this->name;
                $tab->id_parent = $tabId; 
                $tab->icon=$tabArg['icon'];           
                foreach($languages as $lang){
                        $tab->name[$lang['id_lang']] = $tabArg['tab_name'];
                }
                $tab->save();
            }                
        }            
        return true;
    }
    public function createTemplateMail(){
        $languages= Language::getLanguages(false);
        foreach($languages as $language)
        {
            if (!file_exists(dirname(__FILE__).'/mails/'.$language['iso_code'])) {
                mkdir(dirname(__FILE__).'/mails/'.$language['iso_code'], 0755, true);
                Tools::copy(dirname(__FILE__).'/mails/en/contact_form7.html',dirname(__FILE__).'/mails/'.$language['iso_code'].'/contact_form7.html');
                Tools::copy(dirname(__FILE__).'/mails/en/contact_form7.txt',dirname(__FILE__).'/mails/'.$language['iso_code'].'/contact_form7.txt');
                Tools::copy(dirname(__FILE__).'/mails/en/ncontact_reply_form7.html',dirname(__FILE__).'/mails/'.$language['iso_code'].'/contact_reply_form7.html');
                Tools::copy(dirname(__FILE__).'/mails/en/contact_reply_form7.txt',dirname(__FILE__).'/mails/'.$language['iso_code'].'/contact_reply_form7.txt');
                Tools::copy(dirname(__FILE__).'/mails/en/contact_form_7_plain.txt',dirname(__FILE__).'/mails/'.$language['iso_code'].'/contact_form_7_plain.txt');
                Tools::copy(dirname(__FILE__).'/mails/en/contact_form_7_plain.html',dirname(__FILE__).'/mails/'.$language['iso_code'].'/contact_form_7_plain.html');
                Tools::copy(dirname(__FILE__).'/mails/en/contact_reply_form7_plain.txt',dirname(__FILE__).'/mails/'.$language['iso_code'].'/contact_reply_form7_plain.txt');
                Tools::copy(dirname(__FILE__).'/mails/en/contact_reply_form7_plain.html',dirname(__FILE__).'/mails/'.$language['iso_code'].'/contact_reply_form7_plain.html');
                Tools::copy(dirname(__FILE__).'/mails/en/index.php',dirname(__FILE__).'/mails/'.$language['iso_code'].'/index.php');  
            }
        }
        return true;
    }
    private function _uninstallTabs()
    {
        $tabs = array('AdminContactFormContactForm','AdminContactFormMessage','AdminContactFormIntegration','AdminContactFormHelp','AdminContactFormImportExport','AdminContactFormEmail','AdminContactForm','AdminContactFormStatistics');
        if($tabs)
        foreach($tabs as $classname)
        {
            if($tabId = Tab::getIdFromClassName($classname))
            {
                $tab = new Tab($tabId);
                if($tab)
                    $tab->delete();
            }                
        }
        return true;
    }
    public function installDb()
    {
        $res = Db::getInstance()->execute('
        CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'ets_ctf_contact` (
          `id_contact` int(11) unsigned NOT NULL AUTO_INCREMENT,
          `email_to` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
          `bcc` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
          `email_from` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
          `exclude_lines` int(11) NOT NULL,
          `use_html_content` int(11) NOT NULL,
          `use_email2` int(11) NOT NULL,
          `email_to2` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
          `bcc2` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
          `email_from2` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
          `additional_headers` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
          `additional_headers2` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
          `exclude_lines2` int(11) NOT NULL,
          `use_html_content2` int(11) NOT NULL,
          `id_employee` int(1) NOT NULL,
          `save_message` int(1) NOT NULL,
          `save_attachments` INT(1) NOT NULL,
          `star_message` INT(1) NOT NULL,
          `open_form_by_button` INT (1),
          `file_attachments2` text CHARACTER SET utf8 COLLATE utf8_general_ci	 NOT NULL,
          `file_attachments` text CHARACTER SET utf8 COLLATE utf8_general_ci	 NOT NULL,
          `hook` VARCHAR(222),
          `active` INT(1),
          `enable_form_page` INT(1),
          `position` INT(11),
          `date_add` date NOT NULL,
          `date_upd` date NOT NULL,
          PRIMARY KEY (`id_contact`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1');
        $res &= Db::getInstance()->execute('
        CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'ets_ctf_contact_lang` (
          `id_contact` int(11) NOT NULL,
          `id_lang` int(11) NOT NULL,
          `title` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
          `title_alias` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
          `meta_title` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
          `meta_keyword` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
          `meta_description` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
          `button_label` VARCHAR(222),
          `short_code` text CHARACTER SET utf8 COLLATE utf8_general_ci	 NOT NULL,
          `template_mail` text NOT NULL,
          `subject` text CHARACTER SET utf8 COLLATE utf8_general_ci	 NOT NULL,
          `message_body` text CHARACTER SET utf8 COLLATE utf8_general_ci	,
          `subject2` text CHARACTER SET utf8 COLLATE utf8_general_ci	 NOT NULL,
          `message_body2` text CHARACTER SET utf8 COLLATE utf8_general_ci	,
          `message_mail_sent_ok` text CHARACTER SET utf8 COLLATE utf8_general_ci	 NOT NULL,
          `message_mail_sent_ng` text CHARACTER SET utf8 COLLATE utf8_general_ci	 NOT NULL,
          `message_validation_error` text CHARACTER SET utf8 COLLATE utf8_general_ci	 NOT NULL,
          `message_spam` text CHARACTER SET utf8 COLLATE utf8_general_ci	 NOT NULL,
          `message_accept_terms` text CHARACTER SET utf8 COLLATE utf8_general_ci	 NOT NULL,
          `message_invalid_required` text CHARACTER SET utf8 COLLATE utf8_general_ci	 NOT NULL,
          `message_invalid_too_long` text CHARACTER SET utf8 COLLATE utf8_general_ci	 NOT NULL,
          `message_invalid_too_short` text CHARACTER SET utf8 COLLATE utf8_general_ci	 NOT NULL,
          `message_date_too_early` text CHARACTER SET utf8 COLLATE utf8_general_ci	 NOT NULL, 
          `message_invalid_date` text CHARACTER SET utf8 COLLATE utf8_general_ci	 NOT NULL,
          `message_date_too_late` text CHARACTER SET utf8 COLLATE utf8_general_ci	 NOT NULL,
          `message_upload_failed` text CHARACTER SET utf8 COLLATE utf8_general_ci	 NOT NULL,
          `message_upload_file_type_invalid` text CHARACTER SET utf8 COLLATE utf8_general_ci	 NOT NULL,
          `message_upload_file_too_large` text CHARACTER SET utf8 COLLATE utf8_general_ci	 NOT NULL,
          `message_quiz_answer_not_correct` text CHARACTER SET utf8 COLLATE utf8_general_ci	 NOT NULL,
          `message_invalid_email` text CHARACTER SET utf8 COLLATE utf8_general_ci	 NOT NULL,
          `message_invalid_url` text CHARACTER SET utf8 COLLATE utf8_general_ci	 NOT NULL,
          `message_invalid_tel` text CHARACTER SET utf8 COLLATE utf8_general_ci	 NOT NULL,
          `additional_settings` text CHARACTER SET utf8 COLLATE utf8_general_ci	 NOT NULL,
          `message_upload_failed_php_error` text CHARACTER SET utf8 COLLATE utf8_general_ci	 NOT NULL,
          `message_invalid_number` text CHARACTER SET utf8 COLLATE utf8_general_ci	 NOT NULL,
          `message_number_too_small` text CHARACTER SET utf8 COLLATE utf8_general_ci	 NOT NULL,
          `message_number_too_large` text CHARACTER SET utf8 COLLATE utf8_general_ci	 NOT NULL,
          `message_captcha_not_match` text CHARACTER SET utf8 COLLATE utf8_general_ci	 NOT NULL,
          `message_ip_black_list` text CHARACTER SET utf8 COLLATE utf8_general_ci	 NOT NULL
        )ENGINE=InnoDB DEFAULT CHARSET=latin1');
        $res &=Db::getInstance()->execute('CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'ets_ctf_contact_shop` (
          `id_contact` int(11) NOT NULL,
          `id_shop` int(11) NOT NULL
        )ENGINE=InnoDB DEFAULT CHARSET=latin1');
        $res &=Db::getInstance()->execute('
        CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'ets_ctf_contact_message`(
          `id_contact_message` int(11) unsigned NOT NULL AUTO_INCREMENT ,
          `id_contact` int(11) NOT NULL,
          `id_customer` INT (11) NOT NULL,
          `replied` INT(1) NOT NULL,
          `readed` INT(1) NOT NULL,
          `special` INT(1) NOT NULL,
          `subject` text CHARACTER SET utf8 COLLATE utf8_general_ci	 NOT NULL,
          `sender` text CHARACTER SET utf8 COLLATE utf8_general_ci	 NOT NULL,
          `body` text CHARACTER SET utf8 COLLATE utf8_general_ci	 NOT NULL,
          `recipient` text CHARACTER SET utf8 COLLATE utf8_general_ci	 NOT NULL,
          `attachments` text CHARACTER SET utf8 COLLATE utf8_general_ci	 NOT NULL,
          `reply_to` text CHARACTER SET utf8 COLLATE utf8_general_ci	 NOT NULL,
          `date_add` DATETIME NOT NULL,
          `date_upd` DATETIME NOT NULL,
          PRIMARY KEY (`id_contact_message`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1');
        $res &=Db::getInstance()->execute('CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'ets_ctf_contact_message_shop` (
          `id_contact_message` int(11) NOT NULL,
          `id_shop` int(11) NOT NULL
        )ENGINE=InnoDB DEFAULT CHARSET=latin1');
        $res &=Db::getInstance()->execute('CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'ets_ctf_message_reply`(
            `id_ets_ctf_message_reply` INT(11) unsigned NOT NULL AUTO_INCREMENT ,
            `id_contact_message` INT(11) NOT NULL,
            `id_employee` INT(11) NOT NULL,
            `content` text CHARACTER SET utf8 COLLATE utf8_general_ci	 NOT NULL,
            `reply_to` text CHARACTER SET utf8 COLLATE utf8_general_ci	 NOT NULL,
            `subject` text CHARACTER SET utf8 COLLATE utf8_general_ci	 NOT NULL,
            `date_add` date NOT NULL,
            `date_upd` date NOT NULL,
            PRIMARY KEY (`id_ets_ctf_message_reply`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1');
        $res &= Db::getInstance()->execute('CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'ets_ctf_log`(
            `ip` varchar(50) DEFAULT NULL,
            `id_contact` INT(11) NOT NULL,
            `browser` varchar(70) DEFAULT NULL,
            `id_customer` INT (11) DEFAULT NULL,
            `datetime_added` datetime NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8');
        $res &= $this->_installDbConfig();
        return $res;
    }
    public function uninstallDb()
    {
        $res = Db::getInstance()->execute('DROP TABLE IF EXISTS '._DB_PREFIX_.'ets_ctf_contact');
        $res &= Db::getInstance()->execute('DROP TABLE IF EXISTS '._DB_PREFIX_.'ets_ctf_contact_lang');
        $res &= Db::getInstance()->execute('DROP TABLE IF EXISTS '._DB_PREFIX_.'ets_ctf_contact_shop');
        $res &= Db::getInstance()->execute('DROP TABLE IF EXISTS '._DB_PREFIX_.'ets_ctf_contact_message');
        $res &= Db::getInstance()->execute('DROP TABLE IF EXISTS '._DB_PREFIX_.'ets_ctf_contact_message_shop');
        $res &= Db::getInstance()->execute('DROP TABLE IF EXISTS '._DB_PREFIX_.'ets_ctf_message_reply'); 
        $res &= Db::getInstance()->execute('DROP TABLE IF EXISTS '._DB_PREFIX_.'ets_ctf_log');
        $res &= $this->_unInstallDbConfig();
        return $res;
    }
    public function hookDisplayHeader() 
    {
        $this->context->controller->addJS($this->_path.'views/js/date.js');
        $this->context->controller->addCSS($this->_path.'views/css/date.css','all');
        $this->context->controller->addJS($this->_path.'views/js/scripts.js');
        $this->context->controller->addCSS($this->_path.'views/css/style.css','all');
        if(version_compare(_PS_VERSION_, '1.6', '<'))
            $this->context->controller->addCSS($this->_path.'views/css/style15.css','all');
        if(version_compare(_PS_VERSION_, '1.7', '<') && version_compare(_PS_VERSION_, '1.5', '>'))
                $this->context->controller->addCSS($this->_path.'views/css/style16.css','all');
        if(Configuration::get('ETS_CTF7_ENABLE_TMCE'))
        {
            $this->context->controller->addJS($this->_path.'views/js/tinymce/tinymce.min.js');            
        }
        $this->context->smarty->assign(
            array(
                'url_basic'=> $this->getBaseLink(),
                'link_contact_ets' => $this->context->link->getModuleLink('ets_contactform7','contact'),
            )
        );
        return $this->display(__FILE__,'header.tpl').$this->getContactFormByHook('header');
    }
    public function renderFormConfig()
    {
		$helper = new HelperForm();
		$helper->show_toolbar = false;
		$helper->table = $this->table;
		$lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->default_form_language = $lang->id;
		$helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
		$this->fields_form = array();
		$helper->id = (int)Tools::getValue('id_carrier');
		$helper->identifier = $this->identifier;
		$helper->submit_action = 'btnSubmit';
		$helper->currentIndex = $this->context->link->getAdminLink('AdminContactFormIntegration',false);
		$helper->token = Tools::getAdminTokenLite('AdminContactFormIntegration');
		$helper->tpl_vars = array(
            'base_url' => $this->context->shop->getBaseURL(),        
			'fields_value' => $this->getConfigFieldsValues(),
			'languages' => $this->context->controller->getLanguages(),
			'id_language' => $this->context->language->id,
            'image_baseurl' => $this->_path.'views/img/',
            'page'=>'integration',
            'name_controller'=>'integration',
            'link_basic'=> $this->getBaseLink(),
            'ps15'=> version_compare(_PS_VERSION_, '1.6', '<') ? true: false,            
		);
        $helper->module = $this;
		return $helper->generateForm(array(self::$_config_fields));
	}
    public function renderFormEmail()
    {
		$helper = new HelperForm();
		$helper->show_toolbar = false;
		$helper->table = $this->table;
		$lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->default_form_language = $lang->id;
		$helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
		$this->fields_form = array();
		$helper->id = (int)Tools::getValue('id_carrier');
		$helper->identifier = $this->identifier;
		$helper->submit_action = 'btnSubmit';
		$helper->currentIndex = $this->context->link->getAdminLink('AdminContactFormEmail',false);
		$helper->token = Tools::getAdminTokenLite('AdminContactFormEmail');
		$helper->tpl_vars = array(
            'base_url' => $this->context->shop->getBaseURL(),        
			'fields_value' => $this->getEmailFieldsValues(),
			'languages' => $this->context->controller->getLanguages(),
			'id_language' => $this->context->language->id,
            'image_baseurl' => $this->_path.'views/img/',
            'page'=>'email',
            'name_controller'=>'email',
            'link_basic'=> $this->getBaseLink(),
            'ps15'=> version_compare(_PS_VERSION_, '1.6', '<') ? true: false,            
		);
        $helper->module = $this;
		return $helper->generateForm(array(self::$_email_fields));
	}
    public function getEmailFieldsValues()
    {
        $fields_config=self::$_email_fields;
        $inputs = $fields_config['form']['input'];
        $languages= Language::getLanguages(false);
        $fields=array();
        if($inputs)
        {
            foreach($inputs as $input)
            {
                $key= $input['name'];
                if(isset($input['lang']) && $input['lang'])
                {
                    foreach($languages as $language)
                    {
                        $fields[$key][$language['id_lang']] = Tools::getValue($key.'_'.$language['id_lang'],Configuration::get($key,$language['id_lang']));
                    }
                }
                else
                    $fields[$key] = Tools::getValue($key,Configuration::get($key));
            }
        }
        return $fields;
    }
	public function getConfigFieldsValues()
	{
	   $fields_config=self::$_config_fields;
	   $inputs = $fields_config['form']['input'];
       $languages= Language::getLanguages(false);
       $fields=array();
       if($inputs)
       {
            foreach($inputs as $input)
            {
                $key= $input['name'];
                if(isset($input['lang']) && $input['lang'])
                {
                    foreach($languages as $language)
                    {
                        $fields[$key][$language['id_lang']] = Tools::getValue($key.'_'.$language['id_lang'],Configuration::get($key,$language['id_lang']));
                    }
                }
                else
                    $fields[$key] = Tools::getValue($key,Configuration::get($key));
            }
       }
       return $fields;
	}
    public function renderAddContactForm()
	{
        if (Tools::isSubmit('id_contact'))
		{
			$this->contact_fields['form']['input'][] = array('type' => 'hidden', 'name' => 'id_contact');
            $this->contact_fields['form']['legend']['new']= $this->context->link->getAdminLink('AdminModules').'&configure=ets_contactform7&tab_module=front_office_features&module_name=ets_contactform7&addContact=1';
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
		$helper->submit_action = 'submitSaveContact';
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.(Tools::isSubmit('editContact') && Tools::getValue('id_contact')?'&editContact=1&id_contact='.(int)Tools::getValue('id_contact'):'&addContact=1');
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$language = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->tpl_vars = array(
			'base_url' => $this->context->shop->getBaseURL(),
			'language' => array(
				'id_lang' => $language->id,
				'iso_code' => $language->iso_code
			),
			'fields_value' => $this->getAddContactFieldsValues(),
			'languages' => $this->context->controller->getLanguages(),
			'id_language' => $this->context->language->id,
			'image_baseurl' => $this->_path.'views/img/',
            'page'=>'contact',
            'link_basic'=> $this->getBaseLink(),
            'name_controller'=>'edit_contact_form',
            'ps15'=> version_compare(_PS_VERSION_, '1.6', '<') ? true: false,
		);
		$helper->override_folder = '/';
        return $helper->generateForm(array($this->contact_fields));	
	}
    public function getAddContactFieldsValues()
    {
        $fields = array();
        $languages=Language::getLanguages(true);
        $inputs=$this->contact_fields['form']['input'];
		if($id_contact=(int)Tools::getValue('id_contact'))
		{
			$contact= new Ets_contact_class($id_contact);
            if($inputs)
            {
                foreach($inputs as $input)
                {
                    $key=$input['name'];
                    if(isset($input['lang']) && $input['lang'])
                    {                    
                        foreach($languages as $l)
                        {
                            $temp = $contact->$key;
                            $fields[$key][$l['id_lang']] = Tools::getValue($key.'_'.$l['id_lang'],$temp[$l['id_lang']]);
                        }
                    }
                    elseif($input['name']=='id_contact')
                    {
                        $fields['id_contact']=Tools::getValue('id_contact');
                        $fields['link_contact'] = $contact->enable_form_page? Ets_contactform7::getLinkContactForm(Tools::getValue('id_contact')):'';
                    }
                    elseif($input['type']=='checkbox')
                    {
                        $values=Tools::getValue($key, explode(',',$contact->$key));
                        if($values)
                        {
                            foreach($values as $value)
                            {
                                $fields[$key.'_'.$value] =1 ;
                            }
                        }
                        
                    }
                    elseif($input['type']=='select' && isset($input['multiple'])&&$input['multiple'])
                    {
                        $fields[$key.'[]']= Tools::getValue($key, explode(',',$contact->$key));
                    }
                    elseif(!isset($input['tree'])&& $input['type']!='checkbox')
                        $fields[$key] = Tools::getValue($key,$contact->$key);
                }
            }
		}
		else
        {
            $contact= new Ets_contact_class();
            foreach($inputs as $input)
            {
                $key=$input['name'];
                if(isset($input['lang']) && $input['lang'])
                {                    
                    foreach($languages as $l)
                    {
                        $temp = $contact->$key;
                        $fields[$key][$l['id_lang']] = isset($input['default'])&&$input['default'] ? Tools::getValue($key.'_'.$l['id_lang'],$input['default']):Tools::getValue($key.'_'.$l['id_lang']);
                    }
                }
                elseif($input['name']=='id_contact')
                {
                    $fields['id_contact']=Tools::getValue('id_contact');
                }
                elseif($input['type']=='checkbox')
                {
                    $values = isset($input['default'])&&$input['default'] ? Tools::getValue($key,explode(',',$input['default'])):Tools::getValue($key);
                    if($values)
                    {
                        foreach($values as $value)
                        {
                            $fields[$key.'_'.$value] =1 ;
                        }
                    }
                }
                elseif($input['type']=='select' && isset($input['multiple'])&&$input['multiple'])
                {
                    $fields[$key.'[]']= Tools::getValue($key);
                }
                elseif(!isset($input['tree'])&& $input['type']!='checkbox')
                    $fields[$key] = isset($input['default'])&&$input['default'] ? Tools::getValue($key,$input['default']):Tools::getValue($key);
                
            }
        }
		return $fields;
    }
    public function hookDisplayBackOfficeHeader()
    {
        if(Tools::getValue('configure')==$this->name && Tools::getValue('controller')=='AdminModules')
        {
            $this->context->controller->addCSS((__PS_BASE_URI__).'modules/'.$this->name.'/views/css/contact_form7_admin.css','all');
            if(version_compare(_PS_VERSION_, '1.6', '<'))
                $this->context->controller->addCSS((__PS_BASE_URI__).'modules/'.$this->name.'/views/css/contact_form7_admin15.css','all');
        }
        $this->context->controller->addCSS((__PS_BASE_URI__).'modules/'.$this->name.'/views/css/font-awesome.css','all');
        $this->context->controller->addCSS((__PS_BASE_URI__).'modules/'.$this->name.'/views/css/contact_form7_admin_all.css','all');
        
        if(Tools::getValue('controller')=='AdminContactFormStatistics' || Tools::getValue('controller')=='AdminContactFormEmail' || Tools::getValue('controller')=='AdminContactFormImportExport'|| Tools::getValue('controller')=='AdminContactFormContactForm'|| Tools::getValue('controller')=='AdminContactFormMessage'||Tools::getValue('controller')=='AdminContactFormIntegration'|| Tools::getValue('controller')=='AdminContactFormHelp')
        {
            $this->context->controller->addCSS((__PS_BASE_URI__).'modules/'.$this->name.'/views/css/contact_form7_admin.css','all');
             if(version_compare(_PS_VERSION_, '1.7', '<') && version_compare(_PS_VERSION_, '1.5', '>'))
                $this->context->controller->addCSS((__PS_BASE_URI__).'modules/'.$this->name.'/views/css/contact_form7_admin16.css','all');
            if(version_compare(_PS_VERSION_, '1.6', '<'))
                $this->context->controller->addCSS((__PS_BASE_URI__).'modules/'.$this->name.'/views/css/contact_form7_admin15.css','all');
        }
        if(Tools::getValue('controller')=='AdminContactFormStatistics')
        {
            $this->context->controller->addCSS((__PS_BASE_URI__).'modules/'.$this->name.'/views/css/nv.d3_rtl.css.css','all');
            $this->context->controller->addCSS((__PS_BASE_URI__).'modules/'.$this->name.'/views/css/nv.d3.css.css','all');
        }
        
    }
    public function saveContactFrom()
    {
        $errors = array();
        $languages = Language::getLanguages(false);
        $id_lang_default = (int)Configuration::get('PS_LANG_DEFAULT');
        $configs = $this->contact_fields['form']['input'];       
        if($configs)
        {
            foreach($configs as $config)
            {
                $key= $config['name'];
                if(isset($config['lang']) && $config['lang'])
                {
                    if(isset($config['required']) && $config['required'] && $config['type']!='switch' && trim(Tools::getValue($key.'_'.$id_lang_default) == ''))
                    {
                        $errors[] = $config['label'].' '.$this->l('is required');
                    }
                    elseif(isset($config['validate']) && method_exists('Validate',$config['validate']))
                    {
                        $validate = $config['validate'];
                        if(!Validate::$validate(trim(Tools::getValue($key.'_'.$id_lang_default))))
                            $errors[] = $config['label'].' '.$this->l('is invalid');
                        else{
                            $languages= Language::getLanguages(false);
                            if($languages)
                            {
                                foreach($languages as $lang)
                                {
                                    if( Tools::getValue($key.'_'.$lang['id_lang']) &&!Validate::$validate(trim(Tools::getValue($key.'_'.$lang['id_lang']))))
                                        $errors[] = $config['label'].' '.$lang['iso_code'].' '.$this->l('is invalid');
                                }
                            }
                        }
                        unset($validate);
                    }                        
                }
                else
                {
                    if(isset($config['required']) && $config['required'] && isset($config['type']) && $config['type']=='file')
                    {
                        if($this->$key=='' && !isset($_FILES[$key]['size']))
                            $errors[] = $config['label'].' '.$this->l('is required');
                        elseif(isset($_FILES[$key]['size']))
                        {
                            $fileSize = round((int)$_FILES[$key]['size'] / (1024 * 1024));
                			if($fileSize > 100)
                                $errors[] = $config['label'].' '.$this->l('Upload file cannot be large than 100MB');
                        }   
                    }
                    else
                    {
                        if(isset($config['required']) && $config['required'] && $config['type']!='switch' && trim(Tools::getValue($key) == ''))
                        {
                            $errors[] = $config['label'].' '.$this->l('is required');
                        }
                        elseif(!is_array(Tools::getValue($key)) && isset($config['validate']) && method_exists('Validate',$config['validate']))
                        {
                            $validate = $config['validate'];
                            if(!Validate::$validate(trim(Tools::getValue($key))))
                                $errors[] = $config['label'].' '.$this->l('is invalid');
                            unset($validate);
                        }
                    }                          
                }                    
            }
        }
        if(Tools::getValue('enable_form_page'))
        {
            foreach($languages as $language)
            {
                if(Tools::getValue('title_alias_'.$language['id_lang']) && !Validate::isLinkRewrite(Tools::getValue('title_alias_'.$language['id_lang'])))
                {
                    $this->l('Title alias').' ('.$language['iso_code'].') is invalid';
                }
            }
        }            
        if(!$errors)
        {   
            if($id_contact=Tools::getValue('id_contact'))
            {
                $contact= new Ets_contact_class($id_contact);
            } 
            else
            {
                $contact= new Ets_contact_class();
                $contact->position=(int)Db::getInstance()->getValue('SELECT count(*) FROM '._DB_PREFIX_.'ets_ctf_contact_shop where id_shop='.(int)$this->context->shop->id);
            }
            $contact->id_employee= (int)$this->context->employee->id;
            $contact->id_employee = $this->context->employee->id;    
            if($configs)
            {
                foreach($configs as $config)
                {
                    $key=$config['name'];
                    if(isset($config['lang']) && $config['lang'])
                    {
                        $valules = array();
                        foreach($languages as $lang)
                        {
                            if($config['type']=='switch')                                                           
                                $valules[$lang['id_lang']] = (int)trim(Tools::getValue($key.'_'.$lang['id_lang'])) ? 1 : 0;                                
                            else
                                $valules[$lang['id_lang']] = trim(Tools::getValue($key.'_'.$lang['id_lang'])) ? trim(Tools::getValue($key.'_'.$lang['id_lang'])) : trim(Tools::getValue($key.'_'.$id_lang_default));
                        }
                        $contact->$key = $valules;
                    }
                    elseif($config['type']=='switch')
                    {                           
                        $contact->$key = (int)Tools::getValue($key) ? 1 : 0;                                                      
                    }
                    elseif($config['type']=='file')
                    {
                        //Upload file
                        if(isset($_FILES[$key]['tmp_name']) && isset($_FILES[$key]['name']) && $_FILES[$key]['name'])
                        {
                            $salt = Tools::substr(sha1(microtime()),0,10);
                            $type = Tools::strtolower(Tools::substr(strrchr($_FILES[$key]['name'], '.'), 1));
                            $imageName = @file_exists(dirname(__FILE__).'/../views/img/upload/'.Tools::strtolower($_FILES[$key]['name']))|| Tools::strtolower($_FILES[$key]['name'])==$contact->$key ? $salt.'-'.Tools::strtolower($_FILES[$key]['name']) : Tools::strtolower($_FILES[$key]['name']);
                            $fileName = dirname(__FILE__).'/../views/img/upload/'.$imageName;                
                            if(file_exists($fileName))
                            {
                                $errors[] = $config['label'].' '.$this->l('File name already exists. Try to rename the file and upload again');
                            }
                            else
                            {                                    
                    			$imagesize = @getimagesize($_FILES[$key]['tmp_name']);                                    
                                if (!$errors && isset($_FILES[$key]) &&				
                    				!empty($_FILES[$key]['tmp_name']) &&
                    				!empty($imagesize) &&
                    				in_array($type, array('jpg', 'gif', 'jpeg', 'png'))
                    			)
                    			{
                    				$temp_name = tempnam(_PS_TMP_IMG_DIR_, 'PS');    				
                    				if ($error = ImageManager::validateUpload($_FILES[$key]))
                    					$errors[] = $error;
                    				elseif (!$temp_name || !move_uploaded_file($_FILES[$key]['tmp_name'], $temp_name))
                    					$errors[] = $this->l('Cannot upload file');
                    				elseif (!ImageManager::resize($temp_name, $fileName, null, null, $type))
                    					$errors[] = $this->l('An error occurred during the image upload process.');
                    				if (isset($temp_name))
                    					@unlink($temp_name);
                                    if(!$errors)
                                    {
                                        if($contact->$key!='')
                                        {
                                            $oldImage = dirname(__FILE__).'/../views/img/upload/'.$contact->$key;
                                            if(file_exists($oldImage))
                                                @unlink($oldImage);
                                        }  
                                        $contact->$key = $imageName;
                                    }
                                }
                            }
                        }
                        //End upload file                       
                    }
                    elseif($config['type']=='categories' && isset($config['tree']['use_checkbox']) && $config['tree']['use_checkbox'])
                        $contact->$key = implode(',',Tools::getValue($key));  
                    elseif($config['type']=='checkbox')
                    {
                        $values=array();
                        foreach($config['values']['query'] as $value)
                        {
                            if(Tools::getValue($key.'_'.$value['id']))
                            {
                                $values[]=Tools::getValue($key.'_'.$value['id']);
                            }
                        }
                        $contact->$key = implode(',',$values);
                    }
                    elseif($config['type']=='select' && isset($config['multiple'])&& $config['multiple'])
                    {
                        $contact->$key = implode(',',Tools::getValue($key));
                    }                                                 
                    else
                        $contact->$key = trim(Tools::getValue($key));   
                    }
                    $valules = array();
                    foreach($languages as $lang)
                    {
                        if(!Tools::getValue('title_alias_'.$lang['id_lang']) && !Tools::getValue('title_alias_'.$id_lang_default))
                        {
                            $valules[$lang['id_lang']] = trim(Tools::getValue('title_'.$lang['id_lang'])) ? Tools::link_rewrite(trim(Tools::getValue('title_'.$lang['id_lang'])))  : Tools::link_rewrite(trim(Tools::getValue('title_'.$id_lang_default)),true);
                        }
                        else
                            $valules[$lang['id_lang']] = trim(Tools::getValue('title_alias_'.$lang['id_lang'])) ? trim(Tools::getValue('title_alias_'.$lang['id_lang'])) : trim(Tools::getValue('title_alias_'.$id_lang_default));
                        
                    }
                    $contact->title_alias=$valules;
                } 
        } 
        if (!count($errors))
        {          
           if($contact->id && $contact->update())
           {
                if(Tools::isSubmit('submitSaveAndStayContact'))
                    Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&conf=4&editContact=1&id_contact='.(int)$contact->id.'&current_tab='.Tools::getValue('current_tab'));
                else 
                    Tools::redirectAdmin($this->context->link->getAdminLink('AdminContactFormContactForm').'&conf=4');
           }                
           elseif(!$contact->id && $contact->add())
           {
                if(Tools::isSubmit('submitSaveAndStayContact'))
                    Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&conf=3&editContact=1&id_contact='.(int)$contact->id.'&current_tab='.Tools::getValue('current_tab'));
                else 
                    Tools::redirectAdmin($this->context->link->getAdminLink('AdminContactFormContactForm').'&conf=3');
           }
           else
                $errors[] = $this->l('Unknown error happens');
        }
        if($errors)
            return $this->displayError($errors);       
    }
    public function hookDisplayContactForm7($params)
    {
        $id=isset($params['id'])?$params['id']:$params['id_contact'];
        if($id && $this->existContact($id))
        {
            $contact= new Ets_contact_class($id);
            if($contact->active && $contact->id)
            {
                $contact_form = $this->etscf7_contact_form($id);
                return $this->form_html( $contact_form,true );
            }
        }
        return '';
    }
    public function etscf7_contact_form( $id ) {
    	return WPCF7_ContactForm::get_instance( $id );
    }
    public function hookContactForm7LeftBlok()
    {
        $this->context->smarty->assign(
            array(
                'controller'=> Tools::getValue('controller'),
                'link'=> $this->context->link,
                'js_dir_path' => $this->_path.'views/js/',
                'ets_ctf_default_lang'=>Configuration::get('PS_LANG_DEFAULT'),
                'ets_ctf_is_updating' => Tools::getValue('id_contact')?1:0,
                'count_messages' => $this->getCountMessageNoReaed(),
            )
        );
        return $this->display(__FILE__,'block-left.tpl');
    }
    public function hookModuleRoutes($params) {
        $contactAlias =(Configuration::get('ETS_CFT7_CONTACT_ALIAS',$this->context->language->id) ? Configuration::get('ETS_CFT7_CONTACT_ALIAS',$this->context->language->id) : 'contact-form');
        if(!$contactAlias)
            return array();
        $routes = array(
            'etscontactform7contactform' => array(
                'controller' => 'contact',
                'rule' => $contactAlias,
                'keywords' => array(
                ),
                'params' => array(
                    'fc' => 'module',
                    'module' => 'ets_contactform7',
                ),
            ),              
            'etscontactform7contactform_contact' => array(
                'controller' => 'contact',
                'rule' => $contactAlias.'/{id_contact}-{url_alias}'.(Configuration::get('ETS_CTF7_URL_SUBFIX') ?'.html':''),
                'keywords' => array(
                    'id_contact' =>    array('regexp' => '[0-9]+', 'param' => 'id_contact'),
                    'url_alias'       =>   array('regexp' => '[_a-zA-Z0-9-]+','param' => 'url_alias'),
                ),
                'params' => array(
                    'fc' => 'module',
                    'module' => 'ets_contactform7',
                ),
            ),
        );
        return $routes;
    }
    public function hookActionOutputHTMLBefore($params)
    {
        if (isset($params['html']) && $params['html'])
        {
            $params['html'] = $this->doShortcode($params['html']);
        }
    }
    public function hookDisplayHome()
    {
        return $this->getContactFormByHook('home');
    }
    public function hookDisplayNav2(){
        return $this->getContactFormByHook('nav_top');
    }
    public function hookDisplayProductAdditionalInfo()
    {
        return $this->getContactFormByHook('product_info');
    }
    public function hookDisplayFooterProduct()
    {
        return $this->getContactFormByHook('product_footer');
    }
    public function hookDisplayNav(){
        return $this->getContactFormByHook('nav_top');
    }
    public function hookDisplayTop()
    {
        return $this->getContactFormByHook('displayTop');
    }
    public function hookDisplayLeftColumn()
    {
        return $this->getContactFormByHook('left_column');
    }
    public function hookDisplayFooter()
    {
        return $this->getContactFormByHook('footer_page');
    }
    public function hookDisplayRightColumn()
    {
        return $this->getContactFormByHook('right_column');
    }
    public function hookDisplayAfterProductThumbs()
    {
        return $this->getContactFormByHook('product_thumbs');
    }
    public function hookDisplayRightColumnProduct()
    {
        return $this->getContactFormByHook('product_right');
    }
    public function hookDisplayLeftColumnProduct()
    {
        return $this->getContactFormByHook('product_left');
    }
    public function displayShoppingCartFooter(){
        return $this->getContactFormByHook('checkout_page');
    }
    public function hookDisplayCustomerAccountForm()
    {
        return $this->getContactFormByHook('register_page');
    }
    public function hookDisplayCustomerLoginFormAfter()
    {
        return $this->getContactFormByHook('login_page');
    }
    public function getContactFormByHook($hook)
    {
         $contacts= Db::getInstance()->executeS('
            SELECT c.id_contact FROM '._DB_PREFIX_.'ets_ctf_contact c
            INNER JOIN '._DB_PREFIX_.'ets_ctf_contact_shop cs ON (c.id_contact= cs.id_contact)
            LEFT JOIN '._DB_PREFIX_.'ets_ctf_contact_lang cl on (c.id_contact= cl.id_contact AND cl.id_lang="'.(int)$this->context->language->id.'")
            WHERE c.active=1 AND c.hook like "%'.pSQL($hook).'%" AND cs.id_shop="'.(int)$this->context->shop->id.'";
        ');
        if($contacts)
        {
            $form_html ='';
            foreach($contacts as $contact)
            {
                $form_html .= $this->hookDisplayContactForm7($contact);
            }
            return $form_html;
        }
        return '';
    }
    public function doShortcode($str)
    {
        return preg_replace_callback('~\[contact\-form\-7 id="(\d+)"\]~',array($this,'replace'), $str);//[social-locker ]
    }
    public function replaceDefaultContactForm($str)
    {
        return preg_replace('~<section class="contact-form">.*</section>~','abc', $str);
    }
    public function replace ($matches)
    {
        if(is_array($matches) && count($matches)==2)
        {
            $form= $this->hookDisplayContactForm7(array(
                'id' => (int)$matches[1]
            ));
            if($form)
                return $form;
            else
                return $this->display(__FILE__,'no-form-contact.tpl');
        }
    }
    public function setMetas()
    {
        $meta = array();
        if(trim(Tools::getValue('module'))!=$this->name)
            return;
        $id_lang = $this->context->language->id;
        $id_contact=Tools::getValue('id_contact');
        $contact= new Ets_contact_class($id_contact,$id_lang);
        $meta['meta_title'] = $contact->meta_title?$contact->meta_title:$contact->title;
        $meta['meta_description'] = $contact->meta_description;
        $meta['meta_keywords'] = $contact->meta_keyword;
        if (version_compare(_PS_VERSION_, '1.7.0', '>='))
        {
            $body_classes = array(
                'lang-'.$this->context->language->iso_code => true,
                'lang-rtl' => (bool) $this->context->language->is_rtl,
                'country-'.$this->context->country->iso_code => true,                                   
            );
            $page = array(
                'title' => '',
                'canonical' => '',
                'meta' => array(
                    'title' => $meta['meta_title'],
                    'description' => $meta['meta_description'],
                    'keywords' => $meta['meta_keywords'],
                    'robots' => 'index',
                ),
                'page_name' => 'ets_cft_page',
                'body_classes' => $body_classes,
                'admin_notifications' => array(),
            ); 
            $this->context->smarty->assign(array('page' => $page)); 
        }    
        else
        {
            $this->context->smarty->assign($meta);
        }
    }
    public function form_html($contact_form,$displayHook=false) {
        $contact_form->unit_tag = WPCF7_ContactForm::get_unit_tag( $contact_form->id );
        $this->context->smarty->assign(
            array(
                'contact_form'=>$contact_form,
                'link'=> $this->context->link,
                'open_form_by_button' => $contact_form->open_form_by_button && $displayHook,
                'form_elements'=> $contact_form->form_elements(),
                'displayHook'=>$displayHook,
            )
        );
        return $this->display(__FILE__,'contact-form.tpl');
        
	}
    public function etscf7_text_form_tag_handler($tag)
    {
        $validation_error = false;
    	$class = etscf7_form_controls_class( $tag->type, 'wpcf7-text' );
    	if ( in_array( $tag->basetype, array( 'email', 'url', 'tel' ) ) ) {
    		$class .= ' wpcf7-validates-as-' . $tag->basetype;
    	}
    	if ( $validation_error ) {
    		$class .= ' wpcf7-not-valid';
    	}
        $class .=' form-control';
    	$atts = array();
    	$atts['size'] = $tag->get_size_option( '40' );
    	$atts['maxlength'] = $tag->get_maxlength_option();
    	$atts['minlength'] = $tag->get_minlength_option();
    	if ( $atts['maxlength'] && $atts['minlength']
    	&& $atts['maxlength'] < $atts['minlength'] ) {
    		unset( $atts['maxlength'], $atts['minlength'] );
    	}
    	$atts['class'] = $tag->get_class_option( $class );
    	$atts['id'] = $tag->get_id_option();
    	$atts['tabindex'] = $tag->get_option( 'tabindex', 'signed_int', true );
    	$atts['autocomplete'] = $tag->get_option( 'autocomplete',
    		'[-0-9a-zA-Z]+', true );
    	if ( $tag->has_option( 'readonly' ) ) {
    		$atts['readonly'] = 'readonly';
    	}
    	if ( $tag->is_required() ) {
    		$atts['aria-required'] = 'true';
    	}
    	$atts['aria-invalid'] = $validation_error ? 'true' : 'false';
    	$value = (string) reset( $tag->values );
    	if ( $tag->has_option( 'placeholder' ) || $tag->has_option( 'watermark' ) ) {
    		$atts['placeholder'] = $value;
    		$value = '';
    	}
    	$value = $tag->get_default_option( $value );
    	$value = etscf7_get_hangover( $tag->name, $value );
        if($tag->has_option('use_current_url'))
            $value =$this->getFileCacheByUrl();
        if($tag->has_option('read_only'))
            $atts['readonly']='true';
    	$atts['value'] = $value;
    	if ( etscf7_support_html5() ) {
    		$atts['type'] = $tag->basetype;
    	} else {
    		$atts['type'] = 'text';
    	}
    	$atts['name'] = $tag->name;
        $this->context->smarty->assign(
            array(
                'html_class' => ets_sanitize_html_class( $tag->name ),
                'atts'=>$atts,
                'validation_error'=>$validation_error,
            )
        );
        return $this->display(__FILE__,'form_text.tpl');
    }
    public function etscf7_textarea_form_tag_handler($tag)
    {
        $validation_error = false;
    	$class = etscf7_form_controls_class( $tag->type );
    	if ( $validation_error ) {
    		$class .= ' wpcf7-not-valid';
    	}
        $class .=' form-control' .($tag->has_option('rte') && Configuration::get('ETS_CTF7_ENABLE_TMCE') ? ' autoload_rte_ctf7':'');
    	$atts = array();
    	$atts['cols'] = $tag->get_cols_option( '40' );
    	$atts['rows'] = $tag->get_rows_option( '10' );
    	$atts['maxlength'] = $tag->get_maxlength_option();
    	$atts['minlength'] = $tag->get_minlength_option();
    	if ( $atts['maxlength'] && $atts['minlength'] && $atts['maxlength'] < $atts['minlength'] ) {
    		unset( $atts['maxlength'], $atts['minlength'] );
    	}
    	$atts['class'] = $tag->get_class_option( $class );
    	$atts['id'] = $tag->get_id_option();
    	$atts['tabindex'] = $tag->get_option( 'tabindex', 'signed_int', true );
    	$atts['autocomplete'] = $tag->get_option( 'autocomplete',
    		'[-0-9a-zA-Z]+', true );
    	if ( $tag->has_option( 'readonly' ) ) {
    		$atts['readonly'] = 'readonly';
    	}
    	if ( $tag->is_required() ) {
    		$atts['aria-required'] = 'true';
    	}
    	$atts['aria-invalid'] = $validation_error ? 'true' : 'false';
    	$value = empty( $tag->content )
    		? (string) reset( $tag->values )
    		: $tag->content;
    	if ( $tag->has_option( 'placeholder' ) || $tag->has_option( 'watermark' ) ) {
    		$atts['placeholder'] = $value;
    		$value = '';
    	}
    	$value = $tag->get_default_option( $value );
    	$value = etscf7_get_hangover( $tag->name, $value );
    	$atts['name'] = $tag->name;
    	$this->context->smarty->assign(
            array(
                'html_class'=>ets_sanitize_html_class( $tag->name ),
                'atts'=>$atts,
                'value'=>esc_textarea($value),
                'preview' => Tools::getValue('preview') && Configuration::get('ETS_CTF7_ENABLE_TMCE'),
                'validation_error'=>$validation_error,
            )
        );
        return $this->display(__FILE__,'form_textarea.tpl');
    }
    public function etscf7_captcha_form_tag_handler($tag)
    {
        $validation_error = false;
    	$class = etscf7_form_controls_class( $tag->type, 'wpcf7-text' );
    	if ( in_array( $tag->basetype, array( 'email', 'url', 'tel' ) ) ) {
    		$class .= ' wpcf7-validates-as-' . $tag->basetype;
    	}
    	if ( $validation_error ) {
    		$class .= ' wpcf7-not-valid';
    	}
        $class .=' form-control';
    	$atts = array();
    	$atts['size'] = $tag->get_size_option( '40' );
    	$atts['maxlength'] = $tag->get_maxlength_option();
    	$atts['minlength'] = $tag->get_minlength_option();
    	if ( $atts['maxlength'] && $atts['minlength']
    	&& $atts['maxlength'] < $atts['minlength'] ) {
    		unset( $atts['maxlength'], $atts['minlength'] );
    	}
    	$atts['class'] = $tag->get_class_option( $class );
    	$atts['id'] = $tag->get_id_option();
    	$atts['tabindex'] = $tag->get_option( 'tabindex', 'signed_int', true );
    	$atts['autocomplete'] = $tag->get_option( 'autocomplete',
    		'[-0-9a-zA-Z]+', true );
    	if ( $tag->has_option( 'readonly' ) ) {
    		$atts['readonly'] = 'readonly';
    	}
    	if ( $tag->is_required() ) {
    		$atts['aria-required'] = 'true';
    	}
    	$atts['aria-invalid'] = $validation_error ? 'true' : 'false';
//    	$value = (string) reset( $tag->values );
//    	if ( $tag->has_option( 'placeholder' ) || $tag->has_option( 'watermark' ) ) {
//    		$atts['placeholder'] = $value;
//    		$value = '';
//    	}
    	//$atts['value'] = '';
    	//if ( etscf7_support_html5() ) {
//    		$atts['type'] = $tag->basetype;
//    	} else {
//    		$atts['type'] = 'text';
//    	}
        $atts['type'] = 'captcha';
    	$atts['name'] = $tag->name;
    	//$atts = etscf7_format_atts( $atts );
        $rand = md5(rand());
        $theme = $tag->get_option( 'theme', '(basic|complex|colorful)', true );
        $this->context->smarty->assign(
            array(
                'link_captcha_image'=>Context::getContext()->link->getModuleLink('ets_contactform7', 'captcha', array('captcha_name' => $tag->name, 'rand' => $rand,'theme'=>$theme),true),
                'html_class'=> ets_sanitize_html_class( $tag->name ),
                'atts'=>$atts,
                'url_base'=> $this->getBaseLink(),
                'rand'=>$rand,
                'validation_error'=>$validation_error
            )
        );
    	return $this->display(__FILE__,'form_captcha.tpl');
    }
    public function etscf7_quiz_form_tag_handler($tag)
    {
        $validation_error = false;
    	$class = etscf7_form_controls_class( $tag->type );
    	if ( $validation_error ) {
    		$class .= ' wpcf7-not-valid';
    	}
        $class .=' form-control';
    	$atts = array();
    	$atts['size'] = $tag->get_size_option( '40' );
    	$atts['maxlength'] = $tag->get_maxlength_option();
    	$atts['minlength'] = $tag->get_minlength_option();
    	if ( $atts['maxlength'] && $atts['minlength'] && $atts['maxlength'] < $atts['minlength'] ) {
    		unset( $atts['maxlength'], $atts['minlength'] );
    	}
    	$atts['class'] = $tag->get_class_option( $class );
    	$atts['id'] = $tag->get_id_option();
    	$atts['tabindex'] = $tag->get_option( 'tabindex', 'signed_int', true );
    	$atts['autocomplete'] = 'off';
    	$atts['aria-required'] = 'true';
    	$atts['aria-invalid'] = $validation_error ? 'true' : 'false';
    	$pipes = $tag->pipes;
    	if ( $pipes instanceof WPCF7_Pipes && ! $pipes->zero() ) {
    		$pipe = $pipes->random_pipe();
    		$question = $pipe->before;
    		$answer = $pipe->after;
    	} else {
    		// default quiz
    		$question = '1+1=?';
    		$answer = '2';
    	}
    	$answer = etscf7_canonicalize( $answer );
    	$atts['type'] = 'text';
    	$atts['name'] = $tag->name;
    	$this->context->smarty->assign(
            array(
                'html_class' => ets_sanitize_html_class( $tag->name ),
                'question' => $question,
                'atts' =>$atts,
                'tag_name' => $tag->name,
                'answer'=> ets_hash( $answer, 'etscf7_quiz' ),
                'validation_error'=>$validation_error,
            )
        );
        return $this->display(__FILE__,'form_quiz.tpl');
    }
    public function etscf7_number_form_tag_handler($tag)
    {
        $validation_error = false;
    	$class = etscf7_form_controls_class( $tag->type );
    	$class .= ' wpcf7-validates-as-number';
    	if ( $validation_error ) {
    		$class .= ' wpcf7-not-valid';
    	}
        $class .=' form-control';
    	$atts = array();
    	$atts['class'] = $tag->get_class_option( $class );
    	$atts['id'] = $tag->get_id_option();
    	$atts['tabindex'] = $tag->get_option( 'tabindex', 'signed_int', true );
    	$atts['min'] = $tag->get_option( 'min', 'signed_int', true );
    	$atts['max'] = $tag->get_option( 'max', 'signed_int', true );
    	$atts['step'] = $tag->get_option( 'step', 'int', true );
    	if ( $tag->has_option( 'readonly' ) ) {
    		$atts['readonly'] = 'readonly';
    	}
    	if ( $tag->is_required() ) {
    		$atts['aria-required'] = 'true';
    	}
    	$atts['aria-invalid'] = $validation_error ? 'true' : 'false';
    	$value = (string) reset( $tag->values );
    	if ( $tag->has_option( 'placeholder' ) || $tag->has_option( 'watermark' ) ) {
    		$atts['placeholder'] = $value;
    		$value = '';
    	}
    	$value = $tag->get_default_option( $value );
    	$value = etscf7_get_hangover( $tag->name, $value );
    	$atts['value'] = $value;
    	if ( etscf7_support_html5() ) {
    		$atts['type'] = $tag->basetype;
    	} else {
    		$atts['type'] = 'text';
    	}
    	$atts['name'] = $tag->name;
        $this->context->smarty->assign(
            array(
                'html_class' => ets_sanitize_html_class( $tag->name ),
                'atts'=>$atts,
                'validation_error'=>$validation_error,
            )
        );
        return $this->display(__FILE__,'form_number.tpl');
    }
    public function etscf7_hidden_form_tag_handler($tag)
    {
        $atts = array();
    	$class = etscf7_form_controls_class( $tag->type );
    	$atts['class'] = $tag->get_class_option( $class );
    	$atts['id'] = $tag->get_id_option();
    	$value = (string) reset( $tag->values );
    	$value = $tag->get_default_option( $value );
    	$atts['value'] = $value;
    	$atts['type'] = 'hidden';
    	$atts['name'] = $tag->name;
    	$this->context->smarty->assign(
            array(
                'atts'=>$atts,
            )
        );
        return $this->display(__FILE__,'form_hidden.tpl');
    }
    public function etscf7_file_form_tag_handler($tag)
    {
        $validation_error = false;
    	$class = etscf7_form_controls_class( $tag->type );
    	if ( $validation_error ) {
    		$class .= ' wpcf7-not-valid';
    	}
        $class .=' form-control';
    	$atts = array();
    	$atts['size'] = $tag->get_size_option( '40' );
    	$atts['class'] = $tag->get_class_option( $class );
    	$atts['id'] = $tag->get_id_option();
    	$atts['tabindex'] = $tag->get_option( 'tabindex', 'signed_int', true );
    	$atts['accept'] = etscf7_acceptable_filetypes(
    		$tag->get_option( 'filetypes' ), 'attr' );
    
    	if ( $tag->is_required() ) {
    		$atts['aria-required'] = 'true';
    	}
    	$atts['aria-invalid'] = $validation_error ? 'true' : 'false';
    	$atts['type'] = 'file';
    	$atts['name'] = $tag->name;
    	$this->context->smarty->assign(
            array(
                'html_class'=> ets_sanitize_html_class( $tag->name ),
                'atts'=>$atts,
                'validation_error'=>$validation_error,
                'type_file' => $tag->get_option( 'filetypes') ? implode(',',$tag->get_option( 'filetypes')):'',
                'limit_zie' => $tag->get_option('limit') ? implode(',',$tag->get_option('limit')):'',
            )
        );
    	return $this->display(__FILE__,'form_file.tpl');
    }
    public function etscf7_select_form_tag_handler($tag)
    {
        $validation_error = false;
    	$class = etscf7_form_controls_class( $tag->type );
    
    	if ( $validation_error ) {
    		$class .= ' wpcf7-not-valid';
    	}
        $class .=' form-control';
    	$atts = array();
    	$atts['class'] = $tag->get_class_option( $class );
    	$atts['id'] = $tag->get_id_option();
    	$atts['tabindex'] = $tag->get_option( 'tabindex', 'signed_int', true );
    	if ( $tag->is_required() ) {
    		$atts['aria-required'] = 'true';
    	}
    	$atts['aria-invalid'] = $validation_error ? 'true' : 'false';
    	$multiple = $tag->has_option( 'multiple' );
    	$include_blank = $tag->has_option( 'include_blank' );
    	$first_as_label = $tag->has_option( 'first_as_label' );
    	if ( $tag->has_option( 'size' ) ) {
    		$size = $tag->get_option( 'size', 'int', true );
    
    		if ( $size ) {
    			$atts['size'] = $size;
    		} elseif ( $multiple ) {
    			$atts['size'] = 4;
    		} else {
    			$atts['size'] = 1;
    		}
    	}
    	$values = $tag->values;
    	$labels = $tag->labels;
    	if ( $data = (array) $tag->get_data_option() ) {
    		$values = array_merge( $values, array_values( $data ) );
    		$labels = array_merge( $labels, array_values( $data ) );
    	}
    	$defaults = array();
    	$default_choice = $tag->get_default_option( null, 'multiple=1' );
    	foreach ( $default_choice as $value ) {
    		$key = array_search( $value, $values, true );
    
    		if ( false !== $key ) {
    			$defaults[] = (int) $key + 1;
    		}
    	}
    	if ( $matches = $tag->get_first_match_option( '/^default:([0-9_]+)$/' ) ) {
    		$defaults = array_merge( $defaults, explode( '_', $matches[1] ) );
    	}
    	$defaults = array_unique( $defaults );
    	$shifted = false;
        if(!$multiple)
        {
            if ( $include_blank || empty( $values ) ) {
        		array_unshift( $labels, '---' );
        		array_unshift( $values, '' );
        		$shifted = true;
        	} elseif ( $first_as_label ) {
        		$values[0] = '';
        	}
        }
    	$html = '';
    	$hangover = etscf7_get_hangover( $tag->name );
    	foreach ( $values as $key => $value ) {
    		$selected = false;
    		if ( $hangover ) {
    			if ( $multiple ) {
    				$selected = in_array( $value, (array) $hangover, true );
    			} else {
    				$selected = ( $hangover === $value );
    			}
    		} else {
    			if ( ! $shifted && in_array( (int) $key + 1, (array) $defaults ) ) {
    				$selected = true;
    			} elseif ( $shifted && in_array( (int) $key, (array) $defaults ) ) {
    				$selected = true;
    			}
    		}
    		$item_atts = array(
    			'value' => $value,
    			'selected' => $selected ? 'selected' : '',
    		);
    		$label = isset( $labels[$key] ) ? $labels[$key] : $value;
            $this->context->smarty->assign(
                array(
                    'item_atts'=>$item_atts,
                    'label'=>$label,
                )
            );
    		$html .= $this->display(__FILE__,'option.tpl');
    	}
    	if ( $multiple ) {
    		$atts['multiple'] = 'multiple';
    	}
    	$atts['name'] = $tag->name . ( $multiple ? '[]' : '' );
        $this->context->smarty->assign(
            array(
                'html_class'=>ets_sanitize_html_class($tag->name),
                'atts'=>$atts,
                'html'=>$html,
                'validation_error'=>$validation_error,
            )
        );
        return $this->display(__FILE__,'form_select.tpl');
    }
    public function etscf7_submit_form_tag_handler($tag)
    {
        $class = etscf7_form_controls_class( $tag->type );
        
        $atts = array();
    	$atts['class'] = $tag->get_class_option( $class );
    	$atts['id'] = $tag->get_id_option();
    	$atts['tabindex'] = $tag->get_option( 'tabindex', 'signed_int', true );
    	$value = isset( $tag->values[0] ) ? $tag->values[0] : '';
    	if ( empty( $value ) ) {
    		$value ='Send';
    	}
    	$atts['type'] = 'submit';
    	$atts['value'] = $value;
    	$this->context->smarty->assign(
            array(
                'atts'=>$atts
            )
        );
        return $this->display(__FILE__,'form_submit.tpl');
    }
    public function etscf7_recaptcha_form_tag_handler($tag)
    {
        $atts = array();
    	$recaptcha = WPCF7_RECAPTCHA::get_instance();
    	$atts['data-sitekey'] = $recaptcha->get_sitekey();
    	$atts['data-type'] = $tag->get_option( 'type', '(audio|image)', true );
    	$atts['data-size'] = $tag->get_option(
    		'size', '(compact|normal|invisible)', true );
    	$atts['data-theme'] = $tag->get_option( 'theme', '(dark|light)', true );
    	$atts['data-badge'] = $tag->get_option(
    		'badge', '(bottomright|bottomleft|inline)', true );
    	$atts['data-tabindex'] = $tag->get_option( 'tabindex', 'signed_int', true );
    	$atts['data-callback'] = $tag->get_option( 'callback', '', true );
    	$atts['data-expired-callback'] =
    		$tag->get_option( 'expired_callback', '', true );
    	$atts['class'] = $tag->get_class_option(
    		etscf7_form_controls_class( $tag->type, 'g-recaptcha' ) );
    	$atts['id'] = $tag->get_id_option();
        $this->context->smarty->assign(
            array(
                'atts'=>$atts,
                'preview' => Tools::getValue('preview') || Tools::getValue('getFormElementAjax'),
                'html'=>etscf7_recaptcha_noscript(array( 'sitekey' => $atts['data-sitekey'])),
            )
        );
        return $this->display(__FILE__,'form_recaptcha.tpl');
    }
    public function etscf7_date_form_tag_handler($tag)
    {
        $validation_error = false;
    	$class = etscf7_form_controls_class( $tag->type );
    	$class .= ' wpcf7-validates-as-date';
    	if ( $validation_error ) {
    		$class .= ' wpcf7-not-valid';
    	}
        $class .=' form-control datepicker';
    	$atts = array();
    	$atts['class'] = $tag->get_class_option( $class );
    	$atts['id'] = $tag->get_id_option();
    	$atts['tabindex'] = $tag->get_option( 'tabindex', 'signed_int', true );
    	$atts['min'] = $tag->get_date_option( 'min' );
    	$atts['max'] = $tag->get_date_option( 'max' );
    	$atts['step'] = $tag->get_option( 'step', 'int', true );
    	if ( $tag->has_option( 'readonly' ) ) {
    		$atts['readonly'] = 'readonly';
    	}
    	if ( $tag->is_required() ) {
    		$atts['aria-required'] = 'true';
    	}
    	$atts['aria-invalid'] = $validation_error ? 'true' : 'false';
    	$value = (string) reset( $tag->values );
    	if ( $tag->has_option( 'placeholder' ) || $tag->has_option( 'watermark' ) ) {
    		$atts['placeholder'] = $value;
    		$value = '';
    	}
    	$value = $tag->get_default_option( $value );
    	$value = etscf7_get_hangover( $tag->name, $value );
    	$atts['value'] = $value;
    	if ( etscf7_support_html5() ) {
    		$atts['type'] = 'text';
    	} else {
    		$atts['type'] = 'text';
    	}
    	$atts['name'] = $tag->name;
    	$this->context->smarty->assign(
            array(
                'html_class' => ets_sanitize_html_class( $tag->name ),
                'atts'=>$atts,
                'validation_error'=>$validation_error,
            )
        );
    	return $this->display(__FILE__,'form_date.tpl');
    }
    public function etscf7_count_form_tag_handler($tag)
    {
        $targets = etscf7_scan_form_tags( array( 'name' => $tag->name ) );
    	$maxlength = $minlength = null;
    	while ( $targets ) {
    		$target = array_shift( $targets );
    
    		if ( 'count' != $target->type ) {
    			$maxlength = $target->get_maxlength_option();
    			$minlength = $target->get_minlength_option();
    			break;
    		}
    	}
    	if ( $maxlength && $minlength && $maxlength < $minlength ) {
    		$maxlength = $minlength = null;
    	}
    	if ( $tag->has_option( 'down' ) ) {
    		$value = (int) $maxlength;
    		$class = 'wpcf7-character-count down';
    	} else {
    		$value = '0';
    		$class = 'wpcf7-character-count up';
    	}
    	$atts = array();
    	$atts['id'] = $tag->get_id_option();
    	$atts['class'] = $tag->get_class_option( $class );
    	$atts['data-target-name'] = $tag->name;
    	$atts['data-starting-value'] = $value;
    	$atts['data-current-value'] = $value;
    	$atts['data-maximum-value'] = $maxlength;
    	$atts['data-minimum-value'] = $minlength;
    	$this->context->smarty->assign(
            array(
                'atts'=>$atts,
                'value'=>$value,
            )
        );
        return $this->display(__FILE__,'form_count.tpl');
    }
    public function etscf7_checkbox_form_tag_handler($tag)
    {
        $validation_error = false;
    	$class = etscf7_form_controls_class( $tag->type );
    	if ( $validation_error ) {
    		$class .= ' wpcf7-not-valid';
    	}
    	$label_first = $tag->has_option( 'label_first' );
    	$use_label_element = $tag->has_option( 'use_label_element' );
    	$exclusive = $tag->has_option( 'exclusive' );
    	//$free_text = $tag->has_option( 'free_text' );
    	$multiple = false;
    	if ( 'checkbox' == $tag->basetype ) {
    		$multiple = ! $exclusive;
    	} else { // radio
    		$exclusive = false;
    	}
    	if ( $exclusive ) {
    		$class .= ' wpcf7-exclusive-checkbox';
    	}
    	$atts = array();
    	$atts['class'] = $tag->get_class_option( $class );
    	$atts['id'] = $tag->get_id_option();
    	$tabindex = $tag->get_option( 'tabindex', 'signed_int', true );
    	if ( false !== $tabindex ) {
    		$tabindex = (int) $tabindex;
    	}
    	$html = '';
    	$count = 0;
    	$values = (array) $tag->values;
    	$labels = (array) $tag->labels;
    	//if ( $data = (array) $tag->get_data_option() ) {
//    		if ( $free_text ) {
//    			$values = array_merge(
//    				array_slice( $values, 0, -1 ),
//    				array_values( $data ),
//    				array_slice( $values, -1 ) );
//    			$labels = array_merge(
//    				array_slice( $labels, 0, -1 ),
//    				array_values( $data ),
//    				array_slice( $labels, -1 ) );
//    		} else {
//    			$values = array_merge( $values, array_values( $data ) );
//    			$labels = array_merge( $labels, array_values( $data ) );
//    		}
//            
//    	}
    	$defaults = array();
    	$default_choice = $tag->get_default_option( null, 'multiple=1' );
    	foreach ( $default_choice as $value ) {
    		$key = array_search( $value, $values, true );
    
    		if ( false !== $key ) {
    			$defaults[] = (int) $key + 1;
    		}
    	}
    	if ( $matches = $tag->get_first_match_option( '/^default:([0-9_]+)$/' ) ) {
    		$defaults = array_merge( $defaults, explode( '_', $matches[1] ) );
    	}
    	$defaults = array_unique( $defaults );
    	$hangover = etscf7_get_hangover( $tag->name, $multiple ? array() : '' );
    	foreach ( $values as $key => $value ) {
    		$class = 'wpcf7-list-item';
    		$checked = false;
    
    		if ( $hangover ) {
    			if ( $multiple ) {
    				$checked = in_array( $value, (array) $hangover, true );
    			} else {
    				$checked = ( $hangover === $value );
    			}
    		} else {
    			$checked = in_array( $key + 1, (array) $defaults );
    		}
    
    		if ( isset( $labels[$key] ) ) {
    			$label = $labels[$key];
    		} else {
    			$label = $value;
    		}
    		$item_atts = array(
    			'type' => $tag->basetype,
    			'name' => $tag->name . ( $multiple ? '[]' : '' ),
    			'value' => $value,
    			'checked' => $checked ? 'checked' : '',
    			'tabindex' => false !== $tabindex ? $tabindex : '',
                'id'=> $tag->name.'_'.$value,
    		);
    		if ( false !== $tabindex && 0 < $tabindex ) {
    			$tabindex += 1;
    		}
    		$count += 1;
    		if ( 1 == $count ) {
    			$class .= ' first';
    		}
    		//if ( count( $values ) == $count ) { // last round
//    			$class .= ' last';
//    			if ( $free_text ) {
//    				$free_text_name = sprintf(
//    					'_etscf7_%1$s_free_text_%2$s', $tag->basetype, $tag->name );
//    				$free_text_atts = array(
//    					'name' => $free_text_name,
//    					'class' => 'wpcf7-free-text',
//    					'tabindex' => false !== $tabindex ? $tabindex : '',
//    				);
//    				if ( etscf7_is_posted() && Tools::isSubmit($free_text_name) ) {
//    					$free_text_atts['value'] = ets_unslash(
//    						Tools::getValue($free_text_name) );
//    				}
//    				$class .= ' has-free-text';
//    			}
//    		}
            $this->context->smarty->assign(
                array(
                    'class'=>$class,
                    'label'=>$label,
                    'label_first'=>$label_first,
                    'label_for'=> $tag->name.'_'.$value,
                    'use_label_element'=>$use_label_element,
                    'item_atts'=>$item_atts,
                    'values'=>$values,
                    'count'=>$count,
                    //'free_text_atts'=> isset($free_text_atts) ? $free_text_atts:'',
                )
            );
    		$html .= $this->display(__FILE__,'item_checkbox.tpl');
    	}
        $this->context->smarty->assign(
            array(
                'html_class'=> ets_sanitize_html_class($tag->name),
                'atts'=>$atts,  
                'html'=>$html,
                'validation_error'=>$validation_error,
            )
        );
        return $this->display(__FILE__,'form_checkbox.tpl');
    }
    public function etscf7_acceptance_form_tag_handler($tag)
    {
        $validation_error = false;
    	$class = etscf7_form_controls_class( $tag->type );
    	if ( $validation_error ) {
    		$class .= ' wpcf7-not-valid';
    	}
    	if ( $tag->has_option( 'invert' ) ) {
    		$class .= ' invert';
    	}
    	if ( $tag->has_option( 'optional' ) ) {
    		$class .= ' optional';
    	}
    	$atts = array(
    		'class' => trim( $class ),
    	);
    	$item_atts = array();
    	$item_atts['type'] = 'checkbox';
    	$item_atts['name'] = $tag->name;
    	$item_atts['value'] = '1';
    	$item_atts['tabindex'] = $tag->get_option( 'tabindex', 'signed_int', true );
    	$item_atts['aria-invalid'] = $validation_error ? 'true' : 'false';
    	if ( $tag->has_option( 'default:on' ) ) {
    		$item_atts['checked'] = 'checked';
    	}
    	$item_atts['class'] = $tag->get_class_option();
    	$item_atts['id'] = $tag->get_id_option();
    	$content = empty( $tag->content )
    		? (string) reset( $tag->values )
    		: $tag->content;
    	$content = trim( $content );
    	$this->context->smarty->assign(
            array(
                'html_class'=>ets_sanitize_html_class( $tag->name ),
                'atts'=>$atts,
                'item_atts' =>$item_atts,
                'content'=>$content,
                'validation_error'=>$validation_error,
            )
        );
        return $this->display(__FILE__,'form_acceptance.tpl');
    }
    public function replace_all_form_tags($form) {
		$manager = WPCF7_FormTagsManager::get_instance();
        $manager->set_instance();    
		if ( etscf7_autop_or_not() ) {
			$form = $manager->normalize( $form );
			$form = etscf7_autop( $form );
		}
		$form = $manager->replace_all( $form );
		$this->scanned_form_tags = $manager->get_scanned_tags();
		return $form;
	}
    static public function getEmailToString($string)
    {
        $pattern = '/[a-z0-9_\-\+\.]+@[a-z0-9\-]+\.([a-z]{2,4})(?:\.[a-z]{2})?/i';
        preg_match_all($pattern, $string, $matches);
        return isset($matches[0][0])?$matches[0][0]:'';
    }
    public function getContacts($active=false,$filters='',$start=0,$limit=0,$count=false,$order_by='position',$order_way='asc')
    {
        $contacts= Db::getInstance()->executeS('
        SELECT c.*,cl.*,cs.*,e.firstname,e.lastname FROM '._DB_PREFIX_.'ets_ctf_contact c
        INNER JOIN '._DB_PREFIX_.'ets_ctf_contact_shop cs ON (c.id_contact =cs.id_contact)
        LEFT JOIN '._DB_PREFIX_.'ets_ctf_contact_lang cl on (c.id_contact=cl.id_contact AND cl.id_lang="'.(int)$this->context->language->id.'")
        LEFT JOIN '._DB_PREFIX_.'employee e on(c.id_employee= e.id_employee)
        WHERE cs.id_shop ="'.(int)Context::getContext()->shop->id.'"'.$filters.($active? ' AND c.active=1':'').' GROUP BY c.id_contact ORDER BY '.pSQL($order_by).' '.pSQL($order_way).' '.($limit? 'LIMIT '.(int)$start.','.(int)$limit:''));
        if($count)
            return Count($contacts);
        else
            return $contacts;
    }
    public function getBaseLink()
    {
        return (Configuration::get('PS_SSL_ENABLED_EVERYWHERE')?'https://':'http://').$this->context->shop->domain.$this->context->shop->getBaseURI();
    }
    public function getMessages($filters='',$start=0,$limit=0,$count=false,$orderby='')
    {
        $messages= Db::getInstance()->executeS('
            SELECT m.*,cl.title,IF(r.id_ets_ctf_message_reply IS NULL,0,1) AS replied FROM '._DB_PREFIX_.'ets_ctf_contact_message m
            INNER JOIN '._DB_PREFIX_.'ets_ctf_contact_message_shop ms ON (m.id_contact_message=ms.id_contact_message)
            lEFT JOIN '._DB_PREFIX_.'ets_ctf_contact_lang cl on (m.id_contact=cl.id_contact AND cl.id_lang="'.(int)$this->context->language->id.'")
            LEFT JOIN '._DB_PREFIX_.'ets_ctf_message_reply r ON (r.id_contact_message=m.id_contact_message)
            WHERE ms.id_shop="'.(int)Context::getContext()->shop->id.'"'.$filters.' GROUP BY m.id_contact_message '.($orderby ? 'ORDER BY '.$orderby:'').',replied'.($limit? ' LIMIT '.(int)$start.','.(int)$limit:'').'');
        if($count)
            return count($messages);
        if($messages)
        {
            foreach($messages as &$message)
            {
                $message['attachments'] =$message['attachments']? explode(',',$message['attachments']):array();
            }
        }
        return $messages;
    }
    static public function getLinkContactForm($id_contact_form,$id_lang=0)
    {
        $context = Context::getContext();
        $id_lang = $id_lang ? $id_lang : $context->language->id;
        $contact_form= new Ets_contact_class($id_contact_form,$id_lang);
        $blogLink = new Ets_ctf_link_class();     
        if(Configuration::get('PS_REWRITING_SETTINGS') && $contact_form->id && $contact_form->title_alias)
        {            
            $url = $blogLink->getBaseLinkFriendly(null, null).$blogLink->getLangLinkFriendly($id_lang, null, null);
            $url .= (($subAlias = Configuration::get('ETS_CFT7_CONTACT_ALIAS',Context::getContext()->language->id)) ? $subAlias : 'contact-form').'/'.(int)$contact_form->id.'-'. $contact_form->title_alias.(Configuration::get('ETS_CTF7_URL_SUBFIX') ? '.html' : '');
            return $url;                       
        }
        return $context->link->getModuleLink('ets_contactform7','contact',array('id_contact'=>$id_contact_form));
    }
    public function getCountMessageNoReaed()
    {
        $messages= Db::getInstance()->executeS('
            SELECT m.* FROM '._DB_PREFIX_.'ets_ctf_contact_message m
            INNER JOIN '._DB_PREFIX_.'ets_ctf_contact_message_shop ms ON (m.id_contact_message=ms.id_contact_message)
            lEFT JOIN '._DB_PREFIX_.'ets_ctf_contact c on (m.id_contact=c.id_contact)
            WHERE ms.id_shop="'.(int)Context::getContext()->shop->id.'" AND m.readed=0 GROUP BY m.id_contact_message');
        return count($messages);
    }
    public function _installDbConfig()
    {
        $fields_config=self::$_config_fields;
        $inputs = $fields_config['form']['input'];
        $languages = Language::getLanguages(false);
        if($inputs)
        {
            foreach($inputs as $input)
            {
                if(isset($input['default']))
                {
                    $key=$input['name'];
                    if(isset($input['lang']) && $input['lang'])
                    {
                        $vals = array();
                        foreach($languages as $language)
                        {
                            $vals[$language['id_lang']]= $input['default'];
                        }
                        Configuration::updateValue($key,$vals,true);
                    }
                    else
                    {
                        Configuration::updateValue($key,$input['default']);
                    }
                }
            }
        }
        $fields_config=self::$_email_fields;
        $inputs = $fields_config['form']['input'];
        $languages = Language::getLanguages(false);
        if($inputs)
        {
            foreach($inputs as $input)
            {
                if(isset($input['default']))
                {
                    $key=$input['name'];
                    if(isset($input['lang']) && $input['lang'])
                    {
                        $vals = array();
                        foreach($languages as $language)
                        {
                            $vals[$language['id_lang']]= $input['default'];
                        }
                        Configuration::updateValue($key,$vals,true);
                    }
                    else
                    {
                        Configuration::updateValue($key,$input['default']);
                    }
                }
            }
        }
        return true;
    }
    public function _unInstallDbConfig()
    {
        $fields_config=self::$_config_fields;
        $inputs = $fields_config['form']['input'];
        if($inputs)
        {
            foreach($inputs as $input)
            {
                $key=$input['name'];
                Configuration::deleteByName($key);
            }
        }
        $fields_config=self::$_email_fields;
        $inputs = $fields_config['form']['input'];
        if($inputs)
        {
            foreach($inputs as $input)
            {
                $key=$input['name'];
                Configuration::deleteByName($key);
            }
        }
        foreach (glob(dirname(__file__) . '/views/img/etscf7_upload/*.*') as $filename) {
            if($filename!=dirname(__file__) . '/views/img/etscf7_upload/index.php')
                @unlink($filename);
        }
        return true;
    }
    public function displayReplyMessage($reply)
    {
        $this->context->smarty->assign(
            array(
                'reply'=>$reply,
                'countReply' => (int)Db::getInstance()->getValue('SELECT COUNT(*) FROM '._DB_PREFIX_.'ets_ctf_message_reply WHERE id_contact_message="'.(int)$reply->id_contact_message.'"')
            )
        );
        return $this->display(__FILE__,'reply.tpl');
    }
    private function generateArchive()
    {
        $zip = new ZipArchive();
        $cacheDir = dirname(__FILE__).'/cache/';
        $zip_file_name = 'contactform7_'.date('dmYHis').'.zip';
        if ($zip->open($cacheDir.$zip_file_name, ZipArchive::OVERWRITE | ZipArchive::CREATE) === true) {
            if (!$zip->addFromString('Data-Info.xml', $this->renderDataInfo())) {
                $this->_errors[] = $this->l('Cannot create Contact-Info.xml');
            }
            if (!$zip->addFromString('Contact-Info.xml', $this->renderContactFormData())) {
                $this->_errors[] = $this->l('Cannot create Contact-Info.xml');
            }
            $zip->close();
            if (!is_file($cacheDir.$zip_file_name)) {
                $this->_errors[] = $this->l(sprintf('Could not create %1s', $cacheDir.$zip_file_name));
            }
            if (!$this->_errors) {
                if (ob_get_length() > 0) {
                    ob_end_clean();
                }
                ob_start();
                header('Pragma: public');
                header('Expires: 0');
                header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                header('Cache-Control: public');
                header('Content-Description: File Transfer');
                header('Content-type: application/octet-stream');
                header('Content-Disposition: attachment; filename="'.$zip_file_name.'"');
                header('Content-Transfer-Encoding: binary');
                ob_end_flush();
                readfile($cacheDir.$zip_file_name);
                @unlink($cacheDir.$zip_file_name);
                exit;
            }
        }
        {
            echo $this->l('An error occurred during the archive generation');
            die;
        }
    }
    private function renderDataInfo()
    {
        $xml_output = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml_output .= '<entity_profile>'."\n";
        $xml_output .='<version>'.$this->version.'</version>';
        $xml_output .= '</entity_profile>'."\n";
		return $xml_output;
    }
    private function renderContactFormData()
    {
        $xml_output = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml_output .= '<entity_profile>'."\n";
        $contacts = Db::getInstance()->executeS('SELECT c.* FROM '._DB_PREFIX_.'ets_ctf_contact c, '._DB_PREFIX_.'ets_ctf_contact_shop cs WHERE c.id_contact=cs.id_contact AND cs.id_shop="'.(int)$this->context->shop->id.'"');
        if($contacts)
        {
            foreach($contacts as $contact)
            {
                $xml_output .='<contactfrom id="'.(int)$contact['id_contact'].'">';
                    foreach($contact as $key=>$value)
                    {
                        if($key!='id_contact')
                        {
                            $xml_output.='<'.$key.'><![CDATA['.$value.']]></'.$key.'>'."\n";  
                        }
                    }
                $contactLanguages= Db::getInstance()->executeS('SELECT cl.*,l.iso_code FROM '._DB_PREFIX_.'ets_ctf_contact_lang cl,'._DB_PREFIX_.'lang l WHERE cl.id_lang=l.id_lang AND cl.id_contact='.(int)$contact['id_contact']);
                if($contactLanguages)
                {
                    foreach($contactLanguages as $datalanguage)
                    {
                        $xml_output .= '<datalanguage iso_code="'.$datalanguage['iso_code'].'"'.($datalanguage['id_lang']==Configuration::get('PS_LANG_DEFAULT') ? ' default="1"':'').' >'."\n";
                        foreach($datalanguage as $key=>$value)
                            if($key!='id_contact' && $key!='id_lang'&& $key!='iso_code')
                                $xml_output.='<'.$key.'><![CDATA['.$value.']]></'.$key.'>'."\n";   
                        $xml_output .='</datalanguage>'."\n";
                    }
                }
                $xml_output .='</contactfrom>';
            }
        }
        $xml_output .= '</entity_profile>'."\n";
		return $xml_output;
    }
    public function processImport($zipfile = false)
    {
        if(!$zipfile)
        {
            $savePath = dirname(__FILE__).'/cache/';
            if(@file_exists($savePath.'contactform.data.zip'))
                @unlink($savePath.'contactform.data.zip');
            $uploader = new Uploader('contactformdata');
            $uploader->setCheckFileSize(false);
            $uploader->setAcceptTypes(array('zip'));        
            $uploader->setSavePath($savePath);
            $file = $uploader->process('contactform.data.zip'); 
            if ($file[0]['error'] === 0) {
                if (!Tools::ZipTest($savePath.'contactform.data.zip')) 
                    $this->_errors[] = $this->l('Zip file seems to be broken');
            } else {
                $this->_errors[] = $file[0]['error'];
            }
            $extractUrl = $savePath.'contactform.data.zip';
        }
        else      
            $extractUrl = $zipfile;
        if(!@file_exists($extractUrl))
            $this->_errors[] = $this->l('Zip file doesn\'t exist'); 
        if(!$this->_errors)
        {
            $zip = new ZipArchive();
            if($zip->open($extractUrl) === true)
            {
                if ($zip->locateName('Contact-Info.xml') === false)
                {
                    $this->_errors[] = $this->l('Import file is invalid');
                    if($extractUrl)
                       @unlink(dirname(__FILE__).'/cache/contactform.data.zip');
                }
                $zip->close();
            }
            else
                $this->_errors[] = $this->l('Cannot open zip file. It might be broken or damaged');
        }
        if(!$this->_errors)
        {            
            if(!Tools::ZipExtract($extractUrl, dirname(__FILE__).'/views/'))
                $this->_errors[] = $this->l('Cannot extract zip data');
            if(!@file_exists(dirname(__FILE__).'/views/Contact-Info.xml'))
                $this->_errors[] = $this->l('Import file is invalid');            
        }      
        if(!$this->_errors)
        {       
            
            if(@file_exists(dirname(__FILE__).'/views/Contact-Info.xml'))
            {
                $this->importXmlTbl(@simplexml_load_file(dirname(__FILE__).'/views/Contact-Info.xml'));
                @unlink(dirname(__FILE__).'/views/Contact-Info.xml');
                @unlink(dirname(__FILE__).'/views/Data-Info.xml');
            } 
            if($extractUrl)
            {
                @unlink(dirname(__FILE__).'/cache/contactform.data.zip'); 
            }               
        }
        if(!$this->_errors)
        {
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminContactFormContactForm').'&okimport=1');
        }
                  
    }
    public function importXmlTbl($xml)
    {
        $languages = Language::getLanguages(false);
        if($xml && isset($xml->contactfrom))
        {
            if(Tools::getValue('importdeletebefore'))
            {
                Db::getInstance()->execute("DELETE FROM "._DB_PREFIX_."ets_ctf_contact WHERE id_contact IN (SELECT id_contact FROM "._DB_PREFIX_."ets_ctf_contact_shop WHERE id_shop=".(int)$this->context->shop->id.")");
                Db::getInstance()->execute("DELETE FROM "._DB_PREFIX_."ets_ctf_contact_lang WHERE id_contact IN (SELECT id_contact FROM "._DB_PREFIX_."ets_ctf_contact_shop WHERE id_shop=".(int)$this->context->shop->id.")");
                Db::getInstance()->execute('DELETE FROM '._DB_PREFIX_.'ets_ctf_contact_shop WHERE id_shop="'.(int)$this->context->shop->id.'"');
            }
            foreach($xml->contactfrom as $dataContact)
            {
                $id_contact = (int)$dataContact['id'];
                if(Tools::getValue('importoverride') && $this->existContact($id_contact))
                    $contact = new Ets_contact_class($id_contact);
                else
                {
                    $contact= new Ets_contact_class();
                    $contact->position = Db::getInstance()->getValue('SELECT COUNT(*) FROM '._DB_PREFIX_.'ets_ctf_contact_shop where id_shop='.(int)$this->context->shop->id);
                }
                $configs = $this->contact_fields['form']['input'];
                if($configs)
                {
                    foreach($configs as $config)
                    {
                        $key=$config['name'];
                        if(!isset($config['lang']) || !$config['lang'] && $key!='postion')
                            $contact->$key = $dataContact->$key;
                        if($key=='id_employee')
                            $contact->id_employee = (int)$this->context->employee->id;
                    }
                }
                if(isset($dataContact->datalanguage) && $dataContact->datalanguage)
                {
                    $language_xml_default=null;
                    foreach($dataContact->datalanguage as $language_xml)
                    {
                        if(isset($language_xml['default']) && (int)$language_xml['default'])
                        {
                            $language_xml_default=$language_xml;
                            break;
                        }
                    }
                    $list_language_xml=array();
                    foreach($dataContact->datalanguage as $language_xml)
                    {
                        $iso_code = (string)$language_xml['iso_code'];
                        $id_lang = Language::getIdByIso($iso_code);
                        $list_language_xml[]=$id_lang;
                        if($id_lang)
                        {
                            foreach($configs as $config)
                            {
                                $key= $config['name'];
                                if(isset($config['lang']) && $config['lang'])
                                {
                                    $temp = $contact->$key;
                                    $temp[$id_lang] = (string)$language_xml->$key;
                                    if(!$temp[$id_lang])
                                    {
                                        if(isset($language_xml_default) && $language_xml_default && isset($language_xml_default->$key)&& $language_xml_default->$key)
                                        {
                                            $temp[$id_lang]=(string)$language_xml_default->$key;
                                        }
                                    }  
                                    $contact->$key =$temp;
                                }
                            }
                        }
                    }
                    foreach($languages as $language)
                    {
                        if(!in_array($language['id_lang'],$list_language_xml))
                        {
                            foreach($configs as $config)
                            {
                                $key= $config['name'];
                                if(isset($config['lang']) && $config['lang'])
                                {
                                    $temp = $contact->$key;
                                    if(isset($language_xml_default) && $language_xml_default && isset($language_xml_default->$key) && $language_xml_default->$key)
                                    {
                                        $temp[$language['id_lang']]=$language_xml_default->$key;
                                    }  
                                    $contact->$key =$temp;
                                }
                            }
                        }
                    }
                }
                $contact->save();
            }
        }
    }
    public function existContact($id_contact)
    {
        return Db::getInstance()->executeS('SELECT * FROM '._DB_PREFIX_.'ets_ctf_contact c, '._DB_PREFIX_.'ets_ctf_contact_shop cs WHERE c.id_contact="'.(int)$id_contact.'" AND c.id_contact=cs.id_contact AND cs.id_shop="'.(int)$this->context->shop->id.'"');
    }
    public function getFileCacheByUrl()
    {
        $url = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
        if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) {
            $url ='https://'.$url;
        }
        else
            $url ='http://'.$url;
        if (strpos($url, '#') !== FALSE) {
            $url = Tools::substr($url, 0, strpos($url, '#'));
        }
        return $url;
    }
    public function hookDisplayBackOfficeFooter()
    {
        if(version_compare(_PS_VERSION_, '1.6', '<'))
            return '';
        $this->context->smarty->assign(
            array(
                'link_ajax' => $this->context->link->getAdminLink('AdminModules', true).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name,
            )
        );
        return $this->display(__FILE__,'admin_footer.tpl');
    }
    public function getDevice()
    {
      return ($userAgent = new Ctf_browser())? $userAgent->getBrowser().' '.$userAgent->getVersion().' '.$userAgent->getPlatform() : $this->l('Unknown');
    }
}    