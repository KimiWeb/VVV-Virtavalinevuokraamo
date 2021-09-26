<?php
// tutkitaan onko Atun-tieto oikein tullut ja putsataan se mahdollisista html-tageista
if (isset($_POST['Atun'])) {
$Atun = $_POST['Atun'];
$Atun = filter_var($Atun, FILTER_SANITIZE_STRING);

// varmistetaan, että tiedot on annettu ja jos on, niin lähdetään hakemaan tietoa tietokannasta
  if (empty($Atun)){
    echo "Anna henkilötunnus";
  }
  else {
    $palvelin = "mysql.cc.puv.fi";
    $username = "e2000560";
    $password = "VyjhyWKzCSWj";
    $charset = 'utf8mb4';
    
    try {
      $errorInfo = "";
      //PDO
      $yhteys = new PDO("mysql:host=$palvelin;dbname=e2000560_VVV;charset=$charset", $username, $password); 
      $yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
      // poistoLauseessa on vaihtuvan tiedon kohdalla nimetty parametri :Atun
      $poistoLause = "DELETE FROM Asiakas WHERE AsiakasID=:Atun;";
      
      $tietoKantaKasittely = $yhteys->prepare($poistoLause);
      // nimetylle parametrille annetaan tässä arvo (arvo vaihtuu, käyttäjän antaman arvon mukaan)
      $tietoKantaKasittely->bindValue(':Atun', $Atun);
      $onnistuiko = $tietoKantaKasittely->execute();
      $poistettujenLkm = $tietoKantaKasittely->rowCount();
      
      $errorInfo = $tietoKantaKasittely->errorInfo();
     
      if ($poistettujenLkm > 0) {
         echo "Tietoja poistettu " . $poistettujenLkm . " kpl";
        } else {
          echo "Poistettavaa asiakasta ei löytynyt";
        }
    } 
    catch(PDOException $message) {
        $errorInfo = $message->getMessage();
        // lähetetään Ajax response: virheilmoitus
        // echo $errorInfo;
        echo "Asiakkaalla on projektitietoja, poisto ei onnistu";
    }
 }
}
else
{
    // lähetetään Ajax response: virheilmoitus
    echo "Ohjelman laiton käyttö";
}
?>
