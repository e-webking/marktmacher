
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
    var $hoverSrc = '';
    var $mainSrc = '';
    $('.hover-image').on('mouseenter', function (){
        $hoverSrc = $(this).find('.hover').attr('src');
        $mainSrc = $(this).find('.display').attr('src');
        $(this).find('.display').attr('src', $hoverSrc);
        $(this).find('.hover').attr('src', $mainSrc);
        
    });
    $('.hover-image').on('mouseleave', function (){
        $hoverSrc = $(this).find('.hover').attr('src');
        $mainSrc = $(this).find('.display').attr('src');
        $(this).find('.display').attr('src', $hoverSrc);
        $(this).find('.hover').attr('src', $mainSrc);
    });
    
    var $window = $(window);
    var menuanimate = function(){
        if($(window).width() > 768) {
            var winscrolled = $window.scrollTop();
            if (winscrolled >= 130) {
                $(".scrollh").fadeOut();
                $(".scrollv").fadeIn();
            } else {
                $(".scrollv").fadeOut();
                $(".scrollh").fadeIn();
            }
        }
        siteBody.removeClass('menu-is-open');
    }
   
    $window.on('scroll', menuanimate);
    if($(window).width() >= 1280) {
        $( '.parallax-block' ).jarallax({
            speed: 0.4,
            imgWidth: 1366,
            imgHeight: 768
        });
        
        $('.light-parallax').jarallax({
            speed: 0.2
        });
    } else {
        $( '.parallax-block' ).each(function(index){
            $(this).removeAttr('style');
        });
    }
    
    /* Registration */    
    $('#femanager_field_usergroup').on('change', function(){
        if ($(this).val() == 2) {
           var redPg = $('#studentRegPage').val();
           location.href = redPg;
        } 
    });
    
    /* Ajax call for username */
    $('#puser').on('blur', function(){
        var username = $('#puser').val();
        if (username == '') {
            $('#userprocess').html('Bitte geben Sie den Benutzernamen ein');
            $('#puser').focus();
        }
        
        if (username != '') {
            $('#userprocess').html('');
            $('#bformoverlay').show();
            var url = "index.php?eID=armpackage";
            $.ajax({
                    type: "POST",
                    url: url,
                    dataType: "json",
                    format: "json",
                    data: {
                            "arguments[username]": username,
                            "pluginName":"Company",
                            "controllerName":"Package",
                            "actionName":"getCompany",
                            "extensionName": "Armpackage",
                            "vendor": "ARM",
                            "formatName":"html"
                    }
            }).done(function( data ) {
                var html = '';
                $('#bformoverlay').hide();
                if (data.status == 'OK') {
                    //need to assign coupon
                       html += data.text
                       $('#feuser').val(data.uid);
                       $('#company').val(data.company);
                } else{
                       html += '<span class="error">'+data.error+'</span>';
                }
              $('#userprocess').html(html);
            });
        }
    });
    
    $('#packqty').on('change', function(){
        var qty = $('#packqty').val();
        var packuid = $('#package').val();
        var noofpart = $('#noofpart').val();
        
        if (qty < 1) {
            $('#buyprocess').html('Quantity must be greater than zero!');
            $('#btnsub').attr('disabled',1);
            $('#packqty').focus();
        }
        
        if (qty > 0) {
            $('#buyprocess').html('');
            $('#bformoverlay').show();
            var url = "index.php?eID=armpackageprice";
            $.ajax({
                    type: "POST",
                    url: url,
                    dataType: "json",
                    format: "json",
                    data: {
                            "arguments[package]": packuid,
                            "arguments[qty]": qty,
                            "arguments[noofpart]": noofpart,
                            "pluginName":"Package",
                            "controllerName":"Package",
                            "actionName":"getPrice",
                            "extensionName": "Armpackage",
                            "vendor": "ARM",
                            "formatName":"html"
                    }
            }).done(function( data ) {
                var html = '';
                $('#bformoverlay').hide();
                if (data.status == 'OK') {
                    $('#total').val(data.total);
                    $('#amount').val(data.amount);
                    $('#discount').val(data.discount);
                    $('#btnsub').removeAttr("disabled");;
                } else{
                    html += '<span class="error">'+data.error+'</span>';
                }
              $('#buyprocess').html(html);
            });
        }
    });
    $('#noofpart').on('change', function(){
        var qty = $('#packqty').val();
        var packuid = $('#package').val();
        var noofpart = $('#noofpart').val();
        
        if (noofpart < 1) {
            $('#buyprocess').html('Anzahl Seminar-Teilnehmer must be greater than zero!');
            $('#btnsub').attr('disabled',1);
            $('#noofpart').focus();
        }
        
        if (noofpart > 0) {
            $('#buyprocess').html('');
            $('#bformoverlay').show();
            var url = "index.php?eID=armpackageprice";
            $.ajax({
                    type: "POST",
                    url: url,
                    dataType: "json",
                    format: "json",
                    data: {
                            "arguments[package]": packuid,
                            "arguments[qty]": qty,
                            "arguments[noofpart]": noofpart,
                            "pluginName":"Package",
                            "controllerName":"Package",
                            "actionName":"getPrice",
                            "extensionName": "Armpackage",
                            "vendor": "ARM",
                            "formatName":"html"
                    }
            }).done(function( data ) {
                var html = '';
                $('#bformoverlay').hide();
                if (data.status == 'OK') {
                    $('#total').val(data.total);
                    $('#amount').val(data.amount);
                    $('#discount').val(data.discount);
                    $('#btnsub').removeAttr("disabled");;
                } else{
                    html += '<span class="error">'+data.error+'</span>';
                }
              $('#buyprocess').html(html);
            });
        }
    });
   
    menuTrigger.on('click',function(e){e.preventDefault();siteBody.toggleClass('menu-is-open');});
    closeButton.on('click',function(e){e.preventDefault();menuTrigger.trigger('click');});
    siteBody.on('click',function(e){if(!$(e.target).is('.header-nav, .header-nav__content, .header-menu-toggle, .header-menu-toggle span')){siteBody.removeClass('menu-is-open');}});
})(jQuery);

window.addEventListener("load", function(){
window.cookieconsent.initialise({
  "palette": {
    "popup": {
      "background": "#323232",
      "text": "#ffffff"
    },
    "button": {
      "background": "#f1d600"
    }
  },
  "content": {
    "message": "Um unsere Website für Sie optimal zu gestalten verwenden wir Cookies. Weitere Informationen/Datenschutzerklärung",
    "dismiss": "OK",
    "link": "Lern mehr",
    "href": "https://www.marktmacher.com/index.php?id=22"
  }
})});