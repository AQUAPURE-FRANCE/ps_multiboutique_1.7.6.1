{*
* 2007-2018 ETS-Soft
*
* NOTICE OF LICENSE
*
* This file is not open source! Each license that you purchased is only available for 1 wesite only.
* If you want to use this file on more websites (or projects), you need to purchase additional licenses.
* You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please, contact us for extra customization service at an affordable price
*
*  @author ETS-Soft <etssoft.jsc@gmail.com>
*  @copyright  2007-2018 ETS-Soft
*  @license    Valid for 1 website (or project) for each purchase of license
*  International Registered Trademark & Property of ETS-Soft
*}
<span class="wpcf7-form-control-wrap {$html_class|escape:'html':'UTF-8'}">
<span class="custom_choosefile">
<input
    {foreach from=$atts key='key' item='item'}
        {if $item}
            {$key|escape:'html':'UTF-8'}="{$item|escape:'html':'UTF-8'}"
        {/if}
    {/foreach}
 />
 <span class="button_choosefile">{l s='Choose file' mod='ets_contactform7'}</span>
 </span>
{$validation_error|escape:'html':'UTF-8'}
{if $type_file || $limit_zie}
    <span class="file_type_des">{if $limit_zie}{l s='Limit size:' mod='ets_contactform7'}&nbsp;{$limit_zie|escape:'html':'UTF-8'}{/if}{if $type_file}&nbsp;{l s='Type files:' mod='ets_contactform7'}&nbsp;{$type_file|escape:'html':'UTF-8'}{/if}</span>
{/if}
</span>