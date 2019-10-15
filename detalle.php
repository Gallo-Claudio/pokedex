<?php include 'encabezado.html';
    error_reporting(0);



    $conexion = mysqli_connect("localhost","pokemon","poke1234","pokemons_vazquez_claudio");
    $id = $_GET['id'];
    $sql= "select pokemones.id, nombre, t1.tipo, t2.tipo, generaciones.generacion, imagen, descripcion from pokemones
       left outer join generaciones
       on pokemones.generacion = generaciones.id
       left outer join tipos as t1
       on pokemones.tipo1 = t1.id
       left outer join tipos as t2
       on pokemones.tipo2 = t2.id
       where pokemones.id='$id';";
    $resultado = mysqli_query($conexion,$sql);
    $lista = mysqli_fetch_all($resultado);
    $i=0;

        if(empty($lista[0][5])){
            $img="";
        }
        else{
            $img="<img src='img/".$lista[0][5]."' class='ppal'>";
        }

        if(empty($lista[0][3])){
            $img2="";
        }
        else{
            $img2="<img src='img/Tipo_".$lista[0][3].".gif' class='tipo'>";
        }

        echo "<section class='detalle-pokemon'>
                    <p class='destacado'>Descripción de ".$lista[0][1]."</p>
                    
                    <div class='caja2'>
                        ".$img."
                        <div class='linea'><p class='etiqueta'>Nombre: </p>".$lista[0][1]."</div>
                        <div class='linea'><p class='etiqueta'>Tipo/s :</p><img src='img/Tipo_".$lista[0][2].".gif' class='tipo'>
                        ".$img2."</div>
                        <div class='linea'><p class='etiqueta'>Generación: </p>".$lista[0][4]."</div>
                        <div class='linea'><p class='etiqueta'>Descripción: </p>".$lista[0][6]."</div>
                        <div class='limpia-float'></div>
                    </div>
             <a href='javascript:window.history.back();' class='volver'>Volver atrás</a>
             <div class='limpia-float'></div>
             </section>
             
             ";

    include 'pie.html';
?>