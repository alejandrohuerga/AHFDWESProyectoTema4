<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ejercicio 5 - Alejandro De la Huerga</title>
        <style>
            *{
                box-sizing: border-box;
                margin: 0;
            }
            
            header{
                width: 100%;
                height: 140px;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                background-color: lightblue;
            }
            
            main{
                height: 72vh;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.2rem;
            }
            
            footer{
                width: 100%;
                height: 130px;
                background: lightblue;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 30px;
            }
            
            footer img{
                width: 50px;
                height: auto;
            }
        </style>
    </head>
    <body>
        <header>
            <h1>TEMA 4 : TÉCNICAS DE ACCESO PHP</h1>
            <h2>EJERCICIO 5</h2>
        </header>
        <main>
            <?php
            /**
             * @author Alejandro De la Huerga Fernández
             * @version 1.0
             * @date 2025-11-12 
             * 
             *
             * 5. Pagina web que añade tres registros a nuestra tabla Departamento utilizando tres instrucciones
              insert y una transacción, de tal forma que se añadan los tres registros o no se añada ninguno.
             */
            $numRegistros = 0; // Variable para contar el numero de registros que devuelve la consulta.
            // Atributos para el establecimiento de conexión con la base de datos.
            // Utilizamos la variable super global $_SERVER para obtener la ip.

            $dsn = 'mysql:host=' . $_SERVER['SERVER_ADDR'] . ';dbname=DBAHFDWESProyectoTema4';  // Nombre de la base de datos
            $username = 'userAHFDWESProyectoTema4'; // Nombre de usuario de la base de datos
            $password = 'paso'; // password de la base de datos.

            try {
                $ejecucionCorrecta = true;
                //hacemos la conexion
                $miDB = new PDO($dsn, $username, $password);
                //desactivamos el modo autocommit
                $miDB->beginTransaction();
                //realizamos 3 inserciones 1 de ellas esta ya introducida la primary key
                $resultadoConsulta1 = $miDB->exec("INSERT INTO T02_Departamento (T02_CodDepartamento,T02_DescDepartamento,T02_VolumenDeNegocio,T02_FechaCreacionDepartamento) VALUES('TES','Departamento de Transporte',123523.32,now())");
                $resultadoConsulta2 = $miDB->exec("INSERT INTO T02_Departamento (T02_CodDepartamento,T02_DescDepartamento,T02_VolumenDeNegocio,T02_FechaCreacionDepartamento) VALUES('ROB','Departamento de Robótica',15826,now())");
                $resultadoConsulta3 = $miDB->exec("INSERT INTO T02_Departamento (T02_CodDepartamento,T02_DescDepartamento,T02_VolumenDeNegocio,T02_FechaCreacionDepartamento) VALUES('RHH','Departamento de Recursos Humanos',125,now())");

                //hacemos el commit
                $miDB->commit();

                //si todo ha ido bien mostramos todos los registros
                $resultadoDepartamentos = $miDB->query("select * from T02_Departamento");
                print '<table>';
                print '<tr><th>codDepartamento</th><th>descDepartamento</th><th>fechaBaja</th><th>volumenNegocio</th><th>fechaAlta</th></tr>';
                $mostrarDepartamentos = $resultadoDepartamentos->fetchObject();
                while ($mostrarDepartamentos != null) {
                    print"<tr>";
                    while ($mostrarDepartamentos != null) {
                        print"<tr>";
                        echo "<td>$mostrarDepartamentos->T02_CodDepartamento</td>";
                        echo "<td>$mostrarDepartamentos->T02_DescDepartamento</td>";
                        echo "<td>$mostrarDepartamentos->T02_FechaBajaDepartamento</td>";
                        echo "<td>$mostrarDepartamentos->T02_VolumenDeNegocio</td>";
                        echo "<td>$mostrarDepartamentos->T02_FechaCreacionDepartamento</td>";
                        $mostrarDepartamentos = $resultadoDepartamentos->fetchObject();
                    }
                    print "</tr>";
                }
                print '</table>';
            } catch (PDOException $miExcepcionPDO) {
                //revierte los cambios
                $miDB->rollBack();
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
        <a href="https://github.com/alejandrohuerga/AHFDWESProyectoTema4.git">
            <img src="../doc/images/github-logo.png"> 
        </a>
    </footer>
</html>
