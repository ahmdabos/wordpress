<?php
$args = array(
    'post_type' => 'car'
);
$wp_query = new WP_Query($args);
if ($wp_query->have_posts()) :
    while ($wp_query->have_posts()) :
        $wp_query->the_post();
        ?>
        <h1><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h1>
        <div><?php the_post_thumbnail('blog-thumbnail') ?></div>
        <em><?php echo get_the_date() ?></em>
        <em><?php the_author() ?></em>
        <div><?php the_category() ?></div>
        <div><?php the_excerpt() ?></div>
    <?php endwhile; ?>
<?php endif; ?>

