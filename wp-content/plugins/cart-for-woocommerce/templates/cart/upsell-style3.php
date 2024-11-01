<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$front    = \FKCart\Includes\Front::get_instance();
$settings = \FKCart\Includes\Data::get_settings();

$cart_contents = $front->get_upsell_products();
if ( empty( $cart_contents ) ) {
	return;
}

$show_at_load = wp_doing_ajax();
?>
<!-- START: Style 3 -->
<div class="fkcart-drawer fkcart-drawer-upsells fkcart-upsell-style3">
    <div class="fkcart-drawer-container" style="<?php esc_html_e( $show_at_load ? 'transform: translate(0px)' : '' ); ?>">
        <div class="fkcart-drawer-wrap">
            <div class="fkcart-drawer-heading fkcart-upsell-heading"><?php esc_html_e( isset( $settings['upsell_heading'] ) ? $settings['upsell_heading'] : __( 'BUY IT WITH', 'cart-for-woocommerce' ) ) ?></div>
            <div class="fkcart-drawer-items">
                <div class="fkcart-item-wrap">
					<?php
					foreach ( $cart_contents as $cart_item_key => $cart_item ) {
						$is_variable = false;
						$price       = '';
						$button      = __( 'Add', 'woocommerce' );
						$product_id  = 0;
						if ( fkcart_is_preview() ) {
							$price      = $front->get_dummy_product_price( $cart_item );
							$product_id = $cart_item['product_id'];
						} else {
							/**
							 * @var $_product WC_Product
							 */
							$_product    = $cart_item['product'];
							$is_variable = ( fkcart_is_variable_product_type( $_product->get_type() ) );
							$price       = $is_variable ? wc_price( $_product->get_variation_price() ) : ( $_product->is_on_sale() || $_product->is_taxable() ? $_product->get_price_html() : wc_price( $cart_item['product_price'] ) );
							$button      = $is_variable ? __( 'Select options', 'woocommerce' ) : __( 'Add', 'woocommerce' );
							$product_id  = $_product->get_id();
						}
						?>
                        <div class="fkcart--item" data-key="<?php esc_attr_e( $cart_item_key ) ?>">
							<?php echo wp_kses_post( $cart_item['thumbnail'] ) ?>
                            <div class="fkcart-item-info">
                                <div class="fkcart-item-meta">
									<?php echo wp_kses_post( $cart_item['product_name'] ) ?>
                                    <div class="fkcart-item-meta-content"><?php echo wp_kses_post( $cart_item['product_meta'] ) ?></div>
                                    <div class="fkcart-item-price">
										<?php echo wp_kses_post( $price ) ?>
                                    </div>
                                    <div class="fkcart-<?php echo( $is_variable ? 'select-product' : 'add-product-button' ) ?> fkcart-button" data-id="<?php esc_html_e( $product_id ); ?>">
										<?php esc_attr_e( $button ) ?>
                                    </div>
                                </div>
                            </div>
                            <!-- display on mobile screen -->
                            <div class="fkcart-item-misc">
                                <div class="fkcart-item-price"><?php echo wp_kses_post( $price ) ?></div>
                            </div>
                        </div>
						<?php
					}
					?>
                </div>
            </div>
            <div class="fkcart-nav-btn fkcart-nav-btn--prev" type="button" disabled="disabled" data-hide="desktop">
				<?php fkcart_get_template_part( 'icon/arrow', '', [ 'direction' => 'left' ] ); ?>
            </div>
            <div class="fkcart-nav-btn fkcart-nav-btn--next" type="button" data-hide="desktop">
				<?php fkcart_get_template_part( 'icon/arrow', '', [ 'direction' => 'right' ] ); ?>
            </div>
            <!-- Carousel Dots -->
            <div class="fkcart-carousel-dots" data-hide="desktop"></div>
            <script type="text/template" id="fkcart-carousel-dot-template">
                <div class="fkcart-carousel-dot" type="button"></div>
            </script>
        </div>
    </div>
</div>
<!-- END: Style 3 -->
