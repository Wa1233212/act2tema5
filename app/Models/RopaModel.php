<?php

namespace App\Models;

class RopaModel extends ProductoModel
{
    protected $table = 'ropa';

    public function mostrarDescripcion(int $id): string
    {
        $ropa = $this->find($id);
        if (!$ropa) {
            return "Ropa no encontrada.";
        }

        return "Ropa: {$ropa['nombre']}, Precio: {$ropa['precio']}, Talla: {$ropa['talla']}";
    }

    public function buscarPorTalla(string $talla)
    {
        return $this->where('talla', '=', $talla)->get();
    }
}
