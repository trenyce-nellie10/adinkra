<?php
require_once(__DIR__ . "/../core.php");
if (!is_logged_in() || current_user_role() !== 1) { header('Location: ../login.php'); exit; }
require_once(__DIR__ . "/../controllers/brand_controller.php");
require_once(__DIR__ . "/../controllers/product_controller.php");
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Manage Brands - Admin</title>
  <link rel="stylesheet" href="../css/style.css">
  <script defer src="../js/brand.js"></script>
</head>
<body class="page">
  <div class="nav">
    <div class="brand">Adinkra Shop - Admin</div>
    <div class="nav-actions">
      <a href="../index.php" class="btn btn-link">Home</a>
      <a href="../admin/product.php" class="btn btn-secondary">Products</a>
      <a href="../logout.php" class="btn btn-danger">Logout</a>
    </div>
  </div>

  <main class="center-wrap">
    <div class="card" style="max-width:900px;">
      <h2>Brand Management</h2>
      <div style="display:flex; gap:20px;">
        <form id="brandAddForm" style="flex:1;">
          <div class="input-group"><label>Brand name</label><input name="brand_name" required></div>
          <div class="input-group"><label>Category</label>
            <select name="cat_id" required>
              <?php
              // list categories
              require_once(__DIR__ . "/../db/db_connection.php");
              $db = (new DbConnection())->connect();
              $stmt = $db->query("SELECT * FROM categories ORDER BY cat_name");
              foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $c){
                echo "<option value=\"{$c['cat_id']}\">".htmlspecialchars($c['cat_name'])."</option>";
              }
              ?>
            </select>
          </div>
          <button class="btn btn-primary" type="submit">Add Brand</button>
          <div id="brandMessage" class="form-message"></div>
        </form>

        <div style="flex:1;">
          <h3>Existing Brands</h3>
          <div id="brandsList"></div>
        </div>
      </div>
    </div>
  </main>
</body>
</html>
