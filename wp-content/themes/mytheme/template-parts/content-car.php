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


        <?php

        $year = get_post_meta(get_the_ID(), 'car_year', true);

        if (!empty($year)) {
            echo '<h3>Year: ' . $year . '<h3>';
        }
        $car_sunroof = get_post_meta(get_the_ID(), 'car_sunroof', true);
        if (!empty($car_sunroof)) {
            echo '<h3> Car Sunroof: ' . $car_sunroof . '<h3>';
        }
        $car_price = get_post_meta(get_the_ID(), 'car_price', true);
        if (!empty($car_price)) {
            echo '<h3> Car Price: ' . $car_price . '<h3>';
        }
        $car_currency = get_post_meta(get_the_ID(), 'car_currency', true);
        if (!empty($car_currency)) {
            echo '<h3> Car Currency: ' . $car_currency . '<h3>';
        }
        $car_intro = get_post_meta(get_the_ID(), 'car_intro', true);
        if (!empty($car_currency)) {
            echo '<h3> Car Intro: ' . $car_intro . '<h3>';
        }
        ?>


    <?php endwhile; ?>
<?php endif; ?>

