(function($){
	$(document).ready(function(){
		$('.bxslider').each(function(i,slider){
			var mode = $(slider).attr('data-mode');
			var captions = $(slider).attr('data-captions');
			$(slider).bxSlider({
				mode: mode,
				captions: captions
			});
		});
	});
})(jQuery);