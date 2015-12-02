<?php
/** A simple text block **/
class CR_Team_Block extends AQ_Block {

	//set and create block
	function __construct() {
		$block_options = array(
			'image' => 'teammember.png',
			'name' => 'Team Member',
			'size' => 'span6',
                        'imagedesc' => 'team-member.jpg',
                        'tab' => 'Content',
                        'desc' => 'Displays your team memebers in a uniform way.'
		);
		//create the block
		parent::__construct('cr_team_block', $block_options);
	}
	function form($instance) {

		$defaults = array(
			'text' => '',
			'shortcut' =>'',
			'dribble' => '',
			'twitter' => '',
			'youtube' => '',
			'ln' => '',
			'fb' => '',
			'author' => '',
			'entrance_animation' => '',
			'email' => '',
			'bg_member_image' => ''
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		?>
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
		<p class="description">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('member_image') ) ?>">
					Member Photo
				</label>
			</span>
			<span class="rightHalf">
				<?php 
				$image_id = isset($member_imageid) ? $member_imageid : '';
				$image_value = isset($member_image) ? $member_image : '';echo circleflip_field_upload_new('member_image', $block_id, $image_value,$image_id) ?>
			</span>
		</p>
		<p class="description">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('bg_member_image') ) ?>">
					Background image Photo
				</label>
			</span>
			<span class="rightHalf">
				<?php 
				$bg_image_id = isset($bg_member_imageid) ? $bg_member_imageid : '';
				$bg_image_value = isset($bg_member_image) ? $bg_member_image : '';echo circleflip_field_upload_new('bg_member_image', $block_id, $bg_image_value,$bg_image_id) ?>
			</span>
		</p>
		<p class="description">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('author') ) ?>">
					Member Name
				</label>
			</span>
			<span class="rightHalf">
				<?php echo circleflip_field_input('author', $block_id, $author, $size = 'full') ?>
			</span>
		</p>
		<p class="description">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('shortcut') ) ?>">
					Job Title
				</label>
			</span>
			<span class="rightHalf">
				<?php echo circleflip_field_input('shortcut', $block_id, $shortcut, $size = 'full') ?>
			</span>
		</p>
		<div class="description">
			<div class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('text') ) ?>">
					Biography
				</label>
			</div>
			<div class="rightHalf">
				<?php //echo aq_field_textarea('text', $block_id, $text, $size = 'full') ?>
				<?php echo wp_editor($text, $block_id, array('textarea_name'=>'aq_blocks['.$block_id.'][text]','quicktags'=>false)); ?>
			</div>
		</div>
		<p class="description">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('email') ) ?>">
					Email
				</label>
			</span>
			<span class="rightHalf">
				<?php echo circleflip_field_input('email', $block_id, $email, $size = 'full') ?>
			</span>
		</p>
		<p class="description">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('fb') ) ?>">
					Facebook Link
				</label>
			</span>
			<span class="rightHalf">
				<?php echo circleflip_field_input('fb', $block_id, $fb, $size = 'full') ?>
			</span>
		</p>
		<p class="description">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('twitter') ) ?>">
					Twitter Link
				</label>
			</span>
			<span class="rightHalf">
				<?php echo circleflip_field_input('twitter', $block_id, $twitter, $size = 'full') ?>
			</span>
		</p>
		<p class="description">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('ln') ) ?>">
					LinkedIn Link
				</label>
			</span>
			<span class="rightHalf">
				<?php echo circleflip_field_input('ln', $block_id, $ln, $size = 'full') ?>
			</span>
		</p>
		<p class="description">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('shape') ) ?>">
					Layout
				</label>
			</span>
			<span class="rightHalf">
				<span class="rightHalf select">
					<?php echo circleflip_field_select('shape', $block_id, array('Layout 1', 'Layout 2'), isset($shape) ? $shape : 'Layout 1', array('data-fd-handle="team_style"')) ?>
				</span>
			</span>
		</p>
		<p class="" data-fd-rules='["team_style:equal:0"]'>
			<img style="display: block;margin:0 auto;max-height: 250px;" src="<?php echo esc_url(get_template_directory_uri() . '/creiden-framework/content-builder/assets/images/team_layout1.jpg'); ?>" alt=""/>
		</p>
		<p class="" data-fd-rules='["team_style:equal:1"]'>
			<img style="display: block;margin:0 auto;max-width: 100%;" src="<?php echo esc_url(get_template_directory_uri() . '/creiden-framework/content-builder/assets/images/team_layout2.jpg'); ?>" alt=""/>
		</p>
		<p class="description">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('animation_number') ) ?>">
					Hover Animation
				</label>
			</span>
			<span class="rightHalf">
				<span class="rightHalf select">
					<?php echo circleflip_field_select('animation_number', $block_id, array('animation 1','animation 2','animation 3','animation 4'), isset($animation_number) ? $animation_number : 'animation 1') ?>
				</span>
			</span>
		</p>
		<?php
	}

	function block($instance) {
		$defaults = array(
			'bg_member_image' => ''
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		$this->enqueue_view_teamMember_script();
		$class ='';
		switch ($shape) {
			case '0':
					$class = 'part';
					 break;
			case '1':
					 $class = 'full';
					 break;
			default:
					$class .= 'part';
					break;
			}
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
		?>
		<div class="<?php echo esc_attr($class) ?> <?php echo esc_attr($entrance_animation) ?> animateCr">
			<?php if(isset($member_image) && !empty($member_image)) { ?>
			<div class="span3 circlePost circleTeam">
				<div class="circleAnimation <?php echo isset($bg_member_image) && !empty($bg_member_image) ? 'circleImage' : '';?> <?php echo esc_attr($animation) ?>">
					<?php $image_cut = wp_get_attachment_image_src($member_imageid,'team_member'); ?>
					<div class="circleAnimationImage" style="background-image: url('<?php echo esc_url($image_cut[0]); ?>')"></div>
					<?php if(isset($bg_member_image) && !empty($bg_member_image)) { ?>
						<?php $image_cut2 = wp_get_attachment_image_src($bg_member_imageid,'team_member'); ?>
						<div class="circleBackImage" style="background-image: url(<?php echo esc_url($image_cut2[0]);  ?>)"></div>
					<?php } ?>
					<div class="circleAnimation <?php echo esc_attr($animation) ?>">
						<div class="circleAnimationArea animationContainer">
							<div class="circleAnimationSingle animationWrap">
								<div class="circleAnimationImage front" style="background-image: url('<?php echo esc_url($image_cut[0]); ?>')"></div>
									
										<div class="circleAnimationDetails back circlePostDetails" <?php if(isset($bg_member_image) && !empty($bg_member_image)) {?> style="background-image: url(<?php echo esc_url($image_cut2[0]);  ?>)" <?php } ?>>
									
									<div class="memberSocial socialIcons">
										<ul>
											<?php if(isset($fb) && !empty($fb)) {?>
											<li class="teamFacebook teamSocial">
												<a href="<?php echo esc_url($fb); ?>">
													<div class="iconback"><i class="icon-facebook-circled"></i></div>
													<div class="iconfront"><i class="icon-facebook-circled"></i></div>
												</a>
											</li>
											<?php } if(isset($twitter) && !empty($twitter)) {?>
											<li class="teamTwitter teamSocial">
											<a href="<?php echo esc_url($twitter); ?>">
												<div class="iconback"><i class="icon-twitter-circled"></i></div>
												<div class="iconfront"><i class="icon-twitter-circled"></i></div>
											</a>
											</li>
											<?php } if(isset($ln) && !empty($ln)) {?>
											<li class="teamLinkedIn teamSocial">
												<a href="<?php echo esc_url($ln); ?>">
													<div class="iconback"><i class="icon-linkedin-circled"></i></div>
													<div class="iconfront"><i class="icon-linkedin-circled"></i></div>
												</a>
											</li>
											<?php } ?>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php } if($class == 'full'){ ?>
				<div class="teamDetailsContainer">
				<div class="span<?php echo substr($size,4)-3; ?>  teamDetails">
			<?php } ?>
			<?php if(isset($author) && !empty($author)) { ?>
					<div class="teamName"><?php echo esc_html($author); ?></div>
			<?php } ?>
			<?php if(isset($shortcut) && !empty($shortcut)) { ?>
					<div class="teamShortcut"><?php echo esc_html($shortcut); ?></div>
				<?php } ?>
			<?php if(isset($text) && !empty($text)) { ?>
			<div class="memberBio">
				<p><?php echo do_shortcode(htmlspecialchars_decode($text)); ?></p>
			</div>
			<?php } ?>
			<?php if(isset($email) && !empty($email)) { ?>
				<div class="teamEmail"><a href="<?php echo esc_url( 'mailto:' . $email); ?>"><?php echo esc_html($email); ?></a></div>
			<?php } ?>

				<?php if($class == 'full'){ ?>
				</div>
				</div>
				<?php } ?>
			</div>
		<?php
	}
	function enqueue_view_teamMember_script(){
		$theme_version = _circleflip_version();
		wp_register_style('team_member-css',get_template_directory_uri() . "/css/content-builder/team_member.css",array(),$theme_version);
		wp_enqueue_style('team_member-css');
		wp_register_style('circleposts',get_template_directory_uri().'/css/content-builder/circleposts.css');
		wp_enqueue_style('circleposts');
		wp_register_script('recentJS',get_template_directory_uri() . '/scripts/modules/recent.js',array('jquery'),'2.0.3',true);
		wp_enqueue_script('recentJS');
	}

}