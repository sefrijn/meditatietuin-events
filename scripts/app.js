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

});