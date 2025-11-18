<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ejercicio 02 - Consulta Preparada</title>
        <!--<link rel="stylesheet" href="../webroot/css/estilosEjercicio02.css"/> -->
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
                padding: 6px;
                border: 2px solid black ;

            }

            td{
                padding: 6px;
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
            <h2>EJERCICIO 02 - CONSULTA PREPARADA</h2>
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

                // Atributos para el establecimiento de conexión con la base de datos.
                // Utilizamos la variable super global $_SERVER para obtener la ip.

                $dsn= 'mysql:host='.$_SERVER['SERVER_ADDR'].';dbname=DBAHFDWESProyectoTema4';  // Nombre de la base de datos
                $username = 'userAHFDWESProyectoTema4'; // Nombre de usuario de la base de datos
                $password = 'paso'; // password de la base de datos.

                $numRegistros=0; // Variable para contar el numero de registros que devuelve la consulta.
                //
                // Consulta no preparada.
                $sqlDepartamentos='SELECT * FROM T02_Departamento';
                // Conexión a la base de datos con los datos correctos.

                echo '<h3>Contenido de la tabla T02_Departamento</h3>';

                 try{   
                    // Establecimiento de conexion mediante la instancia un objeto PDO
                    $miDB= new PDO($dsn,$username,$password);
                    $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                          
                    $sql = "SELECT * FROM T02_Departamento ";
                    
                    // Consulta preparada.        
                    $consultaPreparada2=$miDB->prepare($sql);
                    $consultaPreparada2->execute();
                        
                        // Tabla para mostrar los registros de la tabla departamentos.
                        echo '<table>';
                        echo '<tr>';
                        echo '<th>Codigo del Departamento</th>';
                        echo '<th>Descripcion del Departamento</th>';
                        echo '<th> Fecha Alta</th>';
                        echo '<th>Volumen del Negocio</th>';
                        echo '<th>Fecha Baja</th>';
                        echo '</tr>';
                        
                    while($registro = $consultaPreparada2->fetchObject()){
                        echo '<tr>';
                        echo '<td>'.$registro->T02_CodDepartamento.'</td>';
                        echo '<td>'.$registro->T02_DescDepartamento.'</td>';
                        $oFechaCreacion = new DateTime($registro->T02_FechaCreacionDepartamento);
                        echo '<td>'. $oFechaCreacion->format("d-m-Y") .'</td>';
                        echo '<td>'.$registro->T02_VolumenDeNegocio.'</td>';
                    if (!is_null($registro->T02_FechaBajaDepartamento)) {
                         //si no se pone la condición la fecha no es null
                        $oFechaBaja = new DateTime($registro->T02_FechaBajaDepartamento);
                        echo '<td>' . $oFechaBaja->format("d-m-Y") . '</td>';
                     } else {
                        echo '<td>Activo</td>';
                    }
                            
                        echo '</tr>';
                    }
                        
                    // Consulta preparada para sacar el numero de registros.
                     echo '</table>';   
                    $numRegistros=$miDB->prepare('SELECT COUNT(*) FROM T02_Departamento');
                    $numRegistros->execute();
                    $total=$numRegistros->fetchColumn();
                        
                    echo '<h3>Numero de registros: '.$total.'</h3>';
                        
                } catch (PDOException $miExceptionPDO) {
                    echo 'Error: '.$miExceptionPDO->getMessage();
                    echo '<br>';
                    echo 'Código de error: '.$miExceptionPDO->getCode();  
                } finally{ 
                    unset($miDB); 
                }
            ?>
        </main>
        <footer>
            <a href="/AHFDWESProyectoTema4/indexProyectoTema4.php">
                <p>Alejandro De la Huerga</p>
            </a>
            <a href="https://github.com/alejandrohuerga/AHFDWESProyectoTema4.git">
                <img src="../doc/images/github-logo.png" class="logo" alt=""/>
            </a>
        </footer>
    </body>
</html>
