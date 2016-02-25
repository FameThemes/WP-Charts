<?php

/**
 * Class wp_charts_widget
 *
 * @since Unknown
 */
class WP_Charts_Widget extends WP_Widget {

    /**
     * constructor
     */
    function __construct() {
        parent::__construct( false, $name = 'WordPress Charts' );
    }

    /**
     * Output the Widget
     *
     * @param array $args
     * @param array $instance
     */
    function widget($args, $instance) {
        extract( $args );
        // global $posttypes;
        $title          = isset($instance['title']) ? apply_filters('widget_title', $instance['title']) : "";
        $chartid        = $instance['chartid'];
        $pretext        = isset($instance['pretext'] ) ? apply_filters('widget_title', $instance['pretext']) : "";
        $chart_type     = $instance['chart_type'];
        $labels         = $instance['labels'];
        $data           = $instance['data'];
        $colors    		  = $instance['colors'];
        $posttext       = isset($instance['posttext'] ) ? apply_filters('widget_title', $instance['posttext']) : "";

        // start widget
        echo $before_widget;

        // output the title
        if ( $title != "" ) {
            echo $before_title . $title . $after_title;
        }

        // output chart intro
        if ( !empty($pretext)) {
            echo wpautop($pretext);
        }

        // output the Chart
        echo do_shortcode(
            "[wp_charts
					title  = '$chartid'
					labels = '$labels'
					type   = '$chart_type'
					data   = '$data'
					colors = '$colors'
					width = '100%'
				]"
        );

        // output Chart Description
        if ( !empty($posttext)) {
            echo wpautop($posttext);
        }

        // end wdget
        echo $after_widget;

    }

    /**
     * Update the Widget
     *
     * @param array $new_instance
     * @param array $old_instance
     * @return array
     */
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = ($new_instance['title']);
        $instance['chartid'] = ($new_instance['chartid']);
        $instance['pretext']        = strip_tags($new_instance['pretext']);
        $instance['chart_type'] = ($new_instance['chart_type']);
        $instance['labels'] = ($new_instance['labels']);
        $instance['data'] = ($new_instance['data']);
        $instance['colors'] = ($new_instance['colors']);
        $instance['posttext']        = strip_tags($new_instance['posttext']);
        return $instance;
    }

    /**
     * Widget Form
     *
     * @param array $instance
     */
    function form($instance) {
        $title          = isset( $instance['title'] ) 		? esc_attr($instance['title']) 			: "";
        $pretext        = isset( $instance['pretext'] ) 	? esc_attr($instance['pretext']) 		: "";
        $chartid        = isset( $instance['chartid'] ) 	? esc_attr($instance['chartid']) 		: "";
        $chart_type     = isset( $instance['chart_type'] ) 	? esc_attr($instance['chart_type'])		: "";
        $labels         = isset( $instance['labels'] ) 		? esc_attr($instance['labels']) 		: "";
        $data           = isset( $instance['data'] ) 		? esc_attr($instance['data']) 			: "";
        $colors         = isset( $instance['colors'] ) 		? esc_attr($instance['colors']) 		: "";
        $posttext       = isset( $instance['posttext'] ) 	? esc_attr($instance['posttext']) 		: "";

        ?>
        <!-- Widget title -->
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title:', 'nona'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>

        <!-- Chart ID -->
        <p>
            <label for="<?php echo $this->get_field_id('chartid'); ?>"><?php _e('Chart Title:', 'nona'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('chartid'); ?>" name="<?php echo $this->get_field_name('chartid'); ?>" type="text" value="<?php echo $chartid; ?>" />
            <small><strong>IMPORTANT!</strong> Your Chart must have a unique title to be indentified by, this title <strong>WILL NOT</strong> be displayed.</small>
        </p>

        <!-- PreText -->
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Introduction:', 'nona'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('pretext'); ?>" name="<?php echo $this->get_field_name('pretext'); ?>" type="text" value="<?php echo $pretext; ?>" />
        </p>

        <!-- type -->
        <p>
            <label for="<?php echo $this->get_field_id('chart_type'); ?>"><?php _e('Type', 'nona'); ?></label>
            <select name="<?php echo $this->get_field_name('chart_type'); ?>" id="<?php echo $this->get_field_id('chart_type'); ?>" class="widefat">
                <?php
                $options = array('Pie', 'Doughnut', 'Radar', 'line', 'Bar', 'PolarArea');
                foreach ($options as $option) {
                    echo '<option value="' . $option . '" id="' . $option . '"', $chart_type == $option ? ' selected="selected"' : '', '>', $option, '</option>';
                }
                ?>
            </select>
        </p>
        <!-- labels -->
        <p>
            <label for="<?php echo $this->get_field_id('labels'); ?>"><?php _e('Labels, separated by commas:', 'nona'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('labels'); ?>" name="<?php echo $this->get_field_name('labels'); ?>" type="text" value="<?php echo $labels; ?>" />
        </p>

        <!-- data & datasets -->
        <p>
            <label for="<?php echo $this->get_field_id('data'); ?>"><?php _e('Data or Datasets', 'nona'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('data'); ?>" name="<?php echo $this->get_field_name('data'); ?>" type="text" value="<?php echo $data; ?>" />
            <small>If you're using the <strong><em>bar, line</em></strong> or <strong><em>radar</em></strong> chart type, you must write your comparative datasets divided by the <strong><em>next</em></strong> keyword eg: 0,0,0 next 0,0,0 etc.</small>
        </p>

        <!-- Custom Colors -->
        <p>
            <label for="<?php echo $this->get_field_id('colors'); ?>"><?php _e('Colors, separated by commas:', 'nona'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('colors'); ?>" name="<?php echo $this->get_field_name('colors'); ?>" type="text" value="<?php echo $colors; ?>" />
        </p>
        <!-- Post Text -->
        <p>
            <label for="<?php echo $this->get_field_id('posttext'); ?>"><?php _e('Chart Description:', 'nona'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('posttext'); ?>" name="<?php echo $this->get_field_name('posttext'); ?>" type="text" value="<?php echo $posttext; ?>" />
        </p>

    <?php } // End Form Function

} // End Class wp_charts_widget

add_action('widgets_init', create_function('', 'return register_widget("WP_Charts_Widget");'));
