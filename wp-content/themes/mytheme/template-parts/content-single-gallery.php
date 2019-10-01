<h1><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h1>
<div><?php the_post_thumbnail('blog-thumbnail') ?></div>
<em><?php echo get_the_date() ?></em>
<em><?php the_author() ?></em>
<div>Categories: <?php the_category() ?></div>
<div>Tags: <?php the_tags() ?></div>
<div><?php the_content() ?></div>

<?php
echo  get_post_galleries_images( $ID );
