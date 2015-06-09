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

function vratiSveNovostiNaslovna(id)
{
    var xmlhttp;
    if (window.XMLHttpRequest)
        xmlhttp = new XMLHttpRequest();
    else
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            var sveNovosti = JSON.parse(xmlhttp.responseText);
            var prikazNovosti = document.getElementById("novosti");
            for (var i = 0; i < sveNovosti.length; i++)
            {
                var ID = sveNovosti[i]["Id"];
                var autor = sveNovosti[i]["Ime"] + " " + sveNovosti[i]["Prezime"];
                var naslov = sveNovosti[i]["Naslov"];
                var slika = sveNovosti[i]["Slika"];
                var sadrzajNovosti = sveNovosti[i]["Opis"];
                var datum = sveNovosti[i]["DatumObjave"];
                var detaljnijeNovosti = sveNovosti[i]["Detaljno"];
                var vidljivost = 'display:block';
                if (detaljnijeNovosti == null || detaljnijeNovosti.length == 0)
                    vidljivost = 'display:none';
                prikazNovosti.innerHTML += "<form method='get' action='PrikazVijest.html'>" +
                "<div class='listItem'>" +
                "<input type='hidden' name='ID' value=" + ID +">" +
                "<img src=" + slika + " alt=" + slika + ">" +
                "<h3 class='naslov'>" + naslov + "</h3>" +
                "<p>" + sadrzajNovosti + "</p><br>" +
                "<p class='nastaviLink'><span>" +  autor + " " + datum + "</span> </p>" + "<input style=" + vidljivost + " type='submit' id='submitButton4' value='Detaljnije>>'>" +
                "</div></form>";
            }
        }
    };
    xmlhttp.open("GET", "Web Servisi/NovostServis.php?id="+id, true);
    xmlhttp.send();
}

function vratiNovostPrikaz(id)
{
    var xmlhttp;
    if (window.XMLHttpRequest)
        xmlhttp = new XMLHttpRequest();
    else
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            var jednaNovost = JSON.parse(xmlhttp.responseText);
            var slika = document.getElementById("prikazanVijestSlika");
            var detaljan = document.getElementById("sadrzajNovosti");
            var autor = document.getElementById("autorVijest");
            var datum = document.getElementById("datumVijest");
            detaljan.innerHTML = jednaNovost[7];
            autor.innerHTML = jednaNovost[0] + " " + jednaNovost[1];
            datum.innerHTML = jednaNovost[8];
            slika.src = jednaNovost[5];
            slika.alt = jednaNovost[5];
            prikaziKomentare(id);
        }
    };
    xmlhttp.open("GET", "Web Servisi/NovostServis.php?id="+id, true);
    xmlhttp.send();
}

function getQueryVariable(variable)
{
    var query = window.location.search.substring(1);
    var vars = query.split('&');
    for (var i = 0; i < vars.length; i++) {
        var pair = vars[i].split('=');
        if (decodeURIComponent(pair[0]) == variable) {
            return decodeURIComponent(pair[1]);
        }
    }
}

function prikaziKomentare(novostID)
{
    var xmlhttp;
    if (window.XMLHttpRequest)
        xmlhttp = new XMLHttpRequest();
    else
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            var sviKomentari = JSON.parse(xmlhttp.responseText);
            document.getElementById("komentarBroj").innerHTML += " " + sviKomentari.length;
            for (var i = sviKomentari.length-1; i >= 0; i--)
            {
                var klasaAutora = '';
                var id = sviKomentari[i]["Id"];
                var komentarID = "M" + id;
                if (sviKomentari[i]["Email"] == null)
                    sviKomentari[i]["Email"] = "";
                if (sviKomentari[i]["Komentator"] == null)
                    sviKomentari[i]["Komentator"] = "";
                if (sviKomentari[i]["Email"] == null || sviKomentari[i]["Email"] == "")
                    klasaAutora = 'spanKomentar';
                else
                    klasaAutora = 'spanKomentarAutor';
                document.getElementById("staro").innerHTML += "<div class='jedanKomentar'><br>" +
                "<label class='labelaKomentar'>Autor:</label><span id=" + id + " " + "onclick='saljiMail(this.id)' class=" + klasaAutora + " >"  + sviKomentari[i]["Komentator"] +"</span><br>" +
                "<label class='labelaKomentar'>Mail:</label><span id=" + komentarID + " " + "class='spanKomentar'>" + sviKomentari[i]["Email"] + "</span><br>" +
                "<label class='labelaKomentar'>Datum objave:</label><span class='spanKomentar'>" + sviKomentari[i]["DatumObjave"] + "</span><br><br>" +
                "<label class='labelaKomentar'>Poruka:</label><p class='spanKomentarPoruka'>" + " \" " + sviKomentari[i]["Poruka"] + " \" " +"</p>" +
                "<br></div><br>";
            }
        }
    };
    xmlhttp.open("GET", "Web Servisi/KomentarServis.php?novostID="+novostID, true);
    xmlhttp.send();
}

