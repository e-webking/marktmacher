
( function( $ ) {
    'use strict';
    $.fn.isInViewport = function() {
        var elementTop = $(this).offset().top;
        var elementBottom = elementTop + $(this).outerHeight();

        var viewportTop = $(window).scrollTop();
        var viewportBottom = viewportTop + $(window).height();

        return elementBottom > viewportTop && elementTop < viewportBottom;
    };
    
    $.fn.moveIt = function(){
        var $window = $(window);
        var instances = [];

        $(this).each(function(){
            instances.push(new moveItItem($(this)));
        });

        window.addEventListener('scroll', function(){
            var scrollTop = $window.scrollTop();
            instances.forEach(function(inst){
            inst.update(scrollTop);
            });
        }, {passive: true});
    }
    
  
    var moveItItem = function(el){
        this.el = $(el);
        this.speed = parseInt(this.el.attr('data-scroll-speed'));
    };

    moveItItem.prototype.update = function(scrollTop){
        if (this.el.isInViewport()) {
            var wrapOffset = this.el.offset();
            var wrapOffsetTop = wrapOffset.top;
            var amountScroll =  wrapOffsetTop - scrollTop;
            this.el.css('transform', 'translateY(-' + (amountScroll / this.speed) + 'px)');
        }
        
    };

    // Initialization
    $('[data-scroll-speed]').moveIt();


    /*----------- Preloader -----------*/
    var menuTrigger=$('.header-menu-toggle'),nav=$('.header-nav'),closeButton=nav.find('.header-nav__close'),siteBody=$('body');
    
    $(window).load(function () {
        $('.pulse').fadeOut();
        $('.preloader').delay(1000).fadeOut('slow');
    });
    $(window).resize(function () {
        $(".navbar-collapse").css({maxHeight: $(window).height() - $(".navbar-header").height() + "px"});
    });

    //menu on hover
    $('.js-activated').dropdownHover({
        instantlyCloseOthers: false,
        delay: 0
    }).dropdown();

    //owl arrows slider
    $(".owl-arrows-slider").owlCarousel({
        loop:true,
        margin:10,
        nav:false,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:3
            }
        }
    });
    
    var $window = $(window);
    var menuanimate = function(){
        if($(window).width() > 768) {
            var winscrolled = $window.scrollTop();
            if (winscrolled >= 550) {
                $(".scrollh").fadeOut();
                $(".scrollv").fadeIn();
            } else {
                $(".scrollv").fadeOut();
                $(".scrollh").fadeIn();
            }
        }
    }
   
    $window.on('scroll', menuanimate);

    $( '.parallax-block' ).jarallax({
        speed: 0.4,
        imgWidth: 1366,
        imgHeight: 768
    });
    
    $('.light-parallax').jarallax({
        speed: 0.2
    });
    menuTrigger.on('click',function(e){e.preventDefault();siteBody.toggleClass('menu-is-open');});
    closeButton.on('click',function(e){e.preventDefault();menuTrigger.trigger('click');});
    siteBody.on('click',function(e){if(!$(e.target).is('.header-nav, .header-nav__content, .header-menu-toggle, .header-menu-toggle span')){siteBody.removeClass('menu-is-open');}});
})(jQuery);
