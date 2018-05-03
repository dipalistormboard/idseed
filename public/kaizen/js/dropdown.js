(function($) { //* hide the namespace
	$(document).ready(function() {
		/* for top navigation */
		$(" .menulink ul ").css({display: "none"}); // Opera Fix
		$(" .menulink li ").hover(function(){
			$(this).find('ul:first').css({visibility: "visible",display: "none"}).slideDown(400);
			$(this).children('a').addClass('active');
		},function(){
			$(this).find('ul:first').css({visibility: "hidden"});
			$(this).children('a').removeClass('active');
		});	
		
	});
})(jQuery); //* hide the namespace


	
