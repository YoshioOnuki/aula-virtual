<?php

use App\Models\Accion;
use App\Models\AccionUsuario;
use App\Models\GestionAula;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Vinkla\Hashids\Facades\Hashids;

const METHOD = "AES-256-CBC";
const SECRET_KEY = '$AULA@2024';
const SECRET_IV = '010524';


// Funcion para obtener la fecha ingresada en formato "dia, 25 de octubre de 2024, 12:00 PM"
if (!function_exists('format_fecha_completa')) {
    function format_fecha_completa($fecha)
    {
        $dia = date('w', strtotime($fecha));
        $dia_semana = format_dia_semana($fecha);
        $dia_mes = date('d', strtotime($fecha));
        $mes = format_mes(date('m', strtotime($fecha)));
        $anio = date('Y', strtotime($fecha));
        $hora = date('h:i A', strtotime($fecha));
        return $dia_semana . ', ' . $dia_mes . ' de ' . $mes . ' de ' . $anio . ', ' . $hora;
    }
}

if (!function_exists('format_fecha_horas')) {
    function format_fecha_horas($fecha)
    {
        return date('h:i A d/m/Y', strtotime($fecha));
    }
}

if (!function_exists('format_fecha')) {
    function format_fecha($fecha)
    {
        return date('d/m/Y', strtotime($fecha));
    }
}

// Funcion para obtener la fecha actual en formato 12 marzo 2021, con el mes abrebiado
if (!function_exists('format_fecha_string')) {
    function format_fecha_string($fecha)
    {
        $dia = date('d', strtotime($fecha));
        $mes = date('m', strtotime($fecha));
        $anio = date('Y', strtotime($fecha));
        return $dia . ' ' . Str::limit(format_mes($mes), 3, '') . ' ' . $anio;
    }
}

if (!function_exists('format_hora')) {
    function format_hora($hora)
    {
        return date('h:i A', strtotime($hora));
    }
}

