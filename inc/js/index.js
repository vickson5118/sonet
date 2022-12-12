$(document).ready(function(){
	
	$('.all-carrousel-container').slick({
		dots: false,
		infinite: true,
		speed: 500,
		slidesToShow: 1,
		slidesToScroll: 1,
		prevArrow: '.carrousel-prev',
		nextArrow: '.carrousel-next',
		autoplay: true,
  		autoplaySpeed: 3000
	});
	
	$(".missions-container .one-mission-container").mouseenter(function(){
		$(this).find("p").animate({top: "0px"},300)
	})
	
	$(".missions-container .one-mission-container").mouseleave(function(){
		$(this).find("p").animate({position: "relative",top: "160px"},300)
	})
	
	$('.partenaires-content').slick({
			dots: false,
			infinite: true,
			speed: 500,
			slidesToShow: 4,
			slidesToScroll: 1,
			prevArrow: '.pub-prev',
			nextArrow: '.pub-next',
			autoplay: true,
	  		autoplaySpeed: 3000
		});
	
})