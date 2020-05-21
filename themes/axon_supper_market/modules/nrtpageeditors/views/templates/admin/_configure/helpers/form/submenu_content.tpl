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


	{if $node.type==1}
	<div data-element-type="1" data-depth="{$node.depth}" data-element-id="{$node.elementId}" class="row menu_row menu_row_element menu-element {if $node.depth==0} first_rows{/if} menu-element-id-{$node.elementId}">
		{include file="./row_content.tpl" node=$node}
		{elseif $node.type==3}
		<div data-element-type="3" data-depth="{$node.depth}" data-element-id="{$node.elementId}" class="row menu_row menu_tabe menu_row_element menu-element menu-element-id-{$node.elementId}">
		{include file="./tab_content.tpl" node=$node}

		{elseif $node.type==2}
		<div data-element-type="2" data-depth="{$node.depth}" data-width-p="{$node.width_p}" data-width-t="{$node.width_t}" data-width-d="{$node.width_d}" data-contenttype="{$node.contentType}" data-element-id="{$node.elementId}" class="{if $node.width_p==13}phone-hidden{else}editors-col-xs-{$node.width_p}{/if} {if $node.width_t==13}tablet-hidden{else}editors-col-sm-{$node.width_t}{/if} {if $node.width_d==13}desktop-hidden{else}editors-col-md-{$node.width_d}{/if} menu_column menu-element menu-element-id-{$node.elementId}">
		{elseif $node.type==4}
		<div data-element-type="4" data-depth="{$node.depth}" data-width-p="{$node.width_p}" data-width-t="{$node.width_t}" data-width-d="{$node.width_d}" data-contenttype="{$node.contentType}" data-element-id="{$node.elementId}" class="{if $node.width_p==13}phone-hidden{else}editors-col-xs-{$node.width_p}{/if} {if $node.width_t==13}tablet-hidden{else}editors-col-sm-{$node.width_t}{/if} {if $node.width_d==13}desktop-hidden{else}editors-col-md-{$node.width_d}{/if} menu_column menu_tabs menu-element menu-element-id-{$node.elementId}">
			{/if}
			<div class="action_click">
            <i class="icon icon-wrench"></i>
            </div>
			<div class="action-buttons-container content_click">
				<button type="button" class="add-row-action" >{l s='Add Row' mod='nrtpageeditors'}</button>
				<button type="button" class="add-column-action" >{l s='Add Column' mod='nrtpageeditors'}</button>
				<button type="button" class="add-tabs-action" >{l s='Add Tabs' mod='nrtpageeditors'}</button>
				<button type="button" class="add-tab-action" >{l s='Add Tab' mod='nrtpageeditors'}</button>
				<button type="button" class="column-content-edit">{l s='Content' mod='nrtpageeditors'}</button>
				<button type="button" class="duplicate-element-action" >{l s='Duplicate' mod='nrtpageeditors'}</button>
				<button type="button" class="edit-row-action" >{l s='Edit' mod='nrtpageeditors'}</button>
				<button type="button" class="remove-element-action" >{l s='Delete' mod='nrtpageeditors'} </button>
			</div>
            
			<div class="dragger-handle btn btn-danger"><i class="icon-arrows "></i></a> {if $node.type==1}{l s='Row' mod='nrtpageeditors'}{elseif $node.type==2}{l s='Column' mod='nrtpageeditors'} {elseif $node.type==3}{l s='Tab' mod='nrtpageeditors'} {elseif $node.type==4}{l s='Tabs' mod='nrtpageeditors'}{/if}</div>

			{if $node.type == 2 || $node.type == 4}
				{include file="./column_content.tpl" node=$node frontEditor=$frontEditor}
			{/if}

			
			{if $node.type==4}
				
				<ul class="nav nav-tabs nav-tabs-sortable">
				{if isset($node.children) && $node.children|@count > 0}
					{foreach from=$node.children item=child name=categoryTreeBranch}
						{if $child.type==3}
							<li data-element-id="{$child.elementId}" data-element-type="3" class="nrtcontent-tab-li nrtcontent-tab-li-id-{$child.elementId}  {if $smarty.foreach.categoryTreeBranch.first} active{/if}"><a href="#nrtcontent-tab-id-{$child.elementId}"  data-toggle="tab">{foreach from=$languages item=language}
								{if $languages|count > 1}
								<span class="translatable-field lang-{$language.id_lang} langtab-{$language.id_lang}-{$child.elementId}" {if $language.id_lang != $defaultFormLanguage}style="display:none"{/if}>
								{/if}
									{if isset($child.tabtitle[$language.id_lang]) && $child.tabtitle[$language.id_lang] !=''}{$child.tabtitle[$language.id_lang]|html_entity_decode}{else}Tab {$child.elementId}{/if}
									{if $languages|count > 1}
								</span>
								{/if}
								{/foreach} <span class="dragger-handle-tab"><i class="icon-arrows "></i></span></a>

								</li> 
						{/if} 	
					{/foreach}
				{/if}
 				</ul>

 				<div class="tab-content">
				{if isset($node.children) && $node.children|@count > 0}
					{foreach from=$node.children item=child name=categoryTreeBranch}
						{if $child.type==3}
							<div id="nrtcontent-tab-id-{$child.elementId}"  class="tab-pane  {if $smarty.foreach.categoryTreeBranch.first} active {/if}nrtcontent-element-id-{$child.elementId}">{include file="./submenu_content.tpl" node=$child frontEditor=$frontEditor}</div>
						{/if} 	
					{/foreach}
				{/if}
				</div> 

			{else}

				{if isset($node.children) && $node.children|@count > 0}
					{foreach from=$node.children item=child name=categoryTreeBranch}
						{include file="./submenu_content.tpl" node=$child frontEditor=$frontEditor}
					{/foreach}
				{/if}

			{/if}


		</div>
