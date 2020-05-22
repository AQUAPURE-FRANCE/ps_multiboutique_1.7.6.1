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
<div id="tag-generator-panel-date" class="hidden">
    <form action="" class="tag-generator-panel" data-id="date"><div class="control-box">
        <fieldset>
        <legend>{l s='Generate a form-tag for a date input field. For more details, see' mod='ets_contactform7'} <a href="{$link_basic|escape:'html':'UTF-8'}/modules/ets_contactform7/help/index.html#!/date-field" target="_blank">{l s='Date Field' mod='ets_contactform7'}</a>.</legend>
        <table class="form-table">
        <tbody>
        	<tr>
        	<th scope="row">{l s='Field type' mod='ets_contactform7'}</th>
        	<td>
        		<fieldset>
        		
        		<label><input type="checkbox" name="required" />{l s='Required field' mod='ets_contactform7'}</label>
        		</fieldset>
        	</td>
        	</tr>
        	<tr>
        	<th scope="row"><label for="tag-generator-panel-date-name">{l s='Name' mod='ets_contactform7'}</label></th>
        	<td><input type="text" name="name" class="tg-name oneline" id="tag-generator-panel-date-name" /></td>
        	</tr>
        	<tr>
        	<th scope="row"><label for="tag-generator-panel-date-values">{l s='Default value' mod='ets_contactform7'}</label></th>
        	<td><input type="text" name="values" class="oneline" id="tag-generator-panel-date-values" /><br />
        	<label><input type="checkbox" name="placeholder" class="option" />{l s='Use this text as the placeholder of the field' mod='ets_contactform7'}</label>
            <label><input type="checkbox" name="time" class="option" />{l s='Allow customer select time "hour and minute"' mod='ets_contactform7'}</label>
            </td>
        	</tr>
        	<tr>
        	<th scope="row"><label for="tag-generator-panel-date-id">{l s='Id attribute' mod='ets_contactform7'}</label></th>
        	<td><input type="text" name="id" class="idvalue oneline option" id="tag-generator-panel-date-id" /></td>
        	</tr>
        	<tr>
        	<th scope="row"><label for="tag-generator-panel-date-class">{l s='Class attribute' mod='ets_contactform7'}</label></th>
        	<td><input type="text" name="class" class="classvalue oneline option" id="tag-generator-panel-date-class" /></td>
        	</tr>
        </tbody>
        </table>
        </fieldset>
        </div>
        <div class="insert-box">
        	<input type="text" name="date" class="tag code" readonly="readonly" onfocus="this.select()" />
        	<div class="submitbox">
        	   <input type="button" class="button button-primary insert-tag" value="{l s='Insert Tag' mod='ets_contactform7'}" />
        	</div>
        	<br class="clear" />
        	<p class="description mail-tag"><label for="tag-generator-panel-date-mailtag">{l s='To use the value input through this field in a mail field, you need to insert the corresponding mail-tag' mod='ets_contactform7'} (<strong><span class="mail-tag"></span></strong>) {l s='into the field on the Mail tab.' mod='ets_contactform7'}.<input type="text" class="mail-tag code hidden" readonly="readonly" id="tag-generator-panel-date-mailtag" /></label></p>
        </div>
    </form>
</div>