<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ejercicio 07 - Alejandro De la Huerga</title>
    </head>
    <body>
        <header>
            <h1>Ejercicio 07</h1>
            <h2>Alejandro De la Huerga</h2>
        </header>
        <main>
        <?php
            /**
             * @author Alejandro De la Huerga Fernández
             * @version 1.0
             * @date 2025-11-16 
             * 
             *
             * 7. Página web que toma datos (código y descripción) de un fichero xml y los añade a la tabla
               Departamento de nuestra base de datos. (IMPORTAR). El fichero importado se encuentra en el
               directorio .../tmp/ del servidor

            */
        
            // Atributos para el establecimiento de conexión con la base de datos.
            // Utilizamos la variable super global $_SERVER para obtener la ip.

            $dsn = 'mysql:host=' . $_SERVER['SERVER_ADDR'] . ';dbname=DBAHFDWESProyectoTema4';  // Nombre de la base de datos
            $username = 'userAHFDWESProyectoTema4'; // Nombre de usuario de la base de datos
            $password = 'paso'; // password de la base de datos.
            
            // Variable que contiene la ruta absoluta del fichero Xml.
            
            $ruta='../tmp/departamentos.xml';
            
            /*
             * Verificamos que el fichero XML existe en la ruta especificada.
             * Si no existe termina la ejecución.
            */
            
            if (!file_exists($ruta)) {
                    exit('<p style="color:red;">Error: No se encuentra el fichero XML.</p>');
            }
            
            /*
             * 1.- Cargamos el fichero XML si existe.
             * 2.- Lo pasamos a objeto SimpleXml.
             */
            
            $xml= simplexml_load_file($ruta);
            
            try{
                // Realizamos la conexion con la base de datos.
                $miDB=new PDO($dsn,$username,$password);
                $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                
                // Iniciamos la transación
                
                $miDB->beginTransaction();
                
                // Consulta preparada para insertar los datos.
                
                $sql = <<<SQL
                        INSERT INTO T02_Departamento 
                        (T02_CodDepartamento, 
                        T02_DescDepartamento, 
                        T02_VolumenDeNegocio) 
                        VALUES (:codigo, :descripcion, :volumen)
                    SQL;
                
                $consultaPreparada = $miDB->prepare($sql);
                
                /*
                 * Recorremos cada elemento del fichero con un foreach.
                 * Convierte cada elemento del Xml a cada dato correcto para insertarlo en la tabla.
                */
                
                foreach ($xml->departamento as $dep) {
                    $codigo = (string) $dep->codDpto;
                    $descripcion = (string) $dep->descDpto;
                    $volumen = isset($dep->volumen) ? (float) $dep->volumen : 0.00;

                    $consultaPreparada->bindParam(':codigo', $codigo);
                    $consultaPreparada->bindParam(':descripcion', $descripcion);
                    $consultaPreparada->bindParam(':volumen', $volumen);

                    // Ejecución de la consulta
                    $consultaPreparada->execute();
                    echo "<p style='color:green;'>Insertado: $codigo - $descripcion</p>";
                }
                
                // CONFIRMAR TRANSACCIÓN
                $miDB->commit();
                echo "<h3 style='color:green;'>Datos insertados correctamente desde el XML.</h3>";
                    
            }  catch (PDOException $miExceptionPDO) {
                    /**
                     * Captura errores de PDO durante la transacción
                     * Revierte los cambios si la transacción está activa
                     * Muestra información detallada del error
                     * 
                     * @var PDOException $miExceptionPDO Excepción lanzada por PDO
                     */
                    // Errores de la base de datos
                    if ($miDB && $miDB->inTransaction()) {
                        $miDB->rollBack();
                    }
                    echo "<h3 style='color:red;'>Error en la base de datos.</h3>";
                    echo "<p><b>Mensaje:</b> " . $miExceptionPDO->getMessage() . "</p>";
                    echo "<p><b>Código:</b> " . $miExceptionPDO->getCode() . "</p>";
                } finally {
                    /**
                     * Cierra la conexión a la base de datos
                     * Se ejecuta siempre, independientemente de si hubo errores
                     */
                    unset($miDB); // Cerrar conexión
                }
            
            
        
        
        ?>
        </main>
    </body>
</html>
