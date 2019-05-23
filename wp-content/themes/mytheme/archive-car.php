<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package mytheme
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

            <?php
            $args = array(
                'post_type'   => 'car',
                'post_status' => 'publish',
                'tax_query'   => array(
                    array(


                    )
                )
            );

            $cars = new WP_Query( $args );
            if( $cars->have_posts() ) :
                ?>
                <ul>
                    <?php
                    while( $cars->have_posts() ) :
                        $cars->the_post();
                        ?>
                        <li><?php printf( '%1$s - %2$s', get_the_title(), get_the_content() );  ?></li>
                    <?php
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </ul>
            <?php
            else :
                esc_html_e( 'No testimonials in the diving taxonomy!', 'text-domain' );
            endif;
            ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
