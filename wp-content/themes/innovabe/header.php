<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php global $k_option, $query_string; $k_option['custom']['real_query'] = $query_string; ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">


<!-- basic meta tags -->
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<?php

   if (function_exists('khelper_follow_nofollow')) khelper_follow_nofollow();
// outputs a rel=follow or nofollow tag to circumvent google duplicate content for archives
// located in framework/helper_functions/lots_of_small_helpers.php

?>



<!-- title -->
<title><?php if (is_home()) { bloginfo('name'); ?><?php } elseif (is_category() || is_page() ||is_single()) { ?> <?php } ?><?php wp_title(''); ?></title>


<!-- feeds and pingback -->
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS2 Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />


<!-- stylesheets -->
<link rel="stylesheet" href="<?php echo bloginfo('template_url'); ?>/js/prettyPhoto/css/prettyPhoto.css" type="text/css" media="screen"/>
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />

<?php $skin = $k_option['general']['skin'] != '' ?  $k_option['general']['skin'] : 1; ?>
<link rel="stylesheet" href="<?php echo bloginfo('template_url'); ?>/css/style<?php echo $skin; ?>.css" type="text/css" media="screen"/>


<!-- scripts -->
<?php 
// check which slider and which config file should be used
if ($k_option['slider']['which_slideshow'] == 1)
{
	if($k_option['slider']['slideshow_config'] == 1)
	{
		$config_url = get_bloginfo('template_url').'/slideshow/dont_edit.php';
	}
	else
	{
		$config_url = get_bloginfo('template_url').'/slideshow/config.xml';
	}
?>
<script type="text/javascript" src="<?php echo get_bloginfo('template_url'); ?>/slideshow/js/swfobject/swfobject.js"></script>

<script type="text/javascript">
	var flashvars = {};
	flashvars.xml = "<?php echo $config_url; ?>";
	var attributes = {};
	attributes.wmode = "transparent";
	attributes.id = "slider";
	swfobject.embedSWF("<?php echo get_bloginfo('template_url'); ?>/slideshow/cu3er.swf", "featured_image", "940", "420", "9", "expressInstall.swf", flashvars, attributes);
</script>
<?php } ?>

<!-- Internet Explorer 6 PNG Transparency Fix for all elements with class 'ie6fix' -->	
<!--[if IE 6]>
<script type='text/javascript' src='<?php echo get_bloginfo('template_url'); ?>/js/dd_belated_png.js'></script>
<script>DD_belatedPNG.fix('.ie6fix');</script>
<style>#footer .box ul li a, #sidebar .box ul a {zoom:1;}</style>
<![endif]-->

<?php 
######################################################################
# PHP scripts
######################################################################
// single post comment reply script by wordpress
if ( is_singular() ) wp_enqueue_script( 'comment-reply' );

// cehck for custom widgets
check_custom_widget();

//wp-head hook, needed for plugins, do not delte
wp_head();

?>

<!-- meta tags, needed for javascript -->
<meta name="autorotate" content="<?php echo $k_option['slider']['slide_autorotate'];?>" />
<meta name="autorotate_duration" content="<?php echo $k_option['slider']['slide_duration']; ?>" />
<meta name="temp_url" content="<?php echo get_bloginfo('template_url'); ?>" />


</head>

<?php 
######################################################################
# check for custom logo
######################################################################
if (isset($k_option['general']['logo']) && $k_option['general']['logo'] != '')
{
	$logo = '<img src="'.$k_option['general']['logo'] .'" alt="'.get_settings('home').'" />';
	$logoclass = '';
}
else // default logo
{
	$logo = get_bloginfo('name');
	$logoclass = 'logobg';
}

######################################################################
# check if front page or subpage and apply class to body
######################################################################
$k_page_id = 'subpage';
$k_body_class ='';

if (is_home()){ $k_page_id = 'frontpage'; }
if (isset($k_option['custom']['bodyclass'])) $k_body_class = $k_option['custom']['bodyclass'];
?>

<body id='<?php echo $k_page_id; ?>' <?php echo $k_body_class; ?>>

	<div class='wrapper'>
	
		<div id="top">
		
			<div id="head">
	
				<h1 class="logo ie6fix <?php echo $logoclass; ?>"><a href="<?php echo get_settings('home'); ?>/"><?php echo $logo; ?></a></h1>
				
				<?php 
				// Menu Controlled by the Backend
				
				if(is_object($k_option['custom']['kriesi_menu'])) $k_option['custom']['kriesi_menu']->display('Menu Manager','show_main_description'); 
				?>
				
			</div>	<!-- end #head -->


        
