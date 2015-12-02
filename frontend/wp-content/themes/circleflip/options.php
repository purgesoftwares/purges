<?php

/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 */
function circleflip_optionsframework_option_name() {

	// This gets the theme name from the stylesheet
	$themename = 'rojo';
	$themename = preg_replace("/\W/", "_", strtolower($themename));

	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = $themename;
	update_option('optionsframework', $optionsframework_settings);
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'options_framework_theme'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function circleflip_optionsframework_options() {

	global $fonts_global_array;

	$args = array(
			'post_type' => 'ml-slider',
			'post_status' => 'publish',
			'orderby' => 'date',
			'order' => 'ASC',
			'posts_per_page' => -1
	);

	$the_query = new WP_Query($args);

	while ($the_query->have_posts()) {
		$the_query->the_post();
		$sliders[$the_query->post->ID] = get_the_title();
	}
	if(!isset($sliders)) {
		$sliders = array();
	}
	array_key_exists(0, $sliders) ? $sliders[$the_query->post->ID + 1] = 'ultimate' : $sliders['ultimate'] = 'ultimate' ;
	array_key_exists(1, $sliders) ? $sliders[$the_query->post->ID + 2] = 'posts' : $sliders['posts'] = 'posts' ;
	array_key_exists(2, $sliders) ? $sliders[$the_query->post->ID + 3] = '3D Slider' : $sliders['3D'] = '3D Slider' ;
	array_key_exists(3, $sliders) ? $sliders[$the_query->post->ID + 4] = 'Elastic Slider' : $sliders['Elastic'] = 'Elastic Slider' ;
	// Background Defaults
	$background_defaults = array(
			'color' => '',
			'image' => '',
			'repeat' => 'repeat',
			'position' => 'top center',
			'attachment' => 'scroll');

	// Typography Defaults
	$typography_defaults = array(
			'size' => '16px',
			'face' => 'Arial',
			'style' => 'Normal',
			'color' => '#bada55');

	// Typography Options
	$my_fonts = array(
	'Arial' => 'Arial',
	'Times New Roman' => 'Times New Roman',
	'DroidArabicKufi' => 'DroidArabicKufi',
	'SourceSansSemiBold' => 'SourceSansSemiBold',
	'sourceSans' => 'sourceSans',
	);
	$typography_options = array(
			'sizes' => range(6, 71),
			'faces' =>  array_merge($my_fonts , $fonts_global_array),
			'styles' => array('Normal' => 'Normal','Italic' => 'Italic'),
			'weights' => array('Normal' => 'Normal','Bold' => 'Bold'),
			'color' => TRUE
	);
	
	// header builder names
	$hb_names = get_option('hb_names');
	//side bars array
	$sideBarsArray = array();
	$side_bars = cr_get_option("sidebars");
	if(isset($side_bars) && is_array($side_bars)) {
		foreach ($side_bars as $sidebar) {
			$sideBarsArray[$sidebar] = $sidebar;
		}
	}
	// Pull all the categories into an array
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}
	// Get all posts in the website
	$allPosts = get_posts(array('numberposts'=>-1));
	$postNames = array();
	foreach ($allPosts as $key => $post) {
		$postNames[$post->ID]= $post->post_title . " on " . date("F j, Y g:i a",strtotime($post->post_date)). " by " . (get_user_by('id', $post->post_author)->display_name) ;
	}
	wp_reset_postdata();

	$pages = get_pages();

	if(isset($pages)&& is_array($pages)){
		foreach ( $pages as $page ) {
			$pagesList[$page->ID]=$page->post_title;
		}
	}
	wp_reset_postdata();

	// Pull all tags into an array
	$options_tags = array();
	$options_tags_obj = get_tags();
	foreach ($options_tags_obj as $tag) {
		$options_tags[$tag->term_id] = $tag->name;
	}


	// Pull all the pages into an array
	$options_pages = array();
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}

	// If using image radio buttons, define a directory path
	$imagepath = get_template_directory_uri() . '/creiden-framework/images/';
	$imagepathinc = get_template_directory_uri() . '/creiden-framework/inc/images/';
	$options = array();

/* ========================================================================================================================

Start of Options

======================================================================================================================== */

