<?php get_header( ); ?>

<?php  if( is_single( )):?>
    <?php get_sidebar('shop' ); ?>
    <div class="col-md-9 col-sm-8">
<?php else: ?>
<div id="slider-section">
<?php endif; ?>


 <?php if(have_posts()):?>
            <?php while(have_posts()):?>
                <?php the_post(); ?>
                    <?php  the_content( ); ?>
            <?php endwhile; ?>
        <?php endif;?>
        </div>
<?php  get_footer( ); ?>