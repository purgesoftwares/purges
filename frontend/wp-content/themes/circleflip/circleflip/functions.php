<?php
/** functions.php
 *
 * @author		Creiden
 * @package		Circleflip
 * @since		1.0.0 - 05.02.2012
 */
if ( class_exists( 'WooCommerce' ) ) {
	require_once get_template_directory() . '/inc/wc-functions.php';
}
if ( ! function_exists( 'circleflip_after_setup_theme' ) ):

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * @author	WordPress.org
	 * @since	1.0.0 - 05.02.2012
	 *
	 * @return	void
	 */
	function circleflip_after_setup_theme() {
		global $content_width;

		if ( ! isset( $content_width ) ) {
			$content_width = 1170;
		}
		define( 'images', get_template_directory_uri() . '/img' );
		load_theme_textdomain( 'circleflip', get_template_directory() . '/lang' );

		add_theme_support( 'automatic-feed-links' );
		
		add_theme_support( "title-tag" );

		add_theme_support( 'post-thumbnails' );

		add_theme_support( 'post-formats', array(
			'gallery',
			'audio',
			'video'
		) );

		add_theme_support( 'tha_hooks', array( 'all' ) );

		add_editor_style();
		/**
		 * Custom template tags for this theme.
		 */
		require_once get_template_directory() . '/inc/template-tags.php' ;

		/**
		 * Implement the Custom Header feature
		 */
		require_once get_template_directory() . '/inc/custom-header.php' ;


		/**
		 * Implement the Header Builder feature
		 */
		require_once get_template_directory() . '/creiden-framework/header-builder/header-builder.php';
		require_once get_template_directory() . '/creiden-framework/header-builder/header-config.php';

		/**
		 * Custom Nav Menu handler for the Navbar.
		 */
		require_once get_template_directory() . '/inc/nav-menu-walker.php';

		/**
		 * Creiden Framework.
		 */
		require_once get_template_directory() . '/inc/creiden-framework.php';
		/**
		 * Creiden Custom Filters.
		 */
		require_once get_template_directory() . '/inc/circle-flip-filters.php';
		/**
		 * Creiden Custom Actions.
		 */
		require_once get_template_directory() . '/inc/circle-flip-actions.php';
		/**
		 * Creiden Ajax.
		 */
		require_once get_template_directory() . '/inc/circle-flip-ajax.php';
		/**
		 * Creiden Custom functions.
		 */
		require_once get_template_directory() . '/inc/cr-custom-functions.php';
		require_once get_template_directory() . '/inc/circleflip-blog-functions.php';
		require_once get_template_directory() . '/inc/circleflip-post-formats-metabox.php';
		require_once get_template_directory() . '/inc/circleflip-gif-support.php';
		require_once get_template_directory() . '/inc/circleflip-media.php';
//		require_once get_template_directory() . '/inc/circleflip-sidebar-functions.php';
		require_once get_template_directory() . '/inc/circleflip-headerBuilder.php';
		if ( ! cr_get_option( 'header_builder' ) ) {
			require_once get_template_directory() . '/inc/circleflip-multimenu.php';
		}

		require_once get_template_directory() . '/inc/importer/circleflip-importer.php';
		/**
		 * Short Code
		 */
		require_once get_template_directory() . '/shortcode.php';
		/**
		 * Thumbnails Generator
		 */
//	require_once get_template_directory() . '/inc/wp-image.php';
		require_once get_template_directory() . '/inc/WP-Make-Missing-Sizes.php';
		/**
		 * Theme Hook Alliance
		 */
		require_if_theme_supports( 'tha_hooks', get_template_directory() . '/inc/tha-theme-hooks.php' );

		/**
		 * Including three menu (header-menu, primary and footer-menu).
		 * Primary is wrapping in a navbar containing div (wich support responsive variation)
		 * Header-menu and Footer-menu are inside pills dropdown menu
		 *
		 * @since	1.2.2 - 07.04.2012
		 * @see		http://codex.wordpress.org/Function_Reference/register_nav_menus
		 */
		register_nav_menus( array(
			'primary'		 => __( 'Main Navigation', 'circleflip' ),
			'header-menu'	 => __( 'Header Menu', 'circleflip' ),
			'footer-menu'	 => __( 'Footer Menu', 'circleflip' )
		) );
		/**
		 * Creiden Custom Widgets
		 */
		require_once get_template_directory() . '/widgets/text_image_widget.php';
		require_once get_template_directory() . '/widgets/contact_information.php';
		require_once get_template_directory() . '/widgets/flickr_widget.php';
		require_once get_template_directory() . '/widgets/images_widget.php';
		require_once get_template_directory() . '/widgets/categories_with_count.php';
		require_once get_template_directory() . '/widgets/Testimonials_Widget.php';
		require_once get_template_directory() . '/widgets/recent_post_thumbnails_widget.php';
		require_once get_template_directory() . '/widgets/recent_post_widget.php';
		require_once get_template_directory() . '/widgets/top_post_views_widget.php';
		require_once get_template_directory() . '/widgets/shortcode_widget.php';
		require_once get_template_directory() . '/widgets/class-circleflip-widget-google-maps.php';

		/*
		 * Creiden Sidebars
		 */
		require_once get_template_directory() . '/creiden-framework/metabox/sidebars.php';
		$args = apply_filters( 'circleflip_custom_background_args', array(
			'default-color' => 'EFEFEF',
				) );

		add_theme_support( "custom-background", $args );
	}

// circleflip_after_setup_theme

endif;

add_action( 'after_setup_theme', 'circleflip_after_setup_theme' );

/**
 * Register the sidebars.
 *
 * @author	Creiden
 * @since	1.0.0 - 05.02.2012
 *
 * @return	void
 */
function circleflip_widgets_init() {

	register_sidebar( array(
		'name'			 => __( 'Main Sidebar', 'circleflip' ),
		'id'			 => 'main',
		'before_widget'	 => '<li id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</li>',
		'before_title'	 => '<h3 class="widgetTitle">',
		'after_title'	 => '</h3>',
	) );

	register_sidebar( array(
		'name'			 => __( 'Image Sidebar', 'circleflip' ),
		'description'	 => __( 'Shown on image attachment pages.', 'the-bootstrap' ),
		'id'			 => 'image',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</aside>',
		'before_title'	 => '<h3 class="widgetTitle">',
		'after_title'	 => '</h3>',
	) );

	register_sidebar( array(
		'name'			 => __( 'Shop', 'circleflip' ),
		'description'	 => __( 'Shown on shop.', 'circleflip' ),
		'id'			 => 'shop',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</aside>',
		'before_title'	 => '<h3 class="widgetTitle">',
		'after_title'	 => '</h3>',
	) );


	register_sidebar( array(
		'name'			 => 'Footer Widget Area',
		'id'			 => 'sidebar-footerwidgetarea',
		'class'			 => '',
		'before_widget'	 => '<li id="%1$s" class="widget %2$s grid4 span' . circleflip_calculate_widget_width() . '">',
		'after_widget'	 => '</li>',
		'before_title'	 => '<h3 class="widgetTitle grid1">',
		'after_title'	 => '</h3>'
	) );

	$custom_sidebars = cr_get_option( 'sidebars', array() );

	if ( ! empty( $custom_sidebars ) ) {
		foreach ( $custom_sidebars as $sidebar ) {
			register_sidebar( array(
				'name'			 => $sidebar,
				'id'			 => 'sidebar-' . strtolower( str_replace( " ", '', $sidebar ) ),
				'class'			 => '',
				'before_widget'	 => '<li id="%1$s" class="widget %2$s">',
				'after_widget'	 => '</li>',
				'before_title'	 => '<h3 class="widgetTitle grid1">',
				'after_title'	 => '</h3>'
			) );
		}
	}
}

add_action( 'widgets_init', 'circleflip_widgets_init' );

/*
 * Calculate the width of the widget
 */

function circleflip_calculate_widget_width() {

	$the_sidebars = wp_get_sidebars_widgets();
	if(isset($the_sidebars) && !empty($the_sidebars) && isset($the_sidebars['sidebar-footerwidgetarea']) && !empty($the_sidebars['sidebar-footerwidgetarea'])) {
		$footer_widgets_count = count( $the_sidebars['sidebar-footerwidgetarea'] );
		if ( $footer_widgets_count > cr_get_option( 'max_number_widgets', 4 ) ) {
			$footer_widgets_count = cr_get_option( 'max_number_widgets', 4 );
		} else if ( $footer_widgets_count == 0 ) {
			$footer_widgets_count = 1;
		}
		return 12 / $footer_widgets_count;
	}
}

