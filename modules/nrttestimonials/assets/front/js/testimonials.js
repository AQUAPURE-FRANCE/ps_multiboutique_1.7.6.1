$(document).ready(function() {
  $('#slide').owlCarousel({
	autoplay:false,
	autoplayTimeout:5000,
	autoplayHoverPause:false,
    lazyLoad:false,
	nav:false,
	dots:true,
	navText: ['<span class="fa fa-angle-left"></span>','<span class="fa fa-angle-right"></span>'],
	responsive:{
		0:{items:1,nav:false,dots:false},
		320:{items:1,nav:false,dots:false},
		568:{items:1,nav:false,dots:false},
		992:{items:2},
		1200:{items:2}
	}
  });
});