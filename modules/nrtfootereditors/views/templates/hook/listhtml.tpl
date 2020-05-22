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
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2014 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<div class="panel">

		<a id="desc-product-new" href="{$link->getAdminLink('AdminModules')}&configure=nrtfootereditors&addCustomHtml=1">
        	<span style="display:inline-block;">
			<i class="process-icon-new "></i>
            {l s='ADD NEW' mod='nrtfootereditors'}
            </span>
		</a>
		<h3></h3>
	<div id="tabsContent">
        <div class="table-responsive-row clearfix"> 
        <table class="table table-bordered table-striped">
        <thead> 
            <tr class="nodrag nodrop"> 
                <th style="text-align:center">{l s='Id' mod='nrtfootereditors'}</th> 
                <th style="text-align:center">{l s='Name' mod='nrtfootereditors'}</th>
                <th></th> 
            </tr> 
        </thead> 
        <tbody> 
        {foreach from=$tabs item=tab}
        <tr id="tabs_{$tab.id_html}"> 
            <td style="text-align:center">{$tab.id_html}</td> 
            <td style="text-align:center">{$tab.title}</td>
            <td style="text-align:right"><a class="btn btn-default"
                href="{$link->getAdminLink('AdminModules')}&configure=nrtfootereditors&id_html={$tab.id_html}">
                <i class="icon-edit"></i>
                {l s='Edit' mod='nrtfootereditors'}
                </a>
                <a class="btn btn-danger"
                href="{$link->getAdminLink('AdminModules')}&configure=nrtfootereditors&delete_id_html={$tab.id_html}">
                <i class="icon-trash"></i>
                {l s='Delete' mod='nrtfootereditors'}
                </a>
           </td>
        </tr> 
        {/foreach}
        </tbody> 
        </table> 
        </div>
	</div>
</div>