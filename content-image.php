<article>
                        <div class="blog-box">
                            <div class="entry-cover">
                            <?php if( has_post_thumbnail() ): ?>
                                <?php the_post_thumbnail( 'full' );  ?>
                            <?php endif; ?>
                            <span class="posted-on">
                                <span class="like"><?php rand(1,100) ?></span>
                                <span class="date"><?php get_the_date('d/m/Y'); ?></span>
                            </span>
                            </div>
                            <div class="blog-box-inner">
                                <header class="entry-header">
                                    <h3><?php the_title( ); ?></h3>
                                </header><!-- entry header /- -->
                                <footer class="entry-footer">
                                    <span class="byline">
                                        <span class="screen-reader-text"><?php _e('BY',KC_DOMAIN)  ?> </span>
                                        <?=author_link(); ?>
                                    </span>
                                    <span class="byline">
                                        <span class="screen-reader-text"><?php _e('Like',KC_DOMAIN)  ?></span>
                                        <a href="#"><?= wp_count_comments()->total_comments; ?></a>
                                    </span>
                                    <span class="byline">
                                        <span class="screen-reader-text"><?php
                                        $cats=wp_get_post_categories( get_the_ID() );

                                        $cats=get_the_category($cats );

                                            foreach($cats as $cat):

                                         echo   '<a href="'.get_category_link($cat->term_id).'">'.$cat->name.'</a>,';
                                            endforeach;
                                         ?> </span>
                                    </span>
                                </footer>
                                <div class="entry-content"> <?php the_content( ); ?></div>

                            </div>
                            <div class="col-md-6">
                                <aside class="widget widget_tags row">
                                   <?php echo get_the_tag_list('<h5>Tags: ',', ','</h5>'); ?>
                                </aside>
                            </div>
                            <div class="col-md-6">
                                <aside class="widget widget_social row">
                                    <ul>
                                        <li><a href="http://www.facebook.com/sharer.php?<?=get_bloginfo('url' ) ?>" target="_blank"><i class="fa fa-facebook"> </i> </a></li>
                                        <li><a title="Twitter" href="https://twitter.com/share?url=<?=get_bloginfo('url' ) ?>&amp;text=Simple%20Share%20Buttons&amp;hashtags=simplesharebuttons" target="_blank"><i class="fa fa-twitter"></i></a></li>
                                        <li><a title="Google Plus" href="https://plus.google.com/share?url=<?=get_bloginfo('url' ) ?>"><i class="fa fa-google-plus"></i></a></li>
                                        <li><a title="Linked In" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?=get_bloginfo('url' ) ?>" ><i class="fa fa-linkedin"></i></a></li>
                                    </ul>
                                </aside>
                            </div>
                        </div>

                    </article>