<?php
$pageinfo = array('full_name' => 'Portfolio Options', 'optionname'=>'portfolio', 'child'=>true, 'filename' => basename(__FILE__));

$options = array (

	array(	"type" => "open"),

	array(	"name" => "Portfolio Items on Page",
			"desc" => "Please choose the number of items you want to display on your portfolio Pages",
	        "id" => "portfolio_entry_count",
	        "type" => "text",
	        "size" => 3,
	        "std" => "9"
	        ),
	
	array(  "name" => "Portfolio Image Link",
			"desc" => "When clicking on a Portfolio Image what should happen?",
            "id" => "portfolio_click",
            "type" => "radio",
            "buttons" => array('Big Image opens in Lightbox','Show Portfolio Single Post'),
            "std" => 1),   
	
	array(	"type" => "close"),

	array(  "type" => "portfolio")
);

$options_page = new kriesi_option_pages($options, $pageinfo);
