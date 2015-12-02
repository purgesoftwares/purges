/**
 * AQPB View JS
 * Front-end js for Aqua Page Builder blocks
 */

/** Fire up jQuery - let's dance! */
$=jQuery;
jQuery(document).ready(function($){
	$('.carouselHome').each(function(index,element) {
		var previous_button = '.carouselPrev'+index, next_button = '.carouselNext'+index;
		$('.prev').eq(index).addClass('carouselPrev'+index);
		$('.next').eq(index).addClass('carouselNext'+index);
		$(element).carouFredSel({
			responsive: true,
			width: '100%',
			scroll: 2,
			prev: previous_button,
			next: next_button,
			//mousewheel: true,
				swipe: {
					onMouse: true,
					onTouch: true
				},
			items: {
				// width: 126,
			//	height: '30%',	//	optionally resize item-height
				visible: {
					min: 2,
					max: 6
				}
			}
		});
	});
	//COVERT HEX COLOR TO RGBA
	R = hexToR(global_creiden.background);//hexToR("#E32831");
	G = hexToG(global_creiden.background);//hexToG("#E32831");
	B = hexToB(global_creiden.background);//hexToB("#E32831");
	$('.squarePostCont,.galleryCont,.hoverStyleNew').css('background-color','rgba('+R+', '+G+', '+B+', 0.80)');
});

//COVERT HEX COLOR TO RGBA
function hexToR(h) {return parseInt((cutHex(h)).substring(0,2),16);}
function hexToG(h) {return parseInt((cutHex(h)).substring(2,4),16);}
function hexToB(h) {return parseInt((cutHex(h)).substring(4,6),16);}
function cutHex(h) {return (h.charAt(0)=="#") ? h.substring(1,7):h;}