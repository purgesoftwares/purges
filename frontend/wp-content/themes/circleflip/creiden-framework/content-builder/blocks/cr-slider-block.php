<?php
/** A simple text block **/
class CR_Slider_Block extends AQ_Block {

	//set and create block
	function __construct() {
		$block_options = array(
			'image' => 'slider.png',
			'name' => 'Slider',
			'size' => 'span6',
			'home' => 'homePage',
                        'imagedesc' => 'slider.jpg',
                        'tab' => 'media',
                        'desc' => 'Adds one of your pre-designed sliders.'
		);

		//create the block
		parent::__construct('cr_slider_block', $block_options);
	}

	function form($instance) {

		$defaults = array(
			'title' => '',
			'margin_bottom' => '0px'
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);

		?>
		<p class="description">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('slider') ) ?>">
					Slider Type
				</label>
			</span>
			<span class="rightHalf">
				<span class="rightHalf select">
					<?php
						$counter = 0;
						$sliders_options = array();
						if(cr_get_option('create_slider')) {
						foreach (cr_get_option('create_slider') as $key => $value) {
							$sliders_options[$counter] = $value;
							$counter++;
						}

					 echo circleflip_field_select('slider', $block_id, $sliders_options, isset($slider) ? $slider : 'nivo_slider');

					}
					?>
				</span>
			</span>

