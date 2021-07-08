
$(window).scroll(function() {    
    let scroll = $(window).scrollTop();
    let sticPoint = 1;
    if (scroll >= sticPoint) {
        $("header").addClass("hSticky");
    }else {
    	$("header").removeClass("hSticky");
    }
});

$(function(){
	
	if ($(window).width() > 1024){
		$(".navMenu .dropdown").hover(
	        function () {
	            $('.dropdown-menu', this).stop(true, true).slideDown("slow");
	            $(this).addClass('open');
	        },
	        function () {
	            $('.dropdown-menu', this).stop(true, true).slideUp("slow");
	            $(this).removeClass('open');
	        }
	    );
	}
	else {
		return false;
	}
});

$(document).ready(function() {

	$(".navBarBtn").on("click",function(){
		$(".navFlex").animate({height: "toggle"});
	});

	$(".navSearchBtn").on("click",function(e){
		e.preventDefault();
		$(".shDesktop").fadeIn("fast");
	});

	$(".shDismiss").on("click",function(e){
		e.preventDefault();
		$(".shDesktop").fadeOut("fast");
	});

	// if ($(window).width > 1024){
	// 	$('.navMenu .dropdown').hover(function() {
	// 		$(this).find('.dropdown-menu').first().stop(true, true).delay(250).slideDown();
	// 		}, function() {
	// 		$(this).find('.dropdown-menu').first().stop(true, true).delay(100).slideUp()
	// 	});
	// }
	// else {
	// 	return false;
	// }


	

	$('#testimonial').owlCarousel({
		nav: false, dots: true, loop: true, autoplay: true, items: 1
	});

	$('#blogSlide').owlCarousel({
		margin: 30, nav: false, dots: true, loop: true, autoplay: true, responsive: {
			0: { items: 1 },
			640: { items: 2 },
			990: { items: 3 }
		}
	});

	// Magnific Popup JS
	$('.imgPopup').magnificPopup({
		type: 'image',
	  	mainClass: 'mfp-with-zoom', 
	  	gallery:{enabled:true},
		zoom: { enabled: true, duration: 300, easing: 'ease-in-out', opener: function(openerElement) 
			{
	    		return openerElement.is('img') ? openerElement : openerElement.find('img');
		  	}
		}
	});

	$('.videoPopup').magnificPopup({
		type: 'iframe',
	  	mainClass: 'mfp-with-zoom',
	  	gallery:{enabled:true}, 
	  	preloader: true
	});

	

	$('select.as_Select').niceSelect();
	

	var module = document.querySelectorAll(".multiline-ellipsis");
		var i;
		for (i = 0; i < module.length; i++) {
			$clamp(module[i], {clamp: 4});
		};
	
});


// Rating Star JS

// $(function(){
// 	var ratingOptions = {
// 		selectors: {
// 			starsSelector: '.rating-stars',
// 			starSelector: '.rating-star',
// 			starActiveClass: 'is--active',
// 			starHoverClass: 'is--hover',
// 			starNoHoverClass: 'is--no-hover',
// 			targetFormElementSelector: '.rating-value'
// 		}
// 	};

// 	$(".rating-stars").ratingStars(ratingOptions);
// });

