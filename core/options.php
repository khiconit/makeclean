<?php
    if ( ! class_exists( 'MakeClean_Theme_Options' ) ) {

        class MakeClean_Theme_Options {

            public $args = array();
            public $sections = array();
            public $theme;
            public $ReduxFramework;

            public function __construct() {

                if ( ! class_exists( 'ReduxFramework' ) ) {
                    return;
                }

                // This is needed. Bah WordPress bugs.  ;)
                if ( true == Redux_Helpers::isTheme( __FILE__ ) ) {
                    $this->initSettings();
                } else {
                    add_action( 'plugins_loaded', array( $this, 'initSettings' ), 10 );
                }

            }

            public function initSettings() {

                // Set the default arguments
                $this->setArguments();

                // Set a few help tabs so you can see how it's done
                $this->setHelpTabs();

                // Create the sections and fields
                $this->setSections();

                if ( ! isset( $this->args['opt_name'] ) ) { // No errors please
                    return;
                }

                $this->ReduxFramework = new ReduxFramework( $this->sections, $this->args );
            }

            public function setSections() {

                $this->sections[] = array(
                    'title'  => __( 'General', KC_DOMAIN ),
                    'desc'   => __( 'Setting General.', KC_DOMAIN ),
                    'icon'   => 'el el-lines',
                    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                    'fields' => array(
                        ['id'   => 'favicon',
                        'type'  =>'media',
                        'title' =>  __('Logo favicon',KC_DOMAIN),
                        'desc'  => __('Choose your favicon',KC_DOMAIN),
                        ],

                    )
                );
               // Section header
                $this->sections[] = array(
                    'title'  => __( 'Header', KC_DOMAIN ),
                    'desc'   => __( 'Option for header', 'redux-framework-demo' ),
                    'icon'   => 'el el-home',
                    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                    'fields' => array(

                        [
                            'id'       => 'logo-on',
                            'type'     => 'switch',
                            'title'    => __( 'Enable images logo', KC_DOMAIN ),
                            'compiler' => 'bool',
                            // Can be set to false to allow any media type, or can also be set to any mime type.
                            'desc'     => __( 'Do you want display logo on website.', KC_DOMAIN ),
                            'subtitle' => __( 'Display logo on website.', KC_DOMAIN ),
                            'on'        => __('Enabled',KC_DOMAIN),
                            'off'       => __('Disabled',KC_DOMAIN),
                            'hint'     => array(
                                //'title'     => '',
                                'content' => 'This is a <b>hint</b> tool-tip for the webFonts field.<br/><br/>Add any HTML based text you like here.',
                            )
                        ],
                        ['id'   => 'logo-image',
                        'type'  =>'media',
                        'title' =>  __('Logo Images',KC_DOMAIN),
                        'desc'  => __('Choose your logo',KC_DOMAIN),
                        ],
                        ['id'   => 'logo-image-mobile',
                        'type'  =>'media',
                        'title' =>  __('Logo Images for mobile response',KC_DOMAIN),
                        'desc'  => __('Choose your logo',KC_DOMAIN),
                        ],
                        [
                        'id'       => 'text-logo',
                        'type'     => 'text',
                        'title'    => __( 'Text logo', KC_DOMAIN ),
                        'compiler' => 'true',
                        // Can be set to false to allow any media type, or can also be set to any mime type.
                        'desc'     => __( 'Display text on logo header.', KC_DOMAIN ),
                        'subtitle' => __( 'Display text on logo header if Logo images is off.', KC_DOMAIN  ),
                        'hint'     => array(
                            //'title'     => '',
                            'content' => 'This is a <b>hint</b> tool-tip for the webFonts field.<br/><br/>Add any HTML based text you like here.',
                            )
                        ],
                        [
                        'id'       => 'text-contact-phone',
                        'type'     => 'text',
                        'title'    => __( 'Text description contact phone', KC_DOMAIN ),
                        'compiler' => 'true',
                        // Can be set to false to allow any media type, or can also be set to any mime type.
                        'desc'     => __( 'Text contact phone.', KC_DOMAIN ),
                        'subtitle' => __( 'Description for text contact phone.', KC_DOMAIN  ),
                        'hint'     => array(
                            //'title'     => '',
                            'content' => 'This is a <b>hint</b> tool-tip for the webFonts field.<br/><br/>Add any HTML based text you like here.',
                            )
                        ],
                        [
                        'id'       => 'contact-phone',
                        'type'     => 'text',
                        'title'    => __( 'Phone number', KC_DOMAIN ),
                        'compiler' => 'true',
                        // Can be set to false to allow any media type, or can also be set to any mime type.
                        'desc'     => __( 'Phone number your company.', KC_DOMAIN ),
                        'subtitle' => __( 'Phone number.', KC_DOMAIN  ),
                        'hint'     => array(
                            //'title'     => '',
                            'content' => 'This is a <b>hint</b> tool-tip for the webFonts field.<br/><br/>Add any HTML based text you like here.',
                            )
                        ],


                    )
                );
                    //Section font
                $this->sections[] = array(
                    'title'  => __( 'Toypography', KC_DOMAIN ),
                    'desc'   => __( 'Setting Typography.', KC_DOMAIN ),
                    'icon'   => 'el el-font',
                    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                    'fields' => array(
                        array(
                            'id'       => 'font-main',
                            'type'     => 'typography',
                            'title'    => __( 'Main typography', KC_DOMAIN ),
                            'output'   => 'body',
                            'text-transform'    =>true,
                            'default'   => ['font-size'=>'14px',
                                            'font-family'=>'tahoma',
                                            'font-color'     => '#33333',

                                            ]
                        ),

                    )
                );

                $this->sections[] = array(
                    'title'  => __( 'Footer', KC_DOMAIN ),
                    'desc'   => __( 'Setting footer.', KC_DOMAIN ),
                    'icon'   => 'el el-photo',
                    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                    'fields' => array(
                         [
                        'id'       => 'text-footer',
                        'type'     => 'editor',
                        'title'    => __( 'Text content on footer', KC_DOMAIN ),
                        'compiler' => 'true',
                        // Can be set to false to allow any media type, or can also be set to any mime type.
                        'desc'     => __( 'Text contact phone.', KC_DOMAIN ),
                        'subtitle' => __( 'Description for text contact phone.', KC_DOMAIN  ),
                        'hint'     => array(
                            //'title'     => '',
                            'content' => 'Enter your phone number display on footer.',
                            )
                        ],
                        [
                        'id'       => 'copyright_footer',
                        'type'     => 'editor',
                        'title'    => __( 'Copyright in footer', KC_DOMAIN ),
                        'compiler' => 'true',
                        // Can be set to false to allow any media type, or can also be set to any mime type.
                        'desc'     => __( 'Text Copyright in footer.', KC_DOMAIN ),
                        'subtitle' => __( 'Enter   text .', KC_DOMAIN  ),
                        'hint'     => array(
                            //'title'     => '',
                            'content' => 'Enter your  display on footer.',
                            )
                        ],

                    )
                );


                //Setcontent
            $this->sections[] = array(
                    'title'  => __( 'Content setting', KC_DOMAIN ),
                    'desc'   => __( 'Setting Content.', KC_DOMAIN ),
                    'icon'   => 'el el-align-center',
                    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                    'fields' => array(

                        [
                            'id'       => 'sidebar-archive',
                            'type'     => 'switch',
                            'title'    => __( 'Enable Sidebar on categories page', KC_DOMAIN ),
                            'compiler' => 'bool',
                            // Can be set to false to allow any media type, or can also be set to any mime type.
                            'desc'     => __( 'Layout display on categories page.', KC_DOMAIN ),
                            'subtitle' => __( 'Layout display on categories page.', KC_DOMAIN ),
                            'on'        => __('Enabled',KC_DOMAIN),
                            'off'       => __('Disabled',KC_DOMAIN),
                            'hint'     => array(
                                //'title'     => '',
                                'content' => 'This is a <b>hint</b> tool-tip for the webFonts field.<br/><br/>Add any HTML based text you like here.',
                            )
                        ],
                        [
                        'id'       => 'number-item-page',
                        'type'     => 'number',
                        'title'    => __( 'Number items on page', KC_DOMAIN ),
                        'compiler' => 'true',
                        // Can be set to false to allow any media type, or can also be set to any mime type.
                        'desc'     => __( 'Number items on page.', KC_DOMAIN ),
                        'subtitle' => __( 'Number items on page.', KC_DOMAIN  ),
                        'hint'     => array(
                            //'title'     => '',
                            'content' => 'Number items on page.',
                            )
                        ],
                        [
                            'id'       => 'sidebar-post',
                            'type'     => 'switch',
                            'title'    => __( 'Enable Sidebar on blog post page', KC_DOMAIN ),
                            'compiler' => 'bool',
                            // Can be set to false to allow any media type, or can also be set to any mime type.
                            'desc'     => __( 'Enable Sidebar on blog post page.', KC_DOMAIN ),
                            'subtitle' => __( 'Enable Sidebar on blog post page.', KC_DOMAIN ),
                            'on'        => __('Enabled',KC_DOMAIN),
                            'off'       => __('Disabled',KC_DOMAIN),
                            'hint'     => array(
                                //'title'     => '',
                                'content' => 'This is a <b>hint</b> tool-tip for the webFonts field.<br/><br/>Add any HTML based text you like here.',
                            )
                        ],
                         [
                            'id'       => 'breadcrumb-shop',
                            'type'     => 'switch',
                            'title'    => __( 'Enable Breabcrum on shop page', KC_DOMAIN ),
                            'compiler' => 'bool',
                            // Can be set to false to allow any media type, or can also be set to any mime type.
                            'desc'     => __( 'Enable Breabcrum on shop page.', KC_DOMAIN ),
                            'subtitle' => __( 'Enable Breabcrum on shop page.', KC_DOMAIN ),
                            'on'        => __('Enabled',KC_DOMAIN),
                            'off'       => __('Disabled',KC_DOMAIN),
                            'hint'     => array(
                                //'title'     => '',
                                'content' => 'This is a <b>hint</b> tool-tip for the webFonts field.<br/><br/>Add any HTML based text you like here.',
                            )
                        ],
                        [
                        'id'       => 'popup-contact',
                        'type'     => 'text',
                        'title'    => __( 'Contact form popup', KC_DOMAIN ),
                        'compiler' => 'true',
                        // Can be set to false to allow any media type, or can also be set to any mime type.
                        'desc'     => __( 'Paste your shortcode Contact form 7.', KC_DOMAIN ),
                        'subtitle' => __( 'Shortcode will display on popup.', KC_DOMAIN  ),
                        'hint'     => array(
                            //'title'     => '',
                            'content' => 'Paste your shortcode Contact form 7.',
                            )
                        ],


                    )
                );
            }

            public function setHelpTabs() {

                // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
                $this->args['help_tabs'][] = array(
                    'id'      => 'redux-help-tab-1',
                    'title'   => __( 'Theme Information 1', 'redux-framework-demo' ),
                    'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'redux-framework-demo' )
                );

                $this->args['help_tabs'][] = array(
                    'id'      => 'redux-help-tab-2',
                    'title'   => __( 'Theme Information 2', 'redux-framework-demo' ),
                    'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'redux-framework-demo' )
                );

                // Set the help sidebar
                $this->args['help_sidebar'] = __( '<p>This is the sidebar content, HTML is allowed.</p>', 'redux-framework-demo' );
            }

            /**
             * All the possible arguments for Redux.
             * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
             * */
            public function setArguments() {

                $theme = wp_get_theme(); // For use with some settings. Not necessary.

                $this->args = array(
                    // TYPICAL -> Change these values as you need/desire
                    'opt_name'           => 'makeclean_theme_option',
                    // This is where your data is stored in the database and also becomes your global variable name.
                    'display_name'       => $theme->get( 'Name' ),
                    // Name that appears at the top of your panel
                    'display_version'    => $theme->get( 'Version' ),
                    // Version that appears at the top of your panel
                    'menu_type'          => 'menu',
                    //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                    'allow_sub_menu'     => true,
                    // Show the sections below the admin menu item or not
                    'menu_title'         => __( 'Make Clean Theme Option', 'makeclean-option' ),
                    'page_title'         => __( 'Make Clean Theme Option', 'makeclean-option' ),
                    // You will need to generate a Google API key to use this feature.
                    // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                    'google_api_key'     => 'AIzaSyAs0iVWrG4E_1bG244-z4HRKJSkg7JVrVQ',
                    // Must be defined to add google fonts to the typography module

                    'async_typography'   => false,
                    // Use a asynchronous font on the front end or font string
                    'admin_bar'          => true,
                    // Show the panel pages on the admin bar
                    'global_variable'    => '',
                    // Set a different name for your global variable other than the opt_name
                    'dev_mode'           => true,
                    // Show the time the page took to load, etc
                    'customizer'         => true,
                    // Enable basic customizer support

                    // OPTIONAL -> Give you extra features
                    'page_priority'      => null,
                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                    // 'page_parent'        => 'themes.php',
                    // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                    'page_permissions'   => 'manage_options',
                    // Permissions needed to access the options panel.
                    'menu_icon'          => 'dashicons-hammer',
                    // Specify a custom URL to an icon
                    'last_tab'           => '',
                    // Force your panel to always open to a specific tab (by id)
                    'page_icon'          => 'icon-themes',
                    // Icon displayed in the admin panel next to your menu_title
                    'page_slug'          => '_options',
                    // Page slug used to denote the panel
                    'save_defaults'      => true,
                    // On load save the defaults to DB before user clicks save or not
                    'default_show'       => false,
                    // If true, shows the default value next to each field that is not the default value.
                    'default_mark'       => '',
                    // What to print by the field's title if the value shown is default. Suggested: *
                    'show_import_export' => true,
                    // Shows the Import/Export panel when not used as a field.

                    // CAREFUL -> These options are for advanced use only
                    'transient_time'     => 60 * MINUTE_IN_SECONDS,
                    'output'             => true,
                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                    'output_tag'         => true,
                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                    // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

                    // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                    'database'           => '',
                    // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                    'system_info'        => false,
                    // REMOVE

                    // HINTS
                    'hints'              => array(
                        'icon'          => 'icon-question-sign',
                        'icon_position' => 'right',
                        'icon_color'    => 'lightgray',
                        'icon_size'     => 'normal',
                        'tip_style'     => array(
                            'color'   => 'light',
                            'shadow'  => true,
                            'rounded' => false,
                            'style'   => '',
                        ),
                        'tip_position'  => array(
                            'my' => 'top left',
                            'at' => 'bottom right',
                        ),
                        'tip_effect'    => array(
                            'show' => array(
                                'effect'   => 'slide',
                                'duration' => '500',
                                'event'    => 'mouseover',
                            ),
                            'hide' => array(
                                'effect'   => 'slide',
                                'duration' => '500',
                                'event'    => 'click mouseleave',
                            ),
                        ),
                    )
                );


                // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
                $this->args['share_icons'][] = array(
                    'url'   => 'https://github.com/ReduxFramework/ReduxFramework',
                    'title' => 'Visit us on GitHub',
                    'icon'  => 'el el-github'
                    //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
                );
                $this->args['share_icons'][] = array(
                    'url'   => 'https://www.facebook.com/khi.con.01',
                    'title' => 'Like us on Facebook',
                    'icon'  => 'el el-facebook'
                );
                $this->args['share_icons'][] = array(
                    'url'   => 'http://twitter.com/reduxframework',
                    'title' => 'Follow us on Twitter',
                    'icon'  => 'el el-twitter'
                );
                $this->args['share_icons'][] = array(
                    'url'   => 'http://www.linkedin.com/company/redux-framework',
                    'title' => 'Find us on LinkedIn',
                    'icon'  => 'el el-linkedin'
                );

                // Panel Intro text -> before the form
                if ( ! isset( $this->args['global_variable'] ) || $this->args['global_variable'] !== false ) {
                    if ( ! empty( $this->args['global_variable'] ) ) {
                        $v = $this->args['global_variable'];
                    } else {
                        $v = str_replace( '-', '_', $this->args['opt_name'] );
                    }
                    $this->args['intro_text'] = sprintf( __( '<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'redux-framework-demo' ), $v );
                } else {
                    $this->args['intro_text'] = __( '<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'redux-framework-demo' );
                }

                // Add content after the form.
                $this->args['footer_text'] = __( '<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'redux-framework-demo' );
            }

        }

        global $reduxConfig;
        $reduxConfig = new MakeClean_Theme_Options();
    }
