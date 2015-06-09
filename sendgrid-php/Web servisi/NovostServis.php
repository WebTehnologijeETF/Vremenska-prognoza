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
    $novosti = array();
    $brojac = 0;
    $konekcija = new mysqli("localhost", "root", "", "vremenskaprognoza");
    $konekcija->set_charset("utf8");
    if ($konekcija->connect_error) {
        die("Nemoguće se povezati sa bazom!" . $konekcija->connect_error);
    }

    if ($data["id"] === "*")
    {
        $sql = "SELECT a.Ime, a.Prezime, n.* FROM autor a, novost n WHERE a.Id = n.AutorID";
        $rezultat = $konekcija->query($sql);
        $konekcija->close();

        if ($rezultat->num_rows > 0) {
            while($red = $rezultat->fetch_assoc()) {
                $novosti[$brojac++] = $red;
            }
        }

        usort($novosti, function($a, $b) {
            return $a['DatumObjave'] - $b['DatumObjave'];
        });
        print json_encode($novosti);
    }
    else
    {
        $spremljen = $konekcija->stmt_init();
        $spremljen->prepare("SELECT a.Ime, a.Prezime, n.* FROM autor a, novost n WHERE a.Id = n.AutorID AND n.ID=?");
        $spremljen->bind_param("i", $idAdmina);
        $idAdmina = $data["id"];
        testirajPodatak($idAdmina);
        $spremljen->execute();
        $rezultat = $spremljen->get_result();
        while ($red = $rezultat->fetch_array(MYSQLI_NUM))
            print json_encode($red);
        $spremljen->close();
    }
}

function rest_post ($request, $data)
{
    if (isset($data['naslov']) && isset($data['url'])  && isset($data['uvod']) && isset($data['imeAutora']) && isset($data['prezimeAutora']))
    {
        if (!empty($data['naslov']) && !empty($data['url']) && !empty($data['uvod']) && !empty($data['imeAutora']) && !empty($data['prezimeAutora']))
        {
            $imeAutora = $data['imeAutora'];
            testirajPodatak($imeAutora);
            $prezimeAutora = $data['prezimeAutora'];
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
                    if ($imeAutora == $red['Ime'] && $prezimeAutora == $red['Prezime'])
                    {
                        $postojiAutor = true;
                        $idAutora = $red['Id'];
                    }
                }
            }

            if ($postojiAutor == false)
            {
                $spreman = $konekcija->prepare("INSERT INTO autor (Ime, Prezime) VALUES (?, ?)");
                $spreman->bind_param("ss", $imeAutora, $prezimeAutora);
                $imeAutora = $data['imeAutora'];
                testirajPodatak($imeAutora);
                $prezimeAutora = $data['prezimeAutora'];
                testirajPodatak($prezimeAutora);
                $spreman->execute();
                $idAutora = $spreman->insert_id;
                $spreman->close();
            }

            $ubaciNovost = $konekcija->prepare("INSERT INTO novost (AutorID, Naslov, Slika, Opis, Detaljno) VALUES (?,?,?,?,?)");
            $noviURL="";
            $noviUvod="";
            $noviDetaljna="";
            $ubaciNovost->bind_param("issss", $autorr, $noviNaslov, $noviURL, $noviUvod, $noviDetaljna);
            $autorr = $idAutora;
            $noviNaslov = $data['naslov'];
            testirajPodatak($noviNaslov);
            $noviURL = $data['url'];
            testirajPodatak($noviURL);
            $noviUvod = $data['uvod'];
            testirajPodatak($noviUvod);
            $noviDetaljna = $data['detaljna'];
            testirajPodatak($noviDetaljna);
            $proslo = "FAILURE";
            if ($ubaciNovost->execute())
                $proslo = "SUCCESS";
            $ubaciNovost->close();
            $konekcija->close();
            print $proslo;
        }
        else print "FAILURE";
    }
    else print "FAILURE";
}

function rest_delete ($request)
{
    $parts = parse_url($request);
    parse_str($parts['query'], $query);
    $idNovost = $query['id'];
    $konekcija = new mysqli("localhost", "root", "", "vremenskaprognoza");
    $konekcija->set_charset("utf8");
    if ($konekcija->connect_error) {
        die("Nemoguće se povezati sa bazom!" . $konekcija->connect_error);
    }
    $spremljen = $konekcija->prepare("DELETE FROM novost WHERE Id = ?");
    $spremljen->bind_param("i", $idVijestt);
    $idVijestt = $idNovost;
    $proslo = "FAILURE";
    if ($spremljen->execute())
        $proslo = "SUCCESS";
    $spremljen->close();
    $konekcija->close();
    print $proslo;
}

function rest_put ($request, $data)
{
    if (isset($data['noviNaslov']) && isset($data['url']) && isset($data['uvod']) && isset($data['imeAutora']) & isset($data['prezimeAutora']))
    {
        $imeAutora = $data['imeAutora'];
        testirajPodatak($imeAutora);
        $prezimeAutora = $data['prezimeAutora'];
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
            $imeAutora = $data['imeAutora'];
            testirajPodatak($imeAutora);
            $prezimeAutora = $data['prezimeAutora'];
            testirajPodatak($prezimeAutora);
            $spreman->execute();
            $idAutora = $spreman->insert_id;
            $spreman->close();
        }
        $noviURL = $noviUvod = $noviDetaljna = $stariID = "";
        $ubaciNovost = $konekcija->prepare("UPDATE novost SET AutorID = ?, Naslov = ?, Slika = ?, Opis = ?, Detaljno = ? Where Id=?");
        $ubaciNovost->bind_param("issssi", $autorr, $noviNaslov, $noviURL, $noviUvod, $noviDetaljna, $stariID);
        $autorr = $idAutora;
        $stariID = $data['naslov'];
        testirajPodatak($stariID);
        $noviNaslov = $data['noviNaslov'];
        testirajPodatak($noviNaslov);
        $noviURL = $data['url'];
        testirajPodatak($noviURL);
        $noviUvod = $data['uvod'];
        testirajPodatak($noviUvod);
        $noviDetaljna = $data['detaljna'];
        testirajPodatak($noviDetaljna);
        $proslo = "FAILURE";
        if ($ubaciNovost->execute())
            $proslo = "SUCCESS";
        $ubaciNovost->close();
        $konekcija->close();
        print $proslo;
    }
    else print "FAILURE";
}

function rest_error ($request)
{
    print "Greška! Servis nije dostupan!";
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