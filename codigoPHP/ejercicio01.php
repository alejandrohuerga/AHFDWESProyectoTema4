<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>EJERCICIO 01 - Alejandro De la Huerga</title>
    </head>
    <body>
        <h1>TEMA 4 : TÉCNICAS DE ACCESO PHP</h1>
        <h2>EJERCICIO 01</h2>
        <?php
        
        /**
         * @author: Alejandro De la Huerga
         * @since: 03/11/2025
         * 1. Conexión a la base de datos con la cuenta usuario y tratamiento de errores.
            Utilizar excepciones automáticas siempre que sea posible en todos los ejercicios.
        */
        
        /* Preparación de los datos de conexión en constantes para luego usarlos como
           atributos al instanciar el objeto PDO.
        */
        
            const DSN = 'mysql:host=192.168.1.100; dbname=DBAHFDWESProyectoTema4';
            const USERNAME = 'userAHFDWESProyectoTema4';
            const PASSWORD = 'paso';
        
        // Array con los atributos de conexión para mostrarlos más adelante.
        
            $aAtributos= array(
                "AUTOCOMMIT", 
                "ERRMODE", 
                "CASE", 
                "CLIENT_VERSION", 
                "CONNECTION_STATUS",
                "ORACLE_NULLS", 
                "PERSISTENT", 
                "PREFETCH", 
                "SERVER_INFO", 
                "SERVER_VERSION",
                "TIMEOUT"
            );
        
        // Conexión a la base de datos con los datos correctos.
        
            echo '<h3>Conexión a la base de datos DBAHFDWESProyectoTema4 correctamente</h3>';
            try{
                $miDB= new PDO(DSN,USERNAME,PASSWORD);
                echo 'Conectado a la Base de Datos correctamente </br>';
                
                echo '<p><b>Atributos de la conexión</b></p>';
                
                foreach($aAtributos as $atributo){
                    echo "PDO::ATTR_$atributo";
                    try{
                        echo '<span class="azul">'.$miDB->getAttribute( constant( "PDO::ATTR_$atributo" ) ) . "</span><br>";
                    } catch (PDOException $miExceptionPDO){
                        echo '<span class="rojo"> <b>Error: </b>'.$miExceptionPDO->getMessage().' <b>con código de error:</b> '.$miExceptionPDO->getCode()."</span><br>";
                    }
                }
            } catch (PDOException $miExceptionPDO) {
                echo 'Error: '.$miExceptionPDO->getMessage();
                echo '<br>';
                echo 'Código de error: '.$miExceptionPDO->getCode();  
            } finally{ 
                unset($miDB); 
            }
        
        // Conexión a la base de datos con los datos incorrectos.
            
            echo '<h3>Conexión a la base de datos DBAHFDWESProyectoTema4 datos incorrectos</h3>';
            try{
                $miDB= new PDO(DSN,USERNAME,'error');
                echo 'Conectado a la Base de Datos correctamente </br>';
                
                echo '<p><b>Atributos de la conexión</b></p>';
                
                foreach($aAtributos as $atributo){
                    echo "PDO::ATTR_$atributo";
                    try{
                        echo '<span class="azul">'.$miDB->getAttribute( constant( "PDO::ATTR_$atributo" ) ) . "</span><br>";
                    } catch (PDOException $miExceptionPDO){
                        echo '<span class="rojo"> <b>Error: </b>'.$miExceptionPDO->getMessage().' <b>con código de error:</b> '.$miExceptionPDO->getCode()."</span><br>";
                    }
                }
            } catch (PDOException $miExceptionPDO) {
                echo 'Error: '.$miExceptionPDO->getMessage();
                echo '<br>';
                echo 'Código de error: '.$miExceptionPDO->getCode();  
            } finally{ 
                unset($miDB); 
            }
        ?>
    </body>
</html>
