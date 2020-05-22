/*
 * Custom code goes here.
 * A template should always ship with an empty custom.js
 */

var AQUATHEME = {
	init:function(){

		AQUATHEME.HeadTitle();
		AQUATHEME.search_open();
		AQUATHEME.init_accordion();
		AQUATHEME.init_toggle();
		AQUATHEME.init_tabs();
// 		AQUATHEME.init_star_rating();
// 		AQUATHEME.cws_touch_events_fix();

	},
	
	/*!
	Category Header Trick
	*/
	HeadTitle:function(){
		var checkTitle = jQuery("h1.h1").text();
		var checkPage = jQuery("body").attr("id");
		if(checkPage == "dorSmartBlogs"){
			checkTitle = jQuery(".info-title-blog > h1").text();
		}
		if(typeof checkTitle == "undefined" || checkTitle == null || checkTitle.length == 0){
			checkTitle = jQuery(".page-header h1").text();
		}
		if(typeof checkTitle == "undefined" || checkTitle == null || checkTitle.length == 0){
			checkTitle = jQuery(".title-head-card").text();
		}
		if(typeof checkTitle == "undefined" || checkTitle == null || checkTitle.length == 0){
			checkTitle = jQuery("#main > h2.h2").text();
		}
		if(typeof checkPage != "undefined" && checkPage != "category" && checkPage != "product" && typeof checkTitle != "undefined" && checkTitle != null && checkTitle.length > 0){
			jQuery("h1.category-name").text(checkTitle);
			jQuery("h1.h1").remove();
			jQuery(".page-header").remove();
			jQuery(".title-head-card").remove();
			jQuery("#main > h2.h2").remove();
		}
	},
	
	/*!
	Sliding Search Bar
	*/
	search_open: function () {
    $('.search-icon').on('click', function (){
      $('#search_block_top').addClass('open-search');
      return false;
      if($('#block-header-center').hasClass('transparent')) {
        $('#block-header-center').addClass('v-hidden')
      }
    })
    $('.search-close-button').on('click', function() {
      $('#search_block_top').removeClass('open-search');
      $('#block-header-center').removeClass('v-hidden');
    })
	},

	/*!
	Menu adaptor
	*/
/*
	cws_touch_events_fix: function (){
	  if ( is_mobile_device() ){
	    jQuery( ".container" ).on( "mouseenter", ".hover-effect, .product .pic", function (e){
	      e.preventDefault();
	      jQuery( this ).trigger( "hover" );
	    });
	    jQuery( ".main-nav" ).on( "hover", ".mobile_nav .button_open, .mobile_nav li > a", function ( e ){
	      e.preventDefault();
	      jQuery( this ).trigger( "click" );
	    });
	  }
	},
*/


	/*!
	Accordion
	*/
	init_accordion: function () {
	    $(".accordion").each(function() {
	        var allPanels = $(this).children('.content').hide();
	        allPanels.first().slideDown("easeOutExpo");
	        $(this).children('.content-title').first().addClass("active");
	
	        $(this).children('.content-title').on('click', function(){
	
	            var current = $(this).next(".content");
	            $(this).parent().children('.content-title').removeClass("active");
	            $(this).addClass("active");
	            allPanels.not(current).slideUp("easeInExpo");
	            $(this).next().slideDown("easeOutExpo");
	
	            return false;
	
	        });
	    })
	
	},

	/*!
	Toggle
	*/	
	init_toggle: function () {
	    $(".toggle > .content").hide();
	    $(".toggle > .content-title.active").next().slideDown();
	    $(".toggle > .content-title").on('click', function(){
	
	        if ($(this).hasClass("active")) {
	
	            $(this).next().slideUp("easeOutExpo");
	            $(this).removeClass("active");
	
	        }
	        else {
	            var current = $(this).next(".content");
	            $(this).addClass("active");
	            $(this).next().slideDown("easeOutExpo");
	        }
	
	        return false;
	    });
	},

	/**/
	/*  Tabs  */
	/**/
	init_tabs: function () {
		$(".tabs .tabs-btn").on( 'click', function() {
		  var idBtn = ($(this).attr("data-tabs-id"));
		  var containerList = $(this).parents(".tabs").find(".container-tabs");
		  var f = $(".tabs [data-tabs-id=cont-"+idBtn+"]");
		
		  $(f).addClass("active").siblings(".container-tabs").removeClass('active');
		  $(containerList).fadeOut( 0 );
		  $(f).fadeIn( 300 );
		  $(this).addClass("active").siblings(".tabs-btn").removeClass('active');
		});
	},
	
	/**/
	/* MARK */
	/**/
/*
	init_star_rating: function() {
	  var stars_active = false;
	  var mark
	  var rating
	
	  $(".stars").on("mouseover", function() {
	    if (!stars_active) {
	      $(this).find("span:not(.stars-active)").append("<span class='stars-active' data-set='no'>&#xf005;&#xf005;&#xf005;&#xf005;&#xf005;</span>");
	      stars_active = true;
	    }
	  });
	  $(".stars").on("mousemove", function (e) {
	    var cursor = e.pageX;
	    var ofs = $(this).offset().left;
	    var fill = cursor - ofs;
	    var width = $(this).width(); 
	    var persent = Math.round(100*fill/width);
	
	    $(".stars span a").css({"line-height":String((width+1)/5)+"px","width":String(width/5)+"px"})
	    $(".stars span .stars-active").css("margin-top","0px");
	    $(this).find(".stars-active").css('width',String(persent)+"%");
	    $(".stars-active").removeClass("fixed-mark");
	
	  });
	  $(".stars").on("click", function (e){
	    var cursor = e.pageX;
	    var ofs = $(this).offset().left;
	    var fill = cursor - ofs;
	    var width = $(this).width(); 
	    var persent = Math.round(100*fill/width);
	
	    mark = $(this).find(".stars-active");
	    mark.css('width',String(persent)+"%").attr("data-set",String(persent));
	    rating = $( this ).closest( '#respond' ).find( '#rating' );
	    rating.val( $($(this).find("span a[class*='star-']")[Math.ceil((persent).toFixed(2)/20)-1]).text());
	  });
	  $(".stars").on("mouseleave", function (e){
	    if ($(mark).attr("data-set") == "no"){
	      mark.css("width","0");
	    }
	    else{
	      var persent = $(mark).attr("data-set");
	      $(mark).css("width",String(persent)+"%");
	      $(".stars-active").addClass("fixed-mark");
	    }
	  });
	},
*/

}
jQuery(document).ready(function(){
	AQUATHEME.init();
	counter();
    $(window).on('scroll', progress_bar_loader);
    progress_bar_loader();
	
});


