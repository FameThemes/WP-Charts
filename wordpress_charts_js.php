<?php
/*
Plugin Name: WordPress Charts
Plugin URI: http://wordpress.org/plugins/wp-charts/
Description: Create amazing HTML5 charts easily in WordPress. A flexible and lightweight WordPress chart plugin including 6 customizable chart types (line, bar, pie, radar, polar area and doughnut types) as well as a fallback to provide support for older IE.  Incorporates the fantastic chart.js script : http://www.chartjs.org/.
Version: 0.7.0.0
Author:  Paul van Zyl
Author URI: http://profiles.wordpress.org/pushplaybang/
*/

/**
 * Copyright (c) 2013 Paul van Zyl. All rights reserved.
 *
 * Released under the GPLv2 license
 * http://www.gnu.org/licenses/gpl-2.0.html
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * **********************************************************************
 *
 *
 */

define( 'WP_CHARTS_URL',  trailingslashit( plugins_url('', __FILE__) ));
define( 'WP_CHARTS_PATH', trailingslashit( plugin_dir_path( __FILE__) ) );
define( 'WP_CHARTS_BASENAME', plugin_basename( __FILE__) );

include WP_CHARTS_PATH.'inc/charts-widget.php';
if ( is_admin() ) {
    include WP_CHARTS_PATH.'inc/admin/admin.php';
}



/**
 * Add IE Fallback for HTML5 and canvas
 * @since Unknown
 */
function wp_charts_html5_support () {
    echo '<!--[if lte IE 8]>';
    echo '<script src="'.plugins_url( '/js/excanvas.compiled.js', __FILE__ ).'"></script>';
    echo '<![endif]-->';
    echo '	<style>
    			/*wp_charts_js responsive canvas CSS override*/
    			.wp_charts_canvas {
    				width:100%!important;
    				max-width:100%;
    			}

    			@media screen and (max-width:480px) {
    				div.wp-chart-wrap {
    					width:100%!important;
    					float: none!important;
						margin-left: auto!important;
						margin-right: auto!important;
						text-align: center;
    				}
    			}
    		</style>';
}

/**
 * Register Script
 *
 * @since Unknown
 */
function wp_charts_load_scripts( $force =  false ) {

	if ( ! is_admin() || $force ) {
		// WP Scripts
		wp_enqueue_script( 'jquery' );

		// Register plugin Scripts
		wp_register_script( 'charts-js', WP_CHARTS_URL.'js/Chart.min.js' );
		wp_register_script( 'wp-chart-functions', WP_CHARTS_URL.'/js/functions.js', array( 'jquery' ) ,'', true );

		// Enqueue those suckers
		wp_enqueue_script( 'charts-js' );
		wp_enqueue_script( 'wp-chart-functions' );
	}

}

if ( !function_exists('wp_charts_compare_fill') ) {
    /**
     * Make sure there are the right number of colors in the colour array
     * @since Unknown
     *
     * @param $measure
     * @param $fill
     */
	function wp_charts_compare_fill(&$measure,&$fill) {
		// only if the two arrays don't hold the same number of elements
		if (count($measure) != count($fill)) {
		    // handle if $fill is less than $measure
		    while (count($fill) < count($measure) ) {
		        $fill = array_merge( $fill, array_values($fill) );
		    }
		    // handle if $fill has more than $measure
		    $fill = array_slice($fill, 0, count($measure));
		}
	}
}


if (!function_exists( "wp_charts_hex2rgb" )) {
    /**
     * Color conversion function
     *
     * @since Unknown
     * @param $hex
     * @return string
     */
	function wp_charts_hex2rgb($hex) {
	   $hex = str_replace("#", "", $hex);

	   if(strlen($hex) == 3) {
	      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
	      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
	      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
	   } else {
	      $r = hexdec(substr($hex,0,2));
	      $g = hexdec(substr($hex,2,2));
	      $b = hexdec(substr($hex,4,2));
	   }

	   $rgb = array($r, $g, $b);
	   return implode(",", $rgb); // returns the rgb values separated by commas
	}
}


if (!function_exists('wp_charts_trailing_comma')) {
    /**
     * wp_charts_trailing_comma
     *
     * @param $incrementor
     * @param $count
     * @param $subject
     * @return string
     */
	function wp_charts_trailing_comma($incrementor, $count, &$subject) {
		$stopper = $count - 1;
		if ($incrementor !== $stopper) {
			return $subject .= ',';
		}
	}
}

/**
 * Chart Shortcode 1 - Core Shortcode with all options
 *
 * @param $atts
 * @return string
 */
