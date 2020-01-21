
<style>
a:hover{text-decoration:none;}
</style>    
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header clearfix">
                    <h2 class="pull-left">Fichas de los usuarios</h2>
                </div>
                <form class="form-inline" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="no_imprimir">
                    <div class="form-group">
                    <div class="col-md-4">
                        <label class="col-md-4 control-label" for="alumno"></label>  
                        <input id="buscar" type="text" name="alumno" placeholder="Buscar Alumno" class="form-control input-md">
                    </div>
                    </div>
                        <button type="submit" class="btn btn-primary mb-2"> <span></span>  Buscar  <i class="fas fa-search"></i></button>
                    <!-- Aquí va el nuevo botón para dar de alta, podría ir al final -->
                    <!-- <a href="utilidades/descargar.php?opcion=PDF&id=all" class="btn btn-primary btn-default" target="_blank"><span class="fas far fa-file-pdf pl-1"></span>  PDF</a> -->
                    <a href="utilidades/descargar.php?opcion=PDF&id=all" class="btn btn-rounded btn-primary" target="_blank">pdf<i class="fas far fa-file-pdf pl-1"></i></a>
                    <a href="utilidades/descargar.php?opcion=XML&id=all" class="btn btn-rounded btn-primary" target="_blank">XML<i class="fas fas fa-file-alt pl-1"></i></a>
                    <!-- <a href="utilidades/descargar.php?opcion=XML&id=all" class="btn btn-primary btn-default" target="_blank"><span class="glyphicon glyphicon-cloud-download"></span> XML</a> -->
                    <a href="vistas/create.php" class="btn btn-success"><span></span>  Añadir Usuario/a <i class="fas fa-plus-circle"></i></a>
                    </div>
                </form>
            </div>
            <!-- Linea para dividir -->
            <div class="page-header clearfix">        
            </div>
            <?php
            session_start();
            // Incluimos los ficheros que ncesitamos
            // Incluimos los directorios a trabajar
            require_once CONTROLLER_PATH."ControladorUsuario.php";
            require_once CONTROLLER_PATH . "Paginador.php";
            require_once UTILITY_PATH."funciones.php"; 

            // creamos la consulta dependiendo si venimos o no del formulario
            // para el buscador: select * from alumnado where nombre like "%%" or apellidos like "%%"
            if (!isset($_POST["alumno"])) {
                $nombre = "";
            } else {
                $nombre = filtrado($_POST["alumno"]);
            }
            // Cargamos el controlador de alumnos
            $controlador = ControladorUsuario::getControlador();
            
            // Parte del paginador
            $pagina = ( isset($_GET['page']) ) ? $_GET['page'] : 1;
            $enlaces = ( isset($_GET['enlaces']) ) ? $_GET['enlaces'] : 10;


            //$lista = $controlador->listarAlumnos($nombre, $dni); //-- > Lo hará el paginador

             // Consulta a realizar -- esto lo cambiaré para la semana que viene
             $consulta = "SELECT * FROM usuario WHERE nombre LIKE :nombre";
             $parametros = array(':nombre' => "%".$nombre."%");
             $limite = 3; // Limite del paginador
             $paginador  = new Paginador($consulta, $parametros, $limite);
             $resultados = $paginador->getDatos($pagina);


            // Si hay filas (no nulo), pues mostramos la tabla
            //if (!is_null($lista) && count($lista) > 0) {
            if(count( $resultados->datos)>0){
                echo "<table class='table table-bordered table-striped'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>Nombre</th>";
                echo "<th>Apellido</th>";
                echo "<th>Email</th>";
                echo "<th>Password</th>";
                echo "<th>Admin</th>";
                echo "<th>Telefono</th>";
                echo "<th>F_alta</th>";
                echo "<th>Foto</th>";
                echo "</thead>";
                echo "<tbody>";
                // Recorremos los registros encontrados
                foreach ($resultados->datos as $a) {
                //foreach ($lista as $alumno) {
                    // Esto lo hago para no cambiaros el resto de codigo, si no podría usar a directamente
                    $alumno = new Usuario($a->id, $a->nombre, $a->apellido, $a->email, $a->password, $a->admin, $a->foto, $a->telefono, $a->f_alta);
                    // Pintamos cada fila
                    echo "<tr>";
                    echo "<td>" . $alumno->getNombre() . "</td>";
                    echo "<td>" . $alumno->getApellido() . "</td>";
                    // echo "<td>" . str_repeat("*",strlen($alumno->getPassword())) . "</td>";
                    echo "<td>" . $alumno->getEmail() . "</td>";
                    echo "<td>" . str_repeat("*",strlen($alumno->getPassword())) . "</td>";
                    echo "<td>" . $alumno->getAdmin() . "</td>";
                    echo "<td>" . $alumno->getTelefono() . "</td>";
                    echo "<td>" . $alumno->getF_alta() . "</td>";
                    echo "<td><img src='imagenes/usuarios/".$alumno->getFoto()."' width='48px' height='48px'></td>";
                    echo "<td>";
                    
                    // Abrimos las sesiones para leerla
                    
                    if(isset($_SESSION['USUARIO']['email'])){
                      // Menu de administrador
                      echo "<a href='vistas/read.php?id=" . encode($alumno->getId()) . "' title='Ver Alumno/a' data-toggle='tooltip'><span class='far fa-eye'></span>  </a>";
                      echo "<a href='vistas/update.php?id=" . encode($alumno->getId()) . "' title='Actualizar Alumno/a' data-toggle='tooltip'><span class='fas fa-pencil-alt'></span>  </a>";
                      echo "<a href='vistas/delete.php?id=" . encode($alumno->getId()) . "' title='Borar Alumno/a' data-toggle='tooltip'><span class='fas fa-trash-alt'></span>  </a>";
                      echo "</td>";
                      echo "</tr>";
                    } else{
                      // Menú normal

                    } 
                }
                echo "</tbody>";
                echo "</table>";
                echo "<ul class='pagination mx-auto justify-content-center' id='no_imprimir'>"; //  <ul class="pagination">
                echo $paginador->crearLinks($enlaces);
                echo "</ul>";
            } else {
                // Si no hay nada seleccionado
                echo "<p class='lead'><em>No se ha encontrado datos de alumnos/as.</em></p>";
            }
            ?>

        </div>
    </div>
    <div id="no_imprimir">
    <?php
        // Leemos la cookie
        if(isset($_COOKIE['CONTADOR'])){
            echo $contador;
            echo $acceso;
        }
        else
            echo "Es tu primera visita hoy";
    ?>
    </div>