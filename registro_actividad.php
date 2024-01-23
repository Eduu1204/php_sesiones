<?php
// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recuperar datos del formulario
    $email = $_POST['email'];
    $password = md5($_POST['password']); // Utilizar una función de hash más segura en producción

    // Validar la extensión del archivo
    $allowedExtensions = ['jpg', 'jpeg', 'pdf'];
    $fileExtension = pathinfo($_FILES['archivo']['name'], PATHINFO_EXTENSION);

    if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
        die('Error: Solo se permiten archivos JPG y PDF.');
    }

    // Mover el archivo a la carpeta deseada
    $uploadDirectory = 'uploads/';
    $uploadFilePath = $uploadDirectory . basename($_FILES['archivo']['name']);

    if (move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadFilePath)) {
        // Guardar en la base de datos
        $conn = new mysqli('localhost', 'root', '', 'actividad5');

        if ($conn->connect_error) {
            die('Error de conexión a la base de datos: ' . $conn->connect_error);
        }

        $sql = "INSERT INTO usuarios (email, password, archivo) VALUES ('$email', '$password', '$uploadFilePath')";

        if ($conn->query($sql) === TRUE) {
            // Redirigir al formulario de inicio de sesión
            header('Location: login.php');
            exit();
        } else {
            echo 'Error al insertar en la base de datos: ' . $conn->error;
        }

        $conn->close();
    } else {
        echo 'Error al subir el archivo.';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Registro</title>
</head>
<body>
<h2>Formulario de Registro</h2>
<form action="registro_actividad.php" method="post" enctype="multipart/form-data">
    <label>Email:</label>
    <input type="email" name="email" required><br>

    <label>Contraseña:</label>
    <input type="password" name="password" required><br>

    <label>Archivo (JPG o PDF):</label>
    <input type="file" name="archivo" accept=".jpg, .jpeg, .pdf" required><br>

    <input type="submit" value="Enviar">
</form>
</body>
</html>
