<?php

use Illuminate\Support\Collection;

const METHOD="AES-256-CBC";
const SECRET_KEY='$AULA@2024';
const SECRET_IV='150324';

if (!function_exists('format_fecha_horas')) 
{
    function format_fecha_horas($fecha)
    {
        return date('h:i A d/m/Y', strtotime($fecha));
    }
}

if (!function_exists('format_fecha')) 
{
    function format_fecha($fecha)
    {
        return date('d/m/Y', strtotime($fecha));
    }
}

if (!function_exists('format_mes')) 
{
    function format_mes($mes)
    {
        switch ($mes) {
            case 1:
                return 'Enero';
            case 2:
                return 'Febrero';
            case 3:
                return 'Marzo';
            case 4:
                return 'Abril';
            case 5:
                return 'Mayo';
            case 6:
                return 'Junio';
            case 7:
                return 'Julio';
            case 8:
                return 'Agosto';
            case 9:
                return 'Septiembre';
            case 10:
                return 'Octubre';
            case 11:
                return 'Noviembre';
            case 12:
                return 'Diciembre';
            case 0:
                return 'Todos los meses';
        }
    }
}

// Funcion para retornar el color de acuerdo al porcentaje conseguido para el proceso
if (!function_exists('color_porcentaje')) 
{
    function color_porcentaje($porcentaje)
    {
        if ($porcentaje >= 0 && $porcentaje <= 15) {
            return 'red';
        } elseif ($porcentaje > 15 && $porcentaje < 25) {
            return 'orange';
        } elseif ($porcentaje >= 25 && $porcentaje < 50) {
            return 'yellow';
        } elseif ($porcentaje >= 50 && $porcentaje <= 100) {
            return 'teal';
        }
    }
}

if (!function_exists('numero_a_romano')) 
{
    function numero_a_romano($numero)
    {
        if (!is_int($numero)) {
            throw new InvalidArgumentException("El argumento debe ser un entero.");
        }

        $map = [
            1000 => 'M', 900 => 'CM', 500 => 'D', 400 => 'CD',
            100 => 'C', 90 => 'XC', 50 => 'L', 40 => 'XL',
            10 => 'X', 9 => 'IX', 5 => 'V', 4 => 'IV',
            1 => 'I'
        ];
        $returnValue = '';
        
        foreach ($map as $value => $roman) {
            while ($numero >= $value) {
                $returnValue .= $roman;
                $numero -= $value;
            }
        }
        
        return $returnValue;
    }
}

// Funcion para limpiar cadenas
if (!function_exists('limpiar_cadena')) 
{
    function limpiar_cadena($cadena)
    {
        $tilde = ['á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú'];
        $dieresis = ['ä', 'ë', 'ï', 'ö', 'ü', 'Ä', 'Ë', 'Ï', 'Ö', 'Ü'];
        $reemplazo = ['a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U'];
        $cadena=trim($cadena);
        $cadena=stripslashes($cadena);
        $cadena=str_ireplace("<script>", "", $cadena);
        $cadena=str_ireplace("</script>", "", $cadena);
        $cadena=str_ireplace("<script src", "", $cadena);
        $cadena=str_ireplace("<script type=", "", $cadena);
        $cadena=str_ireplace("SELECT * FROM", "", $cadena);
        $cadena=str_ireplace("DELETE FROM", "", $cadena);
        $cadena=str_ireplace("INSERT INTO", "", $cadena);
        $cadena=str_ireplace("DROP TABLE", "", $cadena);
        $cadena=str_ireplace("DROP DATABASE", "", $cadena);
        $cadena=str_ireplace("TRUNCATE TABLE", "", $cadena);
        $cadena=str_ireplace("SHOW TABLES", "", $cadena);
        $cadena=str_ireplace("SHOW DATABASES", "", $cadena);
        $cadena=str_ireplace("<?php", "", $cadena);
        $cadena=str_ireplace("?>", "", $cadena);
        $cadena=str_ireplace("--", "", $cadena);
        $cadena=str_ireplace(">", "", $cadena);
        $cadena=str_ireplace("<", "", $cadena);
        $cadena=str_ireplace("[", "", $cadena);
        $cadena=str_ireplace("]", "", $cadena);
        $cadena=str_ireplace("^", "", $cadena);
        $cadena=str_ireplace("==", "", $cadena);
        $cadena=str_ireplace(";", "", $cadena);
        $cadena=str_ireplace("::", "", $cadena);
        $cadena=stripslashes($cadena);
        $cadena=str_replace($tilde, $reemplazo, $cadena);
        $cadena=str_replace($dieresis, $reemplazo, $cadena);
        $cadena=trim($cadena);
        $cadena=strtoupper($cadena);
        return $cadena;
    }
}

// Funcion para encriptar
if (!function_exists('encriptar')) 
{
    function encriptar($string)
    {
        $output=FALSE;
        $key=hash('sha256', SECRET_KEY);
        $iv=substr(hash('sha256', SECRET_IV), 0, 16);
        $output=openssl_encrypt($string, METHOD, $key, 0, $iv);
        $output=base64_encode($output);
        return $output;
    }

}

// Funcion para desencriptar
if (!function_exists('desencriptar')) 
{
    function desencriptar($string)
    {
        $key=hash('sha256', SECRET_KEY);
        $iv=substr(hash('sha256', SECRET_IV), 0, 16);
        $output=openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
        return $output;
    }

}