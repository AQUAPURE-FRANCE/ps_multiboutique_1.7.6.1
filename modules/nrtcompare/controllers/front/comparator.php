<?php
/*
* 2007-2016 PrestaShop
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
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2016 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

/**
 * @since 1.5.0
 */
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
class NrtCompareComparatorModuleFrontController extends ModuleFrontController
{
	private $list_products = array();
	private $ordered_features = '';
	private $product_features = array();
	private $list_ids_product = array();
	
	public function postProcess()
	{
		global $cookie;
		$id_lang = (int)Context::getContext()->language->id;
		$id_shop = (int)Context::getContext()->shop->id;
		$id_lang_default = (int)Configuration::get('PS_LANG_DEFAULT');
		if($cookie->compare_product_list){
		$products_id=explode (",",$cookie->compare_product_list);
		$this->ordered_features = $this->getFeaturesForComparison($products_id, $this->context->language->id);
		$products=array();
		foreach($products_id as $id_product){
			$curProduct = new Product((int)$id_product, true, (int)Context::getContext()->language->id);
			foreach ($curProduct->getFrontFeatures((int)Context::getContext()->language->id) as $feature) {
				$listFeatures[$curProduct->id][$feature['id_feature']] = $feature['value'];
			}
			$customProduct = get_object_vars(new Product($id_product, true, $id_lang));
			$customProduct['id_product'] = $customProduct['id'];
			$coverImage = Product::getCover($customProduct['id_product']);
			$customProduct['id_image'] = $coverImage['id_image'];
			if(Product::getProductProperties($id_lang, $customProduct))
				$products[]= Product::getProductProperties($id_lang, $customProduct);
		}
	
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
		$products_for_template = [];
			if(is_array($products)){
			foreach ($products as $rawProduct) {
				$products_for_template[] = $presenter->present(
					$presentationSettings,
					$assembler->assembleProduct($rawProduct),
					$this->context->language
				);
				}
			}
		$this->list_products=$products_for_template;	
		$this->product_features	=$listFeatures;
		$this->list_ids_product	=$products_id;
		
		}	
	}
	/**
	 * @see FrontController::initContent()
	 */
	public function initContent()
	{
		parent::initContent();
		$this->context->smarty->assign('list_products', $this->list_products);
		$this->context->smarty->assign('ordered_features',$this->ordered_features);
		$this->context->smarty->assign('product_features',$this->product_features);
		$this->context->smarty->assign('list_ids_product',$this->list_ids_product);
		$this->setTemplate('module:nrtcompare/views/templates/front/comparator.tpl');	
		
	}
	
	
    public static function getFeaturesForComparison($list_ids_product, $id_lang)
    {
        if (!Feature::isFeatureActive()) {
            return false;
        }

        $ids = '';
        foreach ($list_ids_product as $id) {
            $ids .= (int)$id.',';
        }

        $ids = rtrim($ids, ',');

        if (empty($ids)) {
            return false;
        }

        return Db::getInstance()->executeS('
			SELECT f.*, fl.*
			FROM `'._DB_PREFIX_.'feature` f
			LEFT JOIN `'._DB_PREFIX_.'feature_product` fp
				ON f.`id_feature` = fp.`id_feature`
			LEFT JOIN `'._DB_PREFIX_.'feature_lang` fl
				ON f.`id_feature` = fl.`id_feature`
			WHERE fp.`id_product` IN ('.$ids.')
			AND `id_lang` = '.(int)$id_lang.'
			GROUP BY f.`id_feature`
			ORDER BY f.`position` ASC
		');
    }
}
