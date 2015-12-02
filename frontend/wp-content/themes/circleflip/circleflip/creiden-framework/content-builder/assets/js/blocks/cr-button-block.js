/*
jQuery(document).ready(function($){
	function bindButtonEvents( $context ){
		console.log('binding ', $context);
		var $shape = $context.find('.adminDropdownShape select'),
		    $color = $context.find('.adminSelectTypeColor select'),
		    $check = $context.find('.ButtonCheckIcon .input-checkbox'),
		    $collection = $shape.add($color),
		    $toToggle = $context.find('.adminColorButtonText, .adminColorButton');
		$toToggle.toggle( ! isHidden() );
		console.log($shape, $color);
		$shape.on('change', function(){
			console.log('shape changed');
			$toToggle.toggle( ! isHidden() );
		});
		if($check.attr("value") == 0 || $check.attr('checked') != 'checked'){
			$context.find('.ButtonIcon').addClass('clearNone');	
		}
		$check.on('click',function(){
			//$('.ButtonCheckIcon .input-checkbox').click(function(){
				if($(this).attr("value") == 0 || $(this).attr('checked') == 'checked' ){
					$(this).closest('.ButtonCheckIcon').parent().children('.ButtonIcon').removeClass('clearNone');
				}else{
					$(this).closest('.ButtonCheckIcon').parent().children('.ButtonIcon').addClass('clearNone');
				}
				//});
		});
		
		$color.on('change', function(){
			$toToggle.toggle( ! isHidden() );
		});
		function isHidden(){
			return !(( $shape.val() == 0 || $shape.val() == 1 ) && $color.val() == 0);
		}
	}
	
	$('ul.blocks').find('.block-cr_buttons_block').each(function(){
		bindButtonEvents( $(this) );
	});
	$( "ul.blocks" ).bind( "sortstop", function(event, ui) {
		if ( ! ui.item.hasClass('block-cr_buttons_block') || ui.item.hasClass('circleflip-bound-listeners') )
			return;
			
		ui.item.addClass('circleflip-bound-listeners');
		bindButtonEvents( ui.item );
	});
});
*/
