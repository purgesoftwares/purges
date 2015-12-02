<?php
/* Aqua Tabs Block */
if(!class_exists('CR_Clinets_Logos')) {
	class CR_Clinets_Logos extends AQ_Block {

		function __construct() {
			$block_options = array(
				'image' => 'clients.png',
				'name' => 'Clients',
				'size' => 'span6',
                                'tab' => 'Content',
                                'imagedesc' => 'clients.jpg',
                                'desc' => 'Adds a slider with your clients images, all images can be clickable.'
			);

			//create the widget
			parent::__construct('CR_Clinets_Logos', $block_options);

			//add ajax functions
			add_action('wp_ajax_aq_block_clients_add_new', array($this, 'add_tab'));
		}

		function form($instance) {

			$defaults = array(
				'title' => 'Clients',
				'perGroupNumber' => '3',
				'tabs' => array(
					1 => array(
						'imagesrc' =>'',
						'link1' => ''
					)
				),
				'type'	=> 'tab',
			);

			$instance = wp_parse_args($instance, $defaults);
			extract($instance);

			?>
			<p class="description">
				<span class="leftHalf">
					<label for="<?php echo esc_attr( $this->get_field_id('title') ) ?>">
						Title
					</label>
					<span class="description_text">
					Write main title for the block here.
					</span>
				</span>
				<span class="rightHalf">
					<?php echo circleflip_field_input('title', $block_id, $title, $size = 'full') ?>
				</span>
			</p>
			<p class="description">
				<span class="leftHalf">
					<label for="<?php echo esc_attr( $this->get_field_id('titleIcon') ) ?>">
						Title Icon:
					</label>
				</span>
				<span class="rightHalf">
					<span class="rightHalf select">
						<?php $titleIconOption = array('without Icon','with Icon'); ?>
						<?php echo circleflip_field_select('titleIcon', $block_id, $titleIconOption, isset($titleIcon) ? $titleIcon : 'without Icon') ?>
					</span>
				</span>
			</p>
			<p class="description">
				<span class="leftHalf">
					<label for="<?php echo esc_attr( $this->get_field_id('perGroupNumber') ) ?>">
						Clients number per slide
					</label>
					<span class="description_text">
						Write Clients number to display per once.
					</span>
				</span>
				<span class="rightHalf">
					<?php echo circleflip_field_input('perGroupNumber', $block_id, $perGroupNumber, $size = 'full') ?>
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
				<br />
				<a href="#" rel="clients" class="aq-sortable-add-new button">Add New</a>
				<br />
			</div>
			<?php
		}

		function tab($tab = array(), $count = 0) {

			?>
			<li id="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-sortable-item-<?php echo esc_attr($count) ?>" class="sortable-item" rel="<?php echo esc_attr($count) ?>">

				<div class="sortable-head cf">
					<div class="sortable-title">
						<strong><?php echo "Client " .esc_attr($count); ?></strong>
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
							<label for="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-link1">
								Client Link
							</label>
							<span class="description_text">
								Insert a link for the client image, or you can leave it blank.
							</span>
						</span>
						<span class="rightHalf">
							<input type="text" id="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-link1" class="input-full" name="<?php echo esc_attr( $this->get_field_name('tabs') ) ?>[<?php echo esc_attr($count) ?>][link1]" value="<?php echo esc_attr($tab['link1']) ?>" />
						</span>
					</p>
					<p class="description">
						<span class="leftHalf">
							<label for="<?php echo esc_attr( $this->get_field_id('image_upload') ) ?>-<?php echo esc_attr($count) ?>-image">
								Client Image
								<?php
									if(isset($tab['image']) && !empty($tab['image']))
										{
											$tab_image = $tab['image'];
											$clients_img_id = $tab['imagesrc'];
										}
									else {
										$tab_image = '';
										$clients_img_id = '';
									}
								?>
							</label>
							<span class="description_text">
								Upload your client image. 
							</span>
						</span>
						<span class="rightHalf">
							<img class="screenshot" src="<?php echo esc_url($tab_image); ?>" alt=""/>
							<input type="hidden" id="<?php echo esc_attr( $this->get_field_id('image_upload') ) ?>-<?php echo esc_attr($count) ?>-imagesrc" 
								   name="<?php echo esc_attr( $this->get_field_name('tabs') ) ?>[<?php echo esc_attr($count) ?>][imagesrc]" 
								   value=<?php echo esc_attr($clients_img_id)  ?> />
							<input type="text" id="<?php echo esc_attr( $this->get_field_id('image_upload') ) ?>-<?php echo esc_attr($count) ?>-image" 
								   class="input-full input-upload" value="<?php echo esc_attr($tab_image) ?>" 
								   name="<?php echo esc_attr( $this->get_field_name('tabs') ) ?>[<?php echo esc_attr($count) ?>][image]">
							<a href="#" class="aq_upload_button button" rel="image">Upload</a>
							<a href="#" class="remove_image button" rel="image">Remove</a>
						</span>
					</p>
					
				</div>
			</li>
			<?php
		}

		function block($instance) {
			extract($instance);
			$titleIconClass;
			switch($titleIcon){
				case 0:
					$titleIconClass = 'withoutIcon';
					break;
				case 1:
					$titleIconClass = 'withIcon';
					break;
				default:
					$titleIconClass = 'withoutIcon';
			}
			$titleIconHead = '';
			if($titleIconClass == 'withIcon'){
				$iconHead;
				if(( defined( "ICL_LANGUAGE_CODE" ) && "ar" === ICL_LANGUAGE_CODE) ) {
					 $iconHead = "icon-left-open-mini"; 
				}else{
					 $iconHead = "icon-right-open-mini"; 
				}
				$titleIconHead = '<div class="headerDot"><span class="'.esc_attr($iconHead).'"></span></div>';
			}
			$this->clients_method();
			$output = '';
			$i=0;
			$clientsCounter = 0;
			$titleHtml = '';
					if(count($tabs) > $perGroupNumber){
						$navigation = '<a class="left carousel-control" href="#myCarousel" data-slide="prev"></a><a class="right carousel-control" href="#myCarousel" data-slide="next"></a>'; 
					}else{
						$navigation ='';
						$titleHtml = '';
					}
					
					if($title != null){
						$titleHtml = '<h3>'.$titleIconHead . esc_html( $title ).'</h3>';
					}
					$output .= '<div id="myCarousel_clients" class="carousel slide clientsLogos carousel-fade">
					'.$titleHtml.$navigation.'
					<div class="carousel-inner">';

					foreach( $tabs as $tab ){
						if($tab['link1']!=''){
							$link1Start = '<a href="'.esc_url($tab['link1']).'">';
							$linkEnd1 = '</a>';
						}
						else{
							$link1Start = '';
							$linkEnd1 = '';
						}

						//$tab['image1'] = '<img src="'.$tab['image1'].'" alt = "" />';
						$tab['imagesrc'] = wp_get_attachment_image($tab['imagesrc'],'full');

						$active = $i == 0 ? 'active' : '';
						
						if($clientsCounter == 0){
							$output .= '
								<div class="item '.esc_attr($active).'">
									<ul>';
						}
							$output .='<li>
										'.$link1Start.'
											'.$tab['imagesrc'].'
										'.$linkEnd1.'
									</li>';
						if($clientsCounter == $perGroupNumber-1){
							$output .='</ul>
							</div>';
							$clientsCounter=0;
						}
						else{
							$clientsCounter++;
						}
						
						$i++;
					}
					if($clientsCounter != $perGroupNumber && ($perGroupNumber != 1)){
						$output .='</ul>
						</div>';
					}
					$output .= '</div></div>';

			echo $output;
		}

		function clients_method(){
			wp_register_style('clientsCSS',get_template_directory_uri() . "/css/content-builder/clients_logo.css");
			wp_enqueue_style('clientsCSS');
			wp_register_script('clientsJS',get_template_directory_uri() . "/scripts/modules/builder_clients_logo.js",array('jquery'),'2.0.3',true);
			wp_enqueue_script('clientsJS');
		}

		/* AJAX add tab */
		function add_tab() {
			// $nonce = $_POST['security'];
			// if (! wp_verify_nonce($nonce, 'aqpb-settings-page-nonce') ) die('-1');

			$count = isset($_POST['count']) ? absint($_POST['count']) : false;
			$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'aq-block-9999';

			//default key/value for the tab
			$tab = array(
				'imagesrc' =>'',
				'link1' => ''
			);

			if($count) {
				$this->tab($tab, $count);
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
