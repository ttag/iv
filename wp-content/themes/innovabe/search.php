<?php 
global $more, $k_options; 
get_header();?> 
<div id="main">
	


	<div id="content">	<h2>Search Results</h2>	
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