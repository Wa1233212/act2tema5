<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo usuario</title>
</head>
<body>
<form action="/logeo" method="POST">
    <!-- Formulario de Registro -->
    <h3>Registrar Usuario</h3>
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" required>
    <label for="correo">Correo:</label>
    <input type="email" name="correo" required>
    <label for="contrasena">Contraseña:</label>
    <input type="password" name="contrasena" required>
    <button type="submit" name="registrar">Registrar</button>
</form>
</body>
</html>