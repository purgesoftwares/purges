<?php
/** A simple text block **/
class CR_Contact_Details extends AQ_Block {

	//set and create block
	function __construct() {
		$block_options = array(
			'image'=> 'contact_details.png',
			'name' => 'Contact Details',
			'size' => 'span6',
                        'tab' => 'Content',
                        'imagedesc' => 'contact.jpg',
                        'desc' => 'Shows contact details you specify.'
		);

		//create the block
		parent::__construct('cr_contact_details', $block_options);
		add_action('wp_ajax_aq_block_cd_tab_add_new', array($this, 'add_tab'));
	}

	function form($instance) {

		$defaults = array(
			'title' => 'Contact Details',
			'entrance_animation' => '',
			'tabs' => array(
				0 => array(
					'title_branch' => 'Main Branch',
					'text' => 'Circle Flip inc. <br /> 701 First Avenue, Sunnyvalesa, CA',
					'postal' => '94089',
					'tel'=> '(408) 349-3300',
					'fax'=> '(408) 349-3301',
					'mail'=> 'info@creiden.com',
				)
			),
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);

		?>
		<div class="description cf">
		<p class="description">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('title') ) ?>">
					Section Title
				</label>
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
			if(isset($tabs)){
				foreach($tabs as $tab) {
					$this->tab($tab, $count);
					$count++;
				}
			}
			?>
		</ul>
		<p></p>
		<a href="#" rel="cd_tab" class="aq-sortable-add-new button">Add New</a>
		<p></p>
		</div>
		<?php
	}


	function tab($tab = array(), $count = 0) {
		$tab = wp_parse_args($tab, array(
					'title_branch' => 'Main Branch',
					'text' => 'Circle Flip inc. <br /> 701 First Avenue, Sunnyvalesa, CA',
					'postal' => '94089',
					'tel'=> '(408) 349-3300',
					'fax'=> '(408) 349-3301',
					'mail'=> 'info@creiden.com',
		));
		?>
		<li id="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-sortable-item-<?php echo esc_attr($count) ?>" class="sortable-item" rel="<?php echo esc_attr($count) ?>">

			<div class="sortable-head cf">
				<div class="sortable-title">
					<strong>Contact <?php echo esc_attr($count); ?></strong>
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
						<label for="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-title_branch">
							Title Branch
						</label>
					</span>
					<span class="rightHalf">
						<input type="text" id="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-title_branch" class="input-full" name="<?php echo esc_attr( $this->get_field_name('tabs') ) ?>[<?php echo esc_attr($count) ?>][title_branch]" value="<?php echo esc_attr($tab['title_branch']) ?>" />
					</span>
				</p>
				<p class="tab-desc description">
					<span class="leftHalf">
						<label for="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-text">
							Address
						</label>
					</span>
					<span class="rightHalf">
						<textarea id="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-text" class="textarea-full" name="<?php echo esc_attr( $this->get_field_name('tabs') ) ?>[<?php echo esc_attr($count) ?>][text]" rows="5"><?php echo isset($tab['text']) && !empty($tab['text']) ? $tab['text'] : ''?></textarea>
					</span>
				</p>
				<p class="tab-desc description">
						<span class="leftHalf">
							<label for="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-postal">
								Postal Code
							</label>
							<span class="description_text">
								Write Postal Code here.
							</span>
						</span>
						<span class="rightHalf">
							<input type="text" id="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-postal" class="input-full" name="<?php echo esc_attr( $this->get_field_name('tabs') ) ?>[<?php echo esc_attr($count) ?>][postal]" value="<?php echo isset($tab['postal']) && !empty($tab['postal']) ? $tab['postal'] : '' ?>" />
						</span>
					</p>
					<p class="tab-desc description">
						<span class="leftHalf">
							<label for="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-tel">
								Telephone
							</label>
							<span class="description_text">
								Write Telephone here.
							</span>
						</span>
						<span class="rightHalf">
							<input type="text" id="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-tel" class="input-full" name="<?php echo esc_attr( $this->get_field_name('tabs') ) ?>[<?php echo esc_attr($count) ?>][tel]" value="<?php echo isset($tab['tel']) && !empty($tab['tel']) ? $tab['tel'] : '' ?>" />
						</span>
					</p>
					<p class="tab-desc description">
						<span class="leftHalf">
							<label for="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-fax">
								Fax
							</label>
							<span class="description_text">
								Write Fax here.
							</span>
						</span>
						<span class="rightHalf">
							<input type="text" id="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-fax" class="input-full" name="<?php echo esc_attr( $this->get_field_name('tabs') ) ?>[<?php echo esc_attr($count) ?>][fax]" value="<?php echo isset($tab['fax']) && !empty($tab['fax']) ? $tab['fax'] : '' ?>" />
						</span>
					</p>
					<p class="tab-desc description">
						<span class="leftHalf">
							<label for="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-mail">
								E-mail
							</label>
							<span class="description_text">
								Write E-Mail here.
							</span>
						</span>
						<span class="rightHalf">
							<input type="text" id="<?php echo esc_attr( $this->get_field_id('tabs') ) ?>-<?php echo esc_attr($count) ?>-mail" class="input-full" name="<?php echo esc_attr( $this->get_field_name('tabs') ) ?>[<?php echo esc_attr($count) ?>][mail]" value="<?php echo isset($tab['mail']) && !empty($tab['mail']) ? $tab['mail'] : '' ?>" />
						</span>
					</p>
			</div>

		</li>
		<?php
	}


	function block($instance) {
		extract($instance);
		if($entrance_animation == 'default') {
			$entrance_animation = cr_get_option('block_animations');
		}
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
		?>
		<div class="contactDetailsSection">
			<?php if(isset($title) && !empty($title)) { ?>
				<div class="titleBlock"><h3 class="grid3"><?php echo $titleIconHead . do_shortcode(htmlspecialchars_decode($title)) ?></h3></div>
			<?php } ?>
			<?php foreach( $tabs as $tab ){ ?>
			<?php if(isset($tab['title_branch']) && !empty($tab['title_branch'])) { ?>
				<h5 class="titleBranch"><?php echo esc_html($tab['title_branch']); ?></h5>
			<?php } ?>
			<?php if(isset($tab['text']) && !empty($tab['text'])) { ?>
				<p class="grid2 contactText"><?php echo do_shortcode(htmlspecialchars_decode($tab['text'])) ?></p>
			<?php } ?>

			<ul class="contactDetails">
				<?php if(isset($tab['postal']) && !empty($tab['postal'])) { ?>
					<li class="animateCr <?php echo esc_attr($entrance_animation)?>">
						<p>
						<span><?php _e('Postal Code: ','circleflip'); ?></span><?php echo do_shortcode(htmlspecialchars_decode($tab['postal'])) ?>
					 	</p>
					</li>
				 <?php } ?>

				 <?php if(isset($tab['tel']) && !empty($tab['tel'])) { ?>
					<li class="animateCr <?php echo esc_attr($entrance_animation)?>">
						<p>
						<span><?php _e('Telephone: ','circleflip'); ?></span><?php echo do_shortcode(htmlspecialchars_decode($tab['tel'])) ?>
					 	</p>
					</li>
				 <?php } ?>

				 <?php if(isset($tab['fax']) && !empty($tab['fax'])) { ?>
					<li class="animateCr <?php echo esc_attr($entrance_animation)?>">
						<p>
						<span><?php _e('Fax: ','circleflip'); ?></span><?php echo do_shortcode(htmlspecialchars_decode($tab['fax'])) ?>
					 	</p>
					</li>
				 <?php } ?>

				 <?php if(isset($tab['mail']) && !empty($tab['mail'])) { ?>
					<li class="animateCr <?php echo esc_attr($entrance_animation)?>">
						<p class="contactMailText">
						<span><?php _e('Mail: ','circleflip'); ?></span><a href="mailto:<?php echo do_shortcode(htmlspecialchars_decode($tab['mail'])) ?>"><?php echo do_shortcode(htmlspecialchars_decode($tab['mail'])) ?></a>
					 	</p>
					</li>
				 <?php } ?>
			</ul>
			<?php } ?>
		</div>
		<?php
	}


	/* AJAX add tab */
	function add_tab() {
		$count = isset($_POST['count']) ? absint($_POST['count']) : false;
		$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'aq-block-9999';
		//default key/value for the tab
		$tab = array(
			'title' => 'Feature '. $count,
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