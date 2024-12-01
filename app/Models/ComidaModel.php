<?php

namespace App\Models;

class ComidaModel extends ProductoModel
{
    protected $table = 'comida';

    public function mostrarDescripcion(int $id): string
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
}
