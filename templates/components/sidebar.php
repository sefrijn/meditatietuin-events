<aside class="z-20 w-full xl:w-1/5 lg:w-1/4 md:w-1/3 md:order-1 order-2 xl:h-32 relative">
	<div class="w-full bg-green-medium mb-4 xl:mb-16 rounded-2xl xl:absolute">
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
				<a href="#tickets" class="scrollto tw-button mt-5 w-full block">Inschrijven</a>
			</div>
		</div>
		<div class="max-h-16">
			<img class="-mt-4 w-full h-full" src="<?php echo plugin_dir_url(__DIR__) ?>../img/wave-green-small.svg" alt="">
		</div>
		<div class="bg-green-dark pb-3 px-4 rounded-b-2xl text-center">
			<p class="-mt-5 mb-1 label text-orange-dark font-semibold text-sm uppercase">Facilitator</p>

			<?php foreach ( $authors as $author) { ?>
				<div class="teacher_profile mb-3 flex flex-col items-center">
					<?php if(get_field('photo',$author)) : ?>
						<img class="mb-1 rounded-full object-cover w-32 h-32" src="<?php echo get_field('photo',$author); ?>" alt="">
					<?php endif; ?>
					<strong><?php echo $author->name; ?></strong>

					<?php if(get_field('beschrijving',$author)) : ?>				
						<p class="text-base"><?php echo get_field('beschrijving',$author); ?> </p>
					<?php endif; ?>

					<?php if(get_field('website',$author)) : ?>
						<a target="_BLANK" href="<?php echo get_field('website',$author)['url'] ?>" class="text-orange-dark text-base font-semibold">
							<span class="underline"><?php echo get_field('website',$author)['title'] ?></span> <i class="fa fa-external-link fa-sm"></i>
						</a>
					<?php endif; ?>
				</div>
			<?php } ?>	
		</div>
	</div>
</aside>