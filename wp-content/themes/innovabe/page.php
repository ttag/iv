<?php 
###############################################################################################
# Check if the page displayed has a different template applied within the custom admin page
# if thats the case display the template file, otherwise display the basic page template
###############################################################################################

global $k_option;
######################################################################
# Check for blog and contact pages
######################################################################
if ($post->ID == $k_option['contact']['contact_page']) $contactpage = true;
else if ($post->ID == $k_option['blog']['blog_page']) $blogpage = true;


######################################################################
# Check for portfolio pages
######################################################################
if(isset($k_option['portfolio']['matrix_slider_port_final']) && $k_option['portfolio']['matrix_slider_port_final'] != ''){
	foreach($k_option['portfolio']['matrix_slider_port_final'] as $key => $value)
	{
		if ($post->ID == $key)
		{	
			$portfoliopage = true;
		} 
	}
}

######################################################################
# Include page templates if other template is applied to the page
######################################################################
if($contactpage)
{
	include(TEMPLATEPATH."/template_contact.php");
}
else if($blogpage)
{
	include(TEMPLATEPATH."/template_blog.php");
}
else if($portfoliopage)
{
	include(TEMPLATEPATH."/template_portfolio.php");
}
else
{
######################################################################
# Display Basic Page
######################################################################
$k_option['custom']['bodyclass'] = ""; // $k_option['custom']['bodyclass'] = "class='fullwidth'";
get_header(); ?>


		<div id="main">
			<div id="content">
			
				<?php if (have_posts()) : while (have_posts()) : the_post(); // start loop
			
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
					<?php edit_post_link('Edit', '', ''); ?>
				</div><!--end entry-->
				<?php endwhile; else: ?>
				<p>Sorry, no posts matched your criteria.</p>
			<!--do not delete-->
			<?php endif; ?>
	
			</div><!-- end content -->
			
<?php get_sidebar(); ?>			
		
		</div><!--end main-->
 
<?php get_footer(); } ?>