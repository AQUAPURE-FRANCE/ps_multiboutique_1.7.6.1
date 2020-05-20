{**
* Multi Accessories
*
* @author    PrestaMonster
* @copyright PrestaMonster
* @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*}
{if $group.display_style == HsMaDisplayStyle::RADIO}
    {assign var=input_type value='radio'}
    {assign var=flag_checked value=0}
{else}
    {assign var=input_type value='checkbox'}
{/if}
{assign var=image_width value=800}
<table id="product_list_accessory_{$group.id_accessory_group|intval}" class="accessorygroup clear">
    {foreach from=$accessories_groups[$group.id_accessory_group] item=accessory key=key}
        {assign var=is_checked value=0}
        {assign var=is_disabled value=0}
        {if $accessory.is_available_buy_together == 1}
            {if $input_type === 'radio' && !$flag_checked}
                {assign var=is_checked value=1}
                {assign var=flag_checked value=1}
            {else}
                {assign var=is_checked value=0}
            {/if}
            {if $input_type === 'checkbox'}
                {assign var=is_checked value=1}
                {if $buy_main_accessory_together == HsMaProductSettingAbstract::BUY_TOGETHER_REQUIRED && $accessory.required == 1}
                    {assign var=is_disabled value=1}
                {/if}
            {/if}
        {/if}
        <tr class="clearfix accessory-block woocommerce" id="{$accessory.random_product_accessories_id|escape:'htmlall':'UTF-8'}">
            {if $is_product_page}
                <td width="0">
                    <input data-id-product-attribute ="{if $accessory.id_product_attribute != 0}{$accessory.id_product_attribute|intVal}{else}{$accessory.default_id_product_attribute|intVal}{/if}"
                           data-randomId ="{$accessory.random_product_accessories_id|escape:'htmlall':'UTF-8'}"
                           {*{if $is_checked == 1}*} checked="checked" data-quang="1" {*{if $is_disabled == 1} disabled='disabled' {/if}{/if}*}
                           data-required-buy-together ="{$accessory.is_available_buy_together|intval}" type="{$input_type|escape:'htmlall':'UTF-8'}"
                           id='accessories_proudct_{$group.id_accessory_group|escape:'htmlall':'UTF-8'}_{$accessory.id_accessory|escape:'htmlall':'UTF-8'}'
                           class="accessory_item" value="{$accessory.id_accessory|escape:'htmlall':'UTF-8'}"
                           {if $accessory.is_available_for_order} disabled="disabled"{/if}
                           {if $group.display_style == HsMaDisplayStyle::RADIO}name="accessories_{$group.id_accessory_group|intval}"{/if}
                    />
                </td>
            {/if}
            {if $accessory_configuration_keys.HSMA_SHOW_IMAGES}
                <td class="checkbox_radio_image">
                    <div class="hsma_images-container">
  
                        <div class="product-cover">
	                    	<a class="product_name js-product-miniature quick-view product-title" href="javascript:void(0)" data-link-action="quickview" data-id-product="{$accessory.id_accessory}" />
{*
							{if !$accessory_configuration_keys.HSMA_APPLY_FANCYBOX_TO_IMAGE}
							<a href="{$accessory.link|escape:'htmlall':'UTF-8'}" target="_blank" class="product_img_link" title="{$accessory.name|escape:'htmlall':'UTF-8'}">
							{/if}
*}
                            <img class="accessory_image hsma-js-qv-product-cover"  src="{$accessory.image|escape:'htmlall':'UTF-8'}" width="45" height="45" title="{$accessory.name|escape:'htmlall':'UTF-8'}" alt="{$accessory.name|escape:'htmlall':'UTF-8'}" itemprop="image">
{*
							{if !$accessory_configuration_keys.HSMA_APPLY_FANCYBOX_TO_IMAGE}
                            </a>
							{/if}
*}
							</a>
							{if $accessory_configuration_keys.HSMA_APPLY_FANCYBOX_TO_IMAGE}
                            <div class="layer hidden-sm-down" data-toggle="modal" data-target="#product-modal_{$group.id_accessory_group}_{$accessory.id_accessory}">
                              <i class="material-icons zoom-in">&#xE8FF;</i>
                            </div>
                          {/if}
                        </div>
                    </div>
                    {if $accessory_configuration_keys.HSMA_APPLY_FANCYBOX_TO_IMAGE}
                    <div class="modal fade hsma_js-product-images-modal" id="product-modal_{$group.id_accessory_group}_{$accessory.id_accessory}">                    
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-body">
                          <figure>
                              <img class="hsma-js-modal-product-cover hsma-product-cover-modal hsma-product_img_link accessory_img_link" width="{$image_width}"  src="{$accessory.image_fancybox|escape:'htmlall':'UTF-8'}" alt="{$accessory.name|escape:'htmlall':'UTF-8'}" title="{$accessory.name|escape:'htmlall':'UTF-8'}" itemprop="image">
                            <figcaption class="image-caption">
                            {block name='product_description_short'}
                              <div id="product-description-short" itemprop="description">{$accessory.description_short nofilter}</div>
                            {/block}
							</figcaption>
                          </figure>
                          <aside id="thumbnails_{$group.id_accessory_group}_{$accessory.id_accessory}" class="thumbnails js-thumbnails text-xs-center"></aside>
                        </div>
                      </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                  </div><!-- /.modal -->
                  {/if}
                </td>
            {/if}
            <td class="product-quantity price-review">
                    {if $accessory_configuration_keys.HSMA_SHOW_CUSTOM_QUANTITY}
                        <div class="input-group bootstrap-touchspin">

                            <span class="input-group-addon bootstrap-touchspin-prefix" style="display: none;"></span>

							<input class="js-cart-line-product-quantity form-control custom_quantity"
                                    {if !$accessory_configuration_keys.HSMA_ALLOW_CUSTOMER_CHANGE_QTY} disabled="disabled"{/if}
                                   data-custom-quantity="{$accessory.default_quantity|intval}"
                                   type="number"
                                   name="hsma_quantity"
                                   id="quantity_{$group.id_accessory_group|escape:'htmlall':'UTF-8'}_{$accessory.id_accessory|escape:'htmlall':'UTF-8'}"
                                   value="{$accessory.default_quantity|intval}"
                                   min='{$accessory.min_quantity|intval}'
                            />

