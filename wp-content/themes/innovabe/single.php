<?php
global $k_option; 
$k_option['custom']['bodyclass'] = ""; // $k_option['custom']['bodyclass'] = "class='fullwidth'";

get_header(); 
?>				
<div id="main">
	<div id="content">		
			<?php 
			if (have_posts()) : 
			while (have_posts()) : the_post();
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

		<div class='entry blogentry'>
		
			<div class="date">
   				<span class='day'><?php the_time('d') ?></span>
   				<span class='month'><?php the_time('M') ?></span>
   				<span class='year'><?php the_time('Y') ?></span>
			</div><!-- end date -->
			<h2><a href="<?php echo get_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_title(); ?></a></h2>
				
			<div class='post_data'>
				<span class='categories'><?php the_category(', ') ?><?php edit_post_link('Edit', ', ', ''); ?></span>
				<span class='author'><?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?></span>
			</div><!--end post data-->
			
		<?php 
		echo $preview; // echo the preview image
		the_content('Read more');  
		?>

	</div><!--end entry-->
	<div class='entry commententry'>
           		<?php comments_template(); ?>
           		</div>	
	<?php 	endwhile; 
	
				kriesi_pagination($query_string);
				else: 
		?>
			<div class="entry">
			<h2>Nothing Found</h2>
			<p>Sorry, no posts matched your criteria.</p>
			</div>
 	<?php
			endif;
	?>  
</div><!-- end content -->

<?php get_sidebar(); ?>

</div><!--end main-->

<?php get_footer();  ?>