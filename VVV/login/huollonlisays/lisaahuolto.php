<?php


// tutkitaan onko koodi-tieto oikein tullut ja putsataan se mahdollisista html-tageista
if (isset($_POST['tyontekijaid'])) {
  $tyontekijaid = $_POST['tyontekijaid'];
  $tyontekijaid = filter_var($tyontekijaid, FILTER_SANITIZE_STRING);
}
if (isset($_POST['laiteid'])) {
  $laiteid = $_POST['laiteid'];
  $laiteid = filter_var($laiteid, FILTER_SANITIZE_STRING);
}
if (isset($_POST['vikatyyppi'])) {
  $vikatyyppi = $_POST['vikatyyppi'];
  $vikatyyppi = filter_var($vikatyyppi, FILTER_SANITIZE_STRING);
}
// tietokantakäsittely
    $palvelin = "mysql.cc.puv.fi";
    $username = "e2000560";
    $password = "VyjhyWKzCSWj";
    try {
      $errorInfo = "";
      $yhteys = new PDO("mysql:host=$palvelin;dbname=e2000560_VVV", $username, $password); 
      
      $yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $yhteys->exec('SET NAMES "utf8"');
      

      // hakuLauseessa on vaihtuvan tiedon kohdalla nimetty parametri :tyontekijaid
      $insertLause = "INSERT INTO Huolto (TyöntekijäID, LaiteID, Vikatyyppi, HuoltoPVM) VALUES (:tyontekijaid, :laiteid, :vikatyyppi, NOW()) ";
      /*nimetylle parametrille annetaan tässä arvo (arvo vaihtuu, käyttäjän antaman arvon mukaan)*/
      $tietoKantaKasittely = $yhteys->prepare($insertLause);
      $tietoKantaKasittely->bindValue(':tyontekijaid', $tyontekijaid);
      $tietoKantaKasittely->bindValue(':laiteid', $laiteid);
      $tietoKantaKasittely->bindValue(':vikatyyppi', $vikatyyppi);
     

      $onnistuikoLisays = $tietoKantaKasittely->execute();
      $errorInfo = $tietoKantaKasittely->errorInfo();
      if ($onnistuikoLisays){
        echo "OK";
      } else
      {
        echo "Tietokantatoiminto ei onnistunut";
      }
     
    }
    catch(PDOException $message) {
        $errorInfo = $message->getMessage();       
        echo "Poikkeusilmoitus" .  $errorInfo;
    } 

?>


