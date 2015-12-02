<?php
/**
 * @package Circle Flip
 * @author Creiden
 * @link http://creiden.com
 */

header("Content-type: text/css;");

$url = $_SERVER["SCRIPT_FILENAME"];
$strpos = strpos($url, 'wp-content');
$base = substr($url, 0, $strpos);
require_once $base . 'wp-load.php';
?>

/************************************************************************************************************************
***************************************************** Admin Styles ******************************************************
*************************************************************************************************************************/
<?php if(( $_GET['is_rtl'] == 1) ) { ?>
/************************************************************************************************************************
												 RTL Styles
*************************************************************************************************************************/
/************************************************************************************************************************
												 heading style
*************************************************************************************************************************/
h1 {
	<?php $optionValue = cr_get_option("rtl_h1",  array('size' => '24px', 'face' => 'sourceSans', 'style' => 'Normal', 'color' => '#2a2a2a', 'weight' => 'Normal'));?>
	font-size: <?php echo $optionValue['size'];?>;
	line-height: <?php echo intval($optionValue['size']) + 2;?>px;
	font-family: <?php echo $optionValue['face'];?>;
	font-weight: <?php echo $optionValue['weight'];?>;
	font-style: <?php echo $optionValue['style'];?>;
	color: <?php echo $optionValue['color'];?>;
}
h2 {
	<?php $optionValue = cr_get_option("rtl_h2",  array('size' => '22px', 'face' => 'sourceSans', 'style' => 'Normal', 'color' => '#2a2a2a', 'weight' => 'Normal'));?>
	font-size: <?php echo $optionValue['size'];?>;
	line-height: <?php echo intval($optionValue['size']) + 2;?>px;
	font-family: <?php echo $optionValue['face'];?>;
	font-weight: <?php echo $optionValue['weight'];?>;
	font-style: <?php echo $optionValue['style'];?>;
	color: <?php echo $optionValue['color'];?>;
}
h3 {
	<?php $optionValue = cr_get_option("rtl_h3",  array('size' => '20px', 'face' => 'sourceSans', 'style' => 'Normal', 'color' => '#2a2a2a', 'weight' => 'Normal'));?>
	font-size: <?php echo $optionValue['size'];?>;
	line-height: <?php echo intval($optionValue['size']) + 2;?>px;
	font-family: <?php echo $optionValue['face'];?>;
	font-weight: <?php echo $optionValue['weight'];?>;
	font-style: <?php echo $optionValue['style'];?>;
	color: <?php echo $optionValue['color'];?>;
}
h4 {
	<?php $optionValue = cr_get_option("rtl_h4",  array('size' => '18px', 'face' => 'sourceSans', 'style' => 'Normal', 'color' => '#2a2a2a', 'weight' => 'Normal'));?>
	font-size: <?php echo $optionValue['size'];?>;
	line-height: <?php echo intval($optionValue['size']) + 2;?>px;
	font-family: <?php echo $optionValue['face'];?>;
	font-weight: <?php echo $optionValue['weight'];?>;
	font-style: <?php echo $optionValue['style'];?>;
	color: <?php echo $optionValue['color'];?>;
}
h5 {
	<?php $optionValue = cr_get_option("rtl_h5",  array('size' => '16px', 'face' => 'sourceSans', 'style' => 'Normal', 'color' => '#2a2a2a', 'weight' => 'Normal'));?>
	font-size: <?php echo $optionValue['size'];?>;
	line-height: <?php echo intval($optionValue['size']) + 2;?>px;
	font-family: <?php echo $optionValue['face'];?>;
	font-weight: <?php echo $optionValue['weight'];?>;
	font-style: <?php echo $optionValue['style'];?>;
	color: <?php echo $optionValue['color'];?>;
}
h6 {
	<?php $optionValue = cr_get_option("rtl_h6",  array('size' => '14px', 'face' => 'sourceSans', 'style' => 'Normal', 'color' => '#2a2a2a', 'weight' => 'Normal'));?>
	font-size: <?php echo $optionValue['size'];?>;
	line-height: <?php echo intval($optionValue['size']) + 2;?>px;
	font-family: <?php echo $optionValue['face'];?>;
	font-weight: <?php echo $optionValue['weight'];?>;
	font-style: <?php echo $optionValue['style'];?>;
	color: <?php echo $optionValue['color'];?>;
}
.titleBlock h3,.titleBlock p{
	<?php $optionValue = cr_get_option("rtl_header_blocks",  array('size' => '22px', 'face' => 'SourceSansSemiBold', 'style' => 'Normal', 'color' => '#2a2a2a', 'weight' => 'Normal'));?>
	font-size: <?php echo $optionValue['size'];?>;
	line-height: <?php echo intval($optionValue['size']) + 2;?>px;
	font-family: <?php echo $optionValue['face'];?>;
	font-weight: <?php echo $optionValue['weight'];?>;
	font-style: <?php echo $optionValue['style'];?>;
	color: <?php echo $optionValue['color'];?>;
}
p, .squarePostText, .aq_block_tabs .aq-tab p, .offerText, .dropcapText, .dropcapLight, .textSlider .carousel-caption p, .contactDetailsSection ul li p, .masonryContent .excerpt, .postText li{
	<?php $optionValue = cr_get_option("rtl_paragraphs", array('size' => '13px', 'face' => 'sourceSans', 'style' => 'Normal', 'color' => '#5a5a5a', 'weight' => 'Normal'));?>
	font-size: <?php echo $optionValue['size'];?>;
	line-height: <?php echo intval($optionValue['size']) + 7;?>px;
	font-family: <?php echo $optionValue['face'];?>;
	font-weight: <?php echo $optionValue['weight'];?>;
	font-style: <?php echo $optionValue['style'];?>;
	color: <?php echo $optionValue['color'];?>;
}
.informationWidget p,.footerList .informationWidget p, .informationList li,div.textwidget, .widget ul li a, .textwidget span a,.widgetcategory_with_count.textwidget span.right,.textwidget .TText{
	<?php $optionValue = cr_get_option("rtl_widget_text_typography", array('size' => '12px', 'face' => 'sourceSans', 'style' => 'Normal', 'color' => '#5a5a5a', 'weight' => 'Normal'));?>
	font-size: <?php echo $optionValue['size'];?>;
	line-height: <?php echo intval($optionValue['size']) + 7;?>px;
	font-family: <?php echo $optionValue['face'];?>;
	font-weight: <?php echo $optionValue['weight'];?>;
	font-style: <?php echo $optionValue['style'];?>;
	color: <?php echo $optionValue['color'];?>;
}
.footerList .informationWidget p,.footerList .footerList .informationWidget p, .footerList .informationList li,.footerList div.textwidget, .footerList .widget ul li, .footerList .textwidget span a,.footerList .widgetcategory_with_count.textwidget span.right,.footerList .textwidget .TText, .footerList .textWidgetParagrph, .footerList .informationWidget p,.footerList .informationList li, .footerList .widget .menu a{
	<?php $optionValue = cr_get_option("rtl_footer_text_style", array('size' => '12px', 'face' => 'sourceSans', 'style' => 'Normal', 'color' => '#5a5a5a', 'weight' => 'Normal'));?>
	font-size: <?php echo $optionValue['size'];?>;
	line-height: <?php echo intval($optionValue['size']) + 7;?>px;
	font-family: <?php echo $optionValue['face'];?>;
	font-weight: <?php echo $optionValue['weight'];?>;
	font-style: <?php echo $optionValue['style'];?>;
	color: <?php echo $optionValue['color'];?>;
}
.widget_wp_recent_post_text p{
	<?php $optionValue = cr_get_option("rtl_footer_text_style", array('size' => '12px', 'face' => 'sourceSans', 'style' => 'Normal', 'color' => '#5a5a5a', 'weight' => 'Normal'));?>
	color: <?php echo $optionValue['color'];?>;
}
.widget-title, .widgetTitle{
	<?php $optionValue = cr_get_option("rtl_widget_title_typography", array('size' => '12px', 'face' => 'sourceSans', 'style' => 'Normal', 'color' => '#5a5a5a', 'weight' => 'Normal'));?>
	font-size: <?php echo $optionValue['size'];?>;
	line-height: <?php echo intval($optionValue['size']) + 7;?>px;
	font-family: <?php echo $optionValue['face'];?>;
	font-weight: <?php echo $optionValue['weight'];?>;
	font-style: <?php echo $optionValue['style'];?>;
	color: <?php echo $optionValue['color'];?>;
}
.footerList .widget-title, .footerList .widgetTitle{
	<?php $optionValue = cr_get_option("rtl_footer_title_style", array('size' => '16px', 'face' => 'SourceSansSemiBold', 'style' => 'Normal', 'color' => '#ffffff', 'weight' => 'Normal'));?>
	font-size: <?php echo $optionValue['size'];?>;
	line-height: <?php echo intval($optionValue['size']) + 7;?>px;
	font-family: <?php echo $optionValue['face'];?>;
	font-weight: <?php echo $optionValue['weight'];?>;
	font-style: <?php echo $optionValue['style'];?>;
	color: <?php echo $optionValue['color'];?>;
}
.widget_wp_recent_post_text h4{
	<?php $optionValue = cr_get_option("rtl_footer_title_style", array('size' => '16px', 'face' => 'SourceSansSemiBold', 'style' => 'Normal', 'color' => '#ffffff', 'weight' => 'Normal'));?>
	color: <?php echo $optionValue['color'];?>;
}
/************************************************************************************************************************
***************************************************** Logo Styles ******************************************************
*************************************************************************************************************************/
.headerStyle5, .headerStyle5 #menuContainer {
	height: <?php echo cr_get_option('header_height','270'); ?>px;
}
#logoWrapper {
	width: <?php echo cr_get_option('logo_wrapper_width','270'); ?>px;
	height: <?php echo cr_get_option('header_height','270'); ?>px;
	position: relative;
}
#logoWrapper a {
	height: <?php echo cr_get_option('logo_height','270'); ?>px;
}
#logoWrapper img {
	top: <?php echo cr_get_option('logo_top','0'); ?>px;
	left: <?php echo cr_get_option('logo_left','0'); ?>px;
	height: <?php echo cr_get_option('logo_height','270'); ?>px;
	position: absolute;
}
.headerStyle1 #menuContainer {
	height: <?php echo cr_get_option('header_height', '90')?>px;
}
/*.headerStyle5.mainHeader .nav.right {
	margin-top: <?php echo cr_get_option('header_height','270') - 64 ?>px
}*/
.headerStyle5 .cr_ad {
	height: <?php echo cr_get_option('header_height', '90') - 20 ?>px;
	width: <?php echo 940 - cr_get_option('logo_wrapper_width')?>px;
}
.headerStyle5 .blackSocial {
	margin-top: <?php echo (cr_get_option('header_height', '90')- 35)/2  ?>px;
}
.headerStyle6.mainHeader .nav.right {
	margin-top: <?php echo cr_get_option('header_height','270') - 83 ?>px
}
/**** Header.php Styles ****/
.headerStickyActive #logoWrapper {
	width:  calc(<?php echo cr_get_option('logo_wrapper_width'); ?> * 80/100) !important;
	height: calc(<?php echo cr_get_option('header_height'); ?> * 80/100) !important;
}
.headerStickyActive .navbar-inner {
	height: calc(<?php echo cr_get_option('header_height'); ?> * 80/100) !important;
}
.headerStickyActive #logoWrapper {
	width:  calc(<?php echo cr_get_option('logo_wrapper_width'); ?>px * 50/100) !important;
	height: calc(<?php echo cr_get_option('header_height'); ?>px * 50/100) !important;
}
.headerStickyActive .navbar-inner {
	height: calc(<?php echo cr_get_option('header_height'); ?>px * 61/100) !important;
}
/*.mainHeader .navbar .nav > li > a:hover {
	padding-bottom: calc(<?php //echo cr_get_option('rtl_header_height');?>/*px/2 - 33px) !important;
	/*padding-top: 10px;
}*/
.mainHeader .navbar .nav > li > a {
	padding-bottom: calc(<?php echo cr_get_option('header_height');?>px/2 - 33px) !important;
}
.headerStickyActive #logoWrapper img {
	top: calc(<?php echo cr_get_option('header_height'); ?>px * 7/100) !important;
}
/************************************************************************************************************************
***************************************************** Menu Styles ******************************************************
*************************************************************************************************************************/
.mainHeader .navbar .nav > li > a, .mainHeader .navbar .nav > li > a, .mainHeader .dropdown-menu > li > a, .headerStyle1 .dropdown-menu > li > a, .mainHeader .dropdown-menu > li > a {
	<?php $optionValue = cr_get_option("rtl_header_menu_typography", array('size' => '15px', 'face' => 'museo_slab500', 'style' => 'Normal', 'color' => '#5a5a5a', 'weight' => 'Normal'));?>
	font-size: <?php echo $optionValue['size'];?>;
	line-height: <?php echo intval($optionValue['size']) + 7;?>px;
	font-family: <?php echo $optionValue['face'];?>;
	font-weight: <?php echo $optionValue['weight'];?>;
	font-style: <?php echo $optionValue['style'];?>;
	color: <?php echo $optionValue['color'];?> !important;
}
.mainHeader .navbar .nav > li > a:hover, .headerStyle4 .navbar .nav > li > a:hover, .headerStyle4 .navbar .nav > li.open > a, .headerStyle9 .navbar .nav > li > a:hover, .headerStyle9 .navbar .nav > li.open > a{
	border-bottom-color: <?php echo cr_get_option("rtl_color_elements", '#e32831');?>;
}
.mainHeader .navbar .nav > li > a:hover, .mainHeader .navbar .nav > li.open > a,.widget ul li a:hover, .hoverlink, .aq_block_toggle h2.tab-head.colored, .aq_block_accordion h2.tab-head.colored{
	color: <?php echo cr_get_option("rtl_color_elements", '#e32831');?> !important;
}
.top_header_style4,.top_header_style3, .offerCircle:hover, .wpcf7-submit, .pricingTable.active .bundleHeader, .pricingTable:hover .bundleHeader, .pricingTable.active .orderBundle, .pricingTable:hover .orderBundle, #megaMenu .sub-menu li li a:before{
	background-color : <?php echo cr_get_option("rtl_color_elements", '#e32831');?>;
}
.headerStyle4 .navigationButton span,.headerStyle3 .navigationButton span, .headerStyle9 .navigationButton span, .woocommerce .widget_price_filter .price_slider_amount .button, .woocommerce-page .widget_price_filter .price_slider_amount .button, .wpcf7-submit:hover {
	border-color: <?php echo cr_get_option("rtl_color_elements", '#e32831');?>;
}
.headerStyle4 .navigationButton span,.headerStyle3 .navigationButton span, .headerStyle9 .navigationButton span{
	color: <?php echo cr_get_option("rtl_color_elements", '#e32831');?>;
}
/* Breaking */
.slidingText .movingHead h2{
	<?php $optionValue = cr_get_option("rtl_header_breaking_title_typography", array('size' => '17px', 'face' => 'museo_slab500', 'style' => 'Normal', 'color' => '#ffffff', 'weight' => 'Normal'));?>
	font-size: <?php echo $optionValue['size'];?>;
	line-height: <?php echo intval($optionValue['size']) + 7;?>px;
	font-family: <?php echo $optionValue['face'];?>;
	font-weight: <?php echo $optionValue['weight'];?>;
	font-style: <?php echo $optionValue['style'];?>;
	color: <?php echo $optionValue['color'];?>;
}
.movingText h6{
	<?php $optionValue = cr_get_option("rtl_header_breaking_text_typography", array('size' => '12px', 'face' => 'sourceSans', 'style' => 'Normal', 'color' => '#ffffff', 'weight' => 'Normal'));?>
	font-size: <?php echo $optionValue['size'];?>;
	line-height: <?php echo intval($optionValue['size']) + 7;?>px;
	font-family: <?php echo $optionValue['face'];?>;
	font-weight: <?php echo $optionValue['weight'];?>;
	font-style: <?php echo $optionValue['style'];?>;
	color: <?php echo $optionValue['color'];?>;
}



