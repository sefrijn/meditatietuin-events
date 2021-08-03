<?php 
/*
* Template Name: Events Overview
*/

?>

<?php get_header(); ?>
<?php $plugin_dir = WP_PLUGIN_DIR . '/meditatietuin-events'; ?>
<?php $plugin_url = WP_PLUGIN_URL . '/meditatietuin-events'; ?>

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

	<section class="top tw-container max-w-prose mx-auto py-16 text-center">
		<h1 class="text-4xl mb-6 font-semibold"><?php the_archive_title(); ?></h1>
		<p class="text-xl text-orange-dark font-medium font-sans-alt"><?php the_field('subtitle'); ?></p>
	</section>

	<section class="filter z-20 relative">
		<div class="flex items-center justify-center p-12">
			<?php $filter = "category"; ?>
			<?php include($plugin_dir.'/templates/components/filter.php'); ?>
			<?php $filter = "teacher"; ?>
			<?php include($plugin_dir.'/templates/components/filter.php'); ?>

		</div>
	</section>

	<section class="events tw-container mx-auto flex flex-wrap">
		<?php 

		$args = array(
			'post_type' => 'mt_events',
			'posts_per_page'=> 3,
		);

		$query1 = new WP_Query( $args );

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
	</section>
</div>
<?php echo apply_filters('the_content', get_post_field('post_content', $page_id)); ?>
<?php get_footer(); ?>