<?php
/**
 * Builder Page
 *
 * @description Main admin UI settings page
 * @package Aqua Page Builder
 *
 */
// Debugging
if(isset($_POST) && $this->args['debug'] == true) {
	echo '<pre>';
	print_r($_POST);
	echo '</pre>';
}

// Permissions Check
global $post;
if ( ! current_user_can( 'edit_post', $post->ID ) )
	wp_die( __( 'Cheatin&#8217; uh?','rojo' ) );

$messages = array();

// Get selected template id
$selected_template_id = isset($_REQUEST['template']) ? (int) $_REQUEST['template'] : 0;

// Actions
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'edit';
$template = isset($_REQUEST['template']) ? $_REQUEST['template'] : 0;


// Template title & layout
$template_name = isset($_REQUEST['template-name']) && !empty($_REQUEST['template-name']) ? htmlspecialchars($_REQUEST['template-name']) : 'No Title';

// Get all templates
$templates = $this->get_templates();

// Get recently edited template
$recently_edited_template = (int) get_user_option( 'recently_edited_template' );

if( ! isset( $_REQUEST['template'] ) && $recently_edited_template && $this->is_template( $recently_edited_template )) {
	$selected_template_id = $recently_edited_template;
} elseif ( ! isset( $_REQUEST['template'] ) && $selected_template_id == 0 && !empty($templates)) {
	$selected_template_id = $templates[0]->ID;
}


//define selected template object
$selected_template_object = get_post($selected_template_id);

// saving action
switch($action) {

	case 'create' :
		$new_id = $this->create_template($template_name);

		if(!is_wp_error($new_id)) {
			$selected_template_id = $new_id;

			//refresh templates var
			$templates = $this->get_templates();
			$selected_template_object = get_post($selected_template_id);

			$messages[] = '<div id="message" class="updated"><p>' . __('The ', 'circleflip-builder') . '<strong>' . $template_name . '</strong>' . __(' page template has been successfully created', 'circleflip-builder') . '</p></div>';
		} else {
			$errors = '<ul>';
			foreach( $new_id->get_error_messages() as $error ) {
				$errors .= '<li><strong>'. $error . '</strong></li>';
			}
			$errors .= '</ul>';

			$messages[] = '<div id="message" class="error"><p>' . __('Sorry, the operation was unsuccessful for the following reason(s): ', 'circleflip-builder') . '</p>' . $errors . '</div>';
		}

		break;

	case 'update' :
		echo '<pre>';
		print_r($_POST);
		echo '</pre>';
		die();
		$blocks = isset($_REQUEST['aq_blocks']) ? $_REQUEST['aq_blocks'] : '';

		$this->update_template($selected_template_id, $blocks, $template_name);

		//refresh templates var
		$templates = $this->get_templates();
		$selected_template_object = get_post($selected_template_id);

		$messages[] = '<div id="message" class="updated"><p>' . __('The ', 'circleflip-builder') . '<strong>' . $template_name . '</strong>' . __(' page template has been updated', 'circleflip-builder') . '</p></div>';
		break;

	case 'delete' :

		$this->delete_template($selected_template_id);

		//refresh templates var
		$templates = $this->get_templates();
		$selected_template_id =	!empty($templates) ? $templates[0]->ID : 0;
		$selected_template_object = get_post($selected_template_id);

		$messages[] = '<div id="message" class="updated"><p>' . __('The template has been successfully deleted', 'circleflip-builder') . '</p></div>';
		break;
}

global $current_user;
update_user_option($current_user->ID, 'recently_edited_template', $selected_template_id);

//display admin notices & messages
if(!empty($messages)) foreach($messages as $message) { echo $message; }

//disable blocks archive if no template
$disabled = $selected_template_id === 0 ? 'metabox-holder-disabled' : '';

?>

