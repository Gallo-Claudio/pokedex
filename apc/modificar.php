<?php
include '../encabezado.html';
session_start();
error_reporting(0);
    if (isset($_SESSION['selogueo']) && $_SESSION['selogueo'] == true) {
    ?>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

                <link rel=StyleSheet href="apc.css" type="text/css" media=screen>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">

                <script src="tinymce/tinymce.min.js"></script>
                <script>
                    tinymce.init({
                        selector: '#mytextarea',
                        width: 600,
                        height: 300,
                        plugins: [
                            'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
                            'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
                            'save table directionality emoticons template paste'
                        ],
                        content_css: 'css/content.css',
                        toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons',
                        toolbar2: 'fontselect',
                        font_formats: 'Arial=arial,helvetica,sans-serif; Courier New=courier new,courier,monospace; AkrutiKndPadmini=Akpdmi-n'

                    });
                </script>

                <?php
                    $error = "";
                    $conexion = mysqli_connect("localhost","pokemon","poke1234","pokemons_vazquez_claudio");

                    if(!$conexion){
                        echo "<p class='error error-panel'>ERROR de conexion a la BD</p>";
                        die;
                    }

                    if (isset($_GET['id'])) {

                        $sql2= "select * from tipos";
                        $resultado2 = mysqli_query($conexion, $sql2);
                        $registro2 = mysqli_fetch_all($resultado2);

                        $sql3= "select * from generaciones";
                        $resultado3 = mysqli_query($conexion, $sql3);
                        $registro3 = mysqli_fetch_all($resultado3);


                        $id = $_GET['id'];
                        $sql= "select pokemones.id, nombre, t1.tipo, t2.tipo, generaciones.generacion, imagen, tipo1, tipo2, pokemones.generacion, descripcion from pokemones
                               left outer join generaciones
                               on pokemones.generacion = generaciones.id
                               left outer join tipos as t1
                               on pokemones.tipo1 = t1.id
                               left outer join tipos as t2
                               on pokemones.tipo2 = t2.id
                               where pokemones.id='$id';";
                        $resultado = mysqli_query($conexion, $sql);
                        if (!$resultado) {
                            $error = "Error - No se pudo encontrar ese Pokemon";
                        }
                        $registro = mysqli_fetch_all($resultado);

                    }


                            else if (isset($_POST['enviar'])){
                                $id = $_POST['id'];
                                $nombre = $_POST['nombre'];
                                $tipo1 = $_POST['tipo1'];
                                $tipo2 = $_POST['tipo2'];
                                $generacion = $_POST['generacion'];
                                $descripcion = $_POST['descripcion'];

                                    if(empty($_FILES['uploadedfile']['name'])){

                                        $sql= "UPDATE pokemones SET nombre='".$nombre."', tipo1='".$tipo1."', tipo2='".$tipo2."', generacion='".$generacion."', descripcion='".$descripcion."' where id='".$id."';";
                                        $resultado = mysqli_query($conexion,$sql);

                                        if(!$resultado){
                                            echo "<p class='error animated shake error-panel'>Error - No se pudieron guardar los cambios</p>
                                                <a href='panel-busqueda.php' class='volver-panel'>Volver al panel</a>";
                                            die;
                                        }
                                        else {
                                            header('location:panel-busqueda.php');
                                        }
                                        die;
                                    }
                                    else {
                                        $uploadedfileload = "true";
                                        $msg = "";
                                        $uploadedfile_size = $_FILES['uploadedfile']['size'];

                                        if ($_FILES['uploadedfile']['size'] > 200000) {
                                            $msg = $msg . "El archivo es mayor que 200KB, debes reducirlo antes de subirlo<BR>Te recomendamos usar http://webresizer.com/resizer/<BR>";
                                            $error = "<p class='error animated shake'>".$msg."</p>";
                                            $uploadedfileload = "false";
                                        }

                                        if (!($_FILES['uploadedfile']['type'] == "image/jpeg" OR $_FILES['uploadedfile']['type'] == "image/gif" OR $_FILES['uploadedfile']['type'] == "image/png")) {
                                            $msg = $msg . " Tu archivo tiene que ser JPG , PNG o GIF. Otros formatos de archivos no son permitidos<BR>";
                                            $error = "<p class='error animated shake'>".$msg."</p>";
                                            $uploadedfileload = "false";
                                        }


                                        if ($uploadedfileload == "true") {

                                            $file_name = $_FILES['uploadedfile']['name'];
                                            $add = "../img/$file_name";

                                            if (!move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $add)) {
                                                $error = "<p class='error animated shake'>Error al subir el archivo ".basename($_FILES['uploadedfile']['name'])."</p>";
                                            }

                                            //persiste en la BD
                                      //      $sql = "UPDATE noticias SET imagen='" . basename($_FILES['uploadedfile']['name']) . "', titulo='$titulo', nota='$desarrollo' where id='$id'";
                                            $sql = "UPDATE pokemones SET nombre='".$nombre."', tipo1='".$tipo1."', tipo2='".$tipo2."', generacion='".$generacion."', descripcion='".$descripcion."', imagen='" . basename($_FILES['uploadedfile']['name']) . "' where id='".$id."';";

                                            $resultado = mysqli_query($conexion, $sql);

                                            if (!$resultado) {
                                                echo "<p class='error animated shake error-panel'>Error - No se pudieron guardar los cambios</p>
                                                <a href='panel.php' class='volver-panel'>Volver al panel</a>";
                                                die;
                                            }

                                            else {
                                                header('location:panel-busqueda.php');
                                                die;
                                            }


                                        } else {

                                            $id = $_POST['id'];
                                            $sql= "select pokemones.id, nombre, t1.tipo, t2.tipo, generaciones.generacion, imagen, tipo1, tipo2, pokemones.generacion from pokemones
                                                   left outer join generaciones
                                                   on pokemones.generacion = generaciones.id
                                                   left outer join tipos as t1
                                                   on pokemones.tipo1 = t1.id
                                                   left outer join tipos as t2
                                                   on pokemones.tipo2 = t2.id
                                                   where pokemones.id='$id';";
                                            $resultado = mysqli_query($conexion, $sql);
                                            $registro = mysqli_fetch_all($resultado);

                                        }


                                    }
                            }
                ?>

                <p class='descripcion'>Modificación de Pokemones</p>
                <form method="POST" action="modificar.php" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $registro[0][0]; ?>">

                    <?php echo $error;
                    echo "
                    <label for='nombre' class='bloque'>Nombre:</label>
                    <input type='text' name='nombre' value='".$registro[0][1]."'>
                 
                    <div class='selector'><label for='tipo1'>Tipo 1:</label>
                    <select name='tipo1'>
                        <option value='".$registro[0][6]."'>".$registro[0][2]."</option>";
                        $i2=0;
                        while($i2 < count($registro2)) {
                            echo"<option value='".$registro2[$i2][0]."'>".$registro2[$i2][1]."</option>";
                            $i2++;
                        }
                    echo "
                    </select></div>

                    <div class='selector'><label for='tipo2'>Tipo 2:</label>
                    <select name='tipo2'>
                        <option value='".$registro[0][7]."'>".$registro[0][3]."</option>";
                        $i2=0;
                        while($i2 < count($registro2)) {
                            echo"<option value='".$registro2[$i2][0]."'>".$registro2[$i2][1]."</option>";
                            $i2++;
                        }
                    echo "
                    </select></div>

                    <div class='selector'><label for='generacion'>Generación:</label>
                    <select name='generacion'>
                        <option value='".$registro[0][8]."'>".$registro[0][4]."</option>";
                        $i3=0;
                        while($i3 < count($registro3)) {
                            echo"<option value='".$registro3[$i3][0]."'>".$registro3[$i3][1]."</option>";
                            $i3++;
                        }
                    echo "
                    </select></div>

                    <label for='descripcion' class='bloque'>Descripción:</label>
                    <textarea id='mytextarea' name='descripcion'>".$registro[0][9]."</textarea>
                    <br><br><br>

                    ";

                    ?>


                    <div class="imagen">
                        <div class="img-asociada">
                            <label>Imágen actual</label>
                            <?php
                            if(empty($registro[0][5])){
                                echo "<p class='mini'> No hay imágen asociada al registro</p>";
                            }
                            else{
                                $img="<img src='../img/".$registro[0][5]."'>";
                                echo $img;
                            }
                            ?>
                        </div>

                        <div>
                            <label>Cambiar/cargar una imágen - Tamaño máximo 200Kb (Formatos aceptados .JPG .PNG .GIF)</label>
                            <input id="files" name="uploadedfile" type="file" />
                            <div id="preview"></div>
                            <output id="list"></output>
                        </div>

                    </div>

                    <button type="submit" name="enviar" class="guardar">Guardar</button>
                    <a href="panel-busqueda.php" class="cancelar">Cancelar</a>

                </form>

                <!--Para visualizar la imagen antes de grabarla -->
                <script>
                    function archivo(evt) {
                        var files = evt.target.files; // FileList object

                        // Obtenemos la imagen del campo "file".
                        for (var i = 0, f; f = files[i]; i++) {
                            //Solo admitimos imágenes.
                            if (!f.type.match('image.*')) {
                                continue;
                            }

                            var reader = new FileReader();

                            reader.onload = (function(theFile) {
                                return function(e) {
                                    // Insertamos la imagen
                                    document.getElementById("list").innerHTML = ['<img class="thumb" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
                                };
                            })(f);

                            reader.readAsDataURL(f);
                        }
                    }

                    document.getElementById('files').addEventListener('change', archivo, false);
                </script>
    <?php
    }else{
        header('location:../index.php');
        exit();
    }
include '../pie.html';