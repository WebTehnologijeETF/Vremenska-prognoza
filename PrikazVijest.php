<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="Glavni.css">
    <link href='http://fonts.googleapis.com/css?family=Rokkitt:400,700' rel='stylesheet' type='text/css'>
    <script src="AjaxOtvori.js"></script>
    <script>
        function prikaziSveKomentare() {
            var kontejner = document.getElementById("prikazKomentari");
            kontejner.style.display = "block";
        }
        function saljiMail(id)
        {
            var mailId = "M" + id;
            var mail = document.getElementById(mailId);
            if (mail.innerHTML != null && mail.innerHTML != "")
                window.open('https://mail.google.com/mail/?view=cm&fs=1&to=' + mail.innerHTML);
        }
    </script>
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
        <?php
        function testirajPodatak(&$podatak)
        {
            $podatak = trim($podatak);
            $podatak = stripcslashes($podatak);
            $podatak = htmlspecialchars($podatak);
        }
        $naziv = $_GET['naslov'];
        if(isset($_GET['komentar']) && ($_GET['komentar'] != null))
        {
            $konekcija = new mysqli("localhost", "root", "", "vremenskaprognoza");
            $konekcija->set_charset("utf8");
            if ($konekcija->connect_error) {
                die("Nemoguće se povezati sa bazom!" . $konekcija->connect_error);
            }
            $sql = $konekcija->prepare("INSERT INTO komentar (Komentator, Email, Poruka, NovostID) VALUES (?, ?, ?, ?)");
            $sql->bind_param("sssi", $Komentator, $Email, $Poruka, $NovostID);
            $Komentator = $_GET['autorKomentara'];
            testirajPodatak($Komentator);
            $Email = $_GET['email'];
            testirajPodatak($Email);
            $Poruka = $_GET['komentar'];
            testirajPodatak($Poruka);
            $NovostID = $_GET['ID'];
            $sql->execute();
            $sql->close();
            $konekcija->close();
            echo "<script>alert('Uspješno ste ostavili komentar!');</script>";
        }
        echo '<h2 id="naslovVijesti">' .ucfirst(strtolower($naziv)). '</h2>';
        ?>
        <br>
    <fieldset id="vijest">
        <img id="prikazanVijestSlika" src=<?php echo $_GET['slika'] ?> alt=<?php echo $_GET['slika'] ?>>
        <p id="sadrzajNovosti"><?php echo $_GET['detaljno'] ?></p>
    </fieldset>
    <p><?php echo 'Autor: ', $_GET['autor'] ?></p>
    <p><?php echo 'Datum objave: ', $_GET['datum'] ?></p>

    <p id="komentarBroj" onclick="prikaziSveKomentare()">Broj komentara: <?php
        $Id = $_GET['ID'];
        $konekcija = new mysqli("localhost", "root", "", "vremenskaprognoza");
        $konekcija->set_charset("utf8");
        if ($konekcija->connect_error) {
            die("Nemoguće se povezati sa bazom!" . $konekcija->connect_error);
        }
        $sql = "SELECT * FROM komentar WHERE NovostID = " . $Id;
        $rezultat = $konekcija->query($sql);
        $konekcija->close();
        echo $rezultat->num_rows;
        ?>
    </p>

    <div id="prikazKomentari">
        <br>
        <form action="PrikazVijest.php" method="get">
            <fieldset class="jedanKomentarUnos">
                <legend>Novi komentar</legend>
                <input type="hidden" name="naslov" value='<?php echo $_GET['naslov']?>' >
                <input type="hidden" name="autor" value='<?php echo $_GET['autor']?>' >
                <input type="hidden" name="slika" value='<?php echo $_GET['slika']?>' >
                <input type="hidden" name="datum" value='<?php echo $_GET['datum']?>' >
                <input type="hidden" name="detaljno" value='<?php echo $_GET['detaljno']?>' >
                <input type="hidden" name="ID" value='<?php echo $_GET['ID']?>' >
                <label class='labelaKomentar'>Autor:</label> <input type="text" name="autorKomentara" class="komentarUnosi"><br>
                <label class='labelaKomentar'>Mail:</label> <input type="text" name="email" class="komentarUnosi"><br><br>
                <label class='labelaKomentar'>Poruka:</label> <textarea id="komentarPoruka" name="komentar"></textarea><br><br>
                <input type="submit" value="Pošalji" class="submitButton5">
            </fieldset>
        </form>
        <br>
        <p>Stari komentari:</p>
        <fieldset>

            <?php
            $komentari = array();
            $brojac = 0;
            $Id = $_GET['ID'];
            $konekcija = new mysqli("localhost", "root", "", "vremenskaprognoza");
            $konekcija->set_charset("utf8");
            if ($konekcija->connect_error) {
                die("Nemoguće se povezati sa bazom!" . $konekcija->connect_error);
            }
            $sql = "SELECT * FROM komentar WHERE NovostID = " . $Id;
            $rezultat = $konekcija->query($sql);
            $konekcija->close();

            if ($rezultat->num_rows > 0) {
                while($red = $rezultat->fetch_assoc()) {
                    $komentari[$brojac++] = $red;
                }
            }

            usort($komentari, function($a, $b) {
                return $b['DatumObjave'] - $a['DatumObjave'];
            });

            for ($i = $brojac-1; $i >= 0; $i--)
            {
                $klasaAutora = '';
                $id = $komentari[$i]["Id"];
                $komentarID = "M" . $id;
                if (empty($komentari[$i]["Email"]))
                    $klasaAutora = 'spanKomentar';
                else
                    $klasaAutora = 'spanKomentarAutor';
                echo "<div class='jedanKomentar'><br>
                    <label class='labelaKomentar'>Autor:</label><span id='$id' onclick='saljiMail(this.id)' class=$klasaAutora>" . $komentari[$i]["Komentator"] ."</span><br>".
                    "<label class='labelaKomentar'>Mail:</label><span id='$komentarID' class='spanKomentar'>" . $komentari[$i]["Email"] ."</span><br>".
                    "<label class='labelaKomentar'>Datum objave:</label><span class='spanKomentar'>" . $komentari[$i]["DatumObjave"] ."</span><br><br>".
                    "<label class='labelaKomentar'>Poruka:</label><p class='spanKomentarPoruka'>" . " \" " . $komentari[$i]["Poruka"] . " \" " ."</p>".
                    "<br></div><br>";
            }
            ?>
        </fieldset>
    </div>
    <br>
</div>

</body>
</html>