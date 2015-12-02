<?php
/** A simple text block **/
class CR_Carousel_Block extends AQ_Block {

	//set and create block
	function __construct() {
		$block_options = array(
			'image' => 'carousel.png',
			'name' => 'Carousel',
			'size' => 'span6',
                        'imagedesc' => 'carousel.jpg',
                        'tab' => 'media',
                	'desc' => 'A type of an image slider, where images are draged sideways.'
		);

		//create the block
		parent::__construct('cr_carousel_block', $block_options);
		add_action('wp_ajax_aq_block_carousel_add_new', array($this, 'add_tab'));
	}

	function form($instance) {

		$defaults = array(
			'tabs' => array(
				1 => array(
					'link' => '#',
					'content' => 'My tab contents',
					'image' => '',
					'imagesrc' => ''
				)
			),
			'type'	=> 'tab',
			'entrance_animation' => ''
		);


		$instance = wp_parse_args($instance, $defaults);
		extract($instance);

		$tab_types = array(
			'tab' => 'Tabs',
			'toggle' => 'Toggles',
			'accordion' => 'Accordion'
		);
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
		?>
		<p class="description">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('title') ) ?>">
					Section Title
				</label>
			</span>
			<span class="rightHalf">
				<?php echo circleflip_field_input('title', $block_id, $title, $size = 'full') ?>
			</span>
		</p>
		<p class="description">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('titleIcon') ) ?>">
					Title Icon:
				</label>
			</span>
			<span class="rightHalf">
				<span class="rightHalf select">
					<?php $titleIconOption = array('without Icon','with Icon'); ?>
					<?php echo circleflip_field_select('titleIcon', $block_id, $titleIconOption, isset($titleIcon) ? $titleIcon : 'without Icon') ?>
				</span>
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
		<div class="description cf">
			<ul id="aq-sortable-list-<?php echo esc_attr($block_id) ?>" class="aq-sortable-list" rel="<?php echo esc_attr($block_id) ?>">
				<?php
				$tabs = is_array($tabs) ? $tabs : $defaults['tabs'];
				$count = 1;
				foreach($tabs as $tab) {
					$this->tab($tab, $count);
					$count++;
				}
				?>
			</ul>
			<p></p>
			<a href="#" rel="carousel" class="aq-sortable-add-new button">Add New</a>
			<p></p>
		</div>
		<?php
	}

	function tab($tab = array(), $count = 0) {

			?>
			<li id="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-sortable-item-<?php echo esc_attr($count) ?>" class="sortable-item" rel="<?php echo esc_attr($count) ?>">

				<div class="sortable-head cf">
					<div class="sortable-title">
						<strong>Item</strong>
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
							<label for="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-link">
								Image Link
							</label>
							<span class="description_text">
								Add a link for the image when it's clicked. 
							</span>
						</span>
						<span class="rightHalf">
							<input type="text" id="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-link" class="input-full" name="<?php echo esc_attr( $this->get_field_name('tabs') ) ?>[<?php echo esc_attr($count) ?>][link]" value="<?php echo esc_attr($tab['link']) ?>" />
						</span>
					</p>
					<p class="description">
						<span class="leftHalf">
							<label for="<?php echo esc_attr( $this->get_field_id('image_upload') ) ?>-<?php echo esc_attr($count) ?>-image">
								Image
								<?php
									if(isset($tab['image']) && !empty($tab['image']))
										{
											$tab_image = $tab['image'];
											$carousel_img_id = $tab['imagesrc'];
										}
									else {
										$tab_image = '';
										$carousel_img_id = '';
									}
								?>
							</label>
							<span class="description_text">
								Upload image.
							</span>
						</span>
						<span class="rightHalf">
							<img class="screenshot" src="<?php echo esc_url($tab_image); ?>" alt=""/>
							<input type="hidden" id="<?php echo esc_attr( $this->get_field_id('image_upload') ) ?>-<?php echo esc_attr($count) ?>-imagesrc" name="<?php echo esc_attr( $this->get_field_name('tabs') ) ?>[<?php echo esc_attr($count) ?>][imagesrc]" value=<?php echo esc_attr($carousel_img_id)  ?> />
							<input type="text" id="<?php echo esc_attr( $this->get_field_id('image_upload') ) ?>-<?php echo esc_attr($count) ?>-image" class="input-full input-upload" value="<?php echo esc_attr($tab_image) ?>" name="<?php echo esc_attr( $this->get_field_name('tabs') ) ?>[<?php echo esc_attr($count) ?>][image]">
							<a href="#" class="aq_upload_button button" rel="image">Upload</a>
							<a href="#" class="remove_image button" rel="image">Remove</a>
						</span>
					</p>
				</div>

			</li>
			<?php
		}

	function block($instance) {
		extract($instance);
		$this->carousel();
		if($entrance_animation == 'default') {
			$entrance_animation = cr_get_option('block_animations');
		}
		$titleIconClass;
		switch($titleIcon){
			case 0:
				$titleIconClass = 'withoutIcon';
				break;
			case 1:
				$titleIconClass = 'withIcon';
				break;
			default:
				$titleIconClass = 'withoutIcon';
		}
		$titleIconHead = '';
		if($titleIconClass == 'withIcon'){
			$iconHead;
			if(( defined( "ICL_LANGUAGE_CODE" ) && "ar" === ICL_LANGUAGE_CODE) ) {
				 $iconHead = "icon-left-open-mini"; 
			}else{
				 $iconHead = "icon-right-open-mini"; 
			}
			$titleIconHead = '<div class="headerDot"><span class="'. esc_attr($iconHead) .'"></span></div>';
		}
		?>
		<?php if($title != null){?>
		<div class="CirclePosts titleBlock">
			<h3>
				<?php echo $titleIconHead . esc_html( $title ) ?>
			</h3>
		</div>
		<?php } ?>
		<div class="list_carousel responsive">
			<ul class="carouselHome">
				<?php foreach( $tabs as $tab ) {?>
				<li class="animateCr <?php echo esc_attr($entrance_animation);  ?>">
					<?php if(isset($tab['link']) && !empty($tab['link'])) { ?>
						<a href="<?php echo esc_url($tab['link']); ?>">
					<?php } ?>
						<?php echo wp_get_attachment_image($tab['imagesrc'],'carousel_home_block'); ?>
					<?php if(isset($tab['link']) && !empty($tab['link'])) { ?>
						</a>
					<?php }  ?>
				</li>
				<?php } ?>
			</ul>
			<div class="clearfix"></div>
			<a class="prev" href="#"></a>
			<a class="next" href="#"></a>
		</div>
		<?php
	}

	/* AJAX add tab */
		function add_tab() {
			$count = isset($_POST['count']) ? absint($_POST['count']) : false;
			$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'aq-block-9999';

			//default key/value for the tab
			$tab = array(
				'link' => '#',
				'image_upload' => '',
				'image' => ''
			);

			if($count) {
				$this->tab($tab, $count);
			} else {
				die(-1);
			}

			die();
		}

		function update($new_instance, $old_instance) {
			$new_instance = circleflip_recursive_sanitize($new_instance);
			return $new_instance;
		}

	function carousel() {
		wp_register_script('carouselJS',get_template_directory_uri().'/js/jquery.carouFredSel-6.2.1-packed.js',array('jquery'),'2.0.3',true);
		wp_register_script('mousewheel',get_template_directory_uri()."/js/jquery.mousewheel.min.js",array('jquery'),'2.0.3',true);
		wp_register_script('touchSwipe',get_template_directory_uri()."/js/jquery.touchSwipe.min.js",array('jquery'),'2.0.3',true);
		wp_register_script('transit',get_template_directory_uri()."/js/jquery.transit.min.js",array('jquery'),'2.0.3',true);
		wp_register_script('throttle',get_template_directory_uri()."/js/jquery.ba-throttle-debounce.min.js",array('jquery'),'2.0.3',true);

		wp_enqueue_script('carouselJS',array('jquery'),false);
		wp_enqueue_script('mousewheel');
		wp_enqueue_script('touchSwipe');
		wp_enqueue_script('transit');
		wp_enqueue_script('throttle');
	}
}