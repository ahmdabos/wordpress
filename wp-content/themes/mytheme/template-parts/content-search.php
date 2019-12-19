<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package mytheme
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
</article><!-- #post-<?php the_ID(); ?> -->
<h1><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h1>
<div><?php the_post_thumbnail('blog-thumbnail') ?></div>
<em><?php echo get_the_date() ?></em>
<em><?php the_author() ?></em>
<div><?php the_category() ?></div>
<div><?php the_excerpt() ?></div>
