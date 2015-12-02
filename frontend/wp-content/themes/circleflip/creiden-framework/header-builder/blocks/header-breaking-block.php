<?php
/** Menu block **/

if(!class_exists('header_breaking')) {
	class header_breaking extends header_builder {

		//set and create block
		function __construct() {
			$block_options = array(
				'image' => 'breaking.png',
				'class' => 'hbSprite-breakingNews icon-newspaper',
				'name' => 'Breaking News',
				'imagedesc' => '',
				'desc' => 'This is an alert Block to show any warning, alert or confirmation message to the user'
			);
			//create the block
			parent::__construct('header_breaking', $block_options);
		}

		function form($instance,$header_name) {
			$defaults = array(
				'title' => '',
				'type' => '',
				'text' => '',
				'categories' => -1,
				'posts_number' => 5 
			);
			$options_categories = array();
			$options_categories_obj = get_categories();
			foreach ($options_categories_obj as $category) {
				$options_categories[$category->cat_ID] = $category->cat_name;
			}
			$instance = wp_parse_args($instance, $defaults);
			extract($instance);
			?>
			<div class="modalRow row clearfix">
				<div class="col-sm-7">
					<p class="settingName">
						Title
					</p>
				</div>
				<?php echo creiden_hb_input($header_name,$id_base,$order, 'title', $title); ?>
			</div>
			<div class="modalRow row clearfix selectSwitcherField">
				<div class="col-sm-7">
					<p class="settingName">
						What to Show
					</p>
					<span class="settingNote">Select the content of the Breaking Area</span>
				</div>
				<?php echo creiden_hb_select($header_name,$id_base,$order,array('Latest Posts','Custom News'),'type',$type); ?>
			</div>
			<div class="modalRow row clearfix selectSwitcher selectSwitcher_0">
				<div class="col-sm-7">
					<p class="settingName">
						Number Of Posts
					</p>
				</div>
				<?php echo creiden_hb_input($header_name,$id_base,$order, 'posts_number', $posts_number); ?>
			</div>
			<div class="modalRow row clearfix selectSwitcher selectSwitcher_0">
				<div class="col-sm-7">
					<p class="settingName">
						Breaking Area Selected Categories
					</p>
					<span class="settingNote">Select the categories you want</span>
				</div>
				<?php echo creiden_hb_select_multiple($header_name,$id_base,$order,$options_categories,'categories',$categories,'multiple'); ?>
			</div>
			<div class="modalRow row clearfix selectSwitcher selectSwitcher_1">
				<div class="col-sm-7">
					<p class="settingName">
						Custom Text
					</p>
					<span class="settingNote">Put the sentences you want to show in the Breaking Area here separated by commas ","</span>
				</div>
				<?php echo creiden_hb_input($header_name,$id_base,$order, 'text', $text); ?>
			</div>
		<?php
		}

		function block($instance) {
			extract($instance);
			if($type) {
				$custom_breaking = explode(',', $text);
				?>
				<div class="slidingText full">
					<div class="movingHead left">
						<h2><?php echo esc_html($title) ?></h2>
					</div>
					<div class="movingText left">
						<ul id="js-news" class="js-hidden">
							<?php foreach ($custom_breaking as $key => $value) { 
								?>
					    		<li class="news-item"><a href="#"><h6><?php echo esc_html($value); ?></h6></a></li>
					    	<?php } ?>
						</ul>
					</div>
				</div>
			<?php
			} else {
				$breakNumPosts = $posts_number ? $posts_number : 5;
				$cat_ids = $categories ? implode(',', $categories) : -1 ; 
				$args = array(
					'showposts'  => $breakNumPosts,
					'category' => $cat_ids,
					'order'      => 'DESC',
					'suppress_filters' => false
				);
				$ticker_posts = get_posts( $args );
				if ($ticker_posts) {
			?>
			<div class="slidingText full">
				<div class="movingHead left">
					<h2><?php echo esc_html($title) ?></h2>
				</div>
				<div class="movingText left">
					<ul id="js-news" class="js-hidden">
						<?php foreach ($ticker_posts as $key => $value) { 
							?>
				    		<li class="news-item"><a href="<?php echo esc_url($value->guid) ?>"><h6><?php echo esc_html($value->post_title); ?></h6></a></li>
				    	<?php } ?>
					</ul>
				</div>
			</div>
		<?php
			}
				
			}
		}

	}
}