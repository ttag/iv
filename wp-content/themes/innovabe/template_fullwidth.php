<?php
/*
Template Name: Full Width
*/

$k_option['custom']['bodyclass'] = "class='fullwidth'"; //$k_option['custom']['bodyclass'] = ""; 
get_header(); ?>


		<div id="main">
			<div id="content">
			
				<?php if (have_posts()) : while (have_posts()) : the_post(); // start loop
			// THIS PAGE CAN ONLY DISPLAY FULLWIDTH PREVIEW PICTURES (940px * 420px)
			
			
			//check if we got a previe picture, and which one should be taken (image resizing with "tim thumb" on? then we can take the big one and resize it)
			$preview_big = get_post_meta($post->ID, "_preview_big", true);
			$preview_medium = get_post_meta($post->ID, "_preview_medium", true);
			
			//defaults:
			$preview = $preview_big;
			$lightbox = '';
			$link = false;
			$link_url = $preview_big;
			
			if (!kriesi_is_file($preview_big,'image')) {$preview = $preview_medium;}
			
			// the kriesi_build_image function used here checks if the image should be resized. 
			// the function is located in framework/helper_functions
			$preview = kriesi_build_image(array('url'=>$preview,'height'=>'420','width'=>'940','lightbox'=>$lightbox,'link'=>$link));			
			?>		
				<div class='entry'>
					<?php echo $preview; ?>
           			<h2><a href="<?php echo get_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_title(); ?></a></h2>
					<?php 
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
 
<?php get_footer();  ?>