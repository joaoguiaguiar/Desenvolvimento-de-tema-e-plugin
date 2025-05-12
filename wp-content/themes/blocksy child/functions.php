<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:
require_once get_stylesheet_directory() . '/simple-menu-widget.php';
// Remove all existing style actions
remove_filter('locale_stylesheet_uri', 'chld_thm_cfg_locale_css');
remove_action('wp_enqueue_scripts', 'child_theme_configurator_css', 10);
remove_action('wp_enqueue_scripts', 'blocksy_child_theme_css', 20);
remove_action('wp_enqueue_scripts', 'enqueue_bootstrap', 30);
remove_action('wp_enqueue_scripts', 'enqueue_custom_js', 40);

// Função para carregar estilos principais e Bootstrap
function mi_load_all_styles() {
    // Parent theme style
    wp_enqueue_style('blocksy-parent-style', get_template_directory_uri() . '/style.css');
    
    // Child theme style - main CSS file (agora com estilos gerais apenas)
    wp_enqueue_style('blocksy-child-style', get_stylesheet_directory_uri() . '/style.css', array('blocksy-parent-style'), filemtime(get_stylesheet_directory() . '/style.css'));
    
    // Carregar arquivos CSS específicos para menus
    wp_enqueue_style('menu-style', get_stylesheet_directory_uri() . '/css/menu.css', array('blocksy-child-style'), filemtime(get_stylesheet_directory() . '/css/menu.css'));
    wp_enqueue_style('menu-2-style', get_stylesheet_directory_uri() . '/css/menu-2.css', array('blocksy-child-style'), filemtime(get_stylesheet_directory() . '/css/menu-2.css'));
    
    // Bootstrap
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css', array(), '5.3.0');
    wp_enqueue_style('bootstrap-icons', 'https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css', array(), '1.11.1');
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js', array('jquery'), '5.3.0', true);
    
    // Material Symbols Outlined
    wp_enqueue_style('material-symbols', 'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200', array(), null);
    
    // Custom script
    wp_enqueue_script('meu-tema-script', get_stylesheet_directory_uri() . '/js/script.js', array('jquery'), '1.0', true);
}
// Add our function with high priority
add_action('wp_enqueue_scripts', 'mi_load_all_styles', 100);

// Debug function for troubleshooting - only shows for admins
function debug_styles_loaded() {
    if (current_user_can('administrator')) {
        global $wp_styles;
        echo "<!-- ESTILOS CARREGADOS: \n";
        foreach($wp_styles->queue as $handle) {
            echo "$handle\n";
        }
        echo "-->\n";
    }
}
add_action('wp_head', 'debug_styles_loaded', 999);

// Registrar áreas de menu para o Museu Imperial
function mi_register_menus() {
    register_nav_menus(array(
        'menu-principal' => __('Menu Principal', 'blocksy-child'),
    
    ));
}
add_action('init', 'mi_register_menus');

// Walkers personalizados para os menus
class MI_Main_Menu_Walker extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $output .= '<a href="' . esc_url($item->url) . '">' . esc_html($item->title) . '</a>';
    }

    function start_lvl(&$output, $depth = 0, $args = null) {
        // Vazio para não criar sub-listas
    }

    function end_lvl(&$output, $depth = 0, $args = null) {
        // Vazio para não criar sub-listas
    }
}

class MI_Menu_Lista_Walker extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = null) {
        // Não faz nada para evitar a criação de sub-listas
    }
    
    function end_lvl(&$output, $depth = 0, $args = null) {
        // Não faz nada
    }
    
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        if ($depth === 0) {
            // Item de topo (categoria)
            $output .= '<li class="item__menu">';
            $output .= '<h5>' . esc_html($item->title) . '</h5>';
        } else {
            // Subitem
            $output .= '<p><a href="' . esc_url($item->url) . '" class="link__menu">' . 
                esc_html($item->title) . '</a></p>';
        }
    }
    
    function end_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        if ($depth === 0) {
            $output .= '</li>';
        }
    }
}

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
// Adicionar à função mi_add_inline_scripts no arquivo functions.php
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