/*!
 * WooCommerce Add to Cart JS
 */
/*
jQuery(function(a) {
    return "undefined" != typeof wc_add_to_cart_params && void a(document).on("click", ".add_to_cart_button", function() {
            var b = a(this);
            if (b.is(".ajax_add_to_cart")) {
                if (!b.attr("data-product_id"))
                    return !0;
                b.removeClass("added"), b.addClass("loading");
                var c = {};
                return a.each(b.data(), function(a, b) {
                    c[a] = b
                }), a(document.body).trigger("adding_to_cart", [b, c]), a.post(wc_add_to_cart_params.wc_ajax_url.toString().replace("%%endpoint%%", "add_to_cart"), c, function(c) {
                    if (c) {
                        var d = window.location.toString();
                        if (d = d.replace("add-to-cart", "added-to-cart"), c.error && c.product_url)
                            return void (window.location = c.product_url);
                        if ("yes" === wc_add_to_cart_params.cart_redirect_after_add)
                            return void (window.location = wc_add_to_cart_params.cart_url);
                        b.removeClass("loading");
                        var e = c.fragments,
                            f = c.cart_hash;
                        e && a.each(e, function(b) {
                            a(b).addClass("updating")
                        }), a(".shop_table.cart, .updating, .cart_totals").fadeTo("400", "0.6").block({
                            message: null,
                            overlayCSS: {
                                opacity: .6
                            }
                        }), b.addClass("added"), wc_add_to_cart_params.is_cart || 0 !== b.parent().find(".added_to_cart").length || b.after(' <a href="' + wc_add_to_cart_params.cart_url + '" class="added_to_cart wc-forward" title="' + wc_add_to_cart_params.i18n_view_cart + '">' + wc_add_to_cart_params.i18n_view_cart + "</a>"), e && a.each(e, function(b, c) {
                            a(b).replaceWith(c)
                        }), a(".widget_shopping_cart, .updating").stop(!0).css("opacity", "1").unblock(), a(".shop_table.cart").load(d + " .shop_table.cart:eq(0) > *", function() {
                            a(".shop_table.cart").stop(!0).css("opacity", "1").unblock(), a(document.body).trigger("cart_page_refreshed")
                        }), a(".cart_totals").load(d + " .cart_totals:eq(0) > *", function() {
                            a(".cart_totals").stop(!0).css("opacity", "1").unblock()
                        }), a(document.body).trigger("added_to_cart", [e, f, b])
                    }
                }), !1
            }
            return !0
        })
});
*/


