$(document).ready(function () {
	var wdth = $( window ).width();	
	if (wdth < 992){
		nrtVmegamenu_mobile();
	} else {
		nrtVmegamenu();
	}
	/* carousels */
	var vm_rp = $(".v-right-section-products").data("pquant");
	if (vm_rp > 1) {
		$(".v-right-section-products").flexisel({
                    pref: "vm-pr",
                    visibleItems: 1,
                    animationSpeed: 500,
                    autoPlay: true,
                    autoPlaySpeed: 3500,
                    pauseOnHover: true,
                    enableResponsiveBreakpoints: false,
                    clone : true
		});  
	}  
	$(".more-vmegamenu").click(function() {
		$(".more_here").slideToggle();
		if($(".more-vmegamenu a span i").attr("class")=="fa fa-plus"){
			$(".more-vmegamenu a span").html('<i class="fa fa-minus"></i>' + CloseVmenu);
		}else{
			$(".more-vmegamenu a span").html('<i class="fa fa-plus"></i>' + MoreVmenu);
		}
	});
});

function nrtVmegamenu_mobile(){

	$('.v-megamenu .opener').click(function(){
		var el = $(this).next('.dd-section');
		var switcher = $(this);
	        el.animate({
	            "height": "toggle"
	        }, 
	        500,
	        function(){
	        	if (el.is(':visible')) {
	                el.addClass("act");
	                switcher.addClass('opn');
	            } else {
	            	switcher.removeClass('opn');
	                el.removeClass("act");
	            }
	        });
		return false;
	});
}

function nrtVmegamenu(){
	$( ".v-megamenuitem" ).hover(function() {
		var el = $(this).find('.submenu');
		el.addClass("showmenu");
	}, function() {
		var el = $(this).find('.submenu');
		el.removeClass("showmenu");
	});
}