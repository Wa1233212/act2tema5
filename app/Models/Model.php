<?php



namespace App\Models;

use PDO;
use PDOException;

class Model
{
    protected $db_host = 'localhost';
    protected $db_user = 'root';
    protected $db_pass = '';
    protected $db_name = 'tienda_database';

    protected $connection;
    protected $stmt; // Última consulta ejecutada
    protected $select = '*';
    protected $where, $values = [];
    protected $orderBy;
    protected $table; // Debe definirse en las clases hijas

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

    public function query($sql, $data = [], $params = null)
    {
        echo "Consulta: {$sql} <br>";
        echo "Data: ";
        var_dump($data);
        echo "Params: ";
        var_dump($params);
        echo "<br>";

        $this->stmt = $this->connection->prepare($sql);
        if ($data) {
            $this->bindParams($this->stmt, $data, $params);
        }

        $this->stmt->execute();
        return $this; // Retorna la instancia del modelo
    }

    protected function bindParams($stmt, $data, $params)
    {
        if ($params === null) {
            $params = '';
            foreach ($data as $value) {
                $params .= is_int($value) ? 'i' : 's';
            }
        }

        $paramTypes = str_split($params);
        foreach ($data as $index => $value) {
            $stmt->bindValue($index + 1, $value, $this->getParamType($paramTypes[$index]));
        }
    }

    protected function getParamType($type)
    {
        return match ($type) {
            'i' => PDO::PARAM_INT,
            's' => PDO::PARAM_STR,
            default => PDO::PARAM_STR,
        };
    }

    public function fetch($mode = PDO::FETCH_ASSOC)
    {
        if (!$this->stmt) {
            throw new \Exception("No se ha ejecutado ninguna consulta para obtener resultados.");
        }
        return $this->stmt->fetch($mode);
    }
    

    public function fetchAll()
    {
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function select(...$columns)
    {
        $this->select = empty($columns) ? '*' : implode(', ', $columns);
        return $this;
    }

    public function get()
    {
        if (empty($this->stmt)) {
            $sql = "SELECT {$this->select} FROM {$this->table}";

            if ($this->where) {
                $sql .= " WHERE {$this->where}";
            }

            if ($this->orderBy) {
                $sql .= " ORDER BY {$this->orderBy}";
            }

            $this->query($sql, $this->values);
        }

        return $this->fetchAll();
    }

    public function find($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        return $this->query($sql, [$id], 'i')->fetch();
    }

    public function where($column, $operator, $value = null, $chainType = 'AND')
    {
        if ($value === null) {
            $value = $operator;
            $operator = '=';
        }

        $this->where = $this->where
            ? "{$this->where} {$chainType} {$column} {$operator} ?"
            : "{$column} {$operator} ?";
        $this->values[] = $value;

        return $this;
    }

    public function orderBy($column, $order = 'ASC')
    {
        $this->orderBy = $this->orderBy
            ? "{$this->orderBy}, {$column} {$order}"
            : "{$column} {$order}";
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
        $fields = array_map(fn($key) => "{$key} = ?", array_keys($data));
        $fieldsList = implode(', ', $fields);

        $sql = "UPDATE {$this->table} SET {$fieldsList} WHERE id = ?";
        $this->query($sql, array_merge(array_values($data), [$id]));

        return $this;
    }

    public function delete($conditions = null, $values = [], $params = null)
    {
        $sql = "DELETE FROM {$this->table}";
        
        if ($conditions) {
            $sql .= " WHERE {$conditions}";
        }
    
        $this->query($sql, $values, $params);
    
        return $this;
    }
    
}
