{**
 * 2007-2017 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
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
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2017 PrestaShop SA
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
*}

{if isset($nodecontent.products) && $nodecontent.products}

 <div class="single-product" itemscope itemtype="https://schema.org/Product">
	 <meta itemprop="url" content="{$product.url}">
 <div class="row">
            {foreach from=$nodecontent.products item="product"}
            <div class="row single-product {$product.category}">
	            {block name='page_content_container'}
	                {block name='page_content'}
	                    {block name='product_flags'}
	                        {if isset($product.show_condition) && isset($product.condition.type) && $product.show_condition == 1}
	                            <span class="action new"><span>{$product.condition.type}</span></span>
	                        {/if}
	                        {if isset($product.on_sale) && $product.on_sale && isset($product.show_price) && $product.show_price }
	                            <span class="action sale"><span>{l s='Sale'}</span></span>
	                        {/if}
	                    {/block}
	
	                    {block name='product_cover_tumbnails'}
	                        {include file='catalog/_partials/product-cover-thumbnails.tpl'}
	                    {/block}
	                {/block}
	            {/block}
	
	            <!-- Product details -->
	            <div class="col-md-4 content-product-detail">
	                {block name='page_header_container'}
	                    {block name='page_header'}
	                        <h1 class="product-title mt-0" itemprop="name">{block name='page_title'}{$product.name}{/block}</h1>
	                        <div class="divider mini gray left"></div>                       
	                    {/block}
	                {/block}
					<div class="review-status">
		                {hook h='displayProductTitleReviews' product=$product}	                
		                <div class="status-product {if $product.show_quantities}in-stock {else}{$product.availability} {/if}">
			                <!-- Products qty in stock -->
	                            {if $product.show_quantities}
	                                {$product.quantity} en stock
	                            {/if}
	                            {if !$configuration.is_catalog}
	                                {block name='product_availability'}
	                                    {if $product.show_availability && $product.availability_message}
	                                        
	                                            {$product.availability_message}
	                                        
	                                    {/if}
	                                {/block}
	                            {/if}
	                        <!-- /Products qty in stock -->
		                </div>
	              	</div>
	
	                <div class="product-information">
	                    {block name='product_description_short'}
	                    <hr class="mt-15 mb-15">
	                    
	                    <div id="product-description-short-{$product.id}" itemprop="description">
	                        {$product.description_short|truncate:190:"...":true nofilter}
	                    </div>
	                    
	                    <hr class="mt-15 mb-15">
	                    <table class="additionnal-infos">
	                    {if isset($product.reference_to_display)}
							<tr class="post-number reference">
								<td>{l s='Reference :' d='Shop.Theme.Catalog'}</td>
								<td><span itemprop="sku">{$product.reference_to_display}</span></td>
							</tr>
					    {/if}
					    {if isset($product.ean13) && $product.ean13 neq ''}
							<tr class="post-number ean">
								<td >{l s='EAN13 :' d='Shop.Theme.Catalog'}</td>
								<td><span itemprop="sku">{$product.ean13}</span></td>
							</tr>
						{/if} 
	                    <tr class="category-line">
		                    <td>{l s='Categories :' d='Shop.Theme.Catalog'}</td>
			                <td>
								{foreach from=Product::getProductCategoriesFull(Tools::getValue('id_product')) item=cat name=cats}
									<a href="{$link->getCategoryLink({$cat.id_category})}" title="{$cat.name}">{$cat.name}</a>{if !$smarty.foreach.cats.last}, {/if}
								{/foreach}
							</td>
	                    </tr>
	                    <tr class="tags-line">
		                    <td>{l s='Tags :' d='Shop.Theme.Catalog'}</td>
		                    <td>
		                    {foreach from=Tag::getProductTags(Tools::getValue('id_product')) key=k item=v}
						        {foreach from=$v item=value name=tags}
						            <a href="{$link->getPageLink('search', true, NULL, "tag={$value|urlencode}")}">{$value|escape:html:'UTF-8'}</a>{if !$smarty.foreach.tags.last}, {/if}
						        {/foreach}
						    {/foreach}
		                    </td>
	                    </tr>
	
						</table>
						
						<hr class="mt-15 mb-15">
	
	                    <div class="indice-features">
		                    <div class="title">{l s='Indices de Valeurs'}<div class="global-indices pull-right">{hook h='displayProductSizeGuide' product=$product}</div></div>
		                    {foreach from=$product.features item=feature}
		                    {if $feature.id_feature < 10}
		                    <div class="skill-bar feature_{$feature.id_feature}">
			                    <div class="name">{$feature.name}<span class="skill-bar-perc"></span></div>
								<div class="bar">
									<span 
										data-units="{if $feature.id_feature == 1 || $feature.id_feature == 2 || $feature.id_feature == 3}{l s='€/L'}
													{elseif $feature.id_feature == 4}{l s='€/m3'}
													{elseif $feature.id_feature == 5 || 6 || 7}{l s='Kg/mois'}
													{elseif $feature.id_feature == 8}{l s='m3/mois'}
													{elseif $feature.id_feature == 9}{l s='g/mois'}
													{/if}"
										data-value="{$feature.value}"
										data-max="{if $feature.id_feature == 1 || $feature.id_feature == 2}1
													{elseif $feature.id_feature == 3}0.1
													{elseif $feature.id_feature == 4}2
													{elseif $feature.id_feature == 5}5
													{elseif $feature.id_feature == 6}25
													{elseif $feature.id_feature == 7}1000
													{elseif $feature.id_feature == 8}10
													{elseif $feature.id_feature == 9}100
													{/if}"
										data-inter="{if $feature.id_feature == 1 || $feature.id_feature == 2}0.01
													{elseif $feature.id_feature == 3}0.001
													{elseif $feature.id_feature == 4}0.01
													{elseif $feature.id_feature == 5}0.01
													{elseif $feature.id_feature == 6}0.1
													{elseif $feature.id_feature == 7}10
													{elseif $feature.id_feature == 8}0.1
													{elseif $feature.id_feature == 9}1
													{/if}"
										class="cp-bg-color skill-bar-progress"
									>
									</span>
								</div>
								<div class="units"><span class="feature-value"></span><span class="skill-bar-unit"></span></div>
							</div>
					        {/if}
					        {/foreach}
	                    </div>
	
	                    {/block}
	                    {if $product.is_customizable && count($product.customizations.fields)}
	                        {block name='product_customization'}
	                            {include file="catalog/_partials/product-customization.tpl" customizations=$product.customizations}
	                        {/block}
	                    {/if}
	                    {capture name='siteguichart'}{hook h='extraLeft'}{/capture}
	                    {if $smarty.capture.siteguichart}
	                        {$smarty.capture.siteguichart nofilter}
	                    {/if}
	                </div>
	
	                {hook h='buttoncompare' product=$product}
	                {hook h='displayProductListFunctionalButtons' product=$product}
	
	{*                {block name='product_additional_info'}*}
	{*                    {include file='catalog/_partials/product-additional-info.tpl'}*}
	{*                {/block}*}
	            </div>
	            <!-- /product details -->
	            <!-- sidebar -->
	            <div class="col-md-4 sidebar">
	                <!-- Accessories -->
	                {block name='product_prices'}
	                    {include file='catalog/_partials/product-prices.tpl'}
	                {/block}
{*	                {hook h='displayRightColumnProduct'}*}
	                <!-- /Accessories -->
	                <!-- Product actions -->
	                <div class="product-actions">
	                    {block name='product_buy'}
	                        <form action="{$urls.pages.cart}" method="post" id="add-to-cart-or-refresh">
		                        {assign var="groups" value=Nrtpageeditors::getProductAttributesForTemplate($product.id)}
	                            <input type="hidden" name="token" value="{$static_token}">
	                            <input type="hidden" name="id_product" value="{$product.id}" id="product_page_product_id">
	                            <input type="hidden" name="id_customization" value="{$product.id_customization}" id="product_customization_id">
	                            {block name='product_variants'}
	                                {include file='catalog/_partials/product-variants.tpl' groups=$groups}
	                            {/block}
	{*                            {block name='product_pack'}*}
	{*                                {if $packItems}*}
	{*                                    <section class="product-pack">*}
	{*                                        <h3 class="h4">{l s='This pack contains' d='Shop.Theme.Catalog'}</h3>*}
	{*                                        {foreach from=$packItems item="product_pack"}*}
	{*                                            {block name='product_miniature'}*}
	{*                                                {include file='catalog/_partials/miniatures/pack-product.tpl' product=$product_pack}*}
	{*                                            {/block}*}
	{*                                        {/foreach}*}
	{*                                    </section>*}
	{*                                {/if}*}
	{*                            {/block}*}
	                            {block name='product_discounts'}
	                                {include file='catalog/_partials/product-discounts.tpl'}
	                            {/block}
	                            <!-- Add to cart -->
	                            {block name='product_add_to_cart'}
	                                {include file='catalog/_partials/product-add-to-cart.tpl'}
	                            {/block}
	                            <!-- /Add to cart -->
	                            {block name='product_refresh'}
	                                <input class="product-refresh ps-hidden-by-js" name="refresh" type="submit" value="{l s='Refresh' d='Shop.Theme.Actions'}" hidden>
	                            {/block}
	                        </form>
	                    {/block}
	                </div>
	                <!-- /Product actions -->
	            </div>
	            <!-- /sidebar -->
	        </div>
            {/foreach}
            
    </div>
{*      '<pre>'{$product|@var_dump}'</pre>'*}
 </div>
{else}
	<p class="alert alert-warning" style="clear:both;margin-bottom:30px;">{l s='No products at this time.'}</p>
{/if}
