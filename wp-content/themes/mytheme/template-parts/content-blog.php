
<?php
global $wp_query;
$cats = get_categories(array('post_type' => 'post'));
?>
<form class='post-filters'>
    <input type="text" name="search" value="" placeholder="Search"/>
    <input type="text" name="from_date" value="" id="date_from"/>
    <input type="text" name="to_date" value="" id="date_to"/>
    <select name="category">
        <?php
        foreach ($cats as $category) {
            echo "<option " . selected($_GET['category'], $category->cat_ID) . " value='$category->cat_ID'>$category->cat_name</option>";
        } ?>

    </select>
    <input type='submit' value='Filter!'>
</form>
<?php
$date_from = date($_GET['date_from']);
$args = array(
    'post_type' => 'post',
    'posts_per_page' => 10,
    'orderby' => 'title',
    'order' => 'ASC',
    's' => $_GET['search'],
    'cat' => $_GET['category'],
    'date_query' => array(
        'relation' => 'AND',
        array(
            'compare' => '<=',
            array(
                'year' => 2019, 'month' => 06, 'day' => 21,
            ),
        ),
        array(
            'compare' => '>=',
            array(
                'year' => 2019, 'month' => 05, 'day' => 21,
            ),
        ),
    ),
    'meta_query' => array()
);

$wp_query = new WP_Query($args);
if ($wp_query->have_posts()) :
    while ($wp_query->have_posts()) :
        $wp_query->the_post();
        ?>
        <div><?php the_post_thumbnail('blog-thumbnail') ?></div>
        <h1><?php the_title() ?></h1>
        <a href="<?php the_permalink() ?>">Read more</a>
        <em><?php echo get_the_date() ?></em>
        <em><?php the_author() ?></em>
        <div><?php the_category() ?></div>
        <div><?php the_excerpt() ?></div>

    <?php endwhile; ?>
<?php endif; ?>




