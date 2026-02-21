<?php

if (!defined('ABSPATH')) {
    exit;
}

/* ENDPOINT PARA FILTROS AJAX */
function an7_filtrar_produtos_loja_ajax()
{
    $categorias_ids = isset($_POST['categorias_ids']) ? $_POST['categorias_ids'] : [];
    $searchText = isset($_POST['searchText']) ? sanitize_text_field($_POST['searchText']) : "";
    $order = isset($_POST['order']) ? sanitize_text_field($_POST['order']) : "ASC";
    $paged = isset($_POST['paged']) ? max(1, intval($_POST['paged'])) : 1;
    $destaque = isset($_POST['destaque']) ? sanitize_text_field($_POST['destaque']) : "";
	$promo = isset($_POST['promo']) ? sanitize_text_field($_POST['promo']) : "";
$promo = filter_var($_POST['promo'] ?? false, FILTER_VALIDATE_BOOLEAN);
	

    $nomes = null;
    if (!empty($categorias_ids)) {
        $nomes = get_terms(array(
            'taxonomy'   => 'product_cat',
            'include'    => $categorias_ids,
            'fields'     => 'names',
            'hide_empty' => false,
        ));
    }
	
	
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => 9,
        'paged'          => $paged,
        'orderby'        => 'title',
        'order'          => $order,
    );

    if (!empty($categorias_ids)) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'term_id',
                'terms'    => $categorias_ids,
            ),
        );
    }

    if (!empty($destaque)) {
        if (!isset($args['tax_query'])) {
            $args['tax_query'] = array();
        }
        $args['tax_query'][] = array(
            'taxonomy'         => 'product_visibility',
            'terms'            => 'featured',
            'field'            => 'name',
            'operator'         => 'IN',
            'include_children' => false,
        );
    }
	

        if ($promo == true) {

            if (!isset($args['meta_query'])) {
                $args['meta_query'] = array();
            }

            $args['meta_query'][] = array(
                'key'     => '_sale_price',
                'value'   => 0,
                'compare' => '>',
                'type'    => 'NUMERIC'
            );
        }

    if (!empty($searchText)) {
        $args['s'] = $searchText;
    }

	
    $query = new WP_Query(array_merge($args, array(
        'no_found_rows'  => false,
        'cache_results'  => false,
    )));
	
    $produtos = $query->posts;
	global $post;
    $produtos_formatados = array();
    foreach ($produtos as $produto) {

        $image = get_the_post_thumbnail_url($produto->ID) ? get_the_post_thumbnail_url($produto->ID) : "https://projetos.an7internet.com.br/raysunshine/wp-content/uploads/woocommerce-placeholder.webp";
        $product = wc_get_product($produto->ID);
       
		$tipo_produto = $product->get_type();

if ($tipo_produto === 'variable') {
    // Para produtos variáveis, pegar o preço mínimo e máximo
    $preco_min = $product->get_variation_price('min', true);
    $preco_max = $product->get_variation_price('max', true);

        $preco_formatado = '
            <div class="precos">
                <span class="preco-variavel">' . wc_price($preco_min) . '</span>
            </div>
        ';
    

    // Usar o menor preço para cálculo de parcelamento
    $preco_regular = $preco_min;
    $preco_promocional = null;
} else {
    // Produto simples
    $preco_promocional = $product->get_sale_price();
    $preco_regular = $product->get_regular_price();

    if ($preco_promocional && $preco_promocional !== '') {
        $preco_formatado = '
            <div class="precos">
                <span class="preco-regular promocional-on">' . wc_price($preco_regular) . '</span>
                <span class="preco-promocional">' . wc_price($preco_promocional) . '</span>
            </div>
        ';
    } elseif ($preco_regular && $preco_regular !== '') {
        $preco_formatado = '
            <div class="precos">
                <span class="preco-regular">' . wc_price($preco_regular) . '</span>
            </div>
        ';
    } else {
        $preco_formatado = '';
    }
}
		

        // Parcelamento (fswp_settings)
        $parcelas_config = get_option('fswp_settings');
        $parcelas = isset($parcelas_config['installment_qty']) ? intval($parcelas_config['installment_qty']) : 6;
        $preco = ($preco_regular && $parcelas) ? ($preco_regular / $parcelas) : 0;
        if ($preco_promocional && $parcelas) {
            $preco = ($preco_promocional / $parcelas);
        }

		
        $parcelas_formatadas = $parcelas
            ? " ou até <strong>{$parcelas}x</strong> de <strong>" . wc_price($preco) . "</strong> {$parcelas_config['installment_suffix']} "
            : 'Parcelamento não disponível';

        $botao_wishlist = '';
        $produtos_formatados[] = array(
            'id'           => $produto->ID,
            'perma_link'   => get_permalink($produto->ID),
            'nome'         => get_the_title($produto->ID),
            'imagem_url'   => $image,
            'preco_regular'=> $preco_formatado,
            'tipo'         => $tipo_produto,
            'parcelamento' => $preco_formatado ? $parcelas_formatadas : ""

        );
    }

    echo json_encode(array(
        'produtos'      => $produtos_formatados,
        'total_pages'   => $query->max_num_pages,
        'current_page'  => $paged,
		'nome_categorias' => $nomes
    ), JSON_UNESCAPED_UNICODE);



    wp_die();
}

add_action('wp_ajax_an7_filtrar_produtos', 'an7_filtrar_produtos_loja_ajax');
add_action('wp_ajax_nopriv_an7_filtrar_produtos', 'an7_filtrar_produtos_loja_ajax');
