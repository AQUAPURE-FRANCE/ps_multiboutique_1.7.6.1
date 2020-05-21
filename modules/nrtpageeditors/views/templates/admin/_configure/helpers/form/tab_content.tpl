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



	<div class="menu-tab-content">
		
		<div class="form-group">
			<label class="control-label">
				{l s='Tab title' mod='nrtpageeditors'}
			</label>
			
			
			{foreach from=$languages item=language}
			{if $languages|count > 1}
			<div class="translatable-field lang-{$language.id_lang}" {if $language.id_lang != $defaultFormLanguage}style="display:none"{/if}>
				{/if}
				<div class="tabinliner">
                    <textarea class="tabtitle tabtitle-{$language.id_lang}">{if isset($node.tabtitle[$language.id_lang])}{$node.tabtitle[$language.id_lang] nofilter}{/if}</textarea>
				</div>
				{if $languages|count > 1}
				<div class="tabinliner">
					<button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
						{$language.iso_code}
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu">
						{foreach from=$languages item=lang}
						<li><a href="javascript:hideOtherLanguage({$lang.id_lang});" tabindex="-1">{$lang.name}</a></li>
						{/foreach}
					</ul>
				</div>
				{/if}
				{if $languages|count > 1}
			</div>
			{/if}
			{/foreach}
		</div>
	</div>	






