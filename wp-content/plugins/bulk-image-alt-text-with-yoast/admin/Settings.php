<?php
namespace Pagup\Bialty;
use Pagup\Bialty\Core\Asset;
use Pagup\Bialty\Controllers\DomController;
use Pagup\Bialty\Controllers\NoticeController;
use Pagup\Bialty\Controllers\MetaboxController;
use Pagup\Bialty\Controllers\OptionsController;
use Pagup\Bialty\Controllers\SettingsController;

//require \Pagup\Bialty\Core\Plugin::path('vendor/persist-admin-notices-dismissal/persist-admin-notices-dismissal.php');

class Settings {

    public function __construct()
    {
        $settings = new SettingsController;
        $metabox = new MetaboxController;

        // Add settings page
        add_action( 'admin_menu', array( &$settings, 'add_settings' ) );

        add_action( 'wp_ajax_bialty_options', array( &$settings, 'save_options' ) );
        add_action( 'wp_ajax_bialty_onboarding', array( &$settings, 'onboarding' ) );

        // Add metabox to post-types
        add_action( 'add_meta_boxes', array(&$metabox, 'add_metabox') );

        // Save meta data
        add_action( 'save_post', array(&$metabox, 'metadata'));

        // Add setting link to plugin page
        $plugin_base = BIALTY_PLUGIN_BASE;
        add_filter( "plugin_action_links_{$plugin_base}", array( &$this, 'setting_link' ) );

        // Add styles and scripts
        add_action( 'admin_enqueue_scripts', array( &$this, 'assets') );

        // Add type module to app script
        add_filter( 'script_loader_tag', array( &$this, 'add_module_to_script' ), 10, 3 );

        add_action('admin_head', array( &$this, 'hide_wp_notifications_on_bialty_page' ));

    }

    public function setting_link( $links ) {

        array_unshift( $links, '<a href="admin.php?page=bialty">Settings</a>' );
        return $links;
    }

    public function assets() {
        
        Asset::style('bialty_metabox', 'admin/assets/metabox.css');

        if ( isset($_GET['page']) && !empty($_GET['page']) && $_GET['page'] === "bialty" ) {

            if (BIALTY_PLUGIN_MODE === "production") {
            
                Asset::style('bialty__styles', 'admin/ui/app.css');
                Asset::script('bialty__main', 'admin/ui/app.js', array(), true);
            
            } else {
            
                Asset::script_remote('bialty__client', 'http://localhost:8888/@vite/client', array(), true, true);
                Asset::script_remote('bialty__main', 'http://localhost:8888/src/main.js', array(), true, true);
            }

        }

        // if ( isset($_GET['page']) && !empty($_GET['page']) && ( $_GET['page'] === "bialty" ) ) {

        //     Asset::style_remote('afkw__font', 'https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap');
        //     Asset::style('bialty_element', 'vendor/css/element-plus.css');
        //     Asset::style('bialty_element_dark', 'vendor/css/element-plus-dark.css');
        //     Asset::style('bialty_introjs', 'vendor/css/introjs.min.css');
        //     Asset::style('bialty_style', 'admin/assets/style.css');

        //     Asset::script('bialty_qs', 'vendor/js/qs.js', array(), true);
        //     Asset::script('bialty_axios', 'vendor/js/axios.min.js', array(), true);
        //     Asset::script('bialty_vuejs', 'vendor/js/vue3.4.3.min.js', array(), true);
        //     Asset::script('bialty_router', 'vendor/js/vue-router4.2.5.min.js', array(), true);
        //     Asset::script('bialty_i18n', 'vendor/js/vue-i18n9.9.0.min.js', array(), true);
        //     Asset::script('bialty_element_plus', 'vendor/js/element-plus2.4.4.min.js', array(), true);
        //     Asset::script('bialty_intro', 'vendor/js/intro.min.js', array(), true);
        //     Asset::script('bialty_app', 'admin/views/App.js', array(), true);
        // }
    
    }

    function add_module_to_script( $tag, $handle, $src ) {

        if (BIALTY_PLUGIN_MODE === "production") {
            if ( 'bialty__main' === $handle ) {
                $tag = '<script type="module" src="' . esc_url( $src ) . '"></script>';
            }
        } else {
            if ( 'bialty__client' === $handle || 'bialty__main' === $handle ) {
                $tag = '<script type="module" src="' . esc_url( $src ) . '"></script>';
            }
        }

        return $tag;
    }

    // public function add_module_to_script( $tag, $handle ) {
    //     if ('bialty_app' === $handle) {

    //         $tag = str_replace('type="text/javascript"', "", $tag);
    //         $tag = str_replace("type='text/javascript'", "", $tag);
    //         $tag = str_replace(' src', ' type="module" src', $tag);
    //         return $tag;
            
    //      }
    
    //     return $tag;
    // }

    public function hide_wp_notifications_on_bialty_page() {
        if ( isset($_GET['page']) && !empty($_GET['page']) && $_GET['page'] === "bialty" ) {
            echo '<style>
                #message, .update-nag, .notice, .notice-success, .notice-error, .notice-warning, .notice-info {
                    display: none !important;
                }
            </style>';
        }
    }
}

$settings = new Settings;
