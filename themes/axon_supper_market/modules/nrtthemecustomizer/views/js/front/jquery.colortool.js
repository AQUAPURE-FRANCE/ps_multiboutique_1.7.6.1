$(document).ready(function() {
    function add_backgroundcolor(bgcolor) {
	$('<style type="text/css">.owl-theme .owl-nav [class*="owl-"],.new_product span,#searchbox .button-search:hover, .outer-slide [data-u="arrowright"],.outer-slide [data-u="arrowleft"],.outer-slide [data-u="arrowright"]:hover,a.slide-button:hover,#cart_block_top .cart_top_ajax a.view-cart,.product-quantity #quantity_wanted ,.product-quantity .input-group-btn-vertical .btn ,#add-to-cart-or-refresh .button-action,.product-actions .add-to-cart:hover,#nrtsizechart-show,#blockcart-modal .cart-content-btn .btn,#blockcart-modal .cart-content-btn a.btn:hover,.page-footer .text-sm-center a ,.page-footer a.account-link ,#box-product-list .button-action:hover,.bootstrap-touchspin .group-span-filestyle .btn-touchspin, .group-span-filestyle .bootstrap-touchspin .btn-touchspin, .group-span-filestyle .btn-default,.btn-tertiary ,.btn-primary,.btn,.cart-grid .cart-grid-body > a.label,.pagination a,.nrt-demo-wrap .control.inactive,.cl-row-reset .cl-reset,.button_unique:hover,.active.nav-button,.horizontal_mode.product-full button.button-action-full:hover,.box-text-product a,.cl-row-reset .cl-reset ,.wapper_video a:hover,.background-overlay,#bar-left-column.active,#bar-right-column.active,.sticky-fixed-top #cart_block_top .click-cart .cart-products-count,.product-full:after{ background-color:#' + bgcolor + '}</style>').appendTo('head');
	$('<style type="text/css">#searchbox .button-search:hover:before,.click-product-list-grid > div,#nrtmegamenu-main.nrtmegamenu .root:hover .root-item > a > .title,#nrtmegamenu-main.nrtmegamenu .root:hover .root-item > .title,#nrtmegamenu-main.nrtmegamenu .root.active .root-item > a > .title,#nrtmegamenu-main.nrtmegamenu .root.active .root-item > .title,#nrtmegamenu-main.nrtmegamenu .root .root-item > a.active > .title{ color:#' + bgcolor + '}</style>').appendTo('head');
	$('<style type="text/css">.owl-theme .owl-dots .owl-dot span,.horizontal_mode .title_text:after,.vertical_mode .title_text:after,.horizontal_mode.product-full .button-action-full,.horizontal_mode.product-full button.button-action-full:hover{ border-color:#' + bgcolor + '}</style>').appendTo('head');
    }
    function add_hovercolor(hcolor) {
	$('<style type="text/css">.owl-theme .owl-nav [class*="owl-"]:hover,.nrt-slideshow-container .flex-control-paging li a:hover, .nrt-slideshow-container .flex-control-paging li a.flex-active, .nivo-controlNav a:hover, .nivo-controlNav a.active,#wrapper_menu,#block-nav-center .sticky-fixed-top.dropdown .expand-more:hover,#cart_block_top.sticky-fixed-top .click-cart:hover,.sale_product span,.horizontal_mode .button-action:hover,.right-product .product-price-and-shipping span.line_product:before,.horizontal_mode .discount-percentage-product,.vertical_mode .button-action:hover,.vertical_mode .left-product .view-product:hover,.vertical_mode .discount-percentage-product,#block-nav-center .dropdown-item:hover,#block-nav-center .current .dropdown-item,#header_links .right-link a:first-child, #cart_block_top .shopping-cart .total,#cart_block_top .click-cart .cart-products-count,.outer-slide [data-u="arrowright"],.outer-slide [data-u="arrowleft"]:hover, .outer-slide [data-u="navigator"] [data-u="prototype"]:hover, .outer-slide:hover [u="navigator"], .outer-slide [data-u="navigator"] .av[data-u="prototype"],a.slide-button,.intro-top span,.horizontal_mode .title_text:after,.vertical_mode .title_text:after,.view a.info:hover ,.view-eighth .mask a:hover,#cart_block_top .cart_top_ajax a.view-cart:hover,.block_testimonials .owl-theme .owl-dots .owl-dot.active span,.box_categories .name_block:before,.box_categories .name_block:after,a.more-cate:hover,#tags_block_left a:hover,.js-qv-mask .owl-theme .owl-controls .owl-buttons [class^="carousel-"] span:hover,.has-discount .discount,#add-to-cart-or-refresh .button-action:hover,.product-actions .add-to-cart,#nrtsizechart-show:hover,#blockcart-modal .cart-content-btn .btn:hover,#blockcart-modal .cart-content-btn a.btn,.tabs .nav-tabs .nav-link:before,.page-footer .text-sm-center a:hover,.page-footer a.account-link:hover,#box-product-list .button-action,#box-product-list .button-action-view:hover,#products .item-product-list .right-product .discount-percentage-product,.products-sort-order .select-list:hover,.btn-secondary.focus, .btn-secondary:focus, .btn-secondary:hover, .btn-tertiary:focus, .btn-tertiary:hover, .focus.btn-tertiary,.btn-primary.focus,.btn-primary:focus,.btn-primary:hover,.btn:hover,.btn-primary:active,.cart-grid .cart-grid-body > a.label:hover,.pagination .current a,.pagination a:not(.disabled ):hover,.cms-box a,#cms #cms-about-us .cms-line .cms-line-comp:before,.nrt-demo-wrap .control.active,.cl-row-reset .cl-reset:hover,.button_unique,.menu-bottom .menu-bottom-dec a,.read-more-blog:hover,.pie:before,.horizontal_mode.product-full button.button-action-full,.horizontal_mode.product-full .button-action-full:hover,.horizontal_mode.product-full .button-action:hover i,.box-text-product a:hover, .date-post,.cl-row-reset .cl-reset:hover ,#nav-mobile,.wapper_video a,.remove_to_compare,.tparrows:hover,.item-countdown-box,#back-top,#goto-compare,#bar-left-column,#bar-right-column,#back-top,#goto-compare,.product-full:before,.tab_by_categories .ui-tabs .ui-tabs-nav li.ui-tabs-active a .img_tab img,.tab_by_categories .ui-tabs .ui-tabs-nav li a:hover .img_tab img,.vertical_tab .ui-tabs .ui-tabs-nav{ background-color:#' + hcolor + '}</style>').appendTo('head');
	$('<style type="text/css">.ui-tabs .ui-tabs-nav li.ui-tabs-active a,.ui-tabs .ui-tabs-nav li a:hover,#header a:hover,a:hover, a:focus,body#checkout a:hover,.cart-grid-body a.label:hover,.ui-menu.ui-autocomplete .ui-menu-item a.ui-state-focus .search-name-ajax, .ui-menu.ui-autocomplete .ui-menu-item a.ui-state-active .search-name-ajax,.price-ajax,.horizontal_mode .item-inner .right-product .product_name a:hover,.box-content-wishlist span:hover,div.star::after,div.star.star_on::after,.star_content div.star.star_hover:after ,#moda_productcomment .modal-header h2,.label_rating,#product_comments_block_tab .comment_author > span,#product_comments_block_tab .report_btn,.price,.vertical_mode .right-product .product_name a:hover,#block-nav-center a:hover,#block-nav-center .dropdown .expand-more span.fa,#block-nav-center .dropdown .expand-more:hover,#block-nav-center .dropdown .expand-more[aria-expanded=true],#cart_block_top .click-cart:hover,.active_cart #cart_block_top .click-cart,#cart_block_top .click-cart .cart-total-top,.wrapper-social-header a:hover:before,#searchbox .button-search:before ,.select-options li:hover ,.small-slide-title .color_text,.title_block .hover_color,.cart_top_ajax:before ,#cart_block_top .product-name-ajax a:hover,#cart_block_top .cart_top_ajax a.remove-from-cart:hover,#wrapper_testimonials .content_test_top p.des_company,.footer-container h3 a:hover,.footer-container .links ul > li a:hover,.footer-container a:hover,.footer-container .bullet ul li a:hover,.footer-container li a:hover,.footer-address a,.modal-header .close span:before,.has-discount.product-price, .has-discount p,#blockcart-modal .cart-content p ,#blockcart-modal .divide-right p,.product-price,#blockcart-modal .divide-right p.price,.tabs .nav-tabs .nav-link.active, .tabs .nav-tabs .nav-link:hover,#wrapper .breadcrumb li a:hover,.order-confirmation-table .text-xs-left,.order-confirmation-table .text-xs-right,#order-items table tr td:last-child,.page-my-account #content .links a:hover ,.page-my-account #content .links a i,.wrapper-tab.myaccount .links a i ,.page-my-account #content .links a:hover i,.left-avm ,body#checkout section.checkout-step .add-address a:hover,.page-addresses .address .address-footer a:hover,.cart-summary-line .value,.product-line-grid-right .cart-line-product-actions, .product-line-grid-right .product-price,.click-product-list-grid > div:hover,.active_list .click-product-list-grid > div.click-product-list,.active_grid .click-product-list-grid > div.click-product-grid,.block-categories a:hover,.block-categories .collapse-icons .add:hover, .block-categories .collapse-icons .remove:hover,.block-categories .arrows .arrow-down:hover, .block-categories .arrows .arrow-right:hover,#search_filters .clear-all-wrapper .btn-tertiary,#search_filters .facet .facet-label.active a, #search_filters .facet .facet-label:hover a ,#search_filters .facet .facet-label.active .custom-checkbox input[type="checkbox"] + span .checkbox-checked, #search_filters .facet .facet-label:hover .custom-checkbox input[type="checkbox"] + span .checkbox-checked ,#search_filters .facet .facet-label.active .custom-checkbox input[type="radio"] + span .checkbox-checked, #search_filters .facet .facet-label:hover .custom-checkbox input[type="radio"] + span .checkbox-checked ,.cms-box .welcome_cms span,#cms #cms-about-us .cms-line .label,.product-cover .layer .zoom-in,#header .nrtmegamenu .submenu .title a:hover,.goto_page,#nrtmegamenu-mobile.nrtmegamenu .root:hover .root-item > a > .title , #nrtmegamenu-mobile.nrtmegamenu .root:hover .root-item > .title , #nrtmegamenu-mobile.nrtmegamenu .root.active .root-item > a > .title , #nrtmegamenu-mobile.nrtmegamenu .root.active .root-item > .title , #nrtmegamenu-mobile.nrtmegamenu .root .root-item > a.active > .title,.nrtmegamenu .menu-item.depth-1 > .title a:hover,.nrtmegamenu .demo_custom_link_cms .menu-item.depth-1 > .title a:hover ,.nrtmegamenu .submenu .title a:hover,.menu-bottom h3,.custom_link_feature li a:hover,.custom-col-html a,.custom-col-html h4 ,#smart-blog-custom .sds_post_title a:hover,#recent_article_smart_blog_block_left .block_content ul li a.read-more:hover,#recent_article_smart_blog_block_left .block_content ul li .info,.info-category span,.info-category span a,.item-countdown-full .section_cout,.arrows_oncolum .owl-theme .owl-nav [class*="owl-"]:hover,#header_mobile_menu .navbar-toggler:hover,#header .has-sub.drop-menu:hover >.title a,.v-megamenu > ul > li:hover a.opener,.v-megamenu > ul > li.more-vmegamenu:hover,#_mobile_vmegamenu > .v-megamenuitem .navbar-toggler:hover,.tab_by_categories .ui-tabs .ui-tabs-nav li.ui-tabs-active a,.tab_by_categories .ui-tabs .ui-tabs-nav li a:hover,.tab_by_categories .ui-tabs .ui-tabs-nav li a .quantity_products span{ color:#' + hcolor + '}</style>').appendTo('head');
	$('<style type="text/css">.owl-theme .owl-dots .owl-dot.active span, .owl-theme .owl-dots .owl-dot:hover span,.title_block,#slide-panel .owl-theme .owl-dots .active img,#slide-panel .owl-theme .owl-dots img:hover,.footer-container .bullet ul li a:hover:before,.products-selection ,.block-categories,#search_filters,#search_filters .facet .facet-label.active .custom-checkbox span.color, #search_filters .facet .facet-label:hover .custom-checkbox span.color ,#search_filters .facet .facet-label.active .custom-checkbox input[type="checkbox"] + span, #search_filters .facet .facet-label:hover .custom-checkbox input[type="checkbox"] + span ,#search_filters .facet .facet-label.active .custom-checkbox input[type="radio"] + span, #search_filters .facet .facet-label:hover .custom-checkbox input[type="radio"] + span ,#smart-blog-custom .news_module_image_holder:hover,.horizontal_mode.product-full button.button-action-full,.horizontal_mode.product-full .button-action-full:hover,.horizontal_mode.product-full .button-action:hover i,.item-countdown-full .section_cout,#_mobile_language a.current,#_mobile_language a:hover,#_mobile_currency a.current,#_mobile_currency a:hover, .numbers_count:before,#category #left-column #search_filters{ border-color:#' + hcolor + '}</style>').appendTo('head');
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
    });
    $('input[name=mode_css][value=wide]').click(function() {
	$('body').removeClass('fullwidth');
	$('body').removeClass('boxed');
	$('body').addClass('fullwidth');
	$.cookie('mode_css', 'fullwidth');
    });
    $('.cl-tr-style-hover a').click(function() {
		var id_color = this.id;
		$.cookie('hover_color_cookie',id_color);
		add_hovercolor($.cookie('hover_color_cookie'));
		var activegr = "#" + $.cookie('hover_color_cookie');
		$('#hoverColor div').css({'background-color': activegr});
    });
    $('.cl-tr-style-curent a').click(function() {
		var id_color = this.id;
		$.cookie('background_color_cookie', id_color);
		add_backgroundcolor($.cookie('background_color_cookie'));
		var backgr = "#" + $.cookie('background_color_cookie');
		$('#backgroundColor div').css({'background-color': backgr});
    });
    /*reset button*/$('.cl-reset').click(function() {
	/* Color */$.cookie('background_color_cookie', '');
	$.cookie('hover_color_cookie', '');
	/* Mode layout */$.cookie('mode_css', '');
	location.reload();
    });
});