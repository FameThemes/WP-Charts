
jQuery(document).ready(function($) {
    // new Chart(document.getElementById("mypie").getContext("2d")).Pie(mypieData,mypieOps);

    window.wp_charts = window.wp_charts || {};
    window.wp_charts_init = window.wp_charts_init || {};
    $.each(window.wp_charts, function( index, value ) {
        switch ( value.type ) {
            case 'Doughnut':
                window.wp_charts_init[ index ] = new Chart(document.getElementById( index ).getContext("2d")).Doughnut( value.data, value.options );
                break;
            case 'PolarArea':
                window.wp_charts_init[ index ] = new Chart(document.getElementById( index ).getContext("2d")).PolarArea( value.data, value.options );
                break;
            case 'Bar':
                window.wp_charts_init[ index ] = new Chart(document.getElementById( index ).getContext("2d")).Bar( value.data, value.options );
                break;
            case 'Line':
                window.wp_charts_init[ index ] = new Chart(document.getElementById( index ).getContext("2d")).Line( value.data, value.options );
                break;
            case 'Radar':
                window.wp_charts_init[ index ] = new Chart(document.getElementById( index ).getContext("2d")).Radar( value.data, value.options );
                break;
            default :
                window.wp_charts_init[ index ] = new Chart(document.getElementById( index ).getContext("2d")).Pie( value.data, value.options );
        }
    });

	// SmartResise
	!function(a,b){var c=function(a,b,c){var d;return function(){function g(){c||a.apply(e,f),d=null}var e=this,f=arguments;d?clearTimeout(d):c&&a.apply(e,f),d=setTimeout(g,b||100)}};jQuery.fn[b]=function(a){return a?this.bind("resize",c(a)):this.trigger(b)}}(jQuery,"smartresize");

	// set Height to width.
	function reSize(selector) {
		$(selector).each(function() {
			var current    = $(this);
			var proportion = current.data('proportion');
			var thisWidth  = current.outerWidth();
			current.css( 'height', (thisWidth / proportion) );
			current.parent().css( 'height', (thisWidth / proportion) );
		});
	}

	// call on load
	reSize('.wp_charts_canvas');

	// Call on debounced resize event
	$(window).smartresize(function() {
		reSize('.wp_charts_canvas');
	});

});