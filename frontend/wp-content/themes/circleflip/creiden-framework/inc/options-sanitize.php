<?php

/* Text */

add_filter('circleflip_of_sanitize_text', 'sanitize_text_field');

/* Logo Builder */

add_filter('circleflip_of_sanitize_logo_builder', 'circleflip_of_sanitize_logo_builder');

function circleflip_of_sanitize_logo_builder($input) {
    $output = $input . '<button></button>';
    return $output;
}

/* Textarea */

function circleflip_of_sanitize_textarea($input) {
    global $allowedposttags;
    $output = wp_kses($input, $allowedposttags);
    return $output;
}

add_filter('circleflip_of_sanitize_textarea', 'circleflip_of_sanitize_textarea');

/* Select */

add_filter('circleflip_of_sanitize_select', 'circleflip_of_sanitize_enum', 10, 2);

/* Radio */

add_filter('circleflip_of_sanitize_radio', 'circleflip_of_sanitize_enum', 10, 2);

/* Images */

add_filter('circleflip_of_sanitize_images', 'circleflip_of_sanitize_enum', 10, 2);

/* Checkbox */

function circleflip_of_sanitize_checkbox($input) {
    if ($input) {
        $output = '1';
    } else {
        $output = false;
    }
    return $output;
}

add_filter('circleflip_of_sanitize_checkbox', 'circleflip_of_sanitize_checkbox');

/* Multicheck */

function circleflip_of_sanitize_multicheck($input, $option) {
    $output = '';
    if (is_array($input)) {
        foreach ($option['options'] as $key => $value) {
            $output[$key] = "0";
        }
        foreach ($input as $key => $value) {
            if (array_key_exists($key, $option['options']) && $value) {
                $output[$key] = "1";
            }
        }
    }
    return $output;
}

add_filter('circleflip_of_sanitize_multicheck', 'circleflip_of_sanitize_multicheck', 10, 2);

/* Select_Multiple */

function circleflip_of_sanitize_selectmultiple($input, $option) {
    return $input;
}

add_filter('circleflip_of_sanitize_selectmultiple', 'circleflip_of_sanitize_selectmultiple', 10, 2);

/* Color Picker */

add_filter('circleflip_of_sanitize_color', 'circleflip_of_sanitize_hex');

/* Uploader */

function circleflip_of_sanitize_upload($input) {
    $output = '';
    $filetype = wp_check_filetype($input);
    if ($filetype["ext"]) {
        $output = $input;
    }
    return $output;
}

add_filter('circleflip_of_sanitize_upload', 'circleflip_of_sanitize_upload');

/* Editor */

function circleflip_of_sanitize_editor($input) {
    if (current_user_can('unfiltered_html')) {
        $output = $input;
    } else {
        global $allowedtags;
        $output = wpautop(wp_kses($input, $allowedtags));
    }
    return $output;
}

add_filter('circleflip_of_sanitize_editor', 'circleflip_of_sanitize_editor');

/* Allowed Tags */

function circleflip_of_sanitize_allowedtags($input) {
    global $allowedtags;
    $output = wpautop(wp_kses($input, $allowedtags));
    return $output;
}

/* Allowed Post Tags */

function circleflip_of_sanitize_allowedposttags($input) {
    global $allowedposttags;
    $output = wpautop(wp_kses($input, $allowedposttags));
    return $output;
}

add_filter('circleflip_of_sanitize_info', 'circleflip_of_sanitize_allowedposttags');


/* Check that the key value sent is valid */

function circleflip_of_sanitize_enum($input, $option) {
    $output = '';
    if (array_key_exists($input, $option['options'])) {
        $output = $input;
    }
    return $output;
}

/* Background */

function circleflip_of_sanitize_background($input) {
    $output = wp_parse_args($input, array(
        'color' => '',
        'image' => '',
        'repeat' => 'repeat',
        'position' => 'top center',
        'attachment' => 'scroll'
            ));

    $output['color'] = apply_filters('circleflip_of_sanitize_hex', $input['color']);
    $output['image'] = apply_filters('circleflip_of_sanitize_upload', $input['image']);
    $output['repeat'] = apply_filters('circleflip_of_background_repeat', $input['repeat']);
    $output['position'] = apply_filters('circleflip_of_background_position', $input['position']);
    $output['attachment'] = apply_filters('circleflip_of_background_attachment', $input['attachment']);

    return $output;
}

