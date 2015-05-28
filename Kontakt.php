<?php

$slika = "<img src='Images/HMZBIH.png' id='logo' alt='Images/HMZBIH.png'> <h1>Hidrometeorološki zavod BiH</h1>";
$ime = $mail = $mjesto = $postanski = $subjekt = $komentar = "";
$imeGreska = $mailGreska = $postanskiGreska = $subjektGreska = $komentarGreska = "";
$imeSlika = $mailSlika = $postanskiSlika = $subjektSlika = $komentarSlika = "display:none";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $sveValidno = true;
    $ime = $_POST['imePrezime'];
    $mail = $_POST['mailAdresa'];
    $mjesto = $_POST['mjesto'];
    $postanski = $_POST['postanski'];
    $subjekt = $_POST['subjekt'];
    $komentar = $_POST['komentar'];
    if (!samoSlova($ime) || empty($ime))
    {
        $sveValidno = false;
        $imeGreska = "Neispravno ime i prezime";
        $imeSlika = "display:block";
    }
    else
    {
        $imeGreska = "";
        $imeSlika = "display:none";
        testirajPodatak($ime);
    }
    if (!mailValidacija($mail) || empty($mail))
    {
        $sveValidno = false;
        $mailGreska = "Neispravna e-mail adresa";
        $mailSlika = "display:block";
    }
    else
    {
        $mailGreska = "";
        $mailSlika = "display:none";
        testirajPodatak($mail);
    }
    if (!subjektValidacija($subjekt, $komentar))
    {
        $sveValidno = false;
        $subjektGreska = "Morate izrabrati subjekt";
        $subjektSlika = "display:block";
    }
    else
    {
        $subjektGreska = "";
        $subjektSlika = "display:none";
        testirajPodatak($subjekt);
    }
    if (!komentarValidacija($subjekt, $komentar))
    {
        $sveValidno = false;
        $komentarGreska = "Morate unijeti komentar";
        $komentarSlika = "display:block";
    }
    else
    {
        $komentarGreska = "";
        $komentarSlika = "display:none";
        testirajPodatak($komentar);
    }
    if (!samoSlova($mjesto) || empty($mjesto) || empty($postanski))
    {
        $sveValidno = false;
        $postanskiGreska = "Neispravan poštanski broj";
        $postanskiSlika = "display:block";
    }
    else
    {
        $postanskiGreska = "";
        $postanskiSlika = "display:none";
        testirajPodatak($mjesto);
        testirajPodatak($postanski);
    }
    if ($sveValidno)
    {
        $slika="";
        include("KontaktProvjera.php");
    }
}

function testirajPodatak(&$podatak)
{
    $podatak = trim($podatak);
    $podatak = stripcslashes($podatak);
    $podatak = htmlspecialchars($podatak);
}

function samoSlova($podatak)
{
    $validno = true;
    if (!preg_match("/^[a-zA-Z\\s]*$/",$podatak)) {
        $validno = false;
    }
    return $validno;
}

function mailValidacija($podatak)
{
    $validno = true;
    if (!preg_match("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\\.[a-zA-Z0-9-.]+$/",$podatak))
    {
        $validno = false;
    }
    return $validno;
}

function subjektValidacija($subjekt, $komentar)
{
    $validno = true;
    if (empty($subjekt) && !empty($komentar))
        $validno = false;
    return $validno;
}

function komentarValidacija($subjekt, $komentar)
{
    $validno = true;
    if (!empty($subjekt) && empty($komentar))
        $validno = false;
    return $validno;
}

echo <<<_HTML_

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Kontakt</title>
    <link rel="stylesheet" href="Glavni.css">
    <link href='http://fonts.googleapis.com/css?family=Rokkitt:400,700' rel='stylesheet' type='text/css'>
    <script src="KontaktValidacija.js"></script>
    <script src="AjaxOtvori.js"></script>
</head>
<body onload="ucitajKontakt()">
<header>
    $slika
</header>

