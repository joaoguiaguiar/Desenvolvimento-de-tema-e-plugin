<?php
/**
 * Template para exibir posts individuais
 *
 * @package Blocksy
 */

get_header();
?>

<!-- Segundo Menu Incorporado -->
<section class="menu-personalizado menu-2" id="menu-2">
    <div class="containner__p">
        <p class="p__menu" style="font-size: 1rem; color: #F5F5F5;">
            Instituto Brasileiro de Museus
        </p>
        <h3>
            <a href="<?php echo home_url('/'); ?>" class="titulo__menu" style="text-decoration: none; color: white;">
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
                $menu_nav = array_slice($menu_items, 0, 8);

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

<!-- Conteúdo do post -->
<?php
if (
    ! function_exists('elementor_theme_do_location') ||
    ! elementor_theme_do_location('single')
) {
    get_template_part('template-parts/single');
}
?>

<?php get_footer(); ?>
