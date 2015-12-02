<?php

/* If the user can't edit theme options, no use running the header builder */

add_action('init', 'circleflip_header_builder_rolescheck' );

function circleflip_header_builder_rolescheck () {
	if ( current_user_can( 'edit_theme_options' ) ) {
		// If the user can edit theme options, let the fun begin!
		add_action( 'admin_menu', 'circleflip_header_builder_add_page');
		add_action( 'admin_init', 'circleflip_header_builder_init' );
		require_once 'header-config.php';
	}
}

/* Add a subpage called "Theme Options" to the appearance menu. */

if ( !function_exists( 'circleflip_header_builder_add_page' ) ) {

	function circleflip_header_builder_add_page() {
		$hb_page = add_theme_page(__('Header Builder', 'circleflip-header_builder'), __('Header Builder', 'circleflip-header_builder'), 'edit_theme_options', 'header_builder','circleflip_header_builder_page');

		// Load the required CSS and javscript
		add_action( 'admin_enqueue_scripts', 'circleflip_header_builder_load_scripts');
		add_action( 'admin_print_styles-' . $hb_page, 'circleflip_header_builder_load_styles' );
	}

}
// initialize the header builder
function circleflip_header_builder_init() {
	// Registers the settings fields and callback
	$hb_names = get_option('hb_names',array());
	if(isset($hb_names) && !empty($hb_names)) {
		foreach ($hb_names as $key => $value) {
			register_setting( "header_builder_$key", $value );	
		}	
	}
	register_setting( 'header_builder_names', 'hb_names' );

	// Change the capability required to save the 'optionsframework' options group.
	add_filter( 'option_page_capability_header_builder', 'circleflip_header_builder_page_capability' );
}


/**
 * Ensures that a user with the 'edit_theme_options' capability can actually set the options
 * See: http://core.trac.wordpress.org/ticket/14365
 *
 * @param string $capability The capability used for the page, which is manage_options by default.
 * @return string The capability to actually use.
 */

function circleflip_header_builder_page_capability( $capability ) {
	return 'edit_theme_options';
}

function circleflip_header_builder_load_scripts($hook) {
	if ( 'appearance_page_header_builder' != $hook )
        return;
	
	wp_register_script( 'bootstrap-3-modal'	    , get_template_directory_uri() . '/creiden-framework/header-builder/js/bootstrap.3.modal.js', array( 'jquery' ) );
	wp_register_script( 'bootstrap-js-tooltip'  , get_template_directory_uri() . '/creiden-framework/header-builder/js/tooltip.js', array('jquery'), time(), true);
	wp_register_script( 'bootstrap-3-popover'   , get_template_directory_uri() . '/creiden-framework/header-builder/js/bootstrap.3.popover.js', array( 'jquery','bootstrap-js-tooltip' ) );
	wp_register_script( 'creiden-headerbuilder' , get_template_directory_uri() . '/creiden-framework/header-builder/js/header-builder.js', array( 'jquery','bootstrap-js-tooltip','thickbox' ) );
	wp_register_script( 'crdn-stackable-modals' , get_template_directory_uri() . '/creiden-framework/content-builder/assets/js/jquery.stackablemodal.js', array( 'jquery', 'bootstrap-3-modal' ), null, true );
	wp_enqueue_script('jquery');
	wp_enqueue_script('underscore');
	wp_enqueue_script('jquery-ui-sortable');
	wp_enqueue_script('jquery-ui-tabs');
	wp_enqueue_script('jquery-ui-resizable');
	wp_enqueue_script('jquery-ui-draggable');
	wp_enqueue_script('jquery-ui-droppable');
	wp_enqueue_script('iris');
	wp_enqueue_script('wp-color-picker');
	wp_enqueue_script('bootstrap-js-tooltip');
	wp_enqueue_script('bootstrap-3-popover');
	wp_enqueue_script('bootstrap-3-modal');
	wp_enqueue_script('thickbox');
	wp_enqueue_script('crdn-stackable-modals');
	wp_enqueue_script('creiden-headerbuilder');
	
	wp_enqueue_media();
	wp_localize_script('creiden-headerbuilder', 'global_creiden' , array(
		'ajax_url' => admin_url('admin-ajax.php'),
	));
	
}

