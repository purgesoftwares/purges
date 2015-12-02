<?php
function circleflip_contentpost($atts,$content = null){
	return '<p class="contentpostSC">'.do_shortcode($content).'</p>';		
}
add_shortcode("contentpost", "circleflip_contentpost");
?>