<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ejercicio 08 - JSON</title>
        <style>
            *{
                box-sizing: border-box;
                margin: 0;
            }
            
            header{
                background: lightblue;
                width: 100%;
                height: 15vh;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
            }
            
            main{
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                height: 74vh;
            }
            
            footer{
                display: flex;
                align-items: center;
                justify-content: center;
                width: 100%;
                height: 13vh;
                gap: 30px;
                background: lightblue;
            }
            
            footer img{
                width: 40px;
                height: auto;
            }
        </style>
    </head>
    <body>
        <header class="header">
            <a href="../indexProyectoTema4.php">Alejandro De la Huerga</a>
            <h1>Ejercicio 08 - JSON</h1>
        </header>
        <main>
            <section>
                <?php
                /**
                 * @author: Alejandro De la Huerga
                 * @since 18/11/2025
                 * 
                 *  * Ejercicio 8
                 * Página web que toma datos (código y descripción) de la tabla Departamento y 
                 * guarda en un fichero departamento.JSON. (COPIA DE SEGURIDAD / EXPORTAR). El fichero 
                 * exportado se encuentra en el directorio .../tmp/ del servidor.
                  /**
                 * Script para exportar departamentos de la base de datos a un archivo JSON
                 * 
                 * Este archivo realiza las siguientes operaciones:
                 * 1. Consulta los departamentos almacenados en la base de datos
                 * 2. Construye un array asociativo con los datos recuperados
                 * 3. Codifica el array a formato JSON
                 * 4. Guarda el archivo JSON generado en el sistema de archivos

                 */
                
                // Atributos para el establecimiento de conexión con la base de datos.
                // Utilizamos la variable super global $_SERVER para obtener la ip.

                $dsn = 'mysql:host=' . $_SERVER['SERVER_ADDR'] . ';dbname=DBAHFDWESProyectoTema4';  // Nombre de la base de datos
                $username = 'userAHFDWESProyectoTema4'; // Nombre de usuario de la base de datos
                $password = 'paso'; // password de la base de datos.

                try {
                    /**
                     * Conexión a la base de datos mediante PDO
                     * Configura el modo de error para lanzar excepciones
                     * 
                     * @var PDO $miDB Objeto de conexión a la base de datos
                     */
                    //Conexion a la base de datos
                    $miDB = new PDO($dsn, $username, $password);
                    $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    echo "<h3>Conexión establecida con éxito.</h3>";

                    /**
                     * Consulta SQL para obtener código y descripción de todos los departamentos
                     * 
                     * @var string $sql Sentencia SELECT para recuperar departamentos
                     */
                    //Consulta Preparada
                    $sql = 'SELECT T02_CodDepartamento, T02_DescDepartamento FROM T02_Departamento';

                    /**
                     * Consulta preparada para la selección de departamentos
                     * 
                     * @var PDOStatement $consultaPreparada Statement preparado con la consulta SQL
                     */
                    $consultaPreparada = $miDB->prepare($sql);

                    //Ejecución de la consulta
                    $consultaPreparada->execute();

                    /**
                     * Array que contendrá todos los departamentos para convertir a JSON
                     * Estructura: ['departamentos' => [array de departamentos]]
                     * 
                     * @var array $aDepartamentos Array principal que contendrá el array de departamentos
                     */
                    //Inicialización del array de departamentos
                    $aDepartamentos = ['departamentos' => []];

                    /**
                     * Itera sobre cada departamento recuperado de la base de datos
                     * Construye un array asociativo con los datos y lo añade al array principal
                     * 
                     * @var stdClass $oDepartamento Objeto con los datos de cada departamento
                     */
                    while ($oDepartamento = $consultaPreparada->fetchObject()) {
                        $aDepartamentos['departamentos'][] = [
                            'codDpto' => $oDepartamento->T02_CodDepartamento,
                            'descDpto' => $oDepartamento->T02_DescDepartamento
                        ];
                    }

                    /**
                     * Convierte el array PHP a formato JSON con formato legible
                     * JSON_PRETTY_PRINT: Formatea el JSON con indentación
                     * JSON_UNESCAPED_UNICODE: Mantiene los caracteres Unicode
                     * 
                     * @var string $json Cadena JSON generada a partir del array
                     */
                    
                    //Codificación a JSON
                    $json = json_encode($aDepartamentos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

                    /**
                     * Ruta absoluta donde se guardará el archivo JSON generado
                     * 
                     * @var string $rutaFichero Ruta completa del archivo de destino
                     */
                    //Se guarda el fichero en la carpeta tmp
                    $rutaFichero = '../tmp/departamentos.json';

                    /**
                     * Guarda el contenido JSON en el archivo 
                     */
                    
                    file_put_contents($rutaFichero, $json);
                    echo "<p>Ruta generada: $rutaFichero</p>";

                    //Mensaje de confirmación
                    echo "<h3 style='color:blue;'>Exportación completada con éxito.</h3>";
                    echo "<p>El archivo se ha guardado en: <b>{$rutaFichero}</b></p>";
                } catch (PDOException $miExceptionPDO) {
                    /**
                     * Captura errores específicos de PDO durante la conexión o consulta
                     * Muestra información detallada del error de base de datos
                     * 
                     * @var PDOException $miExceptionPDO Excepción lanzada por PDO
                     */
                    // errores de la base de datos.    
                    echo "<h3 style='color:red;'>Error en la base de datos.</h3>";
                    echo "<p><b>Mensaje:</b> " . $miExceptionPDO->getMessage() . "</p>";
                    echo "<p><b>Código:</b> " . $miExceptionPDO->getCode() . "</p>";
                } catch (Exception $miExcepcionGeneral) {
                    /**
                     * Captura cualquier otra excepción no relacionada con PDO
                     * Por ejemplo, errores al codificar o guardar el archivo JSON
                     * 
                     * @var Exception $miExcepcionGeneral Excepción general capturada
                     */
                    echo "<h3 style='color:red;'>Error general.</h3>";
                    echo "<p><b>Mensaje:</b> " . $miExcepcionGeneral->getMessage() . "</p>";
                } finally {
                    /**
                     * Cierra la conexión a la base de datos
                     * Se ejecuta siempre, independientemente de si hubo errores
                     */
                    unset($miDB); // Cerrar conexión
                }
                ?>
            </section>


        </main>
    </body>
</html>
