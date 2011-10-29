<?php
header ("Content-Type:text/xml"); 
global $k_option;
$paths = array(
		".",
		"..",
		"../..",
		"../../..",
		"../../../..",
		"../../../../..",
		"../../../../../..",
		"../../../../../../..",
		"../../../../../../../.."
	);
	
	foreach($paths as $path) 
	{
		if(@include( $path.'/wp-load.php'))
		{
			break;
		}
	}
	
	$hide ='';
	
	if($k_option['slider']['slide_duration'] != '')
	{
		if($k_option['slider']['slide_autorotate'] != '2')
		{	
			$timer = 'time="'.$k_option['slider']['slide_duration'].'"';
		}
		else
		{
			$timer = 'time="999999999999"';
			$hide = '<tweenIn x ="99990"/>';
		}
	}

echo'<?xml version="1.0" encoding="utf-8" ?>
<cu3er>
	<settings>
	
		<auto_play>
          <defaults symbol="circular" '.$timer.'/>
          '.$hide.'
      	</auto_play>
      	
      <preloader>
          <tweenIn alpha="0"/>
      </preloader>
      
      <description>
          <defaults heading_font="Trebuchet MS" paragraph_text_size="13" heading_text_margin="10, 25, 5, 25" round_corners="10, 10, 10, 10"/>
          <tweenIn width="740" y="300" x="100"/>
      </description>



		
    	<prev_button>
			<defaults round_corners="5,5,5,5"/>
			<tweenOver tint="0xFFFFFF" scaleX="1.1" scaleY="1.1"/>
			<tweenOut tint="0x000000" />
		</prev_button>
		
    	<prev_symbol>
			<tweenOver tint="0x000000" />			
		</prev_symbol>
		
    	<next_button>
			<defaults round_corners="5,5,5,5"/>			
			<tweenOver tint="0xFFFFFF"  scaleX="1.1" scaleY="1.1"/>
			<tweenOut tint="0x000000" />
		</next_button>
		
    	<next_symbol>
			<tweenOver tint="0x000000" />
		</next_symbol>	
			
	</settings>    

	<slides>
	';
	
	if(is_object($k_option['custom']['slider'])) $k_option['custom']['slider']->display('Mainpage Slider','cu3er');
	
	echo '</slides>
</cu3er>';