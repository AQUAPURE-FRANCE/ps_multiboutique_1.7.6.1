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
	<div data-element-type="1" data-depth="{$node.depth}" data-element-id="{$node.elementId}" class="row menu_row {if !isset($node.row_s.bgw)} menu_row_element {/if} menu-element nrtfootcontent_row nrtfootcontent-element {if $node.depth==0} first_rows{/if} nrtfootcontent-element-id-{$node.elementId} {if isset($node.row_s.prlx) && $node.row_s.prlx}parallax-row{/if} menu-element-id-{$node.elementId}">
		<div class="action-buttons-container">
			<button type="button" class="btn btn-default add-row-action" ><i class="icon icon-plus"></i> {l s='Row' mod='nrtfootereditors'}</button>
			<button type="button" class="btn btn-default add-column-action" >{l s='Add Column' mod='nrtfootereditors'}</button>
			<button type="button" class="btn btn-default add-tabs-action" ><i class="icon icon-plus"></i> {l s='Tabs' mod='nrtfootereditors'}</button>
			<button type="button" class="btn btn-default add-tab-action" ><i class="icon icon-plus"></i> {l s='Tab' mod='nrtfootereditors'}</button>
			<button type="button" class="btn btn-default column-content-edit"><i class="icon-pencil"></i> {l s='Content' mod='nrtfootereditors'}</button>
			<button type="button" class="btn btn-default duplicate-element-action" ><i class="icon icon-files-o"></i>{l s='Duplicate' mod='nrtfootereditors'} </button>
			<button type="button" class="btn btn-default edit-row-action" ><i class="icon icon-wrench"></i>{l s='Edit' mod='nrtfootereditors'}</button>
			<button type="button" class="btn btn-danger remove-element-action" ><i class="icon-trash"></i> {l s='Delete' mod='nrtfootereditors'}</button>
		</div>
		<div class="dragger-handle btn btn-danger"><i class="icon-arrows "></i>	{if $node.type==1}{l s='Row' mod='nrtfootereditors'}{elseif $node.type==2}{l s='Column' mod='nrtfootereditors'}{/if}</div>
		{if isset($node.row_s.bgw) && $node.row_s.bgw}<div class="nrt-fullwidth menu_row_element clearfix ">{/if} 
		{include file="./row_content.tpl" node=$node}
		{elseif $node.type==3}
		<div data-element-type="3" data-depth="{$node.depth}" data-element-id="{$node.elementId}" class="row menu_row menu_tabe menu_row_element menu-element menu-element-id-{$node.elementId}">
			{include file="./tab_content.tpl" node=$node}


			{elseif $node.type==4}
		<div data-element-type="4" data-depth="{$node.depth}" data-width-p="{$node.width_p}" data-width-t="{$node.width_t}" data-width-d="{$node.width_d}" data-contenttype="{$node.contentType}" data-element-id="{$node.elementId}" class="
		{if $node.width_p==13}hidden-xs{else}col-xs-{$node.width_p}{/if} {if $node.width_t==13}hidden-sm{else}col-sm-{$node.width_t}{/if} {if $node.width_d==13}hidden-md hidden-lg{else}col-md-{$node.width_d}{/if} nrtfootcontent-column nrtfootcontent-element  menu_column menu_tabs menu-element menu-element-id-{$node.elementId} clearfix">

			{elseif $node.type==2}
			<div data-element-type="2" data-depth="{$node.depth}" data-width-p="{$node.width_p}" data-width-t="{$node.width_t}" data-width-d="{$node.width_d}" data-contenttype="{$node.contentType}" data-element-id="{$node.elementId}"  
			class="{if $node.width_p==13}hidden-xs{else}col-xs-{$node.width_p}{/if} {if $node.width_t==13}hidden-sm{else}col-sm-{$node.width_t}{/if} {if $node.width_d==13}hidden-md hidden-lg{else}col-md-{$node.width_d}{/if} nrtfootcontent-column nrtfootcontent-element  {if $node.contentType==0}empty-column{/if} menu_column menu-element menu-element-id-{$node.elementId} clearfix" >
			
			{/if}

			{if $node.type==2 || $node.type == 4 || $node.type == 3}

			<div class="action-buttons-container">
				<button type="button" class="btn btn-default add-row-action" >{l s='Add Row' mod='nrtfootereditors'}</button>
				<button type="button" class="btn btn-default add-column-action" >{l s='Add Column' mod='nrtfootereditors'}</button>
				<button type="button" class="btn btn-default add-tabs-action" ><i class="icon icon-plus"></i> {l s='Tabs' mod='nrtfootereditors'}</button>
				<button type="button" class="btn btn-default add-tab-action" ><i class="icon icon-plus"></i> {l s='Tab' mod='nrtfootereditors'}</button>
				<button type="button" class="btn btn-default column-content-edit"><i class="icon-pencil"></i> {l s='Content' mod='nrtfootereditors'}</button>
				<button type="button" class="btn btn-default duplicate-element-action" ><i class="icon icon-files-o"></i> {l s='Duplicate' mod='nrtfootereditors'}</button>
				<button type="button" class="btn btn-default edit-row-action" ><i class="icon icon-wrench"></i>{l s='Edit' mod='nrtfootereditors'}</button>
				<button type="button" class="btn btn-danger remove-element-action" ><i class="icon-trash"></i>{l s='Delete' mod='nrtfootereditors'} </button>
			</div>
			<div class="dragger-handle btn btn-danger"><i class="icon-arrows "></i>	{if $node.type==1}{l s='Row' mod='nrtfootereditors'}{elseif $node.type==2}{l s='Column' mod='nrtfootereditors'} {elseif $node.type==3}{l s='Tab' mod='nrtfootereditors'} {elseif $node.type==4}{l s='Tabs' mod='nrtfootereditors'}{/if}</div>

			{/if}

			{if $node.type==2 || $node.type == 4}

				<div class="nrtfootcontent-element-id-{$node.elementId} nrtfootcontent-element-id">
				<div class="nrtfootcontent-column-inner {if isset($node.content_s.title)}nrtcolumn-have-title{/if} {if isset($node.content_s.title_bg)}nrtcolumn-title-bg{/if} {if isset($node.content.ar) && $node.content.ar == 1}alternative-slick-arrows{/if}">
				{include file="./column_content_editor.tpl" node=$node frontEditor=$frontEditor f_node=$f_node} 
			
			{/if}

			{if $node.type==4}
				<ul class="nav nav-tabs">
				{if isset($node.children) && $node.children|@count > 0}
					{foreach from=$node.children item=child name=categoryTreeBranch}
						{if $child.type==3}
							
							<li class="nrtfootcontent-tab-li-id-{$child.elementId} {if $smarty.foreach.categoryTreeBranch.first} active{/if}"><a href="#nrtfootcontent-tab-id-{$child.elementId}"  data-toggle="tab">
								{foreach from=$languages item=language}
								{if $languages|count > 1}
								<span class="translatable-field lang-{$language.id_lang} langtab-{$language.id_lang}-{$child.elementId}" {if $language.id_lang != $defaultFormLanguage}style="display:none"{/if}>
								{/if}
									{if isset($child.tabtitle[$language.id_lang]) && $child.tabtitle[$language.id_lang] !=''}{$child.tabtitle[$language.id_lang]}{else}Tab {$child.elementId}{/if}
									{if $languages|count > 1}
								</span>
								{/if}
								{/foreach}
							</a>
							</li> 
							
						{/if} 	
					{/foreach}
					</ul>
				{/if}
				 <div class="tab-content">
				{if isset($node.children) && $node.children|@count > 0}
					{foreach from=$node.children item=child name=categoryTreeBranch}
						{if $child.type==3}
							
							<div id="nrtfootcontent-tab-id-{$child.elementId}" class="tab-pane  {if $smarty.foreach.categoryTreeBranch.first} active {/if}nrtfootcontent-element-id-{$child.elementId}">{include file="./submenu_content_editor.tpl" node=$child frontEditor=$frontEditor f_node=$f_node.children[$smarty.foreach.categoryTreeBranch.index]}</div>
							
						{/if} 	
					{/foreach}
				{/if}
				</div>

			{else}

				{if isset($node.children) && $node.children|@count > 0}
					{foreach from=$node.children item=child name=categoryTreeBranch}
						{include file="./submenu_content_editor.tpl" node=$child frontEditor=$frontEditor f_node=$f_node.children[$smarty.foreach.categoryTreeBranch.index]}
					{/foreach}
				{/if}

			{/if}

					{if $node.type==2 || $node.type==4}</div></div>{/if}	
					{if isset($node.row_s.bgw) && $node.row_s.bgw}</div>{/if}

			</div>
