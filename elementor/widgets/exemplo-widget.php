<?php
if (!defined('ABSPATH')) exit;

add_action('elementor/widgets/register', function ($widgets_manager) {

    class An7_Widget_Exemplo extends \Elementor\Widget_Base {

        public function get_name() {
            return 'an7_widget_exemplo';
        }

        public function get_title() {
            return 'An7 – Widget Exemplo';
        }

        public function get_icon() {
            return 'eicon-star';
        }

        // ⚠️ TEM que estar dentro da classe
        public function get_categories() {
            return ['an7-addons'];
        }

        protected function render() {
            echo '<div>Widget An7 funcionando 🚀</div>';
        }
    }

    $widgets_manager->register(new An7_Widget_Exemplo());
});
