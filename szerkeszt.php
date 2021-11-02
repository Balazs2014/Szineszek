<?php

require_once 'db.php';
require_once 'Szinesz.php';

$nevHiba = '';
$magassagHiba = '';
$szulDatumHiba = '';
$dijakSzamaHiba = '';

$szineszId = $_GET['id'] ?? null;

if ($szineszId === null) {
    header('Location: index.php');
    exit();
}

function szulDatumValidalas($szulDatum, $format = 'Y-m-d') {
    $d = DateTime::createFromFormat($format, $szulDatum);
    return $d && $d->format($format) === $szulDatum;
}

$szinesz = Szinesz::getById($szineszId);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ujNev = $_POST['nev'] ?? '';
    $ujMagassag = $_POST['magassag'] ?? 0;
    $ujSzulDatum = $_POST['szul_datum'] ?? '';
    $ujDijakSzama = $_POST['dijak_szama'] ?? 0;
    $ujForgatasonVan = $_POST['forgatason_van'] ?? 0;

    if (empty($_POST['nev'])) {
        $nevHiba = 'Név megadása kötelező';
    }

    if (!isset($_POST['magassag'])) {
        $magassagHiba = 'Magasság megadása kötelező';
    } elseif (!is_numeric($_POST['magassag'])) {
        $magassagHiba = 'A magasságnak számnak kell lennie';
    }

    if (empty($_POST['szul_datum'])) {
        $szulDatumHiba = 'Születési dátum megadása kötelező';
    } elseif (!szulDatumValidalas($_POST['szul_datum'])) {
        $szulDatumHiba = 'Születési dátum formátuma nem megfelelő';
    }

    if (!isset($_POST['dijak_szama'])) {
        $dijakSzamaHiba = 'A díjak számának megadása kötelező';
    } elseif (!is_numeric($_POST['dijak_szama'])) {
        $dijakSzamaHiba = 'A díjak számának számnak kell lennie';
    }
    

    if (empty($nevHiba) && empty($magassagHiba) && empty($szulDatumHiba) && empty($dijakSzamaHiba)) {
        $szinesz->setNev($ujNev);
        $szinesz->setMagassag($ujMagassag);
        $szinesz->setSzulDatum(new DateTime($ujSzulDatum));
        $szinesz->setDijakSzama($ujDijakSzama);
        $szinesz->setForgatasonVan($ujForgatasonVan);

        $szinesz->mentes();
    }
}

?><!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Szerkesztés</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel='stylesheet' type='text/css' media="screen" href='style.css'>
    <script src='main.js'></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 d-flex align-items-end" id="header">
                <h1 id="szerkesztesH1">A Big Színész Bázis</h1>
                <p>Szerkesztés</p>
            </div>
        </div>
    </div>
    <form method='POST' onsubmit="return validacio();">
        <div class="container text-center">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <input type="text" name="nev" placeholder="Név" id="inputNev" class="inputMezo form-control" value='<?php echo $szinesz->getNev(); ?>' required>
                    <div class="invalid-feedback" id="hibaNev"><?php echo $nevHiba ?></div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <input type="number" name="magassag" placeholder="Magasság (cm)" class="inputMezo form-control" id="inputMagassag" value='<?php echo $szinesz->getMagassag(); ?>' required>
                    <div class="invalid-feedback" id="hibaMagassag"><?php echo $magassagHiba ?></div> 
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <input type="date" name="szul_datum" class="inputMezo form-control" id="inputSzulDatum" value='<?php echo date("Y-m-d", strtotime($szinesz->getSzulDatum()->format('Y-m-d'))) ?>' required>
                    <div class="invalid-feedback" id="hibaSzulDatum"><?php echo $szulDatumHiba ?></div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <input type="number" name="dijak_szama" placeholder="Díjak száma" class="inputMezo form-control" id="inputDijakSzama" value='<?php echo $szinesz->getDijakSzama(); ?>' required>
                    <div class="invalid-feedback" id="hibaDijakSzama"><?php echo $dijakSzamaHiba ?></div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 col-sm-12 div-switch">
                <label for="forgatason_van" class="forgatason-label">Filmet forgat</label>
                    <label class="switch">
                        <input type="checkbox" name="forgatason_van" <?php echo ($szinesz->getForgatasonVan() ? "checked" : ""); ?>></input>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
            <div>
                <input type="submit" value="Szerkeszt" class="button-uj" id="btnSzerkeszt">
                <input type="submit" value="Mégse" onclick="history.go(-1);" class="button-megse">
            </div>
        </div>
    </form>
</body>
</html>