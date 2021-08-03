<section id="event-list" class="events tw-container mx-auto flex flex-wrap" data-page-amount="<?php echo $events_per_page; ?>" data-teacher="<?php echo $teacher; ?>" data-mt_category="<?php echo $mt_category; ?>">


	<?php 
	$page_number = 0;
	include($plugin_dir.'/templates/helpers/query_events.php'); ?>
</section>

<div class="text-center w-full py-12" data-max-pages="<?php echo $total_pages; ?>">
	<a href="#" class="loadmore font-sans-alt mt-5 hidden mx-auto bg-orange-light hover:bg-orange-medium transition-colors text-orange-dark text-center text-xl uppercase px-4 py-2">Meer laden...</a>
	<p class="text-center text-orange-medium-dark uppercase font-base loadmore_end hidden">Dit zijn alle evenementen</p>
</div>
