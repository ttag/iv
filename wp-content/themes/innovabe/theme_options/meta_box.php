<?php
global $k_option;

$options = array();
$boxinfo = array('title' => THEMENAME.' Preview Image Options', 'id'=>'prev_pics', 'page'=>array('post','page'), 'context'=>'normal', 'priority'=>'high', 'callback'=>'');

$options[] = array(	"name" => "Please enter the urls to your post/portfolio preview pictures here<br/>You can either choose to enter the URI directly or use the media uploader butten beside.<br/><strong>Attention:<br/></strong> If you have choosen to activate image resizing in '".THEMENAME." Options' you dont need to fill in a small or medium preview field, the big preview image will automaticaly be scaled down<br/><strong>Exception:</strong> If you want to show a video file in your portfolio you need to enter at least a medium preview pic, even if Image resizing is activated",
			"type" => "title");
			

			
$options[] = array(	"name" => "<strong>Preview Picture Small</strong>",
			"desc" => "Image only, Size: 280px * 124px",
			"id" => "_preview_small",
			"button_label" => "Insert Image",
			"std" => "",
			"size" => 40,
			"type" => "media");
			
//if($k_option['general']['tim'] != 1)
//{	
			
	$options[] = array(	"name" => "<strong>Preview Picture Medium</strong>",
				"desc" => "Image only, Size: 610px * 273px",
				"id" => "_preview_medium",
				"std" => "",
				"button_label" => "Insert Image",
				"size" => 40,
				"type" => "media");
//}			

$options[] = array(	"name" => "<strong>Full Size Picture or Video for Lightbox</strong>",
			"desc" => "Image and Video Links allowed",
			"id" => "_preview_big",
			"std" => "",
			"button_label" => "Insert Image/Video",
			"size" => 40,
			"type" => "media");
	
$options[] = array(	"name" => "<strong>Short Intro, Video Posting</strong><br/>If Posting Video you must sometimes add the size depending on what you want to show. 
			Some valid examples: (more info in the documentation)<br/>
			http://www.youtube.com/watch?v=GgR6dyzkKHI<br/>
			http://movies.apple.com/movies/fox/lightningthief/percyjackson-tlrf_h.640.mov?width=640&height=268<br/>
			http://www.adobe.com/products/flashplayer/include/marquee/design.swf?width=792&amp;height=294<br/>",
			"type" => "title");

$new_box = new kriesi_meta_box($options, $boxinfo);
