<?php 
$filtered_month = "";
if ($_GET['maand']) {
	// Set Dutch month
	$filtered_month = $_GET['maand'];

	// Set English numbered month for filters
	$dutch_months = array('januari','februari','maart','april','mei','juni','juli','augustus','september','oktober','november','december');
	$numbered_months = array(1,2,3,4,5,6,7,8,9,10,11,12);
	$filtered_month_array = explode('-',$filtered_month);
	$filtered_month_array[0] = sprintf('%02d', str_replace($dutch_months,$numbered_months,$filtered_month_array[0]));
	$filtered_month_english = '01-'.implode('-',$filtered_month_array);
}
?>

<section class="filter z-20 relative">
	<div class="flex flex-col sm:flex-row space-x-4 items-center justify-center pb-4">
		<?php if(is_archive() || $filtered_month != ""){ ?>
			<a href="<?php echo get_the_permalink($page_id); ?>" class="inline-block justify-center px-4 py-2 text-base font-medium leading-5 text-orange-dark transition duration-150 ease-in-out hover:text-gray-700 hover:bg-orange-medium focus:bg-orange-light rounded-md focus:outline-none focus:border-orange-dark active:bg-orange-medium active:text-gray-800">Verwijder filter
				<span style="line-height: 10px;position: relative;top: 3px;" class="text-2xl">&#215;</span>
			</a>
		<?php }else{ ?>
			<span class="inline-block justify-center px-4 py-2 text-base font-medium leading-5 text-orange-dark transition duration-150 ease-in-out rounded-md">Filter Events
			</span>
		<?php } ?>

		<?php $taxonomy = "none"; ?>
		<?php $name = "Datum" ?>
		<?php $terms = ""; ?>
		<?php include($plugin_dir.'/templates/helpers/get_filter_list.php'); ?>

		<?php $taxonomy = "mt_category"; ?>
		<?php $name = "Categorie" ?>



		<?php 
		// Get all future events
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
		$args = array(
			'post_status' => array(
				'publish'
			),
			'post_type' => 'mt_events',
			'posts_per_page' => 1000,
			'meta_query' => $filter_date,
		);
		$query_filter = new WP_Query( $args );
		// Create empty term array
		$term_list = array();

		// Loop through and get terms for specific event and add to term array
		while ( $query_filter->have_posts() ) {
			$query_filter->the_post();
			if(is_array(get_the_terms(get_the_ID(),$taxonomy))){
				$term_list = array_merge($term_list,get_the_terms(get_the_ID(),$taxonomy));
			}
		}

		// Remove duplicates
		$terms = array_unique($term_list, SORT_REGULAR);

		 ?>
		<?php include($plugin_dir.'/templates/helpers/get_filter_list.php'); ?>

		<?php $taxonomy = "teacher"; ?>
		<?php $name = "Teacher" ?>
		<?php 
		$term_list = array();
		while ( $query_filter->have_posts() ) {
			$query_filter->the_post();
			if(is_array(get_the_terms(get_the_ID(),$taxonomy))){
				$term_list = array_merge($term_list,get_the_terms(get_the_ID(),$taxonomy));
			}
		}

		// Remove duplicates
		$terms = array_unique($term_list, SORT_REGULAR);

		 ?>
		<?php include($plugin_dir.'/templates/helpers/get_filter_list.php'); ?>
		<?php
		// Reset filter query
		wp_reset_postdata();
		 ?>
	</div>
</section>
