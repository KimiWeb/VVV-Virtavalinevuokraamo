<?php
session_start();
// Katsoo onko käyttäjä kirjautunut sisään, jos ei siirtä käyttäjän login sivulle.
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.0.13/css/all.css"
      integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"
      integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB"
      crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css" />
  </head>
  <title>Huollon lisäys</title>
<body>
<section id="home">
    <div class="container">
      <div>
<h1>Asiakastiedon muuttaminen</h1>
<hr>
</hr>
<p>Jos lisäät asiakkaan jätä AsiakasID kohta tyhjäksi se lisätään automaattisesti.</p>
        AsiakasID:
        <br>
        <input id="txtAtun" type="text" value="1" maxlength="49" size="49"/>
        <br>
        Etunimi:
        <br>
        <input id="txtEtunimi" type="text" value="" maxlength="49" size="49" />
        <br>
        Sukunimi:
        <br>
        <input id="txtSukunimi" type="text" value="" maxlength="49" size="49" />
        <br>
        Puhelinnumero:
        <br>
        <input id="txtPuhnro" type="text" value="" maxlength="49" size="49" />
        <br>
        Lähiosoite:
        <br>
        <input id="txtLahi" type="text" value="" maxlength="49" size="49" />
        <br>
        Postinumero:
        <br>
        <input id="txtPnro" type="text" value="" maxlength="49" size="49" />
        <br>
        Postitoimipaikka:
        <br>
        <input id="txtPtoim" type="text" value="" maxlength="49" size="49" />
        <br>
        Sähköposti:
        <br>
        <input id="txtSpost" type="text" value="" maxlength="49" size="49" />
        <br>
        Ilmoitus:
        <br>
        <input id="txtIlmo" type="text" value="" maxlength="49" size="49"> 
        <br>
        <br>
        <input type="submit" value="Hae yksi" id="btnHaeAsiakas" /> 
        <input type="submit" value="Muuta sukunimi" id="btnMuutaAsiakas" />
        <input type="submit" value="Poista asiakas" id="btnPoistaAsiakas" />
        <input type="submit" value="Lisää asiakas" id="btnLisaaAsiakas" />
        <br>
        <hr>
</hr>
        <br>
        <a href="../welcome.php" class="button">Takaisin valikkoon</a>
        <br>
        <br>
</div>
</div>
<script src="app.js"></script>
</body>
</html>
