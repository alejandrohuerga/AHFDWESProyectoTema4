<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ejercicio 03 Consulta Preparada - Alejandro de la Huerga</title>
        <link rel="stylesheet" href="../webroot/css/estilosEjercicio03.css"/>
    </head>
    <body>
    <main>
        <header>
            <h1>TEMA 4 : TÉCNICAS DE ACCESO PHP</h1>
            <h2>EJERCICIO 3</h2>
        </header>
            <?php
            /**
             * @author Alejandro De la Huerga Fernández
             * @version 1.0
             * @date 2025-11-05 
             * 
             *
             * Ejercicio 3 Consulta Preparada
             * *Formulario para añadir un departamento a la tabla Departamento con validación de entrada y control de errores.
             */
            
                //enlace para importar las librerías de validación de campos
                
                require_once '../core/231018libreriaValidacion.php';

                //enlace a los datos de conexión
                require_once '../config/confDBPDO.php';
                
                
            // Array que almacena los errores
            
                $aErrores=[
                    'T02_CodDepartamento' =>'',
                    'T02_DescDepartamento' =>'',
                    'T02_VolumenDeNegocio'=>'',  
                ];
            
            // Array que almacena las respuestas , inicializadas a null
            
                $aRespuestas=[
                    'T02_CodDepartamento' =>null,
                    'T02_DescDepartamento' =>null,
                    'T02_VolumenDeNegocio'=>null,   
                ];
                
            
                
                define('OBLIGATORIO',1); // Constante booleana que define que un campo es obligatorio.
                $entradaOK=true; //Variable booleana que valida que la entrada esta bien , inicializada a true.
                
                
                if(isset($_REQUEST['enviar'])){ // código que se ejecuta cuando se envia el formulario.
                    
                    $aErrores['T02_CodDepartamento']= validacionFormularios::comprobarAlfabetico($_REQUEST['T02_CodDepartamento'], 3, 3, OBLIGATORIO);
                    $aErrores['T02_DescDepartamento']= validacionFormularios::comprobarAlfabetico($_REQUEST['T02_DescDepartamento'], 255, 1, OBLIGATORIO);
                    $aErrores['T02_VolumenDeNegocio']= validacionFormularios::comprobarFloat($_REQUEST['T02_VolumenDeNegocio'], PHP_FLOAT_MAX, 0, OBLIGATORIO);
                    
                    
                // Si en el array de errores encuentra un error la variable entradaOK pasa a un valor false.
                
                    foreach ($aErrores as $campo => $valor) {
                        if($valor!=null){ // Si ha habido algun error $entradaOK es falso.
                            $entradaOK=false;
                        }else{
                            $aRespuestas[$campo]=$_REQUEST[$campo]; // Guardamos el dato correcto en el array de Respuestas.
                        }
                    }   
                    
                }else{
                    $entradaOK=false; // Si el formulario no se ha rellenado nunca.
                }
                
            // Tratamiento del formulario.
            
                if($entradaOK){
                    $aRespuestas['T02_CodDepartamento']=$_REQUEST['T02_CodDepartamento'];
                    $aRespuestas['T02_DescDepartamento']=$_REQUEST['T02_DescDepartamento'];
                    $aRespuestas['T02_VolumenDeNegocio']=$_REQUEST['T02_VolumenDeNegocio'];
                    
                    try{
                        
                    // Establecimiento de conexion mediante la instancia un objeto PDO
                    $miDB = new PDO(DNS, USUARIODB, PSWD);
                        
                    // Preparacon de la consulta con query.
                        
                        $sql=<<<EOT
                            INSERT INTO T02_Departamento (T02_CodDepartamento,T02_DescDepartamento,
                            T02_FechaCreacionDepartamento,T02_VolumenDeNegocio) 
                            VALUES (
                                '{$aRespuestas['T02_CodDepartamento']}',
                                '{$aRespuestas['T02_DescDepartamento']}',
                                 NOW(),
                                '{$aRespuestas['T02_VolumenDeNegocio']}'
                            );   
                        EOT;
                                
                        $miDB->query($sql);
                        
                        echo "<p style='color:green; font-weight:bold;'>DEPARTAMENTO INSERTADO CORRECTAMENTE</p>";
                        
                    } catch (PDOException $miExceptionPDO) {
                        echo 'Error: '.$miExceptionPDO->getMessage();
                        echo '<br>';
                        echo 'Código de error: '.$miExceptionPDO->getCode();  
                    } finally{ 
                        unset($miDB); 
                    }
                    
                    //Se recorre el array de las respuestas y se muestran

                    foreach ($aRespuestas as $campo => $valorCampo) {
                        echo("$campo del usuario : " . $valorCampo . '</br>');
                    }
                }else{ 
                // Si no se ha ingresado correctamente volvemos a mostrar el formulario.
                ?>
                <section class="formulario">
                    <h2>Inserta un nuevo departamento</h2>
                    <form name="formulario" action=<?php echo $_SERVER["PHP_SELF"]; ?> method="post">
                            <label for="T02_CodDepartamento">T02_CodDepartamento:
                                <input style="background-color:lightgoldenrodyellow; text-transform: uppercase;" type="text" name="T02_CodDepartamento"  
                                        value='<?php echo (empty($aErrores['T02_CodDepartamento'])) ? ($_REQUEST['T02_CodDepartamento'] ?? '') : ''; ?>'/>
                                <a style=color:red;> <?php echo $aErrores['T02_CodDepartamento'] ?>  </a>
                            </label>
                            <br/>
                            <label for="T02_DescDepartamento">T02_DescDepartamento:
                                <input style="background-color:lightgoldenrodyellow;" type="text" name="T02_DescDepartamento"  
                                        value='<?php echo (empty($aErrores['T02_DescDepartamento'])) ? ($_REQUEST['T02_DescDepartamento'] ?? '') : ''; ?>'/>
                                <a style=color:red;> <?php echo $aErrores['T02_DescDepartamento'] ?>  </a>
                            </label>
                            <br/>
                            <label for="T02_FechaCreacionDepartamento">T02_FechaCreacionDepartamento:
                                <input style="background-color:lightgrey;" name="T02_FechaCreacionDepartamento" id="T02_FechaCreacionDepartamento" 
                                       type="date" value="<?php echo date('Y-m-d'); ?>" disabled>
                            </label>
                            <br/>
                            <label for="T02_VolumenDeNegocio">T02_VolumenDeNegocio:
                                <input style="background-color:lightgoldenrodyellow;" type="text" name="T02_VolumenDeNegocio"  
                                       value='<?php echo (empty($aErrores['T02_VolumenDeNegocio'])) ? ($_REQUEST['T02_VolumenDeNegocio'] ?? '') : ''; ?>'/>
                                <a style=color:red;> <?php echo $aErrores['T02_VolumenDeNegocio'] ?></a>
                            </label>
                            <br/>
                            <div class="botones">
                                <input type="submit" name="enviar" value="enviar">
                                <a class="cancelar" href="../indexProyectoTema4.php">Cancelar</a>
                            </div>
                    </form>
                <?php        
                }
                ?>
                </section>
                <section class="contenedorTabla">
                    <?php
                    
                        // Establecimiento de conexion mediante la instancia un objeto PDO
                        $miDB= new PDO($dsn,$username,$password);
                        
                        // Consulta no preparada.
                        $sqlDepartamentos='SELECT * FROM T02_Departamento';
                        $resultadoDepartamentos=$miDB->query($sqlDepartamentos);
                        
                        // Tabla para mostrar los registros de la tabla departamentos.
                        echo '<table>';
                        echo '<tr>';
                        echo '<th>T02_CodDepartamento</th>';
                        echo '<th>T02_DescDepartamento</th>';
                        echo '<th>T02_FechaCreacionDepartamento</th>';
                        echo '<th>T02_VolumenDeNegocio</th>';
                        echo '<th>T02_FechaBajaDepartamento</th>';
                        echo '</tr>';

                        while($registro = $resultadoDepartamentos->fetch(PDO::FETCH_ASSOC)){
                            echo '<tr>';
                            echo '<td>'.$registro['T02_CodDepartamento'].'</td>';
                            echo '<td>'.$registro['T02_DescDepartamento'].'</td>';
                            echo '<td>'.$registro['T02_FechaCreacionDepartamento'].'</td>';
                            echo '<td>'.number_format($registro['T02_VolumenDeNegocio'], 2, ",", ".").'</td>';
                            echo '<td>'.$registro['T02_FechaBajaDepartamento'].'</td>';
                            echo '</tr>';
                        }
                        echo '</table>';
                    ?>
                </section>
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
