<?php

class kriesi_menu_display
{
	var $result;				// database query result
	var $menu_table_name; 		// database table name
	var $options; 				// options passed by the option file
	
	function kriesi_menu_display($options)
	{
		$this->options = $options;
		$this->pageinfo = $pageinfo;
	}
	
	function display($menu, $method = 'show_basic')
	{	
		$options_to_use = $this->options[$menu];
		
		//check if passed variable is set
		if($options_to_use['database_table'])
		{	
			global $wpdb;
			$databas_table = $wpdb->prefix .THEMENAME.'_'.$options_to_use['database_table'];
			
			//make a query for database data
			$result = $this->_get_data($databas_table);
			
			if($result && method_exists($this, $method))
			{	
				$link_array = $this->get_data_array($result, $options_to_use);
				$this->$method($result, $options_to_use, $link_array);
			}
		}
	}
	
	function _get_data($databas_table)
	{
		global $wpdb;
		
		$sql = "
			SELECT node.*, COUNT(node.field_number1)-1 AS level 
			FROM ".$databas_table." AS node, ".$databas_table." AS parent 
			WHERE node.field_number2 
			BETWEEN parent.field_number2 and parent.field_number3 
			GROUP BY node.field_number2 
			ORDER BY node.field_number2;"
		;
		return $wpdb->get_results($sql, ARRAY_A);
		
	}
	
	function get_data_array($result, $options_to_use)
	{	
		$level = 0;
		$first_run = true;
		$counter = 1;
		foreach($result as $entries)
		{ 	
			$linkdata = explode("$:$",$entries['field_number6']);
			$link = '';
			$current = '';
			
			if($linkdata[0])
			{
				switch($linkdata[0])
				{
					case 'page':
					$link = get_page_link( $linkdata[1] );
					break;
					
					case 'cat':
					$link = get_category_link( $linkdata[1] );
					break;
					
					case 'manually':
					$link = $linkdata[1];
					break;
					
				}
			}
			
			########################
			# Check for active link
			########################
			$browser_request = $_SERVER['REQUEST_URI'];
			$testlink = $link;
			
			if($browser_request == '' || $browser_request == '/' )
			{
				$browser_request = trim(get_settings('home'),'/');
				$testlink = trim($link,'/');
			}
			preg_match("!(".$browser_request.")$!",$testlink, $current_link);
	
			if($current_link[1] != "") $current = 'current';



			$link_array[$counter]['link'] = $link;
			$link_array[$counter]['active'] = $current;
			$link_array[$counter]['level']	= $entries['level'];
			$link_array[$counter]['parent'] = '';
			
			if($link_array[$counter]['level'] > 0 && $link_array[$counter]['active'] != '')
			{
				$compare_level = $link_array[$counter]['level'];
				
				for($i = $counter-1; $i > 0; $i--)
				{	
					if($compare_level > $link_array[$i]['level'])
					{
						$link_array[$i]['parent'] = 'parent';
						$link_array[$i]['active'] = '';
						$compare_level --;
						if($link_array[$i]['level'] == 0) $i = 0;
					}
				}
			}
			$counter ++;
		}
		
		return $link_array;
	}	


######################################################################
# Display Basic result (first use in display)
######################################################################

	function show_basic($result, $options_to_use, $link_array)
	{	
		$list = '<ul>';
		$counter = 0;
		$level = 0;
		$first_run = true;
		
		foreach($result as $entries)
		{ 	
			$counter ++;
			
			if(!$first_run)
			{
				if ($entries['level'] != $level )
				{
					if($entries['level'] > $level)
					{
						$list .= "<ul>"."\n";
					}
					
					if($entries['level'] < $level)
					{	
						for($i = $level-$entries['level']; $i != 0; $i--)
						{	
							$list .= "</li></ul>"."\n";
						}
						$list .= '</li>'."\n";
					}
					$level = $entries['level'];
				}
				else
				{
					$list .= "</li>"."\n";
				}
			}
			
			if(get_magic_quotes_gpc()){$entries['field_number4'] = stripslashes($entries['field_number4']);}
			
			$first_run = false;
			$list .='<li class="'.$link_array[$counter]['parent'].$link_array[$counter]['active'].'li_item">';
			$list .= '<a class="navlink '.$link_array[$counter]['active'].'" href="'.$link_array[$counter]['link'].'">'.$entries['field_number4'].'</a>';
		}
		
		for($i = $level; $i != 0; $i--)
		{
			$list .= "</li>\n";
			$list .= "</ul><!--end-->\n";
		}
		
		$list .= "</li></ul>\n";
		
		echo $list;
	}
	
######################################################################
# Display Advanced result with description (first used in display)
######################################################################	
	function show_main_description($result, $options_to_use, $link_array)
	{	
		$list = '<ul '.$options_to_use['attr'].'>';
		$counter = 0;
		$level = 0;
		$first_run = true;
		
		foreach($result as $entries)
		{ 	
			$counter ++;
			
			if(!$first_run)
			{
				if ($entries['level'] != $level )
				{
					if($entries['level'] > $level)
					{
						$list .= "<ul>"."\n";
					}
					
					if($entries['level'] < $level)
					{	
						for($i = $level-$entries['level']; $i != 0; $i--)
						{	
							$list .= "</li></ul>"."\n";
						}
						$list .= '</li>'."\n";
					}
					$level = $entries['level'];
				}
				else
				{
					$list .= "</li>"."\n";
				}
			}
			
			if(get_magic_quotes_gpc())
			{
				$entries['field_number4'] = stripslashes($entries['field_number4']);
				$entries['field_number5'] = stripslashes($entries['field_number5']);
			}

			$first_run = false;
			$list .='<li class="'.$link_array[$counter]['parent'].$link_array[$counter]['active'].'li_item">';
			$list .= '<a class="navlink '.$link_array[$counter]['active'].'" href="'.$link_array[$counter]['link'].'">';
			if($level == 0) $list .= '<strong>';
			$list .= $entries['field_number4'];
			if($level == 0) $list .= '</strong><span>'.$entries['field_number5'].'</span>';
			$list .= '</a>';
		}
		
		for($i = $level; $i != 0; $i--)
		{
			$list .= "</li>\n";
			$list .= "</ul><!--end-->\n";
		}
		
		$list .= "</li></ul>\n";
		
		echo $list;
	}

}