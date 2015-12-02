<?php
add_action( 'init', 'circleflip_sidebar_settings_rolescheck' );

function circleflip_sidebar_settings_rolescheck() {
	if ( current_user_can( 'edit_theme_options' ) ) {
		add_action( 'sidebar_admin_page', 'circleflip_sidebar_options' );
	}
}

if ( ! function_exists( 'circleflip_sidebar_options' ) ) {

	function circleflip_sidebar_options() {
		wp_enqueue_style( 'optionsframework', get_template_directory_uri() . '/creiden-framework/inc/css/optionsframework.css' );
		$output = '';
		?>
		<form action="admin-post.php" id="sliderNamesForm"  method="post">
			<input type="hidden" name="action" value="cflip_save_sidebar_options" />

			<div class="option_container">
				<input id="create_slider" placeholder="Sidebar Name" class="of-input" name="sidebar_names" type="text" value="" />
			</div>
			<?php
			submit_button( 'Add Sidebar' );
			?>
		</form>

		<?php
		$val = get_option( 'sidebar_names' );
		$output .= '<div id="custom-sidebars">';
		$output .= '<h5 id="current-sidebars">Current Sidebars</h5><ul>';
		if ( isset( $val ) && is_array( $val ) ) {
			foreach ( $val as $sidebar ) {
				$output .= '<li>
	                    				<div id="sidebar-' . esc_attr( preg_replace( '/[^a-zA-Z0-9._\-]/', '', strtolower( $sidebar ) ) ) . '">' . '<p>' . $sidebar . '</p>';
				$output .= '<input type="hidden" name="sidebar_names" value="' . esc_attr( $sidebar ) . '">';
				$output .= '<button type="button" class="remove" data-sidebar=' . $sidebar . ' data-target="#sidebar-' . esc_attr( preg_replace( '/[^a-zA-Z0-9._\-]/', '', strtolower( $sidebar ) ) ) . '"></button></div></li>';
			}
		}
		$output .= '</ul></div>';
		echo $output;
		?>
		<script>
			( function( $ ) {
				$( document ).ready( function() {
					$( '#custom-sidebars' ).on( 'click', '.remove', function( e ) {
						$.ajax( {
							url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
							type: 'post',
							data: {
								action: 'remove_value_option',
								sidebar: $( this ).data( 'sidebar' )
							},
							success: function( response ) {
								window.location.reload( true );
							}
						} )
					} );
				} );
			} )( jQuery )
		</script>

		<?php
	}

}

add_action( 'admin_post_cflip_save_sidebar_options', 'cflip_admin_save_sidebar' );

function cflip_admin_save_sidebar() {
	$options = get_option( 'sidebar_names' );

	if ( isset( $_POST['sidebar_names'] ) && ! empty( $_POST['sidebar_names'] ) ) {
		$options[] = sanitize_text_field( $_POST['sidebar_names'] );
	}

	update_option( 'sidebar_names', $options );

	wp_redirect( 'widgets.php' );
	exit;
}

add_action( 'wp_ajax_remove_value_option', 'cflip_update_sidebar_option' );

function cflip_update_sidebar_option() {
	if ( isset( $_POST['sidebar'] ) ) {
		if ( $sidebar_options = get_option( 'sidebar_names' ) ) {
			if ( ($key = array_search( $_POST['sidebar'], $sidebar_options )) !== false ) {
				$sidebar_options = array_diff( $sidebar_options, array( $sidebar_options[$key] ) );
				$sidebar_options = array_values( $sidebar_options );
			}
		}
		update_option( 'sidebar_names', $sidebar_options );
	}
}
