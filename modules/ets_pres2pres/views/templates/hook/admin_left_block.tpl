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
* needs, please contact us for extra customization service at an affordable price
*
*  @author ETS-Soft <etssoft.jsc@gmail.com>
*  @copyright  2007-2019 ETS-Soft
*  @license    Valid for 1 website (or project) for each purchase of license
*  International Registered Trademark & Property of ETS-Soft
*}
<script type="text/javascript" src="{$dir_path|escape:'quotes':'UTF-8'}views/js/jquery.form.js"></script>
<script type="text/javascript" src="{$dir_path|escape:'quotes':'UTF-8'}views/js/pres2pres.admin.js"></script>
<script type="text/javascript" src="{$dir_path|escape:'quotes':'UTF-8'}views/js/easytimer.min.js"></script>
<link type="text/css" rel="stylesheet" href="{$dir_path|escape:'quotes':'UTF-8'}views/css/pres2pres.admin.css" />
<link type="text/css" rel="stylesheet" href="{$dir_path|escape:'quotes':'UTF-8'}views/css/font-awesome.css" />
<link type="text/css" rel="stylesheet" href="{$dir_path|escape:'quotes':'UTF-8'}views/css/fic14.css" />
{if $tabmodule=='general'}
    <div class="dtm-left-block">
        <ul>
            <li{if $tabmodule=='import'} class="active"{/if}>
                <a href="index.php?tab=AdminModules&configure=ets_pres2pres&token={$token|escape:'html':'UTF-8'}&tab_module=front_office_features&module_name=ets_pres2pres&tabmodule=import">
                    <span class="dtm_tab_content"><i class="fa fa-cloud-upload"> </i> {l s='Migration' mod='ets_pres2pres'}</span>
                    <span>{l s="Migrate old versions of Prestashop to Prestashop 1.7 (latest version)" mod='ets_pres2pres'}</span>
                </a>
            </li>
            <li{if $tabmodule=='history'} class="active"{/if}>
                <a href="index.php?tab=AdminModules&configure=ets_pres2pres&token={$token|escape:'html':'UTF-8'}&tab_module=front_office_features&module_name=ets_pres2pres&tabmodule=history">
                    <span class="dtm_tab_content"><i class="fa fa-history"> </i> {l s='History' mod='ets_pres2pres'}</span>
                    <span>{l s='A detail list of all past migrations, allow you to resume or restart migration' mod='ets_pres2pres'}</span>
                </a>
            </li>
            <li{if $tabmodule=='clear_up'} class="active"{/if}>
                <a href="index.php?tab=AdminModules&configure=ets_pres2pres&token={$token|escape:'html':'UTF-8'}&tab_module=front_office_features&module_name=ets_pres2pres&tabmodule=clear_up">
                    <span class="dtm_tab_content"><i class="fa fa-eraser"> </i> {l s='Clean-up' mod='ets_pres2pres'}</span>
                    <span>{l s='Clear migration history to release server disk space' mod='ets_pres2pres'}</span>
                </a>
            </li>
            <li{if $tabmodule=='help'} class="active"{/if}>
                <a href="index.php?tab=AdminModules&configure=ets_pres2pres&token={$token|escape:'html':'UTF-8'}&tab_module=front_office_features&module_name=ets_pres2pres&tabmodule=help">
                    <span class="dtm_tab_content"><i class="fa fa-question-circle"> </i> {l s='Help' mod='ets_pres2pres'}</span>
                    <span>{l s='Quick guide to migrate your site to Prestashop 1.7' mod='ets_pres2pres'}</span>
                </a>
            </li>
        </ul>
    </div>
{else}
    <div class="breadcrum_migrate-left-block">
        <ul>
            <li{if $tabmodule=='import'} class="active"{/if}>
                <a href="index.php?tab=AdminModules&configure=ets_pres2pres&token={$token|escape:'html':'UTF-8'}&tab_module=front_office_features&module_name=ets_pres2pres&tabmodule=import">
                    <span class="dtm_tab_content"><i class="fa fa-cloud-upload"> </i> {l s='Migration' mod='ets_pres2pres'}</span>
                </a>
            </li>
            <li{if $tabmodule=='history'} class="active"{/if}>
                <a href="index.php?tab=AdminModules&configure=ets_pres2pres&token={$token|escape:'html':'UTF-8'}&tab_module=front_office_features&module_name=ets_pres2pres&tabmodule=history">
                    <span class="dtm_tab_content"><i class="fa fa-history"> </i> {l s='History' mod='ets_pres2pres'}</span>
                </a>
            </li>
            <li{if $tabmodule=='clear_up'} class="active"{/if}>
                <a href="index.php?tab=AdminModules&configure=ets_pres2pres&token={$token|escape:'html':'UTF-8'}&tab_module=front_office_features&module_name=ets_pres2pres&tabmodule=clear_up">
                    <span class="dtm_tab_content"><i class="fa fa-eraser"> </i> {l s='Clean-up' mod='ets_pres2pres'}</span>
                </a>
            </li>
            <li{if $tabmodule=='help'} class="active"{/if}>
                <a href="index.php?tab=AdminModules&configure=ets_pres2pres&token={$token|escape:'html':'UTF-8'}&tab_module=front_office_features&module_name=ets_pres2pres&tabmodule=help">
                    <span class="dtm_tab_content"><i class="fa fa-question-circle"> </i> {l s='Help' mod='ets_pres2pres'}</span>
                </a>
            </li>
        </ul>
    </div>
{/if}