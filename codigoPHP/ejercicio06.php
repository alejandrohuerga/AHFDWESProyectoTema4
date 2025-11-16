<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ejercicio 06 - Alejandro De la Huerga</title>
        <style>
            *{
                box-sizing: border-box;
                margin: 0;
            }
            
            header{
                width: 100%;
                height: 13vh;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                background: lightblue;
            }
            
            main{
                display: flex;
                align-items: center;
                justify-content: center;
                height: 74vh;
            }
            
            table{
                border: 1px solid black;
                
            }
            
            tr{
                border: 1px solid black;
                
            }
            
            th{
                background: lightblue;
                padding: 4px;
            }
            
            td{
                border: 1px solid black;
                padding: 4px;
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
            <h1>Alejandro De la Huerga</h1>
            <h2>Ejercicio 06</h2>
        </header>
        <main>
        <?php
            /**
             * @author Alejandro De la Huerga Fernández
             * @version 1.0
             * @date 2025-11-12 
             * 
             *
             * 6. Pagina web que cargue registros en la tabla Departamento desde un array departamentosnuevos
                  utilizando una consulta preparada. Probar consultas preparadas sin bind,
                  pasando los parámetros en un array a execute.
             */
        
             // Atributos para el establecimiento de conexión con la base de datos.
            // Utilizamos la variable super global $_SERVER para obtener la ip.

            $dsn = 'mysql:host=' . $_SERVER['SERVER_ADDR'] . ';dbname=DBAHFDWESProyectoTema4';  // Nombre de la base de datos
            $username = 'userAHFDWESProyectoTema4'; // Nombre de usuario de la base de datos
            $password = 'paso'; // password de la base de datos.
            
            //Array en el cual estan almacenados los departamentos a registrar (Array que almacena array con los datos de inserción en cada campo).
            $aDepartamentos = [
                ["T02_CodDepartamento" => "FOR",//codigo de departamento de formacion
                 "T02_DescDepartamento" => "Departamento de Formacion",//descripcion del departamento de Formacion
                 "T02_VolumenDeNegocio" => "1"],//volumen de negocio del departamento de Formacion
                ["T02_CodDepartamento" => "THR",//codigo de departamento de THR
                 "T02_DescDepartamento" => "Departamento de THR",//descripcion del departamento THR
                 "T02_VolumenDeNegocio" => "85"],//volumen de negocio del departamento THR
                ["T02_CodDepartamento" => "PPP",//codigo de departamento de PPP
                 "T02_DescDepartamento" => "Departamento de PPP",//descripcion del departamento  PPP
                 "T02_VolumenDeNegocio" => "1234.63"] //volumen de negocio del departamento PPP
            ];
            
            try{
                // Realizamos la conexion con la base de datos.
                $miDB=new PDO($dsn,$username,$password);
                $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                echo "<h3>Conexión establecida con éxito.</h3>";
                // Creamos la consulta con el insert
                
                $query2=<<< sql
                        INSERT INTO T02_Departamento (T02_CodDepartamento,T02_DescDepartamento,
                         T02_VolumenDeNegocio,T02_FechaCreacionDepartamento)
                        VALUES (:T02_CodDepartamento,:T02_DescDepartamento,:T02_VolumenDeNegocio,NOW());
                        sql;
                
                
                        
                foreach($aDepartamentos as $aDepartamento){
                    $parametrosConsulta=[
                        ":T02_CodDepartamento"=>$aDepartamento['T02_CodDepartamento'],
                        ":T02_DescDepartamento"=>$aDepartamento['T02_DescDepartamento'],
                        ":T02_VolumenDeNegocio"=>$aDepartamento['T02_VolumenDeNegocio']                       
                    ];
                    
                    // Preparación de la inserción.
                    $insert=$miDB->prepare($query2);
                    
                    // Insertamos los datos introducidos en el array.
                    $insert->execute($parametrosConsulta);
                }
                
                $resultadoDepartamentos=$miDB->query("SELECT * FROM T02_Departamento");
                
                print '<table>';
                print '<tr><th>Codigo Departamento</th><th>Descripcion Departamento</th><th>Fecha Alta</th><th>Volumen Negocio</th><th>Fecha Baja</th></tr>';
                $mostrarDepartamentos = $resultadoDepartamentos->fetchObject();
                while ($mostrarDepartamentos != null) {
                    print"<tr>";
                    while ($mostrarDepartamentos != null) {
                        print"<tr>";
                        echo "<td>$mostrarDepartamentos->T02_CodDepartamento</td>";
                        echo "<td>$mostrarDepartamentos->T02_DescDepartamento</td>";
                        echo "<td>$mostrarDepartamentos->T02_FechaCreacionDepartamento</td>";
                        echo "<td>$mostrarDepartamentos->T02_VolumenDeNegocio</td>";
                        echo "<td>$mostrarDepartamentos->T02_FechaBajaDepartamento</td>";
                        $mostrarDepartamentos = $resultadoDepartamentos->fetchObject();
                    }
                    print "</tr>";
                }
                print '</table>';
            } catch (PDOException $miExcepcionPDO) {
                //mostramos el mensaje de error
                echo $miExcepcionPDO->getMessage();
            } finally {
                //nos desconectamos de la base de datos
                unset($miDB);
            }
        ?>
        </main>
    </body>
    
    <footer>
        <a href="../indexProyectoTema3.php">Alejandro De la Huerga Fernández</a>
        <a href="https://github.com/alejandrohuerga/AHFDWESProyectoTema3.git">
            <img src="../doc/images/github-logo.png"> 
        </a>
    </footer> 
</html>
