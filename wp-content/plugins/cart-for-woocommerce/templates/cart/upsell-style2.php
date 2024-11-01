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
?>
<!-- START: Style 2 -->
<div class="fkcart-item-wrap fkcart-carousel-wrap fkcart-upsell-style2">
    <div class="fkcart--item-heading fkcart-upsell-heading fkcart-t--center fkcart-panel"><?php esc_html_e( isset( $settings['upsell_heading'] ) ? $settings['upsell_heading'] : __( 'Even better With These!', 'cart-for-woocommerce' ) ); ?></div>
    <div class="fkcart-carousel fkcart-panel">
        <!-- make data-slide-item count 2 for grid/column view -->
        <div class="fkcart-carousel__viewport" data-slide-item="2" data-count="<?php esc_attr_e( count( $cart_contents ) ); ?>">
            <div class="fkcart-carousel__container">
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
						$_product = $cart_item['product'];

						$is_variable = ( fkcart_is_variable_product_type( $_product->get_type() ) );
						$price       = $is_variable ? wc_price( $_product->get_variation_price() ) : ($_product->is_on_sale() ||  $_product->is_taxable() ? $_product->get_price_html() : wc_price( $cart_item['product_price'] ) );
						$button      = $is_variable ? __( 'Select options', 'woocommerce' ) : $button;
						$product_id  = $_product->get_id();
					}
					?>
                    <!-- Cart Item -->
                    <div class="fkcart--item fkcart-carousel__slide" data-key="<?php esc_attr_e( $cart_item_key ) ?>">
						<?php echo wp_kses_post( $cart_item['thumbnail'] ) ?>
                        <div class="fkcart-item-info">
                            <div class="fkcart-item-meta">
								<?php echo wp_kses_post( $cart_item['product_name'] ) ?>
                                <div class="fkcart-item-meta-content"><?php echo wp_kses_post( $cart_item['product_meta'] ) ?></div>
                            </div>
                        </div>
                        <div class="fkcart-<?php echo( $is_variable ? 'select-product' : 'add-product-button' ) ?> fkcart-button fkcart-full-width" data-id="<?php esc_attr_e( $product_id ); ?>">
							<?php esc_attr_e( $button ) ?>
							<?php
							if ( ! $is_variable ) {
								?>
                                - &nbsp;
                                <div class="fkcart-item-price"><?php echo wp_kses_post( $price ) ?></div>
								<?php
							}
							?>
                        </div>
                    </div>
					<?php
				}
				?>
            </div>
        </div>

        <!-- Carousel Navigation -->
        <div class="fkcart-nav-btn fkcart-nav-btn--prev" type="button">
			<?php fkcart_get_template_part( 'icon/arrow', '', [ 'direction' => 'left' ] ); ?>
        </div>
        <div class="fkcart-nav-btn fkcart-nav-btn--next" type="button">
			<?php fkcart_get_template_part( 'icon/arrow', '', [ 'direction' => 'right' ] ); ?>
        </div>
        <!-- Carousel Dots -->
        <div class="fkcart-carousel-dots"></div>
        <script type="text/template" id="fkcart-carousel-dot-template">
            <div class="fkcart-carousel-dot" type="button"></div>
        </script>
    </div>
</div>
<!-- END: Style 2 -->