// Função para verificar se os arquivos CSS existem e criá-los se não existirem
function mi_check_css_files() {
    // Diretório dos arquivos CSS
    $css_dir = get_stylesheet_directory() . '/css';
    
    // Criar diretório CSS se não existir
    if (!file_exists($css_dir)) {
        wp_mkdir_p($css_dir);
    }
    
    // Arquivos CSS a serem verificados
    $css_files = array(
        'menu.css' => '/* Estilos para o menu principal */',
        'menu-2.css' => '/* Estilos para menus secundários */',
        'menu-mobile.css' => '/* Estilos para o menu em dispositivos móveis */'
    );
    
    // Verificar e criar cada arquivo
    foreach ($css_files as $file => $default_content) {
        $file_path = $css_dir . '/' . $file;
        if (!file_exists($file_path)) {
            file_put_contents($file_path, $default_content);
        }
    }
}
// Executar verificação de arquivos durante a ativação do tema
add_action('after_switch_theme', 'mi_check_css_files');
// Executar uma vez para garantir que os arquivos existam
add_action('init', 'mi_check_css_files');

// END ENQUEUE PARENT ACTION

// Registrar as opções do Customizador
function mi_customize_register($wp_customize) {
    $wp_customize->add_section('mi_menu_options', array(
        'title'    => __('Opções do Menu Personalizado', 'blocksy-child'),
        'priority' => 120,
    ));

    // 1. Cor de fundo do menu
    $wp_customize->add_setting('mi_menu_bg_color', array(
        'default'           => '#121212',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mi_menu_bg_color', array(
        'label'    => __('Cor de Fundo do Menu', 'blocksy-child'),
        'section'  => 'mi_menu_options',
        'settings' => 'mi_menu_bg_color',
    )));

    // 2. Cor do texto geral do menu
    $wp_customize->add_setting('mi_menu_text_color', array(
        'default'           => '#FFFFFF',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mi_menu_text_color', array(
        'label'    => __('Cor do Texto do Menu (Geral)', 'blocksy-child'),
        'section'  => 'mi_menu_options',
        'settings' => 'mi_menu_text_color',
    )));

    // 3. Cor do texto dos links de navegação
    $wp_customize->add_setting('mi_nav_text_color', array(
        'default'           => '#FFFFFF',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mi_nav_text_color', array(
        'label'    => __('Cor do Texto do Menu de Navegação', 'blocksy-child'),
        'section'  => 'mi_menu_options',
        'settings' => 'mi_nav_text_color',
    )));


  
}
add_action('customize_register', 'mi_customize_register');

// Função para gerar o CSS personalizado
function mi_customizer_css() {
    if (is_admin() && !is_customize_preview()) {
        return;
    }

    $menu_bg_color = get_theme_mod('mi_menu_bg_color', '#121212');
    $menu_text_color = get_theme_mod('mi_menu_text_color', '#FFFFFF');
    $nav_text_color = get_theme_mod('mi_nav_text_color', '#FFFFFF');
    $submenu_title_color = get_theme_mod('mi_submenu_title_color', '#FFFFFF');
    $submenu_text_color = get_theme_mod('mi_submenu_text_color', '#FFFFFF');
    ?>
    <style type="text/css">
        /* 1. Fundo */
        .menu-personalizado,
        .menu-2,
        .menu-mobile {
            background-color: <?php echo esc_attr($menu_bg_color); ?> !important;
        }

        /* 2. Texto geral */
        .p__menu, 
        .titulo__menu, 
        .p__menuMobile,
        .material-symbols-outlined,
        .menu-hamburguer {
            color: <?php echo esc_attr($menu_text_color); ?> !important;
        }

        /* 3. Links navegação */
        .menu__items a {
            color: <?php echo esc_attr($nav_text_color); ?> !important;
        }

    

    </style>
    <?php
}
add_action('wp_head', 'mi_customizer_css', 999);


