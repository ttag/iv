<?php
class simple_breadcrumb{
	var $options;
	
function simple_breadcrumb(){
	
	$this->options = array( 	//change this array if you want another output scheme
	'before' => '<span> ',
	'after' => ' </span>',
	'delimiter' => '&raquo;'
	);
	
	$markup = $this->options['before'].$this->options['delimiter'].$this->options['after'];
	
	global $post;
	echo '<p class="breadcrumb"><span class="breadcrumb_info">You are here:</span> <a href="'.get_option('home').'">';
		bloginfo('name');
		echo "</a>";
		if(!is_front_page()){echo $markup;}
				
		$output = $this->simple_breadcrumb_case($post);
		
		echo "<span class='current_crumb'>";
		if ( is_page() || is_single()) {
		the_title();
		}else{
		echo $output;
		}
		echo " </span></p>";
	}
	
function simple_breadcrumb_case($der_post){
	$markup = $this->options['before'].$this->options['delimiter'].$this->options['after'];
	if (is_page()){
		 if($der_post->post_parent) {
			 $my_query = get_post($der_post->post_parent);			 
			 $this->simple_breadcrumb_case($my_query);
			 $link = '<a href="';
			 $link .= get_permalink($my_query->ID);
			 $link .= '">';
			 $link .= ''. get_the_title($my_query->ID) . '</a>'. $markup;
			 echo $link;
		  }	
	return;			 	
	} 
			
			
	if(is_single()){
		$category = get_the_category();
		if (is_attachment()){
		
			$my_query = get_post($der_post->post_parent);			 
			$category = get_the_category($my_query->ID);
			$ID = $category[0]->cat_ID;

			echo get_category_parents($ID, TRUE, $markup, FALSE );
			previous_post_link("%link $markup");
			
		}else{
			$ID = $category[0]->cat_ID;
			echo get_category_parents($ID, TRUE, $markup, FALSE );

		}
	return;
	}
	
	if(is_category()){
		$category = get_the_category(); 
		$i = $category[0]->cat_ID;
		$parent = $category[0]-> category_parent;
		
		if($parent > 0 && $category[0]->cat_name == single_cat_title("", false)){
			echo get_category_parents($parent, TRUE, $markup, FALSE);
		}
	return single_cat_title('',FALSE);
	}
	
	
	if(is_author()){
		$curauth = get_userdatabylogin(get_query_var('author_name'));
		return "Author: ".$curauth->nickname;
	}
	if(is_tag()){ return "Tag: ".single_tag_title('',FALSE); }
	
	if(is_404()){ return "404 - Page not Found"; }
	
	if(is_search()){ return "Search"; }	
	
	if(is_year()){ return get_the_time('Y'); }
	
	if(is_month()){
	$k_year = get_the_time('Y');
	echo "<a href='".get_year_link($k_year)."'>".$k_year."</a>".$markup;
	return get_the_time('F'); }
	
	if(is_day() || is_time()){ 
	$k_year = get_the_time('Y');
	$k_month = get_the_time('m');
	$k_month_display = get_the_time('F');
	echo "<a href='".get_year_link($k_year)."'>".$k_year."</a>".$markup;
	echo "<a href='".get_month_link($k_year, $k_month)."'>".$k_month_display."</a>".$markup;

	return get_the_time('jS (l)'); }
	
	}

}

?>