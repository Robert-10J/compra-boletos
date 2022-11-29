<?php
require('config/db.php');
$db = conectarDB();

$rfc = $_GET['rfc'];
if (!$rfc) {
    header('Location: /boletos/index.php');
}

$confirmado = "SI";

if( $_SERVER["REQUEST_METHOD"] === "POST" ) {   
    $query = "UPDATE boletos SET confirmado = '${confirmado}'";
    $query .= "WHERE rfc = '${rfc}'";
    $resultado = mysqli_query($db, $query);

    if( $resultado ) {
        header('Location: /boletos/index.php');
    }
}
?>

<?php include_once('./templates/head.php') ?>

<div class="card" style="width: 50rem; margin: 2rem;">
    <div class="card-body">
        <h1 class="display-1 mt-5 font-weight-bold">Confirmación de compra</h1>
        <p class="card-text">Confirme su compra en boletos.com</p>
        <form method="POST">
            <input class="btn btn-primary" type="submit" value="Confirmar">
        </form>
    </div>
</div>