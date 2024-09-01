<?php
session_start();

include("connection.php");

if (!isset($_SESSION['username'])) {
    header("location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style1.css">
</head>

<body>

    <div class="container">
        <div class="form-box box">

            <?php

            if (isset($_POST['update'])) {
                $username = $_POST['username'];
                $email = $_POST['email'];
                $password = $_POST['password'];

                $id = $_SESSION['id'];
                $edit_query = mysqli_query($conn, "UPDATE users SET username='$username', email='$email', password='$password' WHERE id = $id");
                if (isset($_POST['update'])) {
                    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
                    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
                    $password = mysqli_real_escape_string($conn, trim($_POST['password']));
                
                    // ... rest of the code
                }
                if (isset($_POST['update'])) {
                    // ... previous code
                    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                
                    $edit_query = mysqli_query($conn, "UPDATE users SET username='$username', email='$email', password='$hashed_password' WHERE id = $id");
                
                    // ... rest of the code
                }
                if ($edit_query) {
                    echo "<div class='message success'><p>Profile Updated!</p></div><br>";
                } else {
                    echo "<div class='message error'><p>Error updating profile. Please try again.</p></div><br>";
                }
                $check_email_query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND id != $id");
                if (mysqli_num_rows($check_email_query) > 0) {
                    echo "<div class='message error'><p>Email already exists. Please use a different email.</p></div><br>";
                } else {
                    // Proceed with the update
                }
                $username = trim($username);
$email = trim($email);
$password = trim($password);
session_start();
$token = bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;

echo "<input type='hidden' name='csrf_token' value='$token'>";
                                                                
                if ($edit_query) {
                    echo "<div class='message'>
                <p>Profile Updated!</p>
                </div><br>";
                    echo "<a href='home.php'><button class='btn'>Go Home</button></a>";
                }
            } else {

                $id = $_SESSION['id'];
                $query = mysqli_query($conn, "SELECT * FROM users WHERE id = $id") or die("error occurs");

                while ($result = mysqli_fetch_assoc($query)) {
                    $res_username = $result['username'];
                    $res_email = $result['email'];
                    $res_password = $result['password'];
                    $res_id = $result['id'];
                }

                ?>

                <header>Change Profile</header>
                <form action="#" method="POST" enctype="multipart/form-data">

                    <div class="form-box">

                        <div class="input-container">
                            <i class="fa fa-user icon"></i>
                            <input class="input-field" type="text" placeholder="Username" name="username"
                                value="<?php echo $res_username; ?>" required>
                        </div>

                        <div class="input-container">
                            <i class="fa fa-envelope icon"></i>
                            <input class="input-field" type="email" placeholder="Email Address" name="email"
                                value="<?php echo $res_email; ?>" required>
                        </div>

                        <div class="input-container">
                            <i class="fa fa-lock icon"></i>
                            <input class="input-field password" type="password" placeholder="Password" name="password"
                                value="<?php echo $res_password; ?>" required>
                            <i class="fa fa-eye toggle icon"></i>
                        </div>

                    </div>


                    <div class="field">
                        <input type="submit" name="update" id="submit" value="Update" class="btn">
                    </div>


                </form>
            </div>
        <?php } ?>
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