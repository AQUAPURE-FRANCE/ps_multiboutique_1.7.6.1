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
{extends file=$layout}

{block name='breadcrumb'}
{if isset($breadcrumb)}
 <nav class="breadcrumb">
  	<div class="container" {if $page.page_name=='category'}style="background-image:url('{$category.image.large.url}'); background-repeat: no-repeat; height: 190px"{else}{/if}>
		<ol itemscope itemtype="http://schema.org/BreadcrumbList">
			<li  class="title_large title_font">
			{l s='Shopping Cart' d='Shop.Theme.Checkout'} 
			</li>
			<li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
	            <a itemprop="item" href="https://3.1.aquapure.fr/fr/">
	              <span itemprop="name"><i class="fa fa-home"></i></span>
	            </a>
            <meta itemprop="position" content="1">
			</li>
			<li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
	            <a itemprop="item">
	            	<span itemprop="name">{l s='Shopping Cart' d='Shop.Theme.Checkout'}</span>
	            </a>
				<meta itemprop="position" content="2">
          </li>
		</ol>
  	</div>
</nav>
{/if}
{/block}

{block name='content'}

  <section id="main">
    <div class="cart-grid row">

      <!-- Left Block: cart product informations & shpping -->
      <div class="cart-grid-body col-xs-12 col-lg-8">

        <!-- cart products detailed -->
        <div class="woocommerce">
          {block name='cart_overview'}
            {include file='checkout/_partials/cart-detailed.tpl' cart=$cart}
          {/block}
        </div>

        {block name='continue_shopping'}
          <a class="button-alt" href="{$urls.pages.index}">
            <i class="material-icons">chevron_left</i>{l s='Continue shopping' d='Shop.Theme.Actions'}
          </a>
        {/block}

        <!-- shipping informations -->
        {block name='hook_shopping_cart_footer'}
          {hook h='displayShoppingCartFooter'}
        {/block}
      </div>

      <!-- Right Block: cart subtotal & cart total -->
      <div class="cart-grid-right col-xs-12 col-lg-4">

        {block name='cart_summary'}
          <div class="woocommerce woocommerce-checkout-review-order cart-summary" id="order_review">

            {block name='hook_shopping_cart'}
              {hook h='displayShoppingCart'}
            {/block}

            {block name='cart_totals'}
              {include file='checkout/_partials/cart-detailed-totals.tpl' cart=$cart}
            {/block}

            {block name='cart_actions'}
              {include file='checkout/_partials/cart-detailed-actions.tpl' cart=$cart}
            {/block}

          </div>
        {/block}

        {block name='hook_reassurance'}
          {hook h='displayReassurance'}
        {/block}

      </div>
    </div>
{*     '<pre>'{$cart.products|@print_r}'</pre>' *}
  </section>
{/block}
