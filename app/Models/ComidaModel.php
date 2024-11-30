<?php

namespace App\Models;

class ComidaModel extends ProductoModel
{
    protected $table = 'comida';

    public function mostrarDescripcion(int $id): string
    {
        $comida = $this->find($id);
        if (!$comida) {
            return "Comida no encontrada.";
        }

        $fechaCaducidad = (new \DateTime($comida['caducidad']))->format('Y-m-d');
        return "Comida: {$comida['nombre']}, Precio: {$comida['precio']}, Caducidad: {$fechaCaducidad}";
    }

    public function buscarPorFechaCaducidad(string $fecha)
    {
        return $this->where('caducidad', '>=', $fecha)->orderBy('caducidad')->get();
    }
}
