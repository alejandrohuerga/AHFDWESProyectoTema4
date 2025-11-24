<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ejercicio 04 - Consulta Preparada</title>
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
                margin-bottom: 20px;
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
            
            #descripcion{
                margin: 20px;
            }
            
            #enviar{
                margin: 20px;
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
            <h2>EJERCICIO 4 - CONSULTA PREPARADA</h2>
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
            
            require_once '../core/231018libreriaValidacion.php';
            //Inicialización de variables
            $entradaOK = true;
            $aErrores = [
                'descripcion' => '',
            ];
            $aRespuestas = [
                'descripcion' => '',
            ];
            require_once '../config/confDBPDO.php';
            $descripcion = null;
            $sql = null;
            $miDB = new PDO(DNS, USUARIODB, PSWD);
            // Comprobar si el formulario se ha enviado
            if (isset($_REQUEST['enviar'])) {
                $aErrores['descripcion'] = validacionFormularios::comprobarAlfaNumerico($_REQUEST['descripcion'], 255, 1, 0);
                if (empty($aErrores['descripcion']) && preg_match('/[0-9]/', $_REQUEST['descripcion'])) {
                    $aErrores['descripcion'] = 'El campo solo puede contener letras (sin números).';
                }
                foreach ($aErrores as $campo => $valor) {
                    if ($valor != null) { // Si ha habido algun error $entradaOK es falso.
                        $entradaOK = false;
                    }
                }
            } else {
                // Formulario no enviado aún
                $entradaOK = false;
            }
            // Tratamiento del formulario
            ?>
            <div>
                <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                    <label for="descripcion">Buscar Departamento de:</label>
                    <input type="text" name="descripcion" id="descripcion" value="<?php echo(empty($aErrores['descripcion'])) ? ($_REQUEST['descripcion'] ?? '') : ''; ?>">
                    <span style="color:red;"><?php echo $aErrores['descripcion']; ?></span>

                    <input type="submit" name="enviar" value="Buscar" id="enviar">
                </form>
            </div>
            <?php
            if ($entradaOK) {
                foreach ($aRespuestas as $campo => $valor) {
                    $aRespuestas[$campo] = $_REQUEST[$campo];
                }
                $descripcion = $aRespuestas['descripcion'];

                try {
                    echo '<h3>RESULTADO DE BUSQUEDA: </h3>';

                    if (empty($aRespuestas['descripcion'])) {
                        $consulta = $miDB->prepare("SELECT * FROM T02_Departamento");
                        $consulta->execute();
                        $sql = $consulta->fetchAll(PDO::FETCH_OBJ);
                    } else {
                        $consulta = $miDB->prepare("
                        SELECT *
                        FROM T02_Departamento
                        WHERE T02_DescDepartamento LIKE :descripcion
                    ");

                        $param = "%" . $descripcion . "%";
                        $consulta->bindValue(':descripcion', $param);

                        $consulta->execute();
                        $sql = $consulta->fetchAll(PDO::FETCH_OBJ);
                    }
                    echo '<table>';
                    echo '<tr id="titulotabla"><td>Codigo de Departamento</td><td>Descripción</td><td>Fecha de Creación</td><td>Volumen de Negocio</td><td>Fecha de Baja</td></tr>';
                    // Con fetchAll() uso foreach() porque devuelve un array con todas las filas
                    foreach ($sql as $registro) {
                        echo '<tr>';
                        foreach (get_object_vars($registro) as $campo => $valor) {
                            if (!is_null($valor)) {
                                echo "<td>$valor</td>";
                            } else {
                                echo "<td>No Determinado</td>";
                            }
                        }
                        echo "</tr>";
                    }
                    echo '</table>';
                } catch (PDOException $miExceptionPDO) {
                    echo 'Error: ' . $miExceptionPDO->getMessage();
                    echo '<br>';
                    echo 'Código de error: ' . $miExceptionPDO->getCode();
                } finally {
                    unset($miDB);
                }
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
