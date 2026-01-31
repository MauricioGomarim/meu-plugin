<?php
if (!defined('ABSPATH')) exit;

class An7_Widget_Filtro_Home extends \Elementor\Widget_Base {

    public function get_name() {
        return 'an7_widget_filtro_home';
    }

    public function get_title() {
        return 'An7 – Filtro Home';
    }

    public function get_icon() {
        return 'eicon-filter';
    }

    public function get_categories() {
        return ['an7-addons'];
    }

    protected function render() {
        echo '<div>Filtro Home funcionando 🚀</div>';
    }
}

\Elementor\Plugin::instance()->widgets_manager->register(
    new An7_Widget_Filtro_Home()
);
