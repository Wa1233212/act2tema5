<?php
declare(strict_types=1);

namespace App\Productos;

// Interfaz vendible
interface VendibleInterface {
    public function calcularPrecioConIVA(): float;
}

// Clase Producto
abstract class Producto implements VendibleInterface {
    public const IVA = 0.21; // 21%
    protected string $id;
    protected string $nombre;
    protected float $precio;

    public function __construct(string $nombre, float $precio) {
        $this->id = uniqid();
        $this->nombre = $nombre;
        $this->precio = $precio;
    }

    abstract public function mostrarDescripcion(): void;

    public function calcularPrecioConIVA(): float {
        return $this->precio * (1 + self::IVA);
    }

    // Nuevo método para obtener el ID
    public function getId(): string {
        return $this->id;
    }
}

// Clase Ropa
class Ropa extends Producto {
    private string $talla;

    public function __construct(string $nombre, float $precio, string $talla) {
        parent::__construct($nombre, $precio); // Llama al constructor padre
        $this->talla = $talla;
    }

    public function mostrarDescripcion(): void {
        echo "Ropa: {$this->nombre}, Precio: {$this->precio}, Talla: {$this->talla}" . PHP_EOL;
    }
}

// Clase Electrónico
class Electronico extends Producto {
    private string $modelo;

    public function __construct(string $nombre, float $precio, string $modelo) {
        parent::__construct($nombre, $precio); // Llama al constructor padre
        $this->modelo = $modelo;
    }

    public function mostrarDescripcion(): void {
        echo "Electrónico: {$this->nombre}, Precio: {$this->precio}, Modelo: {$this->modelo}" . PHP_EOL;
    }
}

// Clase Comida
class Comida extends Producto {
    private \DateTime $caducidad;

    public function __construct(string $nombre, float $precio, string $caducidad) {
        parent::__construct($nombre, $precio); // Llama al constructor padre
        $this->caducidad = new \DateTime($caducidad);
    }

    public function mostrarDescripcion(): void {
        echo "Comida: {$this->nombre}, Precio: {$this->precio}, Caducidad: " . $this->caducidad->format('Y-m-d') . PHP_EOL;
    }
}

// Trait Descuento
trait Descuento {
    public function aplicarDescuento(float $porcentaje): void {
        $this->precio -= $this->precio * ($porcentaje / 100);
    }
}

// Clase Carrito
class Carrito {
    use Descuento;

    private array $productos = [];

    public function agregarProducto(Producto $producto): void {
        $this->productos[$producto->getId()] = $producto;
    }

    public function eliminarProducto(string $id): void {
        unset($this->productos[$id]);
    }

    public function calcularTotal(): float {
        $total = 0;
        foreach ($this->productos as $producto) {
            $total += $producto->calcularPrecioConIVA();
        }
        return $total;
    }

    public function vaciarCarrito(): void {
        $this->productos = [];
    }

    public function mostrarCarrito(): void {
        foreach ($this->productos as $producto) {
            $producto->mostrarDescripcion();
        }
        echo "Total con IVA: " . $this->calcularTotal() . PHP_EOL;
    }
}



?>