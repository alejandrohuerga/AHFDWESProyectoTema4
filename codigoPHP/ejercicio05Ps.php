<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>EJERCICIO 05 - CONSULTA PREPARADA</title>
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
                flex-direction: column;
                align-items: center;
                justify-content: center;
                font-size: 1.2rem;
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
            <h1>TEMA 4 : TÉCNICAS DE ACCESO PHP</h1>
            <h2>EJERCICIO 5 - CONSULTA PREPARADA</h2>
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
            
            //enlace a los datos de conexión
            require_once '../config/confDBPDO.php';
            
            
            //Array en el cual estan almacenados los departamentos a registrar (Array que almacena array con los datos de inserción en cada campo).
            $aDepartamentos = [
                [
                    "CodDepartamentoInsertar" => "TES", //codigo de departamento de formacion
                    "DescDepartamentoInsertar" => "Departamento de Transporte", //descripcion del departamento de Transporte
                    "VolumenDeNegocioInsertar" => "123523.32" //volumen de negocio del departamento de Transporte
                ],
                [
                    "CodDepartamentoInsertar" => "ROB", //codigo de departamento de Robotica
                    "DescDepartamentoInsertar" => "Departamento de Robotica", //descripcion del departamento Robotica
                    "VolumenDeNegocioInsertar" => "15826" //volumen de negocio del departamento Robotica
                ],
                [
                    "CodDepartamentoInsertar" => "RHH", //codigo de departamento de Recursos Humanos
                    "DescDepartamentoInsertar" => "Departamento de Recursos Humanos", //descripcion del departamento  de Recursos Humanos
                    "VolumenDeNegocioInsertar" => "125" //volumen de negocio del departamento PPP
                ] 
            ];
            
            try {
                //hacemos la conexion
                $miDB = new PDO(DNS, USUARIODB, PSWD);
                $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                //desactivamos el modo autocommit
                $miDB->beginTransaction();
                
                // Consulta preparada
                $sql=<<<query
                        INSERT INTO T02_Departamento (T02_CodDepartamento,T02_DescDepartamento,T02_FechaCreacionDepartamento,
                        T02_VolumenDeNegocio) VALUES (:codigo,:descripcion,now(),:volumen);
                    query;
                
                $consultaPreparada=$miDB->prepare($sql);
                
                foreach ($aDepartamentos as $departamento){
                    
                    $consultaPreparada->bindParam(':codigo', $departamento['CodDepartamentoInsertar']);
                    $consultaPreparada->bindParam(':descripcion', $departamento['DescDepartamentoInsertar']);
                    $consultaPreparada->bindParam(':volumen', $departamento['olumenDeNegocioInsertar']);

                    $consultaPreparada->execute();
                }
                
                //hacemos el commit
                $miDB->commit();
                
                //si todo ha ido bien mostramos todos los registros
                $resultadoDepartamentos = $miDB->query("select * from T02_Departamento");
                print '<table>';
                print '<tr><th>Codigo Departamento</th><th>Descripcion Departamento</th><th>Fecha Alta</th><th>Volumen Negocio</th><th>Fecha Baja</th></tr>';
                $mostrarDepartamentos = $resultadoDepartamentos->fetchObject();
                while ($mostrarDepartamentos != null) {
                    
                    while ($mostrarDepartamentos != null) {
                        print"<tr>";
                        echo "<td>$mostrarDepartamentos->T02_CodDepartamento</td>";
                        echo "<td>$mostrarDepartamentos->T02_DescDepartamento</td>";
                        echo "<td>$mostrarDepartamentos->T02_FechaCreacionDepartamento</td>";
                        echo "<td>$mostrarDepartamentos->T02_VolumenDeNegocio</td>";
                        echo "<td>$mostrarDepartamentos->T02_FechaBajaDepartamento</td>";
                        print"</tr>";
                        $mostrarDepartamentos = $resultadoDepartamentos->fetchObject();
                    }
                    
                }
                
                print '</table>';
                
            } catch (PDOException $miExcepcionPDO) {
                //revierte los cambios
                $miDB->rollBack();
                echo "<br>Transacción fallida. Cambios deshechos (ROLLBACK).";
                //mostramos el mensaje de error
                echo $miExcepcionPDO->getMessage();
            } finally {
                //nos desconectamos de la base de datos
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
