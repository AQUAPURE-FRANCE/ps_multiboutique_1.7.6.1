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





	

			<div class="width-selector-wrapper">
			<span class="width-indicatior action_click"><i class="icon icon-arrows-h"></i></span>
			<div class="content_click">
            <div class="col-select">
			<i class="icon icon-mobile"></i>
			<select class="select-column-width-p">
				{for $i=1 to 12}
				<option value="{$i}" {if isset($node.width_p)}{if $node.width_p==$i}selected{/if}{else}{if $i==12}selected{/if}{/if}>{$i}/12</option>
				{/for}
				<option value="13" {if isset($node.width_p)}{if $node.width_p==13}selected{/if}{/if}>{l s='Hidden' mod='nrtfootereditors'}</option>
			</select>
			</div>
		<div class="col-select">
			<i class="icon icon-tablet"></i>
			<select class="select-column-width-t">
				{for $i=1 to 12}
				<option value="{$i}" {if isset($node.width_t)}{if $node.width_t==$i}selected{/if}{else}{if $i==12}selected{/if}{/if}>{$i}/12</option>
				{/for}
				<option value="13" {if isset($node.width_t)}{if $node.width_t==13}selected{/if}{/if}>{l s='Hidden' mod='nrtfootereditors'}</option>
			</select>
		</div>
		<div class="col-select">
			<i class="icon icon-desktop"></i>
			<select class="select-column-width-d">
				{for $i=1 to 12}
				<option value="{$i}" {if isset($node.width_d)}{if $node.width_d==$i}selected{/if}{else}{if $i==12}selected{/if}{/if}>{$i}/12</option>
				{/for}
				<option value="13" {if isset($node.width_d)}{if $node.width_d==13}selected{/if}{/if}>{l s='Hidden' mod='nrtfootereditors'}</option>
			</select>
		</div>
		</div>
		</div>
	
		<p class="column-content-info">{l s='Empty' mod='nrtfootereditors'}</p>

		{if isset($node)}
			{include file="./column_content_modal.tpl" node=$node}
		{else}
			{include file="./column_content_modal.tpl"}
		{/if}