		</p>
		<p class="description">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('margin_bottom') ) ?>">
					Margin Bottom
				</label>
			</span>
			<span class="rightHalf">
				<?php echo circleflip_field_input('margin_bottom', $block_id, $margin_bottom, 'min', 'number') ?>px
			</span>
		</p>
		<p class="description">
			<span class="leftHalf ">
				<label for="<?php echo esc_attr( $this->get_field_id('fullwidthSlider') ) ?>">
					Slider Size
				</label>
				<span class="description_text">
					Choose whether you want the slider to be limited to 1170 px (Normal Width) or to be full width.
				</span>
			</span>
			<span class="rightHalf">
				<span class="rightHalf select">
					<?php
						$sliders_options = array(
							'normalwidth' => 'Normal Width',
							'fullwidth' => 'Full Width'
						);
					?>
					<?php echo circleflip_field_select('fullwidthSlider', $block_id, $sliders_options, isset($fullwidthSlider) ? $fullwidthSlider : 'normalwidth') ?>
				</span>
			</span>
		</p>
		<?php
	}

	function slider_method(){
			wp_register_style('sliderCSS',get_template_directory_uri() . "/css/content-builder/slider.css");
			wp_enqueue_style('sliderCSS');

			wp_register_script('sliderJS',get_template_directory_uri() . "/js/sliders/sliders.js",array('jquery'),'2.0.3',true);
			wp_enqueue_script('sliderJS');
	}
	function nivo_slider_method(){
			wp_register_style('nivoSlider',get_template_directory_uri() . "/css/sliders/nivo/nivo-slider.css");
			wp_enqueue_style('nivoSlider');
			wp_register_style('nivoSliderDefault',get_template_directory_uri() . "/css/sliders/nivo/default.css");
			wp_enqueue_style('nivoSliderDefault');

			wp_register_script('nivoSliderJS',get_template_directory_uri() . "/js/sliders/nivo/jquery.nivo.slider.pack.js",array('jquery'),'2.0.3',true);
			wp_enqueue_script('nivoSliderJS');
	}

	function elastic_slider_method(){
			wp_register_style('elasticSlider',get_template_directory_uri() . "/css/sliders/elastic/elastic.css");
			wp_enqueue_style('elasticSlider');

			wp_register_script('elasticSliderJSEasing',get_template_directory_uri() . "/js/sliders/elastic/jquery.easing.1.3.js",array('jquery'),'2.0.3',true);
			wp_enqueue_script('elasticSliderJSEasing');

			wp_register_script('elasticSliderJS',get_template_directory_uri() . "/js/sliders/elastic/jquery.eislideshow.js",array('jquery'),'2.0.3',true);
			wp_enqueue_script('elasticSliderJS');
	}
	function threed_slider_method(){
			wp_register_style('threedSlider',get_template_directory_uri() . "/css/sliders/threed/slicebox.css");
			wp_enqueue_style('threedSlider');


			wp_register_script('modernizer',get_template_directory_uri() .'/js/sliders/threed/modernizr.custom.46884.js',array('jquery'),'2.0.3',true);
			wp_enqueue_script('modernizer');

			wp_register_script('slicebox',get_template_directory_uri() .'/js/sliders/threed/jquery.slicebox.js',array('modernizer'),'2.0.3',true);
			wp_enqueue_script('slicebox');
	}
	function vertical_accordion_slider_method(){
			wp_register_style('vertical_accordion',get_template_directory_uri() . "/css/sliders/verticalaccordion/verticalstyle.css");
			wp_enqueue_style('vertical_accordion');

			wp_register_script('vertical_accordioneasing',get_template_directory_uri() .'/js/sliders/verticalaccordion/jquery.easing.1.3.js',array('jquery'),'2.0.3',true);
			wp_enqueue_script('vertical_accordioneasing');
			wp_register_script('vertical_accordionmousewheel',get_template_directory_uri() .'/js/sliders/verticalaccordion/jquery.mousewheel.js',array('jquery'),'2.0.3',true);
			wp_enqueue_script('vertical_accordionmousewheel');
			wp_register_script('vertical_accordionJS',get_template_directory_uri() .'/js/sliders/verticalaccordion/jquery.vaccordion.js',array('jquery'),'2.0.3',true);
			wp_enqueue_script('vertical_accordionJS');
	}
	function accordion_slider_method(){
			wp_register_style('accordion',get_template_directory_uri() . "/css/sliders/accordion/accordion.css");
			wp_enqueue_style('accordion');

			wp_register_script('accordionJS',get_template_directory_uri() .'/js/sliders/accordion/accordion.js',array('jquery'),'2.0.3',true);
			wp_enqueue_script('accordionJS');
	}
	function block($instance) {
		$class = '';
		extract($instance);
		$this->slider_method();
		$counter = 0;
		$sliders_options = array();
		$fullwidth = '';
		if($fullwidthSlider == 'fullwidth') {
			$class = '';
			$fullwidth = '100%';
		}
		foreach (cr_get_option('create_slider') as $key => $value) {
			$sliders_options[$counter] = $value;
			$counter++;
		}
		$slider_type = cr_get_option(strtolower(str_replace(' ', '_', $sliders_options[$slider])).'select_slider','');
		$sliders_options[$slider] = strtolower(str_replace(' ', '_', $sliders_options[$slider]));
		$options_array = cr_get_option(strtolower($sliders_options[$slider]));
		if(circleflip_valid($sliders_options[$slider])) {
			switch ($slider_type) {
				case 'nivo_slider':
					$this->nivo_slider_method();
					?>
						<div class="slider-wrapper theme-default <?php echo esc_attr($class) ?>" style="margin-bottom:<?php echo esc_attr($margin_bottom); ?>">
						    <div id="slider" class="nivoSlider">
						    	<?php
						    	for ($i=0; $i < $options_array['number'] ; $i++) {
									if(circleflip_valid($options_array[$i][$sliders_options[$slider].'_link'])) {
										?>
										<a href="<?php echo esc_url($options_array[$i][$sliders_options[$slider].'_link']); ?>">
									<?php } ?>
											<img src="<?php echo circleflip_valid($options_array[$i][$sliders_options[$slider].'_image'])? esc_url($options_array[$i][$sliders_options[$slider].'_image']) : ''; ?>" data-thumb="<?php echo circleflip_valid($options_array[$i][$sliders_options[$slider].'_thumb'])? $options_array[$i][$sliders_options[$slider].'_thumb'] : ''; ?>" alt="" title="<?php echo  circleflip_valid($options_array[$i][$sliders_options[$slider].'_title']) ? esc_attr($options_array[$i][$sliders_options[$slider].'_title']) : ''; ?>" />
									<?php if(circleflip_valid($options_array[$i][$sliders_options[$slider].'_link'])) { ?>
										</a>
									<?php
										}
								}
						    	?>
						    </div>
						</div>
					<?php
				break;
				case 'elastic_slider':
					$this->elastic_slider_method();
					?>
						<div class="wrapper <?php echo esc_attr($class) ?>" style="margin-bottom:<?php echo esc_attr($margin_bottom); ?>px">
			                <div id="ei-slider" class="ei-slider">
			                    <ul class="ei-slider-large">
			                    	<?php for ($i=0; $i < $options_array['number'] ; $i++) { ?>
							    		<li>
							    			<?php if(circleflip_valid($options_array[$i][$sliders_options[$slider].'_link'])) { ?>
											<a href="<?php echo esc_url($options_array[$i][$sliders_options[$slider].'_link']); ?>">
											<?php } ?>
												<img src="<?php echo circleflip_valid($options_array[$i][$sliders_options[$slider].'_image'])? esc_url($options_array[$i][$sliders_options[$slider].'_image']) : ''; ?>"  alt="" />
											<?php if(circleflip_valid($options_array[$i][$sliders_options[$slider].'_link'])) { ?>
											</a>
											<?php } ?>
											<div class="ei-title">
				                                <h2 style="font-family: <?php echo esc_attr($options_array[$i][$sliders_options[$slider].'_font_title']['face']) ?>;font-size:<?php echo esc_attr($options_array[$i][$sliders_options[$slider].'_font_title']['size']) ?>;color:<?php echo esc_attr($options_array[$i][$sliders_options[$slider].'_font_title']['color']) ?>;font-weight: <?php echo esc_attr($options_array[$i][$sliders_options[$slider].'_font_title']['weight']) ?> ;"><?php echo circleflip_valid($options_array[$i][$sliders_options[$slider].'_title']) ? esc_attr($options_array[$i][$sliders_options[$slider].'_title']) : ''; ?></h2>
				                                <h3 style="font-family: <?php echo esc_attr($options_array[$i][$sliders_options[$slider].'_font_text']['face']) ?>;font-size:<?php echo esc_attr($options_array[$i][$sliders_options[$slider].'_font_text']['size']) ?>;color:<?php echo esc_attr($options_array[$i][$sliders_options[$slider].'_font_text']['color']) ?>;font-weight: <?php echo esc_attr($options_array[$i][$sliders_options[$slider].'_font_text']['weight']) ?> ;"><?php echo circleflip_valid($options_array[$i][$sliders_options[$slider].'_text']) ? esc_attr($options_array[$i][$sliders_options[$slider].'_text']) : ''; ?></h3>
				                            </div>
										</li>
									<?php } ?>
			                    </ul><!-- ei-slider-large -->
			                    <ul class="ei-slider-thumbs">
			                    	<li class="ei-slider-element">Current</li>
			                    	<?php for ($i=0; $i < $options_array['number'] ; $i++) { ?>
										<li><a href="<?php echo esc_url($options_array[$i][$sliders_options[$slider].'_link']); ?>"></a><img src="<?php echo circleflip_valid($options_array[$i][$sliders_options[$slider].'_thumb'])? esc_url($options_array[$i][$sliders_options[$slider].'_thumb']) : ''; ?>" /></li>
									<?php } ?>
			                    </ul><!-- ei-slider-thumbs -->
			                </div><!-- ei-slider -->
			            </div><!-- wrapper -->
					<?php
				break;
				case 'threed_slider':
					$this->threed_slider_method();
					?>
						<div class="wrapper <?php echo esc_attr($class) ?>" style="position:relative; margin-bottom:<?php echo esc_attr($margin_bottom); ?>px">
						<div class="wrapper DSlider <?php echo esc_attr($class) ?>">
							<ul id="sb-slider" class="sb-slider">
								<?php for ($i=0; $i < $options_array['number'] ; $i++) { ?>
								<li>
									<?php if(circleflip_valid($options_array[$i][$sliders_options[$slider].'_link'])): ?>
									<a href="<?php echo esc_url($options_array[$i][$sliders_options[$slider].'_link']); ?>" target="_blank"><img src="<?php echo circleflip_valid($options_array[$i][$sliders_options[$slider].'_image'])? esc_url($options_array[$i][$sliders_options[$slider].'_image']) : ''; ?>" alt="image1"/></a>
									<?php else:?>
									<img src="<?php echo circleflip_valid($options_array[$i][$sliders_options[$slider].'_image'])? esc_url($options_array[$i][$sliders_options[$slider].'_image']) : ''; ?>" alt="image1"/>
									<?php endif; ?>
									<?php if(circleflip_valid($options_array[$i][$sliders_options[$slider].'_text'])): ?>
									<div class="sb-description">
										<h3 style="font-family: <?php echo esc_attr($options_array[$i][$sliders_options[$slider].'_font_text']['face']) ?>;font-size:<?php echo esc_attr($options_array[$i][$sliders_options[$slider].'_font_text']['size']) ?>;color:<?php echo esc_attr($options_array[$i][$sliders_options[$slider].'_font_text']['color']) ?>;font-weight: <?php echo esc_attr($options_array[$i][$sliders_options[$slider].'_font_text']['weight']) ?> ;"><?php echo circleflip_valid($options_array[$i][$sliders_options[$slider].'_text']) ? esc_html($options_array[$i][$sliders_options[$slider].'_text']) : ''; ?></h3>
									</div>
									<?php endif; ?>
								</li>
								<?php } ?>
							</ul>

							<div id="shadow" class="shadow"></div>

							<div id="nav-arrows" class="nav-arrows">
								<a href="#" class="icon-right-open-big next"></a>
								<a href="#" class="icon-left-open-big prev"></a>
							</div>

							<div id="nav-dots" class="nav-dots">
								<span class="nav-dot-current"></span>
								<?php for ($i=0; $i < $options_array['number'] ; $i++) { ?>
								<span></span>
								<?php } ?>
							</div>

						</div><!-- /wrapper -->
					<?php
				break;
				case 'vertical_accordion_slider':
					$this->vertical_accordion_slider_method();
					?>
					<div id="va-accordion" class="va-container <?php echo esc_attr($class) ?>" style="margin-bottom:<?php echo esc_attr($margin_bottom); ?>px">
						<div class="va-nav">
							<span class="va-nav-prev icon-up-open-big"></span>
							<span class="va-nav-next icon-down-open-big"></span>
						</div>
						<div class="va-wrapper">
							<?php for ($i=0; $i < $options_array['number'] ; $i++) { ?>
							<div class="va-slice" style="background: #000 url(<?php echo circleflip_valid($options_array[$i][$sliders_options[$slider].'_image'])? esc_url($options_array[$i][$sliders_options[$slider].'_image']) : ''; ?>) no-repeat center center;">
								<h2 class="va-title" style="font-family: <?php echo esc_attr($options_array[$i][$sliders_options[$slider].'_font_title']['face']) ?>;font-size:<?php echo esc_attr($options_array[$i][$sliders_options[$slider].'_font_title']['size']) ?>;color:<?php echo esc_attr($options_array[$i][$sliders_options[$slider].'_font_title']['color']) ?>;font-weight: <?php echo esc_attr($options_array[$i][$sliders_options[$slider].'_font_title']['weight']) ?> ;"><?php echo circleflip_valid($options_array[$i][$sliders_options[$slider].'_title']) ? esc_html($options_array[$i][$sliders_options[$slider].'_title']) : ''; ?></h2>
								<div class="va-content">
									<p style="font-family: <?php echo esc_attr($options_array[$i][$sliders_options[$slider].'_font_text']['face']) ?>;font-size:<?php echo esc_attr($options_array[$i][$sliders_options[$slider].'_font_text']['size']) ?>;color:<?php echo esc_attr($options_array[$i][$sliders_options[$slider].'_font_text']['color']) ?>;font-weight: <?php echo esc_attr($options_array[$i][$sliders_options[$slider].'_font_text']['weight']) ?> ;"><?php echo circleflip_valid($options_array[$i][$sliders_options[$slider].'_text']) ? esc_html($options_array[$i][$sliders_options[$slider].'_text']) : ''; ?></p>
									<ul>
										<?php if(circleflip_valid($options_array[$i][$sliders_options[$slider].'_button1link'])) { ?>
										<li>
											<a href="<?php echo circleflip_valid($options_array[$i][$sliders_options[$slider].'_button1link'])? esc_url($options_array[$i][$sliders_options[$slider].'_button1link']) : ''; ?>"><?php echo circleflip_valid($options_array[$i][$sliders_options[$slider].'_button1'])? esc_html($options_array[$i][$sliders_options[$slider].'_button1']) : ''; ?></a>
										</li>
										<?php } ?>
										<?php if(circleflip_valid($options_array[$i][$sliders_options[$slider].'_button2link'])) { ?>
										<li>
											<a href="<?php echo circleflip_valid($options_array[$i][$sliders_options[$slider].'_button2link'])? esc_url($options_array[$i][$sliders_options[$slider].'_button2link']) : ''; ?>"><?php echo circleflip_valid($options_array[$i][$sliders_options[$slider].'_button2'])? esc_html($options_array[$i][$sliders_options[$slider].'_button2']) : ''; ?></a>
										</li>
										<?php } ?>
										<?php if(circleflip_valid($options_array[$i][$sliders_options[$slider].'_button3link'])) { ?>
										<li>
											<a href="<?php echo circleflip_valid($options_array[$i][$sliders_options[$slider].'_button3link'])? esc_url($options_array[$i][$sliders_options[$slider].'_button3link']) : ''; ?>"><?php echo circleflip_valid($options_array[$i][$sliders_options[$slider].'_button3'])? esc_html($options_array[$i][$sliders_options[$slider].'_button3'] ): ''; ?></a>
										</li>
										<?php } ?>
									</ul>
								</div>
							</div>
							<?php } ?>
						</div>
					</div>
					<?php
				break;
				case 'accordion':
					$this->accordion_slider_method();
					?>
					<div id="accordionSlider" class="<?php echo esc_attr($class) ?>" style="margin-bottom:<?php echo esc_attr($margin_bottom); ?>px">
						<ul id="accordion-slider" class="kwicks-horizontal kwicks">
							<?php for ($i=0; $i < $options_array['number'] ; $i++) { ?>
							<li>
								<?php if(circleflip_valid($options_array[$i][$sliders_options[$slider].'_link'])): ?>
								<a href="<?php echo esc_url($options_array[$i][$sliders_options[$slider].'_link']); ?>">
								<?php endif; ?>
									<img src="<?php echo circleflip_valid($options_array[$i][$sliders_options[$slider].'_image'])? esc_url($options_array[$i][$sliders_options[$slider].'_image']) : ''; ?>" alt="">
								<?php if(circleflip_valid($options_array[$i][$sliders_options[$slider].'_link'])): ?>
								</a>
								<?php endif; ?>
								<?php if(circleflip_valid($options_array[$i][$sliders_options[$slider].'_title'])): ?>
								<div class="accTitle" >
									<p style="font-family: <?php echo esc_attr($options_array[$i][$sliders_options[$slider].'_font_title']['face']) ?>;font-size:<?php echo esc_attr($options_array[$i][$sliders_options[$slider].'_font_title']['size']) ?>;color:<?php echo esc_attr($options_array[$i][$sliders_options[$slider].'_font_title']['color']) ?>;font-weight: <?php echo esc_attr($options_array[$i][$sliders_options[$slider].'_font_title']['weight']) ?> ;"><?php echo circleflip_valid($options_array[$i][$sliders_options[$slider].'_title']) ? esc_html($options_array[$i][$sliders_options[$slider].'_title']) : ''; ?></p>
								</div>
								<?php endif; ?>
								<?php if(circleflip_valid($options_array[$i][$sliders_options[$slider].'_title']) || circleflip_valid($options_array[$i][$sliders_options[$slider].'_text'])): ?>
								<div class="accDetail">
									<?php if(circleflip_valid($options_array[$i][$sliders_options[$slider].'_title'])): ?>
									<p style="font-family: <?php echo esc_attr($options_array[$i][$sliders_options[$slider].'_font_title']['face']) ?>;font-size:<?php echo esc_attr($options_array[$i][$sliders_options[$slider].'_font_title']['size']) ?>;color:<?php echo esc_attr($options_array[$i][$sliders_options[$slider].'_font_title']['color']) ?>;font-weight: <?php echo esc_attr($options_array[$i][$sliders_options[$slider].'_font_title']['weight']) ?> ;"><?php echo circleflip_valid($options_array[$i][$sliders_options[$slider].'_title']) ? esc_html($options_array[$i][$sliders_options[$slider].'_title']) : ''; ?></p>
									<?php endif; ?>
									<h3 style="font-family: <?php echo esc_attr($options_array[$i][$sliders_options[$slider].'_font_text']['face']) ?>;font-size:<?php echo esc_attr($options_array[$i][$sliders_options[$slider].'_font_text']['size']) ?>;color:<?php echo esc_attr($options_array[$i][$sliders_options[$slider].'_font_text']['color']) ?>;font-weight: <?php echo esc_attr($options_array[$i][$sliders_options[$slider].'_font_text']['weight']) ?> ;"><?php echo circleflip_valid($options_array[$i][$sliders_options[$slider].'_text']) ? esc_html($options_array[$i][$sliders_options[$slider].'_text']) : ''; ?></h3>
								</div>
								<?php endif; ?>
							</li>
							<?php } ?>
						</ul>
					</div>
					<?php
				break;
				default:

				break;

			}

		}
	}

}