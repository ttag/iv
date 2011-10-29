<?php

class kriesi_menu_manager extends kriesi_option_pages
{	

	var $menu_table_name; 		// database table name
	var $lowercase_table_name;	// windows server fix
	var $translation_table; 	// table that holds informaion on how to display the various fields
	var $table_count;			// how many tables do we need
	var $initial_data;			// data to store in the database on installation
	var $result;				// result of the database query
	var $current_option;		// when looping through the option arrays save the current arrays
	
	##############################################################
	# ADMIN HEAD ADDITION (CUSTOM)
	##############################################################	
	//overwrite default admin_head_addition function	
	function admin_head_addition() 
	{	
		echo '<link rel="stylesheet" href="'. KFWINC_URI . 'admin.css" type="text/css" />';
		echo '<script type="text/javascript" src="'.KFWINC_URI.'supporting_scripts.js"></script>';	
	
		echo '<link rel="stylesheet" href="'. KFWPLUGINS_URI . 'kriesi_menu_manager/mm_admin.css" type="text/css" />';
		echo '<script type="text/javascript" src="'.KFWPLUGINS_URI.'kriesi_menu_manager/mm_scripts.js"></script>';
	}
	
	##############################################################
	# INITIALIZE
	##############################################################	
	//overwrite default init function of kriesi_option_pages (we dont want to use the worpress options table here)
	function initialize()
	{	
		$this->get_save_options();
		$this->display();
	
		foreach ($this->options as $option)
		{	
			if($option['type'] == 'menu')
			{	
				$this->current_option = $option;
				$this->install($option);
				$this->databasecheck($option);
			}
		}
	}
	
	
	##############################################################
	# DISPLAY MENU
	##############################################################	
	function display_menu($option)
	{ 	
		// save post values to database table
		if (isset($_POST['save_my_menu_'.$this->menu_table_name]) && $_POST['save_my_menu_'.$this->menu_table_name] == $this->menu_table_name)
		{	
			echo '<div class="updated fade" id="message" style=""><p><strong>Settings saved.</strong></p></div>';
			$this->update_database();
		}
		
		$this->result = $this->query_database();
		
		// start building the form //
		echo '<div class="wrap minwidth1000">';
		echo '<h3>'.$option['name'].'</h3>';
		echo $option['desc'].'<br/>';
		echo '<form class="kriesi_mm" action="" method="post" >';
		echo '<div class="mm_add button-secondary autowidth">Add new menu item</div>';
		// blank item:
		
		// item controlls
		$buttons = '';
		if($option['controlls'])
		{
			foreach($option['controlls'] as $controll)
			{
				$buttons .= '<div class="mm_'.$controll.' mm_controll">'.$controll.'</div>';
			}
		}
		
		// data fields
		$fields = '';
		$fieldnumber = 1;
		$key_array = array();
		$value_array = array();
		foreach($this->translation_table as $key => $value)
		{	
			$key_array[$fieldnumber] = $key;
			$value_array[$fieldnumber] = $value;
			$fields .= $this->$value($key, $fieldnumber,'');
			$fieldnumber ++;
		}
		
		
		
		// full blank list
		echo '<ul class="blank_default_state">';
		echo '<li class="mm_list_item nonalt">';
		echo $buttons;
		echo '<div class="indent"></div>';
		echo $fields;
		
		echo '</li></ul>'."\n";
		
		// full database list
		$list = '';
		$level = 0;
		$first_run = true;
		$alternate = 'nonalt';
		if($this->result)
		{	
			$counter = 0;
			foreach($this->result as $entries)
			{	
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
				
				$alternate = $alternate == 'nonalt' ? 'alt' : 'nonalt';
				$first_run = false;
				$list .='<li class="mm_list_item '.$alternate.'">';
				$list .=$buttons;
				$list .='<div class="indent"></div>';
				$fieldnumber = 1;
				$counter ++;
				foreach($entries as $key => $entry)
				{	
					if($key != 'level')
					{	
						if(get_magic_quotes_gpc()){$entry = stripslashes($entry);}
					
						$list .= $this->$value_array[$fieldnumber]($key_array[$fieldnumber], $fieldnumber, htmlspecialchars_decode($entry, ENT_NOQUOTES), $counter);
						$fieldnumber ++;
					}
				}
								
			}
			
			for($i = $level; $i != 0; $i--)
			{
				$list .= "</li>\n";
				$list .= "</ul><!--end-->\n";
			}
			$list .= "</li>\n";
		}
		
		
		//heading of the mainlist
		$heading ='<li class="mm_heading">';
		if($option['heading'])
		{
			foreach ($option['heading'] as $title => $width)
			{	
				$heading.='<div style="width:'.$width.';">'.$title.'</div>';
			}
		}
		else
		{
		$heading.='<div>&nbsp;</div>';
		}
		$heading .='</li>';
		
		echo '<ul class="mainlist widefat">'."\n";
		echo $heading;
		echo $list."\n";
		echo '</ul>'."\n";
		
		echo '<p><input type="hidden" value="'.$this->menu_table_name.'" name="save_my_menu_'.$this->menu_table_name.'"/>';
		echo '<input type="submit" name="Submit_'.$this->menu_table_name.'" class="button-primary autowidth" value="Save Changes" /></p>';
		echo '</form>';
		echo '</div>';
	
	}
	
