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
<!-- images of product-->
<div class="images col-md-4">
    {block name='product_cover'}
        <!-- picture-->
        <div class="pic mb-10">
            <img src="{$product.cover.bySize.large_default.url}" alt="{$product.cover.legend}"
                 title="{$product.cover.legend}" style="width: 100%;"
            >
            <div class="hover-effect back_{$product.category}"></div>
            <div class="links">
                <a data-toggle="modal" data-target="#product-modal" href="{$product.cover.bySize.large_default.url}"
                   class="link-icon fa fa-eye">
                </a>
            </div>
        </div>
        <!-- /picture-->
	{/block}
	{block name='product_images'}
		<div class="thumbnails clearfix">
		{foreach from=$product.images item=image}
			<div class="thumbnail pic">
				<img
					src="{$image.bySize.medium_default.url}"
					alt="{$image.legend}"
					title="{$image.legend}"
					class="thumb owl-lazy js-thumb {if $image.id_image == $product.cover.id_image} selected {/if}"
					data-image-medium-src="{$image.bySize.medium_default.url}"
					data-image-large-src="{$image.bySize.large_default.url}"
					data-src="{$image.bySize.home_default.url}"
				>
				<div class="hover-effect"></div>
{*
				<div class="links">
					<a href="{$product.cover.bySize.large_default.url}"class="link-icon fa fa-eye"></a>
				</div>
*}
			</div>
		{/foreach}
		</div>
	{/block}
	{hook h='displayAfterProductThumbs'}
</div>
<!-- /images of product-->

<script type="text/javascript">
$(document).ready(function() {
  $('.slider-images-detail').owlCarousel({
	items:4,
	autoplay:false,
	autoplayTimeout:5000,
	autoplayHoverPause:false,
	lazyLoad:true,
	nav:true,
	dots:false,
	navText: ['<span class="fa fa-angle-left"></span>','<span class="fa fa-angle-right"></span>']
  });
});
</script>
{if isset($HOOK_ELEVATEZOOM) && !empty($HOOK_ELEVATEZOOM) && $page.page_name=='product'}
    {$HOOK_ELEVATEZOOM nofilter}
{/if}

