<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ejercicio 08 - Alejandro De la Huerga</title>
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
        <header>
            <h1>Ejercicio 08 - XML</h1>
            <a href="../indexProyectoTema4.php"><h2>Alejandro De la Huerga</h2></a>
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
                 * guarda en un fichero departamento.xml. (COPIA DE SEGURIDAD / EXPORTAR). El fichero 
                 * exportado se encuentra en el directorio .../tmp/ del servidor.
                  /**
                 * Script para exportar departamentos de la base de datos a un archivo XML
                 * 
                 * Este archivo realiza las siguientes operaciones:
                 * 1. Consulta los departamentos almacenados en la base de datos
                 * 2. Crea un objeto SimpleXMLElement con la estructura XML
                 * 3. Itera sobre los resultados y construye el árbol XML
                 * 4. Guarda el archivo XML generado en el sistema de archivos
                 * 
                 */
                
                //enlace a los datos de conexión
                require_once '../config/confDBPDO.php';

                try {
                    /**
                     * Conexión a la base de datos mediante PDO
                     * Configura el modo de error para lanzar excepciones
                     * 
                     * @var PDO $miDB Objeto de conexión a la base de datos
                     */
                    //Conexion a la base de datos
                    $miDB = new PDO(DNS, USUARIODB, PSWD);
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
                     * Objeto SimpleXMLElement para construir la estructura XML
                     * Inicializado con la declaración XML y el elemento raíz 'departamentos'
                     * 
                     * @var SimpleXMLElement $xml Objeto que representa el documento XML
                     */
                    //https://www.php.net/manual/es/book.simplexml.php
                    //https://www.w3schools.com/php/php_ref_simplexml.asp
                    //creacion del objeto XML
                    $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><departamentos></departamentos>');

                    /**
                     * Itera sobre cada departamento recuperado de la base de datos
                     * Crea un elemento 'departamento' con sus hijos 'codDpto' y 'descDpto'
                     * 
                     * @var objeto $oDepartamento Objeto con los datos de cada departamento
                     * @var SimpleXMLElement $elemento Elemento XML 'departamento' añadido al árbol
                     */
                    while ($oDepartamento = $consultaPreparada->fetchObject()) {
                        $elemento = $xml->addChild('departamento');
                        $elemento->addChild('codDpto', $oDepartamento->T02_CodDepartamento);
                        $elemento->addChild('descDpto', $oDepartamento->T02_DescDepartamento);
                    }

                    /**
                     * Ruta absoluta donde se guardará el archivo XML generado
                     * 
                     * @var string $rutaFichero Ruta completa del archivo de destino
                     */
                    /*Se guarda el fichero en la carpeta tmp.
                    Es importante que la carpeta tmp tenga permisos de lectura y escritura para que php pueda guardar el fichero departamentos.php
                    para ello se ejecutan estos commandos en el servidor
                    sudo chown -R www-data:www-data /var/www/html/VGDWESProyectoTema4/tmp
                    sudo chmod 775 /var/www/html/VGDWESProyectoTema4/tmp
                    Hay que mirar si el fichero está en la capreta tmp del servidor 
                     porque no se ve en la carpeta tmp de netbeans si no se descarga manualmente
                     */
                    $rutaFichero = '../tmp/departamentos.xml';

                    /**
                     * Guarda el objeto XML como archivo en el sistema de archivos
                     */
                    $xml->asXML($rutaFichero);
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
                     * Por ejemplo, errores al crear o guardar el archivo XML
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
    <footer>
        <a href="../indexProyectoTema3.php">Alejandro De la Huerga Fernández</a>
        <a href="https://github.com/alejandrohuerga/AHFDWESProyectoTema3.git">
            <img src="../doc/images/github-logo.png"> 
        </a>
    </footer> 
</html>