/*!
Scroll Starting Counter
*/
var is_count = true
function counter (){
    if($(".counter").length) {
        var winScr = $(window).scrollTop();
        var winHeight = $(window).height();
        var ofs = $('.counter').offset().top;

        $(window).on('scroll',function(){
            winScr = $(window).scrollTop();
            winHeight = $(window).height();
            ofs = $('.counter').offset().top;

            if ( (winScr+winHeight)>ofs && is_count) {
                $(".counter").each(function () {
                    var atr = $(this).attr('id').replace("c", "");
                    var item = $(this);
                    var n = atr;
                    var d = 0;
                    var c;
                 
                    $(item).text(d);
                    var interval = setInterval(function() {
                        c = atr/70;
                        d+=c;
                        if ( (atr-d)<c) {
                            d=atr;
                        }
                        $(item).text(Math.floor(d) );

                        if (d==atr) {
                            clearInterval(interval);
                        }
                    },50);
                });
                is_count = false;
            }
        })
    }
}


/**/
/*  Skill bar  */
/**/
function progress_bar_loader (){
    if (!is_mobile_device()){
        $('.skill-bar-progress').each(function(){
          var el = this;

          if (is_visible(el)){
            if ($(el).attr("processed")!="true"){
              $(el).css("width","0%");
              $(el).attr("processed","true");
              var val = parseInt($(el).attr('id').replace("b", ""), 10);
              var fill = 0;
              var speed = val/100; 

              var timer = setInterval(function (){
                if (fill<val){
                  fill += 1;
                  $(el).css("width",String(fill)+"%");
                  var ind = $(el).parent().parent().find(".skill-bar-perc");
                  $(ind).text(fill+"%");
                }
              },(10/speed));      
            }
          }
        });
      } else {
        $(".skill-bar-progress").each(function(){
          var el = this;
          var fill = $(el).attr('id').replace("b", "");
          var ind = $(el).parent().parent().find(".skill-bar-perc");

          $(el).css('width',fill+'%');
          $(ind).text(fill+"%");
        });
    }
}

// Is Visible to strat animation Skill bar
function is_visible (el){
    var w_h = $(window).height();
    var dif = $(el).offset().top - $(window).scrollTop();

    if ((dif > 0) && (dif<w_h)){
        return true;

    } else {
        return false;
    }
}

/**/
/* mobile device detect */
/**/
function is_mobile_device () {
  if ( ( $(window).width()<767) || (navigator.userAgent.match(/(Android|iPhone|iPod|iPad)/) ) ) {
    return true;
  } else {
    return false;
  }
}

/*
 * Customize universe slider on homepage
 */
DOM = {
    shops: ['aquahome', 'nomadwater', 'motionwater', 'aquaspring', 'aquahosting'],
    timeEffect: 600,
    all_li: function () { return document.querySelectorAll('.ui-tabs-nav .nav-item') },
    all_liLinks: function () { return document.querySelectorAll('.ui-tabs-nav .nav-item a.ui-tabs-anchor') },
    all_tabs: function () { return document.querySelectorAll('.content-15 .tab_home.ui-tabs .tab-content .tab-pane'); },
    container: function () { return document.querySelector('main .content-15') },
    tabContent: function () { return document.querySelector('.content-15 .tab_home .tab-content') },
    tabsParent: function () { return document.getElementById('tabs') },

    // Initialize when DOM is loaded
    init: function () {
        //DOM.tabContent().style.minHeight = '478px';
        slideUpEffect('class', this.tabContent().className, null);
        slideUpEffect('id', this.tabsParent().id);

        this.all_li().forEach(li => li.classList.add('mouseEnter'));

        // Redirect to shops when clicking on li elements
        this.all_liLinks().forEach((li) => {
            let hostName;
            li.style.cursor = 'pointer';
            li.style.transition = 'all';

            // Create url to be redirected on click on li elements
            li.childNodes.forEach((child, i) => {
                if (child.nodeName === 'DIV' && child.className === 'title_tab') {
                    hostName = li.childNodes[i].textContent.toLowerCase();
                    li.addEventListener('click', (e) => {
                        let url = window.location.href = 'http://' + hostName + '.fr';
                    });
                }
            });
        });
    }
};

