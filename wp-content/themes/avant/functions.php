<?php
/**
 * Avant functions and definitions
 *
 * @package Avant
 */
define( 'AVANT_THEME_VERSION' , '1.1.21' );

// Include Avant Upgrade page
require get_template_directory() . '/upgrade/upgrade.php';

// Load WP included scripts
require get_template_directory() . '/includes/inc/template-tags.php';
require get_template_directory() . '/includes/inc/extras.php';
require get_template_directory() . '/includes/inc/jetpack.php';

// Load Customizer Library scripts
require get_template_directory() . '/customizer/customizer-options.php';
require get_template_directory() . '/customizer/customizer-library/customizer-library.php';
require get_template_directory() . '/customizer/styles.php';
require get_template_directory() . '/customizer/mods.php';

// Load TGM plugin class
require_once get_template_directory() . '/includes/inc/class-tgm-plugin-activation.php';
// Add customizer Upgrade class
require_once( get_template_directory() . '/includes/avant-pro/class-customize.php' );

if ( ! function_exists( 'avant_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function avant_setup() {

	/**
	 * Set the content width based on the theme's design and stylesheet.
	 */
	global $content_width;
	if ( ! isset( $content_width ) ) {
		$content_width = 900; /* pixels */
	}

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on avant, use a find and replace
	 * to change 'avant' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'avant', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
        'top-bar-menu' => esc_html__( 'Top Bar Menu', 'avant' ),
		'primary' => esc_html__( 'Primary Menu', 'avant' ),
        'footer-bar' => esc_html__( 'Footer Bar Menu', 'avant' )
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	// Gutenberg Support
	add_theme_support( 'align-wide' );
	
	// The custom logo
	add_theme_support( 'custom-logo', array(
		'width'       => 280,
		'height'      => 145,
		'flex-height' => true,
		'flex-width'  => true,
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'avant_custom_background_args', array(
		'default-color' => 'F9F9F9',
	) ) );
	
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	add_theme_support( 'header-footer-elementor' );
}
endif; // avant_setup
add_action( 'after_setup_theme', 'avant_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function avant_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'avant' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar(array(
		'name' => __( 'Avant Footer Standard', 'avant' ),
		'id' => 'avant-site-footer-standard',
        'description' => __( 'The footer will divide into however many widgets are placed here.', 'avant' )
	));
}
add_action( 'widgets_init', 'avant_widgets_init' );

/*
 * Change Widgets Title Tags for SEO
 */
function kaira_change_widget_titles( array $params ) {
	$widget_title_tag = get_theme_mod( 'avant-seo-widget-title-tag', customizer_library_get_default( 'avant-seo-widget-title-tag' ) );
    $widget =& $params[0];
    $widget['before_title'] = '<h'.esc_attr( $widget_title_tag ).' class="widget-title">';
    $widget['after_title'] = '</h'.esc_attr( $widget_title_tag ).'>';
    return $params;
}
add_filter( 'dynamic_sidebar_params', 'kaira_change_widget_titles', 20 );

/**
 * Enqueue scripts and styles.
 */
