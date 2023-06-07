<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <title>Login</title>
  <link href="../css/public.login.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" />
</head>

<body>
  <?php include "../shared/navbar.php"; ?>
  <div class="login">
    <h2>Login</h2>
    <form action="../includes/login.inc.php" method="post">
      <label for="username">
        <i class="fas fa-user"></i>
      </label>
      <input type="text" name="username" placeholder="Username" id="username" required />
      <label for="password">
        <i class="fas fa-lock"></i>
      </label>
      <input type="password" name="password" placeholder="Password" id="password" required />

      <?php
      if (isset($_GET["error"])) {
        switch ($_GET["error"]) {
          case "invalidcredentials":
            echo "<p class=error>Invalid Credentials</p>";
            break;
          default:
            break;
        }
      }
      ?>
      <div class="register-ask">
        <span class="register-ask-span">Need an account?</span>
        <a href="./register.php" class="register-ask-link">Register</a>
      </div>
      <input type="submit" value="Login" />
    </form>
  </div>
</body>

</html>