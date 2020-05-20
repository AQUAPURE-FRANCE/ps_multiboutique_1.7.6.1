/*********************************************************************************
 * 			MODIFY ID, NAME & VALUE ATTRIBUTES ON TECHNOLOGIES SECTION
 *********************************************************************************/

(function () {
	const NrtHomepageAjax = {
		DOM: {
			productId: '#product_page_product_id',
			tokenName: 'form input[name="token"]',
			customizationId: '#product_customization_id',
			quantityWanted: '#quantity_wanted',
			contentClass: '.content-76',
			invisibleInputId: 'form input[_id]',
			productVariantsClass: 'form .product-variants',
			pathNamePage: '/aquahome/fr/',
			noAttrMsg: 'Element ---nodeName--- has no attribute ---attr---'
		},

		addUnderscore(element, attr) {
			if (!element.hasAttribute('_' + attr)) {
				element.setAttribute('_' + attr, element.getAttribute(attr))
			}
		},

		makeFormVisible(element) { this.makeAttributeVisible(element, 'id') },

		makeFormInvisible(element) {
			let form = element.closest('form');
			['id', 'action'].map(attr => {
				this.addUnderscore(form, attr);
				form.removeAttribute(attr);
			});
		},

		makeAttributeVisible(element, attrs) {
			attrs.map(attr => {
				let _attr = '_' + attr;
				if (target.hasAttribute(_attr)) {
					element.setAttribute(attr.replace(/_/, ''), element.getAttribute(attr));
					element.removeAttribute(attr);
				} else {
					console.log(this.DOM.noAttrMsg.replace(/---nodeName---/, element.nodeName).replace(/---attr---/, attr));
				}
			});
		},

		makeAttributeInvisible(element, attrs) {
			attrs[0].map(attr => {
				if (element.hasAttribute(attr)) {
					this.addUnderscore(element, attr);
					element.removeAttribute(attr);
				} else {
					console.log(this.DOM.noAttrMsg.replace(/---nodeName---/, element.nodeName).replace(/---attr---/, attr));
				}
			});
		},

		getInactiveTabs(id = null) {
			let inactiveTabs = [];
			document.querySelector(this.DOM.contentClass).querySelectorAll('[data-toggle]').forEach(link => {
				if (link.href.match(/#content-tab/) !== null) {
					let tab = document.querySelector(link.href.replace(/.*(?=#content-tab-)/, ''));
					if (tab.id !== id) {
						inactiveTabs.push(tab);
					}
				}
			});
			return inactiveTabs;
		},

		makeTabActive(link, targetSelector, ...attrs) {
			let tab = document.querySelector(link.href.replace(/.*(?=#content-tab-)/, ''));
			this.makeFormVisible(tab);

			let target = tab.querySelector(this.DOM.invisibleInputId);

			if (target !== null) {
				this.makeAttributeVisible(target, attrs);
			}
		},

		removeTabAttributes(selector, idTab = null, ...attrs) {
			let element, tabs = this.getInactiveTabs(idTab);
			for (let i = 0; i < tabs.length; i++) {
				element = tabs[i].querySelector(selector);
				this.makeFormInvisible(element);
				this.makeAttributeInvisible(element, attrs);
			}
		},

		onload(selector, ...attrs) { this.removeTabAttributes(selector, this.getInactiveTabs()[0].id, attrs) },

		init() {
			if (window.location.pathname === this.DOM.pathNamePage) {
				this.onload(this.DOM.productId, 'id', 'name', 'value');
				this.onload(this.DOM.tokenName, 'name', 'value');
				this.onload(this.DOM.customizationId, 'id', 'name', 'value');
				this.onload(this.DOM.productVariantsClass, 'class');
				this.onload(this.DOM.quantityWanted, 'id', 'name');

				document.addEventListener('DOMContentLoaded', () => {
					document.addEventListener('click', Event => {
						if (Event.target.classList.contains('ui-tabs-anchor') && Event.target.closest(this.DOM.contentClass)) {
							let idTab = Event.target.href.replace(/.*(?=content-tab-\d+)/, '');

							this.makeTabActive(Event.target, this.DOM.productId, 'id', 'name', 'value');
							this.removeTabAttributes(this.DOM.productId, idTab, 'id', 'name', 'value');
							this.removeTabAttributes(this.DOM.tokenName, idTab, 'name', 'value');
							this.removeTabAttributes(this.DOM.customizationId, idTab, 'id', 'name', 'value');
						}
					});
				});
			}
		},
	};
	NrtHomepageAjax.init();
}());

/*
 * Custom code goes here.
 * A template should always ship with an empty custom.js
 */

$(document).ready(function(){	
	/**/
	/* Search Widget */
	/**/
	$(".icon-search").click(function(){
    	$(".icon-search, #search_block_top").toggleClass("search-open");
  	});

	/**/
	/* Contact Form Widget */
	/**/
	$(".contact-iconmenu").click(function(){
		$(".contactform_menu").toggleClass("active")
	});
    
    /**/
	/* fancybox */
	/**/
	
	if ($(".fancy").length) {
		$(".fancy").fancybox();
		$('.fancybox').fancybox({
			helpers: {
				media: {}
			}
		});
	}	
	
	/**/
	/*  Tabs  */
	/**/	
	$(".tabs .tabs-btn").on( 'click', function() {
		var idBtn = ($(this).attr("data-tabs-id"));
		var containerList = $(this).parents(".tabs").find(".container-tabs");
		var f = $(".tabs [data-tabs-id=cont-"+idBtn+"]");
		
		$(f).addClass("active").siblings(".container-tabs").removeClass('active');
		$(containerList).fadeOut( 0 );
		$(f).fadeIn( 300 );
		$(this).addClass("active").siblings(".tabs-btn").removeClass('active');
	});	
	
	/**/
	/* Scroll Starting Counter */
	/**/
	var is_count = true
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

	/**/
	/* Toggle */
	/**/
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
    })
	
    /**/
	/* Accordion */
	/**/
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
    
    /**/
	/* calendar */
	/**/
	if ($("#calendar").length) {
	  $('#calendar').datepicker({
	    prevText: '<i class="fa fa-angle-left"></i>',
	    nextText: '<i class="fa fa-angle-right"></i>',
	    firstDay: 1,
	    dayNamesMin: [ "Su", "Mo", "Tu", "We", "Th", "Fr", "Sa" ]
	  });
	}

	/**/
	/*  Carousel Tabs */
	/**/
	$('.carousel-tabs').each(function(){
		var slider = $('.filtration-carousel');
		var navs = $('#FiltrationCarousel .owl-nav');
		var Video = $('#opening_filtration');
		var carTabs = $('.carousel-tabs');
		var chevron = $('.filtration_slider .title-section i');
		slider.addClass('closed');
		slider.children().slideUp();
		navs.slideUp();
		$('.mechanism-effect div').slideUp();
		Video.trigger('load');
		// Title Chevron Click
		chevron.on( 'click', function(){
			if (carTabs.hasClass("unplayed")){
				// Video Starting if first click
			    Video.trigger('play');
			    Video.on('ended',function(){
				    carTabs.removeClass("unplayed").addClass("played");
			    });
		    }
		});
		// Service Item Click
		$('.carousel-tabs .carousel-btn').on( 'click', function(){
			var idCar = $(this).attr("data-mechanism");
			var mechanism = $('.mechanism-effect #' +idCar);
			var carVideo = $('.filtration-item#' +idCar+ ' video');
			var item = $('.filtration-item#' + idCar);			
			if (!$(this).hasClass('actived') && carTabs.hasClass("played") || carTabs.hasClass('tabs-played')){							    
				var dot = $(this).find('.dot');
				var line = $(this).find('.line');
				var carBtn = $(this).parent().parent().parent().find('.carousel-btn.actived');							
				// Lines & Dots Animation if not fisrt time		
				if (carBtn) {
					var dots = carBtn.find('.dot');
					var lines = carBtn.find('.line');
					var actId = carBtn.attr("data-mechanism");
					var actItem = 	$('.filtration-item#' + actId);
					console.log(actId);			
					carBtn.removeClass('actived');
					dots.removeClass('showed');
				    lines.animate({width:"0"}, {duration:1000, queue: true});
				    dots.animate({left:"0"}, {duration:1000, queue: false});
				    lines.removeClass('showed');
				    dots.delay(600).animate({opacity:"0"}, {duration:500, queue: true});
				    var actMech = $('.mechanism-effect #' + actId);
					var actVideo = $('.filtration-item#' + actId + ' video');
					actMech.slideUp(1000, function(){actVideo.get(0).pause()});				
					mechanism.slideDown(1000, function(){actVideo.get(0).currentTime = 0});				     
				}
				// Lines & Dots Animation
				dot.animate({opacity:"1"}, {duration:500, queue: false});
				line.animate({width:"340px"}, {duration:1000, queue: true});
				dot.animate({left :"340px"}, {duration:1000, queue: true});		
				dot.addClass('showed');					
				line.addClass('showed');
				// Showing Carousel
				$(this).addClass('actived');
				item.slideDown(1000);				
				carVideo.get(0).play();
				actItem.slideUp(1000);			
				// Mechanisms Animation
				
			}
			// Video Starting if first click	   
			if (carTabs.hasClass("unplayed") && $(this).hasClass("actived")){				
			    Video.trigger('play');
			    Video.on('ended',function(){
				    carTabs.removeClass("unplayed").addClass("played");
				    slider.addClass('opened');
			    });			    
		    }
			// Video Starting if first click
			if(carTabs.hasClass("unplayed")){
				Video.trigger('play');
				Video.on('ended',function(){
				    carTabs.removeClass("unplayed").addClass("played");
			    });
			}  
		});
		// Nav Carousel Click
		$('#FiltrationCarousel .owl-nav').on('click', function(){
			var idCar = $('#FiltrationCarousel .owl-item.active .filtration-item').attr("id");
			var idBtn = $('.carousel-btn.' + idCar);
			var carTab = $('.carousel-tabs');
			var carBtn = $('.carousel-tabs .carousel-btn.actived');
			var dot = idBtn.find('.dot');
			var line = idBtn.find('.line');
			var idActived = $('.carousel-tabs .carousel-btn.actived').attr("data-mechanism");
			var mechanism = $('.mechanism-effect #' +idCar);
			var mechVideo = $('.mechanism-effect #' +idCar +' video');
			// Carousel Speed Settings
			if ($(this).find('.owl-prev')){
				owl.trigger('prev.owl.carousel',[2000])
			}
			// Carousel Speed Settings
			if ($(this).find('.owl-next')) {
				owl.trigger('next.owl.carousel',[2000])
			}
			// Lines & Dots Animation if not fisrt time
			if (idBtn) {	
				var dots = carBtn.find('.dot');
				var lines = carBtn.find('.line');
				carBtn.removeClass('actived');
				dots.removeClass('showed');
			    lines.animate({width:"0"}, {duration:1000, queue: true});
			    dots.animate({left:"0"}, {duration:1000, queue: false});
			    lines.removeClass('showed');
			    dots.delay(600).animate({opacity:"0"}, {duration:500, queue: true});
			}
			// Lines & Dots Animation
			dot.animate({opacity:"1"}, {duration:500, queue: true});
			dot.animate({left :"340px"}, {duration:1000, queue: false});
			dot.addClass('showed');
			line.animate({width:"340px"}, {duration:1000, queue: false});
			line.addClass('showed');
			idBtn.addClass('actived')
			// Mechanisms Animation	
			var actMech = $('.mechanism-effect #' + idActived);
			var actVideo = $('.mechanism-effect #' + idActived + ' video');
			actMech.slideUp(1000, function(){actVideo.get(0).pause()});				
			mechanism.slideDown(1000, function(){actVideo.get(0).currentTime = 0});
			mechVideo.get(0).play();
		});
	});

	/**/
	/*  Skill bar  */
	/**/
	$(window).on('scroll', function (){
	    $('.skill-bar-progress').each(function(){
	      var el = this;
	
	      if (is_visible(el)){
	        if ($(el).attr("processed")!="true"){
	          $(el).css("width","0%");
	          $(el).attr("processed","true");
	          var val = parseInt($(el).attr("data-value")*100, 10);
	          var max = parseFloat($(el).attr("data-max"));
	          var speed = val/100;
	          var inter = $(el).attr("data-inter");
	          var unit =  $(el).attr("data-units");
	          var IndiceVal =  parseFloat($(el).attr("data-value"));
	          var Indice = IndiceVal/max;
	          var ratio = Indice*100;
	          
				if (Indice<0.5){
					var fill = 100;
					var start = max;
	              	var timerDown = setInterval(function (){	                		                
		                if (IndiceVal<start) {
		 		          start += -inter;
				          var feat = $(el).parent().parent().find(".feature-value");
				          $(feat).text(start.toFixed(2).replace(".",","));  
			            }
		                if (fill>ratio) {
		                	fill += -0.5;		                			                	
							$(el).css("width",String(fill)+"%");
							var ind = $(el).parent().parent().find(".skill-bar-perc");
							var indFill = max-fill/100;
							var un = $(el).parent().parent().find(".skill-bar-unit");
							$(ind).text(indFill.toFixed(3).replace(".",","));
							$(un).text(' '+ unit);
		                }             
			            		        
	                },10/ratio)
	            };
	            if (Indice>0.5){
		            var fill = 0;
		            var i = 0;
	                var timerUp = setInterval(function (){    				        
				        if (i<IndiceVal){
		 		          i += +inter;
				          var feat = $(el).parent().parent().find(".feature-value");
				          $(feat).text(i.toFixed(2).replace(".",","));  
			            }
				        if (fill<ratio){
		                	fill += 0.5;
		                	var fillR = fill/100;
							$(el).css("width",String(fill)+"%");
							var ind = $(el).parent().parent().find(".skill-bar-perc");
							var un = $(el).parent().parent().find(".skill-bar-unit");
							$(ind).text(fillR.toFixed(3).replace(".",","));
							$(un).text(' '+ unit);
		                }     			            
	              },10/ratio)
	            };   
	        }
	      }
	    });
	});

	// Is Visible Function
	function is_visible (el){
	    var w_h = $(window).height();
	    var dif = $(el).offset().top - $(window).scrollTop();
	
	    if ((dif > 0) && (dif<w_h)){
	        return true;
	
	    } else {
	        return false;
	    }
	}
	
	// Is Mobile Device Function
	function is_mobile_device () {
	  if ( ( $(window).width()<767) || (navigator.userAgent.match(/(Android|iPhone|iPod|iPad)/) ) ) {
	    return true;
	  } else {
	    return false;
	  }
	}
		
	// Scroll to Top Function
	function scroll_top (){
	  $('#scroll-top').on( 'click', function() {
	      $('html, body').animate({scrollTop: 0});
	      return false;
	  });
	  if( $(window).scrollTop() > 700 ) {
	    $('#scroll-top').fadeIn();
	  } else {
	    $('#scroll-top').fadeOut();
	  } 
	  $(window).scroll(function(){
	    if( $(window).scrollTop() > 700 ) {
	      $('#scroll-top').fadeIn();
	    } else {
	      $('#scroll-top').fadeOut();
	    } 
	  })
	 
	}

});


