jQuery(document).ready(function($) {
	//Flickr
	$('.flickrWidget').jflickrfeed({
		limit : global_flickr.limit,
		qstrings : {
			id : global_flickr.id
		},
		useTemplate : false,
		itemCallback : function(item) {
			$(this).children('ul').append("<li><a rel='prettyPhoto[pp_gal_flicker]'  href='" + item.image + "'><img src='" + item.image_s + "' alt='' width='60' height='60' /></a></li>");
			$(this).find('img').hover(function() {
				$(this).stop().animate({
					'opacity' : '0.6'
				}, 400);
			}, function() {
				$(this).stop().animate({
					'opacity' : '1'
				}, 400);
			});
			$("a[rel^='prettyPhoto']").prettyPhoto({social_tools:false,deeplinking:false});
		}
	});
});