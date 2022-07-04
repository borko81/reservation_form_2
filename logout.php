<?php
session_start();
unset($_SESSION['validate_user_is_ok']);
header("Location:index.php");
?>