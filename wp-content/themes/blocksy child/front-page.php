<?php
/**
 * Front Page Template
 *
 * @package Blocksy
 */
get_header();
?>

<!-- Menu Principal -->
<main id="main-content">
    <section class="hero-carousel">
        <div class="carousel-container">
            <?php echo do_shortcode('[smartslider3 slider="2"]'); ?>
        </div>
    </section>

    <section class="hero-menu menu-1" id="menu-1">
        <div class="containner__p">
            <p class="p__menu" style="font-size: 1rem;color: #F5F5F5;">Instituto Brasileiro de Museus</p>
            <h3>
                <a style="text-decoration: none; color: white;" href="<?php echo mi_get_home_url(); ?>" class="titulo__menu">
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
    </section>
</main>

<?php
if (
    ! function_exists('elementor_theme_do_location')
    ||
    ! elementor_theme_do_location('front-page')
) {
    if (have_posts()) :
        while (have_posts()) : the_post();
            ?>
            <div class="mi-content-container">
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </div>
            <?php
        endwhile;
    endif;
}

get_footer();
