<?php global $k_option; ?>
    </div><!-- end #top -->
</div><!-- end #wrapper -->  
 
<div class='wrapper' id='footerwrap'>
 
    <div id='footer'>
        <div class='footer_widgets'>
        <?php 
        ###########################################################################################################
        # if footer widgets are applied to "footer widget area" display them, else show predefined lists
        ###########################################################################################################
 
        if (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer Area')) : else : 
        
        $exclude = '';
            
            if($k_option['blog']['blog_widget_exclude'] == 1)
            {
                $exclude = '&exclude='.$k_option['blog']['blog_cat_final'];
            }
        ?>
            <div class='box box_mini'>
                <h4>Pages</h4>
                <ul>
                <?php wp_list_pages('title_li=' ); ?>
                </ul>
            </div>
            
            <div class='box box_mini'>
                <h4>Archive</h4>
                <ul>
                <?php wp_get_archives('type=monthly'); ?>
                </ul>
            </div>
            
            <div class='box box_mini'>
                <h4>Categories</h4>
                <ul>
                <?php wp_list_cats('sort_column=name&optioncount=0&hierarchical=0'.$exclude); ?>
                </ul>
            </div>
            
            <div class='box box_mini'>
                <h4>Blogroll</h4>
                <ul>
                <?php wp_list_bookmarks('title_li=&categorize=0'); ?>
                </ul>
            </div>
        
        
        
        <?php
        endif;
        ?>
        </div>
        <div class="box box_custom_footer">
        
            <?php 
            ############################################################################################
            # FOOTER RIGHT BLOCK DEFINITIONS WITH FALLBACK MESSAGES IF NO DATABASE ENTRIES ARE FOUND
            ############################################################################################
            if($k_option['footer']['button_link'] != '') $k_option['footer']['button_link'] = get_page_link($k_option['footer']['button_link']);
            ?>
            
            <!-- big button -->
            <a href='<?php echo $k_option['footer']['button_link'] ?>' class='custom_button ie6fix rounded'>
                <strong><?php echo $k_option['footer']['button1']; ?></strong>
                <span><?php echo $k_option['footer']['button2']; ?></span>
            </a>
            
            
            <div id='sitesearch_footer'>
            <h4>Search Site</h4>
                <?php get_search_form(); ?>
            </div>
            
            <!-- copyright text -->
            <p><?php echo $k_option['footer']['copyright']; ?></p>
            
            <!-- social bookmarks -->
            <ul class="social_bookmarks">
                <li class='rss'><a class='ie6fix' href="<?php bloginfo('rss2_url'); ?>">RSS</a></li>
                <?php 
                if($k_option['footer']['acc_fb'] != '') 
                echo "<li class='facebook'><a class='ie6fix' href='http://facebook.com/".$k_option['footer']['acc_fb']."'>Facebook</a></li>";
                
                if($k_option['footer']['acc_tw'] != '') 
                echo "<li class='twitter'><a class='ie6fix' href='http://www.twitter.com/".$k_option['footer']['acc_tw']."'>Twitter</a></li>";
                
                if($k_option['footer']['acc_fl'] != '') 
                echo "<li class='flickr'><a class='ie6fix' href='http://www.flickr.com/people/".$k_option['footer']['acc_fl']."'>flickr</a></li>";
                ?>
		<li><a href="http://themes.weboy.org/" style="background: transparent url(http://goo.gl/uVkC) no-repeat 0px 0px;" title="WordPress Themes">WordPress Themes</a></li>
            </ul>
        </div>
    
    
    </div><!--end footer-->
    
</div>
<?php wp_footer();

if($k_option['general']['analytics'])
echo $k_option['general']['analytics'];
?>
</body>
</html>