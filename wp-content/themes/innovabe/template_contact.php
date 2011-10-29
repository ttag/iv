<?php
/*
Template Name: Contact Form
*/
global $k_option;
$name_of_your_site = get_option('blogname');
$email_adress_reciever = $k_option['contact']['email'];
$error = true;
if(isset($_POST['Send']))
{
	include('send.php');	
}

$k_option['custom']['bodyclass'] = ""; // $k_option['custom']['bodyclass'] = "class='fullwidth'";
get_header();

?>

<div id="main">
			<div id="content">
			
			<?php if (have_posts()) : while (have_posts()) : the_post(); // start loop
			
				$more = 0;
				// check if we got a previe picture, and which one should be taken 
				// (image resizing with "tim thumb" on? then we can take the big one and resize it)
				$preview_small = get_post_meta($post->ID, "_preview_small", true);
				$preview_medium = get_post_meta($post->ID, "_preview_medium", true);
				$preview_big = get_post_meta($post->ID, "_preview_big", true);
				
				//defaults:
				$preview = $preview_medium;
				$link_url = $preview_big;
				$lightbox = 'singlepost';
				$link = true;
				//change if necessary:
				
				// resizing? => take next sized picture
				if ($k_option['general']['tim'] == "1" && $preview_medium == "") 
				{ 
					$preview = $preview_big;
				} 
				
				// no bigpicture? => no lightbox
				if ($preview_big == "") { $lightbox = ''; $link = true; $link_url = get_permalink(); } 
				// the kriesi_build_image function used here checks if the image should be resized. 
				// the function is located in framework/helper_functions

				$preview = kriesi_build_image(array('url'=>$preview,
													'height'=> '273',
													'width'=> '610',
													'lightbox'=>$lightbox,
													'link'=>$link,
													'link_url'=>$link_url
													));				
			?>
		           <div class='entry'>
		           <h2><a href="<?php echo get_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_title(); ?></a></h2>
		           <?php 
		           echo $preview;
		           the_content(); ?>
						           
					<form action="" method="post" class="ajax_form">
						<fieldset><?php if (!isset($error) || $error == true){ ?><h3><span>Send us mail</span></h3>
						
						<p class="<?php if (isset($the_nameclass)) echo $the_nameclass; ?>" ><input name="yourname" class="text_input empty" type="text" id="name" size="20" value='<?php if (isset($the_name)) echo $the_name?>'/><label for="name">Your Name*</label>
						</p>
						<p class="<?php if (isset($the_emailclass)) echo $the_emailclass; ?>" ><input name="email" class="text_input email" type="text" id="email" size="20" value='<?php if (isset($the_email)) echo $the_email ?>' /><label for="email">E-Mail*</label></p>
						<p><input name="website" class="text_input" type="text" id="website" size="20" value="<?php if (isset($the_website))  echo $the_website?>"/><label for="website">Website</label></p>
						<label for="message" class="blocklabel">Your Message*</label>
						<p class="<?php if (isset($the_messageclass)) echo $the_messageclass; ?>"><textarea name="message" class="text_area empty" cols="40" rows="7" id="message" ><?php  if (isset($the_message)) echo $the_message ?></textarea></p>
						
						
						<p>
						<input type="hidden" id="myemail" name="myemail" value="<?php echo $email_adress_reciever; ?>" />
						<input type="hidden" id="myblogname" name="myblogname" value="<?php echo $name_of_your_site; ?>" />
						
						<input name="Send" type="submit" value="Send" class="button" id="send" size="16"/></p>
						<?php } else { ?> 
						<p><h3>Your message has been sent!</h3> Thank you!</p>
						
						<?php } ?>
						</fieldset>
						
					</form> 
					</div>		
			<?php			
			endwhile; 
			endif;
		?>  
			
			</div>
			
						
<?php get_sidebar(); ?>			
		 <!--[if IE 6]><div style="clear: both"></div><![endif]-->
		</div>

<?php get_footer();  ?>