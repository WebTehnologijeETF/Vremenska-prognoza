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

$dodaniUsername = ""; $dodaniPass = ""; $dodaniMail = "";
if (isset($_GET['username']) && isset($_GET['pss'])  && isset($_GET['mailAdresa']))
{
    if (!empty($_GET['username']) && !empty($_GET['pss']) && !empty($_GET['mailAdresa']))
    {
        $dodaniUsername = $_GET['username'];
        testirajPodatak($username);
        $dodaniPass = $_GET['pss'];
        testirajPodatak($password);
        $dodaniMail = $_GET['mailAdresa'];
        testirajPodatak($email);
        $konekcija = new mysqli("localhost", "root", "", "vremenskaprognoza");
        $konekcija->set_charset("utf8");
        if ($konekcija->connect_error) {
            die("Nemoguće se povezati sa bazom!" . $konekcija->connect_error);
        }
        $postojiUsername = false;
        $sql = "SELECT * FROM administrator";
        $rezultat = $konekcija->query($sql);
        if ($rezultat->num_rows > 0) {
            while($red = $rezultat->fetch_assoc()) {
                if ($dodaniUsername == $red["username"])
                {
                    $postojiUsername = true;
                    break;
                }
            }
        }
        if ($postojiUsername)
            echo "<script>alert('Username koji ste unijeli je vec u upotrebi!');</script>";
        else
        {
            $spreman = $konekcija->prepare("INSERT INTO administrator (username, password, mail) VALUES (?, ?, ?)");
            $spreman->bind_param("sss", $korisnikUser, $korisnikPass, $korisnikMail);
            $korisnikUser = $dodaniUsername;
            $korisnikPass = $dodaniPass;
            $korisnikMail = $dodaniMail;
            $spreman->execute();
            $spreman->close();
            $konekcija->close();
            $dodaniUsername = "";
            $dodaniPass = "";
            $dodaniMail = "";
            echo "<script>alert('Uspješno ste dodali korisnika!');</script>";
        }
    }
    else
    {
        $dodaniUsername = $_GET['username'];
        $dodaniPass = $_GET['pss'];
        $dodaniMail = $_GET['mailAdresa'];
        echo "<script>alert('Niste popunili sve potrebne podatke!');</script>";
    }
}

if (isset($_POST['username']))
{
    $konekcija = new mysqli("localhost", "root", "", "vremenskaprognoza");
    $konekcija->set_charset("utf8");
    if ($konekcija->connect_error) {
        die("Nemoguće se povezati sa bazom!" . $konekcija->connect_error);
    }
    $sql = "SELECT * FROM administrator";
    $rezultat = $konekcija->query($sql);
    if ($rezultat->num_rows > 1) {
        $spremljen = $konekcija->prepare("DELETE FROM administrator WHERE Id = ?");
        $spremljen->bind_param("i", $idAdmina);
        $idAdmina = $_POST['username'];
        testirajPodatak($idAdmina);
        $spremljen->execute();
        $spremljen->close();
        $konekcija->close();
        echo "<script>alert('Uspješno ste izvršili brisanje korisnika!');</script>";
    }
    else
    {
        echo "<script>alert('Ne smijete izbrisati sve korisnike!');</script>";
    }
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

    <form action="Korisnici.php" method="GET">
        <fieldset class="dodavanje">
            <legend>Dodavanje korisnika</legend>
            <label>Username (*): </label> <input class="novostUnos" type="text" name="username" value="<?php echo $dodaniUsername ?>"><br><br>
            <label>Password (*): </label> <input class="novostUnos" type="password" name="pss" value="<?php echo $dodaniPass ?>"><br><br>
            <label>Mail adresa (*): </label><input class="novostUnos" type="text" name="mailAdresa" value="<?php echo $dodaniMail ?>"><br><br>
            <input type="submit" value="Dodaj" class="submitButton5">
        </fieldset>
    </form>
    <datalist id="SviKorisnici">
        <?php
        $konekcija = new mysqli("localhost", "root", "", "vremenskaprognoza");
        $konekcija->set_charset("utf8");
        if ($konekcija->connect_error) {
            die("Nemoguće se povezati sa bazom!" . $konekcija->connect_error);
        }
        $sql = "SELECT * FROM administrator";
        $rezultat = $konekcija->query($sql);
        $konekcija->close();
        if ($rezultat->num_rows > 0) {
            while($red = $rezultat->fetch_assoc()) {
                $IDadmin = $red["Id"];
                $usernameKorisnika = $red["username"];
                echo "<option value='$IDadmin'>$usernameKorisnika</option>";
            }
        }
        ?>
    </datalist>
    <form action="UrediKorisnikaForma.php" method="POST">
        <fieldset class="dodavanje">
            <legend>Uređivanje korisnika</legend>
            <p>Izaberite korisnika kojeg želite uređivati:</p>
            <label>Username: </label> <input class="novostUnos" type="text" name="korisnikUsername" list="SviKorisnici"><br><br>
            <input type="submit" value="Uredi" class="submitButton5">
        </fieldset>
    </form>
    <form action="Korisnici.php" method="POST">
        <fieldset class="dodavanje">
            <legend>Brisanje korisnika</legend>
            <p>Izaberite korisnika kojeg želite izbrisati:</p>
            <label>Username: </label> <input class="novostUnos" type="text" name="username" list="SviKorisnici"><br><br>
            <input type="submit" value="Obriši" class="submitButton5">
        </fieldset>
    </form>
    <br>

</div>

</body>
</html>