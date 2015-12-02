<?php
/** Notifications block **/

class cr_counter_block extends AQ_Block {

	//set and create block
	function __construct() {
		$block_options = array(
			'image' => 'alert.png',
			'name' => 'Counter',
			'size' => 'span3',
			'tab' => 'Content',
			'imagedesc' => 'alerts.jpg',
			'desc' => 'This is a counter block, it counts.'
		);

		//create the block
		parent::__construct('cr_counter_block', $block_options);
	}

	function form($instance) {

		$defaults = array(
			'counternumber' => '',
			'counterunit' => '',
			'custom_icon' => '',
			'counter_color'=>'',
			'entrance_animation' => ''
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);

		?>
		<p class="description">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('counternumber') ) ?>">
					<?php _e( 'Number', 'circleflip-builder' ) ?>
				</label>
			</span>
			<span class="rightHalf">
				<?php echo circleflip_field_input('counternumber', $block_id, $counternumber) ?>
			</span>
		</p>
		<p class="description">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('counterunit') ) ?>">
					<?php _e( 'Unit', 'circleflip-builder' ) ?>
				</label>
			</span>
			<span class="rightHalf">
				<?php echo circleflip_field_input('counterunit', $block_id, $counterunit) ?>
			</span>
		</p>
		<div class="description ButtonIcon iconselector" >
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('custom_icon') ) ?>">
					Pick an icon
				</label>
			</span>
			<span class="rightHalf icons">
				<?php $icon_option = array('icon-plus','icon-minus','icon-info','icon-left-thin','icon-up-thin','icon-right-thin','icon-down-thin','icon-level-up','icon-level-down','icon-switch','icon-infinity','icon-plus-squared','icon-minus-squared','icon-home','icon-keyboard','icon-erase','icon-pause','icon-fast-forward','icon-fast-backward','icon-to-end','icon-to-start','icon-hourglass','icon-stop','icon-up-dir','icon-play','icon-right-dir','icon-down-dir','icon-left-dir','icon-adjust','icon-cloud','icon-star','icon-star-empty','icon-cup','icon-menu','icon-moon','icon-heart-empty','icon-heart','icon-note','icon-note-beamed','icon-layout','icon-flag','icon-tools','icon-cog','icon-attention','icon-flash','icon-record','icon-cloud-thunder','icon-tape','icon-flight','icon-mail','icon-pencil','icon-feather','icon-check','icon-cancel','icon-cancel-circled','icon-cancel-squared','icon-help','icon-quote','icon-plus-circled','icon-minus-circled','icon-right','icon-direction','icon-forward','icon-ccw','icon-cw','icon-left','icon-up','icon-down','icon-list-add','icon-list','icon-left-bold','icon-right-bold','icon-up-bold','icon-down-bold','icon-user-add','icon-help-circled','icon-info-circled','icon-eye','icon-tag','icon-upload-cloud','icon-reply','icon-reply-all','icon-code','icon-export','icon-print','icon-retweet','icon-comment','icon-chat','icon-vcard','icon-address','icon-location','icon-map','icon-compass','icon-trash','icon-doc','icon-doc-text-inv','icon-docs','icon-doc-landscape','icon-archive','icon-rss','icon-share','icon-basket','icon-shareable','icon-login','icon-logout','icon-volume','icon-resize-full','icon-resize-small','icon-popup','icon-publish','icon-window','icon-arrow-combo','icon-chart-pie','icon-language','icon-air','icon-database','icon-drive','icon-bucket','icon-thermometer','icon-down-circled','icon-left-circled','icon-right-circled','icon-up-circled','icon-down-open','icon-left-open','icon-right-open','icon-up-open','icon-down-open-mini','icon-left-open-mini','icon-right-open-mini','icon-up-open-mini','icon-down-open-big','icon-left-open-big','icon-right-open-big','icon-up-open-big','icon-progress-0','icon-progress-1','icon-progress-2','icon-progress-3','icon-back-in-time','icon-network','icon-inbox','icon-install','icon-lifebuoy','icon-mouse','icon-dot','icon-dot-2','icon-dot-3','icon-suitcase','icon-flow-cascade','icon-flow-branch','icon-flow-tree','icon-flow-line','icon-flow-parallel','icon-brush','icon-paper-plane','icon-magnet','icon-gauge','icon-traffic-cone','icon-cc','icon-cc-by','icon-cc-nc','icon-cc-nc-eu','icon-cc-nc-jp','icon-cc-sa','icon-cc-nd','icon-cc-pd','icon-cc-zero','icon-cc-share','icon-cc-remix','icon-github','icon-github-circled','icon-flickr','icon-flickr-circled','icon-vimeo','icon-vimeo-circled','icon-twitter','icon-twitter-circled','icon-facebook','icon-facebook-circled','icon-facebook-squared','icon-gplus','icon-gplus-circled','icon-pinterest','icon-pinterest-circled','icon-tumblr','icon-tumblr-circled','icon-linkedin','icon-linkedin-circled','icon-dribbble','icon-dribbble-circled','icon-stumbleupon','icon-stumbleupon-circled','icon-lastfm','icon-lastfm-circled','icon-rdio','icon-rdio-circled','icon-spotify','icon-spotify-circled','icon-qq','icon-instagram','icon-dropbox','icon-evernote','icon-flattr','icon-skype','icon-skype-circled','icon-renren','icon-sina-weibo','icon-paypal','icon-picasa','icon-soundcloud','icon-mixi','icon-behance','icon-google-circles','icon-vkontakte','icon-smashing','icon-db-shape','icon-sweden','icon-logo-db','icon-picture','icon-globe','icon-leaf','icon-graduation-cap','icon-mic','icon-palette','icon-ticket','icon-video','icon-target','icon-music','icon-trophy','icon-thumbs-up','icon-thumbs-down','icon-bag','icon-user','icon-users','icon-lamp','icon-alert','icon-water','icon-droplet','icon-credit-card','icon-monitor','icon-briefcase','icon-floppy','icon-cd','icon-folder','icon-doc-text','icon-calendar','icon-chart-line','icon-chart-bar','icon-clipboard','icon-attach','icon-bookmarks','icon-book','icon-book-open','icon-phone','icon-megaphone','icon-upload','icon-download','icon-box','icon-newspaper','icon-mobile','icon-signal','icon-camera','icon-shuffle','icon-loop','icon-arrows-ccw','icon-light-down','icon-light-up','icon-mute','icon-sound','icon-battery','icon-search','icon-key','icon-lock','icon-lock-open','icon-bell','icon-bookmark','icon-link','icon-back','icon-flashlight','icon-chart-area','icon-clock','icon-rocket','icon-block','icon-basket');?>
				<?php echo circleflip_field_radioButtonIcon('custom_icon', $block_id, $icon_option , isset($custom_icon) ? $custom_icon : ''); ?>
			</span>
		</div>
		<div class="description half last adminColorButtonText">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('counter_color') ) ?>">
					Pick a Color Text On Button
				</label>
				<span class="description_text">
				</span>
			</span>
			<span class="rightHalf">
				<?php echo circleflip_field_color_picker('counter_color', $block_id, $counter_color) ?>
			</span>
		</div>
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
		$this->counterScripts();
		extract($instance);
		if($entrance_animation == 'default') {
			$entrance_animation = cr_get_option('block_animations');
		}
		echo '<div class="cfCounter textCenter cf animateCr '.esc_attr($entrance_animation).'">
			<span class="counterIcon '.esc_attr($custom_icon).'" style="color:'.esc_attr($counter_color).'"></span>
			<span class="counterNumber grid2" style="color:'.esc_attr($counter_color).'">'.esc_html($counternumber).'</span>
			<span class="counterUnit">'.esc_html($counterunit).'</span>
			</div> ';
	}
	
	function counterScripts() {
		wp_register_script('waypoint',get_template_directory_uri()."/js/waypoints.min.js",array('jquery'),'2.0.3',true);
		wp_register_script('counterJs',get_template_directory_uri().'/js/jquery.counterup.min.js',array('jquery'),'2.0.3',true);

		wp_enqueue_script('waypoint');
		wp_enqueue_script('counterJs');
		
		wp_register_style('counterCss',get_template_directory_uri() . "/css/content-builder/counter.css");
		
		wp_enqueue_style('counterCss');
	}

}