/* ========================================================================================================================

General Settings Tab

======================================================================================================================== */

	$options[] = array(
		'name' => 'General Settings',
		'icon_name' => $imagepathinc . 'general.png',
		'type' => 'heading');

			/* ========================================================================================================================

			Header Options

			======================================================================================================================== */
			$options[] = array(
					'name' => 'Header Settings',
					'icon_name' => $imagepathinc . 'sub.png',
					'class' => 'sub_heading',
					'type' => 'heading'
			);
    
            $options[] = array(
					'name' => 'Header Builder',
					'desc' => 'To Enable the header builder and disable the old styles',
					'id' => 'header_builder',
					'class' => 'header_builder',
					'std' => '0',
					'type' => 'checkbox'
            );

			$options[] = array(
					'name' => 'Header Style',
					'desc' => 'Choose the header style',
					'id' => 'header_style',
					'std' => 'style1',
					'class' => 'header_images',
					'type' => "images",
					'options' => array(
						'style1' => $imagepath . 'Header1.png',
						'style2' => $imagepath . 'Header2.png',
						'style4' => $imagepath . 'Header4.png',
						'style5' => $imagepath . 'Header5.png',
						'style6' => $imagepath . 'Header6.png',
						'style7' => $imagepath . 'Header7.png',
						'style8' => $imagepath . 'Header8.png',
						'style9' => $imagepath . 'Header9.png'
						));
						
			if(circleflip_valid($hb_names)) {
				$options[] = array(
					'name' => 'Global Header',
					'desc' => 'Choose the global header setting',
					'id' => 'global_header_builder',
					'type' => "select",
					'options' => $hb_names);
				
				$options[] = array(
					'name' => 'Global RTL Header',
					'desc' => 'Choose the global RTL header setting',
					'id' => 'global_header_builder_rtl',
					'type' => "select",
					'options' => $hb_names);
			}
						
			$options[] = array(
					'name' => 'Header Sticky',
					'desc' => 'To enable Sticky Header',
					'id' => 'sticky_header',
					'class' => 'sticky_header',
					'std' => '0',
					'type' => 'checkbox');

			$options[] = array(
					'name' => 'Top Left Area Settings',
					'desc' => 'Choose what to add in the top left area',
					'id' => 'top_left_area_settings',
					'std' => 'contact',
					'type' => "select",
					'options' => array(
						'contact' => 'Contact',
						'social' => 'Social Icons',
						'main_navigation' => 'Main Navigation',
						'header_menu'=> 'Header Menu'
						));
			$options[] = array(
					'name' => 'Top Right Area Settings',
					'desc' => 'Choose what to add in the top right area',
					'id' => 'top_right_area_settings',
					'std' => 'social',
					'type' => "select",
					'options' => array(
						'contact' => 'Contact',
						'social' => 'Social Icons',
						'main_navigation' => 'Main Navigation',
						'header_menu'=> 'Header Menu'
						));
			$options[] = array(
					'name' => 'Ad Area Settings',
					'desc' => 'Choose what to add in the Ad area',
					'id' => 'top_area_header_settings',
					'std' => 'main_navigation',
					'type' => "select",
					'options' => array(
						'ad' => 'Advertisment',
						'social' => 'Social Icons',
						'main_navigation' => 'Main Navigation',
						'header_menu'=> 'Header Menu'
						));

			$options[] = array(
					'name' => 'Header Revolution Slider Shortcode',
					'desc' => 'Please enter the Overlay Header Revolution Slider Shortcode',
					'id' => 'overlayheader_slider',
					'std' => '',
					'type' => "text",
					);

			$options[] = array(
					'name' => 'Contact info',
					'desc' => 'Write a brief for your contact info to appear in the header',
					'id' => 'header_contact_settings',
					'std' => 'for any inquiry: 000-111-222-333 | info@circleflip.com',
					'type' => "text");
                        $options[] = array(
					'name' => 'Contact Link',
					'desc' => 'where do you want to link your contact text',
					'id' => 'header_contact_link_settings',
                                        'std' =>'',
					'type' => "text");

			$options[] = array(
					'name' => 'Ad Area Image',
					'desc' => 'Add the image of the ad',
					'id' => 'header_ad_area',
					'class' => 'ad_area',
					'std' => '',
					'type' => 'upload');

			$options[] = array(
					'name' => 'Ad Link',
					'desc' => 'Add the link of the ad area',
					'id' => 'header_ad_link',
					'std' => '#',
					'type' => "text");

			$options[] = array(
					'name' => 'Header height',
					'desc' => 'height in pixels (After changing this please refresh the window for changes to take effect on Logo Builder)',
					'id' => 'header_height',
					'std' => 137,
					'class' => 'mini',
					'type' => 'text');

			$options[] = array(
								'name' => 'Search Area',
								'desc' => 'Show the search area in the header',
								'id' => 'search_area',
								'class' => 'mini themeoptionsHidden showSearch',
								'std' => '1',
								'type' => 'checkbox');
			

			$options[] = array(
					'name' => 'Breaking News',
					'desc' => 'Show the breaking area in the header',
					'id' => 'breaking_area',
					'class' => 'mini themeoptionsHidden showBreak',
					'std' => '1',
					'type' => 'checkbox');

			$options[] = array(
					'name' => 'Breaking Title',
					'desc' => 'Text of the breaking area title',
					'id' => 'breaking_title',
					'std' => 'Breaking',
					'class' => 'mini themeoptionsHidden showBreak',
					'type' => 'text');

			$options[] = array(
					'name' => 'What to show',
					'desc' => 'Select the content of the Breaking Area',
					'id' => 'breaking_content',
					'class' => 'themeoptionsHidden showBreak',
					'std' => 'posts',
					'type' => 'radio',
					'options' => array(
							'posts' => 'Latest Posts',
							'custom' => 'Custom News'
					)
			);
			$options[] = array(
					'name' => 'Number of posts',
					'desc' => 'Enter number of posts to show in breaking area',
					'id' => 'number_breaking_posts',
					'class' => 'themeoptionsHidden showBreak',
					'std' => 10,
					'type' => 'text'
			);
			$options[] =  array(
					'name' => 'Breaking Area Selected Categories',
					'desc' => 'Select the categories you want',
					'id' => 'breaking_selected_category',
					'class' => 'themeoptionsHidden showBreak',
					'type' => 'selectmultiple',
					'options' => $options_categories
			);

			$options[] = array(
					'name' => 'Custom Content',
					'desc' => 'Put the sentences you want to show in the Breaking Area here separated by commas "," ',
					'id' => 'custome_breaking',
					'class' => 'themeoptionsHidden showBreak',
					'std' => 'Lorem Ipsum, Lorem Ipsum',
					'type' => 'textarea');


			/* ========================================================================================================================

			Social Icons Options

			======================================================================================================================== */

			$options[] = array(
					'name' => 'Social Icons Settings',
					'icon_name' => $imagepathinc . 'sub.png',
					'class' => 'sub_heading',
					'type' => 'heading'
			);

			$options[] = array(
					'name' => 'Social Links',
					'desc' => 'add your social links',
					'id' => 'social_urls',
					'type' => 'cust_social',
					'std' => array(),
			);

			/* ========================================================================================================================

			Footer Options

			======================================================================================================================== */

			$options[] = array(
					'name' => 'Footer Settings',
					'icon_name' => $imagepathinc . 'sub.png',
					'class' => 'sub_heading',
					'type' => 'heading'
			);

			$options[] = array(
					'name' => 'Copy Rights Text',
					'desc' => 'Enter the text you want to show in your footer here',
					'id' => 'copy_rights_text',
					'std' => 'All rights Reserved',
					'type' => 'text'
			);

			$options[] = array(
					'name' => 'Footer Widgets Width',
					'desc' => 'Choose the maximum number of widgets',
					'id' => 'max_number_widgets',
					'type' => 'select',
					'options' => array(
							'1' => '1',
							'2' => '2',
							'3' => '3',
							'4' => '4',
					)
			);
			/* ========================================================================================================================

			Logo Options

			======================================================================================================================== */

			$options[] = array(
					'name' => 'Logo',
					'icon_name' => $imagepathinc . 'sub.png',
					'class' => 'sub_heading',
					'type' => 'heading'
			);
			$options[] = array(
					'name' => 'Logo Builder',
					'desc' => 'Preferred Logo Size is 194px X 90px ',
					'id' => 'theme_logo',
					'std' => '',
					'class' => 'theme_logo',
					'type' => 'upload');

			$options[] = array(
					'name' => 'Preview Logo Position and Size',
					'desc' => 'Check here',
					'id' => 'logoWrapper',
					'class' => 'builder',
					'type' => 'logo_builder');

			$options[] = array(
					'id' => 'logo_width',
					'class' => 'mini',
					'placeholder' => 'Width',
					'std' => '270',
					'type' => 'text');

			$options[] = array(
					'id' => 'logo_height',
					'class' => 'mini',
					'placeholder' => 'Height',
					'std' => '137',
					'type' => 'text');

			$options[] = array(
					'id' => 'logo_top',
					'class' => 'mini',
					'placeholder' => 'Top',
					'std' => '0',
					'type' => 'text');

			$options[] = array(
					'id' => 'logo_left',
					'class' => 'mini',
					'placeholder' => 'Left',
					'std' => '0',
					'type' => 'text');

			$options[] = array(
					'desc' => 'Aspect Ratio',
					'id' => 'logo_aspectRatio',
					'class' => 'mini',
					'std' => '1',
					'type' => 'checkbox');

			$options[] = array(
					'id' => 'resetLogoSize',
					'text' => 'Reset Size',
					'type' => 'button'
			);

			$options[] = array(
					'name' => 'Logo Wrapper Width',
					'desc' => 'Width in pixels (After changing this please refresh the window for changes to take effect on Logo Builder)',
					'id' => 'logo_wrapper_width',
					'std' => 270,
					'class' => 'mini',
					'type' => 'text');

			$options[] = array(
					'name' => 'Retina Logo',
					'desc' => 'Dimensions should be double of the normal logo (Preferred Size is 540px X 274px) and must be named filename@2x.png',
					'id' => 'retina_logo',
					'std' => '',
					'class' => 'theme_logo',
					'type' => 'upload');
					
			$options[] = array(
					'name' => 'RTL Retina Logo',
					'desc' => 'Dimensions should be double of the normal logo (Preferred Size is 540px X 274px) and must be named filename@2x.png',
					'id' => 'rtl_retina_logo',
					'std' => '',
					'class' => 'theme_logo',
					'type' => 'upload');
			if( !function_exists('wp_site_icon') ) {
				
				$options[] = array(
					'name' => 'Favicon',
					'desc' => 'Upload your favicon here (Please use *.ico file type only)',
					'id' => 'favicon',
					'std' => '',
					'type' => 'upload');	
			}
			

			/* ========================================================================================================================

			Advanced Options

			======================================================================================================================== */

			$options[] = array(
					'name' => 'Advanced',
					'icon_name' => $imagepathinc . 'sub.png',
					'class' => 'sub_heading',
					'type' => 'heading'
			);

			$options[] = array(
					'name' => 'Responsive',
					'desc' => 'To enable viewing this website normally on a mobile device, mark this option',
					'id' => 'responsive',
					'class' => 'mini',
					'std' => '1',
					'type' => 'checkbox');
			
			$options[] = array(
					'name' => 'RTL Website',
					'desc' => 'To enable viewing this website with RTL languages',
					'id' => 'rtl',
					'class' => 'mini',
					'std' => '0',
					'type' => 'checkbox');
					
			$options[] = array(
					'name' => 'Nice scroll bar',
					'desc' => 'Enable nice scroll bar for all pages',
					'id' => 'nice_scroll_bar',
					'class' => 'mini',
					'std' => '',
					'type' => 'checkbox');
			$options[] = array(
					'name' => 'Custom CSS Code',
					'desc' => 'Paste any CSS rules that you want to add to the theme here.',
					'id' => 'custom_css',
					'std' => '',
					'type' => 'textarea');

			$options[] = array(
					'name' => 'Custom Javascript code',
					'desc' => 'Paste any JS that you want to add to the theme here.',
					'id' => 'custom_js',
					'std' => '',
					'type' => 'textarea');
			
			$options[] = array(
					'name' => 'Custom Code',
					'desc' => 'Paste any code that you want to add to the theme here, mainly used when you have a noscript tag or html that you want to place directly to the theme',
					'id' => 'custom_code',
					'std' => '',
					'type' => 'textarea');
					
			$options[] = array(
					'name' => 'Login Page Logo',
					'desc' => 'Upload your preferred image for Wordpress Login page here',
					'id' => 'login_image',
					'type' => 'upload');

			$options[] = array(
					'name' => 'Default Blocks Animations',
					'desc' => 'Choose the default animation for the blocks',
					'id' => 'block_animations',
					'type' => 'select',
					'options' => array(
							'noanimation' => 'no animation',
							'cr_left' => 'Fade To Left',
							'cr_right' => 'Fade To Right',
							'cr_top' => 'Fade To Up',
							'cr_bottom' => 'Fade To Down',
							'cr_popup' => 'Popout',
							'cr_fade' => 'Fade in',
					)
			);
			
			$options[] = array(
				'name' => 'Activate the revisions history',
				'desc' => 'Do you want to activate the revisions history, note: enabling it makes publishing pages a little bit slower however it is safer to your content builder data',
				'id' => 'activate_revisions_history',
				'type' => 'select',
				'options' => array(
						'Yes' => 'Yes',
						'No' => 'No'
				)
			);

		/* ========================================================================================================================

		Pages Settings Tab

		======================================================================================================================== */

	$options[] = array(
			'name' => 'Pages Settings',
			'icon_name' => $imagepathinc . 'pages.png',
			'type' => 'heading');

			/* ========================================================================================================================

			Blog Page Options

			======================================================================================================================== */

			$options[] = array(
					'name' => 'Template Blog Page',
					'icon_name' => $imagepathinc . 'sub.png',
					'class' => 'sub_heading',
					'type' => 'heading'
			);

			$options[] = array(
					'name' => 'Posts per Page',
					'desc' => 'Number of posts to show in the blog page',
					'id' => 'blog_posts_per_page',
					'std' => '5',
					'class' => 'mini',
					'type' => 'text');

			$options[] = array(
					'name' => 'Selected Category',
					'desc' => 'Select the category you want to show in the Blog Page',
					'id' => 'blog_selected_cat',
					'type' => 'selectmultiple',
					'options' => $options_categories
			);

			$options[] = array(
					'name' => 'Display Views Count',
					'desc' => 'View count of comments/views of the posts shown in Blog page',
					'id' => 'blog_views_count',
					'class' => 'mini',
					'std' => '1',
					'type' => 'checkbox');

			$options[] = array(
					'name' => 'Display Date',
					'desc' => 'View date of the posts shown in blog page',
					'id' => 'blog_date',
					'class' => 'mini',
					'std' => '1',
					'type' => 'checkbox');

			$options[] = array(
					'name' => 'Display Author Name',
					'desc' => 'View Author name of the post shown in blog page',
					'id' => 'blog_author',
					'class' => 'mini',
					'std' => '1',
					'type' => 'checkbox');

			$options[] = array(
					'name' => 'Order Direction',
					'desc' => 'Order direction for posts in Blog page ',
					'id' => 'blog_posts_order_direction',
					'std' => 'DESC',
					'type' => 'select',
					'options' => array(
							'ASC' => 'Ascending',
							'DESC' => 'Descending'
					)
			);
			$options[] = array(
					'name' => 'Read More button Text',
					'desc' => 'Text shown under the arrow which opens the post',
					'id' => 'blog_read_more',
					'std' => 'More',
					'class' => 'mini',
					'type' => 'text');

			/* ========================================================================================================================

			Tags page Options

			======================================================================================================================== */

			$options[] = array(
					'name' => 'Tags Page',
					'icon_name' => $imagepathinc . 'sub.png',
					'class' => 'sub_heading',
					'type' => 'heading'
			);
			$options[] = array(
						'name' => "Page Layout",
						'desc' => "Please choose the preferred layout for Tags page",
						'id' => "tags_layout",
						'std' => "right",
						'type' => "images",
						'options' => array(
								'none' => $imagepath . '/1col.png',
								'left' => $imagepath . '/2cl.png',
								'right' => $imagepath . '/2cr.png')
					);

			$options[] = array(
					'name' => 'Tags page Sidebar',
					'desc' => 'Select the side bar you want to view in the Tags page',
					'id' => 'tags_sidebar',
					'type' => 'select',
					'options' => $sideBarsArray
			);

			$options[] = array(
					'name' => 'Posts per Page',
					'desc' => 'Number of posts to show in the tags page',
					'id' => 'tags_posts_per_page',
					'std' => '5',
					'class' => 'mini',
					'type' => 'text');

			$options[] = array(
					'name' => 'Order Direction',
					'desc' => 'Order direction for posts in tags page ',
					'id' => 'tags_posts_order_direction',
					'std' => 'DESC',
					'type' => 'select',
					'options' => array(
							'ASC' => 'Ascending',
							'DESC' => 'Descending'
					)
			);

			/* ========================================================================================================================

			Search Results Options

			======================================================================================================================== */

			$options[] = array(
					'name' => 'Search Results Page',
					'icon_name' => $imagepathinc . 'sub.png',
					'class' => 'sub_heading',
					'type' => 'heading'
			);
			$options[] = array(
						'name' => "Page Layout",
						'desc' => "Please choose the preferred layout for search page",
						'id' => "search_layout",
						'std' => "right",
						'type' => "images",
						'options' => array(
								'none' => $imagepath . '/1col.png',
								'left' => $imagepath . '/2cl.png',
								'right' => $imagepath . '/2cr.png')
					);

			$options[] = array(
					'name' => 'search page Sidebar',
					'desc' => 'Select the side bar you want to view in the search page',
					'id' => 'search_sidebar',
					'type' => 'select',
					'options' => $sideBarsArray
			);

			$options[] = array(
					'name' => 'Posts per Page',
					'desc' => 'Number of posts to show in the search page',
					'id' => 'search_posts_per_page',
					'std' => '5',
					'class' => 'mini',
					'type' => 'text');





			$options[] = array(
					'name' => 'Order Direction',
					'desc' => 'Order direction for posts in search page ',
					'id' => 'search_posts_order_direction',
					'std' => 'DESC',
					'type' => 'select',
					'options' => array(
							'ASC' => 'Ascending',
							'DESC' => 'Descending'
					)
			);

			/* ========================================================================================================================

			Category Page Options

			======================================================================================================================== */

			$options[] = array(
					'name' => 'Category Page',
					'icon_name' => $imagepathinc . 'sub.png',
					'class' => 'sub_heading',
					'type' => 'heading'
			);
			$options[] = array(
						'name' => "Page Layout",
						'desc' => "Please choose the preferred layout for category page",
						'id' => "category_layout",
						'std' => "right",
						'type' => "images",
						'options' => array(
								'none' => $imagepath . '/1col.png',
								'left' => $imagepath . '/2cl.png',
								'right' => $imagepath . '/2cr.png')
					);
			$options[] = array(
					'name' => 'Category page Sidebar',
					'desc' => 'Select the side bar you want to view in the category page',
					'id' => 'category_sidebar',
					'type' => 'select',
					'options' => $sideBarsArray
			);
			$options[] = array(
					'name' => 'Number Of Posts Displayed',
					'desc' => 'Number of posts to show',
					'id' => 'category_posts',
					'std' => '5',
					'class' => 'mini',
					'type' => 'text');

			$options[] = array(
					'name' => 'Order Direction',
					'desc' => 'Order posts in category page ',
					'id' => 'category_posts_order_direction',
					'std' => 'DESC',
					'type' => 'select',
					'options' => array(
							'ASC' => 'Ascending',
							'DESC' => 'Descending'
					)
			);

			/* ========================================================================================================================

			Author Page Options

			======================================================================================================================== */

			$options[] = array(
					'name' => 'Author Page',
					'icon_name' => $imagepathinc . 'sub.png',
					'class' => 'sub_heading',
					'type' => 'heading'
			);
			$options[] = array(
						'name' => "Page Layout",
						'desc' => "Please choose the preferred layout for Author page",
						'id' => "author_layout",
						'std' => "right",
						'type' => "images",
						'options' => array(
								'none' => $imagepath . '/1col.png',
								'left' => $imagepath . '/2cl.png',
								'right' => $imagepath . '/2cr.png')
					);
			$options[] = array(
					'name' => 'Author page Sidebar',
					'desc' => 'Select the side bar you want to view in the author page',
					'id' => 'author_sidebar',
					'type' => 'select',
					'options' => $sideBarsArray
			);
			$options[] = array(
					'name' => 'Number Of Posts Displayed',
					'desc' => 'Number of posts to show',
					'id' => 'author_posts',
					'std' => '5',
					'class' => 'mini',
					'type' => 'text');

			$options[] = array(
					'name' => 'Order Direction',
					'desc' => 'Order posts in author page ',
					'id' => 'author_posts_order_direction',
					'std' => 'DESC',
					'type' => 'select',
					'options' => array(
							'ASC' => 'Ascending',
							'DESC' => 'Descending'
					)
			);
			/* ========================================================================================================================

			Post Page Options

			======================================================================================================================== */

			$options[] = array(
					'name' => 'Post Page',
					'icon_name' => $imagepathinc . 'sub.png',
					'class' => 'sub_heading',
					'type' => 'heading'
			);

			$options[] = array(
					'name' => 'Style Posts',
					'desc' => 'Choose the style of the posts',
					'id' => 'style_posts',
					'std' => 'fade',
					'type' => 'radio',
					'options' => array(
							'singlestyle1' => 'Single Style1',
							'singlestyle2' => 'Single Style2'
					)
			);


			$options[] = array(
					'name' => 'Post side Bar Settings',
					'desc' => 'Select whether to setup layout settings for each post separately or globally through here',
					'id' => 'post_sidebars_option',
					'std' => 'meta',
					'type' => 'radio',
					'options' => array(
							'meta' => 'Use settings from each post separetly (found in the meta box)',
							'global' => 'Use global values set here (This will override meta post settings)'
							)
					);

			$options[] = array(
					'name' => "Post Global Sidebar position",
					'desc' => "Please choose the preferred layout for post page (this will override meta settings)",
					'id' => "post_layout",
					'std' => "none",
					'type' => "images",
					'options' => array(
							'none' => $imagepath . '/1col.png',
							'left' => $imagepath . '/2cl.png',
							'right' => $imagepath . '/2cr.png')
					);
			$options[] = array(
					'name' => 'Post page Global Sidebar',
					'desc' => 'Select the side bar you want to view in the post page (this will override meta settings)',
					'id' => 'post_sidebar',
					'type' => 'select',
					'options' => $sideBarsArray
			);

			$options[] = array(
					'name' => 'Default Post image',
					'desc' => 'The image to show if post has no thumbnail (this will only work if post type is not none)',
					'id' => 'post_default',
					'std' => $imagepathinc . 'defaultImage.png',
					'class' => 'theme_logo',
					'type' => 'upload');

			$options[] = array(
					'name' => 'Display Post image',
					'desc' => 'View Post image/video/slider area',
					'id' => 'post_view_image',
					'class' => 'mini',
					'std' => '1',
					'type' => 'checkbox');

			$options[] = array(
					'name' => 'Display Post author details',
					'desc' => 'View About Author section',
					'id' => 'post_author',
					'class' => 'mini',
					'std' => '1',
					'type' => 'checkbox');

			$options[] = array(
					'name' => 'Display Social Shares icons',
					'desc' => 'View Social section',
					'id' => 'post_social',
					'class' => 'mini',
					'std' => '1',
					'type' => 'checkbox');

			$options[] = array(
					'name' => 'Display Views Count',
					'id' => 'post_views',
					'class' => 'mini',
					'std' => '1',
					'type' => 'checkbox');

			$options[] = array(
					'name' => 'Display Comments Count',
					'id' => 'post_comments_count',
					'class' => 'mini',
					'std' => '1',
					'type' => 'checkbox');

			$options[] = array(
					'name' => 'Display related posts Section',
					'desc' => 'Show related posts below the post',
					'id' => 'post_related',
					'class' => 'mini',
					'std' => '1',
					'type' => 'checkbox');

			$options[] = array(
					'name' => 'Query related posts by',
					'id' => 'post_related_query',
					'std' => 'category',
					'type' => 'select',
					'options' => array(
							'category' => 'Category',
							'author' => 'Author'
					)
			);

			$options[] = array(
					'name' => 'Number of related posts to show',
					'desc' => 'Type the number of related posts you want to show in this section. Please don&#39;t type (-1) as value',
					'id' => 'post_related_number_of_posts',
					'std' => '5',
					'class' => 'mini',
					'type' => 'text');

			$options[] = array(
					'name' => 'Display Wordpress Comments Section',
					'id' => 'post_comments_section',
					'class' => 'mini',
					'std' => '1',
					'type' => 'checkbox');
			$options[] = array(
					'name' => 'Display Facebook Comments Section',
					'id' => 'post_facebook_comments_section',
					'class' => 'mini',
					'std' => '1',
					'type' => 'checkbox');
			/* ========================================================================================================================

			Sitemap Page Options

			======================================================================================================================== */

			$options[] = array(
					'name' => 'Sitemap Page',
					'icon_name' => $imagepathinc . 'sub.png',
					'class' => 'sub_heading',
					'type' => 'heading'
			);
			$options[] = array(
					'name' => 'Show pages section',
					'desc' => 'Show pages sections in the sitemap page',
					'id' => 'show_pages_sitemap',
					'class' => 'mini',
					'std' => '1',
					'type' => 'checkbox');

			$options[] = array(
					'name' => 'Selected Pages',
					'desc' => 'Select the pages you want',
					'id' => 'site_map_selected_pages',
					'type' => 'selectmultiple',
					'options' => $pagesList
					);

			$options[] = array(
					'name' => 'Show Categories section',
					'desc' => 'Show Categories sections in the sitemap page',
					'id' => 'show_categories_sitemap',
					'class' => 'mini',
					'std' => '1',
					'type' => 'checkbox');

			$options[] = array(
					'name' => 'Selected Categories',
					'desc' => 'Select the Categories you want',
					'id' => 'site_map_selected_categories',
					'type' => 'selectmultiple',
					'options' => $options_categories
					);

			$options[] = array(
					'name' => 'Show posts section',
					'desc' => 'Show posts sections in the sitemap page',
					'id' => 'show_posts_sitemap',
					'class' => 'mini',
					'std' => '1',
					'type' => 'checkbox');

			$options[] = array(
					'name' => 'Selected Posts',
					'desc' => 'Select the Posts you want',
					'id' => 'site_map_selected_posts',
					'type' => 'selectmultiple',
					'options' => $postNames
					);

			$options = apply_filters( 'circleflip_theme_options_pages_settings', $options );
			/* ========================================================================================================================

			Sliders Page Options

			======================================================================================================================== */

			$options[] = array(
					'name' => 'Sliders Settings',
					'icon_name' => $imagepathinc . 'pages.png',
					'type' => 'heading'
			);
			/* ========================================================================================================================

			Create Slider

			======================================================================================================================== */
			$options[] = array(
								'name' => 'Create New Slider',
								'icon_name' => $imagepathinc . 'sub.png',
								'class' => 'sub_heading',
								'type' => 'heading'
						);
			$options[] = array(
								'name' => 'Create Slider',
								'id' => 'create_slider',
								'type' => 'create_slider'
						);
			/* ========================================================================================================================

			All Sliders

			======================================================================================================================== */
