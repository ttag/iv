<?php
$pageinfo = array('full_name' => 'Footer Options', 'optionname'=>'footer', 'child'=>true, 'filename' => basename(__FILE__));

$options = array (

	array(	"type" => "open"),
	
	array(	"type" => "group"),	
	
	array(	"name" => "Contact Button Line 1",
			"desc" => "Enter the first line of text to display within your contact button.",
			"id" => "button1",
			"std" => "Contact Form",
			"size" => 20,
			"type" => "text"),
			
	array(	"name" => "Contact Button Line 2",
			"desc" => "Enter the second line of text to display within your contact button.",
			"id" => "button2",
			"std" => "get in touch with us",
			"size" => 20,
			"type" => "text"),
			
	array(	"name" => "Button Link",
			"desc" => "Select the Page the button should link to",
            "id" => "button_link",
            "type" => "dropdown",
            "subtype" => "page"),
            
	array(	"type" => "group"),
		
	array(	"name" => "Copyright Text",
			"desc" => "Enter your copyright text here",
			"id" => "copyright",
			"std" => "This site uses valid HTML and CSS. All content Copyright &copy; 2010 DISPLAY, Inc",
			"size" => 75,
			"type" => "text"),		
			
	array(	"type" => "group"),
	
	array(	"name" => "Facebook Account",
			"desc" => "Enter the name of your facebook account to create a small icon link within your footer",
			"id" => "acc_fb",
			"std" => "",
			"size" => 20,
			"type" => "text"),	
			
	array(	"name" => "Flickr Account",
			"desc" => "Enter the name of your flickr account to create a small icon link within your footer (looks something like this: 34166943@N05 )",
			"id" => "acc_fl",
			"std" => "",
			"size" => 20,
			"type" => "text"),	
			
	array(	"name" => "Twitter Account",
			"desc" => "Enter the name of your twitter account to create a small icon link within your footer",
			"id" => "acc_tw",
			"std" => "",
			"size" => 20,
			"type" => "text"),	
	
	array(	"type" => "group"),		
	
	
	array(	"type" => "close")

	
);

$options_page = new kriesi_option_pages($options, $pageinfo);
