<?php

namespace Etn\Core\Settings;
use Etn\Utils\Helper;
use EventinPro\Integrations\Google\GoogleCredential;

defined( "ABSPATH" ) || exit;

class Pro_Settings extends \Etn\Core\Settings\Base\Config {

    use \Etn\Traits\Singleton;

    public $textdomain = 'eventin';

    /**
     * Call all hooks
     */
    public function init() {
        // add filter to add more settings
        add_filter( 'eventin/settings/pro_settings', [$this, 'add_general_settings'] );
        
        if( class_exists( 'Wpeventin_Pro' )){ 
            add_filter( 'etn_event_templates', [$this, 'add_event_pro_template_options'] );
            add_filter( 'etn_speaker_templates', [$this, 'add_speaker_pro_template_options'] );
        }

        add_action( 'etn_after_notification_settings', [$this, 'after_notification_settings'] );
        add_action( 'etn_after_parchase_report_settings', [$this, 'etn_after_purchase_report_settings'] );

        add_action( 'etn_after_purchase_report_settings', [$this, 'etn_after_purchase_report_settings_fields'] );
        add_action( 'etn_after_woocommerce_fields_settings', [$this, 'etn_after_woocommerce_fields_settings'] );

        add_action( 'etn_after_integration_settings', [$this, 'after_integration_settings_grounhogg'], 10 );
        add_action( 'etn_after_integration_settings', [$this, 'after_integration_settings_google_mapapi'], 15 );

        add_action( 'etn_after_integration_settings_inner_tab_heading', [$this, 'after_integration_settings_inner_tabs'], 10 );
        add_filter( 'eventin/settings/tab_titles', [ $this, 'add_advance_tab' ], 10 );

        add_action( 'etn_after_integration_settings_inner_tab_heading', [$this, 'after_integration_settings_google_meet_tabs'], 15 );
        add_action( 'etn_after_integration_settings', [$this, 'after_integration_settings_google_meet_api'], 20 );

        add_action('etn_after_integration_settings_inner_tab_heading', [$this, 'after_integration_settings_eventin_ai_tab'], 25);
        add_action('etn_after_integration_settings', [$this, 'after_integration_settings_eventin_ai'], 30);

        // Add subtab on settings maing tab.
        add_action( 'etn_before_advance_settings_tab', [$this, 'add_advance_settings_tab'] );

        // Add subtab content on advance tab settings.
        add_action( 'etn_before_advance_settings_tab_content', [$this, 'add_advance_settings_tab_content'] );

        // RSVP Tab
        add_filter( 'eventin/settings/tab_titles', [$this, 'add_rsvp_tab'], 15 );
    }

    /**
     * After Notification Settings
     *
     * @since 2.4.2
     *
     * @return void
     */
    public function after_notification_settings() {
        if ( file_exists( \Wpeventin::core_dir() . "/settings/views/email-notification-settings.php" ) ) {
            include_once \Wpeventin::core_dir() . "/settings/views/email-notification-settings.php";
        }

    }

    /**
     * After purchase report Settings
     *
     * @since 2.4.2
     *
     * @return void
     */
    public function etn_after_woocommerce_fields_settings() {

        $settings = \Etn\Core\Settings\Settings::instance()->get_settings_option();
        $etn_count_refund_price = ( isset( $settings['etn_count_refund_price'] ) ? 'checked' : '' );
        $etn_show_print_download_on_thankyou = ( isset( $settings['etn_show_print_download_on_thankyou'] ) ? 'checked' : '' );

        ?>
        <div class="attr-form-group etn-label-item" id="etn-count-refund-price-wrap">
            <div class="etn-label">
                <label>
                    <?php esc_html_e( 'Count Refunded / Failed Order In Purchase Report', 'eventin' );?>
                </label>
                <div class="etn-desc"> <?php esc_html_e( 'Include cost for refunded / failed tickets in purchase history.', 'eventin' );?> </div>
            </div>
            <?php 
                if(!class_exists( 'Wpeventin_Pro' )){ 
                    echo Helper::get_pro();
                } else {
            ?>
            <div class="etn-meta">
                <input id='etn_count_refund_price' type="checkbox" <?php echo esc_html( $etn_count_refund_price ); ?> class="etn-admin-control-input etn-form-modalinput-paypal_sandbox" name="etn_count_refund_price" />
                <label for="etn_count_refund_price" class="etn_switch_button_label"></label>
            </div>
            <?php } ?>
        </div>
            
        <div class="attr-form-group etn-label-item" id="etn-show-print-download-wrap">
            <div class="etn-label">
                <label>
                    <?php esc_html_e( 'Show Print / Download Invoice On Thankyou Page', 'eventin' );?>
                </label>
                <div class="etn-desc"> <?php esc_html_e( 'Show button for downloading / printing order invoice.', 'eventin' );?> </div>
            </div>
            <?php 
                if(!class_exists( 'Wpeventin_Pro' )){ 
                    echo Helper::get_pro();
                } else {
            ?>
                <div class="etn-meta">
                    <input id='etn_show_print_download_on_thankyou' type="checkbox" <?php echo esc_html( $etn_show_print_download_on_thankyou ); ?> class="etn-admin-control-input etn-form-modalinput-paypal_sandbox" name="etn_show_print_download_on_thankyou" />
                    <label for="etn_show_print_download_on_thankyou" class="etn_switch_button_label"></label>
                </div>
            <?php } ?>
        </div>
        <?php
    }

