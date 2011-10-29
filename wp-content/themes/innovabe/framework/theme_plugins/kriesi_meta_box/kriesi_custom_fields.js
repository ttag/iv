jQuery.noConflict();

jQuery(document).ready(function()
{	
	hijack_media_uploader();
	hijack_preview_pic();
});

function hijack_preview_pic()
{
	jQuery('.kriesi_preview_pic_input').each(function()
	{
		jQuery(this).bind('change focus blur ktrigger', function()
		{	
			
			$select = '#' + jQuery(this).attr('name') + '_div';
			$value = jQuery(this).val();
			$image = '<img src ="'+$value+'" />';
						
			var $image = jQuery($select).html('').append($image).find('img');
			
			//set timeout because of safari
			window.setTimeout(function()
			{
			 	if(parseInt($image.attr('width')) < 40)
				{	
					jQuery($select).html('');
				}
			},500);
		});
	});
}




function hijack_media_uploader()
{		
		$buttons = jQuery('.k_hijack');
		$realmediabuttons = jQuery('.media-buttons a');
		
		
		window.custom_editor = false;
		
		// set a variable depending on what has been clicked, normal media uploader or kriesi hijacked uploader
		$buttons.click(function()
		{
			window.custom_editor = jQuery(this).attr('id');
		});
		
		$realmediabuttons.click(function()
		{
			window.custom_editor = false;
		});

		window.original_send_to_editor = window.send_to_editor;
		window.send_to_editor = function(html)
		{	
			
			if (custom_editor) 
			{	
				$img = jQuery(html).attr('src');
				jQuery('input[name='+custom_editor+']').val($img).trigger('ktrigger');
				custom_editor = false;
				window.tb_remove();
			}
			else 
			{
				window.original_send_to_editor(html);
			}
		};
}

