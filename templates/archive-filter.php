<?php 
/*
* Template Name: Events Overview
*/

?>

<?php get_header(); ?>

<?php 
$args = [
    'post_type' => 'page',
    'fields' => 'ids',
    'nopaging' => true,
    'meta_key' => '_wp_page_template',
    'meta_value' => 'page-template-events-overview.php'
];
$pages = get_posts( $args );
$page_id = -1;
foreach ( $pages as $page ) 
    $page_id = $page;
 ?>

<div class="bg-orange-very-light">

	<section class="top tw-container max-w-prose mx-auto pt-12 pb-10 text-center">
		<h1 class="text-4xl mb-6 font-semibold"><?php echo get_the_title($page_id); ?></h1>
		<p class="text-xl text-orange-dark font-medium font-sans-alt"><?php echo get_field('subtitle',$page_id); ?></p>
	</section>

	<?php include($plugin_dir.'/templates/components/filter.php'); ?>
	<?php include($plugin_dir.'/templates/components/event-list.php'); ?>

</div>
<?php echo apply_filters('the_content', get_post_field('post_content', $page_id)); ?>
<?php get_footer(); ?>