    /**
     * After purchase report Settings
     *
     * @since 2.4.2
     *
     * @return void
     */
    public function etn_after_purchase_report_settings_fields() {

        $settings = \Etn\Core\Settings\Settings::instance()->get_settings_option();
        $etn_stripe_test_mode = (isset($settings['etn_stripe_test_mode']) ? 'checked' : '');
        $stripe_test_publishable_key = (isset($settings['stripe_test_publishable_key']) ? $settings['stripe_test_publishable_key'] : '');
        $stripe_test_secret_key = (isset($settings['stripe_test_secret_key']) ? $settings['stripe_test_secret_key'] : '');
        $stripe_live_publishable_key = (isset($settings['stripe_live_publishable_key']) ? $settings['stripe_live_publishable_key'] : '');
        $stripe_live_secret_key = (isset($settings['stripe_live_secret_key']) ? $settings['stripe_live_secret_key'] : '');

        $etn_stripe_payment_logo = ( ! empty( $settings['etn_stripe_payment_logo'] ) ? $settings['etn_stripe_payment_logo']: '' );
        
        $etn_sells_engine_stripe = (isset($settings['etn_sells_engine_stripe']) ? 'checked' : '');
        $stripe_class = ( $etn_sells_engine_stripe == 'checked' ) ?  'stripe_section' : 'stripe_section_hide';

        $etn_stripe_test_mode = (isset($settings['etn_stripe_test_mode']) ? 'checked' : '');
        $test_mode_class = ( $etn_stripe_test_mode == 'checked' ) ?  'test_key_section' : 'test_key_section_hide';

        ?>

        <div class="attr-form-group etn-label-item etn-label-top">
            <div class="etn-label">
                <label>
                    <?php esc_html_e('Stripe', 'eventin'); ?>
                </label>
                <div class="etn-desc mb-2"> <?php esc_html_e('Enable stripe payment', 'eventin'); ?> </div>
            </div>
            <?php 
                if(!class_exists( 'Wpeventin_Pro' )){ 
                    echo Helper::get_pro();
                } else {
            ?>
                <div class="etn-meta">
                    <input id="etn_sells_engine_stripe" type="checkbox" <?php echo esc_html($etn_sells_engine_stripe); ?> class="etn-admin-control-input" name="etn_sells_engine_stripe" value="stripe" />
                    <label for="etn_sells_engine_stripe" data-left="Yes" data-right="No" class="etn_switch_button_label"></label>
                </div>
            <?php } ?>
            <div class="stripe-payment-methods <?php echo esc_attr($stripe_class); ?>">            
                <div class="attr-form-group etn-label-item etn-label-top">
                    <div class="etn-label">
                        <label>
                            <?php esc_html_e('Test Mode', 'eventin'); ?>
                        </label>
                        <div class="etn-desc"> <?php esc_html_e('Enable test mode', 'eventin'); ?> </div>
                    </div>
                    <div class="etn-meta">
                        <input id="etn_stripe_test_mode" type="checkbox" <?php echo esc_html($etn_stripe_test_mode); ?> class="etn-admin-control-input" name="etn_stripe_test_mode" />
                        <label for="etn_stripe_test_mode" data-left="Yes" data-right="No" class="etn_switch_button_label"></label>
                    </div>
                </div>

                <div class="test-key-wrapper <?php echo esc_attr($test_mode_class); ?>">
                    <?php
                    $markup_fields_one = [
                        'stripe_test_publishable_key' => [
                            'item' => [
                                'label'    => esc_html__( 'Test Publishable key', 'eventin' ),
                                'desc'     => esc_html__( 'Place Publishable key', 'eventin' ),
                                'type'     => 'password',
                                'place_holder' => esc_html__('Test Publishable key here', 'eventin'),
                                'attr'     => ['class' => 'attr-form-group etn-label-item', 'input_class'=> 'etn-setting-input attr-form-control'],
                            ],
                            'data' => [ 'stripe_test_publishable_key' => $stripe_test_publishable_key ],
                        ],
                        'stripe_test_secret_key' => [
                            'item' => [
                                'label'    => esc_html__( 'Test Secret key', 'eventin' ),
                                'desc'     => esc_html__( 'Place Secret key', 'eventin' ),
                                'type'     => 'password',
                                'place_holder' => esc_html__('Test secret key here', 'eventin'),
                                'attr'     => ['class' => 'attr-form-group etn-label-item', 'input_class'=> 'etn-setting-input attr-form-control'],
                            ],
                            'data' => [ 'stripe_test_secret_key' => $stripe_test_secret_key ],
                        ],
                    ];
            
                    foreach ( $markup_fields_one as $key => $info ) {
                        $this->get_field_markup( $info['item'], $key, $info['data'] );
                    }
                    ?>
                </div>

                <div class="live-key-wrapper">
                    <?php
                    $markup_fields_two = [
                        'stripe_live_publishable_key' => [
                            'item' => [
                                'label'    => esc_html__( 'Live Publishable key', 'eventin' ),
                                'desc'     => esc_html__( 'Place Publishable key', 'eventin' ),
                                'type'     => 'password',
                                'place_holder' => esc_html__('Live Publishable key here', 'eventin'),
                                'attr'     => ['class' => 'attr-form-group etn-label-item', 'input_class'=> 'etn-setting-input attr-form-control'],
                            ],
                            'data' => [ 'stripe_live_publishable_key' => $stripe_live_publishable_key ],
                        ],
                        'stripe_live_secret_key' => [
                            'item' => [
                                'label'    => esc_html__( 'Live Secret key', 'eventin' ),
                                'desc'     => esc_html__( 'Place Secret key', 'eventin' ),
                                'type'     => 'password',
                                'place_holder' => esc_html__('Live secret key here', 'eventin'),
                                'attr'     => ['class' => 'attr-form-group etn-label-item', 'input_class'=> 'etn-setting-input attr-form-control'],
                            ],
                            'data' => [ 'stripe_live_secret_key' => $stripe_live_secret_key ],
                        ],
                    ];
            
                    foreach ( $markup_fields_two as $key => $info ) {
                        $this->get_field_markup( $info['item'], $key, $info['data'] );
                    }
                    ?>
                </div>

                <?php
                //add country and currency with symbol
                include(\Wpeventin::core_dir().'/settings/views/country-info.php' );

                $etn_sells_engine_currency =  isset( $settings['etn_settings_country_currency']['options'] ) ? $settings['etn_settings_country_currency']['options'] : "";

                $default_country = isset($etn_sells_engine_currency['location']['country']) ? $etn_sells_engine_currency['location']['country'] : 'US-CA';

                $only_country = explode('-', $default_country);
                $defult_code = isset($countryList[$only_country[0]]['currency']['code']) ? $countryList[$only_country[0]]['currency']['code'] : 'USD';

                $default_currency = isset($etn_sells_engine_currency['currency']['name']) ? $etn_sells_engine_currency['currency']['name'] : $only_country[0].'-'.$defult_code;

                ?>

                <div class="attr-form-group etn-label-item currency-select-dropdown">
                    <div class="etn-label">
                        <label for="captcha-method"><?php esc_html_e( 'Currency', 'eventin' );?></label>
                        <div class="etn-desc"> <?php esc_html_e( 'Select your currency', 'eventin' );?> </div>
                    </div>
                    <div class="etn-meta">
                        <select id="etn_sells_engine_currency" name="etn_settings_country_currency[options][currency][name]" class="etn-setting-input attr-form-control etn-settings-select">
                            <?php
                            if(is_array($countryList) && sizeof($countryList) > 0){
                                foreach($countryList AS $key=>$value):
                                    $name = isset($value['info']['name']) ? $value['info']['name'] : '';
                                    $code = isset($value['currency']['code']) ? $value['currency']['code'] : '';
                                    $symbols = isset($value['currency']['symbol']) ? $value['currency']['symbol'] : '';
                                    $symbols_br = strlen($symbols) > 0 ? '('.$symbols.')' : '';
									$num_decimals = isset($value['currency']['num_decimals']) ? $value['currency']['num_decimals'] : 2;
                                ?>
                                    <option value="<?php echo esc_attr($key.'-'.$code.'-'.$symbols.'-'.$num_decimals);?>" <?php echo ($default_currency == $key.'-'.$code.'-'.$symbols.'-'.$num_decimals) ? 'selected' : '';?>> <?php echo esc_html($name.' -- '.$code.$symbols_br);?> </option>
                                <?php	
                                
                                endforeach;
                            }
                            ?>
                        </select>
                    </div>
                </div>
                
                <div class="logo-wrapper">
                    <?php                    
                    $markup_fields_one = [
                        
                        'etn_stripe_payment_logo' => [
                            'item' => [
                                'label'    => esc_html__( 'Upload Logo', 'eventin' ),
                                'desc'     => esc_html__( 'Upload a logo for stripe popup', 'eventin' ),
                                'type'     => 'media',
                                'input_name' => 'audio',
                                'attr'     => ['class' => 'attr-form-group etn-label-item', 'input_class' => 'custom_media_url'],
                            ],
                            'data' => [ 'etn_stripe_payment_logo' => $etn_stripe_payment_logo ],
                        ],

                    ];
            
                    foreach ( $markup_fields_one as $key => $info ) {
                        $this->get_field_markup( $info['item'], $key, $info['data'] );
                    }
                    
                    ?>
                </div>

            </div>
        </div>
        
        <?php
    }

