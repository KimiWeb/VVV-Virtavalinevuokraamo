<?php
// Aloittaa session
session_start();
 
// Katsoo onko käyttäjä kirjautunut sisään, jos on siirtä käyttäjän welcome sivulle.
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
 
// Ottaa config tiedoston mukaan
require_once "config.php";
 
// Määrittelee variablet ja asettaa niihin tyhjän arvon
$username = $password = "";
$username_err = $password_err = "";
 
// Prosessoi lomakkeen datan  kun lomake on lähetetty
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Katsoo onko käyttäjätunnus tyhjä
    if(empty(trim($_POST["username"]))){
        $username_err = "Kirjoita käyttäjätunnus.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Katsoo onko salasana tyhjä
    if(empty(trim($_POST["password"]))){
        $password_err = "Kirjoita salasana.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Vahvistaa vaaditut
    if(empty($username_err) && empty($password_err)){
        // Valmistelee select lausekkeen
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Yhdistää variablet valmistettuun lausekkeeseen parametreinä
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Asettaa parametrit
            $param_username = $username;
            
            // Yrittää suorittaa valmistetun lauseen
            if(mysqli_stmt_execute($stmt)){
                // Tallentaa tulokset
                mysqli_stmt_store_result($stmt);
                
                // Katsoo onko käyttäjätunnus olemassa, jos on niin tarkistaa salasanan
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Yhdistää tuloktetut variablet
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Salasana on oikea, joten aloita uusi sessio
                            session_start();
                            
                            // Tallenna data session variableista
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Siirtää käyttäjän welcome sivulle
                            header("location: welcome.php");
                        } else{
                            // valid Näyttää virhe viestin jos salasana ei ole oikea
                            $password_err = "Väärä salasana.";
                        }
                    }
                } else{
                    // Näyttää virhe viestin jos tunnuksia ei löytynyt käyttäjänimellä.
                    $username_err = "Tunnuksia ei ollut samalla käyttäjänimellä.";
                }
            } else{
                echo "Jotain meni väärin. Yritä uudelleen myöhemmin.";
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
    <title>Kirjaudu</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Kirjaudu</h2>
        <p>Kirjoita tunnuksesi kirjautumista varten.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Käyttäjätunnus</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Salasana</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Kirjaudu">
            </div>
            <p>Eikö ole tunnuksia? <a href="register.php">Rekisteröi nyt</a>.</p>
        </form>
    </div>    
</body>
</html>