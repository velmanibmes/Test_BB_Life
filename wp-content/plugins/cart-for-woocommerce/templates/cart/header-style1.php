<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$settings = \FKCart\Includes\Data::get_settings();
?>
<div class="fkcart-slider-heading fkcart-panel">
    <div class="fkcart-title"><?php esc_html_e( $settings['cart_heading'] ) ?></div>
    <div class="fkcart-modal-close">
		<?php fkcart_get_template_part( 'icon/close', '', [ 'width' => 20, 'height' => 20 ] ); ?>
    </div>
</div>