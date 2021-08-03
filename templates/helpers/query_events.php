<?php 
$my_query = new WP_Query($args);

if( $my_query->have_posts() ) {
	while ( $my_query->have_posts() ) : $my_query->the_post();

		// Get categories to add as a class
		$categories = get_the_terms(get_the_ID(),'categories');
		$cat_result = "";
		if ( $categories && ! is_wp_error( $categories ) ) { 
			$cat_list = array(); 
			foreach ( $categories as $category ) {
				$cat_list[] = $category->slug;
			}
			$cat_result = join( " ", $cat_list );
		}

		// Get markets to add as a class
		$markets = get_the_terms(get_the_ID(),'markets');
		$markets_result = "";
		if ( $markets && ! is_wp_error( $markets ) ) { 
			$markets_list = array(); 
			foreach ( $markets as $market ) {
				$markets_list[] = $market->slug;
			}
			$markets_result = join( " ", $markets_list );
		}
		?>

		<a href="<?php echo get_the_permalink(); ?>" class="block block-image" style="opacity:0;" data-categories="<?php echo $cat_result; ?>" data-markets="<?php echo $markets_result; ?>" data-sorting="<?php echo get_post_field( 'menu_order', get_the_id()); ?>">
			<div class="image-wrapper">
				<div class="image">
				<?php if ( has_post_thumbnail()) {
					the_post_thumbnail('work-overview');
				} ?>
				</div>
				<div class="content-wrapper content-pink">
					<div class="content">
						<?php if(get_field('overview_more',get_the_ID())){ ?>
							<h3 class="subtitle"><?php echo get_field('overview_more',get_the_ID()); ?></h3>
						<?php }else{ ?>
							<h3 class="subtitle"><?php _e('read more','vb'); ?></h3>
						<?php } ?>
					</div>
				</div>
			</div>
			<h3 class="text-center"><?php the_title(); ?></h3>
		</a>
	<?php 
	endwhile;
}


?>