function mi_customizer_save_after($wp_customize) {
    // Forçar atualização ao salvar configurações
    set_transient('mi_customizer_updated', time(), DAY_IN_SECONDS);
}
add_action('customize_save_after', 'mi_customizer_save_after');


function mi_debug_enqueued_scripts() {
    if (is_customize_preview()) {
        echo '<script>console.log("Customizer preview está ativo");</script>';
    }
}
add_action('wp_head', 'mi_debug_enqueued_scripts');

// Adicione isso no seu tema
function mi_clear_theme_cache() {
    // Limpar qualquer cache que possa estar afetando
    delete_transient('mi_customizer_updated');
    // Forçar um novo timestamp
    set_transient('mi_customizer_updated', time(), HOUR_IN_SECONDS);
}
add_action('after_switch_theme', 'mi_clear_theme_cache');
add_action('customize_save_after', 'mi_clear_theme_cache');

// Adicionar versão ao CSS principal do tema
function mi_add_version_to_stylesheet() {
    $version = get_transient('mi_customizer_updated') ? get_transient('mi_customizer_updated') : wp_get_theme()->get('Version');
    return $version;
}
add_filter('stylesheet_version', 'mi_add_version_to_stylesheet');

// Adicionar suporte para atualização ao vivo no customizador
function mi_customizer_live_preview() {
    wp_enqueue_script(
        'mi-customizer-preview',
        get_stylesheet_directory_uri() . '/js/customizer.js',
        array('jquery', 'customize-preview'),
        time(), // Use time() para evitar cache durante o desenvolvimento
        true
    );
}
add_action('customize_preview_init', 'mi_customizer_live_preview');

