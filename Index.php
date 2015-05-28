<?php

$novosti = array();
$primjer = "";
$brojac = 0;

$konekcija = new mysqli("localhost", "root", "", "vremenskaprognoza");
$konekcija->set_charset("utf8");
if ($konekcija->connect_error) {
    die("Nemoguće se povezati sa bazom!" . $konekcija->connect_error);
}

$sql = "SELECT a.Ime, a.Prezime, n.* FROM autor a, novost n WHERE a.Id = n.AutorID";
$rezultat = $konekcija->query($sql);
$konekcija->close();

if ($rezultat->num_rows > 0) {
    while($red = $rezultat->fetch_assoc()) {
        $novosti[$brojac++] = $red;
    }
}

usort($novosti, function($a, $b) {
    return $a['DatumObjave'] - $b['DatumObjave'];
});


for ($i = 0; $i < $brojac; $i++)
{
    $ID = $novosti[$i]["Id"];
    $autor = $novosti[$i]["Ime"] . " " . $novosti[$i]["Prezime"];
    $naslov = $novosti[$i]["Naslov"];
    $slika = $novosti[$i]["Slika"];
    $sadrzajNovosti = $novosti[$i]["Opis"];
    $datum = $novosti[$i]["DatumObjave"];
    $detaljnijeNovosti = $novosti[$i]["Detaljno"];
    if (empty($detaljnijeNovosti) || $detaljnijeNovosti == null)
        $vidljivost = 'display: none';
    else $vidljivost = 'display: block';
    $primjer .= "
    <form method='get' action='PrikazVijest.php'>
           <div class='listItem'>
            <input type='hidden' name='ID' value='$ID'>
            <input type='hidden' name='autor' value='$autor'>
            <input type='hidden' name='naslov' value='$naslov'>
            <input type='hidden' name='slika' value='$slika'>
            <input type='hidden' name='sadržaj' value= '$sadrzajNovosti'>
            <input type='hidden' name='datum' value='$datum'>
            <input type='hidden' name='detaljno' value='$detaljnijeNovosti'>
            <img src=$slika alt=$slika>
            <h3 class='naslov'>$naslov</h3>
            <p>$sadrzajNovosti</p>
            <br>
            <p class='nastaviLink'><span> $autor,  $datum  </span> </p><input style='$vidljivost' type='submit' id='submitButton4' value='Detaljnije>>'>
          </div>
        </form>";
}
echo <<<_HTML_

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="Glavni.css">
    <link href='http://fonts.googleapis.com/css?family=Rokkitt:400,700' rel='stylesheet' type='text/css'>
    <script src="AjaxOtvori.js"></script>
    <title>Naslovna</title>
</head>
<body>

<header>
        <img src="Images/HMZBIH.png" id="logo" alt="Images/HMZBIH.png"> <h1>Hidrometeorološki zavod BiH</h1>
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
            <li><a onclick="AjaxOtvori('Arhiva.html')">Arhiva</a> </li>
            <li><a onclick="AjaxOtvori('Administrator.php')">Administrator</a></li>
        </ul>
    </nav>
</div>

<div id="sredina">
    <h2>NOVOSTI</h2>
    <div id="novosti">
        $primjer
    </div>
    <div id="nesto">
        <h2>VREMENSKA PROGNOZA</h2>
        <img src="Images/prognoza.jpg" alt="Images/prognoza.jpg">
    </div>
</div>

</body>
</html>

_HTML_;

?>