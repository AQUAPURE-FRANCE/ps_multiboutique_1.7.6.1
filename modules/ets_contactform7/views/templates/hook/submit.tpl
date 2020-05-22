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
<div id="tag-generator-panel-submit" class="hidden">
    <form action="" class="tag-generator-panel" data-id="submit"><div class="control-box">
        <fieldset>
        <legend>{l s='Generate a form-tag for a submit button. For more details, see' mod='ets_contactform7'} <a href="{$link_basic|escape:'html':'UTF-8'}/modules/ets_contactform7/help/index.html#!/submit-button" target="_blank">{l s='Submit Button' mod='ets_contactform7'}</a>.</legend>
        <table class="form-table">
        <tbody>
        	<tr>
        	<th scope="row"><label for="tag-generator-panel-submit-values">{l s='Label' mod='ets_contactform7'}</label></th>
        	<td><input type="text" name="values" class="oneline" id="tag-generator-panel-submit-values" /></td>
        	</tr>
        	<tr>
        	<th scope="row"><label for="tag-generator-panel-submit-id">{l s='Id attribute' mod='ets_contactform7'}</label></th>
        	<td><input type="text" name="id" class="idvalue oneline option" id="tag-generator-panel-submit-id" /></td>
        	</tr>
        	<tr>
        	<th scope="row"><label for="tag-generator-panel-submit-class">{l s='Class attribute' mod='ets_contactform7'}</label></th>
        	<td><input type="text" name="class" class="classvalue oneline option" id="tag-generator-panel-submit-class" /></td>
        	</tr>
        </tbody>
        </table>
        </fieldset>
        </div>
        <div class="insert-box">
        	<input type="text" name="submit" class="tag code" readonly="readonly" onfocus="this.select()" />
        	<div class="submitbox">
        	<input type="button" class="button button-primary insert-tag" value="{l s='Insert Tag' mod='ets_contactform7'}" />
        	</div>
        </div>
    </form>
</div>