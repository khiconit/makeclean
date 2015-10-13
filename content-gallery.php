                <article>
                        <div class="blog-box">

                            <?php if ( $gallery = get_post_gallery( get_the_ID(), false ) ) : ?>
                            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                              <!-- Indicators -->
                              <ol class="carousel-indicators">
                              <?php for($i=0;$i<=count($gallery['src']);$i++): ?>
                                <li data-target="#carousel-example-generic" data-slide-to="<?=$i?>" class="<?php echo ($i==0) ?'active' :''; ?>"></li>

                            <?php endfor; ?>
                              </ol>

                              <!-- Wrapper for slides -->
                              <div class="carousel-inner" role="listbox">

                              <?php foreach ( $gallery['src'] AS $k=> $src ) : ?>

                                <div class="item <?php echo  ($k==0) ? 'active':'';  ?>">
                                  <img src="<?=$src?>" alt="gallery">
                                  <div class="carousel-caption">
                                    <?php the_title( ); ?>
                                  </div>
                                </div>

                                 <?php endforeach; ?>

                              </div>

                              <!-- Controls -->
                              <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                              </a>
                              <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                              </a>
                            </div>
                            <?php endif; ?>


                            <div class="entry-cover">
                            <?php if( has_post_thumbnail() ): ?>
                                <?php the_post_thumbnail( 'large' );  ?>
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