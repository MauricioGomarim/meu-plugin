

jQuery(function ($) {
  $(document).ready(function () {
    /* TIMEOUTS */
    setTimeout(function () {
      $(
        ".categorias-produtos-selecionados-home .categoria:nth-child(1)",
      ).click();
    }, 1000);

    /* TIMEOUTS */

    var path = window.location.pathname;
    var partes = path.split("/").filter(Boolean);
    var categoriaSlug = partes[partes.length - 1]; // exemplo: "armacao"

    // Flag para controlar se o clique automático já rodou
    let filtroAplicado = false;

    if (
      categoriaSlug &&
      path.includes("categoria-produto") &&
      !filtroAplicado
    ) {
      $('.filtro-categorias input[type="checkbox"]').prop("checked", false);

      function normalizarTexto(txt) {
        return txt
          .toLowerCase()
          .normalize("NFD")
          .replace(/[\u0300-\u036f]/g, "");
      }

      var categoriaNormalizada = normalizarTexto(
        categoriaSlug.replace(/-/g, " "),
      );

      var $checkbox = $(".filtro-categorias input[data-slug]").filter(
        function () {
          return normalizarTexto($(this).data("slug")) === categoriaNormalizada;
        },
      );

      if ($checkbox.length) {
        $checkbox.prop("checked", true).trigger("change");
        filtroAplicado = true;
      }
    } else if (path.includes("/loja")) {
      setTimeout(function () {
        $('input[type="checkbox"]').prop("checked", false);
        $("#busca").val("");
        $(".items-order .order").removeClass("active");
        $(".destaque").removeClass("active");
        getProdutosCategoriaBarraLateral([], "", "ASC", 1, "");
      }, 500);
    }

    // Obtem o id da categoria e chama a busca de projetos
    $(".categorias-produtos-selecionados-home .categoria").click(function () {
      $(".categorias-produtos-selecionados-home .categoria").removeClass(
        "active",
      );
      $(this).addClass("active");
      var categoriaProdutoID = $(this).data("id");
      getProdutosCategoria(categoriaProdutoID);
    });

    $(document).ready(function () {
      const urlParams = new URLSearchParams(window.location.search);
      const buscaParam = urlParams.get("s"); // pega ?s=valor
      const busca = buscaParam ? buscaParam : $("#busca").val();
      const categorias = getCategoriasSelecionadas();

      const order = $('input[name="order"]:checked').val() || "ASC";
      getProdutosCategoriaBarraLateral(categorias, busca, order, 1);
    });

    let categoriasSelecionadas = [];

    function getCategoriasSelecionadas() {
      return [
        ...new Set(
          $('.filtro-categorias input[type="checkbox"]:checked')
            .map(function () {
              return $(this).val();
            })
            .get(),
        ),
      ];
    }

    function getParam(name) {
      const urlParams = new URLSearchParams(window.location.search);
      return urlParams.get(name);
    }

    // Verifica se 'promo=true' está presente
    const promoParam = getParam("promo");

    $(document).ready(function () {
      if (promoParam === "true") {
        $(".promocao").addClass("active");

        const categorias = getCategoriasSelecionadas();
        const busca = $("#busca").val();
        const destaque = $('input[name="destaque"]:checked').val() || "";

        const order = $('input[name="order"]:checked').val() || "ASC";
        const orderFormated = $(this).is(":checked") ? order : "ASC";

        setTimeout(function () {
          getProdutosCategoriaBarraLateral(
            categorias,
            busca,
            orderFormated,
            1,
            destaque,
            promoParam,
          );
        }, 1000);
      }
    });

    $('.filtro-categorias input[type="checkbox"]').on("change", function () {
      const valor = $(this).val();
      const checked = $(this).is(":checked");

      // Marca ou desmarca TODOS com mesmo value
      $('.filtro-categorias input[value="' + valor + '"]').prop(
        "checked",
        checked,
      );

      const categorias = getCategoriasSelecionadas();

      const busca = $("#busca").val();
      const order = $('input[name="order"]:checked').val() || "ASC";
      const destaque = $('input[name="destaque"]:checked').val() || "";

      getProdutosCategoriaBarraLateral(categorias, busca, order, 1, destaque);
    });

    $("#busca").on("change input", function () {
      const categorias = getCategoriasSelecionadas();
      const busca = $(this).val();
      const order = $('input[name="order"]:checked').val() || "ASC";
      const destaque = $('input[name="destaque"]:checked').val() || "";
      getProdutosCategoriaBarraLateral(categorias, busca, order, 1, destaque);
    });

    $('input[name="order"]').on('change input[name="order"]', function () {
      $(".items-order .order").removeClass("active");
      $(this).closest(".order").addClass("active");

      const categorias = getCategoriasSelecionadas();
      const busca = $("#busca").val();
      const destaque = $('input[name="destaque"]:checked').val() || "";
      const checked = $('input[name="promo"]').is(":checked");
      const order = $(this).val();
      const orderFormated = $(this).is(":checked") ? order : "ASC";

      getProdutosCategoriaBarraLateral(
        categorias,
        busca,
        orderFormated,
        1,
        destaque,
        checked,
      );
    });

    $('input[name="promo"]').on("change", function () {
      const checked = $(this).is(":checked");

      if (checked) {
        $(".promocao").addClass("active");
      } else {
        $(".promocao").removeClass("active");
      }

      const categorias = getCategoriasSelecionadas();
      const busca = $("#busca").val();
      const destaque = $('input[name="destaque"]:checked').val() || "";

      const order = $('input[name="order"]:checked').val() || "ASC";
      const orderFormated = $(this).is(":checked") ? order : "ASC";

      getProdutosCategoriaBarraLateral(
        categorias,
        busca,
        orderFormated,
        1,
        destaque,
        checked,
      );
    });

    $("#destaque").on("change", function () {
      const categorias = getCategoriasSelecionadas();
      const busca = $("#busca").val();
      const order = $('input[name="order"]:checked').val() || "ASC";
      const checked = $('input[name="promo"]').is(":checked");
      $(".destaque").toggleClass("active");
      const destaque = $(this).is(":checked") ? "destaque" : "";

      getProdutosCategoriaBarraLateral(
        categorias,
        busca,
        order,
        1,
        destaque,
        checked,
      );
    });

    $(document).on("click", ".pagina-link", function (e) {
      e.preventDefault();

      const paged = $(this).data("page");
      const categorias = getCategoriasSelecionadas();
      const busca = $("#busca").val();
      const order = $('input[name="order"]:checked').val() || "ASC";
      const destaque = $('input[name="destaque"]:checked').val() || "";
      const promo = $('input[name="promo"]').is(":checked");

      getProdutosCategoriaBarraLateral(
        categorias,
        busca,
        order,
        paged,
        destaque,
        promo,
      );
    });

    $(".categoria-header").on("click", function (e) {
      // Impede o toggle se clicou dentro do label ou input
      if ($(e.target).closest("label").length) return;

      $(this).closest(".categoria-item").toggleClass("active");
    });

    $(document).on("click", "#clear-filter", function () {
      $('input[type="checkbox"]').prop("checked", false);
      $("#busca").val("");
      $(".items-order .order").removeClass("active");
      $(".destaque").removeClass("active");
      getProdutosCategoriaBarraLateral([], "", "ASC", 1, "");
      $('input[name="promo"]').removeClass("active");
    });

    function getProdutosCategoriaBarraLateral(
      selecionados = [],
      searchText = "",
      order = "ASC",
      paged = 1,
      destaque = "",
      promo = false,
    ) {
      $(".produtos-content-listagem .content-produtos").html(
        '<div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>',
      );

      $.ajax({
        type: "POST",
        url: ajax_object.ajax_url,
        data: {
          action: "an7_filtrar_produtos",
          categorias_ids: selecionados.length ? selecionados : null,
          searchText: searchText,
          order: order,
          paged: paged,
          destaque: destaque,
          promo: promo,
        },
        success: function (response) {
          var data = JSON.parse(response);

          if (data.nome_categorias) {
            $(".categoria-atual").html(data.nome_categorias.join(" | "));
          } else {
            $(".categoria-atual").html("Nossos produtos");
          }

          var produtos = data.produtos || [];
          var total_pages = parseInt(data.total_pages) || 1;
          var current_page = parseInt(data.current_page) || 1;

          var produtosHTML = "";

          $.each(produtos, function (index, projeto) {
            var botao = `
          <div class="btnCTA">
            <a href="${projeto.perma_link}" 
               class="button product_type_simple add_to_cart_button" 
               data-product_id="${projeto.id}">
              Comprar
            </a>
          </div>
        `;

            produtosHTML += `
          <div class='card-produto' data-id='${projeto.id}'>
            <a href='${projeto.perma_link}' class='img-produto'>
              <img src='${projeto.imagem_url}' />
            </a>
            <h1>${projeto.nome}</h1>
            <p class='parcela-personalizada'>a partir de</p>
            <h3 class='preco-regular'>${projeto.preco_regular}</h3>
            <p class='parcela-personalizada'>${projeto.parcelamento}</p>
            <div class='footer-card-product'>
              ${botao}
            </div>
          </div>
        `;
          });

          if (produtosHTML.length > 0) {
            $(".content-produtos").html(
              `<div class="produtos-listagem">${produtosHTML}</div>`,
            );

            montarPaginacao(
              total_pages,
              current_page,
              selecionados,
              searchText,
              order,
              destaque,
              promo,
            );
          } else {
            $(".content-produtos").html(
              '<p class="msg-alert">Nenhum produto encontrado.</p>',
            );

            $(".produtos-content-listagem .paginacao").remove();
          }
        },
      });
    }

    function montarPaginacao(
      total_pages,
      current_page,
      categorias,
      searchText,
      order,
      destaque,
      promo,
    ) {
      if (total_pages <= 1) return;

      var pagHTML = '<div class="paginacao">';
      const maxVisiveis = 2;

      let inicio = Math.max(1, current_page - maxVisiveis);
      let fim = Math.min(total_pages, current_page + maxVisiveis);

      if (current_page > 1) {
        pagHTML += `<a href="#" data-page="${current_page - 1}" class="pagina-link">&laquo;</a>`;
      }

      if (inicio > 1) {
        pagHTML += `<a href="#" data-page="1" class="pagina-link">1</a>`;
        if (inicio > 2) pagHTML += `<span class="dots">...</span>`;
      }

      for (let i = inicio; i <= fim; i++) {
        pagHTML += `
      <a href="#" 
         data-page="${i}" 
         class="pagina-link ${i === current_page ? "active" : ""}">
         ${i}
      </a>
    `;
      }

      if (fim < total_pages) {
        if (fim < total_pages - 1) {
          pagHTML += `<span class="dots">...</span>`;
        }
        pagHTML += `<a href="#" data-page="${total_pages}" class="pagina-link">${total_pages}</a>`;
      }

      if (current_page < total_pages) {
        pagHTML += `<a href="#" data-page="${current_page + 1}" class="pagina-link">&raquo;</a>`;
      }

      pagHTML += "</div>";

      $(".produtos-content-listagem .paginacao").remove();
      $(".content-produtos").after(pagHTML);

      // EVENTO ÚNICO E CORRETO
      $(".pagina-link")
        .off("click")
        .on("click", function (e) {
          e.preventDefault();

          const paginaSelecionada = parseInt($(this).data("page"));

          getProdutosCategoriaBarraLateral(
            categorias,
            searchText,
            order,
            paginaSelecionada,
            destaque,
            promo,
          );
        });
    }
  });
});
