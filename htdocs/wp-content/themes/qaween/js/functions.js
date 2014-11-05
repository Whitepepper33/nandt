(function($) {
	"use strict";

    // Parallax effect
    $('#countdown, #header, .page-title, #rsvp').stellar({
        horizontalScrolling: false,
        verticalOffset: 10
    });

	// Main background image
	if( $('body.home').length > 0 ) {
		var $slideshow = $('#slideshow'),
			slideshowDuration = $slideshow.data('duration'),
			slideshowImages = [];

		$slideshow.find('.slideshow-images > li').each(function(){
			if ( $('img', this).attr('src') )
				slideshowImages.push([ $('img', this).attr('src') ]);
		});

		if ( slideshowImages.length )
			$slideshow.backstretch(slideshowImages, {duration: slideshowDuration, fade: 750});
	}

    var menu = jQuery('nav.main'),
        pos = menu.offset();

    $(menu).addClass('default');

    $(window).scroll( function(){
        // Floating navigation
        if( $(window).width() > '800' ) {
            if($(this).scrollTop() > pos.top+menu.height() && menu.hasClass('default')){
                menu.fadeOut('fast', function(){
                    $(this).removeClass('default').addClass('fixed').fadeIn('fast');
                });
            } else if($(this).scrollTop() <= pos.top && menu.hasClass('fixed')){
                menu.fadeOut('slow', function(){
                    $(this).removeClass('fixed').addClass('default').fadeIn('fast');
                });
            }
        } else {
        	$('nav.main').removeClass('fixed').addClass('default');
        }

        // Animate element on scroll
        $('.animate').each( function(i){
            
            var bottom_of_object = $(this).position().top + $(this).outerHeight();
            var bottom_of_window = $(window).scrollTop() + $(window).height();
            
            /* If the object is completely visible in the window, fade it it */
            if( bottom_of_window > bottom_of_object ){
                $(this).animate({'opacity':'1'}, 1000);
            }
        }); 
    });
    
	// Main Menu
	$('nav.main ul.nav').superfish({
		delay:       1,
		animation:   {opacity:'show',height:'show'},
		speed:       'fast',
		dropShadows: false
	});

   // Mobile Menu
   $('nav.main ul.nav').mobileMenu({
    	defaultText: 'Navigate to...',
	    className: 'menu-mobile',
	    subMenuDash: '&ndash;'
    });

    // Thumbnail overlay
    $('.overlay').hide();

    $('.gallery-item, .thumb-overlay').mouseenter(function() {
        $(this).find('.overlay').fadeIn('fast');
    });

    $('.gallery-item, .thumb-overlay').mouseleave(function() {
        $(this).find('.overlay').fadeOut('fast');
    });
    
    $('#reg-bttn, #select-bttn').click(function(e){
        e.preventDefault();
        $('.choose-region').show('fast');
        if($.browser.msie){
        	$('.choose-region').css("visibility","visible");
		}
	});

    $('#close-region').click(function(e){
        e.preventDefault();
        $('.choose-region').hide();
    });

	// prettyPhoto
	$('a[rel^="prettyPhoto"], dl.gallery-item a[href$=".jpg"], dl.gallery-item a[href$=".png"], dl.gallery-item a[href$=".gif"], dl.gallery-item a[href$=".jpeg"], a[rel="prettyPhoto"]').prettyPhoto({
		theme: 'pp_default',
		deeplinking: false,
		social_tools: false
	});

    // Gallery Mixitup
    if( $('#grid').length > 0 ) {
    	$('#grid').mixitup();
    }
	
	// Resize main background
	resizeWindow();

	// Countdown - Countup
	if( $('#countdown').length > 0 ) {
		var timeTarget = new Date(_warrior.countdown_time),
			timeCurrent = new Date(),
			timeDiff = (timeTarget.getTime()) - (timeCurrent.getTime());

		if ( timeDiff  > 0 ) {
			$('#timer').countdown({
				until: timeTarget,
				format: 'YODHMS',
				layout: $('#timer').html()
			});
		} else {
			$('#countdown .title > *').text(_warrior.countup_title);
			$('#timer').countdown({
				since: timeTarget,
				format: 'YODHMS',
				layout: $('#timer').html()
			});
		}
	}

	// RSVP form
	var $rsvpForm = $('#rsvp-form'),
		$rsvpLoader = $rsvpForm.find('.loader'),
		$rsvpAlert = $rsvpForm.find('.alert');
		
	$rsvpForm.bind('submit', function() {
		$.ajax({
			type: $rsvpForm.attr('method'),
			dataType: 'json',
			url: _warrior.ajaxurl,
			data: {
				name: $('#rsvp-name', this).val(),
				email: $('#rsvp-email', this).val(),
				persons: $('#rsvp-persons', this).val(),
				rsvp_event: $('#rsvp-event option:selected', this).text(),
				action: $('#rsvp-action', this).val(),
				nonce: $('#rsvp-nonce', this).val()
			},
			beforeSend: function() {
				$rsvpAlert.hide().attr('class', 'alert');
				$rsvpLoader.show();
			},
 			success: function(response) {
				$rsvpLoader.hide();
				$rsvpAlert.html(response.info).fadeIn();
				if ( response.error != false ) {
					$rsvpAlert.addClass('error');
				} else {
					$rsvpForm.find('.input').val('')
					$rsvpAlert.addClass('success');
				}
			}
		});
		return false;
	});
	
	$('.widget_categories a').prepend('<i class="fa fa-th-list"></i>');

	function resizeWindow(e) {
		var slideshowHeight = $(window).height() - $('#header').outerHeight();
		if( $('body.home').length > 0 ) {
			$('#slideshow, .backstretch').height(slideshowHeight);
		}

		// Vertical center read more button
	    $('.overlay .read-more, .wedding-date').flexVerticalCenter('top');
	};
	$(window).bind('resize', resizeWindow);

	$(window).load(function() {
		// Vertical center read more button
	    $('.overlay .read-more, .wedding-date').flexVerticalCenter('top');

	    // If Google Map widget is loaded
	    if( $('#map-wrapper').length > 0 ) {
	    	initializeMap();
	    }
	});

	// Google Map
    function initializeMap() {
		var name = $("#map-wrapper").data("map-name"),
			address = $("#map-wrapper").data("map-address"),
			image = $("#map-wrapper").data("map-image"),
			lat = $("#map-wrapper").data("map-lat"),
			lng = $("#map-wrapper").data("map-lng"),
			zoom = $("#map-wrapper").data("map-zoom");
		
		var infoWindow = new google.maps.InfoWindow;
		var html = "<div class='map-thumbnail'><img src='" + image + "' width='60' /></div><div class='map-detail'><a><b>" + name + "</b></a> <br/>" + address + '</div><div style="clear:both;"></div></div>';
		
		if ( lat !== "" && lng !== "" ) {
			var map = new google.maps.Map(document.getElementById("map-wrapper"), {
				center: new google.maps.LatLng(lat,lng),
				zoom: zoom,
				mapTypeId: 'roadmap',
				scrollwheel: false
			});

			var marker = new google.maps.Marker({
				map: map,
				position: map.getCenter(),
				icon: _warrior.map_market_icon,
				shadow: _warrior.map_market_shadow
			});
			
			bindInfoWindow(marker, map, infoWindow, html);
		} else {
			var geocoder = new google.maps.Geocoder();
			geocoder.geocode( { 'address': address}, function(results, status) {
				if(status == google.maps.GeocoderStatus.OK) {
					var map = new google.maps.Map(document.getElementById("map-wrapper"), {
						center: results[0].geometry.location,
						zoom: zoom,
						mapTypeId: 'roadmap',
						scrollwheel: false
					});

					var marker = new google.maps.Marker({
						map: map,
						position: results[0].geometry.location,
						icon: _warrior.map_market_icon,
						shadow: _warrior.map_market_shadow
					});

					bindInfoWindow(marker, map, infoWindow, html);
				}
			});
		}
    }
	
   function bindInfoWindow(marker, map, infoWindow, html) {
      google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
      });
    }

})(jQuery);