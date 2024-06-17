<?php
class Pedido
{

  private $conn;
    
  public function __construct($conn) {
    $this->conn = $conn;
  }

  // Método para criar um id para o pedido
  public function criarPedidoId() {
    try {   
      $query = "INSERT INTO mercado.gerarpedidoid (data_inclusao) VALUES (GETDATE())";
      $stmt = $this->conn->prepare($query);

      if ($stmt->execute()) {
          return (int) $this->conn->lastInsertId(); // Retorna o último ID inserido
      } else {
          return false;
      }
    } catch (PDOException $e) {
        return "Erro: " . $e->getMessage();
    }
  }

  // Método para salvar o pedido
  public function salvarPedido($pedidoId, $quantidade, $descricao, $preco, $imposto){
      
    try {

      $query = "INSERT INTO mercado.pedido (pedido_id, qtd, produto, valor, imposto) VALUES (:pedido_id, :qtd, :produto, :valor, :imposto)";
      $stmt = $this->conn->prepare($query);
      
      // Bind parameters
      $stmt->bindParam(':pedido_id', $pedidoId, PDO::PARAM_INT);
      $stmt->bindParam(':qtd', $quantidade, PDO::PARAM_INT);
      $stmt->bindParam(':produto', $descricao, PDO::PARAM_STR);
      $stmt->bindParam(':valor', $preco, PDO::PARAM_STR);
      $stmt->bindParam(':imposto', $imposto, PDO::PARAM_STR);

      // Execute the query
      if ($stmt->execute()) {
        return ["status" => 200, "message" => "Pedido cadastrado com sucesso."];
      } else {
        return ["status" => 500, "message" => "Erro ao cadastrar o pedido."];
      }
    } catch (PDOException $e) {
      return "Erro: " . $e->getMessage();
    }

  }

}