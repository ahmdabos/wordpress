<?php
global $wp_query;
$cats = get_categories(array('post_type' => 'post'));
?>
<form class='post-filters'>
    <input type="text" name="search" value="<?php echo $_GET['search']?>" placeholder="Search"/>
    <input type="text" name="from_date" value="<?php echo $_GET['from_date']?>" id="from_date"/>
    <input type="text" name="to_date" value="<?php echo $_GET['to_date']?>" id="to_date"/>
    <select name="category">
        <?php
        foreach ($cats as $category) {
            echo "<option " . selected($_GET['category'], $category->cat_ID) . " value='$category->cat_ID'>$category->cat_name</option>";
        } ?>

    </select>
    <input type='submit' value='Filter!'>
</form>
<?php
$from_date = strtotime(date($_GET['from_date']));
$from_year = date("Y", $from_date) ;
$from_month = date("m", $from_date);
$from_day = date("d", $from_date);
$to_date = strtotime(date($_GET['to_date']));
$to_year = date("Y", $to_date) ;
$to_month = date("m", $to_date);
$to_day = date("d", $to_date);


$args = array(
    'post_type' => 'post',
    'posts_per_page' => 10,
    'orderby' => 'date',
    'order' => 'DESC',
    's' => $_GET['search'],
    'cat' => $_GET['category'],
    'date_query' => array(
        'relation' => 'AND',
        array(
            'compare' => '>=',
            array(
                'year' => (int)$from_year, 'month' => (int)$from_month, 'day' => (int)$from_day,
            ),
        ),
        array(
            'compare' => '<=',
            array(
                'year' => (int)$to_year, 'month' => (int)$to_month, 'day' => (int)$to_day,
            ),
        ),
    ),

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




