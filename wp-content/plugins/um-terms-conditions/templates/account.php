<?php
/**
 * Template for the "Terms & Conditions" account tab.
 *
 * This template can be overridden by copying it to yourtheme/ultimate-member/um-terms-conditions/account.php
 *
 * @package um_ext\um_terms_conditions\templates
 * @version 2.1.6
 *
 * @var string $content
 * @var string $error
 * @var string $key
 * @var object $post
 * @var int    $post_id
 * @var string $text_agreement
 * @var string $text_hide
 * @var string $text_show
 * @var bool   $value
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wp_enqueue_script( 'um-terms-conditions' );
wp_enqueue_style( 'um-terms-conditions' );
?>

<div class="um-terms-conditions-account">
	<div class="um-field-area">
		<div class="um-terms-conditions-content">
			<div class="um-terms-conditions-controls">
				<a href="javascript:void(0);" class="um-hide-terms um-link"><?php echo esc_html( $text_hide ); ?></a><br>
			</div>
			<div class="um-terms-conditions-post-content"><?php echo wp_kses_post( $content ); ?></div>
			<div class="um-terms-conditions-controls"></div>
		</div>

		<a href="javascript:void(0);" class="um-toggle-terms um-link"
			data-toggle-show="<?php echo esc_attr( $text_show ); ?>"
			data-toggle-hide="<?php echo esc_attr( $text_hide ); ?>">
			<?php echo esc_html( $text_hide ); ?>
		</a>
	</div>

	<?php
	UM()->fields()->checkbox( $key, $text_agreement, $value );
	echo wp_kses_post( UM()->fields()->field_error( $error, $key ) );
	?>
</div>
