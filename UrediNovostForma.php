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

<header>
    <img src="Images/HMZBIH.png" id="logo" alt="Images/HMZBIH.png"> <h1>Hidrometeorološki zavod BiH</h1>
</header>

<?php
function testirajPodatak(&$podatak)
{
    $podatak = trim($podatak);
    $podatak = stripcslashes($podatak);
    $podatak = htmlspecialchars($podatak);
}

if (isset($_POST['noviNaslov']) && isset($_POST['url']) && isset($_POST['uvod']) && isset($_POST['imeAutora']) & isset($_POST['prezimeAutora']))
{
    $imeAutora = $_POST['imeAutora'];
    testirajPodatak($imeAutora);
    $prezimeAutora = $_POST['prezimeAutora'];
    testirajPodatak($prezimeAutora);
    $konekcija = new mysqli("localhost", "root", "", "vremenskaprognoza");
    $konekcija->set_charset("utf8");
    if ($konekcija->connect_error) {
        die("Nemoguće se povezati sa bazom!" . $konekcija->connect_error);
    }
    $postojiAutor = false;
    $idAutora = "";
    $sql = "SELECT * FROM autor";
    $rezultat = $konekcija->query($sql);
    if ($rezultat->num_rows > 0) {
        while($red = $rezultat->fetch_assoc()) {
            if ($imeAutora == $red["Ime"] && $prezimeAutora == $red["Prezime"])
            {
                $postojiAutor = true;
                $idAutora = $red["Id"];
            }
        }
    }
    if ($postojiAutor == false)
    {
        $spreman = $konekcija->prepare("INSERT INTO autor (Ime, Prezime) VALUES (?, ?)");
        $spreman->bind_param("ss", $imeAutora, $prezimeAutora);
        $imeAutora = $_POST['imeAutora'];
        testirajPodatak($imeAutora);
        $prezimeAutora = $_POST['prezimeAutora'];
        testirajPodatak($prezimeAutora);
        $spreman->execute();
        $idAutora = $spreman->insert_id;
        $spreman->close();
    }
        $ubaciNovost = $konekcija->prepare("UPDATE novost SET AutorID = ?, Naslov = ?, Slika = ?, Opis = ?, Detaljno = ? Where Id=?");
        $ubaciNovost->bind_param("issssi", $autorr, $noviNaslov, $noviURL, $noviUvod, $noviDetaljna, $stariID);
        $autorr = $idAutora;
        $stariID = $_POST['naslov'];
        testirajPodatak($stariID);
        $noviNaslov = $_POST['noviNaslov'];
        testirajPodatak($noviNaslov);
        $noviURL = $_POST['url'];
        testirajPodatak($noviURL);
        $noviUvod = $_POST['uvod'];
        testirajPodatak($noviUvod);
        $noviDetaljna = $_POST['detaljna'];
        testirajPodatak($noviDetaljna);
        $ubaciNovost->execute();
        $ubaciNovost->close();
        $konekcija->close();
        echo "<script>alert('Promjene uspjesno izvrsene!')</script>";
}

$naslov = ""; $slika = ""; $opis = ""; $detaljno = ""; $AID = ""; $ime = ""; $prezime = "";
    $Id = $_POST["naslov"];
    $konekcija = new mysqli("localhost", "root", "", "vremenskaprognoza");
    $konekcija->set_charset("utf8");
    if ($konekcija->connect_error) {
        die("Nemoguće se povezati sa bazom!" . $konekcija->connect_error);
    }
    $sql = "SELECT * FROM novost";
    $rezultat = $konekcija->query($sql);
    $konekcija->close();
    $postoji = false;
    $objekt = "";
    if ($rezultat->num_rows > 0) {
        while ($red = $rezultat->fetch_assoc()) {
            $IDnovosti = $red["Id"];
            if ($Id == $IDnovosti) {
                $postoji = true;
                $objekt = $red;
            }
        }
    }
    if ($postoji) {
        $naslov = $objekt["Naslov"];
        $slika = $objekt["Slika"];
        $opis = $objekt["Opis"];
        $detaljno = $objekt["Detaljno"];
        $AID = $objekt["AutorID"];
        $konekcija = new mysqli("localhost", "root", "", "vremenskaprognoza");
        $konekcija->set_charset("utf8");
        if ($konekcija->connect_error) {
            die("Nemoguće se povezati sa bazom!" . $konekcija->connect_error);
        }
        $sql = "SELECT a.Id, a.Ime, a.Prezime FROM autor a WHERE a.Id = " . $AID;
        $rezultat = $konekcija->query($sql);
        $konekcija->close();
        if ($rezultat->num_rows > 0) {
            while ($red = $rezultat->fetch_assoc()) {
                if ($red["Id"] == $AID) {
                    $ime = $red["Ime"];
                    $prezime = $red["Prezime"];
                }
            }
        }
    } else {
        echo "<script>alert('Greska: Vijest ne postoji sa tim ID-om!')</script>";
        echo "<script>history.go(-1)</script>";
    }
?>

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
    <form method="post" action="UrediNovostForma.php">
        <fieldset class="dodavanje">
            <legend>Uredi novost</legend>
            <input type="hidden" name="naslov" value="<?php echo $Id ?>">
            <label>Naslov: </label> <input class="novostUnos" type="text" name="noviNaslov" value="<?php echo $naslov ?>"><br><br>
            <label>URL slike: </label> <input class="novostUnos" type="text" name="url" value="<?php echo $slika ?>"><br><br>
            <label>Uvod u novost: </label><input class="novostUnos" type="text" name="uvod" value="<?php echo $opis ?>"><br><br>
            <label>Detaljna novost: </label><textarea name="detaljna"><?php echo $detaljno ?></textarea><br><br>
            <label>Ime autora: </label><input class="novostUnos" type="text" name="imeAutora" value="<?php echo $ime ?>"><br><br>
            <label>Prezime autora: </label><input class="novostUnos" type="text" name="prezimeAutora" value="<?php echo $prezime ?>"><br><br>
            <input type="submit" value="Pošalji" class="submitButton5">
        </fieldset>
    </form>
    <br>
</div>

</body>
</html>