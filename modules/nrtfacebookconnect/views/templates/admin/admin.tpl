<form class="form-horizontal defaultForm" method="post" action="{$action}">
	<div class="panel">
		<div class="panel-heading">
			{l s='Facebook Connect' mod='nrtfacebookconnect'}
		</div>
		<div class="form-wrapper">
			<div class="form-group">
				<label class="control-label col-lg-3">
					{l s='Enable Facebook Login ?' mod='nrtfacebookconnect'}
				</label>
				<div class="col-lg-6">
					<span class="switch prestashop-switch fixed-width-lg">
						<input type="radio" name="hi_fb_on" id="hi_fb_on_on" value="1" {if $hi_fb_on == 1}checked="checked"{/if} >
						<label for="hi_fb_on_on">
							{l s='yes' mod='nrtfacebookconnect'}
						</label>
						<input type="radio" name="hi_fb_on" value="0" id="hi_fb_on_off" {if $hi_fb_on == 0}checked="checked"{/if}>
						<label for="hi_fb_on_off">
							{l s='no' mod='nrtfacebookconnect'}
						</label>
						<a class="slide-button btn"></a>
					</span>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-lg-3">
					{l s='Redirect After Login' mod='nrtfacebookconnect'}
				</label>
				<div class="col-lg-3">
					<select name="hi_fb_login_page" >
						<option value="no_redirect" {if $hi_login_page == 'no_redirect'}selected="selected"{/if}>
							{l s='No redirect' mod='nrtfacebookconnect'}
						</option>
						<option value="authentication_page" {if $hi_login_page == 'authentication_page'}selected="selected"{/if}>
							{l s='My Account page' mod='nrtfacebookconnect'}
						</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-lg-3" for="hi_fb_app_id">
					{l s='Facebook App ID' mod='nrtfacebookconnect'}
				</label>
				<div class="col-lg-6">
					<input value="{$hi_fb_app_id}" type="text" placeholder="{l s='Facebook app ID' mod='nrtfacebookconnect'}" name="hi_fb_app_id" id="hi_fb_app_id">
				</div>
			</div>
		</div>
		<div class="panel-footer">
			<button type="submit" class="btn btn-default pull-right" name="hi_fb_submit">
				<i class="process-icon-save"></i>
				{l s='Save' mod='nrtfacebookconnect'}
			</button>
		</div>
	</div>
</form>
<form class="form-horizontal defaultForm" method="post" action="/">
	<div class="panel">
		<div class="panel-heading">
			{l s='How to create Facebook APP' mod='nrtfacebookconnect'}
		</div>
		<div class="form-wrapper">
			<div class="form-group">
				<iframe width="420" height="315" src="https://www.youtube.com/embed/z1LiUIUXYWI" frameborder="0" allowfullscreen></iframe>
			</div>
		</div>
	</div>
</form>
<script>
	$(document).ready(function(){
		$(".hi_fb_position").on("click", function(){
			if($(this).hasClass("checked")){
				$(this).removeClass("checked");
				$(this).find("i").removeClass("icon-check-sign");
				$(this).find("input").val(0);
			}else{
				$(this).addClass("checked");
				$(this).find("i").addClass("icon-check-sign");
				$(this).find("input").val(1);
			}
			return false;
		});
		$(".hi_fb_position_label").on("click", function(){
			$(this).next().click();
		});
	});
</script>
<style type="text/css">
	.addons-style-img_preview-theme{
		max-width: 100%;
	}
	.addons-style-theme-preview > p {
		margin-top: 10px;
	}
</style>