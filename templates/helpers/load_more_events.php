<?php 
	$page_number = $_GET['pageid'];
	$page_parent = $_GET['parent'];
	$post_amount = $_GET['postperpage'];
	$category = $_GET['category'];
	$market = $_GET['market'];
	
	include("../../../../wp-blog-header.php"); 
	wp_reset_postdata();		
	$args=array(
		// 'post_type' => 'page',
		'post_type' => 'vb_projects',
		'post_status' => 'publish',
		'posts_per_page' => $post_amount,
		'paged' => $page_number,
		// 'post_parent' => $page_parent,
		'tax_query' => array(
			'relation' => 'AND',
			array(
				'taxonomy' => 'categories',
				'field' => 'term_id',
				'terms' => $category,
				'operator' => 'IN',
			),
			array(
				'taxonomy' => 'markets',
				'field' => 'term_id',
				'terms' => $market,
				'operator' => 'IN',
			)					
		),		
		'order' => 'ASC',
		'orderby' => 'menu_order'
		);

	include('projects_query.php');

?>

