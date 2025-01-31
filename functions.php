<?php

//** ------- this place is code-house for your reference.
//** ------- Do not just copy paste, understand, modify as per your requirement & contribute if possible
//** ------- Happy coding


// wp security measures **** DO NOT REMOVE ANYTHING BELOW ***** //
remove_action('wp_head', 'wp_generator');
add_filter( 'xmlrpc_enabled', '__return_false' );
// wp security measures **** DO NOT REMOVE ANYTHING ABOVE ***** //



//---------enable support for svg-----------//
function cc_mime_types($mimes) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');
/*-------------------------------------------*/ 



// elementor loop grid hook for search&filter
add_action( 'elementor/query/<your_query_id>', 'your_function_name' );
function your_function_name( $query ) {
	$query->set( 'search_filter_id', 514 ); //change 514 to your filter ID
}
/*-------------------------------------------------------------------*/



/*----------elementor email field special charecter validation-----------*/ 
function elementor_form_validation( $record, $ajax_handler ) {
    $fields = $record->get_field( [
        'id' => '<<enter field id here>>',
    ] );

    if ( empty( $fields ) ) {
        return;
    }

    $field = current( $fields );

    if ( 1 !== preg_match( '/^[a-zA-Z0-9.]+@[a-zA-Z0-9.]+\.[a-zA-Z]{2,}$/', $field['value'] ) ) {
        $ajax_handler->add_error( $field['id'], esc_html__( 'No special charecters allowed.', 'textdomain' ) );
    }
}
add_action( 'elementor_pro/forms/validation', 'elementor_form_validation', 10, 2 );
/*-------------------------------------------------------------------*/



// show posts by view count (for custom shortcode purpose)
function setPostViews($postID) {
    $countKey = 'post_views_count';
    $count = get_post_meta($postID, $countKey, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $countKey);
        add_post_meta($postID, $countKey, '0');
    }else{
        $count++;
        update_post_meta($postID, $countKey, $count);
    }
}

function track_trending_post_views ($post_id) {
    if ( !is_single() ) 
    return;	 
    if ( empty ( $post_id) ) {
        global $post;
        $post_id = $post->ID;    
    }
    setPostViews($post_id);
}
add_action( 'wp_head', 'track_trending_post_views');
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

function show_trending_posts(){
    ob_start();

    $popularpostbyview = array(
        'post_type' =>  '<your_post_type>',
        'meta_key'  => 'post_views_count', 
        'orderby'    => 'meta_value_num',
        'order'      => 'DESC',
        'posts_per_page' => 3
    );
    
    $trending_posts = new WP_Query( $popularpostbyview );
    
    if ( $trending_posts->have_posts() ) :?>
        <ul>
            <?php
                while ( $trending_posts->have_posts() ) : $trending_posts->the_post();
                ?>
                    <li>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </li>
                <?php
                endwhile;
                wp_reset_postdata();
            ?>
        </ul>
    <?php 
    endif;

    return ob_get_clean();
}
add_shortcode('trending-articles', 'show_trending_posts');
/*-------------------------------------------------------------------*/



// show lowest variation price by default for variable products(woocommerce) (for custom purpose)
add_filter( 'woocommerce_variable_sale_price_html', 'art_variation_price_format', 10, 2 );
add_filter( 'woocommerce_variable_price_html', 'art_variation_price_format', 10, 2 );
 
function art_variation_price_format( $price, $product ) {
 
$prices = array( $product->get_variation_price( 'min', true ), $product->get_variation_price( 'max', true ) );
$price = $prices[0] !== $prices[1] ? sprintf( __( 'From: %1$s', 'woocommerce' ), wc_price( $prices[0] ) ) : wc_price( $prices[0] );
 
$prices = array( $product->get_variation_regular_price( 'min', true ), $product->get_variation_regular_price( 'max', true ) );
sort( $prices );
$saleprice = $prices[0] !== $prices[1] ? sprintf( __( 'From: %1$s', 'woocommerce' ), wc_price( $prices[0] ) ) : wc_price( $prices[0] );
 
if ( $price !== $saleprice ) {
$price = '<del>' . $saleprice . $product->get_price_suffix() . '</del> <ins>' . $price . $product->get_price_suffix() . '</ins>';
}
return $price;
}
/*-------------------------------------------------------------------*/



// Create stock checker of overall woocommerce product  (for custom purpose)
function check_product_stock_status(){
    ob_start();

    $stockstatus = get_post_meta( get_the_ID(), '_stock_status', true );

    if ($stockstatus == 'outofstock') {
        echo '<p class="stock out-of-stock">Out of Stock</p>';
    }
    elseif ($stockstatus == 'instock') {
        echo '<p class="stock in-stock">In Stock</p>';
    }

    return ob_get_clean();
}
add_shortcode( 'product-stock-status', 'check_product_stock_status' );
/*-------------------------------------------------------------------*/



