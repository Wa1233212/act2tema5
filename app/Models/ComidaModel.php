<?php

namespace App\Models;

class ComidaModel extends ProductoModel
{
    protected $table = 'comida';

    public function mostrarDescripcion(string $id): string
    {
        $sql = "SELECT p.nombre, p.precio, c.caducidad 
                FROM producto p
                JOIN comida c ON p.id = c.id
                WHERE c.id = ?";
        $comida = $this->query($sql, [$id], 'i')->fetch();

        if (!$comida) {
            return "Comida no encontrada.";
        }

        $fechaCaducidad = (new \DateTime($comida['caducidad']))->format('Y-m-d');
        return "Comida: {$comida['nombre']}, Precio: {$comida['precio']}, Caducidad: {$fechaCaducidad}";
    }

    public function buscarPorFechaCaducidad(string $fecha)
    {
        $sql = "SELECT * FROM {$this->table} WHERE caducidad >= ? ORDER BY caducidad";
        return $this->query($sql, [$fecha], 's')->fetchAll();
    }
        // Método para obtener todos los productos de comida
        public function getProductos()
        {
            $sql = "SELECT p.id, p.nombre, p.precio FROM {$this->table} c INNER JOIN Producto p ON c.id = p.id";
            return $this->query($sql)->fetchAll();
        }
}
