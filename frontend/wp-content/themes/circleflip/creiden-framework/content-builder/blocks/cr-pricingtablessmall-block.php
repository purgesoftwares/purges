<?php
/** A simple text block **/
class CR_pricingtablessmall_Block extends AQ_Block {

	//set and create block
	function __construct() {
		$block_options = array(
			'image' => 'pricing_table_small.png',
			'name' => 'Small Pricing',
			'size' => 'span6',
                        'imagedesc' => 'small-pricing.jpg',
                        'tab' => 'Content',
                        'desc' => 'Ideal for showing your payment plans.'
		);

		//create the block
		parent::__construct('cr_pricingtablessmall_block', $block_options);
		add_action('wp_ajax_aq_block_spt_tab_add_new', array($this, 'add_tab'));
	}

	function form($instance) {

		$defaults = array(

			'tabs' => array(
				1 => array(
					'title' => 'Feature',
					'type' => 'GET IT NOW!',
					'price' => '$25',
					'text' => 'Basic',
					'active' => '',
					'line_color' => '#e32831',
					'color' => '#ffffff',
					'link' => '#'
				)
			),
			'type'	=> 'tab',
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		$color = !empty($color) ? $color : '#dddddd';
		$line_color = !empty($line_color) ? $line_color : '#ddddd';
		?>
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
					<a href="#" rel="spt_tab" class="aq-sortable-add-new button">Add New</a>
					<p></p>
		</div>
		<?php
	}
	function tab($tab = array(), $count = 0) {
			?>
			<li id="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-sortable-item-<?php echo esc_attr($count) ?>" class="sortable-item" rel="<?php echo esc_attr($count) ?>">

				<div class="sortable-head cf">
					<div class="sortable-title">
						<strong><?php echo 'Price ' . esc_html($count); ?> </strong>
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
								Package Name
							</label>
							<span class="description_text">
								Ex. Basic
							</span>
						</span>
						<span class="rightHalf">
							<input type="text" id="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-text" class="input-full" name="<?php echo esc_attr( $this->get_field_name('tabs') ) ?>[<?php echo esc_attr($count) ?>][text]" value="<?php echo esc_attr($tab['text']) ?>" />
						</span>
					</p>
					<p class="tab-desc description">
						<span class="leftHalf">
							<label for="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-type">
								Action
							</label>
							<span class="description_text">
								Ex. Sign Up
							</span>
						</span>
						<span class="rightHalf">
							<input type="text" id="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-type" class="input-full" name="<?php echo esc_attr( $this->get_field_name('tabs') ) ?>[<?php echo esc_attr($count) ?>][type]" value="<?php echo esc_attr($tab['type']) ?>" />
						</span>
					</p>
					<p class="tab-desc description">
						<span class="leftHalf">
							<label for="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-link">
								Link
							</label>
						</span>
						<span class="rightHalf">
							<input type="text" id="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-link" class="input-full" name="<?php echo esc_attr( $this->get_field_name('tabs') ) ?>[<?php echo esc_attr($count) ?>][link]" value="<?php echo esc_attr($tab['link']) ?>" />
						</span>
					</p>
					<p class="description">
						<span class="leftHalf">
							<label for="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-price">
								Price
							</label>
						</span>
						<span class="rightHalf">
							<input type="text" id="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-price" class="input-full" name="<?php echo esc_attr( $this->get_field_name('tabs') ) ?>[<?php echo esc_attr($count) ?>][price]" value="<?php echo esc_attr($tab['price']) ?>" />
						</span>
					</p>
					<p class="description">
						<span class="leftHalf">
							<label for="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-active">
								Highlighted
							</label>
						</span>
						<span class="rightHalf">
							<input type="hidden" name="<?php echo esc_attr( $this->get_field_name('tabs') ) ?>[<?php echo esc_attr($count) ?>][active]" value="0" />
							<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-active" <?php  echo checked( 1, $tab['active'] , false ) ?> class="input-checkbox" name="<?php echo esc_attr( $this->get_field_name('tabs') ) ?>[<?php echo esc_attr($count) ?>][active]"  value="1"/>
						</span>
					</p>
					<div class="description half last">
						<span class="leftHalf">
							<label for="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-line_color">
								Pick the background color
							</label>
						</span>
						<span class="rightHalf">
							<div class="aqpb-color-picker">
								<input type="text" id="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-line_color" class="input-color-picker" value="<?php echo esc_attr($tab['line_color']) ?>" name="<?php echo esc_attr( $this->get_field_name('tabs') ) ?>[<?php echo esc_attr($count) ?>][line_color]" data-default-color="<?php echo esc_attr($tab['line_color']) ?>"/>
							</div>
						</span>
					</div>
					<div class="description half last">
						<span class="leftHalf">
							<label for="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-color">
								Pick the Font color
							</label>
						</span>
						<span class="rightHalf">
							<div class="aqpb-color-picker">
								<input type="text" id="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-color" class="input-color-picker" value="<?php echo esc_attr($tab['color']) ?>" name="<?php echo esc_attr( $this->get_field_name('tabs') ) ?>[<?php echo esc_attr($count) ?>][color]" data-default-color="<?php echo esc_attr($tab['color']) ?>"/>
							</div>
							<?php //echo aq_field_color_picker('color', $block_id, $color) ?>
						</span>
					</div>
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
			'type' => 'GET IT NOW!',
			'price' => '$25',
			'text' => 'Basic',
			'active' => '',
			'line_color' => '#e32831',
			'color' => '#ffffff',
			'link' => '#'
		);

		if($count) {
			$this->tab($tab, $count); ?>

			<script type="text/javascript">
				jQuery(document).ready(function($){
					$('.sortable-item').last().find('.aqpb-color-picker input').each(function(){
						var $this	= $(this),
							parent	= $this.parent();
						$this.wpColorPicker();
					});
				});
 			</script>
		<?php
		} else {
			die(-1);
		}
		die();
	}

	function update($new_instance, $old_instance) {
		$new_instance = circleflip_recursive_sanitize($new_instance);
		return $new_instance;
	}
		function pricing_method(){
			wp_register_style('pricing', get_template_directory_uri() . '/css/content-builder/pricingtables.css');
			wp_enqueue_style('pricing');
		}

	function block($instance) {
		extract($instance);
		$this->pricing_method();


			?>
		<?php foreach( $tabs as $tab ){
			switch ($tab['active']) {
				case '1':
					$class = 'bestBundle';
					break;
				default :
					$class = '';
					break;
			}
		?>
		<div class="miniPricingTable <?php echo esc_attr($class); ?> span2">
			<div class="bundlePrice clearfix">
				<h2><?php echo esc_html($tab['price']) ?></h2>
				<h5><?php echo esc_html($tab['text']) ?></h5>
				<div class="ui-arrowUp" style="border-bottom-color: <?php echo esc_attr($tab['line_color']) ?>"></div>
			</div>
			<a href="<?php echo esc_url($tab['link']) ?>">
				<div class="buyBundle" style="background-color: <?php echo esc_attr($tab['line_color']) ?>">
					<h3 style="color: <?php echo esc_attr($tab['color']) ?>"><strong><?php echo esc_html($tab['type']) ?></strong></h3>
				</div>
			</a>
		</div>
		<?php } ?>
	<?php
	}

}