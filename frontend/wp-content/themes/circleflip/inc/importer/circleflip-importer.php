<?php
add_filter( 'circleflip_theme_options', 'circleflip_importer_themeoption' );
add_filter( 'circleflip_options_interface_import-demo', 'circleflip_importer_render' );
add_action( 'wp_ajax_circleflip-import-demo', 'circleflip_importer_ajax_import_demo' );

function circleflip_importer_themeoption( $theme_options ) {
	wp_enqueue_script( 'circleflip-import-demo', get_template_directory_uri() . '/inc/importer/circleflip-importer.js',array('wp-util') );
	wp_localize_script( 'circleflip-import-demo', 'circleflipOneClickDemo', array( 'nonce' => wp_create_nonce( 'circleflip-import-demo' ) ) );
	$theme_options[] = array(
		'id'	 => 'install-demo',
		'text'	 => 'Install demo content',
		'type'	 => 'import-demo'
	);
	return $theme_options;
}

function circleflip_importer_render() {
	ob_start();
	?>

	<button class="hide-if-no-js button-primary" id="install-demo" type="button">Install Demo</button>
	<div id="message"  style="margin: -8px 0 0 30px;display: block;float: left;">
		<p><strong>Please make sure that your memory limit exceeds <code>256MB</code></strong></p>
	</div>
	<span class="spinner" id="install-demo-spinner" style="float: left;"></span>
	<noscript>
	Javascript is disabled in your browser, Please enable it to install the demo.
	</noscript>
	<p class="fade" id="install-demo-support">Something went wrong please try again. If you continue to get this error, contact our <a href="http://creiden.com/forums">Support</a></p>
	<p class="fade" id="install-demo-required">These plugins are required for the demo to function properly, please install them and try again</p>
	<p class="fade" id="install-demo-success">Demo installed successfully, have fun :)</p>
	<table class="widefat fade" id="install-demo-plugins-list">
		<thead>
			<tr>
				<th>Plugin Name</th>
				<th>Description/Author</th>
			</tr>
		</thead>
		<tbody>

		</tbody>
	</table>
	<?php
	return ob_get_clean();
}

function circleflip_importer_ajax_import_demo() {
	check_ajax_referer( 'circleflip-import-demo' );
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die();
	}
	require_once get_template_directory() . '/inc/importer/class-circleflip-import.php';
	require_once get_template_directory() . '/inc/importer/class-circleflip-import-builder.php';
	require_once get_template_directory() . '/inc/importer/class-circleflip-import-meta.php';
	require_once get_template_directory() . '/inc/importer/class-circleflip-importer-plugin.php';
	if ( ! function_exists( 'plugins_api' ) ) {
		require_once ABSPATH . '/wp-admin/includes/plugin-install.php';
	}

	/**
	 * this function contributes to a stagaring 40% of memory consumption
	 * @link https://drive.google.com/a/creiden.com/file/d/0Bz8Brdcs3IthbDFwS3ZNbjgtcUU/edit?usp=sharing before
	 * @link https://drive.google.com/a/creiden.com/file/d/0Bz8Brdcs3Ithd3lqaHVPazVSNmc/edit?usp=sharing after
	 */
	remove_filter( 'sanitize_option_rojo', 'circleflip_optionsframework_validate' );
	circleflip_importer_check_plugins();
	set_time_limit( 0 );
	$import = new Circleflip_Import;
	new Circleflip_Import_Builder;
	new Circleflip_Import_Meta;
	ob_start();
	$import->import( get_template_directory() . '/inc/importer/export.xml' );
	$import->import_theme_options( get_template_directory() . '/inc/importer/options.php' );
	ob_end_clean();
	wp_send_json_success();
}

function circleflip_importer_check_plugins() {
	$req_plugins = circleflip_importer_validate_plugins( circleflip_importer_get_required_plugins() );
	if ( empty( $req_plugins ) ) {
		return;
	}
	$out = array();
	foreach ( $req_plugins as $plugin ) {
		$out[$plugin->Slug] = $plugin->get_data();
	}
	
	ob_start();
	?>
	<tr>
		<th rowspan="2"><%= data.Title %></th>
		<td><%= data.Description %></td>
	</tr>
	<tr>
		<td>by <%= data.Author %></td>
	</tr>
	<?php
	$template = ob_get_clean();
	
	wp_send_json_error( array( 'plugins' => $out, 'template' => $template ) );
}

