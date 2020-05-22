function show_menu() {
	$('#nrtmegamenu-main .root').hover(function(e) {
	    if (LANG_RTL != 1){
			showMegamenuMenu($(this));
	    } else {
			showMegamenuMenu_rtl($(this));
	    }
	    $(this).addClass('active-menu');
	}, function() {
	    hideMegamenuMenu();
	    $(this).removeClass('active-menu');
	});
}
$(document).ready(function() {
	unitActiveItem();
  if($(window).width() > 991){
	show_menu();
  }
});
$(window).on('resize', function() {
  if($(window).width() > 991){
	hideMegamenuMenu();
	$('#nrtmegamenu-main .root').removeClass('active-menu');
	show_menu();
  }
});
function showMegamenuMenu(el) {
    /* Calculate menu width (parent row width) */var mWidth = $('#nrtmegamenu-main').closest('.row').width();
    var containerOffset = $('#nrtmegamenu-main').closest('.container').offset();
    var rowOffset = $('#nrtmegamenu-main').closest('.row').offset();
    var pWidth = $(el).closest('.root').children('.menu-items').outerWidth();
    var _mpadding = ($(window).width() - mWidth) / 2;
    /* Calculate correct top position for the menu */var _menuHeight = $('#nrtmegamenu-main').height();
    var mTop = _menuHeight;
    /* Calculate correct right position for the menu */var _containerOffset = $('#nrtmegamenu-main').closest('.container').offset();
    var _containerLeftPadding = parseInt($('#nrtmegamenu-main').closest('.container').css('padding-left'));
    var _containerRightPadding = parseInt($('#nrtmegamenu-main').closest('.container').css('padding-right'));
    var _mainOffset = rowOffset.left - containerOffset.left;
    var _menuPopupOffset = $(el).closest('.root').offset();
    var mLeft = _menuPopupOffset.left - _mpadding;
    if (mLeft + pWidth > mWidth + _mainOffset){
	var xLeft = mWidth - pWidth + _mainOffset;
    } else {
	var xLeft = _menuPopupOffset.left - _mpadding;
    }
    $(el).closest('.root').children('.menu-items').css({'left': xLeft}).addClass('active');
}
function showMegamenuMenu_rtl(el) {
    /* Calculate menu width (parent row width) */var mWidth = $('#nrtmegamenu-main').closest('.row').width();
    var containerOffset = $('#nrtmegamenu-main').closest('.container').offset();
    var rowOffset = $('#nrtmegamenu-main').closest('.row').offset();
    var pWidth = $(el).closest('.root').children('.menu-items').outerWidth();
    var _mpadding = ($(window).width() - mWidth) / 2;
    /* Calculate correct top position for the menu */var _menuHeight = $('#nrtmegamenu-main').height();
    var mTop = _menuHeight;
    /* Calculate correct right position for the menu */var _containerOffset = $('#nrtmegamenu-main').closest('.container').offset();
    var _containerLeftPadding = parseInt($('#nrtmegamenu-main').closest('.container').css('padding-left'));
    var _containerRightPadding = parseInt($('#nrtmegamenu-main').closest('.container').css('padding-right'));
    var _mainOffset = rowOffset.left - containerOffset.left;
    var liWidth = $(el).closest('.root').outerWidth();
    var _menuPopupOffset = $(el).closest('.root').offset();
    var mRight = $(window).width() - (_menuPopupOffset.left + liWidth) - _mpadding;
    if (mRight + pWidth > mWidth + _mainOffset){
	var mRight = mWidth - pWidth + _mainOffset - _containerRightPadding;
    } else {
	var mRight = $(window).width() - (_menuPopupOffset.left + liWidth) - _mpadding;
    }
    $(el).closest('.root').children('.menu-items').css({'top': mTop, 'right': mRight, 'left': 'auto'}).addClass('active');
}
function hideMegamenuMenu() {
    $('#nrtmegamenu-main .menu-items.active').removeClass('active');
}
function unitActiveItem() {
    $("#nrtmegamenu-main .root").each(function() {
	var url = document.URL;
	url = url.replace("#", "");
	var url_lang_iso = "/" + langIso.substring(0, 2);
	var url_lang_iso_this = url.substring(url.lastIndexOf(baseUri) + baseUri.length - 1, url.lastIndexOf(baseUri) + baseUri.length + 2);
	if (url_lang_iso_this == url_lang_iso) {
	    var urlx = url.substring(0, url.lastIndexOf(baseUri) + baseUri.length - 1);
	    var urly = url.substring(url.lastIndexOf(baseUri) + baseUri.length + 2, url.length);
	    var url0 = urlx.concat(urly);
	} else {
	    var url0 = url;
	}
	var url1 = url0.replace(url0.substring(0, url0.indexOf("/") + 1), "");
	var url2 = url1.replace(url1.substring(0, url1.indexOf("/") + 1), "");
	var url3 = url2.replace(url2.substring(0, url2.indexOf("/")), "");
	var url4 = url.replace(url.substring(0, url.indexOf("/") + 1), "");
	var url5 = url4.replace(url4.substring(0, url4.indexOf("/") + 1), "");
	var url6 = url5.replace(url5.substring(0, url5.indexOf("/")), "");
	$(".nrtmegamenu .root .root-item a").removeClass("active");
	$('.nrtmegamenu .root .root-item a[href="' + url + '"]').addClass('active');
	$('.nrtmegamenu .root .root-item a[href="' + url0 + '"]').addClass('active');
	$('.nrtmegamenu .root .root-item a[href="' + url3 + '"]').addClass('active');
	$('.nrtmegamenu .root .root-item a[href="' + url6 + '"]').addClass('active');
    });
}
