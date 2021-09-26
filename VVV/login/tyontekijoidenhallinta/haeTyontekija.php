<?php
// tutkitaan onko Ttun-tieto oikein tullut ja putsataan se mahdollisista html-tageista
if (isset($_POST['Ttun'])) {
$Ttun = $_POST['Ttun'];
$Ttun = filter_var($Ttun, FILTER_SANITIZE_STRING);

// varmistetaan, että Ttun-tieto on annettu ja jos on, niin lähdetään hakemaan tietoa tietokannasta
  if (empty($Ttun)){
       echo json_encode("");
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
      
     
      // hakuLauseessa on vaihtuvan tiedon kohdalla nimetty parametri :Ttun
      $hakuLause = "SELECT TyöntekijäID, Etunimi, Sukunimi, Puhelin, Lähiosoite, Posti_nro, Postitoimipaikka, Sähköposti FROM Henkilökunta WHERE TyöntekijäID = :Ttun";
      
      $tietoKantaKasittely = $yhteys->prepare($hakuLause);
      // nimetylle parametrille annetaan tässä arvo (arvo vaihtuu, käyttäjän antaman arvon mukaan)
      $tietoKantaKasittely->bindValue(':Ttun', $Ttun);
      $tietoKantaKasittely->execute();
    
      $errorInfo = $tietoKantaKasittely->errorInfo();
      // executen jälkeen haun tulokset siirretään fetchAll-komennolla muuttujaan $data
      $data = $tietoKantaKasittely->fetchAll(PDO::FETCH_ASSOC);
      
      // tässä tapauksessa löytyi yksi työntekijä, koska haettiin perusavaimen mukaan
 
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
