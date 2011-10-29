<?php

$pageinfo = array('full_name' => 'Menu Manager', 'optionname'=>'menu', 'child'=>true, 'filename' => basename(__FILE__));

$options = array (

"Menu Manager" =>	array(	"name" => "Menu Manager",
							"desc" => "This tool controlls your site menu. descriptions will only be shown on first level menu items",
							"database_table" => "main_menu",
							"type" => "menu",
							"initial" => '',
							"attr" => 'id="nav"',
							"heading" => array("Controlls"=>"174px",'Name'=>'196px', "Description"=>"196px","Link"=>'196px'),
							"controlls" => array('delete','right','left','down','up'),
							"tables" => array(	"id"=>"hidden", 
												"lft"=>"hidden", 
												"rgt"=>"hidden", 
												"Name" => "input",
												"Description" => "input", 
												"Link" =>"multi_link"
												)
							),
							
	array(	"type" => "open"),

	array(  "name" => "Sidebar Menu",
			"desc" => "Do you want to display the Menu in your Sidebar as well?",
            "id" => "sidebar_menu",
            "type" => "radio",
            "buttons" => array('Yes, display menu in Sidebar','No, dont display the menu'),
            "std" => 1),
	
	array(	"type" => "close")
					);

$options_page = new kriesi_menu_manager($options, $pageinfo);
$k_option['custom']['kriesi_menu'] = new kriesi_menu_display($options);