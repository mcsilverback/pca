<?php
if (!is_admin()) add_action( 'wp_print_scripts', 'woothemes_add_javascript' );
function woothemes_add_javascript( ) {
	wp_enqueue_script('jquery');    
	wp_enqueue_script( 'superfish', get_bloginfo('template_directory').'/includes/js/superfish.js', array( 'jquery' ) );
	wp_enqueue_script( 'wootabs', get_bloginfo('template_directory').'/includes/js/woo_tabs.js', array( 'jquery' ) );
	wp_enqueue_script( 'general', get_bloginfo('template_directory').'/includes/js/general.js', array( 'jquery' ) );
	if ( get_option('woo_featured') == "true" )  {
		wp_enqueue_script( 'loopedSlider', get_bloginfo('template_directory').'/includes/js/loopedSlider.js', array( 'jquery' ) );
	}
	if ( get_option('woo_events_calendar') == "true" )  {
		wp_enqueue_script('jquery-ui-core');
		wp_register_script('jquery-ui-datepicker', get_bloginfo('template_directory').'/functions/js/ui.datepicker.js', array( 'jquery-ui-core' ));
		wp_enqueue_script('jquery-ui-datepicker');
	}
}
	
?>