<aside class="w-full xl:w-1/5 lg:w-1/4 md:w-1/3 md:order-1 order-2 bg-green-medium mb-16 rounded-2xl">
	<div class="px-4 pt-6 relative z-10">
		<?php include($plugin_dir.'/templates/components/sidebar-date.php'); ?>

		<p class="mt-5 label text-orange-dark font-semibold text-sm uppercase">waar</p>
		<p class="font-semibold text-base text-black text-opacity-50">
			<?php the_field('locatie'); ?>
		</p>

		<p class="mt-5 label text-orange-dark font-semibold text-sm uppercase">prijs</p>
		<p class="font-semibold text-base text-black text-opacity-50">
			<?php include($plugin_dir.'/templates/components/sidebar-tickets.php'); ?>
		</p>
		<div class="">
			<a href="#tickets" class="scrollto font-sans-alt mt-5 w-full block bg-orange-light hover:bg-orange-medium transition-colors text-orange-dark text-center text-xl uppercase px-4 py-2">Inschrijven</a>
		</div>
	</div>
	<div class="max-h-16">
		<img class="-mt-4 w-full h-full" src="<?php echo plugin_dir_url(__DIR__) ?>../img/wave-green-small.svg" alt="">
	</div>
	<div class="bg-green-dark pb-3 px-4 rounded-b-2xl text-center">
		<p class="-mt-5 mb-1 label text-orange-dark font-semibold text-sm uppercase">Facilitator</p>

		<?php foreach ( $authors as $author) { ?>
			<div class="teacher_profile mb-3 flex flex-col items-center">
				<img class="mb-1 rounded-full object-cover w-32 h-32" src="<?php echo get_field('photo',$author); ?>" alt="">
				<strong><?php echo $author->name; ?></strong>
				<p class="text-base"><?php echo get_field('beschrijving',$author); ?> </p>
				<a target="_BLANK" href="<?php echo get_field('website',$author)['url'] ?>" class="text-orange-dark text-base font-semibold">
					<span class="underline"><?php echo get_field('website',$author)['title'] ?></span> <i class="fa fa-external-link fa-sm"></i></a>
			</div>
		<?php } ?>	
	</div>


</aside>