if (!function_exists('format_dia_semana')) {
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

if (!function_exists('format_mes')) {
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
if (!function_exists('ultima_conexion')) {
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
if (!function_exists('verificar_hora_actual')) {
    function verificar_hora_actual($hora_inicio, $hora_fin, $fecha)
    {
        $hora_actual = date('H:i:s');
        $fecha_actual = date('Y-m-d');
        $fecha = date('Y-m-d', strtotime($fecha));

        // Aumentarle un minuto a la hora de fin
        $hora_fin = date('H:i:s', strtotime('+1 minute', strtotime($hora_fin)));
        if ($fecha_actual === $fecha) {
            if ($hora_actual >= $hora_inicio && $hora_actual < $hora_fin) {
                return true;
            }
        }
        return false;
    }
}

// Funcion para verificar si la hora actual está entre la fecha de inicio y fin en la fecha actual (datetime)
if (!function_exists('verificar_fecha_trabajo')) {
    function verificar_fecha_trabajo($fecha_inicio, $fecha_fin)
    {
        $fecha_actual = date('Y-m-d H:i:s');
        if ($fecha_actual >= $fecha_inicio && $fecha_actual < $fecha_fin) {
            return true;
        }
        return false;
    }
}

// Funcion para verificar si la hora ingresada está entre la hora de inicio y fin en la fecha ingresada en formato Y-m-d H:i:s
if (!function_exists('verificar_hora')) {
    function verificar_hora($hora_inicio, $hora_fin, $fecha, $fecha_comparar)
    {
        $hora_actual = date('H:i:s', strtotime($fecha_comparar));
        $fecha_actual = date('Y-m-d', strtotime($fecha_comparar));
        // Aumentarle un minuto a la hora de fin
        $hora_fin = date('H:i:s', strtotime('+1 minute', strtotime($hora_fin)));
        if ($fecha_actual === $fecha) {
            if ($hora_actual >= $hora_inicio && $hora_actual < $hora_fin) {
                return true;
            }
        }
        return false;
    }
}

// funcion para verificar cuanto tiempo paso desde la fecha ingresada en formato Y-m-d H:i:s, y si no a pasado el tiempo establecido, que no muestre nada
if (!function_exists('tiempo_transcurrido')) {
    function tiempo_transcurrido($fecha_comparacion, $fecha, $hora_inicio, $hora_fin)
    {
        if (verificar_hora($hora_inicio, $hora_fin, $fecha, $fecha_comparacion)) {
            return '';
        }

        $mensaje = '';
        // Formato de dias, horas, minutos y segundos
        $fecha_actual = date('Y-m-d H:i:s', strtotime($fecha_comparacion));
        $fecha_entrada = date('Y-m-d H:i:s', strtotime($fecha . ' ' . $hora_inicio));
        $diferencia = strtotime($fecha_actual) - strtotime($fecha_entrada);
        $dias = floor($diferencia / (60 * 60 * 24));
        $horas = floor(($diferencia - ($dias * 60 * 60 * 24)) / (60 * 60));
        $minutos = floor(($diferencia - ($dias * 60 * 60 * 24) - ($horas * 60 * 60)) / 60);
        $segundos = floor($diferencia - ($dias * 60 * 60 * 24) - ($horas * 60 * 60) - ($minutos * 60));

        if ($dias > 0) {
            $mensaje .= $dias . ' día(s) ';
        }
        if ($horas > 0) {
            $mensaje .= $horas . ' hora(s) ';
        }
        if ($minutos > 0) {
            $mensaje .= $minutos . ' minuto(s) ';
        }
        if ($segundos > 0) {
            $mensaje .= $segundos . ' segundo(s) ';
        }

        return $mensaje;
    }
}

// Funcion para retornar el color de acuerdo al porcentaje conseguido para el proceso
if (!function_exists('color_porcentaje')) {
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

if (!function_exists('numero_a_romano')) {
    function numero_a_romano($numero)
    {
        if (!is_int($numero)) {
            throw new InvalidArgumentException("El argumento debe ser un entero.");
        }

        $map = [
            1000 => 'M',
            900 => 'CM',
            500 => 'D',
            400 => 'CD',
            100 => 'C',
            90 => 'XC',
            50 => 'L',
            40 => 'XL',
            10 => 'X',
            9 => 'IX',
            5 => 'V',
            4 => 'IV',
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
if (!function_exists('limpiar_cadena')) {
    function limpiar_cadena($cadena)
    {
        $tilde = ['á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú'];
        $dieresis = ['ä', 'ë', 'ï', 'ö', 'ü', 'Ä', 'Ë', 'Ï', 'Ö', 'Ü'];
        $reemplazo = ['a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U'];
        $cadena = trim($cadena);
        $cadena = stripslashes($cadena);
        $cadena = str_ireplace("<script>", "", $cadena);
        $cadena = str_ireplace("</script>", "", $cadena);
        $cadena = str_ireplace("<script src", "", $cadena);
        $cadena = str_ireplace("<script type=", "", $cadena);
        $cadena = str_ireplace("SELECT * FROM", "", $cadena);
        $cadena = str_ireplace("DELETE FROM", "", $cadena);
        $cadena = str_ireplace("INSERT INTO", "", $cadena);
        $cadena = str_ireplace("DROP TABLE", "", $cadena);
        $cadena = str_ireplace("DROP DATABASE", "", $cadena);
        $cadena = str_ireplace("TRUNCATE TABLE", "", $cadena);
        $cadena = str_ireplace("SHOW TABLES", "", $cadena);
        $cadena = str_ireplace("SHOW DATABASES", "", $cadena);
        $cadena = str_ireplace("<?php", "", $cadena);
        $cadena = str_ireplace("?>", "", $cadena);
        $cadena = str_ireplace("--", "", $cadena);
        $cadena = str_ireplace(">", "", $cadena);
        $cadena = str_ireplace("<", "", $cadena);
        $cadena = str_ireplace("[", "", $cadena);
        $cadena = str_ireplace("]", "", $cadena);
        $cadena = str_ireplace("^", "", $cadena);
        $cadena = str_ireplace("==", "", $cadena);
        $cadena = str_ireplace(";", "", $cadena);
        $cadena = str_ireplace("::", "", $cadena);
        $cadena = stripslashes($cadena);
        $cadena = str_replace($tilde, $reemplazo, $cadena);
        $cadena = str_replace($dieresis, $reemplazo, $cadena);
        $cadena = trim($cadena);
        // $cadena=strtoupper($cadena);
        return $cadena;
    }
}

// Funcion para encriptar
if (!function_exists('encriptar')) {
    function encriptar($string)
    {
        $output = FALSE;
        $key = hash('sha256', SECRET_KEY);
        $iv = substr(hash('sha256', SECRET_IV), 0, 16);
        $output = openssl_encrypt($string, METHOD, $key, 0, $iv);
        $output = base64_encode($output);
        return $output;
    }
}

// Funcion para desencriptar
if (!function_exists('desencriptar')) {
    function desencriptar($string)
    {
        $key = hash('sha256', SECRET_KEY);
        $iv = substr(hash('sha256', SECRET_IV), 0, 16);
        $output = openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
        return $output;
    }
}

// Funcion para subir un archivo del curso
if (!function_exists('subir_archivo')) {
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
if (!function_exists('asignar_permiso_rutas')) {
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
if (!function_exists('obtener_ruta_base')) {
    function obtener_ruta_base($id_gestion_aula)
    {
        $curso = GestionAula::with([
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
                        ])->select('id_programa', 'id_tipo_programa');
                    }
                ])->select('id_curso', 'id_programa', 'nombre_curso');
            },
            'proceso' => function ($query) {
                $query->select('id_proceso', 'nombre_proceso');
            }
        ])
            ->select('id_gestion_aula', 'id_curso', 'id_proceso')
            ->find($id_gestion_aula);


        $nivel_academico = $curso->curso->programa->tipoPrograma->nivelAcademico->nombre_nivel_academico;
        $proceso = $curso->proceso->nombre_proceso;
        $tipo_programa = $curso->curso->programa->tipoPrograma->nombre_tipo_programa;
        // if ($curso->curso->programa->mencion_programa) {
        //     $nombre_programa = $curso->curso->programa->nombre_programa . ' - ' . $curso->curso->programa->mencion_programa;
        // } else {
        //     $nombre_programa = $curso->curso->nombre_programa;
        // }
        // $ciclo = $curso->curso->ciclo->nombre_ciclo;
        // $nombre_curso = $curso->curso->nombre_curso . ' - ' . $curso->grupo_gestion_aula;

        $carpetas = [
            Str::slug($nivel_academico),
            Str::slug($proceso),
            Str::slug($tipo_programa)
            // Str::slug($nombre_programa),
            // Str::slug($ciclo),
            // Str::slug($nombre_curso)
        ];

        return $carpetas;
    }
}

// Funcion para eliminar un archivo con el nombre del archivo y la ruta
if (!function_exists('eliminar_archivo')) {
    function eliminar_archivo($ruta)
    {
        if (file_exists($ruta)) {
            unlink($ruta);
        }
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

// Funcion para obtener el nombre del archivo sin la extension
if (!function_exists('obtener_nombre_archivo')) {
    function obtener_nombre_archivo($ruta)
    {
        $nombre = pathinfo($ruta, PATHINFO_FILENAME);
        return $nombre;
    }
}

// Funcion para obtener los datos de un archivo
if (!function_exists('format_bytes')) {
    function format_bytes($bytes, $precision = 2)
    {
        // Validación de entrada
        if (!is_numeric($bytes) || $bytes < 0 || !is_int($precision) || $precision < 0) {
            return "Invalid input";
        }

        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $pow = $bytes > 0 ? floor(log($bytes, 1024)) : 0;
        $pow = min($pow, count($units) - 1);

        // División utilizando pow para precisión
        $bytes /= pow(1024, $pow);

        // Redondear a la precisión deseada y concatenar la unidad correcta
        return number_format($bytes, $precision, '.', '') . ' ' . $units[$pow];
    }
}

// Funcion para retornar el color del estado de la asistencia
if (!function_exists('color_estado_asistencia')) {
    function color_estado_asistencia($estado)
    {
        switch ($estado) {
            case 'Presente':
                return config('settings.color-asistencia-presente');
            case 'Tarde':
                return config('settings.color-asistencia-tarde');
            case 'Ausente':
                return config('settings.color-asistencia-ausente');
            case 'Justificado':
                return config('settings.color-asistencia-justificado');
        }
    }
}

// Funcion para retornar el color del estado del trabajo academico
if (!function_exists('color_estado_trabajo_academico')) {
    function color_estado_trabajo_academico($estado)
    {
        switch ($estado) {
            case 'Entregado':
                return config('settings.color-trabajo-academico-entregado');
            case 'Revisado':
                return config('settings.color-trabajo-academico-revisado');
            case 'No entregado':
                return config('settings.color-trabajo-academico-no-entregado');
            case 'Observado':
                return config('settings.color-trabajo-academico-observado');
        }
    }
}

// Funcion para subir archivos de un editor de texto
if (!function_exists('subir_archivo_editor')) {
    function subir_archivo_editor($descripcion, $ruta_archivos)
    {
        $mensaje = $descripcion;
        // dd($mensaje);
        // if ($this->modo_orientaciones === 0) {
        $mensaje = preg_replace('/<meta http-equiv="Content-Type" content="text\/html; charset=utf-8">/', '', $mensaje);
        $mensaje = preg_replace('/\n/', '', $mensaje);
        // }
        $mensaje = '<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>' . $mensaje . '</body></html>';

        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        // Convertir y cargar el contenido HTML en UTF-8
        $utf8Html = mb_convert_encoding($mensaje, 'HTML-ENTITIES', 'UTF-8');
        @$dom->loadHTML($utf8Html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NOERROR | LIBXML_NOWARNING);

        $images = $dom->getElementsByTagName('img');

        foreach ($images as $img) {
            if ($img instanceof DOMElement) { // Verificar si es una instancia de DOMElement
                $data = $img->getAttribute('src');
                if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
                    // Extraer el tipo de imagen y los datos
                    $data = substr($data, strpos($data, ',') + 1);
                    // Asegurarse de que sea un tipo de imagen válido (png, jpg, jpeg, webp, gif)
                    $type = strtolower($type[1]);

                    // Si no es un tipo de imagen válido, continúa con la siguiente iteración
                    $data = base64_decode($data);
                    if ($data === false) {
                        continue;
                    }

                    // Directorio donde se guardará la imagen
                    $directory = public_path($ruta_archivos);

                    // Verifica si el directorio existe, si no, lo crea
                    if (!file_exists($directory)) {
                        mkdir($directory, 0777, true);
                    }

                    $filename = time() . uniqid() . ".$type";
                    $filePath = $directory . $filename;

                    // Guarda el archivo en la ruta especificada
                    file_put_contents($filePath, $data);

                    // Actualizar la fuente de la imagen en el HTML
                    $img->removeAttribute('src');
                    $img->setAttribute('src', asset($ruta_archivos . $filename));
                }
            }
        }

        $m = $dom->saveHTML();
        return $m;
    }
}

// Funcion para eliminar archivos de un editor de texto comparando la descripción actual con la anterior
if (!function_exists('eliminar_comparando_archivos_editor')) {
    function eliminar_comparando_archivos_editor($descripcion_actual, $descripcion_anterior, $ruta_archivos)
    {
        $dom_actual = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom_actual->loadHTML($descripcion_actual, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $dom_anterior = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom_anterior->loadHTML($descripcion_anterior, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $imagenes_actuales = $dom_actual->getElementsByTagName('img');
        $imagenes_anteriores = $dom_anterior->getElementsByTagName('img');

        // Crear un array para las rutas de las imágenes en la descripción actual
        $rutas_actuales = [];
        foreach ($imagenes_actuales as $img_actual) {
            if ($img_actual instanceof DOMElement) {
                $src_actual = $img_actual->getAttribute('src');
                if (strpos($src_actual, asset($ruta_archivos)) !== false) {
                    $rutas_actuales[] = $src_actual;
                }
            }
        }

        $deletedFiles = [];
        foreach ($imagenes_anteriores as $img_anterior) {
            if ($img_anterior instanceof DOMElement) {
                $src_anterior = $img_anterior->getAttribute('src');

                // Si la imagen en la descripción anterior no está en la actual, se elimina
                if (strpos($src_anterior, asset($ruta_archivos)) !== false && !in_array($src_anterior, $rutas_actuales)) {
                    $filePath = str_replace(asset(''), '', $src_anterior);
                    $absolutePath = public_path($filePath);

                    // Verificar si el archivo existe y eliminarlo
                    if (file_exists($absolutePath)) {
                        unlink($absolutePath);
                        $deletedFiles[] = $absolutePath;
                    }
                }
            }
        }

        return $deletedFiles; // Retornar los archivos eliminados para referencia
    }
}

// Funcion para eliminar archivos de un editor de texto
if (!function_exists('eliminar_archivos_editor')) {
    function eliminar_archivos_editor($descripcion, $ruta_archivos)
    {
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($descripcion, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images = $dom->getElementsByTagName('img');

        $deletedFiles = [];
        foreach ($images as $img) {
            if ($img instanceof DOMElement) {
                $src = $img->getAttribute('src');
                if (strpos($src, asset($ruta_archivos)) !== false) {
                    $filePath = str_replace(asset(''), '', $src);
                    $absolutePath = public_path($filePath);

                    // Verificar si el archivo existe y eliminarlo
                    if (file_exists($absolutePath)) {
                        unlink($absolutePath);
                        $deletedFiles[] = $absolutePath;
                    }
                }
            }
        }

        return $deletedFiles; // Retornar los archivos eliminados para referencia
    }
}

// Funcion para verificar si el contenido es vacio
if (!function_exists('limpiar_editor_vacio')) {
    function limpiar_editor_vacio($contenido)
    {
        // Si solo hay espacios, eliminarlos (&nbsp;)
        $contenido = str_replace('&nbsp;', '', $contenido);
        $contenido = trim($contenido);

        if (
            $contenido === '<p><br></p>' ||
            $contenido === '<h1> </h1>' ||
            $contenido === '<h2> </h2>' ||
            $contenido === '<h3> </h3>' ||
            $contenido === '<h4> </h4>' ||
            $contenido === '<h5> </h5>' ||
            $contenido === '<h6> </h6>' ||
            $contenido === '<p> </p>' ||
            $contenido === '<p>  </p>' ||
            $contenido === '<p>   </p>' ||
            $contenido === '<p>    </p>' ||
            $contenido === '<h1><br></h1>' ||
            $contenido === '<h2><br></h2>' ||
            $contenido === '<h3><br></h3>' ||
            $contenido === '<h4><br></h4>' ||
            $contenido === '<h5><br></h5>' ||
            $contenido === '<h6><br></h6>' ||
            $contenido === '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><p><br></p>' ||
            $contenido === '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><h1><br></h1>' ||
            $contenido === '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><h2><br></h2>' ||
            $contenido === '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><h3><br></h3>' ||
            $contenido === '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><h4><br></h4>' ||
            $contenido === '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><h5><br></h5>' ||
            $contenido === '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><h6><br></h6>' ||
            $contenido === '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><p></p>' ||
            $contenido === '<p></p>'
        ) {
            return '';
        }
        return $contenido;
    }
}

// Funcion para el color de las repuestas del foro segun el nivel
if (!function_exists('color_respuesta_foro')) {
    function color_respuesta_foro($nivel)
    {
        switch ($nivel) {
            case 0:
                return config('settings.color-border-card-respuesta-foro-0');
            case 1:
                return config('settings.color-border-card-respuesta-foro-1');
            case 2:
                return config('settings.color-border-card-respuesta-foro-2');
            case 3:
                return config('settings.color-border-card-respuesta-foro-3');
            default:
                return '';
        }
    }
}

// Funcion para obtener el tamaño de una carpeta
if (!function_exists('tamano_carpeta')) {
    function tamano_carpeta($carpeta)
    {
        $size = 0;
        $carpeta = public_path($carpeta);
        // foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($carpeta)) as $file) {
        //     $size += $file->getSize();
        // }
        foreach (File::allFiles($carpeta) as $file) {
            if ($file->isFile()) {
                $size += $file->getSize();
            }
        }
        return format_bytes($size, 2);
    }
}
