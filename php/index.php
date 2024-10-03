<?php
session_start();


// Connect to database
$db = new mysqli("34.173.30.56", "root", "nemra26", "mysite");

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

if (isset($_POST['login_btn'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepared statement to prevent SQL injection
    $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify hashed password
        if (password_verify($password, $user['password'])) {
            // Regenerate session ID to prevent session fixation
            session_regenerate_id(true);
            // $_SESSION['message'] = "You are now Logged In";
            $_SESSION['username'] = $username;

            // Redirect based on role
            if ($username === 'admin') {
                header("location:../admin/admin.html");
            } else {
                header("location:../user/index.html");
            }
            exit();
        } else {
            $_SESSION['message'] = "Invalid username or password.";
        }
    } else {
        $_SESSION['message'] = "User not found.";
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
