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
  <title>Huollot</title>
<body>
<hr>
</hr>
<h1>Huollot</h1>
<br>
<a href="../welcome.php" class="btn btn-warning">Takaisin valikkoon</a>
<a href="../huollonlisays" class="btn btn-warning">Lisää huolto</a>
<hr>
</hr>
<?php
echo "<table style='border: solid 1px black;'>";
echo "<tr><th>TyöntekijäID</th><th>HuoltoID</th><th>LaiteID</th><th>Etunimi</th><th>Sukunimi</th><th>Puhelin</th><th>Vikatyyppi</th><th>HuoltoPVM</th></tr>";

class TableRows extends RecursiveIteratorIterator {
  function __construct($it) {
    parent::__construct($it, self::LEAVES_ONLY);
  }

  function current() {
    return "<td style='width:150px;border:1px solid black;'>" . parent::current(). "</td>";
  }

  function beginChildren() {
    echo "<tr>";
  }

  function endChildren() {
    echo "</tr>" . "\n";
  }
}

$servername = "mysql.cc.puv.fi";
$username = "e2000560";
$password = "VyjhyWKzCSWj";
$dbname = "e2000560_VVV";
$charset = 'utf8mb4';

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=$charset", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $stmt = $conn->prepare("SELECT Huolto.TyöntekijäID, HuoltoID, LaiteID, Etunimi, Sukunimi, Puhelin, Vikatyyppi, HuoltoPVM
  FROM Henkilökunta, Huolto
  WHERE Henkilökunta.TyöntekijäID = Huolto.TyöntekijäID
  ORDER BY HuoltoID DESC");
  $stmt->execute();

  // set the resulting array to associative
  $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
  foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
    echo $v;
  }
} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}
$conn = null;
echo "</table>";
?>
<hr>
</hr>
<a href="../welcome.php" class="btn btn-warning">Takaisin valikkoon</a>
<a href="../huollonlisays" class="btn btn-warning">Lisää huolto</a>
</body>