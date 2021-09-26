<?php
// tutkitaan onko Atun-tieto oikein tullut ja putsataan se mahdollisista html-tageista
if (isset($_POST['Atun'])) {
$Atun = $_POST['Atun'];
$Atun = filter_var($Atun, FILTER_SANITIZE_STRING);

// varmistetaan, että Atun-tieto on annettu ja jos on, niin lähdetään hakemaan tietoa tietokannasta
  if (empty($Atun)){
       echo json_encode("");
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
      
     
      // hakuLauseessa on vaihtuvan tiedon kohdalla nimetty parametri :Atun
      $hakuLause = "SELECT asiakasID, etunimi, sukunimi, puh_nro, lähiosoite, posti_nro, postitoimipaikka, email FROM Asiakas WHERE asiakasID = :Atun";
      
      $tietoKantaKasittely = $yhteys->prepare($hakuLause);
      // nimetylle parametrille annetaan tässä arvo (arvo vaihtuu, käyttäjän antaman arvon mukaan)
      $tietoKantaKasittely->bindValue(':Atun', $Atun);
      $tietoKantaKasittely->execute();
    
      $errorInfo = $tietoKantaKasittely->errorInfo();
      // executen jälkeen haun tulokset siirretään fetchAll-komennolla muuttujaan $data
      $data = $tietoKantaKasittely->fetchAll(PDO::FETCH_ASSOC);
      
      // tässä tapauksessa löytyi yksi asiakas, koska haettiin perusavaimen mukaan
 
      echo json_encode($data);
      
    } 
    catch(PDOException $message) {
        // lähetetään tyhjä Json-tieto ja käsitellään virhe asiakaspuolella
        echo json_encode("");
    }
  }
}
else
{
    // tässä tapauksessa phpkoodiin tullaan väärää reittiä

    echo json_encode("");
}
?>