function avant_scripts() {
	if ( !get_theme_mod( 'avant-disable-google-fonts', customizer_library_get_default( 'avant-disable-google-fonts' ) ) ) {
		if ( !get_theme_mod( 'avant-disable-default-fonts-only', customizer_library_get_default( 'avant-disable-default-fonts-only' ) ) ) {
			wp_enqueue_style( 'avant-title-font', '//fonts.googleapis.com/css?family=Parisienne', array(), AVANT_THEME_VERSION );
			wp_enqueue_style( 'avant-body-font-default', '//fonts.googleapis.com/css?family=Open+Sans', array(), AVANT_THEME_VERSION );
			wp_enqueue_style( 'avant-heading-font-default', 'https://fonts.googleapis.com/css?family=Poppins', array(), AVANT_THEME_VERSION );
		}
	}

	wp_enqueue_style( 'avant-font-awesome', get_template_directory_uri().'/includes/font-awesome/css/all.min.css', array(), '5.9.0' );
	wp_enqueue_style( 'avant-style', get_stylesheet_uri(), array(), AVANT_THEME_VERSION );

	if ( get_theme_mod( 'avant-header-layout' ) == 'avant-header-layout-seven' ) :
		wp_enqueue_style( 'avant-header-style', get_template_directory_uri()."/templates/header/css/header-seven.css", array(), AVANT_THEME_VERSION );
	elseif ( get_theme_mod( 'avant-header-layout' ) == 'avant-header-layout-six' ) :
		wp_enqueue_style( 'avant-header-style', get_template_directory_uri()."/templates/header/css/header-six.css", array(), AVANT_THEME_VERSION );
	elseif ( get_theme_mod( 'avant-header-layout' ) == 'avant-header-layout-five' ) :
		wp_enqueue_style( 'avant-header-style', get_template_directory_uri()."/templates/header/css/header-five.css", array(), AVANT_THEME_VERSION );
	elseif ( get_theme_mod( 'avant-header-layout' ) == 'avant-header-layout-four' ) :
		wp_enqueue_style( 'avant-header-style', get_template_directory_uri()."/templates/header/css/header-four.css", array(), AVANT_THEME_VERSION );
	elseif ( get_theme_mod( 'avant-header-layout' ) == 'avant-header-layout-three' ) :
		wp_enqueue_style( 'avant-header-style', get_template_directory_uri()."/templates/header/css/header-three.css", array(), AVANT_THEME_VERSION );
	elseif ( get_theme_mod( 'avant-header-layout' ) == 'avant-header-layout-two' ) :
		wp_enqueue_style( 'avant-header-style', get_template_directory_uri()."/templates/header/css/header-two.css", array(), AVANT_THEME_VERSION );
	else :
		wp_enqueue_style( 'avant-header-style', get_template_directory_uri()."/templates/header/css/header-one.css", array(), AVANT_THEME_VERSION );
	endif;
	
	if ( avant_is_woocommerce_activated() ) :
		wp_enqueue_style( 'avant-woocommerce-style', get_template_directory_uri()."/includes/css/woocommerce.css", array(), AVANT_THEME_VERSION );
	endif;

	if ( get_theme_mod( 'avant-footer-layout' ) == 'avant-footer-layout-custom' ) :
		wp_enqueue_style( 'avant-footer-style', get_template_directory_uri()."/templates/footer/css/footer-custom.css", array(), AVANT_THEME_VERSION );
	elseif ( get_theme_mod( 'avant-footer-layout' ) == 'avant-footer-layout-social' ) :
		wp_enqueue_style( 'avant-footer-style', get_template_directory_uri()."/templates/footer/css/footer-social.css", array(), AVANT_THEME_VERSION );
	elseif ( get_theme_mod( 'avant-footer-layout' ) == 'avant-footer-layout-none' ) :
		wp_enqueue_style( 'avant-footer-style', get_template_directory_uri()."/templates/footer/css/footer-none.css", array(), AVANT_THEME_VERSION );
	else :
		wp_enqueue_style( 'avant-footer-style', get_template_directory_uri()."/templates/footer/css/footer-standard.css", array(), AVANT_THEME_VERSION );
	endif;
	
	wp_enqueue_script( 'avant-custom-js', get_template_directory_uri() . "/js/custom.js", array('jquery'), AVANT_THEME_VERSION, true );
	
	wp_enqueue_script( 'caroufredsel-js', get_template_directory_uri() . "/js/caroufredsel/jquery.carouFredSel-6.2.1-packed.js", array('jquery'), AVANT_THEME_VERSION, true );
    wp_enqueue_script( 'avant-home-slider', get_template_directory_uri() . '/js/home-slider.js', array('jquery'), AVANT_THEME_VERSION, true );
	
	if ( get_theme_mod( 'avant-blog-layout', customizer_library_get_default( 'avant-blog-layout' ) ) == 'blog-blocks-layout' ) :
		wp_enqueue_script( 'jquery-masonry' );
        wp_enqueue_script( 'avant-masonry-custom', get_template_directory_uri() . '/js/layout-blocks.js', array('jquery'), AVANT_THEME_VERSION, true );
	endif;
	if ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) ) :
		wp_enqueue_script( 'jquery-masonry' );
		wp_enqueue_script( 'avant-jetpack-scroll', get_template_directory_uri() . '/js/jetpack-infinite-scroll.js', array('jquery'), AVANT_THEME_VERSION, true );
	endif;

	wp_enqueue_script( 'avant-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), AVANT_THEME_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'avant_scripts' );

/**
 * To maintain backwards compatibility with older versions of WordPress
 */
function avant_the_custom_logo() {
	if ( function_exists( 'the_custom_logo' ) ) {
		the_custom_logo();
	}
}

/**
 * Add theme stying to the theme content editor
 */
function avant_add_editor_styles() {
    add_editor_style( 'style-theme-editor.css' );
}
add_action( 'admin_init', 'avant_add_editor_styles' );

/**
 * Add pingback to header
 */
function avant_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
	}
}
add_action( 'wp_head', 'avant_pingback_header' );

