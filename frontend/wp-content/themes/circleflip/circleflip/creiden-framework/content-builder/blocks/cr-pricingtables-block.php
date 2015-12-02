<?php
/** A simple text block **/
class CR_PricingTables_Block extends AQ_Block {

	//set and create block
	function __construct() {
		$block_options = array(
			'image' => 'pricing_table.png',
			'name' => 'Pricing Table',
			'size' => 'span6',
                        'imagedesc' => 'pricing-table.jpg',
                        'tab' => 'Content',
                        'desc' => 'Adds a price plan with features and a button.'
		);

		//create the block
		parent::__construct('CR_PricingTables_Block', $block_options);

		add_action('wp_ajax_aq_block_pt_tab_add_new', array($this, 'add_tab'));
	}

	function form($instance) {

		$defaults = array(
			'main_title' => 'Pricing Table',
			'price' => '$20',
			'active' => '',
			'btnText' => 'Buy',
			'btnLink' => '',
			'tabs' => array(
				1 => array(
					'title' => 'Feature',
					'content' => 'Feature Description',
					'imagesrc' =>''
				)
			),
			'type'	=> 'tab',
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		?>
		<div class="description cf">
				<p class="description">
					<span class="leftHalf">
						<label for="<?php echo esc_attr( $this->get_field_id('main_title') ) ?>">
							Main Title
						</label>
						<span class="description_text">
							Ex. Best Bundle
						</span>
					</span>
					<span class="rightHalf">
						<?php echo circleflip_field_input('main_title', $block_id, $main_title, $size = 'full') ?>
					</span>
				</p>
				<p class="description">
					<span class="leftHalf">
						<label for="<?php echo esc_attr( $this->get_field_id('price') ) ?>">
							Price
						</label>
						<span class="description_text">
							Ex. $50
						</span>
					</span>
					<span class="rightHalf">
						<?php echo circleflip_field_input('price', $block_id, $price, $size = 'full') ?>
					</span>
				</p>
				<p class="description">
					<span class="leftHalf">
						<label for="<?php echo esc_attr( $this->get_field_id('active') ) ?>">
							Highlighted
						</label>
 					</span>
					<span class="rightHalf">
						<?php echo circleflip_field_checkbox('active', $block_id, $active) ?>
					</span>
				</p>
				<p class="description">
					<span class="leftHalf">
						<label for="<?php echo esc_attr( $this->get_field_id('btnText') ) ?>">
							Button Text
						</label>
						<span class="description_text">
							Ex. Join Now
						</span>
					</span>
					<span class="rightHalf">
						<?php echo circleflip_field_input('btnText', $block_id, $btnText, $size = 'full') ?>
					</span>
				</p>
				<p class="description">
					<span class="leftHalf">
						<label for="<?php echo esc_attr( $this->get_field_id('btnLink') ) ?>">
							Button Link
						</label>
					</span>
					<span class="rightHalf">
						<?php echo circleflip_field_input('btnLink', $block_id, $btnLink, $size = 'full') ?>
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
				<a href="#" rel="pt_tab" class="aq-sortable-add-new button">Add New</a>
				<p></p>
			</div>
		<?php
	}

	function block($instance) {
		extract($instance);
		$this->pricingTables();
		switch ($active) {
			case '1':
				$class = 'active';
				break;
			default :
				$class = '';
				break;
		}
			?>
			<div class="pricingTable <?php echo esc_attr($class); ?>">
				<div class="bundleHeader alignCenter">
					<h3>
						<?php echo esc_html($main_title) ?>
					</h3>
				</div>
				<div class="price"><p><?php echo esc_html($price) ?></p></div>
				<div class="bundleContent clearfix">
					<ul>
						
						<?php
						foreach( $tabs as $tab ){ 
							$feature_image = wp_get_attachment_image_src($tab['imagesrc'],'full');
							?>
							<li>
								<?php if(isset($feature_image[0]) && !empty($feature_image[0])){ ?>
									<img src="<?php echo esc_url($feature_image[0]); ?>" />
								<?php } ?>
								<?php if(isset($tab['title']) && !empty($tab['title'])){ ?>
								<p><?php echo  esc_html($tab['title']); ?></p>
								<?php } ?>
							</li>
						<?php } ?>
					</ul>
					<a href="<?php echo esc_url($btnLink); ?>" class="orderBundle alignCenter">
						<?php echo esc_html($btnText) ?>
					</a>
				</div>
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
					<p class="description">
						<span class="leftHalf">
							<label for="<?php echo esc_attr( $this->get_field_id('image_upload') ) ?>-<?php echo esc_attr($count) ?>-image">
								Feature Image
								<?php
									if(isset($tab['image']) && !empty($tab['image']))
										{
											$tab_image = $tab['image'];
											$slider_img_id = (isset($tab['imagesrc']))? $tab['imagesrc'] : '';
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
							<input type="text" id="<?php echo esc_attr( $this->get_field_id('image_upload') ) ?>-<?php echo esc_attr($count) ?>-image" readonly
								   class="input-full input-upload" value="<?php echo esc_attr($tab_image) ?>"
								   name="<?php echo esc_attr( $this->get_field_name('tabs') ) ?>[<?php echo esc_attr($count) ?>][image]">
							<a href="#" class="aq_upload_button button" rel="image">Upload</a>
							<a href="#" class="remove_image button" rel="image">Remove</a>
						</span>
					</p>
					<p class="tab-desc description">
						<label for="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-title">
							Feature<br/>
							<input type="text" id="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-title" class="input-full" name="<?php echo esc_attr( $this->get_field_name('tabs') ) ?>[<?php echo esc_attr($count) ?>][title]" value="<?php echo esc_attr($tab['title']) ?>" />
						</label>
					</p>
				</div>

			</li>
			<?php
		}
	/* AJAX add tab */
	function add_tab() {
		$count = isset($_POST['count']) ? absint($_POST['count']) : false;
		$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'aq-block-9999';

		//default key/value for the tab
		$tab = array(
			'title' => 'Feature',
			'imagesrc' =>''
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

	function pricingTables() {
		wp_register_style('pricingtables',get_template_directory_uri().'/css/content-builder/pricingtables.css');
		wp_enqueue_style('pricingtables');

	}
}
