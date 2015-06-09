/**
 * Created by Haris on 3.5.2015.
 */

function AjaxOtvori(url) {
    var xmlhttp = new XMLHttpRequest;

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
            document.open();
            document.write(xmlhttp.responseText);
            document.close();
        }
    };

    xmlhttp.open("GET", url, true);
    xmlhttp.send();
}