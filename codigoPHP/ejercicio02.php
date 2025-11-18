<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ejercicio 2 - Alejandro De la Huerga</title>
        <style>
            *{
                box-sizing: border-box;
                margin: 0;
            }

            header{
                background: lightpink;
                height: 100px;                 /* puedes ajustar la altura */
                display: flex;                 /* activa flexbox */
                flex-direction: column;        /* los elementos uno debajo del otro */
                justify-content: center;       /* centra verticalmente */
                align-items: center;           /* centra horizontalmente */
                text-align: center;
            }

            header h1{
                margin-bottom: 10px;
                font-family: "Playfair Display", serif;
                font-size: 2.0rem;
            }

            main {
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                text-align: center;
                height: 75vh;
            }
            
            
            h3{
                display: inline-block;
                text-align: center;
                margin: 10px;
                width: 30%;
                font-size: 1.5rem;
            }

            h3:nth-of-type(2){
                background-color: lightpink;
                border: 2px solid black;
            }

            table{
                width: 70%;
                border: 2px solid black;
            }

            th{
                background: lightpink;
                padding: 10px;
                border: 2px solid black ;

            }

            td{
                padding: 10px;
                border: 2px solid black;
                border-collapse: collapse;
            }

            footer{
                background: lightpink;
                height: 15vh;
                display: flex;                /* Activa Flexbox */
                justify-content: center;      /* Centra los elementos horizontalmente */
                align-items: center;          /* Centra verticalmente */
                gap: 40px;
                margin-top: auto;
            }

            footer img{
                width: 50px;
                height: 50px;
            }
        </style>   
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
            // Importación de la libreria de validación de formularios.
        
            require_once '../core/231018libreriaValidacion.php';
            
            //enlace a los datos de conexión
            require_once '../config/confDBPDO.php';
            
            $numRegistros=0; // Variable para contar el numero de registros que devuelve la consulta.
            // Consulta no preparada.
            $sqlDepartamentos='SELECT * FROM T02_Departamento';
            // Conexión a la base de datos con los datos correctos.
        
            echo '<h3>Contenido de la tabla T02_Departamento</h3>';
            
            try{
                $miDB = new PDO(DNS, USUARIODB, PSWD);
                
                
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
