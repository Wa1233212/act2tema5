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

?>
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
                Producto: <?= $producto['id_producto']; ?><br>
                Cantidad: <?= $producto['cantidad']; ?><br>
            </p>
        <?php endforeach; ?>
    <?php else : ?>
        <p>Tu carrito está vacío.</p>
    <?php endif; ?>
</div>
<button><a href="/login">Iniciar sesión</a></button>
<button ><a href='/register'>Registrarse</a></button>