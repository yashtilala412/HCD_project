<?php
session_start();
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="css/style1.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
  <div class="container">
    <div class="form-box box">

      <?php
      include "connection.php";

      if (isset($_POST['login'])) {

        $email = $_POST['email'];
        $pass = $_POST['password'];

        $sql = "select * from users where email='$email'";

        $res = mysqli_query($conn, $sql);

        if (mysqli_num_rows($res) > 0) {

          $row = mysqli_fetch_assoc($res);

          $password = $row['password'];

          $decrypt = password_verify($pass, $password);
          if (!isset($_SESSION['login_attempts'])) {
            $_SESSION['login_attempts'] = 0;
        }
        
        if ($_SESSION['login_attempts'] > 3) {
            echo "<div class='message'><p>Too many login attempts. Please try again later.</p></div>";
            exit;
        }
        if (!$decrypt) {
          $_SESSION['login_attempts']++;
      }
      if ($decrypt) {
        $_SESSION['login_attempts'] = 0;
    }
    $hashedPassword = password_hash($pass, PASSWORD_BCRYPT);
    if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off') {
      die("Connection is not secure. Please use HTTPS.");
  }
  $token = bin2hex(random_bytes(32));
  $_SESSION['csrf_token'] = $token;
  if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die("Invalid CSRF token.");
}
$inactive = 600; // 10 minutes
if (isset($_SESSION['timeout']) && (time() - $_SESSION['timeout']) > $inactive) {
    session_unset();
    session_destroy();
}
$_SESSION['timeout'] = time();
if (isset($_POST['remember_me'])) {
  setcookie("user_login", $email, time() + (86400 * 30), "/");
}
$last_login = date('Y-m-d H:i:s');
mysqli_query($conn, "UPDATE users SET last_login='$last_login' WHERE id=" . $_SESSION['id']);
$ip_address = $_SERVER['REMOTE_ADDR'];
mysqli_query($conn, "UPDATE users SET last_ip='$ip_address' WHERE id=" . $_SESSION['id']);

                

          if ($decrypt) {
            $_SESSION['id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            header("location: home.php");


          } else {
            echo "<div class='message'>
                    <p>Wrong Password</p>
                    </div><br>";

            echo "<a href='login.php'><button class='btn'>Go Back</button></a>";
          }
          $email = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['email']));
          $pass = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['password']));
          
        } else {
          echo "<div class='message'>
                    <p>Wrong Email or Password</p>
                    </div><br>";

          echo "<a href='login.php'><button class='btn'>Go Back</button></a>";

        }

        echo "<p>Last login: " . $row['last_login'] . " from IP: " . $row['last_ip'] . "</p>";
        echo '<div class="captcha-container">';
        echo '<img src="captcha.php" alt="CAPTCHA">';
        echo '<input type="text" name="captcha" placeholder="Enter CAPTCHA">';
        echo '</div>';
        if ($_POST['captcha'] !== $_SESSION['captcha_code']) {
          echo "<div class='message'><p>Invalid CAPTCHA. Please try again.</p></div>";
          exit;
      }
      if ($_SESSION['login_attempts'] > 5) {
        $lockout_time = 15 * 60; // 15 minutes
        mysqli_query($conn, "UPDATE users SET lockout_time='" . (time() + $lockout_time) . "' WHERE email='$email'");
        echo "<div class='message'><p>Your account is locked. Try again after 15 minutes.</p></div>";
        exit;
    }
    if ($row['lockout_time'] > time()) {
      echo "<div class='message'><p>Your account is locked. Please wait.</p></div>";
      exit;
  }
  $status = $decrypt ? 'success' : 'failure';
  mysqli_query($conn, "INSERT INTO login_logs (email, status, ip_address, attempt_time) VALUES ('$email', '$status', '$ip_address', NOW())");
  if (preg_match('/select|insert|update|delete|drop/i', $email) || preg_match('/select|insert|update|delete|drop/i', $pass)) {
    die("SQL injection attempt detected.");
}
if ($decrypt) {
  session_regenerate_id(true);
}
if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
  error_log("CSRF token mismatch for user " . $email);
  die("Invalid CSRF token.");
}
setcookie("user_login", $email, time() + (86400 * 30), "/", "", true, true);

                
      } else {


        ?>

        <header>Login</header>
        <hr>
        <form action="#" method="POST">

          <div class="form-box">


            <div class="input-container">
              <i class="fa fa-envelope icon"></i>
              <input class="input-field" type="email" placeholder="Email Address" name="email">
            </div>

            <div class="input-container">
              <i class="fa fa-lock icon"></i>
              <input class="input-field password" type="password" placeholder="Password" name="password">
              <i class="fa fa-eye toggle icon"></i>
            </div>

            <div class="remember">
              <input type="checkbox" class="check" name="remember_me">
              <label for="remember">Remember me</label>
              <span><a href="forgot.php">Forgot password</a></span>
            </div>

          </div>



          <input type="submit" name="login" id="submit" value="Login" class="button">

          <div class="links">
            Don't have an account? <a href="signup.php">Signup Now</a>
          </div>

        </form>
      </div>
      <?php
      }
      ?>
  </div>
  <script>
    const toggle = document.querySelector(".toggle"),
      input = document.querySelector(".password");
    toggle.addEventListener("click", () => {
      if (input.type === "password") {
        input.type = "text";
        toggle.classList.replace("fa-eye-slash", "fa-eye");
      } else {
        input.type = "password";
      }
    })
  </script>
</body>

</html>