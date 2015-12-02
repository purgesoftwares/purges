jQuery(document).ready(function($){
	$("#carousel_related").carouFredSel({
		height:"auto",
		items: {
			visible: {
				min: 1,
				max: 4
			}
		},
		width: "variable",
		scroll: 1,
		prev: {
			button: "#Prev",
			key: "left"
		},
		next: {
			button: "#Next",
			key: "right"
		},
		responsive: true,
		auto:false,
	});
});