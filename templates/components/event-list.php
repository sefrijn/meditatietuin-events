<?php 
if(isset($filtered_month_english)){
	$daterange_start = $filtered_month_english;
	$time = strtotime($daterange_start);
	$daterange_end = date("d-m-Y", strtotime("+1 month", $time));	
}
 ?>

<section id="event-list" class="events tw-container mx-auto flex flex-wrap" data-page-amount="<?php echo $events_per_page; ?>" data-teacher="<?php echo $teacher; ?>" data-mt_category="<?php echo $mt_category; ?>" data-month="<?php echo $filtered_month_english; ?>">


	<?php 
	$page_number = 0;
	include($plugin_dir.'/templates/helpers/query_events.php'); ?>
</section>

<div class="text-center w-full py-12" data-max-pages="<?php echo $total_pages; ?>">
	<a href="#" class="loadmore mt-5 hidden mx-auto tw-button">Meer laden...</a>
	<p class="text-center text-orange-medium-dark uppercase font-base loadmore_end hidden">Dit zijn alle evenementen</p>
</div>
