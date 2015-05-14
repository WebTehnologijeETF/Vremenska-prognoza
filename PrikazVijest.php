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
        <?php
        $naziv = $_GET['naslov'];
        echo '<h2 id="naslovVijesti">' .ucfirst(strtolower($naziv)). '</h2>';
        ?>
        <br>
    <fieldset id="vijest">
        <img id="prikazanVijestSlika" src=<?php echo $_GET['slika'] ?> alt=<?php echo $_GET['slika'] ?>>
        <p id="sadrzajNovosti"><?php echo $_GET['detaljno'] ?></p>
    </fieldset>
    <p><?php echo 'Autor: ', $_GET['autor'] ?></p>
    <p><?php echo 'Datum objave: ', $_GET['datum'] ?></p>
</div>

</body>
</html>