<?php
/** Menu block **/

if(!class_exists('header_ad')) {
	class header_ad extends header_builder {

		//set and create block
		function __construct() {
			$block_options = array(
				'image' => 'ad.png',
				'class' => 'hbSprite-ad icon-megaphone',
				'name' => 'AD',
				'imagedesc' => '',
				'desc' => 'This is an alert Block to show any warning, alert or confirmation message to the user'
			);
			//create the block
			parent::__construct('header_ad', $block_options);
		}

		function form($instance,$header_name) {
			$defaults = array(
				'align' => '',
				'adsense_code' => '',
				'uploaded_image' => 0,
				'ad_image' => '',
				'ad_width' => '',
				'ad_height' => '',
				'ad_link' => '#',
                'ad_link_target' => '_blank',
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
			<div class="modalRow row clearfix checkBoxSwitcherField">
				<div class="col-sm-7">
					<label for="useLogoBuilder">
						<p class="settingName">
							Use Uploaded Image
						</p>
					</label>
				</div>
				<?php echo creiden_hb_checkbox($header_name,$id_base, $order, 'uploaded_image',$uploaded_image); ?>
			</div>
			<div class="modalRow row clearfix checkBoxSwitcher inverse">
				<div class="col-sm-7">
					<label for="useLogoBuilder">
						<p class="settingName">
							Adsense code
						</p>
					</label>
				</div>
				<?php echo creiden_hb_input($header_name,$id_base, $order, 'adsense_code',$adsense_code); ?>
			</div>
			<div class="checkBoxSwitcher">
				<div class="modalRow row clearfix">
					<div class="col-sm-7">
						<p class="settingName">
							Upload image
						</p>
					</div>
					<?php 
					$image_id = isset($image_uploadid) ? $image_uploadid : '';
					echo creiden_hb_upload($header_name,$id_base, $order, 'ad_image',$ad_image,$image_id); ?>
				</div>
				<div class="modalRow row clearfix">
					<div class="col-sm-7">
						<p class="settingName">
							Ad Link
						</p>
					</div>
					<?php echo creiden_hb_input($header_name,$id_base, $order, 'ad_link',$ad_link); ?>
				</div>
                <div class="modalRow row clearfix">
					<div class="col-sm-7">
						<p class="settingName">
							Open Ad in a new tab?
						</p>
					</div>
					<?php echo creiden_hb_checkbox($header_name,$id_base, $order, 'ad_link_target',$ad_link_target); ?>
				</div>
				<div class="modalRow row clearfix logoWidth">
					<div class="col-sm-7">
						<p class="settingName">
							Width
						</p>
					</div>
					<?php echo creiden_hb_input($header_name,$id_base, $order, 'ad_width',$ad_width); ?>
				</div>
				<div class="modalRow row clearfix logoHeight">
					<div class="col-sm-7">
						<p class="settingName">
							Height
						</p>
					</div>
					<?php echo creiden_hb_input($header_name,$id_base, $order, 'ad_height',$ad_height); ?>
				</div>
			</div>
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
			if($uploaded_image) {
				?>
				<div class="headerImage <?php echo esc_attr($align_class) ?>" style="width: <?php echo esc_attr($ad_width) ?>;height: <?php echo esc_attr($ad_height) ?>;">
					<a href="<?php echo esc_url($ad_link) ?>" target="<?php echo $ad_link_target ? '_blank' : ''  ?>">
						<img src="<?php echo esc_url($ad_image)?>" alt="" />
					</a>
				</div>
				<?php
			} else {
				echo $adsense_code;
			}
		}

	}
}