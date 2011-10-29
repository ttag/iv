<?php

$pageinfo = array('full_name' => '"'.THEMENAME.'" General Options', 'optionname'=>'general', 'child'=>false, 'filename' => basename(__FILE__));

$options = array();
			
$options[] = array(	"type" => "open");
	
$options[] = array(	"name" => "'Display' - Skin",
			"desc" => "Please choose one of the 3 Display skins here",
            "id" => "skin",
            "type" => "dropdown",
            "std" => "1",
            "subtype" => array('Display - Light'=>'1','Display - Minimal'=>'2','Display - Dark'=>'3'));
			
$options[] = array(	"name" => "Logo",
			"desc" => "Add the full URI path to your logo. the themes default logo gets applied if the input field is left blank<br/>Logo Dimension: 210px * 90px (if your logo is larger it will get cropped, either resize the logo or change the dimension of the logo area in style.css)<br/> URI Exampe: http://www.yourdomain.com/path/to/image.jpg<br/>",
			"id" => "logo",
			"std" => "",
			"size" => 80,
			"type" => "text");
		
			
######################################################################
# check if Image scaling is available
######################################################################
$cachepath = TEMPLATEPATH."/cache/";	

if (!function_exists("gd_info")){
$options[] = array(	"name" => "Automated Image scaling",
			"desc" => "Sorry your server does not support automatic resizing, because gd library is not installed. <br/>Please contact the server administrator to install it, meanwhile you have to enter the different image sizes by hand.",
			"type" => "title_inside",
			"std" => 2,
			"id" => "tim"
			);
} else if (!is_writeable($cachepath))
{
$options[] = array(	"name" => "Automated Image scaling",
			"desc" => "Your server supports automatic resizing for your portfolio and Frontpage pictures, however the folder 'cache' ($cachepath) is not writable for the resizing script<br/> To make this feature work you have to set the folder permission to 777 (write for everyone)<br/><br/>",
			"type" => "title_inside",
			"std" => 2,
			"id" => "tim"
			);
}	
	
if (is_writeable($cachepath) && function_exists("gd_info"))
{		
$options[] = array(  "name" => "Automated Image scaling",
			"desc" => "<strong>Should the images be scaled automaticaly?</strong><br/>(A script will automatically resize the frontpage and portfolio images and generate thumbnails when needed)   ",
            "id" => "tim",
            "type" => "radio",
            "buttons" => array('yes','no'),
            "std" => 1);
}

// end image scaling
	
$options[] = array(	"name" => "Extra Widget Areas for specific Pages",
			"desc" => "Here you can add widget areas for single pages. that way you can put different content for each page into your sidebar.<br/>
After you have choosen the Pages press the 'Save Changes' button and then start adding widgets to your new widget areas <a href='widgets.php'>here</a>.<br/><br/>

<strong>Attention</strong> when removing areas: You have to be carefull when deleting widget areas that are not the last one in the list.<br/> It is recommended to avoid this. If you want to know more about this topic please read the documentation that comes with this theme.<br/>",
            "id" => "multi_widget",
            "type" => "multi",
            "subtype" => "page");
			
$options[] = array(	"name" => "Google Analytics Code",
		"desc" => "Paste your analytics code here, it will get applied to each page",
        "id" => "analytics",
        "type" => "textarea");
	
	
$options[] = array(	"type" => "close");
	
          

$options_page = new kriesi_option_pages($options, $pageinfo);
