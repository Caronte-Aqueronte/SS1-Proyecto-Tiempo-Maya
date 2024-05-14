<?php

class MenjadorCuentaLarga
{
    private $baktun;
    private $katun;
    private $tun;
    private $uinall;
    private $kinn;

    // Constructor para inicializar las variables
    public function __construct($cuenta_larga)
    {
        $desgolce = explode('.', $cuenta_larga);
        $this->baktun = $desgolce[0];
        $this->katun = $desgolce[1];
        $this->tun = $desgolce[2];
        $this->uinall = $desgolce[3];
        $this->kinn = $desgolce[4];
    }

    // Método para realizar las multiplicaciones
    public function realizarMultiplicaciones()
    {
        $multiplicacion_batun = $this->formatearConComas($this->baktun * 144000);
        $multiplicacion_kati = $this->formatearConComas($this->katun * 7200);
        $multiplicacion_tun = $this->formatearConComas($this->katun * 360);
        $multiplicacion_uinall = $this->formatearConComas($this->uinall * 20);
        $multiplicacion_kinn = $this->formatearConComas($this->kinn * 1);

        return [
            'batun' => $multiplicacion_batun,
            'kati' => $multiplicacion_kati,
            'tun' => $multiplicacion_tun,
            'uinall' => $multiplicacion_uinall,
            'kinn' => $multiplicacion_kinn
        ];
    }

    function convertirFechaMayaAGregoriana()
    {
        // Constante de correlación
        // Esta constante ajusta la diferencia entre la Cuenta Larga Maya y el calendario juliano
        // Para la correlación GMT (Goodman-Martinez-Thompson)
        $constanteCorrelacion = 584283;

        // Convertir la fecha de la Cuenta Larga Maya a días mayas
        $diasMayas = ($this->baktun * 144000) + ($this->katun * 7200) + ($this->tun * 360) + ($this->uinall * 20) + $this->kinn;

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

}
?>