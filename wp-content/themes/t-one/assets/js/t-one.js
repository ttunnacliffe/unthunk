jQuery(document).ready(function($) {
	
	//Bootstrap classes
	$('#respond').addClass('comment-form p-top-40');
	$('#respond form').removeClass('comment-form');
    $('.comment-form #submit').addClass('btn btn-default');
	$(".comment-edit-link").addClass("pull-right");
	$(".comment-reply-link").addClass("pull-right");
	$("#wp-calendar").addClass("table");
	$(".widget_archive select").addClass("form-control");
	$(".wp-caption").addClass("img-responsive");
	$('.menu-item-has-children > a').addClass('dropdown-toggle').attr('data-toggle', 'dropdown');
	$('.menu-item-has-children > a').append('<b class="caret"></b>');
	$('.navbar-default li').addClass('page-scroll');
	
});

jQuery(document).ready(function ($) {


    //jQuery for page scrolling feature - requires jQuery Easing plugin
$(function () {
    $('.page-scroll a').bind('click', function (event) {
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: $($anchor.attr('href')).offset().top
        }, 1500, 'easeInOutExpo');
        event.preventDefault();
    });
});


});

jQuery(document).ready(function ($) {
    $('.popup').magnificPopup({
        type: 'image'
    });
});

jQuery(document).ready(function ($) {
    var $adminBar = $('.navbar-wrap').attr('data-admin');
	if( $adminBar == 'adminbar') { var $top = 32 } else { var $top = 0 };
    $(".navbar-wrap").sticky({
        topSpacing: $top
    });
});

//Portfolio

jQuery('.isotope-item').hover(function () {
        jQuery('.text-work', this).stop().animate({
            'top': '0%',
            opacity: 1
        }, 200);

    },
    function () {
        jQuery('.text-work', this).stop().animate({
            'top': '100%',
            opacity: 0
        }, 200, function () {
            jQuery(this).css('top', '-100%')
        });

    }
);

// Isotope Portfolio
var $container = jQuery('#portfolio-container');
$container.isotope({
    filter: '*',
    animationOptions: {
        duration: 750,
        easing: 'linear',
        queue: false
    },
    layoutMode: 'masonry'
});


jQuery('.portfolio-categories li a').click(function () {
    jQuery('.portfolio-categories li').removeClass('active');
    jQuery(this).parent().addClass('active');

    var selector = jQuery(this).attr('data-filter');
    $container.isotope({
        filter: selector,
        animationOptions: {
            duration: 750,
            easing: 'linear',
            queue: false
        },
        layoutMode: 'fitRows'
    });
    return false;
});



jQuery(window).load(function () {
    $container.isotope('reLayout');
});

jQuery(document).ready(function ($) {

    $("#quote").owlCarousel({
        navigation: true, //Show next and prev buttons
        slideSpeed: 300,
        paginationSpeed: 400,
        singleItem: true,
        navigation: false

    });

});


jQuery(document).ready(function ($) {
	var $animationSpeed = $('.flexslider').attr('data-speed');
	var $directionNav = $('.flexslider').attr('data-direction-nav');
	
    $('.flexslider').flexslider({
		animation:'fade',
        animationSpeed: $animationSpeed,
        directionNav: $directionNav,
        controlNav: false,
		useCSS: false,
		touch:true,

    });
    $('.project-slide').flexslider({
        animation: "slide"
    });

});



(function($) {
  "use strict";

jQuery.fn.exists = function() {
                  return this.length > 0;
              }

    $(function() {
                var navMain = $(".navbar-collapse");
                navMain.on("click", "a", null, function() {
                    if ($(this).attr("href") !== "#") {
                        navMain.collapse('hide');
                    }
                });

                $("#wrapper").bind("click", function() {
                     if ($(".navbar-collapse.navbar-ex1-collapse.in").exists()) {
                        navMain.collapse('hide');
                    }
                });

            });

})(jQuery);




(function($) {
  "use strict";

jQuery.fn.exists = function() {
                  return this.length > 0;
              }

    $(function() {
                var navMain = $(".navbar-collapse");
                navMain.on("click", "a", null, function() {
                    if ($(this).attr("href") !== "#") {
                        navMain.collapse('hide');
                    }
                });

                $("#wrapper").bind("click", function() {
                     if ($(".navbar-collapse.navbar-ex1-collapse.in").exists()) {
                        navMain.collapse('hide');
                    }
                });

            });

})(jQuery);

jQuery(document).ready(function ($) {
	
	var ajaxurl = $('#contactform').attr('action');
	$('#contactform').removeAttr("action");
	
    // Send email 
    jQuery('#contactform').submit(function () {


        $("#message").slideUp(750, function () {
            $('#message').hide();
			
			var img = $('#submit').data('loader');

            $('#submit')
                .after('<img src="' + img + '" class="loader" />')
                .attr('disabled', 'disabled');
				
			challengeField = $("input#recaptcha_challenge_field").val();
    		responseField = $("input#recaptcha_response_field").val();

            $.post(ajaxurl, {
					action: 'ajaxContacForm',
                    name: $('#name').val(),
                    email: $('#email').val(),
                    phone: $('#phone').val(),
                    comments: $('#comments').val(),
					challengeField: $("#recaptcha_challenge_field").val(),
    				responseField: $("#recaptcha_response_field").val(),
					async: false
                },
                function (data) {
                    document.getElementById('message').innerHTML = data;
                    $('#message').slideDown('slow');
                    $('#contactform img.loader').fadeOut('slow', function () {
                        $(this).remove()
                    });
                    $('#submit').removeAttr('disabled');
                    if (data.match('success') != null) $('#contactform').slideUp('slow');

                }
            );

        });

        return false;

    });


});