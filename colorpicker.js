
jQuery(document).ready(function($) {

	var myOptions = {
		// You can declare a default color here,
		// or in the data-default-color attribute on the input
		defaultColor: false,
		// A callback to fire whenever the color changes to a valid color
		change: function(event, ui) {
			$('#colorpicker').val(ui.color.toString());
		},
		// A callback to fire when the input is emptied or an invalid color
		clear: function() {},
		// Hide the color picker controls on load
		hide: true,
		// Show a group of common colors beneath the square
		// or, supply an array of colors to customize further
		palettes: true
	};
	$('#colorpicker').wpColorPicker(myOptions);
	
});