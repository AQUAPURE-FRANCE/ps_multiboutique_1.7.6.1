{*
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
*}
{assign var="link" value=Context::getContext()->link}
{if $products}
	{if !$refresh}
	<div class="wishlistLinkTop">
		<a href="#" id="hideWishlist" class="button_account" onclick="WishlistVisibility('wishlistLinkTop', 'Wishlist'); return false;" title="{l s='Close this wishlist' mod='blockwishlist'}" rel="nofollow"><i class="fa fa-remove"></i></a>
		<ul class="clearfix display_list">
			<li>
				<a href="#" id="hideBoughtProducts" class="button_account"  onclick="WishlistVisibility('wlp_bought', 'BoughtProducts'); return false;" title="{l s='Hide products' mod='blockwishlist'}">{l s='Hide products' mod='blockwishlist'}</a>
				<a href="#" id="showBoughtProducts" class="button_account"  onclick="WishlistVisibility('wlp_bought', 'BoughtProducts'); return false;" title="{l s='Show products' mod='blockwishlist'}">{l s='Show products' mod='blockwishlist'}</a>
			</li>
			{if count($productsBoughts)}
			<li>
				<a href="#" id="hideBoughtProductsInfos" class="button_account" onclick="WishlistVisibility('wlp_bought_infos', 'BoughtProductsInfos'); return false;" title="{l s="Hide products" mod='blockwishlist'}">{l s="Hide bought products' info" mod='blockwishlist'}</a>
				<a href="#" id="showBoughtProductsInfos" class="button_account"  onclick="WishlistVisibility('wlp_bought_infos', 'BoughtProductsInfos'); return false;" title="{l s="Show products" mod='blockwishlist'}">{l s="Show bought products' info" mod='blockwishlist'}</a>
			</li>
			{/if}
		</ul>
		<p class="wishlisturl">{l s='Permalink' mod='blockwishlist'}: <input class="form-control" type="text" value="{$link->getModuleLink('blockwishlist', 'view', ['token' => $token_wish])|escape:'html':'UTF-8'}" readonly/></p>
			<div id="showSendWishlist">
				<a href="#" class="button_account exclusive btn" data-toggle="modal" data-target="#moda_sendwl" title="{l s='Send this wishlist' mod='blockwishlist'}"><i class="fa fa-paper-plane"></i>{l s='Send this wishlist' mod='blockwishlist'}</a>
			</div>
	{/if}
	<div class="wlp_bought">
		<ul class="clearfix wlp_bought_list row">
		{foreach from=$products item=product name=i}
			<li id="wlp_{$product.id_product}_{$product.id_product_attribute}" class="col-md-3 col-sm-4 col-xs-6 address {if $smarty.foreach.i.index % 2}alternate_{/if}item">
				<a href="javascript:;" class="lnkdel" onclick="WishlistProductManage('wlp_bought', 'delete', '{$id_wishlist}', '{$product.id_product}', '{$product.id_product_attribute}', $('#quantity_{$product.id_product}_{$product.id_product_attribute}').val(), $('#priority_{$product.id_product}_{$product.id_product_attribute}').val());" title="{l s='Delete' mod='blockwishlist'}">&raquo; {l s='Delete' mod='blockwishlist'}</a>
				<div class="clearfix">
					<div class="product_image">
						<a href="{$link->getProductlink($product.id_product, $product.link_rewrite, $product.category_rewrite)|escape:'html'}" title="{l s='Product detail' mod='blockwishlist'}">
							<img class="img-responsive" src="{$link->getImageLink($product.link_rewrite, $product.cover, ImageType::getFormatedName('medium'))|escape:'html'}" alt="{$product.name|escape:'html':'UTF-8'}" />
						</a>
					</div>
					<div class="product_infos">
						<p id="s_title" class="product_name">
                        <a href="{$link->getProductlink($product.id_product, $product.link_rewrite, $product.category_rewrite)|escape:'html'}" title="{l s='Product detail' mod='blockwishlist'}">
                        {$product.name|truncate:30:'...'|escape:'html':'UTF-8'}
                        </a>
                        </p>
						<div class="wishlist_product_detail">
						{if isset($product.attributes_small)}
							<a href="{$link->getProductlink($product.id_product, $product.link_rewrite, $product.category_rewrite)|escape:'html'}" title="{l s='Product detail' mod='blockwishlist'}">{$product.attributes_small|escape:'html':'UTF-8'}</a>
						{/if}
                        	<div>
							{l s='Quantity' mod='blockwishlist'}&nbsp;:
                            <input type="text" id="quantity_{$product.id_product}_{$product.id_product_attribute}" value="{$product.quantity|intval}" size="3"  />
							</div>
                            <div>
							{l s='Priority' mod='blockwishlist'}:
							<select id="priority_{$product.id_product}_{$product.id_product_attribute}">
								<option value="0"{if $product.priority eq 0} selected="selected"{/if}>{l s='High' mod='blockwishlist'}</option>
								<option value="1"{if $product.priority eq 1} selected="selected"{/if}>{l s='Medium' mod='blockwishlist'}</option>
								<option value="2"{if $product.priority eq 2} selected="selected"{/if}>{l s='Low' mod='blockwishlist'}</option>
							</select>
                            </div>
							{if $wishlists|count > 1}
                            	<div>
								{l s='Move'}:
                                {foreach name=wl from=$wishlists item=wishlist}
                                    {if $smarty.foreach.wl.first}
                                       <select class="wishlist_change_button">
                                       <option>---</option>
                                    {/if}
                                    {if $id_wishlist != {$wishlist.id_wishlist}}
	                                        <option title="{$wishlist.name}" value="{$wishlist.id_wishlist}" data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}" data-quantity="{$product.quantity|intval}" data-priority="{$product.priority}" data-id-old-wishlist="{$id_wishlist}" data-id-new-wishlist="{$wishlist.id_wishlist}">
	                                                {l s='Move to %s'|sprintf:$wishlist.name mod='blockwishlist'}
	                                        </option>
                                    {/if}
                                    {if $smarty.foreach.wl.last}
                                        </select>
                                    {/if}
                                {/foreach}
                                </div>
                            {/if}
						</div>
					</div>
				</div>
				<div class="btn_action">
					<a href="javascript:;" class="exclusive btn lnksave" onclick="WishlistProductManage('wlp_bought_{$product.id_product_attribute}', 'update', '{$id_wishlist}', '{$product.id_product}', '{$product.id_product_attribute}', $('#quantity_{$product.id_product}_{$product.id_product_attribute}').val(), $('#priority_{$product.id_product}_{$product.id_product_attribute}').val());" title="{l s='Save' mod='blockwishlist'}">{l s='Save' mod='blockwishlist'}</a>
				</div>
                
			</li>
		{/foreach}
		</ul>
	</div>
	{if !$refresh}
