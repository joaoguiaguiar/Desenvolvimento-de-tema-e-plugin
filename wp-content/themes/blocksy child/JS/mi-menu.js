jQuery(document).ready(function($) {
    // Toggle do menu mobile
    $('.menu-hamburguer').on('click', function() {
        $('.container__lista').toggleClass('active');
    });
    
    // AJAX para carregar mais itens
    $('.load-more-items').on('click', function() {
        var button = $(this);
        var category = button.data('category');
        
        $.ajax({
            url: miMenuVars.ajaxurl,
            type: 'post',
            data: {
                action: 'mi_load_more_items',
                category: category,
                nonce: miMenuVars.nonce
            },
            beforeSend: function() {
                button.text('Carregando...');
            },
            success: function(response) {
                if (response.success) {
                    button.closest('li').find('ul').append(response.data.items);
                    button.remove();
                }
            }
        });
    });
});