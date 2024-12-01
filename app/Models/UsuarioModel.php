<?php

// UsuarioModel.php
namespace App\Models;

class UsuarioModel extends Model
{
    protected $table = 'usuarios';

    public function obtenerPorCorreo($correo)
    {
        return $this->where('correo', '=', $correo)->query("SELECT * FROM {$this->table} WHERE correo = ?", [$correo])->fetch();
    }
    
}
