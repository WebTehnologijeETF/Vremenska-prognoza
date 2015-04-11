/**
 * Created by Haris on 11.4.2015.
 */

$(document).ready(function () {

    var treci = $(".treciNivo");
    treci.hide();
    treci.find("li").hide();

    $(".drugiTekst").click(function () {
        var boja = $(this).css("color");
        if (boja == "rgb(255, 255, 255)")
            $(this).css("color","yellow");
        else
            $(this).css("color","white");
        var tekst = $(this).text();
        var novi = tekst.replace("+","-");
        if (novi === tekst)
            var novi = tekst.replace("-","+");
        $(this).text(novi);
        var roditeljTeksta = $(this).closest(".drugiNivo");
        roditeljTeksta.find("ul").toggle();
    });

    $(".treciTekst").click(function () {
        var boja = $(this).css("color");
        if (boja == "rgb(255, 255, 255)")
            $(this).css("color","yellow");
        else
            $(this).css("color","white");
        var tekst = $(this).text();
        var novi = tekst.replace("+","-");
        if (novi === tekst)
            var novi = tekst.replace("-","+");
        $(this).text(novi);
        var roditeljTeksta = $(this).closest(".treciNivo");
        roditeljTeksta.find("ul").toggle();
    });

    $(".cetvrtiTekst").click(function () {
        var boja = $(this).css("color");
        if (boja == "rgb(255, 255, 255)")
            $(this).css("color","yellow");
        else
            $(this).css("color","white");
        var tekst = $(this).text();
        var novi = tekst.replace("+","-");
        if (novi === tekst)
            var novi = tekst.replace("-","+");
        $(this).text(novi);
        var roditeljTeksta = $(this).closest(".cetvrtiNivo");
        roditeljTeksta.find("li").toggle();
    });

});