<?php include 'head.php'; ?>
<?php include 'sidebar.php'; ?>
<?php include 'navbar.php'; ?>

<!-- Form Start -->
<div class="container-fluid pt-4 px-4">
  <div class="row g-4">
    <div class="col-sm-12 col-xl-12">
      <div class="bg-light rounded h-100 p-4">
        <h6 class="mb-4">CADASTRO - TIPO DE PRODUTO</h6>
        <form id="frmTipoProduto">
          <label class="col-lg-4 col-form-label fw-bold fs-6 required">Tipo</label>
          <input class="form-control mb-3" type="text" id="tipoproduto" name="tipoproduto" placeholder="Tipo de produto" aria-label="">
          <label class="col-lg-4 col-form-label fw-bold fs-6 required">Descrição</label>
          <input class="form-control mb-3" type="text" id="descricaotipo" name="descricaotipo" placeholder="Descrição do tipo de produto" aria-label="">
          <label class="col-lg-4 col-form-label fw-bold fs-6 required">Imposto</label>
          <input class="form-control mb-3" type="text" id="imposto" name="imposto" placeholder="Imposto sobre produtos" aria-label="">
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
        <h6 class="mb-4">TIPO DE PRODUTO</h6>
        <div id="lista"></div>
      </div>
    </div>
  </div>
</div>
<!-- Table End -->

<?php include 'footer.php'; ?>

<script src="src/Controller/tipoproduto.js"></script>