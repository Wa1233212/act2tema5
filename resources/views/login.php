<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login usuario</title>
</head>
<style>       
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #007BFF;
        color: #333;
    }

    header {
        background-color: #007BFF;
        color: #fff;
        padding: 1rem;
        text-align: center;
    }

    main {
        padding: 2rem;
        max-width: 800px;
        margin: 0 auto;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    h2 {
        color: #007BFF;
    }
    h1{
        color: white;
    }

    section {
        margin-bottom: 2rem;
    }

    .result-box {
        background: #f9f9f9;
        border: 1px solid #ddd;
        padding: 1rem;
        border-radius: 5px;
        margin-top: 1rem;
        overflow: auto;
    }

    pre {
        background: #272727;
        color: #f1f1f1;
        padding: 1rem;
        border-radius: 5px;
        overflow-x: auto;
    }

    .btn {
        display: inline-block;
        background-color: #007BFF;
        color: #fff;
        padding: 0.5rem 1rem;
        text-decoration: none;
        border-radius: 5px;
        margin-top: 1rem;
    }

    .btn:hover {
        background-color: #0056b3;
    }
</style>
<body>
    <main>
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
</main>
</html>