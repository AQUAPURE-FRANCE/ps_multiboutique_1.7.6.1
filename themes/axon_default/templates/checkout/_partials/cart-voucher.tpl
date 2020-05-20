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
{if $cart.vouchers.allowed && $cart.vouchers.added}
{block name='cart_voucher'}        
	{block name='cart_voucher_list'}
	{foreach from=$cart.vouchers.added item=voucher}
	<tr class="promo-name card-block">            			
		<td class="cart-summary-line">
			<span class="label">{$voucher.name}</span>
			<a class="product-remove pull-right" href="{$voucher.delete_url}" data-link-action="remove-voucher"><i class="fa fa-times-circle remove-from-cart"></i></a>
		</td>
		<td>
			<div class="float-xs-right">
			{$voucher.reduction_formatted}
			</div>
		</td>
	</tr>
	{/foreach}
	{/block}       
{/block}
{/if}