add_filter('circleflip_of_sanitize_background', 'circleflip_of_sanitize_background');

function circleflip_of_sanitize_background_repeat($value) {
    $recognized = circleflip_of_recognized_background_repeat();
    if (array_key_exists($value, $recognized)) {
        return $value;
    }
    return apply_filters('circleflip_of_default_background_repeat', current($recognized));
}

add_filter('circleflip_of_background_repeat', 'circleflip_of_sanitize_background_repeat');

function circleflip_of_sanitize_background_position($value) {
    $recognized = circleflip_of_recognized_background_position();
    if (array_key_exists($value, $recognized)) {
        return $value;
    }
    return apply_filters('circleflip_of_default_background_position', current($recognized));
}

add_filter('circleflip_of_background_position', 'circleflip_of_sanitize_background_position');

function circleflip_of_sanitize_background_attachment($value) {
    $recognized = circleflip_of_recognized_background_attachment();
    if (array_key_exists($value, $recognized)) {
        return $value;
    }
    return apply_filters('circleflip_of_default_background_attachment', current($recognized));
}

add_filter('circleflip_of_background_attachment', 'circleflip_of_sanitize_background_attachment');


/* Typography */

function circleflip_of_sanitize_typography($input, $option) {

    $output = wp_parse_args($input, array(
        'size' => '',
        'face' => '',
        'style' => '',
        'color' => ''
            ));

    if (isset($option['options']['faces']) && isset($input['face'])) {
        if (!( array_key_exists($input['face'], $option['options']['faces']) )) {
            $output['face'] = '';
        }
    } else {
        $output['face'] = apply_filters('circleflip_of_font_face', $output['face']);
    }

    $output['size'] = apply_filters('circleflip_of_font_size', $output['size']);
    $output['style'] = apply_filters('circleflip_of_font_style', $output['style']);
    $output['color'] = apply_filters('circleflip_of_sanitize_color', $output['color']);
    return $output;
}

add_filter('circleflip_of_sanitize_typography', 'circleflip_of_sanitize_typography', 10, 2);

function circleflip_of_sanitize_font_size($value) {
    $recognized = circleflip_of_recognized_font_sizes();
    $value_check = preg_replace('/px/', '', $value);
    if (in_array((int) $value_check, $recognized)) {
        return $value;
    }
    return apply_filters('circleflip_of_default_font_size', $recognized);
}

add_filter('circleflip_of_font_size', 'circleflip_of_sanitize_font_size');

function circleflip_of_sanitize_font_style($value) {
    $recognized = circleflip_of_recognized_font_styles();
    if (array_key_exists($value, $recognized)) {
        return $value;
    }
    return apply_filters('circleflip_of_default_font_style', current($recognized));
}

add_filter('circleflip_of_font_style', 'circleflip_of_sanitize_font_style');

function circleflip_of_sanitize_font_face($value) {
    $recognized = circleflip_of_recognized_font_faces();
    if (array_key_exists($value, $recognized)) {
        return $value;
    }
    return apply_filters('circleflip_of_default_font_face', current($recognized));
}

add_filter('circleflip_of_font_face', 'circleflip_of_sanitize_font_face');

function circleflip_of_sanitize_sidebars($input) {
    $output = array_filter((array)$input);
    return $output;
}

add_filter('circleflip_of_sanitize_cust_sidebars', 'circleflip_of_sanitize_sidebars');


function circleflip_of_sanitize_fonts($input) {
    $output = array_filter((array)$input);
    return $output;
}

add_filter('circleflip_of_sanitize_cust_font', 'circleflip_of_sanitize_fonts');

function circleflip_of_sanitize_sliders($input) {
    return $input;
}

add_filter('circleflip_of_sanitize_add_slide', 'circleflip_of_sanitize_sliders');
function circleflip_of_sanitize_create_slider($input) {
    return $input;
}

add_filter('circleflip_of_sanitize_create_slider', 'circleflip_of_sanitize_create_slider');
/**
 * Get recognized background repeat settings
 *
 * @return   array
 *
 */
function circleflip_of_recognized_background_repeat() {
    $default = array(
        'no-repeat' => __('No Repeat', 'circleflip-themeoptions'),
        'repeat-x' => __('Repeat Horizontally', 'circleflip-themeoptions'),
        'repeat-y' => __('Repeat Vertically', 'circleflip-themeoptions'),
        'repeat' => __('Repeat All', 'circleflip-themeoptions'),
    );
    return apply_filters('circleflip_of_recognized_background_repeat', $default);
}