<?php } else {?>
	
/************************************************************************************************************************
***************************************************** heading style ******************************************************
*************************************************************************************************************************/
h1 {
	<?php $optionValue = cr_get_option("h1",  array('size' => '24px', 'face' => 'sourceSans', 'style' => 'Normal', 'color' => '#2a2a2a', 'weight' => 'Normal'));?>
	font-size: <?php echo $optionValue['size'];?>;
	line-height: <?php echo intval($optionValue['size']) + 2;?>px;
	font-family: <?php echo $optionValue['face'];?>;
	font-weight: <?php echo $optionValue['weight'];?>;
	font-style: <?php echo $optionValue['style'];?>;
	color: <?php echo $optionValue['color'];?>;
}
h2 {
	<?php $optionValue = cr_get_option("h2",  array('size' => '22px', 'face' => 'sourceSans', 'style' => 'Normal', 'color' => '#2a2a2a', 'weight' => 'Normal'));?>
	font-size: <?php echo $optionValue['size'];?>;
	line-height: <?php echo intval($optionValue['size']) + 2;?>px;
	font-family: <?php echo $optionValue['face'];?>;
	font-weight: <?php echo $optionValue['weight'];?>;
	font-style: <?php echo $optionValue['style'];?>;
	color: <?php echo $optionValue['color'];?>;
}
h3 {
	<?php $optionValue = cr_get_option("h3",  array('size' => '20px', 'face' => 'sourceSans', 'style' => 'Normal', 'color' => '#2a2a2a', 'weight' => 'Normal'));?>
	font-size: <?php echo $optionValue['size'];?>;
	line-height: <?php echo intval($optionValue['size']) + 2;?>px;
	font-family: <?php echo $optionValue['face'];?>;
	font-weight: <?php echo $optionValue['weight'];?>;
	font-style: <?php echo $optionValue['style'];?>;
	color: <?php echo $optionValue['color'];?>;
}
h4 {
	<?php $optionValue = cr_get_option("h4",  array('size' => '18px', 'face' => 'sourceSans', 'style' => 'Normal', 'color' => '#2a2a2a', 'weight' => 'Normal'));?>
	font-size: <?php echo $optionValue['size'];?>;
	line-height: <?php echo intval($optionValue['size']) + 2;?>px;
	font-family: <?php echo $optionValue['face'];?>;
	font-weight: <?php echo $optionValue['weight'];?>;
	font-style: <?php echo $optionValue['style'];?>;
	color: <?php echo $optionValue['color'];?>;
}
h5 {
	<?php $optionValue = cr_get_option("h5",  array('size' => '16px', 'face' => 'sourceSans', 'style' => 'Normal', 'color' => '#2a2a2a', 'weight' => 'Normal'));?>
	font-size: <?php echo $optionValue['size'];?>;
	line-height: <?php echo intval($optionValue['size']) + 2;?>px;
	font-family: <?php echo $optionValue['face'];?>;
	font-weight: <?php echo $optionValue['weight'];?>;
	font-style: <?php echo $optionValue['style'];?>;
	color: <?php echo $optionValue['color'];?>;
}
h6 {
	<?php $optionValue = cr_get_option("h6",  array('size' => '14px', 'face' => 'sourceSans', 'style' => 'Normal', 'color' => '#2a2a2a', 'weight' => 'Normal'));?>
	font-size: <?php echo $optionValue['size'];?>;
	line-height: <?php echo intval($optionValue['size']) + 2;?>px;
	font-family: <?php echo $optionValue['face'];?>;
	font-weight: <?php echo $optionValue['weight'];?>;
	font-style: <?php echo $optionValue['style'];?>;
	color: <?php echo $optionValue['color'];?>;
}
.titleBlock h3,.titleBlock p{
	<?php $optionValue = cr_get_option("header_blocks",  array('size' => '22px', 'face' => 'SourceSansSemiBold', 'style' => 'Normal', 'color' => '#2a2a2a', 'weight' => 'Normal'));?>
	font-size: <?php echo $optionValue['size'];?>;
	line-height: <?php echo intval($optionValue['size']) + 2;?>px;
	font-family: <?php echo $optionValue['face'];?>;
	font-weight: <?php echo $optionValue['weight'];?>;
	font-style: <?php echo $optionValue['style'];?>;
	color: <?php echo $optionValue['color'];?>;
}
p, .squarePostText, .aq_block_tabs .aq-tab p, .offerText, .dropcapText, .dropcapLight, .textSlider .carousel-caption p, .contactDetailsSection ul li p, .masonryContent .excerpt, .postText li{
	<?php $optionValue = cr_get_option("paragraphs", array('size' => '13px', 'face' => 'sourceSans', 'style' => 'Normal', 'color' => '#5a5a5a', 'weight' => 'Normal'));?>
	font-size: <?php echo $optionValue['size'];?>;
	line-height: <?php echo intval($optionValue['size']) + 7;?>px;
	font-family: <?php echo $optionValue['face'];?>;
	font-weight: <?php echo $optionValue['weight'];?>;
	font-style: <?php echo $optionValue['style'];?>;
	color: <?php echo $optionValue['color'];?>;
}
.informationWidget p,.footerList .informationWidget p, .informationList li,div.textwidget, .widget ul li a, .textwidget span a,.widgetcategory_with_count.textwidget span.right,.textwidget .TText{
	<?php $optionValue = cr_get_option("widget_text_typography", array('size' => '12px', 'face' => 'sourceSans', 'style' => 'Normal', 'color' => '#5a5a5a', 'weight' => 'Normal'));?>
	font-size: <?php echo $optionValue['size'];?>;
	line-height: <?php echo intval($optionValue['size']) + 7;?>px;
	font-family: <?php echo $optionValue['face'];?>;
	font-weight: <?php echo $optionValue['weight'];?>;
	font-style: <?php echo $optionValue['style'];?>;
	color: <?php echo $optionValue['color'];?>;
}
.footerList .informationWidget p,.footerList .footerList .informationWidget p, .footerList .informationList li,.footerList div.textwidget, .footerList .widget ul li, .footerList .textwidget span a,.footerList .widgetcategory_with_count.textwidget span.right,.footerList .textwidget .TText, .footerList .textWidgetParagrph, .footerList .widget .menu a{
	<?php $optionValue = cr_get_option("footer_text_style", array('size' => '12px', 'face' => 'sourceSans', 'style' => 'Normal', 'color' => '#5a5a5a', 'weight' => 'Normal'));?>
	font-size: <?php echo $optionValue['size'];?>;
	line-height: <?php echo intval($optionValue['size']) + 7;?>px;
	font-family: <?php echo $optionValue['face'];?>;
	font-weight: <?php echo $optionValue['weight'];?>;
	font-style: <?php echo $optionValue['style'];?>;
	color: <?php echo $optionValue['color'];?>;
}
.widget_wp_recent_post_text p{
	<?php $optionValue = cr_get_option("rtl_footer_text_style", array('size' => '12px', 'face' => 'sourceSans', 'style' => 'Normal', 'color' => '#5a5a5a', 'weight' => 'Normal'));?>
	color: <?php echo $optionValue['color'];?>;
}
.widget-title, .widgetTitle{
	<?php $optionValue = cr_get_option("widget_title_typography", array('size' => '12px', 'face' => 'sourceSans', 'style' => 'Normal', 'color' => '#5a5a5a', 'weight' => 'Normal'));?>
	font-size: <?php echo $optionValue['size'];?>;
	line-height: <?php echo intval($optionValue['size']) + 7;?>px;
	font-family: <?php echo $optionValue['face'];?>;
	font-weight: <?php echo $optionValue['weight'];?>;
	font-style: <?php echo $optionValue['style'];?>;
	color: <?php echo $optionValue['color'];?>;
}
.footerList .widget-title, .footerList .widgetTitle{
	<?php $optionValue = cr_get_option("footer_title_style", array('size' => '16px', 'face' => 'SourceSansSemiBold', 'style' => 'Normal', 'color' => '#ffffff', 'weight' => 'Normal'));?>
	font-size: <?php echo $optionValue['size'];?>;
	line-height: <?php echo intval($optionValue['size']) + 7;?>px;
	font-family: <?php echo $optionValue['face'];?>;
	font-weight: <?php echo $optionValue['weight'];?>;
	font-style: <?php echo $optionValue['style'];?>;
	color: <?php echo $optionValue['color'];?>;
}
.widget_wp_recent_post_text h4{
	<?php $optionValue = cr_get_option("rtl_footer_title_style", array('size' => '16px', 'face' => 'SourceSansSemiBold', 'style' => 'Normal', 'color' => '#ffffff', 'weight' => 'Normal'));?>
	color: <?php echo $optionValue['color'];?>;
}
/************************************************************************************************************************
***************************************************** Logo Styles ******************************************************
*************************************************************************************************************************/
.headerStyle5, .headerStyle5 #menuContainer {
	height: <?php echo cr_get_option('header_height','270'); ?>px;
}
#logoWrapper {
	width: <?php echo cr_get_option('logo_wrapper_width','270'); ?>px;
	height: <?php echo cr_get_option('header_height','270'); ?>px;
	position: relative;
}
#logoWrapper a {
	height: <?php echo cr_get_option('logo_height','270'); ?>px;
}
#logoWrapper img {
	top: <?php echo cr_get_option('logo_top','0'); ?>px;
	left: <?php echo cr_get_option('logo_left','0'); ?>px;
	height: <?php echo cr_get_option('logo_height','270'); ?>px;
	position: absolute;
}
.headerStyle1 #menuContainer {
	height: <?php echo cr_get_option('header_height', '90')?>px;
}
/*.headerStyle5.mainHeader .nav.right {
	margin-top: <?php echo cr_get_option('header_height','270') - 64 ?>px
}*/
.headerStyle5 .cr_ad {
	height: <?php echo cr_get_option('header_height', '90') - 20 ?>px;
	width: <?php echo 940 - cr_get_option('logo_wrapper_width')?>px;
}
.headerStyle5 .blackSocial {
	margin-top: <?php echo (cr_get_option('header_height', '90')- 35)/2  ?>px;
}
.headerStyle6.mainHeader .nav.right {
	margin-top: <?php echo cr_get_option('header_height','270') - 83 ?>px
}
/**** Header.php Styles ****/
.headerStickyActive #logoWrapper {
	width:  calc(<?php echo cr_get_option('logo_wrapper_width'); ?> * 80/100) !important;
	height: calc(<?php echo cr_get_option('header_height'); ?> * 80/100) !important;
}
.headerStickyActive .navbar-inner {
	height: calc(<?php echo cr_get_option('header_height'); ?> * 80/100) !important;
}
.headerStickyActive #logoWrapper {
	width:  calc(<?php echo cr_get_option('logo_wrapper_width'); ?>px * 50/100) !important;
	height: calc(<?php echo cr_get_option('header_height'); ?>px * 50/100) !important;
}
.headerStickyActive .navbar-inner {
	height: calc(<?php echo cr_get_option('header_height'); ?>px * 61/100) !important;
}
/*.mainHeader .navbar .nav > li > a:hover {
	padding-bottom: calc(<?php //echo cr_get_option('header_height');?>/*px/2 - 33px) !important;
	/*padding-top: 10px;
}*/
.mainHeader .navbar .nav > li > a {
	padding-bottom: calc(<?php echo cr_get_option('header_height');?>px/2 - 33px) !important;
}
.headerStickyActive #logoWrapper img {
	top: calc(<?php echo cr_get_option('header_height'); ?>px * 7/100) !important;
}
/************************************************************************************************************************
***************************************************** Menu Styles ******************************************************
*************************************************************************************************************************/
.mainHeader .navbar .nav > li > a, .mainHeader .navbar .nav > li > a, .mainHeader .dropdown-menu > li > a, .headerStyle1 .dropdown-menu > li > a, .mainHeader .dropdown-menu > li > a {
	<?php $optionValue = cr_get_option("header_menu_typography", array('size' => '15px', 'face' => 'museo_slab500', 'style' => 'Normal', 'color' => '#5a5a5a', 'weight' => 'Normal'));?>
	font-size: <?php echo $optionValue['size'];?>;
	line-height: <?php echo intval($optionValue['size']) + 7;?>px;
	font-family: <?php echo $optionValue['face'];?>;
	font-weight: <?php echo $optionValue['weight'];?>;
	font-style: <?php echo $optionValue['style'];?>;
	color: <?php echo $optionValue['color'];?> !important;
}
.headerMenu .menuContent a,
.headerMenu .ubermenu .ubermenu-target {
    font-size: <?php echo $optionValue['size'];?>;
    line-height: <?php echo intval($optionValue['size']) + 4;?>px;
	font-family: <?php echo $optionValue['face'];?>;
	font-weight: <?php echo $optionValue['weight'];?>;
	font-style: <?php echo $optionValue['style'];?>;
}
.mainHeader .navbar .nav > li > a:hover, .headerStyle4 .navbar .nav > li > a:hover, .headerStyle4 .navbar .nav > li.open > a, .headerStyle9 .navbar .nav > li > a:hover, .headerStyle9 .navbar .nav > li.open > a{
	border-bottom-color: <?php echo cr_get_option("color_elements", '#e32831');?>;
}
.mainHeader .navbar .nav > li > a:hover, .mainHeader .navbar .nav > li.open > a,.widget ul li a:hover, .hoverlink, .aq_block_toggle h2.tab-head.colored, .aq_block_accordion h2.tab-head.colored{
	color: <?php echo cr_get_option("color_elements", '#e32831');?> !important;
}
.top_header_style4,.top_header_style3, .offerCircle:hover, .wpcf7-submit, #megaMenu .sub-menu li li a:before {
	background-color : <?php echo cr_get_option("color_elements", '#e32831');?>;
}
.headerStyle4 .navigationButton span,.headerStyle3 .navigationButton span, .headerStyle9 .navigationButton span, .woocommerce .widget_price_filter .price_slider_amount .button, .woocommerce-page .widget_price_filter .price_slider_amount .button, .wpcf7-submit:hover {
	border-color: <?php echo cr_get_option("color_elements", '#e32831');?>;
}
.headerStyle4 .navigationButton span,.headerStyle3 .navigationButton span, .headerStyle9 .navigationButton span, .afterFooter ul li a:hover{
	color: <?php echo cr_get_option("color_elements", '#e32831');?>;
}
/* Breaking */
.slidingText .movingHead h2{
	<?php $optionValue = cr_get_option("header_breaking_title_typography", array('size' => '17px', 'face' => 'museo_slab500', 'style' => 'Normal', 'color' => '#ffffff', 'weight' => 'Normal'));?>
	font-size: <?php echo $optionValue['size'];?>;
	line-height: <?php echo intval($optionValue['size']) + 7;?>px;
	font-family: <?php echo $optionValue['face'];?>;
	font-weight: <?php echo $optionValue['weight'];?>;
	font-style: <?php echo $optionValue['style'];?>;
	color: <?php echo $optionValue['color'];?>;
}
.movingText h6{
	<?php $optionValue = cr_get_option("header_breaking_text_typography", array('size' => '12px', 'face' => 'sourceSans', 'style' => 'Normal', 'color' => '#ffffff', 'weight' => 'Normal'));?>
	font-size: <?php echo $optionValue['size'];?>;
	line-height: <?php echo intval($optionValue['size']) + 7;?>px;
	font-family: <?php echo $optionValue['face'];?>;
	font-weight: <?php echo $optionValue['weight'];?>;
	font-style: <?php echo $optionValue['style'];?>;
	color: <?php echo $optionValue['color'];?>;
}
	
