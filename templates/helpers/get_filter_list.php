<?php 
$active = false;
if(get_queried_object()->taxonomy === $taxonomy){
	$name = get_queried_object()->name;
	$active = true;
}
 ?>

<div class="relative inline-block text-left dropdown">
	<span class="rounded-md"
	><button class="<?php if($active){ echo 'bg-orange-light '; } ?>inline-flex justify-center w-full px-4 py-2 text-base font-medium leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-orange-medium focus:bg-orange-light rounded-md focus:outline-none focus:border-orange-dark active:bg-orange-medium active:text-gray-800" 
	type="button" aria-haspopup="true" aria-expanded="true" aria-controls="headlessui-menu-items-117">
	<span><?php echo ucfirst($name); ?></span>
	<svg class="w-5 h-5 ml-2 -mr-1" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
	</button
	></span>
	<div class="opacity-0 invisible dropdown-menu transition-all duration-300 transform origin-top-right -translate-y-2 scale-95">
		<div class="absolute left-0 w-56 mt-2 origin-top-left bg-white border border-gray-200 divide-y divide-gray-100 rounded-md shadow-lg outline-none" aria-labelledby="headlessui-menu-button-1" id="headlessui-menu-items-117" role="menu">
			<div class="py-1">
				<a href="<?php echo get_the_permalink($page_id); ?>" class="<?php if($active == false){ echo 'bg-orange-light '; } ?> text-gray-700 border-b border-gray-200 block px-4 py-2 text-sm font-medium" role="menuitem" tabindex="-1">
					Alles
				</a>

				<?php $terms = get_terms(array(
					'taxonomy' => $taxonomy,
					'hide_empty' => false
				));
				foreach( $terms as $term){ ?>
					<a href="<?php echo get_term_link($term); ?>" class="<?php if($name == $term->name){ echo 'bg-orange-light '; } ?> text-gray-700 block px-4 py-2 text-sm font-medium" role="menuitem" tabindex="-1">
						<?php echo $term->name; ?>
					</a>
				<?php } ?>
			</div>
		</div>
	</div>              
</div>