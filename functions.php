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
            '#141414', // Text und Link Farbe
            '#141414', // Seitenleiste Text und Link Farbe
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

/**
 * Lebensalter berechnen und ausgeben [ckx_age birthday="dd.mm.yy"]
 */
function ckx_altersberechnung_function( $atts, $content = null )
{
    $age = '';

    extract( shortcode_atts( array(
        'birthday' => '',
        'prefix' => '',
        'postfix' => ''
    ), $atts ) );

    $dateFormat  = "d.m.Y";
    $datePattern = '/^([123]0|[012][1-9]|31).(0[1-9]|1[012]).(19[0-9]{2}|2[0-9]{3})$/';
    if (preg_match($datePattern, $birthday, $matches))  {
        $day   = $matches[1];
        $month = $matches[2];
        $year  = $matches[3];
        $actDate = explode(".", date($dateFormat));

        $age = $actDate[2] - $year;
        if ($actDate[1] < $month ||
            ($actDate[1] == $month && $actDate[0] < intval($day))) {
            $age--;
        }
        $age = $prefix . $age . $postfix;
    }
    return $age;
}

add_shortcode('ckx_age', 'ckx_altersberechnung_function');

/**
 * Kommentar Anzahl ausgeben mit Shortcode: [ckx_beitragsanzahl]
 */
function ckx_beitragsanzahl_function(){
   $art_count = wp_count_posts('post');
   $nr_art =  $art_count->publish;
     
   return $nr_art;
}

add_shortcode('ckx_beitragsanzahl', 'ckx_beitragsanzahl_function' );

/**
 * Kommentar Anzahl ausgeben mit Shortcode: [ckx_kommentaranzahl]
 */
function ckx_kommentaranzahl_function(){
    $comments_count = wp_count_comments();
    $nr_komm =  $comments_count->approved;
     
    return $nr_komm; 
}

add_shortcode('ckx_kommentaranzahl', 'ckx_kommentaranzahl_function' );

/**
 * Eine E-Mail-Adresse die mit dem Shortcode [ckx_mail]Adresse[/ckx_mail] übergeben wird, kann anschließen von vielen Spam-Bots nicht mehr aus dem HTML-Code ausgelesen werden.
 */
function ckx_email_verschleiern_function( $atts , $content = null ) {
	if ( ! is_email( $content ) ) {
		return;
	}

	return '<a href="mailto:' . antispambot( $content ) . '">' . antispambot( $content ) . '</a>';
}

add_shortcode( 'ckx_mail', 'ckx_email_verschleiern_function' );

/**
 * Speichern der IP Adresse in zukünftigen Kommentaren verhindern
 */
function  wpb_remove_commentsip( $comment_author_ip ) {
	return '';
	}
add_filter( 'pre_comment_user_ip', 'wpb_remove_commentsip' );