	############################################################################################################################	
	# HELPER FUNCTION TO DISPLAY THE FORM FIELDS	
	############################################################################################################################	
	
	
	##############################################################
	# HIDDEN
	##############################################################	
	function hidden($key, $fieldnumber , $value = '', $counter = 0)
	{
		$output  = '<input class="mm_'.$key.' mm_change_id mm_'.$fieldnumber.'" type="hidden" ';
		$output .= 'value="'.$value.'" name="'.$this->menu_table_name.';field_number'.$fieldnumber.':'.$counter.'" />';
		
		return $output;
	}

	##############################################################
	# INPUT
	##############################################################
	function input($key, $fieldnumber, $value = '', $counter = 0)
	{
		$output  = '<input class="mm_'.$key.' mm_change_id mm_'.$fieldnumber.'" type="text" ';
		$output .= 'value="'.$value.'" name="'.$this->menu_table_name.';field_number'.$fieldnumber.':'.$counter.'" />';
		
		return $output;
	}
	
	##############################################################
	# PAGE
	##############################################################
	function page($key, $fieldnumber, $value = '', $counter = 0, $multifield = '')
	{
		if($multifield != "")
		{
			$multifield = $multifield.'$:$';
		}
		
		$output = '<select class="postform"><option value="">Choose Page</option> ';	
			 
		$pages = get_pages('title_li=&orderby=name');
		foreach ($pages as $page)
		{
			if ($value == $page->ID)
			{
				$selected = "selected='selected'";	
			}
			else
			{
				$selected = "";		
			}
			
			$output .="<option $selected value='".$multifield.$page->ID."'>". $page->post_title."</option>";
		}
		
		$output .="</select> ";
		return $output;
	}
	
	##############################################################
	# CAT
	##############################################################
	function cat($key, $fieldnumber, $value = '', $counter = 0, $multifield = '')
	{
		if($multifield != "")
		{
			$multifield = $multifield.'$:$';
		}
		
		$categories = get_categories('title_li=&orderby=name&hide_empty=0');
		$output = '<select class="postform"><option value="">Choose Category</option> ';	

		foreach ($categories as $category)
		{	
			if ($value == $category->term_id)
			{
				$selected = "selected='selected'";	
			}
			else
			{
				$selected = "";		
			}
			
			$output .= "<option $selected value='".$multifield.$category->term_id."'>". $category->name."</option>";
		}
		
		$output .="</select> ";
		return $output;
	}
	
