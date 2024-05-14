<?php

class MultiplicadorConFormato
{
    private $baktun;
    private $katun;
    private $tun;
    private $uinall;
    private $kinn;

    // Constructor para inicializar las variables
    public function __construct($baktun, $katun, $tun, $uinall, $kinn)
    {
        $this->baktun = $baktun;
        $this->katun = $katun;
        $this->tun = $tun;
        $this->uinall = $uinall;
        $this->kinn = $kinn;
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

    // Método para formatear los resultados con comas
    public function formatearConComas($numero)
    {
        return number_format($numero, 0, '', ',');
    }
}

?>