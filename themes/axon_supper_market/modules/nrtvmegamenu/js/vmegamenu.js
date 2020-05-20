$(document).ready(function () {
	$(".more-vmegamenu").click(function() {
		$(".more_here").slideToggle();
		if($(".more-vmegamenu span i").attr("class")=="fa fa-plus"){
			$(".more-vmegamenu span").html('<i class="fa fa-minus"></i>' + CloseVmenu);
		}else{
			$(".more-vmegamenu span").html('<i class="fa fa-plus"></i>' + MoreVmenu);
		}
	});
});