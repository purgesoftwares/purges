<?php
/** A simple text block **/
class CR_Buttons_Block extends AQ_Block {

	//set and create block
	function __construct() {
		$block_options = array(
			'image' => 'button.png',
			'name' => 'Button',
			'size' => 'span6',
                        'imagedesc' => 'button.jpg',
                        'tab' => 'Content',
                	'desc' => 'Buttons add a button with your selected style.'
		);

		//create the block
		parent::__construct('cr_buttons_block', $block_options);
		add_action('circleflip_aq-page-builder-admin-enqueue', array($this, 'admin_enqueue_buttonBlock'));
	}

	function form($instance) {

		$defaults = array(
			'text' => '',
			'link' => '',
			'target' => '',
            'font_size' => '',
			'color' => '',
			'type' => '',
			'color_button' => '#e32831',
			'color_button_text' => '',
			'entrance_animation' => ''
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		?>
		<p class="description">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('text') ) ?>">
					Text
				</label>
				<span class="description_text">
					Enter Text On Button
				</span>
			</span>
			<span class="rightHalf">
				<?php echo circleflip_field_input('text', $block_id, $text, $size = 'full') ?>
			</span>
		</p>
		<p class="description ButtonCheckIcon">
			<span class="leftHalf ">
				<label for="<?php echo esc_attr( $this->get_field_id('checkIcon') ) ?>">
					Choose with Icon or without Icon
				</label>
				<span class="description_text">
				</span>
			</span>
			<span class="rightHalf">
				<?php echo circleflip_field_checkbox('checkIcon', $block_id, (isset($checkIcon))? $checkIcon : 1, array('data-fd-handle="with_icons"')) ?>
			</span>
		</p>
		<div class="description ButtonIcon iconselector" data-fd-rules='["with_icons:checked"]'>
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('icon') ) ?>">
					icons
				</label>
				<span class="description_text">
					Choose Icon Button
				</span>
			</span>
			<span class="rightHalf icons">
				<?php $icon_option = array('icon-plus','icon-minus','icon-info','icon-left-thin','icon-up-thin','icon-right-thin','icon-down-thin','icon-level-up','icon-level-down','icon-switch','icon-infinity','icon-plus-squared','icon-minus-squared','icon-home','icon-keyboard','icon-erase','icon-pause','icon-fast-forward','icon-fast-backward','icon-to-end','icon-to-start','icon-hourglass','icon-stop','icon-up-dir','icon-play','icon-right-dir','icon-down-dir','icon-left-dir','icon-adjust','icon-cloud','icon-star','icon-star-empty','icon-cup','icon-menu','icon-moon','icon-heart-empty','icon-heart','icon-note','icon-note-beamed','icon-layout','icon-flag','icon-tools','icon-cog','icon-attention','icon-flash','icon-record','icon-cloud-thunder','icon-tape','icon-flight','icon-mail','icon-pencil','icon-feather','icon-check','icon-cancel','icon-cancel-circled','icon-cancel-squared','icon-help','icon-quote','icon-plus-circled','icon-minus-circled','icon-right','icon-direction','icon-forward','icon-ccw','icon-cw','icon-left','icon-up','icon-down','icon-list-add','icon-list','icon-left-bold','icon-right-bold','icon-up-bold','icon-down-bold','icon-user-add','icon-help-circled','icon-info-circled','icon-eye','icon-tag','icon-upload-cloud','icon-reply','icon-reply-all','icon-code','icon-export','icon-print','icon-retweet','icon-comment','icon-chat','icon-vcard','icon-address','icon-location','icon-map','icon-compass','icon-trash','icon-doc','icon-doc-text-inv','icon-docs','icon-doc-landscape','icon-archive','icon-rss','icon-share','icon-basket','icon-shareable','icon-login','icon-logout','icon-volume','icon-resize-full','icon-resize-small','icon-popup','icon-publish','icon-window','icon-arrow-combo','icon-chart-pie','icon-language','icon-air','icon-database','icon-drive','icon-bucket','icon-thermometer','icon-down-circled','icon-left-circled','icon-right-circled','icon-up-circled','icon-down-open','icon-left-open','icon-right-open','icon-up-open','icon-down-open-mini','icon-left-open-mini','icon-right-open-mini','icon-up-open-mini','icon-down-open-big','icon-left-open-big','icon-right-open-big','icon-up-open-big','icon-progress-0','icon-progress-1','icon-progress-2','icon-progress-3','icon-back-in-time','icon-network','icon-inbox','icon-install','icon-lifebuoy','icon-mouse','icon-dot','icon-dot-2','icon-dot-3','icon-suitcase','icon-flow-cascade','icon-flow-branch','icon-flow-tree','icon-flow-line','icon-flow-parallel','icon-brush','icon-paper-plane','icon-magnet','icon-gauge','icon-traffic-cone','icon-cc','icon-cc-by','icon-cc-nc','icon-cc-nc-eu','icon-cc-nc-jp','icon-cc-sa','icon-cc-nd','icon-cc-pd','icon-cc-zero','icon-cc-share','icon-cc-remix','icon-github','icon-github-circled','icon-flickr','icon-flickr-circled','icon-vimeo','icon-vimeo-circled','icon-twitter','icon-twitter-circled','icon-facebook','icon-facebook-circled','icon-facebook-squared','icon-gplus','icon-gplus-circled','icon-pinterest','icon-pinterest-circled','icon-tumblr','icon-tumblr-circled','icon-linkedin','icon-linkedin-circled','icon-dribbble','icon-dribbble-circled','icon-stumbleupon','icon-stumbleupon-circled','icon-lastfm','icon-lastfm-circled','icon-rdio','icon-rdio-circled','icon-spotify','icon-spotify-circled','icon-qq','icon-instagram','icon-dropbox','icon-evernote','icon-flattr','icon-skype','icon-skype-circled','icon-renren','icon-sina-weibo','icon-paypal','icon-picasa','icon-soundcloud','icon-mixi','icon-behance','icon-google-circles','icon-vkontakte','icon-smashing','icon-db-shape','icon-sweden','icon-logo-db','icon-picture','icon-globe','icon-leaf','icon-graduation-cap','icon-mic','icon-palette','icon-ticket','icon-video','icon-target','icon-music','icon-trophy','icon-thumbs-up','icon-thumbs-down','icon-bag','icon-user','icon-users','icon-lamp','icon-alert','icon-water','icon-droplet','icon-credit-card','icon-monitor','icon-briefcase','icon-floppy','icon-cd','icon-folder','icon-doc-text','icon-calendar','icon-chart-line','icon-chart-bar','icon-clipboard','icon-attach','icon-bookmarks','icon-book','icon-book-open','icon-phone','icon-megaphone','icon-upload','icon-download','icon-box','icon-newspaper','icon-mobile','icon-signal','icon-camera','icon-shuffle','icon-loop','icon-arrows-ccw','icon-light-down','icon-light-up','icon-mute','icon-sound','icon-battery','icon-search','icon-key','icon-lock','icon-lock-open','icon-bell','icon-bookmark','icon-link','icon-back','icon-flashlight','icon-chart-area','icon-clock','icon-rocket','icon-block','icon-basket');?>
				<?php echo circleflip_field_radioButtonIcon('icon', $block_id, $icon_option , isset($icon) ? $icon : ''); ?>
			</span>
		</div>
		<p class="description adminDropdownShape">
			<span class="leftHalf">
			<label for="<?php echo esc_attr( $this->get_field_id('shape') ) ?>">
				Shape
			</label>
			<span class="description_text">
				Choose The Shape Button
			</span>
			</span>
			<span class="rightHalf">
				<span class="rightHalf select">
					<?php echo circleflip_field_select('shape', $block_id, array('Rounded Corner', 'Square Corner','Announcement Button'), isset($shape) ? $shape : 'Boxed', array('data-fd-handle="icon_shape"')) ?>
				</span>
			</span>
		</p>
		<p class="description typeButtonAnnounce" data-fd-rules='["icon_shape:equal:2"]'>
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('type') ) ?>">
					Type Button
				</label>
				<span class="description_text">
					Enter Type Button
				</span>
			</span>
			<span class="rightHalf">
				<?php echo circleflip_field_input('type', $block_id, $type, $size = 'full') ?>
			</span>
		</p>
		<p class="description">
			<span class="leftHalf">
			<label for="<?php echo esc_attr( $this->get_field_id('btn_size') ) ?>">
				Size
			</label>
			<span class="description_text">
				Choose Size Button
			</span>
			</span>
			<span class="rightHalf">
				<span class="rightHalf select">
					<?php echo circleflip_field_select('btn_size', $block_id, array('Large','Small','Full Size'), isset($btn_size) ? $btn_size : 'Large') ?>
				</span>
			</span>
		</p>
        <p class="description">
			<span class="leftHalf">
			<label for="<?php echo esc_attr( $this->get_field_id('btn_size') ) ?>">
				Font Size
			</label>
			<span class="description_text">
				Change Font Size, only numbers are allowed.
			</span>
			</span>
			<span class="rightHalf">
				<span class="rightHalf select">
					<?php echo circleflip_field_input('font_size', $block_id, '13', $size = 'full', 'number') ?>
				</span>
			</span>
		</p>
		<p class="description adminSelectTypeColor">
			<span class="leftHalf">
			<label for="<?php echo esc_attr( $this->get_field_id('color') ) ?>">
				Color
			</label>
			<span class="description_text">
				Choose Color Button
			</span>
			</span>
			<span class="rightHalf">
				<span class="rightHalf select">
					<?php $color_option = array('Custom','red','heavyRed', 'yellow', 'orange', 'grey', 'heavyGrey', 'green', 'heavyGreen', 'blue', 'heavyBlue','black') ?>
					<?php echo circleflip_field_select('color', $block_id, $color_option , isset($color) ? $color : 'red', array('data-fd-handle="color"')) ?>
				</span>
			</span>
		</p>
		<div class="description half last adminColorButton" data-fd-rules='["color:equal:0"]'>
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('color_button') ) ?>">
					Pick a Background Color Button
				</label>
				<span class="description_text">
				</span>
			</span>
			<span class="rightHalf">
				<?php echo circleflip_field_color_picker('color_button', $block_id, $color_button) ?>
			</span>
		</div>
		<div class="description half last adminColorButtonText" data-fd-rules='["color:equal:0"]'>
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('color_button_text') ) ?>">
					Pick a Color Text On Button
				</label>
				<span class="description_text">
				</span>
			</span>
			<span class="rightHalf">
				<?php echo circleflip_field_color_picker('color_button_text', $block_id, $color_button_text) ?>
			</span>
		</div>
		<div class="description half last adminColorButtonTextShadow" data-fd-rules='["color:equal:0","icon_shape:equal:2"]'>
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('color_button_text_shadow') ) ?>">
					Text Shadow
				</label>
				<span class="description_text">
					Choose Text Shadow
				</span>
			</span>
			<span class="rightHalf">
				<span class="rightHalf select">
					<?php echo circleflip_field_select('color_button_text_shadow', $block_id, array('none','white','black'), isset($color_button_text_shadow) ? $color_button_text_shadow : 'white') ?>
				</span>
			</span>
		</div>
		<p class="description">
			<span class="leftHalf">
			<label for="<?php echo esc_attr( $this->get_field_id('align') ) ?>">
				Align Direction
			</label>
			<span class="description_text">
				Choose Align Direction Button
			</span>
			</span>
			<span class="rightHalf">
				<span class="rightHalf select">
					<?php echo circleflip_field_select('align', $block_id, array('left','center','right'), isset($align) ? $align : 'left') ?>
				</span>
			</span>
		</p>
		<p class="description">
			<span class="leftHalf">
			<label for="<?php echo esc_attr( $this->get_field_id('link') ) ?>">
				Button Link
			</label>
			<span class="description_text">
			</span>
			</span>
			<span class="rightHalf">
				<?php echo circleflip_field_input('link', $block_id, $link, $size = 'full') ?>
			</span>
		</p>
		<p class="description">
			<span class="leftHalf">
			<label for="<?php echo esc_attr( $this->get_field_id('target') ) ?>">
				Link Target
			</label>
			<span class="description_text">
			</span>
			</span>
			<span class="rightHalf">
				<?php echo circleflip_field_input('target', $block_id, $target, $size = 'full') ?>
			</span>
		</p>
		<p class="description half">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('entrance_animation') ) ?>">
					On-Scroll Animation
				</label>
				<span class="description_text">
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
		$icon_option = array('icon-plus','icon-minus','icon-info','icon-left-thin','icon-up-thin','icon-right-thin','icon-down-thin','icon-level-up','icon-level-down','icon-switch','icon-infinity','icon-plus-squared','icon-minus-squared','icon-home','icon-keyboard','icon-erase','icon-pause','icon-fast-forward','icon-fast-backward','icon-to-end','icon-to-start','icon-hourglass','icon-stop','icon-up-dir','icon-play','icon-right-dir','icon-down-dir','icon-left-dir','icon-adjust','icon-cloud','icon-star','icon-star-empty','icon-cup','icon-menu','icon-moon','icon-heart-empty','icon-heart','icon-note','icon-note-beamed','icon-layout','icon-flag','icon-tools','icon-cog','icon-attention','icon-flash','icon-record','icon-cloud-thunder','icon-tape','icon-flight','icon-mail','icon-pencil','icon-feather','icon-check','icon-cancel','icon-cancel-circled','icon-cancel-squared','icon-help','icon-quote','icon-plus-circled','icon-minus-circled','icon-right','icon-direction','icon-forward','icon-ccw','icon-cw','icon-left','icon-up','icon-down','icon-list-add','icon-list','icon-left-bold','icon-right-bold','icon-up-bold','icon-down-bold','icon-user-add','icon-help-circled','icon-info-circled','icon-eye','icon-tag','icon-upload-cloud','icon-reply','icon-reply-all','icon-code','icon-export','icon-print','icon-retweet','icon-comment','icon-chat','icon-vcard','icon-address','icon-location','icon-map','icon-compass','icon-trash','icon-doc','icon-doc-text-inv','icon-docs','icon-doc-landscape','icon-archive','icon-rss','icon-share','icon-basket','icon-shareable','icon-login','icon-logout','icon-volume','icon-resize-full','icon-resize-small','icon-popup','icon-publish','icon-window','icon-arrow-combo','icon-chart-pie','icon-language','icon-air','icon-database','icon-drive','icon-bucket','icon-thermometer','icon-down-circled','icon-left-circled','icon-right-circled','icon-up-circled','icon-down-open','icon-left-open','icon-right-open','icon-up-open','icon-down-open-mini','icon-left-open-mini','icon-right-open-mini','icon-up-open-mini','icon-down-open-big','icon-left-open-big','icon-right-open-big','icon-up-open-big','icon-progress-0','icon-progress-1','icon-progress-2','icon-progress-3','icon-back-in-time','icon-network','icon-inbox','icon-install','icon-lifebuoy','icon-mouse','icon-dot','icon-dot-2','icon-dot-3','icon-suitcase','icon-flow-cascade','icon-flow-branch','icon-flow-tree','icon-flow-line','icon-flow-parallel','icon-brush','icon-paper-plane','icon-magnet','icon-gauge','icon-traffic-cone','icon-cc','icon-cc-by','icon-cc-nc','icon-cc-nc-eu','icon-cc-nc-jp','icon-cc-sa','icon-cc-nd','icon-cc-pd','icon-cc-zero','icon-cc-share','icon-cc-remix','icon-github','icon-github-circled','icon-flickr','icon-flickr-circled','icon-vimeo','icon-vimeo-circled','icon-twitter','icon-twitter-circled','icon-facebook','icon-facebook-circled','icon-facebook-squared','icon-gplus','icon-gplus-circled','icon-pinterest','icon-pinterest-circled','icon-tumblr','icon-tumblr-circled','icon-linkedin','icon-linkedin-circled','icon-dribbble','icon-dribbble-circled','icon-stumbleupon','icon-stumbleupon-circled','icon-lastfm','icon-lastfm-circled','icon-rdio','icon-rdio-circled','icon-spotify','icon-spotify-circled','icon-qq','icon-instagram','icon-dropbox','icon-evernote','icon-flattr','icon-skype','icon-skype-circled','icon-renren','icon-sina-weibo','icon-paypal','icon-picasa','icon-soundcloud','icon-mixi','icon-behance','icon-google-circles','icon-vkontakte','icon-smashing','icon-db-shape','icon-sweden','icon-logo-db','icon-picture','icon-globe','icon-leaf','icon-graduation-cap','icon-mic','icon-palette','icon-ticket','icon-video','icon-target','icon-music','icon-trophy','icon-thumbs-up','icon-thumbs-down','icon-bag','icon-user','icon-users','icon-lamp','icon-alert','icon-water','icon-droplet','icon-credit-card','icon-monitor','icon-briefcase','icon-floppy','icon-cd','icon-folder','icon-doc-text','icon-calendar','icon-chart-line','icon-chart-bar','icon-clipboard','icon-attach','icon-bookmarks','icon-book','icon-book-open','icon-phone','icon-megaphone','icon-upload','icon-download','icon-box','icon-newspaper','icon-mobile','icon-signal','icon-camera','icon-shuffle','icon-loop','icon-arrows-ccw','icon-light-down','icon-light-up','icon-mute','icon-sound','icon-battery','icon-search','icon-key','icon-lock','icon-lock-open','icon-bell','icon-bookmark','icon-link','icon-back','icon-flashlight','icon-chart-area','icon-clock','icon-rocket','icon-block','icon-basket');
		$color_option = array('Custom','red','heavyRed', 'yellow', 'orange', 'grey', 'heavyGrey', 'green', 'heavyGreen', 'blue', 'heavyBlue','black');
		$class = '';
		$classColor = '';
		$Announcement = 0;
		$textShadow = '';
		switch ($color_button_text_shadow) {
			case '0':
				$textShadow = 'none';
			break;
			case '1':
				$textShadow = '#ffffff';
				break;
			case '2':
				$textShadow = '#000000';
				break;
			default:
				$textShadow .= '#ffffff';
				break;
		}
		if($shape != 'btnStyle3') {
			switch ($shape) {
				case '0':
					$class .= 'btnStyle1 ';
					$Announcement = 0;
				break;
				case '1':
					$class .= 'btnStyle2 ';
					$Announcement = 0;
					break;
				case '2':
					$class .= 'btnStyle3 ';
					$Announcement = 1;
					break;
				default:
					$class .= 'btnStyle1 ';
					$Announcement = 0;
					break;
			}

			if(isset($checkIcon)){
				if($checkIcon == 0){
					$checkIconClass = 'withoutIcon';
				}else{
					$checkIconClass = 'withIcon';
				}
			}


			if(isset($color)) {
				$class .= $color_option[$color] .' ';
				$classColor = $color_option[$color];
			}
			//echo $btn_size;
			switch ($btn_size) {
				case '0':
					$class .= 'btnLarge ';
				break;
				case '1':
					$class .= '';
				break;
				case '2':
					$class .= 'btn-block ';
				break;
				default:

				break;
			}
			switch ($align) {
				case '0':
					$class .= 'btnLeft ';
				break;
				case '1':
					$class .= 'btnCenter ';
					break;
				case '2':
					$class .= 'btnRight ';
					break;
				default:
					$class .= 'btnLeft ';
					break;
			}
		}
		else {
			$class .= 'btnStyle3 ';
			if(isset($color)) {
				$class .= $color_option[$color] .' ';
			}
			switch ($align) {
				case '0':
					$class .= 'btnLeft ';
				break;
				case '1':
					$class .= 'btnCenter ';
					break;
				case '2':
					$class .= 'btnRight ';
					break;
				default:
					$class .= 'btnLeft ';
					break;
			}
		}
		if($Announcement == 0){
		?>
		<a href="<?php echo esc_url($link); ?>" target="<?php echo esc_attr($target) ?>" class=" <?php echo esc_attr($class); ?> <?php echo esc_attr($checkIconClass) ?>  animateCr <?php echo esc_attr($entrance_animation) ?>" <?php if( $classColor == 'Custom' ) { ?> style="background: <?php echo esc_attr($color_button) ?>; color:<?php echo esc_attr($color_button_text) ?>;font-size: <?php echo esc_attr($font_size);?>px;" <?php } ?> >
			<?php 
				if( $btn_size == 2 ) {
					echo '<div class="fullSizeButton">';
				} 
			?>
			<?php if($checkIconClass == 'withIcon'){?>
			<div class="btnIcon <?php echo esc_attr($icon)?>"></div>
			<?php } ?>
			<span> <?php echo do_shortcode(htmlspecialchars_decode($text)); ?></span>
			<?php 
				if( $btn_size == 2 ) {
					echo '</div>';
				} 
			?>
			<span class="btnBefore" <?php if( $classColor == 'Custom' ) { ?> style="border-color: <?php echo esc_attr($color_button) ?>;" <?php } ?>></span>
    		<span class="btnAfter" <?php if( $classColor == 'Custom' ) { ?> style="border-color: <?php echo esc_attr($color_button) ?>;" <?php } ?>></span>
		</a>
		<?php }else{
			?>
			<a href="<?php echo esc_url($link); ?>" target="<?php echo esc_attr($target) ?>" class=" animateCr <?php echo esc_attr($entrance_animation) ?> <?php echo esc_attr($class);  ?>   <?php echo esc_attr($checkIconClass) ?>" <?php if( $classColor == 'Custom' ) { ?> style="background: <?php echo esc_attr($color_button) ?>; color:<?php echo esc_attr($color_button_text) ?>;" <?php } ?> >
				<?php if($checkIconClass == 'withIcon'){?>
				<div class="btnIcon <?php echo esc_attr($icon)?>" style="<?php if($textShadow != 'none'){ ?>text-shadow:1px 1px <?php echo esc_attr($textShadow) ?>;<?php }else{ ?>text-shadow:none;<?php } ?>" ></div>
				<?php } ?>
			 	<?php if($type != null){ ?>
				<span class="buttonType"><?php echo esc_html($type) ?></span>
				<?php } ?>
				<span class="buttonText" style="<?php if($textShadow != 'none'){ ?>text-shadow:1px 1px <?php echo esc_attr($textShadow) ?>;<?php }else{ ?>text-shadow:none;<?php } ?>"><?php echo do_shortcode(htmlspecialchars_decode($text)); ?></span>
				<span class="btnBefore" <?php if( $classColor == 'Custom' ) { ?> style="border-color: <?php echo esc_attr($color_button) ?>;" <?php } ?>></span>
    			<span class="btnAfter" <?php if( $classColor == 'Custom' ) { ?> style="border-color: <?php echo esc_attr($color_button) ?>;" <?php } ?>></span>
			</a>
		<?php
		}
	}
	public function admin_enqueue_buttonBlock(){
		wp_register_script('button-block-script', get_template_directory_uri() . '/creiden-framework/content-builder/assets/js/blocks/cr-button-block.js', array('aqpb-js'),'2.0.3',true);
		wp_enqueue_script('button-block-script');
	}

}