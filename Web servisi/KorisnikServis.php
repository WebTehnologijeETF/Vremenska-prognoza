<?php

function testirajPodatak(&$podatak)
{
    $podatak = trim($podatak);
    $podatak = stripcslashes($podatak);
    $podatak = htmlspecialchars($podatak);
}

function zag ()
{
    header ( " {$_SERVER [ 'SERVER_PROTOCOL' ] } 200 OK" );
    header ( 'ContentType: text/html' );
    header ( 'AccessControlAllowOrigin:*' );
}

function rest_get ($request, $data)
{
    $konekcija = new mysqli("localhost", "root", "", "vremenskaprognoza");
    $konekcija->set_charset("utf8");
    if ($konekcija->connect_error) {
        die("Nemoguće se povezati sa bazom!" . $konekcija->connect_error);
    }
    if ($data["id"] === "*")
    {
        $sql = "SELECT * FROM korisnik";
        $rezultat = $konekcija->query($sql);
        $nizKorisnika = array();
        if ($rezultat->num_rows > 0) {
            while($red = $rezultat->fetch_assoc()) {
                $nizKorisnika[] = $red;
            }
        }
        print json_encode($nizKorisnika);
    }
    else
    {
        $spremljen = $konekcija->stmt_init();
        $spremljen->prepare("SELECT * FROM korisnik WHERE Id = ?");
        $spremljen->bind_param("i", $idAdmina);
        $idAdmina = $data["id"];
        testirajPodatak($idAdmina);
        $spremljen->execute();
        $rezultat = $spremljen->get_result();
        while ($red = $rezultat->fetch_array(MYSQLI_NUM))
            print json_encode($red);
        $spremljen->close();
    }
    $konekcija->close();
}

function rest_post ($request, $data)
{
    if (isset($data['username']) && isset($data['pss'])  && isset($data['mailAdresa']))
    {
        if (!empty($data['username']) && !empty($data['pss']) && !empty($data['mailAdresa']))
        {
            $dodaniUsername = $data['username'];
            testirajPodatak($username);
            $dodaniPass = $data['pss'];
            testirajPodatak($password);
            $dodaniMail = $data['mailAdresa'];
            testirajPodatak($email);
            $dodaniAdmin = $data['admin'];
            $konekcija = new mysqli("localhost", "root", "", "vremenskaprognoza");
            $konekcija->set_charset("utf8");
            if ($konekcija->connect_error) {
                die("Nemoguće se povezati sa bazom!" . $konekcija->connect_error);
            }
            $postojiUsername = false;
            $sql = "SELECT * FROM korisnik";
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
                print "FAILURE";
            else
            {
                $onoMail = "";
                $onoAdmin = false;
                $spreman = $konekcija->prepare("INSERT INTO korisnik (username, password, mail, administrator) VALUES (?, ?, ?, ?)");
                $spreman->bind_param("sssi", $korisnikUser, $korisnikPass, $onoMail, $onoAdmin);
                $korisnikUser = $dodaniUsername;
                $korisnikPass = $dodaniPass;
                $onoMail = $dodaniMail;
                $onoAdmin = (int)$dodaniAdmin;
                $proslo = "FAILURE";
                if ($spreman->execute())
                    $proslo = "SUCCESS";
                $spreman->close();
                $konekcija->close();
                print $proslo;
            }
        }
    }
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
    $proslo = "FAILURE";
    $isAdmin = false;
    $sql = "SELECT * FROM korisnik WHERE administrator=1";
    $rezultat = $konekcija->query($sql);
    while($red = $rezultat->fetch_assoc()) {
        if ($red["Id"] == $query['id'])
        {
            $isAdmin = true;
            break;
        }
    }
    if ($isAdmin)
    {
        if ($rezultat->num_rows > 1) {
            $spremljen = $konekcija->prepare("DELETE FROM korisnik WHERE Id = ?");
            $spremljen->bind_param("i", $idAdmina);
            $idAdmina = $query['id'];
            testirajPodatak($idAdmina);
            if ($spremljen->execute())
                $proslo = "SUCCESS";
            $spremljen->close();
            $konekcija->close();
            print $proslo;
        }
    }
    else
    {
        $spremljen = $konekcija->prepare("DELETE FROM korisnik WHERE Id = ?");
        $spremljen->bind_param("i", $idAdmina);
        $idAdmina = $query['id'];
        testirajPodatak($idAdmina);
        if ($spremljen->execute())
            $proslo = "SUCCESS";
        $spremljen->close();
        $konekcija->close();
        print $proslo;
    }
}

function rest_put ($request, $data)
{
    if (isset($data['noviUsername']) && isset($data['noviPass']) && isset($data['noviMail'])) {
        $dodaniUsername = $data['noviUsername'];
        testirajPodatak($dodaniUsername);
        $dodaniPass = $data['noviPass'];
        testirajPodatak($dodaniPass);
        $dodaniMail = $data['noviMail'];
        testirajPodatak($dodaniMail);
        $konekcija = new mysqli("localhost", "root", "", "vremenskaprognoza");
        $konekcija->set_charset("utf8");
        if ($konekcija->connect_error) {
            die("Nemoguće se povezati sa bazom!" . $konekcija->connect_error);
        }
        $postojiUsername = false;
        $sql = "SELECT * FROM korisnik";
        $rezultat = $konekcija->query($sql);
        if ($rezultat->num_rows > 0) {
            while ($red = $rezultat->fetch_assoc()) {
                if ($dodaniUsername == $red["username"]) {
                    $postojiUsername = true;
                    break;
                }
            }
        }
        if ($postojiUsername)
            print "FAILURE";
        else
        {
            $ubaciNovost = $konekcija->prepare("UPDATE korisnik SET username = ?, password = ?, mail = ? Where Id=?");
            $noviMaill = "";
            $stariID = "";
            $ubaciNovost->bind_param("sssi", $noviUser, $noviPasss, $noviMaill, $stariID);
            $stariID = $data['korisnikUsername'];
            testirajPodatak($stariID);
            $noviUser = $data['noviUsername'];
            testirajPodatak($noviUser);
            $noviPasss = $data['noviPass'];
            testirajPodatak($noviPasss);
            $noviMaill = $data['noviMail'];
            testirajPodatak($noviMaill);
            $proslo = "FAILURE";
            if ($ubaciNovost->execute())
                $proslo = "SUCCESS";
            $ubaciNovost->close();
            $konekcija->close();
            print $proslo;
        }
    }
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