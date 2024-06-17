<?php
  
  class Produto
  {
    private $conn;
    
    public function __construct($conn) {
      $this->conn = $conn;
    }
    
    // Método para cadastrar os tipos de produtos
    public function cadTipoProduto($tipoproduto, $descricaotipo, $imposto)
    {
      try {
          // Verifica se o tipo de produto já existe
          $queryCheck = "SELECT COUNT(*) AS total FROM mercado.tipo WHERE tipo LIKE :tipo";
          $stmtCheck = $this->conn->prepare($queryCheck);
          $paramTipo = '%' . $tipoproduto . '%';
          $stmtCheck->bindParam(':tipo', $paramTipo);
          
          // Adiciona log para verificar o valor do parâmetro
          error_log("Verificando existência do tipo de produto: " . $paramTipo);
          
          $stmtCheck->execute();
          $row = $stmtCheck->fetch(PDO::FETCH_ASSOC);
          
          // Adiciona log para verificar o resultado da consulta
          error_log("Resultado da consulta de verificação: " . json_encode($row));

          if ($row['total'] > 0) {
              return ["status" => 400, "message" => "O tipo de produto já existe."];
          }

          // Inserção do tipo de produto
          $query = "INSERT INTO mercado.tipo (tipo, descricao, tributacao) VALUES (:tipo, :descricao, :tributacao)";
          $stmt = $this->conn->prepare($query);

          // Bind parameters
          $stmt->bindParam(':tipo', $tipoproduto);
          $stmt->bindParam(':descricao', $descricaotipo);
          $stmt->bindParam(':tributacao', $imposto);

          // Execute the query
          if ($stmt->execute()) {
              return ["status" => 200, "message" => "Tipo de produto cadastrado com sucesso."];
          } else {
              return ["status" => 500, "message" => "Erro ao cadastrar tipo de produto."];
          }
      } catch (PDOException $e) {
          return "Erro: " . $e->getMessage();
      }
    }

    // Método para cadastrar os produtos
    public function cadProduto($tipoproduto, $descricaoproduto, $nomeproduto, $precoproduto)
    {
      try {
        // Verifica se o produto já existe
        $queryCheck = "SELECT COUNT(*) AS total FROM mercado.produto WHERE produto LIKE :produto";
        $stmtCheck = $this->conn->prepare($queryCheck);

        // Adiciona '%' para buscar produtos que contenham $nomeproduto
        $paramProduto = '%' . $nomeproduto . '%';

        // Adiciona log para verificar o valor do parâmetro
        error_log("Verificando existência do produto: " . $paramProduto);

        $stmtCheck->bindParam(':produto', $paramProduto);
        $stmtCheck->execute();
        $row = $stmtCheck->fetch(PDO::FETCH_ASSOC);

        if ($row['total'] > 0) {
            return ["status" => 400, "message" => "Já existe um produto com um nome similar cadastrado."];
        }

        // Inserção do produto
        $query = "INSERT INTO mercado.produto (produto, descricao, tipo_id, preco) VALUES (:produto, :descricao, :tipo_id, :preco)";
        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':tipo_id', $tipoproduto);
        $stmt->bindParam(':descricao', $descricaoproduto);
        $stmt->bindParam(':produto', $nomeproduto);
        $stmt->bindParam(':preco', $precoproduto);

        // Execute the query
        if ($stmt->execute()) {
            return ["status" => 200, "message" => "Produto cadastrado com sucesso."];
        } else {
            return ["status" => 500, "message" => "Erro ao cadastrar o produto."];
        }
      } catch (PDOException $e) {
          return "Erro: " . $e->getMessage();
      }
    }

    // Método para listar os tipos de produtos
    public function listaTipoProduto()
    {
      try {
        $query = "SELECT * FROM mercado.tipo ORDER BY tipo ASC";
        $stmt = $this->conn->prepare($query);

        // Execute the query
        if ($stmt->execute()) {
          $ret = $stmt->fetchAll(PDO::FETCH_ASSOC);
          return ["status" => 200, "itens" => $ret, "message" => "Tipo de produto listado com sucesso."];
        } else {
          return ["status" => 500, "message" => "Erro ao cadastrar tipo de produto."];
        }
      } catch (PDOException $e) {
        return "Erro: " . $e->getMessage();
      }

    }

    // Método para cadastrar os produtos
    public function listaProduto()
    {
      try {
        $query = "SELECT p.id_produto, p.produto, p.descricao, p.preco, t.tributacao, t.tipo FROM mercado.produto p INNER JOIN mercado.tipo t ON p.tipo_id = t.tipo_id";
        $stmt = $this->conn->prepare($query);

        // Execute the query
        if ($stmt->execute()) {
          $ret = $stmt->fetchAll(PDO::FETCH_ASSOC);
          return ["status" => 200, "itens" => $ret, "message" => "Produto listado com sucesso."];
        } else {
          return ["status" => 500, "message" => "Erro ao cadastrar o produto."];
        }
      } catch (PDOException $e) {
        return "Erro: " . $e->getMessage();
      }

    }

    // Método para cadastrar os preços dos produtos
    public function listaPreco($id_produto)
    {
      try {
        $query = "SELECT p.preco, t.tributacao, p.descricao FROM mercado.produto p INNER JOIN mercado.tipo t ON p.tipo_id = t.tipo_id WHERE P.id_produto = :id_produto";
        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':id_produto', $id_produto);

        // Execute the query
        if ($stmt->execute()) {
          $ret = $stmt->fetchAll(PDO::FETCH_ASSOC);
          return ["status" => 200, "itens" => $ret, "message" => "Preço do produto listado com sucesso."];
        } else {
          return ["status" => 500, "message" => "Erro ao listar o preço do produto."];
        }
      } catch (PDOException $e) {
        return "Erro: " . $e->getMessage();
      }

    }
    
  }