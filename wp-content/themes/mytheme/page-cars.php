<?php
get_header();
?>


    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <?php
            get_template_part('template-parts/content', 'car');
            ?>
        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_sidebar();
get_footer();
