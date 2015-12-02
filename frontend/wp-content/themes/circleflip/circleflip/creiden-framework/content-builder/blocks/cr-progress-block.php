<?php
/** A simple text block **/
class CR_Progress_Block extends AQ_Block {

	//set and create block
	function __construct() {
		$block_options = array(
			'image' => 'progress.png',
			'name' => 'Progress Bars',
			'size' => 'span6',
                        'tab' => 'Content',
                        'imagedesc' => 'progress-bars.jpg',
                        'desc' => 'creates a progress bar mock-up.'
		);

		//create the block
		parent::__construct('cr_progress_block', $block_options);
		//add ajax functions
		add_action('wp_ajax_aq_block_progress_add_new', array($this, 'add_progress'));
	}

	function form($instance) {

		$defaults = array(
			'lists' => array(
					1 => array(
						'title' => 'Bar',
						'progress' => '',
						'color' => 'custom',
						'progress_color' => '#e32831'
					),
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
				$this->progressItem($list, $count);
				$count++;
			}
		?>
		</ul>
		<p></p>
		<a href="#" rel="progress" class="aq-sortable-add-new button">Add New</a>
		<p></p>
		<?php
	}
	function progressItem($list = array(), $count = 0) { ?>
			<li id="<?php echo esc_attr( $this->get_field_id('lists') ) ?>-sortable-item-<?php echo esc_attr($count) ?>" class="sortable-item" rel="<?php echo esc_attr($count) ?>">
				<div class="sortable-head cf">
					<div class="sortable-title">
						<strong><?php echo esc_html($list['title']) ?></strong>
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
							<label for="<?php echo esc_attr( $this->get_field_id('title') ) ?>">
								Title
							</label>
						</span>
						<span class="rightHalf">
							<input type="text" id="<?php echo esc_attr( $this->get_field_id('title') ) ?>-<?php echo esc_attr($count) ?>-title" class="input-full" name="<?php echo esc_attr( $this->get_field_name('lists') ) ?>[<?php echo esc_attr($count) ?>][title]" value="<?php echo esc_attr($list['title']) ?>" />
						</span>
					</p>
					<p class="tab-desc description">
						<span class="leftHalf">
							<label for="<?php echo esc_attr( $this->get_field_id('progress') ) ?>">
								Percentage
							</label>
						</span>
						<span class="rightHalf progressPercentage">
							<input type="text" id="<?php echo esc_attr( $this->get_field_id('progress') ) ?>-<?php echo esc_attr($count) ?>-progress" class="input-full" name="<?php echo esc_attr( $this->get_field_name('lists') ) ?>[<?php echo esc_attr($count) ?>][progress]" value="<?php echo esc_attr($list['progress']) ?>" />
							<span>%</span>
						</span>
					</p>
					<p class="tab-desc description">
						<span class="leftHalf">
							<label for="<?php echo esc_attr( $this->get_field_id('color') ) ?>">
								color
							</label>
						</span>
						<span class="rightHalf">
							<span class="rightHalf select">
								<?php $color_values=array('custom' => 'Custom','red' => 'Default');?>
							<select id="<?php echo esc_attr( $this->get_field_id('color') ) ?>-<?php echo esc_attr($count) ?>-color" name="<?php echo esc_attr( $this->get_field_name('lists') ) ?>[<?php echo esc_attr($count) ?>][color]" data-fd-handle="progress_color">
								<?php foreach( $color_values as $key=>$value) { ?>
									<option value="<?php echo esc_attr($key) ?>" '<?php echo selected( $list['color'], $key, false ) ?>'><?php echo htmlspecialchars($value); ?></option>
								<?php } ?>
							</select>
							</span>
						</span>
					</p>
					<div class="description half last clearLineColor">
						<span class="leftHalf">
							<label for="<?php echo esc_attr( $this->get_field_id('progress_color') ) ?>-<?php echo esc_attr($count) ?>-progress_color">
								Pick a Progress Color
							</label>
						</span>
						<span class="rightHalf">
							<span class="rightHalf">
								<div class="aqpb-color-picker">
									<input type="text" id="<?php echo esc_attr( $this->get_field_id('progress_color') ) ?>-<?php echo esc_attr($count) ?>-progress_color" class="input-color-picker" value="<?php echo esc_attr($list['progress_color']); ?>" name="<?php echo esc_attr( $this->get_field_name('lists') ) ?>[<?php echo esc_attr($count) ?>][progress_color]" data-default-color="#e32831" />
								</div>
							</span>
						</span>
					</div>
				</div>
			</li>
			<?php
		}
	/* AJAX add list */
		function add_progress() {
			$count = isset($_POST['count']) ? absint($_POST['count']) : false;
			$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'aq-block-9999';

			//default key/value for the tab
			$list = array(
				'title' => 'Bar',
				'progress' => '50',
				'color' => 'custom',
				'progress_color' => '#e32831'
			); ?>
			<script type="text/javascript">
				jQuery(document).ready(function($){
					$('.sortable-item').find('.aqpb-color-picker').last().find('input').each(function(index,element){
						var $this	= $(this),
							parent	= $this.parent();
						$this.wpColorPicker();
					});
					$('.sortable-item').find('.aqpb-color-picker').each(function(index,element){
						if($(element).find('.wp-picker-container').find('.wp-picker-container').length !== 0 ) {
							$(element).find('.wp-picker-container').first().children('.wp-color-result').remove();
						}
					});
				});
 			</script>
			<?php
			if($count) {
				$this->progressItem($list, $count);
			} else {
				die(-1);
			}

			die();
		}
	function block($instance) {
		extract($instance);
		$color = '';
		echo "<ul class='progressList'>";
		foreach ($lists as $key => $value) {
			if($value['color'] == 'custom'){
				$color = 'background:'. esc_attr($value['progress_color']).';';
			}
			echo '<li>
					<h3>'.esc_html($value['title']).'</h3>
					<div class="progress"><div class="bar animateCr '.esc_attr($value['color']).'" style="width:'.esc_attr($value['progress']).'%;'. $color .'"></div></div>
					<div class="persentageProgress"><p>'.esc_html($value['progress']).'%</p></div>
				 </li>';
		}

		echo "</ul>";
	}
	function update($new_instance, $old_instance) {
		$new_instance = circleflip_recursive_sanitize($new_instance);
		return $new_instance;
	}
}