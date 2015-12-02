<?php
/** A simple List block **/
class CR_List_Block extends AQ_Block {

	//set and create block
	function __construct() {
		$block_options = array(
			'image' => 'list.png',
			'name' => 'List',
			'size' => 'span6',
                        'imagedesc' => 'list.jpg',
                        'tab' => 'Content',
                        'desc' => 'Used to add a text list to your page.'
		);

		//create the block
		parent::__construct('cr_list_block', $block_options);
		//add ajax functions
		add_action('wp_ajax_aq_block_list_add_new', array($this, 'add_list'));
	}

	function form($instance) {

		$defaults = array(
			'text' => '',
			'entrance_animation' => '',
			'lists' => array(
					0 => array(
						'text' => 'New Text'
					)
			)
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);

		?>
		<ul id="aq-sortable-list-<?php echo esc_attr($block_id) ?>" class="aq-sortable-list" rel="<?php echo esc_attr($block_id) ?>">
			<?php
			$lists = is_array($lists) ? $lists : $defaults['lists'];
			$count = 1;
			foreach($lists as $list) {
				$this->listItem($list, $count);
				$count++;
			}
			?>
		</ul>
		<p></p>
		<a href="#" rel="list" class="aq-sortable-add-new button">Add New</a>
		<p></p>
		<div class="description ButtonIcon iconselector">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('shape') ) ?>">
					Icon
				</label>
			</span>
			<span class="rightHalf">
				<span class="rightHalf icons">
					<?php $icon_option = array('icon-plus','icon-minus','icon-info','icon-left-thin','icon-up-thin','icon-right-thin','icon-down-thin','icon-level-up','icon-level-down','icon-switch','icon-infinity','icon-plus-squared','icon-minus-squared','icon-home','icon-keyboard','icon-erase','icon-pause','icon-fast-forward','icon-fast-backward','icon-to-end','icon-to-start','icon-hourglass','icon-stop','icon-up-dir','icon-play','icon-right-dir','icon-down-dir','icon-left-dir','icon-adjust','icon-cloud','icon-star','icon-star-empty','icon-cup','icon-menu','icon-moon','icon-heart-empty','icon-heart','icon-note','icon-note-beamed','icon-layout','icon-flag','icon-tools','icon-cog','icon-attention','icon-flash','icon-record','icon-cloud-thunder','icon-tape','icon-flight','icon-mail','icon-pencil','icon-feather','icon-check','icon-cancel','icon-cancel-circled','icon-cancel-squared','icon-help','icon-quote','icon-plus-circled','icon-minus-circled','icon-right','icon-direction','icon-forward','icon-ccw','icon-cw','icon-left','icon-up','icon-down','icon-list-add','icon-list','icon-left-bold','icon-right-bold','icon-up-bold','icon-down-bold','icon-user-add','icon-help-circled','icon-info-circled','icon-eye','icon-tag','icon-upload-cloud','icon-reply','icon-reply-all','icon-code','icon-export','icon-print','icon-retweet','icon-comment','icon-chat','icon-vcard','icon-address','icon-location','icon-map','icon-compass','icon-trash','icon-doc','icon-doc-text-inv','icon-docs','icon-doc-landscape','icon-archive','icon-rss','icon-share','icon-basket','icon-shareable','icon-login','icon-logout','icon-volume','icon-resize-full','icon-resize-small','icon-popup','icon-publish','icon-window','icon-arrow-combo','icon-chart-pie','icon-language','icon-air','icon-database','icon-drive','icon-bucket','icon-thermometer','icon-down-circled','icon-left-circled','icon-right-circled','icon-up-circled','icon-down-open','icon-left-open','icon-right-open','icon-up-open','icon-down-open-mini','icon-left-open-mini','icon-right-open-mini','icon-up-open-mini','icon-down-open-big','icon-left-open-big','icon-right-open-big','icon-up-open-big','icon-progress-0','icon-progress-1','icon-progress-2','icon-progress-3','icon-back-in-time','icon-network','icon-inbox','icon-install','icon-lifebuoy','icon-mouse','icon-dot','icon-dot-2','icon-dot-3','icon-suitcase','icon-flow-cascade','icon-flow-branch','icon-flow-tree','icon-flow-line','icon-flow-parallel','icon-brush','icon-paper-plane','icon-magnet','icon-gauge','icon-traffic-cone','icon-cc','icon-cc-by','icon-cc-nc','icon-cc-nc-eu','icon-cc-nc-jp','icon-cc-sa','icon-cc-nd','icon-cc-pd','icon-cc-zero','icon-cc-share','icon-cc-remix','icon-github','icon-github-circled','icon-flickr','icon-flickr-circled','icon-vimeo','icon-vimeo-circled','icon-twitter','icon-twitter-circled','icon-facebook','icon-facebook-circled','icon-facebook-squared','icon-gplus','icon-gplus-circled','icon-pinterest','icon-pinterest-circled','icon-tumblr','icon-tumblr-circled','icon-linkedin','icon-linkedin-circled','icon-dribbble','icon-dribbble-circled','icon-stumbleupon','icon-stumbleupon-circled','icon-lastfm','icon-lastfm-circled','icon-rdio','icon-rdio-circled','icon-spotify','icon-spotify-circled','icon-qq','icon-instagram','icon-dropbox','icon-evernote','icon-flattr','icon-skype','icon-skype-circled','icon-renren','icon-sina-weibo','icon-paypal','icon-picasa','icon-soundcloud','icon-mixi','icon-behance','icon-google-circles','icon-vkontakte','icon-smashing','icon-db-shape','icon-sweden','icon-logo-db','icon-picture','icon-globe','icon-leaf','icon-graduation-cap','icon-mic','icon-palette','icon-ticket','icon-video','icon-target','icon-music','icon-trophy','icon-thumbs-up','icon-thumbs-down','icon-bag','icon-user','icon-users','icon-lamp','icon-alert','icon-water','icon-droplet','icon-credit-card','icon-monitor','icon-briefcase','icon-floppy','icon-cd','icon-folder','icon-doc-text','icon-calendar','icon-chart-line','icon-chart-bar','icon-clipboard','icon-attach','icon-bookmarks','icon-book','icon-book-open','icon-phone','icon-megaphone','icon-upload','icon-download','icon-box','icon-newspaper','icon-mobile','icon-signal','icon-camera','icon-shuffle','icon-loop','icon-arrows-ccw','icon-light-down','icon-light-up','icon-mute','icon-sound','icon-battery','icon-search','icon-key','icon-lock','icon-lock-open','icon-bell','icon-bookmark','icon-link','icon-back','icon-flashlight','icon-chart-area','icon-clock','icon-rocket','icon-block','icon-basket'); ?>
					<?php echo circleflip_field_radioButtonIcon('iconList', $block_id, $icon_option , isset($iconList) ? $iconList : 'icon-spin3') ?>
				</span>
			</span>
		</div>
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
	function listItem($list = array(), $count = 0) {
			?>
			<li id="<?php echo esc_attr( $this->get_field_id('lists') ) ?>-sortable-item-<?php echo esc_attr($count) ?>" class="sortable-item" rel="<?php echo esc_attr($count) ?>">

				<div class="sortable-head cf">
					<div class="sortable-title">
						<strong><?php echo esc_html($list['text']) ?></strong>
					</div>
					<div class="sortable-out-delete">
						<span></span>
					</div>
					<div class="sortable-handle">
						<a href="#">Open / Close</a>
					</div>
				</div>
				<div class="sortable-body">
					<p class="tab-desc description">
						<span class="leftHalf">
							<label for="<?php echo esc_attr( $this->get_field_id('lists') ) ?>-<?php echo esc_attr($count) ?>-text">
								list Text
							</label>
						</span>
						<span class="rightHalf">
							<input type="text" id="<?php echo esc_attr( $this->get_field_id('lists') ) ?>-<?php echo esc_attr($count) ?>-text" class="input-full" name="<?php echo esc_attr( $this->get_field_name('lists') ) ?>[<?php echo esc_attr($count) ?>][text]" value="<?php echo esc_attr($list['text']) ?>" />
						</span>
					</p>
				</div>
			</li>
			<?php
		}
		/* AJAX add list */
		function add_list() {
			$count = isset($_POST['count']) ? absint($_POST['count']) : false;
			$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'aq-block-9999';

			//default key/value for the tab
			$list = array(
				'text' => 'New Text'
			);
			if($count) {
				$this->listItem($list, $count);
			} else {
				die(-1);
			}

			die();
		}
	function block($instance) {
		extract($instance);
		if($entrance_animation == 'default') {
			$entrance_animation = cr_get_option('block_animations');
		}
		$icon_class = '';
		if(isset($iconList)) {
				$icon_class .= $iconList .' ';
		}
		$isIcon = '';
		if($iconList != 'none' && $iconList != ''){
			$isIcon = 'iconList';
		}
		echo "<ul class='listStyleImage'>";
		foreach ($lists as $key => $value) {
			echo '<li class="'.esc_attr($icon_class.' '.$isIcon.' animateCr '.$entrance_animation).'"><p>'.do_shortcode(htmlspecialchars_decode($value['text'])).'</p></li>';
		}

		echo "</ul>";
	}

	function update($new_instance, $old_instance) {
			$new_instance = circleflip_recursive_sanitize($new_instance);
			return $new_instance;
		}

}