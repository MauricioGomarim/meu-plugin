<?php
if (!defined('ABSPATH')) exit;



class An7_Widget_Filtro_Loja extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'an7_widget_filtro_loja';
    }

    public function get_title()
    {
        return 'An7 – Filtro Loja';
    }

    public function get_icon()
    {
        return 'eicon-filter';
    }

    public function get_categories()
    {
        return ['an7-addons'];
    }

    public function get_style_depends()
    {
        return ['an7-filtro-loja'];
    }

    public function get_script_depends()
    {
        return ['an7-filtro-loja'];
    }

    protected function register_controls() {

    /* =========================
     * SECTION - ESTILO GERAL
     ==========================*/
    $this->start_controls_section(
        'section_style_geral',
        [
            'label' => 'Estilo Geral',
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );

    // Cor primária
    $this->add_control(
        'cor_primaria',
        [
            'label' => 'Cor Primária',
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .categoria-item' => 'color: {{VALUE}};',
                '{{WRAPPER}} .breadcrumb-produtos a' => 'color: {{VALUE}};',
                '{{WRAPPER}} .container-filtro h3' => 'color: {{VALUE}};',                
                '{{WRAPPER}} .container-filtro h1' => 'color: {{VALUE}};',
                '{{WRAPPER}} .categoria-atual' => 'color: {{VALUE}};',
                '{{WRAPPER}} .img-filtro svg path' => 'fill: {{VALUE}};',
                '{{WRAPPER}} .img-filtro' => 'border-color: {{VALUE}};',  
                '{{WRAPPER}} .btnCTA a' => 'background: {{VALUE}};',
            ],
        ]
    );

    // Cor dos textos
    $this->add_control(
        'cor_texto',
        [
            'label' => 'Cor do Texto',
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .card-produto h1' => 'color: {{VALUE}};',
                '{{WRAPPER}} .card-produto bdi' => 'color: {{VALUE}};',
                '{{WRAPPER}} .paginacao a' => 'color: {{VALUE}};',
            ],
        ]
    );

    $this->end_controls_section();



        /* =========================
     * SECTION - BARRA LATERAL
     ==========================*/
    $this->start_controls_section(
        'section_style_lateral',
        [
            'label' => 'Barra Lateral',
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );

  

    // Cor dos textos
    $this->add_control(
        'cor_texto_lateral',
        [
            'label' => 'Cor do titulo',
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .container-filtro h3' => 'color: {{VALUE}};',
            ],
        ]
    );


        // Cor dos textos
