<?php include 'head.php'; ?>
<?php include 'sidebar.php'; ?>
<?php include 'navbar.php'; ?>

<!-- Form Start -->
<div class="container-fluid pt-4 px-4">
  <div class="row g-4">
    <div class="col-sm-12 col-xl-12">
      <div class="bg-light rounded h-100 p-4">
        <h6 class="mb-4">CADASTRO - PRODUTO</h6>
        <form id="frmProduto">
          <label class="col-lg-4 col-form-label fw-bold fs-6 required">Nome</label>
          <input class="form-control mb-3" type="text" id="nomeproduto" name="nomeproduto" placeholder="Nome do produto" aria-label="">
          <label class="col-lg-4 col-form-label fw-bold fs-6 required">Descrição</label>
          <input class="form-control mb-3" type="text" id="descricaoproduto" name="descricaoproduto" placeholder="Descrição do produto" aria-label="">
          <label class="col-lg-4 col-form-label fw-bold fs-6 required">Preço</label>
          <input class="form-control mb-3" type="text" id="precoproduto" name="precoproduto" placeholder="Preço do produto" aria-label="">
          <label class="col-lg-4 col-form-label fw-bold fs-6 required">Tipo</label>
          <select class="form-select" id="tipoproduto" name="tipoproduto" aria-label="">
            <option value="">Selecione um tipo de produto</option>
          </select>
          <p class="mb-3">Obs: se o tipo de produto não estiver na lista, <a href="tipoproduto">clique aqui</a> para cadastrar</p>
          <div class="m-n2">
            <button type="submit" class="btn btn-primary m-2">Salvar</button>
          </div>
        </form>  
      </div>
    </div>
  </div>
</div>
<!-- Form End -->

<!-- Table Start -->
<div class="container-fluid pt-4 px-4">
  <div class="row g-4">
    <div class="col-12">
      <div class="bg-light rounded h-100 p-4">
        <h6 class="mb-4">PRODUTO</h6>
        <div id="lista"></div>
      </div>
    </div>
  </div>
</div>
<!-- Table End -->

<?php include 'footer.php'; ?>

<script src="src/Controller/produto.js"></script>