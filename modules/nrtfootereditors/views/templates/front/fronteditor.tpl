{*
	* 2007-2014 PrestaShop
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
	*  @author    PrestaShop SA <contact@prestashop.com>
	*  @copyright 2007-2014 PrestaShop SA
	*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
	*  International Registered Trademark & Property of PrestaShop SA
	*}
	<script type="text/javascript">
		var module_dir = '{$smarty.const._MODULE_DIR_}';
		var id_language = {$defaultFormLanguage|intval};

		var languages = new Array();

		{foreach $languages as $k => $language}
		languages[{$k}] = {
			id_lang: {$language.id_lang},
			iso_code: '{$language.iso_code}',
			name: '{$language.name}',
			is_default: '{$language.is_default}'
		};
		{/foreach}

	</script>
	<div id="front-actions">

		<input type="hidden" name="submenu-elements" id="submenu-elements" value="{$submenu_content}">

		<div id="column-content-sample" class="hidden">
			{include file="../admin/_configure/helpers/form/column_content.tpl"}
		</div>

		<div id="row-content-sample" class="hidden">
			{include file="../admin/_configure/helpers/form/row_content.tpl"}
		</div>

		<div id="tab-content-sample" class="hidden">
			{include file="../admin/_configure/helpers/form/tab_content.tpl"}
		</div>
	</div>




	<div id="nrtfootereditors" class="block">
		<div id="grid-editors-wrapper" class="preview-d">
			<div class="row grid_editors">
				<div class="col-xs-12 first-rows-wrapper" data-element-id="0">

					{foreach $submenu_content_format as $element name=submenu_content} 
					{include file="../admin/_configure/helpers/form/submenu_content_editor.tpl" node=$element frontEditor=1 f_node=$content_front[$smarty.foreach.submenu_content.index]}               
					{/foreach}

				</div>
				<div id="buttons-sample">
					<div class="action-buttons-container">
						<button type="button" class="btn btn-default add-row-action" ><i class="icon icon-plus"></i> {l s='Row' mod='nrtfootereditors'}</button>
						<button type="button" class="btn btn-default add-column-action" ><i class="icon icon-plus"></i> {l s='Column' mod='nrtfootereditors'}</button>
						<button type="button" class="btn btn-default add-tabs-action" ><i class="icon icon-plus"></i> {l s='Tabs' mod='nrtfootereditors'}</button>
						<button type="button" class="btn btn-default add-tab-action" ><i class="icon icon-plus"></i> {l s='Tab' mod='nrtfootereditors'}</button>
						<button type="button" class="btn btn-default column-content-edit"><i class="icon-pencil"></i> {l s='Content' mod='nrtfootereditors'}</button>
						<button type="button" class="btn btn-default edit-row-action" ><i class="icon icon-wrench"></i>{l s='Edit' mod='nrtfootereditors'}</button>
						<button type="button" class="btn btn-danger remove-element-action" ><i class="icon-trash"></i>{l s='Delete' mod='nrtfootereditors'} </button>
					</div>
					<div class="dragger-handle btn btn-danger"><i class="icon-arrows "></i> <span class="row-dragger-txt">{l s='Row' mod='nrtfootereditors'}</span><span class="col-dragger-txt">{l s='Column' mod='nrtfootereditors'}</span></div>
				</div>
			</div>
		</div>





	</div>

