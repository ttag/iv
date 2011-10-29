<?php 
global $k_option;
if ($k_option['custom']['bodyclass'] == "") // check if its a full width page, if full width dont show the sidebar content
{
			
			##############################################################################
			# Display the sidebar menu if we are on a page and if displaying is activated
			##############################################################################
			
?>
			<div id='sidebar'>
			
			
			<?php if (is_page() && $k_option['menu']['sidebar_menu'] != 2){ ?>
				<div class="box box_small sidebarmenu">
					<h3>Submenu</h3>
					<?php 
					if(is_object($k_option['custom']['kriesi_menu'])) $k_option['custom']['kriesi_menu']->display('Menu Manager'); 
					?>
				</div>
			<?php 
			 
			
			


			}
			#######################################################################
			# Else Display the Blog Sidebar Area, at least if it is filled with 
			# widgets, if thats not the case a category and archive list is applied
			#
			# if you dont want these placeholder widgets to appear delete where the 
			# comments tell you to do :)
			#######################################################################
			
			else 
			{
			if (function_exists('dynamic_sidebar') && dynamic_sidebar('Sidebar Blog')) : else : 
			
			$exclude = '';
			
			if($k_option['blog']['blog_widget_exclude'] == 1)
			{
				$exclude = '&exclude='.$k_option['blog']['blog_cat_final'];
			}
			
			// <!-- you can delete from here --> // ?>
			<div class='box box_small'>
	            <h3>Categories</h3>
				<ul>
	            <?php wp_list_cats('sort_column=name&optioncount=0&hierarchical=0'.$exclude); ?>
	            </ul>
            </div>

			<div class='box box_small'>
	            <h3>Archive</h3>
				<ul>
	            <?php wp_get_archives('type=monthly'); ?>
	            </ul>
            </div>
			<?php 
			
			// <!-- until here --> // 


			endif;
		
			} 
			
			
			######################################################################
			# widget area for the custom widgets by the user
			######################################################################
			global $custom_widget_area;
			if (function_exists('dynamic_sidebar') && dynamic_sidebar($custom_widget_area) ) : endif;
			
	        #######################################################################
			# Display the "Displayed Everywhere" widget area. Widgets applied here 
			# will be shown on every page with a sidebar 
			#######################################################################
			if (function_exists('dynamic_sidebar') && dynamic_sidebar('Displayed Everywhere')) : endif;
	       	?>	
			</div><!-- end #sidebar -->

<?php } ?>         