/**
 * Properly enqueue comment-reply script
 *
 * @author	creiden
 * @since	1.0.0 - 06.23.2013
 *
 * @return	void
 */
function circleflip_comment_form_before() {
	if ( get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'comment_form_before', 'circleflip_comment_form_before' );


/**
 * Returns a "Continue Reading" link for excerpts
 *
 * @author	WordPress.org
 * @since	1.0.0 - 05.02.2012
 *
 * @param	string	$more
 *
 * @return	string
 */
function circleflip_continue_reading_link() {
	return ' <a href="' . esc_url( get_permalink() ) . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'circleflip' ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and creiden_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 *
 * @author	WordPress.org
 * @since	1.0.0 - 05.02.2012
 *
 * @param	string	$more
 *
 * @return	string
 */
function circleflip_excerpt_more( $more ) {
	return '&hellip;' . circleflip_continue_reading_link();
}

add_filter( 'excerpt_more', 'circleflip_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 *
 * @author	WordPress.org
 * @since	1.0.0 - 05.02.2012
 *
 * @param	string	$output
 *
 * @return	string
 */
function circleflip_custom_excerpt_more( $output ) {
	if ( has_excerpt() AND ! is_attachment() ) {
		$output .= circleflip_continue_reading_link();
	}
	return $output;
}

add_filter( 'get_the_excerpt', 'circleflip_custom_excerpt_more' );

/**
 * Get the wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @author	WordPress.org
 * @since	1.0.0 - 05.02.2012
 *
 * @param	array	$args
 *
 * @return	array
 */
function circleflip_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}

add_filter( 'wp_page_menu_args', 'circleflip_page_menu_args' );

/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 *
 * @author	Automattic
 * @since	1.0.0 - 05.02.2012
 *
 * @param	string	$url
 * @param	int		$id
 *
 * @return	string
 */
function circleflip_enhanced_image_navigation( $url, $id ) {

	if ( is_attachment() AND wp_attachment_is_image( $id ) ) {
		$image = get_post( $id );
		if ( $image->post_parent AND $image->post_parent != $id )
			$url .= '#primary';
	}

	return $url;
}

add_filter( 'attachment_link', 'circleflip_enhanced_image_navigation', 10, 2 );

/**
 * Displays comment list, when there are any
 *
 * @author	Creiden
 * @since	1.7.0 - 16.06.2012
 *
 * @return	void
 */
function circleflip_comments_list() {
	if ( post_password_required() ) :
		?>
		<div id="comments">
			<p class="nopassword"><?php esc_html_e( 'This post is password protected. Enter the password to view any comments.', 'circleflip' ); ?></p>
		</div><!-- #comments -->
		<?php
		return;
	endif;


	if ( have_comments() ) :
		?>
		<div id="comments">
			<?php circleflip_comment_nav(); ?>

			<ol class="commentsWrapper">
				<?php wp_list_comments( array( 'callback' => 'circleflip_comment' ) ); ?>
			</ol><!-- .commentlist .unstyled -->
			<div class="sidebarSeparatorPost" id="commentReplay"></div>
			<?php circleflip_comment_nav(); ?>

		</div><!-- #comments -->
		<?php
	endif;
}

add_action( 'tha_comments_before', 'circleflip_comments_list', 0 );

/**
 * Echoes comments-are-closed message when post type supports comments and we're
 * not on a page
 *
 * @author	Creiden
 * @since	1.7.0 - 16.06.2012
 *
 * @return	void
 */
function circleflip_comments_closed() {
	if ( ! is_page() AND post_type_supports( get_post_type(), 'comments' ) ) :
		?>
		<p class="nocomments"><?php esc_html_e( 'Comments are closed.', 'circleflip' ); ?></p>
		<?php
	endif;
}

add_action( 'comment_form_comments_closed', 'circleflip_comments_closed' );

/**
 * Filters comments_form() default arguments
 *
 * @author	Creiden
 * @since	1.7.0 - 16.06.2012
 *
 * @param	array	$defaults
 *
 * @return	array
 */
function circleflip_comment_form_defaults( $defaults ) {
	return wp_parse_args( array(
		'comment_field'			 => '<div class="comment-form-comment control-group"><div class="controls"><textarea class="span7" id="comment" name="comment" rows="8" aria-required="true" placeholder="' . esc_attr_x( 'Body*', 'noun', 'circleflip' ) . '"></textarea></div></div>',
		'comment_notes_before'	 => '',
		'comment_notes_after'	 => ''/* '<div class="form-allowed-tags control-group"><label class="control-label">' . sprintf( __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s', 'circleflip' ), '</label><div class="controls"><pre>' . allowed_tags() . '</pre></div>' ) . '</div>
		  <div class="form-actions">' */,
		'title_reply'			 => '<legend>' . __( 'Leave a reply', 'circleflip' ) . '</legend>',
		'title_reply_to'		 => '<legend>' . __( 'Leave a reply to %s', 'circleflip' ) . '</legend>',
		'must_log_in'			 => '<div class="must-log-in control-group controls">' . sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'circleflip' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( get_the_ID() ) ) ) ) . '</div>',
		'logged_in_as'			 => '<div class="logged-in-as control-group controls">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'circleflip' ), admin_url( 'profile.php' ), wp_get_current_user()->display_name, wp_logout_url( apply_filters( 'the_permalink', get_permalink( get_the_ID() ) ) ) ) . '</div>',
			), $defaults );
}

add_filter( 'comment_form_defaults', 'circleflip_comment_form_defaults' );


