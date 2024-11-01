<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * @var $cart_item []
 * @var $cart_item_key string
 */
$front                = \FKCart\Includes\Front::get_instance();
$is_you_saved_enabled = \FKCart\Includes\Data::is_you_saved_enabled();
$you_save_text        = \FKCart\Includes\Data::you_save_text();
/** @var WC_Product $_product */
$_product = $cart_item['product'];
?>
<div class="fkcart--item fkcart-panel <?php echo $cart_item['_fkcart_free_gift'] ? 'fkcart-free-item' : '' ?>" data-key="<?php esc_attr_e( $cart_item_key ) ?>">
	<?php echo wp_kses_post( $cart_item['thumbnail'] ) ?>
    <div class="fkcart-item-info">
        <div class="fkcart-item-meta">
			<?php echo wp_kses_post( $cart_item['product_name'] ) ?>
			<?php
			do_action( 'fkcart_before_item_meta', $cart_item );
			if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
				echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $_product->get_id() ) );
			}
			?>
            <div class="fkcart-item-meta-content"><?php echo wp_kses_post( $cart_item['product_meta'] ) ?></div>
			<?php
			if ( fkcart_is_variation_product_type( $_product->get_type() ) && ! $cart_item['_fkcart_variation_gift'] && false === $cart_item['is_child_item'] ) {
				$select_options_label = apply_filters( 'fkcart_select_options_label', __( 'Select options', 'woocommerce' ), $cart_item );
				?>
                <div class="fkcart-item-meta-content">
                    <a href="javascript:void(0)" class="fkcart-select-options" data-key="<?php esc_attr_e( $cart_item_key ) ?>" data-product="<?php esc_attr_e( $_product->get_parent_id() ) ?>" data-variation="<?php esc_attr_e( $_product->get_id() ) ?>"><?php esc_attr_e( $select_options_label ) ?></a>
                </div>
				<?php
			}
			?>
			<?php do_action( 'fkcart_after_item_meta', $cart_item, $cart_item_key ); ?>
        </div>
        <div class="fkcart-line-item">
			<?php
			do_action( 'fkcart_before_item_quantity', $cart_item );
			if ( ! $cart_item['sold_individually'] ) {
				echo '<div class="fkcart-quantity-selector">';
				list( $min, $max, $step ) = $front->get_min_max_step( $_product );
				?>
                <div class="fkcart-quantity-button fkcart-quantity-down" data-action="down">
					<?php fkcart_get_template_part( 'icon/minus' ); ?>
                </div>
                <input class="fkcart-quantity__input" name="fkcart-quantity__input" type="text" aria-label="Quantity" inputmode="numeric" step="<?php esc_attr_e( $step ) ?>" min="<?php esc_attr_e( $min ) ?>" max="<?php esc_attr_e( $max ) ?>" data-key="<?php esc_attr_e( $cart_item_key ) ?>" pattern="[0-9]*" value="<?php esc_attr_e( $cart_item['quantity'] ) ?>">
                <div class="fkcart-quantity-button fkcart-quantity-up" data-action="up">
					<?php fkcart_get_template_part( 'icon/plus' ); ?>
                </div>
				<?php
				echo '</div>';
			}
			do_action( 'fkcart_after_item_quantity', $cart_item );
			if ( false === $cart_item['_fkcart_free_gift'] ) {
				?>
                <div class="fkcart-remove-item" data-key="<?php esc_attr_e( $cart_item_key ) ?>">
					<?php fkcart_get_template_part( 'icon/close', '', [ 'width' => 10, 'height' => 10 ] ); ?>
                </div>
				<?php
			}
			?>
        </div>
    </div>
    <div class="fkcart-item-misc">
        <div class="fkcart-item-price">
			<?php echo wp_kses_post( $cart_item['price'] ) ?>
        </div>
		<?php
		if ( $is_you_saved_enabled && false === $cart_item['hide_you_saved_text'] ) {
			$you_save = $front->you_saved_price( $_product, $cart_item['quantity'] );
			if ( is_array( $you_save ) && ! empty( $you_save['percentage'] ) ) {
				$amount = $you_save['amount'];
				if ( strpos( $you_save_text, '{{saving_amount}}' ) !== false ) {
					$you_save_text = str_replace( '{{saving_amount}}', '<span class="fkcart_item_saving_amount">' . wc_price( $amount ) . '</span>', $you_save_text );
				}
				if ( strpos( $you_save_text, '{{saving_percentage}}' ) !== false ) {
					$you_save_text = str_replace( '{{saving_percentage}}', '<span class="fkcart_item_saving_percentage">' . $you_save['percentage'] . '%</span>', $you_save_text );
				}
				?>
                <div class="fkcart-discounted-price">
                    <div class="fkcart-discounted-text"><?php echo $you_save_text; ?></div>
                </div>
				<?php
			}
		}
		?>
    </div>
</div>
