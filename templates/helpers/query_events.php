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
if(isset($daterange_start)){
	$filter_date = array(
		'relation' => 'AND',
		array(
			'key' => 'datum_start',
			'compare' => '>=',
			'value' => date("Ymd",strtotime($daterange_start))
		),
		array(
			'key' => 'datum_start',
			'compare' => '<',
			'value' => date("Ymd",strtotime($daterange_end))
		),
	);
}else{
	$filter_date = array(
		'relation' => 'OR',
		array(
			'key' => 'datum_start',
			'compare' => '>',
			'value' => date("Ymd")
		),
		array(
			'key' => 'event_type',
			'compare' => '==',
			'value' => 'herhalend'
		)
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
$meta_key = 'datum_start';
$args = array(
	'post_status' => array(
		'publish'
	),
	'post_type' => 'mt_events',
	'posts_per_page' => $events_per_page,
	'paged' => $page_number,
	'tax_query' => $filter_cat,
	'meta_key' => $meta_key,
	'meta_query' => $filter_date,
	'orderby' => 'meta_value_num',
	'order' => 'ASC'
);

$query1 = new WP_Query( $args );
$total_pages = $query1->max_num_pages;

while ( $query1->have_posts() ) {
	$query1->the_post(); ?>

	<?php $authors = get_the_terms(get_the_ID(), 'teacher'); ?>
	<?php $tags = get_the_terms(get_the_ID(), 'mt_category'); ?>
	<a href="<?php echo get_the_permalink(); ?>" class="event-item block w-full sm:w-1/2 lg:w-1/3 p-4 rounded-xl hover:bg-orange-light transition-colors hover:cursor-pointer">
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
			<p class="mb-2 font-normal text-orange-dark teacher text-lg">met
				<?php 
				foreach ( $authors as $author) { ?>
					<span><?php echo $author->name; ?></span>
				<?php } ?>	
			</p>
			<p class="text-base"><?php the_field('samenvatting'); ?> </p>
		</div>
	</a>
	<?php
}
wp_reset_postdata();
?>