/**
 * Get recognized background positions
 *
 * @return   array
 *
 */
function circleflip_of_recognized_background_position() {
    $default = array(
        'top left' => __('Top Left', 'circleflip-themeoptions'),
        'top center' => __('Top Center', 'circleflip-themeoptions'),
        'top right' => __('Top Right', 'circleflip-themeoptions'),
        'center left' => __('Middle Left', 'circleflip-themeoptions'),
        'center center' => __('Middle Center', 'circleflip-themeoptions'),
        'center right' => __('Middle Right', 'circleflip-themeoptions'),
        'bottom left' => __('Bottom Left', 'circleflip-themeoptions'),
        'bottom center' => __('Bottom Center', 'circleflip-themeoptions'),
        'bottom right' => __('Bottom Right', 'circleflip-themeoptions')
    );
    return apply_filters('circleflip_of_recognized_background_position', $default);
}

/**
 * Get recognized background attachment
 *
 * @return   array
 *
 */
function circleflip_of_recognized_background_attachment() {
    $default = array(
        'scroll' => __('Scroll Normally', 'circleflip-themeoptions'),
        'fixed' => __('Fixed in Place', 'circleflip-themeoptions')
    );
    return apply_filters('circleflip_of_recognized_background_attachment', $default);
}

/**
 * Sanitize a color represented in hexidecimal notation.
 *
 * @param    string    Color in hexidecimal notation. "#" may or may not be prepended to the string.
 * @param    string    The value that this function should return if it cannot be recognized as a color.
 * @return   string
 *
 */
function circleflip_of_sanitize_hex($hex, $default = '') {
    if (circleflip_of_validate_hex($hex)) {
        return $hex;
    }
    return $default;
}

/**
 * Get recognized font sizes.
 *
 * Returns an indexed array of all recognized font sizes.
 * Values are integers and represent a range of sizes from
 * smallest to largest.
 *
 * @return   array
 */
function circleflip_of_recognized_font_sizes() {
    $sizes = range(6, 71);
    $sizes = apply_filters('circleflip_of_recognized_font_sizes', $sizes);
    $sizes = array_map('absint', $sizes);
    return $sizes;
}

/**
 * Get recognized font faces.
 *
 * Returns an array of all recognized font faces.
 * Keys are intended to be stored in the database
 * while values are ready for display in in html.
 *
 * @return   array
 *
 */
function circleflip_of_recognized_font_faces() {
	global $fonts_global_array;
    $default = $fonts_global_array;;
    return apply_filters('circleflip_of_recognized_font_faces', $default);
}

/**
 * Get recognized font styles.
 *
 * Returns an array of all recognized font styles.
 * Keys are intended to be stored in the database
 * while values are ready for display in in html.
 *
 * @return   array
 *
 */
function circleflip_of_recognized_font_styles() {
    $default = array(
        'Normal' => __('Normal', 'circleflip-themeoptions'),
        'Italic' => __('Italic', 'circleflip-themeoptions'),
    );
    return apply_filters('circleflip_of_recognized_font_styles', $default);
}
function circleflip_of_recognized_font_weights() {
    $default = array(
        'Normal' => __('Normal', 'circleflip-themeoptions'),
        'Bold' => __('Bold', 'circleflip-themeoptions'),
    );
    return apply_filters('circleflip_of_recognized_font_weights', $default);
}
/**
 * Is a given string a color formatted in hexidecimal notation?
 *
 * @param    string    Color in hexidecimal notation. "#" may or may not be prepended to the string.
 * @return   bool
 *
 */
function circleflip_of_validate_hex($hex) {
    $hex = trim($hex);
    /* Strip recognized prefixes. */
    if (0 === strpos($hex, '#')) {
        $hex = substr($hex, 1);
    } elseif (0 === strpos($hex, '%23')) {
        $hex = substr($hex, 3);
    }
    /* Regex match. */
    if (0 === preg_match('/^[0-9a-fA-F]{6}$/', $hex)) {
        return false;
    } else {
        return true;
    }
}

function circleflip_sanitize_social_icons( $output ) {
	return $output;
}

add_filter( 'circleflip_of_sanitize_cust_social', 'circleflip_sanitize_social_icons' );