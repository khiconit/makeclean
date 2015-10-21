<!DOCTYPE html>
<html <?php  language_attributes( ); ?>>
<head>
    <meta charset="<?php bloginfo( ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php makeclean_favicon();  ?>
    <link rel="profile" href="http://gmgp.org/xfn/11" />
    <link rel="pingback" href="<?php echo bloginfo('pingback_url' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>   data-offset="200" data-spy="scroll" data-target=".primary-navigation">
    <a id="top"></a>
    <header id="header-section" class="header-section">
        <!-- Top Header -->
        <div class="top-header">
            <!-- container -->
            <div class="container">
                <div class="row">
                    <!-- col-md-6 -->
                    <div class="col-md-6 col-sm-6">
                        <p><img  src="<?php echo  get_template_directory_uri() ?>/assets/images/icon/thumbs-icon.png" alt="thumbs-icon"/>
                        <?php left_sticker() ; ?></p>
                    </div><!-- col-md-6 /- -->
                    <!-- col-md-6 -->
                    <div class="col-md-6 col-sm-6 text-right">
                        <p><img  src="<?php echo  get_template_directory_uri() ?>/assets/images/icon/clock-icon.png" alt="clock-icon"/>
                        <?php right_sticker() ?></p>
                    </div><!-- col-md-6 /- -->
                </div>
            </div><!-- container /- -->
        </div><!-- Top Header /- -->
        <!-- Logo Block -->
        <div class="logo-block">
            <!-- container -->
            <div class="container">
                <div class="row">
                    <!-- Display Logo -->
                        <?php makeclean_logo(); ?>
                    <!-- /Display logo -->
                    <!-- col-md-4 -->
                    <div class="col-md-6 col-sm-8 pull-right row">
                        <!-- col-md-7 -->
                        <div class="col-md-6 col-sm-6 col-sm-offset-2 col-md-offset-2 call-us">
                            <img src="<?php echo  get_template_directory_uri() ?>/assets/images/icon/mobile-icon.png" alt="mobile-icon" />
                           <?php makeclean_contact_phone() ?>
                        </div><!-- col-md-7 /- -->
                        <!-- col-md-5 -->
                        <div class="cart col-md-4 col-sm-4 text-right ow-padding-left dropdown"><span><?php _e('Your cart',KC_DOMAIN) ?></span>
                            <p id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="cart-icon"><?php echo WC()->cart->cart_contents_count ;?></i>
                            </p>
                                 <ul class="dropdown-menu" aria-labelledby="dLabel" id="top-cart">
                                <div class="col-md-12" id="head-cart"><?php echo do_shortcode('[woocommerce_cart]' ); ?></div>
                                </ul>

                        </div><!-- col-md-5 /- -->
                    </div><!-- col-md-4 /- -->
                </div>
            </div>
        </div><!-- Logo Block /- -->
        <!-- Menu Block -->
        <div class="menu-block">
            <div class="container">
                <div class="row">
                    <!-- col-md-8 -->


                    <nav class="navbar navbar-default col-md-8">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <?php  makeclean_logo_response() ?>
                        </div>
                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <?php  makeclean_main_menu('main_menu'); ?>

                    </nav><!-- col-md-8 /- -->
                    <div class="col-md-4 quote">
                        <a  title="Free Quote"   data-toggle="modal" href='#contact-modal'><?php _e('free instant quote',KC_DOMAIN) ?></a>
                    </div>
                </div>
            </div><!-- /.container -->
        </div><!-- Menu Block /- -->
    </header><!-- Header Section /- -->
    <!-- Page Banner -->
   <?php if((breadcrum() ) && (!is_home())): ?>
 <div id="page-banner" class="page-banner">
        <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/page-banner.png" alt="page-banner" />
        <!-- container -->
        <div class="page-detail">
            <div class="container">

                <!-- <div class="page-breadcrumb pull-right">
                    <ol class="breadcrumb">
                        <li class="page-title"><a title="<?php bloginfo( 'name'); ?>" href="<?php  bloginfo('url'); ?>">Home</a></li>
                       <li class="page-title">Shop </li>
                    </ol>
                </div> -->
            </div>
        </div><!-- container /- -->
    </div><!-- Page Banner /- -->

   <?php endif; ?>