<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$front = \FKCart\Includes\Front::get_instance();

$settings = \FKCart\Includes\Data::get_settings();

$coupons          = $front->get_coupons();
$tax_enabled      = wc_tax_enabled();
$shipping_enabled = wc_shipping_enabled();
$coupon_enable    = wc_coupons_enabled();
$subtotal         = ( 'true' === $settings['show_sub_total'] || true === $settings['show_sub_total'] );

$shipping_tax_calculation_text = isset( $settings['shipping_tax_calculation_text'] ) ? $settings['shipping_tax_calculation_text'] : esc_attr__( 'Shipping & taxes may be re-calculated at checkout', 'cart-for-woocommerce' );
?>
<div class="fkcart-order-summary fkcart-panel fkcart-pt-16">
    <div class="fkcart-order-summary-container">
        <div class="fkcart-summary-line-item fkcart-subtotal-wrap <?php echo( ! $subtotal ? "fkcart-hide" : "" ); ?>">
            <div class="fkcart-summary-text"><strong><?php esc_html_e( 'Subtotal', 'woocommerce' ) ?></strong></div>
            <div class="fkcart-summary-amount"><strong><?php echo wp_kses_post( $front->get_subtotal_row() ) ?></strong></div>
        </div>
		<?php
		if ( $coupon_enable ) {
			foreach ( $coupons as $code => $coupon ) {
				?>
                <div class="fkcart-summary-line-item fkcart-coupon-applied">
                    <div class="fkcart-summary-text">
						<?php _e( 'Coupon', 'woocommerce' ) ?>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 415.33">
                            <path d="M222.67,0H270L47,223,213.67,389.67l-25,25L0,226Z" transform="translate(0 0)" fill="currentColor"></path>
                            <path d="M318,0S94,222,95.33,222L288.67,415.33,512,192V0Zm97.67,133.33a41,41,0,1,1,41-41A41,41,0,0,1,415.67,133.33Z" transform="translate(0 0)" fill="currentColor"></path>
                        </svg>
                        <div class="fkcart-coupon-code"><?php echo wp_kses_post( $coupon['code'] ) ?></div>
                        <div class="fkcart-remove-coupon" data-coupon="<?php esc_attr_e( $coupon['code'] ) ?>">
							<?php fkcart_get_template_part( 'icon/close', '', [ 'width' => 12, 'height' => 12 ] ); ?>
                        </div>
                    </div>
                    <div class="fkcart-summary-amount">-<?php echo wp_kses_post( $coupon['value'] ) ?></div>
                </div>
			<?php }
		}
		if ( $shipping_enabled && class_exists( 'FKCart\Pro\Rewards' ) && ! is_null( WC()->session ) ) {
			$free_shipping = WC()->session->get( '_fkcart_free_shipping_methods', '' );
			if ( ! empty( $free_shipping ) ) {
				?>
                <div class="fkcart-summary-line-item fkcart-coupon-applied">
                    <div class="fkcart-summary-text"><?php _e( 'Shipping', 'woocommerce' ) ?></div>
                    <div class="fkcart-summary-amount"><?php _e( 'Free', 'woocommerce' ); ?></div>
                </div>
				<?php
			}
		}
		if ( $tax_enabled || $shipping_enabled ) {
			?>
            <div class="fkcart-summary-line-item">
                <div class="fkcart-summary-text fkcart-shipping-tax-calculation-text"><?php echo $shipping_tax_calculation_text ?></div>
            </div>
		<?php } ?>
        <div class="fkcart-text-light"></div>
    </div>
</div>
