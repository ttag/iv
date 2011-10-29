<?php  

// adds javascript files to the head of the public site

add_action('wp_print_scripts', 'header_includes');

function header_includes() {
	if(!is_admin())
	{
	// add prettyphoto
	$my_prettyphoto = get_bloginfo('template_url')."/js/prettyPhoto/js/jquery.prettyPhoto.js";
	wp_enqueue_script('prettyphoto',$my_prettyphoto,array('jquery'));
	
	// add custom.js, the main javascript file that calls most functions
	$my_customJs = get_bloginfo('template_url')."/js/custom.js";
	wp_enqueue_script('my_customJs',$my_customJs,array('jquery'));
	
	}
}