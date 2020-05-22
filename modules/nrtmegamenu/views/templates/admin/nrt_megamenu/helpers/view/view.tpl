<script>
    var nrtmm_ajax_url = '{$nrtmm_ajax_url}';
    var nrtmm_id_nrtmegamenu = {$nrtmm_id_nrtmegamenu};

    // Rich Text Editor related
    var iso = '{$iso|addslashes}';
    var pathCSS = '{$smarty.const._THEME_CSS_DIR_|addslashes}';
    var ad = '{$ad|addslashes}';
</script>

<div class="left-column col-lg-4">

    {* CUSTOM LINK FORM *}
    <form id="nrtmm_customlink" class="nrtmm_addmenuitemform form-horizontal">

        <input type="hidden" name="menu_type" value="1" />

        <div class="panel">
            <div class="panel-heading">
                <i class="icon-edit"></i> {l s='Add Custom Link / Text'}
            </div>

            <div class="form-group">
                <div class="col-lg-12">
                    <div class="form-group">
                        {foreach from=$languages item=language}

                            {if $languages|count > 1}
                            <div class="translatable-nrt lang-{$language.id_lang}" {if $language.id_lang != $id_default_lang}style="display:none"{/if}>
                            {/if}

                                <label for="nrtmm_customlink_title_{$language.id_lang}" class="control-label col-lg-3 required">{l s='Title'}</label>
                                <div class="col-lg-7">
                                    <input type="text" id="nrtmm_customlink_title_{$language.id_lang}" name="nrtmm_customlink_title_{$language.id_lang}" class="clearable" />
                                </div>

                                {if $languages|count > 1}
                                    <div class="col-lg-2">
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
            </div>

            <div class="form-group">
                <div class="col-lg-12">
                    <div class="form-group">
                        {foreach from=$languages item=language}

                            {if $languages|count > 1}
                            <div class="translatable-nrt lang-{$language.id_lang}" {if $language.id_lang != $id_default_lang}style="display:none"{/if}>
                            {/if}

                                <label for="nrtmm_customlink_link_{$language.id_lang}" class="control-label col-lg-3">{l s='Link'}</label>
                                <div class="col-lg-7">
                                    <input type="text" id="nrtmm_customlink_link_{$language.id_lang}" name="nrtmm_customlink_link_{$language.id_lang}" class="clearable" />
                                </div>

                                {if $languages|count > 1}
                                    <div class="col-lg-2">
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
            </div>

            <div class="panel-footer">
                <button type="submit" value="1" id="nrtmm_customlink_submit" name="nrtmm_customlink_submit" class="btn btn-default pull-right">
                    <i class="process-icon-new"></i> {l s='Add Custom Link / Text'}
                </button>
            </div>
        </div>

    </form>
    {* END - CUSTOM LINK FORM *}



    {* CATEGORY LINK FORM *}
    <form id="nrtmm_categorylink" class="nrtmm_addmenuitemform form-horizontal">

        <input type="hidden" name="menu_type" value="2" />

        <div class="panel">
            <div class="panel-heading">
                <i class="icon-edit"></i> {l s='Add Category Link'}
            </div>

            <div class="form-group hidden">
                <div class="col-lg-12">
                    <div class="form-group">
                        {foreach from=$languages item=language}

                            {if $languages|count > 1}
                            <div class="translatable-nrt lang-{$language.id_lang}" {if $language.id_lang != $id_default_lang}style="display:none"{/if}>
                            {/if}

                                <label for="nrtmm_categorylink_title_{$language.id_lang}" class="control-label col-lg-3 required">{l s='Title'}</label>
                                <div class="col-lg-7">
                                    <input type="text" id="nrtmm_categorylink_title_{$language.id_lang}" name="nrtmm_categorylink_title_{$language.id_lang}" class="nrtmm_categorylink_title" />
                                </div>

                                {if $languages|count > 1}
                                    <div class="col-lg-2">
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
            </div>

            <div class="form-group hidden">
                <div class="col-lg-12">
                    <div class="form-group">
                        {foreach from=$languages item=language}

                            {if $languages|count > 1}
                            <div class="translatable-nrt lang-{$language.id_lang}" {if $language.id_lang != $id_default_lang}style="display:none"{/if}>
                            {/if}

                                <label for="nrtmm_categorylink_link_{$language.id_lang}" class="control-label col-lg-3 required">{l s='Link'}</label>
                                <div class="col-lg-7">
                                    <input type="text" id="nrtmm_categorylink_link_{$language.id_lang}" name="nrtmm_categorylink_link_{$language.id_lang}" class="nrtmm_categorylink_link" />
                                </div>

                                {if $languages|count > 1}
                                    <div class="col-lg-2">
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
            </div>

            <div class="form-group">
                <div class="col-lg-12">
                    <div class="form-group">

                        <label for="nrtmm_categorylink_category" class="control-label col-lg-3">{l s='Category'}</label>
                        <div class="col-lg-7">
                            <select id="nrtmm_categorylink_category" name="nrtmm_categorylink_category">
                                {foreach $nrtmmCategories as $nrtmmCategory}
                                    <option value="{$nrtmmCategory.value}">{$nrtmmCategory.name}</option>
                                {/foreach}
                            </select>
                        </div>

                    </div>

                </div>
            </div>

            <div class="panel-footer">
                <button type="submit" value="1" id="nrtmm_categorylink_submit" name="nrtmm_categorylink_submit" class="btn btn-default pull-right">
                    <i class="process-icon-new"></i> {l s='Add Category Link'}
                </button>
            </div>
        </div>

    </form>
    {* END - CATEGORY LINK FORM *}



    {* PRODUCT LINK FORM *}
    <form id="nrtmm_productlink" class="nrtmm_addmenuitemform form-horizontal">

        <input type="hidden" name="menu_type" value="3" />

        <div class="panel">
            <div class="panel-heading">
                <i class="icon-edit"></i> {l s='Add Product Link'}
            </div>

            <div class="form-group hidden">
                <div class="col-lg-12">
                    <div class="form-group">
                        {foreach from=$languages item=language}

                            {if $languages|count > 1}
                                <div class="translatable-nrt lang-{$language.id_lang}" {if $language.id_lang != $id_default_lang}style="display:none"{/if}>
                            {/if}

                            <label for="nrtmm_productlink_title_{$language.id_lang}" class="control-label col-lg-3 required">{l s='Title'}</label>
                            <div class="col-lg-7">
                                <input type="text" id="nrtmm_productlink_title_{$language.id_lang}" name="nrtmm_productlink_title_{$language.id_lang}"  class="nrtmm_productlink_title" />
                            </div>

                            {if $languages|count > 1}
                                <div class="col-lg-2">
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
            </div>

            <div class="form-group hidden">
                <div class="col-lg-12">
                    <div class="form-group">
                        {foreach from=$languages item=language}

                            {if $languages|count > 1}
                                <div class="translatable-nrt lang-{$language.id_lang}" {if $language.id_lang != $id_default_lang}style="display:none"{/if}>
                            {/if}

                            <label for="nrtmm_productlink_link_{$language.id_lang}" class="control-label col-lg-3 required">{l s='Link'}</label>
                            <div class="col-lg-7">
                                <input type="text" id="nrtmm_productlink_link_{$language.id_lang}" name="nrtmm_productlink_link_{$language.id_lang}" class="nrtmm_productlink_link" />
                            </div>

                            {if $languages|count > 1}
                                <div class="col-lg-2">
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
            </div>

            <div class="form-group">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="nrtmm_productlink_product" class="control-label col-lg-3">{l s='Product'}</label>
                        <div class="col-lg-7">
                            <input type="text" id="nrtmm_productlink_product" name="nrtmm_productlink_product" class="clearable" />
                            <p class="help-block">{l s='Start typing a product name...'}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel-footer">
                <button type="submit" value="1" id="nrtmm_productlink_submit" name="nrtmm_productlink_submit" class="btn btn-default pull-right">
                    <i class="process-icon-new"></i> {l s='Add Product Link'}
                </button>
            </div>
        </div>

    </form>
    {* END - PRODUCT LINK FORM *}



    {* MANUFACTURER LINK FORM *}
    <form id="nrtmm_manufacturerlink" class="nrtmm_addmenuitemform form-horizontal">

        <input type="hidden" name="menu_type" value="4" />

        <div class="panel">
            <div class="panel-heading">
                <i class="icon-edit"></i> {l s='Add Manufacturer Link'}
            </div>

            <div class="form-group hidden">
                <div class="col-lg-12">
                    <div class="form-group">
                        {foreach from=$languages item=language}

                            {if $languages|count > 1}
                                <div class="translatable-nrt lang-{$language.id_lang}" {if $language.id_lang != $id_default_lang}style="display:none"{/if}>
                            {/if}

                            <label for="nrtmm_manufacturerlink_title_{$language.id_lang}" class="control-label col-lg-3 required">{l s='Title'}</label>
                            <div class="col-lg-7">
                                <input type="text" id="nrtmm_manufacturerlink_title_{$language.id_lang}" name="nrtmm_manufacturerlink_title_{$language.id_lang}" class="nrtmm_manufacturerlink_title" />
                            </div>

                            {if $languages|count > 1}
                                <div class="col-lg-2">
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
            </div>

            <div class="form-group hidden">
                <div class="col-lg-12">
                    <div class="form-group">
                        {foreach from=$languages item=language}

                            {if $languages|count > 1}
                                <div class="translatable-nrt lang-{$language.id_lang}" {if $language.id_lang != $id_default_lang}style="display:none"{/if}>
                            {/if}

                            <label for="nrtmm_manufacturerlink_link_{$language.id_lang}" class="control-label col-lg-3 required">{l s='Link'}</label>
                            <div class="col-lg-7">
                                <input type="text" id="nrtmm_manufacturerlink_link_{$language.id_lang}" name="nrtmm_manufacturerlink_link_{$language.id_lang}" class="nrtmm_manufacturerlink_link" />
                            </div>

                            {if $languages|count > 1}
                                <div class="col-lg-2">
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
            </div>

            <div class="form-group">
                <div class="col-lg-12">
                    <div class="form-group">

                        <label for="nrtmm_manufacturerlink_manufacturer" class="control-label col-lg-3">{l s='Manufacturer'}</label>
                        <div class="col-lg-7">
                            <select id="nrtmm_manufacturerlink_manufacturer" name="nrtmm_manufacturerlink_manufacturer">
                                {foreach $nrtmmManufacturers as $nrtmmManufacturer}
                                    <option value="{$nrtmmManufacturer.value}">{$nrtmmManufacturer.name}</option>
                                {/foreach}
                            </select>
                        </div>

                    </div>

                </div>
            </div>

            <div class="panel-footer">
                <button type="submit" value="1" id="nrtmm_manufacturerlink_submit" name="nrtmm_manufacturerlink_submit" class="btn btn-default pull-right">
                    <i class="process-icon-new"></i> {l s='Add Manufacturer Link'}
                </button>
            </div>
        </div>

    </form>
    {* END - MANUFACTURER LINK FORM *}



    {* SUPPLIER LINK FORM *}
    <form id="nrtmm_supplierlink" class="nrtmm_addmenuitemform form-horizontal">

        <input type="hidden" name="menu_type" value="5" />

        <div class="panel">
            <div class="panel-heading">
                <i class="icon-edit"></i> {l s='Add Supplier Link'}
            </div>

            <div class="form-group hidden">
                <div class="col-lg-12">
                    <div class="form-group">
                        {foreach from=$languages item=language}

                            {if $languages|count > 1}
                                <div class="translatable-nrt lang-{$language.id_lang}" {if $language.id_lang != $id_default_lang}style="display:none"{/if}>
                            {/if}

                            <label for="nrtmm_supplierlink_title_{$language.id_lang}" class="control-label col-lg-3 required">{l s='Title'}</label>
                            <div class="col-lg-7">
                                <input type="text" id="nrtmm_supplierlink_title_{$language.id_lang}" name="nrtmm_supplierlink_title_{$language.id_lang}" class="nrtmm_supplierlink_title" />
                            </div>

                            {if $languages|count > 1}
                                <div class="col-lg-2">
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
            </div>

            <div class="form-group hidden">
                <div class="col-lg-12">
                    <div class="form-group">
                        {foreach from=$languages item=language}

                            {if $languages|count > 1}
                                <div class="translatable-nrt lang-{$language.id_lang}" {if $language.id_lang != $id_default_lang}style="display:none"{/if}>
                            {/if}

                            <label for="nrtmm_supplierlink_link_{$language.id_lang}" class="control-label col-lg-3 required">{l s='Link'}</label>
                            <div class="col-lg-7">
                                <input type="text" id="nrtmm_supplierlink_link_{$language.id_lang}" name="nrtmm_supplierlink_link_{$language.id_lang}" class="nrtmm_supplierlink_link" />
                            </div>

                            {if $languages|count > 1}
                                <div class="col-lg-2">
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
            </div>

            <div class="form-group">
                <div class="col-lg-12">
                    <div class="form-group">

                        <label for="nrtmm_supplierlink_category" class="control-label col-lg-3">{l s='Supplier'}</label>
                        <div class="col-lg-7">
                            <select id="nrtmm_supplierlink_supplier" name="nrtmm_supplierlink_supplier">
                                {foreach $nrtmmSuppliers as $nrtmmSupplier}
                                    <option value="{$nrtmmSupplier.value}">{$nrtmmSupplier.name}</option>
                                {/foreach}
                            </select>
                        </div>

                    </div>

                </div>
            </div>

            <div class="panel-footer">
                <button type="submit" value="1" id="nrtmm_supplierlink_submit" name="nrtmm_supplierlink_submit" class="btn btn-default pull-right">
                    <i class="process-icon-new"></i> {l s='Add Supplier Link'}
                </button>
            </div>
        </div>

    </form>
    {* END - SUPPLIER LINK FORM *}



    {* CMS PAGE LINK FORM *}
    <form id="nrtmm_cmspagelink" class="nrtmm_addmenuitemform form-horizontal">

        <input type="hidden" name="menu_type" value="6" />

        <div class="panel">
            <div class="panel-heading">
                <i class="icon-edit"></i> {l s='Add CMS Page Link'}
            </div>

            <div class="form-group hidden">
                <div class="col-lg-12">
                    <div class="form-group">
                        {foreach from=$languages item=language}

                            {if $languages|count > 1}
                                <div class="translatable-nrt lang-{$language.id_lang}" {if $language.id_lang != $id_default_lang}style="display:none"{/if}>
                            {/if}

                            <label for="nrtmm_cmspagelink_title_{$language.id_lang}" class="control-label col-lg-3 required">{l s='Title'}</label>
                            <div class="col-lg-7">
                                <input type="text" id="nrtmm_cmspagelink_title_{$language.id_lang}" name="nrtmm_cmspagelink_title_{$language.id_lang}" class="nrtmm_cmspagelink_title" />
                            </div>

                            {if $languages|count > 1}
                                <div class="col-lg-2">
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
            </div>

            <div class="form-group hidden">
                <div class="col-lg-12">
                    <div class="form-group">
                        {foreach from=$languages item=language}

                            {if $languages|count > 1}
                                <div class="translatable-nrt lang-{$language.id_lang}" {if $language.id_lang != $id_default_lang}style="display:none"{/if}>
                            {/if}

                            <label for="nrtmm_cmspagelink_link_{$language.id_lang}" class="control-label col-lg-3 required">{l s='Link'}</label>
                            <div class="col-lg-7">
                                <input type="text" id="nrtmm_cmspagelink_link_{$language.id_lang}" name="nrtmm_cmspagelink_link_{$language.id_lang}" class="nrtmm_cmspagelink_link" />
                            </div>

                            {if $languages|count > 1}
                                <div class="col-lg-2">
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
            </div>

            <div class="form-group">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="nrtmm_cmspagelink_cmspage" class="control-label col-lg-3">{l s='CMS Page'}</label>
                        <div class="col-lg-7">
                            <select id="nrtmm_cmspagelink_cmspage" name="nrtmm_cmspagelink_cmspage">
                                {$nrtmmCMSPages}
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel-footer">
                <button type="submit" value="1" id="nrtmm_cmspagelink_submit" name="nrtmm_cmspagelink_submit" class="btn btn-default pull-right">
                    <i class="process-icon-new"></i> {l s='Add CMS Page Link'}
                </button>
            </div>
        </div>

    </form>
    {* END - CMS PAGE LINK FORM *}



    {* ADD CUSTOM CONTENT FORM *}
    <form id="nrtmm_customcontent" class="nrtmm_addmenuitemform form-horizontal">

        <input type="hidden" name="menu_type" value="7" />

        <div class="panel">
            <div class="panel-heading">
                <i class="icon-edit"></i> {l s='Add Custom Content'}
            </div>

            <div class="form-group hidden">
                <div class="col-lg-12">
                    <div class="form-group">
                        {foreach from=$languages item=language}

                            {if $languages|count > 1}
                                <div class="translatable-nrt lang-{$language.id_lang}" {if $language.id_lang != $id_default_lang}style="display:none"{/if}>
                            {/if}

                            <label for="nrtmm_customcontent_title_{$language.id_lang}" class="control-label col-lg-3 required">{l s='Title'}</label>
                            <div class="col-lg-7">
                                <input type="text" id="nrtmm_customcontent_title_{$language.id_lang}" name="nrtmm_customcontent_title_{$language.id_lang}" value="Custom Content" />
                            </div>

                            {if $languages|count > 1}
                                <div class="col-lg-2">
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
            </div>

            <div class="form-group hidden">
                <div class="col-lg-12">
                    <div class="form-group">
                        {foreach from=$languages item=language}

                            {if $languages|count > 1}
                                <div class="translatable-nrt lang-{$language.id_lang}" {if $language.id_lang != $id_default_lang}style="display:none"{/if}>
                            {/if}

                            <label for="nrtmm_customcontent_link_{$language.id_lang}" class="control-label col-lg-3 required">{l s='Link'}</label>
                            <div class="col-lg-7">
                                <input type="text" id="nrtmm_customcontent_link_{$language.id_lang}" name="nrtmm_customcontent_link_{$language.id_lang}" value="customcontent" />
                            </div>

                            {if $languages|count > 1}
                                <div class="col-lg-2">
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
            </div>

            <div class="form-group">
                <div class="col-lg-12">
                    <button type="submit" value="1"  id="nrtmm_advanced_customcontent" name="nrtmm_advanced_customcontent" class="btn btn-default nrtmm_advanced_customcontent">
                        <i class="process-icon-new"></i> {l s='Add Custom Content'}
                    </button>
                </div>
            </div>

        </div>

    </form>
    {* END - ADD CUSTOM CONTENT FORM *}




    {* ADD DIVIDER FORM *}
    <form id="nrtmm_divider" class="nrtmm_addmenuitemform form-horizontal">

        <input type="hidden" name="menu_type" value="8" />

        <div class="panel">
            <div class="panel-heading">
                <i class="icon-edit"></i> {l s='Add Divider'}
            </div>

            <div class="form-group hidden">
                <div class="col-lg-12">
                    <div class="form-group">
                        {foreach from=$languages item=language}

                            {if $languages|count > 1}
                                <div class="translatable-nrt lang-{$language.id_lang}" {if $language.id_lang != $id_default_lang}style="display:none"{/if}>
                            {/if}

                            <label for="nrtmm_divider_title_{$language.id_lang}" class="control-label col-lg-3 required">{l s='Title'}</label>
                            <div class="col-lg-7">
                                <input type="text" id="nrtmm_divider_title_{$language.id_lang}" name="nrtmm_divider_title_{$language.id_lang}" value="Divider" />
                            </div>

                            {if $languages|count > 1}
                                <div class="col-lg-2">
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
            </div>

            <div class="form-group hidden">
                <div class="col-lg-12">
                    <div class="form-group">
                        {foreach from=$languages item=language}

                            {if $languages|count > 1}
                                <div class="translatable-nrt lang-{$language.id_lang}" {if $language.id_lang != $id_default_lang}style="display:none"{/if}>
                            {/if}

                            <label for="nrtmm_divider_link_{$language.id_lang}" class="control-label col-lg-3 required">{l s='Link'}</label>
                            <div class="col-lg-7">
                                <input type="text" id="nrtmm_divider_link_{$language.id_lang}" name="nrtmm_divider_link_{$language.id_lang}" value="divider" />
                            </div>

                            {if $languages|count > 1}
                                <div class="col-lg-2">
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
            </div>

            <div class="form-group">
                <div class="col-lg-12">
                    <button type="submit" value="1"  id="nrtmm_advanced_divider" name="nrtmm_advanced_divider" class="btn btn-default nrtmm_advanced_divider">
                        <i class="process-icon-new"></i> {l s='Add Divider'}
                    </button>
                </div>
            </div>

        </div>

    </form>
    {* END - ADD DIVIDER FORM *}

</div>

<div class="right-column col-lg-8">

    <div class="panel">
        <div class="panel-heading">
            <i class="icon-list"></i> {l s='Menu Structure'}
        </div>

        <div id="nrtmmMenuBuilder">
            {include file='./menu_builder.tpl' nrtmmMenuItems=$nrtmmMenuItems}
        </div>
    </div>

</div>




