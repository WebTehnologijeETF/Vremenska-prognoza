/**
 * Created by Haris on 11.4.2015.
 */

function ucitajDokument() {

    var treci = document.getElementsByClassName("treciNivo");
    var cetvrti = document.getElementsByClassName("cetvrtiNivo");
    for (i = 0; i < treci.length; i++) {
        treci[i].style.display = "none";
    }
    for (i = 0; i < cetvrti.length; i++) {
        cetvrti[i].style.display = "none";
    }
    var drugiTekst = document.getElementsByClassName("drugiTekst");
    for (i = 0; i < drugiTekst.length; i++) {
        drugiTekst[i].onclick = function () {
            var primjer;
            var broj;
            if (this.style.color == "white") {
                this.style.color = "yellow";
                this.innerHTML = this.innerHTML.replace("+", "-");
                primjer = this.closest(".drugiNivo");
                broj = primjer.getElementsByClassName("treciNivo");
                for (j = 0; j < broj.length; j++) {
                    broj[j].style.display = "block";
                }
            }
            else {
                this.style.color = "white";
                this.innerHTML = this.innerHTML.replace("-", "+");
                primjer = this.closest(".drugiNivo");
                broj = primjer.getElementsByClassName("treciNivo");
                for (j = 0; j < broj.length; j++) {
                    broj[j].style.display = "none";
                }
            }
        }
    }

    var treciTekst = document.getElementsByClassName("treciTekst");
    for (i = 0; i < treciTekst.length; i++) {
        treciTekst[i].onclick = function () {
            var primjer;
            var broj;
            if (this.style.color == "white")
            {
                this.style.color = "yellow";
                this.innerHTML = this.innerHTML.replace("+", "-");
                primjer = this.closest(".treciNivo");
                broj = primjer.getElementsByClassName("cetvrtiNivo");
                for (j = 0; j < broj.length; j++) {
                    broj[j].style.display = "block";
                    var listaItemi = broj[j].getElementsByTagName("li");
                    for (z = 0; z < listaItemi.length; z++)
                    {
                        listaItemi[z].style.display = "none";
                    }
                }
            }
            else
            {
                this.style.color = "white";
                this.innerHTML = this.innerHTML.replace("-", "+");
                primjer = this.closest(".treciNivo");
                broj = primjer.getElementsByClassName("cetvrtiNivo");
                for (j = 0; j < broj.length; j++) {
                    broj[j].style.display = "none";
                }
            }
        }
    }

    var cetvrtiTekst = document.getElementsByClassName("cetvrtiTekst");
    var djeca;
    for (i = 0; i < cetvrtiTekst.length; i++) 
    {
        cetvrtiTekst[i].onclick = function ()
        {
            var primjer;
            if (this.style.color == "white")
            {
                this.style.color = "yellow";
                this.innerHTML = this.innerHTML.replace("+", "-");
                primjer = this.closest(".cetvrtiNivo");
                djeca = primjer.getElementsByTagName("li");
                for (j = 0; j < djeca.length; j++)
                {
                    djeca[j].style.display = "block";
                }
            }
            else
            {
                this.style.color = "white";
                this.innerHTML = this.innerHTML.replace("-", "+");
                primjer = this.closest(".cetvrtiNivo");
                djeca = primjer.getElementsByTagName("li");
                for (j = 0; j < djeca.length; j++)
                {
                    djeca[j].style.display = "none";
                }
            }
        }
    }
};