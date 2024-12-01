<?php

namespace App\Models;

class ElectronicoModel extends ProductoModel
{
    protected $table = 'electronico';

    public function mostrarDescripcion(int $id): string
    {
        $sql = "SELECT p.nombre, p.precio, e.modelo 
                FROM producto p
                JOIN electronico e ON p.id = e.id
                WHERE e.id = ?";
        $electronico = $this->query($sql, [$id], 'i')->fetch();

        if (!$electronico) {
            return "Electrónico no encontrado.";
        }

        return "Electrónico: {$electronico['nombre']}, Precio: {$electronico['precio']}, Modelo: {$electronico['modelo']}";
    }

    public function buscarPorModelo(string $modelo)
    {
        $sql = "SELECT * FROM {$this->table} WHERE modelo = ?";
        return $this->query($sql, [$modelo], 's')->fetchAll();
    }
        // Método para obtener todos los productos electrónicos
        public function getProductos()
        {
            $sql = "SELECT p.id, p.nombre, p.precio FROM {$this->table} e INNER JOIN Producto p ON e.id = p.id";
            return $this->query($sql)->fetchAll();
        }
}
