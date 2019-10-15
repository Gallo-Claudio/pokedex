<?php include '../encabezado.html'; ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">

<?php
    $error = "";

    if (isset($_POST['enviar'])) {
        $usuario = $_POST['usuario'];
        $password = $_POST['password'];


        if(empty($usuario) or empty($password)){
            $error = "<p class='error'>Los datos ingresados son incorrectos</p>";
            $clase ="animated shake";
        }else {

            $conexion = mysqli_connect("localhost","pokemon","poke1234","pokemons_vazquez_claudio");

            if (!$conexion) {
                echo "ERROR de conexion a la BD";
                die;
            }

            $sql = "SELECT * FROM usuarios WHERE usuario = '" . $usuario . "'";
            $resultado = mysqli_query($conexion, $sql);
            if (!$resultado) {
                $error = "<p class='error'>Los datos ingresados son incorrectos</p>";
                $clase ="animated shake";
            } else {
                $lista = mysqli_fetch_assoc($resultado);
                if ($lista["clave"] == $password) {

                    session_start();
                    $_SESSION['selogueo'] = true;
                    header('location:panel-busqueda.php');
                    exit();
                } else {
                    $error = "<p class='error'>Los datos ingresados son incorrectos</p>";
                    $clase ="animated shake";
                }
            }
        }
    }

?>
<p class='descripcion'>Acceso al Panel</p>
<form class="login <?php echo $clase; ?>" method="POST" action="index.php">
    <?php echo $error; ?>
    <label for="usuario">Usuario:</label>
    <input type="text" name="usuario">
    <br>
    <label for="password">Password:</label>
    <input type="password" name="password">
    <br>
    <button type="submit" name="enviar">Iniciar Sesion</button>
</form>
<?php include '../pie.html'; ?>