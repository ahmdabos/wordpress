<script>
    jQuery(document).ready(function () {
        jQuery('.owl-carousel').owlCarousel({
            loop:true,
            margin:10,
            nav:true,
            items:1,

        })
    });
</script>
<div class="owl-carousel">
    <?php
    $args = array(
        'post_type' => 'slider'
    );
    $wp_query = new WP_Query($args);
    if ($wp_query->have_posts()) :
        while ($wp_query->have_posts()) :
            $wp_query->the_post();
            ?>
            <div class="item">
                <div><?php the_post_thumbnail('blog-thumbnail') ?></div>
                <h1><?php the_title() ?></h1>
                <a href="<?php the_permalink() ?>">Read more</a>
                <em><?php echo get_the_date() ?></em>
                <em><?php the_author() ?></em>
                <div><?php the_category() ?></div>
                <div><?php the_excerpt() ?></div>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>

</div>




