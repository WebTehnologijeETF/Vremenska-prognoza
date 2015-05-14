<!DOCTYPE html>
<html>
<body>
<img src='Images/HMZBIH.png' id='logo' alt='Images/HMZBIH.png'> <h1>Hidrometeorološki zavod BiH</h1>

<h2 class="provjera">Provjerite da li ste ispravno popunili kontakt formu:</h2>
<form action="PosaljiMail.php" method="post">
    <div id="kontaktPrikaz">
        <fieldset>
            <br>
            <label class="lijeva">Ime i prezime:</label><input class="pregled" name="imeVrijednost" readonly value="<?php echo $ime ?>"><br>
            <label class="lijeva">Mail adresa:</label><input class="pregled" name="mailVrijednost" readonly value="<?php echo $mail ?>"><br>
            <label class="lijeva">Mjesto:</label><input class="pregled" name="mjestoVrijednost" readonly value="<?php echo $mjesto ?>"><br>
            <label class="lijeva">Postanski broj:</label><input class="pregled" name="postanskiVrijednost" readonly value="<?php echo $postanski ?>"><br>
            <label class="lijeva">Subjekt:</label><input class="pregled" name="subjektVrijednost" readonly value="<?php echo $subjekt ?>"><br>
            <label class="lijeva">Komentar:</label><input class="pregled" name="komentarVrijednost" readonly value="<?php echo $komentar ?>"><br>
        </fieldset>
        <h2 class="provjera">Da li ste sigurni da želite poslati ove podatke?</h2>
        <input type="submit" id="submitButton3" value="Siguran sam"><br><br>
    </div>
</form>
<h2 class="provjera">Ako ste pogrešno popunili formu, možete ispod prepraviti unesene podatke:</h2>
<br>
</body>
</html>