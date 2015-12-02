<?php
/** Notifications block **/

if(!class_exists('AQ_Alert_Block')) {
	class AQ_Alert_Block extends AQ_Block {

		//set and create block
		function __construct() {
			$block_options = array(
				'image' => 'alert.png',
				'name' => 'Alerts',
				'size' => 'span6',
				'tab' => 'Content',
				'imagedesc' => 'alerts.jpg',
				'desc' => 'This is an alert Block to show any warning, alert or confirmation message to the user'
			);

			//create the block
			parent::__construct('aq_alert_block', $block_options);
		}

		function form($instance) {

			$defaults = array(
				'content' => '',
				'type' => 'note',
				'style' => '',
				'entrance_animation' => ''
			);
			$instance = wp_parse_args($instance, $defaults);
			extract($instance);

			$type_options = array(
				'default' => 'Standard',
				'info' => 'Info',
				'note' => 'Notification',
				'warn' => 'Warning',
				'tips' => 'Tips'
			);

			?>
			<p class="description">
				<span class="leftHalf">
					<label for="<?php echo esc_attr( $this->get_field_id('title') ) ?>">
						<?php _e( 'Title', 'circleflip-builder' ) ?>
					</label>
				</span>
				<span class="rightHalf">
					<?php echo circleflip_field_input('title', $block_id, $title) ?>
				</span>
			</p>
			<div class="description">
				<div class="leftHalf">
					<label for="<?php echo esc_attr( $this->get_field_id('content') ) ?>">
						<?php _e( 'Content', 'circleflip-builder' ) ?>
					</label>
				</div>
				<div class="rightHalf">
					<?php echo wp_editor($content,$block_id, array('textarea_name'=>'aq_blocks['.$block_id.'][content]','quicktags'=>false,'editor_class'=>'iframeclass')); ?>
				</div>

			</div>
			<p class="description half">
				<span class="leftHalf">
					<label for="<?php echo esc_attr( $this->get_field_id('type') ) ?>">
						<?php _e( 'Type', 'circleflip-builder' ) ?>
					</label>
				</span>
				<span class="rightHalf">
					<span class="rightHalf select">
						<?php echo circleflip_field_select('type', $block_id, $type_options, $type) ?>
					</span>
				</span>
			</p>
			<p class="description half">
				<span class="leftHalf">
					<label for="<?php echo esc_attr( $this->get_field_id('entrance_animation') ) ?>">
						<?php _e( 'Animation', 'circleflip-builder' ) ?>
					</label>
					<span class="description_text">
						<?php _e( 'Choose the animation that you like', 'circleflip-builder' ) ?>
					</span>
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
				if($title=='')
				{
					echo '<div class="aq_alert '.esc_attr($type).' cf animateCr '.esc_attr($entrance_animation).'"><button type="button" class="close" data-dismiss="alert">&times;</button>' . do_shortcode(htmlspecialchars_decode($content)) . '</div>';
				}
				else
				{
					echo '<div class="aq_alert '.esc_attr($type).' cf animateCr '.esc_attr($entrance_animation).'"><button type="button" class="close" data-dismiss="alert">&times;</button><h5>'.$title.'</h5>' . do_shortcode(htmlspecialchars_decode($content)) . '</div>';
				}
		}

	}
}