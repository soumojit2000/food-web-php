<?php

session_start();

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
    <title>Login page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body class="container py-4">

<?php if($error_msg):?>
    <p class="alert alert-danger"><?=$error_msg?></p>
<?php endif; ?>

<?php if($success_msg):?>
    <p class="alert alert-success"><?=$success_msg?></p>
<?php endif; ?>

<h2>Login:</h2>

<?php
require 'config.php';

if(isset($_POST['login'])){
    $name = trim(mysqli_real_escape_string($conn,$_POST['name']));
    $email = trim(mysqli_real_escape_string($conn,$_POST['email']));
    $password = trim(mysqli_real_escape_string($conn,$_POST['pwd']));

    if($name=="" || $email=="" || $password == ""){
        $_SESSION['error_msg']= "Name,email and password can't be empty!";
        header("Location: login.php");
        exit();
    }

    $sql = "SELECT * FROM users_food WHERE name=? AND email=? LIMIT 1";
    
    $stmt= mysqli_prepare($conn,$sql);

    mysqli_stmt_bind_param($stmt, "ss",$name,$email);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $row = mysqli_fetch_assoc($result);

    if($row){
        if(password_verify($password, $row['password'])){
            $_SESSION['id'] = $row['id'];
            $_SESSION['name'] = $row['name'];

            $_SESSION['success_msg']= "Login successful!";
            header("Location: home.php");
            exit();

        }else{
            $_SESSION['error_msg']= "Password is incorrect";
            header("Location: login.php");
            exit();
        }
        
    }else{
        $_SESSION['error_msg']= "No user found with this name and email";
        header("Location: login.php");
        exit();
    }
}

?>

<form method="post">
    
    <input type="text" name="name" class="form-control" placeholder="Enter your name"><br><br>

    <input type="email" name="email" class="form-control" placeholder="Enter your email"><br><br>

    <input type="password" name="pwd" class="form-control" placeholder="Enter your password"><br><br>

    <input type="submit" value="Login" name="login" class="btn btn-primary">
</form>
    <p>Still not registered? <span><a href="register.php" class="btn btn-success">Register</a></span></p>
</body>
</html>