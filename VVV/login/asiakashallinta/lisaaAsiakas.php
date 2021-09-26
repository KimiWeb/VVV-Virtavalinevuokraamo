<?php


// tutkitaan onko koodi-tieto oikein tullut ja putsataan se mahdollisista html-tageista
if (isset($_POST['Etunimi'])) {
  $Etunimi = $_POST['Etunimi'];
  $Etunimi = filter_var($Etunimi, FILTER_SANITIZE_STRING);
}
if (isset($_POST['Sukunimi'])) {
  $Sukunimi = $_POST['Sukunimi'];
  $Sukunimi= filter_var($Sukunimi, FILTER_SANITIZE_STRING);
}
if (isset($_POST['Puhnro'])) {
  $Puhnro = $_POST['Puhnro'];
  $Puhnro = filter_var($Puhnro, FILTER_SANITIZE_STRING);
}
if (isset($_POST['Lahiosoite'])) {
  $Lahiosoite = $_POST['Lahiosoite'];
  $Lahiosoite = filter_var($Lahiosoite, FILTER_SANITIZE_STRING);
}
if (isset($_POST['Postinro'])) {
  $Postinro = $_POST['Postinro'];
  $Postinro = filter_var($Postinro, FILTER_SANITIZE_STRING);
}
if (isset($_POST['Postitoimipaikka'])) {
  $Postitoimipaikka = $_POST['Postitoimipaikka'];
  $Postitoimipaikka = filter_var($Postitoimipaikka, FILTER_SANITIZE_STRING);
}
if (isset($_POST['Email'])) {
  $Email = $_POST['Email'];
  $Email = filter_var($Email, FILTER_SANITIZE_STRING);
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
      

      // hakuLauseessa on vaihtuvan tiedon kohdalla nimetty parametri :htun
      $insertLause = "INSERT INTO Asiakas (etunimi, sukunimi, puh_nro, lähiosoite, posti_nro, postitoimipaikka, email) VALUES (:Etunimi, :Sukunimi, :Puhnro, :Lahiosoite, :Postinro, :Postitoimipaikka, :Email)";
      /*nimetylle parametrille annetaan tässä arvo (arvo vaihtuu, käyttäjän antaman arvon mukaan)*/
      $tietoKantaKasittely = $yhteys->prepare($insertLause);
      $tietoKantaKasittely->bindValue(':Etunimi', $Etunimi);
      $tietoKantaKasittely->bindValue(':Sukunimi', $Sukunimi);
      $tietoKantaKasittely->bindValue(':Puhnro', $Puhnro);
      $tietoKantaKasittely->bindValue(':Lahiosoite', $Lahiosoite);
      $tietoKantaKasittely->bindValue(':Postinro', $Postinro);
      $tietoKantaKasittely->bindValue(':Postitoimipaikka', $Postitoimipaikka);
      $tietoKantaKasittely->bindValue(':Email', $Email);
     

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


