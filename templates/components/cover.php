<section class="relative">
	<img class="z-0 absolute object-cover h-full w-full" src="<?php the_field('banner'); ?>" alt="">
	<div class="bg-black bg-opacity-30 max-width-prose mx-auto py-24 relative z-10 text-center text-white">
		<h1 class="text-shadow text-2xl sm:text-4xl lg:text-6xl text-white font-semibold"><?php the_title(); ?></h1>
		<p class="text-shadow mt-4 -mb-1 label">door</p>
		<h2 class="text-shadow text-lg sm:text-2xl md:text-3xl text-orange-medium teacher font-semibold normal-case tracking-wide">
			<?php 
			foreach ( $authors as $author) { ?>
				<span><?php echo $author->name; ?></span>
			<?php } ?>	
		</h2>
		<p class="text-shadow mt-4 -mb-1 label">wanneer</p>
		<div class="text-shadow text-lg sm:text-2xl font-semibold text-orange-medium date">
			<?php include($plugin_dir.'/templates/components/cover-date.php'); ?>
		</div>
	</div>
</section>