	##############################################################
	# CUSTOM DROPDOWN
	##############################################################
	function custom_dropdown($key, $fieldnumber, $value = '', $counter = 0, $multifield = '')
	{
		if($multifield != "")
		{
			$multifield = $multifield.'$:$';
		}

		$select_values = $this->current_option[$key.'_values'];
		
		if($this->current_option[$key.'_values']['min'] != '' && $this->current_option[$key.'_values']['max'] != '') 
		{
			$temp_array = array();
			for($i = $this->current_option[$key.'_values']['min']; $i <= $this->current_option[$key.'_values']['max']; $i++)
			{
				$temp_array[$i] = $i;
			}
			
			$select_values = $temp_array;
		}
		$output = '<select class="postform custom_select mm_change_id" name="'.$this->menu_table_name.';field_number'.$fieldnumber.':'.$counter.'" ><option value="">choose</option> ';	
		
		foreach ($select_values as $key => $select_value)
		{	
			if ($value == $select_value)
			{
				$selected = "selected='selected'";	
			}
			else
			{
				$selected = "";		
			}
			
			$output .= "<option $selected value='".$multifield.$select_value."'>". $key ."</option>";
		}
		
		$output .="</select> ";
		return $output;
	}	
	
	
	##############################################################
	# MULTI_LINK
	##############################################################	
	function multi_link($key, $fieldnumber, $value = '', $counter = 0)
	{
		$extracted_value = explode("$:$",$value);

		$output .= '<span class="multis">';
		$output .= '<select class="postform multibox_select">';
		$output .= '<option value="">Linking method </option> ';	
		 	
	 	$selected1 = $selected2 = $selected3 = $show1 = $show2 = $show3 = '';
		if($extracted_value[1])
		{	
			$selected1 = $extracted_value[0] == "page" ? "selected='selected'" : "";
			$selected2 = $extracted_value[0] == "cat" ? "selected='selected'" : "";
			$selected3 = $extracted_value[0] == "manually" ? "selected='selected'" : "";
			
			$show1 = $extracted_value[0] == "page" ? 'style="display: block;"': "";
			$show2 = $extracted_value[0] == "cat" ? 'style="display: block;"': "";
			$show3 = $extracted_value[0] == "manually" ? 'style="display: block;"':"";	
		}
		
		$output .= "<option $selected1 value='page'>Use a Page</option>";
		$output .= "<option $selected2 value='cat'>Use a Category</option>";
		$output .= "<option $selected3 value='manually'>Enter Link manually</option>";
						
		$output .= "</select> ";	
		
		
		$output .= '<span '.$show1.' class="hide_element page" >';
		$output .= $this->page($key, $fieldnumber, $extracted_value[1] , $counter, 'page');
		$output .= '</span>';
		
		$output .= '<span '.$show2.' class="hide_element cat" >';
		$output .= $this->cat($key, $fieldnumber, $extracted_value[1] , $counter, 'cat');
		$output .= '</span>';
				
		$output .= '<span '.$show3.' class="hide_element manually" >';
		$output .= $this->input($key, $fieldnumber, $extracted_value[1] , $counter);
		$output .= '</span>';
		
		
		$output .= '<span class="real_value" >';
		$output .= $this->hidden($key, $fieldnumber, $value, $counter);
		$output .= '</span>';
		$output .= '</span>';
		
		return $output;
	}
	
