<?php

class NrtInstagram extends Module
{

    public function __construct()
    {
        $this->name = 'nrtinstagram';
        $this->version = '1.0';
		$this->author = 'AxonVIP';
        parent::__construct();
        $this->displayName = $this->l('Instagram');
        $this->description = $this->l('Display Instagram pics from an account');
        $this->controllers = array('default');
        $this->bootstrap = 1;
    }

    public function install()
    {
        return parent::install() &&
        Configuration::updateValue('NRT_INSTAGRAM_USER_ID', '5719498506') &&
        Configuration::updateValue('NRT_INSTAGRAM_ACCESS_TOKEN', '5719498506.e4e7665.99a9771f2fff4ee1aa948eac6c0619ac') &&
        Configuration::updateValue('NRT_INSTAGRAM_NBR_IMAGE', 8) &&
        Configuration::updateValue('NRT_INSTAGRAM_IMAGE_FORMAT', 'standard_resolution') &&
        $this->registerHook('instagram') &&
        $this->registerHook('displayHome') &&
        $this->addTab();
    }

	public function uninstall()
	{
		Configuration::deleteByName('NRT_INSTAGRAM_USER_ID');
		Configuration::deleteByName('NRT_INSTAGRAM_ACCESS_TOKEN');
		Configuration::deleteByName('NRT_INSTAGRAM_NBR_IMAGE');
	 	Configuration::deleteByName('NRT_INSTAGRAM_IMAGE_FORMAT');
		return parent::uninstall() && $this->_deleteTab();
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
        $tab->class_name = "AdminNrtInstagram";
        $tab->name = array();
        foreach (Language::getLanguages() as $lang) {
            $tab->name[$lang['id_lang']] = "Manage Instagram";
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
        $id_tab = Tab::getIdFromClassName('AdminNrtInstagram');
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

    public function getContent()
    {
        return $this->_postProcess() . $this->_getForm();
    }

    private function _postProcess()
    {
        if (Tools::isSubmit('subMOD')) {
            Configuration::updateValue('NRT_INSTAGRAM_USER_ID', Tools::getValue('NRT_INSTAGRAM_USER_ID'));
            Configuration::updateValue('NRT_INSTAGRAM_ACCESS_TOKEN', Tools::getValue('NRT_INSTAGRAM_ACCESS_TOKEN'));
            Configuration::updateValue('NRT_INSTAGRAM_NBR_IMAGE', intval(Tools::getValue('NRT_INSTAGRAM_NBR_IMAGE')));
            Configuration::updateValue('NRT_INSTAGRAM_IMAGE_FORMAT',(Tools::getValue('NRT_INSTAGRAM_IMAGE_FORMAT')));
            return $this->displayConfirmation($this->l('Settings updated'));
        }
    }

    private function _getForm()
    {
        $helper = new HelperForm();
        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->identifier = $this->identifier;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->languages = $this->context->controller->getLanguages();
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;
        $helper->default_form_language = $this->context->controller->default_form_language;
        $helper->allow_employee_form_lang = $this->context->controller->allow_employee_form_lang;
        $helper->title = $this->displayName;

        $helper->fields_value['NRT_INSTAGRAM_USER_ID'] = Configuration::get('NRT_INSTAGRAM_USER_ID');
        $helper->fields_value['NRT_INSTAGRAM_ACCESS_TOKEN'] = Configuration::get('NRT_INSTAGRAM_ACCESS_TOKEN');
        $helper->fields_value['NRT_INSTAGRAM_NBR_IMAGE'] = Configuration::get('NRT_INSTAGRAM_NBR_IMAGE');
        $helper->fields_value['NRT_INSTAGRAM_IMAGE_FORMAT'] = Configuration::get('NRT_INSTAGRAM_IMAGE_FORMAT');

        $helper->submit_action = 'subMOD';


        # form
        $this->fields_form[] = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->displayName
                ),
                'input' => array(
                    array(
                        'type' => 'text',
                        'label' => $this->l('Instagram User ID :'),
                        'name' => 'NRT_INSTAGRAM_USER_ID',
						'desc'  => $this->l(' ')
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Instagram Access token :'),
                        'name' => 'NRT_INSTAGRAM_ACCESS_TOKEN',
						'desc'  => $this->l('Generate Instagram User ID and Access Token : ')."<a href='https://rudrastyh.com/tools/access-token' target='_blank'> ".$this->l('Click here !')."</a>"
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Image number :'),
                        'name' => 'NRT_INSTAGRAM_NBR_IMAGE',
                        'desc'  => $this->l('You can retry 20 pics maximum')
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Image format :'),
                        'name' => 'NRT_INSTAGRAM_IMAGE_FORMAT',
                        'options'  => array(
                            'query' => array(
                                array('id'   => 'thumbnail', 'name' => $this->l('Thumbnail (150 X 150) - Square crop')),
                                array('id'   => 'low_resolution', 'name' => $this->l('Low resolution (320 x 320)')),
                                array('id'   => 'standard_resolution', 'name' => $this->l('Standard resolution (612 x 612)'))
                            ),
                            'id'    => 'id',
                            'name'  => 'name'
                        )
                    )
                ),
                'submit' => array(
                    'title' => $this->l('Save')
                )
            )
        );