function otkrij()
{
    if (document.getElementById("prikazKomentari").style.display == "block")
    {
        document.getElementById("prikazKomentari").style.display = "none";
        document.getElementById("staro").style.display = "none";
    }
    else
    {
        document.getElementById("prikazKomentari").style.display = "block";
        document.getElementById("staro").style.display = "block";
        prikaziKomentatora();
    }
}

function obrisiKomentar(pritisnutiButton)
{
    var rijeci = pritisnutiButton.split("+");
    var unos = document.getElementById("komentarZaBrisanjeID"+rijeci[1]).value;
    var xmlhttp;
    if (window.XMLHttpRequest)
        xmlhttp = new XMLHttpRequest();
    else
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            if (xmlhttp.responseText == "SUCCESS")
            {
                window.location.href = "Komentari.html";
                alert("Uspješno ste izbrisali komentar!");
            }
            else
                alert("Niste izabrali postojeći komentar za brisanje!");
        }
    };
    xmlhttp.open("DELETE", "Web Servisi/KomentarServis.php?id="+unos, true);
    xmlhttp.send();
}

function ispisiKomentare(novostID)
{
    var xmlhttp;
    if (window.XMLHttpRequest)
        xmlhttp = new XMLHttpRequest();
    else
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            var trenutniKomentari = JSON.parse(xmlhttp.responseText);
            for (var i = 0; i < trenutniKomentari.length; i++)
            {
                var kontejner = document.getElementById(novostID);
                var komentarID = trenutniKomentari[i]["Id"];
                var komentarTekst = trenutniKomentari[i]["Poruka"];
                kontejner.innerHTML += "<label class='prikazKomentara'> ID:" + komentarID + "</label><p class='prikazPorukeKomentara'>" + komentarTekst + "</p><br><br>";
                if (i == trenutniKomentari.length-1)
                {
                    var idBroja = "komentarZaBrisanjeID"+novostID;
                    var idButtona = "buttonZaBrisanje+" + novostID;
                    kontejner.innerHTML += "<hr><p>Unesite ID komentara kojeg želite ukloniti zbog neprimjerenog sadržaja: </p><br>" +
                    "<input id=" + idBroja + " class='unosID' type='number' name='komentarID' min='1'><br><br>";
                    kontejner.innerHTML += "<input id=" + idButtona + " type='button' class='submitButton5' value='Izbriši' list='komentarLista' onclick='obrisiKomentar(this.id)'>";
                }
            }
        }
    };
    xmlhttp.open("GET", "Web Servisi/KomentarServis.php?novostID="+novostID, true);
    xmlhttp.send();
}

function prikaziNovostKomentare()
{
    var xmlhttp;
    if (window.XMLHttpRequest)
        xmlhttp = new XMLHttpRequest();
    else
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            var sveNovosti = JSON.parse(xmlhttp.responseText);
            for (var i = 0; i < sveNovosti.length; i++)
            {
                var naziv = sveNovosti[i]["Naslov"];
                var trenutniID = sveNovosti[i]["Id"];
                var kontejner = document.getElementById("sredina");
                kontejner.innerHTML += "<form><fieldset class='dodavanje' id=" + trenutniID + ">" +
                "<legend>"+naziv+"</legend><br>";
                kontejner.innerHTML += "</fieldset></form><br>";
                ispisiKomentare(trenutniID);
            }
        }
    };
    xmlhttp.open("GET", "Web Servisi/NovostServis.php?id=*", true);
    xmlhttp.send();
}

function dodajKorisnika()
{
    var username = document.getElementById("korisnikUser");
    var password = document.getElementById("korisnikPass");
    var mail = document.getElementById("korisnikMail");
    var isAdmin = document.getElementById("administrator");
    var xmlhttp;
    var params = "username="+username.value+"&pss="+password.value+"&mailAdresa="+mail.value+"&admin="+isAdmin.value;
    if (window.XMLHttpRequest)
        xmlhttp = new XMLHttpRequest();
    else
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            if (xmlhttp.responseText == "SUCCESS")
            {
                alert("Uspješno ste dodali korisnika!");
                window.location.href = "Korisnici.html";
            }
            else
                alert("Operacija dodavanja korisnika nije bila uspješna!");
        }
    };
    xmlhttp.open("POST", "Web Servisi/KorisnikServis.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(params);
}

