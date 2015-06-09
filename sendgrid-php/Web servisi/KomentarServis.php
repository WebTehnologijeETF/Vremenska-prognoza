<?php

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

function rest_get ($request, $data)
{
    if (isset($data["novostID"]))
    {
        $komentari = array();
        $brojac = 0;
        $konekcija = new mysqli("localhost", "root", "", "vremenskaprognoza");
        $konekcija->set_charset("utf8");
        if ($konekcija->connect_error) {
            die("Nemoguće se povezati sa bazom!" . $konekcija->connect_error);
        }
        $sql = "SELECT * FROM komentar WHERE NovostID = " . $data["novostID"];
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

        print json_encode($komentari);
    }
}

function rest_post ($request, $data)
{
    if (isset($data['poruka']))
    {
        if (!empty($data['poruka']))
        {
            $imeAutora = $data['username'];
            testirajPodatak($imeAutora);
            $mail = $data['mail'];
            testirajPodatak($mail);
            $poruka = $data['poruka'];
            testirajPodatak($poruka);
            $anonimnost = $data['anonimno'];

            $konekcija = new mysqli("localhost", "root", "", "vremenskaprognoza");
            $konekcija->set_charset("utf8");
            if ($konekcija->connect_error) {
                die("Nemoguće se povezati sa bazom!" . $konekcija->connect_error);
            }
            if ($anonimnost == "OBICNI" || $anonimnost == "NE")
            {
                $spreman = $konekcija->prepare("INSERT INTO komentar (NovostID, KorisnikID, Komentator, Email, Poruka) VALUES (?, ?, ?, ?, ?)");
                $imeKomentatora = $maila = $porr = "";
                $spreman->bind_param("iisss", $novostIde, $korisnikIde, $imeKomentatora, $maila, $porr);
                $novostIde = $data['novostID'];
                $korisnikIde = null;
                $imeKomentatora = $imeAutora;
                $maila = $mail;
                $porr = $poruka;
                if ($spreman->execute())
                {
                    if ($anonimnost == "OBICNI")
                        print "SUCCESS";
                    else print $spreman->insert_id;
                }
                else print "FAILURE";
                $spreman->close();
            }
            else if ($anonimnost == "DA")
            {
                $spreman = $konekcija->prepare("INSERT INTO komentar (NovostID, KorisnikID, Komentator, Email, Poruka) VALUES (?, ?, ?, ?, ?)");
                $imeKomentatora = $maila = $porr = "";
                $spreman->bind_param("iisss", $novostIde, $korisnikIde, $imeKomentatora, $maila, $porr);
                $novostIde = $data['novostID'];
                $korisnikIde = null;
                $imeKomentatora = "";
                $maila = "";
                $porr = $poruka;
                if ($spreman->execute())
                    print "SUCCESS";
                else print "FAILURE";
                $spreman->close();
            }
            $konekcija->close();
        }
        else print "FAILURE";
    }
    else print "FAILURE";
}

function rest_delete ($request)
{
    $parts = parse_url($request);
    parse_str($parts['query'], $query);
    $konekcija = new mysqli("localhost", "root", "", "vremenskaprognoza");
    $konekcija->set_charset("utf8");
    if ($konekcija->connect_error) {
        die("Nemoguće se povezati sa bazom!" . $konekcija->connect_error);
    }
    $spremljen = $konekcija->prepare("DELETE FROM komentar WHERE Id = ?");
    $spremljen->bind_param("i", $idKomentarr);
    $idKomentarr = $query['id'];
    $uspjeh = "FAILURE";
    if ($spremljen->execute())
        $uspjeh = "SUCCESS";
    $spremljen->close();
    $konekcija->close();
    print $uspjeh;
}

function rest_put ($request, $data)
{
    $username = $data['username'];
    $komentar = $data['komentar'];

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
    $id = "";
    while ($red = $rezultat->fetch_array(MYSQLI_NUM))
        $id = $red[0];
    $spremljen->close();

    $spremljen = $konekcija->stmt_init();
    $spremljen->prepare("UPDATE komentar SET KorisnikID = ? WHERE Id = ?");
    $spremljen->bind_param("ii", $kore, $kome);
    $kome = $komentar;
    $kore = $id;
    if ($spremljen->execute())
        print "SUCCESS";
    else print "FAILURE";
    $spremljen->close();
    $konekcija->close();
}

function rest_error ($request)
{

}

$method = $_SERVER ['REQUEST_METHOD'];
$request = $_SERVER ['REQUEST_URI'];

switch ($method)
{
    case 'PUT':
        parse_str ( file_get_contents ( 'php://input' ), $put_vars );
        zag ();
        $data = $put_vars;
        rest_put ($request, $data);
        break;
    case 'POST':
        zag ();
        $data = $_POST;
        rest_post ($request, $data);
        break;
    case 'GET':
        zag ();
        $data = $_GET;
        rest_get ($request, $data);
        break;
    case 'DELETE':
        zag ();
        rest_delete ($request);
        break;
    default:
        header("{$_SERVER [ 'SERVER_PROTOCOL' ] } 404 Not Found" );
        rest_error ( $request );
        break;
}
?>