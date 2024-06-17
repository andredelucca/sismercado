<?php include 'head.php'; ?>
<?php include 'sidebar.php'; ?>
<?php include 'navbar.php'; ?>

<!-- Form Start -->
<div class="container-fluid pt-4 px-4">
  <div class="row g-4">
    <div class="col-sm-6 col-xl-6">
      <div class="bg-light rounded h-100 p-4">
        <h6 class="mb-4">CADASTRO - PEDIDO</h6>
        <form id="frmPedido">
          <label class="col-lg-4 col-form-label fw-bold fs-6 required">Produto</label>
          <select class="form-select" id="produto" name="produto" aria-label="">
            <option value="">Selecione um produto</option>
          </select>
          <p class="mb-3">Obs: se o tipo o produto não estiver na lista, <a href="produto">clique aqui</a> para cadastrar</p>
          <label class="col-lg-4 col-form-label fw-bold fs-6 required">Quantidade</label>
          <input class="form-control mb-3" type="number" id="qtdproduto" name="qtdproduto" placeholder="Quantidade do produto" aria-label="">
          <div class="m-n2">
            <button type="submit" class="btn btn-primary m-2">Adicionar</button>
          </div>
        </form>  
      </div>
    </div>
    <div class="col-sm-6 col-xl-6">
      <div class="bg-light rounded h-100 p-4">
        <h6 class="mb-4">CARRINHO</h6>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Qtd</th>
                <th scope="col">Produto</th>  
                <th scope="col">Valor</th>
                <th scope="col">Imposto</th>
              </tr>
            </thead>
            <tbody id="lista"></tbody>
          </table>
          <div id="totais">
            <p id="totalColuna3"></p>
            <p id="totalColuna4"></p>
          </div>
          <button class="btn btn-primary m-2" id="salvar">Salvar</button>
        </div> 
      </div>
    </div>
  </div>
</div>
<!-- Form End -->

<?php include 'footer.php'; ?>

<script src="src/Controller/pedido.js"></script>