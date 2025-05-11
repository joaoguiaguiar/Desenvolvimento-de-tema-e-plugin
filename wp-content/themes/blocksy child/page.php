<?php
/**
 * Template para exibir páginas
 *
 * @package Blocksy
 */

get_header(); // Cabeçalho padrão
?>

<!-- Segundo Menu Incorporado -->
<section class="menu-personalizado menu-2" id="menu-2">
    <div class="GRID">
        <div class="containner__p">
            <p class="p__menu" style="font-size: 1rem; color: #F5F5F5;">Instituto Brasileiro de Museus</p>
            <h3>
                <a href="<?php echo home_url('/'); ?>" class="titulo__menu" style="text-decoration: none; color: white;">
                    Museus Castro Maya
                </a>
            </h3>
        </div>

        <div class="menu-and-search">
            <span class="material-symbols-outlined" onclick="toggleMenu()">menu</span>
            
            <nav class="menu__items">
                <?php
                $menu_items = wp_get_nav_menu_items('menu-principal');
                if ($menu_items) {
                    $menu_nav = array_slice($menu_items, 0, 8);
                    foreach ($menu_nav as $item) {
                        echo '<a href="' . esc_url($item->url) . '">' . esc_html($item->title) . '</a>';
                    }
                }
                ?>
            </nav>

            <div class="container__lista">
                <div class="containerflex">
                    <?php 
                        if (is_active_sidebar('main-menu-sidebar')) {
                            dynamic_sidebar('main-menu-sidebar'); 
                        } else {
                            echo '<ul class="lista_item_menu" style="display:flex; justify-content: space-evenly">';
                            echo '<li class="item__menu"><h5>Menu</h5>';
                            echo '<p>Adicione o widget "Menu Lista" na área de widgets do menu principal.</p>';
                            echo '</li></ul>';
                        }
                    ?>    
                </div>
            </div>

            <div class="container__input">
                <?php echo do_shortcode('[wpdreams_ajaxsearchlite]'); ?>
            </div>
        </div>
    </div>
</section>

<!-- Conteúdo Principal da Página -->
<main id="mi-conteudo-principal" class="mi-conteudo-principal">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article id="mi-post-<?php the_ID(); ?>" <?php post_class('mi-post'); ?>>
            <header class="mi-cabecalho-post">
                <?php the_title('<h1 class="mi-titulo-post">', '</h1>'); ?>
            </header>
            <div class="mi-conteudo-post">
                <?php the_content(); ?>
            </div>
        </article>
    <?php endwhile; else : ?>
        <p>Nenhum conteúdo encontrado.</p>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
