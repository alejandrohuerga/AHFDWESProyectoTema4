<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ejercicio 04 - Alejandro De la Huerga</title>
        <link rel="stylesheet" href="../webroot/css/estilosEjercicio03.css"/>
        <style>
            .formulario h2{
                margin-bottom: 20px;
            }
        </style>
    </head>
    <body>
        <header>
            <h1>TEMA 4 : TÉCNICAS DE ACCESO PHP</h1>
            <h2>EJERCICIO 3</h2>
        </header>
        <main>
        <?php
            /**
             * @author Alejandro De la Huerga Fernández
             * @version 1.0
             * @date 2025-11-05 
             * 
             *
             * 4. Formulario de búsqueda de departamentos por descripción (por una parte del campo
                DescDepartamento, si el usuario no pone nada deben aparecer todos los departamentos).
            */
        
                //enlace para importar las librerías de validación de campos
                
                require_once '../core/231018libreriaValidacion.php';

                // Atributos para el establecimiento de conexión con la base de datos.
                // Utilizamos la variable super global $_SERVER para obtener la ip.
            
                $dsn= 'mysql:host='.$_SERVER['SERVER_ADDR'].';dbname=DBAHFDWESProyectoTema4';  // Nombre de la base de datos
                $username = 'userAHFDWESProyectoTema4'; // Nombre de usuario de la base de datos
                $password = 'paso'; // password de la base de datos.
                
                 // Array que almacena los errores
                
                $aErrores=[
                  'T02_DescDepartamento'=>''  
                ];
                
                // Array que almacena las respuestas , inicializadas a null
                
                $aRespuestas=[
                    'T02_DescDepartamento'=>null 
                ];
                
                define('OBLIGATORIO',0); // Constante booleana que define que un campo es obligatorio.
                $entradaOK=true; //Variable booleana que valida que la entrada esta bien , inicializada a true.
                        
                if(isset($_REQUEST['enviar'])){ // código que se ejecuta cuando se envia el formulario.
                      
                    $aErrores['T02_DescDepartamento']= validacionFormularios::comprobarAlfabetico($_REQUEST['T02_DescDepartamento'], 255, 1, OBLIGATORIO);
                    
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
                    
                    $aRespuestas['T02_DescDepartamento']=$_REQUEST['T02_DescDepartamento'];      
                    try{
                        
                    // Establecimiento de conexion mediante la instancia un objeto PDO
                        $miDB= new PDO($dsn,$username,$password);
                        
                    // Preparacon de la consulta con query.
                        
                        $sql="SELECT * FROM T02_Departamento WHERE T02_DescDepartamento LIKE '%$aRespuestas[T02_DescDepartamento]%';";
                                
                        $resultadoBusqueda=$miDB->query($sql);
                        
                        // Tabla para mostrar los registros de la tabla departamentos.
                        echo '<table>';
                        echo '<tr>';
                        echo '<th>T02_CodDepartamento</th>';
                        echo '<th>T02_DescDepartamento</th>';
                        echo '<th>T02_FechaCreacionDepartamento</th>';
                        echo '<th>T02_VolumenDeNegocio</th>';
                        echo '<th>T02_FechaBajaDepartamento</th>';
                        echo '</tr>';
                        
                        while($registro = $resultadoBusqueda->fetch(PDO::FETCH_ASSOC)){
                            echo '<tr>';
                            echo '<td>'.$registro['T02_CodDepartamento'].'</td>';
                            echo '<td>'.$registro['T02_DescDepartamento'].'</td>';
                            echo '<td>'.$registro['T02_FechaCreacionDepartamento'].'</td>';
                            echo '<td>'.$registro['T02_VolumenDeNegocio'].'</td>';
                            echo '<td>'.$registro['T02_FechaBajaDepartamento'].'</td>';
                            echo '</tr>';
                        }
                        
                        
                    } catch (PDOException $miExceptionPDO) {
                        echo 'Error: '.$miExceptionPDO->getMessage();
                        echo '<br>';
                        echo 'Código de error: '.$miExceptionPDO->getCode();  
                    } finally{ 
                        unset($miDB); 
                    }
                    
                    echo '<h3>Resultados de tu búsqueda</h3>';
                    
                }else{ 
                // Si no se ha ingresado correctamente volvemos a mostrar el formulario.
                ?>
            <section class="formulario">
                    <h2>Busca un departamento</h2>
                    <form name="formulario" action=<?php echo $_SERVER["PHP_SELF"]; ?> method="post">
                            <label for="T02_DescDepartamento">
                                <input type="text" name="T02_DescDepartamento"  
                                        value='<?php echo (empty($aErrores['T02_DescDepartamento'])) ? ($_REQUEST['T02_DescDepartamento'] ?? '') : ''; ?>'/>
                                <a style=color:red;> <?php echo $aErrores['T02_DescDepartamento'] ?>  </a>
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
        </main>
    </body>
    
</html>
