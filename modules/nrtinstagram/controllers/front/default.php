<?php

class NrtInstagramDefaultModuleFrontController extends ModuleFrontController
{

    public function initContent()
    {
        parent::initContent();

        $nrtinstagram = Module::getInstanceByName('nrtinstagram');
        $this->context->smarty->assign(array(
            'instagram_pics' => $nrtinstagram->getPics(true),
            'instagram_user' => $nrtinstagram->getAccount(Configuration::get('BI_USERNAME'))
        ));

        $this->setTemplate('default.tpl');
    }

}