<?php
function wp_charts_add_settings_link( $links ) {
    $settings_link = '<a href="'.admin_url( 'upload.php?page=wp-charts' ).'">' . __( 'Docs', 'nona' ) . '</a>';
    array_push( $links, $settings_link );
    return $links;
}
add_filter( "plugin_action_links_".WP_CHARTS_BASENAME, 'wp_charts_add_settings_link' );


add_action('admin_menu', 'wp_charts_register_submenu_page');

function wp_charts_register_submenu_page() {
    add_submenu_page(
        'upload.php',
        esc_html__( 'WP Charts', 'nona' ),
        esc_html__( 'WP Charts', 'nona' ),
        'upload_files',
        'wp-charts',
        'wp_chart_submenu_page_callback' );
}

function wp_chart_submenu_page_callback() {

    wp_charts_load_scripts( true );

    $doc_boxes =  array(
        array(
            'title' => __( 'Pie Chart', 'nona' ),
            'shortcode' => __( '[wp_charts title="mypie" type="pie" align="alignright" margin="5px 20px" data="10,32,50,25,5"]', 'nona' ),
            'content' => __( '[wp_charts title="mypie" type="pie" align="alignright" margin="5px 20px" data="10,32,50,25,5"]', 'nona' ),
        ),
        array(
            'title' => __( 'Doughnut Chart', 'nona' ),
            'shortcode' => __( '[wp_charts title="mydough" type="doughnut" align="alignleft" margin="5px 20px" data="30,10,55,25,15,8" colors="69D2E7,#E0E4CC,#F38630,#96CE7F,#CEBC17,#CE4264"]', 'nona' ),
            'content' => __( '[wp_charts title="mydough" type="doughnut" align="alignleft" margin="5px 20px" data="30,10,55,25,15,8" colors="69D2E7,#E0E4CC,#F38630,#96CE7F,#CEBC17,#CE4264"]', 'nona' ),
        ),
        array(
            'title' => __( 'Polar Area Chart', 'nona' ),
            'shortcode' => __( '[wp_charts title="mypolar" type="polarArea" align="alignright" margin="5px 20px" data="40,32,5,25,50,45" labels="one,two,three,four,five,six"]', 'nona' ),
            'content' => __( '[wp_charts title="mypolar" type="polarArea" align="alignright" margin="5px 20px" data="40,32,5,25,50,45" labels="one,two,three,four,five,six"]', 'nona' ),
        ),
        array(
            'title' => __( 'Bar Chart', 'nona' ),
            'shortcode' => __( '[wp_charts title="barchart" type="bar" align="alignleft" margin="5px 20px" datasets="40,32,50,35 next 20,25,45,42 next 40,43, 61,50 next 33,15,40,22" labels="one,two,three,four"]', 'nona' ),
            'content' => __( '[wp_charts title="barchart" type="bar" align="alignleft" margin="5px 20px" datasets="40,32,50,35 next 20,25,45,42 next 40,43, 61,50 next 33,15,40,22" labels="one,two,three,four"]', 'nona' ),
        ),

        array(
            'title' => __( 'Line Chart', 'nona' ),
            'shortcode' => __( '[wp_charts title="linechart" type="line" align="alignright" margin="5px 20px" datasets="40,43,61,50 next 33,15,40,22" labels="one,two,three,four"]', 'nona' ),
            'content' => __( '[wp_charts title="linechart" type="line" align="alignright" margin="5px 20px" datasets="40,43,61,50 next 33,15,40,22" labels="one,two,three,four"]', 'nona' ),
        ),
        array(
            'title' => __( 'Radar Chart', 'nona' ),
            'shortcode' => __( '[wp_charts title="radarchart" type="radar" align="alignleft" margin="5px 20px" datasets="20,22,40,25,55 next 15,20,30,40,35" labels="one,two,three,four,five" colors="#CEBC17,#CE4264"]', 'nona' ),
            'content' => __( '[wp_charts title="radarchart" type="radar" align="alignleft" margin="5px 20px" datasets="20,22,40,25,55 next 15,20,30,40,35" labels="one,two,three,four,five" colors="#CEBC17,#CE4264"]', 'nona' ),
        ),
    );

    ?>
    <style type="text/css">
        /*wp_charts_js responsive canvas CSS override*/
        .wp_charts_canvas {
            width:100%!important;
            max-width:100%;
        }
        .postbox {
            width: 100%;
            display: block;
        }
        .postbox .inside {
            overflow: hidden;
            width: 100%;
            display: block;
            box-sizing: border-box;
        }

        .postbox .inside  .alignleft,
        .postbox .inside  .alignright{
            float: none;
            box-sizing: border-box;
        }
        .postbox .inside:after {
            clear: both;
            display: block;
            content: " ";
        }
        .chart-inside {
            box-sizing: border-box;
        }
        .shortcode {
            white-space: pre-wrap;       /* css-3 */
            white-space: -moz-pre-wrap;  /* Mozilla, since 1999 */
            white-space: -pre-wrap;      /* Opera 4-6 */
            white-space: -o-pre-wrap;    /* Opera 7 */
            word-wrap: break-word;       /* Internet Explorer 5.5+ */
            display: block;
            background: #F1F1F1;
            padding: 5px;
        }
        .wp-chart-box {
            max-width: 500px;
            box-sizing: border-box;
        }
        .wp-chart-wrap {

            width:100%!important;
        }
        div.wp-chart-wrap {
            box-sizing: border-box;
            width:100%!important;
            float: none!important;
            margin-left: auto!important;
            margin-right: auto!important;
        }
    </style>
    <div class="wrap">
        <h1><?php _e( 'WP Charts', 'nona' ); ?></h1>
        <div id="poststuff">

            <div class="postbox-container meta-box-sortables">
                <?php foreach ( $doc_boxes as $box ){ ?>
                <div class="wp-chart-box postbox closed">
                    <button aria-expanded="false" class="handlediv button-link" type="button">
                        <span class="screen-reader-text"><?php printf( __( 'Toggle panel: %s', 'nona' ), $box['title'] ); ?></span>
                        <span aria-hidden="true" class="toggle-indicator"></span>
                    </button>
                    <h2 class="hndle ui-sortable-handle"><span><?php echo esc_html( $box['title'] ); ?></span></h2>
                    <div class="inside">
                        <div class="chart-inside"><?php echo do_shortcode( wp_kses_post( $box['shortcode'] ) ); ?></div>
                        <pre class="shortcode"><?php echo wp_kses_post( $box['content'] ); ?></pre>
                    </div>
                </div>
                <?php } ?>
            </div>


        </div>
    </div>

    <script type="text/javascript">
        jQuery( document).ready( function( $ ){
            $( '.wp-chart-box').each( function(){
                var box = $( this );
                //box.addClass('closed');
                box.on( 'click', '.handle, .handlediv', function( e ) {
                    e.preventDefault();
                    box.toggleClass('closed');
                    $( window ).resize();
                } );
            } );

        } );
    </script>

    <?php
}