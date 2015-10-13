<?php
function plugin_required_activation(){
    $plugins_path = get_template_directory().'/core/tgm/plugins';
    /*Plugin Required */
    $plugins        =       [
            [
                'name'          =>      'Redux Framework',
                'slug'          =>      'redux-framework',
                'required'      =>      true,
            ],
            [
                'name'          =>      'Visual Composer',
                'slug'          =>      'js_composer',
                'source'        =>      $plugins_path.'/js_composer.zip',
                'required'      =>      true,
            ],
            [
                'name'          =>      'Slider Revolution',
                'slug'          =>      'revslider',
                'source'        =>      $plugins_path.'/revslider.zip',
                'required'      =>      true
            ],
            [
                'name'          =>      'Contact Form 7',
                'slug'          =>      'contact-form-7',
                'required'      =>      false
            ],
            [
                'name'          =>      'Team members',
                'slug'          =>      'team-members',
                'required'      =>      true
            ],
            [
            'name'              =>  'WooCommerce - excelling eCommerce ',
            'slug'              =>  'woocommerce',
            'required'          =>  true
            ],
            [
            'name'              =>  'YITH WooCommerce Brands Add-On',
            'slug'              =>  'yith-woocommerce-brands-add-on/',
            'required'          =>  true
            ]

    ];
    $configs        =       [
            'menu'          =>      'makeclean_plugin_install',
            'has_notice'    =>      true,
            'dissmissable'  =>      false,
            'is_automatic'  =>      true,
    ];
    tgmpa($plugins,$configs);

}
add_action('tgmpa_register','plugin_required_activation' );