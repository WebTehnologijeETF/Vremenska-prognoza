<?php

zag();
$sveValidno = true;
$ime = $_GET['ime'];
testirajPodatak($ime);
$mail = $_GET['mail'];
testirajPodatak($mail);
$mjesto = $_GET['grad'];
testirajPodatak($mjesto);
$postanski = $_GET['posta'];
testirajPodatak($postanski);
$subjekt = $_GET['subjekt'];
testirajPodatak($subjekt);
$komentar = $_GET['komentar'];
testirajPodatak($komentar);
$listaGresaka = array();

if (!samoSlova($ime) || empty($ime))
    $listaGresaka[] = "Neispravno ime i prezime";
else
    $listaGresaka[] = "";

if (!mailValidacija($mail) || empty($mail))
    $listaGresaka[] = "Neispravna e-mail adresa";
else
    $listaGresaka[] = "";

if (!subjektValidacija($subjekt, $komentar))
    $listaGresaka[] = "Morate izrabrati subjekt";
else
    $listaGresaka[] = "";

if (!komentarValidacija($subjekt, $komentar))
    $listaGresaka[] = "Morate unijeti komentar";
else
    $listaGresaka[] = "";

if (!samoSlova($mjesto) || empty($mjesto) || empty($postanski))
    $listaGresaka[] = "Neispravan poštanski broj";
else
    $listaGresaka[] = "";

print json_encode($listaGresaka);

function zag ()
{
    header ( " {$_SERVER [ 'SERVER_PROTOCOL' ] } 200 OK" );
    header ( 'ContentType: text/html' );
    header ( 'AccessControlAllowOrigin:*' );
}

function testirajPodatak(&$podatak)
{
    $podatak = trim($podatak);
    $podatak = stripcslashes($podatak);
    $podatak = htmlspecialchars($podatak);
}

function samoSlova($podatak)
{
    $validno = true;
    if (!preg_match("/^[a-zA-Z\\s]*$/",$podatak)) {
        $validno = false;
    }
    return $validno;
}

function mailValidacija($podatak)
{
    $validno = true;
    if (!preg_match("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\\.[a-zA-Z0-9-.]+$/",$podatak))
    {
        $validno = false;
    }
    return $validno;
}

function subjektValidacija($subjekt, $komentar)
{
    $validno = true;
    if (empty($subjekt) && !empty($komentar))
        $validno = false;
    return $validno;
}

function komentarValidacija($subjekt, $komentar)
{
    $validno = true;
    if (!empty($subjekt) && empty($komentar))
        $validno = false;
    return $validno;
}
?>