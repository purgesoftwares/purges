<?php
/* Aqua Tabs Block */
if(!class_exists('CR_Icon_Box')) {
	class CR_Icon_Box extends AQ_Block {

		function __construct() {
			$block_options = array(
				'image' => 'icon_box.png',
				'name' => 'Icon Box',
				'size' => 'span6',
				'home' => 'homePage',
				'tab'    => 'Content',
                                'imagedesc' => 'iconbox.jpg',
                                'desc' => 'Displays the selected icons with titles and text below them.'
			);

			//create the widget
			parent::__construct('CR_Icon_Box', $block_options);

			//add ajax functions
			add_action('wp_ajax_aq_block_feature_add_new', array($this, 'add_tab'));
		}

		function form($instance) {

			$defaults = array(
				'tabs' => array(
					1 => array(
						'title' => 'New Title',
						'content' => 'New Content',
						'image' => '',
						'link' => '',
						'color' => '',
						'offer' => '',
						'choose_type' =>'',
						'imagesrc' =>'',
						'icon' => ''
					)
				),
				'type'	=> 'tab',
				'entrance_animation' => ''
			);

			$instance = wp_parse_args($instance, $defaults);
			extract($instance);

			?>
			<div class="description cf">
				<p class="description half">
				<span class="leftHalf">
					<label for="<?php echo esc_attr( $this->get_field_id('entrance_animation') ) ?>">
						On-Scroll Animation
					</label>
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
				<br />
				<a href="#" rel="feature" class="aq-sortable-add-new button">Add New</a>
				<br />
				<p class="description">
					<span class="leftHalf">
						<label for="<?php echo esc_attr( $this->get_field_id('type') ) ?>">
							Layout Style
						</label>
						<span class="description_text">
							Choose number of boxes per row. Either thirds or fourths.
						</span>
					</span>
					<span class="rightHalf">
						<span class="rightHalf select">
							<?php echo circleflip_field_select('type', $block_id, array('Thirds','Fourths'), isset($type) ? $type : 'Thirds') ?>
						</span>
					</span>
				</p>
				<p class="description">
					<span class="leftHalf">
						<label for="<?php echo esc_attr( $this->get_field_id('feature') ) ?>">
							Box Style
						</label>
					</span>
					<span class="rightHalf">
						<span class="rightHalf select">
							<?php echo circleflip_field_select('feature', $block_id, array('Style1','Style2','Style3'), isset($feature) ? $feature : 'Thirds', array('data-fd-handle="feature_style"')) ?>
						</span>
					</span>
				</p>
				<p class="" data-fd-rules='["feature_style:equal:0"]'>
					<img style="display: block;margin:0 auto; " src="<?php echo get_template_directory_uri(); ?>/creiden-framework/content-builder/assets/images/feature_style1.png" alt=""/>
				</p>
				<p class="" data-fd-rules='["feature_style:equal:1"]'>
					<img style="display: block;margin:0 auto; " src="<?php echo get_template_directory_uri(); ?>/creiden-framework/content-builder/assets/images/feature_style2.png" alt=""/>
				</p>
				<p class="" data-fd-rules='["feature_style:equal:2"]'>
					<img style="display: block;margin:0 auto; " src="<?php echo get_template_directory_uri(); ?>/creiden-framework/content-builder/assets/images/feature_style3.png" alt=""/>
				</p>
				<br />
			</div>
			<?php
		}

		function tab($tab = array(), $count = 0,$ajax = false) {
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
					<div class="tab-desc description">
						<p class="tab-desc description">
							<span class="leftHalf">
								<label for="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-link">
									Feature Link
								</label>
							</span>
							<span class="rightHalf">
								<input type="text" id="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-link" class="input-full" name="<?php echo esc_attr( $this->get_field_name('tabs') ) ?>[<?php echo esc_attr($count) ?>][link]" value="<?php echo esc_attr($tab['link']) ?>" />
							</span>
						</p>
						<p class="tab-desc description">
							<span class="leftHalf">
								<label for="<?php echo esc_attr( $this->get_field_id('choose_type') ) ?>">
									Choose Image Or Icon
								</label>
							</span>
							<span class="rightHalf">
								<span class="rightHalf select">
									<?php $choose_type = array('Icon','Image'); ?>
									<?php /*foreach( $choose_type as $key=>$value) {
										echo $value .'<br/>';
									} */?>
								<select id="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-choose_type"
										name="<?php echo esc_attr( $this->get_field_name('tabs') ) ?>[<?php echo esc_attr($count) ?>][choose_type]"
										data-fd-handle="feature_icon_image">
									<?php foreach( $choose_type as $key=>$value) { ?>
										<option value="<?php echo $key ?>" '<?php echo selected( (isset($tab['choose_type']))?$tab['choose_type'] : '', $key, false ) ?>'><?php echo $value ; ?></option>
									<?php } ?>
								</select>
								</span>
							</span>
						</p>
						<div class="tab-desc description iconselector" data-fd-rules='["feature_icon_image:equal:0"]'>
							<span class="leftHalf">
								<label for="cc">
									Select Icon
								</label>
							</span>
							<span class="rightHalf icons ">
								<?php echo circleflip_builder_icon_selector( esc_attr( $this->get_field_name( 'tabs' ) ) . "[$count][icon]", isset($tab['icon'])? $tab['icon'] : 'icon-spin3' ) ?>
							</span>
						</div>
					</div>
					<p class="description" data-fd-rules='["feature_icon_image:equal:1"]'>
						<span class="leftHalf">
							<label for="<?php echo esc_attr( $this->get_field_id('image_upload') ) ?>-<?php echo esc_attr($count) ?>-image">
								Choose Image
								<?php
									if(isset($tab['image']) && !empty($tab['image']))
										{
											$tab_image = $tab['image'];
											$slider_img_id = (isset($tab['imagesrc']))? $tab['imagesrc'] : '';
										}
									else {
										$tab_image = '';
										$slider_img_id = '';
									}
								?>
							</label>
							<span class="description_text">
								Upload your image.
							</span>
						</span>
						<span class="rightHalf">
							<img class="screenshot" src="<?php echo esc_url($tab_image); ?>" alt=""/>
							<input type="hidden" id="<?php echo esc_attr( $this->get_field_id('image_upload') ) ?>-<?php echo esc_attr($count) ?>-imagesrc"
								   name="<?php echo esc_attr( $this->get_field_name('tabs') ) ?>[<?php echo esc_attr($count) ?>][imagesrc]"
								   value=<?php echo esc_attr($slider_img_id)  ?> />
							<input type="text" id="<?php echo esc_attr( $this->get_field_id('image_upload') ) ?>-<?php echo esc_attr($count) ?>-image"
								   class="input-full input-upload" value="<?php echo esc_attr($tab_image) ?>"
								   name="<?php echo esc_attr( $this->get_field_name('tabs') ) ?>[<?php echo esc_attr($count) ?>][image]">
							<a href="#" class="aq_upload_button button" rel="image">Upload</a>
							<a href="#" class="remove_image button" rel="image">Remove</a>
						</span>
					</p>
					<p class="tab-desc description">
						<span class="leftHalf">
							<label for="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-title">
								Feature Title
							</label>
						</span>
						<span class="rightHalf">
							<input type="text" id="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-title" class="input-full" name="<?php echo esc_attr( $this->get_field_name('tabs') ) ?>[<?php echo esc_attr($count) ?>][title]" value="<?php echo esc_attr($tab['title']) ?>" />
						</span>
					</p>
					<div class="tab-desc description">
						<div class="leftHalf">
							<label for="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-content">
								Feature Content
							</label>
						</div>
						<div class="rightHalf">
							<?php
							echo wp_editor($tab['content'], esc_attr( $this->get_field_id('tabs') ).'-'.esc_attr($count).'-'.'content', array('textarea_name'=>esc_attr( $this->get_field_name('tabs') ).'['.$count.'][content]','editor_class'=>esc_attr( $this->get_field_id('tabs') ).'_editor_tabbed','quicktags'=>false)); ?>
						</div>
					</div>
					<div class="description half last">
						<span class="leftHalf">
							<label for="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-color">
								Pick the Icon color
							</label>
						</span>
						<span class="rightHalf">
							<div class="aqpb-color-picker">
								<input type="text" id="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-color" class="input-color-picker" value="<?php if(isset($tab['color']) && !empty($tab['color']) ) echo esc_attr($tab['color']) ?>" name="<?php echo esc_attr( $this->get_field_name('tabs') ) ?>[<?php echo esc_attr($count) ?>][color]" data-default-color="<?php echo esc_attr($tab['color']) ?>"/>
							</div>
						</span>
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
								tinyMCE.init( {selector: $(element).attr('id'),
								content_css : '<?php echo get_template_directory_uri()."/css/fonts/fonts-admin.css" ?>',
								plugins: [
							        "textcolor colorpicker_cf directionality wplink"
								],
								menubar: false,
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
									toolbar1 : "save newdocument | bold italic underline strikethrough | justifyleft justifycenter justifyright justifyfull | styleselect formatselect fontselect fontsizeselect",
									toolbar2 : "cut copy paste pastetext pasteword | search replace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image cleanup help code | insertdate inserttime preview | colorpicker_cf  forecolor backcolor alignleft aligncenter alignright alignjustify",
									toolbar3 : "tablecontrols | hr removeformat visualaid | sub sup | charmap emotions iespell media advhr | print | ltr rtl | fullscreen",
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

		function offer_method(){
			wp_register_style('offerCSS',get_template_directory_uri() . "/css/content-builder/offerBlock.css");
			wp_enqueue_style('offerCSS');
		}


		function block($instance) {
			extract($instance);
			$offer = '';
			
			if($entrance_animation == 'default') {
				$entrance_animation = cr_get_option('block_animations');
			}
			switch ($type) {
				case '0':
					$layout = 'span4';
				break;
				case '1':
					$layout = 'span3';
					break;
				default:
					$layout = 'span4';
					break;
			}
			switch ($feature) {
				case '0':
					$feature2 = '';
					$grid = '';
				break;
				case '1':
					$feature2 = '';
					$grid = 'gridStyle';
					break;
				case '2':
					$offer = 'offer';
					$grid = '';
					break;
				default:
					$feature2 = '';
					$grid = '';
					break;
			}

			$output = '';

				$output .= '<div class="circleflip row">';
					$output .= '<ul class="featuresHome '. esc_attr($grid .' '. $offer) .'">';
					if($offer != 'offer'){
						foreach( $tabs as $tab ){
							$style_color;
							if($grid != 'gridStyle'){
								$style_color = $tab['color'];
							}else{
								$style_color = '';
							}
							if($tab['choose_type'] == 1){
								$imageIcon = wp_get_attachment_image($tab['imagesrc']);
								$image_class = 'image_added';
								$image_class_container = 'imageIconBox';
							}else if($tab['choose_type'] == 0) {
								$imageIcon = '<span class="'.esc_attr($tab['icon']).'" style="color:'.esc_attr($style_color).'"></span>';
								$image_class = '';
								$image_class_container= '';
							}
							if($tab['link'] != ''){//IF THERE IS LINK
								$output .= '
								<li class="'. esc_attr($layout .' grid2 animateCr '.$entrance_animation).'">
									<a href="'.esc_url($tab['link']).'">
										<div class="image_title_wrap">';
											$imageIcon = '';
											if ( isset( $imageIcon ) ) {
												$output .= 	'<div class="featureHomeImage">'.$imageIcon.'</div>';
											}
											$output .= '<h3 class="featureHomeTitle">'.$tab['title'].'</h3>
										</div>
									</a>
									<div class="featureHomeText">'.wpautop(do_shortcode(htmlspecialchars_decode($tab['content']))).'</div>
								</li>
								';
							}else{//IF THERE IS NOT LINK
								$output .= '
								<li class="'. esc_attr($layout .' grid2 animateCr '.$entrance_animation).'">
									<div class="image_title_wrap '.esc_attr($image_class_container).'">';
										if(isset( $imageIcon )){
											$output .= '<div class="featureHomeImage '.esc_attr($image_class.' '.$feature2).'">'.$imageIcon.'</div>';
										}
										$output .= '<h3 class="featureHomeTitle">'.$tab['title'].'</h3>
									</div>
									<div class="featureHomeText">'.wpautop(do_shortcode(htmlspecialchars_decode($tab['content']))).'</div>
								</li>
								';
							}
						}
					}else{
						$this->offer_method();
						foreach( $tabs as $tab ){
						if($tab['link'] != ''){//IF THERE IS LINK
							$output .= '
							<li class="'. esc_attr($layout .' grid5 animateCr '.$entrance_animation).'">
								<a href="'.esc_url($tab['link']).'">
									<div class="offerCircle">
										<div class="offerCircleInner">';
										if(isset($tab['icon'])){
											$output .= '<div class="'.$tab['icon'].' offerImage"></div>';
										}
										$output .= '<h3 class="offerTitle">'.$tab['title'].'</h3>
										</div>
									</div>
								</a>
								<div class="offerText">'.wpautop(do_shortcode(htmlspecialchars_decode($tab['content']))).'</div>
							</li>
							';
						}
						else{//IF THERE IS NOT LINK
							$output .= '
							<li class="'. esc_attr($layout .' grid5 animateCr '.$entrance_animation).'">
								<div class="offerCircle grid2">
									<div class="offerCircleInner">';
									if(isset($tab['icon'])){
										$output .= '<div class="'.$tab['icon'].' offerImage"></div>';
									}
									$output .= '<h3 class="offerTitle">'.$tab['title'].'</h3>
									</div>
								</div>
								<div class="offerText">'.wpautop(do_shortcode(htmlspecialchars_decode($tab['content']))).'</div>
							</li>
							';
						}
					}
					}
					$output .= '</ul>';

				$output .= '</div>';
			echo $output;
		}
		/* AJAX add tab */
		function add_tab() {
			// $nonce = $_POST['security'];
			// if (! wp_verify_nonce($nonce, 'aqpb-settings-page-nonce') ) die('-1');

			$count = isset($_POST['count']) ? absint($_POST['count']) : false;
			$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'aq-block-9999';

			//default key/value for the tab
			$tab = array(
				'title' => 'New Title',
				'content' => 'New Content',
				'image' =>'',
				'link' => '',
				'color' => '',
				'choose_type' =>'',
				'imagesrc' =>''
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
			<?php if($count) {
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
