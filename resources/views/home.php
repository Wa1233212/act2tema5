<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <p class="header-paragraph">Pruebas de consultas (hacer scroll):</p>
    <?php
        use App\Models\RopaModel;
        use App\Models\ElectronicoModel;
        use App\Models\ComidaModel;

        $ropaModel = new RopaModel();
        $electronicoModel = new ElectronicoModel();
        $comidaModel = new ComidaModel();

        // Mostrar descripción de un producto de cada tipo
        echo $ropaModel->mostrarDescripcion(1);
        echo $electronicoModel->mostrarDescripcion(2);
        echo $comidaModel->mostrarDescripcion(3);

        // Buscar ropa por talla
        $ropaPorTalla = $ropaModel->buscarPorTalla('M');
        var_dump($ropaPorTalla);

        // Buscar electrónicos por modelo
        $electronicosPorModelo = $electronicoModel->buscarPorModelo('Galaxy S21');
        var_dump($electronicosPorModelo);

        // Buscar comida por fecha de caducidad
        $comidaCaducidad = $comidaModel->buscarPorFechaCaducidad('2024-12-01');
        var_dump($comidaCaducidad);
    ?>
</body>

</html>