function obrisiKorisnika()
{
    var vrijednostID = document.getElementById("izabraniKorisnikZaBrisanje");
    var id = vrijednostID.value;
    var xmlhttp;
    if (window.XMLHttpRequest)
        xmlhttp = new XMLHttpRequest();
    else
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            if (xmlhttp.responseText == "SUCCESS")
            {
                alert("Uspješno ste izbrisali korisnika!");
                window.location.href = "Korisnici.html";
            }
            else
                alert("Operacija brisanja korisnika nije bila uspješna!");
        }
    };
    xmlhttp.open("DELETE", "Web Servisi/KorisnikServis.php?id="+id, true);
    xmlhttp.send();
}

function ucitajKorisnikaZaEdit(korisnikID)
{
    var xmlhttp;
    if (window.XMLHttpRequest)
        xmlhttp = new XMLHttpRequest();
    else
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            var zaposlenik = JSON.parse(xmlhttp.responseText);
            var NU = document.getElementById("noviUsername");
            var NP = document.getElementById("noviPass");
            var NM = document.getElementById("noviMail");
            NU.value = zaposlenik[1];
            NP.value = zaposlenik[2];
            NM.value = zaposlenik[4];
        }
    };
    xmlhttp.open("GET", "Web Servisi/KorisnikServis.php?id="+korisnikID, true);
    xmlhttp.send();
}

function urediKorisnika(korisnikID)
{
    var NU = document.getElementById("noviUsername");
    var NP = document.getElementById("noviPass");
    var NM = document.getElementById("noviMail");
    var params = "korisnikUsername="+korisnikID+"&noviUsername="+NU.value+"&noviPass="+NP.value+"&noviMail="+NM.value;
    var xmlhttp;
    if (window.XMLHttpRequest)
        xmlhttp = new XMLHttpRequest();
    else
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            if (xmlhttp.responseText == "SUCCESS")
            {
                alert("Uspješno ste uredili korisnika!");
                window.location.href = "Korisnici.html";
            }
            else
                alert("Operacija uređivanja korisnika nije bila uspješna!");
        }
    };
    xmlhttp.open("PUT", "Web Servisi/KorisnikServis.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.setRequestHeader("Content-length", params.length);
    xmlhttp.setRequestHeader("Connection", "close");
    xmlhttp.send(params);
}

function popuniKorisnickiDatalist()
{
    var xmlhttp;
    if (window.XMLHttpRequest)
        xmlhttp = new XMLHttpRequest();
    else
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            var sviKorisnici = JSON.parse(xmlhttp.responseText);
            var opcije = "";
            for (var i = 0; i < sviKorisnici.length; i++)
            {
                var korisnikID = sviKorisnici[i]["Id"];
                var korisnikUsername = sviKorisnici[i]["username"];
                opcije += "<option value=" + korisnikID + " >" + korisnikUsername + "</option>";
            }
            document.getElementById("SviKorisnici").innerHTML = opcije;
        }
    };
    xmlhttp.open("GET", "Web Servisi/KorisnikServis.php?id=*", true);
    xmlhttp.send();
}

function popuniNovostiDatalist()
{
    var xmlhttp;
    if (window.XMLHttpRequest)
        xmlhttp = new XMLHttpRequest();
    else
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            var sveNovosti = JSON.parse(xmlhttp.responseText);
            var opcije = "";
            for (var i = 0; i < sveNovosti.length; i++)
            {
                var novostID = sveNovosti[i]["Id"];
                var novostNaslov = sveNovosti[i]["Naslov"];
                opcije += "<option value=" + novostID + " >" + novostNaslov + "</option>";
            }
            document.getElementById("SveNovosti").innerHTML = opcije;
        }
    };
    xmlhttp.open("GET", "Web Servisi/NovostServis.php?id=*", true);
    xmlhttp.send();
}

