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
<li>
    <span class="content-reply">
        <b>{l s='Reply' mod='ets_contactform7'}&nbsp;{$countReply|intval}:&nbsp;</b>{$reply->content|strip_tags:'UTF-8'|truncate:150:'...'}
    </span>
    <span class="content-reply-full">
        <p>
            <b>{l s='Reply to:' mod='ets_contactform7'}</b>&nbsp;{$reply->reply_to|escape:'html':'UTF-8'} {$reply->date_add|escape:'html':'UTF-8'}
        </p>
        <p>
            <b>{l s='Subject:' mod='ets_contactform7'}</b>&nbsp;{$reply->subject|escape:'html':'UTF-8'}
        </p>
        <p class="content-message">
            <b>{l s='Content:' mod='ets_contactform7'}</b>&nbsp;{$reply->content nofilter}
        </p>
    </span>
</li>