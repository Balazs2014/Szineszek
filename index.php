<?php

require_once 'db.php';
require_once 'Szinesz.php';

$nevHiba = '';
$magassagHiba = '';
$szulDatumHiba = '';
$dijakSzamaHiba = '';

function ki($szoveg) {
    echo htmlspecialchars($szoveg, ENT_QUOTES);
}

function szulDatumValidalas($szulDatum, $format = 'Y-m-d') {
    $d = DateTime::createFromFormat($format, $szulDatum);
    return $d && $d->format($format) === $szulDatum;
}

$nevInput = '';
$magassagInput = '';
$szulDatumInput = '';
$dijakSzamaInput = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $deleteId = $_POST['deleteId'] ?? '';
    if ($deleteId !== '') {
        Szinesz::torol($deleteId);
    } else {
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
            $ujSzinesz = new Szinesz($ujNev, $ujMagassag, new DateTime($ujSzulDatum), $ujDijakSzama, $ujForgatasonVan);
            $ujSzinesz->uj();
        }
    }   
}

$szineszek = Szinesz::osszes();

?><!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <title>Színészek</title>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
        <link rel='stylesheet' type='text/css' media='screen' href='style.css'>
        <script src='main.js'></script>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 d-flex align-items-end" id="header">
                    <h1>A Big Színész Bázis</h1>
                </div>
            </div>
        </div>
        <form method="POST" onsubmit="return validacio();">
            <div class="container text-center">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <input type="text" name="nev" placeholder="Név" class="inputMezo form-control" id="inputNev" value='<?php ki($nevInput) ?>' required></input>
                        <div class="invalid-feedback" id="hibaNev"><?php echo $nevHiba ?></div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <input type="number" name="magassag" placeholder="Magasság (cm)" class="inputMezo form-control" id="inputMagassag" min="24" value='<?php ki($magassagInput) ?>' required></input>
                        <div class="invalid-feedback" id="hibaMagassag"><?php echo $magassagHiba ?></div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <input type="date" name="szul_datum" class="inputMezo form-control" id="inputSzulDatum" value='<?php ki($szulDatumInput) ?>' required></input>
                        <div class="invalid-feedback" id="hibaSzulDatum"><?php echo $szulDatumHiba ?></div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <input type="number" name="dijak_szama" placeholder="Díjak száma" class="inputMezo form-control" id="inputDijakSzama" min="0" value='<?php ki($dijakSzamaInput) ?>'></input>
                        <div class="invalid-feedback" id="hibaDijakSzama"><?php echo $dijakSzamaHiba ?></div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 col-sm-12 div-switch">
                        <label for="forgatason_van" class="forgatason-label">Filmet forgat </label>
                        <label class="switch">
                            <input type="checkbox" name="forgatason_van"></input>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
                <div>
                    <input type="submit" value="Új színész" class="button-uj" id="btnUj">
                </div>
            </div>
        </form>

        <?php
            echo "<div class='container'>";
            echo "<div class='row text-center grid-kinezet'>";
            foreach ($szineszek as $szinesz) {
                echo "<div class='col-lg-4 col-md-6 col-sm-12 grid-tartalom-kozep'>";
                echo "<article>";
                echo "<h2>" . $szinesz->getNev() . "</h2>";
                echo "<p class='igazit-bal'>Magasság: <span class='igazit-jobb'>" . $szinesz->getMagassag() . " cm</span></p>";
                echo "<p class='igazit-bal'>Születési dátum: <span class='igazit-jobb'>" . $szinesz->getSzulDatum()->format('Y.m.d') . "</span></p>";
                echo "<p class='igazit-bal'>Díjainak száma: <span class='igazit-jobb'>" . $szinesz->getDijakSzama() . "</span></p>";
                echo "<p>" . ($szinesz->getForgatasonVan() ? "Filmet forgat" : "Nem forgat filmet") . "</p>";
                echo "<a href='szerkeszt.php?id=" . $szinesz->getId() . "'>Szerkeszt</a>";
                echo "<form method='POST'>";
                echo "<input type='hidden' name='deleteId' value='" . $szinesz->getId() . "'>";
                echo "<button type='submit' class='button-torles' id='btnTorles'>Törlés</button>";
                echo "</form>";
                echo "</article>";
                echo "</div>";
            }
            echo "</div>";
            echo "</div>";
        ?>
    </body>
</html>