        return $helper->generateForm($this->fields_form);
    }

    public function hookDisplayHome($params)
    {

        $conf = Configuration::getMultiple(array('NRT_INSTAGRAM_USER_ID', 'NRT_INSTAGRAM_ACCESS_TOKEN'));
		
		$result = $this->fetchData($conf['NRT_INSTAGRAM_USER_ID'] , $conf['NRT_INSTAGRAM_ACCESS_TOKEN']);
		
		if(!$result || isset($result->meta->error_type))
			return false;

		$this->context->smarty->assign(array(
			'instagram_pics' => $this->getPics($result),
			'instagram_user' => $this->getAccount($result)
		));
        return $this->display(__FILE__, 'nrtinstagram.tpl');
    }
   
    # Work only if not hook on displayHome
    public function hookInstagram($params) {
        return $this->isRegisteredInHook('displayHome') ? false : $this->hookDisplayHome($params);
    }
	# Gets getAccount
    public function getAccount($result) {
        return array(
            'full_name' => $result->data[0]->user->full_name,
            'username' => $result->data[0]->user->username
        );
    }
	# Gets Pics
    public function getPics($result) {

        $conf = Configuration::getMultiple(array('NRT_INSTAGRAM_NBR_IMAGE','NRT_INSTAGRAM_IMAGE_FORMAT'));

        $instagram_pics = array();
		
		$items = array_slice($result->data, 0, $conf['NRT_INSTAGRAM_NBR_IMAGE']);
		
        foreach ($items as $item) {

            $image_format = $conf['NRT_INSTAGRAM_IMAGE_FORMAT'] ? $conf['NRT_INSTAGRAM_IMAGE_FORMAT'] : 'standard_resolution';
            $image = $item->images->{$image_format}->url;
            $instagram_pics[] = array(
				'image_width' => $item->images->{$image_format}->width,
				'image_height' => $item->images->{$image_format}->height,
                'image' => $image,
                'original_image' => $item->images->standard_resolution->url,
                'caption' => isset($item->caption->text) ? $item->caption->text : '',
                'link' => $item->link,
                'likes' => $item->likes->count,
                'comments' => $item->comments->count,
                'date' => date($this->context->language->date_format_full, $item->created_time)
            );
        }
        return $instagram_pics;

    }
	# Gets our data
	public function fetchData($userid , $accessToken){
			$url = "https://api.instagram.com/v1/users/" .$userid. "/media/recent?access_token=" . $accessToken;
			$ch = curl_init($url); 
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
			$json = curl_exec($ch); 
			curl_close($ch);
			$result = json_decode($json);
			return $result;
	}
}
