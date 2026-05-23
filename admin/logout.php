<?php
// Cerrar sesion administrador

session_start();
session_destroy();
header("Location: login.php");
exit();
?>