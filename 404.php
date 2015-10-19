<?php get_header( ); ?>

<div id="error-page-section" class="error-page-section">
        <!-- container -->
        <div class="container">
            <!-- col-md-6 -->
            <div class="col-md-6 error-content">
                <img src="<?php echo get_stylesheet_directory_uri();  ?>/assets/images/404.png" alt="404" />
                <h3>Ohh! Coundn’t Find it</h3>
                <p>This file May Have Been Moved or Delated. Be Sure to Check Your Spelling.</p>
                <aside class="widget widget_search">
                    <form class="search" role="search" action="#" method="get">
                        <input type="text" name="s" id="s" placeholder="search again..." class="form-control" required="">
                        <span class="search-icon input-group-btn"><button class="btn btn-xlg" type="submit"></button></span>
                    </form>
                </aside>
            </div><!-- col-md-6 -->
            <!-- col-md-6 -->
            <div class="col-md-6">
                <img src="<?php echo get_stylesheet_directory_uri();  ?>/assets/images/404-2.jpg" alt="404-2" />
            </div><!-- col-md-6 -->
        </div><!-- container -->
    </div>

<?php get_footer( ); ?>