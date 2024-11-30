<?php

namespace App\Models;

class ElectronicoModel extends ProductoModel
{
    protected $table = 'electronico';

    public function mostrarDescripcion(int $id): string
    {
        $electronico = $this->find($id);
        if (!$electronico) {
            return "Electrónico no encontrado.";
        }

        return "Electrónico: {$electronico['nombre']}, Precio: {$electronico['precio']}, Modelo: {$electronico['modelo']}";
    }

    public function buscarPorModelo(string $modelo)
    {
        return $this->where('modelo', '=', $modelo)->get();
    }
}