<?php } ?>
/************************************************************************************************************************
***************************************************** theme color Styles ******************************************************
*************************************************************************************************************************/

/* style.css */ .highLightLeft:after, .highLightRight:after, .progress .bar, .top_header_style4, .headerStyle1 .navigationButton .icon-bar, [class*="btnStyle"].red, .pagination ul > li > span, .pagination ul > li > a:hover, .pagination ul > .active > a, .pagination ul > .active > span, .pagination ul > li:hover > a.prev, .pagination ul > li:hover > a.next, .widget_wysija_cont .wysija-submit, .form-submit #submit, .comment-reply-link, #cancel-comment-reply-link, .edit-link a
/* external/theme-configurator-css/configurator.css */, #titleColored
/* css/content-builder */, .circleAnimationSingle .circleAnimationDetails, .animation3:hover .back, .arrows_gallery .galleryIconArrow:hover, .squarePostCont, .iconAnnouncement, .testimonialsSection .carousel-linked-nav li.active, .aq_block_toggles_wrapper .icon-minus, .aq_block_accordion_wrapper .icon-minus
/* css/parts */, .postBlog2 .postDate .dayMonth, .postBlog4 .postDate, .portfolioHoverCont
/* css/parts/shop.css */, .itemMore, .addToCart.cf-one-button, .customerLogin form input.button, #place_order, #payment .placeOrder, .woocommerce .widget_price_filter .price_slider_amount .button, .woocommerce-page .widget_price_filter .price_slider_amount .button, .woocommerce .widget_price_filter .ui-slider .ui-slider-range, .woocommerce-page .widget_price_filter .ui-slider .ui-slider-range
/* css/widgets */, #wp-calendar thead, .widget_product_search input[type="submit"], .widget_search .input-append button span, .searchform .input-append button, .widget_display_search #bbp_search_submit, .bbp_widget_login .bbp-submit-wrapper button
/* css/bbpress.css */, #bbpress-forums .bbp-search-form #bbp_search_submit, #bbpress-forums li.bbp-header, #bbp-user-navigation li.current:after, .bbp-topic-action #favorite-toggle a:hover, .bbp-topic-action #subscription-toggle a:hover, #bbpress-forums #bbp-your-profile fieldset.submit button
/* css/header */, .headerStyle1 .navigationButton .icon-bar, .headerStyle2 .navigationButton .icon-bar, .top_header_style3, .headerStyle3 .navigationButton .icon-bar, .headerStyle4 .navigationButton .icon-bar, .headerStyle9 .navigationButton .icon-bar, .headerStyle5 .navigationButton .icon-bar, .headerStyle6 .navigationButton .icon-bar, .headerStyle7 .navigationButton .icon-bar
/* aqpb-view.css */, .featuresHome.gridStyle .featureHomeImage:after,.widgetDot, .headerDot, .postBlog1 .postDate .dayMonth,
.faqItem .aq_block_toggle h6 div span, .itemSale, .pricingTable.active .bundleHeader, .pricingTable:hover .bundleHeader, .pricingTable.active .orderBundle, .pricingTable:hover .orderBundle,
.pricingTable:hover .bundleHeader, .pricingTable.active .orderBundle, .pricingTable:hover .orderBundle,
.magazinePost1 .image .magazinePostDate, .magazinePostViews .mag_views_no, .magazinePostComments .mag_comments_no, .magazinePost2 .image .magazinePostDate,
/* Ubermenu */.ubermenu-main .ubermenu-submenu.ubermenu-submenu-drop ul a span:before 
{
	background-color: <?php echo cr_get_option("color_elements", '#e32831');?>;
}
.cart-dropdown.openMini .cart-dropdown-header {
	background-color: <?php echo cr_get_option("color_elements", '#e32831');?> !important;
}
/* css/header */ .headerStyle1 .btn-navbar, .headerStyle2 .btn-navbar, .headerStyle4 .btn-navbar, .headerStyle9 .btn-navbar, .headerStyle5 .btn-navbar, .headerStyle6 .btn-navbar, .headerStyle2 .btn-navbar, .headerStyle2 .btn-navbar, .toggleMenuBtn, .offerLink a
{
	background-color: <?php echo cr_get_option("color_elements", '#e32831');?> !important;
}
/* style.css */ .headerStyle1 .navbar .nav > li > a:hover, .headerStyle1 .navbar .nav > li.open > a
/* external/theme-configurator-css/configurator.css */, .themeLink a
/* css/widgets */, .widget ul li a:hover, .hoverlink, .footerList .widget_pages ul li.current_page_item > a:hover
/* css/bootstrap.min.css */ ,.navbar .nav>.active>a,.navbar .nav>.active>a:hover,.navbar .nav>.active>a:focus, .navbar .nav>.active>a .active>a,.navbar .nav > li.open .active>a,.navbar .nav>.active>a .active,.navbar .nav > li.open .active,
.featuresHome .image_title_wrap:hover .featureHomeImage span, .featuresHome .image_title_wrap:hover .featureHomeTitle
/* aqpb-view.css */ ,.featuresHome .image_title_wrap:hover .featureHomeImage span, .featuresHome .image_title_wrap:hover .featureHomeTitle, .featuresHome.gridStyle .image_title_wrap:hover .featureHomeImage span,
.mainHeader .dropdown-menu > li:hover > a, .mainHeader .dropdown-menu > li:hover > a,
.navbar .nav > li > a:hover, .navbar .nav > li.open > a,
.top_header_style4 .nav > li > a:hover, .top_header_style4 .navbar .nav > li.open > a, .top_header_style4 .navbar .nav>.active>a, .top_header_style4 .navbar .nav>.active>a:hover,
.header6 .navbar .searchFormIcon.searchActive > span, .megaMenu .current_page_item span, .megaMenu .sub-menu .menu-item li:hover span,
.magazinePostTitle h4:hover, .magazineCategories a p:hover, .magazinePost3 .magazinePostBtn a:hover, .magazinePost3 .magazinePostAuthor p:hover, .magazinePost4 .magazinePostBtn a:hover, .magazinePost4 .magazinePostAuthor p:hover, .magazinePost4 .magazineCategories p,
/* Ubermenu */.ubermenu-submenu .ubermenu-current-menu-item a span
{
	color: <?php echo cr_get_option("color_elements", '#e32831');?> !important;
}
/* style.css */ .color, .navbar .searchFormIcon.searchActive > span, .top_header_style4 .dropdown-menu > li > a:hover, .top_header_style4 .dropdown-menu > li:hover, .headerStyle1 .dropdown-menu > li > a:hover, .headerStyle4 .dropdown-menu > li > a:hover, .headerStyle9 .dropdown-menu > li > a:hover, .headerStyle1 .dropdown-menu > li:hover, .headerStyle4 .dropdown-menu > li:hover, .headerStyle9 .dropdown-menu > li:hover,.headerStyle1 .navigationButton  span, .formError .formErrorContent, #respond .must-log-in a:hover, .comment-date, .edit-link a
/* css/widgets */, .testimonials .TName, #wp-calendar tbody td:hover, #wp-calendar tbody td#today , .informationList span, .widget_wp_recent_post_text span, .widget_wp_recent_post_text h4:hover, .widget_wp_recent_post_text p a:hover
/* css/bbpress.css */, #bbpress-forums .bbp-forum-freshness .forumFreshness a, #bbpress-forums .bbp-topic-freshness .forumFreshness a,.bbpSingleReply .bbp-meta .bbp-admin-links, .bbpSingleReply .bbp-meta .bbp-reply-permalink, .bbpSingleReply .bbp-reply-author .bbp-author-name
/* css/landpage.css */, .LandContent a
/* css/content-builder*/, .squarePostsWrapper .squarePostTitle:hover, .aq_block_tabs ul.aq-nav li.ui-state-active a, .aq_block_toggle h2.tab-head.colored, .aq_block_accordion h2.tab-head.colored, .teamShortcut, .teamEmail, .testimonialsSection .TName, .TestmonialStyle2 .testimonialName p
/* css/parts */, .postBlogStyleOne li, .likenum p, .postCreagory a p, .singlePortCat a, .singlePortTag a, .text_under_post .readmore, .text_under_post .readmore span
/* css/parts/shop.css */, .shopDropDownOptions li:hover p, .woocommerce-message a, .cart-dropdown .cart-dropdown-elements .miniDetails p span, .customerLogin label span.required, .checkoutForm .form-row label .required, .order_details.shop_table td a, .order_details.shop_table .product-quantity, .container.removeMargin p
/* aqpb-view.css */, .contactDetailsSection ul li p.contactMailText,
.headerStyle2 .dropdown-menu > li > a:hover, .headerStyle4 .dropdown-menu > li > a:hover, .headerStyle9 .dropdown-menu > li > a:hover, .mainHeader .navbar .nav > li > a:after, .cart-dropdown .cart-dropdown-header span:hover, .tagcloud a:hover , .bbpSingleReply .bbp-reply-content a,
.smallHeader .navbar .nav > li > a:after,
.top_header_style4 .btn-navbar span, .navbar .searchFormIcon > span:hover
, .twitterBlock li span a,
.portOneAuthor a:hover, .portOneContent a:hover, .portfolioOneDetails .date_cat a:hover,
/* Ubermenu */.ubermenu a.ubermenu-target:hover, .ubermenu-trigger-click .ubermenu-has-submenu-drop .ubermenu-target:hover, .ubermenu-main .ubermenu-submenu.ubermenu-submenu-drop ul a span:hover, .ubermenu-current-menu-item a span, .ubermenu-current-menu-ancestor a span, .cfgm-infowidow-title span
{
	color: <?php echo cr_get_option("color_elements", '#e32831');?>;
}
/* style.css */ .headerStyle1 .navigationButton, [class*="btnStyle"].red .btnAfter, [class*="btnStyle"].red .btnBefore, [class*="btnStyle"] .btnAfter, [class*="btnStyle"] .btnBefore,.widget_wysija_cont .wysija-submit, .form-submit #submit, .comment-reply-link, #cancel-comment-reply-link, .edit-link a
/* css/widgets*/, .widget_display_search #bbp_search_submit, .bbp_widget_login .bbp-submit-wrapper button
/* css/bbpress */, #bbpress-forums .bbp-search-form #bbp_search_submit
/* css/content_builder */, .blockquote, .contentpostSC,
/* aqpb-view.css */.featuresHome.gridStyle .featureHomeImage, #place_order,
.headerStyle2 .navbar .nav > li > a:hover, .headerStyle2 .navbar .nav > li.open > a, .tagcloud a:hover , .loader .topLoader , .loader .bottomLoader,.headerStyle6 .navbar .nav > li > a:hover, .headerStyle6 .navbar .nav > li.open > a,
.headerStyle5 .navbar .nav > li > a:hover, .headerStyle5 .navbar .nav > li.open > a,
.magazinePostViews .mag_views_no, .magazinePostComments .mag_comments_no, .magazinePost3 .magazinePostBtn a:hover, .magazinePost4 .magazinePostBtn a:hover,
/* Ubermenu */.ubermenu-main .ubermenu-submenu.ubermenu-submenu-drop
{
	border-color: <?php echo cr_get_option("color_elements", '#e32831');?>;
}
/* css/content_builder */ .aq_block_tabs ul.aq-nav li.ui-state-active:after
/* css/parts */, #singleCommentsTabbed li.active, .filterMenu li:first-child, .postBlog4 .postDate:after, .postBlog4 .postDate .dottedTriangle
/* css/parts/shop.css */, .woocommerce .widget_price_filter .price_slider_amount .button, .woocommerce-page .widget_price_filter .price_slider_amount .button
,#circleFlipFooter
{
	border-top-color: <?php echo cr_get_option("color_elements", '#e32831');?>;
}
/* style.css */ .headerStyle1 .navbar .nav > li > a:hover, .headerStyle1 .navbar .nav > li.open > a, .headerStyle4 .navbar .nav > li > a:hover, .headerStyle4 .navbar .nav > li.open > a
{
	border-bottom-color: <?php echo cr_get_option("color_elements", '#e32831');?>;
}
.headerStyle5 .navbar .nav > li > a:hover, .headerStyle5 .navbar .nav > li.open > a {
	border-bottom-color:  <?php echo cr_get_option("color_elements", '#e32831');?>;
}
.aq_block_tabs ul.aq-nav li.ui-state-active {
	border-top: 3px solid <?php echo cr_get_option("color_elements", '#e32831');?>;
}


