<?php
require('config/db.php');
$db = conectarDB();

$totalPagar = 0;

//EMAIL
$emailDestino = "";
$asunto = "";
$mensaje = "";
$remitente = "Alejandra Celestino Bautista <bautistacelestinoalejandra@gmail.com>";

$alertas = [];

$rfc = $_GET['rfc'];
if (!$rfc) {
    header('Location: /boletos/registros.php');
}

$consulta = "SELECT * FROM  boletos where rfc = '${rfc}'";
$resultado = mysqli_query($db, $consulta);
$usuario = mysqli_fetch_assoc($resultado);

/* echo "<pre>";
var_dump($usuario);
echo "</pre>"; */

$rfc = $usuario['rfc'];
$nombre =  $usuario['nombre'];
$correo =  $usuario['email'];
$costoBoletos =  $usuario['tipoBoleto'];
$noBoletos =  $usuario['cantidad'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $rfc =  mysqli_real_escape_string($db, $_POST["rfc"]);
    $nombre = mysqli_real_escape_string($db, $_POST["nombre"]);
    $correo = mysqli_real_escape_string($db, $_POST["email"]);
    $costoBoletos = mysqli_real_escape_string($db, $_POST["costoBoleto"]);
    $noBoletos = mysqli_real_escape_string($db, $_POST["noBoletos"]);

    if (!$rfc) {
        $alertas[] = "El RFC es obligatorio";
    }
    if (!$nombre) {
        $alertas[] = "El nombre es obligatorio";
    }
    if (!$correo) {
        $alertas[] = "El correo es obligatorio";
    }
    if (!$costoBoletos) {
        $alertas[] = "El tipo de boleto es obligatorio";
    }
    if (!$noBoletos) {
        $alertas[] = "El número de boletos es obligatorio";
    }

    if (empty($alertas)) {
        $query = "UPDATE boletos SET rfc = '${rfc}', nombre = '${nombre}', email = '${correo}'";
        $query .= ",tipoBoleto = '${costoBoletos}', cantidad = '${noBoletos}' WHERE rfc = '${rfc}'";
        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            header('Location: /boletos/registros.php');
        }
    }
}
?>
<?php include_once('./templates/head.php'); ?>
    <h1 class="display-1 text-center">VENTA DE BOLETOS</h1>
    <h2 class="display-2 text-center">Edición</h2>
    <section>
        <div class="container-sm mt-5 d-flex justify-content-center">

            <?php foreach ($alertas as $alerta) : ?>
                <div class="error">
                    <?php echo $alerta; ?>
                </div>
            <?php endforeach; ?>

            <form action="editar.php" method="POST" class="formulario">
                <div class="form-floating mb-3">
                    <input class="form-control mb-3 p-2" type="text" id="rfc" name="rfc" value="<?php echo $rfc; ?>" />
                    <label class="form-label p-2" for="rfc">RFC:</label>
                </div>

                <div class="form-floating mb-3">
                    <input class="form-control" type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" />
                    <label class="form-label" for="nombre">Su Nombre:</label>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control" type="email" id="email" name="email" value="<?php echo $correo; ?>" />
                    <label class="form-label" for="email">Correo Electronico:</label>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="costoBoleto">Costo Boleto:</label>
                    <select name="costoBoleto" id="costoBoleto" class="form-select">
                        <option><?php echo $costoBoletos; ?></option>
                        <option value="1000">Boleto A - $1000</option>
                        <option value="800">Boleto B - $800</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="noBoletos">No. de Boletos:</label>
                    <select name="noBoletos" id="noBoletos" class="mb-3 p-2 form-select">
                        <option><?php echo $noBoletos ?></option>
                        <option value="1">1 Boletos</option>
                        <option value="2">2 Boletos</option>
                        <option value="3">3 Boletos</option>
                        <option value="4">4 Boletos</option>
                        <option value="5">5 Boletos</option>
                    </select>
                </div>
                <input 
                    type="submit" 
                    value="Actualizar Compra" 
                    class="btn btn-primary p-3" 
                />
            </form>
        </div>
    </section>
</body>

</html>