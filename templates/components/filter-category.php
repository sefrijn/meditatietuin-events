<?php $categories = get_terms(array(
	'taxonomy' => 'mt_category'
));
foreach( $categories as $category){ ?>
	<a href="<?php echo get_term_link($category); ?>" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1">
		<?php echo $category->name; ?>
	</a>
<?php } ?>