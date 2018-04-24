
(function ($) {
    'use strict';

    jQuery(document).ready(function () {


       /* Preloader */

        $(window).on('load', function() {
          $('body').addClass('loaded');
        });



       /* Smooth Scroll */

        $('a.smoth-scroll').on("click", function (e) {
            var anchor = $(this);
            $('html, body').stop().animate({
                scrollTop: $(anchor.attr('href')).offset().top - 50
            }, 1000);
            e.preventDefault();
        });




       /* Scroll Naviagation Background Change with Sticky Navigation */

        $(window).on('scroll', function () {
            if ($(window).scrollTop() > 100) {
                $('.header-top-area').addClass('navigation-background');
            } else {
                $('.header-top-area').removeClass('navigation-background');
            }
        });




       /* Mobile Navigation Hide or Collapse on Click */

        $(document).on('click', '.navbar-collapse.in', function (e) {
            if ($(e.target).is('a') && $(e.target).attr('class') != 'dropdown-toggle') {
                $(this).collapse('hide');
            }
        });
        $('body').scrollspy({
            target: '.navbar-collapse',
            offset: 195

		 });




        /* Scroll To Top */

        $(window).scroll(function(){
        if ($(this).scrollTop() >= 500) {
            $('.scroll-to-top').fadeIn();
         } else {
            $('.scroll-to-top').fadeOut();
         }
	   });


	    $('.scroll-to-top').click(function(){
		  $('html, body').animate({scrollTop : 0},800);
		  return false;
	    });

        $(window).load(function()
        {
        $(".typing").typed({
            strings: ["We all eat, and it would be a sad waste of opportunity to eat badly.", "One cannot think well, love well, sleep well, if one has not dined well.","Eat Good Feel Good!!"],
            typeSpeed: 70
          });
         });

        $(window).load(function(){

            setInterval(function()
            {
                window.clearInterval(0);
        $(".typing").typed({
            strings: ["We all eat, and it would be a sad waste of opportunity to eat badly.", "One cannot think well, love well, sleep well, if one has not dined well.","Eat Good Feel Good!!"],
            typeSpeed: 70
          });
      },28000);
         });


        /* Parallax Background */

        $(window).stellar({
            responsive: true,
            horizontalScrolling: false,
            hideDistantElements: false,
            horizontalOffset: 0,
            verticalOffset: 0,
        });




        /* Yoga Images Filtering */

        $('.yogaimages-inner').mixItUp();



        /* Magnific Popup */

        $('.yogaimages-popup').magnificPopup({
            type: 'image',

            gallery: { enabled: true },
			zoom: { enabled: true,
			        duration: 500

          },

         image:{
               markup: '<div class="mfp-figure yogaimages-pop-up">'+
               '<div class="mfp-close"></div>'+
               '<div class="mfp-img"></div>'+
               '<div class="mfp-bottom-bar yogaimages_title">'+
               '<div class="mfp-title"></div>'+
               '<div class="mfp-counter"></div>'+
               '</div>'+
               '</div>',

               titleSrc:function(item){
                return item.el.attr('title');
              }
            }


          });





        $(".yogaquote-carousel-list").owlCarousel({
            items: 1,
            autoPlay: true,
            stopOnHover: false,
            navigation: true,
            navigationText: ["<i class='fa fa-long-arrow-left fa-2x owl-navi'></i>", "<i class='fa fa-long-arrow-right fa-2x owl-navi'></i>"],
            itemsDesktop: [1199, 1],
            itemsDesktopSmall: [980, 1],
            itemsTablet: [768, 1],
            itemsTabletSmall: false,
            itemsMobile: [479, 1],
            autoHeight: true,
            pagination: false,
            transitionStyle : "backSlide"
        });

         /* Google Map */

         $('#my-address').gMap({
            zoom: 5,
            scrollwheel: true,
            maptype: 'ROADMAP',
            markers:[
            {
            address: "Bangalore",
            html: "<b>Address</b>: <br> Hampi Nagar,Vijayanagar, Bangalore, India",
            popup: true
            }
            ]
            });


            });

   })(jQuery);
