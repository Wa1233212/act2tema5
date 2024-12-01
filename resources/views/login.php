<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login usuario</title>
</head>
<body>
<form action="/logeo" method="POST">
    <!-- Formulario de Login -->
    <h3>Iniciar Sesión</h3>
    <label for="correo">Correo:</label>
    <input type="email" name="correo" required>
    <label for="contrasena">Contraseña:</label>
    <input type="password" name="contrasena" required>
    <button type="submit" name="login">Iniciar Sesión</button>
</form>

</body>
</html>