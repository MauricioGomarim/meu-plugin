<?php
if (!defined('ABSPATH')) exit;

/**
 * Cria menu no admin
 */
add_action('admin_menu', 'an7_addons_admin_menu');

function an7_addons_admin_menu() {

    add_menu_page(
        'An7 Addons',              // Título da página
        'An7 Addons',              // Nome no menu
        'manage_options',          // Permissão
        'an7-addons',              // Slug
        'an7_addons_admin_page',   // Callback da página
        'dashicons-admin-plugins', // Ícone
        10                          // Posição (opcional)
    );
	
	
}

/**
 * Conteúdo da página
 */
function an7_addons_admin_page() {
    ?>
    <div class="wrap">
        <h1>An7 Addons</h1>
        <p>Área administrativa do An7 Addons.</p>

        <div style="margin-top:20px; padding:20px; background:#fff; border-radius:6px;">
            <p>Em breve: configurações, módulos, integrações… 🚀</p>
        </div>
    </div>
    <?php
}




