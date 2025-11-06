<?php require_once("core.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login | Adinkra Shop</title>
  <link rel="stylesheet" href="../css/style.css">
  <script defer src="js/login.js"></script>
</head>
<!-- Add class bg-image if you place assets/images/bg.jpg -->
<body class="page page-auth bg-image">
  <div class="nav">
    <div class="brand">Adinkra Shop</div>
    <div class="nav-actions">
      <a href="index.php" class="btn btn-link">Home</a>
      <a href="register.php" class="btn btn-secondary">Register</a>
    </div>
  </div>

  <main class="center-wrap">
    <form id="loginForm" class="card">
      <h2 class="card-title">Welcome back</h2>
      <p class="card-subtitle">Sign in to continue</p>

      <div class="input-group">
        <label>Email</label>
        <input type="email" name="email" placeholder="you@example.com" required>
      </div>

      <div class="input-group">
        <label>Password</label>
        <input type="password" name="password" placeholder="••••••••" required>
      </div>

      <button id="loginBtn" type="submit" class="btn btn-primary btn-full">Login</button>
      <div id="message" class="form-message"></div>
    </form>
  </main>
</body>
</html>
