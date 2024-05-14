<?php session_start(); ?>
<?php
include "./backend/buscar/convertidor_numeros.php";
$conn = include "conexion/conexion.php";

if (isset($_GET['fecha'])) {
    $fecha_consultar = $_GET['fecha'];
} else {
    date_default_timezone_set('US/Central');
    $fecha_consultar = date("Y-m-d");
}

$nahual = include 'backend/buscar/conseguir_nahual_nombre.php';
$energia = include 'backend/buscar/conseguir_energia_numero.php';
$haab = include 'backend/buscar/conseguir_uinal_nombre.php';
$cuenta_larga = include 'backend/buscar/conseguir_fecha_cuenta_larga.php';
$cholquij = $nahual . " " . strval($energia);

//variables necesarias para obtener las imagenes de los numeros
$baktun;
$katun;
$tun;
$uinall;
$kinn;

$baktunDias;
$katunDias;
$tunDias;
$uinallDias;
$kinnDias;
$multiplicaciones;

// Verificar si $cuenta_larga está definido
if (isset($cuenta_larga)) {
    $desgolce = explode('.', $cuenta_larga);
    $baktun = $desgolce[0];
    $katun = $desgolce[1];
    $tun = $desgolce[2];
    $uinall = $desgolce[3];
    $kinn = $desgolce[4];
    //creamos una instancia del multiplicador
    $multiplicador = new MultiplicadorConFormato($baktun, $katun, $tun, $uinall, $kinn);
    //realizar las multiplicaciones
    $multiplicaciones = $multiplicador->realizarMultiplicaciones();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Tiempo Maya - Calculadora de Mayas</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <?php include "blocks/bloquesCss.html" ?>
    <link rel="stylesheet" href="css/estilo.css?v=<?php echo (rand()); ?>" />
    <link rel="stylesheet" href="css/calculadora.css?v=<?php echo (rand()); ?>" />
</head>

<body>
    <?php include "NavBar.php" ?>
    <div>
        <section id="inicio">
            <div id="inicioContainer" class="inicio-container">
                <div id='formulario'>
                    <h1>Calculadora</h1>
                    <form action="#" method="GET">
                        <div class="mb-1">
                            <label for="fecha" class="form-label">Fecha</label>
                            <input type="date" class="form-control" name="fecha" id="fecha"
                                value="<?php echo isset($fecha_consultar) ? $fecha_consultar : ''; ?>">
                        </div>
                        <button type="submit" class="btn btn-get-started"><i class="far fa-clock"></i> Calcular</button>
                    </form>

                    <div id="tabla">
                        <table class="table table-dark table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Calendario</th>
                                    <th scope="col" style="width: 60%;">Fecha</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">Calendario Haab</th>
                                    <td><?php echo isset($haab) ? $haab : ''; ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Calendario Cholquij</th>
                                    <td><?php echo isset($cholquij) ? $cholquij : ''; ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Cuenta Larga</th>
                                    <td><?php echo isset($cuenta_larga) ? $cuenta_larga : ''; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div id='formulario2'>
                    <h1>Cuenta Larga <?php echo isset($cuenta_larga) ? $cuenta_larga : ''; ?></h1>
                    <div class="simbolos_cuenta_div">
                        <div class="simbolos_div">
                            <div class="parejas_div">
                                <div class="cuenta_item">
                                    <img src="./img/cuenta_larga/intro.png" class="img_intro">
                                </div>
                            </div>
                            <div class="parejas_div">
                                <div class="cuenta_item">
                                    <?php
                                    // Verificar si $cuenta_larga está definido y no es igual a '0.0'
                                    if (isset($baktun)) {
                                        // Generar la ruta de la imagen SVG basada en el primer valor de cuenta_larga
                                        $ruta_imagen = "./img/numeros_mayas/{$baktun}.svg";
                                        // Mostrar la imagen solo si el primer valor de cuenta_larga no es '0'
                                        echo '<img src="' . $ruta_imagen . '" class="img_num">';
                                    }
                                    ?>
                                    <img src="./img/cuenta_larga/Baktun.png" class="img_numeral">
                                </div>
                                <div class="cuenta_item">
                                    <?php
                                    // Verificar si $cuenta_larga está definido y no es igual a '0.0'
                                    if (isset($katun)) {
                                        // Generar la ruta de la imagen SVG basada en el primer valor de cuenta_larga
                                        $ruta_imagen = "./img/numeros_mayas/{$katun}.svg";
                                        // Mostrar la imagen solo si el primer valor de cuenta_larga no es '0'
                                        echo '<img src="' . $ruta_imagen . '" class="img_num">';
                                    }
                                    ?>
                                    <img src="./img/cuenta_larga/Katun.png" class="img_numeral">
                                </div>
                            </div>
                            <div class="parejas_div">
                                <div class="cuenta_item">
                                    <?php
                                    // Verificar si $cuenta_larga está definido y no es igual a '0.0'
                                    if (isset($tun)) {
                                        // Generar la ruta de la imagen SVG basada en el primer valor de cuenta_larga
                                        $ruta_imagen = "./img/numeros_mayas/{$tun}.svg";
                                        // Mostrar la imagen solo si el primer valor de cuenta_larga no es '0'
                                        echo '<img src="' . $ruta_imagen . '" class="img_num">';
                                    }
                                    ?>
                                    <img src="./img/cuenta_larga/Tun.png" class="img_numeral">
                                </div>
                                <div class="cuenta_item">
                                    <?php
                                    // Verificar si $cuenta_larga está definido y no es igual a '0.0'
                                    if (isset($uinall)) {
                                        // Generar la ruta de la imagen SVG basada en el primer valor de cuenta_larga
                                        $ruta_imagen = "./img/numeros_mayas/{$uinall}.svg";
                                        // Mostrar la imagen solo si el primer valor de cuenta_larga no es '0'
                                        echo '<img src="' . $ruta_imagen . '" class="img_num">';
                                    }
                                    ?>
                                    <img src="./img/cuenta_larga/Uinal.png" class="img_numeral">
                                </div>
                            </div>
                            <div class="parejas_div">
                                <div class="cuenta_item">
                                    <?php
                                    // Verificar si $cuenta_larga está definido y no es igual a '0.0'
                                    if (isset($kinn)) {
                                        // Generar la ruta de la imagen SVG basada en el primer valor de cuenta_larga
                                        $ruta_imagen = "./img/numeros_mayas/{$kinn}.svg";
                                        // Mostrar la imagen solo si el primer valor de cuenta_larga no es '0'
                                        echo '<img src="' . $ruta_imagen . '" class="img_num">';
                                    }
                                    ?>
                                    <img src="./img/cuenta_larga/Kin.png" class="img_numeral">
                                </div>
                            </div>
                        </div>

                        <div class="cuenta">
                            <div class="conversion">
                                <?php
                                if (isset($baktun)) {
                                    echo '<h2>' . $baktun . ' baktún </h2>';
                                    echo '<p>' . $baktun . ' * 144,000 días = ' . $multiplicaciones['batun'] . ' días</p>';
                                } ?>
                            </div>
                            <div class="conversion">
                                <?php
                                if (isset($katun)) {
                                    echo '<h2>' . $katun . ' katún </h2>';
                                    echo '<p>' . $katun . ' * 7,200 días = ' . $multiplicaciones['kati'] . ' días</p>';
                                } ?>
                            </div>
                            <div class="conversion">
                                <?php
                                if (isset($tun)) {
                                    echo '<h2>' . $tun . ' tun </h2>';
                                    echo '<p>' . $tun . ' * 360 días = ' . $multiplicaciones['tun'] . ' días</p>';
                                } ?>
                            </div>
                            <div class="conversion">
                                <?php
                                   if (isset($uinall)) {
                                    echo '<h2>' . $uinall . ' uinal </h2>';
                                    echo '<p>' . $uinall . ' * 20 días = ' . $multiplicaciones['uinall'] . ' días</p>';
                                } ?>
                            </div>
                            <div class="conversion">
                                <?php
                                 if (isset($kinn)) {
                                    echo '<h2>' . $kinn . ' tun </h2>';
                                    echo '<p>' . $kinn . ' * 1 día = ' . $multiplicaciones['kinn'] . ' días</p>';
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </section>


        <?php include "blocks/bloquesJs1.html" ?>
</body>

</html>