function circleflip_importer_get_required_plugins() {
	$required_plugins = array(
		'contact-form-7' => array(),
		'bbpress'		 => array(),
		'woocommerce'	 => array(),
		'revslider'		 => array(
			'Title'			 => '<a href="http://www.themepunch.com/codecanyon/revolution_wp/" title="Visit plugin homepage">Revolution Slider</a>',
			'Name'			 => 'Revolution Slider',
			'PluginURI'		 => 'http://www.themepunch.com/codecanyon/revolution_wp/',
			'Version'		 => '3.0.95',
			'Description'	 => 'Revolution Slider &#8211; Premium responsive slider <cite>By <a href="http://themepunch.com" title="Visit author homepage">ThemePunch</a>.</cite>',
			'Author'		 => '<a href="http://themepunch.com" title="Visit author homepage">ThemePunch</a>',
			'AuthorName'	 => 'ThemePunch',
			'AuthorURI'		 => 'http://themepunch.com',
		),
	);

	foreach ( $required_plugins as $slug => $info ) {
		$required_plugins[$slug] = new Circleflip_Importer_Plugin( $slug, $info );
	}
	return $required_plugins;
}

function circleflip_importer_validate_plugins( $plugins ) {
	$installed_plugins = get_plugins();
	$installed_plugins_slugs = array_combine( array_keys( $installed_plugins ), array_keys( $installed_plugins ) );
	foreach ( $installed_plugins_slugs as $slug ) {
		//explode on '/' if the plugin is a folder otherwise '.'
		$parts = explode( ( false !== strpos( $slug, '/' ) ? '/' : '.' ), $slug );
		$installed_plugins_slugs[$slug] = $parts[0];
	}
	
	$required_plugins = array();
	foreach ( $plugins as $plugin ) {
		$slug = array_keys( $installed_plugins_slugs, $plugin->Slug );
		if ( false !== $slug && ! empty( $slug ) && is_plugin_active( $slug[0] ) ) {
			continue;
		}
		$required_plugins[] = $plugin;
	}
	return $required_plugins;
}

function circleflip_importer_fetch_local_file( $path ) {
	// extract the file name and extension from the url
	$file_name = basename( $path );
	if ( ! is_readable( $path ) ) {
		return new WP_Error( 'permissions_error', 'File doesnot exist ' . $path );
	}
	// get placeholder file in the upload dir with a unique, sanitized filename
	$upload = wp_upload_bits( $file_name, 0, file_get_contents( $path ) );
	if ( $upload['error'] )
		return new WP_Error( 'upload_dir_error', $upload['error'] );

	$filesize = filesize( $upload['file'] );

	if ( 0 == $filesize ) {
		@unlink( $upload['file'] );
		return new WP_Error( 'import_file_error', __( 'Zero size file downloaded', 'wordpress-importer' ) );
	}

	return $upload;
}

function circleflip_importer_memcmp( $mem_1, $mem_2 ) {
	$mem_1 = circleflip_importer_to_bytes( $mem_1 );
	$mem_2 = circleflip_importer_to_bytes( $mem_2 );
	
	return $mem_1 > $mem_2 ? 1 : ( $mem_1 < $mem_2 ? -1 : 0 );
}

function circleflip_importer_to_bytes( $r ) {
	$pattern = '/(\d+)(\w{1,2})/';
	$multipliers = array(
		'^kb?$'	 => 1024,
		'^mb?$'	 => 1024 * 1024,
		'^gb?$'	 => 1024 * 1024 * 1024,
	);
	if ( ! preg_match( $pattern, $r, $r ) ) {
		return 0;
	}

	foreach ( $multipliers as $modifier => $multiplier ) {
		if ( preg_match( "/$modifier/i", $r[2] ) ) {
			$r[1] *= $multiplier;
			break;
		}
	}

	return $r[1];
}
