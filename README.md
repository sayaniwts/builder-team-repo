# Builder Team
This repository is for builder team. 

## 📚 CSS Documentation

- 👉 [CSS Contributions](docs/README.md)


<h2>Gravity Form</h2>
## 🗓️ Set Dynamic Date Range in Gravity Forms <br>
### Datepicker 1 becomes minDate for datepicker 2 ————————— (Disable past dates from datepicker)

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