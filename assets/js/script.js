(function($){
	'use strict';

	$(document).ready(function(){
		$('.bxslider').each(function(i,slider){
			var mode = $(slider).attr('data-mode');
			var speed = $(slider).attr('data-speed');
			var infiniteLoop = $(slider).attr('data-infiniteLoop');
			var adaptiveHeight = $(slider).attr('data-adaptiveHeight');
			var controls = $(slider).attr('data-controls');
			var pager = $(slider).attr('data-pager');

			$(slider).bxSlider({
				mode: mode,
				speed: speed,
				infiniteLoop: infiniteLoop,
				adaptiveHeight: adaptiveHeight,
				controls: controls,
				pager: pager
			});
		});
	});
})(jQuery);