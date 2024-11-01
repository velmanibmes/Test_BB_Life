<!-- Domain Registration data tab -->
<div class="etn-settings-section attr-tab-pane" data-id="tab_advance" id="etn-advance"> 
    <div class="etn-settings-tab-wrapper etn-settings-tab-style">
        <ul class="etn-settings-nav">
            <?php do_action( 'etn_before_advance_settings_tab' ); ?>
            <li>
                <a class="etn-settings-tab-a"  data-id="domain-registration">
                    <?php echo esc_html__('Domain Registration', 'eventin'); ?>
                    <svg width="14" height="13" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M64 448c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L178.8 256L41.38 118.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l160 160c12.5 12.5 12.5 32.75 0 45.25l-160 160C80.38 444.9 72.19 448 64 448z"></path></svg>
                </a>
            </li> 
            <?php do_action( 'etn_after_advance_settings_tab' ); ?>
        </ul>

        <div class="etn-settings-tab-content">
            <?php do_action( 'etn_before_advance_settings_tab_content' ); ?>
            <div class="etn-settings-tab" id="domain-registration"> 
                <div class="domains">
                    <?php 
                        $domains = isset( $settings['external_domain'] ) ? $settings['external_domain'] : []; 
                    ?> 
                    
                    <?php if ( $domains ): ?>
                        <?php foreach( $domains as $domain ): ?>
                            <div class="attr-form-group etn-label-item etn-label-top">
                                <div class="etn-meta">
                                    <input 
                                        type="text"
                                        name="external_domain[]"
                                        placeholder="example.com"
                                        class="etn-setting-input attr-form-control"
                                        value="<?php echo $domain; ?>" 
                                    >
                                </div>
                                <button class="etn-remove-btn remove-domain">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                </button>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <?php 
                    if(!class_exists( 'Wpeventin_Pro' )){ 
                        echo Etn\Utils\Helper::get_pro();
                    } else {
                ?>
                    <button class="etn-btn-text add-domain"><?php esc_html_e( 'Add Domain', 'eventin' ); ?></button>
                <?php } ?>
            </div>
            <?php do_action( 'etn_after_advance_settings_tab_content' );?>         
        </div>
    </div>
</div>
<!-- End Domain Registration Tab -->