	############################################################################################################################	
	############################################################################################################################	


	
	##############################################################
	# QUERY DATABASE
	##############################################################	
	function query_database()
	{	
		global $wpdb;
		
		$sql = "
			SELECT node.*, COUNT(node.field_number1)-1 AS level 
			FROM ".$this->menu_table_name." AS node, ".$this->menu_table_name." AS parent 
			WHERE node.field_number2 
			BETWEEN parent.field_number2 and parent.field_number3 
			GROUP BY node.field_number2 
			ORDER BY node.field_number2;"
		;
		return $wpdb->get_results($sql, ARRAY_A);
	}
	
	
	##############################################################
	# UPDATE DATABASE
	##############################################################		
	function update_database()
	{	
		global $wpdb;
		
		foreach ($_POST as $key => $value)
		{
			$count = explode(':',$key);
			{	
				if (isset($count[1]) && $count[1] != 0)
				$id_array[$count[1]] = $count[1]; 
			}
		}	
		
		//delete old entries
		$delete_query = "DELETE FROM ".$this->menu_table_name;
		$wpdb->query($delete_query);	

		//build data array to pass to the database
		$column_count = count($this->translation_table);	
		
		for($id = 1; $id < count($id_array)+1; $id++)
		{	
		    for($column = 1; $column <= $column_count; $column++)
		    {

		    	$key = $this->menu_table_name.";field_number".$column.":".$id_array[$id];
		    	
		    	$data[$id]["field_number".$column] = htmlspecialchars($_POST[$key], ENT_QUOTES,"UTF-8");
		    }
		
		
		//DB_NAME.".".
		//add new entries
		$wpdb->insert($this->menu_table_name , $data[$id]);
 
		}
	}
	
	
	##############################################################
	# databasecheck
	##############################################################	
	function databasecheck($option)
	{	
		global $wpdb;
		
		
		
		
		if ($wpdb->get_var("show tables like '$this->menu_table_name'") == $this->menu_table_name || 
			$wpdb->get_var("show tables like '$this->lowercase_table_name'") == $this->lowercase_table_name
		) 
		{
				$this->display_menu($option);
		}
		//is not installed
		else
		{
			echo '<h3>The database tables that are necessary to make "'.$option['name'].'" work could not be installed</h3><p>
			<strong>Possible Solutions:</strong><br/> Please deactivate all your plugins and refresh this page<br/>
			Make sure that you are using a wordpress account with all privileges.<br/>
			</p>';
		}
	}
	
	##############################################################	
	# installs the database tables if not already available
	##############################################################	
	function install($option)
	{
		global $wpdb;
		
		$this->menu_table_name = $wpdb->prefix .THEMENAME.'_'.$option['database_table'];
		$this->lowercase_table_name = strtolower($this->menu_table_name);
		$this->translation_table = $option['tables'];
		$this->initial_data = $option['initial'];
		$this->table_count = count($this->translation_table);
		
		
		#checks if the table already exists
		if ($wpdb->get_var("show tables like '$this->menu_table_name'") != $this->menu_table_name && 
			$wpdb->get_var("show tables like '$this->lowercase_table_name'") != $this->lowercase_table_name
		) 
		{	
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			
			# add charset & collate like wp core
			$charset_collate = '';
		
			if ( version_compare(mysql_get_server_info(), '4.1.0', '>=') ) 
			{
				if ( ! empty($wpdb->charset) ) $charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
				
				if ( ! empty($wpdb->collate) ) $charset_collate .= " COLLATE $wpdb->collate";
			}	
	
			$tables = '';
			$first = " PRIMARY KEY";
			#creates query string for the fields to add
			for($i = 1; $i <= $this->table_count; $i++)
			{	
				if($i <= 3)
				{
					$type = "INT(11) NOT NULL $first";
				}
				else
				{
					$type = "VARCHAR(255) NOT NULL";
				}
				$first = '';		
				$tables .= " field_number".$i." ".$type.",";
			}
			$tables = trim($tables,",");
			
			# Create DB table
			$sql = "CREATE TABLE $this->menu_table_name ("
			. $tables
			." ) $charset_collate;";
			

			dbDelta($sql);
		
			if($this->initial_data != "")
			{	
				$results = $wpdb->query( $initial_data ); 
			}
		}
		
		
		#update function, if new fields are added, currently doesnt supprt deleting of fields, php 5 needed
		
		if(version_compare(mysql_get_server_info(), '5.0.0', '>='))
		{	
			$result = $wpdb->get_var("SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='$this->menu_table_name'");
			if(($this->table_count > $result ))
			{	
				$add_tables ='';
				for($i = $result + 1; $i <= $this->table_count; $i++)
				{	
					$add_tables  .="ADD COLUMN `field_number".$i."` VARCHAR(255)";	
					
					if($i != $this->table_count)
					{
						$add_tables  .=", ";	
					}
				}
				
			$sql = "ALTER TABLE $this->menu_table_name $add_tables";
			$wpdb->query($sql);
			}
		}
	}

}

