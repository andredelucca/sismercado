var produto = $('#produto');
var qtdproduto = $('#qtdproduto');
var frmPedido = $('#frmPedido');

// Função para cadastrar pedido
var cadPedido = function () {

  $.ajax({
    url: "src/Controller/pedido.php",
    type: "POST",
    data: {
      acao: "listaPreco",
      produto: $("#produto").val()
    },
    success: function (ret) {
      // Quando a solicitação é bem-sucedida, fecha a mensagem de carregamento
      Swal.close();

      // Verifica se a resposta do servidor é válida
      if (ret && typeof ret === 'object') {

        // Verifica o status da resposta
        if (ret.status == 200) {

          // Seleciona o corpo da tabela
          var tbody = $('#lista');

          // Itera sobre a lista de tipos de produtos
          $.each(ret.itens, function (index, i) {
            // Cria uma nova linha na tabela
            var row = $('<tr></tr>');
            var preco = i.preco.replace(',', '.');
            var tributacao = i.tributacao.replace(',', '.');
            var valorTributo = preco * (tributacao / 100);
            var qtd = qtdproduto.val();

            // Calcula os valores e impostos
            var valorTotalProduto = qtd * preco;
            var impostoTotalProduto = qtd * valorTributo;

            // Adiciona as células com os dados do tipo de produto
            row.append('<td>' + qtd + '</td>');
            row.append('<td>' + i.descricao + '</td>');
            row.append('<td>R$ ' + valorTotalProduto.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + '</td>');
            row.append('<td>R$ ' + impostoTotalProduto.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + '</td>');

            // Adiciona a linha ao corpo da tabela
            tbody.append(row);

            // Chama a função para somar os valores
            somarValores();

          });

          function somarValores() {
            var totalColuna3 = 0;
            var totalColuna4 = 0;

            $('#lista tr').each(function () {
              var valorColuna3 = parseFloat($(this).find('td:nth-child(3)').text().replace('R$', '').replace(',', '.'));
              var valorColuna4 = parseFloat($(this).find('td:nth-child(4)').text().replace('R$', '').replace(',', '.'));

              if (!isNaN(valorColuna3)) {
                totalColuna3 += valorColuna3;
              }
              if (!isNaN(valorColuna4)) {
                totalColuna4 += valorColuna4;
              }
            });

            $('#totalColuna3').text("Total da Compra: R$ " + totalColuna3.toFixed(2).replace('.', ','));
            $('#totalColuna4').text("Total de Impostos: R$ " + totalColuna4.toFixed(2).replace('.', ','));
          }

          // Limpa os campos de entrada
          $('#produto').val('');
          $('#qtdproduto').val('');

        } else {
          Swal.fire({
            icon: "error",
            title: "Erro",
            text: ret.message
          });
        }
      }

      produto.val('');
      qtdproduto.val('');
      atualizarVisibilidadeBotaoSalvar();

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
    url: "src/Controller/pedido.php",
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

          $.each(ret.itens, function (index, i) {

            $("#produto").append($('<option>', { value: i['id_produto'], text: i['descricao'] }));

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

  if ($("#produto").val().trim() === '') {
    errorMessage += '<p><strong>Produto:</strong> O campo está vazio.</p>';
    isValid = false;
  }

  if ($("#qtdproduto").val().trim() === '') {
    errorMessage += '<p><strong>Quantidade do Produto:</strong> O campo está vazio.</p>';
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
    cadPedido();
  }

  return isValid;

};

// Função para verificar se há linhas na tabela para mostrar ou ocultar o botão de enviar pedido
var atualizarVisibilidadeBotaoSalvar = function () {
  var numRows = $('#lista tr').length > 0;

  if (numRows) {
    $('#salvar').show(); // Mostra o botão salvar
  } else {
    $('#salvar').hide(); // Esconde o botão salvar
  }
};

$(document).ready(function () {

  listaProduto();
  atualizarVisibilidadeBotaoSalvar();

  // Enviar o formulário
  frmPedido.submit(function (e) {
    e.preventDefault();
    validarForm();
    return false;
  });


  // Função apara incluir linhas na tabela do carrinho
  $('#salvar').click(function () {
    var itens = [];

    $('#lista tr').each(function () {
      var row = $(this);
      var item = {
        quantidade: row.find('td:nth-child(1)').text(),
        descricao: row.find('td:nth-child(2)').text(),
        preco: row.find('td:nth-child(3)').text().replace('R$', '').trim(),
        imposto: row.find('td:nth-child(4)').text().replace('R$', '').trim()
      };
      itens.push(item);
    });

    $.ajax({
      url: 'src/Controller/pedido.php',
      method: 'POST',
      contentType: 'application/json',
      data: JSON.stringify({ acao: "salvarPedido", itens: itens }),
      success: function (ret) {

        if (ret.status == 200) {
          Swal.fire({
            icon: "success",
            title: "Sucesso",
            text: "Pedido salvo com sucesso!"
          }).then((result) => {
            // Limpa a lista após o usuário clicar em OK no Swal
            $('#lista').empty();
            $('#totais').empty();
          });
        }
      },
      error: function (xhr, status, error) {
        console.error(error);
        Swal.fire({
          icon: "error",
          title: "Erro",
          text: "Erro ao salvar os dados."
        });
      }
    });
  });

});