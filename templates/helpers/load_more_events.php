<?php 
	$page_number = $_GET['page_number'];
	$events_per_page = $_GET['postperpage'];
	$mt_category = $_GET['mt_category'];
	$teacher = $_GET['teacher'];
	if(!empty($_GET['filtered_month'])){
		$daterange_start = $_GET['filtered_month'];
		$time = strtotime($daterange_start);
		$daterange_end = date("d-m-Y", strtotime("+1 month", $time));
	}
	
	include("../../../../../wp-blog-header.php"); 
	wp_reset_postdata();
	$plugin_dir = WP_PLUGIN_DIR . '/meditatietuin-events';
	$plugin_url = WP_PLUGIN_URL . '/meditatietuin-events';

	include('query_events.php');

?>

