// JavaScript Document

$(function(){
	
	//equalheight jquery start
	equalHeight($(".key-tabpic-right li p"));
	equalHeight($(".key-tabpic-twocol li p"));
	
		
	//form jquery start	
	$('form input[type=text],form input[type=email], form textarea').each(function(){
		var textVal = $(this).val();
		var idVal = $(this).attr('id');
		
		$('#'+idVal).focus(function(){
			if($(this).val() == textVal)
				$(this).val('');
		});
		
		$('#'+idVal).blur(function(){
			if($(this).val() == '')
				$(this).val(textVal);
		});
		
	});	
	
	
	//fact sheet page jquery start
	$('.alpha').click(function(){
		$(this).parents('ul').find('li').removeClass('active');
		$(this).parent('li').addClass('active');
	});
	
	
	$('.alpha').click(function(){
		$('html, body').animate({
			scrollTop: $( $.attr(this, 'href') ).offset().top
		}, 1000);
		return false;
	});
	
	
	$('.back-to-top').click(function(){
		 $('html, body').animate({
            scrollTop: 0
        }, 'slow');
	});
	
	
	$(window).scroll(function(){
        var topVal = $(window).scrollTop();
		if(topVal > 400){
			$('.back-to-top').css('display','block');
		}else{
			$('.back-to-top').css('display','none');
		}
	});
	
	
	$('.fact-tabmenu li').children('a').attr('href','javascript:void(0)');
	
	$('.fact-tabmenu li').click(function(){
		var inexId = $('.fact-tabmenu li').index(this);
		$('.fact-tabmenu li').removeClass('active');
			$(this).addClass('active')
			$('.fact-tabcont').hide();			
			$('.fact-tabcont:eq('+inexId+')').show();
		
	});
	
	
	//keys page jquery start
	$('.keys-tabmenu li').children('a').attr('href','javascript:void(0)');
	
	$('.keys-tabmenu li').click(function(){
		var inexId = $('.keys-tabmenu li').index(this);
		$('.keys-tabmenu li').removeClass('active');
			$(this).addClass('active')
			$('.keys-tabcont').hide();			
			$('.keys-tabcont:eq('+inexId+')').show();
		
	});
	
	
	//fancybox jquery start
	$('.fancybox').fancybox();
	
	
});


$(window).resize(function() {
	
	$(".key-tabpic-right li p, .key-tabpic-twocol li p").css('height','auto');
	
	equalHeight($(".key-tabpic-right li p"));
	equalHeight($(".key-tabpic-twocol li p"));
		
});

function equalHeight(group) {
	 var tallest = 0;
	 group.each(function() {
	 var thisHeight = jQuery(this).height();
	 if(thisHeight > tallest) {
	 tallest = thisHeight;
	 }
	 });
	 group.height(tallest);
}


var onImgLoad = function(selector, callback){
    $(selector).each(function(){
        if (this.complete || /*for IE 10-*/ $(this).height() > 0) {
            callback.apply(this);
        }
        else {
            $(this).on('load', function(){
                callback.apply(this);
            });
        }
    });
};