/**
 * Enqueue admin styling.
 */
function avant_load_admin_script() {
	wp_enqueue_style( 'avant-admin-css', get_template_directory_uri() . '/upgrade/css/admin-css.css', array(), AVANT_THEME_VERSION );
	wp_enqueue_script( 'avant-admin-js', get_template_directory_uri() . "/upgrade/js/admin.js", array( 'jquery' ), AVANT_THEME_VERSION, true );
}
add_action( 'admin_enqueue_scripts', 'avant_load_admin_script' );

/**
 * Enqueue avant custom customizer styling.
 */
function avant_load_customizer_script() {
	wp_enqueue_script( 'avant-customizer-js', get_template_directory_uri() . "/customizer/customizer-library/js/customizer-custom.js", array('jquery'), AVANT_THEME_VERSION, true );
    wp_enqueue_style( 'avant-customizer-css', get_template_directory_uri() . "/customizer/customizer-library/css/customizer.css", array(), AVANT_THEME_VERSION );
}
add_action( 'customize_controls_enqueue_scripts', 'avant_load_customizer_script' );

/**
 * Check if WooCommerce exists.
 */
if ( ! function_exists( 'avant_is_woocommerce_activated' ) ) :
	function avant_is_woocommerce_activated() {
	    if ( class_exists( 'woocommerce' ) ) { return true; } else { return false; }
	}
endif; // avant_is_woocommerce_activated

// If WooCommerce exists include ajax cart
if ( avant_is_woocommerce_activated() ) {
	require get_template_directory() . '/includes/inc/woocommerce-header-inc.php';
}

/**
 * Add classed to the body tag from settings
 */
function avant_add_body_class( $classes ) {
	if ( get_theme_mod( 'avant-page-remove-titlebar' ) ) {
		$classes[] = 'avant-shop-remove-titlebar';
	}
	if ( get_theme_mod( 'avant-remove-wc-page-titles' ) ) {
		$classes[] = 'avant-onlyshop-remove-titlebar';
	}
	
	if ( get_theme_mod( 'avant-remove-blog-title' ) ) {
		$classes[] = 'avant-blog-remove-titlebar';
	}

	return $classes;
}
add_filter( 'body_class', 'avant_add_body_class' );

/**
 * Add classes to the blog list for styling.
 */
function avant_add_blog_post_classes ( $classes ) {
	global $current_class;

	if ( is_home() || is_archive() || is_search() ) :
		$avant_blog_layout = sanitize_html_class( customizer_library_get_default( 'avant-blog-layout' ) );
		if ( get_theme_mod( 'avant-blog-layout' ) ) :
		    $avant_blog_layout = sanitize_html_class( get_theme_mod( 'avant-blog-layout' ) );
		endif;
		$classes[] = $avant_blog_layout;

		$avant_blog_style = sanitize_html_class( 'blog-style-postblock' );
		if ( get_theme_mod( 'avant-blog-layout' ) == 'blog-blocks-layout' ) :
			if ( get_theme_mod( 'avant-blog-blocks-style' ) ) :
			    $avant_blog_style = sanitize_html_class( get_theme_mod( 'avant-blog-blocks-style' ) );
			endif;
		endif;
		$classes[] = $avant_blog_style;

		$avant_blog_img = sanitize_html_class( 'blog-post-noimg' );
		if ( has_post_thumbnail() ) :
		    $avant_blog_img = sanitize_html_class( 'blog-post-hasimg' );
		endif;
		$classes[] = $avant_blog_img;

		$classes[] = $current_class;
		$current_class = ( $current_class == 'blog-alt-odd' ) ? sanitize_html_class( 'blog-alt-even' ) : sanitize_html_class( 'blog-alt-odd' );
	endif;

	return $classes;
}
global $current_class;
$current_class = 'blog-alt-odd';
add_filter ( 'post_class' , 'avant_add_blog_post_classes' );

