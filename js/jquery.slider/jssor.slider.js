jssor_slider_init = function() {

	var jssor_1_SlideshowTransitions = [
		{$Duration:1200,$Opacity:2}
	];

	var options = {
		$AutoPlay: true,
		$DragOrientation: 3,
		$SlideshowOptions: {
			$Class: $JssorSlideshowRunner$,
			$Transitions: jssor_1_SlideshowTransitions,
			$TransitionsOrder: 1
		},
        $ArrowNavigatorOptions: {
			$Class: $JssorArrowNavigator$,
			$ChanceToShow: 2,
			$AutoCenter: 2,
			$Steps: 1
		}
	};

	var jssor_slider = new $JssorSlider$("_slider", options);
	function ScaleSlider() {
		var refSize = jssor_slider.$Elmt.parentNode.clientWidth;
		if (refSize) {
			refSize = Math.min(refSize, 3220);
			jssor_slider.$ScaleWidth(refSize);
		}
		else {
			window.setTimeout(ScaleSlider, 30);
		}
	}
	ScaleSlider();
	$Jssor$.$AddEvent(window, "load", ScaleSlider);
	$Jssor$.$AddEvent(window, "resize", ScaleSlider);
	$Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
};
