<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

require_once get_stylesheet_directory() . '/inc/scripts-styles.php';
require_once get_stylesheet_directory() . '/inc/helper-functions.php';


require_once get_stylesheet_directory() . '/inc/menus/menus.php';
require_once get_stylesheet_directory() . '/inc/menus/menu-home.php';
require_once get_stylesheet_directory() . '/inc/menus/menu-interno.php';

require_once get_stylesheet_directory() . '/simple-menu-widget.php';

require_once get_stylesheet_directory() . '/inc/customizer/customizer.php';
require_once get_stylesheet_directory() . '/inc/customizer/customizer-css.php';
require_once get_stylesheet_directory() . '/inc/customizer/js-init.php';
require_once get_stylesheet_directory() . '/inc/customizer/shortcodes.php';

require_once get_stylesheet_directory() . '/inc/widget/menu-widget.php';


// Remove all existing style actions
remove_filter('locale_stylesheet_uri', 'chld_thm_cfg_locale_css');
remove_action('wp_enqueue_scripts', 'enqueue_bootstrap', 30);
remove_action('wp_enqueue_scripts', 'enqueue_custom_js', 40);



// Função para obter as categorias de menu com seus títulos
function mi_get_menu_categories() {
    return array(
        'menu-o-museu' => 'O Museu',
        'menu-divisao-tecnica' => 'Divisão Técnica',
        'menu-complexo-palacio' => 'Complexo Palácio Imperial',
        'menu-atracoes' => 'Atrações',
        'menu-servicos' => 'Serviços Online',
        'menu-comunicacao' => 'Comunicação'
    );
}

// Função para renderizar um menu de categoria
function mi_render_category_menu($location, $title, $item_class = 'item__menu') {
    if (!has_nav_menu($location)) {
        return '';
    }

    ob_start();
    ?>
    <li class="<?php echo esc_attr($item_class); ?>">
        <h5><?php echo esc_html($title); ?></h5>
        <?php wp_nav_menu(array(
            'theme_location' => $location,
            'container' => false,
            'items_wrap' => '%3$s',
            'fallback_cb' => false,
            'walker' => new MI_Submenu_Walker()
        )); ?>
    </li>
    <?php
    return ob_get_clean();
}

// Função para obter a URL da home
function mi_get_home_url() {
    return esc_url(home_url('/'));
}

// Adicionar script inline para garantir que as funções JavaScript existam
function mi_add_inline_scripts() {
    ?>
    <script>
    function toggleMenu() {
        const lista = document.querySelector('.container__lista');
        if (lista) {
            lista.classList.toggle('active');
        }
    }
    
    // Adicionar para debugging no Customizer
    if (window.wp && window.wp.customize) {
        console.log('WordPress Customizer detected');
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Menu elements:');
            console.log('Menu personalizado:', document.querySelectorAll('.menu-personalizado').length);
            console.log('Menu 2:', document.querySelectorAll('.menu-2').length);
            console.log('Menu mobile:', document.querySelectorAll('.menu-mobile').length);
        });
    }
    </script>
    <?php
}


function meu_script_overlay_postx() {
  ?>
<script>
    jQuery(document).ready(function($) {
      $('.ultp-block-item').each(function() {
        var $item = $(this);
        var $imageContainer = $item.find('.ultp-block-image');
        var $image = $imageContainer.find('img');
        var $title = $item.find('.ultp-block-title');
		var $link = $title.find('.ultp-component-simple'); 
 
		  
        if ($imageContainer.length && $title.length) {
          $image.css({
            'opacity': 'o.4', 
            'transition': 'opacity 0.3s ease'
          });
          $imageContainer.css('position', 'relative');
          $title.appendTo($imageContainer);
          $title.css({
            'position': 'absolute',
            'bottom': '10px',
            'left': '10px',
            'padding': '0.5rem',
            'z-index': '10',
            'max-width': '90%',
            'background': 'transparent',
            'text-decoration': 'none',
            'transition': 'all 0.3s ease',
          });
          $title.hover(
       function () {
              $(this).css('border-bottom', '1px solid white');
            },
            function () {
              $(this).css('border-bottom', '1px solid transparent');
            }
          );
        }
      });
    });
</script>
<?php
}
add_action('wp_footer', 'meu_script_overlay_postx');
