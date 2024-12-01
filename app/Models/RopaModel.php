<?php

namespace App\Models;

class RopaModel extends Model
{
    protected $table = 'ropa';

    public function mostrarDescripcion(int $id): string
    {
        $sql = "SELECT p.nombre, p.precio, r.talla 
                FROM Producto p
                JOIN Ropa r ON p.id = r.id
                WHERE r.id = ?";

        $ropa = $this->query($sql, [$id], 'i')->fetch();

        if (!$ropa) {
            return "Ropa no encontrada.";
        }

        return "Ropa: {$ropa['nombre']}, Precio: {$ropa['precio']}, Talla: {$ropa['talla']}";
    }
}
