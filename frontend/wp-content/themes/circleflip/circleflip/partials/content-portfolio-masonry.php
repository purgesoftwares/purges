<!-- ITEM -->
	<?php tha_entry_before();

	?>
			<?php tha_entry_top() ?>
			<div <?php post_class( array('item','masonryItem')) ?>>
			  	<div class="masonryItemInner">
					<?php echo circleflip_get_post_format_media(get_the_ID()); ?>
			  	</div>
			  	
			</div>
		<?php tha_entry_bottom() ?>
	<?php tha_entry_after() ?>