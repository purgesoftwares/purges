<?php
/** Menu block **/

if(!class_exists('header_menu')) {
	class header_menu extends header_builder {

		//set and create block
		function __construct() {
			$block_options = array(
				'image' => 'menu.png',
				'class' => 'hbSprite-menu icon-menu',
				'name' => 'Menu',
				'imagedesc' => '',
				'desc' => 'This is an alert Block to show any warning, alert or confirmation message to the user'
			);
			//create the block
			parent::__construct('header_menu', $block_options);
		}

		function form($instance,$header_name) {
			$defaults = array(
				'align' => '',
				'menu_select' => 0,
				'toggled_menu' => '',
				'search_icon' => '',
				'responsive_menu' => '',
				'uber_menu' => ''
			);
			$instance = wp_parse_args($instance, $defaults);
			extract($instance);
			?>
			<div class="modalRow row clearfix menuAlign">
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
						Select Menu
					</p>
				</div>
				<?php 
				$nav_menus = wp_get_nav_menus( array('orderby' => 'name') );
				$nav_menus_names = array();
				foreach ($nav_menus as $key => $value) {
					//array_push($nav_menus_names,$value->name);
					$nav_menus_names[$value->term_id] = $value->name;
				}
				echo creiden_hb_select($header_name,$id_base,$order,$nav_menus_names,'menu_select',$menu_select); ?>
			</div>
			<div class="modalRow row clearfix toggleMenu">
				<div class="col-sm-7">
					<label for="toggledMenu">
						<p class="settingName">
							Toggled Menu
						</p> <span class="settingNote">A toggle button will appear instead of the menu.</span></label>
				</div>
				<?php echo creiden_hb_checkbox($header_name,$id_base, $order, 'toggled_menu',$toggled_menu); ?>
			</div>
			<div class="modalRow row clearfix">
				<div class="col-sm-7">
					<label for="fixedRow">
						<p class="settingName">
							Add search icon to the menu
						</p> </label>
				</div>
				<?php echo creiden_hb_checkbox($header_name,$id_base, $order, 'search_icon',$search_icon); ?>
			</div>
			<div class="modalRow row clearfix">
				<div class="col-sm-7">
					<label for="responsiveMenu">
						<p class="settingName">
							Un-responsive menu 
						</p> <span class="settingNote">This option will disable the responsive style of the menu.</span></label>
				</div>
				<?php echo creiden_hb_checkbox($header_name,$id_base, $order, 'responsive_menu',$responsive_menu); ?>
			</div>
			<div class="modalRow row clearfix">
				<div class="col-sm-7">
					<label for="responsiveMenu">
						<p class="settingName">
							Use Ubermenu
						</p> <span class="settingNote">Please make sure that the ubermenu plugin is installed.</span></label>
				</div>
				<?php echo creiden_hb_checkbox($header_name,$id_base, $order, 'uber_menu',$uber_menu); ?>
			</div>
		<?php
		}

		function block($instance) {
			extract($instance);
			global $hb_menu_selected;
			if($align == 0) {
				$align = 'headerLeft';
			} else if($align == 1) {
				$align = 'headerCenter';
			} else {
				$align = 'headerRight';
			}
			$nav_menus = wp_get_nav_menus( array('orderby' => 'name') );
			$nav_menus_names = array();
			foreach ($nav_menus as $key => $value) {
				//array_push($nav_menus_names,$value->name);
				$nav_menus_names[$value->term_id] = $value->name;
			}
			$hb_menu_selected = $menu_select;
			if($search_icon) {
				add_filter( 'wp_nav_menu_items', array($this,'circleflip_search_icon'), 10, 2 );	
			}
			?>
			<!-- Menu -->
			<div class="<?php echo ($responsive_menu) ? '': 'responsiveCheck '; 
			echo ($toggled_menu) ? 'toggledMenu ':'headerMenu ';
			echo $align;
			if ( is_user_logged_in() ) {echo ' adminTop';} ?>">
				<div class="toggleMenuBtn"><span class="icon-menu"></span></div>
				<div class="menuWrapper">
					<div class="closeMenu"><span class="icon-cancel"></span></div>
					<?php
					if ($uber_menu == 0) {
						wp_nav_menu(
							array(
							'menu' => $menu_select, 
							'menu_class' => 'clearfix menuContent', 
							'theme_location' => 'primary',
							'depth' => 13,
							'fallback_cb' => false, 
							'walker' => new Circleflip_Nav_Walker
							)
						);
					} else {
						if(function_exists('ubermenu')) {
							ubermenu( 'main' , array( 'menu' => $menu_select ) );	
						}
					}
					?>
				</div>
			</div>
			<!-- Menu End -->
			<?php 
		}

		function circleflip_search_icon( $items, $args ) {
			global $hb_menu_selected;
			$current_menu = wp_get_nav_menu_object($args->menu);
			if($current_menu && $current_menu->term_id === (int) $hb_menu_selected) {
				ob_start();
				echo '<div>';
					circleflip_navbar_searchform(true,false,false);
				echo '</div>';
				$items .= '<li class="headerMenuSearch"><span class="icon-search-1"></span>' . ob_get_clean() . '</li>';
			}
			return $items;
		}

	}
}