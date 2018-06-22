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
            '#F2F3F4', // Hintergrundfarbe
            '#F2F3F4', // Seitenleiste Hintergrundfarbe
            '#FFFFFF', // Box Hintergrundfarbe
            '#444444', // Text und Link Farbe
            '#444444', // Seitenleiste Text und Link Farbe
            '#F0F0F0', // Meta Box Hintergrundfarbe
        ),
    );

    $schemes['tfseminimal'] = array(
        'label'  => __( 'Twenty Fifteen SE Minimal', 'twentyfifteen' ),
        'colors' => array(
            '#FFFFFF', // Seitenleiste Hintergrundfarbe
            '#FFFFFF', // Box Hintergrundfarbe
            '#FFFFFF', // Hintergrundfarbe
            '#444444', // Text und Link Farbe
            '#444444', // Seitenleiste Text und Link Farbe
            '#F0F0F0', // Meta Box Hintergrundfarbe
        ),
    );
    return $schemes;
}

// --- Google Font CSS aus Twenty Fifteen entfernen ---
function twentyfifteen_child_dequeue_google_font() {
    wp_dequeue_style( 'twentyfifteen-fonts' );
    wp_deregister_style( 'twentyfifteen-fonts' );
}
add_action( 'wp_enqueue_scripts', 'twentyfifteen_child_dequeue_google_font', 100 );

// --- zusätzliches Menü registrieren ---
register_nav_menus(
	array(
		'footer'  => esc_html__( 'Footer Menu', 'twentyfifteen' ),
    )
);