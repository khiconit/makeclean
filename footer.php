    <!-- Footer Section -->
<?php contact_from_modal(); ?>
    <footer id="footer-section" class="footer-section ow-background">
        <!-- container -->
        <div class="container">
            <div class="footer-heading">
                <?php text_footer(); ?>
            </div>
            <?php if(is_active_sidebar('footer-link-1' )): ?>
                <?php dynamic_sidebar('footer-link-1' ); ?>
            <?php endif; ?>
            <?php if(is_active_sidebar('footer-link-2' )): ?>
                <?php dynamic_sidebar('footer-link-2' ); ?>
            <?php endif; ?>
            <?php if(is_active_sidebar('footer-link-3' )): ?>
                <?php dynamic_sidebar('footer-link-3' ); ?>
            <?php endif; ?>


            <?php if(is_active_sidebar('footer-form' )): ?>
                <?php dynamic_sidebar('footer-form' ); ?>
            <?php endif; ?>

            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <?php makeclean_copyright(); ?>
            </div>
            <!-- Footer Bottom /- -->

        </div>
        <!-- container /- -->
    </footer><!-- Footer Section /- -->

    <a href="#0" class="cd-top">Top</a>

    <?php wp_footer(); ?>

</body>
</html>
