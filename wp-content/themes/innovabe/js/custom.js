/* this prevents dom flickering, needs to be outside of dom.ready event: */
document.documentElement.className += 'js_active';
/*end dom flickering =) */

jQuery.noConflict();

jQuery(document).ready(function(){

	// activates the lightbox page, if you are using a dark color scheme use another theme parameter
	my_lightbox("a[rel^='prettyPhoto'], a[rel^='lightbox']");
	
	
	k_form(); //controls the contact form
	k_menu(); // controls the dropdown menu
	
	
});


jQuery(window).load(function(){
	var autorotate = jQuery("meta[name=autorotate]").attr('content');
	var autorotate_duration = jQuery("meta[name=autorotate_duration]").attr('content');
	
	/*image slider (alternate)*/
	var $slide_images = jQuery('#featured_image img');	
	if ($slide_images.length > 0 && autorotate != "2")
	{	
		if(autorotate_duration == '') autorotate_duration = 5;
	
		$slide_images.not('.current_img img').css({display:"none"});
		$slide_images.filter('.current_img img').css({visibility:"visible"});
		// set the automatic image rotation, number is time between transitions in miliseconds
		interval = setInterval(function() { k_fader("#featured_image img",'1'); }, (parseInt(autorotate_duration) * 1000)); 	
	}
});




function k_menu()
{
	jQuery("#nav a, .subnav a").removeAttr('title');
	jQuery(" #nav ul ").css({display: "none"}); // Opera Fix
	
	jQuery("#nav li").each(function()
	{	
		
		var $sublist = jQuery(this).find('ul:first');
		
		jQuery(this).hover(function()
		{	
			$sublist.stop().css({overflow:"hidden", height:"auto", display:"none"}).slideDown(400, function()
			{
				jQuery(this).css({overflow:"visible", height:"auto"});
			});	
		},
		function()
		{	
			$sublist.stop().slideUp(400, function()
			{	
				jQuery(this).css({overflow:"hidden", display:"none"});
			});
		});	
	});
}






function k_fader($items_to_fade, $next_or_prev)
{	
	var $items = jQuery($items_to_fade);
	var $currentitem = $items.filter(":visible");
	var $new_item;
	var $selector;
	
	$items.css('visibility','visible');
	
	if($items.length > 1)
	{
		for(i = 0; i < $items.length; i++)
		{
			if($items[i] == $currentitem[0])
			{	
				$selector = $next_or_prev >= 0 ? i != $items.length-1 ? i+1 : 0 : i == 0 ? $items.length-1 : i-1;
				
				$new_item = jQuery($items[$selector]);
				break;
			}
		}
		
		if( $new_item && $new_item.css("display") == "none" )
			{	
				$currentitem.css({zIndex:2});
				$new_item.css({zIndex:3}).fadeIn(1200, function()
				{
					$currentitem.css({display:"none"});
				});
				
			}
	}
}



function my_lightbox($elements)
{
jQuery($elements).prettyPhoto({
		"theme": 'light_square' /* light_rounded / dark_rounded / light_square / dark_square */																
	});

jQuery($elements).each(function()
{	
	var $image = jQuery(this).contents("img");
	$newclass = 'lightbox_video';
	
	if(jQuery(this).attr('href').match(/(jpg|gif|jpeg|png|tif)/)) $newclass = 'lightbox_image';
		
	if ($image.length > 0)
	{	
		if(jQuery.browser.msie &&  jQuery.browser.version < 7) jQuery(this).addClass('ie6_lightbox');
		
		var $bg = jQuery("<span class='"+$newclass+" ie6fix'></span>").appendTo(jQuery(this));
		
		jQuery(this).bind('mouseenter', function(){
			$height = $image.height();
			$width = $image.width();
			$pos =  $image.position();		
			$bg.css({height:$height, width:$width, top:$pos.top, left:$pos.left});
		});
	}
	
	
	
});	
	
jQuery($elements).contents("img").hover(function(){
		jQuery(this).stop().animate({opacity:0.5},400);
		},function(){
		jQuery(this).stop().animate({opacity:1},400);
		});


}


function k_form(){
	var my_error;
	var url = jQuery("meta[name=temp_url]").attr('content');
	jQuery(".ajax_form #send").bind("click", function(){
											 
	my_error = false;
	jQuery(".ajax_form #name, .ajax_form #message, .ajax_form #email ").each(function(i)
	{
				
				
				var value = jQuery(this).attr("value");
				var check_for = jQuery(this).attr("id");
				var surrounding_element = jQuery(this).parent();
				if(check_for == "email"){
					if(!value.match(/^\w[\w|\.|\-]+@\w[\w|\.|\-]+\.[a-zA-Z]{2,4}$/)){
						
						surrounding_element.attr("class","").addClass("error");
						
						my_error = true;
						}else{
						surrounding_element.attr("class","").addClass("valid");	
						}
					}
				
				if(check_for == "name" || check_for == "message"){
					if(value == ""){
						
						surrounding_element.attr("class","").addClass("error");
						
						my_error = true;
						}else{
						surrounding_element.attr("class","").addClass("valid");	
						}
					}
						   if(jQuery(".ajax_form #name, .ajax_form #message, .ajax_form #email").length  == i+1){
								if(my_error == false){
									jQuery(".ajax_form").slideUp(400);
									
									var $datastring = "ajax=true";
									jQuery(".ajax_form input, .ajax_form textarea, .ajax_form radio, .ajax_form select").each(function(i)
									{
										var $name = jQuery(this).attr('name');	
										var $value = encodeURIComponent(jQuery(this).attr('value'));
										$datastring = $datastring + "&" + $name + "=" + $value;
									});
																		
									
									jQuery(".ajax_form #send").fadeOut(100);	
									
									jQuery.ajax({
									   type: "POST",
									   url: url+"/send.php",
									   data: $datastring,
									   success: function(response){
									   jQuery(".ajax_form").before("<div class='ajaxresponse' style='display: none;'></div>");
									   jQuery(".ajaxresponse").html(response).slideDown(400); 
									   jQuery(".ajax_form #send").fadeIn(400);
									   jQuery(".ajax_form #name, .ajax_form #message, .ajax_form #email , .ajax_form #website").val("");
										   }
										});
									} 
							}
					});
			return false;
	});
}
