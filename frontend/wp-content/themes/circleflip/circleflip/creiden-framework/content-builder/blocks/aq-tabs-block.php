<?php
/* Aqua Tabs Block */
if(!class_exists('AQ_Tabs_Block')) {
	class AQ_Tabs_Block extends AQ_Block {

		function __construct() {
			$block_options = array(
				'image' => 'tabs.png',
				'name' => 'Tabs &amp; Toggles',
				'size' => 'span6',
				'tab'	 => 'Content',
                                'imagedesc' => 'tabs.jpg',
				'desc' => 'Tabs & Toggles lets you display multiple-page-like content in a neat, mess free way.'
			);

			//create the widget
			parent::__construct('AQ_Tabs_Block', $block_options);

			//add ajax functions
			add_action('wp_ajax_aq_block_tab_add_new', array($this, 'add_tab'));
		}

		function form($instance) {

			$defaults = array(
				'tabs' => array(
					1 => array(
						'title' => 'My New Tab',
						'content' => 'My tab contents',
					)
				),
				'type'	=> 'tab',
				'entrance_animation' => ''
			);

			$instance = wp_parse_args($instance, $defaults);
			extract($instance);

			$tab_types = array(
				'tab' => 'Tabs',
				'toggle' => 'Toggles',
				'accordion' => 'Accordion'
			);

			?>
			<p class="description">
				<span class="leftHalf">
					<label for="<?php echo esc_attr( $this->get_field_id('type') ) ?>">
						<?php _e('How to display it ?', 'circleflip-builder') ?>
					</label>
				</span>
				<span class="rightHalf">
					<span class="rightHalf select">
						<?php echo circleflip_field_select('type', $block_id, $tab_types, $type) ?>
					</span>
				</span>
			</p>
			<p class="description half">
				<span class="leftHalf">
					<label for="<?php echo esc_attr( $this->get_field_id('entrance_animation') ) ?>">
						<?php _e( 'Animate the alert ?', 'circleflip-builder' ) ?>
					</label>
					<span class="description_text">
						<?php _e( 'the animation is applied when the tab is visible', 'circleflip-builder'  ) ?>
					</span>
				</span>
				<span class="rightHalf">
					<span class="rightHalf select">
						<?php
						$animation_options = array(
							'default' => 'Default',
							'noanimation' => 'no animation',
							'cr_left' => 'Fade To Left',
							'cr_right' => 'Fade To Right',
							'cr_top' => 'Fade To Up',
							'cr_bottom' => 'Fade To Down',
							'cr_popup' => 'Popout',
							'cr_fade' => 'Fade in',
						);
						echo circleflip_field_select('entrance_animation', $block_id, $animation_options, $entrance_animation); ?>
					</span>
					<span class="entrance_animation_sim"></span>
				</span>
			</p>
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
				<a href="#" rel="tab" class="aq-sortable-add-new button">Add New</a>
				<p></p>
			</div>
			<?php
		}

		function tab($tab = array(), $count = 0, $ajax = false) {
			$tab = wp_parse_args($tab, array(
				'title' => '',
				'text' => '',
				'content' => '',
				'image1' => '',
				'image_position' => '',
			));
			?>
			<li id="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-sortable-item-<?php echo esc_attr($count) ?>" class="sortable-item" rel="<?php echo esc_attr($count) ?>">

				<div class="sortable-head cf">
					<div class="sortable-title">
						<strong><?php echo esc_html($tab['title']) ?></strong>
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
							<label for="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-title">
								<?php _e( 'Title', 'circleflip-builder' ) ?>
							</label>
						</span>
						<span class="rightHalf">
							<input type="text" id="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-title" class="input-full" name="<?php echo esc_attr( $this->get_field_name('tabs') ) ?>[<?php echo esc_attr($count) ?>][title]" value="<?php echo esc_attr($tab['title']) ?>" />
						</span>
					</p>
					<div class="tab-desc description">
						<div class="leftHalf">
							<label for="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-content">
								<?php _e( 'Content', 'circleflip-builder' ) ?>
							</label>
						</div>
						<div class="rightHalf">
							<?php echo wp_editor($tab['content'], esc_attr( $this->get_field_id('tabs') ).'-'.esc_attr($count).'-'.'content', array('textarea_name'=>esc_attr( $this->get_field_name('tabs') ).'['.$count.'][content]','editor_class'=>esc_attr( $this->get_field_id('tabs') ).'_editor_tabbed','quicktags'=>false)); ?>
						</div>
					</div>
				</div>
			</li>
			
			<?php 
			$wordpress_version = get_bloginfo('version');
			
			if($ajax) { ?>
			<script type="text/javascript">
				jQuery(document).ready(function($) {
					jQuery('.wp-editor-area').each(function(index,element) {
						<?php 
							if( version_compare($wordpress_version, '3.9','>=') ) {
						?>
						tinymce.PluginManager.load('colorpicker_cf', '<?php echo get_template_directory_uri()?>/creiden-framework/content-builder/assets/js/colorpicker/colorpicker.js');
                        tinyMCE.init( {
                                selector: $(element).attr('id'),
								content_css : '<?php echo get_template_directory_uri()."/css/fonts/fonts-admin.css" ?>',
								plugins: [
							        "wordpress textcolor colorpicker_cf directionality wplink"
								],
								menubar: false,
                                                                relative_urls: false,
									font_formats : 	"Andale Mono=andale mono,times;"+
													"Droid Kufi Regular=DroidArabicKufi,arial;"+"Droid Kufi Bold=DroidArabicKufiBold,arial;"+
															"Inika =inikaNormal,arial;"+
															"Arial=arial,helvetica,sans-serif;"+
															"Arial Black=arial black,avant garde;"+
															"Source Sans=sourceSans,arial;"+
															"Source Sans Semibold=sourceSansBold,arial;"+
															"Source Sans Light=sourceSansLight,arial;"+
															"Raleway regular=Raleway,arial;"+
															"Raleway Light=Raleway-light,arial;"+
															"Book Antiqua=book antiqua,palatino;"+
															"Comic Sans MS=comic sans ms,sans-serif;"+
															"Courier New=courier new,courier;"+
															"Georgia=georgia,palatino;"+
															"Helvetica=helvetica;"+
															"Impact=impact,chicago;"+
															"Symbol=symbol;"+
															"Tahoma=tahoma,arial,helvetica,sans-serif;"+
															"Terminal=terminal,monaco;"+
															"Times New Roman=times new roman,times;"+
															"Trebuchet MS=trebuchet ms,geneva;"+
															"Verdana=verdana,geneva;"+
															"Webdings=webdings;"+
															"Wingdings=wingdings,zapf dingbats",
									fontsize_formats : "9px 10px 11px 12px 13px 14px 16px 18px 20px 22px 24px 26px 28px 30px 32px 34px 36px 38px 40px 44px 48px 50px 54px",
									toolbar1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
                                  toolbar2 : "cut copy paste pastetext pasteword | search replace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image cleanup help code | insertdate inserttime preview | colorpicker_cf forecolor backcolor | alignleft aligncenter alignright alignjustify",
                                  toolbar3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
									style_formats: [
								        {title: 'Line height 10px', inline: 'span', styles: {'line-height': '10px'}},
								        {title: 'Line height 11px', inline: 'span', styles: {'line-height': '11px'}},
								        {title: 'Line height 12px', inline: 'span', styles: {'line-height': '12px'}},
								        {title: 'Line height 13px', inline: 'span', styles: {'line-height': '13px'}},
								        {title: 'Line height 14px', inline: 'span', styles: {'line-height': '14px'}},
								        {title: 'Line height 15px', inline: 'span', styles: {'line-height': '15px'}},
								        {title: 'Line height 16px', inline: 'span', styles: {'line-height': '16px'}},
								        {title: 'Line height 17px', inline: 'span', styles: {'line-height': '17px'}},
								        {title: 'Line height 18px', inline: 'span', styles: {'line-height': '18px'}},
								        {title: 'Line height 19px', inline: 'span', styles: {'line-height': '19px'}},
								        {title: 'Line height 20px', inline: 'span', styles: {'line-height': '20px'}},
								        {title: 'Line height 21px', inline: 'span', styles: {'line-height': '21px'}},
								        {title: 'Line height 22px', inline: 'span', styles: {'line-height': '22px'}},
								        {title: 'Line height 23px', inline: 'span', styles: {'line-height': '23px'}},
								        {title: 'Line height 24px', inline: 'span', styles: {'line-height': '24px'}},
								        {title: 'Line height 25px', inline: 'span', styles: {'line-height': '25px'}},
								        {title: 'Line height 26px', inline: 'span', styles: {'line-height': '26px'}},
								        {title: 'Line height 27px', inline: 'span', styles: {'line-height': '27px'}},
								        {title: 'Line height 28px', inline: 'span', styles: {'line-height': '28px'}},
								        {title: 'Line height 29px', inline: 'span', styles: {'line-height': '29px'}},
								        {title: 'Line height 30px', inline: 'span', styles: {'line-height': '30px'}},
								        {title: 'Line height 31px', inline: 'span', styles: {'line-height': '31px'}},
								        {title: 'Line height 32px', inline: 'span', styles: {'line-height': '32px'}},
								        {title: 'Line height 33px', inline: 'span', styles: {'line-height': '33px'}},
								        {title: 'Line height 34px', inline: 'span', styles: {'line-height': '34px'}},
								        {title: 'Line height 35px', inline: 'span', styles: {'line-height': '35px'}},
								        {title: 'Line height 36px', inline: 'span', styles: {'line-height': '36px'}},
								        {title: 'Line height 37px', inline: 'span', styles: {'line-height': '37px'}},
								        {title: 'Line height 38px', inline: 'span', styles: {'line-height': '38px'}},
								        {title: 'Line height 39px', inline: 'span', styles: {'line-height': '39px'}},
								        {title: 'Line height 40px', inline: 'span', styles: {'line-height': '40px'}},
								    ]
								} );
									_.delay(function(){
								tinyMCE.execCommand( 'mceAddEditor', true, $(element).attr('id') );
								setTimeout(function() {
									$( 'table.mceLayout' ).css( {
										width: '100%',
										'visibility': 'visible'
									} );	
									$( '.wp-editor-container iframe' ).css('height','170px');
									$('.mceToolbar').show();
								},1000)
							}, 500);
						<?php
							} else {
						?>
							tinyMCE.init( {selector: $(element).attr('id'),
							skin: "wp_theme",
							content_css : '<?php echo get_template_directory_uri()."/css/fonts/fonts-admin.css" ?>',
							theme_advanced_fonts : 	"Andale Mono=andale mono,times;"+
													"Droid Kufi Regular=DroidArabicKufi,arial;"+"Droid Kufi Bold=DroidArabicKufiBold,arial;"+
													"Inika =inikaNormal,arial;"+
													"Arial=arial,helvetica,sans-serif;"+
													"Arial Black=arial black,avant garde;"+
													"Source Sans=sourceSans,arial;"+
													"Source Sans Semibold=sourceSansBold,arial;"+
													"Source Sans Light=sourceSansLight,arial;"+
													"Raleway regular=Raleway,arial;"+
													"Raleway Light=Raleway-light,arial;"+
													"Book Antiqua=book antiqua,palatino;"+
													"Comic Sans MS=comic sans ms,sans-serif;"+
													"Courier New=courier new,courier;"+
													"Georgia=georgia,palatino;"+
													"Helvetica=helvetica;"+
													"Impact=impact,chicago;"+
													"Symbol=symbol;"+
													"Tahoma=tahoma,arial,helvetica,sans-serif;"+
													"Terminal=terminal,monaco;"+
													"Times New Roman=times new roman,times;"+
													"Trebuchet MS=trebuchet ms,geneva;"+
													"Verdana=verdana,geneva;"+
													"Webdings=webdings;"+
													"Wingdings=wingdings,zapf dingbats",
							theme_advanced_font_sizes : "9px,10px,11px,12px,13px,14px,16px,18px,20px,22px,24px,26px,28px,30px,32px,34px,36px,38px,40px,44px,48px,50px,54px",
							theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
							theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
							theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",} );
							_.delay(function(){
								tinyMCE.execCommand( 'mceAddControl', true, $(element).attr('id') );
								setTimeout(function() {
									$( 'table.mceLayout' ).css( {
										width: '100%',
										'visibility': 'visible'
									} );	
									$( '.wp-editor-container iframe' ).css('height','170px');
									$('.mceToolbar').show();
								},1000)
								
							}, 500);
						});
						<?php } ?>
						});
					});
				</script>
				<?php
			} else {
				?>
				<script type="text/javascript">
					function decodeEntities(s){
					    var str, temp= document.createElement('p');
					    temp.innerHTML= s;
					    str= temp.textContent || temp.innerText;
					    temp=null;
					    return str;
					}
					
					
					jQuery(document).ready(function($) {
						jQuery('#aqpb-body #<?php echo esc_attr( $this->get_field_id('tabs') ).'-'.$count.'-'.'content' ?>').each(function(index,element) {
						    $(element).html(decodeEntities($(element).text()));
						})
					});
				</script>
				<?php
			}
		}

		function block($instance) {
			extract($instance);
			wp_enqueue_script('jquery-ui-tabs');
			$this->tabbed_method();
			if($entrance_animation == 'default') {
				$entrance_animation = cr_get_option('block_animations');
			}
			$output = '';
			if($type == 'tab') {


				$output .= '<div id="aq_block_tabs_'. rand(1, 100) .'" class="aq_block_tabs "><div class="aq-tab-inner circleFlipTabs">';
					$output .= '<ul class="aq-nav cf">';

					$i = 1;
					foreach( $tabs as $tab ){
						$tab_selected = $i == 1 ? 'ui-tabs-active' : '';
							$output .= '<li class="'.esc_attr($tab_selected).' animateCr '.esc_attr($entrance_animation).'"><a href="#aq-tab-'. $i .'">'. $tab['title'] .' </a></li>';
						$i++;
					}

					$output .= '</ul>';
					
					$i = 1;
					foreach($tabs as $tab) {
						
						$output .= '<div id="aq-tab-'. $i .'" class="aq-tab clearfix">
										<div class="tabText clearfix">'. wpautop(do_shortcode(htmlspecialchars_decode($tab['content']))) .'</div>
									</div>';
						$i++;
					}
				$output .= '</div></div>';
			} elseif ($type == 'toggle') {
					
					//opening the toggles container
					$output .= '<div id="aq_block_toggles_wrapper_'.rand(1,100).'" class="aq_block_toggles_wrapper">';
					//loop start
					foreach( $tabs as $tab ){
	
						$output  .= '<div class="aq_block_toggle">
										<h2 class="tab-head">'. $tab['title'] .'<span></span></h2>
										<div class="tab-body closeTab cf">
											<div class="tabText clearfix">'.wpautop(do_shortcode(htmlspecialchars_decode($tab['content']))).'</div>
										</div>
									 </div>';
					}
					//loop end 
					//closing the toggles container
					$output .= '</div>';
			} elseif ($type == 'accordion') {

				$count = count($tabs);
				$i = 1;
				
				//Opening the accordion container
				$output .= '<div id="aq_block_accordion_wrapper_'.rand(1,100).'" class="aq_block_accordion_wrapper">';
				//Loop Start
				foreach( $tabs as $tab ){

					$open = $i == 1 ? 'open' : 'closeTab';

					$child = '';
					if($i == 1) $child = 'first-child';
					if($i == $count) $child = 'last-child';
					$i++;

					$output  .= '<div class="aq_block_accordion '.$child.'">';
						$output .= '<h2 class="tab-head">'. $tab['title'] .'<span></span></h2>
									<div class="tab-body '.$open.' cf">
										<div class="tabText clearfix">'.wpautop(do_shortcode(htmlspecialchars_decode($tab['content']))).'</div>
									</div>
								 </div>';
				}
				//Loop end
				//Closing the accordion container
				$output .= '</div>';
			}
			echo $output;
		}
		function tabbed_method() {
			wp_register_style('tabs_acc_toggles',get_template_directory_uri() . "/css/content-builder/tabs_acc_toggles.css",array('circleflip-style'),'2.0.3');
			wp_enqueue_style('tabs_acc_toggles');
			wp_register_script('tabs_acc_toggles_JS',get_template_directory_uri() . "/scripts/modules/builder_tabbed_acc_toggle.js",array('jquery'),'2.0.3',true);
			wp_enqueue_script('tabs_acc_toggles_JS');
		}
		/* AJAX add tab */
		function add_tab() {

			$count = isset($_POST['count']) ? absint($_POST['count']) : false;
			$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'aq-block-9999';

			//default key/value for the tab
			$tab = array(
				'title' => 'New Tab',
				'content' => 'My tab content',
			);

			if($count) {
				$this->tab($tab, $count,true);
			} else {
				die(-1);
			}

			die();
		}

		function update($new_instance, $old_instance) {
			$new_instance = circleflip_recursive_sanitize($new_instance);
			return $new_instance;
		}
	}
}
