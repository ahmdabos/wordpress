<h1><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h1>
<div><?php the_post_thumbnail('blog-thumbnail') ?></div>
<em><?php echo get_the_date() ?></em>
<em><?php the_author() ?></em>
<div><?php the_excerpt() ?></div>
<div><?php the_category() ?></div>