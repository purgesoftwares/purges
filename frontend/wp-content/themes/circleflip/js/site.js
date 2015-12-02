/**
 * @author Creiden
 */
function loadCss(url,file) {
	"use strict";
    var link = document.createElement("link");
    if(!(jQuery("body").find('link').hasClass(file))) {
		link.type = "text/css";
		link.href = url;
	    link.rel = "stylesheet";
	    link.media = "all";
	    document.getElementsByTagName("body")[0].appendChild(link);
	    jQuery('body').find('link').last().addClass(file);
    }
}
jQuery(document).ready(function($) {
	var circleFlip = function(element, options) {
		this.$element = $(element);
		this.init();
		this.windowResize();
		this.ready();
        if(!global_creiden.headerBuilder) {
            this.navigationButton();
            this.headerJS();
        }
		this.animateElements();
	};
	circleFlip.prototype.init = function() {
		var self = this;
		this.prepEventListeners();
	};
	circleFlip.prototype.prepEventListeners = function() {
		$(window).on('resize',jQuery.proxy(this.windowResize, this));
		this.$element.on('click',"#toTop",jQuery.proxy(this.toTop, this));

		/*
			Header Part
		*/
        if(!global_creiden.headerBuilder) {
            this.$element.on('click', ".searchbar .searchHolder", jQuery.proxy(this.searchAnimation, this));
            this.$element.on('click', ".navigationButton", jQuery.proxy(this.navigationButton, this));
		    //this.$element.on('click', ".mainHeader .btn-navbar", jQuery.proxy(this.menuResponsive, this));
		    this.$element.on('click', ".smallHeader .btn-navbar", jQuery.proxy(this.smallMenuResponsive, this));
            this.$element.on('click', document, jQuery.proxy(this.switchMenu, this));
        } else {
            this.$element.on('click', ".headerMenuSearch > span", jQuery.proxy(this.headerMenuSearch, this));
            this.$element.on('click', ".toggledMenu .toggleMenuBtn", jQuery.proxy(this.toggledMenu, this));
            this.$element.on('click', ".closeMenu", jQuery.proxy(this.toggledMenuClose, this));
            this.$element.on('click', document, jQuery.proxy(this.headerMenuSearchClose, this));
        };

		/*
		 * Ajax Elements
		 */
		this.$element.on('click', ".loadCirclePosts", jQuery.proxy(this.loadCirclePosts, this));
		this.$element.on('click', ".loadRecentPosts", jQuery.proxy(this.loadRecentPosts, this));
		this.$element.on('click', ".loadPortfolioPosts", jQuery.proxy(this.loadPortfolioPosts, this));
		this.$element.on('click', ".loadSquareRedPosts", jQuery.proxy(this.loadSquareRedPosts, this));
		this.$element.on('click', ".loadMagazine1Posts", jQuery.proxy(this.loadMagazine1Posts, this));
		this.$element.on('click', ".loadMagazine2Posts", jQuery.proxy(this.loadMagazine2Posts, this));
		this.$element.on('click', ".loadMagazine3Posts", jQuery.proxy(this.loadMagazine3Posts, this));
		this.$element.on('click', ".loadMagazine4Posts", jQuery.proxy(this.loadMagazine4Posts, this));

		/*
		 * Single Post
		 */
		this.$element.on('click', "#singleCommentsTabbed li", jQuery.proxy(this.singleCommentsTabbed, this));
	};
    if(!global_creiden.headerBuilder) {
        circleFlip.prototype.switchMenu = function(c){
            if($(c.target).parent().hasClass('btn')){
                var container = $(".mainHeader .navCollapse");
                container.stop();
                if(container.hasClass('openMenu')){
                    container.slideUp(500);
                    container.removeClass('openMenu');
                    $('.navbar').removeClass('openMenuHeight');
                } else {
                    container.slideDown(500);
                    container.addClass('openMenu');
                    $('.navbar').addClass('openMenuHeight');
                }
            } else {
                if(window.innerWidth <= 979){
                    $(".mainHeader .navCollapse").slideUp(500);
                    $(".mainHeader .navCollapse").removeClass('openMenu');
                    $('.navbar').removeClass('openMenuHeight');
                }
            }
        };
    };
	
	circleFlip.prototype.activatePrettyPhoto = function() {
	   if($("a[rel^='prettyPhoto']").length !==0 ) {
	   		$("a[rel^='prettyPhoto']").prettyPhoto({social_tools:false,deeplinking:false});
	   		$("a[rel^='prettyPhoto'].icon-picture").click(function(){
	   			$('.carousel-gallery ul').carouFredSel();
	   		});
	   }
	};
    if(!global_creiden.headerBuilder) {
		circleFlip.prototype.menuResponsive = function(event) {
			$this = $(event.currentTarget);
			if($(window).width() < 979) {
				var container = $('.mainHeader .navCollapse');
				container.stop();
				if(container.hasClass('openMenu')){
					container.slideUp(500);
					container.removeClass('openMenu');
					$('.navbar').removeClass('openMenuHeight');
				}else {
					container.slideDown(500);
					container.addClass('openMenu');
					$('.navbar').addClass('openMenuHeight');
				}

			}
		};

		circleFlip.prototype.smallMenuResponsive = function(event) {
			$this = $(event.currentTarget);
			if($(window).width() < 979) {
				var container = $('.smallHeader .navCollapse');
				container.stop();
				if(container.hasClass('openMenu')){
					container.slideUp(500);
					container.removeClass('openMenu');
					$('.navbar').removeClass('openMenuHeight');
				} else{
					container.slideDown(500);
					container.addClass('openMenu');
					$('.navbar').addClass('openMenuHeight');
				}

			}
		};
    };

	circleFlip.prototype.toTop = function(event) {
		$('body,html').animate({
			scrollTop : 0
		}, 800);
	};

	circleFlip.prototype.ready = function() {
		//Nice Scroll
		if(global_creiden.nicescroll) {
			if(global_creiden.nicescroll==1){
				$("html").niceScroll({
					autohidemode: false,
					cursorwidth: '7px',
					cursorborder: 'none'
				});
			}
		}
		//parallax stellar
		if($('body').find('.parallaxSection').length != 0 ){
			$(window).stellar({
				horizontalScrolling: false,
	  			verticalScrolling: true,
	  			scrollProperty: 'scroll'
			});
		}
		//Video Background
		if($('body').find('.background_video').length != 0 ){
			$(".wallpapered").not(".defer").wallpaper();
			$(".wallpapered.defer").wallpaper();
		}
		//
		$('.squarePostImg').each(function(){
			if($(this).find('.zoomRecent').length <= 0 ){
				$(this).find('.linkZoomCont').addClass('linkRecentOnly');
				$(this).find('.linkRecent').addClass('linkRecentCenter');
			}
		});
		$('.topPost_list_item').each(function(i){
			$(this).find('.carousel_topPost').carouFredSel({
				 items:{
				 	visible:1,
				 	height:"variable"
				 },
			    scroll: 1,
			    auto: {
			        delay: 1000
			    },
				responsive:true,
				auto: false,
				prev: {
					button: $(this).find('.topPostPrev'),
					key: "left"
				},
				next: {
					button: $(this).find('.topPostNext'),
					key: "right"
				}
			});
		});
		
		$('.recentPost.customWidget').each(function(i){
			$(this).find('.Carousel_recent').carouFredSel({
				 items:{
				 	visible:1,
				 	height:"variable"
				 },
			    scroll: 1,
			    auto: {
			        delay: 1000
			    },
				responsive:true,
				auto: false,
				prev: {
					button: $(this).find('.recentPostPrev'),
					key: "left"
				},
				next: {
					button: $(this).find('.recentPostNext'),
					key: "right"
				}
			});
		});
		
		$('.portfolioHomeCont').each(function(){
			if($(this).find('.zoomStyle3').length <= 0 ){
				$(this).find('.ZoomContStyle3').addClass('linkStyle3Only');
				$(this).find('.linkStyle3').addClass('linkStyle3Center');
			}
		});

		$('.commentsWrapper .comment-reply-link').click(function(){
			$(this).hide();
		});
		$('#cancel-comment-reply-link').click(function(){
			$(this).parents('.commentsWrapper').find('.comment-reply-link').show();
		});
        if(!global_creiden.headerBuilder) {
            $('.searchFormIcon span').click(function(){
                if($(this).parent('.searchFormIcon').hasClass('searchActive')){
                    $(this).parent('.searchFormIcon').removeClass('searchActive');
                }else{
                    $(this).parent('.searchFormIcon').addClass('searchActive');
                }
            });
        };
		$('#toTop').fadeOut();
		$(window).scroll(function() {
			if($(this).scrollTop() > 100) {
				$('#toTop').fadeIn();
			} else {
				$('#toTop').fadeOut();
			}
		});
		$('.postDetails .postImage iframe').css({'height': $('.postDetails .postImage iframe').width()/2});
		if(global_creiden.responsive) {
		// Responsive Files

			if($(window).width() > 1200) {
				$('.headerStyle4 .nav-collapse-main').height(0);
			}

		}
		
		// Counter
		if($('.cfCounter').length > 0 ) {
			$('.counterNumber').counterUp({
                delay: 10,
                time: 1500
            });
		}


		$('.pageRow').each(function(){
			$(this).find('.aq-block-cr_pricingtables_block:first').before('<div class="pricingTableCenter"></div>');
			$(this).find('.aq-block-cr_pricingtables_block').each(function(){
				$(this).appendTo($(this).parents('.pageRow').find('.pricingTableCenter'));
			});
		});
		$('.aq-block').each(function(){
			if($(this).parents('.pageRow').children('.pricingTableCenter').length > 0 && $(this).parents('.pageRow').children('.aq-block').length > 0 ){
				$(this).parents('.pageRow').children('.pricingTableCenter').css({'display':'block'});
			}
		});
		$('.aq-block-cr_features_home').each(function(){
			var attr = $(this).closest('.backgroundBlock ').attr('style');
			if (typeof attr !== 'undefined' && attr !== false) {
			   $(this).find('.featureHomeImage').addClass('notAnimate');
			}
		});
		var self = this;
		// Swipe Menu
        if(!global_creiden.headerBuilder) {
            if($(window).width() < 979) {
                $(".mainHeader .navCollapse").slideUp(500);
                $(document).mouseup(function(e) {
                    var container = $(".mainHeader .navCollapse");
                    if (!container.parents('.mainHeader').find('.icon-menu').is(e.target) && container.parents('.mainHeader').find('.icon-menu-3').has(e.target).length === 0) {
                        container.removeClass('openMenu');
                        $('.navbar').removeClass('openMenuHeight');
                        container.stop();
                        container.slideUp(500);
                    }
                });
                $(".mainHeader .navCollapse").removeClass('mainNav');
            }else{
                $(".mainHeader .navCollapse").addClass('mainNav');
            }

            if($(window).width() < 979) {
                $(".smallHeader .navCollapse").slideUp(500);
                $(document).mouseup(function(e) {
                    var container = $(".smallHeader .navCollapse");
                    if (!container.parents('.smallHeader').find('.icon-menu').is(e.target) && container.parents('.smallHeader').find('.icon-menu-3').has(e.target).length === 0) {
                        container.removeClass('openMenu');
                        $('.navbar').removeClass('openMenuHeight');
                        container.stop();
                        container.slideUp(500);
                    }
                });
                $(".smallHeader .navCollapse").removeClass('mainNav');
            }else{
                $(".smallHeader .navCollapse").addClass('mainNav');
            }
            //Menu hover
             $('.nav li.dropdown').hover(function() {
                $(this).addClass('open');
            }, function() {
                $(this).removeClass('open');
            });
        };
	    if($('.postSorting').length !=0 ) {
			$('.postSorting button').dropdown();
	    }
		$(window).load(function(){
			$('.subscribe a').each(function(){
				if($(window).width() > 750) {
					$(this).css({'top' : $(this).parent().height()/2 + 2 + 'px'});
				}else{
					$(this).css({'top' : '0px'});
				}
			});

			$('.DSlider #nav-arrows').css({'display': 'block'});

			setTimeout(function() {
				$('.cf-masonry-container').each(function(index,element) {
					$(element).parents('.aq-block').height($(element).parent('.squarePostsWrapper').height());
				});
			},1000);
		});

		// Circle Post
		 if($('.circleAnimationImage').length !== 0) {
			$('.circleAnimationImage').each(function(index,element) {
				$(element).parent('.circleAnimation').css('height',$(element).parents('.circlePost').width() + 'px');
				$(element).css('height',$(element).parents('.circlePost').width() + 'px');
				if($(element).parents('.circleAnimationArea').length !== 0) {
					$(element).parents('.circleAnimationArea').css({
						'height' : $(element).parents('.circlePost').width()  - 40,
						'width' :  $(element).parents('.circlePost').width()  - 40
					});
							$(element).height($(element).parents('.circleAnimationArea').height());

				}
			});
		 }

		$('.footerList > li.topPost').removeClass('topPostwidth');
	    self.activatePrettyPhoto();
		if($(".tweet").length !== 0) {
			$(".tweet").tweet({
				username : 'creiden',
				count : 3,
				loading_text : "loading tweets..."
			});
		}
		$('#carousel_related .carousel-inner img,.relatedposts img').hover(function(){
			$(this).parent().children('div').addClass('recentHoverImg');
		},function(){
			$(this).parent().children('div').removeClass('recentHoverImg');
		});
		$('.recentHover').hover(function(){
			$(this).addClass('recentHoverImg');
		},function(){
			$(this).removeClass('recentHoverImg');
		});
		if($('.postSlider').length !== 0) {
			$('.postSlider').each(function(index,element) {
				$(element).find('li').css('width',$(element).width());
				$(element).find('ul').css('width',$(element).find('li').size() * $(element).find('li').width());//Initialize upper image slider
			});
		}

		// WooCommerce Mini cart
		if($('.cart-dropdown').length !== 0) {
                    $( document ).on( 'click', '.cart-dropdown-header', function() {
                        if ($(this).parent('.cart-dropdown').hasClass('openMini' ) ) {
                            $( this ).parent( '.cart-dropdown' ).removeClass( 'openMini' );
                        } else {
                            $( this ).parent( '.cart-dropdown' ).addClass( 'openMini' );
                        }
                    });
                    $(document).mouseup(function(e) {
                        var container = $(".cart-dropdown");
                        if (!container.is(e.target) && container.has(e.target).length === 0) {
                                container.removeClass('openMini');
                        }
                    });
		}

		// WooCommerce Zoom Function
		if ( $('.singleProduct .singleThumbnail').length !== 0 ) {
			$('.postImage').trigger('zoom.destroy').zoom({
                            url: $( '.postImage [data-full]' ).data( 'full' )
			});
			$('.singleThumbnail').on('click', function(e){
				$('.postImage').trigger('zoom.destroy').find('img').attr('src', $(this).data('thumb')).end().zoom({
					url: $(this).data('full')
				});
			});
		}
        $(window).on('load', function(){
            if ( jQuery.fn.masonry )
                $( '.cf-masonry-container' ).masonry( {itemSelector: ".cf-masonry", gutter: 0} );
        });

        // Wrap All Pricing Tables to center them in case there is more than an element inside the same column
        $('.center_pricing_blocks').find('.aq-block-cr_pricingtables_block').wrapAll('<div class="center_blocks"></div>');
        
        
        // One Page Ease Scroll Effect
	  $('.navbar a[href*=#]:not([href=#]), .menuWrapper a[href*=#]:not([href=#])').click(function() {
	    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
	      var target = $(this.hash);
	      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
	      if (target.length) {
	        $('html,body').animate({
	          scrollTop: target.offset().top - 150
	        }, 1000);
	        return false;
	      }
	    }
	  });
	  
	// Ipad and Iphone anchors
	$(function() {

		IS_IPAD = navigator.userAgent.match(/iPad/i) != null;
		IS_IPHONE = (navigator.userAgent.match(/iPhone/i) != null) || (navigator.userAgent.match(/iPod/i) != null);
		
		if (IS_IPAD || IS_IPHONE) {
			$('a[class*="btnStyle"]').on('click touchend', function() {
				var link = $(this).attr('href');
				var target = $(this).attr('target');
				if(target == "_blank") {
					window.open(link,"_blank");
				} 
				else {
					window.open(link,"_self");
				}
				return false;
			});
		}
	}); 
	
		
	/**
	 * make Product variation images work in single product views
	 * 
	 * @since 1.3.4
	 */
	if ( 'object' === typeof $variation_form ) {
		var $productImageContainer = $( '.postImage' );
		$variation_form
			.on( 'found_variation', function( event, variation ) {
				if ( ! variation.image_link ) {
					return;
				}
				$productImageContainer.trigger( 'zoom.destroy' ).zoom( {
					url: variation.image_link
				} );
			} )
			.on( 'reset_image', function( event ) {
				$productImageContainer.trigger( 'zoom.destroy' ).zoom( {
					url: $productImageContainer.find( 'div[data-full]' ).data( 'full' )
				} );
			} );
	}

	};
	// Defining Variables
	circleFlip.prototype.loadCirclePosts = function(event) {
			self = this;
			event.preventDefault();
			$this = $(event.currentTarget);
			$.ajax({
				url : global_creiden.ajax_url,
				type: 'post',
				dataType: 'JSON',
				data : {
					pageNumber : $this.data('pagenumber'),
					postsnumber :  $this.data('postsnumber'),
					cat_id : $this.data('cats'),
					post_type : $this.data('posttype'),
					animation : $this.data('animation'),
					layout : $this.data('layout'),
                    post_or_portfolio: $this.data('postOrPortfolio'),
					action : 'circle_posts_loadmore'
				},
				success : function(data) {
					if(data.length === 0) {
						$.ajax({
							url : global_creiden.ajax_url,
							type: 'post',
							dataType: 'JSON',
							data : {
								pageNumber : 1,
								postsnumber :  $this.data('postsnumber'),
								cat_id : $this.data('cats'),
								post_type : $this.data('posttype'),
								animation : $this.data('animation'),
								layout : $this.data('layout'),
                                post_or_portfolio: $this.data('postOrPortfolio'),
								action : 'circle_posts_loadmore'
							},
							success : function(data) {
								var counter=0;
								$this.closest('.CirclePosts').next('.circleFlip').remove();
								$this.closest('.aq-block').append('<div class="circleFlip row"></div>');
								for (counter=0; counter < data.length; counter++) {
									$this.closest('.aq-block').find('.circleFlip').append(data[counter].postData);
								}
								 if($this.closest('.CirclePosts').next('.circleFlip').find('.circleAnimationImage').length !== 0) {
									$this.closest('.CirclePosts').next('.circleFlip').find('.circleAnimationImage').each(function(index,element) {
										$(element).parent('.circleAnimation').css('height',$(element).parents('.circlePost').width() + 'px');
										$(element).css('height',$(element).parents('.circlePost').width() + 'px');
										if($(element).parents('.circleAnimationArea').length !== 0) {
											$(element).parents('.circleAnimationArea').css({
												'height' : $(element).parents('.circlePost').width()  - 40,
												'width' :  $(element).parents('.circlePost').width()  - 40
											});
											$(element).height($(element).parents('.circleAnimationArea').height());
										}
									});
								 }

								self.activatePrettyPhoto();
								self.activateGalleryModal();
								self.activateVideoPlayer($this.closest('.aq-block').find('.circleFlip'));
								$this.data('pagenumber',2);
							}
						});
					} else {
					var counter=0;
						$this.closest('.CirclePosts').next('.circleFlip').remove();
						$this.closest('.aq-block').append('<div class="circleFlip row"></div>');
						for (counter=0; counter < data.length; counter++) {
							$this.closest('.aq-block').find('.circleFlip').append(data[counter].postData);
						}
						if($this.closest('.CirclePosts').next('.circleFlip').find('.circleAnimationImage').length !== 0) {
									$this.closest('.CirclePosts').next('.circleFlip').find('.circleAnimationImage').each(function(index,element) {
										$(element).parent('.circleAnimation').css('height',$(element).parents('.circlePost').width() + 'px');
										$(element).css('height',$(element).parents('.circlePost').width() + 'px');
										if($(element).parents('.circleAnimationArea').length !== 0) {
											$(element).parents('.circleAnimationArea').css({
												'height' : $(element).parents('.circlePost').width()  - 40,
												'width' :  $(element).parents('.circlePost').width()  - 40
											});
											$(element).height($(element).parents('.circleAnimationArea').height());
										}
									});
								 }
						self.activatePrettyPhoto();
						self.activateGalleryModal();
						self.activateVideoPlayer($this.closest('.aq-block').find('.circleFlip'));
						$this.data('pagenumber',$this.data('pagenumber')+1);
					}

				}
	    });
	};
	circleFlip.prototype.loadRecentPosts = function(event) {
		self = this;
		$this = $(event.currentTarget);
			$.ajax({
				url : global_creiden.ajax_url,
				type: 'post',
				dataType: 'JSON',
				data : {
					pageNumber : $this.data('pagenumber'),
					postsnumber :  $this.data('postsnumber'),
					cat_id : $this.data('cats'),
					post_type : $this.data('posttype'),
					layout : $this.data('layout'),
                    post_or_portfolio: $this.data('postOrPortfolio'),
					action : 'recent_posts_loadmore'
				},
				success : function(data) {
					if(data.length === 0) {
						$.ajax({
							url : global_creiden.ajax_url,
							type: 'post',
							dataType: 'JSON',
							data : {
								pageNumber : 1,
								postsnumber :  $this.data('postsnumber'),
								cat_id : $this.data('cats'),
								post_type : $this.data('posttype'),
								layout : $this.data('layout'),
                                post_or_portfolio: $this.data('postOrPortfolio'),
								action : 'recent_posts_loadmore'
							},
							success : function(data) {
								var counter=0;
								$this.parents('.portfolio').next('.circleFlip').remove();
								$this.closest('.squarePostsWrapper').append('<div class="circleFlip row"></div>');
								for (counter=0; counter < data.length; counter++) {
									$this.closest('.aq-block').find('.circleFlip').append(data[counter].postData);
								}
								$this.data('pagenumber',2);
								self.activatePrettyPhoto();
								self.activateGalleryModal();
								self.activateVideoPlayer($this.closest('.aq-block').find('.circleFlip'));
								R = hexToR(global_creiden.background);
								G = hexToG(global_creiden.background);
								B = hexToB(global_creiden.background);
								$('.squarePostCont,.galleryCont,.hoverStyleNew').css('background-color','rgba('+R+', '+G+', '+B+', 0.80)');
							}
						});
					} else {
						var counter=0;
						$this.parents('.portfolio').next('.circleFlip').remove();
						$this.closest('.squarePostsWrapper').append('<div class="circleFlip row"></div>');
						for (counter=0; counter < data.length; counter++) {
							$this.closest('.aq-block').find('.circleFlip').append(data[counter].postData);
						}
						R = hexToR(global_creiden.background);
						G = hexToG(global_creiden.background);
						B = hexToB(global_creiden.background);
						$('.squarePostCont,.galleryCont,.hoverStyleNew').css('background-color','rgba('+R+', '+G+', '+B+', 0.80)');
						$this.data('pagenumber',$this.data('pagenumber')+1);
						self.activatePrettyPhoto();
						self.activateGalleryModal();
						self.activateVideoPlayer($this.closest('.aq-block').find('.circleFlip'));

					}
				}
	   });
	};
	circleFlip.prototype.loadPortfolioPosts = function(event) {
			self = this;
			$thisPortfolio = $(event.currentTarget);
			$.ajax({
				url : global_creiden.ajax_url,
				type: 'post',
				dataType: 'JSON',
				data : {
					pageNumber : $thisPortfolio.data('pagenumber'),
					postsnumber :  $thisPortfolio.data('postsnumber'),
					cat_id : $thisPortfolio.data('cats'),
					post_type : $thisPortfolio.data('posttype'),
					layout : $thisPortfolio.data('layout'),
                                      post_or_portfolio: $thisPortfolio.data('postOrPortfolio'),
					action : 'portfolio_posts_loadmore'
				},
				beforeSend: function() {

				},
				success : function(data) {

					if(data.length === 0) {
						$.ajax({
							url : global_creiden.ajax_url,
							type: 'post',
							dataType: 'JSON',
							data : {
								pageNumber : 1,
								postsnumber :  $thisPortfolio.data('postsnumber'),
								cat_id : $thisPortfolio.data('cats'),
								post_type : $thisPortfolio.data('posttype'),
								layout : $thisPortfolio.data('layout'),
                                post_or_portfolio: $thisPortfolio.data('postOrPortfolio'),
								action : 'portfolio_posts_loadmore'
							},
							success : function(data) {
								var counter=0;
								$thisPortfolio.closest('.aq-block').find('.circleFlip').remove();
								$thisPortfolio.closest('.aq-block').append('<div class="circleFlip row"></div>');
								for (counter=0; counter < data.length; counter++) {
									$thisPortfolio.closest('.aq-block').find('.circleFlip').append(data[counter].postData);
								}
								R = hexToR(global_creiden.background);
								G = hexToG(global_creiden.background);
								B = hexToB(global_creiden.background);
								$('.squarePostCont,.galleryCont,.hoverStyleNew').css('background-color','rgba('+R+', '+G+', '+B+', 0.80)');
								$thisPortfolio.data('pagenumber',2);
								self.activatePrettyPhoto();
								self.activateGalleryModal();
								self.activateVideoPlayer($thisPortfolio.closest('.aq-block').find('.circleFlip'));
							}
						});
					} else {
						$thisPortfolio.closest('.aq-block').find('.circleFlip').html('');
						var counter=0;
						for (counter=0; counter < data.length; counter++) {
							$thisPortfolio.closest('.aq-block').find('.circleFlip').append(data[counter].postData);
						}
						R = hexToR(global_creiden.background);
						G = hexToG(global_creiden.background);
						B = hexToB(global_creiden.background);
						$('.squarePostCont,.galleryCont,.hoverStyleNew').css('background-color','rgba('+R+', '+G+', '+B+', 0.80)');
						$thisPortfolio.data('pagenumber',$thisPortfolio.data('pagenumber')+1);
						self.activatePrettyPhoto();
						self.activateGalleryModal();
						self.activateVideoPlayer($thisPortfolio.closest('.aq-block').find('.circleFlip'));
					}
				}
	   });
	};
	circleFlip.prototype.loadSquareRedPosts = function(event) {
			// event.preventDefault();
			self = this;
			$thisSquareRed = $(event.currentTarget);
			$.ajax({
				url : global_creiden.ajax_url,
				type: 'post',
				dataType: 'JSON',
				data : {
					pageNumber : $thisSquareRed.data('pagenumber'),
					postsnumber :  $thisSquareRed.data('postsnumber'),
					cat_id : $thisSquareRed.data('cats'),
					post_type : $thisSquareRed.data('posttype'),
					layout : $thisSquareRed.data('layout'),
                    post_or_portfolio: $thisSquareRed.data('postOrPortfolio'),
					action : 'squarered_posts_loadmore'
				},
				beforeSend: function() {

				},
				success : function(data) {
					if(data.length === 0) {
						$.ajax({
							url : global_creiden.ajax_url,
							type: 'post',
							dataType: 'JSON',
							data : {
								pageNumber : 1,
								postsnumber :  $thisSquareRed.data('postsnumber'),
								cat_id : $thisSquareRed.data('cats'),
								post_type : $thisSquareRed.data('posttype'),
								layout : $thisSquareRed.data('layout'),
                                post_or_portfolio: $thisSquareRed.data('postOrPortfolio'),
								action : 'squarered_posts_loadmore'
							},
							success : function(data) {
								var counter=0;
								$thisSquareRed.closest('.aq-block').find('.circleFlip ul').html('');
								for (counter=0; counter < data.length; counter++) {
									$thisSquareRed.closest('.aq-block').find('.circleFlip ul').append(data[counter].postData);
								}
								R = hexToR(global_creiden.background);
								G = hexToG(global_creiden.background);
								B = hexToB(global_creiden.background);
								$('.squarePostCont,.galleryCont,.hoverStyleNew').css('background-color','rgba('+R+', '+G+', '+B+', 0.80)');
								$thisSquareRed.data('pagenumber',2);
								self.activatePrettyPhoto();
								self.activateGalleryModal();
								self.activateVideoPlayer($thisSquareRed.closest('.aq-block').find('.circleFlip'));
							}
						});
					} else {
						$thisSquareRed.closest('.aq-block').find('.circleFlip ul').html('');
						var counter=0;
						for (counter=0; counter < data.length; counter++) {
							$thisSquareRed.closest('.aq-block').find('.circleFlip ul').append(data[counter].postData);
						}
						R = hexToR(global_creiden.background);
						G = hexToG(global_creiden.background);
						B = hexToB(global_creiden.background);
						$('.squarePostCont,.galleryCont,.hoverStyleNew').css('background-color','rgba('+R+', '+G+', '+B+', 0.80)');
						$thisSquareRed.data('pagenumber',$thisSquareRed.data('pagenumber')+1);
						self.activatePrettyPhoto();
						self.activateGalleryModal();
						self.activateVideoPlayer($thisSquareRed.closest('.aq-block').find('.circleFlip'));
					}
				}
	   });
	};
	circleFlip.prototype.loadMagazine1Posts = function(event) {
			// event.preventDefault();
			self = this;
			$thisMag = $(event.currentTarget);
			$.ajax({
				url : global_creiden.ajax_url,
				type: 'post',
				dataType: 'JSON',
				data : {
					pageNumber : $thisMag.data('pagenumber'),
					postsnumber :  $thisMag.data('postsnumber'),
					cat_id : $thisMag.data('cats'),
					post_type : $thisMag.data('posttype'),
					layout : $thisMag.data('layout'),
                    post_or_portfolio: $thisMag.data('postOrPortfolio'),
					action : 'mag1_posts_loadmore'
				},
				beforeSend: function() {

				},
				success : function(data) {
					if(data.length === 0) {
						$.ajax({
							url : global_creiden.ajax_url,
							type: 'post',
							dataType: 'JSON',
							data : {
								pageNumber : 1,
								postsnumber :  $thisMag.data('postsnumber'),
								cat_id : $thisMag.data('cats'),
								post_type : $thisMag.data('posttype'),
								layout : $thisMag.data('layout'),
                                post_or_portfolio: $thisMag.data('postOrPortfolio'),
								action : 'mag1_posts_loadmore'
							},
							success : function(data) {
								var counter=0;
								$thisMag.closest('.aq-block').find('.circleFlip').html('');
								for (counter=0; counter < data.length; counter++) {
									$thisMag.closest('.aq-block').find('.circleFlip').append(data[counter].postData);
								}
								$thisMag.data('pagenumber',2);
							}
						});
					} else {
						$thisMag.closest('.aq-block').find('.circleFlip').html('');
						var counter=0;
						for (counter=0; counter < data.length; counter++) {
							$thisMag.closest('.aq-block').find('.circleFlip').append(data[counter].postData);
						}
						$thisMag.data('pagenumber',$thisMag.data('pagenumber')+1);
					}
				}
	   });
	};
	circleFlip.prototype.loadMagazine2Posts = function(event) {
			// event.preventDefault();
			self = this;
			$thisMag = $(event.currentTarget);
			$.ajax({
				url : global_creiden.ajax_url,
				type: 'post',
				dataType: 'JSON',
				data : {
					pageNumber : $thisMag.data('pagenumber'),
					postsnumber :  $thisMag.data('postsnumber'),
					cat_id : $thisMag.data('cats'),
					post_type : $thisMag.data('posttype'),
					layout : $thisMag.data('layout'),
                    post_or_portfolio: $thisMag.data('postOrPortfolio'),
					action : 'mag2_posts_loadmore'
				},
				beforeSend: function() {

				},
				success : function(data) {
					if(data.length === 0) {
						$.ajax({
							url : global_creiden.ajax_url,
							type: 'post',
							dataType: 'JSON',
							data : {
								pageNumber : 1,
								postsnumber :  $thisMag.data('postsnumber'),
								cat_id : $thisMag.data('cats'),
								post_type : $thisMag.data('posttype'),
								layout : $thisMag.data('layout'),
                                post_or_portfolio: $thisMag.data('postOrPortfolio'),
								action : 'mag2_posts_loadmore'
							},
							success : function(data) {
								var counter=0;
								$thisMag.closest('.aq-block').find('.circleFlip').html('');
								for (counter=0; counter < data.length; counter++) {
									$thisMag.closest('.aq-block').find('.circleFlip').append(data[counter].postData);
								}
								$thisMag.data('pagenumber',2);
							}
						});
					} else {
						$thisMag.closest('.aq-block').find('.circleFlip').html('');
						var counter=0;
						for (counter=0; counter < data.length; counter++) {
							$thisMag.closest('.aq-block').find('.circleFlip').append(data[counter].postData);
						}
						$thisMag.data('pagenumber',$thisMag.data('pagenumber')+1);
					}
				}
	   });
	};
	circleFlip.prototype.loadMagazine3Posts = function(event) {
			// event.preventDefault();
			self = this;
			$thisMag = $(event.currentTarget);
			$.ajax({
				url : global_creiden.ajax_url,
				type: 'post',
				dataType: 'JSON',
				data : {
					pageNumber : $thisMag.data('pagenumber'),
					postsnumber :  $thisMag.data('postsnumber'),
					cat_id : $thisMag.data('cats'),
					post_type : $thisMag.data('posttype'),
					layout : $thisMag.data('layout'),
                    post_or_portfolio: $thisMag.data('postOrPortfolio'),
					action : 'mag3_posts_loadmore'
				},
				beforeSend: function() {

				},
				success : function(data) {
					if(data.length === 0) {
						$.ajax({
							url : global_creiden.ajax_url,
							type: 'post',
							dataType: 'JSON',
							data : {
								pageNumber : 1,
								postsnumber :  $thisMag.data('postsnumber'),
								cat_id : $thisMag.data('cats'),
								post_type : $thisMag.data('posttype'),
								layout : $thisMag.data('layout'),
                                post_or_portfolio: $thisMag.data('postOrPortfolio'),
								action : 'mag3_posts_loadmore'
							},
							success : function(data) {
								var counter=0;
								$thisMag.closest('.aq-block').find('.circleFlip').html('');
								for (counter=0; counter < data.length; counter++) {
									$thisMag.closest('.aq-block').find('.circleFlip').append(data[counter].postData);
								}
								$thisMag.data('pagenumber',2);
							}
						});
					} else {
						$thisMag.closest('.aq-block').find('.circleFlip').html('');
						var counter=0;
						for (counter=0; counter < data.length; counter++) {
							$thisMag.closest('.aq-block').find('.circleFlip').append(data[counter].postData);
						}
						$thisMag.data('pagenumber',$thisMag.data('pagenumber')+1);
					}
				}
	   });
	};
	circleFlip.prototype.loadMagazine4Posts = function(event) {
			// event.preventDefault();
			self = this;
			$thisMag = $(event.currentTarget);
			$.ajax({
				url : global_creiden.ajax_url,
				type: 'post',
				dataType: 'JSON',
				data : {
					pageNumber : $thisMag.data('pagenumber'),
					postsnumber :  $thisMag.data('postsnumber'),
					cat_id : $thisMag.data('cats'),
					post_type : $thisMag.data('posttype'),
					layout : $thisMag.data('layout'),
                    post_or_portfolio: $thisMag.data('postOrPortfolio'),
					action : 'mag4_posts_loadmore'
				},
				beforeSend: function() {

				},
				success : function(data) {
					if(data.length === 0) {
						$.ajax({
							url : global_creiden.ajax_url,
							type: 'post',
							dataType: 'JSON',
							data : {
								pageNumber : 1,
								postsnumber :  $thisMag.data('postsnumber'),
								cat_id : $thisMag.data('cats'),
								post_type : $thisMag.data('posttype'),
								layout : $thisMag.data('layout'),
                                post_or_portfolio: $thisMag.data('postOrPortfolio'),
								action : 'mag4_posts_loadmore'
							},
							success : function(data) {
								var counter=0;
								$thisMag.closest('.aq-block').find('.circleFlip').html('');
								for (counter=0; counter < data.length; counter++) {
									$thisMag.closest('.aq-block').find('.circleFlip').append(data[counter].postData);
								}
								$thisMag.data('pagenumber',2);
							}
						});
					} else {
						$thisMag.closest('.aq-block').find('.circleFlip').html('');
						var counter=0;
						for (counter=0; counter < data.length; counter++) {
							$thisMag.closest('.aq-block').find('.circleFlip').append(data[counter].postData);
						}
						$thisMag.data('pagenumber',$thisMag.data('pagenumber')+1);
					}
				}
	   });
	};
	circleFlip.prototype.searchAnimation = function(event) {
		if($('.searchbar.style1').hasClass('closed')) {
			$('.searchbar.style1').removeClass('closed').addClass('opened');
		}
		else {
			$('.searchbar.style1').addClass('closed').removeClass('opened');
		}
	};
    
    if(!global_creiden.headerBuilder) {
        circleFlip.prototype.headerJS = function(event) {
            //Menu Initialization
            $(window).scroll(function() {
                if($('.headerStyle9').length == 0){
                    if ($(window).scrollTop() > $('header').height()) {
                        if( $(window) > 979 ) {
                            $('.headerWrapper header').addClass('headerStickyActive');
                        }else{
                            $('.headerWrapper').addClass('sticky');
                        }
                        if ($('#wpadminbar').length > 0) { 
                            $('.headerWrapper').addClass('wpadminSticky');
                        }
                    }
                    else {
                        $('.headerWrapper header').removeClass('headerStickyActive');
                        $('.headerWrapper').removeClass('sticky');
                        $('.headerWrapper').removeClass('wpadminSticky');
                    }
                }
            });
            $(".top_header_style3").sticky({topSpacing:0});
            $('.sticky-wrapper').addClass('hide');
            if($('#js-news').length != 0) {
                if(global_creiden.rtl){
                    $('#js-news').ticker({direction: 'rtl'});
                }else{
                    $('#js-news').ticker();
                }
            }

            // adds the class to the last item to make the submenus goes to the right
            $('header').each(function(index,element) {
                $(element).find('.nav > .menu-item').last().children('.dropdown-menu').find('.dropdown-menu').addClass('mostRight');
            });


            $('.menu-item a').click(function() {
                 if($(this).attr('href').charAt(0) == "#") {
                   $('.current_page_item').removeClass('current_page_item').removeClass('active').removeClass('current-menu-item');
                   $(this).parent().addClass('current_page_item').addClass('active');
                 }
           });

        };
        circleFlip.prototype.navigationButton = function(event) {
            if($('.navigationButton').hasClass('closed')) {
                $('.navigationButton').removeClass('closed').addClass('opened');
                $('.top_header_style3').css({'margin-top': -$('.top_header_style3').height() + 'px'});
                $('.top_header_style3').removeClass('topActive');
            } else {
                $('.navigationButton').addClass('closed').removeClass('opened');
                $('.top_header_style3').css({'margin-top':'0'});
                $('.top_header_style3').addClass('topActive');
                $('.sticky-wrapper').removeClass('hide');
            }
        };
    } else {
        /**
         * Header Builder
         */
        // Breaking News
        if ($('#js-news').length != 0) {
            if (global_creiden.rtl) {
                $('#js-news').ticker({
                    direction: 'rtl'
                });
            } else {
                $('#js-news').ticker();
            }
        }
        //--- Side Header 
        // Side Header Bottom Content
        $('.sideHeader .rowWrapper').each(function(index, element) {
            $(element).find('.headerRight').wrapAll('<div class="sideBottom"></div>');
        });
        // Side Header Bar
        if ($('.sideHeader .rowWrapper:first-child').hasClass('mainHeader')) {
            var sideHeaderBar = false;
        }
    };
    // Header Builder End
    
	circleFlip.prototype.windowResize = function(event) {
        if(!global_creiden.headerBuilder) {
            if($(window).width() < 979) {
                $(".mainHeader .navCollapse").removeClass('mainNav');
            } else {
                $(".mainHeader .navCollapse").addClass('mainNav');
            }

            if($(window).width() < 979) {

                $(document).mouseup(function(e) {
                    var container = $(".smallHeader .navCollapse");
                    if (!container.is(e.target) && container.has(e.target).length === 0) {
                        container.stop();
                        container.slideUp(500);
                    }
                });
                $(".smallHeader .navCollapse").removeClass('mainNav');
            }else{
                $(".smallHeader .navCollapse").addClass('mainNav');
                $(".smallHeader .navCollapse").slideUp(500);
            };
        } else {
            this.headerJSresponsive();
        };
		$('.postDetails .postImage iframe').css({'height': $('.postDetails .postImage iframe').width()/2});
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
		if(global_creiden.responsive) {
			if($(window).width() < 979 && $(window).width() > 768) {
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
			else if($(window).width() < 767) {
			$('.galleryStyle2').each(function(){
				var $this = $(this);
				$this.find('.galleryThumbnails').trigger('destroy',true);
			});
			}
		}
		$('.teamDetails').each(function(){
			$(this).css({'width' : $(this).parents('.aq-block-cr_team_block').find('.circleTeam').width()-$(this).parents('.aq-block-cr_team_block').find('.full')});
		});
		// Circle Post
		if($('.circleAnimationImage').length !== 0) {
			$('.circleAnimationImage').each(function(index,element) {
				$(element).parent('.circleAnimation').css('height',$(element).parents('.circlePost').width() + 'px');
				$(element).css('height',$(element).parents('.circlePost').width() + 'px');
				if($(element).parents('.circleAnimationArea').length !== 0) {
					$(element).parents('.circleAnimationArea').css({
						'height' : $(element).parents('.circlePost').width()  - 40,
						'width' :  $(element).parents('.circlePost').width()  - 40
					});
					$(element).height($(element).parents('.circleAnimationArea').height());
				}
			});
		 }
		if($('.memberImage').length !== 0) {
			$('.memberImage').css({
		    	'height' : $('.aboutMember .memberImage').parent().parent().width() + 'px',
				'width' : $('.aboutMember .memberImage').parent().parent().width() + 'px'
			});
		}
		if($('.subscribe').length !== 0) {
			$('.subscribe a').each(function(){
				if($(window).width() > 750) {
					$(this).css({'top' : $(this).parent().height()/2 + 2  + 'px'});
				}else{
					$(this).css({'top' : '0px'});
				}
			});
		}

	};
	circleFlip.prototype.singleCommentsTabbed = function(event) {
		var $this = $(event.currentTarget);
		$this.addClass('active').siblings().removeClass('active');
		if($this.hasClass('wpComments')){
			$('.wp_comments').addClass('active').siblings().removeClass('active');
		}
		else{
			$('.facebook_comments').addClass('active').siblings().removeClass('active');
		}
	};


	circleFlip.prototype.animateElements = function() {
		/* Make it work with the document ready */
		$('.animateCr').each(function(i, element) {
				/* Check the location of each desired element */
				var outer_height = $(element).outerHeight();
				var bottom_of_object = $(element).offset().top + outer_height;
				var bottom_of_window = $(window).scrollTop() + $(window).height();
				/* If the object is completely visible in the window, fade it */
				if (bottom_of_window > bottom_of_object + 50) {
					setTimeout(function() {
						$(element).addClass('animate_CF').removeClass('animateCr');
					}, i * 250);
				}
		});
		/* Every time the window is scrolled ... */
		$(window).scroll(function() {
			$('.animateCr').each(function(i, element) {
					/* Check the location of each desired element */
					var outer_height = $(element).outerHeight();
					var top_of_object = $(element).offset().top + outer_height/2;
					var bottom_of_window = $(window).scrollTop() + $(window).height();
					/* If the object is completely visible in the window, fade it */
					if (bottom_of_window > top_of_object) {
						setTimeout(function() {
							$(element).addClass('animate_CF').removeClass('animateCr');
						}, i * 250);
					}
			});
		});
	};
	circleFlip.prototype.activateGalleryModal = function() {
		if($('.circleModal, .squareModal').length !== 0) {
				$('.circleModal, .squareModal').css({ position: "absolute", visibility: "hidden", display: "block" });
				$('.circleModal .postSlider, .squareModal .postSlider').show().each(function(index,element) {
					$(element).find('li').css('width',$(element).width());
					$(element).find('ul').css('width',$(element).find('li').size() * $(element).find('li').width());//Initialize upper image slider
				});
				$('.circleModal, .squareModal').css({ position: "", visibility: "", display: "" });
			}
	};
	circleFlip.prototype.activateVideoPlayer = function($element) {
		var settings = {};
		if ( typeof _wpmejsSettings !== 'undefined' )
			settings.pluginPath = _wpmejsSettings.pluginPath;
	};
    
    // Header Builder Events
    circleFlip.prototype.stickyHeader = function(event) {
        if ($(window).scrollTop() > $('header').position().top + $('header').height()) {
            $('header').addClass('preSticky');
            setTimeout(function() {
                $('header').addClass('activeSticky');
            }, 1);
        } else {
            $('header').removeClass('preSticky');
            $('header').removeClass('activeSticky');
        };
    };
    circleFlip.prototype.overlayRows = function(event) {
        $('.stickyHeader').removeClass('lightContent darkContent');
        $('.stickyHeader').each(function(sticky) {
            $(this).addClass($(this).attr('content-color'));
        });
    };
    circleFlip.prototype.overlayResponsive = function(event) {
        $('.rowWrapper').removeClass('lightContent darkContent');
        $('.rowWrapper').each(function(sticky) {
            $(this).addClass($(this).attr('content-color'));
        });
    };
    circleFlip.prototype.overlayDefault = function(event) {
        $('.rowWrapper').removeClass('lightContent darkContent');
        $('.rowWrapper').addClass($('header').attr('content-color'));
    };
    circleFlip.prototype.overlayStickyDefault = function(event) {
        $('.stickyHeader').removeClass('lightContent darkContent');
        $('.stickyHeader').addClass($('header').attr('content-color'));
    };
    circleFlip.prototype.headerJSresponsive = function(event) {
        $thisHeader = this;
        // Overlayed Header
        if ($('header').hasClass('overlayedHeader')) {
            if ($(window).width() > 768) {
                if ($(window).scrollTop() > $('header').position().top + $('header').height()) {
                    $thisHeader.overlayRows();
                } else {
                    $thisHeader.overlayDefault();
                }
            } else {
                $thisHeader.overlayResponsive();
            }
        };
        // Side Header Bar
        if ($(window).width() > 980 && sideHeaderBar == false) {
            $('.sideHeader .rowWrapper:first-child').removeClass('mainHeader topHeader').addClass('topHeader');
        } else if ($(window).width() < 980 && sideHeaderBar == false) {
            $('.sideHeader .rowWrapper:first-child').removeClass('mainHeader topHeader').addClass('mainHeader');
        }
        $(window).scroll(function() {
            // Default Header
            if ($('header.defaultHeader').children('.stickyHeader.responsiveCheck').length > 0) {
                $thisHeader.stickyHeader();
            } else if ($(window).width() > 768 && $('header.defaultHeader').children('.stickyHeader').length > 0) {
                $thisHeader.stickyHeader();
            };
            // Overlayed Header
            if ($('header.overlayedHeader').children('.stickyHeader.responsiveCheck').length > 0) {
                $thisHeader.stickyHeader();
                if ($(window).width() > 768) {
                    if ($(window).scrollTop() > $('header').position().top + $('header').height()) {
                        $thisHeader.overlayRows();
                    } else {
                        $thisHeader.overlayStickyDefault();
                    }
                }
            } else if ($(window).width() > 768 && $('header.overlayedHeader').children('.stickyHeader').length > 0) {
                $thisHeader.stickyHeader();
                if ($(window).scrollTop() > $('header').position().top + $('header').height()) {
                    $thisHeader.overlayRows();
                } else {
                    $thisHeader.overlayStickyDefault();
                }
            };
            // Side Header
            if ($(window).width() < 980 && $('header.sideHeader').children('.stickyHeader.responsiveCheck').length > 0) {
                $thisHeader.stickyHeader();
            } else if ($(window).width() > 768 && $(window).width < 980 && $('header.sideHeader').children('.stickyHeader').length > 0) {
                $thisHeader.stickyHeader();
            };
        });
        if ($(window).width() > 980) {
            // Responsive Menu
            $('.headerMenu.responsiveCheck').removeClass('openMenu');
            $('.headerMenu.responsiveCheck .menuWrapper').show();
            //--- Side Header
            if (global_creiden.rtl == false) {
                $('.sideHeader').css('left', 50 - $('.sideHeader').width());
            } else {
                $('.sideHeader').css('right', 50 - $('.sideHeader').width());
            }
            $('.sideToggle').off('click');
            $('.sideToggle').on('click', function() {
                $('.sideHeader').toggleClass('openSideHeader');
            });
            // Menu in small row
            $('.sideHeader .topHeader').find('.headerMenu').removeClass('headerMenu').addClass('toggledMenu defaultMenu');
        } else if ($(window).width() < 980) {
            // Side Header Menu in small row
            $('.sideHeader').find('.toggledMenu.defaultMenu').removeClass('toggledMenu defaultMenu').addClass('headerMenu');
            // Responsive Menu
            $('.headerMenu.responsiveCheck .menuWrapper').hide();
            $('.headerMenu.responsiveCheck .toggleMenuBtn').off('click');
            $('.headerMenu.responsiveCheck .toggleMenuBtn').on('click', function() {
                $(this).parent('.headerMenu').toggleClass('openMenu');
                if ($(this).parent('.headerMenu').hasClass('openMenu')) {
                    $(this).siblings('.menuWrapper').slideDown();
                } else {
                    $(this).siblings('.menuWrapper').slideUp();
                }
            });
            $(document).mouseup(function(responsiveMenu) {
                var container = $(".headerMenu.responsiveCheck.openMenu");
                if (!container.is(responsiveMenu.target) && container.has(responsiveMenu.target).length === 0) {
                    container.removeClass('openMenu');
                    container.find('.menuWrapper').slideUp();
                }
            });
            //--- Side Header
            if (global_creiden.rtl == false) {
                $('.sideHeader').css('left', 0);
            } else {
                $('.sideHeader').css('right', 0);
            }
        };
    };
    // Menu Search
    circleFlip.prototype.headerMenuSearch = function(event) {
        var $this = $(event.currentTarget);
        $this.parent('.headerMenuSearch').toggleClass('openSearch');
    };
    circleFlip.prototype.headerMenuSearchClose = function(event) {
        var container = $(".headerMenuSearch");
        if (!container.is(event.target) && container.has(event.target).length === 0) {
            container.removeClass('openSearch');
        }
    };
    // Toggled Menu
    var menuzIndex = 10;
    circleFlip.prototype.toggledMenu = function(event) {
        var $this = $(event.currentTarget);
        menuzIndex++;
        $this.parent('.toggledMenu').toggleClass('openMenu');
        $this.siblings('.menuWrapper').css('z-index', menuzIndex);
        $('body').addClass('animateBody');
        if ($this.parent('.toggledMenu').hasClass('openMenu')) {
            $('body').addClass('animateBody');
            if ($this.parent('.toggledMenu').hasClass('toggleLeft')) {
                $('body').addClass('slideBodyLeft');
            } else {
                $('body').addClass('slideBody');
            }
        } else {
            if ($('.toggledMenu.openMenu').length == 0) {
                $('body').removeClass('slideBody slideBodyLeft');
                setTimeout(function() {
                    $('body').removeClass('animateBody');
                }, 500);
            }
        }
    };
    circleFlip.prototype.toggledMenuClose = function(event) {
        var $this = $(event.currentTarget);
        $this.parents('.toggledMenu').removeClass('openMenu');
        if ($('.toggledMenu.openMenu').length == 0) {
            $('body').removeClass('slideBody slideBodyLeft');
            setTimeout(function() {
                $('body').removeClass('animateBody');
            }, 500);
        }
    };
    // Header Builder Events End
    
	$.fn.circleFlip = function(option, args) {
		return this.each(function() {
			var $this = $(this), data = $this.data('circleFlip'), options = typeof option == 'object' && option;
			if (!data)
				$this.data('circleFlip', ( data = new circleFlip(this, options)));
			if ( typeof option == 'string')
				data[option](args);
		});
	};

	$.fn.circleFlip.Constructor = circleFlip;
	$(document).circleFlip();
});
