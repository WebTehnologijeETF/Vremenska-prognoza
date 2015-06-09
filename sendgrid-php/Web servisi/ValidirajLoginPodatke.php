<?php

session_start();

function testirajPodatak(&$podatak)
{
    $podatak = trim($podatak);
    $podatak = stripcslashes($podatak);
    $podatak = htmlspecialchars($podatak);
}

$postoji = false;
$admin = "";
$username = $_POST['username'];
testirajPodatak($username);
$pass = $_POST['psw'];
testirajPodatak($pass);
$konekcija = new mysqli("localhost", "root", "", "vremenskaprognoza");
$konekcija->set_charset("utf8");

if ($konekcija->connect_error)
    die("Nemoguće se povezati sa bazom!" . $konekcija->connect_error);

$sql = "SELECT a.username, a.password, a.administrator FROM korisnik a";
$rezultat = $konekcija->query($sql);
$konekcija->close();$isAdmin = false;
if ($rezultat->num_rows > 0) {
    while($red = $rezultat->fetch_assoc()) {
        if ($red["username"] == $username && $red["password"] == $pass)
        {
            $postoji = true;
            $admin = $red;
            $isAdmin = ($red["administrator"] == 1)? true: false;
            break;
        }
    }
}

if ($postoji)
{
    $_SESSION["username"] = $username;
    $_SESSION["password"] = $pass;
    $podaci = array();
    $podaci[] = $username;
    $podaci[] = $pass;
    if ($isAdmin)
    {
        $_SESSION["tip"] = "administrator";
        $podaci[] = "administrator";
    }
    else
    {
        $_SESSION["tip"] = "obicni";
        $podaci[] = "obicni";
    }
    print json_encode($podaci);
}
else
    print "FAILURE";

?>