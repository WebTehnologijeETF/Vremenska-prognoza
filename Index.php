
<?php

$counter=0;
$novosti = array();
$primjer = "";
foreach(glob("novosti/*.txt") as $imeFajla)
{
    $novosti[$counter] = file($imeFajla);
    $counter++;
}

$kolicinaNovosti=count($novosti);
for ($i=0; $i<$kolicinaNovosti; $i++)
{
    for ($j=0; $j<$kolicinaNovosti-1-$i; $j++) {
        $time1 = strtotime($novosti[$j][0]); $newformat1 = date('d-m-Y h:i:s',$time1);
        $time2 = strtotime($novosti[$j+1][0]); $newformat2 = date('d-m-Y h:i:s',$time2);
        if ($time2 < $time1) {
            $tmp=$novosti[$j];
            $novosti[$j]=$novosti[$j+1];
            $novosti[$j+1]=$tmp;
        }
    }
}

for ($i=0; $i<$kolicinaNovosti; $i++)
{
    $novostLength=count($novosti[$i]);
    $sadrzajNovosti=$detaljnijeNovosti="";
    $j=4;
    while ($j<$novostLength){
        if (trim($novosti[$i][$j])=="--"){
            for ($k=$j+1; $k<$novostLength; $k++){
                $detaljnijeNovosti.=$novosti[$i][$k];
            }
            break;
        }
        $sadrzajNovosti.=$novosti[$i][$j];
        $j++;
    }
    $datum=$novosti[$i][0]; $autor=$novosti[$i][1]; $naslov=$novosti[$i][2]; $slika=$novosti[$i][3];
    if (empty($detaljnijeNovosti))
    {
        $vidljivost = 'display: none';
    }
    else
    {
        $vidljivost = 'display: block';
    }
   $primjer .= "
        <form method='get' action='PrikazVijest.php'>
            <div class='listItem'>
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
                <p class='nastaviLink'><span> $autor,  $datum  </span> <input style='$vidljivost' type='submit' id='submitButton4' value='Detaljnije>>'>
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