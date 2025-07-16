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


<h2>Elementor Pro Form</h2>
## 🎯 Elementor form email field special charecter validation

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