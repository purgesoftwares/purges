<?php

if ( ! class_exists( 'Circleflip_Importer_Plugin' ) ) {

	/** Represent plugin info returned by Wordpress.org API
	 * 
	 * @author Creiden <info@creiden.com>
	 * 
	 * @property string $Name Plugin name.
	 * @property string $Title Plugin name wrapped in anchor-tag.
	 * @property string $Author Author name wrapped in anchor-tag.
	 * @property string $AuthorName Author name.
	 * @property string $AuthorURI Author url.
	 * @property string $Version Plugin's semver.
	 * @property string $LastUpdated plugin last update date.
	 * @property string $Description Plugin's short description.
	 * @property string $Slug Plugin's slug.
	 */
	class Circleflip_Importer_Plugin {

		static protected $fields = array(
			'homepage'			 => true,
			'last_updated'		 => true,
			'short_description'	 => true,
			// don't get the rest
			'downloaded'		 => false,
			'ratings'			 => false,
			'rating'			 => false,
			'description'		 => false,
			'donate_link'		 => false,
			'tags'				 => false,
			'sections'			 => false,
			'added'				 => false,
			'compatibility'		 => false,
			'tested'			 => false,
			'requires'			 => false,
			'downloadlink'		 => false,
		);
		protected $data = array();
		protected $slug = '';
		protected $_error = '';

		public function __construct( $slug, $data = array() ) {
			$this->slug = $slug;

			if ( ! empty( $data ) ) {
				$this->data = $this->transform_plugin_data( ( object ) $data );
			}
		}

		public function __get( $name ) {
			if ( false !== $this->data && empty( $this->data ) ) {
				$this->populate_plugin_data();
			}

			return isset( $this->data->$name ) ? $this->data->$name : false;
		}

		public function __isset( $name ) {
			if ( false !== $this->data && empty( $this->data ) ) {
				$this->populate_plugin_data();
			}

			return isset( $this->data->$name );
		}
		
		public function get_data() {
			if ( false !== $this->data && empty( $this->data ) ) {
				$this->populate_plugin_data();
			}
			return $this->data;
		}

		protected function populate_plugin_data() {
			$transient_key = "cfimporter_plugin_$this->slug";
			$transient = get_transient( $transient_key );
			if ( $transient ) {
				$this->data = $transient;
				return;
			}

			$this->data = $this->get_plugin_data_from_api();
			if ( ! is_wp_error( $this->_error ) ) {
				set_transient( $transient_key, $this->data, DAY_IN_SECONDS );
				return;
			}

			$this->data = false;
		}

		protected function get_plugin_data_from_api() {
			$data = plugins_api( 'plugin_information', array(
				'slug'	 => $this->slug,
				'is_ssl' => is_ssl(),
				'fields' => self::$fields,
					) );
			if ( ! is_wp_error( $data ) ) {
				return $this->transform_plugin_data( $data );
			} else {
				$this->_error = $data;
			}
			return false;
		}

		protected function transform_plugin_data( $data ) {
			$direct_mapping = array(
				'name'				 => 'Name',
				'version'			 => 'Version',
				'author'			 => 'Author',
				'last_updated'		 => 'LastUpdate',
				'short_description'	 => 'Description'
			);
			$data->Slug = $this->slug;
			foreach ( $direct_mapping as $key => $target ) {
				if ( ! empty( $data->$key ) ) {
					$data->$target = $data->$key;
				}
			}

			if ( isset( $data->homepage ) ) {
				$data->Title = sprintf( '<a href="%s">%s</a>', esc_url( $data->homepage ), $data->Name );
			}

			if ( isset( $data->author ) ) {
				$author_parts = array();
				preg_match( '/^<a href="(?P<src>[^"]+)">(?P<name>[^<]+)<\/a>$/', $data->author, $author_parts );
				$data->AuthorName = $author_parts['name'];
				$data->AuthorURI = $author_parts['src'];
			}
			return $data;
		}

	}

}