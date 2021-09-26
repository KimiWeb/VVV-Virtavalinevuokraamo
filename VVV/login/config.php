<?php
// Tietokanta tunnukset
define('DB_SERVER', 'mysql.cc.puv.fi');
define('DB_USERNAME', 'e2000560');
define('DB_PASSWORD', 'VyjhyWKzCSWj');
define('DB_NAME', 'e2000560_VVV');
 
/* Yrittää yhdistää MySQL tietokantaan*/
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Katsoo yhteyden
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>