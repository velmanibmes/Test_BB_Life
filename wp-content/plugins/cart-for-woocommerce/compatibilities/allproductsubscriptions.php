<?php
/**
 * https://woo.com/documentation/products/extensions/all-products-for-woocommerce-subscriptions/
 */

namespace FKCart\Compatibilities;
class AllProductSubscriptions {
	public function __construct() {
		add_action( 'fkcart_before_add_to_cart', [ $this, 'remove_subscription_action' ] );
		add_action( 'fkcart_quick_before_view_content', [ $this, 'add_wrapper' ] );
	}

	public function is_enable() {
		return class_exists( '\WCS_ATT_Cart' );
	}

	public function remove_subscription_action() {
		if ( isset( $_REQUEST['subscribe-to-action-input'] ) && 'no' === $_REQUEST['subscribe-to-action-input'] ) {
			remove_filter( 'woocommerce_add_cart_item_data', array( 'WCS_ATT_Cart', 'add_cart_item_data' ), 10 );
		}
	}

	public function add_wrapper() {
		add_action( 'woocommerce_before_add_to_cart_form', [ $this, 'open_div' ] );
		add_action( 'woocommerce_after_add_to_cart_form', [ $this, 'close_div' ] );
	}

	public function open_div() {
		//add product wrapper over the form field because  All product subscription needed
		echo "<div class='product'>";
	}

	public function close_div() {
		echo "</div>";
		$this->js();
	}

	public function js() {
		?>
        <script>
            setTimeout(() => {
                try {
                    jQuery('.fkcart-product-form-field')?.wcsatt_initialize()
                } catch (e) {

                }
            }, 500);
        </script>
		<?php
	}
}

Compatibility::register( new AllProductSubscriptions(), 'allproductsubscriptions' );
