<?php
/** A simple text block **/
class CR_Advertisement_Block extends AQ_Block {

	//set and create block
	function __construct() {
		$block_options = array(
			'image'=> 'cradimage.png',
			'name' => 'Advertisement',
			'size' => 'span6',
                        'tab' => 'Content',
                        'imagedesc' => 'ad.jpg',
                        'desc' => 'Adds a clickable Image Ad.'
		);

		//create the block
		parent::__construct('cr_advertisement_block', $block_options);
	}

	function form($instance) {

		$defaults = array(
			'link' => '#',
			'sponsors_image' => '',
			'entrance_animation' => '',
			'Adsense_code' => '',
			'ad_type' => 'image'
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);

		?>
		<p class="description" data-show="all">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('ad_type') ) ?>">
					<?php _e('Ad Type', 'circleflip-builder') ?>
				</label>
			</span>
			<span class="rightHalf">
				<span class="rightHalf select blockSelector">
					<?php echo circleflip_field_select( 'ad_type', $block_id, array( 'image' => 'Image', 'adsense' => 'Google Adsense' ), $ad_type, array('data-fd-handle="ad_type"') ) ?>
				</span>
			</span>
		</p>
		<p class="description" data-fd-rules='["ad_type:!equal:adsense"]'>
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('link') ) ?>">
					Link
				</label>
				<span class="description_text">
					Enter the URL target of the ad
				</span>
			</span>
			<span class="rightHalf">
				<?php echo circleflip_field_input('link', $block_id, $link, $size = 'full') ?>
			</span>
		</p>

		<p class="description"  data-fd-rules='["ad_type:!equal:adsense"]'>
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('sponsors_image') ) ?>">
					Image
				</label>
			</span>
			<span class="rightHalf">
				<?php
				$image_id = isset($sponsors_imageid) ? $sponsors_imageid : '';
				$image_value = isset($sponsors_image) ? $sponsors_image : '';echo circleflip_field_upload_new('sponsors_image', $block_id, $image_value,$image_id) ?>
			</span>
		</p>
		<p class="description"  data-fd-rules='["ad_type:equal:adsense"]'>
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('Adsense_code') ) ?>">
					Adsense Code
				</label>
			</span>
			<span class="rightHalf">
				<?php echo circleflip_field_textarea('Adsense_code', $block_id, $Adsense_code) ?>
			</span>
		</p>
		<p class="description half">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('entrance_animation') ) ?>">
					On-Scroll Animation
				</label>
			</span>
			<span class="rightHalf">
				<span class="rightHalf select">
					<?php
					$animation_options = array(
						'default' => 'Default',
						'noanimation' => 'no animation',
						'cr_left' => 'Fade To Left',
						'cr_right' => 'Fade To Right',
						'cr_top' => 'Fade To Up',
						'cr_bottom' => 'Fade To Down',
						'cr_popup' => 'Popout',
						'cr_fade' => 'Fade in',
					);
					echo circleflip_field_select('entrance_animation', $block_id, $animation_options, $entrance_animation); ?>
				</span>
				<span class="entrance_animation_sim"></span>
			</span>
		</p>
		<?php
	}

	function block($instance) {
		extract($instance);
		if($entrance_animation == 'default') {
			$entrance_animation = cr_get_option('block_animations');
		}
		?>
		<div class="animateCr <?php echo esc_attr($entrance_animation) ?>">
			<?php
				if($ad_type == 'image') {
			if(isset($link) && !empty($link)) { ?>
				<a href="<?php echo esc_url($link); ?>">
			<?php } ?>
				<?php if(isset($sponsors_imageid) && !empty($sponsors_imageid)) {
					echo wp_get_attachment_image($sponsors_imageid, 'full', false, array(
							'class' => 'attachment-full sponsImage'
						) );
				} ?>
			<?php if(isset($link) && !empty($link)) { ?>
				</a>
			<?php }
				}
			else {
				echo $Adsense_code;
			}
			?>
		</div>
		<?php
	}

}