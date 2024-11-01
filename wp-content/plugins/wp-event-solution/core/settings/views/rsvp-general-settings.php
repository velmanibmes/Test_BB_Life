<?php
use Etn\Utils\Helper;

?>
<!-- General settings data tab -->
<div class="etn-settings-section attr-tab-pane" data-id="tab_rsvp" id="etn-rsvp">
    <div class="etn-settings-tab-wrapper etn-settings-tab-style">
        <ul class="etn-settings-nav">
            <?php do_action( 'etn_before_rsvp_settings_tab' );?>
            <li>
                <a class="etn-settings-tab-a etn-settings-active" data-id="general-settings">
                    <?php echo esc_html__( 'General Settings', 'eventin' ); ?>
                    <svg width="14" height="13" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M64 448c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L178.8 256L41.38 118.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l160 160c12.5 12.5 12.5 32.75 0 45.25l-160 160C80.38 444.9 72.19 448 64 448z"></path></svg>
                </a>
            </li>
            <?php do_action( 'etn_after_rsvp_settings_tab' );?>
        </ul>

        <div class="etn-settings-tab-content">
            <?php do_action( 'etn_before_rsvp_settings_tab_content' );?>
            <div class="etn-settings-tab" id="general-settings">
                <div class="general-settings-wrap">
                    <?php
                    	$rsvp_auto_confirm                          = isset( $settings['rsvp_auto_confirm'] ) ? 'checked' : '';
                    	$rsvp_auto_confirm_send_email               = isset( $settings['rsvp_auto_confirm_send_email'] ) ? 'checked' : '';
                    	$rsvp_display_form_only_for_logged_in_users = isset( $settings['rsvp_display_form_only_for_logged_in_users'] ) ? 'checked' : '';
                    	$rsvp_min_attendees                         = isset( $settings['rsvp_min_attendees'] ) ? $settings['rsvp_min_attendees'] : 0;
                    	$rsvp_auto_confirm_send_email_class         = ( $rsvp_auto_confirm_send_email == 'checked' ) ? 'rsvp_section' : 'rsvp_section_hide';
						$rsvp_auto_confirm_send_email_body          = isset( $settings['rsvp_auto_confirm_send_email_body'] ) ? html_entity_decode( $settings['rsvp_auto_confirm_send_email_body'] ) : '';
					?>
					<div class="attr-form-group etn-label-item">
						<div class="etn-label">
							<label>
							<?php esc_html_e( 'Auto Confirmation for RSVP', 'eventin' );?>
							</label>
							<div class="etn-desc">
								<?php esc_html_e( 'Enable auto confirmation for RSVP', 'eventin' );?>
							</div>
						</div>
						<?php 
							if(!class_exists( 'Wpeventin_Pro' )){ 
								echo Helper::get_pro();
							} else {
						?>
						<div class="etn-meta">
							<input id="rsvp_auto_confirm" type="checkbox" <?php echo esc_html( $rsvp_auto_confirm ); ?> class="etn-admin-control-input" name="rsvp_auto_confirm" />
							<label for="rsvp_auto_confirm" class="etn_switch_button_label"></label>
						</div>
						<?php } ?>
					</div>
					<div class="attr-form-group etn-label-item">
						<div class="etn-label">
							<label>
							<?php esc_html_e( 'Send Email to Auto Confirmation Mode', 'eventin' );?>
							</label>
							<div class="etn-desc">
								<?php esc_html_e( 'Write email body to send email to auto confirmation for RSVP', 'eventin' );?>
							</div>
						</div>
						<?php 
							if(!class_exists( 'Wpeventin_Pro' )){ 
								echo Helper::get_pro();
							} else {
						?>
						<div class="etn-meta">
							<input id="rsvp_auto_confirm_send_email" type="checkbox" <?php echo esc_html( $rsvp_auto_confirm_send_email ); ?> class="etn-admin-control-input" name="rsvp_auto_confirm_send_email" />
							<label for="rsvp_auto_confirm_send_email" class="etn_switch_button_label"></label>
						</div>
						<?php } ?>
					</div>
					<div class="rsvp_auto_confirm_send_email_block <?php echo esc_attr( $rsvp_auto_confirm_send_email_class ); ?>">
						<div class="attr-form-group etn-label-item">
							<div class="etn-label">
								<label>
								<?php esc_html_e( 'Auto confirmation email body', 'eventin' );?>
								</label>
								<div class="etn-desc">
									<?php esc_html_e( 'Write message body to send email to attendee when auto confirmation mode is enable', 'eventin' );?>
								</div>
							</div>
							<?php 
								if(!class_exists( 'Wpeventin_Pro' )){ 
									echo Helper::get_pro();
								} else {
							?>
							<div class="etn-meta">
								<label for="rsvp_auto_confirm_send_email_body" class=""></label>
								<?php wp_editor($rsvp_auto_confirm_send_email_body, 'rsvp_auto_confirm_send_email_body', ['textarea_name'=> 'rsvp_auto_confirm_send_email_body', 'media_buttons' => false, 'wpautop' => true]); ?>
							</div>
							<?php } ?>
						</div>
					</div>
					<div class="attr-form-group etn-label-item">
						<div class="etn-label">
							<label>
								<?php esc_html_e( 'Display Form Only for Logged in Users', 'eventin' );?>
							</label>
							<div class="etn-desc">
								<?php esc_html_e( 'Display the RSVP form only for logged in users', 'eventin' );?>
							</div>
						</div>
						<?php 
							if(!class_exists( 'Wpeventin_Pro' )){ 
								echo Helper::get_pro();
							} else {
						?>
							<div class="etn-meta">
								<input id="rsvp_display_form_only_for_logged_in_users" type="checkbox"							                                                                      							                                                                      							                                                                       <?php echo esc_html( $rsvp_display_form_only_for_logged_in_users ); ?> class="etn-admin-control-input" name="rsvp_display_form_only_for_logged_in_users" />
								<label for="rsvp_display_form_only_for_logged_in_users" class="etn_switch_button_label"></label>
							</div>
						<?php } ?>
					</div>
					<div class="attr-form-group etn-label-item">
						<div class="etn-label">
							<label>
								<?php esc_html_e( 'Minimum Attendees to Start The Event', 'eventin' );?>
							</label>
							<div class="etn-desc">
								<?php esc_html_e( 'Minimum attendees to start the event', 'eventin' );?>
							</div>
						</div>
						<?php 
							if(!class_exists( 'Wpeventin_Pro' )){ 
								echo Helper::get_pro();
							} else {
						?>
						<div class="etn-meta">
							<input type="number" name="rsvp_min_attendees" step="1" value="<?php echo esc_attr( isset( $rsvp_min_attendees ) ? $rsvp_min_attendees : 0 ); ?>" class="etn-setting-input attr-form-control">
						</div>
						<?php } ?>
					</div>
                </div>
            </div>
            <?php do_action( 'etn_after_rsvp_settings_tab_content' );?>
        </div>
    </div>
</div>
<!-- End RSVP Tab -->
