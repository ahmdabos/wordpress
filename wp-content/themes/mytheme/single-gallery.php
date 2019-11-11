<?php
get_header();
?>
    <main>
        <?php
        while (have_posts()) :
            the_post();
            get_template_part('template-parts/content', 'single-gallery');
        endwhile;
        ?>
    </main>
<?php
get_sidebar();
get_footer();
