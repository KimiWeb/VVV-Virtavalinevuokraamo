<?php
// Aloittaa session
session_start();
 
// Lopettaa kaikki session variablet
$_SESSION = array();
 
// Tuhoaa session
session_destroy();
 
// Uudelleen siirtää login sivulle
header("location: login.php");
exit;
?>