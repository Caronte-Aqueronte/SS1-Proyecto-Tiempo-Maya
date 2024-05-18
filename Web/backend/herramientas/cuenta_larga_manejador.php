<?php

class MenjadorCuentaLarga
{
    private $baktun;
    private $katun;
    private $tun;
    private $uinall;
    private $kinn;

    private $multiplicaciones;

    // Constructor para inicializar las variables
    public function __construct($fecha)
    {
        //inicializamos la cuenta larga
        $this->calcularCuentaLarga($fecha);
        $this->realizarMultiplicaciones();
    }

    public function getCuenta()
    {
        return $this->baktun . "." . $this->katun . "." . $this->tun . "." . $this->uinall . "." . $this->kinn;

    }

    private function calcularCuentaLarga($fecha)
    {
        $fecha1 = new DateTime("01-01-2001");
        $fecha2 = new DateTime($fecha);
        $fecha_actual = strtotime(date("d-m-Y H:i:00", $fecha1->getTimestamp()));
        $fecha_entrada = strtotime($fecha);
        $diff = $fecha1->diff($fecha2);
        $dias = $diff->days;
        $reversa = false;
        if ($fecha_actual > $fecha_entrada) {
            $reversa = true;
        }

        $number_4 = 0;
        if ($dias > 7200) {
            $number_4 = floor($dias / 7200);
            $number_3 = floor(($dias % 7200) / 360);
            $number_2 = floor((($dias % 7200) % 360) / 20);
            $number_1 = (($dias % 7200) % 360) % 20;
        } else {
            $number_3 = floor($dias / 360);
            $number_2 = floor(($dias % 360) / 20);
            $number_1 = ($dias % 360) % 20;
        }

        if ($reversa) {
            $number_1 *= -1;
            $number_2 *= -1;
            $number_3 *= -1;
            $number_4 *= -1;
        }

        $number1 = 8 + $number_1;
        $pivot = 0;
        if ($number1 > 19) {
            $number1 = $number1 - 20;
            $pivot = 1;
        } elseif ($number1 < 0) {
            $number1 = 20 + $number1;
            $pivot = -1;
        }

        $number2 = 15 + $number_2 + $pivot;
        $pivot = 0;
        if ($number2 > 17) {
            $number2 = $number2 - 18;
            $pivot = 1;
        } elseif ($number2 < 0) {
            $number2 = 18 + $number2;
            $pivot = -1;
        }
        $number3 = 7 + $number_3 + $pivot;
        $pivot = 0;
        if ($number3 > 19) {
            $number3 = $number3 - 20;
            $pivot = 1;
        } elseif ($number3 < 0) {
            $number3 = 20 + $number3;
            $pivot = -1;
        }
        $number4 = 19 + $number_4 + $pivot;
        $pivot = 0;
        if ($number4 > 19) {
            $number4 = $number4 - 20;
            $pivot = 1;
        } elseif ($number4 < 0) {
            $number4 = 20 + $number4;
            $pivot = -1;
        }
        $number5 = 12 + $pivot;

        //inicialozamos la cuenta larga
        $this->baktun = strval($number5);
        $this->katun = strval($number4);
        $this->tun = strval($number3);
        $this->uinall = strval($number2);
        $this->kinn = strval($number1);
    }

    // Método para realizar las multiplicaciones
    private function realizarMultiplicaciones()
    {
        $multiplicacion_batun = $this->formatearConComas($this->baktun * 144000);
        $multiplicacion_kati = $this->formatearConComas($this->katun * 7200);
        $multiplicacion_tun = $this->formatearConComas($this->katun * 360);
        $multiplicacion_uinall = $this->formatearConComas($this->uinall * 20);
        $multiplicacion_kinn = $this->formatearConComas($this->kinn * 1);

        $this->multiplicaciones = [
            'batun' => $multiplicacion_batun,
            'kati' => $multiplicacion_kati,
            'tun' => $multiplicacion_tun,
            'uinall' => $multiplicacion_uinall,
            'kinn' => $multiplicacion_kinn
        ];
    }

    public function convertirFechaMayaAGregoriana(
        $baktun,
        $katun,
        $tun,
        $uinall,
        $kinn
    ) {
        // Constante de correlación
        // Esta constante ajusta la diferencia entre la Cuenta Larga Maya y el calendario juliano
        // Para la correlación GMT (Goodman-Martinez-Thompson)
        $constanteCorrelacion = 584283;

        // Convertir la fecha de la Cuenta Larga Maya a días mayas
        $diasMayas = ($baktun * 144000) + ($katun * 7200) + ($tun * 360) + ($uinall * 20) + $kinn;

        // Calcular el número de días julianos
        $diasJulianos = $diasMayas + $constanteCorrelacion;

        // Convertir días julianos a fecha gregoriana
        $d = $diasJulianos + 0.5; // Agregar un desplazamiento para ajustar el cálculo
        $z = floor($d); // Obtener la parte entera de los días julianos
        $f = $d - $z; // Obtener la fracción de los días julianos

        $a = $z;
        /*evaluar si z es mayor a 2299161 pues a partir de esta fecha (días julianos), 
        el calendario juliano experimentó un cambio en
         su estructura debido a ajustes en el calendario para corregir errores en la estimación del año solar*/
        if ($z >= 2299161) {
            $alpha = floor(($z - 1867216.25) / 36524.25); // Calcular un ajuste según el valor de z
            $a = $z + 1 + $alpha - floor($alpha / 4); // Aplicar el ajuste a
        }

        $b = $a + 1524; // Calcular el siguiente paso en la conversión
        $c = floor(($b - 122.1) / 365.25); // Calcular c como un valor de ajuste
        $d = floor(365.25 * $c); // Obtener el valor de d
        $e = floor(($b - $d) / 30.6001); // Calcular un valor de ajuste e

        $day = floor($b - $d - floor(30.6001 * $e) + $f); // Obtener el día
        $month = $e - (($e < 14) ? 1 : 13); // Obtener el mes
        $year = $c - (($month > 2) ? 4716 : 4715); // Obtener el año

        // Crear un objeto de fecha gregoriana formateado
        $fechaGregoriana = sprintf('%02d/%02d/%04d', $day, $month, $year);

        return $fechaGregoriana; // Devolver la fecha gregoriana formateada
    }



    // Método para formatear los resultados con comas
    public function formatearConComas($numero)
    {
        return number_format($numero, 0, '', ',');
    }

    // Método para obtener el valor de baktun
    public function getBaktun()
    {
        return $this->baktun;
    }

    // Método para obtener el valor de katun
    public function getKatun()
    {
        return $this->katun;
    }

    // Método para obtener el valor de tun
    public function getTun()
    {
        return $this->tun;
    }

    // Método para obtener el valor de uinall
    public function getUinall()
    {
        return $this->uinall;
    }

    // Método para obtener el valor de kinn
    public function getKinn()
    {
        return $this->kinn;
    }
    // Método para obtener el valor de kinn
    public function getMultiplicaciones()
    {
        return $this->multiplicaciones;
    }
}
?>