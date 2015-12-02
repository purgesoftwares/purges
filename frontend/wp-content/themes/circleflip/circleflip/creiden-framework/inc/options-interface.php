<?php
/**
 * Generates the tabs that are used in the options menu
 */
require_once 'google.fonts';

function circleflip_optionsframework_tabs() {
	$counter = $counter2 = 0;
	$options = circleflip_optionsframework_options();
	$menu = '<ul class="menuWrapper">';

	foreach ( $options as $value ) {
		// Heading for Navigation
		if ( $value['type'] == "heading" ) {
			$counter ++;
			$class = '';
			$value['class'] = isset( $value['class'] ) ? $value['class'] : '';
			$class = ! empty( $value['id'] ) ? $value['id'] : $value['name'];
			$class = preg_replace( '/[^a-zA-Z0-9._\-]/', '', strtolower( $class ) ) . '-tab';
			$menu .= '<li class="nav-tab ' . $class . ' ' . $value['class'] . '">';
			if ( isset( $value['icon_name'] ) ) {
				$menu .= '<img src="' . $value['icon_name'] . '" alt=""/>';
			}
			$menu .= '<a id="options-group-' . $counter . '-tab"  title="' . esc_attr( $value['name'] ) . '" href="' . esc_attr( '#options-group-' . $counter ) . '">' . esc_html( $value['name'] ) . '</a></li>';
		}
	}
	$menu .= '</ul>';
	return $menu;
}

/**
 * Generates the options fields that are used in the form.
 */
$counter = 0;
$builder_counter = 0;
$val = '';
$val_modified = '';

function circleflip_optionsframework_fields() {
	$optionsframework_settings = get_option( 'optionsframework' );
	// Gets the unique option id
	if ( isset( $optionsframework_settings['id'] ) ) {
		$option_name = $optionsframework_settings['id'];
	} else {
		$option_name = 'options_framework_theme';
	};

	$options = circleflip_optionsframework_options();

	$menu = '';

	foreach ( $options as $value ) {
		$val = '';
		$output = circleflip_optionsframework_options_interface( $value, $option_name );
		echo $output;
	}
	echo '</div>';
}

