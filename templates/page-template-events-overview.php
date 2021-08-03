<?php 
/*
* Template Name: Events Overview
*/

?>

<?php get_header(); ?>
<?php $mt_category = ""; ?>
<?php $teacher = ""; ?>


<div class="bg-orange-very-light">

	<section class="top tw-container max-w-prose mx-auto pt-12 pb-10 text-center">
		<h1 class="text-4xl mb-6 font-semibold"><?php the_title(); ?></h1>
		<p class="text-xl text-orange-dark font-medium font-sans-alt"><?php the_field('subtitle'); ?></p>
	</section>

	<?php include($plugin_dir.'/templates/components/filter.php'); ?>
	<?php include($plugin_dir.'/templates/components/event-list.php'); ?>


</div>
<?php the_content(); ?>
<?php get_footer(); ?>