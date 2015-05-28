<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="Glavni.css">
    <link href='http://fonts.googleapis.com/css?family=Rokkitt:400,700' rel='stylesheet' type='text/css'>
    <script src="AjaxOtvori.js"></script>
    <title>Naslovna</title>
</head>
<body>

<?php
if (isset($_SESSION["login"]))
    header("Location: AdministratorPanel.html");
?>

<header>
    <img src="Images/HMZBIH.png" id="logo" alt="Images/HMZBIH.png"> <h1>Hidrometeorološki zavod BiH</h1>
</header>

<div id="navigateDiv">
    <br>
    <nav>
        <ul>
            <li><a onclick="AjaxOtvori('Index.php')">Naslovna</a></li>
            <li><a onclick="AjaxOtvori('Meteorologija.html')">Meteorologija</a></li>
            <li><a onclick="AjaxOtvori('Hidrologija.html')">Hidrologija</a></li>
            <li><a onclick="AjaxOtvori('Projekti.html')">Projekti</a></li>
            <li><a onclick="AjaxOtvori('Kontakt.php')">Kontakt</a></li>
            <li><a onclick="AjaxOtvori('Arhiva.html')">Arhiva</a> </li>
            <li><a onclick="AjaxOtvori('Administrator.php')">Administrator</a></li>
        </ul>
    </nav>
</div>

<div id="sredina">
    <form method="post" action="ValidirajAdmina.php">
        <fieldset class="loginAdmin">
            <p>Unesite vaše login podatke: </p><br>
            <label>Username: </label> <input type="text" name="username"> <br><br>
            <label>Password: </label> <input type="password" name="psw"> <br><br>
            <input type="submit" value="Login" class="submitButton5">
        </fieldset>
    </form>
    <form>
        <fieldset class="loginAdmin">
            <p>Ukoliko ste zaboravili lozinku, unesite Vašu mail adresu i bit će Vam poslana nova.</p><br>
            <label>Mail:</label> <input type="text"> <br><br>
            <input type="submit" value="Pošalji" class="submitButton5">
        </fieldset>
    </form>
</div>

</body>
</html>