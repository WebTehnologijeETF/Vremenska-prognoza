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

if (isset($_POST['noviUsername']) && isset($_POST['noviPass']) && isset($_POST['noviMail'])) {
    $dodaniUsername = $_POST['noviUsername'];
    testirajPodatak($dodaniUsername);
    $dodaniPass = $_POST['noviPass'];
    testirajPodatak($dodaniPass);
    $dodaniMail = $_POST['noviMail'];
    testirajPodatak($dodaniMail);
    $konekcija = new mysqli("127.11.177.130", "adminrHa828q", "U8DdJ3e5RUxl", "wt");
    $konekcija->set_charset("utf8");
    if ($konekcija->connect_error) {
        die("Nemoguće se povezati sa bazom!" . $konekcija->connect_error);
    }
    $postojiUsername = false;
    $sql = "SELECT * FROM administrator";
    $rezultat = $konekcija->query($sql);
    if ($rezultat->num_rows > 0) {
        while ($red = $rezultat->fetch_assoc()) {
            if ($dodaniUsername == $red["username"]) {
                $postojiUsername = true;
                break;
            }
        }
    }
    if ($postojiUsername) {
        echo "<script>alert('Username koji ste unijeli je vec u upotrebi!');</script>";
    } else {
        $ubaciNovost = $konekcija->prepare("UPDATE administrator SET username = ?, password = ?, mail = ? Where Id=?");
        $ubaciNovost->bind_param("sssi", $noviUser, $noviPasss, $noviMaill, $stariID);
        $stariID = $_POST['korisnikUsername'];
        testirajPodatak($stariID);
        $noviUser = $_POST['noviUsername'];
        testirajPodatak($noviUser);
        $noviPasss = $_POST['noviPass'];
        testirajPodatak($noviPasss);
        $noviMaill = $_POST['noviMail'];
        testirajPodatak($noviMaill);
        $ubaciNovost->execute();
        $ubaciNovost->close();
        $konekcija->close();
        echo "<script>alert('Promjene uspjesno izvrsene!')</script>";
    }
}
    $user = $pass = $email = "";
    $Id = $_POST["korisnikUsername"];
    $konekcija = new mysqli("127.11.177.130", "adminrHa828q", "U8DdJ3e5RUxl", "wt");
    $konekcija->set_charset("utf8");
    if ($konekcija->connect_error) {
        die("Nemoguće se povezati sa bazom!" . $konekcija->connect_error);
    }
    $sql = "SELECT * FROM administrator";
    $rezultat = $konekcija->query($sql);
    $konekcija->close();
    $postoji = false;
    $objekt = "";
    if ($rezultat->num_rows > 0) {
        while ($red = $rezultat->fetch_assoc()) {
            $IDadministratora = $red["Id"];
            if ($Id == $IDadministratora) {
                $postoji = true;
                $objekt = $red;
            }
        }
    }
    if ($postoji) {
        $user = $objekt["username"];
        $pass = $objekt["password"];
        $email = $objekt["mail"];
    } else {
        echo "<script>alert('Greska: Korisnik ne postoji sa tim ID-om!')</script>";
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
    <form method="post" action="UrediKorisnikaForma.php">
        <fieldset class="dodavanje">
            <legend>Uredi korisnika</legend>
            <input type="hidden" name="korisnikUsername" value="<?php echo $Id ?>">
            <label>Username (*): </label> <input class="novostUnos" type="text" name="noviUsername" value="<?php echo $user ?>"><br><br>
            <label>Password (*): </label> <input class="novostUnos" type="text" name="noviPass" value="<?php echo $pass ?>"><br><br>
            <label>Mail adresa (*): </label><input class="novostUnos" type="text" name="noviMail" value="<?php echo $email ?>"><br><br>
            <input type="submit" value="Pošalji" class="submitButton5">
        </fieldset>
    </form>
    <br>
</div>

</body>
</html>