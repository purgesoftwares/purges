/**
 * @author Creiden
 */
jQuery(document).ready(function($) {
	jQuery('.imageSlider_carousel').each(function(index,element){
		var $this = jQuery(element);
		var auto_play;
		if($this.hasClass('noBtn')){
			auto_play = true;
		}
		$this.find('.imgCarouselWrap').find('ul').carouFredSel({
		    direction: "left",
		    responsive: true,
			width: '100%',
			height: 'variable',
		    items: {
		        visible: 1,
		        //start: "random",
		        height: 'variable',
		        visible: {
		        	min:1,
		        	max:1
		        }
		    },
		    scroll: {
		        items: 1,
		        pauseOnHover: true
		    },
		    prev: {
		        button: $this.find('.left'),
		    },
		    next: {
		        button: $this.find('.right'),
		    },
		    auto: auto_play
		});
	});
});