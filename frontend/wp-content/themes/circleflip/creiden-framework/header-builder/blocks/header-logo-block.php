<?php
/** Notifications block **/

if(!class_exists('header_logo')) {
	class header_logo extends header_builder {

		//set and create block
		function __construct() {
			$block_options = array(
				'image' => 'logo.png',
				'class' => 'hbSprite-logo icon-leaf',
				'name' => 'Logo',
				'imagedesc' => '',
				'desc' => 'This is an alert Block to show any warning, alert or confirmation message to the user'
			);
			//create the block
			parent::__construct('header_logo', $block_options);
		}

		function form($instance,$header_name) {
			$defaults = array(
				'align' => '',
				'logo_builder' => 1,
				'logo_image' => '',
				'logo_width' => '',
				'logo_height' => '',
				'logo_margin_top' => '',
				'logo_margin_bottom' => ''
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
				<div class="modalRow row clearfix checkBoxSwitcherField inverse">
					<div class="col-sm-7">
						<label for="useLogoBuilder">
							<p class="settingName">
								Use logo builder
							</p>
						</label>
					</div>
					<?php echo creiden_hb_checkbox($header_name,$id_base, $order, 'logo_builder',$logo_builder); ?>
				</div>
				<div class="checkBoxSwitcher">
					<div class="modalRow row clearfix">
						<div class="col-sm-7">
							<p class="settingName">
								Upload logo
							</p>
						</div>
						<?php 
						$image_id = isset($image_uploadid) ? $image_uploadid : '';
						echo creiden_hb_upload($header_name,$id_base, $order, 'logo_image',$logo_image,$image_id); ?>
					</div>
					<div class="modalRow row clearfix logoWidth">
						<div class="col-sm-7">
							<p class="settingName">
								Width
							</p>
							<span class="settingNote">Example : 150px</span>
						</div>
						<?php echo creiden_hb_input($header_name,$id_base, $order, 'logo_width',$logo_width); ?>
					</div>
					<div class="modalRow row clearfix logoHeight">
						<div class="col-sm-7">
							<p class="settingName">
								Height
							</p>
							<span class="settingNote">Example : 150px</span>
						</div>
						<?php echo creiden_hb_input($header_name,$id_base, $order, 'logo_height',$logo_height); ?>
					</div>
					<div class="modalRow row clearfix">
						<div class="col-sm-7">
							<p class="settingName">
								Margin Top
							</p>
							<span class="settingNote">Example : 10px</span>
						</div>
						<?php echo creiden_hb_input($header_name,$id_base, $order, 'logo_margin_top',$logo_margin_top); ?>
					</div>
					<div class="modalRow row clearfix">
						<div class="col-sm-7">
							<p class="settingName">
								Margin Bottom
							</p>
							<span class="settingNote">Example : 10px</span>
						</div>
						<?php echo creiden_hb_input($header_name,$id_base, $order, 'logo_margin_bottom',$logo_margin_bottom); ?>
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
			if($logo_builder) { ?>
			<!-- Logo -->
			<div class="logoWrapper headerLeft" style="width: <?php echo esc_attr(cr_get_option('logo_wrapper_width')); ?>px;height: <?php echo esc_attr(cr_get_option('header_height')); ?>px;">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php if(( defined( 'ICL_LANGUAGE_CODE' ) && 'ar' === ICL_LANGUAGE_CODE) ) { ?>
						<img src="<?php echo esc_url( cr_get_option( 'rtl_theme_logo' ) ); ?>" alt="<?php bloginfo( 'name' ); ?>" width="<?php echo esc_attr( cr_get_option( 'logo_width' ) ); ?>" height="<?php echo esc_attr( cr_get_option( 'logo_height' ) ); ?>" style="left:<?php echo esc_attr( cr_get_option( 'logo_left' ) ); ?>px;top: <?php echo esc_attr( cr_get_option( 'logo_top' ) ); ?>px;"/>
					<?php } else {?>
						<img src="<?php echo esc_url( cr_get_option( 'theme_logo' ) ); ?>" alt="<?php bloginfo( 'name' ); ?>" width="<?php echo esc_attr( cr_get_option( 'logo_width' ) ); ?>" height="<?php echo esc_attr( cr_get_option( 'logo_height' ) ); ?>" style="left:<?php echo esc_attr( cr_get_option( 'logo_left' ) ); ?>px;top: <?php echo esc_attr( cr_get_option( 'logo_top' ) ); ?>px;"/>
					<?php } ?>
				</a>
			</div>
			<!-- Logo End -->
			<?php
			} else {
				?>
				<div class="logoWrapper <?php echo esc_attr($align_class) ?>" style="width: <?php echo esc_attr($logo_width); ?>;height: <?php echo esc_attr($logo_height);?>;margin-top: <?php echo esc_attr($logo_margin_top);?>;margin-bottom: <?php echo esc_attr($logo_margin_bottom)?>">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<img src="<?php echo esc_url($logo_image); ?>" alt="<?php bloginfo( 'name' ); ?>" style="width: <?php echo esc_attr($logo_width); ?>;height: <?php echo esc_attr($logo_height);?>"/>
				</a>
				</div>
				<?php
			}
		}

	}
}