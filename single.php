<?php get_header( ); ?>

<?php if(have_posts()): ?>
    <?php while(have_posts()): ?>
        <?php the_post(); ?>

        <div id="blog-section" class="blog-section blog-list ow-section">
        <!-- container -->
            <div class="container">

                <?php if((isset($makeclean_theme_option['sidebar-post'])) && ($makeclean_theme_option['sidebar-post'] ==0)): ?>
                    <div class="col-md-12 col-sm-11 no-padding">
                <?php else: ?>
                    <div class="col-md-8 col-sm-7 no-padding">
                    <?php endif;  ?>
                        <?php get_template_part('content',get_post_format( ) ); ?>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                    <div class="comment-area">
                    <h2>comments (<?php  wp_count_comments(the_ID()) ?>)</h2>
                    <?php comment_form( );
                     ?>
                    </div>

                </div>
             </div>
                <div class="col-md-1 col-sm-1"></div>
                <?php get_sidebar('blog' ); ?>
            </div><!-- container /- -->
        </div>
        <?php endwhile; ?>
    <?php endif; ?>

<?php get_footer( ); ?>