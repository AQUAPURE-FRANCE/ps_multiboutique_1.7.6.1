<?php
require_once(dirname(__FILE__).'/../../../config/config.inc.php');
require_once(dirname(__FILE__).'/../../../init.php');
include(dirname(__FILE__).'/../nrtvmegamenu.php');
$flex = new nrtvmegamenu();

echo $flex->getProductCover(Tools::getValue('pID'));


?>