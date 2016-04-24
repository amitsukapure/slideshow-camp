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
			add_action('admin_enqueue_scripts', array($this, 'slideshow_camp_admin_assets'));
			add_action( 'admin_menu', array($this, 'slideshow_camp_settings' ));
			if(!defined('slideshowCamp_version')) {
				define('RTCS_VERSION', '1.0');
			}
		}

		function slideshow_camp_settings() {
			add_menu_page(
				__( 'Slideshow Camp', 'slideshow-camp' ),
				__( 'Slideshow','slideshow-camp' ),
				'manage_options',
				'sildeshow-camp',
				array($this, 'slideshow_camp_settings_page'),
				''
			);
		}

		function slideshow_camp_settings_page() {
			include_once 'settings.php';
		}

		function slideshow_camp_admin_assets() {
			wp_enqueue_media();
			wp_enqueue_script('rtc-admin', plugin_dir_url( __FILE__ ) . 'assets/js/admin.js', array( 'jquery' ), RTCS_VERSION, 'all');
			wp_enqueue_style('rtc-admin', plugin_dir_url( __FILE__ ) . 'assets/css/admin.css', null, RTCS_VERSION);

			wp_enqueue_script( 'jquery-ui-sortable' );
		}

		function slideshow_camp_render_assets() {
			wp_register_script('rtc-bxslider', plugin_dir_url( __FILE__ ).'lib/bxslider/jquery.bxslider.js', array('jquery'), RTCS_VERSION, true);
			wp_register_script('rtc-bxslider-custom', plugin_dir_url( __FILE__ ).'assets/js/script.js', array('jquery','rtc-bxslider'), RTCS_VERSION, true);
			wp_register_style('rtc-bxslider', plugin_dir_url( __FILE__ ).'lib/bxslider/jquery.bxslider.css', null, RTCS_VERSION);
			wp_enqueue_script('rtc-bxslider');
			wp_enqueue_script('rtc-bxslider-custom');
			wp_enqueue_style('rtc-bxslider');
		}

		function slideshow_camp_render($atts, $content) {
			$atts = shortcode_atts( array(
				'slug' => '',
			), $atts );

			$slideshows = get_option('slideshowCamp');

			$slideshow = $slideshows[$atts['slug']];

			$images = (isset($slideshow['images'])) ? $slideshow['images'] : '';

			$images_array = array();
			if($images != '') {
				$images_array = explode(',', $images);
			}

			ob_start();
			if(empty($images_array)) :	?>
				<div>No slider found!</div>
			<?php else : ?>
				<ul class="bxslider" data-mode="fade" data-captions="true">
					<?php foreach ($images_array as $key => $image) : ?>
						<li><img src="<?php echo wp_get_attachment_url($image); ?>" title="Happy trees" /></li>
					<?php endforeach; ?>				
				</ul>
			<?php
			endif;
			$output = ob_get_clean();
			return $output;
		} // end of slideshow_camp_render
	}
} // end if
$object = new slideshowCamp;