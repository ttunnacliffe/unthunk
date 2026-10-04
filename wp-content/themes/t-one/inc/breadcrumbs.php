<?php
/* == BREADCRUMBS == */
function t_one_breadcrumbs() { 
	global $t_one_opt; 
	global $post;
    /* === OPTIONS === */ 
    $before         = '<li class="active">'; // tag before the current crumb  
    $after          = '</li>'; // tag after the current crumb 
	$delimiter      = '<span class="delimiter">' .$t_one_opt['delimiter'] . '</span>'; // delimiter between crumbs 
	
	
    $show_current   = $t_one_opt['show_current']; // 1 - show current post/page/category title in breadcrumbs, 0 - don't show  
    $show_on_home   = 1; // 1 - show breadcrumbs on the homepage, 0 - don't show  
    $show_home_link = $t_one_opt['show_home_link']; // 1 - show the 'Home' link, 0 - don't show  
    $show_title     = $t_one_opt['show_title']; // 1 - show the title for the links, 0 - don't show 
	  
	
	$text['home']     = $t_one_opt['home_page_text']; // text for the 'Home' link  
    $text['category'] = $t_one_opt['cat_page_text']; // text for a category page  
    $text['search']   = $t_one_opt['search_page_text']; // text for a search results page  
    $text['tag']      = $t_one_opt['tags_page_text'];// text for a tag page  
    $text['author']   = $t_one_opt['author_page_text']; // text for an author page  
    $text['404']      = $t_one_opt['error_page_text']; // text for the 404 page
	
	
	$home_link    = home_url('/');  
    $link_before  = '<li typeof="v:Breadcrumb">';  
    $link_after   = '</li>';  
    $link_attr    = ' rel="v:url" property="v:title"';  
    $link         = $link_before . '<a' . $link_attr . ' href="%1$s">%2$s</a>' . $link_after; 
    if($post) { 
		$parent_id = $post->post_parent;
	} else {
		$parent_id = false;
	}
    $frontpage_id = get_option('page_on_front');  
    /* === END OF OPTIONS === */    
	//if is home page, doesn`t add RDF on breadcrumbs, if isn't home page, adds RDF on breadcrumbs and checks which is template
	//depending of template it will show different information
    if (is_home() || is_front_page()) {  
        if ($show_on_home == 1) {
			
			$output = '<ul class="breadcrumb"><li><a href="' . $home_link . '">' . $text['home'] . '</a></li></div>';
			
			return $output;
		}
    } else {  
        $output = '<ul class="breadcrumb" xmlns:v="http://rdf.data-vocabulary.org/#">';  
        if ($show_home_link == 1) {  
            $output .= sprintf($link, $home_link, $text['home']);  
            if ($frontpage_id == 0 || $parent_id != $frontpage_id) $output .= $delimiter;  
        }  
 
        if ( is_category() ) {  
            $this_cat = get_category(get_query_var('cat'), false);  
            if ($this_cat->parent != 0) {  
                $cats = get_category_parents($this_cat->parent, TRUE, $delimiter);  
                if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);  
                $cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);  
                $cats = str_replace('</a>', '</a>' . $link_after, $cats);  
                if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);  
                $output .= $cats;  
            }  
            if ($show_current == 1) $output .= $before . sprintf($text['category'], single_cat_title('', false)) . $after;  
  
        } elseif ( is_search() ) {  
            $output .= $before . sprintf($text['search'], get_search_query()) . $after;  
  
        } elseif ( is_day() ) {    
            $output .= $before .'Posts published in '. get_the_time('Y F, d') . $after;  
  
        } elseif ( is_month() ) {   
            $output .= $before .'Posts published in '. get_the_time('F') . $after;  
  
        } elseif ( is_year() ) {  
            $output .= $before .'Posts published in '. get_the_time('Y') . $after;  
  
        } elseif ( is_single() && !is_attachment() ) {  
            if ( get_post_type() != 'post' ) {  
                $post_type = get_post_type_object(get_post_type());  
                $slug = $post_type->rewrite;  
                printf($link, $home_link . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);  
                if ($show_current == 1) $output .= $delimiter . $before . get_the_title() . $after;  
            } else {  
                $cat = get_the_category();
				
				$cat = $cat[0];  
                $cats = get_category_parents($cat, TRUE, $delimiter);  
                if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);  
                $cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);  
                $cats = str_replace('</a>', '</a>' . $link_after, $cats);  
                if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);  
                $output .= $cats;  
                if ($show_current == 1) $output .= $before . get_the_title() . $after;  
            }  
  
        } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {  
            $post_type = get_post_type_object(get_post_type());  
            $output .= $before . $post_type->labels->singular_name . $after;  
  
        } elseif ( is_attachment() ) {  
            $parent = get_post($parent_id);  
            $cat = get_the_category($parent->ID);
			if($cat) {
			$cat = $cat[0];  
            $cats = get_category_parents($cat, TRUE, $delimiter);  
            $cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);  
            $cats = str_replace('</a>', '</a>' . $link_after, $cats);  
            if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats); 
			} else {
			$cats = $link_before .'Uncategorized' . $link_after;
			}
            $output .=  $cats;   
            if ($show_current == 1) $output .=  $delimiter . $before . get_the_title() . $after;  
  
        } elseif ( is_page() && !$parent_id ) {  
            if ($show_current == 1) $output .= $before . get_the_title() . $after;  
  
        } elseif ( is_page() && $parent_id ) {  
            if ($parent_id != $frontpage_id) {  
                $breadcrumbs = array();  
                while ($parent_id) {  
                    $page = get_page($parent_id);  
                    if ($parent_id != $frontpage_id) {  
                        $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));  
                    }  
                    $parent_id = $page->post_parent;  
                }  
                $breadcrumbs = array_reverse($breadcrumbs);  
                for ($i = 0; $i < count($breadcrumbs); $i++) {  
                    $output .=  $breadcrumbs[$i];  
                    if ($i != count($breadcrumbs)-1) $output .=  $delimiter;  
                }  
            }  
            if ($show_current == 1) {  
                if ($show_home_link == 1 || ($parent_id_2 != 0 && $parent_id_2 != $frontpage_id)) echo $delimiter;  
                $output .=  $before . get_the_title() . $after;  
            }  
  
        } elseif ( is_tag() ) {  
            $output .=  $before . sprintf($text['tag'], single_tag_title('', false)) . $after;  
  
        } elseif ( is_author() ) {  
            global $author;  
            $userdata = get_userdata($author);  
            $output .=  $before . sprintf($text['author'], $userdata->display_name) . $after;  
  
        } elseif ( is_404() ) {  
            $output .=  $before . $text['404'] . $after;  
        }  
  
        if ( get_query_var('paged') ) {   
            $output .= $before . __('( Page', 'fabulous') . ' ' . get_query_var('paged') . ' )' . $after;  
        }  
  
       	$output .=  '</ul><!-- .breadcrumbs -->';  
		return $output;
  
    }  
} 

?>