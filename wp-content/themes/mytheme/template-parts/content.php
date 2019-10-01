<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package mytheme
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <h1><?php the_title() ?> </h1>
    </header><!-- .entry-header -->
    <?php the_post_thumbnail() ?>
    <div class="entry-content">
        <?php the_content(); ?>
    </div><!-- .entry-content -->
    <footer class="entry-footer">
        <h3> Categories: <?php the_category() ?></h3>
        <h3>Tags: <?php the_tags() ?></h3>
    </footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