foreach (cr_get_option('create_slider', array()) as $key => $value) {
	if(circleflip_valid($value)) {
		$options[] = array(
			'name' => $value . ' Settings',
			'icon_name' => $imagepathinc . 'sub.png',
			'class' => 'sub_heading',
			'type' => 'heading'
		);

		$value = strtolower(str_replace(' ', '_', $value));
		$options[] = array(
			'name' => 'Slider Type',
			'id' => $value.'select_slider',
			'desc' => 'Choose Your Slider',
			'class' => 'choose_slider',
			'type' => 'select',
			'options' => array(
				'nivo_slider' => 'Nivo Slider',
				'threed_slider' => '3D Slider',
				'accordion' => 'Accordion Slider',
				'elastic_slider' => 'Elastic Slider',
				'vertical_accordion_slider' => 'Vertical Accordion Slider'
			)
		);
		$options[] = array(
			'name' => 'Slider Settings',
			'desc' => 'Add/Remove any slide and click Save Changes to take effect.',
			'std' => 1,
			'id' => $value,
			'type' => 'add_slide',
			'slider_items' => array(
				0 => array(
					'name' => 'Title',
					'desc' => 'Enter the slide title',
					'id' => $value.'_title',
					'class' => 'title',
					'std' => 'Title',
					'type' => 'text'
				),
				1 => array(
					'name' => 'Text',
					'desc' => 'Enter the slide text',
					'id' => $value.'_text',
					'class' => 'text',
					'std' => 'Text',
					'type' => 'text'
				),
				2 => array(
					'name' => 'Radio Button',
					'desc' => 'Select whether to setup layout settings for each post separately or globally through here',
					'id' => $value.'_radio',
					'class' => 'radio',
					'std' => 'meta',
					'type' => 'radio',
					'options' => array(
							'meta' => 'Use settings from each post separetly (found in the meta box)',
							'global' => 'Use global values set here (This will override meta post settings)'
							)
				),
				3 => array(
					'name' => 'Upper Area Sidebar',
					'desc' => 'Select the side bar you want to view in the upper area of the page',
					'id' => $value.'_select',
					'class' => 'select',
					'type' => 'select',
					'options' => array(
							'Option_1' => 'Option 1',
							'Option_2' => 'Option 2',
							'Option_3' => 'Option 3',
							'Option_4' => 'Option 4'
							)
				),
				4 => array(
						'name' => 'Slide Image',
						'desc' => 'Add Your Image',
						'id' => $value.'_image',
						'class' => 'slide_image image',
						'std' => '',
						'type' => 'upload'
				)
				,
				5 => array(
						'name' => 'Slide Thumbnail',
						'desc' => 'Add Your Thumbnail Image',
						'id' => $value.'_thumb',
						'class' => 'slide_image thumb',
						'std' => '',
						'type' => 'upload'
				),
				6 => array(
					'name' => 'Link',
					'desc' => 'Enter the slide link',
					'id' => $value.'_link',
					'class' => 'slide_link link',
					'std' => '',
					'type' => 'text'
				),
				7 => array(
					'name' => 'Title Font',
					'id'  => $value.'_font_title',
					'std' => array('size' => '22px', 'face' => 'BebasNeueRegular', 'style' => 'Normal', 'color' => '#b57e65', 'weight' => 'Normal'),
					'class' => 'titleFont',
					'type' => 'typography',
					'options' => $typography_options
					),
				8 => array(
					'name' => 'Text Font',
					'id'  => $value.'_font_text',
					'std' => array('size' => '22px', 'face' => 'BebasNeueRegular', 'style' => 'Normal', 'color' => '#b57e65', 'weight' => 'Normal'),
					'class' => 'textFont',
					'type' => 'typography',
					'options' => $typography_options
					),
				9 => array(
					'name' => 'button1Text',
					'desc' => 'Enter button 1 text',
					'id' => $value.'_button1',
					'class' => 'button1',
					'std' => 'Text',
					'type' => 'text'
				),
				10 => array(
					'name' => 'button1Link',
					'desc' => 'Enter button 1 Link',
					'id' => $value.'_button1link',
					'class' => 'button1link',
					'std' => 'Text',
					'type' => 'text'
				),
				11 => array(
					'name' => 'button2Text',
					'desc' => 'Enter button 2 text',
					'id' => $value.'_button2',
					'class' => 'button2',
					'std' => 'Text',
					'type' => 'text'
				),
				12 => array(
					'name' => 'button2Link',
					'desc' => 'Enter button 2 Link',
					'id' => $value.'_button2link',
					'class' => 'button2link',
					'std' => 'Text',
					'type' => 'text'
				),
				13 => array(
					'name' => 'button3Text',
					'desc' => 'Enter button 3 text',
					'id' => $value.'_button3',
					'class' => 'button3',
					'std' => 'Text',
					'type' => 'text'
				),
				14 => array(
					'name' => 'button3Link',
					'desc' => 'Enter button 3 Link',
					'id' => $value.'_button3link',
					'class' => 'button3link',
					'std' => 'Text',
					'type' => 'text'
				),
			)
		);
	}

}

