<?php

namespace Nnfy\Admin;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

class NNFy_Admin_Settings {

    private $settings_api;

    function __construct() {
        $this->settings_api = new \NNFy_Settings_API();

        add_action( 'admin_init', [ $this, 'admin_init' ] );
        add_action( 'admin_menu', [ $this, 'admin_menu' ], 220 );

        add_action( 'wsa_form_bottom_nnfy_general_tabs', [ $this, 'html_general_tabs' ] );
        
        $this->plugin_recommendations();

    }

    function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->admin_get_settings_sections() );
        $this->settings_api->set_fields( $this->admin_fields_settings() );

        //initialize settings
        $this->settings_api->admin_init();
    }
    
    // Plugins menu Register
    function admin_menu() {

        $menu = 'add_menu_' . 'page';
        $menu(
            'nnfy_panel',
            esc_html__( '99Fy Options', '99fy' ),
            esc_html__( '99Fy Options', '99fy' ),
            'nnfy_option_page',
            NULL,
            'dashicons-admin-generic',
            59
        );
        
        add_submenu_page(
            'nnfy_option_page', 
            esc_html__( '99Fy Options', '99fy' ),
            esc_html__( '99Fy Options', '99fy' ), 
            'manage_options', 
            'nnfy_options', 
            [ $this, 'plugin_page' ]
        );
        
        add_submenu_page(
            'nnfy_option_page', 
            esc_html__( 'Theme Options', '99fy' ),
            esc_html__( 'Theme Options', '99fy' ), 
            'manage_options', 
            'customize.php'
        );

    }

    /**
     * [plugin_recommendations]
     * @return [void]
     */
    public function plugin_recommendations(){

        $get_instance = Recommended_Plugins::instance( 
            array( 
                'text_domain'       => '99fy', 
                'parent_menu_slug'  => 'nnfy_option_page', 
                'menu_capability'   => 'manage_options', 
                'menu_page_slug'    => '99fy-recommendations',
                'priority'          => 225,
                'assets_url'        => NNFY_PL_URL.'/admin/assets',
                'hook_suffix'       => '99fy-options_page_99fy-recommendations'
            )
        );

        $get_instance->add_new_tab( array(

            'title' => esc_html__( 'Recommended', '99fy' ),
            'active' => true,
            'plugins' => array(

                array(
                    'slug'      => 'woolentor-addons',
                    'location'  => 'woolentor_addons_elementor.php',
                    'name'      => esc_html__( 'WooLentor', '99fy' )
                ),

                array(
                    'slug'      => 'ht-mega-for-elementor',
                    'location'  => 'htmega_addons_elementor.php',
                    'name'      => esc_html__( 'HT Mega', '99fy' )
                ),

                array(
                    'slug'      => 'hashbar-wp-notification-bar',
                    'location'  => 'init.php',
                    'name'      => esc_html__( 'HashBar', '99fy' )
                ),

                array(
                    'slug'      => 'ht-slider-for-elementor',
                    'location'  => 'ht-slider-for-elementor.php',
                    'name'      => esc_html__( 'HT Slider For Elementor', '99fy' )
                ),

                array(
                    'slug'      => 'ht-contactform',
                    'location'  => 'contact-form-widget-elementor.php',
                    'name'      => esc_html__( 'HT Contact Form 7', '99fy' )
                ),

                array(
                    'slug'      => 'extensions-for-cf7',
                    'location'  => 'extensions-for-cf7.php',
                    'name'      => esc_html__( 'Extensions For CF7', '99fy' )
                ),

                array(
                    'slug'      => 'ht-wpform',
                    'location'  => 'wpform-widget-elementor.php',
                    'name'      => esc_html__( 'HT WPForms', '99fy' )
                ),

                array(
                    'slug'      => 'ht-menu-lite',
                    'location'  => 'ht-mega-menu.php',
                    'name'      => esc_html__( 'HT Menu', '99fy' )
                ),

                array(
                    'slug'      => 'insert-headers-and-footers-script',
                    'location'  => 'init.php',
                    'name'      => esc_html__( 'HT Script', '99fy' )
                ),

                array(
                    'slug'      => 'wp-plugin-manager',
                    'location'  => 'plugin-main.php',
                    'name'      => esc_html__( 'WP Plugin Manager', '99fy' )
                ),

                array(
                    'slug'      => 'wc-builder',
                    'location'  => 'wc-builder.php',
                    'name'      => esc_html__( 'WC Builder', '99fy' )
                ),

                array(
                    'slug'      => 'whols',
                    'location'  => 'whols.php',
                    'name'      => esc_html__( 'Whols', '99fy' )
                ),

                array(
                    'slug'      => 'just-tables',
                    'location'  => 'just-tables.php',
                    'name'      => esc_html__( 'JustTables', '99fy' )
                ),

                array(
                    'slug'      => 'wc-multi-currency',
                    'location'  => 'wcmilticurrency.php',
                    'name'      => esc_html__( 'Multi Currency', '99fy' )
                )
            )

        ) );

        $get_instance->add_new_tab(array(
            'title' => esc_html__( 'You May Also Like', '99fy' ),
            'plugins' => array(

                array(
                    'slug'      => 'woolentor-addons-pro',
                    'location'  => 'woolentor_addons_pro.php',
                    'name'      => esc_html__( 'WooLentor Pro', '99fy' ),
                    'link'      => 'https://hasthemes.com/plugins/woolentor-pro-woocommerce-page-builder/',
                    'author_link'=> 'https://hasthemes.com/',
                    'description'=> esc_html__( 'WooLentor is one of the most popular WooCommerce Elementor Addons on WordPress.org. It has been downloaded more than 672,148 times and 60,000 stores are using WooLentor plugin. Why not you?', '99fy' ),
                ),

                array(
                    'slug'      => 'htmega-pro',
                    'location'  => 'htmega_pro.php',
                    'name'      => esc_html__( 'HT Mega Pro', '99fy' ),
                    'link'      => 'https://hasthemes.com/plugins/ht-mega-pro/',
                    'author_link'=> 'https://hasthemes.com/',
                    'description'=> esc_html__( 'HTMega is an absolute addon for elementor that includes 80+ elements & 360 Blocks with unlimited variations. HT Mega brings limitless possibilities. Embellish your site with the elements of HT Mega.', '99fy' ),
                ),

                array(
                    'slug'      => 'swatchly-pro',
                    'location'  => 'swatchly-pro.php',
                    'name'      => esc_html__( 'Product Variation Swatches', '99fy' ),
                    'link'      => 'https://hasthemes.com/plugins/swatchly-product-variation-swatches-for-woocommerce-products/',
                    'author_link'=> 'https://hasthemes.com/',
                    'description'=> esc_html__( 'Are you getting frustrated with WooCommerce’s current way of presenting the variants for your products? Well, say goodbye to dropdowns and start showing the product variations in a whole new light with Swatchly.', '99fy' ),
                ),

                array(
                    'slug'      => 'whols-pro',
                    'location'  => 'whols-pro.php',
                    'name'      => esc_html__( 'Whols Pro', '99fy' ),
                    'link'      => 'https://hasthemes.com/plugins/whols-woocommerce-wholesale-prices/',
                    'author_link'=> 'https://hasthemes.com/',
                    'description'=> esc_html__( 'Whols is an outstanding WordPress plugin for WooCommerce that allows store owners to set wholesale prices for the products of their online stores. This plugin enables you to show special wholesale prices to the wholesaler. Users can easily request to become a wholesale customer by filling out a simple online registration form. Once the registration is complete, the owner of the store will be able to review the request and approve the request either manually or automatically.', '99fy' ),
                ),

                array(
                    'slug'      => 'just-tables-pro',
                    'location'  => 'just-tables-pro.php',
                    'name'      => esc_html__( 'JustTables Pro', '99fy' ),
                    'link'      => 'https://hasthemes.com/wp/justtables/',
                    'author_link'=> 'https://hasthemes.com/',
                    'description'=> esc_html__( 'JustTables is an incredible WordPress plugin that lets you showcase all your WooCommerce products in a sortable and filterable table view. It allows your customers to easily navigate through different attributes of the products and compare them on a single page. This plugin will be of great help if you are looking for an easy solution that increases the chances of landing a sale on your online store.', '99fy' ),
                ),

                array(
                    'slug'      => 'multicurrencypro',
                    'location'  => 'multicurrencypro.php',
                    'name'      => esc_html__( 'Multi Currency Pro for WooCommerce', '99fy' ),
                    'link'      => 'https://hasthemes.com/plugins/multi-currency-pro-for-woocommerce/',
                    'author_link'=> 'https://hasthemes.com/',
                    'description'=> esc_html__( 'Multi-Currency Pro for WooCommerce is a prominent currency switcher plugin for WooCommerce. This plugin allows your website or online store visitors to switch to their preferred currency or their country’s currency.', '99fy' ),
                ),

                array(
                    'slug'      => 'cf7-extensions-pro',
                    'location'  => 'cf7-extensions-pro.php',
                    'name'      => esc_html__( 'Extensions For CF7 Pro', '99fy' ),
                    'link'      => 'https://hasthemes.com/plugins/cf7-extensions/',
                    'author_link'=> 'https://hasthemes.com/',
                    'description'=> esc_html__( 'Contact Form7 Extensions plugin is a fantastic WordPress plugin that enriches the functionalities of Contact Form 7.This all-in-one WordPress plugin will help you turn any contact page into a well-organized, engaging tool for communicating with your website visitors by providing tons of advanced features like drag and drop file upload, repeater field, trigger error for already submitted forms, popup form response, country flags and dial codes with a telephone input field and acceptance field, etc. in addition to its basic features.', '99fy' ),
                ),

                array(
                    'slug'      => 'hashbar-pro',
                    'location'  => 'init.php',
                    'name'      => esc_html__( 'HashBar Pro', '99fy' ),
                    'link'      => 'https://hasthemes.com/plugins/wordpress-notification-bar-plugin/',
                    'author_link'=> 'https://hasthemes.com/',
                    'description'=> esc_html__( 'HashBar is a WordPress Notification / Alert / Offer Bar plugin which allows you to create unlimited notification bars to notify your customers. This plugin has option to show email subscription form (sometimes it increases up to 500% email subscriber), Offer text and buttons about your promotions. This plugin has the options to add unlimited background colors and images to make your notification bar more professional.', '99fy' ),
                ),

                array(
                    'slug'      => 'wp-plugin-manager-pro',
                    'location'  => 'plugin-main.php',
                    'name'      => esc_html__( 'WP Plugin Manager Pro', '99fy' ),
                    'link'      => 'https://hasthemes.com/plugins/wp-plugin-manager-pro/',
                    'author_link'=> 'https://hasthemes.com/',
                    'description'=> esc_html__( 'WP Plugin Manager Pro is a specialized WordPress Plugin that helps you to deactivate unnecessary WordPress Plugins page wise and boosts the speed of your WordPress site to improve the overall site performance.', '99fy' ),
                ),

                array(
                    'slug'      => 'ht-script-pro',
                    'location'  => 'plugin-main.php',
                    'name'      => esc_html__( 'HT Script Pro', '99fy' ),
                    'link'      => 'https://hasthemes.com/plugins/insert-headers-and-footers-code-ht-script/',
                    'author_link'=> 'https://hasthemes.com/',
                    'description'=> esc_html__( 'Insert Headers and Footers Code allows you to insert Google Analytics, Facebook Pixel, custom CSS, custom HTML, JavaScript code to your website header and footer without modifying your theme code.This plugin has the option to add any custom code to your theme in one place, no need to edit the theme code. It will save your time and remove the hassle for the theme update.', '99fy' ),
                ),

                array(
                    'slug'      => 'ht-menu',
                    'location'  => 'ht-mega-menu.php',
                    'name'      => esc_html__( 'HT Menu Pro', '99fy' ),
                    'link'      => 'https://hasthemes.com/plugins/ht-menu-pro/',
                    'author_link'=> 'https://hasthemes.com/',
                    'description'=> esc_html__( 'WordPress Mega Menu Builder for Elementor', '99fy' ),
                ),

                array(
                    'slug'      => 'ht-slider-addons-pro',
                    'location'  => 'ht-slider-addons-pro.php',
                    'name'      => esc_html__( 'HT Slider Pro For Elementor', '99fy' ),
                    'link'      => 'https://hasthemes.com/plugins/ht-slider-pro-for-elementor/',
                    'author_link'=> 'https://hasthemes.com/',
                    'description'=> esc_html__( 'HT Slider Pro is a plugin to create a slider for WordPress websites easily using the Elementor page builder. 80+ prebuild slides/templates are included in this plugin. There is the option to create a post slider, WooCommerce product slider, Video slider, image slider, etc. Fullscreen, full width and box layout option are included.', '99fy' ),
                ),

                array(
                    'slug'      => 'ht-google-place-review',
                    'location'  => 'ht-google-place-review.php',
                    'name'      => esc_html__( 'Google Place Review', '99fy' ),
                    'link'      => 'https://hasthemes.com/plugins/google-place-review-plugin-for-wordpress/',
                    'author_link'=> 'https://hasthemes.com/',
                    'description'=> esc_html__( 'If you are searching for a modern and excellent google places review WordPress plugin to showcase reviews from Google Maps and strengthen trust between you and your site visitors, look no further than HT Google Place Review', '99fy' ),
                ),

                array(
                    'slug'      => 'was-this-helpful',
                    'location'  => 'was-this-helpful.php',
                    'name'      => esc_html__( 'Was This Helpful?', '99fy' ),
                    'link'      => 'https://hasthemes.com/plugins/was-this-helpful/',
                    'author_link'=> 'https://hasthemes.com/',
                    'description'=> esc_html__( "Was this helpful? is a WordPress plugin that allows you to take visitors' feedback on your post/pages or any article. A visitor can share his feedback by like/dislike/yes/no", '99fy' ),
                ),

                array(
                    'slug'      => 'ht-click-to-call',
                    'location'  => 'ht-click-to-call.php',
                    'name'      => esc_html__( 'HT Click To Call', '99fy' ),
                    'link'      => 'https://hasthemes.com/plugins/ht-click-to-call/',
                    'author_link'=> 'https://hasthemes.com/',
                    'description'=> esc_html__( "HT – Click to Call is a lightweight WordPress plugin that allows you to add a floating click to call button on your website. It will offer your website visitors an opportunity to call your business immediately at the right moment, especially when they are interested in your products or services and seeking more information.", '99fy' ),
                ),

                array(
                    'slug'      => 'docus-pro',
                    'location'  => 'docus-pro.php',
                    'name'      => esc_html__( 'Docus Pro', '99fy' ),
                    'link'      => 'https://hasthemes.com/plugins/docus-pro-youtube-video-playlist/',
                    'author_link'=> 'https://hasthemes.com/',
                    'description'=> esc_html__( "Embedding a YouTube playlist into your website plays a vital role to curate your content into several categories and make your web content more engaging and popular by keeping the visitors on your website for a longer period.", '99fy' ),
                ),

            )
        ));

        $get_instance->add_new_tab(array(
            'title' => esc_html__( 'Others', '99fy' ),
            'plugins' => array(

                array(
                    'slug'      => 'really-simple-google-tag-manager',
                    'location'  => 'really-simple-google-tag-manager.php',
                    'name'      => esc_html__( 'Really Simple Google Tag Manager', '99fy' )
                ),

                array(
                    'slug'      => 'ht-instagram',
                    'location'  => 'ht-instagram.php',
                    'name'      => esc_html__( 'HT Feed', '99fy' )
                ),

                array(
                    'slug'      => 'faster-youtube-embed',
                    'location'  => 'faster-youtube-embed.php',
                    'name'      => esc_html__( 'Faster YouTube Embed', '99fy' )
                ),

                array(
                    'slug'      => 'wc-sales-notification',
                    'location'  => 'wc-sales-notification.php',
                    'name'      => esc_html__( 'WC Sales Notification', '99fy' )
                ),

                array(
                    'slug'      => 'preview-link-generator',
                    'location'  => 'preview-link-generator.php',
                    'name'      => esc_html__( 'Preview Link Generator', '99fy' )
                ),

                array(
                    'slug'      => 'quickswish',
                    'location'  => 'quickswish.php',
                    'name'      => esc_html__( 'QuickSwish', '99fy' )
                ),

                array(
                    'slug'      => 'docus',
                    'location'  => 'docus.php',
                    'name'      => esc_html__( 'Docus – YouTube Video Playlist', '99fy' )
                ),

                array(
                    'slug'      => 'data-captia',
                    'location'  => 'data-captia.php',
                    'name'      => esc_html__( 'DataCaptia', '99fy' )
                ),

                array(
                    'slug'      => 'coupon-zen',
                    'location'  => 'coupon-zen.php',
                    'name'      => esc_html__( 'Coupon Zen', '99fy' )
                ),

                array(
                    'slug'      => 'sirve',
                    'location'  => 'sirve.php',
                    'name'      => esc_html__( 'Sirve – Simple Directory Listing', '99fy' )
                ),

                array(
                    'slug'      => 'ht-social-share',
                    'location'  => 'ht-social-share.php',
                    'name'      => esc_html__( 'HT Social Share', '99fy' )
                ),

            )
        ));


    }

    // Options page Section register
    function admin_get_settings_sections() {
        $sections = array(

            array(
                'id'    => 'nnfy_general_tabs',
                'title' => esc_html__( 'General', '99fy' )
            ),

        );

        $advance_element = array();

        return array_merge( $sections, $advance_element );
    }

    // Options page field register
    protected function admin_fields_settings() {

        $settings_fields = array(

            'nnfy_general_tabs'=>array(

            ),


        );

        return $settings_fields;
    }


    function plugin_page() {

        echo '<div class="wrap">';
            echo '<h2>'.esc_html__( '99Fy Settings','99fy' ).'</h2>';
            $this->save_message();
            $this->settings_api->show_navigation();
            $this->settings_api->show_forms();
        echo '</div>';

    }

    function save_message() {
        if( isset($_GET['settings-updated']) ) { ?>
            <div class="updated notice is-dismissible"> 
                <p><strong><?php esc_html_e('Successfully Settings Saved.', '99fy') ?></strong></p>
            </div>
            <?php
        }
    }

    // General tab
    function html_general_tabs(){
        ob_start();
        ?>
            <div class="nnfy-general-tabs">

                <div class="nnfy-document-section">
                    <div class="nnfy-column">
                        <a href="https://youtu.be/yDAC3JhW4jU" target="_blank">
                            <img src="<?php echo NNFY_PL_URL; ?>/admin/assets/images/video-tutorial.jpg" alt="<?php esc_attr_e( 'Video Tutorial', '99fy' ); ?>">
                        </a>
                    </div>
                    <div class="nnfy-column">
                        <a href="https://99fy.thethemedemo.com/landing/index.html" target="_blank">
                            <img src="<?php echo NNFY_PL_URL; ?>/admin/assets/images/online-documentation.jpg" alt="<?php esc_attr_e( 'Online Documentation', '99fy' ); ?>">
                        </a>
                    </div>
                    <div class="nnfy-column">
                        <a href="https://hasthemes.com/contact-us/" target="_blank">
                            <img src="<?php echo NNFY_PL_URL; ?>/admin/assets/images/genral-contact-us.jpg" alt="<?php esc_attr_e( 'Contact Us', '99fy' ); ?>">
                        </a>
                    </div>
                </div>

                <div class="different-pro-free">
                    <h3 class="nnfy-section-title"><?php echo esc_html__( '99Fy Free VS 99Fy Pro.', '99fy' ); ?></h3>

                    <div class="nnfy-admin-row">
                        <div class="features-list-area">
                            <h3><?php echo esc_html__( '99Fy Free', '99fy' ); ?></h3>
                            <ul>
                                <li><?php echo esc_html__( '8 Elementor Addons', '99fy' ); ?></li>
                                <li><?php echo esc_html__( '99 Home Page Include', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Topbar ( Hide / show )', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Topbar Action Button Control', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Breadcrumb 4 Layout', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Control Page title and Breadcrumb Options', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Breadcrumb and page title custom position', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Background Control Options', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Blog Column Options', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Blog Title length, Excerpt length', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Blog Read More button text change options', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Blog Meta Control options', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Blog page sidebar (Left, right, No sidebar )', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Shop page sidebar (Left, right, No sidebar )', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Footer Widgets Area hide/show options', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Footer Widgets column options', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Footer Copyright Area hide/show options', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Footer Copyright text change options', '99fy' ); ?></li>
                                <li class="nnfydel"><del><?php echo esc_html__( '5 Header Layouts', '99fy' ); ?></del></li>
                                <li class="nnfydel"><del><?php echo esc_html__( 'Sticky Header Options', '99fy' ); ?></del></li>
                                <li class="nnfydel"><del><?php echo esc_html__( 'Logo Position Options', '99fy' ); ?></del></li>
                                <li class="nnfydel"><del><?php echo esc_html__( 'Blog Sticky Sidebar Options', '99fy' ); ?></del></li>
                                <li class="nnfydel"><del><?php echo esc_html__( 'Shop Sticky Sidebar Options', '99fy' ); ?></del></li>
                                <li class="nnfydel"><del><?php echo esc_html__( '5 Footer Layouts', '99fy' ); ?></del></li>
                                <li class="nnfydel"><del><?php echo esc_html__( 'Sticky Footer Options', '99fy' ); ?></del></li>
                            </ul>
                            <a class="button button-primary" href="<?php echo esc_url( \NNFy_Template_Library::instance()->get_pro_link() ); ?>" target="_blank"><?php echo esc_html__( 'Upgrade to Pro', '99fy' ); ?></a>
                        </div>
                        <div class="features-list-area">
                            <h3><?php echo esc_html__( '99Fy Pro', '99fy' ); ?></h3>
                            <ul>
                                <li><?php echo esc_html__( '8 Elementor Addons', '99fy' ); ?></li>
                                <li><?php echo esc_html__( '99 Home Page Include', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Topbar ( Hide / show )', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Topbar Action Button Control', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Breadcrumb 4 Layout', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Control Page title and Breadcrumb Options', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Breadcrumb and page title custom position', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Background Control Options', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Blog Column Options', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Blog Title length, Excerpt length', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Blog Read More button text change options', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Blog Meta Control options', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Blog page sidebar (Left, right, No sidebar )', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Shop page sidebar (Left, right, No sidebar )', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Footer Widgets Area hide/show options', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Footer Widgets column options', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Footer Copyright Area hide/show options', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Footer Copyright text change options', '99fy' ); ?></li>
                                <li><?php echo esc_html__( '5 Header Layouts', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Sticky Header Options', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Logo Position Options', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Blog Sticky Sidebar Options', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Shop Sticky Sidebar Options', '99fy' ); ?></li>
                                <li><?php echo esc_html__( '5 Footer Layouts', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Sticky Footer Options', '99fy' ); ?></li>
                            </ul>
                            <a class="button button-primary" href="<?php echo esc_url( \NNFy_Template_Library::instance()->get_pro_link() ); ?>" target="_blank"><?php echo esc_html__( 'Buy Now', '99fy' ); ?></a>
                        </div>
                    </div>

                </div>

            </div>
        <?php
        echo ob_get_clean();
    }



}

new NNFy_Admin_Settings();