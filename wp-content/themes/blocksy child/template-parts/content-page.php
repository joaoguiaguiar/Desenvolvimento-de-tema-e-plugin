<?php
/**
 * The template part for displaying page content
 *
 * @package Blocksy
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php
        // Exibe o título da página

        // Exibe a imagem destacada (thumbnail) da página
        if (has_post_thumbnail()) {
            echo '<div class="post-thumbnail">';
            the_post_thumbnail('large');
            echo '</div>';
        }
        ?>
    </header><!-- .entry-header -->

    <div class="entry-content">
        <?php
        // Exibe o conteúdo da página
        the_content();

        wp_link_pages(array(
            'before' => '<div class="page-links">' . esc_html__('Pages:', 'blocksy'),
            'after'  => '</div>',
        ));
        ?>
    </div><!-- .entry-content -->

    <footer class="entry-footer">
        <?php
        if (function_exists('blocksy_entry_footer')) {
            blocksy_entry_footer();
        }
        ?>
    </footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->

