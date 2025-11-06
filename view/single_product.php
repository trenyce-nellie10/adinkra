<?php require_once(__DIR__ . "/../settings/core.php");
$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) { header('Location: all_product.php'); exit; }
require_once('controllers/product_controller.php');
$p = fetch_product_ctr($id);
if (!$p) { echo "Product not found"; exit; }
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title><?php echo htmlspecialchars($p['title']); ?></title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body class="page bg-image">
  <?php include 'nav.php'; ?>
  <main class="center-wrap">
    <div class="card" style="max-width:900px;">
      <div style="display:flex; gap:20px;">
        <div style="flex:1;">
          <img src="<?php echo htmlspecialchars($p['product_image'] ?? 'assets/images/bg.jpg'); ?>" style="width:100%; height:420px; object-fit:cover; border-radius:12px;">
        </div>
        <div style="flex:1;">
          <h1><?php echo htmlspecialchars($p['product_title']); ?></h1>
          <p><strong>Brand:</strong> <?php echo htmlspecialchars($p['brand_name'] ?? ''); ?></p>
          <p><strong>Category:</strong> <?php echo htmlspecialchars($p['cat_name']); ?></p>
          <p><strong>Price:</strong> ₵ <?php echo number_format($p['product_price'],2); ?></p>
          <p><?php echo nl2br(htmlspecialchars($p['product_desc'])); ?></p>
          <p><strong>Keywords:</strong> <?php echo htmlspecialchars($p['product_keywords']); ?></p>
          <button class="btn btn-primary">Add to Cart</button>
        </div>
      </div>
    </div>
  </main>
</body>
</html>
