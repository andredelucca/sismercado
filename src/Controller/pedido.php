<?php

// Carrega o header como JSON
header("Content-Type: application/json");

// Carrega o arquivo config
require_once '../../config/config.php';

// Recebe e decodifica os dados JSON enviados
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Identifica a ação 
if (isset($data['acao'])) {
  $acao = filter_var($data['acao'], FILTER_UNSAFE_RAW);
} else {
  $acao = filter_var($_POST['acao'] ?? null, FILTER_UNSAFE_RAW);
}

// Ação de listar os preços 
if ($acao === 'listaPreco') {
   $id_produto = filter_var($_POST['produto'], FILTER_UNSAFE_RAW);
   
  include_once('../../src/Model/Produto.php');
  $preco = new Produto($conn);
  $ret = $preco->listaPreco($id_produto);
  echo json_encode($ret);
  exit();

// Ação de listar os produtos 
} elseif($acao === 'listaProduto'){

  include_once('../../src/Model/Produto.php');
  $produto = new Produto($conn);
  $ret = $produto->listaProduto();
  echo json_encode($ret);
  exit();

// Ação de salvar o pedido no banco
} elseif($acao === 'salvarPedido'){
  
  include_once('../../src/Model/Pedido.php');

  if(isset($data['itens']) && is_array($data['itens'])){
    $pedido = new Pedido($conn);
    
    $pedidoId = $pedido->criarPedidoId();
    
    if (!$pedidoId) {
      echo json_encode(['status' => 500, 'message' => 'Erro ao criar o pedido principal.']);
      exit();
    }

    foreach($data['itens'] as $item){
      $quantidade = $item['quantidade'];
      $descricao = $item['descricao'];
      $preco = $item['preco'];
      $imposto = $item['imposto'];

      $ret = $pedido->salvarPedido($pedidoId, $quantidade, $descricao, $preco, $imposto);

    }
    
    echo json_encode($ret);

  } else {
    echo json_encode(['status' => 400, 'message' => 'Dados inválidos.']);
  }
  exit();
}