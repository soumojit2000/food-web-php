<?php

session_start();
session_unset();
session_destroy();

session_start();
$_SESSION['success_msg'] = "Logged out successfully";

header("Location: login.php");
exit();


?>