function dodajNovost()
{
    var naslov = document.getElementById("novostNaslov");
    var slika = document.getElementById("novostSlikaURL");
    var uvod = document.getElementById("novostUvod");
    var detaljno = document.getElementById("novostDetaljno");
    var autorIme = document.getElementById("novostImeAutora");
    var autorPrezime = document.getElementById("novostPrezimeAutora");
    var xmlhttp;
    var params = "naslov="+naslov.value+"&url="+slika.value+"&uvod="+uvod.value+"&imeAutora="+autorIme.value+"&prezimeAutora="+autorPrezime.value+"&detaljna="+detaljno.value;
    if (window.XMLHttpRequest)
        xmlhttp = new XMLHttpRequest();
    else
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            if (xmlhttp.responseText == "SUCCESS")
            {
                alert("Uspješno ste dodali novost!");
                window.location.href = "Novosti.html";
            }
            else
                alert("Operacija dodavanja novosti nije bila uspješna!");
        }
    };
    xmlhttp.open("POST", "Web Servisi/NovostServis.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(params);
}

function obrisiNovost()
{
    var vrijednostID = document.getElementById("izabranaNovostZaBrisanje");
    var id = vrijednostID.value;
    var xmlhttp;
    if (window.XMLHttpRequest)
        xmlhttp = new XMLHttpRequest();
    else
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            if (xmlhttp.responseText == "SUCCESS")
            {
                alert("Uspješno ste izbrisali novost!");
                window.location.href = "Novosti.html";
            }
            else
                alert("Operacija brisanja novosti nije bila uspješna!");
        }
    };
    xmlhttp.open("DELETE", "Web Servisi/NovostServis.php?id="+id, true);
    xmlhttp.send();
}

function ucitajNovostZaEdit(novostID)
{
    var xmlhttp;
    if (window.XMLHttpRequest)
        xmlhttp = new XMLHttpRequest();
    else
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            var novost = JSON.parse(xmlhttp.responseText);
            alert(novost);
            var Naslov = document.getElementById("noviNaslov");
            var URL = document.getElementById("noviUrl");
            var Uvod = document.getElementById("noviUvod");
            var Detaljna = document.getElementById("novaDetaljna");
            var Ime = document.getElementById("novoIme");
            var Prezime = document.getElementById("novoPrezime");
            Naslov.value = novost[4];
            URL.value = novost[5];
            Uvod.value = novost[6];
            Detaljna.value = novost[7];
            Ime.value = novost[0];
            Prezime.value = novost[1];
        }
    };
    xmlhttp.open("GET", "Web Servisi/NovostServis.php?id="+novostID, true);
    xmlhttp.send();
}

function urediNovost(novostID)
{
    var Naslov = document.getElementById("noviNaslov");
    var URL = document.getElementById("noviUrl");
    var Uvod = document.getElementById("noviUvod");
    var Detaljna = document.getElementById("novaDetaljna");
    var Ime = document.getElementById("novoIme");
    var Prezime = document.getElementById("novoPrezime");
    var params = "naslov="+novostID+"&noviNaslov="+Naslov.value+"&url="+URL.value+"&uvod="+Uvod.value+"&imeAutora="+Ime.value+"&prezimeAutora="+Prezime.value+"&detaljna="+Detaljna.value;
    var xmlhttp;
    if (window.XMLHttpRequest)
        xmlhttp = new XMLHttpRequest();
    else
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            if (xmlhttp.responseText == "SUCCESS")
            {
                alert("Uspješno ste uredili novost!");
                window.location.href = "Novosti.html";
            }
            else
                alert("Operacija uređivanja novosti nije bila uspješna!");
        }
    };
    xmlhttp.open("PUT", "Web Servisi/NovostServis.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.setRequestHeader("Content-length", params.length);
    xmlhttp.setRequestHeader("Connection", "close");
    xmlhttp.send(params);
}

function pokreniSesiju()
{
    var xmlhttp;
    if (window.XMLHttpRequest)
        xmlhttp = new XMLHttpRequest();
    else
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            var podaci = JSON.parse(xmlhttp.responseText);
            if (podaci[0] == "administrator")
            {
                var link = document.getElementById("AdminDashboard");
                if (link != null)
                    link.style.display = "block";
                var userPrijavljenTekst = document.getElementById("korisnikPrijava");
                userPrijavljenTekst.innerHTML = "Prijavljeni ste kao: " + podaci[1];
                var prijavaButtonp = document.getElementById("akcijaPrijava");
                prijavaButtonp.innerHTML = "(Odjavi se)";

            }
            else if (podaci[0] == "obicni")
            {
                var userPrijavljenTekst = document.getElementById("korisnikPrijava");
                userPrijavljenTekst.innerHTML = "Prijavljeni ste kao: " + podaci[1];
                var prijavaButtonp = document.getElementById("akcijaPrijava");
                prijavaButtonp.innerHTML = "(Odjavi se)";
            }
        }
    };
    xmlhttp.open("GET", "Web Servisi/PokreniSesiju.php", true);
    xmlhttp.send();
}

