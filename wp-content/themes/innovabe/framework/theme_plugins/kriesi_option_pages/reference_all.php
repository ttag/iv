<?php
/**************************************************************************************************************************************
A full list of possible options with all possible parameters
***************************************************************************************************************************************

$pageinfo = array('full_name' => 'General Options', 'optionname'=>'general', 'child'=>false, 'filename' => basename(__FILE__));

$options = array (

	array(	"name" => "This is a pretty long Welcome Message",
			"desc" => "Enter a title to display for your welcome message.",
			"type" => "title"),
			
	array(	"type" => "open", 
			"desc" => "Enter a title to display for your welcome message."),
	
	array(	"name" => "This is a pretty long Welcome Message",
			"desc" => "Enter a title to display for your welcome message.",
			"type" => "title_inside",
			"std" => "Hallo",
			"id" => "hidden"
			),

	array(	"name" => "Title",
			"desc" => "Enter a title to display for your welcome message.",
			"id" => "welcome_title",
			"std" => "Hallo",
			"size" => 6,
			"type" => "text"),
	
	array(	"type" => "group"),
			
	array(	"name" => "Pages",
			"desc" => "Multi widget selects here.",
            "id" => "multi_widget",
            "type" => "multi",
            "subtype" => "page"),
            
	array(	"name" => "Categories",
			"desc" => "Multi cat selects here.",
            "id" => "multi_cats",
            "type" => "multi",
            "subtype" => "cat"),
			
	array(	"name" => "Pages",
			"desc" => "single page selects here.",
            "id" => "single_page",
            "type" => "dropdown",
            "subtype" => "page"),
            
	array(	"name" => "Categories",
			"desc" => "single cat selects here.",
            "id" => "single_cat",
            "type" => "dropdown",
            "subtype" => "cat"),
    
    array(	"type" => "group"),
            
    array(	"name" => "Custom category",
			"desc" => "single cat selects here.",
            "id" => "single_cat_custom",
            "type" => "dropdown",
            "std" => "asdf",
            "subtype" => array('my pages'=>'asdf','my cats'=>'3','my custom'=>'muhhh')),
            		
	array(	"name" => "Message",
			"desc" => "Text to display as welcome message.",
            "id" => "welcome_message",
            "type" => "textarea"),
	
	array(  "name" => "Disable Welcome Message?",
			"desc" => "Check this box if you would like to DISABLE the welcome message.",
            "id" => "welcome_disable",
            "type" => "checkbox",
            "std" => "false"),
            
    array(  "name" => "Bottom Area - Column",
			"desc" => "How to populate Column",
            "id" => "welcome_boxes",
            "widget" => "Frontpage Bottom Box",
            "type" => "boxes",
            "count" => 3),
            
    array(  "name" => "radio button anyone?",
			"desc" => "Check one of these radio button if you would like to DISABLE the welcome message.",
            "id" => "welcome_radio",
            "type" => "radio",
            "buttons" => array('true','false','maybe'),
            "std" => 1),
	
	array(	"type" => "close"),
	
	array(  "type" => "portfolio")
            
);
$options_page = new kriesi_option_pages($options, $pageinfo);
**********************************
MENU
**********************************


$options = array (

"Mainpage Menu" =>	array(	"name" => "Mainpage Menu",
							"desc" => "This tool controlls your site menu. descriptions will only be shown on first level menu items",
							"database_table" => "main_menu",
							"type" => "menu",
							"initial" => '',
							"heading" => array('Name'=>'196px', "Description"=>"196px","Link"=>'196px'),
							"controlls" => array('delete','right','left','down','up'),
							"tables" => array(	"id"=>"hidden", 
												"lft"=>"hidden", 
												"rgt"=>"hidden", 
												"Name" => "input",
												"Description" => "input", 
												"Link" =>"multi_link"
												)
							),
			
"Footer Menu" =>	array(	"name" => "Footer Menu",
							"desc" => "Enter a title to display for your footer message.",
							"database_table" => "footer_menu",
							"type" => "menu",
							"controlls" => array('up','down','delete'),
							"tables" => array(	"id"=>"hidden", 
												"lft"=>"hidden", 
												"rgt"=>"hidden", 
												"Name" => "input")
							)
					);
					$options_page = new kriesi_menu_manager($options, $pageinfo);
					$kriesi_menu = new kriesi_menu_display($options);
					$kriesi_menu->display('Mainpage Menu');



**********************************
META BOX
**********************************

	array(	"name" => "Please enter the urls to your post/portfolio preview pictures here",
			"type" => "title"),
			
	array(	"name" => "Welcome Message",
			"desc" => "Enter a text to display for your welcome message.",
			"id" => "_welcome_message",
			"std" => "fff",
			"size" => 40,
			"type" => "text"),
	
	array(	"name" => "True or false?",
			"desc" => "Some Description",
			"id" => "_welcome_checkbox",
			"std" => 1,
			"type" => "checkbox"),
			
    array(	"name" => "Custom category",
			"desc" => "single cat selects here.",
	        "id" => "_single_cat_custom",
	        "type" => "dropdown",
	        "std" => "asdf",
	        "subtype" => array('my pages'=>'asdf','my cats'=>'3','my custom'=>'muhhh')),
			
	array(	"name" => "This is an image upload",
			"desc" => "Description text",
			"id" => "_welcome",
			"std" => "nix",
			"size" => 40,
			"type" => "media")
