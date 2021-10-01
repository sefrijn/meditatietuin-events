<?php 
$ticket_date = date_i18n( "ymd", $unixtimestamp );

function checkLimits(){
	global $unixtimestamp;
	if(get_sub_field('limit')){
		$r = 'limit="'.get_sub_field('limit').'" item_id="'.sanitize_title(get_the_title()."-".get_sub_field('ticket_naam'))."-".$unixtimestamp.'" limit_message="<span>'.get_sub_field('ticket_naam').'</span><span>Uitverkocht</span>" ';
		return $r;
	}
}
function createTicket(){
	$btw = 21;
	if(get_sub_field('btw')){
		$btw = get_sub_field('btw');
	}
	return 'type="label" show_amount="true" label="'.get_sub_field('ticket_naam').'" amount="'.get_sub_field('prijs').'" tax="'.$btw.'" quantity="true" /]';
}

?>

<section id="tickets" class="bg-orange-dark" style="min-height:600px;">

	<div class="absolute w-full bg-orange-very-light">
		<?php include($plugin_dir.'/img/wave-orange-large2.svg'); ?>	
	</div>
	<div class="relative z-10 pt-6">
		<h1 class="text-2xl sm:text-4xl md:text-5xl font-semibold text-center">Reserveer je plek</h1>
		<h3 class="text-base sm:text-lg md:text-2xl text-center mt-3"><?php the_title(); ?></h3>
		<div class="max-w-screen-sm mx-auto pb-12 pt-6">
			<?php $tickets_code = '[paytium name="'.get_the_title().' ('.$ticket_date.')" description="'.get_the_title().' ('.$ticket_date.')"]';
			$tickets_code .= '[paytium_field placeholder="Voornaam" type="firstname" label="Voornaam" required="true" /]';
			$tickets_code .= '[paytium_field placeholder="Achternaam" type="lastname" label="Achternaam" required="true" /]';
			$tickets_code .= '[paytium_field placeholder="Email" type="email" label="Email" required="true" /]';
			$tickets_code .= '[paytium_field placeholder="Telefoon" type="text" label="Telefoon" /]';
			if(get_field('extra_velden')['geboortedatum'] && get_field('extra_velden')['geboortedatum'] != "") {
				$tickets_code .= '[paytium_field placeholder="Geboortedatum (dd-mm-yy)" type="date" label="Geboortedatum" required="true" /]';
			}
			if(get_field('extra_velden')['geslacht'] && get_field('extra_velden')['geslacht'] != "") {
				$tickets_code .= '[paytium_field type="dropdown" first_option="text" first_option_text="Geslacht" label="Geslacht" options="Man/Vrouw/Queer" required="true" /]';
			}
			if(get_field('extra_velden')['extra_opmerkingen'] && get_field('extra_velden')['extra_opmerkingen'] != "") {
				$uitleg = "Extra Opmerkingen?";
				if(get_field('extra_velden')['toelichting_voor_bezoekers']){
					$uitleg = get_field('extra_velden')['toelichting_voor_bezoekers'];
				}
				$tickets_code .= '[paytium_field placeholder="Je antwoord" type="textarea" label="'.$uitleg.'" required="false" /]';
			}


			$today = strtotime(date("m/d/Y"));
			if( have_rows('tickets') ){
				while( have_rows('tickets') ){
					the_row();

					if(get_sub_field('startdate') || get_sub_field('enddate')){
						// Dates are set, enable only active tickets

						if((strtotime(get_sub_field('startdate')) <= $today && get_sub_field('startdate')) && (strtotime(get_sub_field('enddate')) >= $today && get_sub_field('enddate'))){
							// start and end date
							$tickets_code .= '[paytium_field ';
							$tickets_code .= checkLimits();
							$tickets_code .= createTicket();
						}elseif((strtotime(get_sub_field('startdate')) <= $today && get_sub_field('startdate')) && !get_sub_field('enddate')){
							// only start date
							$tickets_code .= '[paytium_field ';
							$tickets_code .= checkLimits();
							$tickets_code .= createTicket();

						}elseif((strtotime(get_sub_field('enddate')) >= $today && get_sub_field('enddate')) && !get_sub_field('startdate')){
							// only end date
							$tickets_code .= '[paytium_field ';
							$tickets_code .= checkLimits();
							$tickets_code .= createTicket();

						}else{
							// Display disabled tickets gray
							$tickets_code .= '[paytium_field type="label" label="'.get_sub_field('ticket_naam').'<span>€ '.get_sub_field('prijs').'</span>"/]';
						}
					}else{
						// No dates set, check limits
						$tickets_code .= '[paytium_field ';						
						$tickets_code .= checkLimits();
						$tickets_code .= createTicket();						
					}
				}
			}

			$tickets_code .= '[paytium_total /]';
			$tickets_code .=  '[paytium_button label="Bestellen" /]';
			$tickets_code .=  '[/paytium]';
			echo do_shortcode($tickets_code);
			 ?>
		</div>
	</div>
</section>