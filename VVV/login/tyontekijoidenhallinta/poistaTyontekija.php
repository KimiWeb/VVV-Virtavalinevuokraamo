<?php
// tutkitaan onko Ttun-tieto oikein tullut ja putsataan se mahdollisista html-tageista
if (isset($_POST['Ttun'])) {
$Ttun = $_POST['Ttun'];
$Ttun = filter_var($Ttun, FILTER_SANITIZE_STRING);

// varmistetaan, että tiedot on annettu ja jos on, niin lähdetään hakemaan tietoa tietokannasta
  if (empty($Ttun)){
    echo "Anna henkilötunnus";
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
      
      // poistoLauseessa on vaihtuvan tiedon kohdalla nimetty parametri :Ttun
      $poistoLause = "DELETE FROM Henkilökunta WHERE TyöntekijäID=:Ttun;";
      
      $tietoKantaKasittely = $yhteys->prepare($poistoLause);
      // nimetylle parametrille annetaan tässä arvo (arvo vaihtuu, käyttäjän antaman arvon mukaan)
      $tietoKantaKasittely->bindValue(':Ttun', $Ttun);
      $onnistuiko = $tietoKantaKasittely->execute();
      $poistettujenLkm = $tietoKantaKasittely->rowCount();
      
      $errorInfo = $tietoKantaKasittely->errorInfo();
     
      if ($poistettujenLkm > 0) {
         echo "Tietoja poistettu " . $poistettujenLkm . " kpl";
        } else {
          echo "Poistettavaa työntekijää ei löytynyt";
        }
    } 
    catch(PDOException $message) {
        $errorInfo = $message->getMessage();
        // lähetetään Ajax response: virheilmoitus
        // echo $errorInfo;
        echo "Työntekijällä on projektitietoja, poisto ei onnistu";
    }
 }
}
else
{
    // lähetetään Ajax response: virheilmoitus
    echo "Ohjelman laiton käyttö";
}
?>
