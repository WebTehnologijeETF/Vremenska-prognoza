/**
 * Created by Haris on 9.4.2015.
 */

$(document).ready(function(){
    $("#rucnaGreska").hide();
    $(".errorTekst4").hide();
   $(":submit").click(function () {
       var ime = $("#imePrezime");
       validirajMjesto();
       var prolazi = false;
       $.validator.addMethod('onlyLetters', function (value, element, param) {
           var re = new RegExp("^[a-zA-Z]+$");
           if (re.test(value))
               prolazi = true;
           else prolazi = false;
           return prolazi;
       }, 'Smijete koristii samo slova');

       $.validator.addMethod('filledSubject', function (value, element, param) {
           var x = $("#subjekt").val();
           var y = $("#komentar").val();
           if ((x == "" || x == null) && (y != "" && y!= null))
               prolazi = false;
           else prolazi = true;
           return prolazi;
       }, 'Subjekt ne smije biti prazan, ako postoji komentar');

       $("form").validate({
           rules: {
               imePrezime: {
                   required: true,
                   minlength: 3,
                   maxlength: 25,
                   onlyLetters: true
               },
               mailAdresa:{
                   required: true,
                   email: true
               },
               subjekt:{
                    filledSubject:true
               }
           },
           errorElement: "img",
           errorPlacement: function(error, element) {
                   error.insertAfter(element);
               if (element.attr("id") == "imePrezime")
                   $("<em class='errorTekst1'>Unesite pravilno ime!</em>").insertAfter(error);
               else if (element.attr("id") == "mailAdresa")
                   $("<em class='errorTekst2'>Unesite validnu mail adresu!</em>").insertAfter(error);
               else if (element.attr("id") == "subjekt")
                   $("<em class='errorTekst3'>Izaberite subjekt komentara!</em>").insertAfter(error);
           },
           messages: {
               imePrezime: "Molimo unesite pravilno Vaše ime",
               mailAdresa: "Molimo unesite ispravnu mail adresu"
           },
           unhighlight: function (element) {
               $(element)
                   .closest('.form-group').removeClass('has-error');
           },
           submitHandler: function(form) {
               var doku = $("#rucnaGreska").is(":visible");
               if (doku == false)
                form.submit();
           }
       }
       );
   });
});

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
                $("#rucnaGreska").show();
                $(".errorTekst4").show();
            }
            else
            {
                $("#rucnaGreska").hide();
                $(".errorTekst4").hide();
            }
        }
    };

    xmlhttp.open("GET", "http://zamger.etf.unsa.ba/wt/postanskiBroj.php?mjesto=" + mjesto.value + "&postanskiBroj=" + postanski.value, true);
    xmlhttp.send();
}