/* ========================================================================================================================

Style Settings Tab

======================================================================================================================== */

	$options[] = array(
			'name' => 'Style Settings',
			'icon_name' => $imagepathinc . 'style.png',
			'type' => 'heading');
			/* ========================================================================================================================

			Style Settings Tab

			======================================================================================================================== */
			$options[] = array(
						'name' => 'General Style',
						'icon_name' => $imagepathinc . 'sub.png',
						'class' => 'sub_heading',
						'type' => 'heading');
			$options[] = array(
						'name' => 'Template Color',
						'desc' => 'Select the template color you want',
						'id' => 'template_color',
						'type' => 'select',
						'std' => 'red',
						'options' => array(
										'red' => 'Red (Default)',
										'light_red'=> 'Light Red',
										'blue' => 'Blue',
										'green'=> 'Green',
										'purple'=> 'Purple',
										'dark_blue'=> 'Dark Blue',
										'orange'=> 'Orange',
										'pink'=> 'Pink',
										'grey'=> 'Grey',
										'yellow'=> 'Yellow',
										'brown'=> 'Brown',
										'custom'=> 'Custom'));

			$options[] = array(
				'name' => 'Colored Elements Color (Theme Color)',
				'desc' => 'Applied to Tabs, tags hover,etc ',
				'id' => 'color_elements',
				'std' => '#e32831',
				'type' => 'color');

			$options[] = array(
				'name' => 'Colored Elements Color (Darker Color)',
				'desc' => 'This color is usually darker than theme color.',
				'id' => 'color_elements_dark',
				'std' => '#b92424',
				'type' => 'color');

			$options[] = array(
				'name' => 'H1 Font, size and color',
				'id' => "h1",
				'std' => array('size' => '24px', 'face' => 'sourceSans', 'style' => 'Normal', 'color' => '#2a2a2a', 'weight' => 'Normal'),
				'type' => 'typography',
				'options' => $typography_options,
				);

			$options[] = array(
				'name' => 'H2 Font, size and color',
				'id' => "h2",
				'std' => array('size' => '22px', 'face' => 'sourceSans', 'style' => 'Normal', 'color' => '#2a2a2a', 'weight' => 'Normal'),
				'type' => 'typography',
				'options' => $typography_options,
				);

			$options[] = array(
				'name' => 'H3 Font, size and color',
				'id' => "h3",
				'std' => array('size' => '20px', 'face' => 'sourceSans', 'style' => 'Normal', 'color' => '#2a2a2a', 'weight' => 'Normal'),
				'type' => 'typography',
				'options' => $typography_options,
				);

			$options[] = array(
				'name' => 'H4 Font, size and color',
				'id' => "h4",
				'std' => array('size' => '18px', 'face' => 'sourceSans', 'style' => 'Normal', 'color' => '#2a2a2a', 'weight' => 'Normal'),
				'type' => 'typography',
				'options' => $typography_options,
				);

			$options[] = array(
				'name' => 'H5 Font, size and color',
				'id' => "h5",
				'std' => array('size' => '16px', 'face' => 'sourceSans', 'style' => 'Normal', 'color' => '#2a2a2a', 'weight' => 'Normal'),
				'type' => 'typography',
				'options' => $typography_options,
				);

			$options[] = array(
				'name' => 'H6 Font, size and color',
				'id' => "h6",
				'std' => array('size' => '14px', 'face' => 'sourceSans', 'style' => 'Normal', 'color' => '#2a2a2a', 'weight' => 'Normal'),
				'type' => 'typography',
				'options' => $typography_options,
				);

			$options[] = array(
				'name' => 'Paragraphs',
				'desc' => 'Custom typography options.',
				'id' => "paragraphs",
				'std' => array('size' => '13px', 'face' => 'sourceSans', 'style' => 'Normal', 'color' => '#5a5a5a', 'weight' => 'Normal'),
				'type' => 'typography',
				'options' => $typography_options,
				);

			/* ========================================================================================================================

			Header Style Options

			======================================================================================================================== */

			$options[] = array(
					'name' => 'Header Style',
					'icon_name' => $imagepathinc . 'sub.png',
					'class' => 'sub_heading',
					'type' => 'heading');

			$options[] = array(
				'name' => 'Menu Typography',
				'id' => 'header_menu_typography',
				'std' => array('size' => '15px', 'face' => 'sourceSans', 'style' => 'Normal', 'color' => '#5a5a5a', 'weight' => 'Normal'),
				'type' => 'typography',
				'options' => $typography_options,
				);

			$options[] = array(
				'name' => 'Breaking Title',
				'id' => 'header_breaking_title_typography',
				'std' => array('size' => '17px', 'face' => 'SourceSansSemiBold', 'style' => 'Normal', 'color' => '#ffffff', 'weight' => 'Normal'),
				'type' => 'typography',
				'options' => $typography_options,
				);

			$options[] = array(
				'name' => 'Breaking Text',
				'id' => 'header_breaking_text_typography',
				'std' => array('size' => '12px', 'face' => 'sourceSans', 'style' => 'Normal', 'color' => '#ffffff', 'weight' => 'Normal'),
				'type' => 'typography',
				'options' => $typography_options,
				);


			/*========================================================================================================================

			Footer Style Options

			======================================================================================================================== */

			$options[] = array(
					'name' => 'Footer Widgets Style',
					'icon_name' => $imagepathinc . 'sub.png',
					'class' => 'sub_heading',
					'type' => 'heading'
					);

			$options[] = array(
				'name' => 'Footer Title Typography',
				'id' => 'footer_title_style',
				'std' => array('size' => '22px', 'face' => 'sourceSans', 'style' => 'Normal', 'color' => '#ffffff', 'weight' => 'Normal'),
				'type' => 'typography',
				'options' => $typography_options,
				);
				
			$options[] = array(
				'name' => 'Footer Text Typography',
				'id' => 'footer_text_style',
				'std' => array('size' => '12px', 'face' => 'sourceSans', 'style' => 'Normal', 'color' => '#d5d5d5', 'weight' => 'Normal'),
				'type' => 'typography',
				'options' => $typography_options,
				);

			/* ========================================================================================================================

			Widgets Style Options

			======================================================================================================================== */

			$options[] = array(
					'name' => 'Sidebar Widgets Style',
					'icon_name' => $imagepathinc . 'sub.png',
					'class' => 'sub_heading',
					'type' => 'heading');

			$options[] = array(
				'name' => 'Widget Title Typography',
				'id' => 'widget_title_typography',
				'std' => array('size' => '22px', 'face' => 'sourceSans', 'style' => 'Normal', 'color' => '#2a2a2a', 'weight' => 'Normal'),
				'type' => 'typography',
				'options' => $typography_options,
				 );

			$options[] = array(
				'name' => 'Widget Text Typography',
				'id' => 'widget_text_typography',
				'std' => array('size' => '14px', 'face' => 'sourceSans', 'style' => 'Normal', 'color' => '#5a5a5a', 'weight' => 'Normal'),
				'type' => 'typography',
				'options' => $typography_options,
				);


			/* ========================================================================================================================

			Sitemap Page Style Options

			======================================================================================================================== */

			$options[] = array(
					'name' => 'SiteMap Page ',
					'icon_name' => $imagepathinc . 'sub.png',
					'class' => 'sub_heading',
					'type' => 'heading');

			$options[] = array(
					'name' => 'SiteMap Title Style',
					'desc' => '',
					'id' => 'sitemap_title',
					'std' => array('size' => '28px', 'face' => 'SourceSansSemiBold', 'style' => 'Normal', 'color' => '#333333', 'weight' => 'Normal'),
					'type' => 'typography',
					'options' => $typography_options,
					);

			$options[] = array(
					'name' => 'SiteMap Text',
					'id' => 'sitemap_text',
					'std' => array('size' => '18px', 'face' => 'SourceSansSemiBold', 'style' => 'Normal', 'color' => '#ffffff', 'weight' => 'Normal'),
					'type' => 'typography',
					'options' => $typography_options,
					);
					
			/* ========================================================================================================================

			Layout & Background

			======================================================================================================================== */
			$options[] = array(
						'name' => __('Layout & Background', 'options_framework_theme'),
						'icon_name' => $imagepathinc . 'sub.png',
						'class' => 'sub_heading',
						'type' => 'heading');
						
			$options[] = array(
					'name' => 'Boxed Layout',
					'desc' => 'To enable the boxed layout, mark this option',
					'id' => 'boxedlayout',
					'class' => 'mini',
					'std' => '',
					'type' => 'checkbox');
			
			$options[] = array(
				'name' => 'Page background color',
				'desc' => 'Applied to body',
				'id' => 'body_color',
				'std' => '#fff',
				'type' => 'color');

			$options[] = array(
				'name' => __('Upload page background', 'options_framework_theme'),
				'desc' => __('Upload page background , including patterns, wide images or select one of the patterns below. ', 'options_framework_theme'),
				'id' => 'custom_pattern',
				'std' => '',
				'type' => 'upload');
				
			$options[] = array(
				'name' => __("Background pattern", 'options_framework_theme'),
				'desc' => __("For all pages of the website", 'options_framework_theme'),
				'id' => "featured_pattern",
				'std' => "",
				'class' => "sidebarPosition featuredPatterns",
				'type' => "images",
				'options' => array(
					'p1' => $imagepath . 'patterns/p1.png',
					'p2' => $imagepath . 'patterns/p2.png',
					'p3' => $imagepath . 'patterns/p3.png',
					'p4' => $imagepath . 'patterns/p4.png',
					'p5' => $imagepath . 'patterns/p5.png',
					));
			
			$options[] = array(
				'name' => 'Background type',
				'desc' => 'To enable background patterns, mark this option',
				'id' => 'pattern_check',
				'class' => 'mini',
				'std' => '1',
				'type' => 'checkbox');
			
			