<div class="wrap" style="clear: both;width:100%">
	<div id="page-builder-frame">
		<div id="page-builder-column" class="metabox-holder">
			<div id="page-builder-archive" class="postbox">
				<h3 class="hndle"><span><?php _e('Available Blocks', 'circleflip-builder') ?></span><span id="removing-block"><?php _e('Deleting', 'circleflip-builder') ?></span></h3>
				<div class="inside">
					<ul id="blocks-archive" class="cf">
						<?php $this->blocks_archive() ?>
					</ul>
					<div class="modal fade" id="crdn-cf-gmap-modal">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-body">
									<div id="cr-map-canvas" style="width: 500px; height: 500px;"></div>
									<div id="cr-map-side-controls" style="width: 200px; float: right;">
										<label>
											<input type="checkbox" id="allow-reverse-geocode">Allow Reverse Geocoding
										</label>
										<div id="reverse-geocode-slider"></div>
										<span id="reverse-geocode-value"></span>
									</div>
								</div>
								<div class="modal-footer">
									<button id="cr-map-done" class="button-primary" type="button" data-dismiss="modal">Done</button>
									<button id="cr-map-cancel" class="button-secondary"  type="button" data-dismiss="modal">Cancel</button>
								</div>
							</div>
						</div>
					</div>
					<div class="modal fade" id="crdn-icon-selector-modal">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-body">
									<div class="icons-box">
										<?php $icons = circleflip_get_entypo_icons() ?>
										<?php foreach($icons as $icon) : ?>
											<?php
												if($icon == 'none'){
													echo '<span class="iconfontello none" data-icon="none">none</span>';
												}else{


											 ?>
											<i class="iconfontello <?php echo esc_attr($icon) ?>" data-icon="<?php echo esc_attr($icon) ?>"></i>
											<?php } ?>
 										<?php endforeach; ?>
									</div>
									<div class="icon-preview">
										<i class="iconfontello"></i>
										<p class="icon-name"></p>
									</div>
								</div>
								<div class="modal-footer">
									<button class="crdn-icon-selector-done button-primary" type="button">Done</button>
									<button class="button-secondary"  type="button" data-dismiss="modal">Cancel</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div id="page-builder-fixed">
			<div id="page-builder">
				<div class="aqpb-tabs-nav">

					<div class="aqpb-tabs-arrow aqpb-tabs-arrow-left">
						<a>&laquo;</a>
					</div>

					<div class="aqpb-tabs-wrapper">
						<div class="aqpb-tabs">

							<?php
							foreach ( (array) $templates as $template ) {
								if($selected_template_id == $template->ID) {
									echo '<span class="aqpb-tab aqpb-tab-active aqpb-tab-sortable">'. htmlspecialchars($template->post_title) .'</span>';
								} else {
									echo '<a class="aqpb-tab aqpb-tab-sortable" data-template_id="'.$template->ID.'" href="' . esc_url(add_query_arg(
										array(
											'page' => $this->args['page_slug'],
											'action' => 'edit',
											'template' => $template->ID,
										),
										admin_url( 'themes.php' )
									)) . '">'. htmlspecialchars($template->post_title) .'</a>';
								}
							}
							?>

							<!--add new template button-->
							<?php if($selected_template_id == 0) { ?>
							<span class="aqpb-tab aqpb-tab-add aqpb-tab-active"><abbr title="Add Template">+</abbr></span>
							<?php } else { ?>
							<a class="aqpb-tab aqpb-tab-add" href="<?php
								echo esc_url(add_query_arg(
									array(
										'page' => $this->args['page_slug'],
										'action' => 'edit',
										'template' => 0,
									),
									admin_url( 'themes.php' )
								));
							?>">
								<abbr title="Add Template">+</abbr>
							</a>
							<?php } ?>

						</div>
					</div>

					<div class="aqpb-tabs-arrow aqpb-tabs-arrow-right">
						<a>&raquo;</a>
					</div>

				</div>
				<div class="aqpb-wrap aqpbdiv">
					<form id="update-page-template" action="<?php echo esc_url($this->args['page_url']) ?>" method="post" enctype="multipart/form-data">
						<div id="aqpb-header">

								<div class="submitbox">
									<div class="major-publishing-actions cf">
										<a href="#" class="emptyTemplates"><?php _e('Clear All Blocks','circleflip-builder');?></a>
										<a href="#" class="cr_undo disabled" data-index="0"><span>Undo</span></a>
										<a href="#" class="cr_redo disabled" data-index="0"><span>Redo</span></a>
										<?php 
										if(cr_get_option('activate_revisions_history') == 'Yes') {
											$historyTotalNumber = get_post_meta($post->ID,'_cr_history_total_number',true);
											$historyNumber = get_post_meta($post->ID,'_cr_history_number',true);
										?>
											<select id="cr_revisions">
												<?php 
												if(circleflip_valid($historyTotalNumber) && circleflip_valid($historyNumber)) {
													echo "<option>Select a revision</option>";
													if($historyTotalNumber < 10) {
														$start = 0;
														$end = $historyTotalNumber;
													} else {
														$start = $historyNumber - 10;
														$end = $historyNumber;
													}
													for ($i=$start; $i < $end ; $i++) {
														echo "<option data-revision='_cr_history_".($i)."'>Revision History ".($i)."</option>";					
													}
												} else {
													echo "<option>No Revisions Available</option>";
												}
												?>
											</select>
										<?php } ?>
										<a href="#" class="icon-resize-full crdn-expanded-fullscreen">
											<span>
												Fullscreen Mode
											</span>
										</a>
									</div><!-- END .major-publishing-actions -->
								</div><!-- END #submitpost .submitbox -->

								<?php
								if($selected_template_id === 0) {
									wp_nonce_field( 'create-template', 'create-template-nonce' );
								} else {
									wp_nonce_field( 'update-template', 'update-template-nonce' );
								}
								?>
								<input type="hidden" name="template" id="template" value="<?php echo esc_attr($post->ID) ?>"/>
						</div>
						<div class="preloader hide">
							<img src="<?php echo get_template_directory_uri() .'/creiden-framework/content-builder/assets/images/preloader.gif' ?>" alt="" />
						</div>
						<div id="aqpb-body">
							<ul class="blocks cf" id="blocks-to-edit">
								<?php
									AQ_Page_Builder::display_blocks($post->ID);
								?>
							</ul>
							<div class="importCertainBlock">
								<a href="#crdn-importCertainBlock" data-toggle="modal">Click Here to import a block</a>
							</div>
							<div class="modal fade" id="crdn-importCertainBlock">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h4>Import Block</h4>
											<div type="button" class="tb-close-icon" data-dismiss="modal" aria-hidden="true"></div>
										</div>
										<div class="modal-body">
											<p>Paste the code you copied from the exported block</p>
											<textarea></textarea>
											<button type="button" class="button button-primary">Add Block</button>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div id="aqpb-footer">
							<div style="float: left;" data-container="body" data-toggle="popover" data-placement="top" data-content='<input type="text" placeholder="Template Name" id="saveTemplateName" /><a href="#" class="button button-primary button-small" id="saveBuilderTemplates" data-postid="<?php echo esc_attr($post->ID) ?>">Save</a>'>
								<a id="saveTemplatePopover" class="">
								  Save Template
								</a>
								<label for="saveTemplatePopover">Save Template</label>
							</div>
							<label for="saveTemplateName">Load a pre saved template</label>
							<div class="template-templates">
								<select id="template-templates">
									<option value="">No Template</option>
                                                                        <!-- Layouts -->
                                                                        <option value="cafeflip"><?php _e('One Page Layout','circleflip-builder');?></option>
                                                                        <option value="onepage"><?php _e('One Page Layout','circleflip-builder');?></option>
                                                                        <option value="medical"><?php _e('Medical Layout','circleflip-builder');?></option>
                                                                        <option value="mechanic"><?php _e('Engineer Layout','circleflip-builder');?></option>
                                                                        <option value="school"><?php _e('School Layout','circleflip-builder');?></option>
                                                                        <option value="hotel"><?php _e('Hotel Layout','circleflip-builder');?></option>
                                                                        <option value="lawyer"><?php _e('Law Firm Layout','circleflip-builder');?></option>
                                                                        <option value="tours"><?php _e('Tour Flip Layout','circleflip-builder');?></option>
                                                                        <option value="host"><?php _e('Hosting Layout','circleflip-builder');?></option>
                                                                        <option value="magazine"><?php _e('Magazine','circleflip-builder');?></option>


                                                                        <!-- Home Pages-->
									<option value="homeStyle1"><?php _e('Home Layout 1','circleflip-builder');?></option>
                                                                        <option value="homeStyle2"><?php _e('Home Layout 2','circleflip-builder');?></option>
                                                                        <option value="homeStyle3"><?php _e('Home Layout 3','circleflip-builder');?></option>
                                                                        <option value="homeStyle4"><?php _e('Home Layout 4','circleflip-builder');?></option>
                                                                        <option value="homeStyle5"><?php _e('Home Layout 5','circleflip-builder');?></option>
                                                                        <option value="homeStyle6"><?php _e('Home Layout 6','circleflip-builder');?></option>
                                                                        <option value="homeStyle7"><?php _e('Home Layout 7','circleflip-builder');?></option>
                                                                        <option value="homeStyle8"><?php _e('Home Layout 8','circleflip-builder');?></option>
                                                                        <option value="homeStyle9"><?php _e('Home Layout 9','circleflip-builder');?></option>
                                                                        <option value="homeStyle10"><?php _e('Home Layout 10','circleflip-builder');?></option>
                                                                        <option value="homeStyle11"><?php _e('Home Layout 11','circleflip-builder');?></option>
                                                                        <option value="homeStyle12"><?php _e('Home Layout 12','circleflip-builder');?></option>
                                                                        <option value="homeStyle13"><?php _e('Home Layout 13','circleflip-builder');?></option>
                                                                        <option value="homeStyle14"><?php _e('Home Layout 14','circleflip-builder');?></option>
                                                                        <option value="homeStyle15"><?php _e('Home Layout 15','circleflip-builder');?></option>
                                                                        <option value="homeStyle16"><?php _e('Home Layout 16','circleflip-builder');?></option>
                                                                        <option value="homeStyle17"><?php _e('Home Layout 17','circleflip-builder');?></option>
                                                                        <option value="homeStyle18"><?php _e('Home Layout 18','circleflip-builder');?></option>
                                                                        <!--About Us Pages-->
                                                                        <option value="AboutUsStyle1"><?php _e('About Us Layout 1','circleflip-builder');?></option>
                                                                        <option value="AboutUsStyle2"><?php _e('About Us Layout 2','circleflip-builder');?></option>
                                                                        <option value="AboutUsStyle3"><?php _e('About Us Layout 3','circleflip-builder');?></option>
                                                                        <option value="AboutUsStyle4"><?php _e('About Us Layout 4','circleflip-builder');?></option>
                                                                        <option value="AboutUsStyle5"><?php _e('About Us Layout 5','circleflip-builder');?></option>
                                                                        <option value="AboutUsStyle6"><?php _e('About Us Layout 6','circleflip-builder');?></option>
                                                                        <!--Our Team-->
                                                                        <option value="OurTeamStyle1"><?php _e('Our Team Layout 1','circleflip-builder');?></option>
                                                                        <option value="OurTeamStyle2"><?php _e('Our Team Layout 2','circleflip-builder');?></option>
                                                                        <option value="OurTeamStyle3"><?php _e('Our Team Layout 3','circleflip-builder');?></option>
                                                                        <!--Services-->
                                                                        <option value="ServicesStyle1"><?php _e('Services Layout 1','circleflip-builder');?></option>
                                                                        <option value="ServicesStyle2"><?php _e('Services Layout 2','circleflip-builder');?></option>
                                                                        <!--Contact Us-->
                                                                        <option value="ContactUsStyle1"><?php _e('Contact Us Layout 1','circleflip-builder');?></option>
                                                                        <option value="ContactUsStyle2"><?php _e('Contact Us Layout 2','circleflip-builder');?></option>
                                                                        <option value="ContactUsStyle3"><?php _e('Contact Us Layout 3','circleflip-builder');?></option>
                                                                        <option value="ContactUsStyle4"><?php _e('Contact Us Layout 4','circleflip-builder');?></option>
                                                                        <option value="ContactUsStyle5"><?php _e('Contact Us Layout 5','circleflip-builder');?></option>
                                                                        <option value="ContactUsStyle6"><?php _e('Contact Us Layout 6','circleflip-builder');?></option>
                                                                        <option value="ContactUsStyle7"><?php _e('Contact Us Layout 7','circleflip-builder');?></option>
                                                                        <option value="ContactUsStyle8"><?php _e('Contact Us Layout 8','circleflip-builder');?></option>
                                                                        <!--Page Layouts-->
                                                                        <option value="PageLayoutsStyle1"><?php _e('Right Sidebar Page','circleflip-builder');?></option>
                                                                        <option value="PageLayoutsStyle2"><?php _e('Left Sidebar Page','circleflip-builder');?></option>
                                                                        <option value="PageLayoutsStyle3"><?php _e('Wide Sidebar Page','circleflip-builder');?></option>
                                                                        <option value="PageLayoutsStyle4"><?php _e('Two Sidebars Page','circleflip-builder');?></option>
                                                                        <option value="PageLayoutsStyle5"><?php _e('Two Sidebars on the Same Side Page','circleflip-builder');?></option>
                                                                        <option value="PageLayoutsStyle6"><?php _e('No Sidebar Page (Full Width)','circleflip-builder');?></option>
									<?php $blocks = get_option( 'builderSavedTemp');
										foreach ($blocks as $key => $value) {
											if(circleflip_valid($value)) {
												?>
												<option value="<?php echo esc_attr($key); ?>" class="manuallySaved"><?php echo esc_html($key)?></option>
												<?php
											}
										}
									?>
								</select>
							</div>
							<a href="#" class="deleteTemplates" id="deleteTemplateBuilder" data-postid="<?php echo esc_attr($post->ID) ?>"><?php _e('Delete Template','circleflip-builder');?></a>
							<label for="deleteTemplateBuilder" onclick="jQuery('#deleteTemplateBuilder').click()">Delete Template</label>
							<div id="template-shortcode">
								<input type="text" readonly="readonly" value='[template id="<?php echo esc_attr($post->ID) ?>"]' onclick="select()"/>
							</div>
							<div class="ExporterImporter">
								<a href="#" class="exportToggle">Toggle Export</a>
								<label id="exportLabel" onclick="jQuery('.exportToggle').click()" style="padding-right: 10px;border-right: 1px solid #cacaca;">Export</label>
								<a href="#" class="importToggle">Toggle Import</a>
								<label id="importLabel" onclick="jQuery('.importToggle').click()">Import</label>
							</div>
						</div>

					</div>
				</form>
			</div>
		</div>


	</div>
</div>