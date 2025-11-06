<?php require_once("core.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Adinkra Shop</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body class="page bg-image">
  <div class="nav">
    <div class="brand">Adinkra Shop</div>
    <div class="nav-actions">
      <?php if (is_logged_in()): ?>
        <span class="greet">Hi, <?php echo htmlspecialchars(current_user_name()); ?></span>
        <?php if (current_user_role() === 1): ?>
          <a href="#" class="btn btn-link">Admin</a>
        <?php endif; ?>
        <a href="logout.php" class="btn btn-danger">Logout</a>
      <?php else: ?>
        <a href="register.php" class="btn btn-secondary">Register</a>
        <a href="login.php" class="btn btn-primary">Login</a>
      <?php endif; ?>
    </div>
  </div>

  <main class="center-wrap">
    <section class="hero card glass">
      <h1 class="hero-title">Fresh Cassava Flour, Seamless Shopping</h1>
      <p class="hero-text">
        A clean MVC e-commerce starter with secure authentication, beautiful UI,
        and room to grow.
      </p>
      <?php if (!is_logged_in()): ?>
        <div class="hero-actions">
          <a class="btn btn-primary" href="register.php">Get Started</a>
          <a class="btn btn-link" href="login.php">I already have an account</a>
        </div>
      <?php else: ?>
        <div class="hero-actions">
          <a class="btn btn-primary" href="#">Shop Now</a>
        </div>
      <?php endif; ?>
    </section>
  </main>
</body>
</html>
