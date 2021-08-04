<!-- Reeks -->
<?php if(get_field('event_type') == "reeks"): ?>
	<?php if( have_rows('data') ): ?>
		<p class="label">reeks</p>
		<?php while( have_rows('data') ) : the_row(); ?>
			<?php $date_string = get_sub_field('datum'); ?>
			<?php $unixtimestamp = strtotime( $date_string ); ?>
			<p class="details mb-2">
				<?php echo date_i18n( "l j F Y", $unixtimestamp );  ?>
				<br>
				<?php echo get_field('time')['start']; ?>
				<?php if(get_field('time')['end'] && get_field('time')['end'] != ""):
					echo ' - '.get_field('time')['end']; ?>
				<?php endif; ?>
			</p>
		<?php endwhile; ?>
	<?php endif; ?>
<?php endif; ?>

<!-- Eenmalig -->
<?php if(get_field('event_type') == "eenmalig"): ?>
	<?php $date_string = get_field('datum_start'); ?>
	<?php $date_string = substr($date_string,4,2).'/'.substr($date_string,6,2).'/'.substr($date_string,0,4); ?>	
	<?php $unixtimestamp = strtotime( $date_string ); ?>

	<p class="label">wanneer</p>
	<p class="details">
		<?php echo date_i18n( "l j F Y", $unixtimestamp )  ?>
		<br>
		<?php echo get_field('time')['start']; ?>
		<?php if(get_field('time')['end'] && get_field('time')['end'] != ""):
			echo ' - '.get_field('time')['end']; ?>
		<?php endif; ?>
	</p>
<?php endif; ?>

<!-- Meerdere dagen -->
<?php if(get_field('event_type') == "eenmaliglang"): ?>
	<?php $date_string = get_field('datum_start'); ?>
	<?php $date_string = substr($date_string,4,2).'/'.substr($date_string,6,2).'/'.substr($date_string,0,4); ?>	
	<?php $unixtimestamp = strtotime( $date_string ); ?>
	<?php $date_string = get_field('datum_end'); ?>
	<?php $unixtimestamp_end = strtotime( $date_string ); ?>

	<p class="label">wanneer</p>
	<p class="details">
		van <?php echo date_i18n( "D j M Y", $unixtimestamp )  ?>, 
		<?php echo get_field('time')['start']; ?>
		<br>
		t/m <?php echo date_i18n( "D j M Y", $unixtimestamp_end )  ?>, 
		<?php if(get_field('time')['end'] && get_field('time')['end'] != ""):
			echo get_field('time')['end']; ?>
		<?php endif; ?>
	</p>
<?php endif; ?>

<!-- Herhalend -->
<?php if(get_field('event_type') == "herhalend"): ?>
	<p class="label">wanneer</p>
	<p class="details">
		<?php echo get_field('frequentie'); ?>
		<br>
		<?php echo get_field('time')['start']; ?>
		<?php if(get_field('time')['end'] && get_field('time')['end'] != ""):
			echo ' - '.get_field('time')['end']; ?>
		<?php endif; ?>
	</p>
<?php endif; ?>