<?php

session_start();

use App\Models\RopaModel;
use App\Models\ElectronicoModel;
use App\Models\ComidaModel;
use App\Models\CarritoModel;

// Instanciar el modelo CarritoModel
$carritoModel = new CarritoModel();

// Mostrar Carrito
if (isset($_SESSION['usuario_id'])) {
    $productosEnCarrito = $carritoModel->obtenerCarritoPorUsuario($_SESSION['usuario_id']);
} else {
    $productosEnCarrito = [];
}
// Vaciar Carrito
if (isset($_POST['vaciar_carrito'])) {
    if (isset($_SESSION['usuario_id'])) {
        $carritoModel->vaciarCarrito($_SESSION['usuario_id']);
        echo "Carrito vaciado.";
    } else {
        echo "Por favor, inicie sesión para vaciar el carrito.";
    }
}
?>
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
<main>
<!-- Agregar al Carrito -->
<form action="/home" method="POST">
    <h3>Agregar Producto al Carrito</h3>
    <label for="id_producto">ID del Producto:</label>
    <input type="text" name="id_producto" required>

    <label for="cantidad">Cantidad:</label>
    <input type="number" name="cantidad" min="1" required>

    <button type="submit" name="agregar_carrito">Agregar al Carrito</button>
</form>

<!-- Vaciar Carrito -->
<form action="/home" method="POST">
    <button type="submit" name="vaciar_carrito">Vaciar Carrito</button>
</form>

<!-- Mostrar Carrito -->
<h3>Carrito</h3>
<div class="carrito">
    <?php if (!empty($productosEnCarrito)) : ?>
        <?php foreach ($productosEnCarrito as $producto) : ?>
            <p>
                Producto: <?= $producto['nombre']; ?><br>
                Cantidad: <?= $producto['cantidad']; ?><br>
                Precio: $<?= number_format($producto['precio'], 2); ?><br>
                Total: $<?= number_format($producto['precio'] * $producto['cantidad'], 2); ?><br>
            </p>
        <?php endforeach; ?>
    <?php else : ?>
        <p>Tu carrito está vacío.</p>
    <?php endif; ?>
</div>
<button><a href="/login">Iniciar sesión</a></button>
<button ><a href='/register'>Registrarse</a></button>
</main>
