<?php
session_start();
session_destroy();
header('Location: registro_actividad.php');
exit();
?>
