<?php

session_start();

if (isset($_SESSION["username"]))
{
    $username = $_SESSION["username"];
    $konekcija = new mysqli("localhost", "root", "", "vremenskaprognoza");
    $konekcija->set_charset("utf8");
    if ($konekcija->connect_error) {
        die("Nemoguće se povezati sa bazom!" . $konekcija->connect_error);
    }
    $spremljen = $konekcija->stmt_init();
    $spremljen->prepare("SELECT * FROM korisnik WHERE username = ?");
    $spremljen->bind_param("s", $username);
    $spremljen->execute();
    $rezultat = $spremljen->get_result();
    while ($red = $rezultat->fetch_array(MYSQLI_NUM))
        print json_encode($red);
    $spremljen->close();
    $konekcija->close();
}
else print "FAILURE";

?>