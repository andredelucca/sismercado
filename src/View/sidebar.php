<body>
  <div class="container-xxl position-relative bg-white d-flex p-0">
    <!-- Spinner Start -->
    <div id="spinner"
      class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
      <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </div>
    <!-- Spinner End -->


    <!-- Sidebar Start -->
    <div class="sidebar pe-4 pb-3">
      <nav class="navbar bg-light navbar-light">
        <a href="" class="navbar-brand mx-4 mb-3">
          <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>SOFTEXPERT</h3>
        </a>
        <div class="d-flex align-items-center ms-4 mb-4">
          <div class="position-relative">
            <img class="rounded-circle" src="public/img/user.jpeg" alt="" style="width: 40px; height: 40px;">
            <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1">
            </div>
          </div>
          <div class="ms-3">
            <h6 class="mb-0">André Vicino</h6>
            <span>Admin</span>
          </div>
        </div>
        <div class="navbar-nav w-100">
          <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i
                class="fa fa-laptop me-2"></i>Cadastro</a>
            <div class="dropdown-menu bg-transparent border-0">
              <a href="produto" class="dropdown-item">Produto</a>
              <a href="tipoproduto" class="dropdown-item">Tipo de produto</a>
            </div>
          </div>
          <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i
                class="far fa-file-alt me-2"></i>Venda</a>
            <div class="dropdown-menu bg-transparent border-0">
              <a href="pedido" class="dropdown-item">Pedido</a>
            </div>
          </div>
        </div>
      </nav>
    </div>
    <!-- Sidebar End -->