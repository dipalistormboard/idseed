// Javascript for CFIA FSF templates

// Disable <FONT> tags found in the original FSF data
// CFIA has opted to control the formatting themselves.
// $(document).ready(function(){
//     $('font').each(function(){
//         var $tag = $(this);
//         $tag.attr('color', '');
//         $tag.attr('size', '');
//         $tag.attr('face', '');
//     });
// });

// Turn body into two columns
$(document).ready(function(){
	$('.columnize').columnize({columns: 2});
	
	// This plugin has a bug that leaves the surounding div
	// at its original height.  Shrink it.
	var max_height = 0;
	$('.columnize').children('div').each(function(){
		if($(this).height() > max_height){
			max_height = $(this).height();
		}
	});
	
	$('.columnize').css('height', max_height + 'px');
});

$(document).ready(function(){
	// Recover the large image area and caption.
	var $image = $('.rollover .image img');
	var $caption = $('.rollover .caption');
	
	// Set up rollover handlers on the thumbnails.
	$('#image-bar .thumbnail-group').bind('mouseenter', function(){
	    $image.attr('src', $(this).find('a').attr('href'));
	    $caption.html($(this).find('.caption').html());
	});
});


// Find links that should open into a popup window
$(document).ready(function(){
	$('.popup').each(function(){
		var $a = $(this);
		
		$a.click(function(e){
			var $link = $(this);
			var url = $link.attr('href');
			
			var attr = [];
			attr.push('status=0');
			attr.push('toolbar=0');
			attr.push('menubar=0');
			attr.push('resizable=1');
			attr.push('scrollbars=1');
			attr.push('height=500');
			attr.push('width=600');
			
			window.open(url, 'popup', attr.join(','));
			
			e.preventDefault();
		});
	});
});