    /**
     * Add pro settings to general-settings tab
     *
     * @return void
     */
    public function add_general_settings( $settings_arr ) {
        $settings_arr['pro_details_options']  = \Wpeventin::core_dir() . "/settings/views/details-settings.php";
        $settings_arr['pro_attendee_options'] = \Wpeventin::core_dir() . "/settings/views/attendee-settings.php";
        return $settings_arr;
    }

    /**
     * Add more templates options for Event Single Page
     *
     * @param [type] $all_templates
     * @return void
     */
    public function add_event_pro_template_options( $all_templates ) {
        $all_templates['event-two']   = esc_html__( 'Template Two', 'eventin' );
        $all_templates['event-three'] = esc_html__( 'Template Three', 'eventin' );
        return $all_templates;
    }

    /**
     * Add more templates options for Speaker Single Page
     *
     * @param [type] $all_templates
     * @return void
     */
    public function add_speaker_pro_template_options( $all_templates ) {
        $all_templates['speaker-two']   = esc_html__( 'Template One Pro', 'eventin' );
        $all_templates['speaker-three'] = esc_html__( 'Template Two Pro', 'eventin' );

        return $all_templates;
    }

    /**
     * Add inner tabs for integration tab
     *
     */
    public function after_integration_settings_grounhogg(){
        $settings = \Etn\Core\Settings\Settings::instance()->get_settings_option();
        $etn_groundhogg_api = (isset($settings['etn_groundhogg_api']) ? 'checked' : '');
        $groundhogg_woocommerce_purchase = (isset($settings['groundhogg_woocommerce_purchase']) ? 'checked' : '');
        
        $groundhogg_attendee_email = (isset($settings['groundhogg_attendee_email']) ? 'checked' : '');
        
        $groundhogg_public_key = (isset($settings['groundhogg_public_key']) ? $settings['groundhogg_public_key'] : '');
        $groundhogg_token = (isset($settings['groundhogg_token']) ? $settings['groundhogg_token'] : '');
        $groundhogg_v3_route = (isset($settings['groundhogg_v3_route']) ? $settings['groundhogg_v3_route'] : '');
        $groundhogg_class = ( $etn_groundhogg_api == 'checked' ) ?  'groundhogg_section' : 'groundhogg_section_hide';
        ?>
        <div class="etn-settings-tab" id="groundhogg-options">
            <div class="attr-form-group etn-label-item etn-label-top">
                <div class="etn-label">
                    <label>
                        <?php esc_html_e('Groundhogg', 'eventin'); ?>
                    </label>
                    <div class="etn-desc"> <?php esc_html_e('Enable groundhogg CRM', 'eventin'); ?> </div>
                </div>
                <?php 
                    if(!class_exists( 'Wpeventin_Pro' )){ 
                        echo Helper::get_pro();
                    } else {
                ?>
                    <div class="etn-meta">
                        <input id="groundhogg_api" type="checkbox" <?php echo esc_html($etn_groundhogg_api); ?> class="etn-admin-control-input" name="etn_groundhogg_api" />
                        <label for="groundhogg_api" data-left="Yes" data-right="No" class="etn_switch_button_label"></label>
                    </div>
                <?php } ?>
            </div>

            <div class="groundhogg_block <?php echo esc_attr($groundhogg_class); ?>">
                <div class="attr-form-group etn-label-item">
                    <div class="etn-label">
                        <label class="etn-setting-label" for="groundhogg_public_key"><?php esc_html_e('Public key', 'eventin'); ?></label>
                        <div class="etn-desc"> <?php esc_html_e('Place api public key here that you get from groundhogg contact', 'eventin'); ?> </div>
                    </div>
                    <div class="etn-meta">
                        <div class="etn-secret-key">
                            <input type="password" class="etn-setting-input attr-form-control" name="groundhogg_public_key" value="<?php echo esc_attr($groundhogg_public_key); ?>" id="groundhogg_public_key" />
                            <span><i class="etn-icon etn-eye-slash eye_toggle_click"></i></span>
                        </div>
                    </div>
                </div>
                <div class="attr-form-group etn-label-item etn-label-top">
                    <div class="etn-label">
                        <label class="etn-setting-label" for="groundhogg_token"><?php esc_html_e('Token', 'eventin'); ?></label>
                        <div class="etn-desc"> <?php esc_html_e('Place groundhogg token', 'eventin'); ?>
                        </div>
                    </div>
                    <div class="etn-meta">
                        <div class="etn-secret-key mb-2">
                            <input type="password" class="etn-setting-input attr-form-control" name="groundhogg_token" value="<?php echo esc_attr($groundhogg_token); ?>" id="groundhogg_token" />
                            <span><i class="etn-icon etn-eye-slash eye_toggle_click"></i></span>
                        </div>
                        <div class="etn-desc"> <?php esc_html_e('Check the official documentation from', 'eventin'); ?>
                            <a href="<?php echo esc_url('https://support.themewinter.com/docs/plugins/plugin-docs/eventin/groundhogg-integration/') ?>" target="_blank" rel="noopener"><?php esc_html_e(' here', 'eventin'); ?></a>
                        </div>
                    </div>
                </div>
                <div class="attr-form-group etn-label-item">
                    <div class="etn-label">
                        <label class="etn-setting-label" for="groundhogg_v3_route"><?php esc_html_e('API v3 Route URL', 'eventin'); ?></label>
                        <div class="etn-desc"> <?php esc_html_e('Place the API v3 route URL from Groundhogg settings->API. NOTE: Add "/contacts" at the end of the URL', 'eventin'); ?> </div>
                    </div>
                    <div class="etn-meta">
                        <div class="etn-secret-key">
                            <input type="text" class="etn-setting-input attr-form-control" name="groundhogg_v3_route" value="<?php echo esc_attr($groundhogg_v3_route); ?>" id="groundhogg_v3_route" placeholder="<?php echo esc_attr__('https://mysite.com/wp-json/gh/v3/contacts', 'eventin'); ?>" />
                        </div>
                    </div>
                </div>
                <div class="attr-form-group etn-label-item">
                    <div class="etn-label">
                        <label>
                            <?php esc_html_e('Disable creating contact with WooCommerce billing email', 'eventin'); ?>
                        </label>
                        <div class="etn-desc"> <?php esc_html_e('Disable WooCommerce billing email as Groundhogg contact', 'eventin'); ?> </div>
                    </div>
                    <div class="etn-meta">
                        <input id="groundhogg_woocommerce_purchase" type="checkbox" <?php echo esc_html($groundhogg_woocommerce_purchase); ?> class="etn-admin-control-input" name="groundhogg_woocommerce_purchase" />
                        <label for="groundhogg_woocommerce_purchase" data-left="Yes" data-right="No" class="etn_switch_button_label"></label>
                    </div>
                </div>
                <div class="attr-form-group etn-label-item">
                    <div class="etn-label">
                        <label>
                            <?php esc_html_e('Disable creating contact with attendee email', 'eventin'); ?>
                        </label>
                        <div class="etn-desc"> <?php esc_html_e('Disable attendee email as Groundhogg contact', 'eventin'); ?> </div>
                    </div>
                    <div class="etn-meta">
                        <input id="groundhogg_attendee_email" type="checkbox" <?php echo esc_html($groundhogg_attendee_email); ?> class="etn-admin-control-input" name="groundhogg_attendee_email" />
                        <label for="groundhogg_attendee_email" data-left="Yes" data-right="No" class="etn_switch_button_label"></label>
                    </div>
                </div>
            </div>
        </div>

        <?php

    }

