<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Administrator Panel</title>
    <link rel="stylesheet" href="Glavni.css">
    <link href='http://fonts.googleapis.com/css?family=Rokkitt:400,700' rel='stylesheet' type='text/css'>
    <script src="AjaxOtvori.js"></script>
</head>
<body>

<?php

if (isset($_POST['komentarID']))
{
    $konekcija = new mysqli("localhost", "root", "", "vremenskaprognoza");
    $konekcija->set_charset("utf8");
    if ($konekcija->connect_error) {
        die("Nemoguće se povezati sa bazom!" . $konekcija->connect_error);
    }
    $spremljen = $konekcija->prepare("DELETE FROM komentar WHERE Id = ?");
    $spremljen->bind_param("i", $idKomentarr);
    $idKomentarr = $_POST['komentarID'];
    $spremljen->execute();
    $spremljen->close();
    $konekcija->close();
    echo "<script>alert('Uspješno ste izvršili brisanje komentara!');</script>";
}

?>

<header>
    <img src="Images/HMZBIH.png" id="logo" alt="Images/HMZBIH.png"> <h1>Hidrometeorološki zavod BiH</h1>
</header>

<div id="navigateDiv">
    <br>
    <nav>
        <ul>
            <li><a onclick="AjaxOtvori('Index.php')">Naslovna</a></li>
            <li><a onclick="AjaxOtvori('AdministratorPanel.html')">Dashboard</a></li>
            <li><a onclick="AjaxOtvori('Novosti.php')">Novosti</a></li>
            <li><a onclick="AjaxOtvori('Komentari.php')">Komentari</a></li>
            <li><a onclick="AjaxOtvori('Korisnici.php')">Korisnici</a></li>
            <li><a onclick="AjaxOtvori('Odjava.php')">Odjava</a></li>
        </ul>
    </nav>
</div>

<div id="sredina">
    <h2 id="naslovnaVijest">Lista svih novosti sa komentarima: </h2>
    <?php

    $novosti = array();
    $primjer = "";
    $brojac = 0;
    $konekcija = new mysqli("localhost", "root", "", "vremenskaprognoza");
    $konekcija->set_charset("utf8");
    if ($konekcija->connect_error) {
        die("Nemoguće se povezati sa bazom!" . $konekcija->connect_error);
    }

    $sql = "SELECT * FROM novost";
    $rezultat = $konekcija->query($sql);

    if ($rezultat->num_rows > 0) {
        while($red = $rezultat->fetch_assoc()) {
            $novosti[$brojac++] = $red;
        }
    }

    for ($i = 0; $i < $brojac; $i++)
    {
        echo "<form action='Komentari.php' method='POST'><fieldset class='dodavanje'>";
        $naziv = $novosti[$i]["Naslov"];
        echo "<legend>$naziv</legend><br>";
        $sql = "SELECT * FROM komentar k WHERE k.NovostID=".$novosti[$i]["Id"];
        $novostKomentari = $konekcija->query($sql);
        if ($novostKomentari->num_rows > 0) {
            while($red = $novostKomentari->fetch_assoc()) {
                $komID = $red["Id"];
                $komentarTekst = $red["Poruka"];
                echo "<label class='prikazKomentara'>ID: $komID</label><p class='prikazPorukeKomentara'>$komentarTekst</p><br><br>";
            }
        }
        echo "<hr><p>Unesite ID komentara kojeg želite ukloniti zbog neprimjerenog sadržaja: </p><br>";
        echo "<input class='unosID' type='number' name='komentarID' min='1'><br><br>";
        echo "<input type='submit' class='submitButton5' value='Izbriši' list='komentarLista'>";
        echo "</fieldset></form><br>";
    }
    $konekcija->close();
    ?>

</div>

</body>
</html>