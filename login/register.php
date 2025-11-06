<!DOCTYPE html>
<html>
<head>
  <title>Register</title>
  <script src="js/register.js"></script>
  <link rel="stylesheet" href="css/style.css">

</head>
<body>
  <h2>Customer Registration</h2>
  <form id="registerForm">
    <input type="text" name="full_name" placeholder="Full Name" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <input type="text" name="country" placeholder="Country" required><br>
    <input type="text" name="city" placeholder="City" required><br>
    <input type="text" name="contact_number" placeholder="Contact Number" required><br>
    <button type="submit">Register</button>
  </form>
  <div id="message"></div>
</body>
</html>
