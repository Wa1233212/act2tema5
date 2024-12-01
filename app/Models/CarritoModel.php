<?php

namespace App\Models;

class CarritoModel extends Model
{
    protected $table = 'Carrito';

    // Método para obtener los productos del carrito de un usuario con el precio
    public function obtenerCarritoPorUsuario($usuarioId)
    {
        // Unir la tabla Carrito con la tabla Producto para obtener los precios
        $sql = "SELECT p.nombre, p.precio, c.cantidad, c.id_producto
                FROM {$this->table} c
                JOIN Producto p ON c.id_producto = p.id
                WHERE c.id_usuario = ?";
        $this->query($sql, [$usuarioId], 'i');
        return $this->fetchAll();
    }
        // Método para vaciar el carrito de un usuario
        public function vaciarCarrito($usuarioId)
        {
            $sql = "DELETE FROM {$this->table} WHERE id_usuario = ?";
            $this->query($sql, [$usuarioId], 'i');
        }
}
