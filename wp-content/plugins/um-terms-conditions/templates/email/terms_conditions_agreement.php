<?php
/**
 * Template for the "Terms & Conditions - Agreement request" email.
 *
 * This template can be overridden by copying it to {your-theme}/ultimate-member/email/terms_conditions_agreement.php
 *
 * @version 2.1.6
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div style="max-width: 560px;padding: 20px;background: #ffffff;border-radius: 5px;margin:40px auto;font-family: Open Sans,Helvetica,Arial;font-size: 15px;color: #666;">

	<div style="color: #444444;font-weight: normal;">
		<div style="text-align: center;font-weight:600;font-size:26px;padding: 10px 0;border-bottom: solid 3px #eeeeee;">{site_name}</div>
	</div>

	<div style="padding: 0 30px 30px 30px;border-bottom: 3px solid #eeeeee;">
		<div style="padding: 10px 0 50px 0;text-align: center;">
			Please confirm <strong>terms and conditions</strong> on our website. Follow <a href="{account_terms_conditions_link}" target="_blank" style="color: #3ba1da;text-decoration: none">this link</a> to navigate to the Account page where you can read terms and conditions. Click a button below terms and conditions to confirm.
		</div>

		<div style="padding: 10px 0 50px 0;text-align: center;">
			Note: You have to be logged in to access the Account page. <a href="{login_url}?redirect_to={account_terms_conditions_link}" target="_blank" style="color: #3ba1da;text-decoration: none">Login to our site</a>
		</div>

		<div style="padding:20px;">If you have any problems, please contact us at <a href="mailto:{admin_email}" style="color: #3ba1da;text-decoration: none">{admin_email}</a></div>
	</div>

	<div style="color: #999;padding: 20px 30px">
		<div style="">Thank you!</div>
		<div style="">The <a href="{site_url}" style="color: #3ba1da;text-decoration: none;">{site_name}</a> Team</div>
	</div>
</div>