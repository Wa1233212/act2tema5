<?php
session_start(); 
use App\Models\UsuarioModel;
use App\Models\CarritoModel;

// Instanciar modelos
$usuarioModel = new UsuarioModel();
$carritoModel = new CarritoModel();

// Manejar Formulario
try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['login'])) {
            handleLogin($usuarioModel);
        }

        if (isset($_POST['registrar'])) {
            handleRegister($usuarioModel);
        }
    }

    if (isset($_GET['logout'])) {
        handleLogout();
    }
} catch (Exception $e) {
    echo "Ocurrió un error: " . $e->getMessage();
}

// Función para manejar login
function handleLogin($usuarioModel) {
    $correo = trim($_POST['correo']);
    $contrasena = $_POST['contrasena'];

    if (empty($correo) || empty($contrasena)) {
        echo "Por favor, complete todos los campos.";
        return;
    }

    $usuario = $usuarioModel->obtenerPorCorreo($correo);
    if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nombre'] = $usuario['nombre'];
        header('Location: /home');
        exit();
    } else {
        echo "Credenciales incorrectas.";
    }
}

// Función para manejar registro
function handleRegister($usuarioModel) {
    $nombre = htmlspecialchars(trim($_POST['nombre']));
    $correo = htmlspecialchars(trim($_POST['correo']));
    $contrasena = $_POST['contrasena'];

    if (empty($nombre) || empty($correo) || empty($contrasena)) {
        echo "Por favor, complete todos los campos.";
        return;
    }

    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        echo "El correo no es válido.";
        return;
    }

    $contrasenaHashed = password_hash($contrasena, PASSWORD_DEFAULT);

    // Verificar si el correo ya existe
    $usuarioExistente = $usuarioModel->obtenerPorCorreo($correo);
    if ($usuarioExistente) {
        echo "El correo ya está registrado.";
        return;
    }

    // Registrar usuario
    try {
        $usuarioModel->create([
            'nombre' => $nombre,
            'correo' => $correo,
            'contrasena' => $contrasenaHashed,
        ]);

        echo "Usuario registrado correctamente. Por favor, <a>inicie sesión.</a>";
    } catch (Exception $e) {
        echo "Error al registrar usuario: " . $e->getMessage();
    }
}

// Función para manejar logout
function handleLogout() {
    session_destroy();
    header('Location: /home');
    exit();
}
?>
