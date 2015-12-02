(function($) {
	$(window).load(function() {
		$('.logoandfavicon-tab').click(function() {
			manage_logo();
		});
		manage_logo();
		if($('#theme_logo-image img').length === 0) {
			$('#theme_logo-image').css('border','0px');
			$("#logowrapper .ui-resizable-handle").hide();
		}
	});
})(jQuery);


function manage_logo() {
	$ = jQuery;
	var originalWidth = $(".theme_logo").find('.screenshot img').width(), originalHeight = $(".theme_logo").find('.screenshot img').height(), ratio = (originalWidth / originalHeight);
	$("#logowrapper").parent('.controls').addClass('logoBuilderBG');
	if ($("#logo_aspectratio").attr('checked') === 'checked') {
		$("img.logo").resizable({
			containment : ".containmentLogo",
			resize : function(event, ui) {
				$('#logo_width').val(ui.size.width);
				$('#logo_height').val(ui.size.height);
			},
			maxWidth: $('.containmentLogo').width(),
			maxHeight: $('.containmentLogo').height(),
			aspectRatio : ratio
		});
		$(".ui-wrapper").draggable({
			containment : ".containmentLogo",
			drag : function(event, ui) {
				$('#logo_top').val(ui.position.top);
				$('#logo_left').val(ui.position.left);
			}
		});
	} else {
		$("img.logo").resizable({
			containment : ".containmentLogo",
			resize : function(event, ui) {
				$('#logo_width').val(ui.size.width);
				$('#logo_height').val(ui.size.height);
			},
			maxWidth: $('.containmentLogo').width(),
			maxHeight: $('.containmentLogo').height()
		});
		$(".ui-wrapper").draggable({
			containment : ".containmentLogo",
			drag : function(event, ui) {
				$('#logo_top').val(ui.position.top);
				$('#logo_left').val(ui.position.left);
			}
		});
	}

	$("#logo_aspectratio").click(function() {
		$("img.logo").resizable('destroy');
		if ($(this).attr('checked') === 'checked') {
			$("img.logo").resizable({
				containment : ".containmentLogo",
				resize : function(event, ui) {
					$('#logo_width').val(ui.size.width);
					$('#logo_height').val(ui.size.height);
				},
				maxWidth: $('.containmentLogo').width(),
				maxHeight: $('.containmentLogo').height(),
				aspectRatio : ratio
			});
		} else {

			$("img.logo").resizable({
				containment : ".containmentLogo",
				resize : function(event, ui) {
					$('#logo_width').val(ui.size.width);
					$('#logo_height').val(ui.size.height);
				},
				maxWidth: $('.containmentLogo').width(),
				maxHeight: $('.containmentLogo').height()
			});
		}
		$(".ui-wrapper").draggable({
			containment : ".containmentLogo",
			drag : function(event, ui) {
				$('#logo_top').val(ui.position.top);
				$('#logo_left').val(ui.position.left);
			}
		});
	});
	if ($("#logo_width") === null) {
		$('.logo').width($('.theme_logo').find('.screenshot img').width());
		$('.ui-wrapper').width($('.theme_logo').find('.screenshot img').width());
	}
	if ($("#logo_height") === null) {
		$('.logo').height($('.theme_logo').find('.screenshot img').height());
		$('.ui-wrapper').height($('.theme_logo').find('.screenshot img').height());
	}
	$("#resetlogosize").click(function() {
		$('img.logo').parent('div').css('left',0);
		$('img.logo').parent('div').css('top', 0);
		$("#logo_top").val(0);
		$("#logo_left").val(0);
		$('img.logo').width($('.theme_logo').find('.screenshot img').width());
		$('.ui-wrapper').width($('.theme_logo').find('.screenshot img').width());
		$('img.logo').height($('.theme_logo').find('.screenshot img').height());
		$('img.logo').css({'max-width':$("#logowrapper").width() + "px",'max-height':$("#logowrapper").height() + "px"});
		$('.ui-wrapper').height($('.theme_logo').find('.screenshot img').height());
		if($('img.logo').width() > $("#logo_wrapper_width").val()) {
			$("#logo_width").val($("#logo_wrapper_width").val());
		}
		else {
			$("#logo_width").val($('img.logo').width());
		}
		if($('img.logo').height() > $("#header_height").val()) {
			$("#logo_height").val($("#header_height").val());
		}
		else {
			$("#logo_height").val($('img.logo').height());
		}
	});
}