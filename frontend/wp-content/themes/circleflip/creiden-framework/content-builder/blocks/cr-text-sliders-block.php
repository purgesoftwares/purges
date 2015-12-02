<?php
/* Aqua Tabs Block */
if(!class_exists('CR_Text_Sliders_Block')) {
	class CR_Text_Sliders_Block extends AQ_Block {

		function __construct() {
			$block_options = array(
				'image' => 'text_slider.png',
				'name' => 'Text Slider',
				'size' => 'span6',
                                'imagedesc' => 'text-slider.jpg',
                                'tab' => 'Content',
                                'desc' => 'A slider fot text blocks.'
			);

			//create the widget
			parent::__construct('CR_Text_Sliders_Block', $block_options);

			//add ajax functions
			add_action('wp_ajax_aq_block_text_slider_add_new', array($this, 'add_text_slider_tab'));
		}

		function form($instance) {

			$defaults = array(
				'tabs' => array(
					1 => array(
						'title' => 'New Slide',
						'content' => 'My slide text',
					)
				),
				'type'	=> 'tab',
				'entrance_animation' => ''
			);

			$instance = wp_parse_args($instance, $defaults);
			extract($instance);

			?>
			<div class="description cf">
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
				<a href="#" rel="text_slider" class="aq-sortable-add-new button">Add New</a>
				<p></p>
			</div>
			<?php
		}

		function tab($tab = array(), $count = 0) {

			?>
			<li id="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-sortable-item-<?php echo esc_attr($count) ?>" class="sortable-item" rel="<?php echo esc_attr($count) ?>">

				<div class="sortable-head cf">
					<div class="sortable-title">
						<strong><?php echo esc_html($tab['title']) ?></strong>
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
							<label for="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-title">
								Slide Title
							</label>
						</span>
						<span class="rightHalf">
							<input type="text" id="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-title" class="input-full" name="<?php echo esc_attr( $this->get_field_name('tabs') ) ?>[<?php echo esc_attr($count) ?>][title]" value="<?php echo esc_attr($tab['title']) ?>" />
						</span>
					</p>
					<p class="tab-desc description">
						<span class="leftHalf">
							<label for="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-content">
								Slide Text
							</label>
						</span>
						<span class="rightHalf">
							<textarea id="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-content" class="textarea-full" name="<?php echo esc_attr( $this->get_field_name('tabs') ) ?>[<?php echo esc_attr($count) ?>][content]" rows="5"><?php echo esc_attr($tab['content']) ?></textarea>
						</span>
					</p>
				</div>

			</li>
			<?php
		}

		function block($instance) {
			extract($instance);
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
				$titleIconHead = '<div class="headerDot"><span class="'.esc_attr($iconHead).'"></span></div>';
			}
			$this->textsliders_method();
			$output = '';
				$output .= '<div id="myCarousel" class="carousel slide textSlider carousel-fade  animateCr '.esc_attr($entrance_animation).'"><div class="carousel-inner">';
					$i = 0;
					foreach($tabs as $tab) {
						$tab_selected = $i == 0 ? 'active' : '';
						$prev_next = count($tabs) > 1 ? '<a class="left carousel-control" href="#myCarousel" data-slide="prev"></a><a class="right carousel-control" href="#myCarousel" data-slide="next"></a>' : '';
						$output .= '<div class="item '.esc_attr($tab_selected).'"> <h3>'. $titleIconHead . $tab['title'].'</h3><div class="carousel-caption">'. wpautop(do_shortcode(htmlspecialchars_decode($tab['content']))) .'</div></div>';

						$i++;
					}
				$output .= '</div>'.$prev_next.'</div>';
				//wp_register_style('tabs', get_template_directory_uri() . '/css/content-builder/text_slider.css');

			echo $output;
		}
		function textsliders_method() {
			wp_register_style('textSliderCSS',get_template_directory_uri() . "/css/content-builder/text_slider.css");
			wp_enqueue_style('textSliderCSS');
			wp_register_script('textSliderJS',get_template_directory_uri() . "/scripts/modules/builder_text_slider.js",array('jquery'),'2.0.3',true);
			wp_enqueue_script('textSliderJS');
		}
		/* AJAX add tab */
		function add_text_slider_tab() {
			// $nonce = $_POST['security'];
			// if (! wp_verify_nonce($nonce, 'aqpb-settings-page-nonce') ) die('-1');

			$count = isset($_POST['count']) ? absint($_POST['count']) : false;
			$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'aq-block-9999';

			//default key/value for the tab
			$tab = array(
				'title' => 'New Slide',
				'content' => 'My slide text'
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
	}
}
