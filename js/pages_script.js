var moving = false;
var count = 0;
var carouselPosition = 1;
var totalSlides;
var myPlayer;


var carouselInt;
function nextSlide() {
	if (!moving) {
		$("#Carousel a.rightCarouselArrow").click();
	}
}
function clearCarousel() {
	clearTimeout(carouselInt);
}
function startCarousel(time) {
	if (!time) {
		time = 5000;
	}
	carouselInt = setTimeout("nextSlide()", time);
}
function carouselCallback() {
	if (moving) {
		moving = false;
		var t = Math.round(1000 * Number($("#SlideContainer #Backgrounds .SlideLayer:eq("+(carouselPosition-1)+")").data("time")));
		if (t) {
			startCarousel(t);
		}
	}
}



function optout() {
	var img = new Image();
	img.src = "http://optout.adap.tv/optout";
	setTimeout(reloadWindow,500);
}
function reloadWindow() {
	window.location.reload();	
}





$(document).ready(function() {	

	$.ajax({
	  url: document.location.protocol + '//munchkin.marketo.net/munchkin.js',
	  dataType: 'script',
	  cache: true,
	  success: function() {
		Munchkin.init('617-EYL-246');
	  }
	});


	if ($("form").length > 0) {
		$.validity.setup({ outputMode:"modal" });
        $("form").validity(function() {
	

/*                     $("#agree").assert($("#agree:checked").length != 0,'You must accept the Adap.tv Terms and Conditions Agreements'); */

                    $("#firstname")
                        .require()
                        ;

                        $("#lastname")
                        .require()
                        ;

                        $("#companyname")
                        .require()
                        ;

                        $("#phonenumber")
                        .require()
                        ;

                        $("#emailaddress")
                        .require()
                        .match('email');
                        ;

                         $("#password1")
                        .require()
                        ;

                        $("#password2")
                        .require()
                        ;

       });

	}



	$(".biowrapper .openButton").click(function() {		
		$(this).stop().animate({opacity:0.0},250);
		$(this).closest(".biowrapper").find(".biotext").slideDown(250);	
		return false;	
	});
	
	$(".biowrapper .closeButton").click(function() {		
		$(this).closest(".biowrapper").find(".openButton").css({display:"block",opacity:0.0}).stop().animate({opacity:1.0},250);
		$(this).closest(".biowrapper").find(".biotext").slideUp(250);	
		return false;		
	});


	if (totalSlides = $("#Backgrounds .SlideLayer").length) {
		carouselInt = setTimeout("nextSlide()", 4000);
		carouselPosition = 1;
		
		for (var i = 0; i < totalSlides; i++) {		
			var xpos = (i*1044);		
			$("#Backgrounds .SlideLayer:eq("+i+")").css({"position":"absolute",bottom:"0px",left:xpos+"px"});
		}
	
		for (var i = 0; i < totalSlides; i++) {		
			var xpos = (i*1500);		
			$("#Layer1 .SlideLayer:eq("+i+")").css({"position":"absolute",top:"0px",left:xpos+"px"});
		}
		
		for (var i = 0; i < totalSlides; i++) {		
			var xpos = (i*2000);		
			$("#Layer2 .SlideLayer:eq("+i+")").css({"position":"absolute",top:"0px",left:xpos+"px"});
		}
		
		for (var i = 0; i < totalSlides; i++) {		
			var xpos = (i*2500);		
			$("#Layer3 .SlideLayer:eq("+i+")").css({"position":"absolute",top:"0px",left:xpos+"px"});
		}
		
		for (var i = 0; i < totalSlides; i++) {		
			var xpos = (i*3000);		
			$("#Layer4 .SlideLayer:eq("+i+")").css({"position":"absolute",top:"0px",left:xpos+"px"});
		}
		
		for (var i = 0; i < totalSlides; i++) {		
			var xpos = (i*3500);		
			$("#TextLayer .SlideLayer:eq("+i+")").css({"position":"absolute",top:"0px",left:xpos+"px"});
		}
	}
	
	$("#Carousel a.leftCarouselArrow, #Carousel a.rightCarouselArrow, .tooltip, .dot div.over").css({display:"block", opacity:0.0});
	
	$("#Carousel .dot").mouseenter(function(e) {
		$(this).find(".tooltip, div.over").css({display:"block", opacity:0.0}).stop().animate({opacity:1.0},250);
	}).mouseleave(function(e) {	
		$(this).find(".tooltip, div.over").css({display:"block", opacity:0.0}).stop().animate({opacity:0.0},250, function() {
			$(this).css({display:"none"});
		});
	});	
	
	$("#CarouselNav div.dot").click(function() {
		var ind = $(this).index();		
		carouselPosition = ind+1;
		if (!moving) {
			
			clearCarousel();
			moving = true;
			
			for (var i = 0; i < totalSlides; i++) {	
												
				var xpos = ((i-(carouselPosition-1))*1044);
				$("#Backgrounds .SlideLayer:eq("+i+")").animate({left:xpos+"px"},750,'easeOutExpo');
									
				var xpos = ((i-(carouselPosition-1))*1500);
				$("#Layer1 .SlideLayer:eq("+i+")").animate({left:xpos+"px"},1000,'easeOutExpo');	
								
				var xpos = ((i-(carouselPosition-1))*2000);
				$("#Layer2 .SlideLayer:eq("+i+")").animate({left:xpos+"px"},1000,'easeOutExpo');
				
				var xpos = ((i-(carouselPosition-1))*2500);
				$("#Layer3 .SlideLayer:eq("+i+")").animate({left:xpos+"px"},1000,'easeOutExpo');
				
				var xpos = ((i-(carouselPosition-1))*3000);
				$("#Layer4 .SlideLayer:eq("+i+")").animate({left:xpos+"px"},1000,'easeOutExpo');
				
				var xpos = ((i-(carouselPosition-1))*2500);
				$("#TextLayer .SlideLayer:eq("+i+")").animate();
				
				if ((carouselPosition-1) == i) {
					$("#TextLayer .SlideLayer:eq("+i+")").animate({opacity:1.0,left:xpos+"px"},1000,'easeOutExpo',carouselCallback);
				} else {
					$("#TextLayer .SlideLayer:eq("+i+")").animate({opacity:0.0,left:xpos+"px"},1000,'easeOutExpo',carouselCallback);				
				}
			}	
		
			$("#CarouselNav div.selected").removeClass("selected");
			$(this).addClass("selected");
			
		}
		return false;
	});	

	$("#Carousel a.leftCarouselArrow").mouseover(function(e) {
		e.stopPropagation();
		$(this).find("span.over").css({display:"block",opacity:0.0}).stop().animate({opacity:1.0},250);
	}).mouseout(function(e) {	
		e.stopPropagation();
		$(this).find("span.over").stop().animate({opacity:0.0},250);
	}).click(function() {
		if (!moving) {
			clearCarousel();
			moving = true;	
			
			carouselPosition -= 1;
			if (carouselPosition < 1) {
				carouselPosition = totalSlides;
			}
			
			for (var i = 0; i < totalSlides; i++) {	
												
				var xpos = ((i-(carouselPosition-1))*1044);
				$("#Backgrounds .SlideLayer:eq("+i+")").animate({left:xpos+"px"},750,'easeOutExpo');
									
				var xpos = ((i-(carouselPosition-1))*1500);
				$("#Layer1 .SlideLayer:eq("+i+")").animate({left:xpos+"px"},1000,'easeOutExpo');	
								
				var xpos = ((i-(carouselPosition-1))*2000);
				$("#Layer2 .SlideLayer:eq("+i+")").animate({left:xpos+"px"},1000,'easeOutExpo');
				
				var xpos = ((i-(carouselPosition-1))*2500);
				$("#Layer3 .SlideLayer:eq("+i+")").animate({left:xpos+"px"},1000,'easeOutExpo');
				
				var xpos = ((i-(carouselPosition-1))*3000);
				$("#Layer4 .SlideLayer:eq("+i+")").animate({left:xpos+"px"},1000,'easeOutExpo');
				
				var xpos = ((i-(carouselPosition-1))*2500);
				$("#TextLayer .SlideLayer:eq("+i+")").animate();
				
				if ((carouselPosition-1) == i) {
					$("#TextLayer .SlideLayer:eq("+i+")").animate({opacity:1.0,left:xpos+"px"},1000,'easeOutExpo',carouselCallback);
				} else {
					$("#TextLayer .SlideLayer:eq("+i+")").animate({opacity:0.0,left:xpos+"px"},1000,'easeOutExpo',carouselCallback);				
				}
			}	
		
			$("#CarouselNav div.selected").removeClass("selected").prev("div").addClass("selected");
			if (!$("#CarouselNav div.selected").length) {
				$("#CarouselNav div:last").addClass("selected");
			}
		}
		return false;
	});
	
	
	$("#Carousel a.rightCarouselArrow").mouseover(function(e) {
		e.stopPropagation();
		$(this).find("span.over").css({display:"block",opacity:0.0}).stop().animate({opacity:1.0},250);
	}).mouseout(function(e) {	
		e.stopPropagation();
		$(this).find("span.over").stop().animate({opacity:0.0},250);
	}).click(function() {
		if (!moving) {
			clearCarousel();
			moving = true;	
			
			carouselPosition += 1;
			if (carouselPosition > totalSlides) {
				carouselPosition = 1;
			}
			
			for (var i = 0; i < totalSlides; i++) {	
												
				var xpos = ((i-(carouselPosition-1))*1044);
				$("#Backgrounds .SlideLayer:eq("+i+")").animate({left:xpos+"px"},750,'easeOutExpo');
									
				var xpos = ((i-(carouselPosition-1))*1500);
				$("#Layer1 .SlideLayer:eq("+i+")").animate({left:xpos+"px"},1000,'easeOutExpo');	
								
				var xpos = ((i-(carouselPosition-1))*2000);
				$("#Layer2 .SlideLayer:eq("+i+")").animate({left:xpos+"px"},1000,'easeOutExpo');
				
				var xpos = ((i-(carouselPosition-1))*2500);
				$("#Layer3 .SlideLayer:eq("+i+")").animate({left:xpos+"px"},1000,'easeOutExpo');
				
				var xpos = ((i-(carouselPosition-1))*3000);
				$("#Layer4 .SlideLayer:eq("+i+")").animate({left:xpos+"px"},1000,'easeOutExpo');
				
				var xpos = ((i-(carouselPosition-1))*2500);
				$("#TextLayer .SlideLayer:eq("+i+")").animate();
				
				if ((carouselPosition-1) == i) {
					$("#TextLayer .SlideLayer:eq("+i+")").animate({opacity:1.0,left:xpos+"px"},1000,'easeOutExpo',carouselCallback);
				} else {
					$("#TextLayer .SlideLayer:eq("+i+")").animate({opacity:0.0,left:xpos+"px"},1000,'easeOutExpo',carouselCallback);				
				}
			}	
		
			$("#CarouselNav div.selected").removeClass("selected").next("div").addClass("selected");
			if (!$("#CarouselNav div.selected").length) {
				$("#CarouselNav div:first").addClass("selected");
			}
		}
		return false;
	});
	
	$("#Carousel, #Carousel a.leftCarouselArrow, #Carousel a.rightCarouselArrow").mouseover(function() {		
		$("#Carousel a.leftCarouselArrow").stop().animate({opacity:1.0},250);
		$("#Carousel a.rightCarouselArrow").stop().animate({opacity:1.0},250);		
	}).mouseout(function() {		
		$("#Carousel a.leftCarouselArrow").stop().animate({opacity:0.0},250);
		$("#Carousel a.rightCarouselArrow").stop().animate({opacity:0.0},250);
	});
	
	
	
	$(".videoThumb,.videoThumbSmall,.videoLink").click(function() {		
		$("#Main").append('<div id="OverlayWrapper"><div id="OverlayBack" class="loading"></div></div>');
		$("#OverlayWrapper").fadeIn(500);		
		var URL = $(this).attr('href');		
		$.ajax({
		  url: URL+"true",
		  success: function(html){
			$("#OverlayBack").removeClass('loading');
		  	$("#OverlayWrapper").append(html);
		  }
		});	
		return false;
	});
	
	$("#OverlayWindow .closeButton").live("click",function() {		
		//$("#OverlayWrapper").fadeOut(250, function() {
			$("#OverlayWrapper").remove();
			carouselCallback();	
		//});
		return false;
	});
	
	$(".OverlayLink").live("click",function() {
		clearCarousel();
		if ($("#OverlayWrapper").length) {
			$("#OverlayContent").remove();	
		} else {
			$("body").append('<div id="OverlayWrapper"><div id="OverlayBack" class="loading"></div></div>');
			$("#OverlayWrapper").fadeIn(500);
		}
		$("html, body").animate({ scrollTop: 0 }, 500,'easeOutExpo');
		$.ajax({
		  url: $(this).attr("href"),
		  success: function(html){
			$("#OverlayBack").removeClass('loading');
		  	$("#OverlayWrapper").css({height:$("#Main").height()+"px"}).append(html);
			$("#OverlayContent").css({display:"block",opacity:0.0,height:$("#Main").height()+"px"}).stop().animate({opacity:1.0},250);
		  }
		});	
		return false;
	});
	
	
	$("#consolebutton").click(function() {
		if (!$(this).hasClass("selected")) {
			$(this).addClass("selected");
			$("#techbutton").removeClass("selected");			
			$("#techgraphic").css({display:"block",opacity:1.0}).stop().animate({opacity:0.0},250);
			$("#consolegraphic").css({display:"block",opacity:0.0}).stop().animate({opacity:1.0},250);
		}
		return false;
	});
	
	$("#techbutton").click(function() {
		if (!$(this).hasClass("selected")) {
			$(this).addClass("selected");
			$("#consolebutton").removeClass("selected");			
			$("#consolegraphic").css({display:"block",opacity:1.0}).stop().animate({opacity:0.0},250);
			$("#techgraphic").css({display:"block",opacity:0.0}).stop().animate({opacity:1.0},250);
		}
		return false;
	});
	
	
	$(".mappin").mouseenter(function(e) {
		e.stopPropagation();
		$(this).find(".mapToolTip").css({top:-($(this).find(".mapToolTip").height()+42)+"px",display:"block",opacity:0.0}).stop().animate({opacity:1.0},250);
	}).mouseleave(function(e) {
		e.stopPropagation();
		$(this).find(".mapToolTip").css({display:"block",opacity:1.0}).stop().animate({opacity:0.0},250, function() {  $(this).css({display:"none"}); });
	});
	
	
	
	
});