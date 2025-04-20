<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

// Menu Lista Widget
class Menu_Lista_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'menu_lista_widget',
            'Menu Lista', // Nome do widget
            array('description' => 'Exibe um menu WordPress dentro de uma estrutura personalizada')
        );
    }

    // Exibe o widget no frontend
    // No simple-menu-widget.php, modificar a função widget:

public function widget($args, $instance) {
    $title = !empty($instance['title']) ? apply_filters('widget_title', $instance['title']) : ''; 
    $nav_menu_id = !empty($instance['nav_menu']) ? (int) $instance['nav_menu'] : 0;

    // Exibe o início do widget
    echo $args['before_widget'];

    // Exibe o título do widget, se houver
    if (!empty($title)) {
        echo $args['before_title'] . $title . $args['after_title'];
    }

    // Exibe o menu selecionado
    if ($nav_menu_id > 0) {
        $menu_items = wp_get_nav_menu_items($nav_menu_id);
        
        if ($menu_items) {
            echo '<ul class="lista_item_menu" style="display:flex; justify-content: space-evenly">';
            
            // Organizar itens do menu por hierarquia
            $menu_array = array();
            $menu_children = array();
            
            // Primeiro passamos por todos os itens e identificamos pais e filhos
            foreach ($menu_items as $item) {
                if ($item->menu_item_parent == 0) {
                    // Itens de nível superior (sem pai)
                    $menu_array[$item->ID] = $item;
                } else {
                    // Itens filhos, organizados pelo ID do pai
                    if (!isset($menu_children[$item->menu_item_parent])) {
                        $menu_children[$item->menu_item_parent] = array();
                    }
                    $menu_children[$item->menu_item_parent][] = $item;
                }
            }
            
            // Agora exibimos os itens de nível superior
            foreach ($menu_array as $parent_item) {
                echo '<li class="item__menu">';
                echo '<h5>' . esc_html($parent_item->title) . '</h5>';
                
                // Verificar se este item tem filhos
                if (isset($menu_children[$parent_item->ID])) {
                    foreach ($menu_children[$parent_item->ID] as $child) {
                        echo '<p><a href="' . esc_url($child->url) . '" class="link__menu">' . 
                            esc_html($child->title) . '</a></p>';
                    }
                } else {
                    // Se não tiver filhos, exibir link para o próprio item pai
                    echo '<p><a href="' . esc_url($parent_item->url) . '" class="link__menu">' . 
                        esc_html($parent_item->title) . '</a></p>';
                }
                
                echo '</li>';
            }
            
            echo '</ul>';
        } else {
            echo '<p>Este menu não contém itens.</p>';
        }
    } else {
        echo '<p>Por favor, selecione um menu nas configurações do widget.</p>';
    }

    echo $args['after_widget'];
}

    // Exibe o formulário de configuração do widget no painel de administração
    public function form($instance) {
        $title = isset($instance['title']) ? $instance['title'] : '';
        $nav_menu = isset($instance['nav_menu']) ? $instance['nav_menu'] : '';
        
        // Obtém todos os menus registrados
        $menus = wp_get_nav_menus();
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Título:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        
        <p>
            <label for="<?php echo $this->get_field_id('nav_menu'); ?>">Selecione o Menu:</label>
            <select class="widefat" id="<?php echo $this->get_field_id('nav_menu'); ?>" name="<?php echo $this->get_field_name('nav_menu'); ?>">
                <option value="0">— Selecione —</option>
                <?php foreach ($menus as $menu): ?>
                    <option value="<?php echo esc_attr($menu->term_id); ?>" <?php selected($nav_menu, $menu->term_id); ?>>
                        <?php echo esc_html($menu->name); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>
        <?php
    }

    // Atualiza as configurações do widget
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['nav_menu'] = (!empty($new_instance['nav_menu'])) ? (int) $new_instance['nav_menu'] : 0;
        
        return $instance;
    }
}

// Registrar o widget Menu Lista
function register_menu_lista_widget() {
    register_widget('Menu_Lista_Widget');
}
add_action('widgets_init', 'register_menu_lista_widget');