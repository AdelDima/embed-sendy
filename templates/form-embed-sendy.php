<?php
/**
 * Embed Sendy form.
 *
 * @package ESD
 */

$esd_settings = get_option( 'esd_settings' );

if ( ! is_array( $esd_settings ) ) return;

// Bail early if no lists found.
if ( ! array_key_exists( 'esd_lists', $esd_settings ) || ! array_key_exists( 'esd_url', $esd_settings ) ) return;

$show_name = isset( $esd_settings['esd_show_name'] ) ? $esd_settings['esd_show_name'] : false;

global $wp;
$user = false;

if ( is_user_logged_in() ) {
	$user = get_userdata( get_current_user_id() );
	$user = $user->data;
}

$class = 'esd-form';

if ( isset( $is_block ) ) {
	$class .= ' esd-form--block';
}

if ( $show_name ) {
	$class .= ' esd-form--show-name';
}

?>

<?php do_action( 'embed_sendy_form_before', $list ); ?>

<form id="js-esd-form" class="<?php echo esc_attr( $class ); ?>" action="<?php echo esc_url( $esd_settings['esd_url'] ); ?>/subscribe" method="post" target="_blank">
	<?php do_action( 'embed_sendy_form_start', $list ); ?>

	<div class="esd-form__row esd-form__fields">
		<?php if ( $show_name ) : ?>
		<input type="text" name="name" placeholder="<?php esc_attr_e( 'Name', 'esd' ); ?>" value="<?php echo esc_attr( $user->display_name ); ?>">
		<?php endif; ?>

		<input type="email" name="email" placeholder="<?php esc_attr_e( 'Email', 'esd' ); ?>" value="<?php echo ( $user ) ? esc_attr( $user->user_email ) : ''; ?>" required>
		<input type="submit" value="<?php esc_attr_e( 'Subscribe', 'esd' ); ?>">
		<input type="text" name="hp" id="hp" style="display:none">
		<input type="hidden" name="list" value="<?php echo esc_attr( $list ); ?>">
		<input type="hidden" name="ipaddress" value="<?php echo esc_attr( ESD()->ip_address() ); ?>">
		<input type="hidden" name="referrer" value="<?php echo esc_attr( wp_get_referer() ); ?>">

		<?php do_action( 'embed_sendy_form_fields', $list ); ?>
	</div>

	<?php do_action( 'embed_sendy_form_end', $list ); ?>

	<?php if ( isset( $is_block ) ) : ?>
	<style>
		<?php if ( isset( $background_color ) ) : ?>
		.esd-form--block { background-color: <?php echo esc_html( $background_color ); ?> }
		<?php endif; ?>
		<?php if ( isset( $text_color ) ) : ?>
		.esd-form--block { color: <?php echo esc_html( $text_color ); ?> }
		<?php endif; ?>
	</style>
	<?php endif; ?>
</form><!-- #js-embed-sendy.embed-sendy -->

<?php do_action( 'embed_sendy_form_after', $list ); ?>
