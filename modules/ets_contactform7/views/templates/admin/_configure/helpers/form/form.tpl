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
*  @copyright  2007-2018 ETS-Soft
*  @license    Valid for 1 website (or project) for each purchase of license
*  International Registered Trademark & Property of ETS-Soft
*}
{extends file="helpers/form/form.tpl"}
{block name="fieldset"}
<input type="hidden" name="current_tab" value="{if isset($smarty.get.current_tab)}{$smarty.get.current_tab|escape:'html':'UTF-8'}{else}{if isset($smarty.post.current_tab)}{$smarty.post.current_tab|escape:'html':'UTF-8'}{/if}{/if}" />
{$smarty.block.parent}
{/block}
{block name="label"}
	{if $ps15}
        {if $input.name=='ETS_CTF7_ENABLE_RECAPTCHA'}
            <div class="ets_form_tab_header">
                <span class="active" data-tab="other_setting">{l s='Global settings' mod='ets_contactform7'}</span>
                <span class="" data-tab="google">{l s='reCAPTCHA' mod='ets_contactform7'}</span>
                <span class="" data-tab="black_list">{l s='IP blacklist' mod='ets_contactform7'}</span>
            </div>
            <div class="form-group-wapper">
            <div class="form-group form_group_contact google">
                <div class="col-lg-3">&nbsp;</div>
                <div class="col-lg-9 ">
                    <p class="alert alert-info">
                        <a target="_blank" href="https://www.google.com/recaptcha/intro/index.html">{l s='Google reCAPTCHA ' mod='ets_contactform7'}</a>{l s='is a free service to protect your website from spam and abuse' mod='ets_contactform7'}<br />
                        {l s='To use reCAPTCHA, you need to install an API key pair' mod='ets_contactform7'}<br />
                        {l s='For more details, see' mod='ets_contactform7'} <a target="_blank" href="{$link_basic|escape:'html':'UTF-8'}/modules/ets_contactform7/help/index.html#!/recaptcha">{l s='reCAPTCHA' mod='ets_contactform7'}</a>
                    </p>
                </div>
            </div>
        {/if}
        {if $input.name=='title'}
        <div class="ets_form_tab_header">
                <span class="active" data-tab="form">{l s='Form' mod='ets_contactform7'}</span>
                <span class="" data-tab="mail">{l s='Mail' mod='ets_contactform7'}</span>
                <span class="" data-tab="message">{l s='Messages' mod='ets_contactform7'}</span>
                <span class="" data-tab="seo">{l s='Seo' mod='ets_contactform7'}</span>
                <span class="" data-tab="general_settings">{l s='Settings' mod='ets_contactform7'}</span>
        </div>
        <div class="form-group-wapper">
        {/if}
        {if $input.name=='email_to'}
            <div class="form-group form_group_contact mail">
                <div class="col-lg-3">&nbsp;</div>
                <div class="col-lg-9 ">
                    <p class="alert alert-info">
                    {l s='You can edit the mail template here. For details, see' mod='ets_contactform7'} <a target="_blank" href="{$link_basic|escape:'html':'UTF-8'}/modules/ets_contactform7/help/index.html#!/create">{l s='Create your first contact form' mod='ets_contactform7'}</a>.<br />{l s='In the following fields, you can use mail-tags such as' mod='ets_contactform7'}:<span class="ets_ctf7_tag_shortcode"><span class="mailtag code used">[your-name]</span><span class="mailtag code used">[your-email]</span><span class="mailtag code used">[your-subject]</span><span class="mailtag code used">[your-message]</span></span>
                    </p>
                </div>
            </div>
        {/if}
        {if $input.name=='email_to2'}
            <div class="form-group form_group_contact mail mail2">
                <div class="col-lg-3">&nbsp;</div>
                <div class="col-lg-9">
                    <p class="alert alert-info">
                        {l s='You can edit the mail template here. For details, see' mod='ets_contactform7'} <a target="_blank" href="{$link_basic|escape:'html':'UTF-8'}/modules/ets_contactform7/help/index.html#!/create">{l s='Create your first contact form' mod='ets_contactform7'}</a>.<br />{l s='In the following fields, you can these mail-tags such as' mod='ets_contactform7'}:<span class="ets_ctf7_tag_shortcode"><span class="mailtag code unused">[your-name]</span><span class="mailtag code used">[your-email]</span><span class="mailtag code used">[your-subject]</span><span class="mailtag code used">[your-message]</span></span>
                    </p>
                </div>
            </div>
        {/if}
        {if $input.name=='message_mail_sent_ok'}
            <div class="form-group form_group_contact message">
                <div class="col-lg-3">&nbsp;</div>
                <div class="col-lg-9">
                    <p class="alert alert-info">
                        {l s='You can edit messages used in various situations here.' mod='ets_contactform7'}
                    </p>
                </div>
            </div>
        {/if}
        {if $input.name=='title' && isset($fields_value['id_contact']) && $fields_value['id_contact']}
            <div class="form-group form_group_contact form"> 
                <div class="col-lg-3"></div>
                  <div class="col-lg-9">
                       <p class="alert alert-info">
                        {if isset($fields_value['id_contact']) && $fields_value['id_contact'] && $fields_value['link_contact']}
                        {l s ='Form URL:' mod='ets_contactform7'} <a target="_blank" href="{$fields_value['link_contact']|escape:'html':'UTF-8'}">{$fields_value['link_contact']|escape:'html':'UTF-8'}</a><br />
                        {/if}
                        {l s ='Contact form shortcode: ' mod='ets_contactform7'}<span title="{l s='Click to copy' mod='ets_contactform7'}" style="position: relative;display: inline-block; vertical-align: middle;"><input type="text" class="ctf-short-code" value='[contact-form-7 id="{$fields_value['id_contact']|intval}"]'/><span class="text-copy">{l s='Copied' mod='ets_contactform7'}</span></span><br/>
                        {l s ='Copy the shortcode above, paste onto anywhere on your product description, CMS page content, tpl files, etc. in order to display this contact form' mod='ets_contactform7'}
                        <br />
                        {l s='Besides using shortcode to display the contact form, you can also display the contact form using a custom hook. Copy this custom hook' mod='ets_contactform7'}
                        <span title="{l s='Click to copy' mod='ets_contactform7'}" style="position: relative;display: inline-block; vertical-align: middle;">
                        <input style="width: 234px ! important;" class="ctf-short-code" type="text" value='{literal}{hook h="displayContactForm7" id="{/literal}{$fields_value.id_contact|intval}{literal}"}{/literal}' /><span class="text-copy">{l s='Copied' mod='ets_contactform7'}</span></span>
                        {l s =', place onto your template .tpl files where you want to display the contact form' mod='ets_contactform7'}
                       </p>
                  </div>
             </div>
        {/if}
        <div class="form-group {if isset($input.form_group_class)}{$input.form_group_class|escape:'html':'UTF-8'}{/if}">
    {/if}
    {$smarty.block.parent}
{/block}
{block name="field"}
    {$smarty.block.parent}
    {if $ps15}
        </div>
        {if $input.name=='ETS_CTF7_NUMBER_MESSAGE'}
            <div class="form-group form_group_contact export_import">
                <div class="ctf_export_form_content">            
                    <div class="ctf_export_option">
                        <div class="export_title">{l s='Export contact forms' mod='ets_contactform7'}</div>
                        <p>{l s='Export form configurations of all contact forms of the current shop that you are viewing' mod='ets_contactform7'}</p>
                        <a target="_blank" href="{$link->getAdminlink('AdminModules',true)|escape:'html':'UTF-8'}&configure=ets_contactform7&tab_module=front_office_features&module_name=ets_contactform7&exportContactForm=1" class="btn btn-default mm_export_menu">
                            <i class="fa fa-download"></i>{l s='Export contact forms' mod='ets_contactform7'}
                        </a>
                    </div>                       
                    <div class="ctf_import_option">
                        <div class="export_title">{l s='Import contact forms' mod='ets_contactform7'}</div>
                        <p>{l s='Import contact forms to the current shop that you are viewing for quick configuration. This is useful when you need to migrate contact forms between websites' mod='ets_contactform7'}</p>    
                            <div class="ctf_import_option_updata">
                                <label for="contactformdata">{l s='Data file' mod='ets_contactform7'}</label>
                                <input type="file" name="contactformdata" id="contactformdata" />
                            </div>
                            <div class="cft_import_option_clean">
                                <input type="checkbox" name="importdeletebefore" id="importdeletebefore" value="1" />
                                <label for="importdeletebefore">{l s='Delete all contact forms before importing' mod='ets_contactform7'}</label>
                            </div>
                            <div class="cft_import_option_clean">
                                <input type="checkbox" name="importoverride" id="importoverride" value="1" />
                                <label for="importoverride">{l s='Override all forms with the same IDs' mod='ets_contactform7'}</label>
                            </div>
                            <div class="cft_import_option_button">
                                <input type="hidden" value="1" name="importContactform" />
                                <div class="cft_import_contact_submit">
                                    <i class="fa fa-compress"></i>
                                    <input type="submit" class="btn btn-default cft_import_menu" name="cft_import_contact_submit" value="{l s='Import contact forms' mod='ets_contactform7'}" />
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        {/if}
        {if $input.name=='message_captcha_not_match' || $input.name=='ETS_CTF7_NUMBER_MESSAGE'}
            </div>
        {/if}
    {/if}
{/block}
{block name="input_row"}
{if $input.name=='ETS_CTF7_ENABLE_RECAPTCHA'}
    <div class="ets_form_tab_header">
        <span class="active" data-tab="other_setting">{l s='Global settings' mod='ets_contactform7'}</span>
        <span class="" data-tab="google">{l s='reCAPTCHA' mod='ets_contactform7'}</span>
         <span class="" data-tab="black_list">{l s='IP blacklist' mod='ets_contactform7'}</span>
    </div>
    <div class="form-group-wapper">
    <div class="form-group form_group_contact google">
        <div class="col-lg-3">&nbsp;</div>
        <div class="col-lg-9 ">
            <p class="alert alert-info">
                <a target="_blank" href="https://www.google.com/recaptcha/intro/index.html">{l s='Google reCAPTCHA ' mod='ets_contactform7'}</a>{l s='is a free service to protect your website from spam and abuse' mod='ets_contactform7'}<br />
                {l s='To use reCAPTCHA, you need to install an API key pair' mod='ets_contactform7'}<br />
                {l s='For more details, see' mod='ets_contactform7'} <a target="_blank" href="{$link_basic|escape:'html':'UTF-8'}/modules/ets_contactform7/help/index.html#!/recaptcha">{l s='reCAPTCHA' mod='ets_contactform7'}</a>
            </p>
        </div>
    </div>
{/if}
{if $input.name=='title'}
<div class="ets_form_tab_header">
        <span class="active" data-tab="form">{l s='Form' mod='ets_contactform7'}</span>
        <span class="" data-tab="mail">{l s='Mail' mod='ets_contactform7'}</span>
        <span class="" data-tab="message">{l s='Messages' mod='ets_contactform7'}</span>
        <span class="" data-tab="seo">{l s='Seo' mod='ets_contactform7'}</span>
        <span class="" data-tab="general_settings">{l s='Settings' mod='ets_contactform7'}</span>
