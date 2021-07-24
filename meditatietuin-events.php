<?php
/**
 * Plugin Name: Events - De Meditatietuin
 * Description: Custom build event & ticket system, including safe payments using Paytium & Mollie. Optimised for De Meditatietuin.
 * Version: 0.1
 * Author: How About Yes - Sefrijn
 * Author URI: https://howaboutyes.com
 */

if ( is_readable( __DIR__ . '/vendor/autoload.php' ) ) {
    require __DIR__ . '/vendor/autoload.php';
}
use StoutLogic\AcfBuilder\FieldsBuilder;

/*
* INDEX
*
* Create custom post type
* Register Templates
* - Single Event
* - Overview - WP Archive
* - Overview - Page template
* Stylesheet
* Scripts
* Custom Fields
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
        return plugin_dir_path( __FILE__ ) . 'templates/single-mt_events.php';
    }

    return $template;
}
add_filter( 'single_template', 'load_event_template' );

// >> Overview - WP Archive
function event_archive_template( $template ) {
  if ( is_post_type_archive('mt_events') ) {
    $theme_files = array('archive-mt_events.php', 'meditatietuin-events/templates/archive-mt_events.php');
    $exists_in_theme = locate_template($theme_files, false);
    if ( $exists_in_theme != '' ) {
      return $exists_in_theme;
    } else {
      return plugin_dir_path(__FILE__) . 'templates/archive-mt_events.php';
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
        $template = plugin_dir_path(__FILE__) . 'templates/page-template-events-overview.php';
    return $template;
    }
add_filter ('page_template', 'redirect_page_template');

// > Stylesheet
wp_register_style('style_css', plugin_dir_url(__FILE__) . 'dist/styles/style.css');

// > Scripts
wp_register_script('app_js', plugin_dir_url(__FILE__) . 'dist/scripts/app.js',array('jquery'));

add_action( 'wp_enqueue_scripts', 'mt_style_script' );
function mt_style_script(){
    wp_enqueue_script('app_js');
    wp_enqueue_style('style_css');
}

// > Custom Fields
$event = new FieldsBuilder('event');
$event
->addImage('banner')
->addRadio('event_type', [
        'label' => 'Type event',
    ])
    ->addChoice('eenmalig','Eenmalig - 1 dag(deel)')
    ->addChoice('eenmaliglang','Eenmalig - Meerdere Dagen')
    ->addChoice('reeks','Reeks')
    ->addChoice('herhalend','Herhalend')
    ->setDefaultValue('eenmalig')
->addText('frequentie',[
        'instructions' => 'Zoals wekelijks, maandelijks, elke vrijdag, etc...',
        ])
    ->conditional('event_type','==','herhalend')
->addDatePicker('datum_start',[
            'display_format' => 'l j F Y',
        ])
    ->conditional('event_type','==','eenmalig')
    ->or('event_type','==','eenmaliglang')
->addDatePicker('datum_end',[
            'display_format' => 'l j F Y',
        ])
    ->conditional('event_type','==','eenmaliglang')
->addRepeater('data',[
        'min' => 2,
    ])
    ->conditional('event_type','==','reeks')
    ->addDatePicker('datum',[
            'display_format' => 'l j F Y',
        ])
->endRepeater()

->addGroup('time', [
            'label' => 'Tijden',
            'layout' => 'table',
          ])
    ->addTimePicker('start',[
            'display_format' => 'H:i',
        ])
    ->addTimePicker('end',[
            'display_format' => 'H:i',
        ])
->endGroup()
->addRepeater('tickets',[
        'layout' => 'table',
        'min' => 1,
    ])
    ->addNumber('prijs',[
        'wrapper' => [
            'width' => '25',
        ],
    ])
    ->addText('ticket_naam')
->endRepeater()

->setLocation('post_type', '==', 'mt_events');

add_action('acf/init', function() use ($event) {
   acf_add_local_field_group($event->build());
});
?>