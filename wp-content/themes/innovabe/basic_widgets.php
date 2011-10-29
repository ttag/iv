<?php

if ( function_exists('register_sidebar') )
	register_sidebar(array(
		'name' => 'Displayed Everywhere',
		'before_widget' => '<div id="%1$s" class="box_small box widget %2$s">', 
	'after_widget' => '</div>', 
	'before_title' => '<h3 class="widgettitle">', 
	'after_title' => '</h3>', 
	));

if ( function_exists('register_sidebar') )
	register_sidebar(array(
		'name' => 'Sidebar Blog',
		'before_widget' => '<div id="%1$s" class="box_small box widget %2$s">', 
	'after_widget' => '</div>', 
	'before_title' => '<h3 class="widgettitle">', 
	'after_title' => '</h3>', 
	));
	
if ( function_exists('register_sidebar') )
	register_sidebar(array(
		'name' => 'Footer Area',
		'before_widget' => '<div id="%1$s" class="box_mini box widget %2$s">', 
	'after_widget' => '</div>', 
	'before_title' => '<h4 class="widgettitle">', 
	'after_title' => '</h4>', 
	));