</div>
<div class="form-group-wapper">
{/if}
{if $input.name=='email_to'}
    <div class="form-group form_group_contact mail">
        <div class="col-lg-3">&nbsp;</div>
        <div class="col-lg-9 ">
            <p class="alert alert-info">
            {l s='You can edit the mail template here. For details, see' mod='ets_contactform7'} <a target="_blank" href="{$link_basic|escape:'html':'UTF-8'}/modules/ets_contactform7/help/index.html#!/create">{l s='Create your first contact form' mod='ets_contactform7'}</a>.<br />{l s='In the following fields, you can use mail-tags such as' mod='ets_contactform7'}:<span class="ets_ctf7_tag_shortcode"><span class="mailtag code used">[your-name]</span><span class="mailtag code used">[your-email]</span><span class="mailtag code used">[your-subject]</span><span class="mailtag code used">[your-message]</span></span>
            </p>
        </div>
    </div>
{/if}
{if $input.name=='email_to2'}
    <div class="form-group form_group_contact mail mail2">
        <div class="col-lg-3">&nbsp;</div>
        <div class="col-lg-9">
            <p class="alert alert-info">
                {l s='You can edit the mail template here. For details, see' mod='ets_contactform7'} <a target="_blank" href="{$link_basic|escape:'html':'UTF-8'}/modules/ets_contactform7/help/index.html#!/create">{l s='Create your first contact form' mod='ets_contactform7'}</a>.<br />{l s='In the following fields, you can use mail-tags such as' mod='ets_contactform7'}:<span class="ets_ctf7_tag_shortcode"><span class="mailtag code unused">[your-name]</span><span class="mailtag code used">[your-email]</span><span class="mailtag code used">[your-subject]</span><span class="mailtag code used">[your-message]</span></span>
            </p>
        </div>
    </div>
{/if}
{if $input.name=='message_mail_sent_ok'}
    <div class="form-group form_group_contact message">
        <div class="col-lg-3">&nbsp;</div>
        <div class="col-lg-9">
            <p class="alert alert-info">
                {l s='You can edit messages used in various situations here.' mod='ets_contactform7'}
            </p>
        </div>
    </div>
{/if}
{if $input.name=='title' && isset($fields_value['id_contact']) && $fields_value['id_contact']}
    <div class="form-group form_group_contact form"> 
        <div class="col-lg-3"></div>
          <div class="col-lg-9">
               <p class="alert alert-info">
                {if isset($fields_value['id_contact']) && $fields_value['id_contact'] && $fields_value['link_contact']}
                {l s ='Form URL:' mod='ets_contactform7'} <a target="_blank" href="{$fields_value['link_contact']|escape:'html':'UTF-8'}">{$fields_value['link_contact']|escape:'html':'UTF-8'}</a><br />
                {/if}
                {l s ='Contact form shortcode: ' mod='ets_contactform7'}<span title="{l s='Click to copy' mod='ets_contactform7'}" style="position: relative;display: inline-block; vertical-align: middle;"><input type="text" class="ctf-short-code" value='[contact-form-7 id="{$fields_value['id_contact']|intval}"]'/><span class="text-copy">{l s='Copied' mod='ets_contactform7'}</span></span><br/>
                {l s ='Copy the shortcode above, paste onto anywhere on your product description, CMS page content, tpl files, etc. in order to display this contact form' mod='ets_contactform7'}
                <br />
                {l s='Besides using shortcode to display the contact form, you can also display the contact form using a custom hook. Copy this custom hook' mod='ets_contactform7'}
                <span title="{l s='Click to copy' mod='ets_contactform7'}" style="position: relative;display: inline-block; vertical-align: middle;">
                <input style="width: 234px ! important;" class="ctf-short-code" type="text" value='{literal}{hook h="displayContactForm7" id="{/literal}{$fields_value.id_contact|intval}{literal}"}{/literal}' /><span class="text-copy">{l s='Copied' mod='ets_contactform7'}</span></span>
                {l s =', place onto your template .tpl files where you want to display the contact form' mod='ets_contactform7'}
               </p>
          </div>
     </div>
{/if}
{$smarty.block.parent}
{if $input.name=='message_captcha_not_match' || $input.name=='ETS_CTF7_NUMBER_MESSAGE'}
    </div>
{/if}
{/block}
{block name="input"}
    {if $input.name=='short_code'}
        <ul class="ets_ctf_tab_source">
            <li data-id="source_code" class="active">
                <span>{l s='Source code' mod='ets_contactform7'}</span>
            </li>
            <li data-id="preview">
                <span>{l s='Preview' mod='ets_contactform7'}</span>
            </li>
        </ul>
        {if isset($fields_value['id_contact']) && $fields_value['id_contact'] && $fields_value['link_contact']}
            <a title="{l s='View this form on the font end' mod='ets_contactform7'}" target="_blank" href="{$fields_value['link_contact']|escape:'html':'UTF-8'}">{l s='View this form on the font end' mod='ets_contactform7'}</a>
        {/if}
        <div class="ets_ctf_tab source_code active">
        <p>
        {l s='You can compile the form here. For details, see' mod='ets_contactform7'}
            <a target="_blank" href="{$link_basic|escape:'html':'UTF-8'}/modules/ets_contactform7/help/index.html#!/create">{l s='Create your first contact form' mod='ets_contactform7'}</a>.<br />        
        {l s='After finishing compiling your form, open "Mail" tab to setup respective mail-tags for the form-tags used in this form. See' mod='ets_contactform7'} <a target="_blank" href="{$link_basic|escape:'html':'UTF-8'}/modules/ets_contactform7/help/index.html#!/mail-tag">{l s='mail-tag syntax' mod='ets_contactform7'}</a>.
        </p>
        <span id="tag-generator-list">
            <a title="{l s='Form-tag Generator: text' mod='ets_contactform7'}" class="thickbox button" href="#tag-generator-panel-text">{l s='Text' mod='ets_contactform7'}</a>
            <a title="{l s='Form-tag Generator: email' mod='ets_contactform7'}" class="thickbox button" href="#tag-generator-panel-email">{l s='Email' mod='ets_contactform7'}</a>
            <a title="{l s='Form-tag Generator: URL' mod='ets_contactform7'}" class="thickbox button" href="#tag-generator-panel-url">{l s='URL' mod='ets_contactform7'}</a>
            <a title="{l s='Form-tag Generator: tel' mod='ets_contactform7'}" class="thickbox button" href="#tag-generator-panel-tel">{l s='Tel' mod='ets_contactform7'}</a>
            <a title="{l s='Form-tag Generator: number' mod='ets_contactform7'}" class="thickbox button" href="#tag-generator-panel-number">{l s='Number' mod='ets_contactform7'}</a>
            <a title="{l s='Form-tag Generator: date' mod='ets_contactform7'}" class="thickbox button" href="#tag-generator-panel-date">{l s='Date' mod='ets_contactform7'}</a>
            <a title="{l s='Form-tag Generator: text area' mod='ets_contactform7'}" class="thickbox button" href="#tag-generator-panel-textarea">{l s='Textarea' mod='ets_contactform7'}</a>
            <a title="{l s='Form-tag Generator: drop-down menu' mod='ets_contactform7'}" class="thickbox button" href="#tag-generator-panel-menu">{l s ='Drop down select' mod='ets_contactform7'}</a>
            <a title="{l s='Form-tag Generator: checkboxes' mod='ets_contactform7'}" class="thickbox button" href="#tag-generator-panel-checkbox">{l s='Checkboxes' mod='ets_contactform7'}</a>
            <a title="{l s='Form-tag Generator: radio buttons' mod='ets_contactform7'}" class="thickbox button" href="#tag-generator-panel-radio">{l s='Radio buttons' mod='ets_contactform7'}</a>
            <a title="{l s='Form-tag Generator: acceptance' mod='ets_contactform7'}" class="thickbox button" href="#tag-generator-panel-acceptance">{l s='Acceptance' mod='ets_contactform7'}</a>
            <a title="{l s='Form-tag Generator: quiz' mod='ets_contactform7'}" class="thickbox button" href="#tag-generator-panel-quiz">{l s='Quiz' mod='ets_contactform7'}</a>
            {if Configuration::get('ETS_CTF7_ENABLE_RECAPTCHA')}
                <a title="{l s='Form-tag Generator: reCAPTCHA' mod='ets_contactform7'}" class="thickbox button" href="#tag-generator-panel-recaptcha">{l s='reCaptcha' mod='ets_contactform7'}</a>
            {/if}
            <a title="{l s='Form-tag Generator: image captcha' mod='ets_contactform7'}" class="thickbox button" href="#tag-generator-panel-captcha">{l s='Image captcha' mod='ets_contactform7'}</a>
            <a title="{l s='Form-tag Generator: file' mod='ets_contactform7'}" class="thickbox button" href="#tag-generator-panel-file">{l s='File' mod='ets_contactform7'}</a>
            <a title="{l s='Form-tag Generator: submit' mod='ets_contactform7'}" class="thickbox button" href="#tag-generator-panel-submit">{l s='Submit' mod='ets_contactform7'}</a>
        </span>
    {/if}
    {if $input.type == 'switch'}
    	<span class="switch prestashop-switch fixed-width-lg">
    		{foreach $input.values as $value}
    		<input type="radio" name="{$input.name|escape:'html':'UTF-8'}"{if $value.value == 1} id="{$input.name|escape:'html':'UTF-8'}_on"{else} id="{$input.name|escape:'html':'UTF-8'}_off"{/if} value="{$value.value|escape:'html':'UTF-8'}"{if $fields_value[$input.name] == $value.value} checked="checked"{/if}{if (isset($input.disabled) && $input.disabled) or (isset($value.disabled) && $value.disabled)} disabled="disabled"{/if}/>
    		{strip}
    		<label {if $value.value == 1} for="{$input.name|escape:'html':'UTF-8'}_on"{else} for="{$input.name|escape:'html':'UTF-8'}_off"{/if}>
    			{if $value.value == 1}
    				{l s='Yes' d='Admin.Global' mod='ets_contactform7'}
    			{else}
    				{l s='No' d='Admin.Global' mod='ets_contactform7'}
    			{/if}
    		</label>
    		{/strip}
    		{/foreach}
    		<a class="slide-button btn"></a>
    	</span>
    {elseif $input.type == 'textarea' && $ps15}
		{if isset($input.lang) AND $input.lang}
			<div class="translatable translatable-field">
				{foreach $languages as $language}
					<div class="lang_{$language.id_lang|intval}" id="{$input.name|escape:'html':'UTF-8'}_{$language.id_lang|intval}" style="display:{if $language.id_lang == $defaultFormLanguage}block{else}none{/if}; float: left;">
						<textarea cols="{$input.cols|escape:'html':'UTF-8'}" rows="{$input.rows|escape:'html':'UTF-8'}" name="{$input.name|escape:'html':'UTF-8'}_{$language.id_lang|escape:'html':'UTF-8'}" class="{if isset($input.autoload_rte) && $input.autoload_rte}rte autoload_rte{/if} {if isset($input.class)}{$input.class|escape:'html':'UTF-8'}{/if}" >{$fields_value[$input.name][$language.id_lang]|escape:'htmlall':'UTF-8'}</textarea>
					</div>
				{/foreach}
			</div>
		{else}
			<textarea name="{$input.name|escape:'html':'UTF-8'}" id="{if isset($input.id)}{$input.id|escape:'html':'UTF-8'}{else}{$input.name|escape:'html':'UTF-8'}{/if}" cols="{$input.cols|escape:'html':'UTF-8'}" rows="{$input.rows|escape:'html':'UTF-8'}" {if isset($input.autoload_rte) && $input.autoload_rte}class="rte autoload_rte {if isset($input.class)}{$input.class|escape:'html':'UTF-8'}{/if}"{/if}>{$fields_value[$input.name]|escape:'htmlall':'UTF-8'}</textarea>
		{/if}
    {else}
        {$smarty.block.parent}
    {/if}
    {if $input.name=='title_alias'&& isset($fields_value['id_contact']) && $fields_value['id_contact']}
        <div class="col-lg-9">
            {if count($languages)>1}
                {foreach from=$languages item='language'}
                    <div class="translatable-field lang-{$language.id_lang|intval}" {if $language.id_lang != $defaultFormLanguage}style="display:none"{/if}>
                        <i>{l s='Form page url:' mod='ets_contactform7'}</i>&nbsp;<a target="_blank" href="{Ets_contactform7::getLinkContactForm($fields_value['id_contact']|intval,$language['id_lang']|intval)}">{Ets_contactform7::getLinkContactForm($fields_value['id_contact']|intval,$language['id_lang']|intval)}</a>
                    </div>
                {/foreach}
            {else}
                <i>{l s='Form page url:' mod='ets_contactform7'}</i>&nbsp;<a target="_blank" href="{Ets_contactform7::getLinkContactForm($fields_value['id_contact']|intval)}">{Ets_contactform7::getLinkContactForm($fields_value['id_contact']|intval)}</a>
            {/if}
        </div>
    {/if}
    {if $input.name=='short_code'}
        </div>
        <div class="ets_ctf_tab preview">
        </div>
    {/if}
{/block}
{block name="legend"}
<div class="panel-heading">
	{if isset($field.image) && isset($field.title)}<img src="{$field.image|escape:'html':'UTF-8'}" alt="{$field.title|escape:'html':'UTF-8'}" />{/if}
	{if isset($field.icon)}<i class="{$field.icon|escape:'html':'UTF-8'}"></i>{/if}
	{$field.title|escape:'html':'UTF-8'}
    {if isset($field.new) && $field.new}
        <span class="panel-heading-action">
            <a id="desc-contactform-new" class="list-toolbar-btn" href="{$field.new|escape:'html':'UTF-8'}">
                <span class="label-tooltip" data-toggle="tooltip" data-original-title="{l s='Add new' mod='ets_contactform7'}" data-html="true" data-placement="top" title="{l s='Add new' mod='ets_contactform7'}">
                    <i class="process-icon-new"></i>
                </span>
            </a>
        </span>
    {/if}
</div>
{/block}
{block name="description"}
	{if isset($input.desc) && !empty($input.desc)}
		<p class="help-block">
			{if is_array($input.desc)}
				{foreach $input.desc as $p}
					{if is_array($p)}
						<span id="{$p.id|escape:'html':'UTF-8'}">{$p.text|escape:'html':'UTF-8'}</span>
					{else}
						{$p|escape:'html':'UTF-8'}
					{/if}
				{/foreach}
			{else}
				{$input.desc nofilter}
			{/if}
		</p>
	{/if}
{/block}