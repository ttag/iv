<?php

global $k_option;
##################################################################
# Get Theme informations and save them to PHP Constants
##################################################################
$the_theme = get_theme_data(TEMPLATEPATH . '/style.css');
$the_version = trim($the_theme['Version']);
if(!$the_version) $the_version = "1";

//set theme constants
define('THEMENAME', $the_theme['Title']);
define('THEMEVERSION', $the_version);

// set Path constants
define('KFW', TEMPLATEPATH . '/framework/'); // 'K'riesi 'F'rame 'W'ork;
define('KFWOPTIONS', 	TEMPLATEPATH . '/theme_options/'); 
define('KFWHELPER', 	KFW . 'helper_functions/'); 
define('KFWCLASSES', 	KFW . 'classes/'); 
define('KFWPLUGINS', 	KFW . 'theme_plugins/'); 
define('KFWINC', 		KFW . 'includes/'); 

// set URI constants
define('KFW_URI', get_bloginfo('template_url') . '/framework/'); // 'K'riesi 'F'rame 'W'ork;
define('KFWOPTIONS_URI', 	get_bloginfo('template_url') . '/theme_options/'); 
define('KFWHELPER_URI', 	KFW_URI . 'helper_functions/'); 
define('KFWCLASSES_URI', 	KFW_URI . 'classes/'); 
define('KFWPLUGINS_URI', 	KFW_URI . 'theme_plugins/'); 
define('KFWINC_URI', 		KFW_URI . 'includes/'); 



##################################################################
# this include calls a file that automatically includes all 
# the files within the folder framework and therefore makes 
# all functions and classes available for later use
##################################################################



$autoload['helper'] = array('breadcrumb', 				# breadcrumb navigation
							'header_includes',			# javascript and css includes for header.php
							'lots_of_small_helpers', 	# helper functions that make my developer-life easier =)
							'pagination',				# pagination function
							'twitter',					# get twitter feed and display it
							'kriesi_build_image'		# display a resized image
							);

$autoload['classes'] = array('kclass_display_box');		# display of small content boxes that can display post/page or widget content


$autoload['plugins'] = array('kriesi_option_pages/kriesi_option_pages',		
							'kriesi_menu_manager/kriesi_menu_manager',
							'kriesi_menu_manager/kriesi_menu_display',
							'kriesi_menu_manager/kriesi_slider_display',
							'kriesi_meta_box/kriesi_meta_box'
							);


$autoload['option_pages'] = array('options',
								'mainpage',
								'blog',
								'portfolio',
								'contact',
								'frontpage_slider',
								'menu_manager',
								'footer',
								'meta_box'
								 );
								 
$autoload['templatefiles'] = array('wp_list_comments','widgets');							

include_once(KFW.'/include_framework.php');