// Função para verificar se os arquivos JavaScript existem e criá-los se não existirem
function mi_check_js_files() {
    // Diretório dos arquivos JS
    $js_dir = get_stylesheet_directory() . '/js';
    
    // Criar diretório JS se não existir
    if (!file_exists($js_dir)) {
        wp_mkdir_p($js_dir);
    }
    
    // Arquivo customizer.js
    $customizer_js_path = $js_dir . '/customizer.js';
    if (!file_exists($customizer_js_path)) {
        $customizer_js_content = <<<'EOD'
/**
 * Customizador com atualização ao vivo
 */
(function($) {
    // Atualiza a cor de fundo do menu
    wp.customize('mi_menu_bg_color', function(value) {
        value.bind(function(newVal) {
            $('.menu-personalizado, .menu-2, .menu-mobile').css('background-color', newVal);
        });
    });

    // Atualiza a cor do texto do menu de navegação
    wp.customize('mi_nav_text_color', function(value) {
        value.bind(function(newVal) {
            $('.menu__items a').css('color', newVal);
        });
    });

    // Atualiza a cor do hover do menu de navegação
    wp.customize('mi_nav_hover_color', function(value) {
        value.bind(function(newVal) {
            var styleId = 'mi-nav-hover-style';
            var styleTag = $('#' + styleId);
            
            if (styleTag.length === 0) {
                styleTag = $('<style id="' + styleId + '"></style>').appendTo('head');
            }
            
            styleTag.text(
                '.menu__items a:hover {' +
                '    color: ' + newVal + ' !important;' +
                '}'
            );
        });
    });

    // Atualiza a cor dos títulos do submenu
    wp.customize('mi_submenu_title_color', function(value) {
        value.bind(function(newVal) {
            $('.item__menu h5, .item__menuMobile h5').css('color', newVal);
        });
    });

    // Atualiza a cor do texto dos links do submenu
    wp.customize('mi_submenu_text_color', function(value) {
        value.bind(function(newVal) {
            $('.link__menu').css('color', newVal);
        });
    });

    // Atualiza a cor do hover dos links do submenu
    wp.customize('mi_submenu_hover_color', function(value) {
        value.bind(function(newVal) {
            var styleId = 'mi-submenu-hover-style';
            var styleTag = $('#' + styleId);
            
            if (styleTag.length === 0) {
                styleTag = $('<style id="' + styleId + '"></style>').appendTo('head');
            }
            
            styleTag.text(
                '.link__menu:hover {' +
                '    color: ' + newVal + ' !important;' +
                '}'
            );
        });
    });

    // Configurações legadas para compatibilidade
    wp.customize('mi_menu_text_color', function(value) {
        value.bind(function(newVal) {
            $('.p__menu, .titulo__menu, .p__menuMobile, .material-symbols-outlined, .menu-hamburguer')
                .css('color', newVal);
        });
    });

    wp.customize('mi_menu_hover_color', function(value) {
        value.bind(function(newVal) {
            // Mantido para compatibilidade
            var styleId = 'mi-hover-style';
            var styleTag = $('#' + styleId);
            
            if (styleTag.length === 0) {
                styleTag = $('<style id="' + styleId + '"></style>').appendTo('head');
            }
            
            styleTag.text(
                '.menu__items a:hover, .link__menu:hover {' +
                '    color: ' + newVal + ' !important;' +
                '}'
            );
        });
    });
})(jQuery);
EOD;
        file_put_contents($customizer_js_path, $customizer_js_content);
    } else {
        // Se o arquivo já existe, atualize-o para incluir os novos elementos
        $customizer_js_content = <<<'EOD'
/**
 * Customizador com atualização ao vivo
 */
(function($) {
    // Atualiza a cor de fundo do menu
    wp.customize('mi_menu_bg_color', function(value) {
        value.bind(function(newVal) {
            $('.menu-personalizado, .menu-2, .menu-mobile').css('background-color', newVal);
        });
    });

    // Atualiza a cor do texto do menu de navegação
    wp.customize('mi_nav_text_color', function(value) {
        value.bind(function(newVal) {
            $('.menu__items a').css('color', newVal);
        });
    });

    // Atualiza a cor do hover do menu de navegação
    wp.customize('mi_nav_hover_color', function(value) {
        value.bind(function(newVal) {
            var styleId = 'mi-nav-hover-style';
            var styleTag = $('#' + styleId);
            
            if (styleTag.length === 0) {
                styleTag = $('<style id="' + styleId + '"></style>').appendTo('head');
            }
            
            styleTag.text(
                '.menu__items a:hover {' +
                '    color: ' + newVal + ' !important;' +
                '}'
            );
        });
    });

    // Atualiza a cor dos títulos do submenu
    wp.customize('mi_submenu_title_color', function(value) {
        value.bind(function(newVal) {
            $('.item__menu h5, .item__menuMobile h5').css('color', newVal);
        });
    });

    // Atualiza a cor do texto dos links do submenu
    wp.customize('mi_submenu_text_color', function(value) {
        value.bind(function(newVal) {
            $('.link__menu').css('color', newVal);
        });
    });

    // Atualiza a cor do hover dos links do submenu
    wp.customize('mi_submenu_hover_color', function(value) {
        value.bind(function(newVal) {
            var styleId = 'mi-submenu-hover-style';
            var styleTag = $('#' + styleId);
            
            if (styleTag.length === 0) {
                styleTag = $('<style id="' + styleId + '"></style>').appendTo('head');
            }
            
            styleTag.text(
                '.link__menu:hover {' +
                '    color: ' + newVal + ' !important;' +
                '}'
            );
        });
    });

    // Configurações legadas para compatibilidade
    wp.customize('mi_menu_text_color', function(value) {
        value.bind(function(newVal) {
            $('.p__menu, .titulo__menu, .p__menuMobile, .material-symbols-outlined, .menu-hamburguer')
                .css('color', newVal);
        });
    });

    wp.customize('mi_menu_hover_color', function(value) {
        value.bind(function(newVal) {
            // Mantido para compatibilidade
            var styleId = 'mi-hover-style';
            var styleTag = $('#' + styleId);
            
            if (styleTag.length === 0) {
                styleTag = $('<style id="' + styleId + '"></style>').appendTo('head');
            }
            
            styleTag.text(
                '.menu__items a:hover, .link__menu:hover {' +
                '    color: ' + newVal + ' !important;' +
                '}'
            );
        });
    });
})(jQuery);
EOD;
        file_put_contents($customizer_js_path, $customizer_js_content);
    }
}
add_action('after_switch_theme', 'mi_check_js_files');
add_action('init', 'mi_check_js_files');







