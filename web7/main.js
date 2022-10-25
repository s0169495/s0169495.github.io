$(document).ready(function(){
	$('.slider').slick({
		arrows:true,
		dots:true,
		slidesToShow:4,
        slidesToScroll: 4,
		dotsClass: 'dots-style',
		responsive:[
			{
				breakpoint: 768,
				settings: {
					slidesToShow:2,
					slidesToScroll: 2
				}
			},
		]
	});
});


