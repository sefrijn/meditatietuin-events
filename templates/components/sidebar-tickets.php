<?php 
if( have_rows('tickets') ):
	$lowest = 0;
	$highest = 0;
	while( have_rows('tickets') ) : the_row();
		if ($lowest == 0){
			$lowest = get_sub_field('prijs');
			$highest = $lowest;
		}else{
			if($lowest > get_sub_field('prijs')){
				$lowest = get_sub_field('prijs');
			}
			if($highest < get_sub_field('prijs')){
				$highest = get_sub_field('prijs');
			}
		}
	endwhile;
	if($lowest == 0 && $highest == 0){
		echo 'gratis';
	}elseif($lowest == $highest){
		echo '€'.$lowest;
	}else{
		echo '€'.$lowest .'  tot €'.$highest;
	}
endif;
?>