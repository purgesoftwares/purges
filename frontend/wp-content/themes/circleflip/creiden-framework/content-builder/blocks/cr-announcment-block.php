<?php
/** A simple text block **/
class CR_Announcment_Block extends AQ_Block {

	//set and create block
	function __construct() {
		$block_options = array(
			'image' => 'announcment.png',
			'name' => 'Announcement',
			'size' => 'span6',
                        'tab' => 'Content',
                        'imagedesc' => 'announcment.jpg',
                	'desc' => 'Announcement block with the option of adding a button.'
		);
		//create the block
		parent::__construct('cr_announcment_block', $block_options);
	}

	public function enqueue_view_subscribe_script(){
		$theme_version = _circleflip_version();
		wp_enqueue_style('subscribe-css',get_template_directory_uri() . "/css/content-builder/subscribe.css",array(),$theme_version);
	}

	function form($instance) {

		$defaults = array(
			'text' => '',
			'icon' => '',
			'display' => '',
			'btn_text' => '',
			'link' => '',
			'color' => '',
			'btn_type' => '',
			'entrance_animation' => '',
			'type' => '',
			'color_button' => '',
			'color_button_text' => ''
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);

		?>
		<div class="description">
			<div class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('text') ) ?>">
					Content
				</label>
			</div>
			<div class="rightHalf">
				<?php //echo aq_field_textarea('text', $block_id, $text, $size = 'full') ?>
				<?php echo wp_editor($text, $block_id, array('textarea_name'=>'aq_blocks['.$block_id.'][text]','quicktags'=>false)); ?>
			</div>
		</div>
		<p class="description AnnouncementCheckIcon">
			<span class="leftHalf ">
				<label for="<?php echo esc_attr( $this->get_field_id('checkIcon') ) ?>">
					Announcement Icon
				</label>
			</span>
			<span class="rightHalf">
				<?php echo circleflip_field_checkbox('checkIcon', $block_id, (isset($checkIcon))? $checkIcon : 0, array('data-fd-handle="ann_icon"')) ?>
			</span>
		</p>
		<div class="description AnnouncementIcon iconselector" data-fd-rules='["ann_icon:checked"]'>
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('icon') ) ?>">
					Pick an icon
				</label>
			</span>
			<span class="rightHalf icons">
				<?php $icon_option = array('icon-plus','icon-minus','icon-info','icon-left-thin','icon-up-thin','icon-right-thin','icon-down-thin','icon-level-up','icon-level-down','icon-switch','icon-infinity','icon-plus-squared','icon-minus-squared','icon-home','icon-keyboard','icon-erase','icon-pause','icon-fast-forward','icon-fast-backward','icon-to-end','icon-to-start','icon-hourglass','icon-stop','icon-up-dir','icon-play','icon-right-dir','icon-down-dir','icon-left-dir','icon-adjust','icon-cloud','icon-star','icon-star-empty','icon-cup','icon-menu','icon-moon','icon-heart-empty','icon-heart','icon-note','icon-note-beamed','icon-layout','icon-flag','icon-tools','icon-cog','icon-attention','icon-flash','icon-record','icon-cloud-thunder','icon-tape','icon-flight','icon-mail','icon-pencil','icon-feather','icon-check','icon-cancel','icon-cancel-circled','icon-cancel-squared','icon-help','icon-quote','icon-plus-circled','icon-minus-circled','icon-right','icon-direction','icon-forward','icon-ccw','icon-cw','icon-left','icon-up','icon-down','icon-list-add','icon-list','icon-left-bold','icon-right-bold','icon-up-bold','icon-down-bold','icon-user-add','icon-help-circled','icon-info-circled','icon-eye','icon-tag','icon-upload-cloud','icon-reply','icon-reply-all','icon-code','icon-export','icon-print','icon-retweet','icon-comment','icon-chat','icon-vcard','icon-address','icon-location','icon-map','icon-compass','icon-trash','icon-doc','icon-doc-text-inv','icon-docs','icon-doc-landscape','icon-archive','icon-rss','icon-share','icon-basket','icon-shareable','icon-login','icon-logout','icon-volume','icon-resize-full','icon-resize-small','icon-popup','icon-publish','icon-window','icon-arrow-combo','icon-chart-pie','icon-language','icon-air','icon-database','icon-drive','icon-bucket','icon-thermometer','icon-down-circled','icon-left-circled','icon-right-circled','icon-up-circled','icon-down-open','icon-left-open','icon-right-open','icon-up-open','icon-down-open-mini','icon-left-open-mini','icon-right-open-mini','icon-up-open-mini','icon-down-open-big','icon-left-open-big','icon-right-open-big','icon-up-open-big','icon-progress-0','icon-progress-1','icon-progress-2','icon-progress-3','icon-back-in-time','icon-network','icon-inbox','icon-install','icon-lifebuoy','icon-mouse','icon-dot','icon-dot-2','icon-dot-3','icon-suitcase','icon-flow-cascade','icon-flow-branch','icon-flow-tree','icon-flow-line','icon-flow-parallel','icon-brush','icon-paper-plane','icon-magnet','icon-gauge','icon-traffic-cone','icon-cc','icon-cc-by','icon-cc-nc','icon-cc-nc-eu','icon-cc-nc-jp','icon-cc-sa','icon-cc-nd','icon-cc-pd','icon-cc-zero','icon-cc-share','icon-cc-remix','icon-github','icon-github-circled','icon-flickr','icon-flickr-circled','icon-vimeo','icon-vimeo-circled','icon-twitter','icon-twitter-circled','icon-facebook','icon-facebook-circled','icon-facebook-squared','icon-gplus','icon-gplus-circled','icon-pinterest','icon-pinterest-circled','icon-tumblr','icon-tumblr-circled','icon-linkedin','icon-linkedin-circled','icon-dribbble','icon-dribbble-circled','icon-stumbleupon','icon-stumbleupon-circled','icon-lastfm','icon-lastfm-circled','icon-rdio','icon-rdio-circled','icon-spotify','icon-spotify-circled','icon-qq','icon-instagram','icon-dropbox','icon-evernote','icon-flattr','icon-skype','icon-skype-circled','icon-renren','icon-sina-weibo','icon-paypal','icon-picasa','icon-soundcloud','icon-mixi','icon-behance','icon-google-circles','icon-vkontakte','icon-smashing','icon-db-shape','icon-sweden','icon-logo-db','icon-picture','icon-globe','icon-leaf','icon-graduation-cap','icon-mic','icon-palette','icon-ticket','icon-video','icon-target','icon-music','icon-trophy','icon-thumbs-up','icon-thumbs-down','icon-bag','icon-user','icon-users','icon-lamp','icon-alert','icon-water','icon-droplet','icon-credit-card','icon-monitor','icon-briefcase','icon-floppy','icon-cd','icon-folder','icon-doc-text','icon-calendar','icon-chart-line','icon-chart-bar','icon-clipboard','icon-attach','icon-bookmarks','icon-book','icon-book-open','icon-phone','icon-megaphone','icon-upload','icon-download','icon-box','icon-newspaper','icon-mobile','icon-signal','icon-camera','icon-shuffle','icon-loop','icon-arrows-ccw','icon-light-down','icon-light-up','icon-mute','icon-sound','icon-battery','icon-search','icon-key','icon-lock','icon-lock-open','icon-bell','icon-bookmark','icon-link','icon-back','icon-flashlight','icon-chart-area','icon-clock','icon-rocket','icon-block');?>
				<?php echo circleflip_field_radioButtonIcon('icon', $block_id, $icon_option , isset($icon) ? $icon : ''); ?>
			</span>
		</div>
		<p class="description">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('display') ) ?>">
					Theme
				</label>
			</span>
			<span class="rightHalf">
				<span class="rightHalf select">
					<?php echo circleflip_field_select('display', $block_id, array('Light','Dark'), isset($display) ? $display : 'Light') ?>
				</span>
			</span>
		</p>
		<p class="description">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('btn_text') ) ?>">
					Button Text
				</label>
				<span class="description_text">
					Enter Text On Button
				</span>
			</span>
			<span class="rightHalf">
				<?php echo circleflip_field_input('btn_text', $block_id, $btn_text, $size = 'full') ?>
			</span>
		</p>
		<p class="description ButtonCheckIcon">
			<span class="leftHalf ">
				<label for="<?php echo esc_attr( $this->get_field_id('btn_checkIcon') ) ?>">
					Button Icon
				</label>
				<span class="description_text">
				</span>
			</span>
			<span class="rightHalf">
				<?php echo circleflip_field_checkbox('btn_checkIcon', $block_id, (isset($btn_checkIcon))? $btn_checkIcon : 0, array('data-fd-handle="with_icon"')) ?>
			</span>
		</p>
		<div class="description ButtonIcon iconselector" data-fd-rules='["with_icon:checked"]'>
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('btn_icon') ) ?>">
					Button icons
				</label>
				<span class="description_text">
					Choose Icon Button
				</span>
			</span>
			<span class="rightHalf icons">
				<?php $btn_icon_option = array('icon-plus','icon-minus','icon-info','icon-left-thin','icon-up-thin','icon-right-thin','icon-down-thin','icon-level-up','icon-level-down','icon-switch','icon-infinity','icon-plus-squared','icon-minus-squared','icon-home','icon-keyboard','icon-erase','icon-pause','icon-fast-forward','icon-fast-backward','icon-to-end','icon-to-start','icon-hourglass','icon-stop','icon-up-dir','icon-play','icon-right-dir','icon-down-dir','icon-left-dir','icon-adjust','icon-cloud','icon-star','icon-star-empty','icon-cup','icon-menu','icon-moon','icon-heart-empty','icon-heart','icon-note','icon-note-beamed','icon-layout','icon-flag','icon-tools','icon-cog','icon-attention','icon-flash','icon-record','icon-cloud-thunder','icon-tape','icon-flight','icon-mail','icon-pencil','icon-feather','icon-check','icon-cancel','icon-cancel-circled','icon-cancel-squared','icon-help','icon-quote','icon-plus-circled','icon-minus-circled','icon-right','icon-direction','icon-forward','icon-ccw','icon-cw','icon-left','icon-up','icon-down','icon-list-add','icon-list','icon-left-bold','icon-right-bold','icon-up-bold','icon-down-bold','icon-user-add','icon-help-circled','icon-info-circled','icon-eye','icon-tag','icon-upload-cloud','icon-reply','icon-reply-all','icon-code','icon-export','icon-print','icon-retweet','icon-comment','icon-chat','icon-vcard','icon-address','icon-location','icon-map','icon-compass','icon-trash','icon-doc','icon-doc-text-inv','icon-docs','icon-doc-landscape','icon-archive','icon-rss','icon-share','icon-basket','icon-shareable','icon-login','icon-logout','icon-volume','icon-resize-full','icon-resize-small','icon-popup','icon-publish','icon-window','icon-arrow-combo','icon-chart-pie','icon-language','icon-air','icon-database','icon-drive','icon-bucket','icon-thermometer','icon-down-circled','icon-left-circled','icon-right-circled','icon-up-circled','icon-down-open','icon-left-open','icon-right-open','icon-up-open','icon-down-open-mini','icon-left-open-mini','icon-right-open-mini','icon-up-open-mini','icon-down-open-big','icon-left-open-big','icon-right-open-big','icon-up-open-big','icon-progress-0','icon-progress-1','icon-progress-2','icon-progress-3','icon-back-in-time','icon-network','icon-inbox','icon-install','icon-lifebuoy','icon-mouse','icon-dot','icon-dot-2','icon-dot-3','icon-suitcase','icon-flow-cascade','icon-flow-branch','icon-flow-tree','icon-flow-line','icon-flow-parallel','icon-brush','icon-paper-plane','icon-magnet','icon-gauge','icon-traffic-cone','icon-cc','icon-cc-by','icon-cc-nc','icon-cc-nc-eu','icon-cc-nc-jp','icon-cc-sa','icon-cc-nd','icon-cc-pd','icon-cc-zero','icon-cc-share','icon-cc-remix','icon-github','icon-github-circled','icon-flickr','icon-flickr-circled','icon-vimeo','icon-vimeo-circled','icon-twitter','icon-twitter-circled','icon-facebook','icon-facebook-circled','icon-facebook-squared','icon-gplus','icon-gplus-circled','icon-pinterest','icon-pinterest-circled','icon-tumblr','icon-tumblr-circled','icon-linkedin','icon-linkedin-circled','icon-dribbble','icon-dribbble-circled','icon-stumbleupon','icon-stumbleupon-circled','icon-lastfm','icon-lastfm-circled','icon-rdio','icon-rdio-circled','icon-spotify','icon-spotify-circled','icon-qq','icon-instagram','icon-dropbox','icon-evernote','icon-flattr','icon-skype','icon-skype-circled','icon-renren','icon-sina-weibo','icon-paypal','icon-picasa','icon-soundcloud','icon-mixi','icon-behance','icon-google-circles','icon-vkontakte','icon-smashing','icon-db-shape','icon-sweden','icon-logo-db','icon-picture','icon-globe','icon-leaf','icon-graduation-cap','icon-mic','icon-palette','icon-ticket','icon-video','icon-target','icon-music','icon-trophy','icon-thumbs-up','icon-thumbs-down','icon-bag','icon-user','icon-users','icon-lamp','icon-alert','icon-water','icon-droplet','icon-credit-card','icon-monitor','icon-briefcase','icon-floppy','icon-cd','icon-folder','icon-doc-text','icon-calendar','icon-chart-line','icon-chart-bar','icon-clipboard','icon-attach','icon-bookmarks','icon-book','icon-book-open','icon-phone','icon-megaphone','icon-upload','icon-download','icon-box','icon-newspaper','icon-mobile','icon-signal','icon-camera','icon-shuffle','icon-loop','icon-arrows-ccw','icon-light-down','icon-light-up','icon-mute','icon-sound','icon-battery','icon-search','icon-key','icon-lock','icon-lock-open','icon-bell','icon-bookmark','icon-link','icon-back','icon-flashlight','icon-chart-area','icon-clock','icon-rocket','icon-block','icon-basket');?>
				<?php echo circleflip_field_radioButtonIcon('btn_icon', $block_id, $btn_icon_option , isset($btn_icon) ? $btn_icon : ''); ?>
			</span>
		</div>
		<p class="description adminDropdownShape">
			<span class="leftHalf">
			<label for="<?php echo esc_attr( $this->get_field_id('shape') ) ?>">
				Button Shape
			</label>
			<span class="description_text">
				Choose The Shape Button
			</span>
			</span>
			<span class="rightHalf">
				<span class="rightHalf select">
					<?php echo circleflip_field_select('shape', $block_id, array('Rounded Corner', 'Square Corner','Announcement Button'), isset($shape) ? $shape : 'Boxed', array('data-fd-handle="shape"')) ?>
				</span>
			</span>
		</p>
		<p class="description typeButtonAnnounce" data-fd-rules='["shape:equal:2"]'>
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('type') ) ?>">
					Button Type
				</label>
				<span class="description_text">
					Enter Button Type
				</span>
			</span>
			<span class="rightHalf">
				<?php echo circleflip_field_input('type', $block_id, $type, $size = 'full') ?>
			</span>
		</p>
		<p class="description">
			<span class="leftHalf">
			<label for="<?php echo esc_attr( $this->get_field_id('btn_size') ) ?>">
				Button Size
			</label>
			<span class="description_text">
				Choose Size Button
			</span>
			</span>
			<span class="rightHalf">
				<span class="rightHalf select">
					<?php echo circleflip_field_select('btn_size', $block_id, array('Large','Small'), isset($btn_size) ? $btn_size : 'Large') ?>
				</span>
			</span>
		</p>
		<p class="description adminSelectTypeColor">
			<span class="leftHalf">
			<label for="<?php echo esc_attr( $this->get_field_id('btn_color') ) ?>">
				Color
			</label>
			<span class="description_text">
				Choose Color Button
			</span>
			</span>
			<span class="rightHalf">
				<span class="rightHalf select">
					<?php $btn_color_option = array('Custom','red','heavyRed', 'yellow', 'orange', 'grey', 'heavyGrey', 'green', 'heavyGreen', 'blue', 'heavyBlue','black') ?>
					<?php echo circleflip_field_select('btn_color', $block_id, $btn_color_option , isset($btn_color) ? $btn_color : 'red', array('data-fd-handle="color"')) ?>
				</span>
			</span>
		</p>
		<div class="description half last adminColorButton" data-fd-rules='["color:equal:0"]'>
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('color_button') ) ?>">
					Button Background Color
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
					Button Text Color
				</label>
				<span class="description_text">
				</span>
			</span>
			<span class="rightHalf">
				<?php echo circleflip_field_color_picker('color_button_text', $block_id, $color_button_text) ?>
			</span>
		</div>
		<div class="description half last adminColorButtonTextShadow" data-fd-rules='["color:equal:0","shape:equal:2"]'>
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('color_button_text_shadow') ) ?>">
					Button Text Shadow
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
		$this->enqueue_view_subscribe_script();
		$btn_color_option = array('Custom','red','heavyRed', 'yellow', 'orange', 'grey', 'heavyGrey', 'green', 'heavyGreen', 'blue', 'heavyBlue','black');
		$class = '';
		$icon_btn_class = '';
		$icon_class = '';
		$textShadow = '';
		$validCheckIconClass = 'withoutIcon';
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
		if(isset($icon)) {
				$icon_class .= $icon .' ';
		}
		if(isset($btn_icon)) {
				$icon_btn_class .= $btn_icon .' ';
		}
	$display_subscribe ='';
	switch ($display) {
			case '0':
					$display_subscribe = '';
					 break;
			case '1':
					 $display_subscribe = 'Dark';
					 break;
			default:
					$class .= '';
					break;
			}
	$checkIconClass = 'withoutIcon';
	$classColor = '';
	$Announcement = 0;
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
			if(isset($btn_checkIcon)){
				if($btn_checkIcon == 0){
					$validCheckIconClass = 'withoutIcon';
				}else{
					$validCheckIconClass = 'withIcon';
				}
			}
			if(isset($btn_color)) {
				$class .= $btn_color_option[$btn_color] .' ';
				$classColor = $btn_color_option[$btn_color];
			}
			//echo $btn_size;
			switch ($btn_size) {
				case '0':
					$class .= 'btnLarge ';
				break;
				default:

				break;
			}
		}
		else {
			$class .= 'btnStyle3 ';
		}
		?>
		<div class="<?php echo esc_attr($entrance_animation) ?> animateCr">
			<div class="subscribe <?php echo esc_attr($display_subscribe); ?> clearfix">
				<div class="cornerTop"></div>
				<?php if($checkIconClass == 'withIcon'){ ?>
				<div class="icon"><div class="iconAnnouncement"><span class="iconComment <?php echo esc_attr($icon_class) ?>"></span></div></div>
				<?php } ?>
				<?php if(isset($text) && !empty($text)) { ?>
				<div class="subPragraph"><p><?php echo $text ?></p></div>
				<?php }
				if($Announcement == 0){ ?>
				<a href="<?php echo esc_url($link); ?>" class="<?php echo esc_attr($class); ?> <?php if(isset($btn_CheckIcon)) echo esc_attr($btn_CheckIcon) ?> <?php if($validCheckIconClass == 'withIcon'){ echo 'withIcon'; }   ?>" <?php if( $classColor == 'Custom' ) { ?> style="background: <?php echo esc_attr($color_button) ?>; color:<?php echo esc_attr($color_button_text) ?>; "<?php } ?>>
					<?php
					 if($validCheckIconClass == 'withIcon'){ ?>
					<div class="btnIcon <?php echo esc_attr($btn_icon) ?>"></div>
					<?php } ?>
					<span><?php echo do_shortcode(htmlspecialchars_decode($btn_text)); ?></span>
					<span class="btnBefore" <?php if( $classColor == 'Custom' ) { ?> style="border-color: <?php echo esc_attr($color_button) ?>;" <?php } ?>></span>
					<span class="btnAfter" <?php if( $classColor == 'Custom' ) { ?> style="border-color: <?php echo esc_attr($color_button) ?>;" <?php } ?>></span>
				</a>
				<?php }else{ ?>
					<a href="<?php echo esc_url($link); ?>" class="<?php echo esc_attr($class); ?>  <?php echo esc_attr($validCheckIconClass) ?>" <?php if( $classColor == 'Custom' ) { ?> style="background: <?php echo esc_attr($color_button) ?>; color:<?php echo esc_attr($color_button_text) ?>;" <?php } ?>>
						<?php if($validCheckIconClass == 'withIcon'){?>
						<div class="btnIcon <?php echo esc_attr($icon_btn_class)?>" style="<?php if($textShadow != 'none'){ ?>text-shadow:1px 1px <?php echo esc_attr($textShadow) ?>;<?php }else{ ?>text-shadow:none;<?php } ?>"></div>
						<?php } ?>
					 	<?php if($type != null){ ?>
						<span class="buttonType"><?php echo $type ?></span>
						<?php } ?>
						<span class="buttonText" style="<?php if($textShadow != 'none'){ ?>text-shadow:1px 1px <?php echo esc_attr($textShadow) ?>;<?php }else{ ?>text-shadow:none;<?php } ?>"><?php echo do_shortcode(htmlspecialchars_decode($btn_text)); ?></span>
						<span class="btnBefore" <?php if( $classColor == 'Custom' ) { ?> style="border-color: <?php echo esc_attr($color_button) ?>;" <?php } ?>></span>
    					<span class="btnAfter" <?php if( $classColor == 'Custom' ) { ?> style="border-color: <?php echo esc_attr($color_button) ?>;" <?php } ?>></span>
					</a>
				<?php
				} ?>
				<div class="cornerBottom"></div>
			</div>
		</div>
		<?php
		}
		public function admin_enqueue_buttonBlock(){
			wp_register_script('button-block-script', get_template_directory_uri() . '/creiden-framework/content-builder/assets/js/blocks/cr-button-block.js', array('aqpb-js'),'2.0.3',true);
			wp_enqueue_script('button-block-script');
		}
	}