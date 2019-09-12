<?php
get_header();
?>
    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <?php
            if (is_home() && !is_front_page()) :
                ?>
                <header>
                    <h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
                </header>
            <?php
            endif;
            get_template_part('template-parts/content', 'blog');
            the_posts_navigation();
            ?>
        </main><!-- #main -->
    </div><!-- #primary -->
<?php
get_sidebar();
get_footer();
