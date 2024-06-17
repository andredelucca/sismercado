var tipoproduto = $('#tipoproduto');
var nomeproduto = $('#nomeproduto');
var descricaoproduto = $("#descricaoproduto");
var precoproduto = $("#precoproduto");
var frmProduto = $('#frmProduto');

// Função para cadastrar o produto
var cadProduto = function () {

  $.ajax({
    url: "src/Controller/produto.php",
    type: "POST",
    data: {
      acao: "cadProduto",
      tipoproduto: $("#tipoproduto").val(),
      descricaoproduto: $("#descricaoproduto").val(),
      precoproduto: $("#precoproduto").val(),
      nomeproduto: $("#nomeproduto").val()
    },
    beforeSend: function () {
      // Antes de enviar a solicitação, exibe uma mensagem de carregamento
      Swal.fire({
        title: "Carregando...",
        allowOutsideClick: false,
        didOpen: function () {
          Swal.showLoading();
        }
      });
    },
    success: function (ret) {
      // Quando a solicitação é bem-sucedida, fecha a mensagem de carregamento
      Swal.close();

      // Verifica se a resposta do servidor é válida
      if (ret && typeof ret === 'object') {

        // Verifica o status da resposta
        if (ret.status == 200) {
          // Se for um sucesso, exibe uma mensagem de sucesso
          Swal.fire({
            icon: "success",
            title: "Sucesso",
            text: ret.message,
            didClose: function () {
              // Limpa os campos do formulário ou recarrega a página
              $('#tipoproduto').val('');
              $('#descricaoproduto').val('');
              $('#nomeproduto').val('');
              $('#precoproduto').val('');

              listaProduto();
            }
          });

        } else {
          Swal.fire({
            icon: "error",
            title: "Erro",
            text: ret.message
          });
        }
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      Swal.close();
      Swal.fire({
        icon: "error",
        title: "Erro",
        text: "Ocorreu um erro ao processar a solicitação."
      });
      console.log(textStatus, errorThrown);
    }
  });
};

// Função para listar os produtos
var listaProduto = function () {

  $.ajax({
    url: "src/Controller/produto.php",
    type: "POST",
    data: {
      acao: "listaProduto",
    },
    success: function (ret) {
      // Quando a solicitação é bem-sucedida, fecha a mensagem de carregamento
      Swal.close();

      // Verifica se a resposta do servidor é válida
      if (ret && typeof ret === 'object') {

        // Verifica o status da resposta
        if (ret.status == 200) {

          // Seleciona o elemento com a ID 'lista'
          var lista = $('#lista');

          // Limpa o conteúdo existente da lista
          lista.empty();

          // Cria a estrutura da tabela
          var table = $('<div class="table-responsive"><table class="table"><thead><tr><th scope="col">Produto</th><th scope="col">Descrição</th><th scope="col">Tipo</th><th scope="col">Preço</th><th scope="col">Tributação</th></tr></thead><tbody></tbody></table></div>');

          // Adiciona a tabela à lista
          lista.append(table);

          // Seleciona o corpo da tabela
          var tbody = table.find('tbody');

          // Itera sobre a lista de tipos de produtos
          $.each(ret.itens, function (index, i) {
            // Cria uma nova linha na tabela
            var row = $('<tr></tr>');

            // Adiciona as células com os dados do tipo de produto
            row.append('<td>' + i.produto + '</td>');
            row.append('<td>' + i.descricao + '</td>');
            row.append('<td>' + i.tipo + '</td>');
            row.append('<td>R$ ' + i.preco + '</td>');
            row.append('<td>' + i.tributacao + '%</td>');

            // Adiciona a linha ao corpo da tabela
            tbody.append(row);
          });

        } else {

          Swal.fire({
            icon: "error",
            title: "Erro",
            text: ret.message
          });

        }
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      Swal.close();
      Swal.fire({
        icon: "error",
        title: "Erro",
        text: "Ocorreu um erro ao processar a solicitação."
      });
      console.log(textStatus, errorThrown);
    }
  });
};

// Função para listar os tipos de produtos
var listaTipoProduto = function () {

  $.ajax({
    url: "src/Controller/produto.php",
    type: "POST",
    data: {
      acao: "listaTipoProduto",
    },
    success: function (ret) {
      // Quando a solicitação é bem-sucedida, fecha a mensagem de carregamento
      Swal.close();

      // Verifica se a resposta do servidor é válida
      if (ret && typeof ret === 'object') {

        // Verifica o status da resposta
        if (ret.status == 200) {

          $.each(ret.itens, function (index, i) {

            $("#tipoproduto").append($('<option>', { value: i['tipo_id'], text: i['tipo'] }));

          });

        } else {

          Swal.fire({
            icon: "error",
            title: "Erro",
            text: ret.message
          });

        }
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      Swal.close();
      Swal.fire({
        icon: "error",
        title: "Erro",
        text: "Ocorreu um erro ao processar a solicitação."
      });
      console.log(textStatus, errorThrown);
    }
  });
};

// Função para validar o formulário
var validarForm = function () {

  var isValid = true;
  var errorMessage = '';

  if ($("#nomeproduto").val().trim() === '') {
    errorMessage += '<p><strong>Nome do Produto:</strong> O campo está vazio.</p>';
    isValid = false;
  }

  if ($("#descricaoproduto").val().trim() === '') {
    errorMessage += '<p><strong>Descrição do Produto:</strong> O campo está vazio.</p>';
    isValid = false;
  }

  var precoValue = $("#precoproduto").val().trim();
  if (precoValue === '') {
    errorMessage += '<p><strong>Preço:</strong> O campo está vazio.</p>';
    isValid = false;
  } else if (isNaN(parseFloat(precoValue))) {
    errorMessage += '<p><strong>Preço:</strong> O campo Preço deve conter apenas números.</p>';
    isValid = false;
  }

  if ($("#tipoproduto").val().trim() === '') {
    errorMessage += '<p><strong>Tipo do Produto:</strong> O campo está vazio.</p>';
    isValid = false;
  }

  if (!isValid) {
    Swal.fire({
      icon: 'error',
      title: 'Erro',
      html: errorMessage,
      confirmButtonText: 'OK'
    });
  } else {
    cadProduto();
  }

  return isValid;

};

$(document).ready(function () {

  listaProduto();
  listaTipoProduto();

  // Enviar o formulário
  frmProduto.submit(function (e) {
    e.preventDefault();
    validarForm();
    return false;
  });

});

