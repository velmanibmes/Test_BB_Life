<?php
/**
 * @var $item_data []
 */
foreach ( $item_data as $data ) {
	echo sprintf( '<span class="fkcart-attr-wrap"><span class="fkcart-attr-key" data-attr-key="%1$s">%1$s:</span><span class="fkcart-attr-value">%2$s</span></span>', wp_kses_post( $data['key'] ), wp_kses_post( $data['display'] ) ) . "\n";
}
