<?php $teachers = get_terms(array(
	'taxonomy' => 'teacher'
));
foreach( $teachers as $teacher){ ?>
	<a href="<?php echo get_term_link($teacher); ?>" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1">
		<?php echo $teacher->name; ?>
	</a>
<?php } ?>