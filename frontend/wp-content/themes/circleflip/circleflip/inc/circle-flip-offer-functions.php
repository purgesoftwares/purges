<?php

if ( ! function_exists( 'circleflip_get_offer_items' ) ) {

    function circleflip_get_offer_items( $args = array() ) {
        return get_offer_items( $args );
    }

}

function get_offer_items( $opts ) {
    $args = wp_parse_args( $opts, array(
        'post_type'      => 'circleflip-offer',
        'posts_per_page' => -1
            ) );
    return get_posts( $args );
}

if ( ! function_exists( 'circleflip_get_offer_categories' ) ) {

    function circleflip_get_offer_categories( $post_id = null, $args = array() ) {
        $cats = get_offer_categories( $post_id, $args );
        return ! is_wp_error( $cats ) ? $cats : array();
    }

}

function get_offer_categories( $post_id = null, $args = array() ) {
    if ( null === $post_id ) {
        return get_terms( 'circleflip-offer-category' );
    }
    return wp_get_object_terms( $post_id, 'circleflip-offer-category', $args );
}
