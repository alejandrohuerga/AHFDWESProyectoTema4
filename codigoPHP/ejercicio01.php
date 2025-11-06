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
            
                $miDB= new PDO(DSN,USERNAME,PASSWORD);
                echo 'Conectado a la Base de Datos correctamente </br>';
            try{
                
            } catch (PDOException $miExceptionPDO) {
                echo 'Error: '.$miExceptionPDO->getMessage();
                echo '<br>';
                echo 'Código de error: '.$miExceptionPDO->getCode();
            }
            
        ?>
    </body>
</html>
