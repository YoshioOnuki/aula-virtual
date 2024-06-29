<?php

use App\Models\GestionAulaUsuario;

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

if(!function_exists('format_hora'))
{
    function format_hora($hora)
    {
        return date('h:i A', strtotime($hora));
    }
}

if (!function_exists('format_dia_semana'))
{
    function format_dia_semana($fecha)
    {
        $dia = date('w', strtotime($fecha));
        switch ($dia) {
            case 0:
                return 'Domingo';
            case 1:
                return 'Lunes';
            case 2:
                return 'Martes';
            case 3:
                return 'Miércoles';
            case 4:
                return 'Jueves';
            case 5:
                return 'Viernes';
            case 6:
                return 'Sábado';
        }
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

// Función para obtener la última vez que se conectó un usuario
if (!function_exists('ultima_conexion'))
{
    function ultima_conexion($fecha)
    {
        $fecha_actual = date('Y-m-d');
        $hora_actual = date('H:i:s');
        $fecha_ultima_conexion = date('Y-m-d', strtotime($fecha));
        $hora_ultima_conexion = date('H:i:s', strtotime($fecha));
        if ($fecha_actual == $fecha_ultima_conexion) {
            return 'Hoy a las ' . date('h:i A', strtotime($hora_ultima_conexion));
        } else {
            return 'El ' . date('d/m/Y', strtotime($fecha_ultima_conexion)) . ' a las ' . date('h:i A', strtotime($hora_ultima_conexion));
        }
    }
}

// Funcion para verificar si la hora actual está entre la hora de inicio y fin en la fecha actual
if (!function_exists('verificar_hora_actual'))
{
    function verificar_hora_actual($hora_inicio, $hora_fin, $fecha)
    {
        $hora_actual = date('H:i:s');
        $fecha_actual = date('Y-m-d');
        if ($fecha_actual == $fecha) {
            if ($hora_actual >= $hora_inicio && $hora_actual < $hora_fin) {
                return true;
            }
        }
        return false;
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


// Funcion para subir un archivo del curso
if (!function_exists('subir_archivo'))
{
    function subir_archivo($archivo, $url_archiv, $carpetas, $extencion_archivo)
    {
        if (file_exists($url_archiv)) {
            unlink($url_archiv);
        }

        $base_path = 'archivos/';

        // Asegurar que se creen los directorios con los permisos correctos
        $path = asignar_permiso_rutas($base_path, $carpetas);

        // Nombre del archivo
        $filename = time() . uniqid() . '.' . $extencion_archivo;
        $nombre_db = $path . $filename;

        // Guardar el archivo
        $archivo->storeAs($path, $filename, 'public');

        // Asignar todos los permisos al archivo
        chmod($nombre_db, 0777);

        return $nombre_db;
    }
}

// Funcion para asignar permisos a los directorios
if (!function_exists('asignar_permiso_rutas'))
{
    function asignar_permiso_rutas($base_path, $rutas)
    {
        $path = $base_path;
        foreach ($rutas as $ruta) {
            $path .= $ruta . '/';
            // Asegurar que se creen los directorios con los permisos correctos
            $parent_directory = dirname($path); // Sirve para obtener el directorio padre "archivos/"
            if (!file_exists($parent_directory)) {
                mkdir($parent_directory, 0777, true); // Establecer permisos en el directorio padre
            }
            if (!file_exists($path)) {
                mkdir($path, 0777, true); // 0777 establece todos los permisos para el directorio
            }
        }
        return $path;
    }
}

// Funcion para obtener la ruta base para un archivo
if (!function_exists('obtener_ruta_base'))
{
    function obtener_ruta_base($id_gestion_aula_usuario)
    {
        $curso = GestionAulaUsuario::with([
            'gestionAula' => function ($query) {
                $query->with([
                    'curso' => function ($query) {
                        $query->with([
                            'programa' => function ($query) {
                                $query->with([
                                    'tipoPrograma' => function ($query) {
                                        $query->with([
                                            'nivelAcademico' => function ($query) {
                                                $query->select('id_nivel_academico', 'nombre_nivel_academico');
                                            }
                                        ])->select('id_tipo_programa', 'nombre_tipo_programa', 'id_nivel_academico');
                                    }
                                ])->select('id_programa', 'nombre_programa', 'mencion_programa', 'id_tipo_programa');
                            }
                        ])
                        ->select('id_curso', 'id_programa', 'nombre_curso');
                    },
                    'proceso' => function ($query) {
                        $query->select('id_proceso', 'nombre_proceso');
                    }
                ])->select('id_gestion_aula', 'grupo_gestion_aula', 'id_curso', 'id_proceso');
            }
        ])->where('id_gestion_aula_usuario', $id_gestion_aula_usuario)->first();


        $nombre_curso = $curso->gestionAula->curso->nombre_curso.'_'.$curso->gestionAula->grupo_gestion_aula;
        $proceso = $curso->gestionAula->proceso->nombre_proceso;
        if($curso->gestionAula->curso->programa->mencion_programa)
        {
            $nombre_programa = $curso->gestionAula->curso->programa->nombre_programa.'_'.$curso->gestionAula->curso->programa->mencion_programa;
        }else{
            $nombre_programa = $curso->gestionAula->curso->programa->nombre_programa;
        }
        $tipo_programa = $curso->gestionAula->curso->programa->tipoPrograma->nombre_tipo_programa;
        $nivel_academico = $curso->gestionAula->curso->programa->tipoPrograma->nivelAcademico->nombre_nivel_academico;

        $carpetas = [
            $nivel_academico,
            $tipo_programa,
            $nombre_programa,
            $proceso,
            $nombre_curso
        ];

        return $carpetas;

    }
}

// Funcion para obtener el tamaño de un archivo en formato legible
if (!function_exists('formato_tamano_archivo')) {
    function formato_tamano_archivo($bytes)
    {
        $unidad = ['bytes', 'KB', 'MB', 'GB', 'TB', 'PB'];
        if ($bytes == 0) return '0 bytes';
        $i = floor(log($bytes, 1024));
        $calculatedSize = $bytes / pow(1024, $i);
        return round($calculatedSize, 2) . ' ' . $unidad[$i];
    }
}

// Funcion para obtener la ruta del icono de archivo segun la extension
if (!function_exists('obtener_icono_archivo')) {
    function obtener_icono_archivo($ruta)
    {
        $extension = pathinfo($ruta, PATHINFO_EXTENSION);
        $extension = strtolower($extension);
        switch ($extension) {
            case 'doc':
            case 'docx':
                return '/media/icons/icon-archivo-doc.webp';
            case 'pdf':
                return '/media/icons/icon-archivo-pdf.webp';
            case 'jpg':
            case 'jpeg':
                return '/media/icons/icon-archivo-jpg.webp';
            case 'png':
                return '/media/icons/icon-archivo-png.webp';
            case 'ppt':
            case 'pptx':
                return '/media/icons/icon-archivo-ppt.webp';
            case 'xls':
            case 'xlsx':
                return '/media/icons/icon-archivo-xls.webp';
            case 'txt':
                return '/media/icons/icon-archivo-txt.webp';
            default:
                return '/media/icons/icon-archivo-generico.webp';
        }
    }
}

// Funcion para obtener la extension de un archivo
if (!function_exists('obtener_extension_archivo')) {
    function obtener_extension_archivo($ruta)
    {
        $extension = pathinfo($ruta, PATHINFO_EXTENSION);
        $extension = strtolower($extension);
        return $extension;
    }
}
