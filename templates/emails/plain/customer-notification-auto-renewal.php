<?php
/**
 * Customer Notification: Notify the customer that an automated renewal their subscription is about to happen. Plain text version.
 *
 * @package WooCommerce_Subscriptions/Templates/Emails/Plain
 * @version 7.2.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

echo esc_html( $email_heading . "\n\n" );

echo "\n\n";

echo esc_html(
	sprintf(
		/* translators: %s: Customer first name */
		__( 'Hi %s.', 'woocommerce-subscriptions' ),
		$subscription->get_billing_first_name()
	)
);

echo "\n\n";

echo esc_html(
	sprintf(
		// translators: %1$s: human readable time difference (eg 3 days, 1 day), %2$s: date in local format.
		__(
			'Your subscription will automatically renew in %1$s — that’s %2$s.',
			'woocommerce-subscriptions'
		),
		$subscription_time_til_event,
		$subscription_event_date
	)
);

echo "\n\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n";

// Show subscription details.
\WC_Subscriptions_Email::subscription_details( $subscription, $order, $sent_to_admin, $plain_text, true );

/** This action is documented in templates/emails/customer-notification-auto-renewal.php */
do_action( 'woocommerce_subscriptions_email_order_details', $subscription, $sent_to_admin, $plain_text, $email );

esc_html_e( 'You can manage this subscription from your account dashboard: ', 'woocommerce-subscriptions' );
echo esc_url( wc_get_page_permalink( 'myaccount' ) );

echo "\n\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n";

/**
 * Show user-defined additional content - this is set in each email's settings.
 */
if ( $additional_content ) {
	echo esc_html( wp_strip_all_tags( wptexturize( $additional_content ) ) );
	echo "\n\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n";
}

echo wp_kses_post( apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) ) );
