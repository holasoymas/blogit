<?php
session_start();
if (!isset($_SESSION['uid'])) {
  // Redirect to login if no user is logged in
  header('Location: login.html');
  exit();
}
$uid = $_SESSION['uid'];
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Blog Register</title>
  <script>
    const uid = "<?php echo $uid; ?>"; // Embed the PHP session user ID into JavaScript
  </script>
  <link rel="stylesheet" href="backend/public/assets/css/register.css" />
  <script type="module" src="backend/public/assets/js/pages/updateProfile.js"></script>
</head>

<body>
  <div class="login-container">
    <div class="login-form">
      <h2>Login to Your Blog</h2>
      <form id="register-form" method="post">
        <div class="form-group">
          <label for="fname">Firstname:</label>
          <input type="text" id="fname" name="fname" />
          <small class="error-field" id="error-fname"></small>
        </div>
        <div class="form-group">
          <label for="lname">Lastname:</label>
          <input type="text" id="lname" name="lname" />
          <small class="error-field" id="error-lname"></small>
        </div>
        <div class="form-group">
          <label for="dob">Date of Birth:</label>
          <input type="date" id="dob" name="dob" />
          <small class="error-field" id="error-dob"></small>
        </div>
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" id="email" name="email" />
          <small class="error-field" id="error-email"></small>
        </div>
        <div class="form-group">
          <label for="password">Password:</label>
          <input type="password" id="password" name="password" />
          <small class="error-field" id="error-password"></small>
        </div>
        <button type="submit" class="login-btn">Sign up</button>
      </form>
    </div>
  </div>
</body>

</html>
