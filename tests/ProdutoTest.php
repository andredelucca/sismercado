<?php
use PHPUnit\Framework\TestCase;

require_once 'src/Model/Produto.php';

class ProdutoTest extends TestCase
{

  private $conn;
  private $produto;

  protected function setUp(): void
  {
    // Definições de conexão com o banco de dados para testes
    $db_host = 'localhost\SQLEXPRESS';
    $db_name = ''; 
    $db_user = ''; 
    $db_pass = ''; 

    try {
        // Criando a conexão PDO
        $this->conn = new PDO("sqlsrv:Server=$db_host;Database=$db_name", $db_user, $db_pass);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Instanciando a classe Produto com a conexão criada
        $this->produto = new Produto($this->conn);
    } catch (PDOException $e) {
        $this->fail("Erro na conexão com o banco de dados: " . $e->getMessage());
    }
  }

  protected function tearDown(): void
  {
    // Limpeza dos dados de teste para cadTipoProduto
    $tipoProduto = 'NovoTipo';
    $queryDelete = "DELETE FROM mercado.tipo WHERE tipo = :tipo";
    $stmtDelete = $this->conn->prepare($queryDelete);
    $stmtDelete->bindParam(':tipo', $tipoProduto);
    $stmtDelete->execute();

    // Limpeza dos dados de teste para cadProduto
    $nomeProduto = 'NovoProduto';
    $queryDeleteProduto = "DELETE FROM mercado.produto WHERE produto = :produto";
    $stmtDeleteProduto = $this->conn->prepare($queryDeleteProduto);
    $stmtDeleteProduto->bindParam(':produto', $nomeProduto);
    $stmtDeleteProduto->execute();


    // Desconectando e limpando os recursos após cada teste
    $this->conn = null;
    $this->produto = null;
  }

  public function testCadTipoProduto()
  {
    $tipoProduto = 'NovoTipo';
    $descricaoTipo = 'Descrição do Novo Tipo';
    $imposto = 10.0;

    // Teste de inserção bem-sucedida de tipo de produto
    $result = $this->produto->cadTipoProduto($tipoProduto, $descricaoTipo, $imposto);
    error_log("Resultado do teste de inserção bem-sucedida: " . json_encode($result));
    $this->assertEquals(200, $result['status']);
    $this->assertEquals('Tipo de produto cadastrado com sucesso.', $result['message']);

    // Teste de tipo de produto já existente
    $result = $this->produto->cadTipoProduto($tipoProduto, $descricaoTipo, $imposto); // Tentativa de inserir o mesmo tipo novamente
    error_log("Resultado do teste de tipo de produto já existente: " . json_encode($result));
    $this->assertEquals(400, $result['status']); // Esperamos agora um status 400
    $this->assertEquals('O tipo de produto já existe.', $result['message']);

    // Excluir o tipo de produto criado para limpeza do banco de dados
    $queryDelete = "DELETE FROM mercado.tipo WHERE tipo = :tipo";
    $stmtDelete = $this->conn->prepare($queryDelete);
    $stmtDelete->bindParam(':tipo', $tipoProduto);
    $stmtDelete->execute();
  }
  public function testCadProduto()
  {
    $tipoProduto = 1;  // Supondo que 1 é um ID válido na tabela tipo
    $descricaoProduto = 'Descrição do Novo Produto';
    $nomeProduto = 'NovoProduto';
    $precoProduto = 100.0;

    // Teste de inserção bem-sucedida de produto
    $result = $this->produto->cadProduto($tipoProduto, $descricaoProduto, $nomeProduto, $precoProduto);
    error_log("Resultado do teste de inserção bem-sucedida: " . json_encode($result));
    $this->assertEquals(200, $result['status']);
    $this->assertEquals('Produto cadastrado com sucesso.', $result['message']);

    // Teste de produto já existente
    $result = $this->produto->cadProduto($tipoProduto, $descricaoProduto, $nomeProduto, $precoProduto); // Tentativa de inserir o mesmo produto novamente
    error_log("Resultado do teste de produto já existente: " . json_encode($result));
    $this->assertEquals(400, $result['status']); // Esperamos agora um status 400
    $this->assertEquals('Já existe um produto com um nome similar cadastrado.', $result['message']);

    // Excluir o produto criado para limpeza do banco de dados
    $queryDelete = "DELETE FROM mercado.produto WHERE produto = :produto";
    $stmtDelete = $this->conn->prepare($queryDelete);
    $stmtDelete->bindParam(':produto', $nomeProduto);
    $stmtDelete->execute();
  }

}