<?php
/** searchform.php
 *
 * The template for displaying search forms
 *
 * @author		Creiden
 * @package		Circleflip
 * @since		1.0.0 - 07.02.2012
 */
?>
<form method="get" id="searchform" class="form-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="s" class="assistive-text hidden"><?php esc_html_e( 'Search', 'circleflip' ); ?></label>
	<div class="input-append">
		<input class="span2 search-query" type="search" name="s" placeholder="<?php esc_attr_e( 'Search', 'circleflip' ); ?>">
	 	<button class="btn" name="submit" id="searchsubmit" type="submit"><span class="icon-search-1"></span></button>
   	</div>
</form>
<?php


/* End of file searchform.php */
/* Location: ./wp-content/themes/circleflip/searchform.php */