<?php
// Definições de conexão com o banco de dados LOCALHOST
define('DB_HOST', 'localhost\SQLEXPRESS');
define('DB_NAME', '');
define('DB_USER', '');
define('DB_PASS', '');

// Criando a conexão PDO
try {
  $conn = new PDO("sqlsrv:Server=" . DB_HOST . ";Database=" . DB_NAME, DB_USER, DB_PASS);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo json_encode(['status' => 500, 'message' => "Erro: " . $e->getMessage()]);
  exit; 
}

