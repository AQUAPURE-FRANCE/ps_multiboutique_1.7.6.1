$(document).ready(function() {
    function add_backgroundcolor(bgcolor) {
	$('<style type="text/css">.owl-theme .owl-dots .owl-dot span,.new_product span,.horizontal_mode .button-action i,a.slide-button:hover,#cart_block_top .cart_top_ajax a.view-cart, #footer,.product-actions .add-to-cart:hover,#blockcart-modal .cart-content .btn,.page-footer .text-xs-center a ,.page-footer a.account-link ,.products.horizontal_mode #box-product-list .action-product-list:hover,.bootstrap-touchspin .group-span-filestyle .btn-touchspin, .group-span-filestyle .bootstrap-touchspin .btn-touchspin, .group-span-filestyle .btn-default,.btn-tertiary ,.btn-primary,.btn,.cart-grid .cart-grid-body > a.label,.nrt-demo-wrap .control.inactive,.cl-row-reset .cl-reset,.button_unique:hover,#header_mobile_menu ,#header_mobile_menu .nrtmm-nav ,.box-text-product a{ background-color:#' + bgcolor + '}</style>').appendTo('head');
	$('<style type="text/css">.click-product-list-grid > div,.menu-bottom .menu-bottom-dec a:hover{ color:#' + bgcolor + '}</style>').appendTo('head');
	$('<style type="text/css">ul.tab_isotope:after,.horizontal_mode .title_text:after,.vertical_mode .title_text:after{ border-color:#' + bgcolor + '}</style>').appendTo('head');
    }
    function add_hovercolor(hcolor) {
	$('<style type="text/css">.owl-theme .owl-dots .owl-dot.active span, .owl-theme .owl-dots .owl-dot:hover span,.owl-theme .owl-nav [class*="owl-"]:hover,.nrt-slideshow-container .flex-control-paging li a:hover, .nrt-slideshow-container .flex-control-paging li a.flex-active, .nivo-controlNav a:hover, .nivo-controlNav a.active, #back-top a,#block-nav-center .sticky-fixed-top.dropdown .expand-more:hover,#cart_block_top.sticky-fixed-top .click-cart:hover,.sale_product span,.horizontal_mode .button-action:hover i,.horizontal_mode .button-action span.bg:after,.horizontal_mode .discount-percentage-product,.vertical_mode .button-action:hover,.vertical_mode .left-product .view-product:hover,.vertical_mode .discount-percentage-product,#block-nav-center .dropdown-item:hover,#block-nav-center .current .dropdown-item,#header_links .right-link a:first-child, #cart_block_top .shopping-cart .total,#cart_block_top .click-cart:hover,#cart_block_top .click-cart.active,#search_block_top .current:hover, #search_block_top .current[aria-expanded="true"],#searchbox .button-search,.outer-slide [data-u="arrowright"]:hover, .outer-slide [data-u="arrowleft"]:hover, .outer-slide [data-u="navigator"] [data-u="prototype"]:hover, .outer-slide:hover [u="navigator"], .outer-slide [data-u="navigator"] .av[data-u="prototype"],a.slide-button,.intro-box:hover,ul.tab_isotope:after,.horizontal_mode .title_text:after,.vertical_mode .title_text:after,.view a.info:hover ,.view-eighth .mask a:hover,#cart_block_top .cart_top_ajax a.view-cart:hover,.block_testimonials .owl-theme .owl-dots .owl-dot.active span,.box_categories .name_block:before,.box_categories .name_block:after,a.more-cate:hover,.footer-container .bullet ul li a:hover:before,.modal-header .close,.js-qv-mask .owl-theme .owl-controls .owl-buttons [class^="carousel-"] span:hover,.has-discount .discount,.product-actions .add-to-cart,#nrtsizechart-show:hover,#blockcart-modal .cart-content .btn:hover,.tabs .nav-tabs .nav-link:before,.page-footer .text-xs-center a:hover,.page-footer a.account-link:hover,.products.horizontal_mode #box-product-list .action-product-list,#products .item-product-list .right-product .discount-percentage-product,.products-sort-order .select-list:hover,.btn-secondary.focus, .btn-secondary:focus, .btn-secondary:hover, .btn-tertiary:focus, .btn-tertiary:hover, .focus.btn-tertiary,.btn-primary.focus,.btn-primary:focus,.btn-primary:hover,.btn:hover,.btn-primary:active,.cart-grid .cart-grid-body > a.label:hover,.pagination .current a,.pagination a:not(.disabled ):hover,#cms #cms-about-us .page-subheading ,#cms #cms-about-us .cms-line .cms-line-comp,.nrt-demo-wrap .control.active,.cl-row-reset .cl-reset:hover,.button_unique,#nrtmegamenu-main.nrtmegamenu .root:hover .root-item > a > .title,#nrtmegamenu-main.nrtmegamenu .root:hover .root-item > .title,#nrtmegamenu-main.nrtmegamenu .root.active .root-item > a > .title,#nrtmegamenu-main.nrtmegamenu .root.active .root-item > .title,#nrtmegamenu-main.nrtmegamenu .root .root-item > a.active > .title,.menu-bottom .menu-bottom-dec a,#recent_article_smart_blog_block_left .block_content ul li a.read-more:hover,.pie:before,.horizontal_mode.product-full .button-action:hover i,.product-full .owl-theme .owl-dots .owl-dot.active span, .owl-theme .owl-dots .owl-dot:hover span,.box-text-product a:hover,.newsletter .button-email, .date-post{ background-color:#' + hcolor + '}</style>').appendTo('head');
	$('<style type="text/css">.owl-theme .owl-nav [class*="owl-"],a:hover, a:focus,body#checkout a:hover,.cart-grid-body a.label:hover,.ui-menu.ui-autocomplete .ui-menu-item a.ui-state-focus .search-name-ajax, .ui-menu.ui-autocomplete .ui-menu-item a.ui-state-active .search-name-ajax,.price-ajax,.price,.vertical_mode .right-product .product_name a:hover,#block-nav-center a:hover,#block-nav-center .dropdown .expand-more:hover,#block-nav-center .dropdown .expand-more[aria-expanded=true],#cart_block_top .click-cart .cart-products-count,#cart_block_top .click-cart .cart-total-top, #search_block_top .current ,.wrapper-social-header a:hover:before,#searchbox .button-search:before ,.select-options li:hover ,.small-slide-title .color_text,.title_block .hover_color,.intro-top,ul.tab_isotope li.active,ul.tab_isotope li:hover,ul.tab_isotope li.active:before,.cart_top_ajax:before ,#cart_block_top .product-name-ajax a:hover,#cart_block_top .cart_top_ajax a.remove-from-cart:hover,#wrapper_testimonials .content_test_top p.des_namepost,.footer-container h3 a:hover,.footer-container .links ul > li a:hover,.footer-container a:hover,.footer-container .bullet ul li a:hover,.footer-container li a:hover,.social_footer a:hover,.has-discount.product-price, .has-discount p,#blockcart-modal .cart-content p,.product-price,#blockcart-modal .divide-right p.price,.tabs .nav-tabs .nav-link.active, .tabs .nav-tabs .nav-link:hover,.order-confirmation-table .text-xs-left,.order-confirmation-table .text-xs-right,#order-items table tr td:last-child,.page-my-account #content .links a:hover ,.page-my-account #content .links a:hover i,body#checkout section.checkout-step .add-address a:hover,.page-addresses .address .address-footer a:hover,.cart-summary-line .value,.product-line-grid-right .cart-line-product-actions, .product-line-grid-right .product-price,.click-product-list-grid > div:hover,.active_list .click-product-list-grid > div.click-product-list,.active_grid .click-product-list-grid > div.click-product-grid,.block-categories a:hover,.block-categories .collapse-icons .add:hover, .block-categories .collapse-icons .remove:hover,.block-categories .arrows .arrow-down:hover, .block-categories .arrows .arrow-right:hover,#search_filters .clear-all-wrapper .btn-tertiary,#search_filters .facet .facet-label.active a, #search_filters .facet .facet-label:hover a ,#search_filters .facet .facet-label.active .custom-checkbox input[type="checkbox"] + span .checkbox-checked, #search_filters .facet .facet-label:hover .custom-checkbox input[type="checkbox"] + span .checkbox-checked ,#search_filters .facet .facet-label.active .custom-checkbox input[type="radio"] + span .checkbox-checked, #search_filters .facet .facet-label:hover .custom-checkbox input[type="radio"] + span .checkbox-checked ,.popup_title p,.product-cover .layer .zoom-in,#nrtmegamenu-mobile.nrtmegamenu .root:hover .root-item > a > .title , #nrtmegamenu-mobile.nrtmegamenu .root:hover .root-item > .title , #nrtmegamenu-mobile.nrtmegamenu .root.active .root-item > a > .title , #nrtmegamenu-mobile.nrtmegamenu .root.active .root-item > .title , #nrtmegamenu-mobile.nrtmegamenu .root .root-item > a.active > .title,.nrtmegamenu .menu-item.depth-1 > .title a:hover,.nrtmegamenu > ul > li.demo_other_menu,.nrtmegamenu .demo_custom_link_cms .menu-item.depth-1 > .title a:hover ,.nrtmegamenu .submenu .title a:hover,.menu-bottom h3,.custom_link_feature li a:hover,.custom-col-html a,.custom-col-html h4 ,#recent_article_smart_blog_block_left .block_content ul li .info,.info-category span,.info-category span a,.item-countdown-full .section_cout,.right-product-full .product_name a{ color:#' + hcolor + '}</style>').appendTo('head');
	$('<style type="text/css">.owl-theme .owl-nav [class*="owl-"],.horizontal_mode .button-action span.bg:before,#block-nav-center,.outer-slide [data-u="arrowright"],.outer-slide [data-u="arrowleft"],.cart_top_ajax,#search_filters .facet .facet-label.active .custom-checkbox span.color, #search_filters .facet .facet-label:hover .custom-checkbox span.color ,#search_filters .facet .facet-label.active .custom-checkbox input[type="checkbox"] + span, #search_filters .facet .facet-label:hover .custom-checkbox input[type="checkbox"] + span ,#search_filters .facet .facet-label.active .custom-checkbox input[type="radio"] + span, #search_filters .facet .facet-label:hover .custom-checkbox input[type="radio"] + span ,.nrtmegamenu .menu-items ,#smart-blog-custom .news_module_image_holder:hover,#smart-blog-custom .date_added,.horizontal_mode.product-full .button-action:hover i,.item-countdown-full .section_cout{ border-color:#' + hcolor + '}</style>').appendTo('head');
    }
    $('.control').click(function() {
	if ($(this).hasClass('inactive')) {
	    $(this).removeClass('inactive');
	    $(this).addClass('active');
	    if (LANG_RTL == '1') {
		$('.nrt-demo-wrap').animate({right: '0'}, 500);
	    } else {
		$('.nrt-demo-wrap').animate({left: '0'}, 500);
	    }
	    $('.nrt-demo-wrap').css({'box-shadow': '0 0 10px #adadad', 'background': '#fff'});
	    $('.nrt-demo-option').animate({'opacity': '1'}, 500);
	    $('.nrt-demo-title').animate({'opacity': '1'}, 500);
	} else {
	    $(this).removeClass('active');
	    $(this).addClass('inactive');
	    if (LANG_RTL == '1') {
		$('.nrt-demo-wrap').animate({right: '-210px'}, 500);
	    } else {
		$('.nrt-demo-wrap').animate({left: '-210px'}, 500);
	    }
	    $('.nrt-demo-wrap').css({'box-shadow': 'none', 'background': 'transparent'});
	    $('.nrt-demo-option').animate({'opacity': '0'}, 500);
	    $('.nrt-demo-title').animate({'opacity': '0'}, 500);
	}
    });
    $('#backgroundColor, #hoverColor').each(function() {
	var $el = $(this);
	/* set time */var date = new Date();
	date.setTime(date.getTime() + (1440 * 60 * 1000));
	$el.ColorPicker({color: '#555555', onChange: function(hsb, hex, rgb) {
		$el.find('div').css('backgroundColor', '#' + hex);
		switch ($el.attr("id")) {
		    case 'backgroundColor' :
			add_backgroundcolor(hex);
			$.cookie('background_color_cookie', hex, {expires: date});
			break;
		    case 'hoverColor' :
			add_hovercolor(hex);
			$.cookie('hover_color_cookie', hex, {expires: date});
			break;
		    }
	    }});
    });
    /* set time */var date = new Date();
    date.setTime(date.getTime() + (1440 * 60 * 1000));
    if ($.cookie('background_color_cookie') && $.cookie('hover_color_cookie')) {
	add_backgroundcolor($.cookie('background_color_cookie'));
	add_hovercolor($.cookie('hover_color_cookie'));
	var backgr = "#" + $.cookie('background_color_cookie');
	var activegr = "#" + $.cookie('hover_color_cookie');
	$('#backgroundColor div').css({'background-color': backgr});
	$('#hoverColor div').css({'background-color': activegr});
    }
    /*Theme mode layout*/
    if (!$.cookie('mode_css') && NRT_mainLayout == "boxed"){
	$('input[name=mode_css][value=box]').attr("checked", true);
    } else if (!$.cookie('mode_css') && NRT_mainLayout == "fullwidth") {
	$('input[name=mode_css][value=wide]').attr("checked", true);
    } else if ($.cookie('mode_css') == "boxed") {
	$('body').removeClass('fullwidth');
	$('body').removeClass('boxed');
	$('body').addClass('boxed');
	$.cookie('mode_css', 'boxed');
	$.cookie('mode_css_input', 'box');
	$('input[name=mode_css][value=box]').attr("checked", true);
    } else if ($.cookie('mode_css') == "fullwidth") {
	$('body').removeClass('fullwidth');
	$('body').removeClass('boxed');
	$('body').addClass('fullwidth');
	$.cookie('mode_css', 'fullwidth');
	$.cookie('mode_css_input', 'wide');
	$('input[name=mode_css][value=wide]').attr("checked", true);
    }
    $('input[name=mode_css][value=box]').click(function() {
	$('body').removeClass('fullwidth');
	$('body').removeClass('boxed');
	$('body').addClass('boxed');
	$.cookie('mode_css', 'boxed');
        fullwidth_click();
    });
    $('input[name=mode_css][value=wide]').click(function() {
	$('body').removeClass('fullwidth');
	$('body').removeClass('boxed');
	$('body').addClass('fullwidth');
	$.cookie('mode_css', 'fullwidth');
        fullwidth_click();
    });
    $('.cl-td-layout a').click(function() {
	var id_color = this.id;
	$.cookie('background_color_cookie', id_color.substring(0, 6));
	$.cookie('hover_color_cookie', id_color.substring(7, 13));
	add_backgroundcolor($.cookie('background_color_cookie'));
	add_hovercolor($.cookie('hover_color_cookie'));
	var backgr = "#" + $.cookie('background_color_cookie');
	var activegr = "#" + $.cookie('hover_color_cookie');
	$('#backgroundColor div').css({'background-color': backgr});
	$('#hoverColor div').css({'background-color': activegr});
    });
    /*reset button*/$('.cl-reset').click(function() {
	/* Color */$.cookie('background_color_cookie', '');
	$.cookie('hover_color_cookie', '');
	/* Mode layout */$.cookie('mode_css', '');
	location.reload();
    });
    function fullwidth_click(){
        $('.nrtFullWidth').each(function() {
                var t = $(this);
                var fullwidth = $('#page').width(),
                    margin_full = fullwidth/2;
        if (LANG_RTL != 1) {
                t.css({'left': '50%', 'position': 'relative', 'width': fullwidth, 'margin-left': -margin_full});
        } else{
                t.css({'right': '50%', 'position': 'relative', 'width': fullwidth, 'margin-right': -margin_full});
        }
    });
    }
});