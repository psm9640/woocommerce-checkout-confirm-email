
# WooCommerce - Add "Confirm Email Address" Field at Checkout

This repository adds a custom "Confirm Email Address" field to the WooCommerce checkout form, ensuring that the customer enters matching email addresses for validation.

WooCommerce, by default, does not include an out-of-the-box email verification or confirmation field in the checkout process. It only provides a single field for the billing email address, and there is no built-in feature to confirm or verify that the entered email is correct. Since this single email entry point is often tied to CRM or email campaign providers, shipping services, etc. As a result, getting a bad email address not only becomes a customer service pain point, but it also prevents a merchant's ability to remarket.

## Features

- Adds a "Verify Email Address" field after the "Email Address" field in WooCommerce checkout.
- Validates that the two email fields match before the customer can proceed with the checkout.
- Displays an error message if the email addresses do not match.

## Installation

1. **Download or Clone this repository:**

   ```
   git clone https://github.com/psm9640/woocommerce-checkout-confirm-email.git
   ```

2. **Add the code to your theme or custom plugin:**

   You can place the code into your theme’s `functions.php` file or use it within a custom plugin.
   - `wp-content/themes/your-theme/functions.php`

   Since I wanted it available no matter what theme was being used I created a single .php file for the mu-plugins folder

3. **Test the Functionality:**

   - Navigate to your WooCommerce checkout page.
   - Enter an email address and a different email in the "Verify Email Address" field to trigger the validation.

## Code Explanation

### 1. Add "Verify Email Address" Field:

This adds the custom field right after the billing email address field by using the `woocommerce_checkout_fields` filter.

```php
add_filter( 'woocommerce_checkout_fields', 'custom_add_confirm_email_field' );

function custom_add_confirm_email_field( $fields ) {
    $fields['billing']['custom_email_verify'] = array(
        'type'          => 'text',
        'required'      => true,
        'class'         => array('form-row-wide'),
        'label'         => 'Verify Email Address',
        'priority'      => 111, // Just after billing_email (110)
    );
    return $fields;
}
```

### 2. Validation for Matching Emails:

This part checks whether the email addresses match during the checkout process. If they don’t match, an error message is displayed.

```php
add_action('woocommerce_checkout_process', 'custom_matching_email_addresses');

function custom_matching_email_addresses() {
    if (is_user_logged_in()) return;

    $email1 = trim(strtolower($_POST['billing_email']));
    $email2 = trim(strtolower($_POST['custom_email_verify']));

    if ( $email2 !== $email1 && strlen($email2) > 0 ) {
        wc_add_notice( 'Your email addresses do not match', 'error' );
    }
}
```

## Customization

- You can modify the `label` text for the "Verify Email Address" field to suit your needs.
- Adjust the priority to change the position of the field if necessary.
- Customize the error message inside the validation function.

## License

This project is open source and available under the [MIT License](LICENSE).
