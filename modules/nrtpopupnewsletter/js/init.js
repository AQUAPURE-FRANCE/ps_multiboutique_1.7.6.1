$(document).ready(function () {

	if ($.cookie("nrtpopupnewsletter") != "true") {

$("#moda_popupnewsletter").modal({show: true});

		$(".send-reqest").click(function(){
			var email = $("#newsletter-input-popup").val();
			$.ajax({
				type: "POST",
				headers: { "cache-control": "no-cache" },
				async: false,
				url: nrt_path,
				data: "name=marek&email="+email,
				dataType: "jsonp",
				jsonp: 'callback',
				success: function(data) {
					if (data)
						$(".send-response").html(data);
				}
			});
		});
		$('#newsletter-input-popup').keypress(function(event){
		  var keycode = (event.keyCode ? event.keyCode : event.which);
		  if (keycode == '13') {
			var email = $("#newsletter-input-popup").val();
			$.ajax({
				type: "POST",
				headers: { "cache-control": "no-cache" },
				async: false,
				url: nrt_path,
				data: "name=marek&email="+email,
				dataType: "jsonp",
				jsonp: 'callback',
				success: function(data) {
					if (data)
						$(".send-response").html(data);
				}
			});
					return false;
		  }
		});
                $("#newsletter_popup_dont_show_again").prop("checked") == false;
	}
	var domain_name = baseUri.replace(baseUri.substring(0, baseUri.indexOf("/") + 2), "");
	domain_name = domain_name.substring(0, domain_name.indexOf("/"));
	
	$('#newsletter_popup_dont_show_again').change(function(){
	    if($(this).is(':checked')){
		$.cookie("nrtpopupnewsletter", "true",{'expires':7,'domain':domain_name,'path':'/'});
	    }else{
		$.cookie("nrtpopupnewsletter", "false",{'expires':-1,'domain':domain_name,'path':'/'});
	    }
	});

});