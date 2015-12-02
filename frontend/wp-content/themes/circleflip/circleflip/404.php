<?php
/** 404.php
 *
 * The template for displaying 404 pages (Not Found).
 *
 * @author		Creiden
 * @package		Circleflip
 * @since		1.0.0 - 07.02.2012
 */

get_header(); ?>
<div  class="errorPage">
	<hr>
	<div class="container">
		<div class="row">
			<div class="missingPage">
				<div class="span4">
					<img src="<?php echo esc_url( trailingslashit( images ) . 'error/error.png' ) ?>" alt="page not found"/>
				</div>
				<div class="span8">
					<h1>404<small>Error</small></h1>
					<p>Did you know that errors starting with 4xx mean Error at the client side? Please re-check the URL you entered and make sure it is typed correctly.</p>
					<p>Or, Navigate to one of our pages above !</p>
				</div>
			</div>
		</div>
	</div>
	<hr>
</div>
<?php
get_footer();
/* End of file 404.php */
/* Location: ./wp-content/themes/circleflip/404.php */