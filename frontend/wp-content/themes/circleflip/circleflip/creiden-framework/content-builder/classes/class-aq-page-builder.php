<?php
/**
 * AQ_Page_Builder class
 *
 * The core class that generates the functionalities for the
 * Aqua Page Builder. Almost nothing inside in the class should
 * be overridden by theme authors
 *
 * @since forever
 **/

if(!class_exists('AQ_Page_Builder')) {
	class AQ_Page_Builder {

		public $url;
		public $config = array();
		private $admin_notices;

		/**
		 * Stores public queryable vars
		 */
		function __construct( $config = array()) {
			$this->url = get_template_directory_uri() .'/creiden-framework/content-builder/';
			$defaults['menu_title'] = __('Page Builder', 'circleflip-builder');
			$defaults['page_title'] = __('Page Builder', 'circleflip-builder');
			$defaults['page_slug'] = __('aq-page-builder', 'circleflip-builder');
			$defaults['debug'] = false;

			$this->args = wp_parse_args($config, $defaults);

			$this->args['page_url'] = esc_url(add_query_arg(
				array('page' => $this->args['page_slug']),
				admin_url( 'themes.php' )
			));

		}

		/**
		 * Initialise Page Builder page and its settings
		 *
		 * @since 1.0.0
		 */
		function init() {

			add_action('add_meta_boxes', array(&$this, 'builder_page'));
			add_action('init', array(&$this, 'add_shortcode'));
			add_action('init', array(&$this, 'create_template'));
			add_action('template_redirect', array(&$this, 'preview_template'));
			add_filter('contextual_help', array(&$this, 'contextual_help'));
			if(!is_admin()) add_filter('init', array(&$this, 'view_enqueue'));
			add_action('admin_bar_menu', array(&$this, 'add_admin_bar'), 1000);

			/** TinyMCE button */
			add_filter('media_buttons_context', array(&$this, 'add_media_button') );
			add_action('admin_footer', array(&$this, 'add_media_display') );

		}

		/**
		 * Create Settings Page
		 *
		 * @since 1.0.0
		 */
		function builder_page() {
			//enqueue styles/scripts on the builder page
			add_action( 'edit_form_after_editor', array($this, 'emulate_metabox') );
			add_action( 'admin_print_styles-post.php', array(&$this, 'admin_enqueue') );
			add_action( 'admin_print_styles-post-new.php', array(&$this, 'admin_enqueue') );
		}

		function emulate_metabox( $post ) {
			$post_type = ! empty($post) ? $post->post_type : get_current_screen()->post_type;
			if ( 'page' !== $post_type )
				return;

			$box = array(
				'id'		 => $this->args['page_slug'],
				'title'		 => $this->args['page_title'],
				'callback'	 => array(&$this, 'builder_settings_show'),
			);
			$page = get_current_screen()->id;
			echo '<div id="' . $box['id'] . '" class="postbox ' . postbox_classes( $box['id'], $page ) . ' hidden" ' . '>' . "\n";
			echo '<div class="handlediv" title="' . esc_attr__( 'Click to toggle', 'circleflip-builder' ) . '"><br /></div>';
			echo "<h3 class='hndle'><span>{$box['title']}</span></h3>\n";
			echo '<div class="inside">' . "\n";
			call_user_func( $box['callback'], $post, $box );
			echo "</div>\n";
			echo "</div>\n";
		}
		/**
		 * Add shortcut to Admin Bar menu
		 *
		 * @since 1.0.4
		 */
		function add_admin_bar(){
			global $wp_admin_bar;

		}

		/**
		 * Register and enqueueu styles/scripts
		 *
		 * @since 1.0.0
		 * @todo min versions
		 */
		function admin_enqueue() {
			$wordpress_version = get_bloginfo('version');

			// Register 'em
			wp_register_style( 'aqpb-css', $this->url.'assets/css/aqpb.css', array(), time(), 'all');
			wp_register_style( 'aqpb-blocks-css', $this->url.'assets/css/aqpb_blocks.css', array(), time(), 'all');
			wp_register_style( 'bootstrap-3-modal', $this->url . 'assets/css/bootstrap.3.modal.css' );
			wp_register_style( 'bootstrap-3-tooltip', $this->url . 'assets/css/bootstrap-tooltip.css' );
			wp_register_style( 'bootstrap-3-popover', $this->url . 'assets/css/bootstrap-popover.css' );
			wp_register_style( 'jquery-ui', 'http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css' );
			wp_register_script( 'bootstrap-3-modal', $this->url . 'assets/js/bootstrap.3.modal.js', array( 'jquery' ) );
			wp_register_script( 'crdn-stackable-modals', $this->url . 'assets/js/jquery.stackablemodal.js', array( 'jquery', 'bootstrap-3-modal' ), null, true );
			wp_register_script( 'crdn-field-dependency', $this->url . 'assets/js/jquery.crdn.fielddependency.min.js', array( 'jquery', 'underscore' ), null, true );
			wp_register_script('bootstrap-js-tooltip', $this->url . 'assets/js/tooltip.js', array('jquery'), time(), true);
			wp_register_script( 'bootstrap-3-popover', $this->url . 'assets/js/bootstrap.3.popover.js', array( 'jquery','bootstrap-js-tooltip' ) );
			wp_register_script( 'cr_undo', $this->url . 'assets/js/cr_undo.js', array( 'jquery', 'crdn-stackable-modals', 'crdn-field-dependency' ), time(), true );

			if(version_compare($wordpress_version, '3.9','>=')) {
				wp_register_script( 'aqpb-js', $this->url . 'assets/js/aqpb3.9.js', array( 'jquery', 'crdn-stackable-modals', 'crdn-field-dependency', 'cr_undo' ), time(), true );
			}
			else {
				wp_register_script( 'aqpb-js', $this->url . 'assets/js/aqpb.js', array( 'jquery', 'crdn-stackable-modals', 'crdn-field-dependency', 'cr_undo' ), time(), true );
			}
			wp_register_script('aqpb-fields-js', $this->url . 'assets/js/aqpb-fields.js', array('jquery'), time(), true);
			// Enqueue 'em
			wp_enqueue_style('aqpb-css');
			wp_enqueue_style('aqpb-blocks-css');
			wp_enqueue_style('wp-color-picker');
			wp_enqueue_style('bootstrap-3-modal');
			wp_enqueue_style('bootstrap-3-tooltip');
			wp_enqueue_style('bootstrap-3-popover');
			wp_enqueue_style( 'jquery-ui' );
			wp_enqueue_script('jquery');
			wp_enqueue_script('jquery-ui-sortable');
			wp_enqueue_script('jquery-ui-tabs');
			wp_enqueue_script('jquery-ui-resizable');
			wp_enqueue_script('jquery-ui-draggable');
			wp_enqueue_script('jquery-ui-droppable');
			wp_enqueue_script('iris');
			wp_enqueue_script('wp-color-picker');
			wp_enqueue_script('bootstrap-js-tooltip');
			wp_enqueue_script('bootstrap-3-popover');
			wp_enqueue_script('cr_undo');
			wp_enqueue_script('aqpb-js');
			wp_enqueue_script('aqpb-fields-js');

			$googleFonts = implode('|',cr_get_option('cust_font',array()));
			if ($googleFonts != ''){
				$link = 'http://fonts.googleapis.com/css?family=' . preg_replace("/ /", "+", $googleFonts);
				wp_register_style('google_fonts',$link);
				wp_enqueue_style('google_fonts');
			}
			wp_localize_script('aqpb-js', 'global_creiden' , array(
				'ajax_url' => admin_url('admin-ajax.php'),
				'template_dir' => get_template_directory_uri(),
				'activate_revisions' => cr_get_option('activate_revisions_history'),
				'google_fonts' => cr_get_option('cust_font')
			));
			
			wp_localize_script('cr_undo', 'global_creiden' , array(
				'ajax_url' => admin_url('admin-ajax.php'),
				'template_dir' => get_template_directory_uri()
			));

			// Media library uploader
			wp_enqueue_script('thickbox');
	        wp_enqueue_style('thickbox');
	        wp_enqueue_script('media-upload');
	        wp_enqueue_media();

			// Hook to register custom style/scripts
			do_action('circleflip_aq-page-builder-admin-enqueue');

		}

		/**
		 * Register and enqueueu styles/scripts on front-end
		 *
		 * @since 1.0.0
		 * @todo min versions
		 */
		function view_enqueue() {

			// front-end css
			wp_register_style( 'aqpb-view-css', $this->url.'assets/css/aqpb-view.css', array(), time(), 'all');
			wp_enqueue_style('aqpb-view-css');

			// front-end js
			wp_register_script('aqpb-view-js', $this->url . 'assets/js/aqpb-view.js', array('jquery'), time(), true);
			wp_enqueue_script('aqpb-view-js');

			//hook to register custom styles/scripts
			do_action('circleflip_aq-page-builder-view-enqueue');

		}

		/**
		 * Checks if template with given id exists
		 *
		 * @since 1.0.0
		 */
		function is_template($template_id) {

			$template = get_post($template_id);

			if($template) {
				if($template->post_type != 'template' || $template->post_status != 'publish') return false;
			} else {
				return false;
			}

			return true;

		}

		/**
		 * Retrieve all blocks from on Save
		 *
		 * @return	array - $blocks
		 * @since	1.0.0
		 */
		function get_blocks($template_id) {
			//verify template
			//filter post meta to get only blocks data
			$blocks = array();
			if(isset($_POST['aq_blocks']) && !empty($_POST['aq_blocks'])) {
			$all = $_POST['aq_blocks'];
			foreach($all as $key => $block) {
				if(substr($key, 0, 9) == 'aq_block_' && substr($key, 8, 14) != '___i__') {
					$block_instance = $all[$key];
					if(is_array($block_instance)) $blocks[$key] = $block_instance;
				}
			}
			
			//sort by order
			$sort = array();
			foreach($blocks as $block) {
				$sort[] = $block['order'];
			}
			array_multisort($sort, SORT_NUMERIC, $blocks);
			}

			return $blocks;

		}

		/**
		 * Display template blocks
		 *
		 * @since	1.0.0
		 */
		function display_template_blocks( $blocks ) {
			$saved_blocks = $blocks;
			//verify template
			$blocks = is_array($blocks) ? $blocks : array();
			$blocks = unserialize($blocks[0]);
			//return early if no blocks
			if(empty($blocks)) {
				echo '<p class="empty-template">';
				echo __('Drag block items from the left into this area to begin building your template.', 'circleflip-builder');
				echo '</p>';
				return;

			} else {
				//outputs the blocks
				foreach($blocks as $key => $instance) {
					global $aq_registered_blocks;
					if(isset($instance) && !empty($instance) && $instance !=FALSE && is_array($instance)) {
					extract($instance);
						if(isset($aq_registered_blocks[$id_base])) {
							//get the block object
							$block = $aq_registered_blocks[$id_base];
							//insert template_id into $instance
							$instance['template_id'] = $template_id;

							//display the block
							if($parent == 0) {
								$block->form_callback($instance,$saved_blocks);
							}
						}
					}
				}
			}
		}

		/**
		 * Retrieve all blocks for UI
		 * @param $importer: Boolean to check if data is being imported to push the added blocks to the saved blocks
		 * @return	array - $blocks
		 * @since	1.0.0
		 */
		function retrieve_blocks($post_id,$saved_blocks = array(), $importer = false) {
			$blocks = array();
			$all = get_post_meta($post_id);
			$valid_all = false;
			if($all) {
				foreach($all as $key => $block) {
					if(substr($key, 0, 9) == 'aq_block_' && substr($key, 8, 14) != '___i__')
						$valid_all = true;
				}
				if((!$valid_all && isset($saved_blocks) && !empty($saved_blocks)) || $importer) {
					$all = $saved_blocks;
				}
				foreach($all as $key => $block) {
					if(substr($key, 0, 9) == 'aq_block_' && substr($key, 8, 14) != '___i__') {
						$block_instance = $all[$key];
						if(is_array($block_instance)) $blocks[$key] = $block_instance;
					}
				}
	
				//sort by order
				$sort = array();
				$block_mod_array = array();
	
				foreach($blocks as $key => $block) {
					if(isset($block[0])) {
						$saving_template = false;
						$temp = unserialize($block[0]);
					} else {
						$saving_template = true;
						if(is_array($block)) {
							$temp = $block;
							$blocks[$key] = array(serialize($block));
						} else {
							$temp = unserialize($block);
						}
					}
					if(isset($temp['order']))
						$sort[] = $temp['order'];
					else
						$sort[] = '';
				}
				array_multisort($sort, SORT_NUMERIC, $blocks);
			}
			return $blocks;
		}
		/**
		 * Display blocks archive
		 *
		 * @since	1.0.0
		 */
		function blocks_archive() {

			global $aq_registered_blocks;
			$tabs = $this->group_by_tab( $aq_registered_blocks );
			echo "<ul>";
			foreach ( array_keys( $tabs ) as $tab_nav ) {
				echo "<li><a href='#aq-builder-{$tab_nav}-tab'>" . ucwords( str_replace( array('-', '_'), ' ', $tab_nav ) ) . "</a></li>";
			}
			echo "<li style='float: right;margin-top: 4px;'><input type='text' placeholder='Live Search' id='cr_builder_search' /></li>";
			echo "</ul>";
			foreach( $tabs as $tab => $blocks ) {
				echo "<ul id='aq-builder-{$tab}-tab'>";
				foreach ( $blocks as $block ) {
					$block->form_callback();
				}
				echo '</ul>';
			}
		}

		function group_by_tab( $blocks ) {
			$grouped = array('others' => '');
			foreach ( $blocks as $block ) {
				$tab = isset( $block->block_options['tab'] ) ? $block->block_options['tab'] : 'others';
				if ( ! isset( $grouped[ $tab ] ) ) {
					$grouped[ $tab ] = array();
				}
				$grouped[ $tab ][] = $block;
			}
                        if ( empty($grouped['others'])) {
                            unset($grouped['others']);
                        }
			if ( ! empty( $grouped['Layout'] ) ) {
				$layout = array( 'Layout' => $grouped['Layout'] );
				unset( $grouped['Layout'] );
				$grouped = $layout + $grouped;
			}
			uksort( $grouped, 'strnatcmp' );
                        foreach($grouped as $tab => $blocks ) {
                            usort($grouped[$tab], array($this, 'sort_by_name'));
                        }
			return $grouped;
		}

                function sort_by_name($a, $b) {
                    return strnatcmp($a->name, $b->name);
                }

		/**
		 * Display template blocks
		 *
		 * @since	1.0.0
		 */
		function display_blocks( $template_id ) {
			//verify template
			$blocks = $this->retrieve_blocks($template_id);
			$blocks = is_array($blocks) ? $blocks : array();
			$saved_blocks = $blocks;
			foreach ($blocks as $keys => $values) {
				foreach ($values as $key => $value) {
					$blocks[$keys] = unserialize($value);
				}
			}
			//return early if no blocks
			if(empty($blocks)) {
				echo '<p class="empty-template">';
				echo __('Drag block items from the left into this area to begin building your template.', 'circleflip-builder');
				echo '</p>';
				return;

			} else {
				//outputs the blocks
				foreach($blocks as $key => $instance) {
					global $aq_registered_blocks;
					if(isset($instance) && !empty($instance) && $instance !=FALSE && is_array($instance)) {
					extract($instance);
					if(isset($id_base) && isset($aq_registered_blocks[$id_base])) {
						//get the block object
						$block = $aq_registered_blocks[$id_base];
						//insert template_id into $instance
						$instance['template_id'] = $template_id;

						//display the block
						if($parent == 0) {
							$block->form_callback($instance,$saved_blocks);
						}
					}
					}
				}
			}

		}

		/**
		 * Get all saved templates
		 *
		 * @since	1.0.0
		 */
		function get_templates() {

			$args = array (
				'nopaging' => true,
				'post_type' => 'template',
				'status' => 'publish',
				'orderby' => 'title',
				'order' => 'ASC',
			);

			$templates = get_posts($args);

			return $templates;

		}
		/**
		 * Creates a new template
		 *
		 * @since	1.0.0
		 */
		function create_template() {

			//create new template only if title don't yet exist
			if(!get_page_by_title( 'pageTemplate', 'OBJECT', 'template' )) {
				//set up template name
				$template = array(
					'post_title' => wp_strip_all_tags('pageTemplate'),
					'post_type' => 'template',
					'post_status' => 'publish',
				);

				//create the template
				$template_id = wp_insert_post($template);

			} else {
				return new WP_Error('duplicate_template', 'Template names must be unique, try a different name');
			}

			//return the new id of the template
			return $template_id;

		}

		/**
		 * Function to update templates
		 *
		 * @since	1.0.0
		**/
		function update_template($template_id, $blocks, $title) {

			//first let's check if template id is valid
			if(!$this->is_template($template_id)) wp_die('Error : Template id is not valid');

			//wp security layer
			check_admin_referer( 'update-template', 'update-template-nonce' );

			//update the title
			$template = array('ID' => $template_id, 'post_title'=> $title);
			wp_update_post( $template );

			//now let's save our blocks & prepare haystack
			$blocks = is_array($blocks) ? $blocks : array();
			$haystack = array();
			$template_transient_data = array();
			$i = 1;

			foreach ($blocks as $new_instance) {
				global $aq_registered_blocks;global $post;

				$old_key = isset($new_instance['number']) ? 'aq_block_' . $new_instance['number'] : 'aq_block_0';
				$new_key = isset($new_instance['number']) ? 'aq_block_' . $i : 'aq_block_0';

				$old_instance = get_post_meta($template_id, $old_key, true);

				extract($new_instance);

				if(class_exists($id_base)) {
					//get the block object
					$block = $aq_registered_blocks[$id_base];

					//insert template_id into $instance
					$new_instance['template_id'] = $template_id;

					//sanitize instance with AQ_Block::update()
					$new_instance = $block->update($new_instance, $old_instance);
				}

				//update block
				update_post_meta($template_id, $new_key, $new_instance);

				//store instance into $template_transient_data
				$template_transient_data[$new_key] = $new_instance;

				//prepare haystack
				$haystack[] = $new_key;

				$i++;
			}

			//update transient
			$template_transient = 'aq_template_' . $template_id;
			add_post_meta( $post->ID, $template_transient, $template_transient_data );
			//use haystack to check for deleted blocks
			$curr_blocks = $this->get_blocks($post->ID);
			$curr_blocks = is_array($curr_blocks) ? $curr_blocks : array();
			foreach($curr_blocks as $key => $block){
				if(!in_array($key, $haystack))
					delete_post_meta($template_id, $key);
			}

		}

		/**
		 * Delete page template
		 *
		 * @since	1.0.0
		**/
		function delete_template($template_id) {

			//first let's check if template id is valid
			if(!$this->is_template($template_id)) return false;

			//wp security layer
			check_admin_referer( 'delete-template', '_wpnonce' );

			//delete template, hard!
			wp_delete_post( $template_id, true );

			//delete template transient
			$template_transient = 'aq_template_' . $template_id;
			delete_transient( $template_transient );

		}

		/**
		 * Preview template
		 *
		 * Theme authors should attempt to make the preview
		 * layout to be consistent with their themes by using
		 * the filter provided in the function
		 *
		 * @since	1.0.0
		 */
		function preview_template() {

			global $wp_query, $aq_page_builder;
			$post_type = $wp_query->query_vars['post_type'];
			if($post_type == 'page') {
				get_header();
				?>
					<div id="main" class="cf">
						<div id="content" class="cf">
							<?php $this->display_template(get_the_ID()); ?>
							<?php if($this->args['debug'] == true) print_r(circleflip_get_blocks(get_the_ID())) //for debugging ?>
						</div>
					</div>
				<?php
				get_footer();
				exit;
			}

		}

		/**
		 * Display the template on the front end
		 *
		 * @since	1.0.0
		**/
		function display_template($template_id) {
			global $post;
			//get transient if available
			$template_transient = 'aq_template_' . $template_id;
			//$template_transient_data = get_transient($template_transient);
			$template_transient_data = get_post_meta($post->ID, $template_transient);
			if($template_transient_data == false) {
				// Get the real data from the Original page
				if( function_exists('icl_object_id') ) {
					global $sitepress;
					$active_lang = $sitepress->get_active_languages();
					$current_lang = $sitepress->get_current_language();
					// remove the current language from the array
					unset($active_lang[$current_lang]);
					// check for the meta in the original
					foreach ($active_lang as $key => $value) {
						$original_ID = icl_object_id( $post->ID, 'page', false, $key);
						$original_ID = intval($original_ID);
						$template_transient = 'aq_template_' . $original_ID;
						$template_transient_data = get_post_meta($original_ID, $template_transient);
						if($template_transient_data != false) {
							$blocks = $template_transient_data;
							break;
						}
					}
					if($template_transient_data == false) {
						$blocks = $this->retrieve_blocks($template_id);
					} else {
						$blocks = $template_transient_data;
					}
				} else {
					$blocks = $this->retrieve_blocks($template_id);
				// $blocks = $this->get_blocks($template_id);
				}

			} else {
				$blocks = $template_transient_data;
			}

			if(is_array($blocks) && !empty($blocks)) {
				$blocks = $blocks[0];
			} else {
				$blocks = array();
			}
			//return early if no blocks
			if(!empty($blocks)) {
				$saved_blocks = $blocks;
				$overgrid = 0; $span = 0; $first = false;

				// 6,5,7,9,2,6
				$rows = array();
				$running_total = 0;
				$current_row = array();
				foreach ( $blocks as $key => $instance ) {
					if ( 0 != $instance['parent'] ) {
						continue;
					}
					if ( isset( $instance['fullwidthSlider'] ) && 'fullwidth' == $instance['fullwidthSlider'] ) {
						if ( ! empty( $current_row ) ) {
							// only flush the row when we have something in it
							$rows[] = $current_row;
							$current_row = array();
						}
						$running_total = 0;
						$rows[] = $instance;
						continue;
					}
					// find block size
					$col_size = absint( preg_replace( "/[^0-9]/", '', $instance['size'] ) );
					// increment this row's total length
					$running_total += $col_size;
					if ( 12 < $running_total ) {
						// flush current row, we're overflowing
						$rows[] = $current_row;
						$current_row = array();
						// reset running_total
						$running_total = $col_size;
						// add our big block to the newly created row
						$current_row[] = $instance;
						// add 'has_background' to the relevant row
						// we're doing this after flushing the current row
						// handling the short rows & first block with background
						if ( isset( $instance['fullwidthSlider'] ) && 'full-width-column' == $instance['fullwidthSlider'] ) {
							$current_row['has_background'] = $instance;
						}
					} else if ( 12 == $running_total ) {
						// is this a row background ?
						if ( isset( $instance['fullwidthSlider'] ) && 'full-width-column' == $instance['fullwidthSlider'] ) {
							$current_row['has_background'] = $instance;
						}
						// blocks just add up to 12, perfect :)
						$current_row[] = $instance;
						// flush & reset
						$rows[] = $current_row;
						$running_total = 0;
						$current_row = array();
					} else {
						// is this a row background ?
						if ( isset( $instance['fullwidthSlider'] ) && 'full-width-column' == $instance['fullwidthSlider'] ) {
							$current_row['has_background'] = $instance;
						}
						// we still have room for more blocks
						$current_row[] = $instance;
					}
				}
				if ( ! empty($current_row) ) {
					// our last row blocks don't add up to 12
					// add them and clear $current_row
					$rows[] = $current_row;
					$current_row = null;
				}
				global $aq_registered_blocks;
				//outputs the blocks
				foreach( $rows as $row ) {
					if ( ! empty( $row['has_background'] ) ) {
						$class = '';
						$block = $aq_registered_blocks[$row['has_background']['id_base']];
						list($before, $after) = $block->get_background( $row['has_background'], $saved_blocks );
						unset( $row['has_background'] );
					} elseif ( isset( $row['fullwidthSlider'] ) ) {
						$class = 'row-fluid';
						$row = array($row);
						$before = $after = '';
					} else {
						$class = 'container';
						$before = $after = '';
					}
					echo '<div class="backgroundBlock"> <div class="' . $class . '">';
					echo $before;
					foreach($row as $key => $instance) {
						extract($instance);
						if(class_exists($id_base)) {
							//get the block object
							$block = $aq_registered_blocks[$id_base];

							//insert template_id into $instance
							$instance['template_id'] = $template_id;

							//display the block
							if($parent == 0) {

								$col_size = absint(preg_replace("/[^0-9]/", '', $size));

								$overgrid = $span + $col_size;

								if($overgrid > 12 || $span == 12 || $span == 0) {
									$span = 0;
									$first = true;
								}

								if($first == true) {
									$instance['first'] = true;
								}

								$block->block_callback($instance,$saved_blocks);

								$span = $span + $col_size;

								$overgrid = 0; //reset $overgrid
								$first = false; //reset $first
							}
						}
					}
					echo $after;
					echo '</div></div>';
				}
			}
		}

		/**
		 * Add the [template] shortcode
		 *
		 * @since 1.0.0
		 */
		function add_shortcode() {

			global $shortcode_tags;
			if ( !array_key_exists( 'template', $shortcode_tags ) ) {
				add_shortcode( 'template', array(&$this, 'do_shortcode') );
			} else {
				add_action('admin_notices', create_function('', "echo '<div id=\"message\" class=\"error\"><p><strong>Aqua Page Builder notice: </strong>'. __('The \"[template]\" shortcode already exists, possibly added by the theme or other plugins. Please consult with the theme author to consult with this issue', 'circleflip-builder') .'</p></div>';"));
			}

		}

		/**
		 * Shortcode function
		 *
		 * @since 1.0.0
		 */
		function do_shortcode($atts, $content = null) {

			$defaults = array('id' => 0);
			extract( shortcode_atts( $defaults, $atts ) );

			//capture template output into string
			ob_start();
				$this->display_template($id);
				$template = ob_get_contents();
			ob_end_clean();

			return $template;

		}


		/**
		 * Media button shortcode
		 * 
		 * NOOP
		 * 
		 * @since 1.0.6
		 */
		function add_media_button( $button ) {
			return $button;
		}

		/**
		 * Media button display
		 *
		 * @since 1.0.6
		 */
		function add_media_display() {

			global $pagenow;

			/** Only run in post/page new and edit */
			if ( in_array( $pagenow, array( 'post.php', 'page.php', 'post-new.php', 'post-edit.php' ) ) ) {
				/** Get all published templates */
				$templates = get_posts( array(
					'post_type' 		=> 'template',
					'posts_per_page'	=> -1,
					'post_status' 		=> 'publish',
					'order'				=> 'ASC',
					'orderby'			=> 'title'
		    		)
				);

				?>
				<script type="text/javascript">
					function insertTemplate() {
						var id = jQuery( '#select-aqpb-template' ).val();

						/** Alert user if there is no template selected */
						if ( '' == id ) {
							alert("<?php echo esc_js( __( 'Please select your template first!', 'circleflip-builder' ) ); ?>");
							return;
						}

						/** Send shortcode to editor */
						window.send_to_editor('[template id="' + id + '"]');
					}
				</script>

				<div id="aqpb-iframe-container" style="display: none;">
					<div class="wrap" style="padding: 1em">

						<?php do_action( 'circleflip_aqpb_before_iframe_display', $templates ); ?>

						<?php
						/** If there is no template created yet */
						if ( empty( $templates ) ) {
							echo sprintf( __( 'You don\'t have any template yet. Let\'s %s create %s one!', 'circleflip-builder' ), '<a href="' .admin_url().'themes.php?page=aq-page-builder">', '</a>' );
							return;
						}
						?>

						<h3><?php _e( 'Choose Your Page Template', 'circleflip-builder' ); ?></h3><br />
						<select id="select-aqpb-template" style="clear: both; min-width:200px; display: inline-block; margin-right: 3em;">
						<?php
							foreach ( $templates as $template )
								echo '<option value="' . absint( $template->ID ) . '">' . esc_attr( $template->post_title ) . '</option>';
						?>
						</select>

						<input type="button" id="aqpb-insert-template" class="button-primary" value="<?php echo esc_attr__( 'Insert Template', 'circleflip-builder' ); ?>" onclick="insertTemplate();" />
						<a id="aqpb-cancel-template" class="button-secondary" onclick="tb_remove();" title="<?php echo esc_attr__( 'Cancel', 'circleflip-builder' ); ?>"><?php echo esc_attr__( 'Cancel', 'circleflip-builder' ); ?></a>

						<?php do_action( 'circleflip_aqpb_after_iframe_display', $templates ); ?>

					</div>
				</div>

				<?php
			} /** End Coditional Statement for post, page, new and edit post */

		}

		/**
		 * Contextual help tabs
		 *
		 * @since 1.0.0
		 */
		function contextual_help() {

			$screen = get_current_screen();
			$contextual_helps = apply_filters('circleflip_aqpb_contextual_helps', array());


		}

		/**
		 * Main page builder settings page display
		 *
		 * @since	1.0.0
		 */
		function builder_settings_show($post){
			echo '<input type="hidden" name="rojo_mb_nonce-page_builder" value="' . wp_create_nonce('rojo_mb_nonce-page_builder') . '" />';
			$activate_builder = get_post_meta($post->ID, 'page_builder');
			require_once AQPB_PATH . 'view/view-settings-page.php';
			?>
			<input type="hidden" name="rojo[page_builder]" value="1"/>
			<div class="exportWrapper">
				<ul>
					<li>
						<h3>Export All Builder Templates</h3>
						<textarea id="exportBuilderTemplate" rows="8" cols="40"><?php echo base64_encode(serialize(get_option('builderSavedTemp'))); ?></textarea>
					</li>
					<li style="border-right:0">
						<h3>
							<a href="#" id="retrievePosts">Export This Page Blocks</a>
						</h3>
						<textarea id="retrieveBuilderTemplate" rows="8" cols="40"></textarea>
					</li>
					<li>
						<h3>Exported Block</h3>
						<textarea id="exportedBlock" rows="8" cols="40"></textarea>
					</li>
				</ul>
			</div>
			<div class="importWrapper">
				<ul>
					<li>
						<h3> Import All Builder Templates </h3>
							<textarea id="importBuilderTemplate" name="builderSavedTemp" rows="8" cols="40"></textarea>
					</li>
				</ul>
			</div>
			<?php
		}

		function post_content_builder_mb_save() {
			global $post;
			$template_id = isset($_POST['post_ID']) ? $_POST['post_ID'] : '';
			/*Security Check*/
		    if (!isset($_POST['rojo_mb_nonce-page_builder']) || !wp_verify_nonce($_POST['rojo_mb_nonce-page_builder'], 'rojo_mb_nonce-page_builder'))
				return $template_id;

		   //now let's save our blocks & prepare haystack
			$blocks = AQ_Page_Builder::get_blocks($template_id);
			$haystack = array();
			$template_transient_data = array();
			$i = 1;

			foreach ($blocks as $new_instance) {
				global $aq_registered_blocks;global $post;

				$old_key = isset($new_instance['number']) ? 'aq_block_' . $new_instance['number'] : 'aq_block_0';
				$new_key = isset($new_instance['number']) ? 'aq_block_' . $i : 'aq_block_0';

				$old_instance = get_post_meta($template_id, $old_key, true);

				extract($new_instance);


				if(class_exists($id_base)) {
					//get the block object
					$block = $aq_registered_blocks[$id_base];

					//insert template_id into $instance
					$new_instance['template_id'] = $template_id;
					//sanitize instance with AQ_Block::update()
					$new_instance = $block->update($new_instance, $old_instance);
				}
				//update block
				update_post_meta($template_id, $new_key, $new_instance);

				//store instance into $template_transient_data
				$template_transient_data[$new_key] = $new_instance;

				//prepare haystack
				$haystack[] = $new_key;

				$i++;
			}
			//update transient
			$template_transient = 'aq_template_' . $template_id;
			update_post_meta( $template_id, $template_transient, $template_transient_data );
			//use haystack to check for deleted blocks
			$curr_blocks = AQ_Page_Builder::retrieve_blocks($template_id);
			//$curr_blocks = $this->get_blocks($template_id);
			$curr_blocks = is_array($curr_blocks) ? $curr_blocks : array();
			foreach($curr_blocks as $key => $block){
				if(!in_array($key, $haystack)) {
					delete_post_meta($template_id, $key);
				}
			}
			$activate_builder = $_POST['rojo']['page_builder'];
            $old = get_post_meta($template_id, 'page_builder',$activate_builder, true);
            $new = $activate_builder;
            if ($new && $new != $old) {
                update_post_meta($template_id, 'page_builder', $new);
            } elseif ('' == $new && $old) {
                delete_post_meta($template_id, 'page_builder', $old);
            }
		    return $template_id;
		}
	}
}
// not much to say when you're high above the mucky-muck