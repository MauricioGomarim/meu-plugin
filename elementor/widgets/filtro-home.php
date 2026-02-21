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



   protected function register_controls() {

        $this->start_controls_section(
            'section_content',
            [
                'label' => 'Conteúdo',
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'titulo',
            [
                'label' => 'Título',
                'type'  => \Elementor\Controls_Manager::TEXT,
                'default' => 'Meu Filtro Personalizado',
            ]
        );

        $this->add_control(
            'descricao',
            [
                'label' => 'Descrição',
                'type'  => \Elementor\Controls_Manager::TEXTAREA,
                'rows'  => 4,
                'default' => 'Descrição do filtro aqui...',
            ]
        );

        $this->add_control(
            'codigo_html',
            [
                'label' => 'Código HTML',
                'type'  => \Elementor\Controls_Manager::CODE,
                'language' => 'html',
                'rows' => 15,
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {

        $settings = $this->get_settings_for_display();

        echo '<div class="an7-filtro-home">';
        echo '<h2>' . esc_html($settings['titulo']) . '</h2>';
        echo '<p>' . esc_html($settings['descricao']) . '</p>';
        echo $settings['codigo_html'];
        echo '</div>';
    }
}

\Elementor\Plugin::instance()->widgets_manager->register(
    new An7_Widget_Filtro_Home()
);
