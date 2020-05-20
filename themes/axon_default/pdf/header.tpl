{**
 * 2007-2017 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
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
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *}
	
<table style="border-bottom: 2px solid #e6e6e6; width:100%;">
	<tr>
		<td style="width: 30%">
			{if $logo_path}
			<img style="height: 30px" src="{$logo_path}"/>
			{/if}
		</td>
		<td rowspan="2" style="width: 70%; vertical-align: bottom; text-align: right">
			<img style="height: 55px;" src="{$stick_logo}"/>
		</td>
	</tr>
	<tr style= "width: 100%">
		<td style="font-family: 'OpenSans-Light'; font-size: 20pt; color: #6b7579; width:100%;">{if isset($header)}{$header|escape:'html':'UTF-8'|upper}{/if} {$title|escape:'html':'UTF-8'} <span style="font-size: 12pt; font-style: italic; ">{l s='established' d='Shop.Pdf' pdf='true'} {$date|escape:'html':'UTF-8'}</span>
		</td>
	</tr>
</table>

