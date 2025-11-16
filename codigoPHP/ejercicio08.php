<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ejercicio 08 - Alejandro De la Huerga</title>
    </head>
    <body>
        <?php
            /**
             * @author Alejandro De la Huerga Fernández
             * @version 1.0
             * @date 2025-11-16 
             * 
             *
             * 8. Página web que toma datos (código y descripción) de la tabla Departamento y guarda en un
               fichero departamento.xml. (COPIA DE SEGURIDAD / EXPORTAR). El fichero exportado se
               encuentra en el directorio .../tmp/ del servidor.
            
                 * Script para exportar departamentos de la base de datos a un archivo XML
                 * 
                 * Este archivo realiza las siguientes operaciones:
                 * 1. Consulta los departamentos almacenados en la base de datos
                 * 2. Crea un objeto SimpleXMLElement con la estructura XML
                 * 3. Itera sobre los resultados y construye el árbol XML
                 * 4. Guarda el archivo XML generado en el sistema de archivos
                 * 
            */
        
            // Atributos para el establecimiento de conexión con la base de datos.
            // Utilizamos la variable super global $_SERVER para obtener la ip.

            $dsn = 'mysql:host=' . $_SERVER['SERVER_ADDR'] . ';dbname=DBAHFDWESProyectoTema4';  // Nombre de la base de datos
            $username = 'userAHFDWESProyectoTema4'; // Nombre de usuario de la base de datos
            $password = 'paso'; // password de la base de datos.
            
            try{
                
                // Realizamos la conexion con la base de datos.
                    $miDB=new PDO($dsn,$username,$password);
                    $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                // Consulta preparada
                
                    $sql='SELECT T02_CodDepartamento,T02_DescDepartamento FROM T02_Departamento';
                
                    $consultaPreparada = $miDB->prepare($sql);

                //Ejecución de la consulta
                    $consultaPreparada->execute();
                
                /**
                * Objeto SimpleXMLElement para construir la estructura XML
                * Inicializado con la declaración XML y el elemento raíz 'departamentos'
                * 
                * @var SimpleXMLElement $xml Objeto que representa el documento XML
                */
                
                // https://www.php.net/manual/es/class.simplexmlelement.php
                
                // Creación del objeto con el constructor de la clase.
                // Crea la etiqueta raiz con el parametro que le pasemos.
                
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
                
                /*
                * Creacion de la ruta de guardaddo del fichero.
                * 
                */
                    
                    $ruta='../tmp/departamentos.xml';
                
                /*
                 * Debemos darle al servidor permisos de lectura y escritura en la carpeta en la cual se va 
                   a guardar el documento XML.
                 * Utilizaremos los siguientes comandos para ello:
                 * 
                 * sudo chown -R www-data:www-data /var/www/html/AHFDWESProyectoTema4/tmp
                 * sudo chmod 775 /var/www/html/AHFDWESProyectoTema4/tmp
                 * 
                 * Mirar en el MobaXterm si el fichero se ha creado correctamente ya que NetBeans no lo descarga automaticamente
                   hay que hacerlo manualmente.
                */
                    
                // Guardamos el fichero en la ruta indicada.
                    
                    $xml->asXML($ruta);
                    echo "<p>Ruta generada: $ruta</p>";
                    
                // Mensaje de confirmación
                    
                echo "<h3>Archivo creado exitosamente en la ruta: <b>{$ruta}</b></h3>";
                
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
    </body>
</html>
