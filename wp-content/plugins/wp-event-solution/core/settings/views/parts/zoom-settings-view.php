<!-- Zoom data tab -->
<?php

use Eventin\Integrations\Zoom\ZoomCredential;

$authorize_url = 'https://zoom.us/oauth/authorize';
$redirect_uri  = ZoomCredential::get_redirect_uri();

$args = [
	'response_type' => 'code',
	'redirect_uri'  => $redirect_uri,
	'client_id'     => $zoom_client_id
];

$connect_button_url = add_query_arg( $args, $authorize_url );

?>
<div class="etn-settings-section attr-tab-pane" data-id="tab5" id="etn-user_data">
    <div class="etn-settings-tab-wrapper etn-settings-tab-style">
        <ul class="etn-settings-nav">

            <?php do_action( 'etn_before_integration_settings_inner_tab_heading' ); ?>
            <li>
                <a class="etn-settings-tab-a"  data-id="zoom-options">
                    <?php echo esc_html__('Zoom Settings', 'eventin'); ?>
                    <svg width="14" height="13" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M64 448c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L178.8 256L41.38 118.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l160 160c12.5 12.5 12.5 32.75 0 45.25l-160 160C80.38 444.9 72.19 448 64 448z"></path></svg>
                </a>
            </li>
            <?php do_action( 'etn_after_integration_settings_inner_tab_heading' ); ?>
            
        </ul>

        <div class="etn-settings-tab-content">
            <?php do_action( 'etn_before_integration_settings' ); ?>
            <div class="etn-settings-tab" id="zoom-options">                
                <div class="attr-form-group etn-label-item">
                    <div class="etn-label">
                        <label>
                            <?php esc_html_e('Zoom', 'eventin'); ?>
                        </label>
                        <div class="etn-desc"> <?php esc_html_e('You will get all zoom options and shortcode to show meeting.', 'eventin'); ?> </div>
                    </div>
                    <div class="etn-meta">
                        <input id="zoom_api" type="checkbox" <?php echo esc_html($etn_zoom_api); ?> class="etn-admin-control-input" name="etn_zoom_api" />
                        <label for="zoom_api" data-left="Yes" data-right="No" class="etn_switch_button_label"></label>
                    </div>
                </div>
                <div class="zoom_block <?php echo esc_attr($zoom_class); ?>">
                    <div class="attr-form-group etn-label-item">
                        <div class="etn-label">
                            <label class="etn-setting-label" for="zoom_client_id"><?php esc_html_e('Client ID', 'eventin'); ?></label>
                            <div class="etn-desc"> <?php esc_html_e('Place your client ID here that you get from zoom account', 'eventin'); ?> </div>
                        </div>
                        <div class="etn-meta">
                            <div class="etn-secret-key">
                                <input type="password" class="etn-setting-input attr-form-control" name="zoom_client_id" value="<?php echo esc_attr($zoom_client_id); ?>" id="zoom_client_id" />
                                <span><i class="etn-icon etn-eye-slash eye_toggle_click"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="attr-form-group etn-label-item etn-label-top">
                        <div class="etn-label">
                            <label class="etn-setting-label" for="zoom_client_secret"><?php esc_html_e('Client Secret', 'eventin'); ?></label>
                            <div class="etn-desc"> <?php esc_html_e('Place client secret here that you get from zoom account', 'eventin'); ?> </div>
                        </div>
                        <div class="etn-meta">
                            <div class="etn-secret-key">
                                <input type="password" class="etn-setting-input attr-form-control" name="zoom_client_secret" value="<?php echo esc_attr($zoom_client_secret); ?>" id="zoom_client_secret" />
                                <span><i class="etn-icon etn-eye-slash eye_toggle_click"></i></span>
                            </div>                           
                        </div>
                    </div>
					<div class="attr-form-group etn-label-item etn-label-top">
                        <div class="etn-label">
                            <label class="etn-setting-label" for="zoom_redirect_url"><?php esc_html_e('Redirect URL', 'eventin'); ?></label>
                            <div class="etn-desc"> <?php esc_html_e('Place this redirect URL in the zoom app settings', 'eventin'); ?> </div>
                        </div>
                        <div class="etn-meta">
                            <div class="etn-secret-key">
                                <input type="text" class="etn-setting-input attr-form-control" name="zoom_redirect_url" value="<?php echo esc_attr($redirect_uri); ?>" id="zoom_redirect_url" readonly />
                            </div>                           
                        </div>
                    </div>
                    <div class="attr-form-group etn-label-item etn-label-connection etn-label-top">
                        <div class="etn-label">
                            <label class="etn-setting-label" for="zoom_secret_key"><?php esc_html_e('Check Connection', 'eventin'); ?></label>
                            <div class="etn-desc"> 
                                <?php esc_html_e('Client ID and Client Secret must be entered before checking connection status. For more details, please check official', 'eventin'); ?> 
                                <a href="<?php echo esc_url('//support.themewinter.com/docs/plugins/eventin/zoom-meeting-2/')?>" target="_blank" rel="noopener">
                                    <?php esc_html_e('Documentation', 'eventin'); ?> 
                                </a>
                            </div>
                        </div>
                        <div class="etn-meta">
                            <div class="etn-api-connect-wrap" style="display:flex; flex-direction:column; align-items:end;">
                                <div style="<?php echo ($zoom_client_secret === '' || $zoom_client_id === '') ? " cursor: not-allowed;" :  " cursor: pointer;"?>">
                                    <a style="<?php echo ($zoom_client_secret === '' || $zoom_client_id === '') ? "pointer-events: none;" :  "pointer-events: auto; "?>" href="<?php echo esc_url($connect_button_url); ?>" class="etn-btn-text connect_zoom"><?php echo esc_html__('connect', 'eventin') ?></a>
                                </div>
                                <?php if($zoom_client_secret === '' || $zoom_client_id === '') {
                                ?>
                                    <span style="color:red;">Please provide client id and client secrect first!</span>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
            <?php do_action( 'etn_after_integration_settings' ); ?>           
        </div>
    </div>
</div>
<!-- End Zoom Tab -->