{*                             <input class="custom_quantity" {if !$accessory_configuration_keys.HSMA_ALLOW_CUSTOMER_CHANGE_QTY} disabled="disabled" {/if} data-custom-quantity="{$accessory.default_quantity|intval}" type="number" name="hsma_quantity" id="quantity_{$group.id_accessory_group|escape:'htmlall':'UTF-8'}_{$accessory.id_accessory|escape:'htmlall':'UTF-8'}" value="{$accessory.default_quantity|intval}" min='{$accessory.min_quantity|intval}'/> *}
                            <span class="input-group-addon bootstrap-touchspin-postfix" style="display: none;"></span>

                            <span class="input-group-btn-vertical">
                                <button class="btn btn-touchspin js-touchspin js-increase-product-quantity bootstrap-touchspin-up" type="button">
                                    <i class="material-icons touchspin-up"></i>
                                </button>
                                <button class="btn btn-touchspin js-touchspin js-decrease-product-quantity bootstrap-touchspin-down" type="button">
                                    <i class="material-icons touchspin-down"></i>
                                </button>
                            </span>
                            

                        </div>
                    {/if}
					
						<a class="ma_accessory_name {if $accessory.combinations}sliding{/if} js-product-miniature quick-view" href="javascript:void(0)" data-link-action="quickview" data-id-product="{$accessory.id_accessory}" title="{$hs_i18n.click_to_view_details|strip_tags:'UTF-8'}">
	                    {$accessory.name|escape:'htmlall':'UTF-8'}
	                    </a>
	                    {if $accessory.combinations}
	                    <div class="button-groups">
	                    	<span class="combination_{$group.id_accessory_group|escape:'htmlall':'UTF-8'}_{$accessory.id_accessory|escape:'htmlall':'UTF-8'}"></span>
	                    	{if $accessory_configuration_keys.HSMA_SHOW_SHORT_DESCRIPTION}
	                        {*<a class="icon-info-sign tooltip accessories-btn" title="{l s='view detail' mod='hsmultiaccessoriespro'}">&nbsp;</a>*}
	                        <div class="tooltipster-content" style="display:none;">
	                            {if $accessory_configuration_keys.HSMA_SHOW_IMAGES}
	                            <img class="accessory_image" src="{$link->getImageLink($accessory.link_rewrite|escape:'htmlall':'UTF-8', $accessory.id_image, {$accessory_image_type})|escape:'html'}" width="45" height="45" title="{$accessory.name|escape:'htmlall':'UTF-8'}" title="{$hs_i18n.click_to_view_details|escape:'html':'UTF-8'}" />
	                            {/if}
	                            {$accessory.description_short|escape:'htmlall':'UTF-8'}{*HTML should be kept. PrestaShop accepts html in back office, therefore there is no result to escape here.*}
	                        </div>
							{/if}
						</div>
						{/if}                    
					{if $accessory.is_available_when_out_of_stock && $accessory_configuration_keys.HSMA_SHOW_ICON_OUT_OF_STOCK}
                        <span class="warning_out_of_stock" title="{$accessory.available_later|escape:'html':'UTF-8'}"></span>
                    {else if $accessory.is_available_for_order && $accessory_configuration_keys.HSMA_SHOW_ICON_OUT_OF_STOCK}
                        <span class="forbidden_ordering" title="{$hs_i18n.out_of_stock|escape:'html':'UTF-8'}"></span>
                    {/if}
                    {include file='module:productcomments/views/templates/hook/accessory-list-reviews.tpl' product=$accessory}
                    
                    <span class="accessory_price">
                        {if $accessory_configuration_keys.HSMA_SHOW_PRICE}
                            {assign var=old_price value=''}
                            {if isset($accessory.cart_rule) && !empty($accessory.cart_rule)}
                                {assign var=old_price value='line_though'}
                            {/if}
                            <span class="{$old_price|escape:'htmlall':'UTF-8'} price_{$group.id_accessory_group|escape:'htmlall':'UTF-8'}_{$accessory.id_accessory|escape:'htmlall':'UTF-8'}"> {Tools::displayPrice($accessory.price)}</span>
                            {if isset($accessory.cart_rule) && !empty($accessory.cart_rule)}
                                <span class="discount_price final_price_{$group.id_accessory_group|escape:'htmlall':'UTF-8'}_{$accessory.id_accessory|escape:'htmlall':'UTF-8'}"> {Tools::displayPrice($accessory.final_price)}</span>
                            {/if}
                        {/if}
                        {if $accessory.customizable}
                            {block name='product_customization'}
                                <span class="hsma_customize_group_{$group.id_accessory_group|intval}">
                                    <a class="hsma_customize accessory_customization_{$accessory.id_accessory|intval}"  data-id_accessory="{$accessory.id_accessory|intval}" data-randomid ="{$accessory.random_product_accessories_id|escape:'htmlall':'UTF-8'}" title="{$hs_i18n.add_customization_data|escape:'htmlall':'UTF-8'}" data-toggle="modal" data-target="#customize-modal_{$group.id_accessory_group}_{$accessory.id_accessory}">
                                        {$hs_i18n.customize|escape:'htmlall':'UTF-8'}
                                        <input type="hidden" name="hsma_id_customization" class="hsma_id_customization" data-isenoughcustomization="{$accessory.is_enough_customization|intval}" value="{$accessory.id_customization|intval}">
                                        <span class="hsma_warning_red {if $accessory.is_enough_customization} hide {/if}" title="{$hs_i18n.please_fill_the_required_custom_fields_to_complete_the_sale|escape:'htmlall':'UTF-8'}"></span>
                                    </a>
                                </span>
                            {/block}
                            <div class="modal fade hsma_js-product-images-modal" id="customize-modal_{$group.id_accessory_group}_{$accessory.id_accessory}">                    
			                    <div class="modal-dialog" role="document">
				                    <div class="modal-content">
					                    <div class="modal-body">
					                    	<div class="card card-block">
										    <h3 class="h4 card-title">{l s='Product customization' d='Shop.Theme.Catalog'}</h3>
										    {l s='Don\'t forget to save your customization to be able to add to cart' d='Shop.Forms.Help'}
										
										      {block name='product_customization_form'}
										        <form method="post" action="{$accessory.link|escape:'htmlall':'UTF-8'}" target="_self" enctype="multipart/form-data">
										          <ul class="clearfix">
										            {foreach from=$accessory.customizations.fields item="field"}
										              <li class="product-customization-item">
										                <label> {$field.label}</label>
										                {if $field.type == 'text'}
										                  <textarea placeholder="{l s='Your message here' d='Shop.Forms.Help'}" class="product-message" maxlength="250" {if $field.required} required {/if} name="{$field.input_name}"></textarea>
										                  <small class="float-xs-right">{l s='250 char. max' d='Shop.Forms.Help'}</small>
										                  {if $field.text !== ''}
										                      <h6 class="customization-message">{l s='Your customization:' d='Shop.Theme.Catalog'}
										                          <label>{$field.text}</label>
										                      </h6>
										                  {/if}
										                {elseif $field.type == 'image'}
										                  {if $field.is_customized}
										                    <br>
										                    <img src="{$field.image.small.url}">
										                    <a class="remove-image" href="{$field.remove_image_url}" rel="nofollow">{l s='Remove Image' d='Shop.Theme.Actions'}</a>
										                  {/if}
										                  <span class="custom-file">
										                    <span class="js-file-name">{l s='No selected file' d='Shop.Forms.Help'}</span>
										                    <input class="file-input js-file-input" {if $field.required} required {/if} type="file" name="{$field.input_name}">
										                    <button class="btn btn-primary">{l s='Choose file' d='Shop.Theme.Actions'}</button>
										                  </span>
										                  <small class="float-xs-right">{l s='.png .jpg .gif' d='Shop.Forms.Help'}</small>
										                {/if}
										              </li>
										            {/foreach}
										          </ul>
										          <div class="clearfix">
										            <button class="btn btn-primary float-xs-right" type="submit" name="submitCustomizedData">{l s='Save Customization' d='Shop.Theme.Actions'}</button>
										          </div>
										        </form>
										      {/block}
										
										    </div>
					                    </div>
				                    </div><!-- /.modal-content -->
								</div><!-- /.modal-dialog -->
							</div><!-- /.modal -->
                        {/if}
                        {if $accessory_configuration_keys.HSMA_EACH_ACCESSORY_TO_BASKET && !$accessory.is_available_for_order && $is_enabling_cart_ajax}
                            <a href="{if $utilize_block_cart_ajax}javascript:void(0);{else}{$urls.pages.cart}&amp;add=1&amp;id_product={$accessory.id_accessory|intval}&amp;token={$static_token}{/if}" title="{$hs_i18n.add_to_cart|escape:'html':'UTF-8'}"  rel="{$urls.pages.cart}" class='hs_multi_accessories_add_to_cart' data-product-group="{$group.id_accessory_group|escape:'htmlall':'UTF-8'}_{$accessory.id_accessory|escape:'htmlall':'UTF-8'}" data-idproduct="{$accessory.id_accessory|intVal}" data-idProductattribute="{if $accessory.id_product_attribute <> 0}{$accessory.id_product_attribute|intVal}{else}{$accessory.default_id_product_attribute|intVal}{/if}"><span></span></a>
                        {/if}
                    </span>
            </td>
        </tr>
    {/foreach}
    {if $group.display_style == HsMaDisplayStyle::RADIO}
        {if $buy_main_accessory_together == HsMaProductSettingAbstract::BUY_TOGETHER_NO || empty($id_products_buy_together[$group.id_accessory_group])}
            <tr class="clearfix">
                <td width="10%">
                    <input type="radio" name="accessories_{$group.id_accessory_group|intval}" class="accessory_item" value="0"/>
                </td>
                {if $accessory_configuration_keys.HSMA_SHOW_IMAGES}
                    <td>&nbsp;</td>
                {/if}
                <td>
                    <span  class="ma_none_option">{$hs_i18n.none|escape:'html':'UTF-8'}</span>
                </td>
            </tr>  
        {/if}
    {/if}
</table>
{* '<pre>{$accessory|@print_r}'</pre>' *}