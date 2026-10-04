<?php
add_action( 'widgets_init', 't_one_load_widgets' );

/* Function that registers widget. */
function t_one_load_widgets() {
    register_widget( 'Popular_posts' );
    register_widget( 'Recent_posts' );
}

/* CUSTOM POSTS LIST */
class Popular_posts extends WP_Widget {

    public function __construct() {
        /* Widget settings. */
        $widget_ops = array( 'classname' => 'popular_posts', 'description' => __('Display popular posts.', 't_one') );
        /* Create the widget. */
        parent::__construct( 'popular_posts', __('Popular posts (T-one)', 't_one'), $widget_ops );
    }

    public function widget( $args, $instance ) {
        extract( $args );
        /* User-selected settings. */
        $title = apply_filters('widget_title', $instance['title'] );
        $num = $instance['num'];

        /* Before widget (defined by themes). */
        echo $before_widget;

        /* Title of widget (before and after defined by themes). */
        if ( $title )
            echo $before_title . $title . $after_title;

        echo t_one_popular_posts($num);

        /* After widget (defined by themes). */
        echo $after_widget;
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        /* Strip tags (if needed) and update the widget settings. */
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['num'] = strip_tags( $new_instance['num'] );
        return $instance;
    }

    public function form( $instance ) {
        /* Set up some default widget settings. */
        $defaults = array( 'title' => '', 'id' => 'posts-list-widget', 'num' => '5');    
        $instance = wp_parse_args( (array) $instance, $defaults ); 
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>">
                <?php _e('Title:', 't_one') ?>
            </label>
            <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'num' ); ?>">
                <?php _e('Number of posts:', 't_one') ?>
            </label>
            <input id="<?php echo $this->get_field_id( 'num' ); ?>" name="<?php echo $this->get_field_name( 'num' ); ?>" value="<?php echo $instance['num']; ?>" style="width:100%;" />
        </p>
        <?php
    }
}

/* CUSTOM POSTS LIST */
class Recent_posts extends WP_Widget {

    public function __construct() {
        /* Widget settings. */
        $widget_ops = array( 'classname' => 'recent_posts', 'description' => __('Display recent posts.', 't_one') );
        /* Create the widget. */
        parent::__construct( 'recent_posts', __('Recent posts (T-one)', 't_one'), $widget_ops );
    }

    public function widget( $args, $instance ) {
        extract( $args );
        /* User-selected settings. */
        $title = apply_filters('widget_title', $instance['title'] );
        $num = $instance['num'];

        /* Before widget (defined by themes). */
        echo $before_widget;

        /* Title of widget (before and after defined by themes). */
        if ( $title )
            echo $before_title . $title . $after_title;

        echo t_one_recent_posts($num);

        /* After widget (defined by themes). */
        echo $after_widget;
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        /* Strip tags (if needed) and update the widget settings. */
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['num'] = strip_tags( $new_instance['num'] );
        return $instance;
    }

    public function form( $instance ) {
        /* Set up some default widget settings. */
        $defaults = array( 'title' => '', 'id' => 'posts-list-widget', 'num' => '5');    
        $instance = wp_parse_args( (array) $instance, $defaults ); 
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>">
                <?php _e('Title:', 't_one') ?>
            </label>
            <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'num' ); ?>">
                <?php _e('Number of posts:', 't_one') ?>
            </label>
            <input id="<?php echo $this->get_field_id( 'num' ); ?>" name="<?php echo $this->get_field_name( 'num' ); ?>" value="<?php echo $instance['num']; ?>" style="width:100%;" />
        </p>
        <?php
    }
}

?>