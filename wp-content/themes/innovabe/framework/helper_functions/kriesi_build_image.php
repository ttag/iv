<?php
######################################################################
# displays an image, resized with timthumb if the options are set to
# resize, resizing is possible and the image is larger than the 
# parameters provided. Also appends lightbox link if requested
######################################################################

function kriesi_build_image($option)
{	
	global $k_option;
	
	$defaults = array(	'url'=>'', 									// string: uri 
						'link_url'=>'',								// string: optional link uri 
						'height'=>100,								// int: height
						'width'=>100,								// int: width
						'link'=>false,								// bol:	check if link should be created
						'lightbox'=>'',								// string: if set lightbox with that group will be attached
						'resize'=> $k_option['general']['tim'],		// int: 1 = true, 2 = false
						'script'=> KFWINC_URI.'timthumb.php?src=',	// string: timthumb uri
						'zc' => 1,									// int: zoomcrop 1 = true, 0 = false
						'title'=>'',								// string: title tag
						'uri_only'=>false,							// bol: return image uri only
						'domain'=>false								// bol: add or remove domain from timthumb output
						);
	
	$option = array_merge((array)$defaults,(array)$option);
	
	// defaults
	$link = $image = array('','');
	$lightbox = '';
	$parameters = '';
	$option['link_url'] = htmlspecialchars($option['link_url']);
	$option['url'] = htmlspecialchars($option['url']);
	
	//check if url var is set, if false return
	if($option['url'] == '') return ''; 
	
	
	//check if link should be displayed, if yes build link array
	if($option['link'])
	{	
		$link_url = $option['link_url'] != '' ? $option['link_url'] : $option['url'];
		$lightbox = $option['lightbox'] != '' ? 'rel="lightbox['.$option['lightbox'].']"' : '';
		
		
		$link[0] = '<a href="'.$link_url.'" title="'.$option['title'].'" '.$lightbox.'>';
		$link[1] = '</a>';
	}
	
	// check if only url should be returned
	if(!$option['uri_only'])
	{
		$image[0] = '<img src="';
		$image[1] = '" alt="" />';
	}
	
	
	//check if resizing should be done, if false return plane image
	if($option['resize'] != 1) return $link[0] .$image[0].$option['url'].$image[1].$link[1];
	
	
	// settings are set to resize, make pre check if the image should be resized
	$size = @getimagesize($option['url']);
	
	if (is_array($size) && isset($size[1]))
	{
		if ($size[1] <= $option['height'] && $size[0] <= $option['width'])
		{	
			// no need for resizing, image is smaller or has perfect size
			return $link[0] .$image[0].$option['url'].$image[1].$link[1];
		}
	}
	
	
	
	if($option['height'] != '') $parameters .= '&amp;h='.$option['height'];
	if($option['width'] != '') 	$parameters .= '&amp;w='.$option['width'];
	if($option['zc'] != '') 	$parameters .= '&amp;zc='.$option['zc'];
	
	//check if domain should be included in timthumb output
	if($option['domain'] == false)
	{
		$uri_array = parse_url($option['url']);
		$option['url'] = $uri_array['path'];
	}
	
	//build timthumb uri string
	$image_src = $option['script'].$option['url'].$parameters;
	
	return $link[0] .$image[0].$image_src.$image[1].$link[1];;


}