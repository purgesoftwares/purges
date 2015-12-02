<?php
/** Notifications block **/

if(!class_exists('header_row')) {
	class header_row extends header_builder {

		//set and create block
		function __construct() {
			$block_options = array(
				'image' => 'row.png',
				'class' => 'hbSprite-headerRow icon-progress-0',
				'name' => 'Header Row',
				'imagedesc' => '',
				'desc' => 'This is an alert Block to show any warning, alert or confirmation message to the user'
			);
			//create the block
			parent::__construct('header_row', $block_options);
		}

		function form($instance,$header_name) {
			$defaults = array(
				'row_style' => 0,
				'content_color' => 1,
				'stickyrow' => 0,
				'invisible_fixed_row' => 0,
				'bg_color' => '#fff',
				'sticky_responsive' => 0
			);
			$instance = wp_parse_args($instance, $defaults);
			extract($instance);
			?>
			<div class="modalRow row clearfix">
				<div class="col-sm-7">
					<p class="settingName">
						Row Height
					</p>
					<span class="settingNote">Note: For the small style, logo builder's style won't work.</span>
				</div>
				<?php echo creiden_hb_select($header_name,$id_base,$order,array('Large','Narrow'),'row_style',$row_style); ?>
			</div>
			<div class="modalRow row clearfix">
				<div class="col-sm-7">
					<p class="settingName">
						Background color
					</p>
				</div>
				<?php echo creiden_hb_color_picker($header_name,$id_base, $order, 'bg_color', $bg_color); ?>
			</div>
			<div class="modalRow row clearfix">
				<div class="col-sm-7">
					<p class="settingName">
						Content color
					</p>
				</div>
				<?php echo creiden_hb_select($header_name,$id_base,$order,array('Light Content','Dark Content'),'content_color',$content_color); ?>
			</div>
			<div class="modalRow row clearfix">
				<div class="col-sm-7">
					<label for="fixedRow">
						<p class="settingName">
							Sticky Row
						</p> </label>
				</div>
				<?php echo creiden_hb_select($header_name,$id_base,$order,array('Nope','Sticky','Invisible Sticky'),'stickyrow',$stickyrow); ?>
			</div>
			<div class="modalRow row clearfix">
				<div class="col-sm-7">
					<p class="settingName">
						Disable sticky on small devices.
					</p>
				</div>
				<?php echo creiden_hb_checkbox($header_name,$id_base, $order, 'sticky_responsive',$sticky_responsive); ?>
			</div>		
			<?php
		}

		function block($instance,$settings) {
			$defaults = array(
				'row_style' => 0,
				'content_color' => 1,
				'stickyrow' => 0,
				'bg_color' => '#fff',
				'sticky_responsive' => 0
			);
			$instance = wp_parse_args($instance, $defaults);
			
			extract($instance);
			switch ($settings['header_content_color']) {
				case 0:
					$content_color_settings = 'lightContent ';
					break;
				case 1:
					$content_color_settings = 'darkContent ';
					break;
				default:
					$content_color_settings = 'lightContent ';
					break;
			}
			?>
			<!-- Top Header -->
			<div class="rowWrapper <?php echo $row_style ? 'topHeader ' : "mainHeader ";
							  echo ($settings['header_type'] == 2) ? $content_color_settings : ($content_color ? 'darkContent ' : 'lightContent ');
							  foreach ($children as $key => $value) {
                                  echo (($value['id_base'] !== 'header_logo' || $row_style) ? '' : "logoSiblings_$order ");
                                  echo (($value['id_base'] !== 'header_ad' || $row_style) ? '' : "logoSiblings_$order ");
                              }
							  echo $stickyrow == 1 ? 'stickyHeader ' : '';
							  echo $stickyrow == 2 ? 'stickyHeader justFixed ' : '';
							  echo $sticky_responsive ? '' : 'responsiveCheck ';
							  echo ( is_user_logged_in() ) ? 'adminTop': ''; ?>"
							  content-color="<?php echo $content_color ? 'darkContent' : 'lightContent'; ?>"
							  style="background-color: <?php echo esc_attr($bg_color); ?>;">
				<div class="headerWrapper">
					<div class="container">
						<div class="headerRow">
							<?php if($settings['header_type'] == 1) { ?>
								<!-- Side Header Toggle -->
								<div class="sideToggle">
									<span class="icon-menu"></span>
								</div>
								<!-- Side Header Toggle End -->	
							<?php } 
							if(isset($children)) {
								$this-> render_blocks_view($header_name,$children);
							}
							?>
						</div>
					</div>
				</div>
					<?php 
					// If there is a logo Add this style
					if(isset($children)) {
                        $header_heights = array();
                        $logoheight = 0;
                        foreach ($children as $key => $value) {
                            if($value['id_base'] == 'header_logo') {
                                if($value['logo_builder']){
                                    array_push ($header_heights,cr_get_option('header_height',0));
                                } else {
                                     $logoheight = intVal(substr($value['logo_height'],0,-2),10) + intVal(substr($value['logo_margin_top'],0,-2),10) + intVal(substr($value['logo_margin_bottom'],0,-2),10);
                                    array_push ($header_heights,$logoheight);
                                }
                            } else if($value['id_base'] == 'header_ad') {
                                array_push ($header_heights,intVal(substr($value['ad_height'],0,-2),10));
                            }
                        }
                        array_push ($header_heights,50);
                        $header_heights = max($header_heights); // Get maximum Height in the row
						foreach ($children as $key => $value) {
							if($value['id_base'] == 'header_logo' || $value['id_base'] == 'header_ad') {
								 // large and not sideheader
								if(!$row_style) { 
                                ?>
								<style>
									<?php echo ".logoSiblings_$order";?> .headerMenu.responsiveCheck,
									<?php echo ".logoSiblings_$order";?> .headerMenu .menuContent > li > a,
									<?php echo ".logoSiblings_$order";?> .headerMenuSearch > span,
									<?php echo ".logoSiblings_$order";?> .headerMenu .menuContent,
									<?php echo ".logoSiblings_$order";?> .headerMenu #megaMenu ul.megaMenu li.menu-item.ss-nav-menu-mega > a, 
									<?php echo ".logoSiblings_$order";?> .headerMenu #megaMenu ul.megaMenu li.menu-item.ss-nav-menu-mega > span.um-anchoremulator,
									<?php echo ".logoSiblings_$order";?> .headerMenu #megaMenu .headerMenuSearch > span,
									<?php echo ".logoSiblings_$order";?> .headerMenu .ubermenu-nav > .ubermenu-item > a,
                                    <?php echo ".logoSiblings_$order";?> .headerMenu .ubermenu-nav > li > a,
                                    
									<?php echo ".logoSiblings_$order";?> .headerSocial,
									<?php echo ".logoSiblings_$order";?> .toggledMenu,
									<?php echo ".logoSiblings_$order";?> .headerSpacer,
									<?php echo ".logoSiblings_$order";?> .headerText p,
									<?php echo ".logoSiblings_$order";?> .headerButton {
										height: <?php echo $header_heights + 20;echo 'px'; ?>;
									}
                                    @media (min-width: 400px) {
                                        <?php echo ".logoSiblings_$order";?> .headerImage,
                                        <?php echo ".logoSiblings_$order";?> .logoWrapper {
                                            height: <?php echo $header_heights;echo 'px'; ?> !important;
                                        }
                                    }
								</style>
								<?php
                                    break;
									}
							}
						}
					}
				?>
		</div>
		<?php
		}

	}
}