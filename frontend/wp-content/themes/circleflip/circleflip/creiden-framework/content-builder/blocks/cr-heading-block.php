<?php

/** A simple text block **/
class CR_Heading_Block extends AQ_Block {

	//set and create block
	function __construct() {
		$block_options = array(
			'image'=> 'heading.png',
			'name' => 'Heading',
			'size' => 'span6',
                        'imagedesc' => 'heading.jpg',
                        'tab' => 'Content',
                        'desc' => 'Headings from H1 through H6.'
		);
		//create the block
		parent::__construct('cr_heading_block', $block_options);
	}
	function form($instance) {

		$defaults = array(
			'heading' => '',
			'align' => '',
			'custom_image' => '',
			'entrance_animation' => '',
			'headcolor' => '#2a2a2a',
			'headMarginBottom' => '20'
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);

		?>
		<p class="description">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('heading') ) ?>">
					Heading Text
				</label>
				<span class="description_text">
					Write your heading text.
				</span>
			</span>
			<span class="rightHalf">
				<?php echo circleflip_field_input('heading', $block_id, $heading, $size = 'full') ?>
			</span>
		</p>
		<p class="description">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('headsize') ) ?>">
					Heading Size
				</label>
				<span class="description_text">
					Choose the size.
				</span>
			</span>
			<span class="rightHalf">
				<span class="rightHalf select">
					<?php $head_array = array('h1','h2','h3','h4','h5','h6'); ?>
					<?php echo circleflip_field_select('headsize', $block_id, $head_array, isset($headsize) ? $headsize : 'h1') ?>
				</span>
			</span>
		</p>
		<div class="description">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('headcolor') ) ?>">
					Heading Color
				</label>
				<span class="description_text">
					Choose the color.
				</span>
			</span>
			<span class="rightHalf">
				<?php echo circleflip_field_color_picker('headcolor', $block_id, $headcolor, $defaults['headcolor']) ?>
			</span>
		</div>
		<p class="description headingSelect">
			<span class="leftHalf">
			<label for="<?php echo esc_attr( $this->get_field_id('type') ) ?>">
				Heading Type
			</label>
			</span>
			<span class="rightHalf">
				<span class="rightHalf select">
					<?php echo circleflip_field_select('type', $block_id, array('Without Default Icon','With Default Icon','Choose Your Icon'), isset($type) ? $type : 'without dot', array('data-fd-handle="type"')) ?>
				</span>
			</span>
		</p>
		<div class="description ButtonIcon iconselector" data-fd-rules='["type:equal:2"]'>
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('custom_icon') ) ?>">
					Custom Icon
				</label>
				<span class="description_text">
					Choose your heading icon.
				</span>
			</span>
			<span class="rightHalf icons">
				<?php $icon_option = array('icon-plus','icon-minus','icon-info','icon-left-thin','icon-up-thin','icon-right-thin','icon-down-thin','icon-level-up','icon-level-down','icon-switch','icon-infinity','icon-plus-squared','icon-minus-squared','icon-home','icon-keyboard','icon-erase','icon-pause','icon-fast-forward','icon-fast-backward','icon-to-end','icon-to-start','icon-hourglass','icon-stop','icon-up-dir','icon-play','icon-right-dir','icon-down-dir','icon-left-dir','icon-adjust','icon-cloud','icon-star','icon-star-empty','icon-cup','icon-menu','icon-moon','icon-heart-empty','icon-heart','icon-note','icon-note-beamed','icon-layout','icon-flag','icon-tools','icon-cog','icon-attention','icon-flash','icon-record','icon-cloud-thunder','icon-tape','icon-flight','icon-mail','icon-pencil','icon-feather','icon-check','icon-cancel','icon-cancel-circled','icon-cancel-squared','icon-help','icon-quote','icon-plus-circled','icon-minus-circled','icon-right','icon-direction','icon-forward','icon-ccw','icon-cw','icon-left','icon-up','icon-down','icon-list-add','icon-list','icon-left-bold','icon-right-bold','icon-up-bold','icon-down-bold','icon-user-add','icon-help-circled','icon-info-circled','icon-eye','icon-tag','icon-upload-cloud','icon-reply','icon-reply-all','icon-code','icon-export','icon-print','icon-retweet','icon-comment','icon-chat','icon-vcard','icon-address','icon-location','icon-map','icon-compass','icon-trash','icon-doc','icon-doc-text-inv','icon-docs','icon-doc-landscape','icon-archive','icon-rss','icon-share','icon-basket','icon-shareable','icon-login','icon-logout','icon-volume','icon-resize-full','icon-resize-small','icon-popup','icon-publish','icon-window','icon-arrow-combo','icon-chart-pie','icon-language','icon-air','icon-database','icon-drive','icon-bucket','icon-thermometer','icon-down-circled','icon-left-circled','icon-right-circled','icon-up-circled','icon-down-open','icon-left-open','icon-right-open','icon-up-open','icon-down-open-mini','icon-left-open-mini','icon-right-open-mini','icon-up-open-mini','icon-down-open-big','icon-left-open-big','icon-right-open-big','icon-up-open-big','icon-progress-0','icon-progress-1','icon-progress-2','icon-progress-3','icon-back-in-time','icon-network','icon-inbox','icon-install','icon-lifebuoy','icon-mouse','icon-dot','icon-dot-2','icon-dot-3','icon-suitcase','icon-flow-cascade','icon-flow-branch','icon-flow-tree','icon-flow-line','icon-flow-parallel','icon-brush','icon-paper-plane','icon-magnet','icon-gauge','icon-traffic-cone','icon-cc','icon-cc-by','icon-cc-nc','icon-cc-nc-eu','icon-cc-nc-jp','icon-cc-sa','icon-cc-nd','icon-cc-pd','icon-cc-zero','icon-cc-share','icon-cc-remix','icon-github','icon-github-circled','icon-flickr','icon-flickr-circled','icon-vimeo','icon-vimeo-circled','icon-twitter','icon-twitter-circled','icon-facebook','icon-facebook-circled','icon-facebook-squared','icon-gplus','icon-gplus-circled','icon-pinterest','icon-pinterest-circled','icon-tumblr','icon-tumblr-circled','icon-linkedin','icon-linkedin-circled','icon-dribbble','icon-dribbble-circled','icon-stumbleupon','icon-stumbleupon-circled','icon-lastfm','icon-lastfm-circled','icon-rdio','icon-rdio-circled','icon-spotify','icon-spotify-circled','icon-qq','icon-instagram','icon-dropbox','icon-evernote','icon-flattr','icon-skype','icon-skype-circled','icon-renren','icon-sina-weibo','icon-paypal','icon-picasa','icon-soundcloud','icon-mixi','icon-behance','icon-google-circles','icon-vkontakte','icon-smashing','icon-db-shape','icon-sweden','icon-logo-db','icon-picture','icon-globe','icon-leaf','icon-graduation-cap','icon-mic','icon-palette','icon-ticket','icon-video','icon-target','icon-music','icon-trophy','icon-thumbs-up','icon-thumbs-down','icon-bag','icon-user','icon-users','icon-lamp','icon-alert','icon-water','icon-droplet','icon-credit-card','icon-monitor','icon-briefcase','icon-floppy','icon-cd','icon-folder','icon-doc-text','icon-calendar','icon-chart-line','icon-chart-bar','icon-clipboard','icon-attach','icon-bookmarks','icon-book','icon-book-open','icon-phone','icon-megaphone','icon-upload','icon-download','icon-box','icon-newspaper','icon-mobile','icon-signal','icon-camera','icon-shuffle','icon-loop','icon-arrows-ccw','icon-light-down','icon-light-up','icon-mute','icon-sound','icon-battery','icon-search','icon-key','icon-lock','icon-lock-open','icon-bell','icon-bookmark','icon-link','icon-back','icon-flashlight','icon-chart-area','icon-clock','icon-rocket','icon-block','icon-basket');?>
				<?php echo circleflip_field_radioButtonIcon('custom_icon', $block_id, $icon_option , isset($custom_icon) ? $custom_icon : ''); ?>
			</span>
		</div>
		<p class="description">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('align') ) ?>">
					Heading Align
				</label>
				<span class="description_text">
				</span>
			</span>
			<span class="rightHalf">
				<span class="rightHalf select">
					<?php $align_array = array('left','center','right'); ?>
					<?php echo circleflip_field_select('align', $block_id, $align_array, isset($align) ? $align : 'left') ?>
				</span>
			</span>
		</p>
		<p class="description">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('headMarginBottom') ) ?>">
					Heading Margin Bottom
				</label>
				<span class="description_text">
				</span>
			</span>
			<span class="rightHalf">
				<?php echo circleflip_field_input('headMarginBottom', $block_id, $headMarginBottom, 'min', 'number') ?> px
			</span>
		</p>
		<p class="description">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('weight') ) ?>">
					font-style
				</label>
				<span class="description_text">
					Choose font style.
				</span>
			</span>
			<span class="rightHalf">
				<span class="rightHalf select">
					<?php $weight_array = array('normal','bold'); ?>
					<?php echo circleflip_field_select('weight', $block_id, $weight_array, isset($weight) ? $weight : 'left') ?>
				</span>
			</span>
		</p>
		<p class="description half">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('entrance_animation') ) ?>">
					On-Scroll Animation
				</label>
				<span class="description_text">
					Choose the heading scroll animation.
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
		function title_method(){
			wp_register_style('titleCSS',get_template_directory_uri() . "/css/content-builder/title.css");
			wp_enqueue_style('titleCSS');
		}

	function block($instance) {
		$head_array = array('h1','h2','h3','h4','h5','h6');
		$align_array = array('left','center','right');
		$weight_array = array('normal','bold');
		extract($instance);
		if($entrance_animation == 'default') {
			$entrance_animation = cr_get_option('block_animations');
		}
		$this->title_method();
		$class = "";
		switch ($type) {
			case '0':
				$class ='withoutDot';
			break;
			case '1':
				$class ='headerDot';
				break;
			case '2':
				$class ='custom';
				break;
			default:
				$class ='withOutDot';
				break;
		}
		if(isset($headsize)) {
			$tag = $head_array[$headsize];
		}
		?>
		<div class="animateCr <?php echo esc_attr($entrance_animation) ?>"></div>
		<?php
			if(cr_get_option('rtl') == '1') { ?>
			<<?php echo tag_escape($tag); ?> class="<?php echo esc_attr($align_array[$align]); ?> <?php echo esc_attr($weight_array[$weight]) ?> " style="margin-bottom:<?php echo esc_attr($headMarginBottom); ?>px;color:<?php echo esc_attr($headcolor) ?>">
				
					<?php echo do_shortcode(htmlspecialchars_decode($heading)); ?><div class="<?php echo esc_attr($class); if($class == 'custom' ){echo ' headerDot';} ?>"><span class="<?php if($class == 'custom'){ echo esc_attr($custom_icon); }else{ if($class != 'withoutDot'){ if(( defined( 'ICL_LANGUAGE_CODE' ) && 'ar' === ICL_LANGUAGE_CODE) ) { echo 'icon-left-open-mini'; }else{ echo 'icon-right-open-mini'; } } } ?>"></span></div>
				</<?php echo tag_escape($tag); ?>>
		<?php } else{ ?>
			<<?php echo tag_escape($tag); ?> class="align<?php echo esc_attr($align_array[$align]); ?> <?php echo esc_attr($weight_array[$weight]) ?>" style="margin-bottom:<?php echo esc_attr($headMarginBottom); ?>px;color:<?php echo esc_attr($headcolor) ?>">
				<div class="<?php echo esc_attr($class); if($class == 'custom' ){echo ' headerDot';} ?>"><span class="<?php if($class == 'custom'){ echo esc_attr($custom_icon); }else{ if($class != 'withoutDot'){ if(( defined( 'ICL_LANGUAGE_CODE' ) && 'ar' === ICL_LANGUAGE_CODE) ) { echo 'icon-left-open-mini'; }else{ echo 'icon-right-open-mini'; } } } ?>"></span></div><?php echo do_shortcode(htmlspecialchars_decode($heading)); ?>
			</<?php echo tag_escape($tag); ?>>
			
		<?php } ?>
		<?php
	}
}