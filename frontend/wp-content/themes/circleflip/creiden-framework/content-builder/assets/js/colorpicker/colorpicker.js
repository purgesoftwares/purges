/**
 * plugin.min.js
 *
 * Copyright, Alberto Peripolli
 * Released under Creative Commons Attribution-NonCommercial 3.0 Unported License.
 *
 */
tinyMCE.PluginManager.add("colorpicker_cf", function(e) {
	function t() {
		e.focus(true);
		var t = "Color Picker";
		win = e.windowManager.open({
			title : t,
			file : global_creiden.template_dir + "/creiden-framework/content-builder/assets/js/colorpicker/index.html",
			width : 570,
			height : 240,
			inline : 1,
			resizable : true,
			maximizable : true
		});
	};
	e.addButton("colorpicker_cf", {
		image : global_creiden.template_dir + "/creiden-framework/content-builder/assets/js/colorpicker/color.png",
		tooltip : "Color Picker",
		onclick : t
	});
});