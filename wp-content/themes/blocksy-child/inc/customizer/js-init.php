<?php
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