/********************************** Darker Color ************************************************/
/* accordion.css */
/* dropcap.css */
/* faq_block.css */
/* tabs.css */
/* portfolio.css */
/* portfolio-page.css */

.aq_block_toggle h2.tab-head.colored, .aq_block_accordion h2.tab-head.colored, .drop, .faqNavList:hover, .aq_block_tabs ul.aq-nav li.ui-state-active a, #circleflip-filters li:hover, #circleflip-filters li.active, .portOneCategories a, .singlePortTag a{
	color: <?php echo cr_get_option("color_elements_dark", '#b92424');?>;
}
/* dropcap.css, faq_block.css, blog.css, widgets.css */
/* style.css */
.dropcap, .postBlog1 .postDate .year, .blogStyle2 .like, .postBlog2 .postDate .year, .checkoutCoupon form input.button, .woocommerce .widget_price_filter .ui-slider .ui-slider-handle, .woocommerce-page .widget_price_filter .ui-slider .ui-slider-handle, .widget_pages ul li.current_page_item > a, .widget-area .menu li.menu-item.active a, .backcolor, [class*="btnStyle"].heavyRed
, .flatBtn, .pricingTable.active .price p, .pricingTable:hover .price p, .pricingTable.active .price p, .pricingTable:hover .price p, #wp-calendar caption {
	background-color: <?php echo cr_get_option("color_elements_dark", '#b92424');?>;
}
/* tabs.css */
/* shop.css */
.woocommerce-tabs .tabs li.active a {
	border-top: 2px solid <?php echo cr_get_option("color_elements_dark", '#b92424');?>;
}
.widget_nav_menu .menu-item a:hover {
	border-left: 3px solid <?php echo cr_get_option("color_elements", '#e32831');?>; 
}

