<?php
$args = array(
    'post_type' => 'gallery'
);
$wp_query = new WP_Query($args);
if ($wp_query->have_posts()) :
    while ($wp_query->have_posts()) :
        $wp_query->the_post();
        ?>

        <!-- click to show the post in different page template -->
        <h1><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h1>
        <!-- click to show the post in ajax request page template -->
        <button id="get_post" data-id="<?php the_ID(); ?>">View Gallery</button>
        <div><?php the_post_thumbnail('blog-thumbnail') ?></div>
        <em><?php echo get_the_date() ?></em>
        <em><?php the_author() ?></em>
        <div><?php the_excerpt() ?></div>
    <?php endwhile; ?>
<?php endif; ?>

<div id="results"></div>
<script>
    jQuery(document).on('click', '#get_post', function () {
        var post_id = jQuery(this).data('id');
        var request = jQuery.ajax({
            url: 'http://localhost/wordpress/wp-json/wp/v2/gallery/' + post_id,
            method: "GET",
            dataType: "json"
        });
        request.done(function (data) {
            console.log(data);
            jQuery('#results').html(data.content.rendered);
        });
        request.fail(function (jqXHR, textStatus) {
            console.log('fail')
        });
        return false;
    });
</script>

