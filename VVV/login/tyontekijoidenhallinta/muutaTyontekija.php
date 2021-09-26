<?php
// tutkitaan onko Ttun-tieto ja sukunimi tieto oikein tullut ja putsataan se mahdollisista html-tageista
if (isset($_POST['Ttun'])) {
$Ttun = $_POST['Ttun'];
$Ttun = filter_var($Ttun, FILTER_SANITIZE_STRING);

if (isset($_POST['sukunimi'])) {
  $snimi = $_POST['sukunimi'];
  $snimi = filter_var($snimi, FILTER_SANITIZE_STRING);
// varmistetaan, että tiedot on annettu ja jos on, niin lähdetään hakemaan tietoa tietokannasta
  if (empty($Ttun) || empty($snimi)){
    echo "Anna tarvittavat tiedot";
  }
  else {
    $palvelin = "mysql.cc.puv.fi";
    $username = "e2000560";
    $password = "VyjhyWKzCSWj";
    $charset = 'utf8mb4';
    
    try {
      $errorInfo = "";

      $yhteys = new PDO("mysql:host=$palvelin;dbname=e2000560_VVV;charset=$charset", $username, $password); 
      $yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
      // muutosLauseessa on vaihtuvan tiedon kohdalla nimetty parametri :Ttun
      $muutosLause = "UPDATE Henkilökunta SET Sukunimi=:snimi WHERE TyöntekijäID=:Ttun;";
      
      $tietoKantaKasittely = $yhteys->prepare($muutosLause);
      // nimetylle parametrille annetaan tässä arvo (arvo vaihtuu, käyttäjän antaman arvon mukaan)
      $tietoKantaKasittely->bindValue(':Ttun', $Ttun);
      $tietoKantaKasittely->bindValue(':snimi', $snimi);
      $onnistuiko = $tietoKantaKasittely->execute();
    
      $errorInfo = $tietoKantaKasittely->errorInfo();
      $muutettujenLkm = $tietoKantaKasittely->rowCount();
      if ($muutettujenLkm > 0) {
         echo "Tieto muutettu";
        } else {
          echo "Muutettavaa asiakasta ei löytynyt";
        }
    } 
    catch(PDOException $message) {
        $errorInfo = $message->getMessage();
        // lähetetään Ajax response: virheilmoitus
        echo $errorInfo;
    }
  }
 }
}
else
{
    // lähetetään Ajax response: virheilmoitus
    echo "Ohjelman laiton käyttö";
}
?>
