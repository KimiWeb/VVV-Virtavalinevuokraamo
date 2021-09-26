<?php
// Aloittaa session
session_start();
 
// Katsoo onko käyttäjä kirjautunut sisään, jos ei siirtä käyttäjän login sivulle.
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
 
// ottaa config tiedoston mukaan.
require_once "config.php";
 
// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
 
// Prosessoi lomakkeen datan kun se on lähetetty.
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Tarkastaa uuden salasanan.
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Kirjoita uusi salasana.";     
    } elseif(strlen(trim($_POST["new_password"])) < 5){
        $new_password_err = "Salasanan on oltava yli 5 kirjainta.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Tarkastaa varmistus salasanan.
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Kirjoita salasana uudestaan.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Salasanat eivät olleet samoja.";
        }
    }
        
    // Katsoo onko tullut virheitä ennenkuin lähettää tiedot databaseen.
    if(empty($new_password_err) && empty($confirm_password_err)){
        // Valmistaa update lausekkeen.
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Yhdistää variablet parametreihin.
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
            
            // Asettaa parametrit
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            // Yritää lähettää valmiin lauseen
            if(mysqli_stmt_execute($stmt)){
                // Salasanan päivitys onnistunut. Tuhoa session, ja siirrä takaisin login sivulle.
                session_destroy();
                header("location: login.php");
                exit();
            } else{
                echo "Joitain meni väärin. Yritä uudelleen myöhemmin.";
            }

            // Lopettaa lausekkeen.
            mysqli_stmt_close($stmt);
        }
    }
    
    // Sulkee yhteyden.
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Resetoi salasana</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Resetoi salasana</h2>
        <p>Täytä tämä lomake salasanan restoroimiseksi.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                <label>Uusi salasana</label>
                <input type="password" name="new_password" class="form-control" value="<?php echo $new_password; ?>">
                <span class="help-block"><?php echo $new_password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Kirjoita salasana uudestaan</label>
                <input type="password" name="confirm_password" class="form-control">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a class="btn btn-link" href="welcome.php">Peru</a>
            </div>
        </form>
    </div>    
</body>
</html>