    /**
     * Add google map api keys options
     *
     */

    public function after_integration_settings_google_mapapi(){
        $settings = \Etn\Core\Settings\Settings::instance()->get_settings_option();
        $etn_googlemap_api = (isset($settings['etn_googlemap_api']) ? 'checked' : '');
        $google_api_key = (isset($settings['google_api_key']) ? $settings['google_api_key'] : '');
        $googlemap_class = ( $etn_googlemap_api == 'checked' ) ?  'googlemap_section' : 'googlemap_section_hide';
        ?>

        <div class="etn-settings-tab" id="googlemap-options">
            <div class="attr-form-group etn-label-item etn-label-top">
                <div class="etn-label">
                    <label>
                        <?php esc_html_e('Google Map', 'eventin'); ?>
                    </label>
                    <div class="etn-desc"> <?php esc_html_e('Enable Google Map', 'eventin'); ?> </div>
                </div>
                <?php 
                    if(!class_exists( 'Wpeventin_Pro' )){ 
                        echo Helper::get_pro();
                    } else {
                ?>
                <div class="etn-meta">
                    <input id="etn_googlemap_api" type="checkbox" <?php echo esc_html($etn_googlemap_api); ?> class="etn-admin-control-input" name="etn_googlemap_api" />
                    <label for="etn_googlemap_api" data-left="Yes" data-right="No" class="etn_switch_button_label"></label>
                </div>
                <?php } ?>
            </div>

            <div class="googlemap_block <?php echo esc_attr($googlemap_class); ?>">
                <?php
                $markup_fields_one = [
                    'google_api_key' => [
                        'item' => [
                            'label'    => esc_html__( 'Map API key', 'eventin' ),
                            'desc'     => esc_html__( 'Place Google map API key', 'eventin' ),
                            'type'     => 'password',
                            'place_holder' => esc_html__('Google Map API key here', 'eventin'),
                            'attr'     => ['class' => 'attr-form-group etn-label-item', 'input_class'=> 'etn-setting-input attr-form-control'],
                        ],
                        'data' => [ 'google_api_key' => $google_api_key ],
                    ],
                ];
        
                foreach ( $markup_fields_one as $key => $info ) {
                    $this->get_field_markup( $info['item'], $key, $info['data'] );
                }
                ?>
            </div>
        </div>
        <?php

    }

