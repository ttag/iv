<?php
$pageinfo = array('full_name' => 'Frontpage Slider', 'optionname'=>'slider', 'child'=>true, 'filename' => basename(__FILE__));

$options = array (

	array(	"type" => "open",  "desc" => "Slider Options"),	
	array(  "name" => "Which slider do you want to use?",
			"desc" => "You can choose which slideshow you want to use: the 3D slideshow or the basic fading jquery slideshow<br/>",
            "id" => "which_slideshow",
            "type" => "radio",
            "buttons" => array('Use 3D Flash Slideshow','Use jQuery Fading Slider'),
            "std" => 1),
            
	array(  "name" => "How do you want to populate the slideshow",
			"desc" => "You can easily set up your slideshow with the slideshow manager bellow, however there might be situations where you want to set more options, if thats the case you can also edit the config.xml file directly<br/>",
            "id" => "slideshow_config",
            "type" => "radio",
            "buttons" => array('Use Slideshow Manager bellow','Use config.xml file within folder "slideshow"'),
            "std" => 2),
            
    array(  "name" => "Autoplay",
			"desc" => "Should the slider auto-rotate?",
            "id" => "slide_autorotate",
            "type" => "radio",
            "buttons" => array('Yes','No'),
            "std" => 1),
    
    array(	"name" => "Autoplay Duration",
			"desc" => "Enter time between transitions in seconds",
			"id" => "slide_duration",
			"std" => "5",
			"size" => 4,
			"type" => "text"),
            
	array(	"type" => "close"),
	
	
//name and key value must be identical
"Mainpage Slider" => array(	"name" => "Mainpage Slider",
							"desc" => "This tool controlls your Mainpage Image slider. Enter the URI of the Image that should be displayed and choose from various transition types.",
							"database_table" => "slider_menu",
							"type" => "menu",
							"initial" => '',
							"attr" => 'id="slider"',
							"heading" => array("Controlls"=>"98px",'Image URI (940px * 420px)'=>'196px', "Direction"=>"53px","Slicing"=>'67px',"Slices"=>'54px',"Shader"=>'54px',"Z-Axis"=>'54px',"Link"=>'100px'),
							"controlls" => array('delete','down','up'),
							"tables" => array(	"id"=>"hidden", 
												"lft"=>"hidden", 
												"rgt"=>"hidden", 
												"URI" => "input",
												"Direction" => "custom_dropdown", 
												"Slicing" =>"custom_dropdown",
												"Slices" =>"custom_dropdown",
												"Shader" => "custom_dropdown",
												"Multiply" => "custom_dropdown",
												"Link" => "multi_link"
												),
							'Direction_values' => 	array('Up'=>'up','Down'=>'down','Left'=>'left','Right'=>'right'),
							'Slicing_values' => 	array('Vertical'=>'vertical','Horizontal'=>'horizontal'),
							'Slices_values' => 		array('min'=>'0','max'=>'12'),
							'Shader_values' => 		array('none'=>'none','flat'=>'flat','phong'=>'phong'),
							'Multiply_values' => 	array('min'=>'0','max'=>'12')
							
							)

	
			
);

$options_page = new kriesi_menu_manager($options, $pageinfo);
$k_option['custom']['slider'] = new kriesi_slider_display($options);
