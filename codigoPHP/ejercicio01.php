<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>EJERCICIO 01 - Alejandro De la Huerga</title>
        <style>
            *{
                box-sizing: border-box;
                margin: 0;
            }
            
            header{
                width: 100%;
                height: 12vh;
                background: lightblue;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
            }
            
            
            
            main{
                width: 100%;
                height: 60vh;
                padding-top: 50px;
                background: linen;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
            }
            
            section h3{
                font-size: 1.5rem;
                margin-bottom:25px;
                margin-top: 10px;
            } 
            section h3:nth-of-type(2){
                font-size: 1.5rem;
                margin-bottom:15px;
                margin-top: 40px;
            }
            
            h4{
                font-size: 1.4rem;
                margin-top: 20px;
                margin-bottom:20px;
            }
        </style>
    </head>
    <body>
        <header>
            <h1>TEMA 4 : TÉCNICAS DE ACCESO PHP</h1>
            <h2>EJERCICIO 01</h2>
        </header>
            <main>
                <section> 
                <?php

                /**
                 * @author: Alejandro De la Huerga
                 * @since: 03/11/2025
                 * 1. Conexión a la base de datos con la cuenta usuario y tratamiento de errores.
                    Utilizar excepciones automáticas siempre que sea posible en todos los ejercicios.
                */

                //enlace a los datos de conexión
                require_once '../config/confDBPDO.php';
                
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
                        $miDB = new PDO(DNS, USUARIODB, PSWD);
                        echo 'Conectado a la Base de Datos correctamente </br>';

                        echo '<h4><b>Atributos de la conexión</b></h4>';

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
            </section>
        </main>
    </body>
    <footer>
        <a href="../indexProyectoTema4.php">Alejandro De la Huerga Fernández</a>
        <a href="https://github.com/alejandrohuerga/AHFDWESProyectoTema4.git">
            <img src="../doc/images/github-logo.png"> 
        </a>
    </footer>
</html>
