<?php
/** A simple text block **/
class CR_Twitter_Block extends AQ_Block {

	//set and create block
	function __construct() {
		$block_options = array(
			'image' => 'twitter.png',
			'name' => 'Twitter',
			'size' => 'span6',
			'tab'    => 'Content',
                        'imagedesc' => 'twitter.jpg',
                        'desc' => 'Gets the twitter feed of the user name specified.'
		);

		//create the block
		parent::__construct('cr_twitter_block', $block_options);
	}

	function form($instance) {

		$defaults = array(
			'text' => '',
			'entrance_animation' => '',
			'count' => 3,
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);

		?>
		<p class="description">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('title') ) ?>">
					<?php _e( 'Title', 'circleflip-builder' ) ?>
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
		<p class="description">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('text') ) ?>">
					<?php _e( 'Username', 'circleflip-builder' ) ?>
				</label>
				<span class="description_text">
					<?php _e( "the twitter username whose feed will be shown", 'circleflip-builder' ) ?>
				</span>
			</span>
			<span class="rightHalf">
				<?php echo circleflip_field_input('text', $block_id, $text, $size = 'full') ?>
			</span>
		</p>
		<p class="description">
			<span class="leftHalf">
					<label for="<?php echo esc_attr( $this->get_field_id('count') ) ?>">
						<?php _e( 'How many tweets to show ?', 'circleflip-builder' ) ?>
					</label>
				</span>
				<span class="rightHalf">
					<?php echo circleflip_field_input('count', $block_id, $count, $size = 'full') ?>
				</span>
			</p>
			<p class="description half">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('entrance_animation') ) ?>">
					<?php _e('Animation', 'circleflip-builder') ?>
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
		<?php
	}

	function block($instance) {
		extract($instance);
		$this->twitter_method($instance);
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
			$titleIconHead = '<div class="headerDot"><span class="'.$iconHead.'"></span></div>';
		}
		?>
		<div class="twitterWrapper animateCr <?php echo esc_attr( $entrance_animation ) ?>">
			<?php if(circleflip_valid($title)) { ?>
			<div class="titleBlock">
				<h3><?php echo $titleIconHead . esc_html( $title ); ?></h3>
			</div>
			<?php } ?>
			<div class="<?php echo esc_attr( $block_id ); ?> twitterBlock"></div>
		</div>
		<?php
	}

	function twitter_method($instance) {
		extract($instance);
		wp_register_style('twitterBlockCSS',get_template_directory_uri() . "/css/content-builder/twitter_block.css");
		wp_enqueue_style('twitterBlockCSS');
		?>
		<script>
			jQuery(window).load(function($) {
				jQuery(".<?php echo $block_id ?>").tweet({
					username : "<?php echo $text ?>",
					count : <?php echo $count ?>,
					loading_text : "loading tweets..."
				});
			});
		</script>
		<?php
	}

}