<?php

namespace App\Models;

class ProductoModel extends Model
{
    protected $table = 'productos';

    public function calcularPrecioConIVA(float $precio): float
    {
        $iva = 0.21;
        return $precio * (1 + $iva);
    }

    public function aplicarDescuento(int $id, float $porcentaje): bool
    {
        $producto = $this->find($id);
        if (!$producto) {
            return false;
        }

        $nuevoPrecio = $producto['precio'] - ($producto['precio'] * ($porcentaje / 100));
        return $this->update($id, ['precio' => $nuevoPrecio]) !== false;
    }

    public function mostrarDescripcion(int $id): string
    {
        $producto = $this->find($id);
        if (!$producto) {
            return "Producto no encontrado.";
        }

        return "Producto: {$producto['nombre']}, Precio: {$producto['precio']}";
    }
}
