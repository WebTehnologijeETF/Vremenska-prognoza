/**
 * Created by Haris on 3.5.2015.
 */

function sakrij()
{
    document.getElementById("rucnaGreska").style.display = "none";
    document.getElementById("greskaText").style.display = "none";
    document.getElementById("rucnaGreska2").style.display = "none";
    document.getElementById("greskaText2").style.display = "none";
    document.getElementById("rucnaGreska3").style.display = "none";
    document.getElementById("greskaText3").style.display = "none";
    ucitajProizvode();
}

function unesiProizvod() {
    document.getElementById("rucnaGreska").style.display = "none";
    document.getElementById("greskaText").style.display = "none";
    document.getElementById("rucnaGreska2").style.display = "none";
    document.getElementById("greskaText2").style.display = "none";
    document.getElementById("rucnaGreska3").style.display = "none";
    document.getElementById("greskaText3").style.display = "none";
    var url = "http://zamger.etf.unsa.ba/wt/proizvodi.php?brindexa=16358";
    var sveValidno = true;
    var naziv = document.getElementById("naziv").value;
    var opis = document.getElementById("opis").value;
    var cijena = document.getElementById("cijena").value;
    var slika = document.getElementById("slika").value;

    if (naziv.length < 3 || naziv.length > 25)
    {
        document.getElementById("rucnaGreska2").style.display = "block";
        document.getElementById("greskaText2").style.display = "block";
        document.getElementById("greskaText2").textContent = 'Morate unijeti pravilno ime';
        sveValidno = false;
    }
    else
    {
        document.getElementById("rucnaGreska2").style.display = "none";
        document.getElementById("greskaText2").style.display = "none";
    }
    if (validirajCIjenu(cijena) == false)
    {
        document.getElementById("rucnaGreska3").style.display = "block";
        document.getElementById("greskaText3").style.display = "block";
        document.getElementById("greskaText3").textContent = 'Morate unijeti ispravan broj';
        sveValidno = false;
    }
    else
    {
        document.getElementById("rucnaGreska3").style.display = "none";
        document.getElementById("greskaText3").style.display = "none";
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
                ucitajProizvode();
            }
        };

        xmlhttp.open("POST", url, true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("akcija=dodavanje" + "&brindexa=16358&proizvod=" + JSON.stringify(proizvod));
    }
}

function obrisiProizvod() {
    document.getElementById("rucnaGreska").style.display = "none";
    document.getElementById("greskaText").style.display = "none";
    document.getElementById("rucnaGreska2").style.display = "none";
    document.getElementById("greskaText2").style.display = "none";
    document.getElementById("rucnaGreska3").style.display = "none";
    document.getElementById("greskaText3").style.display = "none";
    var ID_vrijednost = document.getElementById("ID").value;
    if (validirajID(ID_vrijednost) == false)
    {
        document.getElementById("rucnaGreska").style.display = "block";
        document.getElementById("greskaText").style.display = "block";
        document.getElementById("greskaText").textContent = 'Morate unijeti validan ID';
    }
    else
    {
        document.getElementById("rucnaGreska").style.display = "none";
        document.getElementById("greskaText").style.display = "none";
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
                ucitajProizvode();
            }
            else
            {
                document.getElementById("rucnaGreska").style.display = "block";
                document.getElementById("greskaText").style.display = "block";
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
        document.getElementById("rucnaGreska").style.display = "block";
        document.getElementById("greskaText").style.display = "block";
        document.getElementById("greskaText").textContent = 'Morate unijeti validan ID';
        sveValidno = false;
    }
    else {
        document.getElementById("rucnaGreska").style.display = "none";
        document.getElementById("greskaText").style.display = "none";
    }
    if (naziv.length < 3 || naziv.length > 25)
    {
        document.getElementById("rucnaGreska2").style.display = "block";
        document.getElementById("greskaText2").style.display = "block";
        document.getElementById("greskaText2").textContent = 'Morate unijeti pravilno ime';
        sveValidno = false;
    }
    else
    {
        document.getElementById("rucnaGreska2").style.display = "none";
        document.getElementById("greskaText2").style.display = "none";
    }
    if (validirajCIjenu(cijena) == false)
    {
        document.getElementById("rucnaGreska3").style.display = "block";
        document.getElementById("greskaText3").style.display = "block";
        document.getElementById("greskaText3").textContent = 'Morate unijeti ispravan broj';
        sveValidno = false;
    }
    else
    {
        document.getElementById("rucnaGreska3").style.display = "none";
        document.getElementById("greskaText3").style.display = "none";
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
                document.getElementById("rucnaGreska").style.display = "block";
                document.getElementById("greskaText").style.display = "block";
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

    var tabela = document.getElementById("tabelaProizvoda");
    var noviRed = tabela.insertRow(1);
    var idCell = noviRed.insertCell(0);
    var nazivCell = noviRed.insertCell(1);
    var slikaCell = noviRed.insertCell(2);
    var opisCell = noviRed.insertCell(3);
    var cijenaCell = noviRed.insertCell(4);
    for (i = 0; i < lista.length; i++)
    {
        idCell.innerHTML = lista[i].id;
        nazivCell.innerHTML = lista[i].naziv;
        slikaCell.innerHTML = "<img src="+ lista[i].slika + " />";
        opisCell.innerHTML = lista[i].opis;
        cijenaCell.innerHTML = lista[i].cijena;
    }
}

