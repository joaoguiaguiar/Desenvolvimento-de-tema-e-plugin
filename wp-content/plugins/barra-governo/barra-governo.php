<?php
/*
Plugin Name: Barra do Governo Brasil
Description: Adiciona a barra do governo ao tema pai sem ser removida em atualizações.
Version: 1.0
Author: joao.aguiar
*/



if (!defined('ABSPATH')) {
    exit;
}

function adicionar_barra_governo_tema_pai() {
    echo '<div id="barra-brasil"></div>';
    echo '<script defer src="https://barra.brasil.gov.br/barra_2.0.js"></script>';
}

add_action('wp_body_open', 'adicionar_barra_governo_tema_pai');

function adicionar_estilo_barra_governo() {
    echo '<style>
        #barra-brasil {
            position: relative;
            z-index: 1000;
            display: block;
        }
        body {
            overflow-x: hidden;
        }
    </style>';
}
add_action('wp_head', 'adicionar_estilo_barra_governo');
