<?php

global $k_option;

// Widget Settings


	
	if ( function_exists('register_sidebar') )
	{	
		$dynamic_widgets = explode(',',$k_option['general']['multi_widget_final']);
		foreach ($dynamic_widgets as $page_name)
		{	
			if($page_name != "")
			register_sidebar(array(
			'name' => get_the_title($page_name),
			'before_widget' => '<div id="%1$s" class="box_small box widget %2$s">', 
			'after_widget' => '</div>', 
			'before_title' => '<h3 class="widgettitle">', 
			'after_title' => '</h3>', 
			));
		}
	}
