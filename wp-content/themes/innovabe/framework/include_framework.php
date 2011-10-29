<?php
##########################################################################################
# CONFIG 
##########################################################################################
define('FRAMEWORK_VERSION', 1.1);


##########################################################################################
# AUTOLOADER 
##########################################################################################

foreach ($autoload as $path => $includes)
{	
	if($includes)
	{
		foreach ($includes as $include)
		{
			switch($path)
			{
			case 'classes':
			include_once(KFWCLASSES.$include.'.php');
			break;
			
			case 'helper':
			include_once(KFWHELPER.$include.'.php');
			break;
			
			case 'plugins':
			include_once(KFWPLUGINS.$include.'.php');
			break;
			
			case 'option_pages':
			include_once(KFWOPTIONS.$include.'.php');
			break;
			
			case 'templatefiles':
			include_once(TEMPLATEPATH.'/'.$include.'.php');
			break;
			}
		}
	}
}
