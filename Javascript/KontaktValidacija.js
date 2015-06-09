
function kontaktValidacija()
{
    validirajMjesto();
    var xmlhttp;
    if (window.XMLHttpRequest)
        xmlhttp = new XMLHttpRequest();
    else
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            var kontaktPodaci = JSON.parse(xmlhttp.responseText);
            var imePoruka = document.getElementById("greskaText");
            var imeSlika = document.getElementById("rucnaGreska");
            if (kontaktPodaci[0] != "")
            {
                imePoruka.innerHTML = kontaktPodaci[0];
                imeSlika.style.display = "block";
            }
            else
            {
                imePoruka.innerHTML = "";
                imeSlika.style.display = "none";
            }
            var mailPoruka = document.getElementById("greskaText2");
            var mailSlika = document.getElementById("rucnaGreska2");
            if (kontaktPodaci[1] != "")
            {
                mailPoruka.innerHTML = kontaktPodaci[1];
                mailSlika.style.display = "block";
            }
            else
            {
                mailPoruka.innerHTML = "";
                mailSlika.style.display = "none";
            }
            var mjestoPoruka = document.getElementById("greskaText3");
            var mjestoSlika = document.getElementById("rucnaGreska3");
            if (kontaktPodaci[4] != "")
            {
                mjestoPoruka.innerHTML = kontaktPodaci[4];
                mjestoSlika.style.display = "block";
            }
            else
            {
                mjestoPoruka.innerHTML = "";
                mjestoSlika.style.display = "none";
            }
            var subjektPoruka = document.getElementById("greskaText4");
            var subjektSlika = document.getElementById("rucnaGreska4");
            if (kontaktPodaci[2] != "")
            {
                subjektPoruka.innerHTML = kontaktPodaci[2];
                subjektSlika.style.display = "block";
            }
            else
            {
                subjektPoruka.innerHTML = "";
                subjektSlika.style.display = "none";
            }
            var komentarPoruka = document.getElementById("greskaText5");
            var komentarSlika = document.getElementById("rucnaGreska5");
            if (kontaktPodaci[3] != "")
            {
                komentarPoruka.innerHTML = kontaktPodaci[3];
                komentarSlika.style.display = "block";
            }
            else
            {
                komentarPoruka.innerHTML = "";
                komentarSlika.style.display = "none";
            }
            if (imeSlika.style.display == "none" && mailSlika.style.display == "none" && mjestoSlika.style.display == "none" && subjektSlika.style.display == "none" && komentarSlika.style.display == "none")
                prikaziDodatno();
        }
    };
    var ime = document.getElementById("imePrezime");
    var mail = document.getElementById("mailAdresa");
    var grad = document.getElementById("mjesto");
    var posta = document.getElementById("postanski");
    var subjekt = document.getElementById("subjekt");
    var komentar = document.getElementById("komentar");
    xmlhttp.open("GET", "Web Servisi/KontaktValidacija.php?ime=" + ime.value + "&mail=" + mail.value + "&grad=" + grad.value + "&posta=" + posta.value + "&subjekt=" + subjekt.value + "&komentar=" + komentar.value, true);
    xmlhttp.send();
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

function resetForm()
{
    document.getElementById("imePrezime").value = "";
    document.getElementById("mailAdresa").value = "";
    document.getElementById("mjesto").value = "";
    document.getElementById("postanski").value = "";
    document.getElementById("subjekt").value = "";
    document.getElementById("komentar").value = "";
}

function prikaziDodatno()
{
    var prikaz = document.getElementById("kontaktProvjera");
    prikaz.style.display = "block";
    var ime = document.getElementById("imePrezime");
    var mail = document.getElementById("mailAdresa");
    var grad = document.getElementById("mjesto");
    var posta = document.getElementById("postanski");
    var subjekt = document.getElementById("subjekt");
    var komentar = document.getElementById("komentar");
    document.getElementById("imeVrijednost").value = ime.value;
    document.getElementById("mailVrijednost").value = mail.value;
    document.getElementById("mjestoVrijednost").value = grad.value;
    document.getElementById("postanskiVrijednost").value = posta.value;
    document.getElementById("subjektVrijednost").value = subjekt.value;
    document.getElementById("komentarVrijednost").value = komentar.value;
}