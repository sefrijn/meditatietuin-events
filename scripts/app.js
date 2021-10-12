jQuery( () => {
	console.log("Meditatietuin Events JS loaded correctly");

	jQuery('.scrollto').click(function(e){
		e.preventDefault();
		var target = jQuery(this).attr('href');
		console.log(target);
		jQuery('body, html').animate({
			scrollTop: jQuery(target).offset().top - 120
		}, 800);
	});

	// Get query variables
	var page_number = 1; // reset current page to 1
	var total_pages = jQuery('[data-max-pages]').data('max-pages');
	jQuery('#event-list').attr('data-page-number',page_number);
	if(page_number >= total_pages){
		jQuery('.loadmore_end').show();
		jQuery('.loadmore').hide();
	}else{
		jQuery('.loadmore').show();
	}

	jQuery('.loadmore ').click(function(e){
		e.preventDefault();
		page_number = parseInt(jQuery('#event-list').attr('data-page-number'))+1;
		jQuery('#event-list').attr('data-page-number',page_number);
		var page_amount = jQuery('#event-list').attr('data-page-amount');
		var mt_category = jQuery('#event-list').attr('data-mt_category');
		var teacher = jQuery('#event-list').attr('data-teacher');
		var filtered_month = jQuery('#event-list').attr('data-month');

		// Load more projects
		var loadmorePath = js_urls.plugin_url + "/meditatietuin-events/templates/helpers/load_more_events.php";
		jQuery.ajax({
			method: "GET",
			url: loadmorePath,
			data: {
				page_number: page_number,
				postperpage: page_amount,
				mt_category: mt_category,
				teacher: teacher,
				filtered_month: filtered_month,
			}
		})
		.done(function( data ) {
			// console.log(data);
			jQuery('#event-list').append(data);
			if(page_number >= total_pages){
				jQuery('.loadmore').hide();
				jQuery('.loadmore_end').show();
			}
		});
	});

});