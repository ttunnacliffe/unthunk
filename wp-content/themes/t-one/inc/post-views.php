<?php

//return posts view count
function t_one_get_post_views($postID){

    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);

    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return '0';
    }

    return $count;

}

//get post views each time single page display
function t_one_set_post_views($postID) {

    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);

    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }

}

//necessary for well working
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

?>