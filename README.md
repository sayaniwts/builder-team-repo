# Builder Team
This repository is for builder team. 

## 📚 CSS Documentation

- 👉 [CSS Contributions](docs/README.md)


<h2>Gravity Form</h2>
<h3># Set 1</h3>
<strong>🗓️ Set Dynamic Date Range in Gravity Forms <br> Datepicker 1 becomes minDate for datepicker 2 ————————— (Disable past dates from datepicker)</strong>
<pre>📝 Gravity Form JS Hook</pre>
<pre>
gform.addFilter('gform_datepicker_options_pre_init', function (optionsObj, formId, fieldId) {
    if (formId == 2 && fieldId == 23) {
        optionsObj.minDate = 0;
        optionsObj.onClose = function (dateText, inst) {
            jQuery('#input_2_24')
                .datepicker('option', 'minDate', dateText)
                .datepicker('setDate', dateText);
        };
    }
    return optionsObj;
});
</pre>

<h3># Set 2</h3>
<strong>Gravity forms offset issue fixed after submission</strong>
<pre>
    add_filter( 'gform_confirmation_anchor', '__return_false' );
</pre>

<h3># Set 3</h3>
<strong>Gravity form email, phone, name field validation and blocked specific spam phone numbers.</strong>
<pre> 
add_filter( 'gform_field_validation', 'custom_multi_field_validation', 10, 4 );
function custom_multi_field_validation( $result, $value, $form, $field ) {
 
    // === Define target fields by type ===
    $name_fields = array(
        2 => array( 3, 6 ),
        3 => array( 3 ),
    );
 
    $email_fields = array(
        3 => array( 14, 15 ),
        5 => array( 2 ),
    );
 
    $phone_fields = array(
        3 => array( 10 ),
        5 => array( 4 ),
    );
 
    // === Block specific spam phone numbers ===
    $blocked_numbers = array(
        '555-555-1212',
        '+15555551212',
        '0000000000',
    );
 
    // === Name Field Validation (letters only) ===
    if ( isset( $name_fields[ $form['id'] ] ) && in_array( $field->id, $name_fields[ $form['id'] ] ) ) {
        if ( empty( $value ) ) {
            $result['is_valid'] = false;
            $result['message'] = 'This field is required.';
        } elseif ( ! preg_match( '/^[a-zA-Z\s.,]+$/', $value ) ) {
            $result['is_valid'] = false;
            $result['message'] = 'Please enter only letters.';
        }
    }
 
    // === Email Field Validation ===
    if ( isset( $email_fields[ $form['id'] ] ) && in_array( $field->id, $email_fields[ $form['id'] ] ) ) {
    if ( empty( $value ) ) {
        $result['is_valid'] = false;
        $result['message'] = 'This field is required';
    } elseif ( ! preg_match( '/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/', $value ) ) {
        $result['is_valid'] = false;
        $result['message'] = 'Please enter a valid email address (lowercase only)';
    }
}
 
    // === Phone Field Validation ===
    if ( isset( $phone_fields[ $form['id'] ] ) && in_array( $field->id, $phone_fields[ $form['id'] ] ) ) {
        if ( empty( $value ) ) {
            $result['is_valid'] = false;
            $result['message'] = 'Phone number is required';
        } else {
            // Normalize value to digits only
            $normalized_value = preg_replace( '/\D/', '', $value );
            $normalized_blocked = array_map( function( $n ) {
                return preg_replace( '/\D/', '', $n );
            }, $blocked_numbers );
 
            if ( in_array( $normalized_value, $normalized_blocked ) ) {
                $result['is_valid'] = false;
                $result['message'] = 'Invalid phone number.';
            }
        }
    }
 
    return $result;
}
</pre>


<h2>Elementor</h2>
## 🎯 Elementor form email field special charecter validation

<h3># Set 1</h3>
<pre>
function elementor_form_validation( $record, $ajax_handler ) {
    $fields = $record->get_field( [
        'id' => 'paste_ID',
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
</pre>

<h3># Set 2</h3>
<strong>Disable site zoom</strong>
<pre>
function custom_hello_elementor_viewport_content() {
	return 'width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no';
}
add_filter( 'hello_elementor_viewport_content', 'custom_hello_elementor_viewport_content' );
</pre>


<h2>WooCommerce</h2>
<h3># Set 1</h3>
<strong>WooCommerce checkout form First and Last name validation</strong>

<pre>
add_action('woocommerce_checkout_process', 'validate_billing_name_fields');
 
function validate_billing_name_fields() {
    // Regular expression to allow only alphabets (no spaces, numbers, or special characters)
    $name_pattern = "/^[a-zA-Z]+$/";
 
    // Check First Name
    if (!preg_match($name_pattern, $_POST['billing_first_name'])) {
        wc_add_notice(__('Billing First Name should contain only letters (A-Z, a-z).', 'woocommerce'), 'error');
    }
 
    // Check Last Name
    if (!preg_match($name_pattern, $_POST['billing_last_name'])) {
        wc_add_notice(__('Billing Last Name should contain only letters (A-Z, a-z).', 'woocommerce'), 'error');
    }
}
add_action('woocommerce_customer_save_address', 'validate_my_account_address_name_fields', 10, 2);
 
function validate_my_account_address_name_fields($user_id, $load_address) {
    $first_name = isset($_POST[$load_address . '_first_name']) ? sanitize_text_field($_POST[$load_address . '_first_name']) : '';
    $last_name = isset($_POST[$load_address . '_last_name']) ? sanitize_text_field($_POST[$load_address . '_last_name']) : '';
 
    $pattern = '/^[a-zA-Z]+$/';
 
    if (!preg_match($pattern, $first_name)) {
        wc_add_notice(ucfirst($load_address) . ' First Name should contain only letters (A-Z, a-z).', 'error');
    }
 
    if (!preg_match($pattern, $last_name)) {
        wc_add_notice(ucfirst($load_address) . ' Last Name should contain only letters (A-Z, a-z).', 'error');
    }
}
</pre>


<h2>Global</h2>
<strong>Elementor + Gravity Form</strong>
<pre>
$( document ).on( 'elementor/popup/show', () => {
    setTimeout(() => {
        // window.gform.recaptcha.renderRecaptcha();
        $(document).trigger("gform_post_render", [3, 1]); [just use your form id instead of 3]
    }, 100);
});
</pre>

<strong>Prevent blank search</strong>
<pre> 
$('form.e-search-form').on('submit', function(e) {
    var input = $(this).find('input[type="search"], input[type="text"]').val().trim();
 
    if (input === '') {
      e.preventDefault();
      alert('Please enter a valid search term.');
    }
  });
</pre>
