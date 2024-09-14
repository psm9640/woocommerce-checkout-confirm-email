<?php

/*
/*	Add "Confirm Email Address" Field At WooCommerce Checkout
/*
/*	Based upon snippets from:
/*	https://www.businessbloomer.com/woocommerce-add-confirm-email-address-field-checkout/
/*	https://rudrastyh.com/woocommerce/checkout-fields.html
/*
/*------------------------------------------------------------------*/

// Add custom email verification field to the checkout form
add_filter( 'woocommerce_checkout_fields', 'custom_add_confirm_email_field' );

function custom_add_confirm_email_field( $fields ) {

    // Add the 'Verify Email Address' field after the 'billing_email' field
    $fields['billing']['custom_email_verify'] = array(
        'type'          => 'text',
        'required'      => true,
        'class'         => array('form-row-wide'),
        'label'         => 'Verify Email Address',
        'priority'      => 111, // Just after the billing_email (110)
    );

    return $fields;
}

// ---------------------------------
// Generate error message if field values are different

add_action('woocommerce_checkout_process', 'custom_matching_email_addresses');

function custom_matching_email_addresses() {

    if (is_user_logged_in()) return;

    $email1 = trim(strtolower($_POST['billing_email']));
    $email2 = trim(strtolower($_POST['custom_email_verify']));

    if ( $email2 !== $email1 && strlen($email2) > 0 ) {
        wc_add_notice( 'Your email addresses do not match', 'error' );
    }
}

?>
