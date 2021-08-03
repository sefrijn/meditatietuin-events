<section class="filter z-20 relative">
	<div class="flex space-x-4 items-center justify-center pb-4">
		<?php if(is_archive()){ ?>
			<a href="<?php echo get_the_permalink($page_id); ?>" class="inline-block justify-center px-4 py-2 text-base font-medium leading-5 text-orange-dark transition duration-150 ease-in-out hover:text-gray-700 hover:bg-orange-medium focus:bg-orange-light rounded-md focus:outline-none focus:border-orange-dark active:bg-orange-medium active:text-gray-800">Verwijder filter 
				<svg class="inline-block h-3 w-3 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="-949 951 100 125">
					<path d="M-851.5 966.2l-12.7-12.7-34.8 34.8-34.8-34.8-12.7 12.7 34.8 34.8-34.8 34.8 12.7 12.7 34.8-34.8 34.8 34.8 12.7-12.7-34.8-34.8z"/>
				</svg>
			</a>
		<?php }else{ ?>
			<span class="inline-block justify-center px-4 py-2 text-base font-medium leading-5 text-orange-dark transition duration-150 ease-in-out rounded-md">Filter Events 
				<svg class="inline-block h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 40">
				    <path d="M3 7h1v2a1 1 0 001 1h6a1 1 0 001-1V7h17a1 1 0 000-2H12V3a1 1 0 00-1-1H5a1 1 0 00-1 1v2H3a1 1 0 000 2zm3-3h4v4H6V4zM29 15h-3v-2a1 1 0 00-1-1h-6a1 1 0 00-1 1v2H3a1 1 0 000 2h15v2a1 1 0 001 1h6a1 1 0 001-1v-2h3a1 1 0 000-2zm-5 3h-4v-4h4v4zM29 25H16v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2H3a1 1 0 000 2h5v2a1 1 0 001 1h6a1 1 0 001-1v-2h13a1 1 0 000-2zm-15 3h-4v-4h4v4z"/>
				</svg>
			</span>
		<?php } ?>
		<?php $taxonomy = "mt_category"; ?>
		<?php $name = "Categorie" ?>
		<?php include($plugin_dir.'/templates/helpers/get_filter_list.php'); ?>
		<?php $taxonomy = "teacher"; ?>
		<?php $name = "Teacher" ?>
		<?php include($plugin_dir.'/templates/helpers/get_filter_list.php'); ?>
	</div>
</section>