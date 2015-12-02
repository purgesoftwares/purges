<!-- ITEM -->
<?php tha_entry_before() ?>
<li <?php post_class( array('item') ) ?>>
	<?php tha_entry_top() ?>
		<?php echo circleflip_get_post_format_media(get_the_ID()); ?>
	<?php tha_entry_bottom() ?>
</li>
<?php tha_entry_after() ?>