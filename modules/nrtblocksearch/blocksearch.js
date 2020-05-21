$(document).ready(function () {
	var $searchWidget = $('#search_widget');
	var $searchBox    = $('#search_query_top');
	var searchURL     = $('#searchbox').attr('data-search-controller-url');
	$.widget('prestashop.psBlockSearchAutocomplete', $.ui.autocomplete, {
		delay: 0,
		_renderItem: function (ul, product) {
			var url_img='';
			if(typeof product.images[0] != 'undefined'){
				url_img=product.images[0].bySize.cart_default.url;
			}
			return $("<li>")
					.append($("<a>")
					.append($("<span class='left-search-ajax'>").html('<img src="'+ url_img +'">'))
					.append($("<span class='right-search-ajax'>").html('<span class="search-name-ajax">'+product.name+'</span><span class="price-search-ajax">'+(product.regular_price!=product.price ? '<span class="price-regular-ajax">'+product.regular_price+'</span>' : '' )+'<span class="price-ajax">'+product.price+'</span></span>'))
				).appendTo(ul)
			;
		}
	});
	$searchBox.psBlockSearchAutocomplete({
		delay: 0,
		source: function (query, response) {
			$.get(searchURL,{
				s: query.term,
				category_filter:$("#category_filter").val(),
				resultsPerPage:20
			}, null, 'json')
			.then(function (resp) {
				response(resp.products);
			})
			.fail(response);
		},
		select: function (event, ui) {
			var url = ui.item.url;
			window.location.href = url;
		},
	});
	
	/*
Reference: http://jsfiddle.net/BB3JK/47/
*/
    var $this = $('#category_filter'), numberOfOptions = $('#category_filter').children('option').length;
    var $styledSelect = $this.next('div.select-styled');
    $styledSelect.text($this.children('option').eq(0).text());
    var $list = $('<ul />', {
        'class': 'select-options'
    }).insertAfter($styledSelect);
  
    for (var i = 0; i < numberOfOptions; i++) {
        $('<li />', {
            text: $this.children('option').eq(i).text(),
            rel: $this.children('option').eq(i).val()
        }).appendTo($list);
    }
  
    var $listItems = $list.children('li');
  
    $styledSelect.click(function(e) {
        e.stopPropagation();
        $('div.select-styled.active').not(this).each(function(){
            $(this).removeClass('active').next('ul.select-options').hide();
        });
        $(this).toggleClass('active').next('ul.select-options').toggle();
    });
  
    $listItems.click(function(e) {
        e.stopPropagation();
        $styledSelect.text($(this).text()).removeClass('active');
        $this.val($(this).attr('rel'));
        $list.hide();
        //console.log($this.val());
    });
	$('.search_filter .select-options li').each(function(){
		if($(this).attr('rel') == $('#category_filter option[selected="selected"]').attr('value')){
        	$styledSelect.text($(this).text()).removeClass('active');
		}
	});
    $(document).click(function() {
        $styledSelect.removeClass('active');
        $list.hide();
    });

});