/**
 * Adjust is_home query if avant-blog-cats is set
 */
function avant_set_blog_queries( $query ) {
    $blog_query_set = '';
    if ( get_theme_mod( 'avant-blog-cats' ) ) {
        $blog_query_set = get_theme_mod( 'avant-blog-cats' );
    }

    if ( $blog_query_set ) {
        // do not alter the query on wp-admin pages and only alter it if it's the main query
        if ( !is_admin() && $query->is_main_query() ){
            if ( is_home() ){
                $query->set( 'cat', $blog_query_set );
            }
        }
    }
}
add_action( 'pre_get_posts', 'avant_set_blog_queries' );

/**
 * Display recommended plugins with the TGM class
 */
function avant_register_required_plugins() {
	$plugins = array(
		// The recommended WordPress.org plugins.
		array(
			'name'      => __( 'WooCommerce', 'avant' ),
			'slug'      => 'woocommerce',
			'required'  => false,
		),
		array(
			'name'      => __( 'Elementor Page Builder', 'avant' ),
			'slug'      => 'elementor',
			'required'  => false,
			'external_url' => 'https://kairaweb.com/go/elementor/'
		),
		array(
			'name'      => __( 'Contact Form by WPForms', 'avant' ),
			'slug'      => 'wpforms-lite',
			'required'  => false,
		),
		array(
			'name'      => __( 'Breadcrumb NavXT', 'avant' ),
			'slug'      => 'breadcrumb-navxt',
			'required'  => false,
		),
		array(
			'name'      => __( 'Meta Slider', 'avant' ),
			'slug'      => 'ml-slider',
			'required'  => false,
		)
	);
	$config = array(
		'id'           => 'avant',
		'menu'         => 'tgmpa-install-plugins',
	);

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'avant_register_required_plugins' );

/**
 * Add classes to the admin body class
 */
function avant_add_admin_body_class() {
	$avant_admin_class = '';

	if ( get_theme_mod( 'avant-footer-layout' ) ) {
		$avant_admin_class = sanitize_html_class( get_theme_mod( 'avant-footer-layout' ) );
	} else {
		$avant_admin_class = sanitize_html_class( 'avant-footer-layout-standard' );
	}
	return $avant_admin_class;
}
add_filter( 'admin_body_class', 'avant_add_admin_body_class' );

/**
 * Function to remove Category pre-title text
 */
function avant_cat_title_remove_pretext( $avant_cat_title ) {
	if ( is_category() ) {
        $avant_cat_title = single_cat_title( '', false );
    } elseif ( is_post_type_archive() ) {
		$avant_cat_title = post_type_archive_title( '', false );
    } elseif ( is_tag() ) {
        $avant_cat_title = single_tag_title( '', false );
    } elseif ( is_author() ) {
        $avant_cat_title = '<span class="vcard">' . get_the_author() . '</span>' ;
    }
    return $avant_cat_title;
}
if ( get_theme_mod( 'avant-remove-cat-pre-title' ) ) :
	add_filter( 'get_the_archive_title', 'avant_cat_title_remove_pretext' );
endif;

/**
 * Register a custom Post Categories ID column
 */
function avant_edit_cat_columns( $avant_cat_columns ) {
    $avant_cat_in = array( 'cat_id' => 'Category ID <span class="cat_id_note">For the Default Slider</span>' );
    $avant_cat_columns = avant_cat_columns_array_push_after( $avant_cat_columns, $avant_cat_in, 0 );
    return $avant_cat_columns;
}
add_filter( 'manage_edit-category_columns', 'avant_edit_cat_columns' );

/**
 * Print the ID column
 */
function avant_cat_custom_columns( $value, $name, $cat_id ) {
    if( 'cat_id' == $name )
        echo $cat_id;
}
add_filter( 'manage_category_custom_column', 'avant_cat_custom_columns', 10, 3 );

