<?php 
$active = false;
if(get_queried_object()->taxonomy === $taxonomy){
	$name = get_queried_object()->name;
	$active = true;
}
if($taxonomy == "none"){
	if($filtered_month != ""){
		$name = str_replace("-"," ",$filtered_month);
		$active = true;
	}
}
?>
<div class="relative inline-block text-left dropdown">
	<span class="rounded-md"
	><button class="<?php if($active){ echo 'bg-orange-light '; } ?>inline-flex justify-center w-full px-4 py-2 text-base font-medium leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-orange-medium focus:bg-orange-light rounded-md focus:outline-none focus:border-orange-dark active:bg-orange-medium active:text-gray-800" 
	type="button" aria-haspopup="true" aria-expanded="true" aria-controls="headlessui-menu-items-117">
	<span><?php echo ucfirst($name); ?></span>
	<span style="line-height: 15px;position: relative;top: 3px; margin-left:4px;" class=""> &#9662;</span>
	</button
	></span>
	<div class="opacity-0 relative z-20 invisible dropdown-menu transition-all duration-300 transform origin-top-right -translate-y-2 scale-95">
		<div class="absolute right-0 w-56 mt-2 origin-top-right bg-white border border-gray-200 divide-y divide-gray-100 rounded-md shadow-lg outline-none" aria-labelledby="headlessui-menu-button-1" id="headlessui-menu-items-117" role="menu">
			<div class="py-1">
				<a href="<?php echo get_the_permalink($page_id); ?>" class="<?php if($active == false){ echo 'bg-orange-light '; } ?> text-gray-700 border-b border-gray-200 block px-4 py-2 text-sm font-medium" role="menuitem" tabindex="-1">
					Alles
				</a>

				<?php 
				if ($terms == ""){
					$current_month = date('01-m-Y');
					$months = array();
					$months_written = array();
					$formatter = new IntlDateFormatter('nl_NL', IntlDateFormatter::SHORT, IntlDateFormatter::SHORT);
					$formatter->setPattern('MMMM-yyyy');
					for ($i=0; $i < 8; $i++) { 
						$months[$i] = date("01-m-Y", strtotime(" +".$i." months"));
						setlocale(LC_TIME, "nl_NL");		
						$dateObj = DateTime::createFromFormat('d-m-Y', $months[$i]);
						$months_written[$i] = $formatter->format($dateObj);
					}
					foreach ($months_written as $index => $month_name) {
						 ?>
						<a href="<?php echo get_the_permalink($page_id)."?maand=".strtolower($month_name); ?>" class="<?php if($filtered_month == $month_name){ echo 'bg-orange-light '; } ?> text-gray-700 block px-4 py-2 text-sm font-medium" role="menuitem" tabindex="-1">
							<?php echo str_replace("-"," ",ucwords($month_name)); ?>
						</a>						
					<?php }
				}else{
					foreach( $terms as $term){ ?>
						<a href="<?php echo get_term_link($term); ?>" class="<?php if($name == $term->name){ echo 'bg-orange-light '; } ?> text-gray-700 block px-4 py-2 text-sm font-medium" role="menuitem" tabindex="-1">
							<?php echo $term->name; ?>
						</a>
					<?php 
					}
				} ?>
			</div>
		</div>
	</div>              
</div>