if ( ! function_exists( 'circleflip_comment' ) ) :

	/**
	 * Template for comments and pingbacks.
	 *
	 * To override this walker in a child theme without modifying the comments template
	 * simply create your own circleflip_comment(), and that function will be used instead.
	 *
	 * Used as a callback by wp_list_comments() for displaying the comments.
	 *
	 * @author	Creiden
	 * @since	1.0.0 - 05.02.2012
	 *
	 * @param	object	$comment	Comment data object.
	 * @param	array	$args
	 * @param	int		$depth		Depth of comment in reference to parents.
	 *
	 * @return	void
	 */
	function circleflip_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		if ( 'pingback' == $comment->comment_type OR 'trackback' == $comment->comment_type ) :
			?>

			<li id="li-comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
				<p class="row">
					<strong class="ping-label span1"><?php _e( 'Pingback:', 'circleflip' ); ?></strong>
					<span class="span7"><?php
						comment_author_link();
						edit_comment_link( __( 'Edit', 'circleflip' ), '<span class="sep">&nbsp;</span><span class="edit-link label">', '</span>' );
						?></span>
				</p>

				<?php
			else:
				$offset = $depth - 1;
				$span = 7 - $offset;
				if ( cr_get_option( 'style_posts', '' ) == 'singlestyle1' ) {
					$span = 6 - $offset;
				}
				?>
			<li  id="li-comment-<?php comment_ID(); ?>" class="clearfix">
				<article id="comment-<?php comment_ID(); ?>" class="comment clearfix">
					<?php if ( ! $comment->comment_approved ) : ?>
						<div class="comment-awaiting-moderation clearfix alert alert-info"><em><?php esc_html_e( 'Your comment is awaiting moderation.', 'circleflip' ); ?></em></div>
					<?php endif; ?>
					<div class="comment-author-avatar">
						<?php echo get_avatar( $comment, 70 ); ?>
					</div>
					<div class="commentContainer">
						<div class="comment-meta clearfix">
							<p class="comment-author"><?php printf( __( '%1$s ', 'circleflip' ), sprintf( '<span class="fn">%s</span>', get_comment_author_link() ) ) ?></p>
							<p class="comment-date vcard">
								<?php
								/* translators: 1: comment author, 2: date and time */
								printf( __( '%1$s', 'circleflip' ), sprintf( '<span class="on">on </span><a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>', esc_url( get_comment_link( $comment->comment_ID ) ), get_comment_time( 'c' ),
												/* translators: 1: date, 2: time */ sprintf( __( '%1$s at %2$s', 'circleflip' ), get_comment_date(), get_comment_time() )
										)
								);
								edit_comment_link( __( 'Edit', 'circleflip' ), '<span class="sep">&nbsp;</span><span class="edit-link label">', '</span>' );
								?>
							</p><!-- .comment-author .vcard -->
						</div><!-- .comment-meta -->

						<div class="comment-content clearfix">
							<?php
							comment_text();
							comment_reply_link( array_merge( $args, array(
								'reply_text' => __( 'Reply', 'circleflip' ),
								'depth'		 => $depth,
								'max_depth'	 => $args['max_depth']
							) ) );
							?>
						</div><!-- .comment-content -->
					</div>
				</article>

			<?php
			endif; // comment_type
		}

	endif; // ends check for circleflip_comment()

	/**
	 * Adds markup to the comment form which is needed to make it work with Bootstrap
	 * needs
	 *
	 * @author	Creiden
	 * @since	1.0.0 - 05.02.2012
	 *
	 * @param	string	$html
	 *
	 * @return	string
	 */
	function circleflip_comment_form_top() {
		echo '<div class="form-horizontal">';
	}

	add_action( 'comment_form_top', 'circleflip_comment_form_top' );

	/**
	 * Adds markup to the comment form which is needed to make it work with Bootstrap
	 * needs
	 *
	 * @author	Creiden
	 * @since	1.0.0 - 05.02.2012
	 *
	 * @param	string	$html
	 *
	 * @return	string
	 */
	function circleflip_comment_form() {
		echo '</div>';
	}

	add_action( 'comment_form', 'circleflip_comment_form' );

	/**
	 * Custom author form field for the comments form
	 *
	 * @author	Creiden
	 * @since	1.0.0 - 05.02.2012
	 *
	 * @param	string	$html
	 *
	 * @return	string
	 */
	function circleflip_comment_form_field_author( $html ) {
		$commenter = wp_get_current_commenter();
		$req = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );

		return '<div class="comment-form-author control-group">
				<div class="controls">
					<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' placeholder="' . esc_html__( 'Name*', 'circleflip' ) . '"/>

				</div>
			</div>';
	}

	add_filter( 'comment_form_field_author', 'circleflip_comment_form_field_author' );

	/**
	 * Custom HTML5 email form field for the comments form
	 *
	 * @author	Creiden
	 * @since	1.0.0 - 05.02.2012
	 *
	 * @param	string	$html
	 *
	 * @return	string
	 */
	function circleflip_comment_form_field_email( $html ) {
		$commenter = wp_get_current_commenter();
		$req = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );

		return '<div class="comment-form-email control-group">
				<div class="controls">
					<input id="email" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' placeholder="' . esc_html__( 'Email*', 'circleflip' ) . '" />
				</div>
			</div>';
	}

	add_filter( 'comment_form_field_email', 'circleflip_comment_form_field_email' );

	/**
	 * Custom HTML5 url form field for the comments form
	 *
	 * @author	Creiden
	 * @since	1.0.0 - 05.02.2012
	 *
	 * @param	string	$html
	 *
	 * @return	string
	 */
	function circleflip_comment_form_field_url( $html ) {
		$commenter = wp_get_current_commenter();

		return '<div class="comment-form-url control-group">
				<div class="controls">
					<input id="url" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30"  placeholder="' . esc_html__( 'Website', 'circleflip' ) . '"/>
				</div>
			</div>';
	}

	add_filter( 'comment_form_field_url', 'circleflip_comment_form_field_url' );

	/**
	 * Adjusts an attechment link to hold the class of 'thumbnail' and make it look
	 * pretty
	 *
	 * @author	Creiden
	 * @since	1.0.0 - 05.02.2012
	 *
	 * @param	string	$link
	 * @param	int		$id			Post ID.
	 * @param	string	$size		Default is 'thumbnail'. Size of image, either array or string.
	 * @param	bool	$permalink	Default is false. Whether to add permalink to image.
	 * @param	bool	$icon		Default is false. Whether to include icon.
	 * @param	string	$text		Default is false. If string, then will be link text.
	 *
	 * @return	string
	 */
	function circleflip_get_attachment_link( $link, $id, $size, $permalink, $icon, $text ) {
		return ( ! $text ) ? str_replace( '<a ', '<a class="thumbnail" ', $link ) : $link;
	}

	add_filter( 'wp_get_attachment_link', 'circleflip_get_attachment_link', 10, 6 );

	/**
	 * Adds the 'hero-unit' class for extra big font on sticky posts
	 *
	 * @author	Creiden
	 * @since	1.0.0 - 05.02.2012
	 *
	 * @param	array	$classes
	 *
	 * @return	array
	 */
	function circleflip_post_classes( $classes ) {

		if ( is_sticky() AND is_home() ) {
			$classes[] = 'hero-unit';
		}

		return $classes;
	}

	add_filter( 'post_class', 'circleflip_post_classes' );

	/**
	 * Callback function to display galleries (in HTML5)
	 *
	 * @author	Creiden
	 * @since	1.0.0 - 05.02.2012
	 *
	 * @param	string	$content
	 * @param	array	$attr
	 *
	 * @return	string
	 */
	function circleflip_post_gallery( $content, $attr ) {
		global $instance, $post;
		$instance ++;

		// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
		if ( isset( $attr['orderby'] ) ) {
			$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
			if ( ! $attr['orderby'] )
				unset( $attr['orderby'] );
		}

		extract( shortcode_atts( array(
			'order'		 => 'ASC',
			'orderby'	 => 'menu_order ID',
			'id'		 => $post->ID,
			'itemtag'	 => 'figure',
			'icontag'	 => 'div',
			'captiontag' => 'figcaption',
			'columns'	 => 3,
			'size'		 => 'thumbnail',
			'include'	 => '',
			'exclude'	 => ''
						), $attr ) );


		$id = intval( $id );
		if ( 'RAND' == $order )
			$orderby = 'none';

		if ( $include ) {
			$include = preg_replace( '/[^0-9,]+/', '', $include );
			$_attachments = get_posts( array(
				'include'		 => $include,
				'post_status'	 => 'inherit',
				'post_type'		 => 'attachment',
				'post_mime_type' => 'image',
				'order'			 => $order,
				'orderby'		 => $orderby
					) );

			$attachments = array();
			foreach ( $_attachments as $key => $val ) {
				$attachments[$val->ID] = $_attachments[$key];
			}
		} elseif ( $exclude ) {
			$exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
			$attachments = get_children( array(
				'post_parent'	 => $id,
				'exclude'		 => $exclude,
				'post_status'	 => 'inherit',
				'post_type'		 => 'attachment',
				'post_mime_type' => 'image',
				'order'			 => $order,
				'orderby'		 => $orderby
					) );
		} else {
			$attachments = get_children( array(
				'post_parent'	 => $id,
				'post_status'	 => 'inherit',
				'post_type'		 => 'attachment',
				'post_mime_type' => 'image',
				'order'			 => $order,
				'orderby'		 => $orderby
					) );
		}

		if ( empty( $attachments ) )
			return;

		if ( is_feed() ) {
			$output = "\n";
			foreach ( $attachments as $att_id => $attachment )
				$output .= wp_get_attachment_link( $att_id, $size, true ) . "\n";
			return $output;
		}



		$itemtag = tag_escape( $itemtag );
		$captiontag = tag_escape( $captiontag );
		$columns = intval( min( array( 8, $columns ) ) );
		$float = (is_rtl()) ? 'right' : 'left';

		if ( 4 > $columns )
			$size = 'full';

		$selector = "gallery-{$instance}";
		$size_class = sanitize_html_class( $size );
		$output = "<ul id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class} thumbnails'>";

		$i = 0;
		foreach ( $attachments as $id => $attachment ) {
			$comments = get_comments( array(
				'post_id'	 => $id,
				'count'		 => true,
				'type'		 => 'comment',
				'status'	 => 'approve'
					) );

			$link = wp_get_attachment_link( $id, $size,  ! ( isset( $attr['link'] ) AND 'file' == $attr['link'] ) );
			$clear_class = ( 0 == $i ++ % $columns ) ? ' clear' : '';
			$span = 'span' . floor( 8 / $columns );

			$output .= "<li class='{$span}{$clear_class}'><{$itemtag} class='gallery-item'>";
			$output .= "<{$icontag} class='gallery-icon'>{$link}</{$icontag}>\n";

			if ( $captiontag AND ( 0 < $comments OR trim( $attachment->post_excerpt ) ) ) {
				$comments = ( 0 < $comments ) ? sprintf( _n( '%d comment', '%d comments', $comments, 'circleflip' ), $comments ) : '';
				$excerpt = wptexturize( $attachment->post_excerpt );
				$out = ($comments AND $excerpt) ? " $excerpt <br /> $comments " : " $excerpt$comments ";
				$output .= "<{$captiontag} class='wp-caption-text gallery-caption'>{$out}</{$captiontag}>\n";
			}
			$output .= "</{$itemtag}></li>\n";
		}
		$output .= "</ul>\n";

		return $output;
	}

	add_filter( 'post_gallery', 'circleflip_post_gallery', 10, 2 );

	/**
	 * HTML 5 caption for pictures
	 *
	 * @author	Creiden
	 * @since	1.0.0 - 05.02.2012
	 *
	 * @param	string	$empty
	 * @param	array	$attr
	 * @param	string	$content
	 *
	 * @return	string
	 */
	function circleflip_img_caption_shortcode( $empty, $attr, $content ) {

		extract( shortcode_atts( array(
			'id'		 => '',
			'align'		 => 'alignnone',
			'width'		 => '',
			'caption'	 => ''
						), $attr ) );

		if ( 1 > ( int ) $width OR empty( $caption ) ) {
			return $content;
		}

		if ( $id ) {
			$id = 'id="' . esc_attr( $id ) . '" ';
		}

		return '<figure ' . $id . 'class="wp-caption thumbnail ' . esc_attr( $align ) . '" style="width: ' . absint( $width ) . 'px;">
				' . do_shortcode( str_replace( 'class="thumbnail', 'class="', $content ) ) . '
				<figcaption class="wp-caption-text">' . esc_html( $caption ) . '</figcaption>
			</figure>';
	}

	add_filter( 'img_caption_shortcode', 'circleflip_img_caption_shortcode', 10, 3 );

	/**
	 * Returns a password form which dispalys nicely with Bootstrap
	 *
	 * @author	Creiden
	 * @since	1.0.0 - 05.02.2012
	 *
	 * @param	string	$form
	 *
	 * @return	string	Circleflip password form
	 */
	function circleflip_the_password_form( $form ) {
		return '<form class="post-password-form form-horizontal" action="' . home_url( 'wp-pass.php' ) . '" method="post"><legend>' . esc_html__( 'This post is password protected. To view it please enter your password below:', 'circleflip' ) . '</legend><div class="control-group"><label class="control-label" for="post-password-' . get_the_ID() . '">' . esc_html__( 'Password:', 'circleflip' ) . '</label><div class="controls"><input name="post_password" id="post-password-' . get_the_ID() . '" type="password" size="20" /></div></div><div class="form-actions"><button type="submit" class="post-password-submit submit">' . esc_html__( 'Submit', 'circleflip' ) . '</button></div></form>';
	}

	add_filter( 'the_password_form', 'circleflip_the_password_form' );

	/**
	 * Modifies the category dropdown args for widgets on 404 pages
	 *
	 * @author	Creiden
	 * @since	1.5.0 - 19.05.2012
	 *
	 * @param	array	$args
	 *
	 * @return	array
	 */
	function circleflip_widget_categories_dropdown_args( $args ) {
		if ( is_404() ) {
			$args = wp_parse_args( $args, array(
				'orderby'	 => 'count',
				'order'		 => 'DESC',
				'show_count' => 1,
				'title_li'	 => '',
				'number'	 => 10
					) );
		}
		return $args;
	}

	add_filter( 'widget_categories_dropdown_args', 'circleflip_widget_categories_dropdown_args' );

	/**
	 * Adds the .thumbnail class when images are sent to editor
	 *
	 * @author	Creiden
	 * @since	2.0.0 - 29.08.2012
	 *
	 * @param	string	$html
	 * @param	int		$id
	 * @param	string	$caption
	 * @param	string	$title
	 * @param	string	$align
	 * @param	string	$url
	 * @param	string	$size
	 * @param	string	$alt
	 *
	 * @return	string	Image HTML
	 */
	function circleflip_image_send_to_editor( $html, $id, $caption, $title, $align, $url, $size, $alt ) {
		if ( $url ) {
			$html = str_replace( '<a ', '<a class="thumbnail" ', $html );
		} else {
			$html = str_replace( 'class="', 'class="thumbnail ', $html );
		}

		return $html;
	}

	add_filter( 'image_send_to_editor', 'circleflip_image_send_to_editor', 10, 8 );

	/**
	 * Adjusts content_width value for full-width and single image attachment
	 * templates, and when there are no active widgets in the sidebar.
	 *
	 * @author	WordPress.org
	 * @since	2.0.0 - 29.08.2012
	 *
	 * @return	void
	 */
	function circleflip_content_width() {
		if ( is_attachment() ) {
			global $content_width;
			$content_width = 940;
		}
	}

	add_action( 'template_redirect', 'circleflip_content_width' );

	/**
	 * Returns the Theme version string
	 *
	 * @author	Creiden
	 * @since	1.2.4 - 07.04.2012
	 * @access	private
	 *
	 * @return	string	Circleflip version
	 */
	function _circleflip_version() {
		$theme_version = '1.0.0';
		if ( function_exists( 'wp_get_theme' ) ) {
			$theme_version = wp_get_theme()->get( 'Version' );
		}
		return $theme_version;
	}

	/* ========================================================================================================================

	  Image resize Function

	  ======================================================================================================================== */

	/**
	 * Crops the images to the needed sizes
	 *
	 * @author	creiden
	 * @since	1.0.0 - 06.23.2013
	 * @access	private
	 * 	sample of usage -> add_image_size('slider-thumb', width, height, true);
	 */
	function circleflip_resize() {
		add_image_size( 'circle-posts', 370, 370, true );
		add_image_size( 'cf-recent-posts', 85, 75, true );
		add_image_size( 'cf-related-posts', 120, 120, true );
		add_image_size( 'cf-top-post', 220, 240, true );
		add_image_size( 'blog_posts_1_full', 1065, 400, true );
		add_image_size( 'blog_posts_2_full', 1170, 400, true );
		add_image_size( 'blog_posts_3_full', 155, 100, true );
		add_image_size( 'blog_posts_4_full', 1020, 400, true );
		add_image_size( 'icon_box_image', 240, 160, true );

		add_image_size( 'recent_home_posts', 270, 150, true );
		add_image_size( 'recent_home_posts_two', 367, 195, true );
		add_image_size( 'thumbnail2', 76, 76, true );
		add_image_size( 'thumbnailGallery', 70, 70, true );
		add_image_size( 'single_posts_full', 1065, 400 );

		add_image_size( 'masonry-post', 385, 9999 ); //300 pixels wide (and unlimited height)

		add_image_size( 'carousel_home_block', 170, 108, true );

		add_image_size( 'team_member', 270, 270, true );

		add_image_size( 'gallery_slider', 1170, 9999 ); // unlimited height
		//woocommerce

		add_image_size( 'cf-woocommerce-shop-thumb', 370, 270 );
		add_image_size( 'cf-woocommerce-single-thumb-small', 115, 115, true );
		add_image_size( 'cf-woocommerce-single-thumb2', 370 );

		//Magazine
		add_image_size( 'magazine_half', 570, 230, true );
	}

	add_action( 'init', 'circleflip_resize' );

	/* meta box for post */

	function circleflip_register_page_custom_mb() {
		$options = array(
			'id'			 => 'cf-custom-menu',
			'title'			 => 'Page Title Style',
			'callback'		 => 'circleflip_render_page_custom_mb',
			'context'		 => 'normal',
			'priority'		 => 'high',
			'screen'		 => 'page',
			'callback_args'	 => NULL
		);
		extract( $options );
		add_meta_box( $id, $title, $callback, $screen, $context, $priority, $callback_args );
	}

	add_action( 'add_meta_boxes', 'circleflip_register_page_custom_mb' );

	function circleflip_render_page_custom_mb( $post ) {
		echo '<input type="hidden" name="nonce-custom_menu" value="' . wp_create_nonce( "cf-custom-menu" ) . '" />';
		$args = array(
			'order'			 => 'ASC',
			'orderby'		 => 'menu_order',
			'post_type'		 => 'nav_menu_item',
			'post_status'	 => 'publish'
		);
		?>
		<p><label for="subtitle">Select Page Title Type</label></p>
		<?php
		$page_title_select = get_post_meta( $post->ID, 'page_title_select', TRUE );
		?>
		<select id="pageTitleShape" name="cf[page_title_select]">
			<option value="default_page_title" <?php selected( $page_title_select, 'default_page_title' ); ?>>Default Page Title</option>
			<option value="coloured_page_title" <?php selected( $page_title_select, 'coloured_page_title' ); ?>>Page Title with coloured background</option>
			<option value="image_page_title" <?php selected( $page_title_select, 'image_page_title' ); ?>>Page Title with image background</option>
			<option value="revolution_page_title" <?php selected( $page_title_select, 'revolution_page_title' ); ?>>Page Title with Revolution Slider</option>
			<option value="no_title" <?php selected( $page_title_select, 'no_title' ); ?>>No Title</option>
		</select>
		<div id="default_page_title" class="pageTitleType">

		</div>
		<div id="coloured_page_title" class="pageTitleType">
			<p><label for="pageTitle-color-field">Choose the color of the background</label></p>
			<!-- color -->
			<?php $color_field = get_post_meta( $post->ID, '_color_field', TRUE ); ?>
			<input type="text" id="pageTitle-color-field" class="pageTitle-color-field" value="<?php echo esc_attr( $color_field ); ?>" name="cf[_color_field]" data-default-color="#e32831"/>
			<p><label for="pageTitle-color-text-one">Choose the color of the text</label></p>
			<?php $color_field_text = get_post_meta( $post->ID, '_color_field_text', TRUE ); ?>
			<input type="text" id="pageTitle-color-text-one" class="pageTitle-color-field" value="<?php echo esc_attr( $color_field_text ); ?>" name="cf[_color_field_text]" data-default-color="#e32831"/>
		</div>
		<div id="image_page_title" class="pageTitleType">
			<!-- color & image-->
			<p><label for="pageTitle-color-text">Choose the color of the Text</label></p>
			<?php
			$color_text = get_post_meta( $post->ID, '_color_text', TRUE );
			$upload_image = get_post_meta( $post->ID, '_upload_image', TRUE );
			?>
			<input type="text" id="pageTitle-color-text" class="pageTitle-color-field" value="<?php echo esc_attr( $color_text ); ?>" name="cf[_color_text]" data-default-color="#e32831"/>
			<p><label for="upload_image">Upload the image</label></p>
			<input type="text" id="upload_image" class="input-full input-upload" value="<?php echo esc_attr( $upload_image ) ?>" name="cf[_upload_image]">
			<a href="#" class="aq_upload_button button" rel="image">Upload</a><p></p>
		</div>
		<div id="revolution_page_title" class="pageTitleType">
			<?php $revolution = get_post_meta( $post->ID, '_revolutionID', TRUE ); ?>
			<p><label for="revolutionID">Enter the shortcode for the revolution slider</label></p>
			<input type="text" id="revolutionID" name="cf[_revolutionID]" value="<?php echo esc_attr( $revolution ); ?>"/>
		</div>
		<script type="text/javascript">
			jQuery( document ).ready( function( $ ) {
				$( '.pageTitle-color-field' ).wpColorPicker();
				$( "#pageTitleShape" ).change( function() {
					$( '.pageTitleType' ).hide();
					$( '#' + $( this ).val() ).show();
				} )
				$( '#' + $( "#pageTitleShape" ).val() ).show();
			} )
		</script>
		<style>
			.pageTitleType {
				display: none;
			}
		</style>
		<?php
	}

	function circleflip_save_page_custom_mb( $post_id ) {
		if ( ( ! isset( $_POST['nonce-custom_menu'] ) || ! wp_verify_nonce( $_POST['nonce-custom_menu'], 'cf-custom-menu' )) || (defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE) || ('page' == $_POST['post_type'] && ! current_user_can( 'edit_page', $post_id ))
		)
			return $post_id;
		foreach ( $_POST['cf'] as $field => $value ) {
			$old = get_post_meta( $post_id, $field, true );
			$new = $value;
			if ( $new && $new != $old ) {
				update_post_meta( $post_id, $field, $new );
			} elseif ( '' == $new && $old ) {
				delete_post_meta( $post_id, $field, $old );
			}
		} // end foreach
		return $post_id;
	}

	add_action( 'save_post', 'circleflip_save_page_custom_mb' );

	/* ========================================================================================================================

	  Woo Commerce Edit

	  ======================================================================================================================== */

	/**
	 * Edit WooCommerce Template
	 *
	 * @author	creiden
	 * @since	1.0.0 - 06.23.2013
	 * @access	private
	 *
	 */
	// WooCommerce's Circle Flip Style
	function circleflip_enqueue_woocommerce_style() {
		wp_register_style( 'woocommerce', get_template_directory_uri() . '/css/parts/shop.css' );
		if ( class_exists( 'woocommerce' ) ) {
			wp_enqueue_style( 'woocommerce' );
		}
	}

	add_action( 'wp_enqueue_scripts', 'circleflip_enqueue_woocommerce_style' );
	/* ========================================================================================================================

	  Creting Posts Views count Table

	  ======================================================================================================================== */

	function circleflip_myactivationfunction( $oldname, $oldtheme = false ) {
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( "CREATE TABLE views_count (
			id int(11) NOT NULL AUTO_INCREMENT,
			post_id int(11) NOT NULL,
			visitor_ip int(16) UNSIGNED NOT NULL,
                        UNIQUE KEY id (id)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;" );
	}

	add_action( "init", "circleflip_myactivationfunction", 10, 2 );

	add_action( 'wp_enqueue_scripts', 'circleflip_get_google_fonts' );

	/* Enque Script of Google Fonts */

	function circleflip_get_google_fonts() {
		$link = '';
		$googleFonts = '';
		$my_fonts = array(
			'BebasNeueRegular'	 => 'BebasNeueRegular',
			'Times New Roman'	 => 'Times New Roman',
			'Arial'				 => 'Arial',
			'DroidArabicKufi'	 => 'DroidArabicKufi',
			'SourceSansSemiBold' => 'SourceSansSemiBold',
			'sourceSans'		 => 'sourceSans',
			'museo_slab500'		 => 'museo_slab500'
		);
		$cfOptions = get_option( 'rojo' );
		$faces = array();
		foreach ( new RecursiveIteratorIterator( new RecursiveArrayIterator( $cfOptions ), RecursiveIteratorIterator::LEAVES_ONLY ) as $k => $value ) {
			if ( 'face' === $k ) {
				if ( ! in_array( $value, $my_fonts ) ) {
					$faces[] = $value;
				}
			}
		}
        $faces = array_unique( $faces );
 	    $result = array_merge($faces, cr_get_option( 'cust_font',array() ));
	    $result = array_unique($result);
        $googleFonts = implode ( '|' , $result);
        if ( $googleFonts != '' ) {
            $link = 'https://fonts.googleapis.com/css?family=' . preg_replace( "/ /", "+", $googleFonts );
            wp_register_style( 'google_fonts', $link );
            wp_enqueue_style( 'google_fonts' );
        }
	}

	add_filter( 'bwp_minify_style_ignore', 'circleflip_exclude_my_css' );

	function circleflip_exclude_my_css( $excluded ) {
		$excluded = array( 'handle1', 'handle2' );
		return $excluded;
	}

	/* End of file functions.php */



	if ( ! function_exists( 'circleflip_register_admin_widget_scripts' ) ) {

		function circleflip_register_admin_widget_scripts( $hook ) {
			if ( 'widgets.php' === $hook ) {
				wp_register_script( 'bootstrap-3-modal', get_template_directory_uri() . '/creiden-framework/content-builder/assets/js/bootstrap.3.modal.js', array( 'jquery' ) );
				wp_register_script( 'crdn-stackable-modals', get_template_directory_uri() . '/creiden-framework/content-builder/assets/js/jquery.stackablemodal.js', array( 'jquery', 'bootstrap-3-modal' ), null, true );
				wp_enqueue_script( 'cf-widgets-admin', get_template_directory_uri() . '/js/widgets.admin.js', array( 'jquery', 'crdn-stackable-modals' ) );
				wp_enqueue_style( 'crdn-bootstrap-3-modal', get_template_directory_uri() . '/creiden-framework/content-builder/assets/css/bootstrap.3.modal.css' );
				wp_enqueue_style( 'fonts-admin', get_template_directory_uri() . "/css/fonts/fonts.css" );
			}
		}

		add_action( 'admin_enqueue_scripts', 'circleflip_register_admin_widget_scripts' );
	}

	if ( ! function_exists( 'circleflip_register_admin_builder_scripts' ) ) {

		function circleflip_register_admin_builder_scripts( $hook ) {
			if ( 'post-new.php' === $hook || 'post.php' === $hook ) {
				$theme_version = _circleflip_version();
				wp_register_style( 'circleflip-fonts', get_template_directory_uri() . "/css/fonts/fonts.css", array(), $theme_version );
				wp_enqueue_style( 'circleflip-fonts' );
			}
		}

		add_action( 'admin_enqueue_scripts', 'circleflip_register_admin_builder_scripts' );
	}

	function circleflip_register_themeoptions_icon_selector( $hook ) {
		if ( 'appearance_page_options-framework' === $hook ) {
			wp_enqueue_script( 'bootstrap-3-modal', get_template_directory_uri() . '/creiden-framework/content-builder/assets/js/bootstrap.3.modal.js', array( 'jquery' ) );
			wp_enqueue_style( 'crdn-bootstrap-3-modal', get_template_directory_uri() . '/creiden-framework/content-builder/assets/css/bootstrap.3.modal.css' );
			// wp_enqueue_style( 'fonts-admin', get_template_directory_uri() . "/css/fonts/fonts.css" );
		}
	}

	add_action( 'admin_enqueue_scripts', 'circleflip_register_themeoptions_icon_selector' );

	if ( ! function_exists( 'circleflip_print_icon_selector_modal' ) ) {

		function circleflip_print_icon_selector_modal() {
			?>
			<div class="modal fade" id="crdn-icon-selector-modal">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-body">
							<div class="icons-box">
								<?php $icons = circleflip_get_entypo_icons() ?>
								<?php foreach ( $icons as $icon ) : ?>
									<i class="iconfontello <?php echo esc_attr( $icon ) ?>" data-icon="<?php echo esc_attr( $icon ) ?>"></i>
								<?php endforeach; ?>
							</div>
							<div class="icon-preview">
								<i class="iconfontello"></i>
								<p class="icon-name"></p>
							</div>
						</div>
						<div class="modal-footer">
							<button class="crdn-icon-selector-done button-primary" type="button">Done</button>
							<button class="button-secondary"  type="button" data-dismiss="modal">Cancel</button>
						</div>
					</div>
				</div>
			</div>
			<style>
				.icons-box {
					width: 60%;
					font-size: 2em;
					line-height: 1.5em;
					overflow-y: scroll;
					height: 400px;
					float: left;
				}
				.icons-box .iconfontello.selectedIcon {
					color: rgb(247, 86, 86);
				}
				.icon-preview {
					width: 40%;
					margin: 0;
					text-align: center;
					float: left;
					padding-top: 30px;
				}
				.icon-preview .iconfontello {
					font-size: 14em;
				}
				.icon-name {
					font-size: 2em;
					font-family: monospace;
				}

				#crdn-icon-selector-modal .modal-body {
					overflow: hidden;
				}
			</style>
			<?php
		}

		add_action( 'sidebar_admin_page', 'circleflip_print_icon_selector_modal' );
		add_action( 'circleflip_optionsframework_after', 'circleflip_print_icon_selector_modal' );
	}

	function circleflip_icon_selector( $field_id, $selected = '' ) {
		ob_start();
		?>
		<div class="crdn-icon-selector">
			<button type="button" class="button-secondary" data-target="#crdn-icon-selector-modal" data-toggle="modal"><?php esc_html_e( 'pick an icon', 'circleflip' ) ?></button>
			<input type="hidden" class="crdn-selected-icon" name="<?php echo esc_attr( $field_id ) ?>" value="<?php echo esc_attr( $selected ) ?>">
			<i class="iconfontello preview <?php echo esc_attr( $selected ) ?>"></i>
		</div>
		<?php     
		return ob_get_clean();
	}

	function circleflip_get_entypo_icons() {
		global $cf_entypo_icons;
		if ( empty( $cf_entypo_icons ) )
			include_once get_template_directory() . '/entypo_fonts.php';

		return $cf_entypo_icons;
	}

	/* Changing Login Page image */

	function circleflip_my_login_logo() {
		global $rojoOptions;
		if ( circleflip_valid( 'login_image' ) ) {
			?>
			<style type="text/css">
				body.login div#login h1 a {
					background-image: url(<?php echo esc_url( cr_get_option( 'login_image' ) ) ?>);
					padding-bottom: 30px;
					background-size: initial;
					width: auto;
				}
			</style>
			<?php
		}
	}

	add_action( 'login_enqueue_scripts', 'circleflip_my_login_logo' );


	/* ======================================================================================================================

	  Change query size

	  ======================================================================================================================== */

	function circleflip_change_wp_query_size( $query ) {
		if ( $query->is_category && $query->is_main_query() ) { // Make sure it is a category / search page
			$query->set( 'posts_per_page', intval( cr_get_option( 'category_posts', 5 ) ) );
			$query->set( 'order', cr_get_option( 'category_posts_order_direction', 'DESC' ) );
			$query->set( 'post_type', 'post' ); //to execlude pages from the search query
		}
		if ( $query->is_tag && $query->is_main_query() ) {
			$query->set( 'posts_per_page', cr_get_option( 'tags_posts_per_page', 5 ) );
			$query->set( 'order', cr_get_option( 'tags_posts_order_direction', 'DESC' ) );
		}
		if ( $query->is_search && $query->is_main_query() ) {
			$query->set( 'posts_per_page', cr_get_option( 'search_posts_per_page', 5 ) );
			$query->set( 'order', cr_get_option( 'search_posts_order_direction', 'DESC' ) );
		}
		if ( $query->is_author && $query->is_main_query() ) {
			$query->set( 'posts_per_page', cr_get_option( 'author_posts', 5 ) );
			$query->set( 'order', cr_get_option( 'author_posts_order_direction', 'DESC' ) );
		}
	}

	add_action( 'pre_get_posts', 'circleflip_change_wp_query_size' ); // Hook our custom function onto the request filter

	add_action( 'init', 'header_search_icon' );

	function header_search_icon() {
		if ( ! cr_get_option( 'header_builder' ) ) {

			function circleflip_search_icon( $items, $args ) {
				if ( isset( $args->theme_location ) && 'footer-menu' == $args->theme_location ) {
					return $items;
				}
				if ( cr_get_option( 'search_area', true ) ) {
					ob_start();
					echo '<div>';
					circleflip_navbar_searchform( true, false, false );
					echo '</div>';
					$items .= '<li class="searchFormIcon"><span class="icon-search-1"></span>' . ob_get_clean() . '</li>';
				}
				return $items;
			}

			add_filter( 'wp_nav_menu_items', 'circleflip_search_icon', 10, 2 );
		};
	}

	/*	 * ******************************************
	 * **** Remove disable delete custom fields in page editor
	 * ****************************************** */
	add_action( 'admin_head', 'circleflip_remove_wordpress_cfields' );

	function circleflip_remove_wordpress_cfields() {
		echo '<style>
			label[for="circleflip-custom-sidebar-hide"],label[for="circleflip-blog-layout-hide"],label[for="circleflip-portfolio-layout-mb-hide"]
			{
				 display: none;
			}
		  </style>';
	}

	/* ======================================================================================================== *
	 *                                             Scripts & Styles                                             *
	 * ======================================================================================================== */

	if ( ! function_exists( 'circleflip_register_scripts_styles' ) ) {

		function circleflip_register_scripts_styles() {

			if ( ! is_admin() && ! circleflip_is_login_page() ) {
				$theme_version = _circleflip_version();
				$suffix = '.min';

				/* -------------------------------------------- Register Scripts -------------------------------------------- */

				wp_register_script( 'circleflip-site', get_template_directory_uri() . "/js/site.js", array( 'jquery', 'circleflip-sticky', 'circleflip-ticker', 'circleflip-tweet' ), $theme_version, true );
				wp_register_script( 'circleflip-tweet', get_template_directory_uri() . "/js/twitter/jquery.tweet.js", array( 'jquery' ), $theme_version, false );
				wp_register_script( 'circleflip-swipe', get_template_directory_uri() . '/js/jquery.touchSwipe.min.js', array( 'jquery' ), $theme_version, true );
				wp_register_script( 'circleflip-ticker', get_template_directory_uri() . "/js/ticker.js", array( 'jquery' ), $theme_version, true );
				wp_register_script( 'circleflip-retina', get_template_directory_uri() . '/js/retina-1.1.0.js', array( 'jquery' ), $theme_version, true );
				wp_register_script( 'circleflip-sticky', get_template_directory_uri() . "/js/jquery.sticky.js", array( 'jquery' ), $theme_version, true );
				wp_register_script( 'circleflip-isotope', get_template_directory_uri() . '/js/jquery.isotope.js', array( 'jquery' ), $theme_version, true );
				wp_register_script( 'circleflip-sliders', get_template_directory_uri() . "/scripts/modules/sliders.js", array( 'jquery' ), $theme_version, true );
				wp_register_script( 'circleflip-carouFredSel', get_template_directory_uri() . '/js/carouFredSel/jquery.carouFredSel-6.2.1.js', array( 'jquery' ), $theme_version, true );
				wp_register_script( 'circleflip-tw-bootstrap', get_template_directory_uri() . "/js/bootstrap.js", array( 'jquery' ), '2.0.3', true );
				wp_register_script( 'circleflip-the-bootstrap', get_template_directory_uri() . "/js/the-bootstrap{$suffix}.js", array( 'circleflip-tw-bootstrap' ), $theme_version, true );
				wp_register_script( 'circleflip-nicescroll', get_template_directory_uri() . '/js/jquery.nicescroll.js', array( 'jquery' ), $theme_version, true );
				wp_register_script( 'pretty', get_template_directory_uri() . '/js/prettyPhoto.js', array( 'jquery' ), '2.0.3', true );
				wp_register_script( 'recentJS', get_template_directory_uri() . '/scripts/modules/recent.js', array( 'jquery' ), '2.0.3', true );
				wp_register_script('galleryJS', get_template_directory_uri() .'/scripts/modules/gallery.js');
				wp_register_script( 'blogStyleJS', get_template_directory_uri() . '/scripts/singleStyle.js' );
				wp_register_script('zoomIn',get_template_directory_uri().'/js/jquery.zoom-min.js');
				/* ------------------------------------------ End Register Scripts ------------------------------------------ */



				/* ----------------------------------------- Register Generic Styles ----------------------------------------- */

				wp_register_style( 'circleflip-fonts', get_template_directory_uri() . "/css/fonts/fonts.css", array(), $theme_version );
				wp_register_style( 'circleflip-style', get_template_directory_uri() . "/style.css", array( 'circleflip-the-bootstrap', 'circleflip-bootstrap_min' ), '2.0.3' );
				wp_register_style( 'circleflip-widget', get_template_directory_uri() . "/css/widgets/widgets.css", array( 'circleflip-style', 'circleflip-tw-bootstrap' ), $theme_version );
				wp_register_style( 'circleflip-tw-bootstrap', get_template_directory_uri() . "/css/bootstrap{$suffix}.css", array( 'circleflip-fonts' ), '2.0.3' );
				wp_register_style( 'circleflip-the-bootstrap', get_template_directory_uri() . "/style{$suffix}.css", array( 'circleflip-tw-bootstrap' ), $theme_version );
				wp_register_style( 'blog', get_template_directory_uri() . '/css/parts/blog.css' );
				wp_register_style( 'blog-post', get_template_directory_uri() . '/css/parts/blog-post.css' );
				wp_register_style( 'squareposts', get_template_directory_uri() . '/css/content-builder/squareposts.css' );
				wp_register_style( 'prettyStyle', get_template_directory_uri() . '/css/prettyphoto/style/prettyPhoto.css' );
				wp_register_style('gallery', get_template_directory_uri() .'/css/content-builder/gallery.css');
				/* --------------------------------------- End Register Generic Styles --------------------------------------- */



				/* -------------------------------------------- Register IE Styles -------------------------------------------- */

				wp_register_style( 'circleflip-ie9', get_template_directory_uri() . '/css/ie9.css' );
				global $wp_styles;
				$wp_styles->add_data( 'circleflip-ie9', 'conditional', 'IE 9' );

				/* ------------------------------------------ End Register IE Styles ------------------------------------------ */



				/* ---------------------------------------- Register Responsive Styles ---------------------------------------- */

				wp_register_style( 'circleflip-responsive1', get_template_directory_uri() . "/css/parts/responsive1.css", array( 'circleflip-style', 'circleflip-tw-bootstrap' ), $theme_version );
				wp_register_style( 'circleflip-responsive2', get_template_directory_uri() . "/css/parts/responsive2.css", array( 'circleflip-style', 'circleflip-tw-bootstrap' ), $theme_version );
				wp_register_style( 'circleflip-responsive3', get_template_directory_uri() . "/css/parts/responsive3.css", array( 'circleflip-style', 'circleflip-tw-bootstrap' ), $theme_version );
				wp_register_style( 'circleflip-bootstrap_min', get_template_directory_uri() . "/css/parts/bootstrap-responsive.css", array( 'circleflip-tw-bootstrap' ), $theme_version );

				/* ------------------------------------ Register Responsive RTL Styles ------------------------------------ */

				wp_register_style( 'circleflip-responsive-rtl1', get_template_directory_uri() . "/css/parts/responsive-rtl1.css" );
				wp_register_style( 'circleflip-responsive-rtl2', get_template_directory_uri() . "/css/parts/responsive-rtl2.css" );

				/* ---------------------------------- End Register Responsive RTL Styles ---------------------------------- */

				/* -------------------------------------- End Register Responsive Styles -------------------------------------- */



				/* ------------------------------------------ Register Header Styles ------------------------------------------ */
				wp_register_style( 'circleflip-header-builder', get_template_directory_uri() . '/css/header-builder/style.css', array( 'circleflip-style' ) );
				wp_register_style( 'circleflip-header-builder-responsive', get_template_directory_uri() . '/css/header-builder/responsive.css', array( 'circleflip-style' ) );
				wp_register_style( 'circleflip-header-builder-rtl', get_template_directory_uri() . '/css/header-builder/rtl.css', array( 'circleflip-style' ) );
				wp_register_style( 'circleflip-header-style', get_template_directory_uri() . '/css/headers/style.css', array( 'circleflip-style' ) );
				wp_register_style( 'circleflip-header-1', get_template_directory_uri() . '/css/headers/headerStyle1.css', array( 'circleflip-style' ) );
				wp_register_style( 'circleflip-header-2', get_template_directory_uri() . '/css/headers/headerStyle2.css', array( 'circleflip-style' ) );
				wp_register_style( 'circleflip-header-3', get_template_directory_uri() . '/css/headers/headerStyle3.css', array( 'circleflip-style' ) );
				wp_register_style( 'circleflip-header-4', get_template_directory_uri() . '/css/headers/headerStyle4.css', array( 'circleflip-style' ) );
				wp_register_style( 'circleflip-header-5', get_template_directory_uri() . '/css/headers/headerStyle5.css', array( 'circleflip-style' ) );
				wp_register_style( 'circleflip-header-6', get_template_directory_uri() . '/css/headers/headerStyle6.css', array( 'circleflip-style' ) );
				wp_register_style( 'circleflip-header-7', get_template_directory_uri() . '/css/headers/headerStyle7.css', array( 'circleflip-style' ) );
				wp_register_style( 'circleflip-header-8', get_template_directory_uri() . '/css/headers/headerStyle8.css', array( 'circleflip-style' ) );
				wp_register_style( 'circleflip-header-9', get_template_directory_uri() . '/css/headers/headerStyle9.css', array( 'circleflip-style' ) );
				wp_register_style( 'circleflip-header-responsive', get_template_directory_uri() . '/css/headers/responsive.css', array( 'circleflip-style' ) );
				wp_register_style( 'circleflip-header-rtl', get_template_directory_uri() . '/css/headers/rtl.css', array( 'circleflip-style' ) );
				wp_register_style( 'circleflip-header-responsive-rtl', get_template_directory_uri() . '/css/headers/responsive-rtl.css', array( 'circleflip-style' ) );
				/* ---------------------------------------- End Register Header Styles ---------------------------------------- */


				$circleflip_dynamic_style_url = esc_url( add_query_arg( 'is_rtl', intval( is_rtl() ), get_template_directory_uri() . '/style.php' ) );
				wp_register_style( 'circleflip-theme_admin', $circleflip_dynamic_style_url );
			}
		}

		add_action( 'init', 'circleflip_register_scripts_styles' );
	}

	if ( ! function_exists( 'circleflip_enqueue_scripts_styles' ) ) {

		function circleflip_enqueue_scripts_styles() {
			if ( is_admin() ) {
				wp_enqueue_style( 'circleflip-fonts' );
			}
			if ( is_admin() || circleflip_is_login_page() ) {
				return;
			}

			/* ----------------------- Enqueue Scripts ----------------------- */
			wp_enqueue_script( 'circleflip-the-bootstrap' );
			wp_enqueue_script( 'circleflip-tweet' );
			wp_enqueue_script( 'circleflip-require' );
			wp_enqueue_script( 'circleflip-ticker' );
			wp_enqueue_script( 'circleflip-site' );
			wp_enqueue_script( 'circleflip-carouFredSel' );
			wp_enqueue_script( 'circleflip-swipe' );
			wp_enqueue_script( 'pretty' );
		    wp_enqueue_script( 'recentJS' );
			wp_enqueue_script('galleryJS');
			wp_enqueue_script( 'blogStyleJS' );
			wp_enqueue_script('zoomIn'); 
			if ( cr_get_option( 'woocommerce_masonry' ) ) {
				wp_enqueue_script( 'cf-masonry', get_template_directory_uri() . '/js/masonry.pkgd.min.js', array('jquery') );
			}
			if ( cr_get_option( 'nice_scroll_bar' ) == 1 ) {
				wp_enqueue_script( 'circleflip-nicescroll' );
			}

			/* --------------------- End Enqueue Scripts --------------------- */



			/* --------------------- Enqueue Header Styles --------------------- */
			if ( cr_get_option( 'header_builder' ) ) {
				wp_enqueue_style( 'circleflip-header-builder' );
				wp_enqueue_style( 'circleflip-header-builder-responsive' );
			} else {
				wp_enqueue_style( 'circleflip-header-style' );
				switch ( cr_get_option( 'header_style' ) ) {
					case 'style2' : wp_enqueue_style( 'circleflip-header-2' );
						break;
					case 'style3' : wp_enqueue_style( 'circleflip-header-3' );
						break;
					case 'style4' : wp_enqueue_style( 'circleflip-header-4' );
						break;
					case 'style5' : wp_enqueue_style( 'circleflip-header-5' );
						break;
					case 'style6' : wp_enqueue_style( 'circleflip-header-6' );
						break;
					case 'style7' : wp_enqueue_style( 'circleflip-header-7' );
						break;
					case 'style8' : wp_enqueue_style( 'circleflip-header-8' );
						break;
					case 'style9' : wp_enqueue_style( 'circleflip-header-9' );
						break;
					case 'style1' :
					default : wp_enqueue_style( 'circleflip-header-1' );
						break;
				}
			}
			/* ------------------- End Enqueue Header Styles-------------------- */



			/* -------------------- Enqueue Generic Styles -------------------- */
			wp_enqueue_style( 'circleflip-fonts' );
			wp_enqueue_style( 'blog' );
			wp_enqueue_style( 'blog-post' );
			wp_enqueue_style( 'squareposts' );
			wp_enqueue_style( 'prettyStyle' );
			wp_enqueue_style('gallery');
			if ( is_child_theme() ) {
				wp_enqueue_style( 'circleflip-the-bootstrap-child', get_stylesheet_uri(), array( 'circleflip-the-bootstrap' ) );
			} else {
				wp_enqueue_style( 'circleflip-style' );
				wp_enqueue_style( 'circleflip-widget' );
			}
			/* ------------------ End Enqueue Generic Styles ------------------ */



			/* ----------------------- Enqueue IE Styles ----------------------- */
			wp_enqueue_style( 'circleflip-ie9' );
			/* --------------------- End Enqueue IE Styles --------------------- */
		}

		add_action( 'wp_enqueue_scripts', 'circleflip_enqueue_scripts_styles', 1 );
	}

	if ( ! function_exists( 'circleflip_enqueue_dynamic_styles' ) ) {

		function circleflip_enqueue_dynamic_styles() {
			if ( is_admin() ) {
				return;
			}
			/* ------------------- Enqueue Responsive Styles ------------------- */
			if ( cr_get_option( 'responsive' ) ) {

				wp_enqueue_style( 'circleflip-responsive1' );
				wp_enqueue_style( 'circleflip-responsive2' );
				wp_enqueue_style( 'circleflip-responsive3' );
				wp_enqueue_style( 'circleflip-header-responsive' );
				/* ------------ Enqueue Responsive RTL Styles ------------ */
				if ( is_rtl() ) {
					if ( cr_get_option( 'header_builder' ) ) {
						wp_enqueue_style( 'circleflip-header-builder-rtl' );
					} else {
						wp_enqueue_style( 'circleflip-header-rtl' );
						wp_enqueue_style( 'circleflip-responsive-rtl1' );
						wp_enqueue_style( 'circleflip-responsive-rtl2' );
						wp_enqueue_style( 'circleflip-header-responsive-rtl' );
					}
				}
				/* ---------- End Enqueue Responsive RTL Styles ---------- */


				wp_enqueue_style( 'circleflip-bootstrap_min' );
			}
			/* ----------------- End Enqueue Responsive Styles ----------------- */
			wp_enqueue_style( 'circleflip-theme_admin' );
		}

		add_action( 'wp_footer', 'circleflip_enqueue_dynamic_styles', 19 );
	}

	if ( ! function_exists( 'circleflip_localize_scripts' ) ) {

		function circleflip_localize_scripts() {
			wp_localize_script( 'circleflip-site', 'global_creiden', array(
				'theme_path'	 => get_template_directory_uri(),
				'ajax_url'		 => admin_url( 'admin-ajax.php' ),
				'background'	 => cr_get_option( "color_elements", '#e32831' ),
				'responsive'	 => cr_get_option( 'responsive' ),
				'rtl'			 => is_rtl(),
				'nicescroll'	 => cr_get_option( 'nice_scroll_bar' ),
				'headerBuilder'	 => cr_get_option( 'header_builder' )
			) );
		}

		add_action( 'wp_enqueue_scripts', 'circleflip_localize_scripts' );
	}

	if ( ! function_exists( 'circleflip_print_ie_scripts' ) ) {

		function circleflip_print_ie_scripts() {
			?>
			<!--[if lt IE 9]>
					<script src="<?php echo esc_url( get_template_directory_uri() . '/js/html5shiv.min.js' ); ?>" type="text/javascript"></script>
					<script src="<?php echo esc_url( get_template_directory_uri() . '/js/respond.min.js' ); ?>" type="text/javascript"></script>
			<![endif]-->
			<?php
		}

		add_action( 'wp_head', 'circleflip_print_ie_scripts', 11 );
	}

	function circleflip_themeoptions_custom_css() {
		?>
		<style type="text/css">
	<?php echo htmlspecialchars_decode( cr_get_option( 'custom_css', '' ) ) ?>			
		</style>
		<?php
	}

	add_action( 'wp_head', 'circleflip_themeoptions_custom_css' );

	function circleflip_footer_scripts() {
		?>
		<script>
	<?php echo cr_get_option( "custom_js", '' ); ?>
		</script>
		<?php echo cr_get_option( "custom_code", '' ); ?>
		<?php
		wp_enqueue_script( 'circleflip-retina' );
	}

	add_action( 'wp_footer', 'circleflip_footer_scripts' );

	function get_header_builder() {
		global $post;
		$hb_names = get_option( 'hb_names' );
		//$hb_names = array_values($hb_names);
		$postmeta = get_post_meta( $post->ID, '_circleflip_headerBuilder' );
		$postmeta_slider = get_post_meta( $post->ID, '_circleflip_headerBuilder_slider' );
		if ( ! isset( $postmeta ) || empty( $postmeta ) ) {
			if ( is_rtl( 'global_header_builder_rtl' ) ) {
				$header_name = cr_get_option( 'global_header_builder_rtl', 0 );
			} else {
				$header_name = cr_get_option( 'global_header_builder', 0 );
			}

			$header_name = $hb_names[$header_name];
		} else {
			if ( $postmeta[0] != 'global' ) {
				$header_name = $hb_names[$postmeta[0]];
			} else {
				if ( is_rtl( 'global_header_builder_rtl' ) ) {
					$header_name = cr_get_option( 'global_header_builder_rtl', 0 );
				} else {
					$header_name = cr_get_option( 'global_header_builder', 0 );
				}
				$header_name = $hb_names[$header_name];
			}
		}
		// Get the slider before rendering the header
		if ( isset( $postmeta_slider ) && ! empty( $postmeta_slider ) ) {
			echo do_shortcode( $postmeta_slider[0] );
		}
		$header_builder = new header_builder;
		$header_builder->render_blocks_view( $header_name );
	}

	add_action( 'after_setup_theme', 'woocommerce_support' );

	function woocommerce_support() {
		add_theme_support( 'woocommerce' );
	}
	