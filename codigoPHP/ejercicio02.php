<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ejercicio 2 - Alejandro De la Huerga</title>
        <link rel="stylesheet" href="../webroot/css/estilosEjercicio02.css"/>
    </head>
    <body>
        <header>
            <h1>TEMA 4 : TÉCNICAS DE ACCESO PHP</h1>
            <h2>EJERCICIO 02</h2>
        </header>
    <main>
        <?php
        /**
         * @author: Alejandro De la Huerga
         * @since: 06/11/2025
         * 2. Mostrar el contenido de la tabla Departamento y el número de registros.
        */
        
            $dsn= 'mysql:host='.$_SERVER['SERVER_ADDR'].';dbname=DBAHFDWESProyectoTema4';
            $username = 'userAHFDWESProyectoTema4';
            $password = 'paso';
            
            $numRegistros=0; // Variable para contar el numero de registros que devuelve la consulta.
            // Consulta no preparada.
            $sqlDepartamentos='SELECT * FROM T02_Departamento';
            // Conexión a la base de datos con los datos correctos.
        
            echo '<h3>Contenido de la tabla T02_Departamento</h3>';
            try{
                $miDB= new PDO(dsn,username,password);
                
                
                // Utilizamos query para consultas de SELECT.
                $resultadoDepartamentos=$miDB->query($sqlDepartamentos);
                
                
                echo '<table>';
                echo '<tr>';
                echo '<th>T02_CodDepartamento</th>';
                echo '<th>T02_DescDepartamento</th>';
                echo '<th>T02_FechaCreacionDepartamento</th>';
                echo '<th>T02_VolumenDeNegocio</th>';
                echo '<th>T02_FechaBajaDepartamento</th>';
                echo '</tr>';
                
                while($registro = $resultadoDepartamentos->fetch()){
                    $numRegistros++;
                    echo '<tr>';
                    echo '<td>'.$registro['T02_CodDepartamento'].'</td>';
                    echo '<td>'.$registro['T02_DescDepartamento'].'</td>';
                    echo '<td>'.$registro['T02_FechaCreacionDepartamento'].'</td>';
                    echo '<td>'.$registro['T02_VolumenDeNegocio'].'</td>';
                    echo '<td>'.$registro['T02_FechaBajaDepartamento'].'</td>';
                    echo '</tr>';
                }
                echo '</table>';
                
                echo '<h3>El número de registros es: '.$numRegistros.'</h3>';
            } catch (PDOException $miExceptionPDO) {
                echo 'Error: '.$miExceptionPDO->getMessage();
                echo '<br>';
                echo 'Código de error: '.$miExceptionPDO->getCode();  
            } finally{ 
                unset($miDB); 
            }
        ?>
    </main>
    </body>
    <footer>
        <a href="/AHFDWESProyectoTema4/indexProyectoTema4.php">
            <p>Alejandro De la Huerga</p>
        </a>
        <a href="https://github.com/alejandrohuerga/AHFDWESProyectoTema4.git">
            <img src="../doc/images/github-logo.png" class="logo" alt=""/>
        </a>
    </footer>
</html>
