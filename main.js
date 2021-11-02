function validacio() {
    let nev = document.getElementById('inputNev');
    let magassag = document.getElementById('inputMagassag');
    let szulDatum = document.getElementById('inputSzulDatum');
    let dijakSzama = document.getElementById('inputDijakSzama');

    let logikai = true;

    if (nev.value === "") {
        document.getElementById('hibaNev').innerHTML = "Név megadása kötelező";
        logikai = false;
        nev.classList.add('is-invalid');
    } else if (nev.value !== "") {
        document.getElementById('hibaNev').innerHTML = "";
        nev.classList.remove('is-invalid');
    }

    if (magassag.value.length == 0) {
        document.getElementById('hibaMagassag').innerHTML = "Magasság megadása kötelező";
        logikai = false;
        magassag.classList.add('is-invalid');
    } else if (isNaN(magassag.value)) {
        document.getElementById('hibaMagassag').innerHTML = "A magasságnak számnak kell lennie";
        logikai = false;
        magassag.classList.add('is-invalid');
    } else if (magassag.value.length != 0) {
        document.getElementById('hibaMagassag').innerHTML = "";
        magassag.classList.remove('is-invalid');
    } else if (!isNaN(magassag.value)) {
        document.getElementById('hibaMagassag').innerHTML = "";
        magassag.classList.remove('is-invalid');
    }

    if (szulDatum.value === "") {
        document.getElementById('hibaSzulDatum').innerHTML = "Születési dátum megadása kötelező";
        logikai = false;
        szulDatum.classList.add('is-invalid');
    } else if (szulDatum.value !== "") {
        document.getElementById('hibaSzulDatum').innerHTML = "";
        szulDatum.classList.remove('is-invalid');
    }

    if (dijakSzama.value.length == 0) {
        document.getElementById('hibaDijakSzama').innerHTML = "A díjak számának megadása kötelező";
        logikai = false;
        dijakSzama.classList.add('is-invalid');
    } else if (isNaN(dijakSzama.value)) {
        document.getElementById('hibaDijakSzama').innerHTML = "A díjak számának számnak kell lennie";
        logikai = false;
        dijakSzama.classList.add('is-invalid');
    } else if (dijakSzama.value.length != 0) {
        document.getElementById('hibaDijakSzama').innerHTML = "";
        dijakSzama.classList.remove('is-invalid');
    } else if (!isNaN(dijakSzama.value)) {
        document.getElementById('hibaDijakSzama').innerHTML = "";
        dijakSzama.classList.remove('is-invalid');
    }

    return logikai;
}

function index() {
    document.getElementById('btnUj').addEventListener('click', validacio);
}
document.addEventListener('DOMContentLoaded', index);

function szerkeszt() {
    document.getElementById('btnSzerkeszt').addEventListener('click', validacio);
}
document.addEventListener('DOMContentLoaded', szerkeszt);


    
