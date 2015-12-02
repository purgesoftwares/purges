<?php
/* Aqua Tabs Block */
if(!class_exists('CR_Faq_Block')) {
	class CR_Faq_Block extends AQ_Block {

		function __construct() {
			$block_options = array(
				'image' => 'faq.png',
				'name' => 'FAQ',
                            	'size' => 'span6',
                                'tab' => 'Content',
                                'imagedesc' => 'faq.jpg',
                                'desc' => 'Displays FAQs in accordion tabs, with category filters.'
			);

			//create the widget
			parent::__construct('CR_Faq_Block', $block_options);

			//add ajax functions
			add_action('wp_ajax_aq_block_faq_add_new', array($this, 'add_tab'));
		}

		function form($instance) {

			$defaults = array(
				'tabs' => array(
					1 => array(
						'question' =>'Question',
						'answer' => 'Answer',
						'category' =>'Category',
						'entrance_animation' => ''
					)
				),
				'type'	=> 'tab',
				'entrance_animation' => ''
			);

			$instance = wp_parse_args($instance, $defaults);
			extract($instance);
			?>
			<div class="description cf">
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
				<br />
				<a href="#" rel="faq" class="aq-sortable-add-new button">Add New</a>
				<br />
			</div>
			<?php
		}

		function tab($tab = array(), $count = 0) {

			?>
			<li id="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-sortable-item-<?php echo esc_attr($count) ?>" class="sortable-item" rel="<?php echo esc_attr($count) ?>">

				<div class="sortable-head cf">
					<div class="sortable-title">
						<strong><?php echo "FAQ " .$count; ?></strong>
					</div>
					<div class="sortable-handle">
						<a href="#">Open / Close</a>
					</div>
				</div>

				<div class="sortable-body">
					<p class="tab-desc description">
						<span class="leftHalf">
							<label for="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-question">
								Question
							</label>
							<span class="description_text">
								Write the question here.
							</span>
						</span>
						<span class="rightHalf">
							<input type="text" id="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-question" class="input-full" name="<?php echo esc_attr( $this->get_field_name('tabs') ) ?>[<?php echo esc_attr($count) ?>][question]" value="<?php echo esc_attr($tab['question']) ?>" />
						</span>
					</p>
					<p class="tab-desc description">
						<span class="leftHalf">
							<label for="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-answer">
								Answer
							</label>
							<span class="description_text">
								Write Answer here.
							</span>
						</span>
						<span class="rightHalf">
							<textarea id="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-answer" class="textarea-full" name="<?php echo esc_attr( $this->get_field_name('tabs') ) ?>[<?php echo esc_attr($count) ?>][answer]" rows="5"><?php echo esc_attr($tab['answer']) ?></textarea>
						</span>
					</p>
					<p class="tab-desc description">
						<span class="leftHalf">
							<label for="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-category">
								Category
							</label>
							<span class="description_text">
								Write the category of this question.
							</span>
						</span>
						<span class="rightHalf">
							<input type="text" id="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-category" class="input-full" name="<?php echo esc_attr( $this->get_field_name('tabs') ) ?>[<?php echo esc_attr($count) ?>][category]" value="<?php echo esc_attr($tab['category']) ?>" />
						</span>
					</p>
					<p class="tab-desc description"><a href="#" class="sortable-delete">Delete</a></p>
				</div>

			</li>
			<?php
		}

		function block($instance) {
			$defaults = array(
				'tabs' => array(
					1 => array(
						'question' =>'Question',
						'answer' => 'Answer',
						'category' =>'Category',
						'entrance_animation' => ''
					)
				),
				'type'	=> 'tab',
				'entrance_animation' => ''
			);

			$instance = wp_parse_args($instance, $defaults);
			extract($instance);
			$this->enqueue_scripts();
			$nav_categories = array();
			foreach ( $tabs as $tab ) {
				$nav_categories = array_merge( $nav_categories, explode( ',', $tab['category'] ) );
			}
			$nav_categories = array_map( 'strtolower', $nav_categories );
			$nav_categories = array_map( 'trim', $nav_categories );
			$nav_categories = array_unique( $nav_categories );
			if($entrance_animation == 'default') {
				$entrance_animation = cr_get_option('block_animations');
			}
			?>
			<div class="animateCr <?php echo esc_attr($entrance_animation) ?>">
				<div class="row faqContainer">
					<!-- CATEGORY FILTERS -->
					<ul class="<?php echo(esc_attr($size)); ?> clearfix filter-options">
						<li class="active faqNavList" data-dimension="category" data-filter="*"><?php echo _e('All','circleflip-builder'); ?></li>
						<?php foreach($nav_categories as $v) : ?>
							<?php $categories = array_map( 'strtolower', explode( ',', $v ) ); ?>
								<?php $categories = array_map( 'trim', $categories ); ?>
								<?php $categories = array_map( 'sanitize_title_with_dashes', $categories ); ?>
							<li class="faqNavList" data-dimension="category" data-filter=".category-<?php echo esc_attr(urldecode($categories[0])) ?>">
								<?php echo urldecode($categories[0]); ?>
							</li>
						<?php endforeach; ?>
					</ul>
					<?php foreach( $tabs as $tab ) : ?>
						<?php $categories = array_map( 'strtolower', explode( ',', $tab['category'] ) ); ?>
						<?php $categories = array_map( 'trim', $categories ); ?>
						<?php $categories = array_map( 'sanitize_title_with_dashes', $categories ); ?>
						<div class="<?php echo($size); ?> faqItem category-<?php echo urldecode(implode(' category-', (array) $categories))?>">
							<div class="aq_block_toggles_wrapper">
								<div class="aq_block_toggle">
									<h6 class="tab-head clearfix"><?php echo $tab['question'] ?><div><span></span></div></h6>
									<div class="tab-body closeTab cf">
										<p><?php echo do_shortcode(htmlspecialchars_decode($tab['answer'])); ?></p>
									</div>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
					<div class="span12 m-span3 shuffle__sizer"></div>
				</div>
			</div>
			<?php
		}

		function enqueue_scripts(){
			wp_register_style('faqCSS',get_template_directory_uri() . "/css/content-builder/faq_block.css");
			wp_enqueue_style('faqCSS');
			wp_enqueue_script('circleflip-isotope');
			wp_register_script('faqJS',get_template_directory_uri() . "/scripts/modules/faq_block.js",array('jquery'),'2.0.3',true);
			wp_enqueue_script('faqJS');
			wp_register_script('tabs_acc_toggles_JS',get_template_directory_uri() . "/scripts/modules/builder_tabbed_acc_toggle.js",array('jquery'),'2.0.3',true);
			wp_enqueue_script('tabs_acc_toggles_JS');
		}

		/* AJAX add tab */
		function add_tab() {
			$count = isset($_POST['count']) ? absint($_POST['count']) : false;
			$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'aq-block-9999';

			//default key/value for the tab
			$tab = array(
				'question' =>'Question',
				'answer' => 'Answer',
				'category' =>'Category'
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
