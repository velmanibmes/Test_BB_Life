<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$is_upsells_enabled = \FKCart\Includes\Data::is_upsells_enabled();
$is_rewards_enabled = \FKCart\Includes\Data::is_rewards_enabled();
$is_coupon_enabled  = \FKCart\Includes\Data::is_coupon_enabled();
$cart_settings      = \FKCart\Includes\Data::get_settings();
$front              = \FKCart\Includes\Front::get_instance();
$is_preview         = fkcart_is_preview();
$coupon_enable      = wc_coupons_enabled() && ( $is_coupon_enabled || $is_preview );

$show_at_load = ! did_action( 'wc_ajax_get_refreshed_fragments' ) && wp_doing_ajax();

$is_style1_upsell_enabled = $is_preview || ( $is_upsells_enabled && 'style1' === $cart_settings['upsell_style'] );
$is_style2_upsell_enabled = $is_preview || ( $is_upsells_enabled && 'style2' === $cart_settings['upsell_style'] );
$is_style3_upsell_enabled = $is_preview || ( $is_upsells_enabled && 'style3' === $cart_settings['upsell_style'] );
$is_style4_upsell_enabled = $is_preview || ( $is_upsells_enabled && 'style4' === $cart_settings['upsell_style'] );
$is_style5_upsell_enabled = $is_preview || ( $is_upsells_enabled && 'style5' === $cart_settings['upsell_style'] );

$has_zero_state = '';
if ( ! $is_preview && ! is_null( WC()->cart ) && WC()->cart->is_empty() ) {
	$has_zero_state = 'has-zero-state';
}
$slider_footer_class = ( ! $is_upsells_enabled || $is_style1_upsell_enabled || $is_style2_upsell_enabled || $is_style3_upsell_enabled ) ? 'fkcart-pb-16' : '';
$slider_body_class   = '';
if ( $is_upsells_enabled && $is_style2_upsell_enabled ) {
	$slider_body_class = 'fkcart-body-275';
}
if ( $is_upsells_enabled && $is_style1_upsell_enabled ) {
	$slider_body_class = 'fkcart-body-150';
}

if ( $is_upsells_enabled && $is_style1_upsell_enabled ) {
	$slider_body_class = 'fkcart-body-style-3';
}
$slider_footer_class = empty( $slider_footer_class ) && ! defined( 'WFFN_PRO_BUILD_VERSION' ) ? 'fkcart-pb-16' : $slider_footer_class;

$slider_below_cta_class = ( $is_style4_upsell_enabled || $is_style5_upsell_enabled ) ? 'fkcart-pt-16' : '';

?>
<div class="fkcart-modal-container <?php echo ( is_null( WC()->cart ) || WC()->cart->is_empty() ) ? '' : 'fkcart-has-items' ?>" data-direction="<?php esc_attr_e( is_rtl() ? 'rtl' : 'ltr' ); ?>" data-slider-pos="<?php esc_attr_e( $cart_settings['cart_icon_position'] ); ?>" data-nonce="<?php echo wp_create_nonce( 'fkcart' ); ?>">
    <div class="fkcart-preview-ui <?php echo( $has_zero_state ); ?>" data-anim="<?php echo esc_attr( $cart_settings['css_animation_speed'] ); ?>">
        <!-- Header -->
        <div class="fkcart-slider-header">
			<?php fkcart_get_template_part( 'cart/header-style1' ); ?>
        </div>

		<?php do_action( 'fkcart_after_header', $front ); ?>

        <!-- Reward -->
		<?php $is_rewards_enabled && fkcart_get_template_part( 'cart/rewards' ); ?>
        <!-- END: Reward -->

        <!-- Body -->
        <div class="fkcart-slider-body">
            <!-- Cart Zero State -->
			<?php ! $is_preview && fkcart_get_template_part( 'cart/zero-item-state' ); ?>
            <!-- END: Cart Zero State -->

            <!-- START: Cart Items -->
			<?php fkcart_get_template_part( 'cart/items' ); ?>
            <!-- END: Cart Items -->

            <!-- START: Upsell Style -->
			<?php $is_style1_upsell_enabled && fkcart_get_template_part( 'cart/upsell-style1' ) ?>
			<?php $is_style2_upsell_enabled && fkcart_get_template_part( 'cart/upsell-style2' ) ?>
			<?php $is_style3_upsell_enabled && fkcart_get_template_part( 'cart/upsell-style3' ) ?>
            <!-- END: Upsell Style -->
        </div>

        <!-- Slider Footer -->
        <div class="fkcart-slider-footer <?php echo $slider_footer_class ?>">

            <!-- START: Coupon Area -->
			<?php $coupon_enable && fkcart_get_template_part( 'cart/coupon-box' ) ?>
            <!-- END: Coupon Area -->

            <!-- START: Order Summary -->
			<?php fkcart_get_template_part( 'cart/order-summary' ); ?>
            <!-- END: Order Summary -->

            <!-- START: CTA -->
			<?php fkcart_get_template_part( 'cart/cart-cta' ); ?>
            <!-- END: CTA -->

            <!-- START: Upsell Style -->
            <div class="fkcart-below-checkout-upsell <?php echo $slider_below_cta_class ?>">
				<?php $is_style4_upsell_enabled && fkcart_get_template_part( 'cart/upsell-style1' ) ?>
				<?php $is_style5_upsell_enabled && fkcart_get_template_part( 'cart/upsell-style2' ) ?>
            </div>
            <!-- END: Upsell Style -->
        </div>
    </div>

    <!-- START: Quick View -->
	<?php fkcart_get_template_part( 'cart/item-quick-view' ); ?>
    <!-- END: Quick View -->

    <!-- Notice -->
    <div class="fkcart-slider-notices fkcart-hide-notice" id="fkcart-notice" data-status="error">
        <div class="fkcart-notice-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2ZM12 15.125C11.4822 15.125 11.0625 15.5447 11.0625 16.0625C11.0625 16.5803 11.4822 17 12 17C12.5178 17 12.9375 16.5803 12.9375 16.0625C12.9375 15.5447 12.5178 15.125 12 15.125ZM12 7C11.6932 7 11.438 7.22109 11.3851 7.51266L11.375 7.625V13.25L11.3851 13.3623C11.438 13.6539 11.6932 13.875 12 13.875C12.3068 13.875 12.562 13.6539 12.6149 13.3623L12.625 13.25V7.625L12.6149 7.51266C12.562 7.22109 12.3068 7 12 7Z" fill="currentColor"/>
            </svg>
        </div>
        <div class="fkcart-notice-text"></div>
    </div>

    <!-- Modal Shadow -->
    <div class="fkcart-modal-backdrop"></div>
</div>
