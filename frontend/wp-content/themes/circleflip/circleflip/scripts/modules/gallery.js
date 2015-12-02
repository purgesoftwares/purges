/**
 * @author Creiden
 */
jQuery(document).ready(function($) {
	$('.galleryStyle1 .galleryThumbnails li, .galleryStyle2 .galleryThumbnails li').each(function(index,element) {
		$this = $(element);
		$largeImage = $(element).parents('.galleryBlock').find('.largeImage').find('img');
		setTimeout(function() {
			$largeImage.parents('.largeImage').find('a').attr('href',$this.data('large'));
			$largeImage.parents('.largeImage').children('.galleryCont').width($largeImage.width());
			$largeImage.parents('.largeImage').children('.galleryCont').css({'left': 'calc((100% - '+$largeImage.width()+'px)/2)'});	
		},400);
	});
	$('.galleryStyle1 .galleryThumbnails li, .galleryStyle2 .galleryThumbnails li').mouseenter(function() {
		$this = $(this);
		$largeImage = $(this).parents('.galleryBlock').find('.largeImage').find('img');
		if($largeImage.attr('src') != $this.data('large')) {
			$largeImage.fadeOut(200,function() {
				$largeImage.attr('src',$this.data('large'));
				$largeImage.fadeIn(200);
				setTimeout(function() {
					$largeImage.parents('.largeImage').find('a').attr('href',$this.data('large'));
					$largeImage.parents('.largeImage').children('.galleryCont').width($largeImage.width());
					$largeImage.parents('.largeImage').children('.galleryCont').css({'left': 'calc((100% - '+$largeImage.width()+'px)/2)'});	
				},400);
				
			});
		}
	});
	if($(window).width() < 767) {
		$('.galleryStyle2').each(function(){
			var $this = $(this);
			$this.find('.galleryThumbnails').trigger('destroy',true);
		});
	}else{
		$('.galleryStyle2').each(function(){
			var $this = $(this);
			$this.find('.galleryThumbnails').carouFredSel({
				height: 350,
			    direction: "up",
			    items: {
			        visible: 3,
			        //start: "random",
			        height: "variable"
			    },
			    scroll: {
			        items: 1,
			        pauseOnHover: true
			    },
			    prev: {
			        button: $this.find('.prev')
			    },
			    next: {
			        button: $this.find('.next')
			    },
			    auto: false
			});
		});
	}
	$('.carousel-gallery').each(function(index,element){
		var $this= $(element);
		$(window).load(function(){
			$this.parent().find('.containerLoader').addClass('removeLoad');
			$this.addClass('galleryDisplay');
			$this.find('ul').carouFredSel({
			    direction: "left",
			    responsive: true,
				width: '100%',
				height: 'variable',
			    items: {
			        visible: 1,
			        //start: "random",
			        height: "variable",
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
			    auto: false
			});
		});
		
	});
});