// Shortcode para usar o carrossel em qualquer lugar
function menu_categories_carousel_shortcode() {
    return get_menu_categories_carousel();
}
add_shortcode('menu_categories_carousel', 'menu_categories_carousel_shortcode');


function mi_customizer_dynamic_css() {
    if (!is_customize_preview()) {
        return;
    }
    ?>
    <style id="mi-dynamic-customizer-css"></style>
    <script>
    (function($) {
        $(function() {
            var $style = $('#mi-dynamic-customizer-css');

            function updateCSS() {
                var css = '';

                var menuBgColor = wp.customize('mi_menu_bg_color')();
                if (menuBgColor) {
                    css += '.menu-personalizado, .menu-2, .menu-mobile { background-color: ' + menuBgColor + ' !important; }';
                }

                var menuTextColor = wp.customize('mi_menu_text_color')();
                if (menuTextColor) {
                    css += '.p__menu, .titulo__menu, .p__menuMobile, .material-symbols-outlined, .menu-hamburguer { color: ' + menuTextColor + ' !important; }';
                }

                var navTextColor = wp.customize('mi_nav_text_color')();
                if (navTextColor) {
                    css += '.menu__items a { color: ' + navTextColor + ' !important; }';
                }

               
               

                $style.text(css);
            }

            updateCSS();

            wp.customize('mi_menu_bg_color', function(value) { value.bind(updateCSS); });
            wp.customize('mi_menu_text_color', function(value) { value.bind(updateCSS); });
            wp.customize('mi_nav_text_color', function(value) { value.bind(updateCSS); });

        });
    })(jQuery);
    </script>
    <?php
}
add_action('wp_footer', 'mi_customizer_dynamic_css', 999);


// Remover o widget Menu Lista personalizado
function remove_menu_lista_widget_completely() {
    unregister_widget('Menu_Lista_Widget');
}
add_action('widgets_init', 'remove_menu_lista_widget_completely', 99);

// Registrar a sidebar de Menu Principal
function register_main_menu_sidebar() {
    register_sidebar(array(
        'name'          => 'Menu Lista Categorias',
        'id'            => 'main-menu-sidebar',
        'description'   => 'Adicione o widget de Navegação aqui para exibir o menu principal',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'register_main_menu_sidebar');

// Registrar a sidebar de Menu Principal


// Customização do menu
function custom_menu_widget_style($items, $args) {
    // Checa se o menu é o Menu Principal
    if (isset($args->theme_location) && $args->theme_location == 'main-menu') {
        // Exibe os itens do menu dentro de uma lista flexível
        $items = '<ul class="lista_item_menu" style="display: flex; justify-content: space-evenly; list-style: none; padding: 0;">';
        
        // Percorre os itens do menu
        foreach ($items as $item) {
            $items .= '<li>' . $item . '</li>';
        }

        $items .= '</ul>';
    }

    return $items;
}
add_filter('wp_nav_menu_items', 'custom_menu_widget_style', 10, 2);


// --------------------------------

// Função helper para renderizar o conteúdo do widget de menu
function mi_get_menu_widget_content() {
    ob_start();
    if (is_active_sidebar('main-menu-sidebar')) {
        dynamic_sidebar('main-menu-sidebar'); 
    } else {
        echo '<ul class="lista_item_menu" style="display:flex; justify-content: space-evenly">';
        echo '<li class="item__menu"><h5>Menu</h5>';
        echo '<p>Adicione o widget "Menu Lista" na área de widgets do menu principal.</p>';
        echo '</li></ul>';
    }
    return ob_get_clean();
}