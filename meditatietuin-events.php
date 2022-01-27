<?php
/**
 * Plugin Name: Events - De Meditatietuin
 * Description: Custom build event & ticket system, including safe payments using Paytium & Mollie. Optimised for De Meditatietuin.
 * Version: 1.0
 * Author: How About Yes - Sefrijn
 * Author URI: https://howaboutyes.com
 */

/*
* INDEX
*
* Load Composer
* Custom post type & taxonomy
* - Events post type
* - Teachers Taxonomy
* - Category Taxonomy
* -- Taxonomy fix - hide parent dropdown
* Register 3 Templates
* - 1. Single Event
* - 2. Overview & Filters - Archive pages
* - 3. Overview - Page template
* Stylesheet
* Script
* Custom Fields
* - Event Single
* - Teacher Fields
* - Overview Fields
* Add Fields to admin area
* - Payment Admin Fields
* - Events Admin Fields
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Configuration variables
$events_per_page = 9;
$plugin_dir = WP_PLUGIN_DIR . '/meditatietuin-events';
$plugin_url = WP_PLUGIN_URL . '/meditatietuin-events';


/*

> Load Composer

*/

if ( is_readable( __DIR__ . '/vendor/autoload.php' ) ) {
    require __DIR__ . '/vendor/autoload.php';
}
use StoutLogic\AcfBuilder\FieldsBuilder;

include($plugin_dir.'/templates/elementor-block.php');


/*

> Custom post type & taxonomy

*/

function mt_custom_post_type() {


    // >> Events post type
    register_post_type('mt_events',
        array(
            'labels'      => array(
                'name'          => __('Events', 'mt_events'),
                'singular_name' => __('Event', 'mt_events'),
                'add_new'       => __( 'Nieuw Event', 'mt_events' ),
                'add_new_item'  => __( 'Nieuw Event', 'mt_events' ),
            ),
            'menu_icon' => 'dashicons-calendar-alt',
            'public'      => true,
            'has_archive' => true,
            'rewrite'     => array( 'slug' => 'event' ),
            'menu_position' => 2,
        )
    );


    // >> Teachers Taxonomy
    $labels = array(
        'name'              => _x( 'Teachers', 'taxonomy general name', 'mt_events' ),
        'singular_name'     => _x( 'Teacher', 'taxonomy singular name', 'mt_events' ),
        'search_items'      => __( 'Search Teachers', 'mt_events' ),
        'all_items'         => __( 'Alle Teachers', 'mt_events' ),
        'edit_item'         => __( 'Edit Teachers', 'mt_events' ),
        'update_item'       => __( 'Update Teachers', 'mt_events' ),
        'add_new_item'      => __( 'Add Teachers', 'mt_events' ),
        'new_item_name'     => __( 'New Teachers Name', 'mt_events' ),
        'menu_name'         => __( 'Teachers', 'mt_events' ),
    );
    $args = array(
        'labels'            => $labels,
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
    );
    register_taxonomy( 'teacher', 'mt_events', $args );
    unset($args);
    unset($labels);


    // >> Category Taxonomy
    $labels = array(
        'name'              => _x( 'Categoriën', 'taxonomy general name', 'mt_events' ),
        'singular_name'     => _x( 'Categorie', 'taxonomy singular name', 'mt_events' ),
        'search_items'      => __( 'Search Categoriën', 'mt_events' ),
        'all_items'         => __( 'Alle Categoriën', 'mt_events' ),
        'edit_item'         => __( 'Edit Categoriën', 'mt_events' ),
        'update_item'       => __( 'Update Categoriën', 'mt_events' ),
        'add_new_item'      => __( 'Voeg Categorie toe', 'mt_events' ),
        'new_item_name'     => __( 'Nieuwe Categorie Naam', 'mt_events' ),
        'menu_name'         => __( 'Categoriën', 'mt_events' ),
    );
    $args = array(
        'labels'            => $labels,
        'hierarchical'      => true,
        'rewrite'     => array( 'slug' => 'events' ),
        'show_ui'           => true,
        'show_admin_column' => true,
    );
    register_taxonomy( 'mt_category', 'mt_events', $args );
}
add_action('init', 'mt_custom_post_type');



/*

>>> Taxonomy fix - hide parent dropdown

*/
add_filter( 'post_edit_category_parent_dropdown_args', 'hide_parent_dropdown_select' );

function hide_parent_dropdown_select( $args ) {
    if ( 'teacher' == $args['taxonomy'] ) {
        $args['echo'] = false;
    }
    if ( 'mt_category' == $args['taxonomy'] ) {
        $args['echo'] = false;
    }
    return $args;
}




/* 

> Register 3 Templates

*/

// >> 1. Single Event
function load_event_template( $template ) {
    global $post;

    if ( 'mt_events' === $post->post_type && locate_template( array( 'single-mt_events.php' ) ) !== $template ) {
        return plugin_dir_path( __FILE__ ) . 'templates/single-mt_events.php';
    }

    return $template;
}
add_filter( 'single_template', 'load_event_template' );