/* ========================================================================================================================
			
			RTL Style Settings Tab
			
			======================================================================================================================== */

			$options[] = array(
					'name' => 'RTL Style Settings',
					'icon_name' => $imagepathinc . 'style.png',
					'type' => 'heading');
			/* ========================================================================================================================

			Style Settings Tab

			======================================================================================================================== */
			$options[] = array(
						'name' => 'RTL General Style',
						'icon_name' => $imagepathinc . 'sub.png',
						'class' => 'sub_heading',
						'type' => 'heading');
			
			$options[] = array(
						'name' => 'Template Color',
						'desc' => 'Select the template color you want',
						'id' => 'rtl_template_color',
						'type' => 'select',
						'std' => 'red',
						'options' => array(
										'red' => 'Red (Default)',
										'light_red'=> 'Light Red',
										'blue' => 'Blue',
										'green'=> 'Green',
										'purple'=> 'Purple',
										'dark_blue'=> 'Dark Blue',
										'orange'=> 'Orange',
										'pink'=> 'Pink',
										'grey'=> 'Grey',
										'yellow'=> 'Yellow',
										'brown'=> 'Brown',
										'custom'=> 'Custom'));
				$options[] = array(
					'name' => 'Contact info',
					'desc' => 'Write a brief for your contact info to appear in the header',
					'id' => 'rtl_header_contact_settings',
					'std' => 'test',
					'type' => "text");
				
				$options[] = array(
					'name' => 'Contact Link',
					'desc' => 'where do you want to link your contact text',
					'id' => 'rtl_header_contact_link_settings',
                                        'std' =>'',
					'type' => "text");
								
										
			$options[] = array(
					'name' => 'Logo Builder',
					'desc' => 'Preferred Logo Size is 194px X 90px ',
					'id' => 'rtl_theme_logo',
					'std' => '',
					'class' => 'theme_logo',
					'type' => 'upload');

			$options[] = array(
				'name' => 'Colored Elements Color (Theme Color)',
				'desc' => 'Applied to Tabs, tags hover,etc ',
				'id' => 'rtl_color_elements',
				'std' => '#e32831',
				'type' => 'color');

			$options[] = array(
				'name' => 'Colored Elements Color (Darker Color)',
				'desc' => 'This color is usually darker than theme color.',
				'id' => 'rtl_color_elements_dark',
				'std' => '#b92424',
				'type' => 'color');

			$options[] = array(
				'name' => 'H1 Font, size and color',
				'id' => "rtl_h1",
				'std' => array('size' => '24px', 'face' => 'sourceSans', 'style' => 'Normal', 'color' => '#2a2a2a', 'weight' => 'Normal'),
				'type' => 'typography',
				'options' => $typography_options,
				);

			$options[] = array(
				'name' => 'H2 Font, size and color',
				'id' => "rtl_h2",
				'std' => array('size' => '22px', 'face' => 'sourceSans', 'style' => 'Normal', 'color' => '#2a2a2a', 'weight' => 'Normal'),
				'type' => 'typography',
				'options' => $typography_options,
				);

			$options[] = array(
				'name' => 'H3 Font, size and color',
				'id' => "rtl_h3",
				'std' => array('size' => '20px', 'face' => 'sourceSans', 'style' => 'Normal', 'color' => '#2a2a2a', 'weight' => 'Normal'),
				'type' => 'typography',
				'options' => $typography_options,
				);

			$options[] = array(
				'name' => 'H4 Font, size and color',
				'id' => "rtl_h4",
				'std' => array('size' => '18px', 'face' => 'sourceSans', 'style' => 'Normal', 'color' => '#2a2a2a', 'weight' => 'Normal'),
				'type' => 'typography',
				'options' => $typography_options,
				);

			$options[] = array(
				'name' => 'H5 Font, size and color',
				'id' => "rtl_h5",
				'std' => array('size' => '16px', 'face' => 'sourceSans', 'style' => 'Normal', 'color' => '#2a2a2a', 'weight' => 'Normal'),
				'type' => 'typography',
				'options' => $typography_options,
				);

			$options[] = array(
				'name' => 'H6 Font, size and color',
				'id' => "rtl_h6",
				'std' => array('size' => '14px', 'face' => 'sourceSans', 'style' => 'Normal', 'color' => '#2a2a2a', 'weight' => 'Normal'),
				'type' => 'typography',
				'options' => $typography_options,
				);

			$options[] = array(
				'name' => 'Paragraphs',
				'desc' => 'Custom typography options.',
				'id' => "rtl_paragraphs",
				'std' => array('size' => '13px', 'face' => 'sourceSans', 'style' => 'Normal', 'color' => '#5a5a5a', 'weight' => 'Normal'),
				'type' => 'typography',
				'options' => $typography_options,
				);

			/* ========================================================================================================================

			Header Style Options

			======================================================================================================================== */

			$options[] = array(
					'name' => 'RTL Header Style',
					'icon_name' => $imagepathinc . 'sub.png',
					'class' => 'sub_heading',
					'type' => 'heading');

			$options[] = array(
				'name' => 'Menu Typography',
				'id' => 'rtl_header_menu_typography',
				'std' => array('size' => '15px', 'face' => 'museo_slab500', 'style' => 'Normal', 'color' => '#5a5a5a', 'weight' => 'Normal'),
				'type' => 'typography',
				'options' => $typography_options,
				);

			$options[] = array(
				'name' => 'Breaking Title',
				'id' => 'rtl_header_breaking_title_typography',
				'std' => array('size' => '17px', 'face' => 'museo_slab500', 'style' => 'Normal', 'color' => '#ffffff', 'weight' => 'Normal'),
				'type' => 'typography',
				'options' => $typography_options,
				);

			$options[] = array(
				'name' => 'Breaking Text',
				'id' => 'rtl_header_breaking_text_typography',
				'std' => array('size' => '12px', 'face' => 'OpenSansRegular', 'style' => 'Normal', 'color' => '#ffffff', 'weight' => 'Normal'),
				'type' => 'typography',
				'options' => $typography_options,
				);


			/*========================================================================================================================

			Footer Style Options

			======================================================================================================================== */

			$options[] = array(
					'name' => 'RTL Footer Widgets Style',
					'icon_name' => $imagepathinc . 'sub.png',
					'class' => 'sub_heading',
					'type' => 'heading'
					);

			$options[] = array(
				'name' => 'Footer Title Typography',
				'id' => 'rtl_footer_title_style',
				'std' => array('size' => '16px', 'face' => 'OpenSansBold', 'style' => 'Normal', 'color' => '#ffffff', 'weight' => 'Normal'),
				'type' => 'typography',
				'options' => $typography_options,
				);
				
			$options[] = array(
				'name' => 'Footer Text Typography',
				'id' => 'rtl_footer_text_style',
				'std' => array('size' => '16px', 'face' => 'OpenSansBold', 'style' => 'Normal', 'color' => '#ffffff', 'weight' => 'Normal'),
				'type' => 'typography',
				'options' => $typography_options,
				);

			/* ========================================================================================================================

			Widgets Style Options

			======================================================================================================================== */

			$options[] = array(
					'name' => 'RTL Sidebar Widgets Style',
					'icon_name' => $imagepathinc . 'sub.png',
					'class' => 'sub_heading',
					'type' => 'heading');

			$options[] = array(
				'name' => 'Widget Title Typography',
				'id' => 'rtl_widget_title_typography',
				'std' => array('size' => '14px', 'face' => 'sourceSans', 'style' => 'Normal', 'color' => '#2a2a2a', 'weight' => 'Normal'),
				'type' => 'typography',
				'options' => $typography_options,
				 );

			$options[] = array(
				'name' => 'Widget Text Typography',
				'id' => 'rtl_widget_text_typography',
				'std' => array('size' => '12px', 'face' => 'sourceSans', 'style' => 'Normal', 'color' => '#5a5a5a', 'weight' => 'Normal'),
				'type' => 'typography',
				'options' => $typography_options,
				);


			/* ========================================================================================================================

			Sitemap Page Style Options

			======================================================================================================================== */

			$options[] = array(
					'name' => 'RTL SiteMap Page ',
					'icon_name' => $imagepathinc . 'sub.png',
					'class' => 'sub_heading',
					'type' => 'heading');

			$options[] = array(
					'name' => 'SiteMap Title Style',
					'desc' => '',
					'id' => 'rtl_sitemap_title',
					'std' => array('size' => '40px', 'face' => 'OpenSansExtrabold', 'style' => 'Normal', 'color' => '#333333', 'weight' => 'Normal'),
					'type' => 'typography',
					'options' => $typography_options,
					);

			$options[] = array(
					'name' => 'SiteMap Text',
					'id' => 'rtl_sitemap_text',
					'std' => array('size' => '26px', 'face' => 'OpenSansExtrabold', 'style' => 'Normal', 'color' => '#ffffff', 'weight' => 'Normal'),
					'type' => 'typography',
					'options' => $typography_options,
					);
