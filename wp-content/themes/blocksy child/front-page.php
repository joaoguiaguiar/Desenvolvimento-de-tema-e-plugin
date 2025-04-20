<?php
/**
 * Front Page Template
 *
 * @package Blocksy
 */

get_header();
?>

<main id="main-content">

    <!-- Carrossel -->
    <section class="hero-carousel">
        <div class="carousel-container">
            <?php echo do_shortcode('[smartslider3 slider="3"]'); ?>
        </div>
    </section>

    <!-- Menu Principal -->
    <section class="hero-menu menu-1" id="menu-1">
        <div class="containner__p">
            <p class="p__menu" style="font-size: 1rem; color: #F5F5F5;">
                Instituto Brasileiro de Museus
            </p>
            <h3>
                <a href="<?php echo mi_get_home_url(); ?>" class="titulo__menu" style="text-decoration: none; color: white;">
                    Museus Castro Maya
                </a>
            </h3>
        </div>

        <div class="menu-and-search">

            <!-- Ícone do menu mobile -->
            <span class="material-symbols-outlined" onclick="toggleMenu()">menu</span>

            <!-- Navegação principal -->
            <nav class="menu__items">
                <?php
                $menu_items = wp_get_nav_menu_items('menu-principal');

                if ($menu_items) {
                    $menu_nav = array_slice($menu_items, 0, 7);

                    foreach ($menu_nav as $item) {
                        echo '<a href="' . esc_url($item->url) . '">' . esc_html($item->title) . '</a>';
                    }
                }
                ?>
            </nav>

            <!-- Lista dinâmica via widget -->
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

            <!-- Campo de busca -->
            <div class="container__input">
                <?php echo do_shortcode('[wpdreams_ajaxsearchlite]'); ?>
            </div>

        </div>
    </section>

    <!-- Conteúdo da página (caso não tenha front-page Elementor) -->
    <?php
    if (
        ! function_exists('elementor_theme_do_location') ||
        ! elementor_theme_do_location('front-page')
    ) {
        if (have_posts()) :
            while (have_posts()) : the_post(); ?>
                <div class="mi-content-container">
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                </div>
            <?php endwhile;
        endif;
    }
    ?>

</main>

<?php get_footer(); ?>
