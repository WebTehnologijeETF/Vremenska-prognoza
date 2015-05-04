/**
 * Created by Haris on 3.5.2015.
 */


$(document).ready(function(){
    $("#rucnaGreska").hide();
    $("#greskaText").hide();
    $("#rucnaGreska2").hide();
    $("#greskaText2").hide();
    $("#rucnaGreska3").hide();
    $("#greskaText3").hide();
    ucitajProizvode();
});


function unesiProizvod() {
    $("#rucnaGreska").hide();
    $("#greskaText").hide();
    $("#rucnaGreska2").hide();
    $("#greskaText2").hide();
    $("#rucnaGreska3").hide();
    $("#greskaText3").hide();
    var url = "http://zamger.etf.unsa.ba/wt/proizvodi.php?brindexa=16358";
    var sveValidno = true;
    var naziv = document.getElementById("naziv").value;
    var opis = document.getElementById("opis").value;
    var cijena = document.getElementById("cijena").value;
    var slika = document.getElementById("slika").value;

    if (naziv.length < 3 || naziv.length > 25)
    {
        $("#rucnaGreska2").show();
        $("#greskaText2").show();
        document.getElementById("greskaText2").textContent = 'Morate unijeti pravilno ime';
        sveValidno = false;
    }
    else
    {
        $("#rucnaGreska2").hide();
        $("#greskaText2").hide();
    }
    if (validirajCIjenu(cijena) == false)
    {
        $("#rucnaGreska3").show();
        $("#greskaText3").show();
        document.getElementById("greskaText3").textContent = 'Morate unijeti ispravan broj';
        sveValidno = false;
    }
    else
    {
        $("#rucnaGreska3").hide();
        $("#greskaText3").hide();
    }
    if (sveValidno) {

        var proizvod = {
            naziv: naziv,
            opis: opis,
            cijena: cijena,
            slika: slika
        };
        var xmlhttp;

        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        }
        else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.status == 200 && xmlhttp.readyState == 4) {
                alert("Uspjesno ste unijeli artikal!");
            }
        };

        xmlhttp.open("POST", url, true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("akcija=dodavanje" + "&brindexa=16358&proizvod=" + JSON.stringify(proizvod));
    }
}

function obrisiProizvod() {
    $("#rucnaGreska").hide();
    $("#greskaText").hide();
    $("#rucnaGreska2").hide();
    $("#greskaText2").hide();
    $("#rucnaGreska3").hide();
    $("#greskaText3").hide();
    var ID_vrijednost = document.getElementById("ID").value;
    if (validirajID(ID_vrijednost) == false)
    {
        $("#rucnaGreska").show();
        $("#greskaText").show();
        document.getElementById("greskaText").textContent = 'Morate unijeti validan ID';
    }
    else
    {
        $("#rucnaGreska").hide();
        $("#greskaText").hide();
        var proizvod = {
            id: ID_vrijednost
        };

        var xmlhttp;

        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        }
        else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.status == 200 && xmlhttp.readyState == 4) {

                alert("Uspjesno obrisan proizvod!");
            }
            else
            {
                $("#rucnaGreska").show();
                $("#greskaText").show();
                document.getElementById("greskaText").textContent = 'ID ne postoji u bazi!';
            }

        };

        xmlhttp.open("POST", "http://zamger.etf.unsa.ba/wt/proizvodi.php?brindexa=16358", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("akcija=brisanje" + "&brindexa=16358&proizvod=" + JSON.stringify(proizvod));
    }
}

function validirajID(ID){
    var ispravanUnos = true;
    if (ID == null || ID == '')
        ispravanUnos = false;
    var re = new RegExp("^[0-9]*$");
    if (!re.test(ID) || ID < 0)
        ispravanUnos = false;
    return ispravanUnos;
}

function validirajCIjenu(cijena)
{
    var ispravno;
    var re = new RegExp("^[0-9]*$");
    if (re.test(cijena))
        ispravno = true;
    else ispravno = false;
    if (cijena < 0)
        ispravno = false;
    return ispravno;
}

function urediProizvod(){
    var ID_vrijednost = document.getElementById("ID").value;
    var naziv = document.getElementById("naziv").value;
    var opis = document.getElementById("opis").value;
    var cijena = document.getElementById("cijena").value;
    var slika = document.getElementById("slika").value;
    var sveValidno = true;
    if (validirajID(ID_vrijednost) == false) {
        $("#rucnaGreska").show();
        $("#greskaText").show();
        document.getElementById("greskaText").textContent = 'Morate unijeti validan ID';
        sveValidno = false;
    }
    else {
        $("#rucnaGreska").hide();
        $("#greskaText").hide();
    }
    if (naziv.length < 3 || naziv.length > 25)
    {
        $("#rucnaGreska2").show();
        $("#greskaText2").show();
        document.getElementById("greskaText2").textContent = 'Morate unijeti pravilno ime';
        sveValidno = false;
    }
    else
    {
        $("#rucnaGreska2").hide();
        $("#greskaText2").hide();
    }
    if (validirajCIjenu(cijena) == false)
    {
        $("#rucnaGreska3").show();
        $("#greskaText3").show();
        document.getElementById("greskaText3").textContent = 'Morate unijeti ispravan broj';
        sveValidno = false;
    }
    else
    {
        $("#rucnaGreska3").hide();
        $("#greskaText3").hide();
    }
    if (sveValidno == true) {
        var proizvod = {
            id: ID_vrijednost,
            naziv: naziv,
            opis: opis,
            slika: slika,
            cijena: cijena
        };

        var xmlhttp;

        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        }
        else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.status == 200 && xmlhttp.readyState == 4) {
                alert("Uspjesno ste promjenili proizvod!");
                ucitajProizvode();
            }
            else
            {
                $("#rucnaGreska").show();
                $("#greskaText").show();
                document.getElementById("greskaText").textContent = 'ID ne postoji u bazi!';
            }

            xmlhttp.open("POST", "http://zamger.etf.unsa.ba/wt/proizvodi.php?brindexa=16358", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("akcija=promjena" + "&brindexa=16358&proizvod=" + JSON.stringify(proizvod));
        }
    }

}

function ucitajProizvode() {

    var xmlhttp;

    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    }
    else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function(event){
        if(xmlhttp.status == 200 && xmlhttp.readyState == 4) {
            var listaProizvoda = JSON.parse(xmlhttp.responseText);
            popuniTabelu(listaProizvoda);
            event.preventDefault();
        }
    };

    xmlhttp.open("GET","http://zamger.etf.unsa.ba/wt/proizvodi.php?brindexa=16358", true);
    xmlhttp.send();
}

function popuniTabelu(lista){


}