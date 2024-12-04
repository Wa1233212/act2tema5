<?php

namespace App\Models;

class CarritoModel extends Model
{
    protected $table = 'carrito';

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

        public function agregarAlCarrito($idUsuario, $idProducto, $cantidad)
        {
            // Verificar si el producto ya existe en el carrito
            $productoExistente = $this->where('id_usuario', '=', $idUsuario)
                                      ->where('id_producto', '=', $idProducto)
                                      ->get();
    
            if (count($productoExistente) > 0) {
                // Actualizar cantidad si ya existe
                $this->update($productoExistente[0]['id'], [
                    'cantidad' => $productoExistente[0]['cantidad'] + $cantidad
                ]);
            } else {
                // Agregar nuevo producto al carrito
                $this->create([
                    'id_usuario' => $idUsuario,
                    'id_producto' => $idProducto,
                    'cantidad' => $cantidad
                ]);  
            }
        }     
}
