var tipoproduto = $('#tipoproduto');
var imposto = $('#imposto');
var descricaotipo = $("#descricaotipo");
var frmTipoProduto = $('#frmTipoProduto');

// Função para cadastrar tipo de produto
var cadTipoProduto = function () {

  $.ajax({
    url: "src/Controller/tipoproduto.php",
    type: "POST",
    data: {
      acao: "cadTipoProduto",
      tipoproduto: $("#tipoproduto").val(),
      imposto: $("#imposto").val(),
      descricaotipo: $("#descricaotipo").val()
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
              $('#descricaotipo').val('');
              $('#imposto').val('');

              listaTipoProduto();

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

// Função para listar os tipo de produto
var listaTipoProduto = function () {

  $.ajax({
    url: "src/Controller/tipoproduto.php",
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

          // Seleciona o elemento com a ID 'lista'
          var lista = $('#lista');

          // Limpa o conteúdo existente da lista
          lista.empty();

          // Cria a estrutura da tabela
          var table = $('<div class="table-responsive"><table class="table"><thead><tr><th scope="col">Tipo</th><th scope="col">Descrição</th><th scope="col">Tributação</th></tr></thead><tbody></tbody></table></div>');

          // Adiciona a tabela à lista
          lista.append(table);

          // Seleciona o corpo da tabela
          var tbody = table.find('tbody');

          // Itera sobre a lista de tipos de produtos
          $.each(ret.itens, function (index, i) {
            // Cria uma nova linha na tabela
            var row = $('<tr></tr>');

            // Adiciona as células com os dados do tipo de produto
            row.append('<td>' + i.tipo + '</td>');
            row.append('<td>' + i.descricao + '</td>');
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

// Função para validar o formulário
var validarForm = function () {

  var isValid = true;
  var errorMessage = '';

  if ($("#tipoproduto").val().trim() === '') {
    errorMessage += '<p><strong>Tipo de Produto:</strong> O campo está vazio.</p>';
    isValid = false;
  }

  if ($("#descricaotipo").val().trim() === '') {
    errorMessage += '<p><strong>Descrição do Tipo:</strong> O campo está vazio.</p>';
    isValid = false;
  }

  var impostoValue = $("#imposto").val().trim();
  if (impostoValue === '') {
    errorMessage += '<p><strong>Imposto:</strong> O campo está vazio.</p>';
    isValid = false;
  } else if (isNaN(parseFloat(impostoValue))) {
    errorMessage += '<p><strong>Imposto:</strong> O campo Imposto deve conter apenas números.</p>';
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
    cadTipoProduto();
  }

  return isValid;

};

$(document).ready(function () {

  listaTipoProduto();

  // Envio do formulário
  frmTipoProduto.submit(function (e) {
    e.preventDefault();
    validarForm();
    return false;
  });

});