    /**
     * Add inner tabs for integration tab
     *
     */

    function after_integration_settings_inner_tabs() {
        ?>
        <li>
            <a class="etn-settings-tab-a" data-id="groundhogg-options">
                <?php echo esc_html__('Groundhogg', 'eventin'); ?>
                <svg width="14" height="13" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M64 448c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L178.8 256L41.38 118.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l160 160c12.5 12.5 12.5 32.75 0 45.25l-160 160C80.38 444.9 72.19 448 64 448z"></path></svg>
            </a>
        </li>
        <li>
            <a class="etn-settings-tab-a" data-id="googlemap-options">
                <?php echo esc_html__('Google Map', 'eventin'); ?>
                <svg width="14" height="13" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M64 448c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L178.8 256L41.38 118.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l160 160c12.5 12.5 12.5 32.75 0 45.25l-160 160C80.38 444.9 72.19 448 64 448z"></path></svg>
            </a>
        </li>
        <?php
    }


    /**
     * Add advance settings tab
     *
     * @param   array  $settings  Advance setting tab
     *
     * @return  array Settings            
     */
    public function add_advance_tab( $settings ) {
        $settings['etn-advance']    = [
            "class"         => "etnshortcode-nav nav-tab",
            "icon_class"    => "eventin-user_icon",
            "data_id"       => "tab_advance",
            "title"         => esc_html__( 'Advanced', 'eventin' ),
            "icon"			=> '
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-sliders"><line x1="4" y1="21" x2="4" y2="14"></line><line x1="4" y1="10" x2="4" y2="3"></line><line x1="12" y1="21" x2="12" y2="12"></line><line x1="12" y1="8" x2="12" y2="3"></line><line x1="20" y1="21" x2="20" y2="16"></line><line x1="20" y1="12" x2="20" y2="3"></line><line x1="1" y1="14" x2="7" y2="14"></line><line x1="9" y1="8" x2="15" y2="8"></line><line x1="17" y1="16" x2="23" y2="16"></line></svg>',
            "content"       => \Wpeventin::plugin_dir() . "/core/settings/views/advance/domain-registration.php",
        ];

        return $settings;
		
    }

    public function after_integration_settings_google_meet_tabs() {
        ?>
        <li>
            <a class="etn-settings-tab-a" data-id="google-meet-options">
                <?php echo esc_html__( 'Google Meet', 'eventin' ); ?>
                <svg width="14" height="13" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M64 448c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L178.8 256L41.38 118.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l160 160c12.5 12.5 12.5 32.75 0 45.25l-160 160C80.38 444.9 72.19 448 64 448z"></path></svg>
            </a>
        </li>
        <?php
    }

