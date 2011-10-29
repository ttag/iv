<?php
$pageinfo = array('full_name' => 'Mainpage Options', 'optionname'=>'mainpage', 'child'=>true, 'filename' => basename(__FILE__));

$options = array (

	array(	"type" => "open"),

//	array(	"name" => "Welcome Message",
//			"desc" => "Enter a text to display for your welcome message.",
//			"id" => "welcome",
//			"std" => "This is <strong>«display»</strong>, a unique Themeforest template for showcasing your work and perfect for any business in need of a stunning website...",
//			"size" => 80,
//			"type" => "text"),
			
	array(	"type" => "group"),	
	
	array(	"name" => "Mainpage - Columns",
			"desc" => "The 3 columns at the front page can be populated in 3 different ways. You can choose from: Post, Page or Widget.<br/> If nothing is choosen a default HTML Placeholder text is displayed (you can of course edit this text in the index.php file if you want to)",
			"type" => "title_inside"),	
		
	array(  "name" => "Mainpage - Column",
			"desc" => "How to populate Mainpage Columns",
            "id" => "mainpage_column",
            "widget" => "Mainpage Column",
            "type" => "boxes",
            "count" => 3),
	
	array(	"type" => "group"),

            
	array(	"type" => "close")


	
			
);

$options_page = new kriesi_option_pages($options, $pageinfo);
