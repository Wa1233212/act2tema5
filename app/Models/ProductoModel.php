<?php

namespace App\Models;

class ProductoModel extends Model
{
    protected $table = 'producto';

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
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        $producto = $this->query($sql, [$id], 'i')->fetch();

        if (!$producto) {
            return "Producto no encontrado.";
        }

        return "Producto: {$producto['nombre']}, Precio: {$producto['precio']}";
    }

}
