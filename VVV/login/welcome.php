<?php
// Aloittaa session
session_start();
 
// Katsoo onko käyttäjä kirjautunut sisään, jos ei siirtä käyttäjän login sivulle.
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tervetuloa</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
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
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <div class="page-header">
        <h1>Tervetuloa, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Mitä haluat tehä?</h1>
    </div>
        
        
      <br>
      <br>
      <br>
        <a href="asiakashallinta" class="button">Asiakkaiden tietojenmuutto</a>
      <br>
      <br>
      <br>
        <a href="tyontekijoidenhallinta" class="button">Henkilökunnan tiedon hallinta</a>
      <br>
      <br>
      <br>
      <a href="huollot" class="button">Katso kaikki huollot</a>
      <br>
      <br>
      <br>
      <a href="huollonlisays" class="button">Lisää huolto</a>
      <br>
      <br>
    <hr>
    </hr>
        <a href="reset-password.php" class="btn btn-warning">Resetoi salasana</a>
        <a href="logout.php" class="btn btn-warning">Kirjaudu ulos</a>
        <a href="../" class="btn btn-warning">Takaisin etusivulle</a>
    </p>
</body>
</html>