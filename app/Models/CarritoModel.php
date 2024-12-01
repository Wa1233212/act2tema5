<?php

namespace App\Models;

class CarritoModel extends Model
{
    protected $table = 'carrito';

    public function obtenerCarritoPorUsuario($idUsuario)
    {
        return $this->where('id_usuario', '=', $idUsuario)->get();
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

    public function vaciarCarrito($idUsuario)
    {
        $this->where('id_usuario', '=', $idUsuario)->delete();
    }
}
