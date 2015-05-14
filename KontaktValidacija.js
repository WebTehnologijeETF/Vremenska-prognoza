/**
 * Created by Haris on 9.4.2015.
 */

function ucitajKontakt(){
    document.getElementById("greskaText").textContent = "";
    document.getElementById("greskaText2").textContent = "";
    document.getElementById("greskaText3").textContent = "";
    document.getElementById("greskaText4").textContent = "";
    document.getElementById("greskaText5").textContent = "";
    var submitDugme = document.getElementById("submitButton");
    submitDugme.onclick = function () {
        var ime = document.getElementById("imePrezime").value;
        var mail = document.getElementById("mailAdresa").value;
        validirajMjesto();
        var subbool = validirajSubjektKomentar();
        var sveProlazi = true;
        if (document.getElementById("rucnaGreska3").style.display == "block")
            sveProlazi = false;
        if (validirajIme(ime) == false)
        {
            sveProlazi = false;
            document.getElementById("rucnaGreska").style.display = "block";
            document.getElementById("greskaText").textContent = "Neispravno ime i prezime";
        }
        else
        {
            document.getElementById("rucnaGreska").style.display = "none";
            document.getElementById("greskaText").textContent = "";
        }
        if (validirajMail(mail) == false)
        {
            sveProlazi = false;
            document.getElementById("rucnaGreska2").style.display = "block";
            document.getElementById("greskaText2").textContent = "Neispravna e-mail adresa";
        }
        else
        {
            document.getElementById("rucnaGreska2").style.display = "none";
            document.getElementById("greskaText2").textContent = "";
        }
        if (subbool == false)
            sveProlazi = false;
        if (sveProlazi == false)
            event.preventDefault();
   }
}

function validirajMjesto() {
    var mjesto = document.getElementById("mjesto");
    var postanski = document.getElementById("postanski");
    var xmlhttp;

    if (window.XMLHttpRequest)
    {
        xmlhttp = new XMLHttpRequest();
    }
    else
    {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function() {
        if(xmlhttp.status == 200 && xmlhttp.readyState == 4) {
            var odgovor = JSON.parse(xmlhttp.responseText);
            var tacnaPosta = false;
            if (Object.keys(odgovor)[0] == "ok")
                tacnaPosta = true;
            if (tacnaPosta == false)
            {
                document.getElementById("rucnaGreska3").style.display = "block";
                document.getElementById("greskaText3").textContent = "Neispravan poštanski broj";
            }
            else
            {
                document.getElementById("rucnaGreska3").style.display = "none";
                document.getElementById("greskaText3").textContent = "";
            }
        }
    };

    xmlhttp.open("GET", "http://zamger.etf.unsa.ba/wt/postanskiBroj.php?mjesto=" + mjesto.value + "&postanskiBroj=" + postanski.value, true);
    xmlhttp.send();
}

function validirajMail(email)
{
    var ispravno = true;
    var mailTest = new RegExp("^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\\.[a-zA-Z0-9-.]+$");
    if (!mailTest.test(email))
    ispravno = false;
    return ispravno;
}

function validirajIme(imePrezime)
{
    var ispravno = true;
    if (imePrezime.length < 3 || imePrezime > 30)
        ispravno = false;
    var imeTest = new RegExp("^[a-zA-Z\\s]*$");
    if (!imeTest.test(imePrezime))
        ispravno = false;
    return ispravno;
}

function validirajSubjektKomentar()
{
    var subjekt = document.getElementById("subjekt").value;
    var komentar = document.getElementById("komentar").value;
    var tacno = true;
    if ((subjekt == null || subjekt == "") && (komentar != null && komentar != ""))
    {
        tacno = false;
        document.getElementById("rucnaGreska4").style.display = "block";
        document.getElementById("greskaText4").textContent = "Morate izrabrati subjekt";
    }
    else
    {
        document.getElementById("rucnaGreska4").style.display = "none";
        document.getElementById("greskaText4").textContent = "";
    }
    if ((subjekt != null && subjekt != "") && (komentar == null || komentar == ""))
    {
        tacno = false;
        document.getElementById("rucnaGreska5").style.display = "block";
        document.getElementById("greskaText5").textContent = "Morate unijeti komentar";
    }
    else
    {
        document.getElementById("rucnaGreska5").style.display = "none";
        document.getElementById("greskaText5").textContent = "";
    }
    return tacno;
}

function resetForm()
{
    document.getElementById("imePrezime").value = "";
    document.getElementById("mailAdresa").value = "";
    document.getElementById("mjesto").value = "";
    document.getElementById("postanski").value = "";
    document.getElementById("subjekt").value = "";
    document.getElementById("komentar").value = "";
}