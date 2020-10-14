<?php 
/****************************************************************************************
 * Descripción: Funcion que muestra la estructura de carpetas a partir de la ruta dada. *
 * Autor	  : José de Jesús Gutiérrez Martínez                                        *
 * Fecha	  : 11/10/2019                                                              *
 *                                                                                        *
 * CONTROL DE CAMBIOS                                                                   *
 * ------------------------------------------------------------------------------------ *
 * | Fecha    | Cambio                                                                  *
 * ------------------------------------------------------------------------------------ *
 * | 11/10/19 | Creación del archivo                                                    *
 ****************************************************************************************/
function obtener_estructura_directorios($ruta){
    // Se comprueba que realmente sea la ruta de un directorio
    if (is_dir($ruta)){
        // Abre un gestor de directorios para la ruta indicada
        $gestor = opendir($ruta);
        echo "<ul class='carpeta'>";

        // Recorre todos los elementos del directorio
        while (($archivo = readdir($gestor)) !== false)  {
                
            $ruta_completa = $ruta . "/" . $archivo;

            // Se muestran todos los archivos y carpetas excepto "." y ".."
            if ($archivo != "." && $archivo != "..") {
                // Si es un directorio se recorre recursivamente
                if (is_dir($ruta_completa)) {
                    echo "<li>" . $archivo . "</li>";
                    obtener_estructura_directorios($ruta_completa);
                } else {
                    echo "<li>" . $archivo . " - " .filetype($ruta_completa) . "</li>";
                }
            }
        }
        
        // Cierra el gestor de directorios
        closedir($gestor);
        echo "</ul>";
    } else {
        echo "No es una ruta de directorio valida<br/>";
    }
}

/******************************************************************************************
 * Descripción: Funcion que muestra las imagenes que hay en la ruta pasada como parametro *
 * Autor	  : José de Jesús Gutiérrez Martínez                                          *
 * Fecha	  : 11/10/2019                                                                *
 *                                                                                        *
 * CONTROL DE CAMBIOS                                                                     *
 * -------------------------------------------------------------------------------------- *
 * | Fecha    | Cambio                                                                    *
 * -------------------------------------------------------------------------------------- *
 * | 11/10/19 | Creación del archivo                                                      *
 ******************************************************************************************/
function mostrar_imagenes($ruta){
    // Se comprueba que realmente sea la ruta de un directorio
    if (is_dir($ruta)){
        // Abre un gestor de directorios para la ruta indicada
        $gestor = opendir($ruta);

        // Recorre todos los archivos del directorio
        while (($archivo = readdir($gestor)) !== false)  {
            // Solo buscamos archivos sin entrar en subdirectorios
            if (is_file($ruta."/".$archivo)) {
                echo "<img src='".$ruta."/".$archivo."' width='200px' alt='".$archivo."' title='".$archivo."'>";
            }            
        }

        // Cierra el gestor de directorios
        closedir($gestor);
    } else {
        echo "No es una ruta de directorio valida<br/>";
    }
}

/** 
* Converts bytes into human readable file size. 
* 
* @param string $bytes 
* @return string human readable file size (2,87 Мб)
* @author Mogilev Arseny 
*/ 
function FileSizeConvert($bytes)
{
    $bytes = floatval($bytes);
        $arBytes = array(
            0 => array(
                "UNIT" => "TB",
                "VALUE" => pow(1024, 4)
            ),
            1 => array(
                "UNIT" => "GB",
                "VALUE" => pow(1024, 3)
            ),
            2 => array(
                "UNIT" => "MB",
                "VALUE" => pow(1024, 2)
            ),
            3 => array(
                "UNIT" => "KB",
                "VALUE" => 1024
            ),
            4 => array(
                "UNIT" => "B",
                "VALUE" => 1
            ),
        );

    foreach($arBytes as $arItem)
    {
        if($bytes >= $arItem["VALUE"])
        {
            $result = $bytes / $arItem["VALUE"];
            $result = str_replace(".", "," , strval(round($result, 2)))." ".$arItem["UNIT"];
            break;
        }
    }
    return $result;
}


?>