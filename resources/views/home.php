<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../public/css/styles.css">
</head>


<body>
    <header>
        <h1>Tienda - Pruebas de Consultas</h1>
    </header>
    <main>
        <section>
            <h2>Descripción de Productos</h2>
            <?php
                use App\Models\RopaModel;
                use App\Models\ElectronicoModel;
                use App\Models\ComidaModel;

                $ropaModel = new RopaModel();
                $electronicoModel = new ElectronicoModel();
                $comidaModel = new ComidaModel();

                // Mostrar descripción de un producto de cada tipo
                echo "<div class='result-box'>";
                echo "<strong>Ropa:</strong> " . $ropaModel->mostrarDescripcion(1) . "<br>";
                echo "<strong>Electrónico:</strong> " . $electronicoModel->mostrarDescripcion(2) . "<br>";
                echo "<strong>Comida:</strong> " . $comidaModel->mostrarDescripcion(3) . "<br>";
                echo "</div>";
            ?>
        </section>

        <section>
            <h2>Búsqueda por Categorías</h2>

            <h3>Ropa por Talla</h3>
            <?php
                // Buscar ropa por talla
                $ropaPorTalla = $ropaModel->buscarPorTalla('M');
                echo "<div class='result-box'>";
                echo "<pre>" . var_export($ropaPorTalla, true) . "</pre>";
                echo "</div>";
            ?>

            <h3>Electrónicos por Modelo</h3>
            <?php
                // Buscar electrónicos por modelo
                $electronicosPorModelo = $electronicoModel->buscarPorModelo('Galaxy S21');
                echo "<div class='result-box'>";
                echo "<pre>" . var_export($electronicosPorModelo, true) . "</pre>";
                echo "</div>";
            ?>

            <h3>Comida por Fecha de Caducidad</h3>
            <?php
                // Buscar comida por fecha de caducidad
                $comidaCaducidad = $comidaModel->buscarPorFechaCaducidad('2024-12-01');
                echo "<div class='result-box'>";
                echo "<pre>" . var_export($comidaCaducidad, true) . "</pre>";
                echo "</div>";
            ?>
        </section>

        <section>
            <h2>Pruebas Adicionales</h2>
            <a href="/" class="btn">Recargar Página</a>
        </section>
    </main>
</body>

</html>