<?php
/*
Template Name: Portfolio
*/
global $k_option, $more;
$k_option['custom']['bodyclass'] = "class='fullwidth'"; //$k_option['custom']['bodyclass'] = ""; 

get_header();


$more = 0;
$posts_per_page = $k_option['portfolio']['portfolio_entry_count'];
$query_string ="posts_per_page=".$posts_per_page;
$query_string .= "&cat=".$k_option['portfolio']['matrix_slider_port_final'][$post->ID]."&paged=$paged";

// the query string now looks like this:
// "cat=3,10,12&posts_per_page=9&paged=$paged";
// you can add additional query options if you want, all of them are described here:
// http://codex.wordpress.org/Template_Tags/query_posts#Examples
// append this parameters with the "&" sign

// example: $query_string =  $query_string."&orderby=author&order=ASC";

query_posts($query_string);
?>
<div id="main" >	
	<div id="content" >		
			<?php 
			$boxnumber = 1;
			
			if (have_posts()) : 
			while (have_posts()) : the_post();
			$more = 0;
			// check if we got a previe picture, and which one should be taken 
				// (image resizing with "tim thumb" on? then we can take the big one and resize it)
				$preview_small = get_post_meta($post->ID, "_preview_small", true);
				$preview_medium = get_post_meta($post->ID, "_preview_medium", true);
				$preview_big = get_post_meta($post->ID, "_preview_big", true);
				
				//defaults:
				$preview = $preview_small;
				$link_url = $preview_big;
				$lightbox = 'boxes';
				$link = true;
				//change if necessary:
				
				// resizing? => take next sized picture
				if ($k_option['general']['tim'] == "1" && $preview_small == "") 
				{ 
					$preview = $preview_medium  != '' ? $preview_medium : $preview_big;
				} 
				
				if (!kriesi_is_file($preview_big,'image')) 
				{
					$preview = $preview_small  != '' ? $preview_small : $preview_medium; 
					$link_url = $preview_big;
				}	
				
				// no bigpicture? => no lightbox
				if ($preview_big == "") { $lightbox = ''; $link = true; $link_url = get_permalink(); } 
				// the kriesi_build_image function used here checks if the image should be resized. 
				// the function is located in framework/helper_functions

				$preview = kriesi_build_image(array('url'=>$preview,
													'height'=> '124',
													'width'=> '280',
													'lightbox'=>$lightbox,
													'link'=>$link,
													'link_url'=>$link_url
													));

			

			if ($boxnumber == 1) echo '<div class="entry portfolio_entry">'; ?>

			<div class="box box_small box<?php echo $boxnumber; ?>">
			
				<?php echo $preview; // echo the preview image ?>
				
				<h3 id="post-<?php the_ID(); ?>"><a href="<?php echo get_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_title(); ?></a></h3>
				<?php the_excerpt(); // small excerpt of the post content ?> 
			
				<a href="<?php echo get_permalink(); ?>" class="more-link">Read more</a>
				
			</div>	
			
					
			<?php 
			if ($boxnumber == 3) echo '</div>';
           	$boxnumber = $boxnumber == 3 ? '1' : $boxnumber + 1;
			
			endwhile; 
			
			if($boxnumber != 1){
			echo '</div>';
			}
	
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
<?php	                   
get_footer(); ?>