function circleflip_optionsframework_options_interface( $value, $option_name, $parent = '' ) {
	global $allowedtags, $builder_counter, $counter, $val, $fonts_global_array;
	if ( $builder_counter == '' ) {
		$builder_counter = 0;
	}
	$settings = get_option( $option_name );

	$select_value = '';
	$checked = '';
	if ( isset( $output ) ) {
		
	} else {
		$output = '';
	}
	$value_extratag = isset( $value['extraTag'] ) ? "[{$value['extraTag']}]" : '';
	// Wrap all options
	if ( ($value['type'] != "heading") && ($value['type'] != "info") && (empty( $value['builder_type'] ) || $value['builder_type'] != "builderOption") ) {

		if ( $value['type'] == "pageBuilder" && $value_extratag == '[closeBuilder]' ) {
			
		} else {
			// Keep all ids lowercase with no spaces
			if ( ! isset( $value['id'] ) ) {
				echo $value['name'];
			}
			$value['id'] = preg_replace( '/[^a-zA-Z0-9._\-]/', '', strtolower( $value['id'] ) );

			$id = 'section-' . $value['id'];

			$class = 'section';

			if ( isset( $value['type'] ) ) {
				$class .= ' section-' . $value['type'];
			}
			if ( isset( $value['class'] ) ) {
				$class .= ' ' . $value['class'];
			}
			if ( isset( $value_extratag ) ) {
				if ( $value_extratag == '[openDiv]' ) {
					$output .= '<div class="sections_wrapper">';
				}
			}

			$output .= '<div id="' . esc_attr( $id ) . '" class="' . esc_attr( $class ) . '">' . "\n";
			if ( isset( $value['name'] ) ) {
				$output .= '<h4 class="heading">' . esc_html( $value['name'] ) . '</h4>' . "\n";
			}
			if ( $value['type'] != 'editor' ) {
				$output .= '<div class="option">' . "\n" . '<div class="controls">' . "\n";
			} else if ( $value['type'] == 'editor' ) {
				$output .= '<div class="option">' . "\n" . '<div>' . "\n";
			}

			if ( $value['type'] == "pageBuilder" && $value_extratag == '[openBuilder]' ) {
				$output .= '<ul id="sortable">';
			}
		}
	} else if ( ! empty( $value['builder_type'] ) && $value['builder_type'] == "builderOption" ) {

		$value['id'] = preg_replace( '/[^a-zA-Z0-9._\-]/', '', strtolower( $value['id'] ) );
		if ( $value_extratag == '[openTab]' ) {

			$output .= '<li class="' . $value['tab_class'] . '" >';

			$output .= '<div class="widget-head"> ' . $value["tab_name"] . '
							<span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
							<span class="plus-icon"></span>
							<span class="minus-icon"></span>
							<span class="remove-icon"></span>
						</div>
						<div class="widget-content">';
		}
	}

	// Set default value to $val
	if ( isset( $value['std'] ) ) {
		if ( $parent != '' ) {
			$val_modified = $value['std'];
		} else {
			$val = $value['std'];
		}
	}
	// If the option is already saved, ovveride $val
	if ( ($value['type'] != 'heading') && ($value['type'] != 'info') ) {
		if ( isset( $settings[$value['id']] ) ) {
			if ( $parent != '' ) {
				$val_modified = $settings[$value['id']];
			} else {
				$val = $settings[$value['id']];
			}
			if ( ! is_array( $val ) ) {
				$val = stripslashes( $val );
			}
		}
	}

	// If there is a description save it for labels
	$explain_value = '';
	if ( isset( $value['desc'] ) ) {
		$explain_value = $value['desc'];
	}

	$value_class = isset( $value['class'] ) ? $value['class'] : '';
	$value_placeholder = isset( $value['placeholder'] ) ? $value['placeholder'] : '';
	$value_wrappertype = isset( $value['wrapper_type'] ) ? $value['wrapper_type'] : '';
	$value_children = isset( $value['children'] ) ? $value['children'] : '';
	switch ( $value['type'] ) {
		// page builder
		case 'pageBuilder':
			if ( isset( $value['children'] ) ) {
				foreach ( $value['children'] as $key => $children_value ) {
					foreach ( $children_value as $k => $children_second_value ) {
						$output .= circleflip_optionsframework_options_interface( $children_second_value, $option_name, "[{$value['id']}]" );
					}
				}
			}
			if ( $value_extratag == '[closeBuilder]' ) {
				$output .= '</ul>';
			}
			break;
		// Basic text input
		case 'text' :
			$output .= '<div class="option_container">';
			if ( $parent != '' ) {
				if ( isset( $value['name'] ) ) {
					$output .= '<h4 class="heading">' . esc_html( $value['name'] ) . '</h4>' . "\n";
				}
				if ( isset( $val[$value['wrapper_type']][$value['id']] ) ) {
					$val_modified = $val[$value['wrapper_type']];
					$val_modified = $val_modified[$value['id']];
				}
				if ( isset( $val_modified ) && ! is_array( $val_modified ) ) {
					$val_modified = stripslashes( $val_modified );
				}
				$output .= '<input id="' . esc_attr( $value['id'] ) . '" placeholder="' . esc_attr( $value_placeholder ) . '" class="of-input" name="' . esc_attr( $option_name . $parent . '[' . $value['wrapper_type'] . '][' . $value['id'] . ']' ) . '" type="text" value="' . esc_attr( $val_modified ) . '" />
                <label class="explain" for="' . esc_attr( $value['id'] ) . '">' . wp_kses( $explain_value, $allowedtags ) . '</label>
                </div>';
			} else {
				$output .= '<input id="' . esc_attr( $value['id'] ) . '" placeholder="' . esc_attr( $value_placeholder ) . '" class="of-input" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" type="text" value="' . esc_attr( $val ) . '" />
                <label class="explain" for="' . esc_attr( $value['id'] ) . '">' . wp_kses( $explain_value, $allowedtags ) . '</label>
                </div>';
			}

			break;
		case 'empty' :

			break;
        case 'cust_sidebars' :
            $output .= '<div class="option_container">';
            $output .= '<input id="' . esc_attr($value['id']) . '" placeholder="Sidebar Name" class="of-input" name="' . esc_attr($option_name . '[' . $value['id'] . '][]') . '" type="text" value="" /><button type="button" id="add-sidebar"></button><label class="explain" for="' . esc_attr($value['id']) . '">' . wp_kses($explain_value, $allowedtags) . '</label></div>';
            $output .= '<div id="custom-sidebars">';
            $output .= '<h5 id="current-sidebars">Current Sidebars</h5><ul>';
            if (isset($val) && is_array($val)) {
                foreach ($val as $sidebar) {
                    $output .= '<li>
	                    				<div id="sidebar-' . esc_attr(preg_replace('/[^a-zA-Z0-9._\-]/', '', strtolower($sidebar))) . '">' . '<p>' . $sidebar . '</p>';
                    $output .= '<input type="hidden" name="' . esc_attr($option_name . $parent . '[' . $value['id'] . '][]') . '" value="' . esc_attr($sidebar) . '">';
                    $output .= '<button type="button" class="remove" data-target="#sidebar-' . esc_attr(preg_replace('/[^a-zA-Z0-9._\-]/', '', strtolower($sidebar))) . '"></button></div></li>';
                }
            }
            $output .= '</ul></div>';
            ?>
            <script>
                (function($) {
                    $(document).ready(function() {
                        var $input = $('#<?php echo esc_attr($value['id']) ?>');
                        $('#add-sidebar').on('click', function(e) {
                            var sb_name = $input.val();
                            var new_sidebar = "<li><div id='sidebar-" + sb_name + "'><p>" + sb_name
                                    + "</p><input type='hidden' name='<?php echo esc_attr($option_name . $parent . '[' . $value['id'] . '][]') ?>' value='" + sb_name + "'>"
                                    + "<button type='button' class='remove' data-target='#sidebar-" + sb_name + "'></button></div></li>";
                            $('#custom-sidebars ul').append(new_sidebar);
                            $input.val('');
                        });
                        $('#custom-sidebars').on('click', '.remove', function(e) {
                            $($(this).data('target')).parent('li').remove();
                        });
                    });
                })(jQuery)
            </script>
            <?php
            break;
		case 'cust_font' :
			$output .= '<div class="option_container">';
			$output .= '<select class="add-font-select">';
			foreach ( $fonts_global_array as $key_font => $value_font ) {
				$output .= '<option value="' . $key_font . '">' . $value_font . '</option>';
			}
			$output .= '</select>';
			$output .= '<input id="' . esc_attr( $value['id'] ) . '" style="display: none;" class="of-input" name="" type="text" value="" /><button type="button" id="add-font"></button><label class="explain" for="' . esc_attr( $value['id'] ) . '">' . wp_kses( $explain_value, $allowedtags ) . '</label></div>';
			$output .= '<div id="custom-fonts">';
			$output .= '<h5 id="current-fonts">Current fonts</h5><ul>';
			if ( isset( $val ) && is_array( $val ) ) {
				foreach ( $val as $font ) {
					$output .= '<li>
	                    				<div id="font-' . esc_attr( preg_replace( '/[^a-zA-Z0-9._\-]/', '', strtolower( $font ) ) ) . '">' . '<p>' . $font . '</p>';
					$output .= '<input type="hidden" name="' . esc_attr( $option_name . $parent . '[' . $value['id'] . '][]' ) . '" value="' . esc_attr( $font ) . '">';
					$output .= '<button type="button" class="remove" data-target="#font-' . esc_attr( preg_replace( '/[^a-zA-Z0-9._\-]/', '', strtolower( $font ) ) ) . '"></button></div></li>';
				}
			}
			$output .= '</ul></div>';
			?>
			<script>
				( function( $ ) {
					$( document ).ready( function() {
						var $input = $( '#<?php echo esc_attr( $value['id'] ) ?>' );
						$( '#add-font' ).on( 'click', function( e ) {
							$input.val( $( '.add-font-select' ).val() );
							var sb_name = $input.val();
							var new_font = "<li><div id='font-" + sb_name + "'><p>" + sb_name
									+ "</p><input type='hidden' name='<?php echo esc_attr( $option_name . $parent . '[' . $value['id'] . '][]' ) ?>' value='" + sb_name + "'>"
									+ "<button type='button' class='remove' data-target='#font-" + sb_name + "'></button></div></li>";
							$( '#custom-fonts ul' ).append( new_font );
							$input.val( '' );
						} );
						$( '#custom-fonts' ).on( 'click', '.remove', function( e ) {
							$( $( this ).data( 'target' ) ).parent( 'li' ).remove();
						} );
					} );
				} )( jQuery )
			</script>
			<?php
			break;
		case 'cust_social':
			$name = $option_name . '[social_urls]';
			ob_start();
			?>
			<div class="option_container">
				<ul id="social-icons-fields">
					<?php foreach ( ( array ) $val as $i => $social ): ?>
						<li>
							<div class="iconsLink">
								<label>
									Link:
									<input type="text" name="<?php echo $name . '[' . $i . ']' . '[link]' ?>" value="<?php echo $social['link'] ?>">
								</label>
							</div>
							<label class="icon_picker">
								<p>Icon:</p>
								<?php echo circleflip_icon_selector( $name . '[' . $i . ']' . '[icon]', $social['icon'] ); ?>
							</label>
							<button type="button" class="button cf-of-si-remove">Remove</button>
						</li>
					<?php endforeach; ?>
				</ul>
				<button type="button" class="cf-of-si-add">Add</button>
			</div>
			<script type="text/template" id="social-icons-template">
				<li>
				<div class="iconsLink">
				<label>
				Link:
				<input type="text" name="<?php echo $name . '[<%= data.i %>][link]' ?>" value="">
				</label>
				</div>
				<label class="icon_picker">
				<p>Icon:</p>
				<?php echo circleflip_icon_selector( "{$name}[<%= data.i %>][icon]" ); ?>
				</label>
				<button type="button" class="button cf-of-si-remove">Remove</button>
				</li>
			</script>
			<script>
				jQuery( function( $ ) {
					var socialIconsList = $( '#social-icons-fields' ),
							socialIconsTemplate = $( '#social-icons-template' ),
							socialIconsTmpl = _.template( socialIconsTemplate.html(), null, { variable: 'data' } );
					$( '.cf-of-si-add' ).on( 'click', function() {
						socialIconsList.append( socialIconsTmpl( { i: parseInt( socialIconsList.children().length ) + 1 } ) );
					} );
					$( document ).on( 'click', '.cf-of-si-remove', function() {
						var toRemove = $( this ).closest( 'li' );
						toRemove.slideUp( 'fast', function() {
							toRemove.remove();
						} );
					} );
				} );
			</script>
			<?php
			$output.= ob_get_clean();
			break;
		// export options
		case 'export-options':
			$nonce = wp_create_nonce( "creiden_rojo_export_options_ajax" );
			$output .= '<textarea onclick="this.select()" id="export-data" data-_ajax_nonce="' . $nonce . '" class="of-input">' . base64_encode( serialize( get_option( 'rojo' ) ) ) . '</textarea><label class="explain" for="' . esc_attr( $value['id'] ) . '">' . wp_kses( $explain_value, $allowedtags ) . '</label>';
			break;
		// export options
		case 'import_options':
			$output .= '<textarea id="import-data" class="of-input" name="' . esc_attr( $option_name . $parent ) . '"></textarea><label class="explain" for="' . esc_attr( $value['id'] ) . '">' . wp_kses( $explain_value, $allowedtags ) . '</label>';
			break;
		// Password input
		case 'password' :
			$output .= '<input id="' . esc_attr( $value['id'] ) . '" class="of-input" name="' . esc_attr( $option_name . $parent . '[' . $value['id'] . ']' ) . '" type="password" value="' . esc_attr( $val ) . '" />
            <label class="explain" for="' . esc_attr( $value['id'] ) . '">' . wp_kses( $explain_value, $allowedtags ) . '</label>
            ';
			break;

		// Textarea
		case 'textarea' :
			$output .= '<div class="option_container">';
			$rows = '8';

			if ( isset( $value['settings']['rows'] ) ) {
				$custom_rows = $value['settings']['rows'];
				if ( is_numeric( $custom_rows ) ) {
					$rows = $custom_rows;
				}
			}

			if ( $parent != '' ) {
				if ( isset( $value['name'] ) ) {
					$output .= '<h4 class="heading">' . esc_html( $value['name'] ) . '</h4>' . "\n";
				}
				$val_modified = isset( $val[$value['wrapper_type']][$value['id']] ) ? $val[$value['wrapper_type']][$value['id']] : $val_modified;
				if ( isset( $val_modified ) && ! is_array( $val_modified ) ) {
					$val_modified = stripslashes( $val_modified );
				}
				$output .= '<textarea id="' . esc_attr( $value['id'] ) . '" class="of-input" name="' . esc_attr( $option_name . $parent . '[' . $value['wrapper_type'] . '][' . $value['id'] . ']' ) . '" rows="' . $rows . '">' . esc_textarea( $val_modified ) . '</textarea>
                <label class="explain" for="' . esc_attr( $value['id'] ) . '">' . wp_kses( $explain_value, $allowedtags ) . '</label>
                </div>';
			} else {
				$output .= '<textarea id="' . esc_attr( $value['id'] ) . '" class="of-input" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" rows="' . $rows . '">' . $val . '</textarea>
                <label class="explain" for="' . esc_attr( $value['id'] ) . '">' . wp_kses( $explain_value, $allowedtags ) . '</label>
                </div>';
			}
			break;

		// Select Box
		case 'select' :
			$class = isset( $value['class'] ) ? $value['class'] : '';
			$output .= '<div class="option_container">';
			if ( $parent != '' ) {
				if ( isset( $value['name'] ) ) {
					$output .= '<h4 class="heading">' . esc_html( $value['name'] ) . '</h4>' . "\n";
				}
				$output .= '<select class="of-input ' . $class . '" name="' . esc_attr( $option_name . $parent . '[' . $value['wrapper_type'] . '][' . $value['id'] . ']' ) . '" id="' . esc_attr( $value['id'] ) . '">';
				foreach ( $value['options'] as $key => $option ) {
					$selected = '';
					if ( isset( $val[$value['wrapper_type']][$value['id']] ) ) {
						if ( $val[$value['wrapper_type']][$value['id']] != '' ) {
							if ( $val[$value['wrapper_type']][$value['id']] == $key ) {
								$selected = ' selected="selected"';
							}
						}
					}
					$output .= '<option' . $selected . ' value="' . esc_attr( $key ) . '">' . esc_html( $option ) . '</option>';
				}
				$output .= '</select>
                <label class="explain" for="' . esc_attr( $value['id'] ) . '">' . wp_kses( $explain_value, $allowedtags ) . '</label>
                </div>';
			} else {
				$output .= '<select class="of-input ' . $class . '" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" id="' . esc_attr( $value['id'] ) . '">';
				$layout_counter = 0;
				foreach ( $value['options'] as $key => $option ) {
					$data_homelayout = isset( $value['data-homelayout'][$layout_counter] ) ? $value['data-homelayout'][$layout_counter] : "";
					$data_sidebar = isset( $value['data-sidebar-alignment'][$layout_counter] ) ? $value['data-sidebar-alignment'][$layout_counter] : "";
					$selected = '';
					if ( $val != '' ) {
						if ( $val == $key ) {
							$selected = ' selected="selected"';
						}
					}
					$output .= '<option' . $selected . ' value="' . esc_attr( $key ) . '" data-homelayout="' . $data_homelayout . '" data-sidebar-alignment="' . $data_sidebar . '" > ' . esc_html( $option ) . '</option>';
					$layout_counter ++;
				}
				$output .= '</select>
                <label class="explain" for="' . esc_attr( $value['id'] ) . '">' . wp_kses( $explain_value, $allowedtags ) . '</label>
                </div>';
			}
			break;
		// encoding input
		case 'hiddenInput' :
			$output .= '<input type="hidden" id="' . esc_attr( $value['id'] ) . '" name="' . esc_attr( $option_name . '[' . $value['hidden_name'] . ']' ) . '" value="" />';
			break;
		// Radio Box
		case "radio" :
			$output .= '<div class="option_container">';
			if ( $parent != '' ) {
				if ( isset( $value['name'] ) ) {
					$output .= '<h4 class="heading">' . esc_html( $value['name'] ) . '</h4>' . "\n";
				}
				$val_modified = isset( $val[$value['wrapper_type']][$value['id']] ) ? $val[$value['wrapper_type']][$value['id']] : $val_modified;
				$name = $option_name . $parent . '[' . $value['wrapper_type'] . '][' . $value['id'] . ']';
				$output .= '<ul class="radioButtonWrapper">';
				foreach ( $value['options'] as $key => $option ) {
					$id = $option_name . '-' . $value['id'] . '-' . $key;
					$output .= '<li><label><input class="of-input of-radio" type="radio" name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '" value="' . esc_attr( $key ) . '" ' . checked( $val_modified, $key, false ) . ' />' . esc_html( $option ) . '</label></li>';
				}
				$output.='</ul>
                <label class="explain" for="' . esc_attr( $value['id'] ) . '">' . wp_kses( $explain_value, $allowedtags ) . '</label>
                </div>';
			} else {
				$name = $option_name . '[' . $value['id'] . ']';
				$output .= '<ul class="radioButtonWrapper">';
				foreach ( $value['options'] as $key => $option ) {
					$id = $option_name . '-' . $value['id'] . '-' . $key;
					$output .= '<li><label><input class="of-input of-radio" type="radio" name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '" value="' . esc_attr( $key ) . '" ' . checked( $val, $key, false ) . ' />' . esc_html( $option ) . '</label></li>';
				}
				$output.='</ul>
                <label class="explain" for="' . esc_attr( $value['id'] ) . '">' . wp_kses( $explain_value, $allowedtags ) . '</label>
                </div>';
			}
			break;

		// Image Selectors
		case "images" :
			$class = isset( $value['class'] ) ? $value['class'] : '';
			$output .= '<div class="option_container"><ul class="' . $class . '">';
			if ( $parent != '' ) {
				if ( isset( $value['name'] ) ) {
					$output .= '<h4 class="heading">' . esc_html( $value['name'] ) . '</h4>' . "\n";
				}
				$name = $option_name . $parent . '[' . $value['wrapper_type'] . '][' . $value['id'] . ']';
				foreach ( $value['options'] as $key => $option ) {
					$selected = '';
					$checked = '';
					$val_modified = isset( $val[$value['wrapper_type']][$value['id']] ) ? $val[$value['wrapper_type']][$value['id']] : $val_modified;
					if ( $val_modified != '' ) {
						if ( $val_modified == $key ) {
							$selected = ' of-radio-img-selected';
							$checked = ' checked="checked"';
						}
					}
					$output .= '<li><input type="radio" id="' . esc_attr( $value['id'] . '_' . $key ) . '" class="of-radio-img-radio" value="' . esc_attr( $key ) . '" name="' . esc_attr( $name ) . '" ' . $checked . ' />';
					$output .= '<div class="of-radio-img-label">' . esc_html( $key ) . '</div>';
					$output .= '<img src="' . esc_url( $option ) . '" alt="' . $option . '" class="of-radio-img-img' . $selected . '" onclick="document.getElementById(\'' . esc_attr( $value['id'] . '_' . $key ) . '\').checked=true;" /></li>';
				}
				$output.='</ul>
                <label class="explain" for="' . esc_attr( $value['id'] ) . '">' . wp_kses( $explain_value, $allowedtags ) . '</label>
                </div>';
			} else {
				$name = $option_name . '[' . $value['id'] . ']';
				foreach ( $value['options'] as $key => $option ) {
					$selected = '';
					$checked = '';
					if ( $val != '' ) {
						if ( $val == $key ) {
							$selected = ' of-radio-img-selected';
							$checked = ' checked="checked"';
						}
					}
					$output .= '<li><input type="radio" id="' . esc_attr( $value['id'] . '_' . $key ) . '" class="of-radio-img-radio" value="' . esc_attr( $key ) . '" name="' . esc_attr( $name ) . '" ' . $checked . ' />';
					$output .= '<div class="of-radio-img-label">' . esc_html( $key ) . '</div>';
					$output .= '<img src="' . esc_url( $option ) . '" alt="' . $option . '" class="of-radio-img-img' . $selected . '" onclick="document.getElementById(\'' . esc_attr( $value['id'] . '_' . $key ) . '\').checked=true;" /></li>';
				}
				$output.='</ul>
                <label class="explain" for="' . esc_attr( $value['id'] ) . '">' . wp_kses( $explain_value, $allowedtags ) . '</label>
                </div>';
			}
			break;

		// Checkbox
		case "checkbox" :
			$output .= '<div class="option_container">';
			if ( $parent != '' ) {
				if ( isset( $value['name'] ) ) {
					$output .= '<h4 class="heading">' . esc_html( $value['name'] ) . '</h4>' . "\n";
				}
				$name = $option_name . $parent . '[' . $value['wrapper_type'] . '][' . $value['id'] . ']';
				$val_modified = isset( $val[$value['wrapper_type']][$value['id']] ) ? 1 : '';
				$output .= '<input id="' . esc_attr( $value['id'] ) . '" class="checkbox of-input" type="checkbox" name="' . esc_attr( $name ) . '" ' . checked( $val_modified, 1, false ) . ' />';
				$output .= '<label class="explain" for="' . esc_attr( $value['id'] ) . '">' . wp_kses( $explain_value, $allowedtags ) . '</label></div>';
			} else {
				$output .= '<input id="' . esc_attr( $value['id'] ) . '" class="checkbox of-input" type="checkbox" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" ' . checked( $val, 1, false ) . ' />';
				$output .= '<label class="explain" for="' . esc_attr( $value['id'] ) . '">' . wp_kses( $explain_value, $allowedtags ) . '</label></div>';
			}
			break;

		// Multicheck
		case "multicheck" :
			$output .= '<div class="option_container">';
			if ( $parent != '' ) {
				if ( isset( $value['name'] ) ) {
					$output .= '<h4 class="heading">' . esc_html( $value['name'] ) . '</h4>' . "\n";
				}
				foreach ( $value['options'] as $key => $option ) {
					$checked = '';
					$label = $option;
					$option = preg_replace( '/[^a-zA-Z0-9._\-]/', '', strtolower( $key ) );

					$id = $option_name . '-' . $value['id'] . '-' . $option;
					$name = $option_name . $parent . '[' . $value['wrapper_type'] . '][' . $value['id'] . '][' . $option . ']';
					$val_modified = isset( $val[$value['wrapper_type']][$value['id']][$key] ) ? 1 : '';
					if ( isset( $val_modified ) ) {
						$checked = checked( $val_modified, 1, false );
					}

					$output .= '<input id="' . esc_attr( $id ) . '" class="checkbox of-input" type="checkbox" name="' . esc_attr( $name ) . '" ' . $checked . ' /><label for="' . esc_attr( $id ) . '">' . esc_html( $label ) . '</label>';
				}
				$output.='<label class="explain" for="' . esc_attr( $value['id'] ) . '">' . wp_kses( $explain_value, $allowedtags ) . '</label></div>';
			} else {
				foreach ( $value['options'] as $key => $option ) {
					$checked = '';
					$label = $option;
					$option = preg_replace( '/[^a-zA-Z0-9._\-]/', '', strtolower( $key ) );

					$id = $option_name . '-' . $value['id'] . '-' . $option;
					$name = $option_name . '[' . $value['id'] . '][' . $option . ']';

					if ( isset( $val[$option] ) ) {
						$checked = checked( $val[$option], 1, false );
					}

					$output .= '<input id="' . esc_attr( $id ) . '" class="checkbox of-input" type="checkbox" name="' . esc_attr( $name ) . '" ' . $checked . ' /><label for="' . esc_attr( $id ) . '">' . esc_html( $label ) . '</label>';
				}
				$output.='</div>';
			}
			break;

		// Color picker
		case "color" :
			$output .= '<div class="option_container">';
			if ( $parent != '' ) {
				if ( isset( $value['name'] ) ) {
					$output .= '<h4 class="heading">' . esc_html( $value['name'] ) . '</h4>' . "\n";
				}
				$name = $option_name . $parent . '[' . $value['wrapper_type'] . '][' . $value['id'] . ']';
				$default_color = '';
				$val_modified = isset( $val[$value['wrapper_type']][$value['id']] ) ? $val[$value['wrapper_type']][$value['id']] : $val_modified;
				if ( isset( $value['std'] ) ) {
					if ( $val_modified != $value['std'] )
						$default_color = ' data-default-color="' . $value['std'] . '" ';
				}
				$output .= '<input name="' . esc_attr( $name ) . '" id="' . esc_attr( $value['id'] ) . '" class="of-color"  type="text" value="' . esc_attr( $val_modified ) . '"' . $default_color . ' />
                <label class="explain" for="' . esc_attr( $value['id'] ) . '">' . wp_kses( $explain_value, $allowedtags ) . '</label>
                </div>';
			}
			else {
				$default_color = '';
				if ( isset( $value['std'] ) ) {
					if ( $val != $value['std'] )
						$default_color = ' data-default-color="' . $value['std'] . '" ';
				}
				$output .= '<input name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" id="' . esc_attr( $value['id'] ) . '" class="of-color"  type="text" value="' . esc_attr( $val ) . '"' . $default_color . ' />
                <label class="explain" for="' . esc_attr( $value['id'] ) . '">' . wp_kses( $explain_value, $allowedtags ) . '</label>
                </div>';
			}
			break;

		case "selectmultiple":
			$output .= '<div class="option_container">';
			if ( $parent != '' ) {
				if ( isset( $value['name'] ) ) {
					$output .= '<h4 class="heading">' . esc_html( $value['name'] ) . '</h4>' . "\n";
				}
				$output .= '<select name="' . esc_attr( $option_name . $parent . '[' . $value['wrapper_type'] . '][' . $value['id'] . '][]' ) . '" id="' . esc_attr( $value['id'] ) . '" multiple>';
				foreach ( $value['options'] as $key => $option ) {
					$selected = '';
					if ( isset( $val[$value['wrapper_type']][$value['id']] ) ) {
						if ( in_array( $key, $val[$value['wrapper_type']][$value['id']] ) ) {
							$selected = 'selected = "selected"';
						}
					}
					$output .= '<option value="' . $key . '"' . $selected . '>' . $option . '</option>';
				}
				$output .= '</select>
				<label class="explain" for="' . esc_attr( $value['id'] ) . '">' . wp_kses( $explain_value, $allowedtags ) . '</label>';
			} else {
				$output .= '<select name="' . esc_attr( $option_name . '[' . $value['id'] . '][]' ) . '" id="' . esc_attr( $value['id'] ) . '" multiple>';
				foreach ( $value['options'] as $key => $option ) {
					$selected = '';
					if ( isset( $val ) && is_array( $val ) ) {
						if ( in_array( $key, $val ) ) {
							$selected = 'selected = "selected"';
						}
					}
					$output .= '<option value="' . $key . '"' . $selected . '>' . $option . '</option>';
				}
				$output .= '</select>
				<label class="explain" for="' . esc_attr( $value['id'] ) . '">' . wp_kses( $explain_value, $allowedtags ) . '</label>';
			}
			$output .= '</div>';
			break;

		// Uploader
		case "upload" :
			$output .= '<div class="option_container">';
			if ( $parent != '' ) {
				$val_modified = isset( $val[$value['wrapper_type']][$value['id']] ) ? $val[$value['wrapper_type']][$value['id']] : '';
				$name = $parent . '[' . $value['wrapper_type'] . '][' . $value['id'] . ']';
				$name = substr( $name, 1, -1 );
				$output .= circleflip_optionsframework_uploader( $name, $val_modified, null );
				$output .= '<label class="explain" for="' . esc_attr( $value['id'] ) . '">' . wp_kses( $explain_value, $allowedtags ) . '</label></div>';
			} else {
				$output .= circleflip_optionsframework_uploader( $value['id'], $val, null );
				$output .= '<label class="explain" for="' . esc_attr( $value['id'] ) . '">' . wp_kses( $explain_value, $allowedtags ) . '</label></div>';
			}
			break;
		// Logo Builder
		case "logo_builder" :
			$output .= '<div id="' . $value['id'] . '" class="containmentLogo" style="height: ' . cr_get_option( 'header_height', 137 ) . 'px; width: ' . cr_get_option( 'logo_wrapper_width', 270 ) . 'px">
				 <img class="logo" src="' . cr_get_option( 'theme_logo' ) . '" style="width:' . cr_get_option( 'logo_width' ) . 'px;height:' . cr_get_option( 'logo_height' ) . 'px;left:' . cr_get_option( 'logo_left' ) . 'px;top:' . cr_get_option( 'logo_top' ) . 'px;" alt="">
			</div>';
			break;

		// Button
		case "button" :
			$output .= '<button id="' . $value['id'] . '" class="' . $value_class . ' button" type="button">' . $value['text'] . '</button>';
			$output .= isset( $value['desc'] ) ? $value['desc'] : '';
			break;

		// Button
		case "builder_button" :
			$output .= '<button id="' . $value['id'] . '" class="' . $value_class . ' button" type="button">' . $value['text'] . '</button>';
			break;
		// Typography
		case 'typography':

			unset( $font_size, $font_style, $font_face, $font_color, $font_weight );

			$typography_defaults = array(
				'size'	 => '',
				'face'	 => '',
				'style'	 => '',
				'weight' => '',
				'color'	 => ''
			);

			$typography_stored = wp_parse_args( $val, $typography_defaults );

			$typography_options = array(
				'sizes'		 => circleflip_of_recognized_font_sizes(),
				'faces'		 => circleflip_of_recognized_font_faces(),
				'styles'	 => circleflip_of_recognized_font_styles(),
				'weights'	 => circleflip_of_recognized_font_weights(),
				'color'		 => true
			);

			if ( isset( $value['options'] ) ) {
				$typography_options = wp_parse_args( $value['options'], $typography_options );
			}

			// Font Size
			if ( $typography_options['sizes'] ) {
				$font_size = '<select class="of-typography of-typography-size ' . $value_class . '" name="' . esc_attr( $option_name . '[' . $value['id'] . '][size]' ) . '" id="' . esc_attr( $value['id'] . '_size' ) . '">';
				$sizes = $typography_options['sizes'];
				foreach ( $sizes as $i ) {
					$size = $i . 'px';
					$font_size .= '<option value="' . esc_attr( $size ) . '" ' . selected( $typography_stored['size'], $size, false ) . '>' . esc_html( $size ) . '</option>';
				}
				$font_size .= '</select>';
			}

			// Font Face
			if ( $typography_options['faces'] ) {
				$font_face = '<select class="of-typography of-typography-face  ' . $value_class . '" name="' . esc_attr( $option_name . '[' . $value['id'] . '][face]' ) . '" id="' . esc_attr( $value['id'] . '_face' ) . '">';
				$faces = $typography_options['faces'];
				foreach ( $faces as $key => $face ) {
					$font_face .= '<option value="' . esc_attr( $key ) . '" ' . selected( $typography_stored['face'], $key, false ) . '>' . esc_html( $face ) . '</option>';
				}
				$font_face .= '</select>';
			}

			// Font Styles
			if ( $typography_options['styles'] ) {
				$font_style = '<select class="of-typography of-typography-style  ' . $value_class . '" name="' . $option_name . '[' . $value['id'] . '][style]" id="' . $value['id'] . '_style">';
				$styles = $typography_options['styles'];
				foreach ( $styles as $key => $style ) {
					$font_style .= '<option value="' . esc_attr( $key ) . '" ' . selected( $typography_stored['style'], $key, false ) . '>' . $style . '</option>';
				}
				$font_style .= '</select>';
			}

			// Font Weights
			if ( $typography_options['weights'] ) {
				$font_weight = '<select class="of-typography of-typography-weight  ' . $value_class . '" name="' . $option_name . '[' . $value['id'] . '][weight]" id="' . $value['id'] . '_weight">';
				$weights = $typography_options['weights'];
				foreach ( $weights as $key => $weight ) {
					$font_weight .= '<option value="' . esc_attr( $key ) . '" ' . selected( $typography_stored['weight'], $key, false ) . '>' . $weight . '</option>';
				}
				$font_weight .= '</select>';
			}
			// Font Color
			if ( $typography_options['color'] ) {
				$default_color = '';
				if ( isset( $value['std']['color'] ) ) {
					if ( $val != $value['std']['color'] )
						$default_color = ' data-default-color="' . $value['std']['color'] . '" ';
				}
				$font_color = '<input name="' . esc_attr( $option_name . '[' . $value['id'] . '][color]' ) . '" id="' . esc_attr( $value['id'] . '_color' ) . '" class="of-color of-typography-color ' . $value_class . '"  type="text" value="' . esc_attr( $typography_stored['color'] ) . '"' . $default_color . ' />';
			}

			// Allow modification/injection of typography fields
			$typography_fields = compact( 'font_size', 'font_face', 'font_style', 'font_color', 'font_weight' );
			$typography_fields = apply_filters( 'circleflip_of_typography_fields', $typography_fields, $typography_stored, $option_name, $value );
			$output .= implode( '', $typography_fields );

			break;
		// Add Slide
		case 'add_slide' :
			if ( ! isset( $val['number'] ) ) {
				$val = array( 'number' => 1 );
			}
			$output .= '<div class="option_container">';
			$output .= '<input id="' . esc_attr( $value['id'] ) . '" placeholder="Number of slides" class="of-input" name="' . esc_attr( $option_name . '[' . $value['id'] . '][number]' ) . '" type="hidden" value="' . esc_attr( $val['number'] ) . '" /><label class="explain" for="' . esc_attr( $value['id'] ) . '">' . wp_kses( $explain_value, $allowedtags ) . '</label></div>';
			$output .= '<div class="add_slide">';
			$output .= '<h5 id="current-sidebars" class="current_slides">Current Slides</h5><button type="button" class="add-slide button button-large" id="add-slide_' . esc_attr( $value['id'] ) . '">Add Slide</button>';
			$output .= '<ul class="slidesWrapper">';
			for ( $i = 0; $i < $val['number']; $i ++  ) {
				$output .= '<li class="slide_container">';
				$output .= '<div>';
				$output .= '<div class="slideTopBar">';
				$output .= '<div class="slideNavigator"><span class="slideUp"></span><span class="slideDown"></span></div>';
				$output .= '<h6>Slide ' . ($i + 1) . '</h6>';
				$output .= '<div class="slideView"><button type="button" class="remove icon-trash"></button><div class="collapseSlide"><button type="button" class="icon-up-open"></button></div></div>';
				$output .= '</div>';
				$output .= '<ul class="slideList">';
				foreach ( $value['slider_items'] as $key => $small_values ) {
					$output .= '<li>';
					$output .= circleflip_optionsframework_option_interface_indented( $small_values, $option_name, '', $val, $value['id'], $i );
					$output .= '</li>';
				}
				$output .= '</ul>';
				$output .= '</div>';
				$output .= '</li>';
			}
			$output .= '</ul>';
			$output .= '</div>';
			?>
			<script>
				( function( $ ) {
					$( document ).ready( function() {
						add_slide();
						slide_toggle();
						function add_slide() {
							var $input = $( '#<?php echo esc_attr( $value['id'] ) ?>' );
							$( '#add-slide_<?php echo esc_attr( $value['id'] ) ?>' ).on( 'click', function( e ) {
								var sb_name = parseInt( $input.val() );
								sb_name = sb_name + 1;
								$input.val( sb_name );
								$add_slide = $input.parent().next( '.add_slide' ).children( '.slidesWrapper' );

								var $cloned_element = $add_slide.find( '.slide_container' ).first().clone();
								$cloned_element.find( '.slideTopBar h6' ).text( 'Slide ' + sb_name );
								// Handle the radio buttons
								var radio_name = $cloned_element.find( '.of-radio' ).attr( 'name' );
								$cloned_element.find( '.of-radio' ).attr( 'name', 'radio_temporary' );
								$cloned_element.find( '.of-radio' ).attr( 'name', radio_name.replace( /\d+/, sb_name - 1 ) );
								$cloned_element.appendTo( $add_slide );

								var $name = $add_slide.find( '.slide_container' ).last().find( 'input[type=text],input[type=radio]' ).each( function( index, element ) {
									$( element ).attr( 'name', $( element ).attr( 'name' ).replace( /\d+/, sb_name - 1 ) );
									$( element ).val( '' ).removeAttr( 'checked' );
								} );
								var $name = $add_slide.find( '.slide_container' ).last().find( 'select' ).each( function( index, element ) {
									$( element ).attr( 'name', $( element ).attr( 'name' ).replace( /\d+/, sb_name - 1 ) );
									$( element ).find( 'option:selected' ).removeAttr( 'selected' );
								} );

								// empty all the modules if the copied element was remove
								if ( $( '.slide_container' ).first().find( '.screenshot' ).prev().val() == 'Remove' ) {
									$add_slide.find( '.slide_container' ).last().find( '.remove-file' ).remove();
									$add_slide.find( '.slide_container' ).last().find( '.screenshot' ).hide();
									$add_slide.find( '.slide_container' ).last().find( '.screenshot' ).before( '<input id="remove-<?php echo esc_attr( $value['id'] ) ?>_image" class="button upload-button" type="button" value="Upload">' );
								}
								optionsframework_file_bindings();
								$( '#add-slide_<?php echo esc_attr( $value['id'] ) ?>' ).off( 'click' );
								add_slide();
								slide_toggle();
							} );
							$( '.slide_container' ).off( 'click', '.remove' );
							$( '.slide_container' ).on( 'click', '.remove', function( e ) {
								$( this ).parents( '.slide_container' ).remove();
								var sb_name = parseInt( $input.val() );
								sb_name = sb_name - 1;
								$input.val( sb_name );
								$add_slide = $input.parent().next( '.add_slide' );
								var $name = $add_slide.find( '.slide_container' ).each( function( index, element ) {
									$( element ).find( '.slideTopBar h6' ).text( 'Slide ' + parseInt( index + 1 ) );
									$( element ).find( 'input' ).each( function( count, small_element ) {
										if ( typeof $( small_element ).attr( 'name' ) !== 'undefined' && $( small_element ).attr( 'name' ) !== false ) {
											$( small_element ).attr( 'name', $( small_element ).attr( 'name' ).replace( /\d+/, index ) );
										}
									} );


								} );
								var $name = $add_slide.find( '.slide_container' ).each( function( index, element ) {
									$( element ).find( 'input' ).each( function( count, small_element ) {
										if ( typeof $( small_element ).attr( 'name' ) !== 'undefined' && $( small_element ).attr( 'name' ) !== false ) {
											$( small_element ).attr( 'name', $( small_element ).attr( 'name' ).replace( /\d+/, index ) );
										}
									} )
								} );
							} );
							$( ".slidesWrapper" ).sortable( {
								placeholder: "ui-state-highlight",
								beforeStop: function( event, ui ) {
									var sb_name = parseInt( $input.val() );
									$add_slide = $input.parent().next( '.add_slide' )
									var $name = $add_slide.find( '.slide_container' ).each( function( index, element ) {
										$( element ).find( 'input[type=text]' ).each( function( count, small_element ) {
											$( small_element ).attr( 'name', $( small_element ).attr( 'name' ).replace( /\d+/, index ) );
										} )
										$( element ).find( 'input[type=radio]' ).each( function( count, small_element ) {
											$( small_element ).attr( 'name', $( small_element ).attr( 'name' ).replace( /\d+/, index ) );
										} )
									} );
									var $name = $add_slide.find( '.slide_container' ).each( function( index, element ) {
										$( element ).find( 'input[type=text]' ).each( function( count, small_element ) {
											$( small_element ).attr( 'name', $( small_element ).attr( 'name' ).replace( /\d+/, index ) );
										} )
										$( element ).find( 'input[type=radio]' ).each( function( count, small_element ) {
											$( small_element ).attr( 'name', $( small_element ).attr( 'name' ).replace( /\d+/, index ) );
										} )
									} );
								}
							} );
						}
						function slide_toggle() {
							$( '.slide_container' ).off( 'click', '.collapseSlide button' );
							$( '.slide_container' ).on( 'click', '.collapseSlide button', function( e ) {
								$this = $( this );
								$this.parents( '.slideTopBar' ).siblings( '.slideList' ).slideToggle( function() {
									if ( $this.hasClass( 'icon-up-open' ) ) {
										$this.removeClass( "icon-up-open" );
										$this.addClass( "icon-down-open" );
									}
									else {
										$this.removeClass( "icon-down-open" );
										$this.addClass( "icon-up-open" );
									}
								} );
								e.stopPropagation();
							} );
						}
					} );
				} )( jQuery )
			</script>
			<?php
			break;
		//case create_slider
		case 'create_slider' :
			$output .= '<div class="option_container">';
			$output .= '<input id="' . esc_attr( $value['id'] ) . '" placeholder="Slider Name" class="of-input" name="' . esc_attr( $option_name . '[' . $value['id'] . '][]' ) . '" type="text" value="" /><button type="button" id="add-slider"></button><label class="explain" for="' . esc_attr( $value['id'] ) . '">' . wp_kses( $explain_value, $allowedtags ) . '</label></div>';
			$output .= '<div id="slider-created">';
			$output .= '<h5 id="current-sliders">Current Sliders</h5><ul>';
			if ( isset( $val ) && is_array( $val ) ) {
				foreach ( $val as $slider ) {
					if ( isset( $slider ) && ! empty( $slider ) ) {
						$output .= '<li>
		                    				<div id="slider-' . esc_attr( preg_replace( '/[^a-zA-Z0-9._\-]/', '', strtolower( $slider ) ) ) . '">' . '<p>' . $slider . '</p>';
						$output .= '<input type="hidden" name="' . esc_attr( $option_name . $parent . '[' . $value['id'] . '][]' ) . '" value="' . esc_attr( $slider ) . '">';
						$output .= '<button type="button" class="remove" data-target="#slider-' . esc_attr( preg_replace( '/[^a-zA-Z0-9._\-]/', '', strtolower( $slider ) ) ) . '"></button></div></li>';
					}
				}
			}
			$output .= '</ul></div>';
			?>
			<script>
						( function( $ ) {
							$( document ).ready( function() {
								var $input = $( '#<?php echo esc_attr( $value['id'] ) ?>' );
								$( '#add-slider' ).on( 'click', function( e ) {
									var sb_name = $input.val();
									var sb_name_trimmed = sb_name.replace( / /g, '' );
									var find_same_name = false;
									$( '#slider-created ul li' ).each( function() {
										//Check if slider name is already taken
										if ( $( this ).children( 'div' ).attr( 'id' ) == ( 'slider-' + sb_name_trimmed ) ) {
											find_same_name = true;
											$( '#create_slider' ).val( '' );
											$( "#create_slider" ).parents( '.section' ).append( '<div id="message" class="updated fade in" style="margin-top: -10px;"><p><strong>Please write another name, there is a slider with the same name</strong></p></div>' );
											setTimeout( function() {
												$( "#message" ).hide().remove();
											}, 5000 );
										}
									} );
									if ( sb_name_trimmed != '' && find_same_name == false ) {
										var new_sidebar = "<li><div id='slider-" + sb_name_trimmed + "'><p>" + sb_name
												+ "</p><input type='hidden' name='<?php echo esc_attr( $option_name . $parent . '[' . $value['id'] . '][]' ) ?>' value='" + sb_name + "'>"
												+ "<button type='button' class='remove' data-target='#slider-" + sb_name_trimmed + "'></button></div></li>";
										$( '#slider-created ul' ).append( new_sidebar );
										$input.val( '' );
										$( "#create_slider" ).parents( '.section' ).append( '<div id="message" class="updated fade in" style="margin-top: -10px;"><p><strong>Please Save your options and refresh the page to create a new slider</strong></p></div>' );
										setTimeout( function() {
											$( "#message" ).hide().remove();
										}, 5000 );
									}
								} );
								$( '#slider-created' ).on( 'click', '.remove', function( e ) {
									$( $( this ).data( 'target' ) ).parent( 'li' ).remove();
									$( "#create_slider" ).parents( '.section' ).append( '<div id="message" class="updated fade in" style="margin-top: -10px;"><p><strong>Please Save your options and refresh the page for the changes to take effect</strong></p></div>' );
									setTimeout( function() {
										$( "#message" ).hide().remove();
									}, 5000 );
								} );
							} );
						} )( jQuery )
			</script>
			<?php
			break;
		// Background
		case 'background' :
			$background = $val;

			// Background Color
			$default_color = '';
			if ( isset( $value['std']['color'] ) ) {
				if ( $val != $value['std']['color'] )
					$default_color = ' data-default-color="' . $value['std']['color'] . '" ';
			}
			$output .= '<input name="' . esc_attr( $option_name . $parent . '[' . $value['id'] . '][color]' ) . '" id="' . esc_attr( $value['id'] . '_color' ) . '" class="of-color of-background-color"  type="text" value="' . esc_attr( $background['color'] ) . '"' . $default_color . ' />';

			// Background Image
			if ( ! isset( $background['image'] ) ) {
				$background['image'] = '';
			}

			$output .= circleflip_optionsframework_uploader( $value['id'], $background['image'], null, esc_attr( $option_name . $parent . '[' . $value['id'] . '][image]' ) );

			$class = 'of-background-properties';
			if ( '' == $background['image'] ) {
				$class .= ' hide';
			}
			$output .= '<div class="' . esc_attr( $class ) . '">';

			// Background Repeat
			$output .= '<select class="of-background of-background-repeat" name="' . esc_attr( $option_name . $parent . '[' . $value['id'] . '][repeat]' ) . '" id="' . esc_attr( $value['id'] . '_repeat' ) . '">';
			$repeats = circleflip_of_recognized_background_repeat();

			foreach ( $repeats as $key => $repeat ) {
				$output .= '<option value="' . esc_attr( $key ) . '" ' . selected( $background['repeat'], $key, false ) . '>' . esc_html( $repeat ) . '</option>';
			}
			$output .= '</select>';

			// Background Position
			$output .= '<select class="of-background of-background-position" name="' . esc_attr( $option_name . $parent . '[' . $value['id'] . '][position]' ) . '" id="' . esc_attr( $value['id'] . '_position' ) . '">';
			$positions = circleflip_of_recognized_background_position();

			foreach ( $positions as $key => $position ) {
				$output .= '<option value="' . esc_attr( $key ) . '" ' . selected( $background['position'], $key, false ) . '>' . esc_html( $position ) . '</option>';
			}
			$output .= '</select>';

			// Background Attachment
			$output .= '<select class="of-background of-background-attachment" name="' . esc_attr( $option_name . $parent . '[' . $value['id'] . '][attachment]' ) . '" id="' . esc_attr( $value['id'] . '_attachment' ) . '">';
			$attachments = circleflip_of_recognized_background_attachment();

			foreach ( $attachments as $key => $attachment ) {
				$output .= '<option value="' . esc_attr( $key ) . '" ' . selected( $background['attachment'], $key, false ) . '>' . esc_html( $attachment ) . '</option>';
			}
			$output .= '</select>';
			$output .= '</div>';

			break;

		// Editor
		case 'editor' :
			$output .= '<div class="explain">' . wp_kses( $explain_value, $allowedtags ) . '</div>' . "\n";
			echo $output;
			$textarea_name = esc_attr( $option_name . $parent . '[' . $value['id'] . ']' );
			$default_editor_settings = array( 'textarea_name' => $textarea_name, 'media_buttons' => false, 'tinymce' => array( 'plugins' => 'wordpress' ) );
			$editor_settings = array();
			if ( isset( $value['settings'] ) ) {
				$editor_settings = $value['settings'];
			}
			$editor_settings = array_merge( $editor_settings, $default_editor_settings );
			wp_editor( $val, $value['id'], $editor_settings );
			$output = '';
			break;

		// Info
		case "info" :
			$id = '';
			$class = 'section';
			if ( isset( $value['id'] ) ) {
				$id = 'id="' . esc_attr( $value['id'] ) . '" ';
			}
			if ( isset( $value['type'] ) ) {
				$class .= ' section-' . $value['type'];
			}
			if ( isset( $value['class'] ) ) {
				$class .= ' ' . $value['class'];
			}

			$output .= '<div ' . $id . 'class="' . esc_attr( $class ) . '">' . "\n";
			if ( isset( $value['name'] ) ) {
				$output .= '<h4 class="heading">' . esc_html( $value['name'] ) . '</h4>' . "\n";
			}
			if ( $value['desc'] ) {
				$output .= apply_filters( 'circleflip_of_sanitize_info', $value['desc'] ) . "\n";
			}
			$output .= '</div>' . "\n";
			break;

		// Heading for Navigation
		case "heading" :
			$counter ++;
			if ( $counter >= 2 ) {
				$output .= '</div>' . "\n";
			}
			$class = '';
			$class = ! empty( $value['id'] ) ? $value['id'] : $value['name'];
			$class = preg_replace( '/[^a-zA-Z0-9._\-]/', '', strtolower( $class ) );
			$output .= '<div id="options-group-' . $counter . '" class="group ' . $class . '">';
			$output .= '<div class="headingWrapper">';
			if ( isset( $value['icon_name'] ) ) {
				$output .= '<img src="' . $value['icon_name'] . '" alt=""/>';
			}
			$output .= '<h3>' . esc_html( $value['name'] ) . '</h3>' . "\n";
			$output .= '</div>';
			break;
		default :
			$output .= apply_filters( "circleflip_options_interface_{$value['type']}", $value, $option_name, $val );
	}
	if ( ! empty( $value_extratag ) ) {
		switch ( $value_extratag ) {
			case "[closeTab]" :
				$width = isset( $val[$value['wrapper_type']]['width'] ) ? $val[$value['wrapper_type']]['width'] : 100;
				$output .= '<input type="hidden" class="list_width" name="' . esc_attr( $option_name . $parent . '[' . $value_wrappertype . '][width]' ) . '" value="' . esc_attr( $width ) . '" />
					</div></li>';
				$builder_counter ++;
				break;
			case '[closeDiv]' :
				$output .= '</div>';
				break;
		}
	}


	if ( ($value['type'] != "heading") && ($value['type'] != "info") && (empty( $value['builder_type'] ) || $value['builder_type'] != "builderOption") ) {
		if ( $value['type'] == "pageBuilder" && $value_extratag == '[openBuilder]' ) {
			//do nothing
		} else {
			$output .= '</div>';
			$output .= '</div></div>' . "\n";
		}
	}
	return $output;
}

