<?php require_once("core.php"); ?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>All Products</title>
  <link rel="stylesheet" href="css/style.css">
  <script>
    async function loadProducts() {
      const res = await fetch('actions/product_actions.php?action=fetch_all');
      const products = await res.json();
      const container = document.getElementById('productGrid');
      container.innerHTML = products.map(p => `
        <div class="card" style="max-width:320px; margin:10px;">
          <img src="${p.image_path || 'assets/images/bg.jpg'}" style="width:100%; height:180px; object-fit:cover; border-radius:10px;">
          <h3>${p.title}</h3>
          <p>${p.brand_name ?? ''} • ${p.cat_name}</p>
          <p>₵ ${parseFloat(p.price).toFixed(2)}</p>
          <a class="btn btn-primary" href="single_product.php?id=${p.product_id}">View</a>
        </div>
      `).join('');
    }
    document.addEventListener('DOMContentLoaded', loadProducts);
  </script>
</head>
<body class="page bg-image">
  <?php include 'nav.php'; // optional nav include ?>
  <main class="center-wrap">
    <section style="max-width:1100px; width:100%;">
      <h2>All Products</h2>
      <div id="productGrid" style="display:flex; flex-wrap:wrap; gap:12px;"></div>
    </section>
  </main>
</body>
</html>
