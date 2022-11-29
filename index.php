<?php
require('config/db.php');
$db = conectarDB();

$rfc = "";
$nombre = "";
$correo = "";
$costoBoletos = 0;
$noBoletos = 0;

$totalPagar = 0;
$tipoA = 1000;
$tipoB = 800;

//EMAIL
$emailDestino = "";
$asunto = "";
$mensaje = "";
$remitente = "Roberto Villanueva <tovi.rob20@gmail.com>";

$alertas = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $rfc =  mysqli_real_escape_string($db, $_POST["rfc"]);
    $nombre = mysqli_real_escape_string($db, $_POST["nombre"]);
    $correo = mysqli_real_escape_string($db, $_POST["email"]);
    $costoBoletos = mysqli_real_escape_string($db, $_POST["costoBoleto"]);
    $noBoletos = mysqli_real_escape_string($db, $_POST["noBoletos"]);

    $confirmado = "NO";

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

    $confirmacionLink = "<a href='https://roberttv.alwaysdata.net/boletos/confirmar.php?rfc=".$_POST['rfc']. "'>Confirme su compra</a>";

    if (empty($alertas)) {
        $query = "INSERT INTO boletos(rfc, nombre, email, tipoBoleto, confirmado,cantidad)";
        $query .= "VALUES ('$rfc','$nombre','$correo','$costoBoletos', '$confirmado', '$noBoletos')";
        $resultado = mysqli_query($db, $query);
        if ($resultado) {
            header('Location: /boletos/registros.php');
        }
    }

    if ($costoBoletos === "TipoA-1000") {
        $totalPagar = 1000 * (int)$noBoletos;
    } else {
        $totalPagar = 800 * (int)$noBoletos;
    }


    $emailDestino = $correo;
    $asunto = "Compra de sus " . $noBoletos . " boletos";
    $mensaje = $nombre . " usted ha comprado " . $noBoletos . " boletos, siendo un total de $" . $totalPagar . " pesos";
    $mensaje .= "<html><body>";
    $mensaje .= "<head><title>Compra Boletos</title></head>";
    $mensaje .= "<img src='https://concienciaradio.com/images/boleto_admision_conferencia_en_linea_especimen.gif'>";
    $mensaje .= $confirmacionLink;
    $mensaje .= "</body></html>";
    $cabeceras = 'MIME-Version: 1.0' . "\r\n";
    $cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";

    mail($emailDestino, $asunto, $mensaje, $cabeceras, $remitente);
}

/* echo $totalPagar;

    echo "<pre>";
    var_dump( $_POST );
    echo "</pre>"; */

?>

<?php include_once('./templates/head.php'); ?>
    <h1 class="display-1 text-center font-weight-bold">VENTA DE BOLETOS</h1>
    <section>
        <?php foreach ($alertas as $alerta) : ?>
            <div class="container-sm alert alert-danger w-5 text-center">
                <?php echo $alerta; ?>
            </div>
        <?php endforeach; ?>
        <div class="container-sm mt-5 d-flex justify-content-center">
            <form action="index.php" method="POST" class="formulario">
                <div class="form-floating mb-3">
                    <input 
                        class="form-control mb-3 p-2" 
                        type="text" 
                        id="rfc" 
                        name="rfc" 
                        placeholder="Ingrese su RFC"/>
                    <label class="form-label p-2" for="rfc">RFC:</label>
                </div>

                <div class="form-floating mb-3">
                    <input 
                        class="form-control mb-3 p-2" 
                        type="text" 
                        id="nombre" 
                        name="nombre"
                        placeholder="Su Nombre" />
                    <label class="form-label p-2" for="nombre">Su Nombre:</label>
                </div>
                <div class="form-floating mb-3">
                    <input 
                        class="form-control mb-3 p-2" 
                        type="email" 
                        id="email" 
                        name="email" 
                        placeholder="Ingrese su correo electronico" />
                    <label class="form-label" for="email">Correo Electronico:</label>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="costoBoleto">Costo Boleto:</label>
                    <select name="costoBoleto" id="costoBoleto" class="mb-3 p-2 form-select">
                        <option value="">-- Seleccione --</option>
                        <option value="TipoA-1000">Boleto A - $1000</option>
                        <option value="TipoB-800">Boleto B - $800</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="noBoletos">No. de Boletos:</label>
                    <select name="noBoletos" id="noBoletos" class="mb-3 p-2 form-select">
                        <option value="">-- Seleccione --</option>
                        <option value="1">1 Boletos</option>
                        <option value="2">2 Boletos</option>
                        <option value="3">3 Boletos</option>
                        <option value="4">4 Boletos</option>
                        <option value="5">5 Boletos</option>
                    </select>
                </div>
                <input type="submit" value="Comprar" class="btn btn-success p-2 w-5" />
            </form>
        </div>
    </section>
</body></html>