function circleflip_optionsframework_option_interface_indented( $value, $option_name, $parent = '', $val, $children_type, $counter ) {
	global $allowedtags;
	$value_class = isset( $value['class'] ) ? $value['class'] : '';
	$value_placeholder = isset( $value['placeholder'] ) ? $value['placeholder'] : '';
	$value_wrappertype = isset( $value['wrapper_type'] ) ? $value['wrapper_type'] : '';
	$value_children = isset( $value['children'] ) ? $value['children'] : '';
	$output = '';
	$explain_value = '';
	if ( isset( $value['desc'] ) ) {
		$explain_value = $value['desc'];
	}
	switch ( $value['type'] ) {
		// Basic text input
		case 'text' :
			$output .= '<input id="' . esc_attr( $value['id'] ) . '" placeholder="' . esc_attr( $value_placeholder ) . '" class="of-input ' . $value_class . '" name="' . esc_attr( $option_name . '[' . $children_type . ']' . '[' . $counter . ']' . '[' . $value['id'] . ']' ) . '" type="text" value="' . esc_attr( isset( $val[$counter][$value['id']] ) ? $val[$counter][$value['id']] : '' ) . '" />
            			<label class="explain" for="' . esc_attr( $value['id'] ) . '">' . wp_kses( $explain_value, $allowedtags ) . '</label>';

			break;
		case 'empty' :

			break;

		// Password input
		case 'password' :
			$output .= '<input id="' . esc_attr( $value['id'] ) . '" class="of-input" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" type="password" value="' . esc_attr( $val ) . '" />
            <label class="explain" for="' . esc_attr( $value['id'] ) . '">' . wp_kses( $explain_value, $allowedtags ) . '</label>
            ';
			break;

		// Textarea
		case 'textarea' :
			$output .= '<div class="option_container">';
			$rows = '8';

			if ( isset( $value['settings']['rows'] ) ) {
				$custom_rows = $value['settings']['rows'];
				if ( is_numeric( $custom_rows ) ) {
					$rows = $custom_rows;
				}
			}

			$output .= '<textarea id="' . esc_attr( $value['id'] ) . '" class="of-input" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" rows="' . $rows . '">' . esc_textarea( $val ) . '</textarea>
                <label class="explain" for="' . esc_attr( $value['id'] ) . '">' . wp_kses( $explain_value, $allowedtags ) . '</label>
                </div>';
			break;

		// Select Box
		case 'select' :
			$output .= '<select class="of-input ' . $value_class . '" name="' . esc_attr( $option_name . '[' . $children_type . ']' . '[' . $counter . ']' . '[' . $value['id'] . ']' ) . '" id="' . esc_attr( $value['id'] ) . '">';
			foreach ( $value['options'] as $key => $option ) {
				$selected = '';
				if ( $val != '' ) {
					if ( isset( $val[$counter][$value['id']] ) && $val[$counter][$value['id']] == $key ) {
						$selected = ' selected="selected"';
					}
				}
				$output .= '<option' . $selected . ' value="' . esc_attr( $key ) . '">' . esc_html( $option ) . '</option>';
			}
			$output .= '</select>
                <label class="explain" for="' . esc_attr( $value['id'] ) . '">' . wp_kses( $explain_value, $allowedtags ) . '</label>';
			break;
		// encoding input
		case 'hiddenInput' :
			$output .= '<input type="hidden" id="' . esc_attr( $value['id'] ) . '" name="' . esc_attr( $option_name . '[' . $value['hidden_name'] . ']' ) . '" value="" />';
			break;
		// Radio Box
		case "radio" :
			$name = esc_attr( $option_name . '[' . $children_type . '][' . $counter . '][' . $value['id'] . ']' );
			//;
			$output .= '<ul class="radioButtonWrapper">';
			foreach ( $value['options'] as $key => $option ) {
				$checked = isset( $val[$counter][$value['id']] ) ? checked( $val[$counter][$value['id']], $key, false ) : '';
				$id = $option_name . '-' . $value['id'] . '-' . $key;
				$output .= '<li><label><input class="of-input of-radio ' . $value_class . '" type="radio" name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '" value="' . esc_attr( $key ) . '" ' . $checked . ' />' . esc_html( $option ) . '</label></li>';
			}
			$output.='</ul>
            <label class="explain" for="' . esc_attr( $value['id'] ) . '">' . wp_kses( $explain_value, $allowedtags ) . '</label>';
			break;

		// Image Selectors
		case "images" :
			$class = isset( $value['class'] ) ? $value['class'] : '';
			$output .= '<div class="option_container"><ul class="' . $class . '">';
			$name = $option_name . '[' . $value['id'] . ']';
			foreach ( $value['options'] as $key => $option ) {
				$selected = '';
				$checked = '';
				if ( $val != '' ) {
					if ( $val == $key ) {
						$selected = ' of-radio-img-selected';
						$checked = ' checked="checked"';
					}
				}
				$output .= '<li><input type="radio" id="' . esc_attr( $value['id'] . '_' . $key ) . '" class="of-radio-img-radio" value="' . esc_attr( $key ) . '" name="' . esc_attr( $name ) . '" ' . $checked . ' />';
				$output .= '<div class="of-radio-img-label">' . esc_html( $key ) . '</div>';
				$output .= '<img src="' . esc_url( $option ) . '" alt="' . $option . '" class="of-radio-img-img' . $selected . '" onclick="document.getElementById(\'' . esc_attr( $value['id'] . '_' . $key ) . '\').checked=true;" /></li>';
			}
			$output.='</ul>
                <label class="explain" for="' . esc_attr( $value['id'] ) . '">' . wp_kses( $explain_value, $allowedtags ) . '</label>
                </div>';
			break;

		// Checkbox
		case "checkbox" :
			$output .= '<div class="option_container">';
			$output .= '<input id="' . esc_attr( $value['id'] ) . '" class="checkbox of-input" type="checkbox" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" ' . checked( $val, 1, false ) . ' />';
			$output .= '<label class="explain" for="' . esc_attr( $value['id'] ) . '">' . wp_kses( $explain_value, $allowedtags ) . '</label></div>';
			break;

		// Multicheck
		case "multicheck" :
			$output .= '<div class="option_container">';
			foreach ( $value['options'] as $key => $option ) {
				$checked = '';
				$label = $option;
				$option = preg_replace( '/[^a-zA-Z0-9._\-]/', '', strtolower( $key ) );

				$id = $option_name . '-' . $value['id'] . '-' . $option;
				$name = $option_name . '[' . $value['id'] . '][' . $option . ']';

				if ( isset( $val[$option] ) ) {
					$checked = checked( $val[$option], 1, false );
				}

				$output .= '<input id="' . esc_attr( $id ) . '" class="checkbox of-input" type="checkbox" name="' . esc_attr( $name ) . '" ' . $checked . ' /><label for="' . esc_attr( $id ) . '">' . esc_html( $label ) . '</label>';
			}
			$output.='</div>';
			break;

		// Color picker
		case "color" :
			$output .= '<div class="option_container">';
			$default_color = '';
			if ( isset( $value['std'] ) ) {
				if ( $val != $value['std'] )
					$default_color = ' data-default-color="' . $value['std'] . '" ';
			}
			$output .= '<input name="' . esc_attr( $option_name . '[' . $children_type . ']' . '[' . $counter . ']' . '[' . $value['id'] . ']' ) . '" id="' . esc_attr( $value['id'] ) . '" class="of-color"  type="text" value="' . esc_attr( isset( $val[$counter][$value['id']] ) ? $val[$counter][$value['id']] : '' ) . '"' . $default_color . ' />
                <label class="explain" for="' . esc_attr( $option_name . '[' . $children_type . ']' . '[' . $counter . ']' . '[' . $value['id'] . ']' ) . '">' . wp_kses( $explain_value, $allowedtags ) . '</label>
                </div>';
			break;

		case "selectmultiple":
			$output .= '<div class="option_container">';
			$output .= '<select name="' . esc_attr( $option_name . '[' . $value['id'] . '][]' ) . '" id="' . esc_attr( $value['id'] ) . '" multiple>';
			foreach ( $value['options'] as $key => $option ) {
				$selected = '';
				if ( isset( $val ) && is_array( $val ) ) {
					if ( in_array( $key, $val ) ) {
						$selected = 'selected = "selected"';
					}
				}
				$output .= '<option value="' . $key . '"' . $selected . '>' . $option . '</option>';
			}
			$output .= '</select>
				<label class="explain" for="' . esc_attr( $value['id'] ) . '">' . wp_kses( $explain_value, $allowedtags ) . '</label>';
			$output .= '</div>';
			break;

		// Uploader
		case "upload" :
			$valid_val = isset( $val[$counter][$value['id']] ) ? $val[$counter][$value['id']] : '';
			$name = $option_name . '[' . $children_type . '][' . $counter . '][' . $value['id'] . ']';
			$output .= circleflip_optionsframework_uploader( $value['id'], $valid_val, null, $name );
			$output .= '<label class="explain ' . $value_class . '" for="' . esc_attr( $value['id'] ) . '">' . wp_kses( $explain_value, $allowedtags ) . '</label>';
			break;

		// Button
		case "button" :
			$output .= '<button id="' . $value['id'] . '" class="' . $value_class . ' button" type="button">' . $value['text'] . '</button>';
			$output .= isset( $value['desc'] ) ? $value['desc'] : '';
			break;

		// Button
		case "builder_button" :
			$output .= '<button id="' . $value['id'] . '" class="' . $value_class . ' button" type="button">' . $value['text'] . '</button>';
			break;
		// Typography
		case 'typography':

			unset( $font_size, $font_style, $font_face, $font_color, $font_weight );

			$typography_defaults = array(
				'size'	 => '',
				'face'	 => '',
				'style'	 => '',
				'weight' => '',
				'color'	 => ''
			);
			$typography_stored = wp_parse_args( isset( $val[$counter][$value['id']] ) ? $val[$counter][$value['id']] : '', $typography_defaults );
			$typography_options = array(
				'sizes'		 => circleflip_of_recognized_font_sizes(),
				'faces'		 => circleflip_of_recognized_font_faces(),
				'styles'	 => circleflip_of_recognized_font_styles(),
				'weights'	 => circleflip_of_recognized_font_weights(),
				'color'		 => true
			);

			if ( isset( $value['options'] ) ) {
				$typography_options = wp_parse_args( $value['options'], $typography_options );
			}

			// Font Size
			if ( $typography_options['sizes'] ) {
				$font_size = '<select class="of-typography of-typography-size ' . $value_class . '" name="' . esc_attr( $option_name . '[' . $children_type . ']' . '[' . $counter . ']' . '[' . $value['id'] . '][size]' ) . '" id="' . esc_attr( $value['id'] . '_size' ) . '">';
				$sizes = $typography_options['sizes'];
				foreach ( $sizes as $i ) {
					$size = $i . 'px';
					$font_size .= '<option value="' . esc_attr( $size ) . '" ' . selected( $typography_stored['size'], $size, false ) . '>' . esc_html( $size ) . '</option>';
				}
				$font_size .= '</select>';
			}

			// Font Face
			if ( $typography_options['faces'] ) {
				$font_face = '<select class="of-typography of-typography-face ' . $value_class . '" name="' . esc_attr( $option_name . '[' . $children_type . ']' . '[' . $counter . ']' . '[' . $value['id'] . '][face]' ) . '" id="' . esc_attr( $value['id'] . '_face' ) . '">';
				$faces = $typography_options['faces'];
				foreach ( $faces as $key => $face ) {
					$font_face .= '<option value="' . esc_attr( $key ) . '" ' . selected( $typography_stored['face'], $key, false ) . '>' . esc_html( $face ) . '</option>';
				}
				$font_face .= '</select>';
			}

			// Font Styles
			if ( $typography_options['styles'] ) {
				$font_style = '<select class="of-typography of-typography-style ' . $value_class . '" name="' . esc_attr( $option_name . '[' . $children_type . ']' . '[' . $counter . ']' . '[' . $value['id'] . '][style]' ) . '" id="' . $value['id'] . '_style">';
				$styles = $typography_options['styles'];
				foreach ( $styles as $key => $style ) {
					$font_style .= '<option value="' . esc_attr( $key ) . '" ' . selected( $typography_stored['style'], $key, false ) . '>' . $style . '</option>';
				}
				$font_style .= '</select>';
			}

			// Font Weights
			if ( $typography_options['weights'] ) {
				$font_weight = '<select class="of-typography of-typography-weight ' . $value_class . '" name="' . esc_attr( $option_name . '[' . $children_type . ']' . '[' . $counter . ']' . '[' . $value['id'] . '][weight]' ) . '" id="' . $value['id'] . '_weight">';
				$weights = $typography_options['weights'];
				foreach ( $weights as $key => $weight ) {
					$font_weight .= '<option value="' . esc_attr( $key ) . '" ' . selected( $typography_stored['weight'], $key, false ) . '>' . $weight . '</option>';
				}
				$font_weight .= '</select>';
			}
			// Font Color
			if ( $typography_options['color'] ) {
				$default_color = '';
				if ( isset( $value['std']['color'] ) ) {
					if ( $val != $value['std']['color'] )
						$default_color = ' data-default-color="' . $value['std']['color'] . '" ';
				}
				$font_color = '<input name="' . esc_attr( $option_name . '[' . $children_type . ']' . '[' . $counter . ']' . '[' . $value['id'] . '][color]' ) . '" id="' . esc_attr( $value['id'] ) . '" class="of-color of-typography-color ' . $value_class . '"  type="text" value="' . esc_attr( $typography_stored['color'] ) . '"' . $default_color . ' />';
			}

			// Allow modification/injection of typography fields
			$typography_fields = compact( 'font_size', 'font_face', 'font_style', 'font_color', 'font_weight' );
			$typography_fields = apply_filters( 'circleflip_of_typography_fields', $typography_fields, $typography_stored, $option_name, $value );
			$output .= implode( '', $typography_fields );

			break;
	}
	return $output;
}
