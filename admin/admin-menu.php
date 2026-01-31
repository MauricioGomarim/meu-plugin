<?php
if (!defined('ABSPATH')) exit;

add_action('admin_menu', 'an7_addons_admin_menu');
add_action('admin_init', 'an7_addons_register_settings');

function an7_addons_admin_menu()
{

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

function an7_addons_register_settings()
{
    register_setting('an7_addons_group', 'an7_addons');
}

function an7_addons_page()
{

    $addons = get_option('an7_addons', []);
?>
    <div class="wrap">
        <h1>An7 Addons</h1>

        <form method="post" action="options.php">
            <?php settings_fields('an7_addons_group'); ?>

            <div class="an7-cards">

                <?php
                $features = [
                    'widget_exemplo' => [
                        'title' => 'Widget Exemplo',
                        'desc'  => 'Ativa o widget de exemplo no site'
                    ],
                    'widget_filtro_home' => [
                        'title' => 'Filtro home',
                        'desc'  => 'Descrição curta da feature X'
                    ]
 
                ];

                foreach ($features as $key => $feature) :
                    $enabled = !empty($addons[$key]);
                ?>
                    <div class="an7-card">
                        <div class="an7-card-content">
                            <h3><?= esc_html($feature['title']); ?></h3>
                            <p><?= esc_html($feature['desc']); ?></p>
                        </div>

                        <label class="an7-switch">
                            <input type="checkbox"
                                name="an7_addons[<?= esc_attr($key); ?>]"
                                value="1"
                                <?php checked($enabled, true); ?>>
                            <span class="an7-slider"></span>
                        </label>
                    </div>
                <?php endforeach; ?>

            </div>


            <?php submit_button(); ?>
        </form>
    </div>
<?php
}
