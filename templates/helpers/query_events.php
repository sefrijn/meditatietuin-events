<?php

$sort_by = "";
$filter_cat = array();
if(!empty($mt_category)){
	$filter_cat = array(
    	array(
        	'taxonomy' => 'mt_category',
        	'field'    => 'slug',
        	'terms'    => $mt_category,
    	),
	);
}
if(!empty($teacher)){
	$filter_cat = array(
    	array(
        	'taxonomy' => 'teacher',
        	'field'    => 'slug',
        	'terms'    => $teacher,
    	),
	);
}	
// $filter_teacher = 
$meta_key = 'frequentie';
$args = array(
	'post_status' => array(
		'future'
	),
	'post_type' => 'mt_events',
	'posts_per_page' => $events_per_page,
	'paged' => $page_number,
	'tax_query' => $filter_cat,

	// WORKING WITH EXTRA FIELD
	'meta_query'  => array(
		'relation' => 'OR',
		array(
			'key'     => $meta_key,
			'compare' => 'NOT EXISTS',
		),
		// array(
			// 'relation' => 'OR',
			// array(
			// 	'key'   => $meta_key,
			// 	'value' => 22,
			// ),
			array(
				'key'     => $meta_key,
				'value'   => 1,
				'compare' => '!=',
			),
		// ),
		array(
			'key'     => $meta_key,
			'value'   => 1,
			// 'compare' => '!=',
		),

	),
	'orderby'     => array( 'meta_value' => 'DESC', 'date' => 'ASC' ),


// // NEW
// 	'meta_query'  => array(
// 		'relation' => 'OR',
// 		// array(
// 		// 	'key'     => $meta_key,
// 		// 	'compare' => 'EXISTS',
// 		// ),
// 		// array(
// 			// 'relation' => 'OR',
// 			// array(
// 			// 	'key'   => $meta_key,
// 			// 	'value' => 22,
// 			// ),
// 		// ),
// 		array(
// 			'key'     => $meta_key,
// 			'value'   => 'herhalend',
// 			'compare' => '==',
// 		),
// 		array(
// 			'key'     => $meta_key,
// 			'value'   => 'herhalend',
// 			'compare' => '!=',
// 		),

// 	),
// 	// 'orderby'     => array( 'meta_value' => 'DESC', 'date' => 'ASC' ),	
// 	'orderby'     => array( 'date' => 'ASC' ),	



	// 'meta_query' => array(
	// 	'relation' => 'OR',
	// 	array(
	// 		'key' => 'fixed',
	// 		'compare' => 'NOT EXISTS',
	// 	),			
	// 	array(
	// 		'key' => 'fixed',
	// 		'compare' => 'EXISTS',
	// 	),
	// ),
 //    // 'meta_key' => 'fixed',
 //    'orderby' => 'fixed date',

	// // 'orderby' => array(
	// // 	'title' => 'ASC',
	// // 	// 'date' => 'ASC'
	// // ),
	// 'order' => 'ASC'
);

$query1 = new WP_Query( $args );
$total_pages = $query1->max_num_pages;

while ( $query1->have_posts() ) {
	$query1->the_post(); ?>

	<?php $authors = get_the_terms(get_the_ID(), 'teacher'); ?>
	<?php $tags = get_the_terms(get_the_ID(), 'mt_category'); ?>
	<a href="<?php echo get_the_permalink(); ?>" class="event-item block w-1/3 p-4 rounded-xl hover:bg-orange-light transition-colors hover:cursor-pointer">
		<div class="relative h-60">
			<img class="z-0 object-cover h-full w-full" src="<?php the_field('banner'); ?>" alt="">
			<div class="absolute bottom-0 w-full bg-gradient-to-t from-black bg-opacity-30 z-10 text-center text-white">
				<div class="text-shadow my-2 text-lg font-semibold text-white date">
					<?php include($plugin_dir.'/templates/components/cover-date.php'); ?>
				</div>
			</div>
		</div>
		<div class="text-center">
			<h3 class="text-2xl mt-5 tracking-wide normal-case text-black font-semibold"><?php the_title(); ?></h3>
			<p class="my-2 font-normal text-orange-medium teacher">met
				<?php 
				foreach ( $authors as $author) { ?>
					<span><?php echo $author->name; ?></span>
				<?php } ?>	
			</p>
			<p><?php the_field('samenvatting'); ?> </p>
		</div>
	</a>
	<?php
}
wp_reset_postdata();
?>