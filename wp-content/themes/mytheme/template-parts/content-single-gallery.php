<script>

    jQuery(document).ready(function () {
        jQuery('.wp-block-gallery').addClass('owl-carousel');
        jQuery('.owl-carousel').owlCarousel({
            loop:true,
            margin:10,
            nav:true,
            items:1,

        })
    });
</script>
<h1><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h1>
<em><?php echo get_the_date() ?></em>
<div><?php the_content() ?></div>
