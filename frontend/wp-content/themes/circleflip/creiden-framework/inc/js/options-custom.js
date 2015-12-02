/**
 * Prints out the inline javascript needed for the colorpicker and choosing
 * the tabs in the panel.
 */

jQuery(document).ready(function($) {
	$("#optionsframework").fadeIn();
	$(".saving_indicator_start").hide();
	if($("#optionsframework-submit").length !=0 ) {
		$("#optionsframework-submit").sticky({topSpacing:28});
		$('.nav-tab-wrapper').sticky({topSpacing:-99});
	}
	// $('.menuWrapper').find('a , li').each(function(){
		// $(this).click(function(){
			// $(window).scrollTop(0);
		// });
	// });




	// checkboxes and radiobuttons styling

	// Fade out the save message
	$('.fade').delay(1000).fadeOut(1000);
		$('.of-color').wpColorPicker();
		$("#color_elements, #colored_text, #color_border").wpColorPicker({
			change: function (event, ui) {
				if($("#template_color").val() !== 'custom') {
					$("#template_color").val('custom');
				}
		}
		});
	$('#template_color').parents('.group').last().click(function() {
		if(!$("#template_color").hasClass('clickedCache')) {
			$("#template_color").each(function() {
				if($(this).val() == 'blue') {
					adjust_colors("#3498db","#2977ab");
				}
				else if($(this).val() == 'light_red') {
					adjust_colors("#EB7070","#AC3232");
				}
				else if($(this).val() == 'red') {
					adjust_colors("#E32831","#980910");
				}
				else if($(this).val() == 'green') {
					adjust_colors("#9BCC32","#679416");
				}
				else if($(this).val() == 'dark_blue') {
					adjust_colors("#1A80B6","#055C8A");
				}
				else if($(this).val() == 'orange') {
					adjust_colors("#fa6b15","#cc5711");
				}
				else if($(this).val() == 'pink') {
					adjust_colors("#FF32A5","#B80168");
				}
				else if($(this).val() == 'grey') {
					adjust_colors("#9E9E9E","#616161");
				}
				else if($(this).val() == 'yellow') {
					adjust_colors("#fec70b","#d9aa09");
				}
				else if($(this).val() == 'brown') {
					adjust_colors("#CAA176","#886137");
				}
				else if($(this).val() == 'purple') {
					adjust_colors("#c295bf","#76126f");
				}
			});
			$('#template_color').addClass('clickedCache');
		}
	});
	$("#template_color").change(function() {
		if($(this).val() === 'blue') {
			adjust_colors("#52a2da","#2f6890");
		}
		else if($(this).val() === 'red') {
			adjust_colors("#E32831","#980910");
		}
		else if($(this).val() === 'light_red') {
			adjust_colors("#EB7070","#AC3232");
		}
		else if($(this).val() === 'green') {
			adjust_colors("#9AC748","#679416");
		}
		else if($(this).val() === 'dark_blue') {
			adjust_colors("#1A80B6","#055C8A");
		}
		else if($(this).val() === 'orange') {
			adjust_colors("#F37121","#C95B18");
		}
		else if($(this).val() === 'pink') {
			adjust_colors("#FF32A5","#B80168");
		}
		else if($(this).val() === 'grey') {
			adjust_colors("#9E9E9E","#616161");
		}
		else if($(this).val() === 'yellow') {
			adjust_colors("#F3D02E","#C29F00");
		}
		else if($(this).val() === 'brown') {
			adjust_colors("#CAA176","#886137");
		}
		else if($(this).val() === 'purple') {
			adjust_colors("#c295bf","#76126f");
		}
	});
	function adjust_colors(light,dark) {
			$("#color_elements, #colored_text, #links_hover_color").val(light).parents('.wp-picker-container').children('a').css('background-color',light);
			$("#color_elements, #colored_text, #links_hover_color").parents('.wp-picker-container').find('.iris-square-inner').css('background-color',light);
			$("#color_elements, #colored_text, #links_hover_color").parents('.wp-picker-container').find('.iris-strip').css('background-color',light).css('background-image',"");

			$("#color_elements_dark").val(dark).parents('.wp-picker-container').children('a').css('background-color',dark);
			$("#color_elements_dark").parents('.wp-picker-container').find('.iris-square-inner').css('background-color',dark);
			$("#color_elements_dark").parents('.wp-picker-container').find('.iris-strip').css('background-color',dark).css('background-image',"");
	}
	// Switches option sections
	$('.group').hide();
	var active_tab = '';
	if (typeof(localStorage) !== 'undefined' ) {
		active_tab = localStorage.getItem("active_tab");
	}
	if (active_tab != '' && $(active_tab).length ) {
		$(active_tab).fadeIn();
	} else {
		$('.group:first').fadeIn();
	}
	if (active_tab != '' && $(active_tab + '-tab').length ) {
		$(active_tab + '-tab').parent('li').addClass('nav-tab-active').parent('ul.sub_heading_parent').slideDown();
	}
	else {
		$('.nav-tab-wrapper a:first').parent('li').addClass('nav-tab-active').parent('ul.sub_heading_parent').slideDown();
	}

	$('.nav-tab-wrapper li').click(function(evt) {


		$('.nav-tab-wrapper li').removeClass('nav-tab-active');
		$(this).addClass('nav-tab-active').blur();
		var clicked_group = $(this).children('a').attr('href');
		if (typeof(localStorage) != 'undefined' ) {
			localStorage.setItem("active_tab", $(this).children('a').attr('href'));
		}
		$('.group').hide();
		$(clicked_group).fadeIn();
		evt.preventDefault();

		// Editor Height (needs improvement)
		$('.wp-editor-wrap').each(function() {
			var editor_iframe = $(this).find('iframe');
			if ( editor_iframe.height() < 30 ) {
				editor_iframe.css({'height':'auto'});
			}
		});
		//$($(".nav-tab-active").children('a').attr('href')).find('input:checkbox').uniform();

	});
	$('.nav-tab').click(function(e) {
		$this = $(this);
		if(!($this.next().hasClass('sub_heading')) && (!$this.is(':last-child'))) {
			$('ul.sub_heading_parent').slideUp(500);
		}
		if(!($this.hasClass('clicked'))) {
			$this.next('ul').slideDown().addClass('active_parent');
			$this.next('ul').siblings('ul').slideUp(500,function() {
				$('.active_parent').removeClass('active_parent');
			});
			$this.next('ul').children('li').first().addClass('clicked').click();
		}
		if($this.hasClass('clicked')) {
			$this.removeClass('clicked');
		}
	});
	// Image Options
	$('.of-radio-img-img').click(function(){
		$(this).parent().parent().find('.of-radio-img-img').removeClass('of-radio-img-selected');
		$(this).addClass('of-radio-img-selected');
	});

	$('.of-radio-img-label').hide();
	$('.of-radio-img-img').show();
	$('.of-radio-img-radio').hide();




	var Things = new Array();
	$('#optionsframework-submit input[name="update"]').click(function() {
		if($("#import-data").val() === '') {
			$("#import-data").remove();
		}
		$("[name^='rojo[pagebuilder][tabbed_categories'][multiple],[name^='rojo[pagebuilder][masonry_layout'][multiple]").children('option:selected').each(function(){
        		var value = $(this).text();
        			if(jQuery.inArray(value,Things) != -1){
        				alert("Attention, You picked up the same category in more than one Tabbed/Masonry Section, the duplicated Category is "+value+" . Please change it otherwise it will cause conflicts in the Home page.");
        			}else{
        				Things.push(value) ;
        			}
        });
        Things = new Array();
	});

	// exporting homepage builder options

	// Options Menu Wrapping
	$('.sub_heading').each(function(index,element) {
		$(element).addClass('wrapThis');
		if(!$(element).next('li').hasClass('sub_heading')) {
			$('.wrapThis').wrapAll('<ul class="sub_heading_parent"></ul>').removeClass('wrapThis');
			return true;
		}
	});
	$('.nav-tab-active').parent('ul.sub_heading_parent').slideDown();
	$('.nav-tab').each(function() {
		$this = $(this);
		// get the parent image
		$parent_image = $this.parents('ul').prev('li').children('img').attr('src');
		$selected_item = $this.children('a').attr('href');
		$($selected_item).children('.headingWrapper').find('img').attr('src',$parent_image);
	});

	$("#reset_tuts").on('click', function() {
		$.ajax({
			url: ajaxurl,
			data: {
				action: 'reload_tutorial'
			},
			success: function(data){
				window.location.reload();
			}
		});
	});

	$("#creiden-form").on("submit", function(e){
		if($('#import-data').text() == '') {
			e.preventDefault();
			/* get some values from elements on the page: */
			var $form = $( this ),
		  	  url = $form.attr('action'),
		  	  data = $form.serialize();
			xhr =  $.ajax({
			  	type: 'POST',
			  	url: url,
			  	data: data,
			  	beforeSend: function(data) {
			  		$('.saving_indicator').show().css({'left':$(document).width()/2 + 'px','top':parseInt($(window).height()/2) - 100 + parseInt($(window).scrollTop()) + 'px'});
			  	},
			  	success: function(data) {
			  		if($("#rojo-reset-theme-opts").hasClass('clicked')) {
						window.location.reload();
					}
			  		$('.saving_indicator').hide();
			  		$(".saving_indicator_done").show().css({'left':$(document).width()/2 + 'px','top':parseInt($(window).height()/2) - 100 + parseInt($(window).scrollTop()) + 'px'});
			  		setTimeout(function() {
			  			$(".saving_indicator_done").hide();
			  		},1000);
			  	}
			});
		}
	});
	$("#rojo-reset-theme-opts").click(function() {
		$(this).addClass('clicked');
	});
	$('#backup-options').on('click', function(e){
		$.ajax({
			url: ajaxurl,
			data:{
				action: 'creiden_backup_options'
			},
			success: function(data){
				$("#backup_log").html(data);
			}
		});
	});

	$('#restore-options').on('click', function(e){
		answer = confirm("Clicking restore will erase all the stored data and replace it with the Backed-Up data. This action is irreversible. We recommend copying the Export field to somewhere safe before proceeding");
		if(answer == true) {
			$.ajax({
				url: ajaxurl,
				data:{
					action: 'creiden_restore_options'
				},
				success: function(data){
					window.location.reload();
				}
			});
		}
	});

	$("#options-group-26-tab").on("click", function(){
		$('.saving_indicator').clone().appendTo("#section-export_data .option").show();
		$.getJSON(ajaxurl, {
			action: "cr_rojo_export",
			_ajax_nonce: $("#export-data").data("_ajax_nonce")
		})
		.done(function(result){
			if($.isPlainObject(result)){
				$("#export-data")
					.val(result._export)
					.data("_ajax_nonce", result._n_nonce);
				$('#section-export_data').find(".saving_indicator").hide().remove();
			}
		})
		.always(function(){

		});
	});
	$("#import-data").keyup(function() {
		$(this).parents('.section').find("#message").remove();
		showMessage("Importing options will erase all the stored data and replace it with the imported data. This action is irreversible. We recommend copying the Export field to somewhere safe before proceeding. Click Save and refresh the window for changes to take effect.",true,"#import-data",190);
	});
	$("#header_height").keyup(function() {
		$(this).parents('.section').find("#message").remove();
		showMessage("Click Save and refresh the window for changes to take effect on the Logo Builder ",false,"#header_height",90);
	});
	$("#logo_wrapper_width").keyup(function() {
		$(this).parents('.section').find("#message").remove();
		showMessage("Click Save and refresh the window for changes to take effect on the Logo Builder",false,"#logo_wrapper_width",90);
	});
	function showMessage(message, errormsg, element, margin)
		{
			if(!margin) {
				margin = 90;
			}
			if (errormsg) {
				$(element).parents('.section').append('<div id="message" class="error" style="position: relative;margin-top: '+margin+'px;"><p><strong>'+message+'</strong></p></div>');
			}
			else {
				$(element).parents('.section').append('<div id="message" class="updated fade" style="position: relative;margin-top: '+margin+'px;"><p><strong>'+message+'</strong></p></div>');
			}
		}
	if($(".menuWrapper .nav-tab").first().hasClass('nav-tab-active')) {
		$(".menuWrapper .nav-tab").first().click();
		setTimeout(function() {
			$('#creiden-form .group').first().hide();
		},500);
	}
	//$($(".nav-tab-active").children('a').attr('href')).find('select').uniform();
	//$($(".nav-tab-active").children('a').attr('href')).find('input:checkbox').uniform();
	//$('#circleflip-custom-sidebar select').uniform();

	/* ============================================================
	 						DEMO IMPORT
	 * ============================================================ */
	$("#get_demo").on("click", function(e){
		e.preventDefault();
		var $dialog = $("#demo_confirm_dialog");
		$dialog.dialog({
			modal		: true	,
			resizable	: false	,
			height		: 200	,
			buttons		: {
				Normal: function(){
					window.location = "themes.php?page=cr-rojo-demo";
				},
				RTL: function(){
					window.location = "themes.php?page=cr-rojo-demo&rtl=1";
				},
				cancel: function(){
					$dialog.dialog( "close" );
				}
			}
		});
	});
	/* ============================================================
	 						Hide and Show Elements
	 * ============================================================ */
	$('#header_style_style1').siblings('img').click(function () {
		$(".showSearch").removeClass('themeoptionsHidden');
		$(".showBreak").addClass('themeoptionsHidden');
	});
	$('#header_style_style4').siblings('img').click(function () {
		$(".showSearch").addClass('themeoptionsHidden');
		$(".showBreak").removeClass('themeoptionsHidden');
	});
	$('#header_style_style2, #header_style_style3, #header_style_style5, #header_style_style6, #header_style_style7, #header_style_style8').siblings('img').click(function () {
		$(".showSearch").addClass('themeoptionsHidden');
		$(".showBreak").addClass('themeoptionsHidden');
	});
	$('.header_images li').each(function(index,element) {
		if($(element).find('input').prop("checked")) {
			if($(element).find('input').attr('id') == 'header_style_style1') {
				$(".showSearch").removeClass('themeoptionsHidden');
				$(".showBreak").addClass('themeoptionsHidden');			
			} else if($(element).find('input').attr('id') == 'header_style_style4') {
				$(".showSearch").addClass('themeoptionsHidden');
				$(".showBreak").removeClass('themeoptionsHidden');
			} else {
				$(".showSearch").addClass('themeoptionsHidden');
				$(".showBreak").addClass('themeoptionsHidden');			
			}
		};
	});
	/* ============================================================
	 						Sliders Select
	 * ============================================================ */
	var show = new Array;
	$('.choose_slider option:selected').each(function() {
		
		if($(this).val() == 'nivo_slider') {
			show[1] = 'title';
			show[2] = 'image';
			show[3] = 'link';
			show[4] = 'slide_link';
			// show[0] = 'text';
			//show[3] = 'thumb';
			// show[3] = 'width';
			// show[4] = 'height';
			sliderFilterShow($(this).parents('.choose_slider').parents('.group'),show);
		} else if($(this).val() == 'flex_slider') {
			show[0] = 'text';
			show[1] = 'title';
			// show[2] = 'image';
			 show[3] = 'radio';
			 show[4] = 'select';
			 show[5] = 'titleFont';
			 show[6] = 'textFont';
			 show[7] = 'slide_link';
			sliderFilterShow($(this).parents('.choose_slider').parents('.group'),show);
		} else if($(this).val() == 'vertical_accordion_slider') {
			 show[0] = 'text';
			 show[1] = 'title';
			 show[2] = 'image';
			 show[3] = 'button1';
			 show[4] = 'button1link';
			 show[5] = 'button2';
			 show[6] = 'button2link';
			 show[7] = 'button3';
			 show[8] = 'button3link';
			 show[9] = 'titleFont';
			 show[10] = 'textFont';
			sliderFilterShow($(this).parents('.choose_slider').parents('.group'),show);
		} else if($(this).val() == 'threed_slider') {
			 show[0] = 'text';
			 show[1] = 'image';
			 show[2] = 'textFont';
			 show[3] = 'slide_link';
			sliderFilterShow($(this).parents('.choose_slider').parents('.group'),show);
		} else if($(this).val() == 'accordion') {
			 show[0] = 'text';
			 show[1] = 'title';
			 show[2] = 'image';
			 show[3] = 'link';
			 show[4] = 'titleFont';
			 show[5] = 'textFont';
			 show[6] = 'slide_link';
			sliderFilterShow($(this).parents('.choose_slider').parents('.group'),show);
		} else if($(this).val() == 'elastic_slider') {
			 show[0] = 'text';
			 show[1] = 'title';
			 show[2] = 'image';
			 show[3] = 'thumb';
			 show[4] = 'link';
			 show[5] = 'titleFont';
			 show[6] = 'textFont';
			 show[7] = 'slide_link';
			sliderFilterShow($(this).parents('.choose_slider').parents('.group'),show);
		}
	
	});
	$('.choose_slider').change(function() {
		var show = new Array;

		if($(this).val() == 'nivo_slider') {
			show[1] = 'title';
			show[2] = 'image';
			show[3] = 'link';
			show[4] = 'slide_link';
			// show[0] = 'text';
			//show[3] = 'thumb';
			// show[3] = 'width';
			// show[4] = 'height';
			sliderFilterShow($(this).parents('.group'),show);
		} else if($(this).val() == 'flex_slider') {
			show[0] = 'text';
			show[1] = 'title';
			// show[2] = 'image';
			 show[3] = 'radio';
			 show[4] = 'select';
			 show[5] = 'titleFont';
			 show[6] = 'textFont';
			 show[7] = 'slide_link';
			sliderFilterShow($(this).parents('.group'),show);
		} else if($(this).val() == 'vertical_accordion_slider') {
			 show[0] = 'text';
			 show[1] = 'title';
			 show[2] = 'image';
			 show[3] = 'button1';
			 show[4] = 'button1link';
			 show[5] = 'button2';
			 show[6] = 'button2link';
			 show[7] = 'button3';
			 show[8] = 'button3link';
			 show[9] = 'titleFont';
			 show[10] = 'textFont';
			sliderFilterShow($(this).parents('.group'),show);
		} else if($(this).val() == 'threed_slider') {
			 show[0] = 'text';
			 show[1] = 'image';
			 show[2] = 'textFont';
			 show[3] = 'slide_link';
			sliderFilterShow($(this).parents('.group'),show);
		} else if($(this).val() == 'accordion') {
			 show[0] = 'text';
			 show[1] = 'title';
			 show[2] = 'image';
			 show[3] = 'link';
			 show[4] = 'titleFont';
			 show[5] = 'textFont';
			 show[6] = 'slide_link';
			sliderFilterShow($(this).parents('.group'),show);
		} else if($(this).val() == 'elastic_slider') {
			 show[0] = 'text';
			 show[1] = 'title';
			 show[2] = 'image';
			 show[3] = 'thumb';
			 show[4] = 'link';
			 show[5] = 'titleFont';
			 show[6] = 'textFont';
			 show[7] = 'slide_link';
			sliderFilterShow($(this).parents('.group'),show);
		}
	});
	function sliderFilterShow(element,show) {
		element.find('.title,.text,.image,.thumb,.radio,.select,.button1,.button1link,.button2,.button2link,.button3,.button3link,.titleFont,.textFont,.slide_link').parents('li').hide();
		var i;
		for (i = 0; i < show.length; ++i) {
			element.find('.'+show[i]).parents('li').show();
		}

	}
    /**
     * ICON SELECTOR
     */
    $( '#crdn-icon-selector-modal' )
            .on( 'show.bs.modal', function( e ) {
                var _relatedTarget = $( e.relatedTarget ), that = $( this );
                if ( _relatedTarget ) {
                    var container = _relatedTarget.closest( '.crdn-icon-selector' );
                    var oldIcon = container.find( '.crdn-selected-icon' ).val();
                    that.find( '.icons-box' )
                            .find( '.selectedIcon' ).removeClass( 'selectedIcon' ).end()
                            .find( '.' + ( oldIcon || 'iconfontello:first' ) ).addClass( 'selectedIcon' );
                    that.find( '.icon-preview' )
                            .find( '.iconfontello' ).removeClass().addClass( 'iconfontello ' + that.find( '.icons-box .selectedIcon' ).data( 'icon' ) )
                            .end().find( '.icon-name' ).text( that.find( '.icons-box .selectedIcon' ).data( 'icon' ) );
                    that.one( 'click.iconselector', '.crdn-icon-selector-done', function() {
                        var selectedIcon = that.find( '.selectedIcon' ).data( 'icon' );
                        container.find( '.crdn-selected-icon' )
                                .val( selectedIcon )
                                .end()
                                .find( '.iconfontello.preview' )
                                .toggleClass( selectedIcon + ' ' + oldIcon );
                        that.modal( 'hide' );
                    } )
                            .one( 'hide', function() {
                                that.off( '.iconselector' );
                            } );
                }
                that.on( 'click', '.iconfontello', function() {
                    if ( $( this ).hasClass( 'selectedIcon' ) ) {
                        return;
                    }
                    that.find( '.icons-box' ).find( '.selectedIcon' ).removeClass( 'selectedIcon' );
                    $( this ).addClass( 'selectedIcon' );
                    that.find( '.icon-preview' ).find( '.iconfontello' ).removeClass().addClass( 'iconfontello ' + $( this ).data( 'icon' ) );
                    that.find( '.icon-preview' ).find( '.icon-name' ).text( $( this ).data( 'icon' ) );
                } );
            } );
            $('#section-top_left_area_settings').hide();
            $('#section-top_right_area_settings').hide();
            $('#section-top_area_header_settings').hide();
            $('.header_images img').on('click',function(){
               id = $(this).parent().find('input').attr('id');
               if (id == "header_style_style1"){
                   $('#top_area_header_settings option[value="main_navigation"]').prop('selected',true);
                   } else if (id == "header_style_style2") {
                       $('#top_area_header_settings option[value="main_navigation"]').prop('selected',true);
                   } else if (id == "header_style_style4"){
                       $('#top_area_header_settings option[value="main_navigation"]').prop('selected',true);
                       $('#top_left_area_settings option[value="contact"]').prop('selected',true);
                       $('#top_right_area_settings option[value="social"]').prop('selected',true);
                   } else if (id == "header_style_style5") {
                       $('#top_left_area_settings option[value="contact"]').prop('selected',true);
                       $('#top_right_area_settings option[value="social"]').prop('selected',true);
                       $('#top_area_header_settings option[value="ad"]').prop('selected',true);
                   } else if (id == "header_style_style6") {
                       $('#top_left_area_settings option[value="main_navigation"]').prop('selected',true);
                       $('#top_right_area_settings option[value="social"]').prop('selected',true);
                       $('#top_area_header_settings option[value="ad"]').prop('selected',true);
                   } else if (id == "header_style_style7"){
                       $('#top_area_header_settings option[value="main_navigation"]').prop('selected',true);
                   } else if (id == "header_style_style8"){
                       $('#top_area_header_settings option[value="main_navigation"]').prop('selected',true);
                   } else if (id == "header_style_style9"){
                       $('#top_area_header_settings option[value="main_navigation"]').prop('selected',true);
                       $('#top_left_area_settings option[value="contact"]').prop('selected',true);
                       $('#top_right_area_settings option[value="social"]').prop('selected',true);
                   }
            });
             
});
