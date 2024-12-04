<?php

session_start();

use App\Models\CarritoModel;

// Crear una instancia de CarritoModel
$carritoModel = new CarritoModel();

// Agregar Producto al Carrito
if (isset($_POST['agregar_carrito'])) {
    $idProducto = $_POST['id_producto'];
    $cantidad = $_POST['cantidad'];

    if (isset($_SESSION['usuario_id'])) {
        $carritoModel->agregarAlCarrito($_SESSION['usuario_id'], $idProducto, $cantidad);
        echo "Producto agregado al carrito.";
        header('Location: /home');
    } else {
        echo "Por favor, inicie sesión para agregar productos al carrito.";
    }
}

