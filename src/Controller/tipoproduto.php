<?php

//Carrega o header como JSON
header("Content-Type: application/json");

// Carrega o arquivo config
require_once '../../config/config.php';

// Identifica a ação 
$acao = filter_var($_POST['acao'], FILTER_UNSAFE_RAW);

// Função para cadastrar os tipos de produtos
if ($acao === 'cadTipoProduto') {

  $tipoproduto = filter_var($_POST['tipoproduto'], FILTER_UNSAFE_RAW);
  $descricaotipo = filter_var($_POST['descricaotipo'], FILTER_UNSAFE_RAW);
  $imposto = filter_var($_POST['imposto'], FILTER_UNSAFE_RAW);
    
  include_once('../../src/Model/Produto.php');
  $tipo = new Produto($conn);
  $ret = $tipo->cadTipoProduto($tipoproduto, $descricaotipo, $imposto);
  echo json_encode($ret);
  exit();

// // Função para listar os tipos de produtos
} elseif($acao === 'listaTipoProduto'){

  include_once('../../src/Model/Produto.php');
  $tipo = new Produto($conn);
  $ret = $tipo->listaTipoProduto();
  echo json_encode($ret);
  exit();

}