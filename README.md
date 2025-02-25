# builder-team
This repository is for builder team. Add optimized code here.

<code>
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
</code>