/* ========================================================================================================================

Sidebars Tab

======================================================================================================================== */

	$options[] = array(
			'name' => 'Sidebars',
			'icon_name' => $imagepathinc . 'sidebars.png',
			'type' => 'heading'
			);

	$options[] = array(
			'name' => 'Custom Sidebars',
			'desc' => 'Add/Remove any sidebar and click Save Changes to take effect.',
			'std'=> '',
			'id' => 'sidebars',
			'type' => 'cust_sidebars'
	);

/* ========================================================================================================================

Fonts Tab

======================================================================================================================== */

	$options[] = array(
			'name' => 'Page Builder Fonts',
			'icon_name' => $imagepathinc . 'sidebars.png',
			'type' => 'heading'
			);

	$options[] = array(
			'name' => 'Custom Fonts',
			'desc' => 'Add/Remove any font and click Save Changes to take effect.',
			'std'  => '',
			'id'   => 'cust_font',
			'type' => 'cust_font'
	);
/* ========================================================================================================================

WooCommerce Tab

======================================================================================================================== */
	$options[] = array(
		'name'		 => 'WooCommerce settings',
		'icon_name'	 => $imagepathinc . 'pages.png',
		'type'		 => 'heading',
	);

	$options[] = array(
		'name'	 =>  'do you want a masonry shop?',
		'desc'	 => 'check to enable masonry shop',
		'id'	 => 'woocommerce_masonry',
		'class'	 => 'mini',
		'std'	 => '0',
		'type'	 => 'checkbox'
	);

	$options[] = array(
		'name'	 =>  'Enable sidebar in shop page',
		'id'	 => 'woocommerce_shop_sidebar',
		'class'	 => 'mini',
		'std'	 => '1',
		'type'	 => 'checkbox'
	);

	$options[] = array(
		'name'	 =>  'Enable sidebar in product page',
		'id'	 => 'woocommerce_product_sidebar',
		'class'	 => 'mini',
		'std'	 => '0',
		'type'	 => 'checkbox'
	);

	/* ========================================================================================================================

Maintainance Tab

======================================================================================================================== */
			$options[] = array(
				'name' => 'Maintainance Page',
				'icon_name' => $imagepathinc . 'contact.png',
				'type' => 'heading'
			);
			$options[] = array(
					'name' => 'Maintainance Logo Uploader',
					'desc' => 'Upload your Maintainance Logo here',
					'id' => 'maintainance_logo',
					'std' => '',
					'type' => 'upload'
			);
			$options[] = array(
					'name' => 'Maintainance Background Uploader',
					'desc' => 'Upload your Maintainance Background here',
					'id' => 'maintainance_background',
					'std' => '',
					'type' => 'upload'
			);
			$options[] = array(
				'name' => 'Maintainance Page Title',
				'desc' => 'Enter the title of the maintanance page',
				'std'=> 'Our Website is Almost Ready',
				'id' => 'maintainance_page_title',
				'type' => 'text'
			);
			$options[] = array(
				'name' => 'Maintainance Page Count Down Title',
				'desc' => 'Enter the title of the Count Down',
				'std'=> 'Time left till Launch',
				'id' => 'maintainance_page_countdown_title',
				'type' => 'text'
			);
			$options[] = array(
				'name' => 'Maintainance Page Facebook Link',
				'desc' => 'Enter the link of the facebook page',
				'std'=> 'http://www.facebook.com',
				'id' => 'maintainance_page_facebook_link',
				'type' => 'text'
			);
			$options[] = array(
				'name' => 'Maintainance Page Twitter Link',
				'desc' => 'Enter the link of the Twitter page',
				'std'=> 'http://www.twitter.com',
				'id' => 'maintainance_page_twitter_link',
				'type' => 'text'
			);
			$options[] = array(
				'name' => 'Maintainance Page LinkedIn Link',
				'desc' => 'Enter the link of the LinkedIn page',
				'std'=> 'http://www.linkedin.com',
				'id' => 'maintainance_page_linkedin_link',
				'type' => 'text'
			);
			$options[] = array(
				'name' => 'Maintainance Page Google Plus Link',
				'desc' => 'Enter the link of the Google Plus page',
				'std'=> 'http://www.plus.google.com',
				'id' => 'maintainance_page_google_link',
				'type' => 'text'
			);
			$options[] = array(
				'name' => 'Maintainance Page Youtube Link',
				'desc' => 'Enter the link of the Youtube page',
				'std'=> 'http://www.youtube.com',
				'id' => 'maintainance_page_youtube_link',
				'type' => 'text'
			);
			$options[] = array(
				'name' => 'Maintainance Page Dribbble Link',
				'desc' => 'Enter the link of the Dribbble page',
				'std'=> 'http://www.dribbble.com',
				'id' => 'maintainance_page_dribbble_link',
				'type' => 'text'
			);

			$options[] = array(
				'name' => 'Maintainance Page Forrst Link',
				'desc' => 'Enter the link of the Forrst page',
				'std'=> 'http://www.forrst.com',
				'id' => 'maintainance_page_forrst_link',
				'type' => 'text'
			);
			$options[] = array(
				'name' => 'Maintainance Page Behance Link',
				'desc' => 'Enter the link of the Behance page',
				'std'=> 'http://www.behance.com',
				'id' => 'maintainance_page_behance_link',
				'type' => 'text'
			);
			$options[] = array(
				'name' => 'Maintainance Page Picasa Link',
				'desc' => 'Enter the link of the Picasa page',
				'std'=> 'http://www.picasa.com',
				'id' => 'maintainance_page_picasa_link',
				'type' => 'text'
			);
			$options[] = array(
				'name' => 'Maintainance Page Pinterest Link',
				'desc' => 'Enter the link of the Pinterest page',
				'std'=> 'http://www.pinterest.com',
				'id' => 'maintainance_page_pinterest_link',
				'type' => 'text'
			);
			$options[] = array(
				'name' => 'Maintainance Page Flickr Link',
				'desc' => 'Enter the link of the Flickr page',
				'std'=> 'http://www.flickr.com',
				'id' => 'maintainance_page_flickr_link',
				'type' => 'text'
			);

			$options[] = array(
				'name' => 'Maintainance Page Know More Text',
				'desc' => 'Enter the text of the Know More',
				'std'=> '+ Know More',
				'id' => 'maintainance_page_knowmore',
				'type' => 'text'
			);

			$options[] = array(
				'name' => 'Maintainance Page Know More Title',
				'desc' => 'Enter the Title of the Know More Page',
				'std'=> 'About CircleFlip',
				'id' => 'maintainance_page_knowmore_title',
				'type' => 'text'
			);

			$options[] = array(
				'name' => 'Maintainance Page Know More Paragraph',
				'desc' => 'Enter the Paragraph of the Know More Page',
				'std'=> 'Quisque sagittis turpis leo, id tempus elit ullamcorper vitae. Suspendisse iaculis dui a enim fringilla condimentum. Cras id euismod ligula. Aenean hendrerit commodo velit at pulvinar. Praesent vestibulum quam sed pretium placerat. Aenean porttitor a turpis nec dapibus. Pellentesque sodales commodo nibh, id tincidunt magna consectetur venenatis. Curabitur tempor, tellus eu scelerisque dignissim, mauris libero venenatis metus, vitae tincidunt diam lectus quis justo. Vivamus eget massa faucibus, fringilla nisl vel, gravida ipsum. Nunc pharetra sodales urna, sit amet rhoncus sapien malesuada quis. Maecenas augue turpis, luctus sed purus a, lobortis eleifend sapien.',
				'id' => 'maintainance_page_knowmore_paragraph',
				'type' => 'text'
			);

			$options[] = array(
				'name' => 'Maintainance Page Know More Mail',
				'desc' => 'Enter the Mail of the Know More Page',
				'std'=> 'Support@creiden.com',
				'id' => 'maintainance_page_knowmore_mail',
				'type' => 'text'
			);
			$options[] = array(
				'name' => 'Maintainance Page Know More Phone',
				'desc' => 'Enter the Phone of the Know More Page',
				'std'=> '+ 00 123 456 789 0',
				'id' => 'maintainance_page_knowmore_phone',
				'type' => 'text'
			);
			$options[] = array(
				'name' => 'Maintainance Page Know More Fax',
				'desc' => 'Enter the Fax of the Know More Page',
				'std'=> '+ 00 123 456 789 0',
				'id' => 'maintainance_page_knowmore_fax',
				'type' => 'text'
			);
