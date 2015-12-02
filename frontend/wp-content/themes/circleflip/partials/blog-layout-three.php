<?php
$categories = wp_get_post_categories( get_the_ID(), array( 'fields' => 'all' ) );
$cat_list = array();
foreach ( $categories as $category ) {
    $cat_list[] = '<a href=' . get_category_link( $category ) . '>'
	    . '<p class="color">' . $category->name . '</p></a>';
}

$tags = wp_get_post_tags( get_the_ID(), array( 'fields' => 'all' ) );
$tags_list = array();
foreach ( $tags as $tag ) {
    $tags_list[] = '<a href=' . get_tag_link( $tag ) . '>'
	    . '<p class="color">' . $tag->name . '</p></a>';
}
?>
<div class="postBlog4 clearfix">
    <div class="postDateCreagory">
	<?php if ( cr_get_option( 'blog_date' ) == 1 ) { ?>
    	<!-- Post Date -->
    	<div class="postDate cleafix">
    	    <div class="innerBorder clearfix">
    		<div class="day">
    		    <div class="right">
    			<p>
				<?php echo get_the_date( 'd' ) ?>
    			</p>
    			<span><?php echo get_the_date( 'D' ) ?></span>
    		    </div>
    		</div>
    		<div class="monthYear">
    		    <div class="left">
    			<p>
				<?php echo get_the_date( 'M y' ) ?>
    			</p>
    		    </div>
    		</div>
    		<div class="dottedTriangle">
    		    <span></span>
    		</div>
    	    </div>
    	</div>
	<?php } ?>
	<div class="postCreagory clearfix">
	    <?php if ( cr_get_option( 'blog_author' ) ) { ?>
    	    <div>
    		<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" class="postAuthor">
    		    <span class="icon-user"></span>
    		    <p class="color"><?php the_author_meta( 'display_name' ); ?></p>
    		</a>
    	    </div>
	    <?php } ?>	
	    <!-- CATEGORIES -->
	    <?php if ( $cat_list ) : ?>
    	    <div class="PostCategories">
    		<span class="icon-folder"></span>
		    <?php echo implode( '<p class="color">,</p>', $cat_list ); ?>
    	    </div>
	    <?php endif; ?>
	    <!-- Views -->
	    <?php if ( get_post_type() != 'circleflip-offer' ): ?>
		<?php if ( cr_get_option( "blog_views_count", '0' ) == 1 ) { ?>
		    <div class="postViews">
			<span class="icon-eye"></span>
			<p class="color">
			    <?php
			    if ( cr_get_option( "rtl", '0' ) == '1' ) {
				$standard = array( "0", "1", "2", "3", "4", "5", "6", "7", "8", "9" );
				$east_arabic = array( "&#1632;", "&#1633;", "&#1634;", "&#1635;", "&#1636;", "&#1637;", "&#1638;", "&#1639;", "&#1640;", "&#1641;" );
				$numOfViews = circleflip_read_number_of_views( $post->ID );
				$numOfViews = str_replace( $standard, $east_arabic, $numOfViews );
			    } else {
				$numOfViews = circleflip_read_number_of_views( $post->ID );
			    }
			    echo esc_html($numOfViews);
			    ?>
			</p>
		    </div>
		<?php } ?>
	    <?php else: ?>
		<?php
		$offer_meta = get_post_meta( get_the_ID(), 'cflip_offer_meta' ) ? get_post_meta( get_the_ID(), 'cflip_offer_meta', true ) : "";
		?><div class="postViews">
			<span class="icon-users"></span>
			<p class="color">
			    <?php echo esc_html($offer_meta['person']); ?>
			</p>
		</div>
	    <?php endif; ?>
	    <!-- TAGS -->
	    <?php if ( $tags_list ) : ?>
    	    <div class="postTags">
    		<span class="icon-tag"></span>
		    <?php echo implode( '<p class="color">,</p>', $tags_list ); ?>
    	    </div>
	    <?php endif; ?>
	    <div>
		<a href="#" class="postComment"><span class="icon-comment"></span><p class="color"><?php comments_number(); ?> </p></a>
	    </div>
	</div>
    </div>
    <!-- Post Details -->
    <div class="postDetails">
	<!-- Post Image -->
	<div class="postImage <?php echo has_post_format( 'video' ) ? 'embedBlock iframe_container' : '' ?>">
	    <?php echo circleflip_get_post_format_media( $post->ID, 'blog_posts_4_full' ) ?>
	</div>
	<a href="<?php the_permalink() ?>">
	    <h2><?php the_title() ?></h2>
	</a>
	<div class="clearfix postText">
	    <p>
		<?php echo circleflip_string_limit_characters( get_the_excerpt(), '800' ) ?>
	    </p>
	    <a class="postLink btnStyle2 red" href="<?php the_permalink() ?>"><span><?php _e( 'More', 'circleflip' ); ?></span><span class='btnBefore'></span><span class='btnAfter'></span></a>
	</div>
    </div>
</div>
