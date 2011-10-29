<?php

class kriesi_slider_display
{
	var $result;				// database query result
	var $menu_table_name; 		// database table name
	var $options; 				// options passed by the option file
	
	function kriesi_slider_display($options)
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
				$this->$method($result, $options_to_use);
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
	
	function cu3er($results, $options_to_use)
	{
		foreach($results as $result)
		{	
			$link = '';
			if( $result['field_number10'] != '')
			{
				$linkdata = explode("$:$",$result['field_number10']);
				
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
			}
			if ($link != '') $link ='<link target="_self">'.$link.'</link>'; 
				
			echo '<slide>';	
	        echo '   <url>'.kriesi_build_image(array('url'=>$result['field_number4'],'height'=>'420','width'=>'940','uri_only'=>true)).'</url>';
	        echo $link;
	        echo '</slide>';
	        
	        if( $result['field_number5'] != '' ||
	        	$result['field_number6'] != '' ||
	        	$result['field_number7'] != '' ||
	        	$result['field_number8'] != '' ||
	        	$result['field_number9'] != ''  )
	        	{
		        	if($result['field_number5'] != '') $direction = 'direction="'.$result['field_number5'].'"';
		        	if($result['field_number6'] != '') $slicing = 'slicing="'.$result['field_number6'].'"';
		        	if($result['field_number7'] != '') $num = 'num="'.$result['field_number7'].'"';
		        	if($result['field_number8'] != '') $shader = 'shader="'.$result['field_number8'].'"';
		        	if($result['field_number9'] != '') $zindex = 'z_multiplier="'.$result['field_number9'].'"';
		        	
		        	
		        	echo '<transition '.$direction.' '.$slicing.' '.$num.' '.$shader.' '.$zindex.' />';
				}
		}
	
	}
		
	function show_basic($results, $options_to_use)
	{
		$firstrun = " class='current_img'";
		
		foreach($results as $result)
		{	
			$link = '#';
			$image = '';
			
			
			if( $result['field_number10'] != '')
			{
				$linkdata = explode("$:$",$result['field_number10']);
				
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
			}
	        echo "\n".'<a href="'.$link.'"'.$firstrun.'><img src="'.kriesi_build_image(array('url'=>$result['field_number4'],'height'=>'420','width'=>'940','uri_only'=>true)).'" alt="" /></a>';
	        $firstrun = '';
		}
	}
}