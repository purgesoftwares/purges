jQuery(document).ready(function(){
	$('.teamName').click(function(){
		alert("here");
	});
	$('.aboutMember').each(function(){
		alert("here");
		    $(this).children('.memberImage').css({'height' : $(this).find('[class^="span"]').width()  - 40
			// 'width' : $(element).children('[class^="span"]').width()  - 40	
	});	    
	});
});