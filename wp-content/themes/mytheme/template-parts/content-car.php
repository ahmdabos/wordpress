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
            echo '<p>Year: ' . $year . '<p>';
        }
        $car_sunroof = get_post_meta(get_the_ID(), 'car_sunroof', true);
        if (!empty($car_sunroof)) {
            echo '<p> Car Sunroof: ' . $car_sunroof . '<p>';
        }
        $car_price = get_post_meta(get_the_ID(), 'car_price', true);
        if (!empty($car_price)) {
            echo '<p> Car Price: ' . $car_price . '<p>';
        }
        $car_currency = get_post_meta(get_the_ID(), 'car_currency', true);
        if (!empty($car_currency)) {
            echo '<p> Car Currency: ' . $car_currency . '<p>';
        }
        $car_intro = get_post_meta(get_the_ID(), 'car_intro', true);
        if (!empty($car_info)) {
            echo '<p> Car Intro: ' . $car_intro . '<p>';
        }
        $car_condition = get_post_meta(get_the_ID(), 'car_condition', true);
        if (!empty($car_condition)) {
            echo '<p> Car Condition: ' . $car_condition . '<p>';
        }
        $car_details= get_post_meta(get_the_ID(), 'car_details', true);
        if (!empty($car_details)) {
            echo '<p> Car details: ' . $car_details . '<p>';
        }
        $car_email= get_post_meta(get_the_ID(), 'car_email', true);
        if (!empty($car_email)) {
            echo '<p> Car Email: ' . $car_email . '<p>';
        }
        $car_date= get_post_meta(get_the_ID(), 'car_date', true);
        if (!empty($car_date)) {
            echo '<p> Car Date: ' . $car_date . '<p>';
        }
        ?>


    <?php endwhile; ?>
<?php endif; ?>

