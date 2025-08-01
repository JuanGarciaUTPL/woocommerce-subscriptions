<?php
/**
 * Cancelled Subscription email (plain text)
 *
 * @author  Prospress
 * @package WooCommerce_Subscriptions/Templates/Emails/Plain
 * @version 1.0.0 - Migrated from WooCommerce Subscriptions v2.1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

echo wp_kses_post( $email_heading ) . "\n\n";

// translators: $1: customer's billing first name and last name
printf( esc_html__( 'A subscription belonging to %1$s has expired. Their subscription\'s details are as follows:', 'woocommerce-subscriptions' ), esc_html( $subscription->get_formatted_billing_full_name() ) );

echo "\n\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n";

/**
 * @hooked WC_Subscriptions_Email::order_details() Shows the order details table.
 * @since 1.0.0 - Migrated from WooCommerce Subscriptions v2.1.0
 */
do_action( 'woocommerce_subscriptions_email_order_details', $subscription, $sent_to_admin, $plain_text, $email );

echo "\n----------\n\n";

$last_order_time_created = $subscription->get_time( 'last_order_date_created', 'site' );

if ( ! empty( $last_order_time_created ) ) {
	// translators: placeholder is last time subscription was paid
	echo esc_html( sprintf( __( 'Last Order Date: %s', 'woocommerce-subscriptions' ), date_i18n( wc_date_format(), $last_order_time_created ) ) ) . "\n";
}

$end_time = $subscription->get_time( 'end', 'site' );

if ( ! empty( $end_time ) ) {
	// translators: placeholder is localised date string
	echo esc_html( sprintf( __( 'End Date: %s', 'woocommerce-subscriptions' ), date_i18n( wc_date_format(), $end_time ) ) ) . "\n";
}

do_action( 'woocommerce_email_order_meta', $subscription, $sent_to_admin, $plain_text, $email );

// translators: %s: subscription URL
echo "\n" . esc_html( sprintf( _x( 'View Subscription: %s', 'in plain emails for subscription information', 'woocommerce-subscriptions' ), wcs_get_edit_post_link( $subscription->get_id() ) ) ) . "\n";

echo "\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";

do_action( 'woocommerce_email_customer_details', $subscription, $sent_to_admin, $plain_text, $email );

echo "\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";

/**
 * Show user-defined additional content - this is set in each email's settings.
 */
if ( $additional_content ) {
	echo esc_html( wp_strip_all_tags( wptexturize( $additional_content ) ) );
	echo "\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";
}

echo wp_kses_post( apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) ) );
