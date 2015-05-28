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
function testirajPodatak(&$podatak)
{
    $podatak = trim($podatak);
    $podatak = stripcslashes($podatak);
    $podatak = htmlspecialchars($podatak);
}

$dodaniNaslov = ""; $dodaniURL = ""; $dodaniUvod = ""; $dodaniImeAutora = ""; $dodaniPrezimeAutora = ""; $dodaniDetaljno = "";
if (isset($_GET['naslov']) && isset($_GET['url'])  && isset($_GET['uvod']) && isset($_GET['imeAutora']) && isset($_GET['prezimeAutora']))
{

    if (!empty($_GET['naslov']) && !empty($_GET['url']) && !empty($_GET['uvod']) && !empty($_GET['imeAutora']) && !empty($_GET['prezimeAutora']))
    {
        $imeAutora = $_GET['imeAutora'];
        testirajPodatak($imeAutora);
        $prezimeAutora = $_GET['prezimeAutora'];
        testirajPodatak($prezimeAutora);
        $konekcija = new mysqli("127.11.177.130", "adminrHa828q", "U8DdJ3e5RUxl", "wt");
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
            $imeAutora = $_GET['imeAutora'];
            testirajPodatak($imeAutora);
            $prezimeAutora = $_GET['prezimeAutora'];
            testirajPodatak($prezimeAutora);
            $spreman->execute();
            $idAutora = $spreman->insert_id;
            $spreman->close();
        }

        $ubaciNovost = $konekcija->prepare("INSERT INTO novost (AutorID, Naslov, Slika, Opis, Detaljno) VALUES (?,?,?,?,?)");
        $ubaciNovost->bind_param("issss", $autorr, $noviNaslov, $noviURL, $noviUvod, $noviDetaljna);
        $autorr = $idAutora;
        $noviNaslov = $_GET['naslov'];
        testirajPodatak($noviNaslov);
        $noviURL = $_GET['url'];
        testirajPodatak($noviURL);
        $noviUvod = $_GET['uvod'];
        testirajPodatak($noviUvod);
        $noviDetaljna = $_GET['detaljna'];
        testirajPodatak($noviDetaljna);
        $ubaciNovost->execute();
        $ubaciNovost->close();
        $konekcija->close();
        echo "<script>alert('Uspješno ste dodali novost!');</script>";
        $dodaniNaslov = "";
        $dodaniURL = "";
        $dodaniUvod = "";
        $dodaniDetaljno = "";
        $dodaniImeAutora = "";
        $dodaniPrezimeAutora = "";
    }
    else
    {
        $dodaniNaslov = $_GET['naslov'];
        $dodaniURL = $_GET['url'];
        $dodaniUvod = $_GET['uvod'];
        $dodaniDetaljno = $_GET['detaljna'];
        $dodaniImeAutora = $_GET['imeAutora'];
        $dodaniPrezimeAutora = $_GET['prezimeAutora'];
        echo "<script>alert('Niste popunili sve potrebne podatke!');</script>";
    }
}

if (isset($_POST['naslov']))
{
    $konekcija = new mysqli("127.11.177.130", "adminrHa828q", "U8DdJ3e5RUxl", "wt");
    $konekcija->set_charset("utf8");
    if ($konekcija->connect_error) {
        die("Nemoguće se povezati sa bazom!" . $konekcija->connect_error);
    }
    $spremljen = $konekcija->prepare("DELETE FROM novost WHERE Id = ?");
    $spremljen->bind_param("i", $idVijestt);
    $idVijestt = $_POST['naslov'];
    $spremljen->execute();
    $spremljen->close();
    $konekcija->close();
    echo "<script>alert('Uspješno ste izvršili brisanje novosti!');</script>";
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
    <form action="Novosti.php" method="GET">
        <fieldset class="dodavanje">
            <legend>Dodavanje novosti</legend>
            <label>Naslov (*): </label> <input class="novostUnos" type="text" name="naslov" value="<?php echo $dodaniNaslov ?>"><br><br>
            <label>URL slike (*): </label> <input class="novostUnos" type="text" name="url" value="<?php echo $dodaniURL ?>"><br><br>
            <label>Uvod u novost (*): </label><input class="novostUnos" type="text" name="uvod" value="<?php echo $dodaniUvod ?>"><br><br>
            <label>Detaljna novost: </label><textarea name="detaljna"><?php echo $dodaniDetaljno ?></textarea><br><br>
            <label>Ime autora (*): </label><input class="novostUnos" type="text" name="imeAutora" value="<?php echo $dodaniImeAutora ?>"><br><br>
            <label>Prezime autora (*): </label><input class="novostUnos" type="text" name="prezimeAutora" value="<?php echo $dodaniPrezimeAutora ?>"><br><br>
            <input type="submit" value="Dodaj" class="submitButton5">
        </fieldset>
    </form>
    <datalist id="SveNovosti">
        <?php
        $konekcija = new mysqli("127.11.177.130", "adminrHa828q", "U8DdJ3e5RUxl", "wt");
        $konekcija->set_charset("utf8");
        if ($konekcija->connect_error) {
            die("Nemoguće se povezati sa bazom!" . $konekcija->connect_error);
        }
        $sql = "SELECT * FROM novost";
        $rezultat = $konekcija->query($sql);
        $konekcija->close();
        if ($rezultat->num_rows > 0) {
            while($red = $rezultat->fetch_assoc()) {
                $IDnovosti = $red["Id"];
                $naslovNovosti = $red["Naslov"];
                echo "<option value='$IDnovosti'>$naslovNovosti</option>";
            }
        }
        ?>
    </datalist>
    <form action="UrediNovostForma.php" method="POST">
        <fieldset class="dodavanje">
            <legend>Uređivanje novosti</legend>
            <p>Izaberite vijest koju želite uređivati:</p>
            <label>Naslov: </label> <input class="novostUnos" type="text" name="naslov" list="SveNovosti"><br><br>
            <input type="submit" value="Uredi" class="submitButton5">
        </fieldset>
    </form>
    <form action="Novosti.php" method="POST">
        <fieldset class="dodavanje">
            <legend>Brisanje novosti</legend>
            <p>Izaberite vijest koju želite izbrisati:</p>
            <label>Naslov: </label> <input class="novostUnos" type="text" name="naslov" list="SveNovosti"><br><br>
            <input type="submit" value="Obriši" class="submitButton5">
        </fieldset>
    </form>
<br>
</div>

</body>
</html>