<div id="moda_sendwl" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
  	<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
    <div class="modal-body">
	<form method="post" class="wl_send std" onsubmit="return (false);">
			<div class="row">
            	<div class="col-xs-3">
					<label for="email1">{l s='Email' mod='blockwishlist'}&nbsp;1 <sup style="color:red">*</sup></label>
                </div>
                <div class="col-xs-9">
					<input class="form-control" type="email" name="email1" id="email1" required="required"/>
                </div>
			</div>
			{section name=i loop=11 start=2}
			<div class="row">
            	<div class="col-xs-3">
				<label for="email{$smarty.section.i.index}">{l s='Email' mod='blockwishlist'}&nbsp;{$smarty.section.i.index}</label>
                </div>
                <div class="col-xs-9">
				<input class="form-control" type="email" name="email{$smarty.section.i.index}" id="email{$smarty.section.i.index}" />
                </div>
			</div>
			{/section}
			<div class="row">
                <div class="col-xs-3">
                	<label style="color:red; padding-left:10px;">
						<sup style="left:0">*</sup> {l s='Required field' mod='blockwishlist'}
                    </label>
                </div>
            	<div class="col-xs-9" style="text-align:right;">
					<input class="btn" type="submit" value="{l s='Send' mod='blockwishlist'}" name="submitWishlist" onclick="WishlistSend('wl_send', '{$id_wishlist}', 'email');" />
                 </div>
			</div>
	</form>
    </div>
    </div>
  </div>
</div>
	{if count($productsBoughts)}
	<table class="wlp_bought_infos hidden std">
		<thead>
			<tr>
				<th class="first_item">{l s='Product' mod='blockwishlist'}</th>
				<th class="item">{l s='Quantity' mod='blockwishlist'}</th>
				<th class="item">{l s='Offered by' mod='blockwishlist'}</th>
				<th class="last_item">{l s='Date' mod='blockwishlist'}</th>
			</tr>
		</thead>
		<tbody>
		{foreach from=$productsBoughts item=product name=i}
			{foreach from=$product.bought item=bought name=j}
			{if $bought.quantity > 0}
				<tr>
					<td class="first_item">
						<span style="float:left;"><img class="img-responsive" src="{$link->getImageLink($product.link_rewrite, $product.cover, 'small')|escape:'html'}" alt="{$product.name|escape:'html':'UTF-8'}" /></span>
						<span style="float:left;">
							{$product.name|truncate:40:'...'|escape:'html':'UTF-8'}
						{if isset($product.attributes_small)}
							<br /><i>{$product.attributes_small|escape:'html':'UTF-8'}</i>
						{/if}
						</span>
					</td>
					<td class="item align_center">{$bought.quantity|intval}</td>
					<td class="item align_center">{$bought.firstname} {$bought.lastname}</td>
					<td class="last_item align_center">{$bought.date_add|date_format:"%Y-%m-%d"}</td>
				</tr>
			{/if}
			{/foreach}
		{/foreach}
		</tbody>
	</table>
	{/if}
	{/if}
{else}
	<p class="warning">{l s='No products' mod='blockwishlist'}</p>
{/if}
