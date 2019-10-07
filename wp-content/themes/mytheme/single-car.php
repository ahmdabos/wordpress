<?php
get_header();
?>
    <main>
        <?php
        while (have_posts()) :
            the_post();
            get_template_part('template-parts/content', 'single-car');
        endwhile;
        ?>
    </main>
<?php
get_sidebar();
get_footer();
