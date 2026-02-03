<?php
function hello_elementor_child_enqueue_scripts() {
	wp_enqueue_style(
		'hello-elementor-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		[
			'hello-elementor-theme-style',
		],
		rand(1, 10)
	);
	
    wp_enqueue_script( 'custom-scripts', get_stylesheet_directory_uri() . '/script.js', array( 'jquery' ), true, true);

    // wp_enqueue_script('fancybox', '//cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js', ['jquery'], '3.5.7', true);
    // wp_enqueue_style('fancyBox-css','//cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css', [], '3.5.7', 'all');
	
	// wp_enqueue_script('owlcarouseljs', '//cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js', ['jquery'], '2.3.4', true);
    // wp_enqueue_style('owlcarouselcss','//cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css', [], '2.3.4', 'all');
	// wp_enqueue_style('owlcarouselthemecss','//cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css', [], '2.3.4', 'all');
	
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_enqueue_scripts' );
//-----------------------



//Below codes helps to create a dynamic copyrights line footer
function site_title_shortcode() {
  	$site_title = get_bloginfo( 'name' );
	$site_url = site_url();
	$title_url = '<a href="'.$site_url.'">'.$site_title.'</a>';
  	return $title_url;
}
add_shortcode('site_title', 'site_title_shortcode');
//-----------------------------------


//** ------- this place is code-house for your reference.
//** ------- Do not just copy paste, understand, modify as per your requirement & contribute if possible
//** ------- Happy coding

// wp security measures **** DO NOT REMOVE ANYTHING BELOW ***** //
remove_action('wp_head', 'wp_generator');

//Know more about this "xmlrpc_enabled" https://www.hostinger.in/tutorials/xmlrpc-wordpress
add_filter( 'xmlrpc_enabled', '__return_false' );
// wp security measures **** DO NOT REMOVE ANYTHING ABOVE ***** //


//---------enable support for svg-----------//
function cc_mime_types($mimes) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');
/*-------------------------------------------*/ 



