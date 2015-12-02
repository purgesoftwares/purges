jQuery(document).ready(function(){
	$('.landImageScreen img').hover(function(){
		$(this).css({"top": '-' + ($(this).height()-175)});
	},function(){
		$(this).css({"top" : '0px'});
	});
});
