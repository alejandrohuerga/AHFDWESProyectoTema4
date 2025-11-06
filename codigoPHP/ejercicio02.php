<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ejercicio 2 - Alejandro De la Huerga</title>
    </head>
    <body>
        <h1>TEMA 4 : TÉCNICAS DE ACCESO PHP</h1>
        <h2>EJERCICIO 02</h2>
        <?php
        /**
         * @author: Alejandro De la Huerga
         * @since: 06/11/2025
         * 2. Mostrar el contenido de la tabla Departamento y el número de registros.
        */
        
            const DSN = 'mysql:host=10.199.8.195; dbname=DBAHFDWESProyectoTema4';
            const USERNAME = 'userAHFDWESProyectoTema4';
            const PASSWORD = 'paso';
            
            // Conexión a la base de datos con los datos correctos.
        
            echo '<h3>Conexión a la base de datos DBAHFDWESProyectoTema4 correctamente</h3>';
            try{
                $miDB= new PDO(DSN,USERNAME,PASSWORD);
                echo 'Conectado a la Base de Datos correctamente </br>';
                
                echo 'Consulta sin preparar';
                $sqlDepartamentos='SELECT * FROM T02_Departamento';
                $resultadoDepartamentos=$miDB->query('SELECT * FROM T02_Departamento');
                
                
                echo '<table>';
                echo '<tr>';
                echo '<th>T02_CodDepartamento</th>';
                echo '<th>T02_DescDepartamento</th>';
                echo '<th>T02_FechaCreacionDepartamento</th>';
                echo '<th>T02_VolumenDeNegocio</th>';
                echo '<th>T02_FechaBajaDepartamento</th>';
                echo '</tr>';
                echo '</table>';
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
