<?php
/** A simple text block **/
class CR_Image_Slider_Block extends AQ_Block {

	//set and create block
	function __construct() {
		$block_options = array(
			'image' => 'image_slider.png',
			'name' => 'Image Slider',
			'size' => 'span6',
                        'tab' => 'media',
                        'imagedesc' => 'image-slider.jpg',
                        'desc' => 'An easy to make image slider.'
		);

		//create the block
		parent::__construct('cr_image_slider_block', $block_options);
		add_action('wp_ajax_aq_block_ImageSlider_add_new', array($this, 'add_tab'));
	}

	function form($instance) {

		$defaults = array(
			'title_block' => '',
			'text' => '',
			'count' => '',
			'displayButton' => '',
			'tabs' => array(
					1 => array(
						'imagesrc' => ''
					)
				),
				'type'	=> 'tab',
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		?>
		<p class="description">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('title_block') ) ?>">
					Title
				</label>
				<span class="description_text">
					Write a title for the block, or leave it blank.
				</span>
			</span>
			<span class="rightHalf">
				<?php echo circleflip_field_input('title_block', $block_id, $title_block, $size = 'full') ?>
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
				<label for="<?php echo esc_attr( $this->get_field_id('displayButton') ) ?>">
					Display Navigation Buttons
				</label>
			</span>
				<?php echo circleflip_field_checkbox('displayButton', $block_id, (isset($displayButton))? $displayButton : 0) ?>
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
				<br />
				<a href="#" rel="ImageSlider" class="aq-sortable-add-new button">Add New</a>
				<br />
		</div>
		<?php
	}

	function tab($tab = array(), $count = 0) {
			?>
			<li id="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-sortable-item-<?php echo esc_attr($count) ?>" class="sortable-item" rel="<?php echo esc_attr($count) ?>">

				<div class="sortable-head cf">
					<div class="sortable-title">
						<strong><?php echo "Image " .esc_html($count);  ?></strong>
					</div>
					<div class="sortable-out-delete">
						<span></span>
					</div>
					<div class="sortable-handle">
						<a href="#">Open / Close</a>
					</div>
				</div>
				<div class="sortable-body">
					<p class="description">
						<span class="leftHalf">
							<label for="<?php echo esc_attr( $this->get_field_id('image_upload') ) ?>-<?php echo esc_attr($count) ?>-image">
								Image
								<?php
									if(isset($tab['image']) && !empty($tab['image']))
										{
											$tab_image = $tab['image'];
											$slider_img_id = $tab['imagesrc'];
										}
									else {
										$tab_image = '';
										$slider_img_id = '';
									}
								?>
							</label>
							<span class="description_text">
								Upload your image.
							</span>
						</span>
						<span class="rightHalf">
							<img class="screenshot" src="<?php echo esc_url($tab_image); ?>" alt=""/>
							<input type="hidden" id="<?php echo esc_attr( $this->get_field_id('image_upload') ) ?>-<?php echo esc_attr($count) ?>-imagesrc"
								   name="<?php echo esc_attr( $this->get_field_name('tabs') ) ?>[<?php echo esc_attr($count) ?>][imagesrc]"
								   value=<?php echo esc_attr($slider_img_id)  ?> />
							<input type="text" id="<?php echo esc_attr( $this->get_field_id('image_upload') ) ?>-<?php echo esc_attr($count) ?>-image"
								   class="input-full input-upload" value="<?php echo esc_attr($tab_image) ?>"
								   name="<?php echo esc_attr( $this->get_field_name('tabs') ) ?>[<?php echo esc_attr($count) ?>][image]">
							<a href="#" class="aq_upload_button button" rel="image">Upload</a>
						</span>
					</p>
				</div>
			</li>
			<?php
		}
	function imageSlider(){
		$theme_version = _circleflip_version();
		wp_register_style('imageSlider-css',get_template_directory_uri() . "/css/content-builder/imageSlider.css",array(),$theme_version);
		wp_enqueue_style('imageSlider-css');

		wp_register_script('imageSlider-js', get_template_directory_uri() .'/scripts/modules/imageSlider.js');
		wp_enqueue_script('imageSlider-js');
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
			$titleIconHead = '<div class="headerDot"><span class="'.esc_attr($iconHead).'"></span></div>';
		}
		$this->imageSlider();
			?>

			<?php $display = '';
			  		if($displayButton == 0){
			  			$display = 'noBtn';
			  		}else{
			  			$display = 'existBtn';
			  		} ?>
			<div class="imageSlider_carousel <?php echo esc_attr($display); ?>">
				<div class="titleBlock" style="<?php echo circleflip_valid($title_block) ? '' : 'height: 54px;' ?>">
					<?php if(circleflip_valid($title_block)): ?>
						<h3><?php echo $titleIconHead . esc_html( $title_block ); ?></h3>
					<?php endif; ?>
					<?php if( $display == 'existBtn' ): ?>
					<div class="imageSlider right">
						<a class="left carousel-control" href="#" style="display: block ">
							<span class="icon-prev"></span>
						</a>
						<a class="right carousel-control" href="#" style="display: block ">
							<span class="icon-next"></span>
						</a>
					</div>
					<?php endif; ?>
				</div>

				  <!-- Wrapper for slides -->
				  <div class="imgCarouselWrap">
				  	<ul>
					  	<?php $i = 0;?>
					  	<?php foreach( $tabs as $tab ){ ?>
						<li class="<?php if($i++ == 0){ echo 'active';} ?>">
							<?php echo wp_get_attachment_image($tab['imagesrc'],'full');?>
						</li>
					    <?php } ?>
				    </ul>
				  </div>

				  <!-- Controls -->
			</div>
			<?php

	}
/* AJAX add tab */
		function add_tab() {
			$count = isset($_POST['count']) ? absint($_POST['count']) : false;
			$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'aq-block-9999';

			//default key/value for the tab
			$tab = array(
				'imagesrc' => ''
			);

			if($count) {
				$this->tab($tab, $count);
			} else {
				die(-1);
			}

			die();
		}
}