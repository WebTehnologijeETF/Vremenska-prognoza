/**
 * Created by Haris on 9.4.2015.
 */

$(document).ready(function(){
   $(":submit").click(function () {
       var ime = $("#imePrezime");
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
           submitHandler: function(form) {
               form.submit();
           }
       });
   });
});