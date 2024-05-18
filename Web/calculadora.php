<?php session_start(); ?>
<?php
include "./backend/herramientas/cuenta_larga_manejador.php";
include "./backend/herramientas/rueda_calendarica_calculadora.php";
include "./backend/herramientas/rueda_calendarica_grafica.php";


if (isset($_GET['fecha'])) {
    $fecha_consultar = $_GET['fecha'];
} else {
    date_default_timezone_set('US/Central');
    $fecha_consultar = date("Y-m-d");
}



//$nahual = include 'backend/buscar/conseguir_nahual_nombre.php';
//$energia = include 'backend/buscar/conseguir_energia_numero.php';
//$haab = include 'backend/buscar/conseguir_uinal_nombre.php';
//$cholquij = $nahual . " " . strval($energia);
//$cuenta_larga = include 'backend/buscar/conseguir_fecha_cuenta_larga.php';


//este convertidor nos ayudara a convertir fechas gregorianas en cuentas largas
$convertidor_fecha_larga = new MenjadorCuentaLarga($fecha_consultar);
//iniciamos la calculadora de la rueda calendarica
$rueda_calculadora = new RuedaCalendaricaCalculadora();
//aqui se guardan las multiplicaciones que se hacen para la primera cuenta larga
$multiplicaciones = $convertidor_fecha_larga->getMultiplicaciones();
//obtenemos la cuenta larga
$cuenta_larga = $convertidor_fecha_larga->getCuenta();
//obtenemos la rueda calendarica
$haab = $rueda_calculadora->obtenerHaab($fecha_consultar);
$cholquij = $rueda_calculadora->obtenerCholquij($fecha_consultar);

//iniciamos la rueda calendarica grafica
$rueda_grafica = new RuedaCalendaricaGrafica($haab, $cholquij);


/**Variables para los calculos con cuenta larga */

//fecha que gregoriana que representa la cuenta larga ingresada
$fecha_gregoriana;





/**Variables para los calculos de rueda calendarica */
if (isset($_GET['fecha2'])) {
    $fecha2 = $_GET['fecha2'];
} else {
    date_default_timezone_set('US/Central');
    $fecha2 = date("Y-m-d");
}

$haab2 = $rueda_calculadora->obtenerHaab($fecha2);
$cholquij2 = $rueda_calculadora->obtenerCholquij($fecha2);

//iniciamos la rueda calendarica grafica
$rueda_grafica2 = new RuedaCalendaricaGrafica($haab2, $cholquij2);


