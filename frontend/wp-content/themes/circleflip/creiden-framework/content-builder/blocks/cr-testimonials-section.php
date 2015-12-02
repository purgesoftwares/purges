<?php
/* Aqua Tabs Block */
if(!class_exists('CR_Testimonials_Section')) {
	class CR_Testimonials_Section extends AQ_Block {

		function __construct() {
			$block_options = array(
				'image' => 'testimonials.png',
				'name' => 'Testimonials',
				'size' => 'span6',
                                'tab' => 'Content',
                                'imagedesc' => 'testimonials.jpg',
                                'desc' => 'Displays your testimonials with a selection of designs.'
			);

			//create the widget
			parent::__construct('CR_Testimonials_Section', $block_options);

			//add ajax functions
			add_action('wp_ajax_aq_block_testimonials_add_new', array($this, 'add_tab'));
		}

		function form($instance) {

			$defaults = array(
				'title' => 'Testimonials',
				'tabs' => array(
					1 => array(
						'text' =>'',
						'imagesrc' => '',
						'name' =>'',
						'job' => '',
					)
				),
				'type'	=> 'tab',
				'entrance_animation' => ''
			);

			$instance = wp_parse_args($instance, $defaults);
			extract($instance);

			?>
			<p class="description">
				<span class="leftHalf">
					<label for="<?php echo esc_attr( $this->get_field_id('title') ) ?>">
						Title
					</label>
					<span class="description_text">
						Write a title here
					</span>
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
			<p class="description">
				<span class="leftHalf">
					<label for="<?php echo esc_attr( $this->get_field_id('arrows') ) ?>">
						Navigation type:
					</label>
					<span class="description_text">
					</span>
				</span>
				<span class="rightHalf">
					<span class="rightHalf select">
						<?php $arrows_type = array('arrows','bullets','none'); ?>
						<?php echo circleflip_field_select('arrows', $block_id, $arrows_type, isset($arrows) ? $arrows : 'arrows') ?>
					</span>
				</span>
			</p>
			<p class="description">
				<span class="leftHalf">
					<label for="<?php echo esc_attr( $this->get_field_id('testmonial_type') ) ?>">
						Testmonials Style:
					</label>
					<span class="description_text">
					</span>
				</span>
				<span class="rightHalf">
					<span class="rightHalf select">
						<?php $test_type = array('Testmonials Style1','Testmonials Style2'); ?>
						<?php echo circleflip_field_select('testmonial_type', $block_id, $test_type, isset($testmonial_type) ? $testmonial_type : 'Testmonials Style1', array('data-fd-handle="testimonial_style"')) ?>
					</span>
				</span>
			</p>
			<p class="description" data-fd-rules='["testimonial_style:equal:0"]'>
				<img style="display: block;margin:0 auto;max-width: 100%;" src="<?php echo get_template_directory_uri(); ?>/creiden-framework/content-builder/assets/images/testimonial1.jpg" alt=""/>
			</p>
			<p class="description" data-fd-rules='["testimonial_style:equal:1"]'>
				<img style="display: block;margin:0 auto;max-width: 100%;" src="<?php echo get_template_directory_uri(); ?>/creiden-framework/content-builder/assets/images/testimonial2.jpg" alt=""/>
			</p>
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
				<a href="#" rel="testimonials" class="aq-sortable-add-new button">Add New</a>
				<br />
			</div>
			<?php
		}

		function tab($tab = array(), $count = 0) {

			?>
			<li id="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-sortable-item-<?php echo esc_attr($count) ?>" class="sortable-item" rel="<?php echo esc_attr($count) ?>">

				<div class="sortable-head cf">
					<div class="sortable-title">
						<strong><?php echo "Group " .$count; ?></strong>
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
							<label for="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-text">
								Text
							</label>
							<span class="description_text">
								Write content text here.
							</span>
						</span>
						<span class="rightHalf">
							<textarea id="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-content" class="textarea-full" name="<?php echo esc_attr( $this->get_field_name('tabs') ) ?>[<?php echo esc_attr($count) ?>][text]" rows="5"><?php echo esc_attr($tab['text']) ?></textarea>
						</span>
					</p>
					<p class="description">
						<span class="leftHalf">
							<label for="<?php echo esc_attr( $this->get_field_id('image_upload') ) ?>-<?php echo esc_attr($count) ?>-image">
								Testimonial Image
								<?php
									if(isset($tab['image']) && !empty($tab['image']))
										{
											$tab_image = $tab['image'];
											$testimonials_img_id = $tab['imagesrc'];
										}
									else {
										$tab_image = '';
										$testimonials_img_id = '';
									}
								?>
							</label>
							<span class="description_text">
								Upload your testimonial image. 
							</span>
						</span>
						<span class="rightHalf">
							<img class="screenshot" src="<?php echo esc_url($tab_image); ?>" alt=""/>
							<input type="hidden" id="<?php echo esc_attr( $this->get_field_id('image_upload') ) ?>-<?php echo esc_attr($count) ?>-imagesrc" 
								   name="<?php echo esc_attr( $this->get_field_name('tabs') ) ?>[<?php echo esc_attr($count) ?>][imagesrc]" 
								   value=<?php echo esc_attr($testimonials_img_id)  ?> />
							<input type="text" id="<?php echo esc_attr( $this->get_field_id('image_upload') ) ?>-<?php echo esc_attr($count) ?>-image" 
								   class="input-full input-upload" value="<?php echo esc_attr($tab_image) ?>" 
								   name="<?php echo esc_attr( $this->get_field_name('tabs') ) ?>[<?php echo esc_attr($count) ?>][image]">
							<a href="#" class="aq_upload_button button" rel="image">Upload</a>
							<a href="#" class="remove_image button" rel="image">Remove</a>
						</span>
					</p>
					<p class="tab-desc description">
						<span class="leftHalf">
							<label for="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-name">
								Name
							</label>
							<span class="description_text">
								Write name here.
							</span>
						</span>
						<span class="rightHalf">
							<input type="text" id="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-name" class="input-full" name="<?php echo esc_attr( $this->get_field_name('tabs') ) ?>[<?php echo esc_attr($count) ?>][name]" value="<?php echo esc_attr($tab['name']) ?>" />
						</span>
					</p>
					<p class="tab-desc description">
						<span class="leftHalf">
							<label for="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-job">
								Job
							</label>
							<span class="description_text">
								Write job here.
							</span>
						</span>
						<span class="rightHalf">
							<input type="text" id="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-job" class="input-full" name="<?php echo esc_attr( $this->get_field_name('tabs') ) ?>[<?php echo esc_attr($count) ?>][job]" value="<?php echo esc_attr($tab['job']) ?>" />
						</span>
					</p>
				</div>

			</li>
			<?php
		}

		function block($instance) {
			extract($instance);
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
				$titleIconHead = '<div class="headerDot"><span class="'.$iconHead.'"></span></div>';
			}
			if($entrance_animation == 'default') {
				$entrance_animation = cr_get_option('block_animations');
			}
			$none = ($arrows == 2) ? 'no_bullets_arrows' : '';
			$bullets_case = ($arrows ==1) ? 'bullets_case' : '';
			$arrows_html = '';
			$bullets_html = '';
			$classStyle = '';
			$titleStyle = '';
			if($testmonial_type == 0){
				$classStyle = 'TestmonialStyle2';
				$titleStyle = 'testmonialStyle2Title';
			}
			
			$title_html = (circleflip_valid($title) || $arrows == 0) ? '<div class="titleBlock"><h3 class="'.esc_attr($titleStyle).'">'.$titleIconHead . esc_html( $title ).'</h3></div>' : '';
			switch($arrows){
				case 0:{
					$arrows_html = '<a class="left carousel-control" href="#myCarousel" data-slide="prev"></a><a class="right carousel-control" href="#myCarousel" data-slide="next"></a>';
					break;
				}
				case 1:{
					$bullets_html = '<ol class="carousel-linked-nav pagination carousel-indicators">';
					$i = 1;
					$j = 0;
					foreach( $tabs as $tab ){
						$bullets_html .= ($i==1 ? '<li class="active" data-slide-to="'.$j.'"></li>' : '<li data-slide-to="'.$j.'"></li>'); 
						$i++;
						$j++;
					}
					$bullets_html .= '</ol>';
					break;
				}
				case 2:{
					break;
				}
			}
			
			$this->testimonials_method();
			$output = '';
			$i=0;
			
					$output .= '<div id="myCarousel_testimonials" class="'.$none.' '.$bullets_case.' '. $classStyle .' carousel slide testimonialsSection carousel-fade animateCr '.$entrance_animation.'">
					'.$title_html.'
					'.$arrows_html.'
					<div class="carousel-inner">';

					foreach( $tabs as $tab ){
							
						
						$active = $i == 0 ? 'active' : '';
						if($testmonial_type == 1){
							$output .= '
							<div class="item '.$active.'">
								<div class="TContainer clearfix">
									<div class="TTextContent">
										<p class="TText">'.$tab['text'].'</p>
									</div>
									<div class="testimonialsRight">
										<div class="image">' . wp_get_attachment_image( $tab['imagesrc'], 'thumbnail' ) . '</div>
										<div class="testimonialspersonnal">
											<p class="TName">'.$tab['name'].'</p>
											<p class="TJob">'.$tab['job'].'</p>
										</div>
									</div>
								</div>
							</div>
							';
						}else if($testmonial_type == 0){
							$image_cut = wp_get_attachment_image_src($tab['imagesrc'],'thumbnail2');
							$output .= '
							<div class="item '.$active.'">
								<div class="TContainer clearfix">
									<p>'.$tab['text'].'</p>
									<div class="testmoialImage">
										'.  wp_get_attachment_image( $tab['imagesrc'], 'thumbnail2' ).'
									</div>
									<div class="testimonialName"><p>'.$tab['name'].' - '.$tab['job'].'</p></div>
								</div>
							</div>';
						}
						$i++;
					}
					$output .= '</div>'.$bullets_html.'</div>';

			echo $output;
		}

		function testimonials_method(){
			wp_register_style('testimonialsCSS',get_template_directory_uri() . "/css/content-builder/testimonialsSection.css");
			wp_enqueue_style('testimonialsCSS');
			wp_register_script('testimonialsJS',get_template_directory_uri() . "/scripts/modules/builder_testimonials.js",array('jquery'),'2.0.3',true);
			wp_enqueue_script('testimonialsJS');
		}

		/* AJAX add tab */
		function add_tab() {
			// $nonce = $_POST['security'];
			// if (! wp_verify_nonce($nonce, 'aqpb-settings-page-nonce') ) die('-1');

			$count = isset($_POST['count']) ? absint($_POST['count']) : false;
			$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'aq-block-9999';

			//default key/value for the tab
			$tab = array(
				'text' =>'',
				'imagesrc' => '',
				'name' =>'',
				'job' => '',
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