// >> 2. Overview & Filters - Archive pages
function event_archive_template( $template ) {
    // Category archive
    if ( is_archive() && property_exists(get_queried_object(),'taxonomy') ) {
        if(get_queried_object()->taxonomy == "mt_category" || get_queried_object()->taxonomy == "teacher"){
            $theme_files = array('archive-filter.php', 'meditatietuin-events/templates/archive-filter.php');
            $exists_in_theme = locate_template($theme_files, false);
            if ( $exists_in_theme != '' ) {
                return $exists_in_theme;
            } else {
                return plugin_dir_path(__FILE__) . 'templates/archive-filter.php';
            }
        }
    }
    // Events overview archive
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

// >> 3. Overview - Page template
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


/* 

> Stylesheet

*/
wp_register_style('style_css', plugin_dir_url(__FILE__) . 'dist/styles/style.css');
add_action( 'wp_enqueue_scripts', 'mt_style', 99 );
function mt_style(){
    wp_enqueue_style('style_css');
}


/* 

> Script

*/
wp_register_script('app_js', plugin_dir_url(__FILE__) . 'scripts/app.js',array('jquery'));
add_action( 'wp_enqueue_scripts', 'mt_script', 0 );
function mt_script(){
    wp_enqueue_script('app_js');

    $js_urls = array( 
        'plugin_url' => plugins_url(),
        'base_url' => site_url()
    );
    wp_localize_script( 'app_js', 'js_urls', $js_urls );     
    
}



/*

> Custom Fields

*/

// >> Event Single
$event = new FieldsBuilder('event');
$event
->addImage('banner',[
    'return_format' => 'url',
])
->addTextarea('samenvatting',[
    'label' => 'Korte samenvatting voor in overzicht',
    'rows' => '2',
    'instructions' => 'max. 180 karakters',
    'maxlength' => '180',
    'new_lines' => 'br',
])
->addRadio('event_type', [
        'label' => 'Type event',
        // 'return_format' => 'label',
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
            'return_format' => 'Ymd'
        ])
    ->conditional('event_type','==','eenmalig')
    ->or('event_type','==','eenmaliglang')
    ->or('event_type','==','reeks')
->addDatePicker('datum_end',[
            'display_format' => 'l j F Y',
            'return_format' => 'm/d/Y'
        ])
    ->conditional('event_type','==','eenmaliglang')
->addRepeater('data',[
        'min' => 2,
        'label' => 'Alle data in deze reeks/cursus:',
        'button_label' => 'Voeg datum toe',
    ])
    ->conditional('event_type','==','reeks')
    ->addDatePicker('datum',[
            'display_format' => 'l j F Y',
            'return_format' => 'm/d/Y'
        ])
->endRepeater()

->addGroup('time', [
            'label' => 'Tijden',
            'layout' => 'table',
          ])
    ->addTimePicker('start',[
            'display_format' => 'H:i',
            'return_format' => 'H:i',
        ])
    ->addTimePicker('end',[
            'display_format' => 'H:i',
            'return_format' => 'H:i',
        ])
->endGroup()
// ->addTrueFalse('fixed',[
//         'label' => 'Vaste positie in evenementen overzicht?',
//         'instructions' => 'Herhalende evenementen staan standaard bovenaan.<br>Zet dit vinkje uit als je dat niet wil. De datum van het event bepaald dan de positie.',
//         'ui' => true,
//         'default_value' => 1
//         ])
//     ->conditional('event_type','==','herhalend')
->addRepeater('tickets',[
        'layout' => 'table',
        'min' => 1,
    ])
    ->addNumber('prijs',[
        'wrapper' => [
            'width' => '14',
        ],
    ])
    ->addText('ticket_naam')
    ->addNumber('limit',[
            'label' => 'Limiet',
            'wrapper' => [
                'width' => '12',
            ],            
        ])
    ->addDatePicker('startdate',[
            'label' => 'Start verkoop',
            'display_format' => 'j M y',
            'return_format' => 'm/d/Y',            
            'wrapper' => [
                'width' => '18',
            ],            
        ])
    ->addDatePicker('enddate',[
            'label' => 'tot en met',
            'display_format' => 'j M y',
            'return_format' => 'm/d/Y',            
            'wrapper' => [
                'width' => '18',
            ],            
        ])

->endRepeater()
->addRadio('btw')
    ->addChoice('0','0% - Vrijgesteld')
    ->addChoice('9','9%')
    ->addChoice('21','21%')
    ->setDefaultValue('21')
->addTextarea('locatie',[
    'label' => 'Adres en/of zaal',    
    'rows' => '4',
    'new_lines' => 'br',
])
->addGroup('extra_velden', [
    'label' => 'Extra formulier velden',
    'instructions' => 'Kies hieronder welke extra informatie bezoekers moeten invullen',
    'layout' => 'row',
          ])
    ->addTrueFalse('geboortedatum',[
        'ui' => true,
    ])
    ->addTrueFalse('geslacht',[
        'ui' => true,
    ])
    ->addTrueFalse('extra_opmerkingen',[
        'ui' => true,
    ])
    ->addText('toelichting_voor_bezoekers')
        ->conditional('extra_opmerkingen','==','1')


->endGroup()
->setLocation('post_type', '==', 'mt_events');

add_action('acf/init', function() use ($event) {
   acf_add_local_field_group($event->build());
});

// >> Teacher Fields
$teacher_fields = new FieldsBuilder('teacher_info');
$teacher_fields
->addTextarea('beschrijving',[
    'instructions' => 'max. 100 karakters en 3 regels',
    'maxlength' => '100',
    'rows' => '3',
    'new_lines' => 'br',
])
->addImage('photo',[
    'instructions' => 'wordt automatisch vierkant uitgesneden',
    'return_format' => 'url',    
])
->addLink('website')
->setLocation('taxonomy', '==', 'teacher');

add_action('acf/init', function() use ($teacher_fields) {
   acf_add_local_field_group($teacher_fields->build());
});

// Remove default description box with teachers and categories
function hide_cat_descr() { ?>

    <style type="text/css">
       .term-description-wrap {
           display: none;
       }
    </style>

<?php } 

add_action( 'admin_head-term.php', 'hide_cat_descr' );
add_action( 'admin_head-edit-tags.php', 'hide_cat_descr' );

// >> Overview Fields
$overview_page = new FieldsBuilder('overview_page');
$overview_page
->addTextarea('subtitle',[
    'instructions' => 'max. 180 karakters en 3 regels',
    'maxlength' => '180',
    'rows' => '3',
    'new_lines' => 'br',
])
->setLocation('page_template', '==', 'page-template-events-overview.php');

add_action('acf/init', function() use ($overview_page) {
   acf_add_local_field_group($overview_page->build());
});


/*

> Add Fields to admin area

*/
// >> Payment Admin Fields
function add_paytium_columns ( $columns ) {
   return array_merge ( $columns, array ( 
     'description' => __ ( 'Event' ),
     'name' => __('Name'),
   ) );
 }
 add_filter ( 'manage_pt_payment_posts_columns', 'add_paytium_columns' );

function paytium_custom_column ( $column, $post_id ) {
    switch ( $column ) {
        case 'description':
            echo substr(get_post_meta($post_id,'_description')[0],0,-5);
            break;
        case 'name':
            echo get_post_meta($post_id,'_pt-customer-name')[0];
            break;

    }
}
add_action ( 'manage_pt_payment_posts_custom_column', 'paytium_custom_column', 10, 2 );

// >> Events Admin Fields
function add_acf_columns ( $columns ) {
   return array_merge ( $columns, array ( 
     'field_event_datum_start' => __ ( 'Start Event' ),
     'event_type' => __ ( 'Soort Event' ),
   ) );
 }
 add_filter ( 'manage_mt_events_posts_columns', 'add_acf_columns' );

function mt_events_custom_column ( $column, $post_id ) {
    switch ( $column ) {
        case 'field_event_datum_start':
            if(get_field('datum_start',$post_id)){
                $date_string = get_field('datum_start',$post_id);
                $date_string = substr($date_string,4,2).'/'.substr($date_string,6,2).'/'.substr($date_string,0,4);
                $unixtimestamp = strtotime( $date_string );
                echo date_i18n( "j F", $unixtimestamp );
                if(get_field('time',$post_id)){
                    echo ' - '.get_field('time',$post_id)['start'];
                }

            // }elseif(get_field('data',$post_id)){
            //     echo get_field('data',$post_id)[0]['datum'];
            }elseif(get_field('frequentie',$post_id)){
                echo get_field('frequentie',$post_id);
                if(get_field('time',$post_id)){
                    echo ' - '.get_field('time',$post_id)['start'];
                }                
            }
            break;
        case 'event_type':
            echo get_field_object('event_type',$post_id)['choices'][get_field('event_type')];
            break;
    }
}
add_action ( 'manage_mt_events_posts_custom_column', 'mt_events_custom_column', 10, 2 );

add_filter( 'manage_edit-mt_events_sortable_columns', 'sortable_column' );
function sortable_column( $columns ) {
    $columns['field_event_datum_start'] = 'sort';
 
    //To make a column 'un-sortable' remove it from the array
    unset($columns['date']);
    unset($columns['title']);
 
    return $columns;
}
add_action( 'pre_get_posts', 'my_slice_orderby',99 );
function my_slice_orderby( $query ) {
    if( ! is_admin() && 'mt_events' != $query->get( 'post_type' )  )
        return;
 
    $orderby = $query->get( 'orderby');
    if( 'sort' == $orderby || $_GET['post_type'] == 'mt_events') {
        $query->set('meta_key','datum_start');
        $query->set('orderby','meta_value_num');
    }
}
?>