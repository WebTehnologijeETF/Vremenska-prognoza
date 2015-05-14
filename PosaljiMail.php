<?php

require("sendgrid-php/sendgrid-php.php");
$eol = PHP_EOL;
$service_plan_id = "sendgrid_7a780";
$account_info = json_decode(getenv($service_plan_id), true);
$sendgrid = new SendGrid("hhcustovic1493", "dalrea0107");
$email    = new SendGrid\Email();
$message = "Ime i prezime: ".$_POST['imeVrijednost']."\r\n"."Email: ".$_POST['mailVrijednost']."\r\n"."Mjesto: ".$_POST['mjestoVrijednost']." ".$_POST['postanskiVrijednost']."\r\n"."\r\n"."\r\n".$_POST['komentarVrijednost'];
$from = $_POST['mailVrijednost'];
$subject = $_POST['subjektVrijednost'];
$send_to = "custovicharis@gmail.com";
$email->addTo($send_to)
    ->addCc("irfanpra@gmail.com")
    ->setFrom($from)
    ->setSubject($subject)
    ->setHtml($message);
try {
    $sendgrid->send($email);
    echo "<script>alert('Uspješno ste poslali mail!')</script>";
    echo file_get_contents("Index.php");
} catch(\SendGrid\Exception $e) {
    echo $e->getCode();
    foreach($e->getErrors() as $er) {
        echo $er;
    }
}
?>