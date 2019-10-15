<?php include '../encabezado.html'; ?>
<link  type="text/css" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link  type="text/css" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/modal.js"></script>
<script type="text/javascript" src="js/bootbox-all.js"></script>

<?php
    session_start();
    error_reporting(0);
    if (isset($_SESSION['selogueo']) && $_SESSION['selogueo'] == true) {
        echo "<button class='salir' onclick=\"location.href='salir.php'\">Salir</button>";
        echo "<p class='descripcion'>Panel de Pokedex</p>";
        echo "<div class='menu'><a href='ingresar.php'>Ingresar un nuevo Pokemon</a></div>";

        $conexion = mysqli_connect("localhost","pokemon","poke1234","pokemons_vazquez_claudio");

        if (isset($_POST['enviar'])) {
            $busqueda = $_POST['busqueda'];

            if(!$conexion){
                echo "<p class='error error-panel'>ERROR de conexion a la BD</p>";
                die;
            }

            if(!empty($busqueda)){

            $sql= "select pokemones.id, nombre, t1.tipo, t2.tipo, generaciones.generacion from pokemones
             left outer join generaciones
             on pokemones.generacion = generaciones.id
             left outer join tipos as t1
             on pokemones.tipo1 = t1.id
             left outer join tipos as t2
             on pokemones.tipo2 = t2.id
             WHERE nombre='$busqueda';";
            $resultado = mysqli_query($conexion, $sql);
            $lista = mysqli_fetch_all($resultado);

                if(empty($lista)){
                    $error="No existe ese Pokemon";
                    $sql= "select pokemones.id, nombre, t1.tipo, t2.tipo, generaciones.generacion, imagen from pokemones
                            left outer join generaciones
                            on pokemones.generacion = generaciones.id
                            left outer join tipos as t1
                            on pokemones.tipo1 = t1.id
                            left outer join tipos as t2
                            on pokemones.tipo2 = t2.id;";
                    $resultado = mysqli_query($conexion, $sql);
                    $lista = mysqli_fetch_all($resultado);
                    $i = 0;
                }else{
                  //  $lista = mysqli_fetch_all($resultado);
                    $i = 0;
                }

            } else {
                $sql= "select pokemones.id, nombre, t1.tipo, t2.tipo, generaciones.generacion, imagen from pokemones
               left outer join generaciones
               on pokemones.generacion = generaciones.id
               left outer join tipos as t1
               on pokemones.tipo1 = t1.id
               left outer join tipos as t2
               on pokemones.tipo2 = t2.id;";
                $resultado = mysqli_query($conexion, $sql);
                $lista = mysqli_fetch_all($resultado);
                $i = 0;
            }

        } else {
            $sql= "select pokemones.id, nombre, t1.tipo, t2.tipo, generaciones.generacion, imagen from pokemones
               left outer join generaciones
               on pokemones.generacion = generaciones.id
               left outer join tipos as t1
               on pokemones.tipo1 = t1.id
               left outer join tipos as t2
               on pokemones.tipo2 = t2.id;";
            $resultado = mysqli_query($conexion, $sql);
            $lista = mysqli_fetch_all($resultado);
            $i = 0;
        }
        ?>

        <form method="POST" action="panel-busqueda.php" class="busqueda">
            <label for="busqueda">Busqueda:</label>
            <input type="text" name="busqueda" class="ingreso-busqueda">
            <?php echo $error; ?>
            <button type="submit" name="enviar" class="guardar busqueda2">Buscar</button>
        </form>


        <?php

            echo "<table>
                <thead>
                  <tr>
                    <td class='nombre'>Nombre</td>
                    <td class='tipos'>Tipo 1</td>
                    <td class='tipos'>Tipo 2</td>
                    <td class='generacion'>Generación</td>
                    <td class='editar'>Editar</td>
                    <td class='borrar'>Borrar</td>
                  </tr>
                 </thead>
                 <tbody>";



        while($i < count($lista)) {
           /* if(empty($lista[$i][2])){
                $img="";
            }
            else{
                $img="<img src='uploads/".$lista[$i][2]."' width='42'>";
            }*/

            echo "<tr>
                    <td align='center' class='nombre-fila'>".$lista[$i][1]."</td>
                    <td style='padding-left: 10px' class='tipos-fila'>".$lista[$i][2]."</td>
                    
                    <td style='padding-left: 10px' class='tipos-fila'>".$lista[$i][3]."</td>
                    <td style='padding-left: 10px' class='generacion-fila'>".$lista[$i][4]."</td>
                    
                    
                    
                    
                    <td align='center' class='editar-fila'><a href='modificar.php?id=".$lista[$i][0]."'><img src='img/editar.png'></a></td>
                    <td align='center' class='borrar-fila'><a href='javascript:void(0)' data-id='".$lista[$i][0]."' data-nombre='".$lista[$i][1]."' class='dltBtn'><img src='img/borrar.png'></a></td>
                  </tr>";
        $i++;
        }
            echo "</tbody></table>";


    }else{
        header('location:index.php');
        exit();
    }
?>
<?php include '../pie.html'; ?>