function korisnickiRacunKlik()
{
    tekst = document.getElementById("akcijaPrijava").innerHTML;
    if (tekst == "(Prijavi se)")
        window.location.href = "Prijava.html";
    else
    {
        var xmlhttp;
        if (window.XMLHttpRequest)
            xmlhttp = new XMLHttpRequest();
        else
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                alert("Uspješno ste se odjavili sa sistema!");
                window.location.href = "Index.html";
            }
        };
        xmlhttp.open("GET", "Web Servisi/Odjava.php", true);
        xmlhttp.send();
    }
}

function prijava()
{
    var username = document.getElementById("Luser");
    var password = document.getElementById("Lpass");
    var xmlhttp;
    var params = "username="+username.value+"&psw="+password.value;
    if (window.XMLHttpRequest)
        xmlhttp = new XMLHttpRequest();
    else
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            if (xmlhttp.responseText == "FAILURE")
            {
                alert('Neispravni login podaci!');
                window.location.href = 'Prijava.html';
            }
            else
            {
                var podaci = JSON.parse(xmlhttp.responseText);
                alert("Uspješno ste prijavljeni na sistem!");
                if (podaci[2] == "administrator")
                    window.location.href = 'AdministratorPanel.html';
                else
                    window.location.href = 'Index.html';
            }
        }
    };
    xmlhttp.open("POST", "Web Servisi/ValidirajLoginPodatke.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(params);
}

function prikaziKomentatora()
{
    var xmlhttp;
    if (window.XMLHttpRequest)
        xmlhttp = new XMLHttpRequest();
    else
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            if (xmlhttp.responseText != "FAILURE")
            {
                var korisnik = JSON.parse(xmlhttp.responseText);
                var ime = document.getElementById("autorKomentara");
                ime.value = korisnik[1];
                ime.readOnly = true;
                var mail = document.getElementById("email");
                mail.value = korisnik[4];
                mail.readOnly = true;
                document.getElementById("anonimnost").style.display = "block";
                document.getElementById("anonimnostLabela").style.display = "block";
            }
        }
    };
    xmlhttp.open("GET", "Web Servisi/KorisnikUsername.php", true);
    xmlhttp.send();
}

function dodajStraniKljuc(korisnikUsername, komentar, novostID)
{
    var params = "username="+korisnikUsername+"&komentar="+komentar;
    var xmlhttp;
    if (window.XMLHttpRequest)
        xmlhttp = new XMLHttpRequest();
    else
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            if (xmlhttp.response == "SUCCESS")
            {
                alert("Uspješno ste dodali komentar!");
                window.location.href = "PrikazVijest.html?ID=" + novostID;
            }
            else
            {
                alert("Operacija dodavanja komentara nije bila uspješna!");
            }
        }
    };
    xmlhttp.open("PUT", "Web Servisi/KomentarServis.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(params);
}

function posaljiKomentar(novostID)
{
    var username = document.getElementById("autorKomentara").value;
    var mail = document.getElementById("email").value;
    var poruka = document.getElementById("komentarPoruka").value;
    var pokAnonimno = document.getElementById("anonimnost");
    var anonimno = "";
    if (pokAnonimno.style.display == "block")
    {
        if (pokAnonimno.checked == true)
            anonimno = "DA";
        else anonimno = "NE";
    }
    else anonimno = "OBICNI";
    var xmlhttp;
    var params = "username="+username+"&mail="+mail+"&poruka="+poruka+"&anonimno="+anonimno+"&novostID="+novostID;
    if (window.XMLHttpRequest)
        xmlhttp = new XMLHttpRequest();
    else
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            if (xmlhttp.responseText == "SUCCESS")
            {
                alert("Uspješno ste dodali komentar!");
                window.location.href = "PrikazVijest.html?ID="+novostID;
            }
            else if (xmlhttp.responseText == "FAILURE")
            {
                alert("Operacija dodavanja komentara nije bila uspješna!");
            }
            else
            {
                var komentarID = xmlhttp.responseText;
                dodajStraniKljuc(username, komentarID, novostID);
            }
        }
    };
    xmlhttp.open("POST", "Web Servisi/KomentarServis.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(params);
}