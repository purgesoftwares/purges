<?php 
	class Circleflip_follow extends WP_Widget {
		function __construct() {
			parent::__construct(false, 'CF contact information');
		}
		
		function form($instance) {
			$this->if__i__();
		// outputs the options form on admin
			$instance = wp_parse_args($instance, array(
				'title' => 'Reaching Us !',
				'text' => 'You can reach us through various ways, either through the follwoing contacts or through social media below.<br/><br/>Circle Flip inc.<br/>701 First Avenue, Sunnyvalesa, CA, USA',
				'postalCode' => '94089',
				'tel' => '(408) 349-3300',
				'fax' => '(408) 349-3301',
				'social' => array(),
			));
			extract($instance);
		 	?>
            <p>
        		<label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
	            	<?php _e('Title:','circleflip'); ?> 
	            	<input class="widefat" 
	            		   id="<?php echo esc_attr($this->get_field_id('title')); ?>" 
	            		   name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
    		   </label>
		   	</p>
            <br />
            <p><label for="<?php echo esc_attr($this->get_field_id('text')); ?>"><?php _e('Text :','circleflip'); ?> <textarea style="height: 150px" class="widefat" id="<?php echo esc_attr($this->get_field_id('text')); ?>" name="<?php echo esc_attr($this->get_field_name('text')); ?>"><?php echo esc_textarea( $text); ?></textarea></label></p>
            <br />
            <p><label for="<?php echo esc_attr($this->get_field_id('postalCode')); ?>"><?php _e('Postal Code:','circleflip'); ?> <input class="widefat" id="<?php echo esc_attr($this->get_field_id('postalCode')); ?>" name="<?php echo esc_attr($this->get_field_name('postalCode')); ?>" type="text" value="<?php echo esc_attr($postalCode); ?>" /></label></p>
            <br />
            <p><label for="<?php echo esc_attr($this->get_field_id('tel')); ?>"><?php _e('Telephone:','circleflip'); ?> <input class="widefat" id="<?php echo esc_attr($this->get_field_id('tel')); ?>" name="<?php echo esc_attr($this->get_field_name('tel')); ?>" type="text" value="<?php echo esc_attr($tel); ?>" /></label></p>
            <br />
            <p><label for="<?php echo esc_attr($this->get_field_id('fax')); ?>"><?php _e('Fax:','circleflip'); ?> <input class="widefat" id="<?php echo esc_attr($this->get_field_id('fax')); ?>" name="<?php echo esc_attr($this->get_field_name('fax')); ?>" type="text" value="<?php echo esc_attr($fax); ?>" /></label></p>
            <br />
            <?php
			    wp_enqueue_style( 'wp-color-picker' );
				wp_enqueue_script( 'wp-color-picker' );
            ?>
            <p>Social links:</p>
			<div id="<?php echo esc_attr($this->get_field_id('social-links-container')) ?>">
				<?php foreach( $instance['social'] as $social_item) : ?>
				<div class="crdn-contact-social-item" style="position: relative;">
					<button class="crdn-remove-contact-social-item" type="button">X</button>
					<p style="width: 47%;float: left;">
						<label>
							Link:
							<input class="widefat" 
								   name="<?php echo esc_attr($this->get_field_name('social_link')) ?>[]" 
								   type="text" value="<?php echo esc_url($social_item[0]) ?>" />
						</label>
				   	</p>
				   	<div style="width: 47%;float: right;margin: 1em 0;">
						<label>
							Icon:
								   <?php echo circleflip_icon_selector( $this->get_field_name( 'social_icon' ) . "[]", $social_item[1] ) ?>
						</label>
				   	</div>
				   	<p style="clear: both;">
				   		<label>
				   			<input class="crdn-ci-color-field" 
								   name="<?php echo esc_attr($this->get_field_name('social_color')) ?>[]" 
								   type="text" value="<?php echo esc_attr($social_item[2]) ?>" data-default-color="#2daae1"/>
				   		</label>
				   	</p>
				   	<hr />
			   </div>
				<?php endforeach ?>
			</div>
			<input type="button" value="New Social" 
				   id="<?php echo esc_attr($this->get_field_id('add-social-field')) ?>" 
				   data-target="#<?php echo esc_attr($this->get_field_id('social-links-container')) ?>"
				   data-social-link="<?php echo esc_attr($this->get_field_name('social_link')) ?>"
				   data-social-icon="<?php echo esc_attr($this->get_field_name('social_icon')) ?>"
				   data-social-color="<?php echo esc_attr($this->get_field_name('social_color')) ?>"
				   class="crdn-ci-add-social-icon"/>
			<script>
				jQuery(function($){$('#<?php echo esc_attr($this->get_field_id( 'social-links-container' )) ?>').find('.crdn-ci-color-field').wpColorPicker()})
			</script>
        <?php 
		}
		
		protected function if__i__() {
		if ( $this->number !== '__i__' )
				return;
		?>
			<style>
			.crdn-remove-contact-social-item{
				position: absolute;
				right: 0px;
				top: 0px;
				background: rgb(204, 204, 204);
				border: 1px solid white;
				cursor: pointer;
				font-family: Arial;
				font-weight: bold;
				font-size: 12px;
				color: white;
				padding: 1px 4px 1px 4px;
				border-radius: 4px;
			}
			.crdn-remove-contact-social-item:hover {
				background: rgb(163, 163, 163);
			}
			.preview{
				margin: 5px 15px 0px 0px;
			}
			</style>
			<script id="crdn-tmpl-contact-info-social-icons" type="text/tmpl">
				<div class="crdn-contact-social-item" style="position: relative;">
					<button class="crdn-remove-contact-social-item" type="button">X</button>
					<p style="width: 47%;float: left;">
						<label>
							Link:
							<input class="widefat" 
								   name="<%=data.social_link_name%>[]" 
								   type="text" value="" />
						</label>
				   	</p>
				   	<div style="width: 47%;float: right;margin: 1em 0;">
						<label>
							Icon:
							<?php echo circleflip_icon_selector('<%=data.social_icon_name%>[]') ?>
						</label>
				   	</div>
				   	<p style="clear: both;">
						<label>
							<input class="crdn-ci-color-field" 
								   name="<%=data.social_color_name%>[]" 
								   type="text" value="2daae1" data-default-color="#2daae1"/>
						</label>
				   	</p>
				   	<hr />
			   	</div>
			</script>
			<?php
		}
				
		function update($new_instance, $old_instance) {
			// processes widget options to be saved
			$instance = $old_instance;
			$social_links = array_map(null, $new_instance['social_link'], $new_instance['social_icon'], $new_instance['social_color']);
			unset($new_instance['social_icon']);
			unset($new_instance['social_link']);
			unset($new_instance['social_color']);
			$text = $new_instance['text'];
			$instance = array_map('strip_tags', $new_instance);
			$instance['text'] = $text;
			$instance['social'] = ! empty($social_links) ? $social_links : array();
			return $instance;
		}
		
		function contactInformation(){
			wp_enqueue_style('Contact_information_css', get_template_directory_uri() . '/css/widgets/contact_information.css');
		}
		
		function widget($args, $instance) {
			// outputs the content of the widget
			extract( $args );
			$this->contactInformation();
       		 $title = apply_filters('widget_title', $instance['title']);
			 $text = $instance['text'];
			 $postalCode = $instance['postalCode'];
			 $tel = $instance['tel'];
			 $fax = $instance['fax'];
			 $social = $instance['social'];
			 if($args['id'] == 'sidebar-footerwidgetarea')
				 $footer_width = 'span'.circleflip_calculate_widget_width();
			 else 
				$footer_width = '';
			 ?>
				<li class="informationWidget widget customWidget <?php echo esc_attr($footer_width) ?>">
					<?php if($title != null) { ?>
						<div class="widgetDot"></div>
						<h3 class="widgetTitle"><?php echo esc_html($title);?></h5>
					<?php } ?>
					<?php if($text != null) { ?>
						<p><?php echo esc_html($text);?></p>
					<?php } ?>
					<?php if($postalCode != null || $tel != null || $fax !=null) { ?>
						<ul class="informationList <?php if(count($instance['social']) != 0 ){ echo 'grid4'; } ?>">
							<?php if($postalCode != null) { ?>
								<li>
									<span><?php _e('Postal Code: ','circleflip'); ?></span><?php echo esc_html($postalCode);?>
								</li>
							<?php } ?>
							<?php if($tel != null) { ?>
								<li>
									<span><?php _e('Tel: ','circleflip'); ?></span><?php echo esc_html($tel);?>
								</li>
							<?php } ?>
							<?php if($fax != null) { ?>
								<li>
									<span><?php _e('Fax: ','circleflip'); ?></span><?php echo esc_html($fax);?>
								</li>
							<?php } ?>
						</ul>
					<?php } ?>
					<?php if(count($instance['social']) != 0 ){ ?>
					<ul class="widgetSocials clearfix">
						<?php foreach( $instance['social'] as $social_item) : ?>
							<li onMouseOut="this.style.backgroundColor='#494949'" onMouseOver="this.style.backgroundColor='<?php echo esc_js($social_item[2]); ?>'">
								<a href="<?php echo esc_url($social_item[0]); ?>">
									<div class="<?php echo esc_attr($social_item[1]); ?>"></div>
								</a>
							</li>
						<?php endforeach ?>
					</ul>
					<?php } ?>
				</li>
			<?php }
		}
	register_widget('Circleflip_follow');
