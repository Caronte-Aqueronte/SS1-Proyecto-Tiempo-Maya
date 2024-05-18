<?php

class RuedaCalendaricaCalculadora
{
    private $conn;

    // Constructor to initialize the connection
    public function __construct()
    {
        $this->conn = include "conexion/conexion.php";
    }

    public function obtenerHaab($fecha)
    {
        $fecha1 = new DateTime("1990-04-03");
        $fecha2 = new DateTime($fecha);
        $fecha_actual = strtotime(date("d-m-Y H:i:00", $fecha1->getTimestamp()));
        $fecha_entrada = strtotime($fecha);
        $diff = $fecha1->diff($fecha2);
        $dias = $diff->days;
        $reversa = false;

        if ($fecha_actual > $fecha_entrada) {
            $reversa = true;
        }

        if ($reversa) {
            $dias = $dias % 365;
            if ($dias < 360) {
                $mes = 18 - ceil($dias / 20);
                $dia = 20 - $dias % 20;
            } else {
                $mes = 0;
                $dia = 365 - $dias;
            }
        } else {
            if ($dias >= 365) {
                $dias = $dias % 365;
            }
            if ($dias > 5) {
                $dias = $dias - 5;
                $diasmes = $dias + 1;
                $mes = ceil($diasmes / 20);
                $dia = $dias % 20;
            } else {
                $mes = 0;
                $dia = $dias % 20;
            }
        }

        $query = $this->conn->query("SELECT nombre FROM uinal WHERE idweb = $mes;");
        $row = mysqli_fetch_assoc($query);
        $uinal = $row['nombre'] . " ";
        return $uinal . strval($dia);
    }

    public function obtenerCholquij($fecha)
    {
        return $this->obtenerNahual($fecha) . " " . strval($this->obtenerEnergia($fecha));
    }

    private function obtenerNahual($fecha)
    {
        $formato = mktime(0, 0, 0, 1, 1, 1720) / (24 * 60 * 60);
        $fecha = date("U", strtotime($fecha)) / (24 * 60 * 60);
        $id = $fecha - $formato;
        $nahual = $id % 20;
        if ($nahual < 0) {
            $nahual = 19 + $nahual;
        }
        $Query = $this->conn->query("SELECT nombre FROM nahual WHERE idweb=" . $nahual . " ;");
        $row = mysqli_fetch_assoc($Query);
        $query = $row['nombre'];
        return $query;
    }

    private function obtenerEnergia($fecha)
    {
        $for = mktime(0, 0, 0, 1, 1, 1720) / (24 * 60 * 60);
        $fech = date("U", strtotime($fecha)) / (24 * 60 * 60);
        $idd = $fech - $for;
        $nn = $idd % 13;
        if ($nn < 0) {
            $nn = 12 + $nn;
        }
        if ($nn == 12) {
            return 1;
        } else {
            return $nn + 2;
        }
    }

}
?>