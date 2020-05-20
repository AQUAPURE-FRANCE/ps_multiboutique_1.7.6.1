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
{block name='cart_detailed_totals'}
<table class="cart-detailed-totals shop_table woocommerce-checkout-review-order-table">
	<thead>
		<tr>
			<th class="product-name">{l s='Product' d='Shop.Theme.Checkout'}</th>
			<th class="product-total">{l s='Total' d='Shop.Theme.Checkout'}</th>
		</tr>
	</thead>
	<tbody>
			
		{foreach from=$cart.products item=product}
		<tr class="cart_item">
			
			<td class="product-name cart-summary-line">
				{$product.quantity} x {$product.name}
			</td>
			<td>
				<span class="amount">{$product.total}
{*
				{if $subtotal.type === 'shipping'}
					<small class="value">{hook h='displayCheckoutSubtotalDetails' subtotal=$subtotal}</small>
				{/if}
*}
				</span>						
			</td>				
			
		</tr>
		{/foreach}
		

	{block name='cart_voucher'}
	{include file='checkout/_partials/cart-voucher.tpl'}
	{/block}
	
	</tbody>
	<tfoot class="card-block">
	{if $cart.subtotals.products}
		<tr class="cart-summary-line cart-total">
			<th class="label">{$cart.subtotals.products.label}</td>
			<th class="amount">{$cart.subtotals.products.value}</td>
		</tr>
	{/if}
	{if $cart.subtotals.discounts}		
		<tr class="cart-summary-line">
			<td class="label">{$cart.subtotals.discounts.label}</td>
			<td class="amount">{$cart.subtotals.discounts.value}</td>
		</tr>
	{/if}
	{if $cart.subtotals.shipping}
		<tr class="cart-summary-line cart-total">
			<td class="label">{$cart.subtotals.shipping.label}</td>
			<td class="amount">{$cart.subtotals.shipping.value}</td>
		</tr>
	{/if}
	{if $cart.subtotals.tax}		
		<tr class="cart-summary-line">
			<td class="label">{$cart.subtotals.tax.label}</td>
			<td class="amount">{$cart.subtotals.tax.value}</td>
		</tr>
	{/if}

		<tr class="cart-summary-line order-total cart-total">
			<th><span>{$cart.totals.total.label} {$cart.labels.tax_short}</span></th>
			<th><span class="amount">{$cart.totals.total.value}</span></th>
		</tr>

	</tfoot>
  
</table>
{/block}
