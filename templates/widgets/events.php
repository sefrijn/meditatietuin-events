<?php
namespace Elementor;
use WP_Query;

class My_Widget_1 extends Widget_Base {
	
	public function get_name() {
		return 'events';
	}
	
	public function get_title() {
		return 'Events Block';
	}
	
	public function get_icon() {
		return 'eicon-gallery-grid';
	}
	
	public function get_categories() {
		return [ 'basic' ];
	}
	
	protected function _register_controls() {

		$this->start_controls_section(
			'section_title',
			[
				'label' => __( 'Events block', 'elementor' ),
			]
		);
		
		$this->end_controls_section();
	}
	
	protected function render() {

        $settings = $this->get_settings_for_display();
		$meta_key = 'datum_start';
		$filter_date = array(
			'relation' => 'OR',
			array(
				'key' => 'datum_start',
				'compare' => '>',
				'value' => date("Ymd")
			),
			// array(
			// 	'key' => 'event_type',
			// 	'compare' => '==',
			// 	'value' => 'herhalend'
			// )
		);		
        $args = array(
        	'post_status' => array(
        		'publish'
        	),
        	'post_type' => 'mt_events',
        	'posts_per_page' => 6,
        	'meta_key' => $meta_key,
        	'meta_query' => $filter_date,
        	'orderby' => 'meta_value_num',
        	'order' => 'ASC'        	
        );

        $query_events = new WP_Query( $args );

    	echo '<section id="event-list" class="events flex flex-wrap">';
        while ( $query_events->have_posts() ) {
        	$query_events->the_post();

        	$authors = get_the_terms(get_the_ID(), 'teacher');
        	$tags = get_the_terms(get_the_ID(), 'mt_category');
        	echo '<a href="'.get_the_permalink().'" class="event-item block w-full sm:w-1/2 lg:w-1/3 p-4 rounded-xl hover:bg-orange-very-dark transition-colors hover:cursor-pointer">
        		<div class="relative h-60">
        			<img class="z-0 object-cover h-full w-full" src="'.get_field('banner').'" alt="">
        			<div class="absolute bottom-0 w-full bg-gradient-to-t from-black bg-opacity-30 z-10 text-center text-white">
        				<div class="text-shadow my-2 text-lg font-semibold text-white date">';
        					include(dirname(__FILE__).'/../components/cover-date.php');
        				echo '</div>
        			</div>
        		</div>
        		<div class="text-center">
        			<h3 class="text-2xl mt-5 tracking-wide normal-case text-black font-semibold">'.get_the_title().'</h3>
        			<p class="mb-2 font-semibold text-orange-medium teacher text-lg">met ';
						foreach ( $authors as $author) {
							echo '<span>'.$author->name.'</span>';
						}
        			echo '</p>
        			<p class="text-base">'.get_field('samenvatting').'</p>
        		</div>
        	</a>';
        }
        echo '</section>';
        wp_reset_postdata();

		 

	}
	
	protected function _content_template() {

    }
	
	
}