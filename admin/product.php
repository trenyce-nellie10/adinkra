<?php
require_once(__DIR__ . "/../core.php");
if (!is_logged_in() || current_user_role() !== 1) { header('Location: ../login.php'); exit; }
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Manage Products - Admin</title>
  <link rel="stylesheet" href="../css/style.css">
  <script defer src="../js/product.js"></script>
</head>
<body class="page">
<div class="nav">
  <div class="brand">Adinkra Shop - Admin</div>
  <div class="nav-actions">
    <a href="../admin/brand.php" class="btn btn-link">Brands</a>
    <a href="../index.php" class="btn btn-link">Home</a>
    <a href="../logout.php" class="btn btn-danger">Logout</a>
  </div>
</div>

<main class="center-wrap">
  <div class="card" style="max-width:880px;">
    <h2>Product (Add / Edit)</h2>
    <form id="productForm">
      <input type="hidden" name="product_id" value="">
      <div style="display:flex; gap:12px;">
        <div style="flex:1;">
          <div class="input-group"><label>Category</label>
            <select name="cat_id" required>
              <?php
                $db = (new DbConnection())->connect();
                $cats = $db->query("SELECT * FROM categories ORDER BY cat_name")->fetchAll(PDO::FETCH_ASSOC);
                foreach($cats as $c) echo "<option value=\"{$c['cat_id']}\">".htmlspecialchars($c['cat_name'])."</option>";
              ?>
            </select>
          </div>
          <div class="input-group"><label>Brand</label>
            <select name="brand_id" required>
              <?php
                $brands = $db->query("SELECT b.brand_id, b.brand_name, c.cat_name FROM brands b JOIN categories c ON b.cat_id=c.cat_id ORDER BY c.cat_name, b.brand_name")->fetchAll(PDO::FETCH_ASSOC);
                foreach($brands as $b) echo "<option value=\"{$b['brand_id']}\">".htmlspecialchars($b['brand_name'].' ('.$b['cat_name'].')')."</option>";
              ?>
            </select>
          </div>
          <div class="input-group"><label>Title</label><input name="title" required></div>
          <div class="input-group"><label>Price</label><input name="price" type="number" step="0.01" required></div>
        </div>

        <div style="flex:1;">
          <div class="input-group"><label>Description</label><textarea name="description" rows="6"></textarea></div>
          <div class="input-group"><label>Keywords</label><input name="keywords"></div>
          <div class="input-group"><label>Image</label>
            <input type="file" id="product_image" accept="image/*">
            <button id="uploadImageBtn" class="btn btn-secondary">Upload Image</button>
            <input type="hidden" id="image_path" name="image_path">
            <img id="preview" src="" alt="preview" style="max-width:100%; margin-top:8px;">
          </div>
        </div>
      </div>

      <button class="btn btn-primary btn-full" type="submit">Save Product</button>
      <div id="productMessage" class="form-message"></div>
    </form>
  </div>
</main>
</body>
</html>
