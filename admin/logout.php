<?php session_start();
include "includes/checkAdminInstallation.php";
session_unset(); 
session_destroy(); 

header("Location: login.php");
?>