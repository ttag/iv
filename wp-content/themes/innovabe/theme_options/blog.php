<?php
$pageinfo = array('full_name' => 'Blog Options', 'optionname'=>'blog', 'child'=>true, 'filename' => basename(__FILE__));

$options = array (

	array(	"type" => "open"),

	array(	"name" => "Blog Page",
			"desc" => "The Page you choose here will display the Blog in addition to the normal page content:",
	        "id" => "blog_page",
	        "type" => "dropdown",
	        "subtype" => "page"),
	        
	array(	"type" => "group"),
	
	array(	"name" => "Exclude Categories",
			"desc" => "The blog Page usually displays all Categorys, since sometimes you want to exclude some of these categories (for example porfolio entries) you can EXCLUDE multiple categories here:",
            "id" => "blog_cat",
            "type" => "multi",
            "subtype" => "cat"),
             
    array(  "name" => "Exclude from Sidebar",
			"desc" => "Also exclude those categories selected above from the sidebar category list and widgets?",
            "id" => "blog_widget_exclude",
            "type" => "radio",
            "buttons" => array('Yes','No'),
            "std" => 1),     
            	       
	array(	"type" => "group"),
	
	array(	"type" => "close")

	
);

$options_page = new kriesi_option_pages($options, $pageinfo);
