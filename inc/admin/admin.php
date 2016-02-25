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
            background: #ffffff;
            padding: 5px;
        }
        .inside .shortcode{
            background: #F1F1F1;
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
            <h3><?php _e( 'Example Shortcode Usage', 'nona' ); ?></h3>
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


            <div class="postbox-container meta-box-sortables">
                <h3><?php _e( 'All Shortcode Attributes', 'nona' ); ?></h3>

<pre class="shortcode">'type'             = "pie"
choose from pie, doughnut, radar, polararea, bar, line

'title'            = "chartname"
each chart requires a uniqe title. (note that the title should be unique on the page if you are using multiple charts on the same page)

'width'            = "45%"
optional - This sets the width of the container for the chart, and should be the only size property you need to adjust.  Setting it as a % value will make the chart fluid / responsive, you can use any valid CSS measurement of value (em, px, %).

'height'           = "auto"
optional - the height will automatticaly be proportionate to the width, and you should not need to adjust this .

'canvaswidth'      = "625"
optional - this will be converted to px, only adjust this up or down if you experience rendering issues.

'canvasheight'     = "625"
optional - this will be converted to px, only adjust this up or down if you experience rendering issues.

'margin'           = "20px"
optional - use standard css syntax for the margin, defaults to 5px for top, bottom, left and right.

'align'            = "alignleft"
optional - use one of the standard WordPress alignment classes alignleft, alignright, aligncenter.

'class'            = ""
optional - apply a css class to the chart container.

'labels'           = ""
Used for the bar, line and polararea charts.

'data'             = "30,50,100"
Used for the pie, doughnut and radar charts.

'datasets'         = "30,50,100 next 20,90,75"
Used for the bar, line, and radar charts,  the data for each 'set' is put in as before, but using the 'next' keyword to seperate each of the datasets.

'colors'           = "69D2E7,#E0E4CC,#F38630,#96CE7F,#CEBC17,#CE4264"
optional -  These should be put in in there HEX value only(as above). These are the default colors, there should be the same number of colours as data points, or datasets, but if you only got a few, or too many, don't worry the plugin will handle it.  (more practically if you don't want your chart to look like a rainbow, the plugin will cycle a set a colors for your data)

'fillopacity'      = "0.7"
optional -  for line, bar and polararea type charts you can set an opactiy for fill of the chart.

'pointstrokecolor' = "#FFFFFF"
optional -  for line and polararea type charts you can set the point color, though usually looks pretty good with the default.

'animation'        => 'true'
optional -  turn the load animation for the charts on or off

'scaleFontSize'    => '12'
optional -  adjust the font size of the scale for the charts that display it

'scaleFontColor'   => '#666'
optional -  change the scale font colour

'scaleOverride'    => 'false'
optional -  by default this is turned off, and the script attempts to output an appropriate scale, setting this to true will require the following three properties to be set as well: scaleSteps, scaleStepWidth and scaleStartValue

'scaleSteps'       => 'null'
optional -  only applicable if scaleOveride is set to true - the number of steps in the scale

'scaleStepWidth'   => 'null'
optional -  only applicable if scaleOveride is set to true - the value jump used in the scale

'scaleStartValue'  => 'null'
optional -  only applicable if scaleOveride is set to true - the center starting value for the scale

Example Usage with scale options
[wp_charts title="linechart" type="line" align="alignright" margin="5px 20px" datasets="40,43,61,50 next 33,15,40,22" labels="one,two,three,four" scaleoverride="true" scalesteps="5" scalestepwidth="10" scalestartvalue="0"]
                </pre>
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