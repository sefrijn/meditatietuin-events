<?php
/**
 * Plugin Name: Events - De Meditatietuin
 * Description: Custom build event & ticket system, including safe payments using Paytium & Mollie. Optimised for De Meditatietuin.
 * Version: 0.1
 * Author: How About Yes - Sefrijn
 * Author URI: https://howaboutyes.com
 */


/*
* INDEX
*
* Create custom post type
* Register Templates
* - Single Event
* - Overview - WP Archive
* - Overview - Page template
*/

// > Create custom post type
function mt_custom_post_type() {
    register_post_type('mt_events',
        array(
            'labels'      => array(
                'name'          => __('Events', 'mt_events'),
                'singular_name' => __('Event', 'mt_events'),
            ),
                'public'      => true,
                'has_archive' => true,
                'rewrite'     => array( 'slug' => 'events' ),
        )
    );
}
add_action('init', 'mt_custom_post_type');

// > Register Templates
// >> Single Event
function load_event_template( $template ) {
    global $post;

    if ( 'mt_events' === $post->post_type && locate_template( array( 'single-mt_events.php' ) ) !== $template ) {
        return plugin_dir_path( __FILE__ ) . 'single-mt_events.php';
    }

    return $template;
}
add_filter( 'single_template', 'load_event_template' );

// >> Overview - WP Archive
function event_archive_template( $template ) {
  if ( is_post_type_archive('mt_events') ) {
    $theme_files = array('archive-mt_events.php', 'meditatietuin-events/archive-mt_events.php');
    $exists_in_theme = locate_template($theme_files, false);
    if ( $exists_in_theme != '' ) {
      return $exists_in_theme;
    } else {
      return plugin_dir_path(__FILE__) . 'archive-mt_events.php';
    }
  }
  return $template;
}
add_filter('template_include', 'event_archive_template');

// >> Overview - Page template
function add_page_template ($templates) {
    $templates['page-template-events-overview.php'] = 'Events Overview';
    return $templates;
    }
add_filter ('theme_page_templates', 'add_page_template');
function redirect_page_template ($template) {
    $post = get_post();
    $page_template = get_post_meta( $post->ID, '_wp_page_template', true );
    if ('page-template-events-overview.php' == basename ($page_template ))
        $template = WP_PLUGIN_DIR . '/meditatietuin-events/page-template-events-overview.php';
    return $template;
    }
add_filter ('page_template', 'redirect_page_template');
?>