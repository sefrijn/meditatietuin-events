<?php get_header(); ?>
<?php $authors = get_the_terms(get_the_ID(), 'teacher'); ?>
<?php $tags = get_the_terms(get_the_ID(), 'mt_category'); ?>

<?php include($plugin_dir.'/templates/components/cover.php'); ?>

<section class="bg-orange-very-light">
	<div class="tw-container flex flex-wrap items-start mx-auto px-4">

		<div class="triangle-red w-full text-center py-10 text-base sm:text-lg md:text-2xl font-sans-alt tracking-widest uppercase font-light text-orange-dark category">
			<?php foreach ( $tags as $tag) { ?>
				<span><?php echo $tag->name; ?></span>
			<?php } ?>	
		</div>
		<?php include($plugin_dir.'/templates/components/sidebar.php'); ?>
		<?php include($plugin_dir.'/templates/components/main.php'); ?>
	</div>
</section>
<?php include($plugin_dir.'/templates/components/tickets.php'); ?>

<?php echo do_shortcode('[elementor-template id="3610"]'); ?>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<?php get_footer(); ?>
