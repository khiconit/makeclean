<?php get_header( ); ?>

<div id="blog-section" class="blog-section blog-list ow-section">
        <!-- container -->
        <div class="container">
            <!-- col-md-8 -->
            <div class="col-md-<?php echo makeclean_archive_layout(); ?> col-sm-7 no-padding">
            <?php if(have_posts()): ?>
                <?php while(have_posts()): ?>
                    <?php the_post(); ?>
                            <article>
                                <div class="blog-box">
                                    <div class="entry-cover">
                                        <a title="Blog Cover" href="<?php the_permalink(the_ID()); ?>"><?=get_the_post_thumbnail(the_ID(),'large'); ?></a>
                                        <span class="posted-on">
                                            <span class="like"><?php wp_count_comments() ?></span>
                                            <span class="date"><?php echo get_the_date('d/m/Y'); ?></span>
                                        </span>
                                    </div>
                                    <div class="blog-box-inner">
                                        <!-- entry header -->
                                        <header class="entry-header">
                                            <h3><a title="Post Title" href="blog-post.html"><?php the_title( ); ?></a></h3>
                                        </header><!-- entry header /- -->

                                        <footer class="entry-footer">
                                            <span class="byline">
                                                <span class="screen-reader-text"><?php __('BY',KC_DOMAIN) ?> </span>
                                                <?php author_link(); ?>
                                            </span>
                                            <span class="byline">
                                                <span class="screen-reader-text">Likes </span>
                                                <a title="Likes" href="#"><?php echo rand(1,100); ?></a>
                                            </span>
                                            <span class="byline">
                                                <span class="screen-reader-text"><?php single_cat_title(); ?> </span>
                                            </span>
                                        </footer>

                                        <div class="entry-content">
                                            <p><?php the_excerpt();?></p>
                                        </div>
                                    </div>
                                    <a href="<?php the_permalink(); ?>" class="btn"><?php _e('Read more',KC_DOMAIN) ?></a>
                                </div>
                            </article>
                        <?php endwhile; ?>
                    <?php endif; ?>


             <!--    <ul class="pagination">
                    <li>Pages</li>
                    <li><a title="Pagination" href="#">1</a></li>
                    <li><a title="Pagination" href="#">2</a></li>
                    <li><a title="Pagination" href="#">3</a></li>
                    <li><a title="Pagination" href="#">...</a></li>
                    <li><a title="Pagination" href="#">20</a></li>
                </ul> -->
               <?php
                 makeclean_archive_pagination();?>
            </div><!-- col-md-8 /- -->
            <div class="col-md-1 col-sm-1"></div>
            <!-- col-md-3 -->
            <?php if(makeclean_archive_layout() ==8) get_sidebar('blog' ); ?>
        <!-- container /- -->
    </div>

<?php get_footer( ); ?>