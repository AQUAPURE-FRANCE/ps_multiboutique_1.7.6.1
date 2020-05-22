<?php
require_once(dirname(__FILE__).'/../../config/config.inc.php');
require_once(dirname(__FILE__).'/../../init.php');
include(dirname(__FILE__).'/nrtcompare.php');
$compare = new NrtCompare();
if(isset($_POST['id_product_add'])){
	$compare->AddCompare($_POST['id_product_add']);
}

if(isset($_POST['id_product_remove'])){
	$compare->RemoveCompare($_POST['id_product_remove']);
}
