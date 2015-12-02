<?php
/** Menu block **/

if(!class_exists('header_button')) {
	class header_button extends header_builder {

		//set and create block
		function __construct() {
			$block_options = array(
				'image' => 'spacer.png',
				'class' => 'hbSprite-spacer icon-link',
				'name' => 'Button',
				'imagedesc' => '',
				'desc' => 'This is an alert Block to show any warning, alert or confirmation message to the user'
			);
			//create the block
			parent::__construct('header_button', $block_options);
		}

		function form($instance,$header_name) {
			$defaults = array(
				'align' => '',
				'text' => '',
				'link' => ''
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
				<?php echo creiden_hb_input($header_name,$id_base, $order, 'text',$text); ?>
			</div>
			<div class="modalRow row clearfix">
				<div class="col-sm-7">
					<p class="settingName">
						Link
					</p>
				</div>
				<?php echo creiden_hb_input($header_name,$id_base,$order,'link',$link); ?>
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
			<div class="headerButton <?php echo esc_attr($align_class);?>">
				<a href="<?php echo esc_url($link); ?>">
					<span><?php echo esc_html($text); ?></span>
					<span class="btnBefore"></span>
	    			<span class="btnAfter"></span>
				</a>
			</div>
			<!-- Header Text End -->
			<?php
		}

	}
}