    /*
    * Google Meet integration API key options
    */

    public function after_integration_settings_google_meet_api() {
        $settings                      = \Etn\Core\Settings\Settings::instance()->get_settings_option();
        $google_meet_client_id         = isset( $settings['google_meet_client_id'] ) ? $settings['google_meet_client_id'] : '';
        $google_meet_client_secret_key = isset( $settings['google_meet_client_secret_key'] ) ? $settings['google_meet_client_secret_key'] : '';
        $redirect_uri                  = site_url( 'eventin-integration/google-auth' );
        $google_auth_url               = 'https://accounts.google.com/o/oauth2/v2/auth';
        $auth_scope                    = 'https://www.googleapis.com/auth/calendar';

        $auth_url = '';

        if ( class_exists( 'Wpeventin_Pro' ) ) {
            $auth_url = GoogleCredential::get_auth_url();
        }
        
        ?>
        <div class="etn-settings-tab" id="google-meet-options" >
            <div class="google-meet-block">
                <div class="attr-form-group etn-label-item etn-label-top">
                    <div class="etn-label">
                        <label class="etn-setting-label" for="google_meet_client_id"><?php esc_html_e( 'Client ID', 'eventin' );?></label>
                        <div class="etn-desc">
                            <?php esc_html_e( 'Please enter Google Meet client ID here.', 'eventin' );?>
                        </div>
                    </div>
                    <?php 
                        if(!class_exists( 'Wpeventin_Pro' )){ 
                            echo Helper::get_pro();
                        } else {
                    ?>
                    <div class="etn-meta">
                        <div class="etn-secret-key mb-2">
                            <input
                                type="password"
                                class="etn-setting-input attr-form-control"
                                name="google_meet_client_id"
                                value="<?php echo esc_attr( $google_meet_client_id ); ?>"
                                id="google_meet_client_id"
                                placeholder="<?php echo esc_attr__( 'Enter client ID', 'eventin' ); ?>"
                            />
                            <span><i class="etn-icon etn-eye-slash eye_toggle_click"></i></span>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <div class="attr-form-group etn-label-item etn-label-top">
                    <div class="etn-label">
                        <label class="etn-setting-label" for="google_meet_client_secret_key"><?php esc_html_e( 'Client Secret Key', 'eventin' );?></label>
                        <div class="etn-desc">
                            <?php esc_html_e( 'Please enter Google Meet client secret key.', 'eventin' );?>
                        </div>
                    </div>
                    <?php 
                        if(!class_exists( 'Wpeventin_Pro' )){ 
                            echo Helper::get_pro();
                        } else {
                    ?>
                    <div class="etn-meta">
                        <div class="etn-secret-key mb-2">
                            <input type="password"class="etn-setting-input attr-form-control" name="google_meet_client_secret_key" value="<?php echo esc_attr( $google_meet_client_secret_key ); ?>" id="google_meet_client_secret_key" placeholder="<?php echo esc_attr__( 'Enter client secret key', 'eventin' ); ?>"
                            />
                            <span><i class="etn-icon etn-eye-slash eye_toggle_click"></i></span>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <div class="attr-form-group etn-label-item etn-label-top">
                    <div class="etn-label">
                        <label class="etn-setting-label" for="google_meet_redirect_url"><?php esc_html_e( 'Authorized redirect URI', 'eventin' );?></label>
                        <div class="etn-desc">
                            <?php esc_html_e( 'Your redirection will authorize from this URL.', 'eventin' );?>
                        </div>
                    </div>
                    <?php 
                        if(!class_exists( 'Wpeventin_Pro' )){ 
                            echo Helper::get_pro();
                        } else {
                    ?>
                    <div class="etn-meta">
                        <div class="etn-secret-key mb-2">
                            <input type="text" readonly class="etn-setting-input attr-form-control" name="google_meet_redirect_url" value="<?php echo esc_attr( $redirect_uri ); ?>" id="google_meet_redirect_url" placeholder="<?php echo esc_attr__( 'Enter redirect URL', 'eventin' ); ?>"
                            />
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <div class="attr-form-group etn-label-item etn-label-connection etn-label-top">
                    <div class="etn-label">
                        <label class="etn-setting-label"><?php esc_html_e( 'Authenticate with Google account', 'eventin' );?></label>
                        <div class="etn-desc">
                            <p>
                                <strong>
                                    <?php esc_html_e('Alert:', 'eventin'); ?>
                                </strong>
                                <?php esc_html_e( 'Client ID and Client Secret Key must be entered and saved before authenticate.', 'eventin' ); ?>
                                <span>
                                    <?php esc_html_e( 'For more details please check our ', 'eventin' );?>
                                    <a target="_blank" href="<?php echo esc_url( 'https://support.themewinter.com/docs/plugins/plugin-docs/integration/google-meet' ) ?>">
                                        <?php esc_html_e( 'documentation', 'eventin' );?>
                                    </a>
                                </span>
                            </p>
                        </div>
                    </div>
                    <?php 
                        if(!class_exists( 'Wpeventin_Pro' )){ 
                            echo Helper::get_pro();
                        } else {
                    ?>
                        <div class="etn-meta">
                            <div class="etn-api-connect-wrap">
                                <a href="<?php echo esc_url( $auth_url ); ?>" type="button" class="etn-btn-text google_meet_authentication"><?php echo esc_html__( 'Authenticate', 'eventin' ) ?></a>
                                <div class="api-keys-msg">
                                    <?php esc_html_e( 'Note: Save changes before authenticate.', 'eventin' );?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Add advance settings tab for webhook
     *
     * @return  void
     */

    public function add_advance_settings_tab() {
       ?>
       <li>
            <a class="etn-settings-tab-a etn-settings-active"  data-id="webhooks">
                <?php echo esc_html__( 'Webhooks', 'eventin' ); ?>
                <svg width="14" height="13" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M64 448c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L178.8 256L41.38 118.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l160 160c12.5 12.5 12.5 32.75 0 45.25l-160 160C80.38 444.9 72.19 448 64 448z"></path></svg>
            </a>
        </li> 
       <?php
    }

    /**
     * Add advance settings tab content for webhook
     *
     * @return  void
    */
    public function add_advance_settings_tab_content() {
        ?>
        <div class="etn-settings-tab" id="webhooks">

            <?php include \Wpeventin::core_dir() . '/settings/views/webhook-item.php'; ?>
            <?php
                $webhooks = new \WP_Query( [
                    'post_type'   => 'etn-webhook',
                    'post_status' => 'publish',
                    'fields'      =>  'ids',
                ] );

                foreach( $webhooks->posts as $webhook_id ) {
                    include \Wpeventin::core_dir() . '/settings/views/webhook-item.php';
                }
            ?>
        </div>

        <?php
    }

    /**
	 * Add RSVP settings tab
	 *
	 * @param   array  $settings RSVP setting tab
	 *
	 * @return  array Settings
	 */
	public function add_rsvp_tab( $settings ) {
		$rsvp = \Etn\Core\Addons\Helper::instance()->check_active_module('rsvp');
		if ( $rsvp == '' ) {
			return $settings;
		}
		$settings['etn-rsvp'] = [
			"class"      => "etnshortcode-nav nav-tab",
			"icon_class" => "eventin-user_icon",
			"data_id"    => "tab_rsvp",
			"title"      => esc_html__( 'RSVP', 'eventin' ),
			"icon"       => '<svg width="34" height="36" viewBox="0 0 34 36" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" clip-rule="evenodd" d="M4.11807 2.2691C5.27007 0.755 7.45377 0 11.2087 0H22.2881C26.0431 0 28.2268 0.755 29.3788 2.2691C29.9425 3.0101 30.2021 3.8646 30.3273 4.7348C30.4499 5.5875 30.4499 6.5123 30.4499 7.4169V17.5069C30.4499 17.9154 30.1027 18.2466 29.6743 18.2466C29.246 18.2466 28.8988 17.9154 28.8988 17.5069V7.4466C28.8988 6.5078 28.8974 5.6788 28.7906 4.9359C28.6849 4.2012 28.4829 3.6105 28.1234 3.138C27.4288 2.2251 25.9194 1.4795 22.2881 1.4795H11.2087C7.57737 1.4795 6.06797 2.2251 5.37347 3.138C5.01397 3.6105 4.81187 4.2012 4.70617 4.9359C4.59937 5.6788 4.59797 6.5078 4.59797 7.4466V17.5069C4.59797 17.9154 4.25077 18.2466 3.82247 18.2466C3.39417 18.2466 3.04688 17.9154 3.04688 17.5069V7.4169C3.04688 6.5123 3.04687 5.5875 3.16947 4.7348C3.29467 3.8646 3.55427 3.0101 4.11807 2.2691Z" fill="#77797E"/>
							<path fill-rule="evenodd" clip-rule="evenodd" d="M1.0346 19.1693C2.1553 17.5731 4.2949 16.7671 7.9784 16.7671C8.9309 16.7671 9.6141 16.8647 10.2063 17.0916C10.7739 17.3091 11.2082 17.6297 11.6509 17.9566C11.6628 17.9654 11.6747 17.9741 11.6865 17.9829C11.7221 18.0091 11.7551 18.0383 11.7854 18.0701L13.6052 19.9848L13.6064 19.9861C15.454 21.9095 18.5485 21.9057 20.3746 19.9871L20.3768 19.9848L22.2172 18.0675C22.2467 18.0367 22.2789 18.0084 22.3135 17.9829L22.3491 17.9566C22.7918 17.6297 23.2261 17.3091 23.7937 17.0916C24.3859 16.8647 25.0691 16.7671 26.0216 16.7671C29.7051 16.7671 31.8447 17.5731 32.9654 19.1693C33.5095 19.9442 33.7599 20.8367 33.881 21.7487C34 22.6457 34 23.6197 34 24.5798V26.3835C34 28.8977 33.5419 31.3251 32.0235 33.1279C30.4796 34.961 27.9696 36 24.2172 36H9.7828C5.1968 36 2.6062 34.9941 1.26 33.0762C0.6032 32.1404 0.2965 31.0566 0.1472 29.9323C-3.72529e-07 28.8232 0 27.6162 0 26.4124V24.5799C0 23.6198 4.32134e-07 22.6457 0.119 21.7487C0.2401 20.8367 0.490499 19.9442 1.0346 19.1693ZM1.6289 21.938C1.5236 22.7315 1.5224 23.6157 1.5224 24.6082V26.3835C1.5224 27.6201 1.5236 28.7373 1.6571 29.743C1.7898 30.7425 2.0468 31.5716 2.5177 32.2425C3.427 33.538 5.3471 34.5205 9.7828 34.5205H24.2172C27.6821 34.5205 29.6829 33.5711 30.8455 32.1908C32.0335 30.7803 32.4776 28.7693 32.4776 26.3835V24.6082C32.4776 23.6157 32.4764 22.7315 32.3711 21.938C32.2666 21.1507 32.0659 20.5131 31.7079 20.0031C31.0243 19.0295 29.5553 18.2465 26.0216 18.2465C25.1697 18.2465 24.6981 18.3353 24.3521 18.4679C24.0095 18.5992 23.7376 18.7902 23.2859 19.123L21.4922 20.9917L21.4911 20.9929C19.0593 23.5465 14.9384 23.5427 12.4919 20.994L12.4894 20.9913L10.7126 19.1219C10.2618 18.7898 9.9901 18.5991 9.6479 18.4679C9.3019 18.3353 8.8303 18.2465 7.9784 18.2465C4.4447 18.2465 2.9757 19.0295 2.2921 20.0031C1.9341 20.5131 1.7334 21.1507 1.6289 21.938Z" fill="#77797E"/>
							<path d="M20.9415 6.65747H22.3255L20.7108 12.5753H19.3269L17.7122 6.65747H19.0962L20.0188 10.0405L20.9415 6.65747ZM10.8845 10.5041L11.7149 12.5753H10.3309L9.54666 10.6027H8.48556V12.5753H7.10156V6.65747H10.3309C11.1152 6.65747 11.7149 7.29857 11.7149 8.13697V9.12327C11.7149 9.71507 11.3458 10.2575 10.8845 10.5041ZM10.3309 8.13697H8.48556V9.12327H10.3309V8.13697ZM26.0161 10.6027H24.1708V12.5753H22.7868V6.65747H26.0161C26.7819 6.65747 27.4001 7.31837 27.4001 8.13697V9.12327C27.4001 9.94187 26.7819 10.6027 26.0161 10.6027ZM26.0161 8.13697H24.1708V9.12327H26.0161V8.13697ZM16.7895 6.65747V8.13697H14.0216V8.87667H15.8669C16.3743 8.87667 16.7895 9.32047 16.7895 9.86297V11.589C16.7895 12.1315 16.3743 12.5753 15.8669 12.5753H12.6376V11.0959H15.4056V10.3562H13.3296C12.9513 10.3562 12.6376 10.0208 12.6376 9.61637V7.64377C12.6376 7.10137 13.0528 6.65747 13.5602 6.65747H16.7895Z" fill="#77797E"/>
							</svg>',
			"content"    => \Wpeventin::core_dir() . "/settings/views/rsvp-general-settings.php",
		];

		return $settings;
	}

    /**
     * Add Eventin AI settings tab
     *
     * @return  void
     */

    public function after_integration_settings_eventin_ai_tab() {
        ?>
            <li>
                <a class="etn-settings-tab-a"  data-id="eventin-ai-options">
                    <?php echo esc_html__( 'Eventin AI', 'eventin' ); ?>
                    <svg width="14" height="13" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M64 448c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L178.8 256L41.38 118.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l160 160c12.5 12.5 12.5 32.75 0 45.25l-160 160C80.38 444.9 72.19 448 64 448z"></path></svg>
                </a>
            </li> 
        <?php
    }

    /**
     * Add Eventin AI settings tab content
     *
     * @return  void
     */

    public function after_integration_settings_eventin_ai($settings) {
        $settings               = \Etn\Core\Settings\Settings::instance()->get_settings_option();
        $eventin_ai_auth_key         = isset( $settings['eventin_ai_auth_key'] ) ? $settings['eventin_ai_auth_key'] : '';


        ?>
        <div class="etn-settings-tab" id="eventin-ai-options" >
            <div class="eventin-ai-block">
                <div class="attr-form-group etn-label-item etn-label-top">
                    <div class="etn-label">
                        <label class="etn-setting-label" for="eventin_ai_auth_key"><?php esc_html_e( 'Open AI Key', 'eventin' );?></label>
                        <div class="etn-desc">
                            <p>
                                <?php esc_html_e( 'Enter OpenAI API key', 'eventin' ); ?>
                                <br>
                                <span>
                                    <?php esc_html_e( 'Please visit official guide for creating OpenAI api key.', 'eventin' );?>
                                    <a target="_blank" href="<?php echo esc_url( 'https://platform.openai.com/api-keys' ) ?>">
                                        <?php esc_html_e( 'Documentation', 'eventin' );?>
                                    </a>
                                </span>
                            </p>
                        </div>
                    </div>
                    <?php 
                        if( ! class_exists( 'Wpeventin_Pro' ) ){ 
                            echo Helper::get_pro();
                        } elseif ( ! class_exists( 'EventinAI' )){
                            echo Helper::get_eventin_ai();
                        } else { ?>
                        <div class="etn-meta">
                            <div class="etn-secret-key mb-2">
                                <input
                                    type="password"
                                    class="etn-setting-input attr-form-control"
                                    name="eventin_ai_auth_key"
                                    value="<?php echo esc_attr( $eventin_ai_auth_key ); ?>"
                                    id="eventin_ai_auth_key"
                                    placeholder="<?php echo esc_attr__( 'Enter Open AI API Key', 'eventin' ); ?>"
                                />
                                <span><i class="etn-icon etn-eye-slash eye_toggle_click"></i></span>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php
    }

}
