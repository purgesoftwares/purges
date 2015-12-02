/*
    Header Part
*/
this.$element.on('click', ".headerMenuSearch > span", jQuery.proxy(this.headerMenuSearch, this));
this.$element.on('click', ".toggledMenu .toggleMenuBtn", jQuery.proxy(this.toggledMenu, this));
this.$element.on('click', ".closeMenu", jQuery.proxy(this.toggledMenuClose, this));
this.$element.on('click', document, jQuery.proxy(this.headerMenuSearchClose, this));

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
//--- Side Header 
// Side Header Bottom Content
$('.sideHeader .rowWrapper').each(function(index, element) {
    $(element).find('.headerRight').wrapAll('<div class="sideBottom"></div>');
});
// Side Header Bar
if ($('.sideHeader .rowWrapper:first-child').hasClass('mainHeader')) {
    var sideHeaderBar = false;
}
circleFlip.prototype.headerJSresponsive = function(event) {
    $this = this;
    // Overlayed Header
    if ($('header').hasClass('overlayedHeader')) {
        if ($(window).width() > 768) {
            if ($(window).scrollTop() > $('header').position().top + $('header').height()) {
                $this.overlayRows();
            } else {
                $this.overlayDefault();
            }
        } else {
            $this.overlayResponsive();
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
            $this.stickyHeader();
        } else if ($(window).width() > 768 && $('header.defaultHeader').children('.stickyHeader').length > 0) {
            $this.stickyHeader();
        };
        // Overlayed Header
        if ($('header.overlayedHeader').children('.stickyHeader.responsiveCheck').length > 0) {
            $this.stickyHeader();
            if ($(window).width() > 768) {
                if ($(window).scrollTop() > $('header').position().top + $('header').height()) {
                    $this.overlayRows();
                } else {
                    $this.overlayStickyDefault();
                }
            }
        } else if ($(window).width() > 768 && $('header.overlayedHeader').children('.stickyHeader').length > 0) {
            $this.stickyHeader();
            if ($(window).scrollTop() > $('header').position().top + $('header').height()) {
                $this.overlayRows();
            } else {
                $this.overlayStickyDefault();
            }
        };
        // Side Header
        if ($(window).width() < 980 && $('header.sideHeader').children('.stickyHeader.responsiveCheck').length > 0) {
            $this.stickyHeader();
        } else if ($(window).width() > 768 && $(window).width < 980 && $('header.sideHeader').children('.stickyHeader').length > 0) {
            $this.stickyHeader();
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
// Header Builder End
circleFlip.prototype.windowResize = function(event) {
    this.headerJSresponsive();
};