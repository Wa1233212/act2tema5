<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda - Consultas Interactivas</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <header>
        <h1>Consultas de prueba</h1>
    </header>

    <main>
        <!-- Descripción de productos -->
        <section>
            <h2>Descripción de Productos</h2>
            <?php
                use App\Models\RopaModel;
                use App\Models\ElectronicoModel;
                use App\Models\ComidaModel;

                $ropaModel = new RopaModel();
                $electronicoModel = new ElectronicoModel();
                $comidaModel = new ComidaModel();

                echo "<div class='result-box'>";
                echo "<strong>Ropa:</strong> " . $ropaModel->mostrarDescripcion('P001') . "<br>";
                echo "<strong>Electrónico:</strong> " . $electronicoModel->mostrarDescripcion('P004') . "<br>";
                echo "<strong>Comida:</strong> " . $comidaModel->mostrarDescripcion('P005') . "<br>";
                echo "</div>";
            ?>
        </section>

        <!-- Búsqueda por categorías -->
        <section>
            <h2>Búsqueda por Categorías</h2>

            <!-- Buscar ropa por talla -->
            <h3>Buscar Ropa por Talla</h3>
            <form action="" method="POST">
                <label for="talla">Talla:</label>
                <input type="text" id="talla" name="talla" placeholder="Ejemplo: M" required>
                <button type="submit" name="buscarRopa">Buscar</button>
            </form>

            <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buscarRopa'])) {
                    $talla = $_POST['talla'];
                    $ropaPorTalla = $ropaModel->buscarPorTalla($talla);
                    echo "<div class='result-box'>";
                    if (!empty($ropaPorTalla)) {
                        foreach ($ropaPorTalla as $ropa) {
                            echo "Nombre: {$ropa['nombre']}, Precio: {$ropa['precio']}, Talla: {$ropa['talla']}<br>";
                        }
                    } else {
                        echo "No se encontraron prendas con la talla especificada.";
                    }
                    echo "</div>";
                }
            ?>

            <!-- Buscar electrónicos por modelo -->
            <h3>Buscar Electrónicos por Modelo</h3>
            <form action="" method="POST">
                <label for="modelo">Modelo:</label>
                <input type="text" id="modelo" name="modelo" placeholder="Ejemplo: Galaxy S21" required>
                <button type="submit" name="buscarElectronico">Buscar</button>
            </form>

            <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buscarElectronico'])) {
                    $modelo = $_POST['modelo'];
                    $electronicosPorModelo = $electronicoModel->buscarPorModelo($modelo);
                    echo "<div class='result-box'>";
                    if (!empty($electronicosPorModelo)) {
                        foreach ($electronicosPorModelo as $electro) {
                            echo "Nombre: {$electro['nombre']}, Precio: {$electro['precio']}, Modelo: {$electro['modelo']}<br>";
                        }
                    } else {
                        echo "No se encontraron electrónicos con el modelo especificado.";
                    }
                    echo "</div>";
                }
            ?>

            <!-- Buscar comida por fecha de caducidad -->
            <h3>Buscar Comida por Fecha de Caducidad</h3>
            <form action="" method="POST">
                <label for="fecha">Fecha (YYYY-MM-DD):</label>
                <input type="date" id="fecha" name="fecha" required>
                <button type="submit" name="buscarComida">Buscar</button>
            </form>

            <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buscarComida'])) {
                    $fecha = $_POST['fecha'];
                    $comidaCaducidad = $comidaModel->buscarPorFechaCaducidad($fecha);
                    echo "<div class='result-box'>";
                    if (!empty($comidaCaducidad)) {
                        foreach ($comidaCaducidad as $comida) {
                            echo "Nombre: {$comida['nombre']}, Precio: {$comida['precio']}, Caducidad: {$comida['caducidad']}<br>";
                        }
                    } else {
                        echo "No se encontraron alimentos con la fecha de caducidad especificada.";
                    }
                    echo "</div>";
                }
            ?>
        </section>
        <button><a href="/login">Iniciar sesión</a></button>
        <button ><a href='/register'>Registrarse</a></button>
    </main>
</body>

</html>
