<?php

//Carrega o header como JSON
header("Content-Type: application/json");

// Carrega o arquivo config
require_once '../../config/config.php';

// Identifica a ação 
$acao = filter_var($_POST['acao'], FILTER_UNSAFE_RAW);

// Função para cadastrar produtos
if ($acao === 'cadProduto') {

  $tipoproduto = filter_var($_POST['tipoproduto'], FILTER_UNSAFE_RAW);
  $descricaoproduto = filter_var($_POST['descricaoproduto'], FILTER_UNSAFE_RAW);
  $nomeproduto = filter_var($_POST['nomeproduto'], FILTER_UNSAFE_RAW);
  $precoproduto = filter_var($_POST['precoproduto'], FILTER_UNSAFE_RAW);
    
  include_once('../../src/Model/Produto.php');
  $produto = new Produto($conn);
  $ret = $produto->cadProduto($tipoproduto, $descricaoproduto, $nomeproduto, $precoproduto);
  echo json_encode($ret);
  exit();

// Função para listar produtos
} elseif($acao === 'listaProduto'){

  include_once('../../src/Model/Produto.php');
  $listaproduto = new Produto($conn);
  $ret = $listaproduto->listaProduto();
  echo json_encode($ret);
  exit();

// Função para listar os tipos de produtos
} elseif($acao === 'listaTipoProduto'){

  include_once('../../src/Model/Produto.php');
  $tipo = new Produto($conn);
  $ret = $tipo->listaTipoProduto();
  echo json_encode($ret);
  exit();
}