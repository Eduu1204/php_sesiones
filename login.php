<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Obtener el contenido privado del usuario desde la base de datos
$user_id = $_SESSION['user_id'];

// Aquí deberías realizar una consulta a la base de datos para obtener la información privada del usuario
// y mostrarla en la página.

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Contenido Privado</title>
</head>
<body>
<h2>Bienvenido al Contenido Privado</h2>
<!-- Mostrar el contenido privado del usuario -->
<p>Contenido privado para el usuario con ID <?php echo $user_id; ?></p>
<p><a href="logout.php">Cerrar sesión</a></p>
</body>
</html>