/**
 * Insert an element at the beggining of the array
 */
function avant_cat_columns_array_push_after( $src, $avant_cat_in, $pos ) {
    if ( is_int( $pos ) ) {
        $R = array_merge( array_slice( $src, 0, $pos + 1 ), $avant_cat_in, array_slice( $src, $pos + 1 ) );
    } else {
        foreach ( $src as $k => $v ) {
            $R[$k] = $v;
            if ( $k == $pos )
                $R = array_merge( $R, $avant_cat_in );
        }
    }
    return $R;
}

/**
 * Adjust the Recent Posts widget query if avant-slider-cats is set
 */
function avant_filter_recent_posts_widget_parameters( $params ) {
	$slider_categories = get_theme_mod( 'avant-slider-cats' );
    $slider_type 	   = get_theme_mod( 'avant-slider-type', customizer_library_get_default( 'avant-slider-type' ) );
	
	if ( $slider_categories && $slider_type == 'avant-slider-default' ) {
		if ( !empty( $slider_categories ) ) { // if ( count( $slider_categories ) > 0 ) {
			// do not alter the query on wp-admin pages and only alter it if it's the main query
			$params['category__not_in'] = $slider_categories;
		}
	}
	
	return $params;
}
add_filter( 'widget_posts_args', 'avant_filter_recent_posts_widget_parameters' );

/**
 * Adjust the widget categories query if avant-slider-cats is set
 */
function avant_set_widget_categories_args($args){
	$slider_categories = get_theme_mod( 'avant-slider-cats' );
    $slider_type 	   = get_theme_mod( 'avant-slider-type', customizer_library_get_default( 'avant-slider-type' ) );
	
	if ( $slider_categories && $slider_type == 'avant-slider-default' ) {
		//if ( count($slider_categories) > 0) {
			//$exclude = implode(',', $slider_categories);
			$args['exclude'] = $slider_categories;
		//}
	}
	
	return $args;
}
add_filter( 'widget_categories_args', 'avant_set_widget_categories_args' );

function avant_set_widget_categories_dropdown_arg($args){
	$slider_categories = get_theme_mod( 'avant-slider-cats' );
    $slider_type 	   = get_theme_mod( 'avant-slider-type', customizer_library_get_default( 'avant-slider-type' ) );
	
	if ( $slider_categories && $slider_type == 'avant-slider-default' ) {
		// if ( count($slider_categories) > 0) {
			// $exclude = implode(',', $slider_categories);
			$args['exclude'] = $slider_categories;
		// }
	}
	
	return $args;
}
add_filter( 'widget_categories_dropdown_args', 'avant_set_widget_categories_dropdown_arg' );

/**
 * Admin notice to enter a purchase license
 */
