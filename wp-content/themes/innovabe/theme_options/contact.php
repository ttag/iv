<?php
$pageinfo = array('full_name' => 'Contact Options', 'optionname'=>'contact', 'child'=>true, 'filename' => basename(__FILE__));

$options = array (

	array(	"type" => "open"),

	array(	"name" => "Contact Page",
			"desc" => "The Page you choose here will display the Contact Form in addition to the normal page content:",
	        "id" => "contact_page",
	        "type" => "dropdown",
	        "subtype" => "page"),

	array(	"name" => "E-Mail adress",
			"desc" => "Enter the Email adress where mails should be delivered to. (default is '".get_option('admin_email')."')",
            "id" => "email",
            "type" => "text",
            "std" => get_option('admin_email')
            ),	       
	
	array(	"type" => "close")

	
);

$options_page = new kriesi_option_pages($options, $pageinfo);
