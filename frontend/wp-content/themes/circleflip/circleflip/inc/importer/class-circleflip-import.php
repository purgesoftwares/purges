<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/** Display verbose errors */
define( 'IMPORT_DEBUG', false );

// Load Importer API
require_once ABSPATH . 'wp-admin/includes/import.php';

if ( ! class_exists( 'WP_Importer' ) ) {
	$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
	if ( file_exists( $class_wp_importer ) )
		require $class_wp_importer;
}
require_once plugin_dir_path( __FILE__ ) . 'bootstrap.php';

/**
 * Description of class-circleflip-import
 *
 * @author ayman
 */
class Circleflip_Import extends WP_Import {

	protected $woocommerce_galleries = array();

	public function import( $file ) {
		add_filter( 'wp_import_post_comments', '__return_empty_array' );
		add_filter( 'import_post_meta_key', array( $this, 'is_valid_meta_key' ) );
		add_filter( 'http_request_timeout', array( &$this, 'bump_request_timeout' ) );

		$this->import_start( $file );
		global $wpdb;
		$this->get_author_mapping();
		wp_suspend_cache_invalidation( true );
		$wpdb->query( 'SET autocommit = 0' );
		$this->process_categories();
		$this->process_tags();
		$this->process_terms();
		$this->process_posts();
		$wpdb->query( 'COMMIT' );
		$wpdb->query( 'SET autocommit = 1' );
		wp_suspend_cache_invalidation( false );

		// update incorrect/missing information in the DB
		$this->backfill_parents();

		$this->import_end();
	}

	public function get_author_mapping() {
		$demo_user = get_user_by( 'login', 'circleflip_demo' );
		if ( ! $demo_user ) {
			$demo_user = wp_create_user( 'circleflip_demo', wp_generate_password() );
			if ( ! is_wp_error( $demo_user ) ) {
				$demo_user = get_user_by( 'id', $demo_user );
			} else {
				$demo_user = wp_get_current_user();
			}
		}

		foreach ( $this->authors as $author ) {
			$old_login = sanitize_user( $author['author_login'], true );
			$old_id = isset( $author['author_id'] ) ? intval( $author['author_id'] ) : false;

			if ( $old_id ) {
				$this->processed_authors[$old_id] = $demo_user->ID;
			}
			$this->author_mapping[$old_login] = $demo_user->ID;
		}
	}

	public function is_valid_meta_key( $key ) {
		// skip _edit_lock as not relevant for import
		if ( in_array( $key, array( '_edit_lock' ) ) )
			return false;
		return $key;
	}

	public function import_end() {
		wp_cache_flush();
		foreach ( get_taxonomies() as $tax ) {
			delete_option( "{$tax}_children" );
			_get_term_hierarchy( $tax );
		}

		wp_defer_term_counting( false );
		wp_defer_comment_counting( false );

		echo '<p>' . __( 'All done.', 'wordpress-importer' ) . ' <a href="' . admin_url() . '">' . __( 'Have fun!', 'wordpress-importer' ) . '</a>' . '</p>';
		echo '<p>' . __( 'Remember to update the passwords and roles of imported users.', 'wordpress-importer' ) . '</p>';

		do_action( 'import_end' );
	}

	function allow_fetch_attachments() {
		return false;
	}

	public function import_theme_options( $file ) {
		$opts = include_once $file;
		foreach ( $opts as $op_n => $op_v ) {
			if ( 'page_on_front' == $op_n && isset( $this->processed_posts[$op_v] ) ) {
				$op_v = $this->processed_posts[$op_v];
			}
			if ( 'theme_mods' == $op_n ) {
				$op_n = 'theme_mods_' . get_option( 'stylesheet' );
				if ( isset( $op_v['nav_menu_locations'] ) ) {
					foreach ( $op_v['nav_menu_locations'] as $i => $location ) {
						$op_v['nav_menu_locations'][$i] = $this->processed_terms[$location];
					}
				}
			}
			update_option( $op_n, $op_v );
		}
	}

}
