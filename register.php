<?php
session_start();
require 'config.php';

// FLASH MESSAGES
$error_msg = $_SESSION['error_msg'] ?? "";
$success_msg = $_SESSION['success_msg'] ?? "";

unset($_SESSION['error_msg']);
unset($_SESSION['success_msg']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">

<?php if ($error_msg): ?>
    <div class="alert alert-danger"><?= $error_msg ?></div>
<?php endif; ?>

<?php if ($success_msg): ?>
    <div class="alert alert-success"><?= $success_msg ?></div>
<?php endif; ?>

<h2>Register Form:</h2>

<?php
if(isset($_POST['register'])){

    $name = trim(mysqli_real_escape_string($conn, $_POST['name']));
    $email = trim(mysqli_real_escape_string($conn, $_POST['email']));
    $password = trim(mysqli_real_escape_string($conn, $_POST['password']));

    // CHECK EMPTY
    if($name == "" || $email == "" || $password == ""){
        $_SESSION['error_msg'] = "Name, Email and Password can't be empty!";
        header("Location: register.php");
        exit();
    }

    // CHECK VALID EMAIL
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $_SESSION['error_msg'] = "Please enter a valid email address!";
        header("Location: register.php");
        exit();
    }

    // HASH PASSWORD
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // INSERT
    $sql = "INSERT INTO users_food (name, email, password) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hashed_password);

    $run = mysqli_stmt_execute($stmt);

    if($run){
        $_SESSION['success_msg'] = "Registration successful! Please login.";
        header("Location: login.php");
        exit();
    } else {
        if(mysqli_errno($conn) == 1062){
            $_SESSION['error_msg'] = "This email is already registered!";
        } else {
            $_SESSION['error_msg'] = "Something went wrong!";
        }
        header("Location: register.php");
        exit();
    }
}
?>

<!-- REGISTER FORM -->
<form method="post">

    <div class="form-group">
        <label>Your Name</label>
        <input type="text" class="form-control" name="name" placeholder="Enter your name">
    </div>
    <br>

    <div class="form-group">
        <label>Your Email</label>
        <input type="email" class="form-control" name="email" placeholder="Enter your email">
    </div>
    <br>

    <div class="form-group">
        <label>Your Password</label>
        <input type="password" class="form-control" name="password" placeholder="Enter your password">
    </div>
    <br>

    <button type="submit" class="btn btn-primary" name="register">Register</button>
</form>

<p class="mt-3">
    Already have an account?
    <a href="login.php" class="btn btn-success btn-sm">Login Here</a>
</p>

</body>
</html>
