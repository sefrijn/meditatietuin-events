<?php 
$short_date;
if(get_field('event_type') == "reeks"){
	if( have_rows('data') ):
		while( have_rows('data') ) : the_row();
			$date_string = get_sub_field('datum');
			$unixtimestamp = strtotime( $date_string );
			echo '<span>'.date_i18n( "j F", $unixtimestamp ).'</span>';
			if(!$short_date){
				$short_date = date_i18n( "j F", $unixtimestamp );
			}
		endwhile;
	endif;
}
if(get_field('event_type') == "eenmalig"){
	$date_string = get_field('datum_start');
	$date_string = substr($date_string,4,2).'/'.substr($date_string,6,2).'/'.substr($date_string,0,4);
	$unixtimestamp = strtotime( $date_string );
	echo '<span>'.date_i18n( "j F", $unixtimestamp );
	$short_date = date_i18n( "j F", $unixtimestamp );
	if( have_rows('time') ):
		while( have_rows('time') ) : the_row();
			echo ' · '.get_sub_field('start');
		endwhile;
	endif;
	echo '</span>';
}
if(get_field('event_type') == "eenmaliglang"){
	$date_string = get_field('datum_start');
	$date_string = substr($date_string,4,2).'/'.substr($date_string,6,2).'/'.substr($date_string,0,4);
	$unixtimestamp = strtotime( $date_string );
	$date_string = get_field('datum_end');
	$unixtimestamp_end = strtotime( $date_string );
	echo '<span>'.date_i18n( "j F", $unixtimestamp );
	$short_date = date_i18n( "j F", $unixtimestamp );	
	echo ' t/m '.date_i18n( "j F", $unixtimestamp_end );
	echo '</span>';
}	
if(get_field('event_type') == "herhalend"){
	echo '<span>'.get_field('frequentie');
	$short_date = get_field('frequentie');
	if( have_rows('time') ):
		while( have_rows('time') ) : the_row();
			echo ' · '.get_sub_field('start');
		endwhile;
	endif;
	echo '</span>';
}	
?>