/* ========================================================================================================================

Backup & Restore Tab

======================================================================================================================== */

	$options[] = array(
			'name' => 'Backup & Restore',
			'icon_name' => $imagepathinc . 'importexport.png',
			'type' => 'heading'
	);
	$backup = get_option('rojo_backups', array());
	$backup_log = isset($backup['backup_log']) ? $backup['backup_log'] : 'no backup available';
	$options[] = array(
			'id' => 'backup-options',
			'text' => 'Backup',
			'desc' => "<p id='backup_log'>" . $backup_log . "</p>",
			'type' => 'button'
	);

	$options[] = array(
			'id' => 'restore-options',
			'text' => 'Restore',
			'type' => 'button'
	);

	$options[] = array(
			'name' => 'Export Options',
			'id' => 'export_data',
			'type' => 'export-options'
	);
	$options[] = array(
			'name' => 'Import Options',
			'id' => 'import_data',
			'type' => 'import_options'
	);
	return apply_filters('circleflip_theme_options', $options);
}

/* ========================================================================================================================

End of Options

======================================================================================================================== */


add_action( 'admin_enqueue_scripts', 'circleflip_of_static_pagebuilder' );

function circleflip_of_static_pagebuilder($screen_hook) {
	if(!preg_match('/^(appearance_page_options-framework|post\.php|post-new\.php)$/', $screen_hook)) return;
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}
	$categoriesHTML ='';
	foreach ($options_categories as $catID => $catName) {
		$categoriesHTML .= '<option value="' . $catID . '">' . $catName .'</option>' ;
	}
	$postsHTML='';
	$allPosts = get_posts(array('numberposts'=>-1));
	$postNames = array();
	foreach ($allPosts as $key => $post) {
		$postNames[$post->ID]= $post->post_title . " on " . date("F j, Y g:i a",strtotime($post->post_date)). " by " . (get_user_by('id', $post->post_author)->display_name) ;
	}
	foreach ($postNames as $postID => $value) {
		$postsHTML.= '<option value="' . $postID . '">' . $value .'</option>' ;
	}
	wp_reset_postdata();

	$args = array(
			'post_type' => 'ml-slider',
			'post_status' => 'publish',
			'orderby' => 'date',
			'order' => 'ASC',
			'posts_per_page' => -1
	);
	$get_sliders = get_posts($args);
	foreach ($get_sliders as $key => $post) {
		$sliders[$post->ID] = $post->post_title;
	}
	if(!isset($sliders)) {
		$sliders = array();
	}
	array_key_exists(0, $sliders) ? $sliders[$post->ID + 1] = 'ultimate' : $sliders['ultimate'] = 'ultimate' ;
	array_key_exists(1, $sliders) ? $sliders[$post->ID + 2] = 'posts' : $sliders['posts'] = 'posts' ;
	array_key_exists(2, $sliders) ? $sliders[$post->ID + 3] = '3D Slider' : $sliders['3D'] = '3D Slider' ;
	array_key_exists(3, $sliders) ? $sliders[$post->ID + 4] = 'Elastic Slider' : $sliders['Elastic'] = 'Elastic Slider' ;
	$slidersHTML='';
	foreach ($sliders as $id => $value) {
		$slidersHTML.= '<option value="' . $id . '">' . $value .'</option>' ;
	}
	$carousel_posts_area =	'';

	$home_slider =	'';

	$vertical_posts_area =	'';

	$twitter_area =	'';

	$tabbed_categories_area = '';

	$selected_categories_area =	'';

	$masonry_layout_builder = '';

	$advertisementArea = '';

	$dividerArea = '';
	// wp_register_script( 'uniform', OPTIONS_FRAMEWORK_DIRECTORY . 'js/uniform.min.js', array( 'jquery') );
	// wp_enqueue_script( 'uniform' );
	// Enqueue custom option panel JS
	wp_enqueue_script( 'options-custom', OPTIONS_FRAMEWORK_DIRECTORY . 'js/options-custom.js', array( 'jquery','wp-color-picker' ) );
		wp_enqueue_style( 'meta_style', OPTIONS_FRAMEWORK_DIRECTORY . 'css/meta.css');
		wp_enqueue_style( 'fontello', get_template_directory_uri() . '/css/fonts/fonts.css');
	wp_localize_script('options-custom', 'creiden_admin',array(
	'carousel_posts_area' => $carousel_posts_area,
	'home_slider' => $home_slider,
	'vertical_posts_area' => $vertical_posts_area,
	'twitter_area' => $twitter_area,
	'tabbed_categories_area' => $tabbed_categories_area,
	'selected_categories_area' => $selected_categories_area,
	'masonary_layout_area' => $masonry_layout_builder,
	'adv_area' => $advertisementArea,
	'divider_area' => $dividerArea,
	'template_directory' => get_template_directory_uri()
	));
}
/*
 * This is an example of how to add custom scripts to the options panel.
* This example shows/hides an option when a checkbox is clicked.
*/

