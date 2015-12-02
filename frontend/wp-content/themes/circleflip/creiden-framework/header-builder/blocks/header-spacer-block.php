<?php
/** Menu block **/

if(!class_exists('header_spacer')) {
	class header_spacer extends header_builder {

		//set and create block
		function __construct() {
			$block_options = array(
				'image' => 'spacer.png',
				'class' => 'hbSprite-spacer icon-doc-landscape',
				'name' => 'Spacer',
				'imagedesc' => '',
				'desc' => 'This is an alert Block to show any warning, alert or confirmation message to the user'
			);
			//create the block
			parent::__construct('header_spacer', $block_options);
		}

		function form($instance,$header_name) {
			$defaults = array(
				'spacer' => '',
				'align' => '',
			);
			$instance = wp_parse_args($instance, $defaults);
			extract($instance);
			?>
			<div class="modalRow row clearfix">
					<div class="col-sm-7">
						<p class="settingName">
							Align element
						</p>
						<span class="settingNote">Note: Center alignment won't allow you to add another element in this header row.</span>
					</div>
					<?php echo creiden_hb_select($header_name,$id_base,$order,array('Left','Center','Right'),'align',$align); ?>
				</div>
			<div class="modalRow row clearfix">
				<div class="col-sm-7">
					<p class="settingName">
						Horizontal space in pixels
					</p>
					<span class="settingNote">Add space between the elements, Example: 48px</span>
				</div>
				<?php echo creiden_hb_input($header_name,$id_base, $order, 'spacer',$spacer); ?>
			</div>
			
		<?php
		}

		function block($instance) {
			extract($instance);
			switch ($align) {
				case 0:
					$align_class = 'headerLeft';
					break;
				case 1:
					$align_class = 'headerCenter';
					break;
				case 2:
					$align_class = 'headerRight';
					break;
				default:
					$align_class = 'headerLeft';
					break;
			}
			?>
			<!-- Header Spacer -->
			<div class="headerSpacer <?php echo esc_attr($align_class) ?>" style="width: <?php echo esc_attr($spacer); ?>;">
				<div class="headerSpacerVert" style="height: <?php echo esc_attr($spacer); ?>"></div>
			</div>
			<!-- Header Spacer End -->
			<?php
		}

	}
}