function avant_add_license_notice() {
	global $current_user;
	$avant_user_id = $current_user->ID;

	if ( !get_user_meta( $avant_user_id, 'avant_flash_notice_ignore' ) ) : ?>
		<div class="notice notice-info avant-admin-notice avant-notice-add">
			<h4>
				<?php esc_html_e( 'Thank you for trying out Avant!', 'avant' ); ?> -
				<span>
					<?php
					/* translators: %s: 'Recommended Resources' */
					printf( esc_html__( 'Premium is currently on a %1$s for only $17', 'avant' ), wp_kses( __( '<a href="https://kairaweb.com/go/notice-purchase/" target="_blank">flash sale</a>', 'avant' ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ) );
					?>
				</span>
			</h4>
			<p><?php esc_html_e( 'We\'re here to help... Please read through our help notes below on getting started with Avant:', 'avant' ); ?></p>
			<div class="avant-admin-notice-blocks">
				<div class="avant-admin-notice-block">
					<h5><?php esc_html_e( 'About Avant:', 'avant' ); ?></h5>
					<p>
						<?php esc_html_e( 'Avant is a widely used and loved WordPress theme which gives you 7 header layouts, multiple blog and footer layouts, and lots of customization settings... so you can easily change the look of your site any time.', 'avant' ); ?>
					</p>
					<p>
						<?php
						/* translators: %s: 'Recommended Resources' */
						printf( esc_html__( 'Read through our %1$s and %2$s and we\'ll help you build a professional website easily.', 'avant' ), wp_kses( __( '<a href="https://kairaweb.com/go/recommended-resources/" target="_blank">Recommended Resources</a>', 'avant' ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ), wp_kses( __( '<a href="https://kairaweb.com/documentation/" target="_blank">Kaira Documentation</a>', 'avant' ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ) );
						?>
					</p>
					<a href="<?php echo esc_url( admin_url( 'themes.php?page=avant_theme_info' ) ) ?>" class="avant-admin-notice-btn">
						<?php esc_html_e( 'Read More About Avant', 'avant' ); ?>
					</a>
				</div>
				<div class="avant-admin-notice-block">
					<h5><?php esc_html_e( 'Using Avant:', 'avant' ); ?></h5>
					<p>
						<?php
						/* translators: %s: 'set up your site in WordPress' */
						printf( esc_html__( 'See our recommended %1$s and how to get ready before you start building your website after you\'ve %2$s.', 'avant' ), wp_kses( __( '<a href="https://kairaweb.com/documentation/our-recommended-wordpress-basic-setup/" target="_blank">WordPress basic setup</a>', 'avant' ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ), wp_kses( __( '<a href="https://kairaweb.com/wordpress-hosting/" target="_blank">setup WordPress Hosting</a>', 'avant' ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ) );
						?>
					</p>
					<a href="<?php echo esc_url( 'https://kairaweb.com/go/recommended-resources/' ) ?>" class="avant-admin-notice-btn-in" target="_blank">
						<?php esc_html_e( 'Recommended Resources', 'avant' ); ?>
					</a>
					<p>
						<?php esc_html_e( 'We\'ve neatly built most of the Avant settings into the WordPress Customizer so you can see all your changes happen as you built your site.', 'avant' ); ?>
					</p>
					<a href="<?php echo esc_url( admin_url( 'customize.php' ) ) ?>" class="avant-admin-notice-btn-grey">
						<?php esc_html_e( 'Start Customizing Your Website', 'avant' ); ?>
					</a>
				</div>
				<div class="avant-admin-notice-block avant-nomargin">
					<h5><?php esc_html_e( 'Popular FAQ\'s:', 'avant' ); ?></h5>
					<p>
					<?php esc_html_e( 'See our list of popular help links for building your website and/or any issues you may have.', 'avant' ); ?>
					</p>
					<ul>
						<li>
							<a href="https://kairaweb.com/documentation/setting-up-the-default-slider/" target="_blank"><?php esc_html_e( 'Setup the Avant default slider', 'avant' ); ?></a>
						</li>
						<li>
							<a href="https://kairaweb.com/documentation/adding-custom-css-to-wordpress/" target="_blank"><?php esc_html_e( 'Adding Custom CSS to WordPress', 'avant' ); ?></a>
						</li>
						<li>
							<a href="https://kairaweb.com/documentation/mobile-menu-not-working/" target="_blank"><?php esc_html_e( 'Mobile Menu is not working', 'avant' ); ?></a>
						</li>
						<li>
							<a href="https://kairaweb.com/go/what-premium-offers-notice/" target="_blank"><?php esc_html_e( 'What does Avant Premium offer extra', 'avant' ); ?></a>
						</li>
					</ul>
					<a href="<?php echo esc_url( 'https://kairaweb.com/documentation/' ) ?>" class="avant-admin-notice-btn-grey" target="_blank">
						<?php esc_html_e( 'See More Documentation', 'avant' ); ?>
					</a>
				</div>
			</div>
			<a href="?avant_add_license_notice_ignore=" class="avant-notice-close"><?php esc_html_e( 'Dismiss Notice', 'avant' ); ?></a>
		</div><?php
	endif;
}
add_action( 'admin_notices', 'avant_add_license_notice' );
/**
 * Admin notice save dismiss to wp transient
 */
function avant_add_license_notice_ignore() {
    global $current_user;
	$avant_user_id = $current_user->ID;

    if ( isset( $_GET['avant_add_license_notice_ignore'] ) ) {
		update_user_meta( $avant_user_id, 'avant_flash_notice_ignore', true );
    }
}
add_action( 'admin_init', 'avant_add_license_notice_ignore' );
