<?php
global $post;
$post_format = get_post_format( $post );
$post_format = $post_format ? $post_format : 'standard';
$data = wp_parse_args( get_post_meta( $post->ID, '_circleflip_post_formats', true ), array(
	'audio_embed'		 => '',
	'audio_id'			 => '',
	'video_embed'		 => '',
	'video_id'			 => '',
	'slider_shortcode'	 => '',
	'slider'			 => '',
	'gallery'            => array(),
	'gallery_layout'     => 'layout1',
		) );
$data['audio_text'] = $data['audio_id'] ? get_post( $data['audio_id'] )->post_title : '';
$data['video_text'] = $data['video_id'] ? get_post( $data['video_id'] )->post_title : '';
?>
<!-- POST FORMAT AUDIO -->
<div class="circleflip-pf-audio circleflip-post-formats <?php echo 'audio' !== $post_format ? 'hidden' : '' ?>">
	<div class="circleflip-media-embed">
		<label for="circleflip-pf-audio-input">Paste your link here(Embed Code or Direct Link)</label>
		<br />
		<input id="circleflip-pf-audio-input" type="text" name="_circleflip_post_formats[audio_embed]" value="<?php echo esc_attr( $data['audio_embed'] ) ?>" />
	</div>
	<div class="circleflip-media-upload">
		<label for="circleflip-pf-audio-media"><strong>OR</strong> Upload your file here</label>
		<input type="text" class="circleflip-media-target-text"
			   id="circleflip-pf-audio-media"
			   value="<?php echo esc_attr( $data['audio_text'] ) ?>" readonly>
		<input type="hidden" class="circleflip-media-target"
			   name="_circleflip_post_formats[audio_id]"
			   value="<?php echo esc_attr( $data['audio_id'] ) ?>">
		<button type="button" class='circleflip-media button button-primary button-small' data-type='Audio'>
			<?php echo empty( $data['audio_id'] ) ? 'Upload' : 'Change' ?>
		</button>
		<button type="button"
				class="circleflip-media-remove button button-primary button-small <?php echo empty( $data['audio_id'] ) ? 'hidden' : '' ?>">
			Remove
		</button>
	</div>
</div>
<!-- POST FORMAT VIDEO -->
<div class="circleflip-pf-video circleflip-post-formats <?php echo 'video' !== $post_format ? 'hidden' : '' ?>">
	<!-- EMBED CODE -->
	<div class="circleflip-media-embed">
		<label for="circleflip-pf-video-input">Paste your link here(Embed Code or Direct Link)</label>
		<br />
		<input id="circleflip-pf-video-input" name="_circleflip_post_formats[video_embed]" value="<?php echo esc_attr($data['video_embed']) ?>" />
	</div>
	<!-- UPLOAD -->
	<div class="circleflip-media-upload">
		<label for="circleflip-pf-video-media"><strong>OR</strong> Upload your file here</label>
		<input type="text" class="circleflip-media-target-text"
			   id="circleflip-pf-video-media"
			   value="<?php echo esc_attr( $data['video_text'] ) ?>" readonly>
		<input type="hidden" class="circleflip-media-target"
			   name="_circleflip_post_formats[video_id]"
			   value="<?php echo esc_attr( $data['video_id'] ) ?>">
		<button type="button" class='circleflip-media button button-primary button-small ' data-type='Video'>
			<?php echo empty( $data['video_id'] ) ? 'Upload' : 'Change' ?>
		</button>
		<button type="button"
				class="circleflip-media-remove button button-primary button-small  <?php echo empty( $data['video_id'] ) ? 'hidden' : '' ?>">
			Remove
		</button>
	</div>
</div>
<!-- POST FORMAT GALLERY -->
<div class="circleflip-pf-gallery circleflip-post-formats <?php echo 'gallery' !== $post_format ? 'hidden' : '' ?>">
	<input type="hidden" name="_circleflip_post_formats[gallery]" id="gallery-ids" value="<?php echo esc_attr(implode( ',', $data['gallery'] )) ?>">
	<h4 style="display: inline-block;margin-right: 30px;">Select Gallery Images</h4><button type="button" id="gallery-button" class="button button-primary button-small">Select</button>
        <?php $layouts = array(
	            'layout1' => 'layout1',
	            'layout2' => 'layout2',
	            'layout3' => 'layout3',
	            'layout4' => 'layout4'
	        );
		$images = array( 0 => 'layout-1.png', 1 => 'layout-2.png', 2 => 'layout-3.png', 3 => 'layout-4.png');
        ?>
        <h4>Gallery Layout</h4>
		<div id="sidebar-positions">
			<ul>
				<?php foreach ($layouts as $slug => $label): ?>
				<li>
					<label class="sidebar-position">
					<input type="radio" name="_circleflip_post_formats[layout]" id="<?php echo esc_attr($label) ?>"
						value="<?php echo esc_attr($slug) ?>" <?php checked($data['gallery_layout'], $slug) ?>> <?php echo esc_html($label) ?>
						<img src="<?php echo esc_url( get_template_directory_uri() . '/creiden-framework/images/' . array_shift($images) ) ?>" class="of-radio-img-img"  style="display: inline;">
					</label>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
</div>