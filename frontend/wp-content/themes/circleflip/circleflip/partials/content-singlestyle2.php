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
    $tags_list[] = '<a href=' . esc_url( get_tag_link( $tag ) ) . '>'
			. '<p class="color">' . esc_html( $tag->name ) . '</p></a>';
}

if ( cr_get_option( 'post_sidebars_option' ) == 'global' ) {
    if ( cr_get_option( 'post_layout' ) == 'none' ) {
	$sidebar_exist = 'span3';
    } else if ( cr_get_option( 'post_layout' ) == 'left' ) {
	$sidebar_exist = 'span4';
    } else if ( cr_get_option( 'post_layout' ) == 'right' ) {
	$sidebar_exist = 'span4';
    }
} else {
    $sidebar_exist = get_post_custom_values( '_sidebar-position', $post->ID );
    if ( $sidebar_exist[0] == 'none' ) {
	$sidebar_exist = 'span3';
    } else {
	$sidebar_exist = 'span4';
    }
}
?>
<div class="blog1">
    <!-- Blog Layout 1 Post -->
    <div class="postBlog1 blogStyle2 clearfix">
	<!-- Post Date -->
	<!-- Post Details -->
	<div class="postDetails">
	    <?php global $post; ?>
	    <h2><?php the_title(); ?></h2>
	    <div class="postCreagory clearfix">
		<a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) )); ?>" class="postAuthor">
		    <span class="icon-user"></span>
		    <p class="color"><?php the_author_meta( 'display_name' ); ?></p>
		</a>
		<!-- CATEGORIES -->
		<?php if ( $cat_list ) : ?>
    		<div class="PostCategories">
    		    <span class="icon-folder"></span>
			<?php echo implode( '<p class="color">,</p>', $cat_list ); ?>
    		</div>
		<?php endif; ?>
		<!-- Views -->
		<?php if ( get_post_type() != 'circleflip-offer' ): ?>

		    <?php if ( cr_get_option( "post_views", '0' ) == 1 ) { ?>
			<div class="postViews">
			    <span class="icon-eye"></span>
			    <p class="color">
				<?php
				if ( cr_get_option( "rtl", '0' ) == '1' ) {
				    $standard = array( "0", "1", "2", "3", "4", "5", "6", "7", "8", "9" );
				    $east_arabic = array( "&#1632;", "&#1633;", "&#1634;", "&#1635;", "&#1636;", "&#1637;", "&#1638;", "&#1639;", "&#1640;", "&#1641;" );
				    $numOfViews = circleflip_get_number_of_views( $post->ID );
				    $numOfViews = str_replace( $standard, $east_arabic, $numOfViews );
				} else {
				    $numOfViews = circleflip_get_number_of_views( $post->ID );
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
		<?php if ( cr_get_option( 'post_comments_count', '' ) == 1 ) { ?>
    		<a href="#commentReplay" class="postComment">
    		    <span class="icon-comment"></span>
				<p><?php echo esc_html( get_comments_number( $post->ID ) . ' Comments' ) ?></p>
    		</a>
		<?php } ?>
	    </div>
	    <!-- Post Image -->
	    <?php
	    if ( cr_get_option( 'post_view_image', '' ) == 1 ) {
		if ( get_post_format_string( get_post_format() ) != 'Standard' || (get_post_format_string( get_post_format() ) == 'Standard' && has_post_thumbnail( $post->ID )) ) {
		    ?>
		    <div class="postImage">
			<?php echo circleflip_get_post_format_media( $post->ID, 'full' ) ?>
		    </div>
		<?php } ?>
		<?php if ( get_post_format_string( get_post_format() ) == 'Standard' && has_post_thumbnail( $post->ID ) ) { ?>
		    <div class="arrow-left arrowdate"></div>
		<?php } ?>
    	    <div class="postDate <?php if ( get_post_format_string( get_post_format() ) != 'Standard' || (get_post_format_string( get_post_format() ) == 'Standard' && ! has_post_thumbnail( $post->ID )) ) { ?> postDateFormat <?php } ?>">
    		<div class="dayMonth">
    		    <p><?php the_date( 'd F,y' ) ?></p>
    		</div>
		    <?php if ( cr_get_option( 'show_like' ) == 1 ) { ?>
			<div class="like">
			    <p><?php
				echo get_post_meta( $post->ID, '_likes', true );
				if ( get_post_meta( $post->ID, '_likes', true ) == '' ) {
				    echo '0';
				}
				?> Likes</p>
			</div>
		    <?php } ?>
    	    </div>
	    <?php } ?>
	    <div class="clearfix postText">
		<p><?php
		    the_content();
		    circleflip_link_pages();
		    ?></p>
	    </div>
	    <div class="sidebarSeparatorPost"></div>
        <?php if ( cr_get_option( 'post_social', '' ) == 1 ) { ?>
        <div class="clearfix likesShareContainer">
            <!-- Share post  -->
    		<div class="socialShare noLike">
    		    <h3><?php _e( 'SHARE', 'circleflip' ); ?></h3>
    		    <ul>
    			<li>
					<a class="twitter popup" href="<?php echo esc_url( 'http://twitter.com/share?text=' . get_the_title() . '&url=' . get_the_permalink() ); ?>" title="Share on Twitter"></a>
    			</li>
    			<li>
				<?php
				$image_id = get_post_thumbnail_id( $post->ID );
				$image_attributes = wp_get_attachment_image_src( $image_id );
				?>
					<a class="popup pinterest" href="<?php echo esc_url( 'http://pinterest.com/pin/create/button/?url=' . get_the_permalink() . '&amp;media=' . $image_attributes[0] ); ?>" title="Share on Pinterest"></a>
    			</li>
    			<li>
    			    <script src="http://platform.tumblr.com/v1/share.js"></script>
    			    <a class="popup tumblr" href="http://www.tumblr.com/share/link?url=<?php echo urlencode( get_permalink() ) ?>&name=<?php echo urlencode( get_the_title() ) ?>" title="Share on Tumblr"></a>
    			</li>
    			<li>
    			    <a class="popup stumbleUpon" href="http://www.stumbleupon.com/submit?url=<?php the_permalink(); ?>&title=<?php the_title(); ?>" target="_blank" title="Share on StumbleUpon"></a>
    			</li>
    			<li>
    			    <div class="googleplus">
    				<div class="googlehider">
    				    <script src="http://platform.linkedin.com/in.js" type="text/javascript"></script><script type="IN/Share" data-url="<?php the_permalink(); ?>" data-counter="right"></script>
    				</div>
    				<span class="linkedIn"></span>
    			    </div>
    			</li>
    			<li>
    			    <a class="popup facebook" href="http://www.facebook.com/sharer.php?&amp;p[url]=<?php the_permalink(); ?>&amp;p[title]=<?php the_title(); ?>&amp;p[images][0]=<?php echo isset( $image_attributes[0] ) && ! empty( $image_attributes[0] ) ? $image_attributes[0] : ''; ?>" title="Share on Facebook"></a>
    			</li>
    			<li>
    			    <div class="googleplus">
    				<div class="googlehider">
    				    <a href="https://plus.google.com/share?url=<?php the_permalink(); ?>" onclick="javascript:window.open( this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600' );
    					    return false;" target="_blank"></a>
    				</div>
    				<span class="googlePlusBtn"></span>
    			    </div>
    			</li>
    		    </ul>
    		</div>
        </div>
        <div class="sidebarSeparatorPost"></div>
        <?php } ?>
	    <!-- Related Posts  -->
	    <?php if ( cr_get_option( 'post_related', '' ) == 1 ) { ?>
    	    <div class="relatedContainer clearfix">
		    <?php
		    add_filter( 'circleflip_post_format_gallery_html', 'circleflip_gallery_portfolioformat', 10, 5 );
		    add_filter( 'circleflip_post_format_standard_html', 'circleflip_standard_portfolioformat', 10, 5 );
		    add_filter( 'circleflip_post_format_video_html', 'circleflip_video_portfolioformat', 10, 5 );
		    add_filter( 'circleflip_post_format_audio_html', 'circleflip_audio_portfolioformat', 10, 5 );
		    add_filter( 'circleflip_post_format_media_size', 'circleflip_full_video_size', 10, 5 );
		    add_filter( 'circleflip_post_format_meta', 'circleflip_gallery_layout', 10, 5 );
		    
		    global $post;
		    $tmp_post = $post;
		    $categories = get_the_category( $post->ID );
		    $category_ids = array();
		    foreach ( $categories as $category ) {
			array_push( $category_ids, $category->term_id );
			$post_category = $category->slug;
		    }
		    $categories_imploded = implode( ', ', $category_ids );
		    if ( cr_get_option( 'post_related_query', '' ) == 'category' ) {
			$args = array(
			    'category__in'	 => $categories_imploded,
			    'showposts'	 => cr_get_option( 'post_related_number_of_posts', '' ),
			    'exclude'	 => get_the_ID(),
			    'order'		 => 'DESC' );
		    } elseif ( cr_get_option( 'post_related_query', '' ) == 'author' ) {
			$args = array(
			    'author'	 => $author_id,
			    'showposts'	 => cr_get_option( 'post_related_number_of_posts', '' ),
			    'exclude'	 => get_the_ID(),
			    'order'		 => 'DESC' );
		    } else {
			$args = array(
			    'category__in'	 => $categories_imploded,
			    'showposts'	 => cr_get_option( 'post_related_number_of_posts', '' ),
			    'exclude'	 => get_the_ID(),
			    'order'		 => 'DESC' );
		    }
		    $relatedPosts = get_posts( $args );
		    if ( count( $relatedPosts ) ):
			?>
			<div class="row-fluid">
			    <h3 class="normal span12" style="margin-bottom:19px;color:">
				<div class="headerDot"><span class="icon-right-open-mini"></span></div>
				<?php esc_html_e( 'Related Posts', 'circleflip' ); ?>
			    </h3>
			</div>
			<div class="row-fluid">
			    <?php $relatedCount = 0; ?>
			    <?php foreach ( $relatedPosts as $post ) : ?>
				<?php
				$src = '';
				$image_recent = '';
				if ( has_post_thumbnail( $post->ID ) ) {
				    $image_id = get_post_thumbnail_id( $post->ID );
				    $image_recent = wp_get_attachment_image_src( $image_id, 'recent_home_posts' );
				}
				$relatedCount ++;
				$relatedNumber = 0;
				if ( $sidebar_exist == 'span4' ) {
				    $relatedNumber = 2;
				} else if ( $sidebar_exist == 'span3' ) {
				    $relatedNumber = 3;
				}
				?>
	    		    <div class="<?php echo esc_attr($sidebar_exist); ?> <?php
				if ( $relatedCount == 1 ) {
				    echo 'portfolioHomeMargin';
				}
				?> portfolioHome">
	    			<div class="portfolioHomeImg">
					<?php if ( circleflip_valid( $image_recent ) ) { ?>
					    <?php echo wp_get_attachment_image( $image_id, 'recent_home_posts' ) ?>
					<?php } else { ?>
					    <?php echo circleflip_get_default_image( 'recent_home_posts' ) ?>
					    <?php
					}
					echo circleflip_get_post_format_media( $post->ID, 'recent_home_posts', 'my_unique_portfolio_posts' );
					?>
	    			</div>
	    		    </div>
				<?php
				if ( $relatedCount > $relatedNumber ) {
				    $relatedCount = 0;
				}
				?>
			    <?php endforeach; ?>
			</div>
			<?php
		    endif;
		    $post = $tmp_post;
		    ?>
    	    </div>
        <div class="sidebarSeparatorPost"></div>
	    <?php } ?>
	    <?php if ( cr_get_option( 'post_author' ) == '1' ) { ?>
		<?php if ( get_the_author_meta( 'description' ) != '' ) { ?>
		    <div class="authorDetails">
			<div class="authorImg"><?php echo get_avatar( get_the_author_meta( 'ID' ) ); ?></div>
			<div class="authorContent">
			    <h4><?php _e( 'This Post is posted by', 'circleflip' ); ?> <?php echo get_the_author(); ?></h4>
			    <p><?php the_author_meta( 'description' ); ?></p>
			</div>
		    </div>
		    <div class="sidebarSeparatorPost"></div>
		<?php } ?>
	    <?php } ?>
	    <?php
	    circleflip_get_number_of_views( $post->ID );
	    add_action( 'tha_content_after', create_function( '', 'echo "</div></div>";' ) );
?>