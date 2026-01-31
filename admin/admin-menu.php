<?php
if (!defined('ABSPATH')) exit;

add_action('admin_menu', 'an7_addons_admin_menu');
add_action('admin_init', 'an7_addons_register_settings');

function an7_addons_admin_menu() {

    add_menu_page(
        'An7 Addons',
        'An7 Addons',
        'manage_options',
        'an7-addons',
        'an7_addons_page',
        'dashicons-admin-generic',
        58
    );
}

function an7_addons_register_settings() {
    register_setting('an7_addons_group', 'an7_addons');
}

function an7_addons_page() {

    $addons = get_option('an7_addons', []);
    ?>
    <div class="wrap">
        <h1>An7 Addons</h1>

        <form method="post" action="options.php">
            <?php settings_fields('an7_addons_group'); ?>

            <table class="form-table">
                <tr>
                    <th scope="row">Widget Exemplo</th>
                    <td>
                        <label>
                            <input type="checkbox"
                                   name="an7_addons[widget_exemplo]"
                                   value="1"
                                   <?php checked($addons['widget_exemplo'] ?? '', 1); ?>>
                            Ativar Widget Exemplo
                        </label>
                    </td>
                </tr>
            </table>

            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}
