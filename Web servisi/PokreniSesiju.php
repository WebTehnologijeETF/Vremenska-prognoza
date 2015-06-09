<?php
session_start();

if (isset($_SESSION["tip"]))
{
    $podaci = array($_SESSION["tip"], $_SESSION["username"], $_SESSION["password"]);
    print json_encode($podaci);
}
else
{
    session_unset();
    session_destroy();
    print "FAILURE";
}
?>