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
			add_action('wp_enqueue_scripts', array($this, 'slideshow_camp_render_assets'));
			if(!defined('slideshowCamp_version')) {
				define('RTCS_VERSION', '1.0');
			}
		}

		function slideshow_camp_render_assets() {
			wp_register_script('rtc-bxslider', plugin_dir_url( __FILE__ ).'lib/bxslider/jquery.bxslider.js', array('jquery'), RTCS_VERSION, true);
			wp_register_script('rtc-bxslider-custom', plugin_dir_url( __FILE__ ).'assets/js/script.js', array('jquery','rtc-bxslider'), RTCS_VERSION, true);
			wp_register_style('rtc-bxslider', plugin_dir_url( __FILE__ ).'lib/bxslider/jquery.bxslider.css', null, RTCS_VERSION);
			wp_enqueue_script('rtc-bxslider');
			wp_enqueue_script('rtc-bxslider-custom');
			wp_enqueue_style('rtc-bxslider');
		}

		function slideshow_camp_render($attr, $content) {
			ob_start();
			?>
				<ul class="bxslider" data-mode="fade" data-captions="true">
					<li><img src="http://bxslider.com//images/730_200/tree_root.jpg" title="Funky roots" /></li>
					<li><img src="http://bxslider.com//images/730_200/hill_road.jpg" title="The long and winding road" /></li>
					<li><img src="http://bxslider.com//images/730_200/trees.jpg" title="Happy trees" /></li>
				</ul>
			<?php
			$output = ob_get_clean();
			return $output;
		} // end of slideshow_camp_render
	}
} // end if
$object = new slideshowCamp;