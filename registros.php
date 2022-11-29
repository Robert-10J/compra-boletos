<?php
require('config/db.php');
$db = conectarDB();

$query = "SELECT * FROM boletos";
$resultado = mysqli_query($db, $query);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $rfc = $_POST['rfc'];

    if ($rfc) {
        $queryEliminar = "DELETE FROM boletos WHERE rfc = '${rfc}'";
        $resultado = mysqli_query($db, $queryEliminar);

        if ($resultado) {
            header('Location: /boletos/registros.php');
        }
    }
}
?>

<?php include_once('./templates/head.php'); ?>
    <h1 class="display-1 text-center">Registros de compra</h1>
    <div class="container mt-5">
        <table class="table">
            <thead>
                <tr class="table-info">
                    <th>RFC</th>
                    <th>NOMBRE</th>
                    <th>CORREO</th>
                    <th>TIPO DE BOLETO</th>
                    <th>CANTIDAD DE BOLETOS</th>
                    <th>COMPRA CONFIRMADA</th>
                    <th>OPCIONES</th>
                </tr>
            </thead>

            <tbody>
                <?php while ($registros = mysqli_fetch_assoc($resultado)) : ?>
                    <tr>
                        <td><?php echo $registros["rfc"] ?></td>
                        <td><?php echo $registros["nombre"] ?></td>
                        <td><?php echo $registros["email"] ?></td>
                        <td><?php echo $registros["tipoBoleto"] ?></td>
                        <td><?php echo $registros["cantidad"] ?></td>
                        <td><?php echo $registros["confirmado"] ?></td>
                        <td>
                            <a 
                                href="editar.php?rfc=<?php echo $registros['rfc']; ?>"
                                class="btn btn-primary">Editar</a>
                            <form method="POST">
                                <input 
                                    type="hidden" 
                                    name="rfc" 
                                    value="<?php echo $registros['rfc']; ?>">
                                <input 
                                    type="submit" 
                                    value="Eliminar" 
                                    class="btn btn-danger mt-2">
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body></html>