<?php
/**
 * Theme functions and definitions
 *
 * @package HelloElementorChild
 */

/**
 * Load child theme css and optional scripts
 *
 * @return void
 */
function hello_elementor_child_enqueue_scripts() {
	wp_enqueue_style(
		'hello-elementor-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		[
			'hello-elementor-theme-style',
		],
		'1.0.0'
	);
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_enqueue_scripts' );

//-------Custom Js file----------------
function mycustomscript_enqueue() {
    wp_enqueue_script( 'custom-scripts', get_stylesheet_directory_uri() . '/script.js', array( 'jquery' ), true);
}
add_action( 'wp_enqueue_scripts', 'mycustomscript_enqueue' );
//-----------------------


//-------Extra CDNs to enqueue[uncomments the default CDNs if required]----------------
function extra_css_js_cdn()
{
    // wp_enqueue_script('fancybox', '//cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js', ['jquery'], '3.5.7', true);
    // wp_enqueue_style('fancyBox-css','//cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css', [], '3.5.7', 'all');
	
	// wp_enqueue_script('aos', '//unpkg.com/aos@2.3.1/dist/aos.js',['jquery'], '2.3.1', true);
	// wp_enqueue_style('aos', '//unpkg.com/aos@2.3.1/dist/aos.css', [], '2.3.1', 'all');
	
	wp_enqueue_script('owlcarouseljs', '//cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js', ['jquery'], '2.3.4', true);
    wp_enqueue_style('owlcarouselcss','//cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css', [], '2.3.4', 'all');
	wp_enqueue_style('owlcarouselthemecss','//cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css', [], '2.3.4', 'all');
	
	// wp_enqueue_style('animatecss','//cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css', [], '3.5.2', 'all');
}

add_action('wp_enqueue_scripts', 'extra_css_js_cdn');
//---------------------------------------------------------------

//Below codes helps to create a dynamic copyrights line footer
function year_shortcode() {
  	$year = date('Y');
  	return $year;
}
add_shortcode('year', 'year_shortcode');

function site_title_shortcode() {
  	$site_title = get_bloginfo( 'name' );
	$site_url = site_url();
	$title_url = '<a href="'.$site_url.'" style="font-size: 15px; color: #fff;">'.$site_title.'</a>';
  	return $title_url;
}
add_shortcode('site_title', 'site_title_shortcode');
//-----------------------------------

// Show \ Hide page title (default: show)
add_filter( 'hello_elementor_page_title', '__return_false' );