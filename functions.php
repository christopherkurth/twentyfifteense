<?php
// --- zuerst das Eltern Stylesheet laden und danach das Child Theme Stylesheet ---
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
  wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}

// --- Farbschema für TwentyFifteen SE ---
add_filter('twentyfifteen_color_schemes', 'tfse_color_schemes');
function tfse_color_schemes( $schemes ) {
    $schemes['tfse'] = array(
        'label'  => __( 'Twenty Fifteen SE', 'twentyfifteen' ),
        'colors' => array(
            '#F3F4F5', // Hintergrundfarbe
            '#F3F4F5', // Seitenleiste Hintergrundfarbe
            '#FFFFFF', // Box Hintergrundfarbe
            '#000000', // Text und Link Farbe
            '#000000', // Seitenleiste Text und Link Farbe
            '#F8F8F8', // Meta Box Hintergrundfarbe
        ),
    );
    return $schemes;
}

/* ------------------------------------------------------------------------- *
* Returning an authentication error if a user who is not logged in tries to query the REST API
/* ------------------------------------------------------------------------- */
function only_allow_logged_in_rest_access( $access ) {
    if( ! is_user_logged_in() ) {
        return new WP_Error( 'rest_API_cannot_access', 'Only authenticated users can access the REST API.', array( 'status' => rest_authorization_required_code() ) );
    }
    return $access;
}
add_filter( 'rest_authentication_errors', 'only_allow_logged_in_rest_access' );

remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
remove_action( 'template_redirect', 'rest_output_link_header', 11 );
remove_action( 'xmlrpc_rsd_apis', 'rest_output_rsd' );

/**
 * Remove the Google font CSS of Twenty Fifteen.
 */
function twentyfifteen_child_dequeue_google_font() {
    wp_dequeue_style( 'twentyfifteen-fonts' );
    wp_deregister_style( 'twentyfifteen-fonts' );
}
add_action( 'wp_enqueue_scripts', 'twentyfifteen_child_dequeue_google_font', 100 );

/**
 * Add async and defer attribute to certain JavaScript files.
 *
 * @param string $tag The &lt;script&gt; tag for the enqueued script.
 * @param string $handle The script's registered handle.
 * @return string
 */
function twentyfifteen_child_add_async_attribute( $tag, $handle ) {
    $defer_script_handles = array(
        'twentyfifteen-skip-link-focus-fix',
        'jquery-scrollto',
        'wp-embed'
    );

    if ( ! in_array( $handle, $defer_script_handles ) ) return $tag;

    return str_replace( ' src', ' async defer src', $tag );
}
add_filter( 'script_loader_tag', 'twentyfifteen_child_add_async_attribute', 10, 2 );
