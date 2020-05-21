/**
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
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2014 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*
* Don't forget to prefix your containers with your own identifier
* to avoid any conflicts with others containers.
*/
$(document).ready(function(){

	$(document).on('click','.action_click',function(e) {
		$(".content_click").hide();
        $(this).siblings('.content_click').toggle();
		e.stopPropagation();
    });
	$(document).on('click','body',function(e) {
         $(".content_click").hide();
    });
	$(document).on('click','.content_click select', function(e){
		e.stopPropagation();
	});
	$('.iframe-upload').fancybox({	
		'width'		: 900,
		'height'	: 600,
		'type'		: 'iframe',
		'autoScale' : false,
		'autoDimensions': false,
		'fitToView' : false,
		'autoSize' : false,
		onUpdate : function(){ $('.fancybox-iframe').contents().find('a.link').data('field_id', $(this.element).data("input-name"));
		$('.fancybox-iframe').contents().find('a.link').attr('data-field_id', $(this.element).data("input-name"));},
		afterShow: function(){
			$('.fancybox-iframe').contents().find('a.link').data('field_id', $(this.element).data("input-name"));
			$('.fancybox-iframe').contents().find('a.link').attr('data-field_id', $(this.element).data("input-name"));
		}
	});

	$('.iframe-column-upload').fancybox({	
		'width'		: 900,
		'height'	: 600,
		'type'		: 'iframe',
		'autoScale' : false,
		'autoDimensions': false,
		'fitToView' : false,
		'autoSize' : false,
		onUpdate : function(){ 
			$('.fancybox-iframe').contents().find('a.link').data('field_id', $(this.element).data("input-name"));
			$('.fancybox-iframe').contents().find('a.link').attr('data-field_id', $(this.element).data("input-name"));
		},
		afterShow: function(){
			$('.fancybox-iframe').contents().find('a.link').data('field_id', $(this.element).data("input-name"));
			$('.fancybox-iframe').contents().find('a.link').attr('data-field_id', $(this.element).data("input-name"));
		}
	});
	


$(".grid_editors .spectrumcolor").each(function() {

$(this).spectrum({
    showInput: true,
    clickoutFiresChange: true,
    preferredFormat: "rgb",
    allowEmpty: true,
    showAlpha: true,
    showInitial: true,
    appendTo: $(this).parents('.modal-body').first()
});

});
	
	$('.icp-auto').iconpicker({
                        iconBaseClass: 'icon',
                        iconComponentBaseClass: 'icon',
                        iconClassPrefix: 'icon-'
                    });
var p_auto_settings =  {
		minChars: 2,
		autoFill: true,
		max:20,
		matchContains: true,
		mustMatch:false,
		cacheLength:0,
		dataType: 'json', 
		extraParams: {
			format: 'json' 
		},
		parse: function(data) {
			var parsed = [];
			if (data == null)
				return true;
			for (var i = 0; i < data.length; i++) {
				parsed[parsed.length] = {
					data: data[i],
					value: data[i].name,
					result: data[i].name
				};
			}

			return parsed;
		},
		formatItem: function(item) {
			return  '<img src="' + item.image + '" style="width: 30px; max-height: 100%; margin-right: 5px; border: 1px dotted #cecece; display: inline-block; vertical-align: middle;" />(ID: ' + item.id + ') ' + item.name;
		},
		cacheLength:0,

	};

var p_auto_settingsf =  {
		minChars: 3,
		selectFirst: false,
		autoFill: false,
		max:20,
		matchContains: true,
		mustMatch:false,
		cacheLength:0,
		dataType: 'json', 
		parse: function(data) {
			var parsed = [];
			if (data == null)
				return true;
			for (var i = 0; i < data.length; i++) {
				parsed[parsed.length] = {
					data: data[i],
					value: data[i].name,
					result: data[i].name
				};
			}

			return parsed;
		},
		formatItem: function(item) {
			return  '<img src="' + item.obr_thumb + '" style="width: 30px; max-height: 100%; margin-right: 5px; border: 1px dotted #cecece; display: inline-block; vertical-align: middle;" />(ID: ' + item.id_product + ') ' + item.pname;
		},
		extraParams: {
					ajaxSearch: 1
		},
		cacheLength:0,

	};



	if (typeof nrt_fronteditors != 'undefined' && nrt_fronteditors)
	{

		$('.product-autocomplete').autocomplete(search_url_editor, p_auto_settingsf).result(function(event, data, formatted) {
			if (data == null)
				return false;
			var productId = data.id_product;
			var productName = data.pname;
			val = productId;

			$(this).parent().parent().parent().find('.select-products-ids').first().append('<option value="' + val + '">' + '(ID: ' + productId + ') ' + productName + '</option>');
			$(this).val('');

		});

	}
	else
	{

		$('.product-autocomplete').autocomplete(nrtsearch_url, p_auto_settings).result(function(event, data, formatted) {
			if (data == null)
				return false;
			var productId = data.id;
			var productName = data.name;
			val = productId;

			$(this).parent().parent().parent().find('.select-products-ids').first().append('<option value="' + val + '">' + '(ID: ' + productId + ') ' + productName + '</option>');
			$(this).val('');

		});

	}


//fix for tinymce source code edit
$(document).on('focusin', function(e) {
    if ($(e.target).closest(".mce-window").length) {
        e.stopImmediatePropagation();
    }
});



/**
* Grid editors
* type = 1 = row
* type = 2 = column
*/


//first rows sortable init
$( '.first-rows-wrapper' ).sortable({
	items: ".first_rows",
	placeholder: "row-placeholder",
	handle: ".dragger-handle"
});
//$( '.first-rows-wrapper' ).disableSelection();

//menu row sortable init
$( '.menu_row' ).sortable({
	items: ".menu_column",
	handle: ".dragger-handle",
	forcePlaceholderSize: true,
	placeholder: "col-placeholder",
	start: function(e, ui){
        ui.placeholder.height(ui.item.outerHeight());
        ui.placeholder.addClass('editors-col-xs-' + ui.item.data('width-p'));
        ui.placeholder.addClass('editors-col-sm-' + ui.item.data('width-t'));
        ui.placeholder.addClass('editors-col-md-' + ui.item.data('width-d'));
    },
	connectWith: ".menu_row"
});
//$( '.menu_row' ).disableSelection();

//menu column sortable init
$( '.menu_column' ).sortable({
	items: ".menu_row",
	handle: ".dragger-handle",
	placeholder: "row-placeholder",
	connectWith: ".menu_column"
});
//$( '.menu_column' ).disableSelection();


//menu column sortable init
$( '.nav-tabs-sortable' ).sortable({
	items: ".nrtfootcontent-tab-li",
	handle: ".dragger-handle-tab"
});

//bind sort update
$('.first-rows-wrapper').on('sortupdate', function( event, ui ) {

	tmpelementId1 = ui.item.data('elementId');
	tmpparentId = ui.item.parents('.menu-element').first().data('elementId');

	if (ui.item.data('element-type') == 3)
	{
		ui.item.parents('.nav-tabs-sortable').find('.nrtfootcontent-tab-li').each(function( index) {
			submenu_content[$(this).data('elementId')].position = index;
		});
	}
	else{

		if(typeof tmpparentId === 'undefined'){
			tmpparentId = 0;
		};
		if (submenu_content.hasOwnProperty(tmpelementId1)) {
			submenu_content[tmpelementId1].parentId = tmpparentId;
		}
		updateElementsPositions();
	}	
});

//set column width phone
$( '.grid_editors' ).on( 'change', '.select-column-width-p', function() 
{
	$element = $(this).parents('.menu_column').first();
	tmpelementId = $element.data('elementId');

	if (typeof nrt_fronteditors != 'undefined' && nrt_fronteditors)
	{
		$element.removeClass('col-xs-' + $element.data('width-p'));
		$element.addClass('col-xs-' + this.value);
		$element.data('width-p', this.value);

		if(this.value == 13)
			$element.addClass('hidden-xs');
		else
			$element.removeClass('hidden-xs');
		$('.nrtcarousel').slick('setPosition');
	}
	else
	{
		$element.removeClass('editors-col-xs-' + $element.data('width-p'));
		$element.addClass('editors-col-xs-' + this.value);
		$element.data('width-p', this.value);

		if(this.value == 13)
			$element.addClass('phone-hidden');
		else
			$element.removeClass('phone-hidden');
	}


	if (submenu_content.hasOwnProperty(tmpelementId)) {
			submenu_content[tmpelementId].width_p = parseInt(this.value);
	}

});

//set column width phone
$( '.grid_editors' ).on( 'change', '.select-column-width-t', function() 
{
	$element = $(this).parents('.menu_column').first();
	tmpelementId = $element.data('elementId');
	
	if (typeof nrt_fronteditors != 'undefined' && nrt_fronteditors)
	{
		$element.removeClass('col-sm-' + $element.data('width-t'));
		$element.addClass('col-sm-' + this.value);
		$element.data('width-t', this.value);

		if(this.value == 13)
			$element.addClass('hidden-sm');
		else
			$element.removeClass('hidden-sm')
		$('.nrtcarousel').slick('setPosition');
	}
	else
	{
		$element.removeClass('editors-col-sm-' + $element.data('width-t'));
		$element.addClass('editors-col-sm-' + this.value);
		$element.data('width-t', this.value);

		if(this.value == 13)
			$element.addClass('tablet-hidden');
		else
			$element.removeClass('tablet-hidden')
	}
	
	if (submenu_content.hasOwnProperty(tmpelementId)) {
		submenu_content[tmpelementId].width_t = parseInt(this.value);
	}

});

//set column width phone
$( '.grid_editors' ).on( 'change', '.select-column-width-d', function() 
{
	$element = $(this).parents('.menu_column').first();
	tmpelementId = $element.data('elementId');

	if (typeof nrt_fronteditors != 'undefined' && nrt_fronteditors)
	{
		$element.removeClass('col-md-' + $element.data('width-d'));
		$element.addClass('col-md-' + this.value);
		$element.data('width-d', this.value);

		if(this.value == 13){
			$element.addClass('hidden-md');
			$element.addClass('hidden-lg');
			}
		else{
			$element.removeClass('hidden-md');
			$element.removeClass('hidden-md');
		}
		$('.nrtcarousel').slick('setPosition');
	}
	else
	{
		$element.removeClass('editors-col-md-' + $element.data('width-d'));
		$element.addClass('editors-col-md-' + this.value);
		$element.data('width-d', this.value);

		if(this.value == 13)
			$element.addClass('desktop-hidden');
		else
			$element.removeClass('desktop-hidden');
	}

	if (submenu_content.hasOwnProperty(tmpelementId)) {
			submenu_content[tmpelementId].width_d = parseInt(this.value);
	}
});

$( '.grid_editors' ).on( 'input', '.tabtitle', function() 
{
	$element = $(this).parents('.menu_tabe').first();
	tmpelementId = $element.data('elementId');

	tabtitle = {};

	if (typeof languages != "undefined") {
		languages.forEach(function(jsLang) {
			tabtitle[jsLang.id_lang] = $element.find('.tabtitle-' + jsLang.id_lang).first().val();	
		});
	} else {
		tabtitle[id_language] = $element.find('.tabtitle-' + id_language).first().val();
	}

	if (submenu_content.hasOwnProperty(tmpelementId)) {
			submenu_content[tmpelementId].tabtitle = tabtitle;
	}
});




//open content modal
$( '.grid_editors' ).on( 'click', '.column-content-edit', function() 
{
	$($(this).parent().parent().find('.column-content-modal').first()).modal({
		keyboard: false
	});
});

//open edit row modal
$( '.grid_editors' ).on( 'click', '.edit-row-action', function() 
{
	$($(this).parent().parent().find('.row-settings-modal').first()).modal({
		keyboard: false
	});
});

//colum type
$( '.grid_editors' ).on( 'change', '.select-column-content', function() 
{
	$element = $(this).parents('.menu_column').first();

	elmid = $element.data('elementId');

	if (submenu_content.hasOwnProperty(elmid)) {
			submenu_content[elmid].contentType = parseInt(this.value);
	}
	setContentForm($element, this.value);
});

$( '.grid_editors' ).on( 'change', '.select-module', function() 
{
	$element = $(this).parent().parent().find('.select-module-hook');
	$element.empty();
	if($(this).find(":selected").val() != '' )
	{
	hooks = $(this).find(":selected").data("hooks").split(',');
	
	var i;
	for (i = 0; i < hooks.length; ++i)
	{
		$element.append('<option value="' + hooks[i] + '">' + hooks[i] + '</option>');
	}
	}

});

//set content options
$( '.grid_editors' ).on( 'hidden.bs.modal', '.column-content-modal', function(e) {

	modid = $(this).parents('.menu_column').first().data('elementId');

	if (submenu_content.hasOwnProperty(modid)) {
		delete submenu_content[modid].content;
	}
	switch(parseInt($(this).find('.select-column-content').first().val())) {
		case 1:
		setHtmlContent(this, modid);
		break;
		case 2:
		setCategoriesContent(this, modid);
		setBoxStyle(this, modid);
		break;
		case 3:
		setLinksContent(this, modid);
		break;
		case 4:
		setProductsContent(this, modid);
		setBoxStyle(this, modid);
		break;
		case 5:
		setManufacturersContent1(this, modid);
		break;
		case 6:
		setImagesContent(this, modid);
		break;
		case 7:
		setManufacturersContent(this, modid);
		break;
		case 8:
		setCustomHookContent(this, modid);
		break;
		case 9:
		setModuleIncludeContent(this, modid);
		break;

	}	
	setColumnStyle(this, modid);
});

//set row options
$( '.grid_editors' ).on( 'hidden.bs.modal', '.row-settings-modal', function(e) {

	modid = $(this).parents('.menu_row').first().data('elementId');

	row_s = {};

	if(bgc = $(this).find('.row-bgc').first().val())
		row_s.bgc = bgc;

	if(bgi = $(this).find('.row-bgi').first().val())
	{
		row_s.bgi = bgi;
		row_s.bgr = parseInt($(this).find('.select-row-bgr').first().val());
	}	

	if(bgw = parseInt($(this).find('.select-row-bgw').first().val()))
		row_s.bgw = bgw;

	if(bgh = parseInt($(this).find('.select-row-bgh').first().val()))
		row_s.bgh = bgh;

	if(br_top_st = parseInt($(this).find('.br_top_st').first().val()))
	{
		row_s.br_top_st = br_top_st;
		row_s.br_top_wh = parseInt($(this).find('.br_top_wh').first().val());
		row_s.br_top_c = $(this).find('.br_top_c').first().val();
	}

	if(br_bottom_st = parseInt($(this).find('.br_bottom_st').first().val()))
	{
		row_s.br_bottom_st = br_bottom_st ;
		row_s.br_bottom_wh = parseInt($(this).find('.br_bottom_wh').first().val());
		row_s.br_bottom_c = $(this).find('.br_bottom_c').first().val();
	}
	
	if(prlx = $(this).find('.select-row-prlx').first().val())
		row_s.prlx = prlx;

	if(padd = $(this).find('.select-row-padd').first().val())
		row_s.padd = padd;

	if(valign = $(this).find('.select-row-valign').first().val())
		row_s.valign = valign;

	if($(this).find('.r-margin-right').first().prop('checked'))
		row_s.m_r = 1;	
	
	if($(this).find('.r-margin-left').first().prop('checked'))
		row_s.m_l = 1;

	if(p_t = parseInt($(this).find('.select-r-padding-top').first().val()))
		row_s.p_t = p_t;	
	
	if(p_b = parseInt($(this).find('.select-r-padding-bottom').first().val()))
		row_s.p_b = p_b;	

	if (submenu_content.hasOwnProperty(modid)) {
		submenu_content[modid].row_s = row_s;
	}

	
});



function setCategoriesContent(modal, elmid)
{
	column_content = {};

	if(ids = $(modal).find('.select-categories-ids').first().val())
	{
		column_content.ids = ids;
		column_content.limit = parseInt($(modal).find('.categories-products-limit').first().val());
		column_content.view = parseInt($(modal).find('.select-categories-view').first().val());
		column_content.itype = $(modal).find('.select-image-type').first().val();
		column_content.o = $(modal).find('.select-categories-o').first().val();
		column_content.ob = $(modal).find('.select-categories-ob').first().val();
		column_content.ar = parseInt($(modal).find('.select-categories-ar').first().val());
		column_content.ap = parseInt($(modal).find('.select-categories-ap').first().val());
		column_content.dt = parseInt($(modal).find('.select-categories-dt').first().val());
		column_content.colnb = parseInt($(modal).find('.select-categories-per-column').first().val());
		column_content.line_lg = parseInt($(modal).find('.select-categories-line-lg').first().val());
		column_content.line_md = parseInt($(modal).find('.select-categories-line-md').first().val());
		column_content.line_sm = parseInt($(modal).find('.select-categories-line-sm').first().val());
		column_content.line_ms = parseInt($(modal).find('.select-categories-line-ms').first().val());
		column_content.line_xs = parseInt($(modal).find('.select-categories-line-xs').first().val());
	}

	if (submenu_content.hasOwnProperty(elmid)) {
		submenu_content[elmid].content = column_content;
	}
}



function setImagesContent(modal, elmid)
{
	column_content = {};

	source = {};
	href = {};

	if (typeof languages != "undefined") {
		languages.forEach(function(jsLang) {
			source[jsLang.id_lang] = $(modal).find('.image-source-' + jsLang.id_lang).first().val();
			href[jsLang.id_lang] = $(modal).find('.image-href-' + jsLang.id_lang).first().val();		
		});
	} else {
		source[id_language] = $(modal).find('.image-source-' + id_language).first().val();
		href[id_language] = $(modal).find('.image-href-' + id_language).first().val();
	}	

	column_content.window = parseInt($(modal).find('.select-image-window').first().val());
	column_content.iheight = parseInt($(modal).find('.select-image-height').first().val());
	
	column_content.source = source;
	column_content.href = href;

	if (submenu_content.hasOwnProperty(elmid)) {
		submenu_content[elmid].content = column_content;
	}
	
}


function setProductsContent(modal, elmid)
{
	column_content = {};

	if(ids = serialize_productsselect($(modal).find('.select-products-ids').first().find('option')))
	{
		column_content.ids = ids;
		column_content.view = parseInt($(modal).find('.select-products-view').first().val());
		column_content.colnb = parseInt($(modal).find('.select-products-per-column').first().val());
		column_content.itype = $(modal).find('.select-pimage-type').first().val();
		column_content.ar = parseInt($(modal).find('.select-products-ar').first().val());
		column_content.ap = parseInt($(modal).find('.select-products-ap').first().val());
		column_content.dt = parseInt($(modal).find('.select-products-dt').first().val());
		column_content.line_lg = parseInt($(modal).find('.select-products-line-lg').first().val());
		column_content.line_md = parseInt($(modal).find('.select-products-line-md').first().val());
		column_content.line_sm = parseInt($(modal).find('.select-products-line-sm').first().val());
		column_content.line_ms = parseInt($(modal).find('.select-products-line-ms').first().val());
		column_content.line_xs = parseInt($(modal).find('.select-products-line-xs').first().val());
	}

	if (submenu_content.hasOwnProperty(elmid)) {
		submenu_content[elmid].content = column_content;
	}
	
}

function setCustomHookContent(modal, elmid)
{
	column_content = {};

	column_content.hook = $(modal).find('.custom-hook-name').first().val();
	
	if (submenu_content.hasOwnProperty(elmid)) {
		submenu_content[elmid].content = column_content;
	}
}

function setModuleIncludeContent(modal, elmid)
{
	column_content = {};

	if(id_module = $(modal).find('.select-module').first().val())
	{
		column_content.id_module = id_module;
		column_content.hook = $(modal).find('.select-module-hook').first().val();
	}
	
	if (submenu_content.hasOwnProperty(elmid)) {
		submenu_content[elmid].content = column_content;
	}
}

function setManufacturersContent(modal, elmid)
{
	column_content = {};

	if(ids = $(modal).find('.select-manufacturers-ids').first().val())
	{
		column_content.ids = ids;
		column_content.view = parseInt($(modal).find('.select-manufacturers-view').first().val());
		column_content.colnb = parseInt($(modal).find('.select-manufacturers-per-column').first().val());
		column_content.ar = parseInt($(modal).find('.select-manufacturers-ar').first().val());
		column_content.ap = parseInt($(modal).find('.select-manufacturers-ap').first().val());
		column_content.dt = parseInt($(modal).find('.select-manufacturers-dt').first().val());
		column_content.line_lg = parseInt($(modal).find('.select-manufacturers-line-lg').first().val());
		column_content.line_md = parseInt($(modal).find('.select-manufacturers-line-md').first().val());
		column_content.line_sm = parseInt($(modal).find('.select-manufacturers-line-sm').first().val());
		column_content.line_ms = parseInt($(modal).find('.select-manufacturers-line-ms').first().val());
		column_content.line_xs = parseInt($(modal).find('.select-manufacturers-line-xs').first().val());

	}

	if (submenu_content.hasOwnProperty(elmid)) {
		submenu_content[elmid].content = column_content;
	}
	
}


function setLinksContent(modal, elmid)
{
	column_content = {};

	if(ids = $(modal).find('.select-links-ids').first().val())
	{
		column_content.ids = ids;
		column_content.view = parseInt($(modal).find('.select-links-view').first().val());
	}

	if (submenu_content.hasOwnProperty(elmid)) {
		submenu_content[elmid].content = column_content;
	}
	
}

function setHtmlContent(modal, elmid)
{
	column_content = {};

	if(ids = $(modal).find('.select-customhtml').first().val())
	{
		column_content.ids = ids;
	}

	if (submenu_content.hasOwnProperty(elmid)) {
		submenu_content[elmid].content = column_content;
	}
	
}

function setBoxStyle(modal, elmid)
{
	box_style = {};

	if((pbx_b_st = parseInt($(modal).find('.pbx_b_st').first().val())) != 6)
	{
		box_style.pbx_b_st = pbx_b_st;
		box_style.pbx_b_wh = parseInt($(modal).find('.pbx_b_wh').first().val());
		box_style.pbx_b_c = $(modal).find('.pbx_b_c').first().val();
	}

	if((pbxh_b_st = parseInt($(modal).find('.pbxh_b_st').first().val())) != 6)
	{
		box_style.pbxh_b_st = pbxh_b_st;
		box_style.pbxh_b_wh = parseInt($(modal).find('.pbxh_b_wh').first().val());
		box_style.pbxh_b_c = $(modal).find('.pbxh_b_c').first().val();
	}

	if(pbx_sh = $(modal).find('.pbx_sh').first().val())
		box_style.pbx_sh= pbx_sh;

	if(pbxh_sh= $(modal).find('.pbxh_sh').first().val())
		box_style.pbxh_sh= pbxh_sh;

	if(pbx_bg = $(modal).find('.pbx_bg').first().val())
		box_style.pbx_bg = pbx_bg;

	if(pbx_nc = $(modal).find('.pbx_nc').first().val())
		box_style.pbx_nc = pbx_nc;

	if(pbx_pc = $(modal).find('.pbx_pc').first().val())
		box_style.pbx_pc = pbx_pc;

	if(pbx_rc = $(modal).find('.pbx_rc').first().val())
		box_style.pbx_rc = pbx_rc;

	if(pbxh_bg = $(modal).find('.pbxh_bg').first().val())
		box_style.pbxh_bg = pbxh_bg;

	if(pbxh_nc = $(modal).find('.pbxh_nc').first().val())
		box_style.pbxh_nc = pbxh_nc;

	if(pbxh_pc = $(modal).find('.pbxh_pc').first().val())
		box_style.pbxh_pc = pbxh_pc;

	if(pbxh_rc = $(modal).find('.pbxh_rc').first().val())
		box_style.pbxh_rc = pbxh_rc;

	if (submenu_content.hasOwnProperty(elmid)) {
		submenu_content[elmid].content.box_style = box_style;
	}
}

function setColumnStyle(modal, elmid)
{	
	submenu_style = {};

	title = {};
	href = {};
	legend = {};

	if (typeof languages != "undefined") {
		languages.forEach(function(jsLang) {
			title[jsLang.id_lang] = $(modal).find('.column-title-' + jsLang.id_lang).first().val();
			href[jsLang.id_lang] = $(modal).find('.column-href-' + jsLang.id_lang).first().val();	
			legend[jsLang.id_lang] = $(modal).find('.column-legend-' + jsLang.id_lang).first().val();		
		});
	} else {
		title[id_language] = $(modal).find('.column-title-' + id_language).first().val();
		href[id_language] = $(modal).find('.column-href-' + id_language).first().val();
		legendf[id_language] = $(modal).find('.column-legen-' + id_language).first().val();
	}

	submenu_style.title = title;
	submenu_style.href = href;
	submenu_style.legend = legend;


	if(bgcolor = $(modal).find('.column_bg_color').first().val())
		submenu_style.bg_color = bgcolor;

	if(legend_bg = $(modal).find('.legend_bg').first().val())
		submenu_style.legend_bg = legend_bg;

	if(legend_txt = $(modal).find('.legend_txt').first().val())
		submenu_style.legend_txt = legend_txt;

	if(title_borderc = $(modal).find('.title_borderc').first().val())
		submenu_style.title_borderc = title_borderc;

	if(title_color = $(modal).find('.title_color').first().val())
		submenu_style.title_color = title_color;

	if(title_colorh = $(modal).find('.title_colorh').first().val())
		submenu_style.title_colorh = title_colorh;

	if(title_bg = $(modal).find('.title_bg').first().val())
		submenu_style.title_bg = title_bg;

	




	if(br_top_st = parseInt($(modal).find('.br_top_st').first().val()))
	{
	submenu_style.br_top_st = br_top_st;
	submenu_style.br_top_wh = parseInt($(modal).find('.br_top_wh').first().val());
	submenu_style.br_top_c = $(modal).find('.br_top_c').first().val();
	}

	if(br_right_st = parseInt($(modal).find('.br_right_st').first().val()))
	{
	submenu_style.br_right_st = br_right_st;
	submenu_style.br_right_wh = parseInt($(modal).find('.br_right_wh').first().val());
	submenu_style.br_right_c = $(modal).find('.br_right_c').first().val();
	}

	if(br_bottom_st = parseInt($(modal).find('.br_bottom_st').first().val()))
	{
	submenu_style.br_bottom_st = br_bottom_st ;
	submenu_style.br_bottom_wh = parseInt($(modal).find('.br_bottom_wh').first().val());
	submenu_style.br_bottom_c = $(modal).find('.br_bottom_c').first().val();
	}

	if(br_left_st = parseInt($(modal).find('.br_left_st').first().val()))
	{
	submenu_style.br_left_st = br_left_st;
	submenu_style.br_left_wh = parseInt($(modal).find('.br_left_wh').first().val());
	submenu_style.br_left_c = $(modal).find('.br_left_c').first().val();
	}

	//paddings	
	if($(modal).find('.c-padding-top').first().prop('checked'))
		submenu_style.c_p_t = 1;

	if($(modal).find('.c-padding-right').first().prop('checked'))
		submenu_style.c_p_r = 1;	

	if($(modal).find('.c-padding-bottom').first().prop('checked'))
		submenu_style.c_p_b = 1;	

	if($(modal).find('.c-padding-left').first().prop('checked'))
		submenu_style.c_p_l = 1;

	//margins
	if($(modal).find('.c-margin-top').first().prop('checked'))
		submenu_style.c_m_t = 1;

	if($(modal).find('.c-margin-top2').first().prop('checked'))
		submenu_style.c_m_t2 = 1;

	if($(modal).find('.c-margin-right').first().prop('checked'))
		submenu_style.c_m_r = 1;	

	if($(modal).find('.c-margin-bottom').first().prop('checked'))
		submenu_style.c_m_b = 1;	

	if($(modal).find('.c-margin-left').first().prop('checked'))
		submenu_style.c_m_l = 1;						


	if (submenu_content.hasOwnProperty(elmid)) {
		submenu_content[elmid].content_s = submenu_style;
	}
	
}

function serialize_productsselect(element)
{	
	options = [];
	element.each(function(i){
		options[i] =  parseInt($(this).val());
	});

	return unnrtProducts(options);

}

function unnrtProducts(a) {
    var prims = {"boolean":{}, "number":{}, "string":{}}, objs = [];

    return a.filter(function(item) {
        var type = typeof item;
        if(type in prims)
            return prims[type].hasOwnProperty(item) ? false : (prims[type][item] = true);
        else
            return objs.indexOf(item) >= 0 ? false : objs.push(item);
    });
}

function setContentForm($element, val)
{
	
		$element.find('.column-content-info').first().text($element.find('.select-column-content option[value="' + parseInt(val) + '"]').first().text());
		
		switch(parseInt(val)) {
			case 0:
			$element.find('.content-options-wrapper').hide();
			break;
			case 1:
			$element.find('.content-options-wrapper').not('.htmlcontent-wrapper').hide();
			$element.find('.htmlcontent-wrapper').show();
			break;
			case 2:
			$element.find('.content-options-wrapper').not('.categorytree-wrapper, .product-boxes-styles-wrapper').hide();
			$element.find('.categorytree-wrapper').show();
			$element.find('.product-boxes-styles-wrapper').show();
			break;
			case 3:
			$element.find('.content-options-wrapper').not('.va-links-wrapper').hide();
			$element.find('.va-links-wrapper').show();
			break;
			case 4:
			$element.find('.content-options-wrapper').not('.products-wrapper, .product-boxes-styles-wrapper').hide();
			$element.find('.products-wrapper').show();
			$element.find('.product-boxes-styles-wrapper').show();
			break;
			case 5:
			$element.find('.content-options-wrapper').not('.manufacturers-wrapper').hide();
			$element.find('.manufacturers-wrapper').show();
			break;
			case 6:
			$element.find('.content-options-wrapper').not('.column-image-wrapper').hide();
			$element.find('.column-image-wrapper').show();
			break;
			case 7:
			$element.find('.content-options-wrapper').not('.manufacturers-wrapper').hide();
			$element.find('.manufacturers-wrapper').show();
			break;
			case 8:
			$element.find('.content-options-wrapper').not('.customhook-wrapper').hide();
			$element.find('.customhook-wrapper').show();
			break;
			case 9:
			$element.find('.content-options-wrapper').not('.moduleinclude-wrapper').hide();
			$element.find('.moduleinclude-wrapper').show();
			break;
		}	
	
}



//init submenu elements

var submenu_content = {};
var elementId = 0;

if ($('#submenu-elements').length) {
	var prev_submenu_val = $('#submenu-elements').val();
	if (prev_submenu_val.length !== 0) {
		var old_submenu_content = JSON.parse(prev_submenu_val);
		$.extend(submenu_content, old_submenu_content);

		var ids = $("#grid-editors-wrapper .menu-element").map(function() {
			return parseInt($(this).data('element-id'), 10);
		}).get();

		elementId = Math.max.apply(Math, ids);

	}
}

$('.menu_column').each(function() {

 setContentForm($(this), $(this).data('contenttype'));
});


//set preview typ
$( '.preview-buttons' ).on( 'click', '.switch-view-btn', function() 
{

$('#grid-editors-wrapper').removeAttr('class');	
$('#grid-editors-wrapper').addClass($(this).data("preview-type"));

$('.preview-buttons .switch-view-btn').removeClass('active-preview');
$(this).addClass('active-preview');

});

//add first row button
$( '#buttons-sample' ).on( 'click', '.add-row-action', function() {
	
	$parentElement = $( this ).parent().parent().parent().find('.first-rows-wrapper'); 
	if (typeof nrt_fronteditors != 'undefined' && nrt_fronteditors)
		$parentElement.append( '<div data-element-type="1" data-depth="0" data-element-id="' + (++elementId) + '" class="row menu_row menu_row_element  nrtfootcontent_row nrtfootcontent-element first_rows menu-element menu-element-id-' + (elementId) + '">' + $( '#buttons-sample' ).html() + $( '#row-content-sample' ).html() + '</div>' );
	else
		$parentElement.append( '<div data-element-type="1" data-depth="0" data-element-id="' + (++elementId) + '" class="row menu_row menu_row_element first_rows menu-element menu-element-id-' + (elementId) + '">' + $( '#buttons-sample' ).html() + $( '#row-content-sample' ).html() + '</div>' );

	$( '.menu-element-id-' + elementId).sortable({
		items: ".menu_column",
		handle: ".dragger-handle",
		connectWith: ".menu_row",
		placeholder: "col-placeholder",
	});
	//$( '.menu-element-id-' + elementId).disableSelection();

	position = $parentElement.children().length;

	var newElement = {
		'elementId': elementId,
		'type': 1,
		'depth': 0,
		'position':  position,
		'parentId': 0
	};
	
	$('.menu-element-id-' + elementId + ' .spectrumcolor').spectrum({
    showInput: true,
    clickoutFiresChange: true,
    preferredFormat: "rgb",
    allowEmpty: true,
    showAlpha: true,
    showInitial: true,
    appendTo: $('.menu-element-id-' + elementId ).find('.modal-body').first()

});


	$('.menu-element-id-' + elementId + ' .row-bgi').attr('id', elementId + '-row-bgi');
	$('.menu-element-id-' + elementId + ' .row-bgi').parent().find('.iframe-column-upload').data('input-name', elementId + '-row-bgi');

	submenu_content[elementId] = newElement;
});

//add row button
$( '.grid_editors' ).on( 'click', '.menu-element .add-row-action', function() {
	
	parentId = 	$( this ).parent().parent().data("element-id");
	depth = 	$( this ).parent().parent().data("depth")+1;

	$parentElement = $( this ).parent().parent();
	 
	if (typeof nrt_fronteditors != 'undefined' && nrt_fronteditors)
		$parentElement.append( '<div data-element-type="1" data-depth="' + depth + '" data-element-id="' + (++elementId) + '" class="row menu_row menu_row_element nrtfootcontent_row nrtfootcontent-element menu-element menu-element-id-' + (elementId) + '">' + $( '#buttons-sample' ).html() + ' </div>' );
	else
		$parentElement.append( '<div data-element-type="1" data-depth="' + depth + '" data-element-id="' + (++elementId) + '" class="row menu_row menu_row_element menu-element menu-element-id-' + (elementId) + '">' + $( '#buttons-sample' ).html() + ' </div>' );

	$( '.menu-element-id-' + elementId).sortable({
		items: ".menu_column",
		handle: ".dragger-handle",
		placeholder: "col-placeholder",
		connectWith: ".menu_row"
	});
	//$( '.menu-element-id-' + elementId).disableSelection();

	position = $parentElement.children().length;

	var newElement = {
		'elementId': elementId,
		'type': 1,
		'depth': depth,
		'position':  position,
		'parentId': parentId
	};

	submenu_content[elementId] = newElement;

});

//add tab button
$( '.grid_editors' ).on( 'click', '.menu-element .add-tab-action', function() {
	
	parentId = 	$( this ).parent().parent().data("element-id");
	depth = 	$( this ).parent().parent().data("depth")+1;
	
	++elementId;

	$parentElement = $( this ).parent().parent();
	$parentElement.find('.nav-tabs li').removeClass('active');
	$parentElement.find('.tab-content .tab-pane').removeClass('active');
	$parentElement.find('.nav-tabs').first().append( '<li data-element-id="' + (elementId) + '" data-element-type="3" class="nrtfootcontent-tab-li nrtfootcontent-tab-li-id-' + (elementId) + ' active"><a href="#nrtfootcontent-tab-id-' + (elementId) + '" data-toggle="tab">Tab ' + (elementId) + '<span class="dragger-handle-tab"><i class="icon-arrows "></i></span></a></li>' );
	$parentElement.find('.tab-content').first().append( '<div id="nrtfootcontent-tab-id-' + (elementId) + '" class="tab-pane   active nrtfootcontent-element-id-' + (elementId) + '"><div data-element-type="3" data-depth="' + depth + '" data-element-id="' + (elementId) + '" class="row menu_row menu_tabe menu_row_element menu-element menu-element-id-' + (elementId) + '">' + $( '#buttons-sample' ).html() + $( '#tab-content-sample' ).html() + ' </div></div>' );
	


	$( '.menu-element-id-' + elementId).sortable({
		items: ".menu_column",
		handle: ".dragger-handle",
		placeholder: "col-placeholder",
		connectWith: ".menu_tabs"
	});
	//$( '.menu-element-id-' + elementId).disableSelection();

	position = $parentElement.children().length;

	var newElement = {
		'elementId': elementId,
		'type': 3,
		'depth': depth,
		'position':  position,
		'parentId': parentId
	};

	submenu_content[elementId] = newElement;

});


//clone column
$( '.grid_editors' ).on( 'click', ' .duplicate-element-action', function() 
{	
	$brotherElement = $(this).parents('.menu-element').first();
	brotherId = $brotherElement.data('element-id');

	if (submenu_content.hasOwnProperty(brotherId)) {
			
			clonedElement = clone(submenu_content[brotherId]);
			clonedElement.elementId = ++elementId;
			
			$cloneElement = $brotherElement.clone(true);
			$cloneElement.data('element-id', elementId);
			$cloneElement.removeClass('menu-element-id-' + brotherId);
			$cloneElement.addClass('menu-element-id-' + elementId).appendTo($brotherElement.parent());
			submenu_content[elementId] = clonedElement;
			$cloneElement.find('.content_click').attr('style','');
	}
});


//add column button
$( '.grid_editors' ).on( 'click', '.menu-element .add-column-action', function() 
{
	parentId = 	$( this ).parents('.menu_row').first().data('element-id');
	depth = 	$( this ).parents('.menu_row').first().data("depth")+1;
	
	$parentElement = $( this ).parents('.menu_row_element').first();
	
	if (!$parentElement.length ) {
    	$parentElement = $( this ).parents('.menu_row').find('.menu_row_element').first();
	}

	if (typeof nrt_fronteditors != 'undefined' && nrt_fronteditors)
		$parentElement.append( '<div data-element-type="2" data-depth="' + depth + '"  data-width-p="12" data-width-t="12" data-width-d="12" data-element-id="' + (++elementId) + '" class="col-xs-12 col-sm-12 col-md-12 nrtfootcontent-column nrtfootcontent-element menu_column menu-element menu-element-id-' + (elementId) + ' clearfix">' + $( '#buttons-sample' ).html() + $( '#column-content-sample' ).html() + '</div>' );
	else
		$parentElement.append( '<div data-element-type="2" data-depth="' + depth + '"  data-width-p="12" data-width-t="12" data-width-d="12" data-element-id="' + (++elementId) + '" class="editors-col-xs-12 editors-col-sm-12 editors-col-md-12 menu_column menu-element menu-element-id-' + (elementId) + '">' + $( '#buttons-sample' ).html() + $( '#column-content-sample' ).html() + '</div>' );
	
	$( '.menu-element-id-' + elementId).sortable({
		items: ".menu_row",
		handle: ".dragger-handle",
		placeholder: "row-placeholder",
		connectWith: ".menu_column"
	});
	//$( '.menu-element-id-' + elementId).disableSelection();

	position = $parentElement.children().length;

	var newElement = {
		'elementId': elementId,
		'type': 2,
		'depth': depth,
		'width_p': 12,
		'width_t': 12,
		'width_d': 12,
		'contentType': 0,
		'position':  position,
		'parentId': parentId
	};
	

$('.menu-element-id-' + elementId + ' .spectrumcolor').spectrum({
    showInput: true,
    clickoutFiresChange: true,
    preferredFormat: "rgb",
    allowEmpty: true,
    showAlpha: true,
    showInitial: true,
    appendTo: $('.menu-element-id-' + elementId ).find('.modal-body').first()
});


	$('.menu-element-id-' + elementId + ' .image-source').attr('id', elementId + '-image-source-' + $(this).data('lang-id'));


	$('.menu-element-id-' + elementId + ' .image-source').each(function() {
		$(this).attr('id', elementId + '-image-source-' + $(this).data('lang-id'));
		$(this).parent().find('.iframe-column-upload').data('input-name', elementId + '-image-source-' + $(this).data('lang-id'));
	});

	$('.menu-element-id-' + elementId + ' .rte').each(function() {
		$(this).attr('id', elementId + '-htmlcontent-' + $(this).data('lang-id'));

	});

	


	

	submenu_content[elementId] = newElement;
	setContentForm($('.menu-element-id-' + elementId), 0);

	if (typeof nrt_fronteditors != 'undefined' && nrt_fronteditors)
	{

		$('.menu-element-id-' + elementId + ' .product-autocomplete').autocomplete(search_url_editor, p_auto_settingsf).result(function(event, data, formatted) {
			if (data == null)
				return false;
			var productId = data.id_product;
			var productName = data.pname;
			val = productId;

			$(this).parent().parent().parent().find('.select-products-ids').first().append('<option value="' + val + '">' + '(ID: ' + productId + ') ' + productName + '</option>');
			$(this).val('');

		});

	}
	else{

		$('.menu-element-id-' + elementId + ' .product-autocomplete').autocomplete(nrtsearch_url, p_auto_settings).result(function(event, data, formatted) {
			if (data == null)
				return false;
			var productId = data.id;
			var productName = data.name;
			val = productId;

			$(this).parent().parent().parent().find('.select-products-ids').first().append('<option value="' + val + '">' + '(ID: ' + productId + ') ' + productName + '</option>');
			$(this).val('');

		});

	}

});




//add column button
$( '.grid_editors' ).on( 'click', '.menu-element .add-tabs-action', function() 
{
	parentId = 	$( this ).parents('.menu_row').first().data('element-id');
	depth = 	$( this ).parents('.menu_row').first().data("depth")+1;
	
	$parentElement = $( this ).parents('.menu_row_element').first();
	
	if (!$parentElement.length ) {
    	$parentElement = $( this ).parents('.menu_row').find('.menu_row_element').first();
	}

	if (typeof nrt_fronteditors != 'undefined' && nrt_fronteditors)
		$parentElement.append( '<div data-element-type="4" data-depth="' + depth + '"  data-width-p="12" data-width-t="12" data-width-d="12" data-element-id="' + (++elementId) + '" class="col-xs-12 col-sm-12 col-md-12 nrtfootcontent-column nrtfootcontent-element menu_column menu_tabs menu-element menu-element-id-' + (elementId) + ' clearfix">' + $( '#buttons-sample' ).html() + $( '#column-content-sample' ).html() + '<ul class="nav nav-tabs nav-tabs-sortable"></ul><div class="tab-content"></div></div>' );
	else
		$parentElement.append( '<div data-element-type="4" data-depth="' + depth + '"  data-width-p="12" data-width-t="12" data-width-d="12" data-element-id="' + (++elementId) + '" class="editors-col-xs-12 editors-col-sm-12 editors-col-md-12 menu_column menu_tabs menu-element menu-element-id-' + (elementId) + '">' + $( '#buttons-sample' ).html() + $( '#column-content-sample' ).html() + ' <ul class="nav nav-tabs nav-tabs-sortable"></ul><div class="tab-content"></div></div>' );
	


	$( '.menu-element-id-' + elementId).sortable({
		items: ".menu_row",
		handle: ".dragger-handle",
		placeholder: "row-placeholder",
		connectWith: ".menu_column"
	});

	$( '.menu-element-id-' + elementId).find('.nav-tabs-sortable').sortable({
	items: ".nrtfootcontent-tab-li",
	handle: ".dragger-handle-tab"
	});

	//$( '.menu-element-id-' + elementId).disableSelection();

	position = $parentElement.children().length;

	var newElement = {
		'elementId': elementId,
		'type': 4,
		'depth': depth,
		'width_p': 12,
		'width_t': 12,
		'width_d': 12,
		'contentType': 0,
		'position':  position,
		'parentId': parentId
	};
	

$('.menu-element-id-' + elementId + ' .spectrumcolor').spectrum({
    showInput: true,
    clickoutFiresChange: true,
    preferredFormat: "rgb",
    allowEmpty: true,
    showAlpha: true,
    showInitial: true,
    appendTo: $('.menu-element-id-' + elementId ).find('.modal-body').first()
});




	submenu_content[elementId] = newElement;
	setContentForm($('.menu-element-id-' + elementId), 0);

});








//remove element button
$( '.grid_editors' ).on( 'click', '.remove-element-action', function() {
	deleteId = 	$( this ).parent().parent().data('element-id');
	$parent_element = $( this ).parent().parent();

	if($parent_element.data('element-type') == 3)
		$('.nrtfootcontent-tab-li-id-' + $parent_element.data('element-id')).remove();

	$parent_element.remove();



	delete submenu_content[deleteId];
	deleteMenuElelement(deleteId)
});

//pass submenu to input field
$('button[name="submitNrtfootereditorsModule"]').on("click",function() {
	if($.isEmptyObject(submenu_content))
		$('#submenu-elements').val('');
	else
		$('#submenu-elements').val(encodeURIComponent(JSON.stringify(submenu_content)));
});

//remove product fromc olumn
$( '.grid_editors' ).on( 'click', '.remove-products-ids', function() {
	
	$(this).parent().find('.select-products-ids option:selected').each(function(i){
		$(this).remove();
	});

});



//delete menu elements recursivly
function deleteMenuElelement(id)
{	
	for (var key in submenu_content) {
		if (submenu_content.hasOwnProperty(key)) {
			if(submenu_content[key].parentId == id)
			{	
				tmpelid = submenu_content[key].elementId;
				delete submenu_content[key];
				deleteMenuElelement(tmpelid);
			}
		}
	}
}



function saveEditorAjax()
{	

	if($.isEmptyObject(submenu_content))
		var submenu_elements = '';
	else
		var submenu_elements = encodeURIComponent(JSON.stringify(submenu_content));
			

	$.ajax({
		type: 'POST',
		url: admin_fronteditor_ajax_urlf + parent.admin_fronteditor_ajax_url,
		data: {
			controller : 'NrtFronteditor',
     		 action : 'saveEditor',
			submenu_elements : submenu_elements,
			ajax : true
		},
		success: function(jsonData)
		{
			location.reload(true);
		}
	});
}
window.getSubmenuContentWindow = function() {
   return getSubmenuContent();
}

function getSubmenuContent()
{
	if($.isEmptyObject(submenu_content))
		var submenu_elements = '';
	else
		var submenu_elements = submenu_content;

	return submenu_elements;
}

function clone(src) {
	function mixin(dest, source, copyFunc) {
		var name, s, i, empty = {};
		for(name in source){
			// the (!(name in empty) || empty[name] !== s) condition avoids copying properties in "source"
			// inherited from Object.prototype.	 For example, if dest has a custom toString() method,
			// don't overwrite it with the toString() method that source inherited from Object.prototype
			s = source[name];
			if(!(name in dest) || (dest[name] !== s && (!(name in empty) || empty[name] !== s))){
				dest[name] = copyFunc ? copyFunc(s) : s;
			}
		}
		return dest;
	}

	if(!src || typeof src != "object" || Object.prototype.toString.call(src) === "[object Function]"){
		// null, undefined, any non-object, or function
		return src;	// anything
	}
	if(src.nodeType && "cloneNode" in src){
		// DOM Node
		return src.cloneNode(true); // Node
	}
	if(src instanceof Date){
		// Date
		return new Date(src.getTime());	// Date
	}
	if(src instanceof RegExp){
		// RegExp
		return new RegExp(src);   // RegExp
	}
	var r, i, l;
	if(src instanceof Array){
		// array
		r = [];
		for(i = 0, l = src.length; i < l; ++i){
			if(i in src){
				r.push(clone(src[i]));
			}
		}
		// we don't clone functions for performance reasons
		//		}else if(d.isFunction(src)){
		//			// function
		//			r = function(){ return src.apply(this, arguments); };
	}else{
		// generic objects
		r = src.constructor ? new src.constructor() : {};
	}
	return mixin(r, src, clone);

}



//update all  menu positions after drag and drop
function updateElementsPositions()
{
	for (var key in submenu_content) {
		if (submenu_content.hasOwnProperty(key)) {
			submenu_content[key].position =  $('.menu-element-id-' + submenu_content[key].elementId).index();
		}
	}
}

});
