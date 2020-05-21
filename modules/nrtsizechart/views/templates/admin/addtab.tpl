<div id="ModuleIqitsizeguide">
	<input type="hidden" name="submitted_tabs[]" value="ModuleIqitsizeguide" />
	<h2>{l s='Add or modify customizable properties' mod='nrtsizechart'}</h2>

	{if isset($display_common_field) && $display_common_field}
		<div class="alert alert-info">{l s='Warning, if you change the value of fields with an orange bullet %s, the value will be changed for all other shops for this product'  mod='nrtsizechart' sprintf=$bullet_common_field}</div>
	{/if}

<div class="form-group">
		<label class="control-label col-lg-4" for="id_nrtsizechart">{l s='Select from created guides' mod='nrtsizechart'}</label>
		<div class="col-lg-3">
			<select name="id_nrtsizechart" id="id_nrtsizechart" class="">
				<option value="0">- {l s='Choose (optional)' mod='nrtsizechart'} -</option>
				{if isset($guides)}
				{foreach from=$guides item=guide}
				<option value="{$guide.id_guide}" {if isset($selectedGuide) && ($guide.id_guide == $selectedGuide)}selected="selected"{/if}>{$guide.title}</option>
				{/foreach}
				{/if}
			</select>
		</div>
		<div class="col-lg-5">
			<a class="btn btn-link bt-icon confirm_leave" style="margin-bottom:0" href="{$link->getAdminLink('AdminModules')}&configure=nrtsizechart&addGuide=1">
				<i class="icon-plus-sign"></i> {l s='Create new guide' mod='nrtsizechart'} <i class="icon-external-link-sign"></i>
			</a>
		</div>
	</div>
</div>
