<?php
/*
Plugin Name: Slideshow Camp
Plugin URI: http://wpsince.in/
Description: A simple slideshow plugin
Version: 1.0
Author: Amit Sukapure
License: GPL
Textdomain: slideshow-camp
*/
if(!class_exists('slideshowCamp')) {
	class slideshowCamp {
		function __construct() {
			add_shortcode( 'slideshowCamp', array($this, 'slideshow_camp_render') );
		}

		function slideshow_camp_render($attr, $content) {
			ob_start();
			?>
				hi
			<?php
			$output = ob_get_clean();
			return $output;
		} // end of slideshow_camp_render
	}
} // end if
$object = new slideshowCamp;