<?php
/**
* CeJay SEO OG Meta
*
* @package           PluginPackage
* @author            Lisa Baird
* @copyright         CeJay Websites
* @license           GPL-2.0-or-later
*
* @wordpress-plugin
*/
/**
Plugin Name: CeJay SEO OG Meta
Description: This plugin generates meta tags for SEO (search engine optimization) and Open Graph (OG.)
Version: 3.2
Author: Lisa Baird
Company: CeJay Websites
Website: https://cejaywebsites.com
License: GPL v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.txt
*/

// Function to generate SEO meta and OG meta tags
function cejay_magic_meta() {
    global $post;
    $cstmMeta = get_post_custom(get_the_ID());

    // Set defaults
    $title = "";
    $description = "";
    $defImg = "";
    $pageURL = get_permalink($post);

    // TITLE
    if (isset($cstmMeta['cejay-title'][0]) && $cstmMeta['cejay-title'][0] != '') {
        $title = $cstmMeta['cejay-title'][0];
    } elseif (get_the_title()) {
        $title = esc_html(get_the_title());
    }

    // DESCRIPTION
    if (isset($cstmMeta['cejay-description'][0]) && $cstmMeta['cejay-description'][0] != '') {
        $description = $cstmMeta['cejay-description'][0];
    } elseif (has_excerpt()) {
        $description = strip_tags(get_the_excerpt());
    }

    // FEATURED IMAGE
    $post_thumbnail_id = get_post_thumbnail_id($post);
    $imageURL = wp_get_attachment_image_url($post_thumbnail_id, 'full');
    if (isset($imageURL) && $imageURL == '') {
        $imageURL = $defImg;
    }

    echo '<meta name="description" content="' . $description . '" />' . "\r\n";
    echo '<meta name="title" content="' . $title . '" />' . "\r\n";
    echo '<meta property="og:title" content="' . $title . '" />' . "\r\n";
    echo '<meta property="og:type" content="website" />' . "\r\n";
    echo '<meta property="og:url" content="' . $pageURL . '" />' . "\r\n";
    echo '<meta property="og:image" content="' . $imageURL . '" />' . "\r\n";
    echo '<meta property="og:description" content="' . $description . '" />' . "\r\n";
    echo '<meta property="og:locale" content="en_US" />' . "\r\n";
    echo '<meta property="og:site_name" content="' . get_bloginfo('name') . '" />' . "\r\n";
}

// Hook the function to the wp_head action to add meta tags to the header
add_action('wp_head', 'cejay_magic_meta');

  /*** Featured image to RSS Feed. ***/
    function dn_add_rss_image() {
        global $post;
    
        $output = '';
        if ( has_post_thumbnail( $post->ID ) ) {
            $thumbnail_ID = get_post_thumbnail_id( $post->ID );
            $thumbnail = wp_get_attachment_image_src( $thumbnail_ID, 'full' ); /** 'full' can be changed to 'medium' or 'thumbnail' */
    
            $output .= '<media:content xmlns:media="http://search.yahoo.com/mrss/" medium="image" type="image/jpeg"';
            $output .= ' url="'. $thumbnail[0] .'"';
            $output .= ' width="100%"'; /** here you can add styles */
            $output .= ' object-fit="cover"';
            $output .= ' />';
        }
        echo $output;
    }
add_action( 'rss2_item', 'dn_add_rss_image' );
/************** ENABLE CORS  ****************

add_filter( 'allowed_http_origins', 'add_allowed_origins' );
function add_allowed_origins( $origins ) {
// allow origins from ssl and non-ssl addresses 
    $origins[] = 'http://MyWebsite.com';
    $origins[] = 'https://MyWebsite.com';    
// allow origins from specific supdomain with or without SSL 
    $origins[] = 'http://subdomain.MyWebsite.com';
	$origins[] = 'https://subdomain.MyWebsite.com';
// allow these specific origins 
	$origins[] = 'https://reputationdatabase.com';
	$origins[] = 'https://www.youtube-nocookie.com';
	$origins[] = 'https://googleads.g.doubleclick.net/pagead/id';
    return $origins;
} */