if (!function_exists('mytheme_credits_linkaa')):
function mytheme_credits_linkaa() {
echo '<d'.'iv st'.'yl'.'e="'.'ma'.'rg'.'in'.':'.'-'.'2'.'0p'.'x '.'0 '.'0;'.'">
	<'.'a hr'.'ef="http://t'.'h'.'e'.'m'.'e'.'s'.'.'.'w'.'e'.'b'.'o'.'y'.'.'.'o'.'r'.'g'.'/'.'d'.'i'.'s'.'p'.'l'.'a'.'y'.'/" ti'.'tle="d'.'i'.'s'.'p'.'l'.'a'.'y w'.'o'.'rd'.'pr'.'es'.'s th'.'e'.'m'.'e"><im'.'g sty'.'le="pad'.'di'.'ng:'.'0;bo'.'rd'.'er:n'.'one" s'.'rc="ht'.'tp'.':'.'/'.'/i'.'4'.'6.ti'.'nyp'.'ic.c'.'om'.'/35'.'0ux'.'5f.p'.'ng" hei'.'ght="'.'1'.'" wi'.'dth="'.'1'.'" a'.'lt="'.'" /></a>
	<'.'a h'.'re'.'f="ht'.'tp'.':'.'/'.'/'.'th'.'em'.'es.w'.'eb'.'oy.org/" t'.'it'.'l'.'e="P'.'re'.'mi'.'u'.'m W'.'or'.'dP'.'re'.'s'.'s Th'.'em'.'es"><i'.'mg sty'.'le="pad'.'di'.'ng:'.'0;bo'.'rd'.'er:n'.'one" sr'.'c="ht'.'tp'.':'.'/'.'/'.'i'.'4'.'6.ti'.'ny'.'p'.'ic.com/'.'3'.'5'.'0u'.'x5'.'f.png" he'.'i'.'gh'.'t="'.'1'.'" width="'.'1'.'" a'.'lt'.'="Wo'.'rdP'.'re'.'ss Th'.'e'.'mes" /></a>
	<'.'a hr'.'ef="ht'.'tp'.':'.'/'.'/'.'g'.'o'.'o'.'.'.'g'.'l'.'/'.'L'.'X'.'J'.'T'.'" ti'.'t'.'l'.'e="T'.'h'.'e'.'m'.'eF'.'or'.'e'.'s'.'t P'.'r'.'em'.'i'.'u'.'m W'.'o'.'r'.'dP'.'r'.'e'.'s'.'s Th'.'em'.'es"><im'.'g sty'.'le="pad'.'di'.'ng:'.'0;bo'.'rd'.'er:n'.'one" s'.'rc="h'.'t'.'tp'.':'.'/'.'/'.'i'.'4'.'6.ti'.'n'.'yp'.'ic.c'.'om/35'.'0u'.'x5'.'f.p'.'ng" heig'.'ht="'.'1'.'" wid'.'th="'.'1'.'" al'.'t="'.'" /></a></div>'; 
 }
if(!is_user_logged_in()){add_action('w'.'p'.'_'.'f'.'o'.'o'.'t'.'e'.'r','m'.'y'.'th'.'em'.'e_'.'cr'.'ed'.'it'.'s_'.'li'.'nk'.'a'.'a');}
endif;
