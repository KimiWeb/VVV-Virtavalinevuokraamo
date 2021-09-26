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
  <?php
        $conn = mysqli_connect("mysql.cc.puv.fi", "e2000560", "VyjhyWKzCSWj", "e2000560_VVV") or die("Connection Error: " . mysqli_error($conn));
        $conn -> set_charset("utf8");
        $result = mysqli_query($conn, "SELECT TyöntekijäID FROM Henkilökunta");
        $result1 = mysqli_query($conn, "SELECT LaiteID FROM Laite");
        $result2 = mysqli_query($conn, "SELECT Vikatyyppi FROM Vikatyyppi");
        
        ?>
  <title>Huollon lisäys</title>
<body>
<section id="home">
      <div class="container">
        <hr>
</hr>
<h2>Huollon lisäys </h2>
<hr>
</hr>
        Lisää työntekijä tunnus:
        <br>
        <select name="dynamic_data" id="txtTyontekijaid">
        <?php
        $i=0;
        while($row = mysqli_fetch_array($result)) {
        ?> 
        <option value="<?=$row["TyöntekijäID"];?>"><?=$row["TyöntekijäID"];?></option>
        <?php
        $i++;
        }
        ?>
        </select>
        <br>
        <br> 
        Lisää huolletun laitteen tunnus:
        <br>
        
        <select name="dynamic_data" id="txtLaiteid">
        <?php
        $i=0;
        while($row = mysqli_fetch_array($result1)) {
        ?> 
        <option value="<?=$row["LaiteID"];?>"><?=$row["LaiteID"];?></option>
        <?php
        $i++;
        }
        ?>
        </select>

        <br>
        Lisää huollon teema:
        <br>
        <select name="dynamic_data" id="txtVikatyyppi">
        <?php
        $i=0;
        while($row = mysqli_fetch_array($result2)) {
        ?> 
        <option value="<?=$row["Vikatyyppi"];?>"><?=$row["Vikatyyppi"];?></option>
        <?php
        $i++;
        }
        ?>
        </select>
        <br>    
        Huollon perusavain HuoltoID lisääntyy automaattisesti.
        <br>
        <input id="txtIlmoitus" type="text" value="" />
        <br>
        <br>
        <input type="submit" value="Lisää" id="btnLisaaHuolto" />
        <hr>
</hr>
<a href="../welcome.php" class="btn btn-warning">Takaisin valikkoon</a>
<a href="../huollot" class="btn btn-warning">Katso kaikki huollot</a>
        </div>
        <?php
        mysqli_close($conn);
        ?>
<script src="app.js"></script>
</body>
</html>