// Initializing when DOM is loaded
window.addEventListener('DOMContentLoaded', () => {
    DOM.init();
    hideInactiveLi();
    DOM.all_li().forEach(li => li.addEventListener('mouseenter', mouseEnter));
});

// Show products of current category on mouseenter
const mouseEnter = (event) => {
    let li;
    if (event.currentTarget.classList.contains('mouseEnter')) {
        li = event.currentTarget;

        if (sessionStorage.getItem('li') !== li.getAttribute('aria-controls')) {
            slideUpEffect('id', DOM.tabsParent().id);
        }
        slideDownEffect('class', DOM.tabContent().className, li);
    }
};

function slideDownEffect (selector, value, li) {
    let element;
    if (selector === 'id') {
        element = $('#' + value);
    } else if (selector === 'class') {
        element = $('.' + value);
    }
    element.stop(true, true).slideDown(DOM.timeEffect, function () {
        sessionStorage.setItem('li', li.getAttribute('aria-controls'));

        hideInactiveLi(); // Hide all inactive li
        hideInactiveTabs(); // Hide all inactive tabs
        displayAndShowActiveLi(li); // Display and show active li

        let currentTab = document.getElementById(li.getAttribute('aria-controls'));
        displayAndShowActiveTab(currentTab); // Display current tab
        //document.querySelector('#' + currentTab.id + ' ' + '.owl-carousel.owl-theme')
         //   .classList.toggle('owl-hidden');

        $('#' + DOM.tabsParent().id).slideDown(DOM.timeEffect);
    });
}

function slideUpEffect (selector, value) {
    let element;
    if (selector === 'id') {
        element = $('#' + value);
    } else if (selector === 'class') {
        element = $('.' + value);
    }
    element.fadeOut('slow');
    element.stop(true, true).slideUp(DOM.timeEffect);
}

// Hide all products of inactive categories
const hideInactiveLi = () => {
    removeOrSetAttribute(DOM.all_li(), 'class', null,'ui-tabs-active', 'ui-state-active');
    removeOrSetAttribute(DOM.all_li(), 'aria-selected', null, 'false');
    removeOrSetAttribute(DOM.all_li(), 'tabindex', null, -1);
    removeOrSetAttribute(DOM.all_liLinks(), 'class', null,'active');
};

// Show all products od current category
const displayAndShowActiveLi = (element) => {
    let li = element;
    //li.classList.add('ui-tabs-active', 'ui-state-active');
    li.childNodes[1].classList.add('active');
    li.setAttribute('aria-selected', true);
    li.setAttribute('tabindex', 0);
    li.style.backgroundColor = 'white';
    li.style.boxShadow = '0 -7px 15px -12px';

    switch (li.querySelector('.title_tab').textContent.toLowerCase()) {
        case DOM.shops.aquahome:
            li.classList.add('aquahome');
            break;
        case 'nomadwater':
            li.classList.add('nomadwater');
            break;
        case 'motionwater':
            li.classList.add('motionwater');
            break;
        case 'aquaspring':
            li.classList.add('aquaspring');
            break;
        case 'aquahosting':
            li.classList.add('aquahosting');
            break;
    }
};

// Hide all inactive tabs
const hideInactiveTabs = () => {
    removeOrSetAttribute(DOM.all_tabs(), 'aria-expanded', null, false);
    removeOrSetAttribute(DOM.all_tabs(), 'aria-hidden', null, true);
    DOM.all_tabs().forEach(tab => {
        tab.classList.remove('active');
        tab.style.display = 'none';
       // document.querySelector('#' + tab.id + ' ' + '.owl-carousel.owl-theme').classList.add('owl-hidden');
    });
};

// Display current tab
const displayAndShowActiveTab = (tab) => {
    tab.classList.add('active');
    tab.setAttribute('aria-expanded', true);
    tab.setAttribute('aria-hidden', false);
    tab.style.display = 'block';
};

// Setting existing attributes
const removeOrSetAttribute = (DOMarray, attr, property = null, ...values) => {
    DOMarray.forEach((el) => {
        values.forEach((value) => {
            if (attr === 'class') {
                el.classList.remove(value);
                el.style.backgroundColor = 'transparent';
                el.style.boxShadow = 'none';
            } else if (property === 'display') {
                el.style.display = value;
            } else {
                el.setAttribute(attr, value);
            }
        });
    });
};

console.log(DOM.shops[0]);