add_action('circleflip_optionsframework_custom_scripts', 'circleflip_optionsframework_custom_scripts');

function circleflip_optionsframework_custom_scripts() {


	?>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		/************************************************/
		$('#tags_count').click(function() {
			$('#section-tags_radio_count').fadeToggle(400);
		});

		if ($('#tags_count:checked').val() !== undefined) {
			$('#section-tags_radio_count').show();
		} else {
			$('#section-tags_radio_count').hide();
		}
		/************************************************/
		$('#category_count').click(function() {
			$('#section-category_radio_count').fadeToggle(400);
		});

		if ($('#category_count:checked').val() !== undefined) {
			$('#section-category_radio_count').show();
		} else {
			$('#section-category_radio_count').hide();
		}
		/************************************************/
		$('#search_count').click(function() {
			$('#section-search_radio_count').fadeToggle(400);
		});

		if ($('#search_count:checked').val() !== undefined) {
			$('#section-search_radio_count').show();
		} else {
			$('#section-search_radio_count').hide();
		}
		/************************************************/
		$('#breaking_area').click(function() {
			$('#section-breaking_title, #section-breaking_content, #section-number_breaking_posts, #section-breaking_selected_category, #section-custome_breaking').fadeToggle(400);
		});
		if ($('#breaking_area:checked').val() !== undefined) {
			$('#section-breaking_title, #section-breaking_content, #section-number_breaking_posts, #section-breaking_selected_category, #section-custome_breaking').show();
		} else {
			$('#section-breaking_title, #section-breaking_content, #section-number_breaking_posts, #section-breaking_selected_category, #section-custome_breaking').hide();
		}
		/************************************************/
		if ($('#rojo-separator_radio-text').is(':checked')) {
			$('#separator_text, #separator_button_text, #separator_button_link').parent().show();
			$('#twitter_username').parent().hide();
		} else if ($('#rojo-separator_radio-twitter').is(':checked')) {
			$('#separator_text, #separator_button_text, #separator_button_link').parent().hide();
			$('#twitter_username').parent().show();
		}

		$('#section-pagebuilder').on('click', '#rojo-separator_radio-twitter', function() {
			$('#separator_text, #separator_button_text, #separator_button_link').parent().hide();
			$('#twitter_username').parent().show();
		})
		$('#section-pagebuilder').on('click', '#rojo-separator_radio-text', function() {
			$('#separator_text, #separator_button_text, #separator_button_link').parent().show();
			$('#twitter_username').parent().hide();
		});

		/************************************************/
		$('.advertisement_area').each(function() {
			if ($(this).find('#rojo-ad_type-image').attr('checked') == 'checked') {
				$(this).find('#ad_script').parent().hide();
				$(this).find('.remove-file').parent().show();
				$(this).find('.upload-button').parent().show();
				$(this).find('#adv_target_url').parent().show();
			} else if ($(this).find('#rojo-ad_type-script').attr('checked') == 'checked') {
				$(this).find('#ad_script').parent().show();
				$(this).find('.remove-file').parent().hide();
				$(this).find('.upload-button').parent().hide();
				$(this).find('#adv_target_url').parent().hide();
			}
		});
		$('#section-pagebuilder').on('click', '#rojo-ad_type-image', function() {
			$(this).parents('.widget-content').find('#ad_script').parent().hide();
			$(this).parents('.widget-content').find('.remove-file').parent().show();
			$(this).parents('.widget-content').find('.upload-button').parent().show();
			$(this).parents('.widget-content').find('#adv_target_url').parent().show();
		})
		$('#section-pagebuilder').on('click', '#rojo-ad_type-script', function() {
			$(this).parents('.widget-content').find('#ad_script').parent().show();
			$(this).parents('.widget-content').find('.remove-file').parent().hide();
			$(this).parents('.widget-content').find('.upload-button').parent().hide();
			$(this).parents('.widget-content').find('#adv_target_url').parent().hide();
		})
		/************************************************/

		if ($('#rojo-post_sidebars_option-meta').is(':checked')) {
			$('#section-post_layout').fadeOut();
			$('#section-post_sidebar').fadeOut();
		} else if ($('#rojo-post_sidebars_option-global').is(':checked')) {
			$('#section-post_layout').fadeIn();
			$('#section-post_sidebar').fadeIn();
		}

		$('#section-post_sidebars_option input').click(function() {
			if ($(this).val() == 'meta') {
				$('#section-post_layout').fadeOut();
				$('#section-post_sidebar').fadeOut();
			} else {
				$('#section-post_layout').fadeIn();
				$('#section-post_sidebar').fadeIn();
			}
		});

		/******************************************************/
	});
    </script>
<?php
}