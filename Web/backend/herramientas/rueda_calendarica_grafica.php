<?php

class RuedaCalendaricaGrafica
{
    private $haab;
    private $cholquij;

    // Constructor para inicializar las variables
    public function __construct($haab, $cholquij)
    {
        $this->haab = $this->separar($haab);
        $this->cholquij = $this->separar($cholquij);
    }

    private function separar($separar)
    {
        // Separamos por espacios
        $desglose = explode(' ', $separar);

        // Reemplazamos las comillas en la primera posición y cambiamos a minúsculas
        if (isset($desglose[0])) {
            $desglose[0] = strtolower(str_replace(["'", "´"], '', $desglose[0]));
        }

        // Obtenemos la última posición del array
        $ultimaPosicion = end($desglose);

        // Preparamos el array de retorno
        $resultado = [
            $desglose[0] . ".png" ?? '',
            $ultimaPosicion . ".svg" ?? ''
        ];

        // Retornamos el array
        return $resultado;
    }

    // Getter para haab
    public function getHaab()
    {
        return $this->haab;
    }

    // Getter para cholquij
    public function getCholquij()
    {
        return $this->cholquij;
    }
}
?>