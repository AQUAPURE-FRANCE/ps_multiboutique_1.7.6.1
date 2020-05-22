{**
 * 2007-2017 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
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
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *}
{block name='cart_detailed_product'}
<div class="cart-overview js-cart" data-refresh-url="{url entity='cart' params=['ajax' => true, 'action' => 'refresh']}">
	<table class="shop_table cart">
		{if $cart.products}  
		<thead>
		<tr>
		  <th class="product-thumbnail">Product</th>
		  <th class="product-name">&nbsp;</th>
		  <th class="product_price">Price</th>
		  <th class="product-quantity">Quantity</th>
		  <th class="product-subtotal">Total</th>
		  <th class="product-remove">&nbsp;</th>
		</tr>
		</thead>
		<tbody>	
	      
	      	{foreach from=$cart.products item=product}
	        <tr class="cart_item">
	          {block name='cart_detailed_product_line'}
	            {include file='checkout/_partials/cart-detailed-product-line.tpl' product=$product}
	          {/block}
	        </tr>
	        {if $product.customizations|count >1}<hr>{/if}
			{/foreach}
			<tr>
				<td colspan="{if $cart.discounts|count < 1}6{/if}{if $cart.discounts|count > 0}2{/if}" class="actions block-promo">
					<p class="mb-0">
					<a class="mb-0 collapse-button promo-code-button" data-toggle="collapse" href="#promo-code" aria-expanded="false" aria-controls="promo-code">
					{l s='Have a promo code?' d='Shop.Theme.Checkout'}
					</a>
					</p>
					<div class="coupon promo-code collapse{if $cart.discounts|count > 0} in{/if}" id="promo-code">
						{block name='cart_voucher_form'}
						<form action="{$urls.pages.cart}" data-link-action="add-voucher" method="post">
						<input type="hidden" name="token" value="{$static_token}">
						<input type="hidden" name="addDiscount" value="1">
						<input class="promo-input" type="text" name="discount_name" placeholder="{l s='Promo code' d='Shop.Theme.Checkout'}" id="coupon_code">
						<button type="submit" class="aqua-button alt"><span>{l s='Add' d='Shop.Theme.Actions'}</span></button>
						</form>
						{/block}
					
						{block name='cart_voucher_notifications'}
						<div class="alert alert-danger js-error" role="alert">
						<i class="material-icons">&#xE001;</i><span class="ml-1 js-error-text"></span>
						</div>
						{/block}
					</div>
				</td>
				{if $cart.discounts|count > 0}
				<td colspan="4" class="actions block-promo">
					<p class="block-promo promo-highlighted">
					{l s='Take advantage of our exclusive offers:' d='Shop.Theme.Actions'}
					</p>
					<ul class="js-discount card-block promo-discounts">
					{foreach from=$cart.discounts item=discount}
						<li class="cart-summary-line">
							<span class="tx-small"><span class="button-submit-alt code">{$discount.code}</span> : {$discount.name}</span>
						</li>
					{/foreach}
					</ul>
				</td>
				{/if}				
			</tr>
		</tbody>
	    {else}
	    <thead>
		    <th class="product-thumbnail">Product</th>
		</thead>
		<tbody>
			<tr>
			<td class="no-items">{l s='There are no more items in your cart' d='Shop.Theme.Checkout'}</td>
			</tr>
		</tbody>	    
	    {/if}	    
    </table>
</div>
{/block}