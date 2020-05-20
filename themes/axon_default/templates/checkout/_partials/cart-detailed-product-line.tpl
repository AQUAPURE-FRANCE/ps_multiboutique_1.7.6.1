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

	<!--  product left content: image-->
	<td class="product-thumbnail">
		<a {if $product.has_discount}class="has-discount"{/if}>
		<img class="attachment-shop_thumbnail wp-post-image" src="{$product.cover.bySize.cart_default.url}" alt="{$product.name|escape:'quotes'}">
		{if $product.has_discount}
			{if $product.discount_type === 'percentage'}
	        <span class="action sale discount-percentage">
	        -{$product.discount_percentage_absolute}
	        </span>
	        {else}
	        <span class="action hot discount-amount">
	        -{$product.discount_to_display}
	        </span>
	        {/if}
	    {/if}    
		</a>
	</td>

	<!--  product left body: description -->
  
	<td class="product-name product">
		
	    <a class="product_name js-product-miniature quick-view product-title" href="javascript:void(0)" data-link-action="quickview" data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}" data-id_customization="{$product.id_customization|intval}">{$product.name}</a> 
		  
	    {foreach from=$product.attributes key="attribute" item="value"}
		<div class="product-line-info">
			<span class="label">{$attribute}:</span>
			<span class="value">{$value}</span>
		</div>
	    {/foreach}
	
		{if $product.customizations|count}
		<br>
		{block name='cart_detailed_product_line_customization'}
		{foreach from=$product.customizations item="customization"}
		<p><a href="#" data-toggle="modal" data-target="#product-customizations-modal-{$customization.id_customization}">{l s='Product customization' d='Shop.Theme.Catalog'}</a></p>
			<div class="modal fade customization-modal" id="product-customizations-modal-{$customization.id_customization}" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<h4 class="modal-title">{l s='Product customization' d='Shop.Theme.Catalog'}</h4>
						</div>
						<div class="modal-body">
						{foreach from=$customization.fields item="field"}
							<div class="product-customization-line row">
							<div class="col-sm-3 col-xs-4 label">
						{$field.label}
						</div>
						<div class="col-sm-9 col-xs-8 value">
						{if $field.type == 'text'}
							{if (int)$field.id_module}
								{$field.text nofilter}
							{else}
								{$field.text}
							{/if}
						{elseif $field.type == 'image'}
							<img src="{$field.image.small.url}">
						{/if}
							</div>
							</div>
						{/foreach}
						</div>
					</div>
				</div>
			</div>
		{/foreach}
		{/block}
		{/if}
	</td>

  <!--  product left body: description -->
	<td class="product_price {if $product.has_discount}has-discount{/if}">
        <span class="amount {if $product.has_discount}{if $product.discount_type === 'percentage'}sale {else} hot{/if}{/if}">{$product.price_wt|number_format:2:",":"."}<sup>{$currency.sign}</sup></span>
        {if $product.has_discount}
        <div class="product-discount">
          <span class="regular-price old-price">{$product.price_without_reduction|number_format:2:",":"."}<sup>{$currency.sign}</sup></span>
        </div>
		{/if}

        {if $product.unit_price_full}
          <div class="unit-price-cart">{$product.unit_price_full}</div>
        {/if}

	</td>
    

        
	<td class="product-quantity">
	{if isset($product.is_gift) && $product.is_gift}
	  <span class="gift-quantity">{$product.quantity}</span>
	{else}
	  <input
	    class="js-cart-line-product-quantity"
	    data-down-url="{$product.down_quantity_url}"
	    data-up-url="{$product.up_quantity_url}"
	    data-update-url="{$product.update_quantity_url}"
	    data-product-id="{$product.id_product}"
	    type="text"
	    value="{$product.quantity}"
	    name="product-quantity-spin"
	    min="{$product.minimal_quantity}"
	  />
	{/if}
	</td>
          
	<td class="product_price">
		<span class="amount">
		  <strong>
		    {if isset($product.is_gift) && $product.is_gift}
		      <span class="gift">{l s='Gift' d='Shop.Theme.Checkout'}</span>
		    {else}
		      {$product.total_wt|number_format:2:",":"."}<sup>{$currency.sign}</sup>
		    {/if}
		  </strong>
		</span>
	</td>        

	<td class="product-remove">
		<div class="cart-line-product-actions">
		  <a
		      class                       = "remove-from-cart"
		      rel                         = "nofollow"
		      href                        = "{$product.remove_from_cart_url}"
		      data-link-action            = "delete-from-cart"
		      data-id-product             = "{$product.id_product|escape:'javascript'}"
		      data-id-product-attribute   = "{$product.id_product_attribute|escape:'javascript'}"
		      data-id-customization   	  = "{$product.id_customization|escape:'javascript'}"
		  >
		    {if !isset($product.is_gift) || !$product.is_gift}
		    <i class="material-icons">delete</i>
		    {/if}
		  </a>
		
		  {block name='hook_cart_extra_product_actions'}
		    {hook h='displayCartExtraProductActions' product=$product}
		  {/block}
		
		</div>
	</td>

  