// change sales badge to offer percentage (for custom purpose)
add_filter( 'woocommerce_sale_flash', 'add_percentage_to_sale_badge', 20, 3 );
function add_percentage_to_sale_badge( $html, $post, $product ) {

  if( $product->is_type('variable')){
      $percentages = array();

      // Get all variation prices
      $prices = $product->get_variation_prices();

      // Loop through variation prices
      foreach( $prices['price'] as $key => $price ){
          // Only on sale variations
          if( $prices['regular_price'][$key] !== $price ){
              // Calculate and set in the array the percentage for each variation on sale
              $percentages[] = round( 100 - ( floatval($prices['sale_price'][$key]) / floatval($prices['regular_price'][$key]) * 100 ) );
          }
      }
      // We keep the highest value
      $percentage = max($percentages) . '%';

  } elseif( $product->is_type('grouped') ){
      $percentages = array();

      // Get all variation prices
      $children_ids = $product->get_children();

      // Loop through variation prices
      foreach( $children_ids as $child_id ){
          $child_product = wc_get_product($child_id);

          $regular_price = (float) $child_product->get_regular_price();
          $sale_price    = (float) $child_product->get_sale_price();

          if ( $sale_price != 0 || ! empty($sale_price) ) {
              // Calculate and set in the array the percentage for each child on sale
              $percentages[] = round(100 - ($sale_price / $regular_price * 100));
          }
      }
      // We keep the highest value
      $percentage = max($percentages) . '%';

  } else {
      $regular_price = (float) $product->get_regular_price();
      $sale_price    = (float) $product->get_sale_price();

      if ( $sale_price != 0 || ! empty($sale_price) ) {
          $percentage    = round(100 - ($sale_price / $regular_price * 100)) . '%';
      } else {
          return $html;
      }
  }
  return '<span class="onsale">' . esc_html__( 'SALE', 'woocommerce' ) . ' ' . $percentage . '</span>';
}
/*-------------------------------------------------------------------*/



// gform name field validation to accept only alphabets
//1 notify form ID, 8 notify field ID
add_filter( 'gform_field_validation_1_8', 'name_field_validation', 10, 4 );
function name_field_validation( $result, $value, $form, $field ) {
	if ( empty( $value )){
		$result['is_valid'] = false;
		$result['message'] = 'This field is required.';
	} elseif ( ! preg_match( '/^[a-zA-Z\s.,]+$/', $value ) ) {
		$result['is_valid'] = false;
		$result['message'] = 'Please enter only letters.';
	}
    return $result;
}
/*----------------------------------------------------*/



// increase elementor dynamic tag limit for display condition & add search field
function custom_custom_fields_meta_limit( $limit ) {
    $new_limit = 500; // Change this to your desired limit
    return $new_limit; 
}
add_filter('elementor_pro/display_conditions/dynamic_tags/custom_fields_meta_limit', 'custom_custom_fields_meta_limit');
    
function enqueue_custom_script_for_elementor_editor() {
    if ( did_action( 'elementor/loaded' ) && \Elementor\Plugin::instance()->editor->is_edit_mode() ) {
        ?>
        <script type="text/javascript">
        // Function to add the search input to the menu list
        function addSearchInput() {
            const menuList = document.querySelector('.e-conditions-select-menu .MuiMenu-list');
            if (menuList) {
                const firstItem = menuList.querySelector('li:first-child');
                if (!firstItem || !firstItem.classList.contains('search-input-item')) {
                    const searchInputItem = document.createElement('li');
                    searchInputItem.classList.add('search-input-item');
                    searchInputItem.innerHTML = '<input type="text" placeholder="Search..." oninput="filterMenu(this)" />';
                    
                    // Prevent default keydown behavior
                    const searchInput = searchInputItem.querySelector('input');
                    searchInput.addEventListener('keydown', function(event) {
                        event.stopPropagation();
                    });
                    
                    menuList.insertBefore(searchInputItem, menuList.firstChild);
                }
            }
        }

        // Function to filter menu items based on the search input
        function filterMenu(input) {
            const filter = input.value.toLowerCase();
            const menuItems = input.parentElement.parentElement.querySelectorAll('li:not(.search-input-item)');
            menuItems.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(filter) ? '' : 'none';
            });
        }

        // Mutation observer callback
        const observerCallback = function(mutationsList) {
            for (let mutation of mutationsList) {
                if (mutation.type === 'childList') {
                    mutation.addedNodes.forEach(node => {
                        if (node.classList && node.classList.contains('MuiPopover-root')) {
                            addSearchInput();
                        }
                    });
                }
            }
        };

        // Set up the mutation observer
        const observer = new MutationObserver(observerCallback);
        observer.observe(document.body, { childList: true });

        // Adding CSS for the search input item
        const style = document.createElement('style');
        style.textContent = `
          .search-input-item {
            position: sticky;
            top: 0;
            background: white;
            z-index: 10;
            padding: 5px;
          }
          .search-input-item input {
            width: 100%;
            box-sizing: border-box;
            padding: 5px;
          }

         /* prevent word cropping */
        .e-conditions-select-menu .css-ivsn3r {
            max-width: initial;
        }
        `;
        document.head.appendChild(style);
        </script>
        <?php
    }
}
add_action( 'elementor/editor/footer', 'enqueue_custom_script_for_elementor_editor' );
/*----------------------------------------------------*/