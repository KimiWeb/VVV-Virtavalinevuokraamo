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
  <title>Työntekijöiden hallinta</title>
<body>
<section id="home">
    <div class="container">
      <div>
<h1>Työntekijöiden lisäys/tietojenhaku/muutos/poisto</h1>
<hr>
</hr>
<p>Lisää työntekijätunnukseen 3 kirjainta työntekijän nimesta esim. Matti Mahtava=mtm.</p>
        TyöntekijänID:
        
        <br>
          <?php
          //Etsitään php:n avulla tietokannassa olevas työntekijö tunnukset
          $mysqli = New MySQLi('mysql.cc.puv.fi', 'e2000560', 'VyjhyWKzCSWj', 'e2000560_VVV');
          $mysqli->set_charset('utf8mb4');
          $resultSet = $mysqli->query("SELECT TyöntekijäID FROM Henkilökunta");
          ?>
          <select id="txtTtun" name="Henkilökunta">
          <?php
          while($rows = $resultSet->fetch_assoc())
          {
              $TyöntekijäID= $rows['TyöntekijäID'];
              echo "<option value='$TyöntekijäID'>$TyöntekijäID</option>";
          }
          ?>
</select>
        <br>
        Etunimi:
        <br>
        <input id="txtEtunimi" type="text" value="" maxlength="49" size="49" />
        <br>
        Sukunimi:
        <br>
        <input id="txtSukunimi" type="text" value="" maxlength="49" size="49" />
        <br>
        Puhelin:
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
          Jos lisäät työntekijän kirjoita työntekijä tunnus tähän:   
        <br>
        <input id="txtLisaaT" type="text" value="" maxlength="49" size="49" />
        <br>
        <br>
        <input type="submit" value="Hae työntekijätunnuksen mukaan" id="btnHaeTyontekija" /> 
        <input type="submit" value="Muuta työntekijän sukunimi" id="btnMuutaTyontekija" />
        <input type="submit" value="Poista työntekijä" id="btnPoistaTyontekija" />
        <input type="submit" value="Lisää työntekijä" id="btnLisaaTyontekija" />
        <br>
        <br>
        <hr>
        </hr>
        <a href="../welcome.php" class="button">Takaisin valikkoon</a>
        <br>
        <br>
</div>
</div>
<script src="app.js"></script>
</body>
</html>
