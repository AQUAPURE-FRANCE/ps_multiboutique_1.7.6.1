<div class="cws-widget">
	<div class="widget-title widget_shopping_cart_content_title widget-title-icon">
		<span>{l s='Cart' d='Shop.Theme.Checkout'}</span>
	</div>
	
	<div class="widget_shopping_cart_content">
		<div class="woo_mini_cart cart-summary" data-refresh-url="{$refresh_url}">
			{if $cart.products}
			<ul class="cart_list product_list_widget ">
				{foreach from=$cart.products item="product"}
				<li class="mini_cart_item">
					<a
	                  class                       = "remove-from-cart"
	                  rel                         = "nofollow"
	                  href                        = "{$product.remove_from_cart_url}"
	                  data-link-action            = "delete-from-cart"
	                  data-id-product             = "{$product.id_product|escape:'javascript'}"
	                  data-id-product-attribute   = "{$product.id_product_attribute|escape:'javascript'}"
	                  data-id-customization   	  = "{$product.id_customization|escape:'javascript'}">
		            {if !isset($product.is_gift) || !$product.is_gift}
		            ×
		            {/if}
		            </a>
	                <a class="cart-item-product-left" href="{$product.url}">
					<img class="img-responsive" src="{$product.cover.bySize.cart_default.url}" alt="{$product.name|escape:'quotes'}">{$product.name}
		        	</a>
		        	{foreach from=$product.attributes key="attribute" item="value"}
					<div class="product-line-info-top">
						<span class="value-top">{$value}</span>
					</div>
					{/foreach}
		        	<span class="qtt-ajax quantity">{$product.quantity} x 
                    	<span class="value price">{$product.price}</span>
						{if $product.unit_price_full}
						<div class="unit-price-cart">{$product.unit_price_full}</div>
						{/if}
		            </span>
				</li>
				{/foreach}
			</ul>
	<div class="card-block-top">
		<div class="totals-top">
			<span class="label-top">{$cart.totals.total.label} {$cart.labels.tax_short}</span>
			<span class="value-top price">{$cart.totals.total.value}</span>
		</div>
		<div class="totals-top">
			<span class="label-top">{$cart.subtotals.tax.label}</span>
			<span class="value-top price">{$cart.subtotals.tax.value}</span>
		</div>
	</div>
	<div class="buttons">
		<a href="{$cart_url}" class="btn view-cart"><i class="pf-view-basket"></i> {l s='View Cart' d='Shop.Theme.Actions'}</a>
		<a href="{$urls.pages.order}" class="btn checkout"><i class="pf-checkout"></i> {l s='Proceed to checkout' d='Shop.Theme.Actions'}</a>
	</div>
			{else}
			<ul class="cart_list product_list_widget ">
				<li class="empty">{l s='There are no more items in your cart' d='Shop.Theme.Checkout'}</li>
			</ul>
			{/if}
		</div>
	</div>
	<!-- end product list -->	
</div>