/* style.css */
[class*="btnStyle"].heavyRed .btnAfter, [class*="btnStyle"].heavyRed .btnBefore {
		border-color: <?php echo cr_get_option("color_elements_dark", '#b92424');?>;
}
body {
	background-color: <?php echo cr_get_option("body_color", '#fff');?>;
	<?php if(cr_get_option('custom_pattern') != null) { 	
		echo 'background-image: url('. cr_get_option("custom_pattern") .');';
	} elseif(cr_get_option('featured_pattern') == true && cr_get_option('pattern_check') == true) { 
		echo 'background-image: url('. get_template_directory_uri() . '/img/patterns/' .cr_get_option("featured_pattern", 'pattern') .'.png)';
	} ?>;
	<?php if(cr_get_option('pattern_check') == true && cr_get_option('custom_pattern') != null ) {
		echo 'background-size: initial;background-position: left top;background-repeat: repeat;';
	} elseif (cr_get_option('pattern_check') == false && cr_get_option('custom_pattern') != null ) {
		echo 'background-repeat: no-repeat;background-size: contain;background-position: top center;';			
	}?>
		
}
@media screen and (min-width: 1200px) {
	.top_header_style4 .nav > li > a:hover, .top_header_style4 .navbar .nav > li.open > a, .top_header_style4 .navbar .nav>.active>a, .top_header_style4 .navbar .nav>.active>a:hover {
		color: white !important;
	}
}