// Verifica si se ha enviado el formulario usando el método GET
if (
    isset($_GET['baktun']) && isset($_GET['katun'])
    && isset($_GET['tun']) && isset($_GET['uinal']) && isset($_GET['kin'])
) {
    // Obtiene los valores de los campos del formulario
    $baktun2 = $_GET['baktun'] == '' ? '0' : $_GET['baktun'];
    $katun2 = $_GET['katun'] == '' ? '0' : $_GET['katun'];
    $tun2 = $_GET['tun'] == '' ? '0' : $_GET['tun'];
    $uinal2 = $_GET['uinal'] == '' ? '0' : $_GET['uinal'];
    $kin2 = $_GET['kin'] == '' ? '0' : $_GET['kin'];
    // Concatena los valores en un solo parámetro
    $cuenta_larga_convetir = strval($baktun2) . "." . strval($katun2) . "." . strval($tun2)
        . "." . strval($uinal2) . "." . strval($kin2);
    //convertimos la cuenta larga en fecha gregoriana
    $fecha_gregoriana = $convertidor_fecha_larga->convertirFechaMayaAGregoriana(
        $baktun2,
        $katun2,
        $tun2,
        $uinal2,
        $kin2
    );
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

    <section id="inicio">
        <div id="inicioContainer" class="inicio-container">
            <h1>CALCULADORA</h1>
            <a href='#calculadora' class='btn-get-started'>Fecha Gregoriana a Cuenta larga</a>
            <a href='#larga-fecha' class='btn-get-started'>Cuenta larga a Fecha Gregoriana</a>
            <a href='#rueda' class='btn-get-started'>Calcula tu rueda calendarica</a>
        </div>
    </section>
    <div class="cuerpo-container">
        <div class="separador"></div>
        <div class="cuerpo-container">
            <h1>Cuenta larga a Fecha Gregoriana</h1>
            <div class="parejas-seccion">
                <div id='calculadora'>
                    <h1>Elige una fecha</h1>
                    <form action="#calculadora" method="GET">
                        <div class="mb-1">
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
                <div id='formulario2' class="formulario2">
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
                                    if (isset($convertidor_fecha_larga)) {
                                        // Generar la ruta de la imagen SVG basada en el primer valor de cuenta_larga
                                        $ruta_imagen = "./img/numeros_mayas/{$convertidor_fecha_larga->getBaktun()}.svg";
                                        // Mostrar la imagen solo si el primer valor de cuenta_larga no es '0'
                                        echo '<img src="' . $ruta_imagen . '" class="img_num">';
                                    }
                                    ?>
                                    <img src="./img/cuenta_larga/Baktun.png" class="img_numeral">
                                </div>
                                <div class="cuenta_item">
                                    <?php
                                    // Verificar si $cuenta_larga está definido y no es igual a '0.0'
                                    if (isset($convertidor_fecha_larga)) {
                                        // Generar la ruta de la imagen SVG basada en el primer valor de cuenta_larga
                                        $ruta_imagen = "./img/numeros_mayas/{$convertidor_fecha_larga->getKatun()}.svg";
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
                                    if (isset($convertidor_fecha_larga)) {
                                        // Generar la ruta de la imagen SVG basada en el primer valor de cuenta_larga
                                        $ruta_imagen = "./img/numeros_mayas/{$convertidor_fecha_larga->getTun()}.svg";
                                        // Mostrar la imagen solo si el primer valor de cuenta_larga no es '0'
                                        echo '<img src="' . $ruta_imagen . '" class="img_num">';
                                    }
                                    ?>
                                    <img src="./img/cuenta_larga/Tun.png" class="img_numeral">
                                </div>
                                <div class="cuenta_item">
                                    <?php
                                    // Verificar si $cuenta_larga está definido y no es igual a '0.0'
                                    if (isset($convertidor_fecha_larga)) {
                                        // Generar la ruta de la imagen SVG basada en el primer valor de cuenta_larga
                                        $ruta_imagen = "./img/numeros_mayas/{$convertidor_fecha_larga->getUinall()}.svg";
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
                                    if (isset($convertidor_fecha_larga)) {
                                        // Generar la ruta de la imagen SVG basada en el primer valor de cuenta_larga
                                        $ruta_imagen = "./img/numeros_mayas/{$convertidor_fecha_larga->getKinn()}.svg";
                                        // Mostrar la imagen solo si el primer valor de cuenta_larga no es '0'
                                        echo '<img src="' . $ruta_imagen . '" class="img_num">';
                                    }
                                    ?>
                                    <img src="./img/cuenta_larga/Kin.png" class="img_numeral">
                                </div>
                                <!--RUEDA CAL CHOLQUIJ -->
                                <div class="cuenta_item">
                                    <?php
                                    // Verificar si $cuenta_larga está definido y no es igual a '0.0'
                                    if (isset($convertidor_fecha_larga)) {
                                        // Generar la ruta de la imagen SVG basada en el primer valor de cuenta_larga
                                        $ruta_imagen = "./img/numeros_mayas/{$rueda_grafica->getCholquij()[1]}";
                                        // Mostrar la imagen solo si el primer valor de cuenta_larga no es '0'
                                        echo '<img src="' . $ruta_imagen . '" class="img_num">';
                                    }
                                    ?>
                                    <?php echo '<img src="./img/nahuales/' . $rueda_grafica->getCholquij()[0] . '" class="img_numeral">' ?>
                                </div>
                            </div>
                            <div class="parejas_div">
                                <!--RUEDA CAL HAAB -->
                                <div class="cuenta_item">
                                    <?php
                                    // Verificar si $cuenta_larga está definido y no es igual a '0.0'
                                    if (isset($convertidor_fecha_larga)) {
                                        // Generar la ruta de la imagen SVG basada en el primer valor de cuenta_larga
                                        $ruta_imagen = "./img/numeros_mayas/{$rueda_grafica->getHaab()[1]}";
                                        // Mostrar la imagen solo si el primer valor de cuenta_larga no es '0'
                                        echo '<img src="' . $ruta_imagen . '" class="img_num">';
                                    }
                                    ?>
                                    <?php echo '<img src="./img/uinal/' . $rueda_grafica->getHaab()[0] . '" class="img_numeral">' ?>
                                </div>
                            </div>
                        </div>

                        <div class="cuenta">
                            <div class="conversion">
                                <?php
                                if (isset($convertidor_fecha_larga)) {
                                    echo '<h2>' . $convertidor_fecha_larga->getBaktun() . ' baktún </h2>';
                                    echo '<p>' . $convertidor_fecha_larga->getBaktun() . ' * 144,000 días = ' . $multiplicaciones['batun'] . ' días</p>';
                                } ?>
                            </div>
                            <div class="conversion">
                                <?php
                                if (isset($convertidor_fecha_larga)) {
                                    echo '<h2>' . $convertidor_fecha_larga->getKatun() . ' katún </h2>';
                                    echo '<p>' . $convertidor_fecha_larga->getKatun() . ' * 7,200 días = ' . $multiplicaciones['kati'] . ' días</p>';
                                } ?>
                            </div>
                            <div class="conversion">
                                <?php
                                if (isset($convertidor_fecha_larga)) {
                                    echo '<h2>' . $convertidor_fecha_larga->getTun() . ' tun </h2>';
                                    echo '<p>' . $convertidor_fecha_larga->getTun() . ' * 360 días = ' . $multiplicaciones['tun'] . ' días</p>';
                                } ?>
                            </div>
                            <div class="conversion">
                                <?php
                                if (isset($convertidor_fecha_larga)) {
                                    echo '<h2>' . $convertidor_fecha_larga->getUinall() . ' uinal </h2>';
                                    echo '<p>' . $convertidor_fecha_larga->getUinall() . ' * 20 días = ' . $multiplicaciones['uinall'] . ' días</p>';
                                } ?>
                            </div>
                            <div class="conversion">
                                <?php
                                if (isset($convertidor_fecha_larga)) {
                                    echo '<h2>' . $convertidor_fecha_larga->getKinn() . ' k\'in </h2>';
                                    echo '<p>' . $convertidor_fecha_larga->getKinn() . ' * 1 día = ' . $multiplicaciones['kinn'] . ' días</p>';
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="separador"></div>
        <div class="cuerpo-container" id="larga-fecha">

            <h1>Cuenta larga a Fecha Gregoriana</h1>
            <div class="resultado">
                <?php
                if (isset($cuenta_larga_convetir)) {
                    echo "<p>La cuenta larga " . $cuenta_larga_convetir . " corresponde a la fecha gregoriana " . $fecha_gregoriana . "</p>";
                } ?>

            </div>
            <form action="#larga-fecha" method="GET" class="formulario-larga-greg">
                <div class="input-container">
                    <img src="./img/cuenta_larga/Baktun.png" class="img_numeral">
                    <p>Baktun</p>
                    <input type="number" required class="form-control" name="baktun" id="baktun"
                        value="<?php echo isset($baktun2) ? $baktun2 : ''; ?>">
                </div>
                <div class="input-container">
                    <img src="./img/cuenta_larga/Katun.png" class="img_numeral">
                    <p>Katun</p>
                    <input type="number" required class="form-control" name="katun" id="katun"
                        value="<?php echo isset($katun2) ? $katun2 : ''; ?>">
                </div>
                <div class="input-container">
                    <img src="./img/cuenta_larga/Tun.png" class="img_numeral">
                    <p>Tun</p>
                    <input type="number" required class="form-control" name="tun" id="tun"
                        value="<?php echo isset($tun2) ? $tun2 : ''; ?>">
                </div>
                <div class="input-container">
                    <img src="./img/cuenta_larga/Uinal.png" class="img_numeral">
                    <p>Uinal</p>
                    <input type="number" required class="form-control" name="uinal" id="uinal"
                        value="<?php echo isset($uinal2) ? $uinal2 : ''; ?>">
                </div>
                <div class="input-container">
                    <img src="./img/cuenta_larga/Kin.png" class="img_numeral">
                    <p>K'in</p>
                    <input type="number" required class="form-control" name="kin" id="kin"
                        value="<?php echo isset($kin2) ? $kin2 : ''; ?>">
                </div>
                <button type="submit" class="btn btn-get-started botones"><i class="far fa-clock"></i> Calcular</button>
            </form>


        </div>
        <div class="separador"></div>

        <!--CALCULO DE LA RUEDA CALENDARICA-->
        <div class="cuerpo-container" id="rueda">

            <h1>Calcula tu rueda calendarica</h1>
            <form action="#rueda" method="GET" class="formulario-larga-greg">
                <div class="mb-1">
                    <input type="date" class="form-control" name="fecha2" id="fecha2"
                        value="<?php echo isset($fecha2) ? $fecha2 : ''; ?>">
                </div>
                <button type="submit" class="btn btn-get-started botones"><i class="far fa-clock"></i> Calcular</button>
            </form>
            <div class="resultado">
                <?php
                echo "<p> Calendario Cholquij: " . $cholquij2 . ", Calendario Haab: " . $haab2 . "</p>";
                ?>

            </div>
            <div class="formulario-larga-greg">
                <!--RUEDA CAL Cholquij -->
                <div class="cuenta_item">
                    <?php
                    // Verificar si $cuenta_larga está definido y no es igual a '0.0'
                    if (isset($rueda_grafica2)) {
                        // Generar la ruta de la imagen SVG basada en el primer valor de cuenta_larga
                        $ruta_imagen = "./img/numeros_mayas/{$rueda_grafica2->getCholquij()[1]}";
                        // Mostrar la imagen solo si el primer valor de cuenta_larga no es '0'
                        echo '<img src="' . $ruta_imagen . '" class="img_num">';
                    }
                    ?>
                    <?php echo '<img src="./img/nahuales/' . $rueda_grafica2->getCholquij()[0] . '" class="img_numeral">' ?>
                </div>
                <!--RUEDA CAL HAAB -->
                <div class="cuenta_item">
                    <?php
                    // Verificar si $cuenta_larga está definido y no es igual a '0.0'
                    if (isset($rueda_grafica2)) {
                        // Generar la ruta de la imagen SVG basada en el primer valor de cuenta_larga
                        $ruta_imagen = "./img/numeros_mayas/{$rueda_grafica2->getHaab()[1]}";
                        // Mostrar la imagen solo si el primer valor de cuenta_larga no es '0'
                        echo '<img src="' . $ruta_imagen . '" class="img_num">';
                    }
                    ?>
                    <?php echo '<img src="./img/uinal/' . $rueda_grafica2->getHaab()[0] . '" class="img_numeral">' ?>
                </div>

            </div>


        </div>
        <div class="separador"></div>
    </div>

    <?php include "blocks/bloquesJs1.html" ?>
</body>

</html>