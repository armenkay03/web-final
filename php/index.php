<?php
session_start();
if (isset($_SESSION['username'])) {
    header("location:index.html");
    die();
}
// Connect to database
$db = mysqli_connect("34.173.30.56", "root", "nemra26", "mysite");
if ($db) {
    if (isset($_POST['login_btn'])) {
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $password = mysqli_real_escape_string($db, $_POST['password']);
        $password = md5($password); // Remember we hashed the password before storing last time
        $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $result = mysqli_query($db, $sql);

        if ($result) {
            if (mysqli_num_rows($result) >= 1) {
                $_SESSION['message'] = "You are now Logged In";
                $_SESSION['username'] = $username;

                // Check if the user is admin
                if ($username === 'admin') {
                    header("location:../admin/admin.html");
                } else {
                    header("location:../user/index.html");
                }
                die();
            } else {
                $_SESSION['message'] = "Username and Password combination incorrect";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Portal</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../styles/Login.css">
</head>
<body>

<div class="container">
    <h1 class="page-title">Portal</h1>

    <!-- Flexbox container for both forms -->
    <div class="form-wrapper">
        <!-- Login Form -->
        <div class="form-content">
            <h2>Log In</h2>
            <div class="col-md-12">
                <?php
                if (isset($_SESSION['message'])) {
                    echo "<div id='error_msg'>" . $_SESSION['message'] . "</div>";
                    unset($_SESSION['message']);
                }
                ?>
                <form method="post" action="index.php">
                    <table>
                        <tr>
                            <td>Username:</td>
                            <td><input type="text" name="username" class="textInput" required></td>
                        </tr>
                        <tr>
                            <td>Password:</td>
                            <td><input type="password" name="password" class="textInput" required></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="submit" name="login_btn" value="Log In" class="submit-btn"></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>

        <!-- Register Form -->
        <div class="form-content">
            <h2>Register</h2>
            <div class="col-md-12">
                <?php
                if (isset($_SESSION['message'])) {
                    echo "<div id='error_msg'>" . $_SESSION['message'] . "</div>";
                    unset($_SESSION['message']);
                }
                ?>
                <form method="post" action="register.php">
                    <table>
                        <tr>
                            <td>Username:</td>
                            <td><input type="text" name="username" class="textInput" required></td>
                        </tr>
                        <tr>
                            <td>Email:</td>
                            <td><input type="email" name="email" class="textInput" required></td>
                        </tr>
                        <tr>
                            <td>Password:</td>
                            <td><input type="password" name="password" class="textInput" required></td>
                        </tr>
                        <tr>
                            <td>Password again:</td>
                            <td><input type="password" name="password2" class="textInput" required></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="submit" name="register_btn" value="Register" class="submit-btn"></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>
