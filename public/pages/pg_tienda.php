<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php';
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tienda | Comunidad de Animales</title>

  <?php require PUBLIC_PAGES_COMPONENTS . 'link-styles.php'; ?>
  <!-- Estilos específicos de la tienda -->
  <link rel="stylesheet" href="<?php echo PUBLIC_STYLES_URL; ?>custom-tienda.css">
</head>

<body id="ContenedorGeneral">

  <!-- Navbar -->
  <?php require PUBLIC_PAGES_COMPONENTS . 'navbar.php'; ?>

  <!-- Hero -->
  <section class="hero d-flex align-items-center">
    <div class="container content py-5">
      <div class="row align-items-center">
        <div class="col-lg-7">
          <h1 class="display-6 fw-bold">Todo para el cuidado y bienestar de tus mascotas</h1>
          <p class="lead mb-4">Alimentos, higiene, juguetes y accesorios. Envíos en el día y promos todas las semanas.</p>
          <div class="d-flex gap-2">
            <a href="#productos" class="btn btn-success btn-lg"><i class="bi bi-bag-check"></i> Ver productos</a>
            <a href="#categorias" class="btn btn-outline-light btn-lg"><i class="bi bi-ui-checks"></i> Categorías</a>
          </div>
        </div>
        <div class="col-lg-5 d-none d-lg-block">
          <div class="chip shadow-sm"><i class="bi bi-truck"></i> Envío gratis desde $25.000</div>
          <div class="chip shadow-sm mt-2"><i class="bi bi-shield-lock"></i> Pagos seguros</div>
          <div class="chip shadow-sm mt-2"><i class="bi bi-stars"></i> Productos seleccionados</div>
        </div>
      </div>
    </div>
  </section>

  <!-- Categorías -->
  <section class="container my-5" id="categorias">
    <h2 class="section-title mb-3">Categorías</h2>
    <div class="row g-3">
      <div class="col-6 col-md-3">
        <div class="card h-100">
          <img src="https://i.imgur.com/24l8qOe.jpeg" class="card-img-top" alt="Alimentos">
          <div class="card-body">
            <h6 class="card-title">Alimentación</h6>
            <button class="btn btn-sm btn-outline-success" onclick="setCategory('Alimentación')">Ver</button>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="card h-100">
          <img src="https://i.imgur.com/2O1v2oC.jpeg" class="card-img-top" alt="Higiene">
          <div class="card-body">
            <h6 class="card-title">Higiene & Cuidado</h6>
            <button class="btn btn-sm btn-outline-success" onclick="setCategory('Higiene')">Ver</button>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="card h-100">
          <img src="https://i.imgur.com/ZC5mZf5.jpeg" class="card-img-top" alt="Juguetes">
          <div class="card-body">
            <h6 class="card-title">Juegos & Juguetes</h6>
            <button class="btn btn-sm btn-outline-success" onclick="setCategory('Juguetes')">Ver</button>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="card h-100">
          <img src="https://i.imgur.com/WxE4F8r.jpeg" class="card-img-top" alt="Accesorios">
          <div class="card-body">
            <h6 class="card-title">Accesorios & Ropa</h6>
            <button class="btn btn-sm btn-outline-success" onclick="setCategory('Accesorios')">Ver</button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Filtros -->
  <section class="container">
    <div class="card border-0 bg-light">
      <div class="card-body d-flex flex-wrap gap-2 align-items-center">
        <div class="input-group" style="max-width: 340px;">
          <span class="input-group-text"><i class="bi bi-search"></i></span>
          <input type="text" class="form-control" id="searchInput" placeholder="Buscar productos..." oninput="renderProducts()">
        </div>
        <select id="categorySelect" class="form-select" style="max-width: 220px;" onchange="renderProducts()">
          <option value="">Todas las categorías</option>
          <option value="Alimentación">Alimentación</option>
          <option value="Higiene">Higiene & Cuidado</option>
          <option value="Juguetes">Juegos & Juguetes</option>
          <option value="Accesorios">Accesorios & Ropa</option>
        </select>
        <select id="sortSelect" class="form-select" style="max-width: 220px;" onchange="renderProducts()">
          <option value="">Ordenar</option>
          <option value="priceAsc">Precio: menor a mayor</option>
          <option value="priceDesc">Precio: mayor a menor</option>
          <option value="nameAsc">Nombre: A-Z</option>
          <option value="nameDesc">Nombre: Z-A</option>
        </select>
      </div>
    </div>
  </section>

  <!-- Productos -->
  <section class="container my-4" id="productos">
    <h2 class="section-title mb-3">Productos</h2>
    <div class="row g-3" id="productGrid"></div>
    <div class="text-center my-4">
      <button class="btn btn-outline-secondary" onclick="loadMore()">Cargar más</button>
    </div>
  </section>

  <!-- Footer -->
  <?php require PUBLIC_PAGES_COMPONENTS . 'footer.php'; ?>
  <?php require PUBLIC_PAGES_COMPONENTS . 'support.php'; ?>

  <!-- Scripts globales -->
  <?php require PUBLIC_PAGES_COMPONENTS . 'src-scripts.php'; ?>
</body>

</html>