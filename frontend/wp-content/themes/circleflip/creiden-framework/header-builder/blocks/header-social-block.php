<?php
/** Notifications block **/

if(!class_exists('header_social')) {
	class header_social extends header_builder {

		//set and create block
		function __construct() {
			$block_options = array(
				'image' => 'social.png',
				'class' => 'hbSprite-socialIcons icon-facebook-circled',
				'name' => 'Social icons',
				'imagedesc' => '',
				'desc' => 'This is an alert Block to show any warning, alert or confirmation message to the user'
			);
			//create the block
			parent::__construct('header_social', $block_options);
		}

		function form($instance,$header_name) {
			$defaults = array(
				'align' => '',
				'icon_selector' => '',
				'link_text' => array (0=>'#'),
				'link_name' => ''				
			);
			$instance = wp_parse_args($instance, $defaults);
			extract($instance);
			?>
				<div class="modalRow row clearfix">
					<div class="col-sm-7">
						<p class="settingName">
							Align element
						</p>
						<span class="settingNote">Note: Center alignment won't allow you to add another element in this header row.</span>
					</div>
					<?php echo creiden_hb_select($header_name,$id_base,$order,array('Left','Center','Right'),'align',$align); ?>
				</div>
				<?php 
					if(isset($link_name) && !empty($link_name)) {
						foreach ($link_name as $key => $value) { ?>
					<div class="modalRow row clearfix socialWrapper">
						<?php echo creiden_hb_iconselector_input($header_name,$id_base, $order, 'link_text',$link_text[$key],$key); ?>
						<div class="col-sm-6">
							<?php echo creiden_hb_icon_selector($header_name,$order,$value, 'link_name',$key) ?>
						</div>
					</div>
						<?php }	
					} else { 
						?>
					<div class="modalRow row clearfix socialWrapper">
						<?php echo creiden_hb_iconselector_input($header_name,$id_base, $order, 'link_text',$link_text[0],0); ?>
						<div class="col-sm-6">
							<?php echo creiden_hb_icon_selector($header_name,$order,$link_name, 'link_name',0) ?>
						</div>
					</div>		
						<?php
					}
					 ?>
				<button type="button" class="btn btn-default addSocial">
					Add Social Icon
				</button>
			<?php
		}

		function block($instance) {
			extract($instance);
			switch ($align) {
				case 0:
					$align_class = 'headerLeft';
					break;
				case 1:
					$align_class = 'headerCenter';
					break;
				case 2:
					$align_class = 'headerRight';
					break;
				default:
					$align_class = 'headerLeft';
					break;
			}
			?>
			<!-- Header Social -->
			<div class="headerSocial <?php echo esc_attr($align_class) ?>">
				<ul>
					<?php foreach ($link_name as $key => $value) { ?>
					<li class="headerFlip">
						<a href="<?php echo esc_url($link_text[$key]) ?>" target="_blank">
							<div class="back">
								<i class="<?php echo esc_attr($value) ?>"></i>
							</div>
							<div class="front">
								<i class="<?php echo esc_attr($value) ?>"></i>
							</div>
						</a>
					</li>
					<?php } ?>
				</ul>
			</div>
			<!-- Header Social End -->
		<?php
		}

	}
}