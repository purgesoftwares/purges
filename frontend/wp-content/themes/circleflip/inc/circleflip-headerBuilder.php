<?php
add_action( 'add_meta_boxes_page', 'circleflip_headerBuilder_register_metabox' );
add_action( 'save_post_page', 'circleflip_headerBuilder_save_metabox', 10, 3 );

function circleflip_headerBuilder_register_metabox( $page ) {
	if ( ! current_user_can( 'edit_page', $page->ID ) ) {
		return;
	}

	add_meta_box( 'circleflip-headerBuilder', _x( '(Circleflip) Header Builder', 'metabox title', 'circleflip' ), 'circleflip_headerBuilder_render_metabox', 'page', 'side', 'low' );
}

function circleflip_headerBuilder_render_metabox( $page ) {
	if ( ! current_user_can( 'edit_page', $page->ID ) ) {
		return;
	}
	wp_nonce_field( 'circleflip-headerBuilder-save', 'circleflip_headerBuilder_nonce' );
	
	$postmeta = get_post_meta($page->ID,'_circleflip_headerBuilder');
	$postmeta_slider = get_post_meta($page->ID,'_circleflip_headerBuilder_slider');
	if(!$postmeta) {
		$postmeta[0] = '';
	}
	if(!$postmeta_slider) {
		$postmeta_slider[0] = '';
	}
	$hb_names = get_option('hb_names');?>
		<label class="screen-reader-text" for="circleflip-headerBuilder-menu"><?php _e( 'Menu', 'circleflip' ) ?></label>
		<select id="circleflip-headerBuilder-menu" name="circleflip_headerBuilder_menu">
			<option value="global">(Default Value) Global Setting</option>
			<?php foreach ( $hb_names as $key => $hb_name ) : ?>
				<option value="<?php echo esc_attr($key) ?>" <?php selected( $postmeta[0], $key, true ) ?>><?php echo esc_html($hb_name); ?></option>
			<?php endforeach; ?>
		</select>
		<label><strong>Please enter the slider shortcode</strong></label>
		<input type="text" name="circleflip_headerBuilder_slider" value="<?php echo (isset($postmeta_slider[0]) && !empty($postmeta_slider[0])) ? $postmeta_slider[0] : ''; ?>"/>
	<?php
}

function circleflip_headerBuilder_save_metabox( $page_ID, $page, $update ) {
	if ( ! current_user_can( 'edit_page', $page_ID ) || ! isset( $_POST['circleflip_headerBuilder_menu'] ) || ! isset( $_POST['circleflip_headerBuilder_nonce'] ) || ! wp_verify_nonce( $_POST['circleflip_headerBuilder_nonce'], 'circleflip-headerBuilder-save' )
	) {
		return;
	}

	$_override_menu = sanitize_meta( '_circleflip_headerBuilder', $_POST['circleflip_headerBuilder_menu'], 'page' );
	$_override_slider = sanitize_meta( '_circleflip_headerBuilder_slider', $_POST['circleflip_headerBuilder_slider'], 'page' );
	update_post_meta( $page_ID, '_circleflip_headerBuilder', $_override_menu );
	update_post_meta( $page_ID, '_circleflip_headerBuilder_slider', $_override_slider );
}