<div id="navigateDiv">
    <br>
    <nav>
        <ul>
            <li><a onclick="AjaxOtvori('Index.php')">Naslovna</a></li>
            <li><a onclick="AjaxOtvori('Meteorologija.html')">Meteorologija</a></li>
            <li><a onclick="AjaxOtvori('Hidrologija.html')">Hidrologija</a></li>
            <li><a onclick="AjaxOtvori('Projekti.html')">Projekti</a></li>
            <li><a onclick="AjaxOtvori('Kontakt.php')">Kontakt</a></li>
            <li><a onclick="AjaxOtvori('Arhiva.html')">Arhiva</a></li>
            <li><a onclick="AjaxOtvori('Administrator.php')">Administrator</a></li>
        </ul>
    </nav>
</div>

<div id="oNama">
    <datalist id="listaSubjekata">
        <option value="Meteorologija"> </option>
        <option value="Hidrologija"> </option>
        <option value="Astronomija"> </option>
        <option value="Projekti"> </option>
    </datalist>
    <form method="POST" action="Kontakt.php">
        <fieldset>
            <h1 id="kontaktNaslov">Kontaktirajte nas</h1>
            <p>Ova stranica služi da kontaktirate kreatora web stranice, ukoliko imate bilo kakvih primjedbi i sugestija za naredni rad stranice.</p>
            <label for="imePrezime">Ime i prezime (*): </label> <input id="imePrezime" type="text" class="unosPodataka" name="imePrezime" value=$ime> <img style=$imeSlika src="http://png-2.findicons.com/files/icons/1609/ose_png/256/warning.png" alt="http://png-2.findicons.com/files/icons/1609/ose_png/256/warning.png" class="greska" id="rucnaGreska"> <em name="imeGreska" class="errorTekst5" id="greskaText">$imeGreska</em> <br><br>
            <label for="mailAdresa">Mail adresa (*): </label> <input id="mailAdresa" type="text" class="unosPodataka" name="mailAdresa" value=$mail> <img style=$mailSlika src="http://png-2.findicons.com/files/icons/1609/ose_png/256/warning.png" alt="http://png-2.findicons.com/files/icons/1609/ose_png/256/warning.png" class="greska" id="rucnaGreska2"> <em class="errorTekst5" id="greskaText2">$mailGreska</em> <br><br>
            <label for="mjesto">Mjesto (*): </label> <input id="mjesto" type="text" class="unosPodataka" name="mjesto" value=$mjesto> <br><br>
            <label for="postanski">Poštanski broj (*): </label> <input id="postanski" type="text" class="unosPodataka" name="postanski" value=$postanski> <img style=$postanskiSlika src="http://png-2.findicons.com/files/icons/1609/ose_png/256/warning.png" alt="http://png-2.findicons.com/files/icons/1609/ose_png/256/warning.png" class="greska" id="rucnaGreska3"> <em class="errorTekst5" id="greskaText3">$postanskiGreska</em>
            <br><br>
            <label for="subjekt">Subjekt: </label> <input id="subjekt" type="text" list="listaSubjekata" class="unosPodataka" name="subjekt" value=$subjekt> <img style=$subjektSlika src="http://png-2.findicons.com/files/icons/1609/ose_png/256/warning.png" alt="http://png-2.findicons.com/files/icons/1609/ose_png/256/warning.png" class="greska" id="rucnaGreska4"> <em class="errorTekst5" id="greskaText4">$subjektGreska</em> <br><br>
            <label>Komentar: </label> <textarea id="komentar" name="komentar">$komentar</textarea> <img style=$komentarSlika src="http://png-2.findicons.com/files/icons/1609/ose_png/256/warning.png" alt="http://png-2.findicons.com/files/icons/1609/ose_png/256/warning.png" class="greska" id="rucnaGreska5"> <em class="errorTekst5" id="greskaText5">$komentarGreska</em> <br><br>
            <input type="submit" value="Posalji" id="submitButton"> <input type="button" value="Reset" id="resetButton" onclick="resetForm()"/>
        </fieldset>
    </form>
</div>
</body>
</html>

_HTML_;

?>