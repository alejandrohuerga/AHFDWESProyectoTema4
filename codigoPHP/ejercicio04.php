<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ejercicio 04 - Alejandro De la Huerga</title>
        <!--<link rel="stylesheet" href="../webroot/css/estilosEjercicio03.css"/>-->
        <style>
            *{
                box-sizing: border-box;
                margin: 0;
            }

            body {
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                font-family: Arial, sans-serif;
                background: lightslategray;
            }

            header{
                background: lightpink;
                width: 100%;
                height: 150px;                 /* puedes ajustar la altura */
                display: flex;                 /* activa flexbox */
                flex-direction: column;        /* los elementos uno debajo del otro */
                justify-content: center;       /* centra verticalmente */
                align-items: center;           /* centra horizontalmente */
                text-align: center;
            }
            
            .formulario {
                border:2px solid lightpink;
                border-radius:12px;
                padding:24px;
                background:#fff;
                width:100%;
                max-width:760px;
                margin: 20px auto;
                box-shadow:0 6px 20px rgba(0,0,0,0.06);
            }
            .formulario h2{
                margin-bottom: 15px;
            }
            main {
                text-align: center;
                flex: 1; /* empuja el footer abajo */
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: flex-start;
                height: 70vh;
            }
            header h1{
                margin-bottom: 10px;
                font-family: "Playfair Display", serif;
                font-size: 2.0rem;
            }
            
            /* BOTONES centrados y a la misma altura */
            .botones{
                display:flex;
                justify-content:center;
                gap:16px;
                margin-top:18px;
            }
            
            input[type="text"], input[type="date"]{
                flex:1;
                height:36px;
                width: 80%;
                border:1px solid black;
                border-radius:6px;
                padding:6px 10px;
                font-size:15px;
            }
            
            table{
                margin: 2rem auto;
                width: 70%;
                border: 2px solid black;
                border-collapse: collapse;
            }

            th{
                background: lightpink;
                padding: 5px;
                border: 2px solid black;
            }

            td{
                padding: 5px;
                border: 2px solid black;
                border-collapse: collapse;
                background: white;
            }
            .formulario h2{
                margin-bottom: 20px;
            }
            
            .formulario{
                height: 200px;
                
            }
            
            input[type="submit"], a.cancelar{
                background:#666;
                color:#fff;
                border:none;
                padding:10px 18px;
                border-radius:6px;
                font-size:16px;
                text-decoration:none;
                display:inline-flex;
                align-items:center;
                justify-content:center;
                min-width:120px;
            }

            input[type="submit"]:hover, a.cancelar:hover{
                background:#4d4d4d;
                cursor:pointer;
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
             * @date 2025-11-10 
             * 
             *
             * 4. Formulario de búsqueda de departamentos por descripción (por una parte del campo
                DescDepartamento, si el usuario no pone nada deben aparecer todos los departamentos).
            */
        
                //enlace para importar las librerías de validación de campos
                
                require_once '../core/231018libreriaValidacion.php';
                
                $numRegistros=0; // Variable para contar el numero de registros que devuelve la consulta.
                
                //enlace a los datos de conexión
                require_once '../config/confDBPDO.php';
                
                 // Array que almacena los errores
                
                $aErrores=[
                  'DescDepartamentoBuscar'=>''  
                ];
                
                // Array que almacena las respuestas , inicializadas a null
                
                $aRespuestas=[
                    'T02_DescDepartamento'=>null 
                ];
                
                define('OBLIGATORIO',0); // Constante booleana que define que un campo es obligatorio.
                $entradaOK=true; //Variable booleana que valida que la entrada esta bien , inicializada a true.
                        
                if(isset($_REQUEST['enviar'])){ // código que se ejecuta cuando se envia el formulario.
                      
                    //$aErrores['DescDepartamentoBuscar']= validacionFormularios::comprobarAlfabetico($_REQUEST['T02_DescDepartamento'], 255, 1, OBLIGATORIO);
                    
                    if (!empty($_REQUEST['T02_DescDepartamento'])) {
                        $aErrores['T02_DescDepartamento'] = validacionFormularios::comprobarAlfaNumerico($_REQUEST['T02_DescDepartamento'], 255, 0, 0);
                    }
                    
                // Si en el array de errores encuentra un error la variable entradaOK pasa a un valor false.
                
                    foreach ($aErrores as $campo => $valor) {
                        if($valor!=null){ // Si ha habido algun error $entradaOK es falso.
                            $entradaOK=false;
                        }else{
                            $aRespuestas[0]=$_REQUEST['T02_DescDepartamento']; // Guardamos el dato correcto en el array de Respuestas.
                        }
                    }   
                    
                }else{
                    $entradaOK=false; // Si el formulario no se ha rellenado nunca.
                }
                
                // Tratamiento del formulario.
            
                if($entradaOK){
                    
                    $aRespuestas['T02_DescDepartamento']=$_REQUEST['T02_DescDepartamento'];      
                    
                }
                // Si no se ha ingresado correctamente volvemos a mostrar el formulario.
                ?>
            <section class="formulario">
                    <h2>Busca un departamento</h2>
                    <form name="formulario" action=<?php echo $_SERVER["PHP_SELF"]; ?> method="post">
                            <label class="buscar" for="T02_DescDepartamento">
                                <input type="text" name="T02_DescDepartamento" class="buscar" 
                                        value='<?php echo (empty($aErrores['DescDepartamentoBuscar'])) ? ($_REQUEST['T02_DescDepartamento'] ?? '') : ''; ?>'/>
                                <a style=color:red;> <?php echo $aErrores['DescDepartamentoBuscar'] ?>  </a>
                            </label>
                            <br/>
                            <div class="botones">
                                <input type="submit" name="enviar" value="Buscar">
                            </div>
                    </form>
            </section>
                <?php 
                    try{
                        
                    // Establecimiento de conexion mediante la instancia un objeto PDO
                    $miDB = new PDO(DNS, USUARIODB, PSWD);
                        
                    // Preparacon de la consulta con query.
                        
                        $sql="SELECT * FROM T02_Departamento WHERE T02_DescDepartamento LIKE '%$aRespuestas[T02_DescDepartamento]%' ORDER BY T02_DescDepartamento;";
                                
                        $resultadoBusqueda=$miDB->query($sql);
                        
                        // Tabla para mostrar los registros de la tabla departamentos.
                        echo '<table>';
                        echo '<tr>';
                        echo '<th>Codigo del Departamento</th>';
                        echo '<th>Descripcion del Departamento</th>';
                        echo '<th> Fecha Alta</th>';
                        echo '<th>Volumen del Negocio</th>';
                        echo '<th>Fecha Baja</th>';
                        echo '</tr>';
                        
                        while($registro = $resultadoBusqueda->fetchObject()){
                            $numRegistros++;
                            echo '<tr>';
                            echo '<td>'.$registro->T02_CodDepartamento.'</td>';
                            echo '<td>'.$registro->T02_DescDepartamento.'</td>';
                            echo '<td>'.$registro->T02_FechaCreacionDepartamento.'</td>';
                            echo '<td>'.$registro->T02_VolumenDeNegocio.'</td>';
                            echo '<td>'.$registro->T02_FechaBajaDepartamento.'</td>';
                            echo '</tr>';
                        }
                        
                        echo '<h3>Numero de registros: '.$numRegistros.'</h3>';
                        
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
</html>
