<?php

namespace App\Models;

use PDO;
use PDOException;
use Exception;

/**
 * Gestiona la conexión a la base de datos e incluye un esquema para
 * un Query Builder. Los return son ejemplo en caso de consultar la tabla
 * usuarios.
 */

class Model
{
    protected $db_host = 'localhost';
    protected $db_user = 'root'; // Las credenciales se deben guardar en un archivo .env
    protected $db_pass = '';
    protected $db_name = 'tienda_database';

    protected $connection;

    protected $query; // Consulta a ejecutar

    protected $select = '*';
    protected $where, $values = [];
    protected $orderBy;

    protected $table; // Definido en la clase hija

    public function __construct()
    {
        $this->connection();
    }

    public function connection()
    {
        try {
            $dsn = "mysql:host={$this->db_host};dbname={$this->db_name};charset=utf8";
            $this->connection = new PDO($dsn, $this->db_user, $this->db_pass);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Conexión fallida: " . $e->getMessage());
        }
    }

    // QUERY BUILDER

    public function query($sql, $data = [], $params = null)
    {
        echo "Consulta: {$sql} <br>"; // solo para pruebas
        echo "Data: ";
        var_dump($data);
        echo "Params: ";
        var_dump($params);
        echo "<br>";

        $stmt = $this->connection->prepare($sql);
        if ($data) {
            $this->bindParams($stmt, $data, $params);
        }

        $stmt->execute();
        $this->query = $stmt;

        return $this;
    }

    protected function bindParams($stmt, $data, $params)
    {
        // Si no se pasan tipos de parámetros, genera los tipos según los valores en $data
        if ($params === null) {
            $params = '';
            foreach ($data as $value) {
                if (is_int($value)) {
                    $params .= 'i'; // Integer
                } elseif (is_bool($value)) {
                    $params .= 'b'; // Boolean
                } elseif (is_null($value)) {
                    $params .= 'n'; // Null
                } else {
                    $params .= 's'; // String
                }
            }
        }
    
        // Asegúrate de que los tipos de parámetro sean correctos
        $paramTypes = str_split($params);
    
        // Verifica que la cantidad de tipos y valores coincidan
        if (count($paramTypes) !== count($data)) {
            throw new Exception("La cantidad de parámetros no coincide con la cantidad de valores.");
        }
    
        foreach ($data as $index => $value) {
            $stmt->bindValue($index + 1, $value, $this->getParamType($paramTypes[$index]));
        }
    }

    protected function getParamType($type)
    {
        switch ($type) {
            case 'i': return PDO::PARAM_INT;
            case 'd': return PDO::PARAM_STR;
            case 's': return PDO::PARAM_STR;
            default: return PDO::PARAM_STR;
        }
    }

    public function select(...$columns)
    {
        $this->select = empty($columns) ? '*' : implode(', ', $columns);
        return $this;
    }

    public function all()
    {
        $sql = "SELECT {$this->select} FROM {$this->table}";
        return $this->query($sql)->get();
    }

    public function get()
    {
        if (empty($this->query)) {
            $sql = "SELECT {$this->select} FROM {$this->table}";

            if ($this->where) {
                $sql .= " WHERE {$this->where}";
            }

            if ($this->orderBy) {
                $sql .= " ORDER BY {$this->orderBy}";
            }

            $this->query($sql, $this->values);
        }

        return $this->query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        return $this->query($sql, [$id], 'i')->get();
    }

    public function where($column, $operator, $value = null, $chainType = 'AND')
    {
        if ($value === null) {
            $value = $operator;
            $operator = '=';
        }

        $this->where = $this->where ? "{$this->where} {$chainType} {$column} {$operator} ?" : "{$column} {$operator} ?";
        $this->values[] = $value;

        return $this;
    }

    public function orderBy($column, $order = 'ASC')
    {
        $this->orderBy = $this->orderBy ? "{$this->orderBy}, {$column} {$order}" : "{$column} {$order}";
        return $this;
    }

    public function create($data)
    {
        $columns = array_keys($data);
        $columnsList = implode(', ', $columns);
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO {$this->table} ({$columnsList}) VALUES ({$placeholders})";
        $this->query($sql, array_values($data));

        return $this;
    }

    public function update($id, $data)
    {
        // Preparar las columnas a actualizar
        $fields = array_map(fn($key) => "{$key} = ?", array_keys($data));
        $fieldsList = implode(', ', $fields);
    
        // Crear la consulta SQL
        $sql = "UPDATE {$this->table} SET {$fieldsList} WHERE id = ?";
    
        // Combinar los valores de los datos y el ID, asegurando que el ID va al final
        $params = array_merge(array_values($data), [$id]);
    
        // Imprimir los valores de los parámetros antes de la consulta para depurar
        echo "Params before query: ";
        var_dump($params); // Verificar que los valores sean correctos
        echo "SQL: " . $sql . "<br>";
    
        // Ejecutar la consulta con los parámetros correctamente ordenados
        $this->query($sql, $params);
    
        return $this;
    }
    

    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $this->query($sql, [$id], 'i');

        return $this;
    }

    public function consultaPrueba()
    {
        return [
            ['id' => 1, 'nombre' => 'Nombre1', 'apellido' => 'Apellido1'],
            ['id' => 2, 'nombre' => 'Nombre2', 'apellido' => 'Apellido2'],
            ['id' => 3, 'nombre' => 'Nombre3', 'apellido' => 'Apellido3']
        ];
    }
}
