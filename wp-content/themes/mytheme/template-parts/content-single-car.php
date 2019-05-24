<h1><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h1>
<div><?php the_post_thumbnail('blog-thumbnail') ?></div>
<em><?php echo get_the_date() ?></em>
<em><?php the_author() ?></em>
<div>Categories: <?php the_category() ?></div>
<div>Tags: <?php the_tags() ?></div>
<div><?php the_content() ?></div>

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
?>