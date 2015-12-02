<?php
/**
 * Description of cr-gallery
 *
 * @author ayman
 */
class CR_Gallery extends AQ_Block {
	public function __construct() {
		parent::__construct( 'cr_gallery', array(
			'image'	 => 'image_slider.png',
			'name'	 => 'Gallery',
			'size'	 => 'span6',
			'tab'    => 'media',
                        'imagedesc' => 'gallery.jpg',
                        'desc' => 'Adds an Image gallery with the layout of your choice.'
		) );
	}

	public function block( $instance ) {
		$this->set_defaults( $instance );
		if ( ! empty( $instance['ids'] ) )
			echo circleflip_get_gallery( $instance['ids'], $instance['layout'] );
	}

	public function form( $instance ) {
		$instance = $this->set_defaults($instance);
		$this->admin_enqueue();
		$ids = implode( ',', $instance['ids'] );
		$layouts = array(
			'layout1' => 'Layout 1',
			'layout2' => 'Layout 2',
			'layout3' => 'Layout 3',
			'layout4' => 'Layout 4',
		);
		?>
		
		
		<p class="description">
			<span class="leftHalf">
				<label>
					<?php _e( 'Select', 'circleflip-builder' ) ?>
				</label>
				<span class="description_text">
					<?php _e( 'Select gallery images', 'circleflip-builder' ) ?>
				</span>
			</span>
			<span class="rightHalf">
				<span class="rightHalf">
					<input type="hidden" class="cr-gallery-ids" value="<?php echo esc_attr($ids) ?>" name="<?php echo esc_attr( $this->get_field_name( 'ids' ) ) ?>">
					<button type="button" class="cr-gallery">select</button>
				</span>
			</span>
		</p>
		
		<div class="description" style="width: 100%;">
			<ul class="cr-gallery-list">
				<?php $this->gallery_list( $instance['ids'] ); ?>
			</ul>
		</div>
		
		<p class="description">
			<span class="leftHalf">
				<label>
					<?php _e( 'Layout', 'circleflip-builder' ) ?>
				</label>
				<span class="description_text">
					<?php _e( 'Choose gallery layout', 'circleflip-builder' ) ?>
				</span>
			</span>
			<span class="rightHalf">
				<span class="rightHalf radioBtnWrapper">
					<?php $i=1; ?>
					<?php foreach ( $layouts as $slug => $layout ) : ?>
					<label style="width: auto;display: inline-block;margin-right: 30px;vertical-align: top;">
						<input type="radio"
							   name="<?php echo esc_attr( $this->get_field_name( 'layout' ) ) ?>"
							   value="<?php echo esc_attr($slug) ?>"
							   <?php checked( $instance['layout'], $slug ) ?> >
						<?php echo esc_html($layout) ?>
						<img style="display: block;margin-top:10px;" src="<?php echo get_template_directory_uri();  ?>/creiden-framework/content-builder/assets/images/gallery_layout<?php echo esc_attr($i);$i++; ?>.png" alt=""/>
					</label>
				<?php endforeach; ?>
				</span>
			</span>
		</p>
		
		<?php
	}

	public function update( $new_instance, $old_instance ) {
			$new_instance['ids'] = explode( ',', $new_instance['ids'] );
		return parent::update( $new_instance, $old_instance );
	}

	protected function gallery_list( $ids ) {
		foreach( $ids as $id ) {
			echo '<li>', wp_get_attachment_image( $id ), '</li>';
		}
	}

	protected function admin_enqueue() {
		wp_register_script(
				'cr-gallery-admin',
				get_template_directory_uri() . '/creiden-framework/content-builder/assets/js/blocks/cr-gallery-admin.js',
				array('jquery', 'underscore'),'2.0.3',true
		);
		wp_enqueue_script( 'cr-gallery-admin' );
	}

	protected function wp_enqueue() {

	}

	protected function set_defaults($instance) {
		return wp_parse_args( $instance, array('ids' => array(), 'layout' => 'layout1') );
	}
}