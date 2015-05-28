<?php

session_start();

function is_session_started()
{
    if ( php_sapi_name() !== 'cli' ) {
        if ( version_compare(phpversion(), '5.4.0', '>=') ) {
            return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
        } else {
            return session_id() === '' ? FALSE : TRUE;
        }
    }
    return FALSE;
}

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

    if ($konekcija->connect_error) {
        die("Nemoguće se povezati sa bazom!" . $konekcija->connect_error);
    }

    $sql = "SELECT a.username, a.password FROM administrator a";
    $rezultat = $konekcija->query($sql);
    $konekcija->close();

    if ($rezultat->num_rows > 0) {
        while($red = $rezultat->fetch_assoc()) {
            if ($red["username"] == $username && $red["password"] == $pass)
            {
                $postoji = true;
                $admin = $red;
            }
        }
    }

    if ($postoji)
    {
        $_SESSION["login"] = "da";
        $_SESSION["username"] = $username;
        $_SESSION["password"] = $pass;
        echo "<script>window.open('AdministratorPanel.html');</script>";
    }
    else
    {
        echo "<script>alert('Neispravni login podaci!');</script>";
        echo "<script>history.go(-1);</script>";
    }
?>