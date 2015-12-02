<?php
/** Menu block **/

if(!class_exists('header_text')) {
	class header_text extends header_builder {

		//set and create block
		function __construct() {
			$block_options = array(
				'image' => 'spacer.png',
				'class' => 'hbSprite-spacer icon-info',
				'name' => 'Text',
				'imagedesc' => '',
				'desc' => 'This is an alert Block to show any warning, alert or confirmation message to the user'
			);
			//create the block
			parent::__construct('header_text', $block_options);
		}

		function form($instance,$header_name) {
			$defaults = array(
				'align' => '',
				'text' => '',
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
						Text
					</p>
				</div>
				<?php echo creiden_hb_input($header_name,$id_base, $order, 'text',htmlspecialchars($text)); ?>
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
			<!-- Header Text -->
			<div class="headerText <?php echo esc_attr($align_class);?>">
				<p><?php echo htmlspecialchars_decode($text); ?></p>
			</div>
			<!-- Header Text End -->
			<?php
		}

	}
}