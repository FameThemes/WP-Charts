=== WordPress Charts ===
Contributors: pushplaybang
Tags: chart, charts, charting, graph, graphs, graphing, visualisation, visualise data, visualization, visualize data, HTML5, canvas, pie chart, line chart, chart js, plugin, widget, shortcode
Requires at least: 4.0
Tested up to: 4.4
Stable tag: 0.7.0
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Create amazing HTML5 charts easily in WordPress. A flexible and lightweight WordPress chart plugin including 6 customizable chart types.

== Description ==

Create amazing HTML5 charts easily in WordPress. A flexible and lightweight WordPress chart plugin including 6 customizable chart types (line, bar, pie, radar, polar area and doughnut types) as well as a fallback to provide support for older IE.

Incorporates the fantastic chart.js script : [http://www.chartjs.org/](http://www.chartjs.org/) created by Nivk Downie.

### 6 Chart types ###
Visualise your data in different ways. Each of them animated, fully customisable and look great, even on retina displays.

### HTML5 Based ###
Chart.js uses the HTML5 canvas element. It supports all modern browsers, and polyfills provide support for IE7/8.

### Simple and Flexible ###
Chart.js is dependency free, lightweight (4.5k when minified and gzipped) and offers loads of customisation options.

(above descriptions taken from chartjs.org)

### New WP Charts Widget ###

Brand new WP Charts Widget, basic options for now, more on there way.

### Latest Fix / Patch ###
* Proportions Proerty now works (and works responsively), an example as been added to the installation section.
* The Widget is now working

### Features Coming Soon ###
* Chart Key tables, next big change up!
* Additional Widget Options.
* Editor admin pop up to make creating beautiful charts faster than you can say "user friendly"
* Color palette themes for quick stylish data
* Plugin Options for extensive chart control by setting your own sensible defaults (just for you fiddly folk)

== Installation ==

### Easy ###
1. Search WP charts via plugins > add new.
2. Find the plugin listed and click activate.
3. Use the Shortcodes and widget for fun and profit

### Not So Easy ###
1. Fire up your favourite FTP and upload `wp_charts folder` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. For Now  - Use the Shortcodes for fun and profit

# Usage #

### Basic Concept ###
the basic shortcode is `[wp_charts]` which on its own should not produce anything. you will need to add properities to the shotcode for it to work.  The format for shortcode properties is `property="somthing"`.  for example, each chart needs a title and a type, so we would start by putting the following into the wordpress editor : `[wp_charts title="any title" type="pie"]`.  Different Charts require different specific basic properties, as described below.  Further you can see a full list of properties with descriptions as well.

### Use Shortcode ###
Quick access to chart type and shortcode by going to Media -> WP Charts

### Important ###
* Every chart reuqires a type, title and data or datasets attributes.
* if you're using a Pie, Doughnut, or PolarArea chart type you must use the data shortcode attribute (as these are 1 dimensional charts), where as if you're using the Bar, Line or Radar chart types you must use the datasets attribute (as these types are multidimentional).  Also note that datasets are seperated using the next keyword as shown in the examples below.

# Example Shortcode Usage #

	Pie Chart
	[wp_charts title="mypie" type="pie" align="alignright" margin="5px 20px" data="10,32,50,25,5"]

	Doughnut Chart

	[wp_charts title="mydough" type="doughnut" align="alignleft" margin="5px 20px" data="30,10,55,25,15,8" colors="69D2E7,#E0E4CC,#F38630,#96CE7F,#CEBC17,#CE4264"]

	Polar Area Chart

	[wp_charts title="mypolar" type="polarArea" align="alignright" margin="5px 20px" data="40,32,5,25,50,45" labels="one,two,three,four,five,six"]

	Bar Chart

	[wp_charts title="barchart" type="bar" align="alignleft" margin="5px 20px" datasets="40,32,50,35 next 20,25,45,42 next 40,43, 61,50 next 33,15,40,22" labels="one,two,three,four"]

	Line Chart

	[wp_charts title="linechart" type="line" align="alignright" margin="5px 20px" datasets="40,43,61,50 next 33,15,40,22" labels="one,two,three,four"]

	Radar Chart

	[wp_charts title="radarchart" type="radar" align="alignleft" margin="5px 20px" datasets="20,22,40,25,55 next 15,20,30,40,35" labels="one,two,three,four,five" colors="#CEBC17,#CE4264"]


# All Shortcode Attributes #

	'type'             = "pie"
	choose from pie, doughnut, radar, polararea, bar, line

	'title'            = "chartname"
	each chart requires a uniqe title. (note that the title should be unique on the page if you are using multiple charts on the same page)

	'width'			   = "45%"
	optional - This sets the width of the container for the chart, and should be the only size property you need to adjust.  Setting it as a % value will make the chart fluid / responsive, you can use any valid CSS measurement of value (em, px, %).

	'height'		   = "auto"
	optional - the height will automatticaly be proportionate to the width, and you should not need to adjust this .

	'canvaswidth'      = "625"
	optional - this will be converted to px, only adjust this up or down if you experience rendering issues.

	'canvasheight'     = "625"
	optional - this will be converted to px, only adjust this up or down if you experience rendering issues.

	'margin'		   = "20px"
	optional - use standard css syntax for the margin, defaults to 5px for top, bottom, left and right.

	'align'            = "alignleft"
	optional - use one of the standard WordPress alignment classes alignleft, alignright, aligncenter.

	'class'			   = ""
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

	'animation'		   => 'true'
	optional -  turn the load animation for the charts on or off

	'scaleFontSize'    => '12'
	optional -  adjust the font size of the scale for the charts that display it

	'scaleFontColor'   => '#666'
	optional -  change the scale font colour

	'scaleOverride'    => 'false'
	optional -  by default this is turned off, and the script attempts to output an appropriate scale, setting this to true will require the following three properties to be set as well: scaleSteps, scaleStepWidth and scaleStartValue

	'scaleSteps' 	   => 'null'
	optional -  only applicable if scaleOveride is set to true - the number of steps in the scale

	'scaleStepWidth'   => 'null'
	optional -  only applicable if scaleOveride is set to true - the value jump used in the scale

	'scaleStartValue'  => 'null'
	optional -  only applicable if scaleOveride is set to true - the center starting value for the scale

	Example Usage with scale options
	[wp_charts title="linechart" type="line" align="alignright" margin="5px 20px" datasets="40,43,61,50 next 33,15,40,22" labels="one,two,three,four" scaleoverride="true" scalesteps="5" scalestepwidth="10" scalestartvalue="0"]


### Non Symmetrical Charts ###

To create responsive non symmetrical charts you will need to set the width, height, canvaswidth, canvasheight and relativewidth properties for the shorcode.  The relativewidth propertty is the relationship between the heigth adn width, in the following example we have a chart that is twice as wide as it is high.

    [wp_charts title="linechart" type="line" align="alignleft" margin="5px 20px" datasets="40,43,61,50,20,40,20 next 33,15,40,32,38,57,46" labels="one,two,three,four,five,six,seven" scaleoverride="true" scalesteps="8" scalestepwidth="10" scalestartvalue="0" scaleFontSize="16" canvaswidth="920px" canvasheight="460px" relativewidth="2" width="920px" height="460px"]

### WP Charts Widget  ###

head on over the 'widgets' page in wp admin area (listed under the Appearance menu) and look for the WP Charts widget, the widget is pretty self explanatory and only includes the basic options for now, check the properties above if your not quite sure what each field should be used for.

== Frequently Asked Questions ==

= Are Shortcodes Really User Friendly? =

Short Answer : NO.  But an easy to use admin interface for WP Charts will eventually be realised. Along with many features to help you quickly produce amazing charts.  In the mean time copy and paste the demo shortcodes and edit them carefully, while they can seem a little difficult they're actually still pretty simple to understand and use.  Its best to paste the shortcode into the html/text editor rather than the visual editor.

= How do you use the new scale properties? =

Its quite easy actually, have a look at the example shortcode below :

	[wp_charts title="linechart" type="line" align="alignright" margin="5px 20px" datasets="40,43,61,50 next 33,15,40,22" labels="one,two,three,four" scaleoverride="true" scalesteps="5" scalestepwidth="10" scalestartvalue="0"]

= canvas Height ? width ? canvas width ? responsive charts ? whats going on ? =

The canvas height and width properties set the actual canvas drawing area (for example if you're displaying a huge chart set these values higher to avoid aliasing / poor rendering), the height and width properties set the chart container height and width, and I use CSS and JS to set the canvas to 100%, measure the width and set the height to an equal value.  This makes it possible to have these charts responsive.  Note that in order to create non symmetrical charts you will need to set all of these properties as well as the relativewidth property in the shortcode, there is an example at the end of the installation section.

= Are you still going to eat that ? =

Not since you poked it with your fat sticky finger, but I will eat this here elephant one bite at a time.

== Screenshots ==

1. All Charts being used on a single page, in the default 2012 theme.
2. An example non symmetrical chart

== Changelog ==
0.7.0
* Add WP Charts Menu: Media -> WP Charts to quick access to chart shortcodes
* Planned to add charts as a Post Type which will be easy to edit and insert into content.
* Add WP Charts docs page.
* Fix issue for WordPress 4.4.2.

0.6.9 - Fixes
* Relative width and proportions now work correctly, see the end of the installation section for an example.
* Widget is now working.

0.6.8  - hotfix
* for missing script closing tag that killed sites in IE8 - sorry
* experimental proportions feature for non square responsive charts, use ````relativewidth```` property (ratio of width to height - for square charts the default value is 1, 1.5 would result in a chart 1.5 times as wide as the chart is high)

0.6.7 - Fix for new shortcode properties - bad camel case formatting sorted out - readme.txt update

0.6.6 - Proper update of all features.

0.6.5 - Added js fix for IE stretching charts, with more robust responsiveness - broken release becuase I failed hard at SVN.

0.6.0 - Added first extended options to the shortcode including animation on/off, scale font size, scale font colour, scale overirde with custom scale settings.  Secondly added a basic WP Charts Widget.

0.5.1 - Readme.txt update and assets update

0.4 - First stable release.

== Upgrade Notice ==

Come on Keep up. WordPress Charts is going places.  squashing bugs! bugs bugs bugs!!