function wp_charts_shortcode( $atts ) {

    // Default Attributes
    // - - - - - - - - - - - - - - - - - - - - - - -
    extract( shortcode_atts(
            array(
                'type'             => 'pie',
                'title'            => 'chart',
                'canvaswidth'      => '625',
                'canvasheight'     => '625',
                'width'			   => '48%',
                'height'		   => 'auto',
                'margin'		   => '5px',
                'relativewidth'	   => '1',
                'align'            => '',
                'class'			   => '',
                'labels'           => '',
                'data'             => '30,50,100',
                'datasets'         => '30,50,100 next 20,90,75',
                'colors'           => '#69D2E7,#E0E4CC,#F38630,#96CE7F,#CEBC17,#CE4264',
                'fillopacity'      => '0.7',
                'pointstrokecolor' => '#FFFFFF',
                'animation'		   => 'true',
                'scalefontsize'    => '12',
                'scalefontcolor'   => '#666',
                'scaleoverride'    => 'false',
                'scalesteps' 	   => 'null',
                'scalestepwidth'   => 'null',
                'scalestartvalue'  => 'null'
            ), $atts )
    );

    // prepare data
    // - - - - - - - - - - - - - - - - - - - - - - -
    $title    = str_replace(' ', '', $title);
    $data     = explode(',', str_replace(' ', '', $data));
    $datasets = explode("next", str_replace(' ', '', $datasets));

    if ( ! $title || ( empty( $data ) && empty( $datasets ) ) ) {
        return '';
    }

    // check that the colors are not an empty string
    if ($colors != "") {
        $colors   = explode(',', str_replace(' ','',$colors));
    } else {
        $colors = array('#69D2E7','#E0E4CC','#F38630','#96CE7F','#CEBC17','#CE4264');
    }

    (strpos($type, 'lar') !== false ) ? $type = 'PolarArea' : $type = ucwords($type);

    // output - covers Pie, Doughnut, and PolarArea
    // - - - - - - - - - - - - - - - - - - - - - - -
    $currentchart = '<div class="'.$align.' '.$class.' wp-chart-wrap" style="max-width: 100%; width:'.$width.'; height:'.$height.';margin:'.$margin.';" data-proportion="'.$relativewidth.'">';
    $currentchart .= '<canvas id="'.$title.'" height="'.$canvasheight.'" width="'.$canvaswidth.'" class="wp_charts_canvas" data-proportion="'.$relativewidth.'"></canvas></div>
	<script type="text/javascript">';

    // output Options
    $currentchart .= 'var '.$title.'Ops = {
		animation: '.$animation.',';

    if ($type == 'Line' || $type == 'Radar' || $type == 'Bar' || $type == 'PolarArea') {
        $currentchart .=	'scaleFontSize: '.$scalefontsize.',';
        $currentchart .=	'scaleFontColor: "'.$scalefontcolor.'",';
        $currentchart .=    'scaleOverride:'   .$scaleoverride.',';
        $currentchart .=    'scaleSteps:' 	   .$scalesteps.',';
        $currentchart .=    'scaleStepWidth:'  .$scalestepwidth.',';
        $currentchart .=    'scaleStartValue:' .$scalestartvalue;
    }

    // end options array
    $currentchart .= '}; ';

    // start the js arrays correctly depending on type
    if ($type == 'Line' || $type == 'Radar' || $type == 'Bar' ) {

        wp_charts_compare_fill($datasets, $colors);
        $total    = count($datasets);

        // output labels
        $currentchart .= 'var '.$title.'Data = {';
        $currentchart .= 'labels : [';
        $labelstrings = explode(',',$labels);
        for ($j = 0; $j < count($labelstrings); $j++ ) {
            $currentchart .= '"'.$labelstrings[$j].'"';
            wp_charts_trailing_comma($j, count($labelstrings), $currentchart);
        }
        $currentchart .= 	'],';
        $currentchart .= 'datasets : [';
    } else {
        wp_charts_compare_fill($data, $colors);
        $total = count($data);
        $currentchart .= 'var '.$title.'Data = [';
    }

    // create the javascript array of data and attr correctly depending on type
    for ($i = 0; $i < $total; $i++) {

        if ($type === 'Pie' || $type === 'Doughnut' || $type === 'PolarArea') {
            $currentchart .= '{
					value 	: '. $data[$i] .',
					color 	: '.'"'. $colors[$i].'"'.'
				}';

        } else if ($type === 'Bar') {
            $currentchart .= '{
					fillColor 	: "rgba('. wp_charts_hex2rgb( $colors[$i] ) .','.$fillopacity.')",
					strokeColor : "rgba('. wp_charts_hex2rgb( $colors[$i] ) .',1)",
					data 		: ['.$datasets[$i].']
				}';

        } else if ($type === 'Line' || $type === 'Radar') {
            $currentchart .= '{
					fillColor 	: "rgba('. wp_charts_hex2rgb( $colors[$i] ) .','.$fillopacity.')",
					strokeColor : "rgba('. wp_charts_hex2rgb( $colors[$i] ) .',1)",
					pointColor 	: "rgba('. wp_charts_hex2rgb( $colors[$i] ) .',1)",
					pointStrokeColor : "'.$pointstrokecolor.'",
					data 		: ['.$datasets[$i].']
				}';

        }  // end type conditional
        wp_charts_trailing_comma($i, $total, $currentchart);
    }

    // end the js arrays correctly depending on type
    if ($type == 'Line' || $type == 'Radar' || $type == 'Bar') {
        $currentchart .=	']};';
    } else {
        $currentchart .=	'];';
    }

    //var wpChart'.$title.$type.' = new Chart(document.getElementById("'.$title.'").getContext("2d")).'.$type.'('.$title.'Data,'.$title.'Ops);

    $currentchart .= '
         window.wp_charts = window.wp_charts || {};
	     window.wp_charts["'.$title.'"] = { options: '.$title.'Ops, data: '.$title.'Data, type: "'.$type.'" };

	</script>';

    // return the final result
    // - - - - - - - - - - - - - - - - - - - - - - -
    return $currentchart;
}

/**
 * wp_charts_kickoff
 *
 * @since Unknown
 */
function wp_charts_kickoff() {
	add_action( "wp_enqueue_scripts", "wp_charts_load_scripts" );
	add_action('wp_head', 'wp_charts_html5_support');
	add_shortcode( 'wp_charts', 'wp_charts_shortcode' );
}

add_action('init', 'wp_charts_kickoff');

