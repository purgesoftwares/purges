<?php
/** nav-menu-walker.php
 *
 * @author		Creiden
 * @package		Circleflip
 * @since		1.5.0 - 15.05.2012
 */

class Circleflip_Nav_Walker extends Walker_Nav_Menu {

	/**
	 * @see Walker_Nav_Menu::start_lvl()
	 */
	
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		
		if(cr_get_option('header_builder') == 0) {
			$output .= "\n<ul class=\"dropdown-menu header-menu\">\n";
		} else {
			$output .= "\n<ul class=\"sub-menu\">\n";
		}
		
	}

	/**
	 * @see Walker_Nav_Menu::start_el()
	 */
	function start_el( &$output, $item, $depth = 0, $args=array(), $current_object_id = 0 ) {
		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		$li_attributes = $class_names = $value = '';
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		if ( $args->has_children ) {
			if(cr_get_option('header_builder') == 0) {
				$classes[] = ( 1 > $depth) ? 'dropdown': 'dropdown-submenu';
				$li_attributes .= ' data-dropdown="dropdown"';
			} else {
				$classes[] = 'menu-parent'; 
			}
			
			
		}

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $value . $class_names . $li_attributes . '>';

		$attributes	=	$item->attr_title	? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes	.=	$item->target		? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes	.=	$item->xfn			? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes	.=	$item->url			? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		if(cr_get_option('header_builder') == 0) {
			$attributes	.=	$args->has_children	? ' class="dropdown-toggle"' : '';
		}

		$arrowAicon;
		if(cr_get_option('header_builder') == 0) {
			if(( defined( 'ICL_LANGUAGE_CODE' ) && 'ar' === ICL_LANGUAGE_CODE) ) {
				$arrowAicon = ' <span class="icon-left-open menuArrowRight"></span>';
			} else{
				$arrowAicon = ' <span class="icon-right-open menuArrowRight"></span>';
			}
		} else {
			if(( defined( 'ICL_LANGUAGE_CODE' ) && 'ar' === ICL_LANGUAGE_CODE) ) {
				$arrowAicon = ' <i class="icon-left-open sub-arrow"></i>';
			} else{
				$arrowAicon = ' <i class="icon-right-open sub-arrow"></i>';
			}
		}
		
		$item_output	=	$args->before . '<a' . $attributes . '>';
		$item_output	.=	$args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		if(cr_get_option('header_builder') == 0) {
			$item_output	.=	( $args->has_children AND 1 > $depth ) ? ' <b class="icon-down-open menuArrowDown"></b>' : '';
		} else {
			$item_output	.=	( $args->has_children AND 1 > $depth ) ? ' <i class="icon-down-open parent-arrow"></i>' : '';
		}
		$item_output	.=	( $args->has_children AND 1 <= $depth ) ? $arrowAicon : '';
		$item_output	.=	'</a>' . $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	/**
	 * @see Walker::display_element()
	 */
	function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {
		if ( ! $element )
			return;
		$id_field = $this->db_fields['id'];

		//display this element
		if ( is_array( $args[0] ) )
			$args[0]['has_children'] = (bool) ( ! empty( $children_elements[$element->$id_field] ) AND $depth != $max_depth - 1 );
		elseif ( is_object(  $args[0] ) )
			$args[0]->has_children = (bool) ( ! empty( $children_elements[$element->$id_field] ) AND $depth != $max_depth - 1 );

		$cb_args = array_merge( array( &$output, $element, $depth ), $args );
		call_user_func_array( array( &$this, 'start_el' ), $cb_args );

		$id = $element->$id_field;

		// descend only when the depth is right and there are childrens for this element
		if ( ( $max_depth == 0 OR $max_depth > $depth+1 ) AND isset( $children_elements[$id] ) ) {

			foreach ( $children_elements[ $id ] as $child ) {

				if ( ! isset( $newlevel ) ) {
					$newlevel = true;
					//start the child delimiter
					$cb_args = array_merge( array( &$output, $depth ), $args );
					call_user_func_array( array( &$this, 'start_lvl' ), $cb_args );
				}
				$this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
			}
			unset( $children_elements[ $id ] );
		}

		if ( isset( $newlevel ) AND $newlevel ) {
			//end the child delimiter
			$cb_args = array_merge( array( &$output, $depth ), $args );
			call_user_func_array( array( &$this, 'end_lvl' ), $cb_args );
		}

		//end this element
		$cb_args = array_merge( array( &$output, $element, $depth ), $args );
		call_user_func_array( array( &$this, 'end_el' ), $cb_args );
	}
}


/**
 * Adds the active CSS class
 *
 * @author	Creiden
 * @since	1.5.0 - 15.05.2012
 *
 * @param	array	$classes	Default class names
 *
 * @return	array
 */
function creiden_nav_menu_css_class( $classes ) {
	if ( in_array('current-menu-item', $classes ) OR in_array( 'current-menu-ancestor', $classes ) )
		$classes[]	=	'active';

	return $classes;
}
add_filter( 'nav_menu_css_class', 'creiden_nav_menu_css_class' );


/* End of file nav-menu-walker.php */
/* Location: ./wp-content/themes/circleflip/inc/nav-menu-walker.php */