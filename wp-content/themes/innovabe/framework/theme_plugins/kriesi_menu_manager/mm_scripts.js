jQuery.noConflict();

(function($)
{ 
	$.fn.kriesi_mm = function(default_options) 
	{	
		return this.each(function()
		{	
			//variables for later use
			var $menu = $(this);
			var $button_add = $menu.find('.mm_add');
			
			var $blank_entry = $menu.find('.blank_default_state>li');
			var $mainlist = $menu.find('.mainlist');		
			
			var $item;
			
			//nesting variables
			var left;
			var right;
			var modifier;
			
			
			$menu.event = {
			
				//add new item to the bottom of the list
				add_item : function()
				{
					$item = $blank_entry.clone().appendTo($mainlist);
					return this;
				},
				
				//updates all ids
				update_ids : function()
				{	
					
					$mainlist.find('.mm_id').each(function(i)
					{	
						$(this).val(i+1);
					});
					
					$mainlist.find('.mm_list_item').each(function(i){
					
						$(this).find('.mm_change_id').each(function(){
							$oldname = $(this).attr('name').split(':');
							$(this).attr('name', $oldname[0]+":"+(i+1))
							
						});
					
					});
					
					
					return this;
				},
				
				
				//updates the nesting set values 
				update_nesting : function($level)
				{	
					if(!$level || $level == undefined)
					{
						$level = $mainlist.find('>li');
						left = 0;
						right = 0;
						modifier = 0;
					}
					
					modifier++;
					
					$level.each(function()
					{	
						left += 2;
						right += 2;
						$(this).find('>.mm_lft').val(left-modifier);
						
						$menu.event.update_nesting($(this).find('>ul>li'));
						
						$(this).find('>.mm_rgt').val(right-modifier+2);
						modifier--;
						
					});
					
					return this;
					
				},
				
				apply_click_events : function()
				{						
					$mainlist.find('.mm_up').unbind('click').bind("click", function(){ $menu.event.move_item(-1, this).update_ids().update_nesting().useless(); });
					
					$mainlist.find('.mm_down').unbind('click').bind("click", function(){ $menu.event.move_item(1, this).update_ids().update_nesting().useless(); });
					
					$mainlist.find('.mm_left').unbind('click').bind("click", function(){ $menu.event.indent_item(-1, this).update_ids().update_nesting().useless(); });
					
					$mainlist.find('.mm_right').unbind('click').bind("click", function(){ $menu.event.indent_item(1, this).update_ids().update_nesting().useless(); });

					$mainlist.find('.mm_delete').unbind('click').bind("click", function(){ $menu.event.delete_item(this).update_ids().update_nesting().useless(); });
					
					return this;
				},
				
				delete_item : function($me)
				{
					$($me).parents('li:eq(0)').remove();
					return this;
				},
				
				// moves item up or down
				move_item : function($direction, $me)
				{	
					var $moving_item = $($me).parents('li:eq(0)'), $otheritem;
					
					if($direction === -1)
					{
						$otheritem = $moving_item.prev('.mm_list_item');
						$moving_item.insertBefore($otheritem);
						
					}else{
					
						$otheritem = $moving_item.next('.mm_list_item');
						$moving_item.insertAfter($otheritem);
					}
				
					return this;
				},
				
				useless : function()
				{	
					$mainlist.find('.mm_list_item .mm_controll').removeClass('mm_disabled');
					
					$mainlist.find('.mm_list_item').each(function(i){	
				
						if(!$(this).prev().is('.mm_list_item'))
						{	
							$(this).find('.mm_up:eq(0) , .mm_right:eq(0)').addClass('mm_disabled');
						}
													
						if(!$(this).next().is('.mm_list_item'))
						{	
							$(this).find('.mm_down:eq(0)').addClass('mm_disabled');
						}
						
						if($(this).parent().is('.mainlist'))
						{	
							$(this).find('.mm_left:eq(0)').addClass('mm_disabled');
						}
		
					});
					return this;
				},
				
				//indent on +1 and outdent on -1 items
				indent_item : function($direction, $me)
				{	
					var $moving_item = $($me).parents('li:eq(0)'), $otheritem;
					
					if($direction === -1)
					{
						$otheritem = $moving_item.parents('.mm_list_item:first');
						$oldlist = $moving_item.parent('ul');
						
						//move the list item out of the ul
						$moving_item.insertAfter($otheritem);
						
						//delete the ul if empty
						if($oldlist.contents().length  == 0)
						{
							$oldlist.remove();
						}
						
					}else{
						
						//check if previous item is a list
						$otheritem = $moving_item.prev();
						
						if($otheritem.is('.mm_list_item') && $otheritem.find('ul').length == 0)
						{
							$moving_item = $moving_item.wrap('<ul></ul>').parent('ul');
							
						}
						else
						{	
							$otheritem = $otheritem.find('ul:first');
						}
						
						$moving_item.appendTo($otheritem);
					}
				return this;
				
				}
				
				
				
			
			}//end events
			
			$menu.event.update_ids().update_nesting().apply_click_events().useless();
			//add event trigger (new item)
			$button_add.click(function()
			{
				$menu.event.add_item().update_ids().update_nesting().apply_click_events().useless();
				select_multibox()
			});
			
			
			//add event trigger (new item)

		});	
	};
})(jQuery); 




function select_multibox() //improves the kriesi_menu with jquery functionallity
{
	jQuery('.multibox_select').parent('span').each(function(i)
	{	
		var $set_of_elements = jQuery(this);
		var $hidden_spans = $set_of_elements.find('.hide_element');
		var $multiboxselect = $set_of_elements.find('.multibox_select');
		var $multibox_item = $hidden_spans.find('input, select');
		
		$multiboxselect.unbind('change').bind('change', function()
		{
			$selected = jQuery(this).val();
			
			
			if($selected != "")
			{					
				$hidden_spans.css({display:"none"});
				$set_of_elements.find('.'+$selected).show(400);
				$multibox_item = $set_of_elements.find('.'+$selected+' input, .'+$selected+' select');
				
				if($multibox_item.is('input')){$multibox_item.val("")}
				
				var $real_value = $multibox_item.val();
				$set_of_elements.find('.real_value input').attr('value', $real_value);
				
			}else{
				$hidden_spans.css({display:"none"});	
				$set_of_elements.find('.real_value input').attr('value', '');
			}
			
			
			
		});
		
		$multibox_item.unbind('change').bind('change', function()
		{
			var $selected = $multiboxselect.val();	
			var $real_value = jQuery(this).val();
						
			if(jQuery(this).is("input")) 
			{
				$real_value = "manually$:$"+$real_value;
			}
			
			$set_of_elements.find('.real_value input').attr('value',$real_value);
		});
		
	})
}








jQuery(document).ready(function()
{	select_multibox();
	jQuery('.kriesi_mm').kriesi_mm();
});