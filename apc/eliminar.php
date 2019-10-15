<?php
$conexion = mysqli_connect("localhost","pokemon","poke1234","pokemons_vazquez_claudio");

if(!$conexion){
    echo "ERROR de conexion a la BD";
    die;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM pokemones WHERE id = '$id'";
    $resultado = mysqli_query($conexion, $sql);
    if (!$resultado) {
        $error = "Error - No se pudo encontrar esa nota";
    }
    header('location:panel.php');
}

?>

