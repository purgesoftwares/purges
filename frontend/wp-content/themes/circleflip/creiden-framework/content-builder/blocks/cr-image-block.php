<?php
/** A simple text block **/
class CR_Image_Block extends AQ_Block {

	//set and create block
	function __construct() {
		$block_options = array(
			'image' => 'image.png',
			'name' => 'Image',
			'size' => 'span6',
                        'imagedesc' => 'image.jpg',
                        'tab' => 'media',
                        'desc' => 'Used to add the image of your choice.'
		);

		//create the block
		parent::__construct('cr_image_block', $block_options);
	}

	function form($instance) {

		$defaults = array(
			'text' => '',
			'image_hover_style' => '',
			'pretty' => '',
			'link_target' => '',
			'entrance_animation' => '',
			'image_shape' => 'square'
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		?>
		<p class="description half">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('image_shape') ) ?>">
					<?php _e('Image Shape', 'circleflip-builder') ?>
				</label>
				<span class="description_text">
					Choose shape of image
				</span>
			</span>
			<span class="rightHalf">
				<span class="rightHalf select">
					<?php
					$shape_options = array(
						'square' => 'Square',
						'circle' => 'Circle',
					);
					echo circleflip_field_select('image_shape', $block_id, $shape_options, $image_shape, array('data-fd-handle="image_shape"')); ?>
				</span>
			</span>
		</p>
		<p class="description">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('image_upload') ) ?>">
					Image
				</label>
			</span>
			<span class="rightHalf">
				<?php 
				$image_id = isset($image_uploadid) ? $image_uploadid : '';
				$image_value = isset($image_upload) ? $image_upload : '';echo circleflip_field_upload_new('image_upload', $block_id, $image_value,$image_id) ?>
			</span>
		</p>
		<p class="description" data-fd-rules='["hover:equal:default", "image_shape:equal:square"]'>
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('image_hover_upload') ) ?>">
					Image Hover
				</label>
			</span>
			<span class="rightHalf">
				<?php 
				$image_hover_id = isset($image_hover_uploadid) ? $image_hover_uploadid : '';
				$image_hover_value = isset($image_hover_upload) ? $image_hover_upload : '';echo circleflip_field_upload_new('image_hover_upload', $block_id, $image_hover_value,$image_hover_id) ?>
			</span>
		</p>
		<p class="description half" data-fd-rules='["image_shape:equal:square"]'>
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('image_hover_animation') ) ?>">
					<?php _e('Hover', 'circleflip-builder') ?>
				</label>
				<span class="description_text">
					Choose hover effect for image
				</span>
			</span>
			<span class="rightHalf">
				<span class="rightHalf select">
					<?php
					$animation_options = array(
						'default' => 'No Hover',
						'hover1' => 'Hover style 1',
						'hover2' => 'Hover style 2',
					);
					echo circleflip_field_select('image_hover_style', $block_id, $animation_options, $image_hover_style, array('data-fd-handle="hover"')); ?>
				</span>
			</span>
		</p>
		<!-- only visible when post_shape is circle -->
		<p class="description circlePostsShow" data-fd-rules='["image_shape:equal:circle"]'>
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('animation_number') ) ?>">
					<?php _e('Hover style', 'circleflip-builder') ?>
				</label>
			</span>
			<span class="rightHalf">
				<span class="rightHalf select">
					<?php echo circleflip_field_select('animation_number', $block_id, array('animation 1','animation 2','animation 3','animation 4'), isset($animation_number) ? $animation_number : 'animation 1') ?>
				</span>
			</span>
		</p>
		<p class="description" data-fd-rules='["hover:regex:hover(\\d)"]'>
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('pretty') ) ?>">
					Prettyphoto
				</label>
				<span class="description_text">
					Check to open image in prettyphoto
				</span>
			</span>
			<span class="rightHalf">
				<?php echo circleflip_field_checkbox('pretty', $block_id, $pretty) ?>
			</span>
		</p>
		<p class="description" data-fd-rules='["image_shape:equal:square"]'>
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('link_target') ) ?>">
					Link
				</label>
				<span class="description_text">
					Add target link or leave it blank. 
				</span>
			</span>
			<span class="rightHalf">
				<?php echo circleflip_field_input('link_target', $block_id, $link_target, $size = 'full') ?>
			</span>
		</p>
		<p class="description" data-fd-rules='["image_shape:equal:circle"]'>
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('link_target_circle') ) ?>">
					Link
				</label>
				<span class="description_text">
					Add target link or leave it blank. 
				</span>
			</span>
			<span class="rightHalf">
				<?php echo circleflip_field_input('link_target_circle', $block_id, $link_target_circle, $size = 'full') ?>
			</span>
		</p>
		<p class="description" data-fd-rules='["image_shape:equal:circle"]'>
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('title_circle') ) ?>">
					Title
				</label>
				<span class="description_text">
					Write title to appear on hover 
				</span>
			</span>
			<span class="rightHalf">
				<?php echo circleflip_field_input('title_circle', $block_id, $title_circle, $size = 'full') ?>
			</span>
		</p>
		<p class="description">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('imageMarginBottom') ) ?>">
					Image Margin Bottom
				</label>
				<span class="description_text">
				</span>
			</span>
			<span class="rightHalf">
					<?php echo circleflip_field_input('imageMarginBottom', $block_id, isset($imageMarginBottom) ? $imageMarginBottom : '20', 'min', 'number') ?> px
			</span>
		</p>
		<p class="description half">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('entrance_animation') ) ?>">
					<?php _e('Animation', 'circleflip-builder') ?>
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
		$defaults = array(
			'image_shape' => 'square'
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		if($entrance_animation == 'default') {
			$entrance_animation = cr_get_option('block_animations');
		}
		if($image_shape == 'square' || !isset($image_shape)){
			$image_cut = wp_get_attachment_image_src($image_uploadid,'full');
			if($image_hover_style=='default'){
				$img_hover_class = !empty($image_hover_uploadid) ? 'hover_exist' : '';
				?>
				<div class="single_image_block double_image animateCr <?php echo esc_attr($img_hover_class.' '.$entrance_animation); ?>" 
					 style="margin-bottom:<?php echo esc_attr($imageMarginBottom); ?>px;">
					<div class="single_image_first">
						<?php if(circleflip_valid($link_target)) { ?>
							<a href="<?php echo esc_url($link_target); ?>">
						<?php }
								echo wp_get_attachment_image( $image_uploadid, 'full', false, array(
									'class'	 => "attachment-full",
								) );
							if(circleflip_valid($link_target)) {
						?>
							</a>
						<?php } ?>
					</div>
					<?php if(!empty($image_hover_uploadid)){ ?>
					<div class="single_image_second">
						<?php if(circleflip_valid($link_target)) { ?>
							<a href="<?php echo esc_url($link_target); ?>">
						<?php }
								echo wp_get_attachment_image( $image_hover_uploadid, 'full', false, array(
									'class'	 => "attachment-full",
								) );
							if(circleflip_valid($link_target)) {
						?>
						</a>
						<?php } ?>
					</div>
					<?php } ?>
				</div>
				<?php
			}elseif ($image_hover_style=='hover1') {
				$this->square_white_enqueue();
				?>
				<div class="squarePost single_image_block" style="margin-bottom:<?php echo esc_attr($imageMarginBottom); ?>px;">
					<div class="squarePostImg">
						<?php echo wp_get_attachment_image( $image_uploadid, 'full', false, array(
								'class'	 => "attachment-full animateCr $entrance_animation",
							) );
						?>
						<div class="squarePostCont">
							<div class="squareAlignMid">
								<div class="squareAlignMid2">
									<div class="linkZoomCont">
										<?php if($pretty==1) { ?>
											<a href="<?php echo esc_url($image_cut[0]); ?>" class="zoomRecent <?php if(!circleflip_valid($link_target)):echo "centerIcon";endif; ?>" rel="prettyPhoto"></a>
										<?php }?>
										<?php if(circleflip_valid($link_target)) { ?>
											<a href="<?php echo esc_url($link_target); ?>" class="linkRecent <?php if($pretty==0):echo "centerIcon";endif; ?>"></a>
										<?php }?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php
			}
			elseif ($image_hover_style=='hover2') {
				$this->square_white_enqueue();
				?>
				<div class="portfolioHome single_image_block" style="margin-bottom:<?php echo esc_attr($imageMarginBottom); ?>px;">
					<div class="portfolioHomeImg animateCr <?php echo esc_attr($entrance_animation); ?>">
						<?php echo wp_get_attachment_image( $image_uploadid, 'full' );
						?>
						<div class="portfolioHomeCont">
							<div class="portfolioHomeCont2">
								<div class="portfolioHomeCont2Inner">
									<div class="ZoomContStyle3">
										<?php if($pretty==1) { ?>
											<a href="<?php echo esc_url($image_cut[0]); ?>" class="zoomStyle3 <?php if(!circleflip_valid($link_target)):echo "centerIcon";endif; ?>" rel="prettyPhoto"></a>
										<?php } ?>
										<?php if(circleflip_valid($link_target)) { ?>
											<a href="<?php echo esc_url($link_target); ?>" class="linkStyle3 <?php if($pretty==0):echo "centerIcon";endif; ?>"></a>
										<?php }?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php
			}
		}
		elseif($image_shape == 'circle'){
			$this->circle_posts_enqueue();
			switch ($animation_number) {
				case '0':
					$animation = 'animation1';
					break;
				case '1':
					$animation = 'animation2';
					break;
				case '2':
					$animation = 'animation3';
					break;
				case '3':
					$animation = 'animation4';
					break;
				default:
					$animation = 'animation1';
					break;
			}
			$image_attributes = wp_get_attachment_image_src($image_uploadid,'circle-posts');
			?>
			<div class="circlePost animate_CF image_block" style="margin-bottom:<?php echo esc_attr($imageMarginBottom); ?>px;">
				<div class="circleAnimation <?php echo esc_attr($animation); ?>" style="height: 370px;">
					<div class="circleAnimationImage" data-image="<?php echo esc_url($image_attributes[0]); ?>" style="height: 370px; background-image: url('<?php echo esc_url($image_attributes[0]); ?>');"></div>
					<div class="circleAnimation <?php echo esc_attr($animation); ?>">
						<div class="circleAnimationArea animationContainer" style="height: 330px; width: 330px;">
							<div class="circleAnimationSingle animationWrap">
								<div class="circleAnimationImage front" style="height: 230px; background-image: url('<?php echo esc_url($image_attributes[0]); ?>');"></div>
								<div class="circleAnimationDetails back circlePostDetails">
									<div class="circleDetailsWrapper">
										<?php if(circleflip_valid($link_target_circle)){ ?>
										<a href="<?php echo esc_url($link_target_circle); ?>" class="zoomRecent zoomCircle icon-link <?php echo circleflip_valid($title_circle) ? '': 'noTitle'; ?>"></a>
										<?php } ?>
										<?php if(circleflip_valid($title_circle)){ ?>
										<h4 class="<?php echo circleflip_valid($link_target_circle) ? '': 'noZoom'; ?>"><a href="<?php echo esc_url($link_target_circle); ?>"><?php echo esc_html($title_circle); ?></a></h4>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php }
	}
	function square_white_enqueue() {
		wp_register_style('squareposts',get_template_directory_uri().'/css/content-builder/squareposts.css');
		wp_enqueue_style('squareposts');
		wp_register_script('pretty',get_template_directory_uri() . '/js/prettyPhoto.js',array('jquery'),'2.0.3',true);
		wp_enqueue_script('pretty');
		wp_register_script('recentJS',get_template_directory_uri() . '/scripts/modules/recent.js',array('jquery'),'2.0.3',true);
		wp_enqueue_script('recentJS');
		wp_register_style('prettyStyle', get_template_directory_uri() . '/css/prettyphoto/style/prettyPhoto.css');
		wp_enqueue_style('prettyStyle');
	}
	function square_red_enqueue() {
		wp_register_style( 'portfolioStyle', get_template_directory_uri() . '/css/parts/portfolio.css' );
		wp_enqueue_style(  'portfolioStyle' );
		wp_register_script('recentJS',get_template_directory_uri() . '/scripts/modules/recent.js',array('jquery'),'2.0.3',true);
		wp_enqueue_script('recentJS');
		wp_register_script('pretty',get_template_directory_uri() . '/js/prettyPhoto.js',array('jquery'),'2.0.3',true);
		wp_enqueue_script('pretty');
		wp_register_style('prettyStyle', get_template_directory_uri() . '/css/prettyphoto/style/prettyPhoto.css');
		wp_enqueue_style('prettyStyle');
	}
	function circle_posts_enqueue() {
		wp_register_style('circleposts',get_template_directory_uri().'/css/content-builder/circleposts.css');
		wp_enqueue_style('circleposts');
		wp_register_script('recentJS',get_template_directory_uri() . '/scripts/modules/recent.js',array('jquery'),'2.0.3',true);
		wp_enqueue_script('recentJS');
		wp_register_script('pretty',get_template_directory_uri() . '/js/prettyPhoto.js',array('jquery'),'2.0.3',true);
		wp_enqueue_script('pretty');
		wp_register_style('prettyStyle', get_template_directory_uri() . '/css/prettyphoto/style/prettyPhoto.css');
		wp_enqueue_style('prettyStyle');
	}

}