$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name' => 'tipografia_texto_lateral',
        'selector' => '{{WRAPPER}} .container-filtro h3',
    ]
);

    // Cor dos textos
    $this->add_control(
        'cor_icons',
        [
            'label' => 'Cor dos icones',
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .img-filtro svg path' => 'fill: {{VALUE}};',
                '{{WRAPPER}} .img-filtro' => 'border-color: {{VALUE}};',  
            ],
        ]
    );


    $this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name' => 'tipografia_texto_icones',
        'selector' => '{{WRAPPER}} .item label',
    ]
);


    // Cor dos textos
    $this->add_control(
        'cor_categorias',
        [
            'label' => 'Cor das categorias',
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .categoria-item label' => 'color: {{VALUE}};'
            ],
        ]
    );


    $this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name' => 'tipografia_categorias',
        'selector' => '{{WRAPPER}} .categoria-item label',
    ]
);
    
    $this->end_controls_section();

    /* =========================
     * SECTION - CARD PRODUTO
     ==========================*/
    $this->start_controls_section(
        'section_style_card',
        [
            'label' => 'Card Produto',
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );

    // Background do card
    $this->add_control(
        'card_background',
        [
            'label' => 'Background do Card',
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .card-produto' => 'background: {{VALUE}};',
            ],
        ]
    );

    // Border radius
    $this->add_control(
        'card_radius',
        [
            'label' => 'Border Radius',
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'selectors' => [
                '{{WRAPPER}} .card-produto' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $this->end_controls_section();


    /* =========================
     * SECTION - BOTÃO
     ==========================*/
    $this->start_controls_section(
        'section_style_button',
        [
            'label' => 'Botão',
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );

    $this->add_control(
        'button_color',
        [
            'label' => 'Cor do Botão',
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .btnCTA a' => 'background: {{VALUE}};',
            ],
        ]
    );

    $this->add_control(
        'button_text_color',
        [
            'label' => 'Cor Texto Botão',
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .btnCTA a' => 'color: {{VALUE}};',
            ],
        ]
    );

    $this->end_controls_section();
}



    protected function render()
    { ?>
        <div class="container-filtro-loja">
            <?php
            $this->render_barra_lateral();
            $this->listagem_produtos();
            ?>
        </div>
    <?php
    }


    private function render_barra_lateral()
    {


            // Obtém categorias principais (parent = 0)
            $categorias = get_terms(array(
                'taxonomy'   => 'product_cat',
                'hide_empty' => false,
                'parent'     => 0,
                'orderby'    => 'term_order',
                'order'      => 'ASC',
                'exclude'    => array(16),
            ));

            if (!function_exists('render_subcategorias')) {
                function render_subcategorias($parent_id)
                {
                    $subcategorias = get_terms(array(
                        'taxonomy'   => 'product_cat',
                        'hide_empty' => false,
                        'parent'     => $parent_id,
                    ));

                    if (!empty($subcategorias) && !is_wp_error($subcategorias)) {
                        echo '<div class="subcategorias">';
                        foreach ($subcategorias as $sub) {
                            echo '<div class="subcategoria-item">';
                            echo '<label>';
                            echo '<input type="checkbox" name="categoria[]" value="' . esc_attr($sub->term_id) . '">';
                            echo esc_html($sub->name);
                            echo '</label>';

                            // Chamada recursiva
                            render_subcategorias($sub->term_id);

                            echo '</div>';
                        }
                        echo '</div>';
                    }
                }
            }


            ob_start();
        ?>

            <div class="container-filtro">
                <h3>Categorias</h3>
                <div class="filtro-categorias">
                    <?php foreach ($categorias as $categoria) : ?>
                        <div class="categoria-item" data-category="'<?php echo $categoria->name; ?>'">
                            <div class="categoria-header" data-toggle="accordion">
                                <label>
                                    <input type="checkbox" name="categoria[]" value="<?php echo esc_attr($categoria->term_id); ?>" data-slug="<?php echo esc_attr($categoria->name); ?>">
                                    <?php echo esc_html($categoria->name); ?>
                                </label>
                                <?php
                                $tem_sub = get_terms(array(
                                    'taxonomy'   => 'product_cat',
                                    'hide_empty' => false,
                                    'parent'     => $categoria->term_id,
                                    'orderby' => 'menu'
                                ));
                                if (!empty($tem_sub)) : ?>
                                    <span class="seta">
                                        <img src="https://projetos.an7internet.com.br/fornopaulista/wp-content/uploads/2025/08/arrow-down.png" />
                                    </span>
                                <?php endif; ?>
                            </div>

                            <?php
                            // Subcategorias recursivas
                            render_subcategorias($categoria->term_id);
                            ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <h3>Ordenar</h3>
                <div class="items-order">
                    <div class="item order">
                        <label>
                            <div class='img-filtro'>
                                <svg width="50" height="50" viewBox="0 0 284 418" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M42.2719 139.912H102.272L116.672 182.632H133.632L72.3519 0.712006L11.0719 182.632H27.8719L42.2719 139.912ZM72.3519 50.952L96.8319 123.912H47.7119L72.3519 50.952Z" fill="black" />
                                    <path d="M272.144 340.856L226.32 386.664V25.832H210.32V386.664L164.512 340.856L153.2 352.168L218.32 417.288L283.456 352.168L272.144 340.856Z" fill="black" />
                                    <path d="M17.6159 260.52V276.52H109.856L0.543945 407.864H126.928V391.864H34.688L144 260.52H17.6159Z" fill="black" />
                                </svg>

                            </div>
                            de A a Z
                            <input name="order" value="ASC" hidden type="radio" />
                        </label>
                    </div>
                    <div class="item order">
                        <label>
                            <div class='img-filtro'>
                                <svg width="50" height="50" viewBox="0 0 284 418" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M42.272 139.912H102.272L116.672 182.632H133.632L72.352 0.712006L11.072 182.632H27.872L42.272 139.912ZM72.352 50.952L96.832 123.912H47.712L72.352 50.952Z" fill="black" />
                                    <path d="M164.512 102.264L210.336 56.456L210.336 417.288L226.336 417.288L226.336 56.456L272.144 102.264L283.456 90.952L218.336 25.832L153.2 90.952L164.512 102.264Z" fill="black" />
                                    <path d="M17.616 260.52V276.52H109.856L0.544006 407.864H126.928V391.864H34.688L144 260.52H17.616Z" fill="black" />
                                </svg>

                            </div>
                            de Z a A
                            <input name="order" value="DESC" hidden type="radio" />
                        </label>
                    </div>

                    <div class="item destaque">
                        <label for="destaque">
                            <div class='img-filtro'>
                                <svg width="50" height="50" viewBox="0 0 401 483" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M232.279 231.997H208.279V135.997C208.278 131.579 204.696 127.998 200.277 127.999C198.156 127.999 196.123 128.842 194.623 130.341L162.623 162.341C159.554 165.519 159.642 170.584 162.82 173.653C165.92 176.647 170.835 176.647 173.935 173.653L192.279 155.309V231.997H168.279C163.861 231.997 160.279 235.579 160.279 239.997C160.279 244.415 163.861 247.997 168.279 247.997H232.279C236.697 247.997 240.279 244.415 240.279 239.997C240.279 235.579 236.697 231.997 232.279 231.997Z" fill="black" />
                                    <path d="M164.939 77.088C96.9939 96.606 57.7369 167.509 77.2549 235.453C78.2429 238.879 81.378 241.237 84.943 241.237C85.69 241.239 86.434 241.134 87.151 240.925C91.396 239.705 93.8499 235.275 92.6309 231.029C86.8579 210.93 86.827 189.617 92.542 169.502C109.446 110 171.385 75.469 230.886 92.373C290.387 109.277 324.919 171.216 308.015 230.717C306.807 234.967 309.273 239.393 313.523 240.601C317.773 241.809 322.199 239.343 323.407 235.093C329.939 212.103 329.903 187.743 323.304 164.772C303.786 96.827 232.883 57.57 164.939 77.088Z" fill="black" />
                                    <path d="M279.479 267.877C276.353 264.751 271.285 264.751 268.159 267.877C265.033 271.003 265.033 276.071 268.159 279.197L279.471 290.501C280.971 292.001 283.005 292.845 285.127 292.845V292.853C287.248 292.853 289.282 292.01 290.781 290.511C293.906 287.387 293.906 282.322 290.783 279.197L279.479 267.877Z" fill="black" />
                                    <path d="M308.191 253.069L294.343 245.069C290.538 242.906 285.702 244.202 283.489 247.977C281.254 251.788 282.532 256.69 286.343 258.925L300.191 266.925C301.406 267.63 302.786 268 304.191 267.997C307.049 267.997 309.69 266.472 311.119 263.997C313.328 260.171 312.017 255.278 308.191 253.069Z" fill="black" />
                                    <path d="M132.399 267.877C129.273 264.751 124.205 264.751 121.079 267.877L109.775 279.189C108.276 280.689 107.433 282.723 107.433 284.843C107.432 289.261 111.013 292.844 115.431 292.845C117.55 292.842 119.581 291.999 121.079 290.501L132.399 279.197C135.525 276.071 135.525 271.003 132.399 267.877Z" fill="black" />
                                    <path d="M114.308 258.871C118.119 256.636 119.397 251.735 117.162 247.923C114.927 244.111 110.026 242.834 106.214 245.069L92.366 253.069C89.891 254.498 88.366 257.139 88.366 259.997C88.366 264.415 91.947 267.997 96.366 267.997C97.771 268 99.151 267.63 100.366 266.925L114.214 258.925C114.246 258.907 114.277 258.889 114.308 258.871Z" fill="black" />
                                    <path d="M398.215 194.637L363.543 156.237L374.399 105.653C375.263 101.636 372.942 97.617 369.031 96.357L319.775 80.501L303.927 31.245C302.667 27.334 298.648 25.013 294.631 25.877L244.039 36.733L205.639 2.061C202.594 -0.687 197.964 -0.687 194.919 2.061L156.519 36.733L105.935 25.877C101.918 25.013 97.899 27.334 96.639 31.245L80.783 80.493L31.527 96.349C27.616 97.609 25.295 101.628 26.159 105.645L37.015 156.237L2.34298 194.637C-0.405018 197.682 -0.405018 202.312 2.34298 205.357L37.015 243.757L26.159 294.341C25.295 298.358 27.616 302.377 31.527 303.637L68.783 315.637C67.876 316.288 67.116 317.122 66.551 318.085L6.23098 422.557C4.01998 426.382 5.32798 431.276 9.15298 433.487C10.995 434.552 13.185 434.839 15.239 434.285L73.023 418.765L88.551 476.629C89.388 479.757 92.028 482.072 95.239 482.493C95.584 482.534 95.931 482.556 96.279 482.557C99.137 482.557 101.778 481.032 103.207 478.557L163.287 374.477C163.993 373.169 164.315 371.688 164.215 370.205L194.919 397.933C197.964 400.681 202.594 400.681 205.639 397.933L236.343 370.205C236.243 371.688 236.565 373.169 237.271 374.477L297.351 478.557C298.78 481.032 301.421 482.557 304.279 482.557C304.627 482.556 304.974 482.534 305.319 482.493C308.53 482.072 311.17 479.757 312.007 476.629L327.535 418.765L385.319 434.285C389.585 435.435 393.975 432.909 395.125 428.643C395.679 426.589 395.391 424.399 394.327 422.557L334.007 318.077C333.444 317.115 332.687 316.281 331.783 315.629L369.031 303.629C372.942 302.369 375.263 298.35 374.399 294.333L363.543 243.757L398.215 205.357C400.963 202.312 400.963 197.682 398.215 194.637ZM149.431 366.477L99.015 453.837L86.415 406.885C85.272 402.617 80.886 400.083 76.618 401.226C76.614 401.227 76.61 401.228 76.607 401.229L29.767 413.821L80.415 326.077C81.253 324.548 81.56 322.783 81.287 321.061L96.631 368.749C97.891 372.66 101.91 374.981 105.927 374.117L151.271 364.389C150.536 364.968 149.912 365.675 149.431 366.477ZM370.807 413.837L323.959 401.229C319.693 400.08 315.303 402.607 314.154 406.874C314.153 406.878 314.152 406.882 314.151 406.885L301.551 453.837L251.151 366.477C250.669 365.675 250.046 364.968 249.311 364.389L294.647 374.117C298.664 374.981 302.683 372.66 303.943 368.749L319.295 321.045C319.018 322.773 319.325 324.543 320.167 326.077L370.807 413.837ZM348.927 236.077C347.206 237.986 346.507 240.605 347.047 243.117L357.231 290.629L310.959 305.517C308.504 306.306 306.58 308.23 305.791 310.685L290.903 356.949L243.399 346.765C240.886 346.211 238.261 346.912 236.359 348.645L200.279 381.213L164.199 348.645C162.729 347.317 160.82 346.582 158.839 346.581C158.274 346.58 157.71 346.641 157.159 346.765L109.647 356.949L94.759 310.677C93.97 308.222 92.046 306.298 89.591 305.509L43.327 290.621L53.511 243.117C54.051 240.605 53.352 237.986 51.631 236.077L19.063 199.997L51.631 163.917C53.352 162.008 54.051 159.389 53.511 156.877L43.327 109.365L89.599 94.477C92.054 93.688 93.978 91.764 94.767 89.309L109.655 43.045L157.159 53.229C159.672 53.79 162.3 53.088 164.199 51.349L200.279 18.781L236.359 51.349C238.256 53.091 240.886 53.793 243.399 53.229L290.911 43.045L305.799 89.317C306.588 91.772 308.512 93.696 310.967 94.485L357.231 109.373L347.047 156.877C346.507 159.389 347.206 162.009 348.927 163.917L381.495 199.997L348.927 236.077Z" fill="black" />
                                    <path d="M239.063 313.853L234.919 298.397C233.756 294.134 229.359 291.621 225.096 292.784C220.862 293.939 218.349 298.288 219.463 302.533L223.607 317.997C224.544 321.491 227.709 323.922 231.327 323.925C232.029 323.929 232.729 323.837 233.407 323.653C237.675 322.509 240.207 318.123 239.063 313.855V313.853Z" fill="black" />
                                    <path d="M259.207 286.069C257.024 282.228 252.14 280.884 248.299 283.067C244.458 285.25 243.114 290.134 245.297 293.975C245.315 294.006 245.333 294.037 245.351 294.068L253.351 307.916C255.586 311.727 260.487 313.005 264.299 310.77C268.074 308.556 269.37 303.72 267.207 299.916L259.207 286.069Z" fill="black" />
                                    <path d="M175.479 292.725C171.212 291.58 166.824 294.112 165.68 298.379V298.381L161.536 313.837C160.391 318.104 162.923 322.492 167.19 323.636H167.192C167.87 323.82 168.57 323.912 169.272 323.908C172.89 323.905 176.055 321.474 176.992 317.98L181.136 302.516C182.274 298.252 179.743 293.869 175.479 292.725Z" fill="black" />
                                    <path d="M152.279 283.141C148.453 280.932 143.56 282.243 141.351 286.069L133.351 299.917C131.117 303.729 132.395 308.63 136.207 310.864C140.019 313.098 144.92 311.82 147.154 308.008C147.172 307.978 147.189 307.947 147.207 307.916L155.207 294.068C157.416 290.243 156.105 285.35 152.279 283.141Z" fill="black" />
                                    <path d="M200.279 295.997C195.861 295.997 192.279 299.579 192.279 303.997V319.997C192.279 324.415 195.861 327.997 200.279 327.997C204.697 327.997 208.279 324.415 208.279 319.997V303.997C208.279 299.579 204.697 295.997 200.279 295.997Z" fill="black" />
                                </svg>

                            </div>
                            MAIS VENDIDO
                            <input id="destaque" name="destaque" value="destaque" hidden type="checkbox" />
                        </label>
                    </div>



                    <div class="item promocao">
                        <label for="promocao">
                            <div class='img-filtro'>
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="50" height="50" x="0" y="0" viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                    <g>
                                        <path d="M15.846 23.999c-.384 0-.769-.081-1.124-.243l-2.012-.915a1.718 1.718 0 0 0-1.419 0l-2.012.914a2.729 2.729 0 0 1-2.163.037 2.731 2.731 0 0 1-1.504-1.555l-.776-2.07a1.712 1.712 0 0 0-1.003-1.003l-2.07-.776c-.702-.264-1.268-.812-1.555-1.504s-.273-1.48.037-2.163l.915-2.012a1.722 1.722 0 0 0 0-1.419L.244 9.278c-.31-.682-.324-1.471-.037-2.163s.854-1.24 1.555-1.504l2.07-.776c.464-.174.83-.54 1.003-1.003l.776-2.07A2.729 2.729 0 0 1 7.115.207a2.725 2.725 0 0 1 2.163.037l2.012.915c.45.204.968.205 1.419 0l2.012-.914c.682-.311 1.471-.324 2.163-.037s1.24.854 1.504 1.555l.776 2.07c.174.464.54.83 1.003 1.003l2.07.776c.702.264 1.268.812 1.555 1.504s.273 1.48-.037 2.163l-.915 2.012a1.722 1.722 0 0 0 0 1.419l.914 2.012c.31.682.324 1.471.037 2.163s-.854 1.24-1.555 1.504l-2.07.776c-.464.174-.83.54-1.003 1.003l-.776 2.07a2.71 2.71 0 0 1-2.541 1.761zM12 21.688c.383 0 .766.081 1.123.243l2.013.915c.438.2.923.208 1.366.023.444-.184.781-.533.95-.982l.776-2.07a2.712 2.712 0 0 1 1.588-1.588l2.07-.776c.45-.168.799-.506.982-.95a1.696 1.696 0 0 0-.023-1.366l-.915-2.012a2.719 2.719 0 0 1 0-2.247l.915-2.013c.199-.437.207-.922.023-1.366s-.533-.781-.982-.95l-2.07-.776a2.712 2.712 0 0 1-1.588-1.588l-.776-2.07a1.692 1.692 0 0 0-.95-.982 1.692 1.692 0 0 0-1.366.023l-2.012.915a2.724 2.724 0 0 1-2.246 0l-2.014-.917c-.438-.199-.922-.207-1.366-.023s-.781.533-.95.982l-.776 2.07a2.716 2.716 0 0 1-1.588 1.589l-2.07.776c-.45.168-.799.506-.982.95-.185.444-.176.929.022 1.366l.915 2.012a2.719 2.719 0 0 1 0 2.247l-.915 2.013c-.199.437-.207.922-.023 1.366s.533.781.982.95l2.07.776a2.712 2.712 0 0 1 1.588 1.588l.776 2.07c.168.45.506.799.95.982.444.184.928.176 1.366-.023l2.012-.915A2.748 2.748 0 0 1 12 21.688zm.917-20.074h.01z" fill="#391f84" opacity="1" data-original="#000000" class="" />
                                        <path d="M8.5 10C7.122 10 6 8.878 6 7.5S7.122 5 8.5 5 11 6.122 11 7.5 9.878 10 8.5 10zm0-4C7.673 6 7 6.673 7 7.5S7.673 9 8.5 9 10 8.327 10 7.5 9.327 6 8.5 6zM15.5 19c-1.378 0-2.5-1.122-2.5-2.5s1.122-2.5 2.5-2.5 2.5 1.122 2.5 2.5-1.122 2.5-2.5 2.5zm0-4c-.827 0-1.5.673-1.5 1.5s.673 1.5 1.5 1.5 1.5-.673 1.5-1.5-.673-1.5-1.5-1.5zM8.5 18a.499.499 0 0 1-.421-.768l7-11a.5.5 0 0 1 .843.537l-7 11A.5.5 0 0 1 8.5 18z" fill="#391f84" opacity="1" data-original="#000000" class="" />
                                    </g>
                                </svg>

                            </div>
                            PROMOÇÕES
                            <input id="promocao" name="promo" value="false" hidden type="checkbox" />
                        </label>
                    </div>
                </div>

                <button id="clear-filter" type="button">
                    Limpar filtro
                </button>
            </div>
        <?php
    }


    private function listagem_produtos()
    {
        $paged = isset($_POST['pagina']) ? intval($_POST['pagina']) : 1;

        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => 3,
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
            'paged'          => $paged,
        );

        $query = new WP_Query($args);

        $categoria_atual = null;
        if (is_tax('product_cat')) {
            $categoria_atual = get_queried_object();
        }


        // Início da listagem
    ?>
        <div class='produtos-content-listagem'>

            <div class='breadcrumb-produtos'>
                <a href="<?php echo home_url(); ?>">Home</a> <span><svg xmlns="http://www.w3.org/2000/svg" id="Isolation_Mode" data-name="Isolation Mode" viewBox="0 0 24 24" width="15" height="15"><path d="M22.33,9.533,12.8.005,10.68,2.126l9.529,9.528a.49.49,0,0,1,0,.692L10.68,21.874,12.8,24l9.529-9.528A3.493,3.493,0,0,0,22.33,9.533Z"/><path d="M13.8,10.939,2.86.005.739,2.126,10.613,12,.739,21.874,2.86,24,13.8,13.061A1.5,1.5,0,0,0,13.8,10.939Z"/></svg></span>
                <?php if ($categoria_atual): ?>
                    <span class='categoria-atual'><?php echo esc_html($categoria_atual->name); ?></span>
                <?php else: ?>
                    <span class='categoria-atual'>Nossos produtos</span>
                <?php endif; ?>
            </div>

            <h1 class='categoria-atual'><?php echo $categoria_atual ? esc_html($categoria_atual->name) : 'Nossos produtos'; ?></h1>

            <!--
            <div class='search-field-produtos'>
                <input id='busca' placeholder='Pesquise o produto' />
                <img src='https://projetos.an7internet.com.br/fornopaulista/wp-content/uploads/2025/08/busca.png' />
            </div> -->

            <div class='content-produtos'>
                <div class='produtos-listagem'>
                </div>
            </div>

        </div>
<?php


    }
}

\Elementor\Plugin::instance()->widgets_manager->register(
    new An7_Widget_Filtro_Loja()
);
