
jQuery(document).ready(function($) {

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