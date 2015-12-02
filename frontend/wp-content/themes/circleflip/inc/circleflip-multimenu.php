<?php
add_filter( 'wp_nav_menu_args', 'circleflip_multimenu_override_menu' );
add_filter( 'sanitize_page_meta__circleflip_multimenu', 'circleflip_multimenu_sanitize_data', 10, 3 );
add_action( 'add_meta_boxes_page', 'circleflip_multimenu_register_metabox' );
add_action( 'save_post_page', 'circleflip_multimenu_save_metabox', 10, 3 );

function circleflip_multimenu_register_metabox( $page ) {
	if ( ! current_user_can( 'edit_page', $page->ID ) ) {
		return;
	}

	add_meta_box( 'circleflip-multimenu', _x( '(Circleflip) MultiMenu', 'metabox title', 'circleflip' ), 'circleflip_multimenu_render_metabox', 'page', 'side', 'low' );
}

function circleflip_multimenu_render_metabox( $page ) {
	if ( ! current_user_can( 'edit_page', $page->ID ) ) {
		return;
	}
	$default_value = 0;
	$_nav_menus = wp_get_nav_menus( 'fields=id=>name' );
	//get_terms return WP_Error if taxonomy doesn't exist
	if ( is_wp_error( $_nav_menus ) ) {
		$_nav_menus = array();
	}
	$locations = array_map( 'sanitize_key', array_keys( get_nav_menu_locations() ) );
	$selected_menu = wp_parse_args(
			get_post_meta( $page->ID, '_circleflip_multimenu', true ),
			array_combine( $locations, array_fill( 0, count( $locations ), $default_value ) )
	);

	wp_nonce_field( 'circleflip-multimenu-save', 'circleflip_multimenu_nonce' );
	?>
	<?php foreach ( $locations as $location ) : ?>
		<p><strong><?php echo esc_html($location) ?></strong></p>
		<label class="screen-reader-text" for="circleflip-multimenu-menu"><?php _e( 'Menu', 'circleflip' ) ?></label>
		<select id="circleflip-multimenu-menu" name="circleflip_multimenu_menu[<?php echo sanitize_key( $location ) ?>]">
			<option value="<?php echo esc_attr($default_value) ?>" <?php selected( $selected_menu[sanitize_key( $location )], $default_value ) ?>><?php _e( 'Default (global setting)', 'circleflip' ) ?></option>
			<?php foreach ( $_nav_menus as $id => $name ) : ?>
				<?php printf( '<option value="%d" %s>%s</option>', $id, selected( $selected_menu[sanitize_key( $location )], $id, false ), $name ) ?>
			<?php endforeach; ?>
		</select>
	<?php endforeach; ?>
	<?php
}

function circleflip_multimenu_save_metabox( $page_ID, $page, $update ) {
	if ( ! current_user_can( 'edit_page', $page_ID ) || ! isset( $_POST['circleflip_multimenu_menu'] ) || ! isset( $_POST['circleflip_multimenu_nonce'] ) || ! wp_verify_nonce( $_POST['circleflip_multimenu_nonce'], 'circleflip-multimenu-save' )
	) {
		return;
	}

	$_override_menu = sanitize_meta( '_circleflip_multimenu', $_POST['circleflip_multimenu_menu'], 'page' );
	update_post_meta( $page_ID, '_circleflip_multimenu', $_override_menu );
}

function circleflip_multimenu_sanitize_data( $meta_value, $meta_key, $meta_type ) {
	$_valid_nav_menus = wp_get_nav_menus( 'fields=ids' );
	foreach($meta_value as $location => $menu ) {
		if ( ! in_array( $menu, $_valid_nav_menus ) ) {
			$meta_value[$location] = 0;
		}
	}
	return $meta_value;
}

function circleflip_multimenu_override_menu( $args ) {
	$page = get_post();
	if ( $page && 'page' === get_post_type( $page ) && isset( $args['theme_location'] ) ) {
		$_override_menu = $page->_circleflip_multimenu;
		if ( $_override_menu && !empty( $_override_menu[ $args[ 'theme_location' ] ] ) ) {
			$args['menu'] = ( int ) $_override_menu[$args['theme_location']];
		}
	}
	return $args;
}
