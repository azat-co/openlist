$(document).ready(function(){
	$('li[class=category]>a').click(function (e){
		e.preventDefault();
		$(this).next().next().toggle('fast');
		$(this).toggleClass('open');		
		//alert('!');
		});

	$('li[class=category]>a').next().next().hide('slow');
	

	$('li[class=category]>a').attr({title:''});

	$('li[class=category]>a').hover(function(e) {
		$(this).next()
		.stop(true, true)
		//.css({display:'block'})
		.animate({left:"6em",opacity: "show"}, "fast");
	}, function() {
		$(this).next()
		.stop(true, true)		
		.animate({opacity: "hide",left:"0em"}, "fast");
		//.css({display:'none'})
	});

});