<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// New snippet to add custom field & heading to my-account page.
add_filter('woocommerce_account_dashboard', 'cws_add_ffl_license_no_to_my_account');
function cws_add_ffl_license_no_to_my_account( $user_id ) {
   if ( is_user_logged_in() ) {
		$user_id = get_current_user_id();
		$bc_atf_ffl_number = get_user_meta( $user_id, 'bc_atf_ffl_number', true );
		$bc_user_id = rwmb_meta( 'bc_user_id', [ 'object_type' => 'user' ], $user_id );
		$bc_tenant_id = rwmb_meta( 'bc_tenant_id', [ 'object_type' => 'user' ], $user_id);
		$bc_database = rwmb_meta( 'bc_database', [ 'object_type' => 'user' ], $user_id );
		$bc_logon_url = rwmb_meta( 'bc_logon_url', [ 'object_type' => 'user' ], $user_id );

		if ( empty( $bc_atf_ffl_number ) ) {
			$bc_atf_ffl_number = '<em>Unassigned</em>';
		}

		?>
			<div class="my-account-wrapper">
				<div class="subsection-heading">
					<h2>FFLAssist Account Meta Information</h2>
				</div>
				<p><div>ATF FFL Number: </div>
				<?php echo $bc_atf_ffl_number; ?></p>
				<div>Logon URL: <br>
		<?php

		if ( empty( $bc_user_id ) || ( empty( $bc_tenant_id ) && empty( $bc_database ) ) ) {
			$bc_url = '<em>Unassigned</em><br>Your account setup is not yet complete. Please check back.';
			echo $bc_url;
		} else if  ( empty( $bc_logon_url ) ) {
			$bc_url = 'https://businesscentral.dynamics.com/'. $bc_tenant_id . '/' . $bc_database . '/';
			echo '<a href="' . $bc_url . '">' . $bc_url . '</a>';
		}
		?>
				</div> <!-- Logon URL -->
			</div> <!-- my-account-wrapper -->		
		<?php 
		// Dump out big button to access FFLAssist Portal.
		capweb_fflassist_portal_content(); 
		}
}

	/**
	 * My Account dashboard.
	 *
	 * @since 2.6.0
	 */
	do_action( 'woocommerce_account_dashboard' );

	/**
	 * Deprecated woocommerce_before_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_before_my_account' );

	/**
	 * Deprecated woocommerce_after_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_after_my_account' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
