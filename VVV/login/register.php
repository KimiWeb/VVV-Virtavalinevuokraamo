<?php
// Ottaa config tiedoston mukaan
require_once "config.php";
 
// Määrittelee variablet ja laittaa niihn tyhjän arvon
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// Prosessoi lomakkeen datan kun lomake on lähetetty
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Määrittelee käyttäjätunnuksen
    if(empty(trim($_POST["username"]))){
        $username_err = "Lisää käyttäjätunnus.";
    } else{
        // Valmistelee select lausekkeen
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Yhdistää variablet ja valmistaa ne lausekkeeseen parametreinä
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Valmistaa parametrit
            $param_username = trim($_POST["username"]);
            
            // Yrittää suorittaa valmistetun lauseen
            if(mysqli_stmt_execute($stmt)){
                /* tallentaa tuloksen */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "Tämä käyttäjätunnus onjo olemassa.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Jotain meni väärin. Yritä uudelleen myöhemmin.";
            }

            // Sulkee lausekkeen
            mysqli_stmt_close($stmt);
        }
    }
    
    // Määrittelee salasanan
    if(empty(trim($_POST["password"]))){
        $password_err = "Kirjoita salana.";     
    } elseif(strlen(trim($_POST["password"])) < 5){
        $password_err = "Salasanan on oltava yli 5 kirjainta.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Määrittelee varmistus salasanan
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Kirjoita salasana uudestaan.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Salasanat eivät olleet samoja.";
        }
    }
    
    // Katsoo onko tullut input virheitä ennen kuin lähettää tietokantaan
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Valmistelee insert lauseen.
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Yhdistää variablet valmistuneeseen lausekkeeseen parametreinä
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // Valmistaa parametrit
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Yrittää suorittaa valmistetun lauseen
            if(mysqli_stmt_execute($stmt)){
                // Uudelleen siirtää login sivulle
                header("location: login.php");
            } else{
                echo "Joitan meni väärin. Yritä uudelleen myöhemmin.";
            }

            // Sulkee lausekkeen
            mysqli_stmt_close($stmt);
        }
    }
    
    // Sulkee yhteyden
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rekisteröinti</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Rekisteröinti lomake</h2>
        <p>Täytä tämä lomake tunnuksia varten.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Käyttäjätunnus</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Salasana</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Laita salasana uudestaan</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Rekisteröidy">
                <input type="reset" class="btn btn-default" value="Resetoi">
            </div>
            <p>Onko sinulla jo Käyttäjätunnus? <a href="login.php">Kirjaudu tästä</a>.</p>
        </form>
    </div>    
</body>
</html>