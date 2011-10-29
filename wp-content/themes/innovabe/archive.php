<?php 
global $more, $k_options; 
get_header();?> 
<div id="main">

	<div id="content">	
	<h2><?php /* If this is a category archive */ if (is_category()) { ?>				
				Archive for <?php echo single_cat_title(); ?>
				
 			  	<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
				Archive for <?php the_time('F jS, Y'); ?>
				
			 	<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
				Archive for <?php the_time('F, Y'); ?>
			
				<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
				Archive for <?php the_time('Y'); ?>
				
			  	<?php /* If this is a search */ } elseif (is_search()) { ?>
				Search Results
				
			  	<?php /* If this is an author archive */ } elseif (is_author()) { ?>
				Author Archive
			
				<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
				Blog Archives
				<?php } ?></h2>
		
			<?php 
			if (have_posts()) : 
			while (have_posts()) : the_post(); ?>

		<div class='entry blogentry'>

			<h3><a href="<?php echo get_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_title(); ?></a></h3>
		<?php 
		the_excerpt();  
		
		?>
		<a href="<?php echo get_permalink(); ?>" class="more-link">Read more</a>
	</div><!--end entry-->
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