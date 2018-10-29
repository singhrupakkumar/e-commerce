jQuery(document).ready(function(){

	jQuery("#s").autocomplete({
		minLength: 2,
		select: function(event, ui) {
			jQuery("#s").val(ui.item.label);
			jQuery("#searchform").submit();
		},
		source: function (request, response) {
			jQuery.ajax({
				url: 'https://rupak.crystalbiltech.com/shop/products/searchjson',
				data: {
					term: request.term
				},
				dataType: "json",
				success: function(data) {
					response(jQuery.map(data, function(el, index) {
						return {
							value: el.Product.name,
							name: el.Product.name,
							image: el.Product.image
						};
					}));
				}
			});
		}
	}).data("ui-autocomplete")._renderItem = function (ul, item) {
		return jQuery("<li></li>")
			.data("item.autocomplete", item) 
			.append("<a><img width='40' src='" + Shop.basePath + "images/large/" + item.image + "' /> " + item.name + "</a>")
			.appendTo(ul)
	};

});