function circleflip_header_builder_load_styles() {
	 wp_enqueue_style(	'hbBootstrap'		 , get_template_directory_uri() . '/creiden-framework/header-builder/css/bootstrap.css');
	 wp_enqueue_style(	'hbStyle'			 , get_template_directory_uri() . '/creiden-framework/header-builder/css/style.css');
	 wp_enqueue_style( 'fontello', get_template_directory_uri() . '/css/fonts/fonts.css');
	 wp_enqueue_style(	'wp-color-picker');
	 wp_enqueue_style('thickbox');
	 wp_enqueue_style('wp-color-picker');
}
if ( !function_exists( 'circleflip_header_builder_page' ) ) :
function circleflip_header_builder_page() {
	$hb_names = get_option('hb_names');
	?>
		<div id="tabs">
			<div class="col-sm-12">
				<form action="options.php" id="hbNamesForm" class="<?php echo isset($hb_names) && !empty($hb_names) ? '' : 'noHeaders';  ?>" method="post">
				  	<?php settings_fields('header_builder_names');?>
				  	<div class="headerGear" data-toggle="modal" data-target="#addHeaderModal">
						<span class="">+</span>
					</div>
					<?php if(isset($hb_names) && empty($hb_names)) {
						echo "<p class='firstHeaderText'>Start building your first header</p>";
					};?>
					
					<?php ?>
				  	<div id="addHeaderModal" class="modal fade hbModal">
				  		<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-body">
								  	<?php
									$counter = 0; 
										if($hb_names) {
											    foreach ($hb_names as $key => $value) {
										    ?>
							  				<div class="modalRow row clearfix" style="display: none">
												<div class="col-sm-7">
													<p class="settingName">
														Header name
													</p>
												</div>
												<div class="col-sm-5">
													<input type="hidden" data-originalValue="<?php echo esc_attr($value) ?>" readonly class="hb_names" id="hb_names_input_<?php echo esc_attr($counter); ?>" name="hb_names[<?php echo esc_attr($counter)?>]" value="<?php echo esc_attr($value) ?>"/>
													<!-- <p><?php echo $value ?></p> -->
												</div>
											</div>
											<?php  
												$counter++; }
										}
									?>
									<div class="modalRow row clearfix">
										<div class="col-sm-7">
											<p class="settingName">
												Header name
											</p>
										</div>
										<div class="col-sm-5">
											<input type="text" class="hb_names" name="hb_names[<?php echo esc_attr($counter)?>]" value=""/>  
										</div>
									</div>
					  			</div>  
		  						<div class="modal-footer">
									<button class="btn btn-primary saveName" type="submit">
										Save Name
									</button>
									<button type="button" class="btn btn-default" data-dismiss="modal">
										Close
									</button>
								</div>
		  					</div>
		  				</div>
		  			</div>
				</form>
				<ul class="headerSelectors">
					<?php 
					if($hb_names) {
						foreach ($hb_names as $key => $value) { ?>
							<li><a href="#tabs-<?php echo esc_attr($key); ?>"><?php echo esc_html($value); ?></a></li>
						<?php }
					}					
					 ?>
				</ul>
			</div> 
			<?php 
			if($hb_names) {
			foreach ($hb_names as $key => $value) {
				$name = "$value";
				?>
				<div id="tabs-<?php echo esc_attr($key); ?>">
					<div class="col-sm-3 grid3">
						<div class="hbItems">
							<ul>
								<?php 
									$header_builder = new header_builder;
									$header_builder->render_blocks($name);
								?>
							</ul>
						</div>
					</div>
					<div class="col-sm-9 grid3">
						<form action="options.php" method="post" id="creiden-form">
							<?php settings_fields("header_builder_$key"); ?>
								<div class="hbDropArea">
									<?php 
									$hb_blocks = get_option($name,array());
									$temp_blocks['settings'] = array();
									$temp_blocks = $hb_blocks;
									$defaults = array(
										'settings' => array(
											'header_type' => 0,
											'bgColor' => '',
											'opacity' => '100',
											'header_content_color' => 1
										)
									);
									$temp_blocks = wp_parse_args($temp_blocks, $defaults);
									if(isset($hb_blocks) && !empty($hb_blocks)) {
										$hb_blocks = $header_builder->prepare_blocks_array($hb_blocks,$name);
										$header_builder->render_blocks_admin($hb_blocks,$name);
									}
									
									?>
								</div>
							<div class="hbHeaderSettings clearfix">
								<div class="pull-left">
									<button type="button" data-toggle="modal" data-target="#<?php echo "modal_$value"; ?>" class="btn btn-info" ><?php echo "$value Settings"; ?></button>
								</div>
								<div class="header_buttons_settings pull-left">
									<button class="btn btn-default clear_headers">Clear All</button>
								</div>
								<div id="optionsframework-submit" class="pull-right">
									<button type="submit" id="header_builder-save-theme-opts" class="btn btn-primary" ><?php echo "Save $value Options"; ?></button>
								</div>
								<div class="pull-right">
									<button type="submit" rel="<?php echo esc_attr($value); ?>" class="btn delete_header btn-danger" ><?php echo "Delete $value"; ?></button>
								</div>
							</div>
							
							
							
							<div class="modal fade hbModal" id="<?php echo "modal_$value"; ?>">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">
												<span aria-hidden="true">×</span><span class="sr-only"></span>
											</button>
											<h4 class="modal-title" id="myModalLabel"><?php echo "<span>$value</span> settings"; ?></h4>
										</div>
										<div class="modal-body">
											<div class="modalRow row clearfix headerType selectSwitcherField">
												<div class="col-sm-7">
													<p class="settingName">
														Header type
													</p>
												</div>
												<div class="col-sm-5">
													<select name="<?php echo esc_attr($name.'[settings][header_type]')?>">
														<option value="0" <?php echo ($temp_blocks['settings']['header_type'] == 0) ?  "selected='selected'" : '' ?>>Default Header</option>
														<!-- <option value="1" <?php //echo ($temp_blocks['settings']['header_type'] == 1) ?  "selected='selected'" : '' ?>>Side Header</option> -->
														<option value="2" <?php echo ($temp_blocks['settings']['header_type'] == 2) ?  "selected='selected'" : '' ?>>Overlayed Header</option>
													</select>
												</div>
											</div>
											<div class="selectSwitcher selectSwitcher_2 selectSwitcher_0 settingsColorPicker">
												<div class="modalRow row clearfix">
													<div class="col-sm-7">
														<p class="settingName">
															Backround color
														</p>
													</div>
													<div class="col-sm-5">
														<span class="aqpb-color-picker">
															<input type="text" class="input-color-picker" value="<?php echo $temp_blocks['settings']['bgColor'] ? esc_attr($temp_blocks['settings']['bgColor']) : '#ffffff' ?>" name="<?php echo esc_attr($name.'[settings][bgColor]')?>" data-default-color="#e32831"/>
														</span>
												    </div>
												</div>
												<div class="modalRow row clearfix">
													<div class="col-sm-7">
														<p class="settingName">
															Opacity
														</p>
														<span class="settingNote">Type the background opacity between 0 to 100.</span>
													</div>
													<div class="col-sm-5">
														<span class="aqpb-color-picker">
															<input type="text" value="<?php echo esc_attr($temp_blocks['settings']['opacity']) ?>" name="<?php echo esc_attr($name.'[settings][opacity]')?>"/>
														</span>
												    </div>
												</div>
											</div>
											<div class="modalRow row clearfix selectSwitcher selectSwitcher_2">
												<div class="col-sm-7">
													<p class="settingName">
														Content Color
													</p>
													<span class="settingNote">Note: This option only works to the 'Overlayed Header' and it will not apply to the content colors of the fixed rows.</span>
												</div>
												<div class="col-sm-5">
													<select name="<?php echo esc_attr($name.'[settings][header_content_color]')?>">
														<option value="0" <?php echo ($temp_blocks['settings']['header_content_color'] == 0) ?  "selected='selected'" : '' ?>>Light Content</option>
														<option value="1" <?php echo ($temp_blocks['settings']['header_content_color'] == 1) ?  "selected='selected'" : '' ?>>Dark Content</option>
													</select>
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<p>
												Add custom class
											</p>
											<input id="customClass" type="text">
											<button type="button" class="btn btn-primary" data-dismiss="modal">
												Done
											</button>
										</div>
									</div>
								</div>
							</div>
							
						</form>
					</div>
				</div>
			<?php } 
			}
			?>
			<?php	
			if(isset($header_builder)) {
				$header_builder->icon_selector_modal();	
			}
			?>
		</div>
		<div class="hbPreview col-sm-12">
			<header id="branding" role="banner" class="defaultHeader">
			</header>
		</div>
<?php 
}
endif;