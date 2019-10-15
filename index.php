<?php include 'encabezado.html'; ?>

    <section class="opciones">
        <a href="apc/" class="login">Ingresar al Panel</a>
        <p class="destacado">POKEDEX</p>
        <h2>Pokemones</h2>
        <div class="espacio-derecha"></div>
        <div class="espacio-izquierda"></div>

        <?php
        error_reporting(0);

        $conexion = mysqli_connect("localhost","pokemon","poke1234","pokemons_vazquez_claudio");
        if(!$conexion){
            echo "<p class='error error-panel'>ERROR de conexion a la BD</p>";
            die;
        }


        if (isset($_POST['enviar'])) {
            $busqueda = $_POST['busqueda'];

            if(!empty($busqueda)){

                $sql= "select pokemones.id, nombre, t1.tipo, t2.tipo, generaciones.generacion, imagen from pokemones
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
        <form method="POST" action="index.php" class="busqueda-w">
            <input type="text" name="busqueda" class="ingreso-busqueda-w"><br>
            <?php echo $error; ?>
            <button type="submit" name="enviar" class="guardar btn-busqueda">Buscar</button>
        </form>
        <?php
        while($i < count($lista)) {
            if(empty($lista[$i][5])){
                $img="";
            }
            else{
                $img="<img src='img/".$lista[$i][5]."'>";
            }

            if(empty($lista[$i][3])){
                $img2="";
            }
            else{
                $img2="<img src='img/Tipo_".$lista[$i][3].".gif' class='tipo'>";
            }

            echo "<div class='caja'>
                    <a href='detalle.php?id=".$lista[$i][0]."'>".$img."</a>
                     <div class='detalle'>
                    <a href='detalle.php?id=".$lista[$i][0]."'>".$lista[$i][1]."</a>
                    <img src='img/Tipo_".$lista[$i][2].".gif' class='tipo'>
                    ".$img2."
                    <p>".$lista[$i][4]."</p>
                </div>
              </div>";
            $i++;
        }
        ?>
    </section>
<?php include 'pie.html'; ?>