@media (max-width: 1199px) and (min-width: 978px) {
	.top_header_style4 .nav > li > a:hover, .top_header_style4 .navbar .nav > li.open > a, .top_header_style4 .navbar .nav>.active>a, .top_header_style4 .navbar .nav>.active>a:hover {
		color: white !important;
	}
}

/************************************************************************************************************************
***************************************************** Header Builder ******************************************************
*************************************************************************************************************************/
.headerMenu .menuContent > li > a:after,
.headerMenu .ubermenu .ubermenu-submenu .ubermenu-submenu a:before {
	background-color: <?php echo cr_get_option("color_elements", '#e32831');?>;
}
.headerMenu .sub-menu li:hover > a,
.headerMenu .sub-menu li.active > a,
.headerMenu .ubermenu .ubermenu-submenu a:hover,
.headerMenu .ubermenu .ubermenu-submenu a:hover,
.headerMenu .ubermenu .ubermenu-submenu .ubermenu-current-menu-item > a,
.lightContent .headerMenu .toggleMenuBtn,
.darkContent .headerMenu .menuContent > li:hover > a,
.darkContent .headerMenu .menuContent > li.active > a,
.darkContent .headerMenuSearch:hover > span,
.darkContent .headerMenuSearch.openSearch > span,
.darkContent .headerMenu .ubermenu-nav > .ubermenu-item:hover > a,
.darkContent .headerMenu .ubermenu-nav > .ubermenu-item.ubermenu-current-menu-item > a,
.darkContent .headerMenu .ubermenu-nav > .ubermenu-item.ubermenu-current-page-parent > a,
.darkContent .toggleMenuBtn,
.darkContent .headerSocial .back i {
	color: <?php echo cr_get_option("color_elements", '#e32831');?>;
}
.toggledMenu .menuWrapper {
	border-left-color: <?php echo cr_get_option("color_elements", '#e32831');?>;
}
.headerMenu .ubermenu .ubermenu-item .ubermenu-submenu-drop {
	border-top-color: <?php echo cr_get_option("color_elements", '#e32831');?>;
}
.darkContent .toggleMenuBtn,
.darkContent .headerButton a span {
    border-color: <?php echo cr_get_option("color_elements", '#e32831');?>;
}
@media (min-width: 980px) {
	.sideHeader .headerMenu .ubermenu .ubermenu-item .ubermenu-submenu-drop {
		border-left-color: <?php echo cr_get_option("color_elements", '#e32831');?>;
	}
}
@media (max-width: 979px) and (min-width: 768px) {
	.headerMenu.responsiveCheck .menuContent > li.menu-parent > .sub-menu {
    	border-top-color: <?php echo cr_get_option("color_elements", '#e32831');?>;
	}
	.lightContent .headerMenu.responsiveCheck .menuContent > li:hover > a,
    .lightContent .headerMenu.responsiveCheck .menuContent > li.active > a {
        color: <?php echo cr_get_option("color_elements", '#e32831');?>;
    }
}
@media (max-width: 767px) {
	.headerMenu.responsiveCheck .menuContent > li.menu-parent > .sub-menu {
	    border-top-color: <?php echo cr_get_option("color_elements", '#e32831');?>;
	}
	.lightContent .headerMenu.responsiveCheck .menuContent > li:hover > a,
    .lightContent .headerMenu.responsiveCheck .menuContent > li.active > a {
        color: <?php echo cr_get_option("color_elements", '#e32831');?>;
    }
}