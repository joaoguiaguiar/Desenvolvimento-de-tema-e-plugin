<?php
/**
 * The template part for displaying single posts
 *
 * @package Blocksy
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php
        // if (has_post_thumbnail()) {
        //     echo '<div class="post-thumbnail">';
        //     the_post_thumbnail('large');
        //     echo '</div>';
        // }
        ?>
    </header>

    <div class="entry-content">
        <?php
     
        the_content();

        wp_link_pages(array(
            'before' => '<div class="page-links">' . esc_html__('Pages:', 'blocksy'),
            'after'  => '</div>',
        ));
        ?>
    </div>

    <footer class="entry-footer">
        <?php
        if (function_exists('blocksy_entry_footer')) {
            blocksy_entry_footer();
        }
        ?>
    </footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->