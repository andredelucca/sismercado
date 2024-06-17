<?php
use PHPUnit\Framework\TestCase;

require_once 'src/Model/Pedido.php';

class PedidoTest extends TestCase
{

  private $conn;
  private $pedido;

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
        $this->pedido = new Pedido($this->conn);
    } catch (PDOException $e) {
        $this->fail("Erro na conexão com o banco de dados: " . $e->getMessage());
    }
  }

  protected function tearDown(): void
  {

    // Desconectando e limpando os recursos após cada teste
    $this->conn = null;
    $this->pedido = null;

  }

  public function testCriarPedidoId()
  {
    // Teste de criação de ID de pedido
    $pedidoId = $this->pedido->criarPedidoId();
    error_log("Pedido ID criado: " . $pedidoId);
    $this->assertIsInt($pedidoId);
    $this->assertGreaterThan(0, $pedidoId);

    // Excluir o pedido criado para limpeza do banco de dados
    $queryDelete = "DELETE FROM mercado.gerarpedidoid WHERE pedido_id = :id";
    $stmtDelete = $this->conn->prepare($queryDelete);
    $stmtDelete->bindParam(':id', $pedidoId, PDO::PARAM_INT);
    $stmtDelete->execute();
  }

  public function testSalvarPedido()
  {
    // Criar um ID de pedido para usar no teste
    $pedidoId = $this->pedido->criarPedidoId();
    error_log("Pedido ID criado para salvar pedido: " . $pedidoId);
    $quantidade = 5;
    $descricao = 'Produto Teste';
    $preco = 100.0;
    $imposto = 10.0;

    // Teste de inserção bem-sucedida de pedido
    $result = $this->pedido->salvarPedido($pedidoId, $quantidade, $descricao, $preco, $imposto);
    error_log("Resultado do teste de inserção bem-sucedida: " . json_encode($result));
    $this->assertEquals(200, $result['status']);
    $this->assertEquals('Pedido cadastrado com sucesso.', $result['message']);

    // Excluir o pedido criado para limpeza do banco de dados
    $queryDelete = "DELETE FROM mercado.pedido WHERE pedido_id = :pedido_id";
    $stmtDelete = $this->conn->prepare($queryDelete);
    $stmtDelete->bindParam(':pedido_id', $pedidoId, PDO::PARAM_INT);
    $stmtDelete->execute();

    // Excluir o ID de pedido gerado
    $queryDeleteId = "DELETE FROM mercado.gerarpedidoid WHERE pedido_id = :id";
    $stmtDeleteId = $this->conn->prepare($queryDeleteId);
    $stmtDeleteId->bindParam(':id', $pedidoId, PDO::PARAM_INT);
    $stmtDeleteId->execute();
  }

}

